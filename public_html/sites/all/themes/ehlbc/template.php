<?php

/**
 * @file
 * Put yout custom function-y goodness here
 *
 * Contains theme override functions and preprocess functions for the
 * Cogito_child theme theme.
 */


/**
 * Implements template_preprocess_field().
 * This way we can theme any field with its own function
 */
function ehlbc_preprocess_field(&$variables) {
  // Allow for separate theming functions:
  $function = 'ehlbc_preprocess_field__' . $variables['element']['#field_name'];
  if (function_exists($function)) {
    $function($variables);
  }
  // But also allow for grouping of some common tasks:
  switch ($variables['element']['#field_name']) {
    // File fields:
    case 'field_attachments':
      $variables['label_hidden'] = TRUE;
      $format = '<strong>%s</strong>: %s';
      foreach ($variables['element']['#items'] as $key => $item) {
        $download_url = file_create_url($item['uri']); 
        $attachment['items'][] = sprintf($format, t('Description'), $item['description']);
        $attachment['items'][] = sprintf($format, t('File path/name'), $download_url);
        $attachment['items'][] = sprintf($format, t('Filesize'), format_size($item['filesize']));
        $attachment['items'][] = sprintf($format, t('File Type'), $item['filemime']);
        $attachment['items'][] = sprintf($format, t('File Upload Date'), format_date($item['timestamp'], 'custom', variable_get('date_format_event_view', drupal_get_user_timezone())));
        $attachment['items'][] = l(t('Download'), $download_url);
        $attachment_details = theme('item_list', $attachment);
        $variables['items'][$key]['#markup'] = $attachment_details;
      }
      break;
    // License fields:
    case 'field_license_archival':
    case 'field_license_ereserves':
    case 'field_license_ill':
      $variables['label'] = t('Summary');
      break;
    case 'field_license_archival_txt':
    case 'field_license_eres_text':
    case 'field_license_ill_txt':
      $variables['label'] = t('Relevant License Text');
      break;
    // Contact fields:
    case 'field_contact_last_name':
      $variables['label'] = t('Name');
      $variables['items'][0]['#markup'] = $variables['element']['#object']->title . ' ' . $variables['items'][0]['#markup'];
      break;
    // Event fields:
    case 'field_event_location':
      $variables['label'] = t('Address');
      break;
    // Organization fields:
    case 'field_organization_ref':
      $node = node_load($variables['items'][0]['#markup']);
      $renderable = array(
        0 => array(
          0 => array(
            '#theme' => 'location',
            '#location' => $node->field_location['und'][0],
          ),
          '#access' => TRUE,
          '#bundle' => 'organization',
          '#entity_type' => 'node',
          '#field_type' => 'location',
          '#formatter' => 'location_default',
          '#items' => array(
            $node->field_location['und'][0],
          ),
          '#object' => $node,
          '#theme' => 'field',
          '#view_mode' => 'full',
        ),
      );
      unset($renderable[0]['#items'][0]['latitude']);
      unset($renderable[0]['#items'][0]['longitude']);
      $patterns = array(
        '/<div class="field-label[^>]+>:[^<]+<\/div>/',
        '/<div class="map-link">\s*<div class="location map-link">[^<]+<a[^>]*>[^<]+<\/a><\/div>\s*<\/div>/',
        '/<span class="geo"><abbr[^>]*>[^<]+<\/abbr>\s*,\s*<abbr[^>]+>[^<]+<\/abbr><\/span>/'
      );
      $variables['items'][0]['#markup'] = preg_replace($patterns, '', render($renderable));
      break;
    // Resources fields:
    case 'field_resources_generic_url':
      // There's a help message as part of the field--insert it here:
      $variables['items'][0]['#suffix'] = '<div class="help">'
                 . l(t("Why can't I connect to the database?"), 'node/114')
                 . '</div>';
      break;
    // Trial-renewal fields:
    case 'field_trial_access':
      $variables['label'] = t('Free Trial Access');
      break;
    case 'field_trial_active':
      if ($variables['element']['#items'][0]['value'] === 'N') {
        $variables['items'][0]['#markup'] = t('<strong><span class="notice">Please Note</span>: This Renewal is not currently active. This documentation is for reference only.</strong>'); 
      }
      break;
    case 'field_trial_deadline':
      $variables['items'][0]['#markup'] = preg_replace('/<span[^>]+>([^>]+)<\/span>/', '<div class="deadline"><strong>*** ' . t('Response Deadline') . ': $1 ***</strong></div>', $variables['items'][0]['#markup']);
      break;
  }
} // ehlbc_preprocess_field()


/**
 * Implements template_preprocess_node().
 */
function ehlbc_preprocess_node(&$variables){
  switch ($variables['type']) {
    case 'license': 
      break;

    case 'resource':

      break;
    case 'trial_renewal':
      // First, deal with the field_resource_ref stuff:
      //
      // Get the resource node and the vendor node:
      $resource_items = field_get_items('node', $variables['node'], 'field_resource_ref', NULL);
      $resource_node = node_load($resource_items[0]['nid']);
      $vendor_ref_items = field_get_items('node', $resource_node, 'field_resource_vendor_ref', NULL);
      $vendor_node = node_load($vendor_ref_items[0]['nid']);
      $resource_body_items = field_get_items('node', $resource_node, 'body', NULL);
      $variables['content']['field_resource_ref']['#title'] = t('Vendor Description');
      $variables['content']['field_resource_ref'][0]['#markup'] = $resource_body_items[0]['value'];
      // We need to create and insert a resource access field in the current
      // (trial_renewal) node:
      $variables['content']['field_resource_access'] = $variables['content']['field_trial_active'];
      $variables['content']['field_resource_access']['#title'] = t('Access Details');
      $variables['content']['field_resource_access']['#label_display'] = 'above';
      $variables['content']['field_resource_access']['#field_name'] = 'field_resource_access';
      $variables['content']['field_resource_access'][0]['#markup'] = $resource_node->field_resource_access['und'][0]['safe_value'];
      $variables['content']['field_resource_access']['#weight'] = 5;
      // Get the license node:
      $license_items = field_get_items('node', $resource_node, 'field_resources_license', NULL);
      $license_node = node_load($license_items[0]['nid']);
      // We need to create and insert a license title field in the current
      // (trial_renewal) node:
      $variables['content']['field_license_title'] = $variables['content']['field_trial_active'];
      $variables['content']['field_license_title']['#title'] = t('License');
      $variables['content']['field_license_title']['#label_display'] = 'above';
      $variables['content']['field_license_title']['#field_name'] = 'field_license_title';
      $variables['content']['field_license_title'][0]['#markup'] = $license_node->title;
      $variables['content']['field_license_title']['#weight'] = 48;
      // We also need a new field for the vendor name and url:
      $variables['content']['field_vendor_info'] = $variables['content']['field_trial_active'];
      $variables['content']['field_vendor_info']['#title'] = t('Vendor Information');
      $variables['content']['field_vendor_info']['#label_display'] = 'above';
      $variables['content']['field_vendor_info']['#field_name'] = 'field_vendor_info';
      $variables['content']['field_vendor_info'][0]['#markup'] = t('<strong>Vendor Name</strong>: !vendor-name', array('!vendor-name' => l($vendor_node->title, 'vendor/' . $vendor_node->nid)));

      $variables['content']['field_vendor_info']['#weight'] = 6;

      // We need to position the license title field in relation to the 'other'
      // field:
      $variables['content']['field_trial_other']['#weight'] = 50;
      // Then, deal with the field_trial_access stuff:
      if (!user_access('view field_trial_access')) {
        // If the user doesn't have access, we need to do two things:
        // 1. Allow access to the field, BUT
        // 2. Change the content:
        $variables['content']['field_trial_access']['#access'] = TRUE;
        $variables['content']['field_trial_access'][0]['#markup'] = t('To view pricing info and a link to the free trial, please log into the e-HLbc site using the orange LOGIN button at the top of this page.');
      }
      // Also, deal with the field_trial_active stuff:
      if ($variables['content']['field_trial_active'][0]['#markup'] !== 'N') {
        $variables['content']['field_trial_active']['#access'] = FALSE;
      }
      // Also, deal with the license term stuff:
      $variables['content']['field_trial_begins']['#title'] = t('Subscription Information');
      $variables['content']['field_trial_begins'][0]['#markup'] = t('<strong>License Term</strong>: !start - !end', array('!start' => $variables['content']['field_trial_begins'][0]['#markup'], '!end' => $variables['content']['field_trial_ends'][0]['#markup'])); 
      $variables['content']['field_trial_ends']['#access'] = FALSE;
      break;
  }
} // ehlbc_preprocess_node()


/**
 * Implements template_preprocess_page().
 */
function ehlbc_preprocess_page(&$variables) {
  drupal_add_js('http://w.sharethis.com/button/buttons.js', 'external');
  drupal_add_js('stLight.options({publisher:"4e1667cf-8007-473e-96b5-3eda0d97f1fb"});', 'inline');
} // ehlbc_preprocess_page()


/**
 * Implements template_preprocess_views_view().
 */
function ehlbc_preprocess_views_view(&$variables) {
  // Pick a view, any view...
  switch ($variables['view']->name) {
    // We only care about the events view at this time:
    case 'events':
      // Specifically, we only care about the 'block_2' display:
      if ($variables['display_id'] === 'block_2') {
        // Start with zero duplicates:
        $duplicates_found = FALSE;
        // Loop through the results:
        foreach ($variables['view']->result as $row => $contents) {
          // Figure out if there's a previous row and get an integer for it:
          $previous_row = ((int) $row > 0) ? ((int) $row - 1) : NULL;
          // If the previous row was numeric, and the current field_date_value_summary is
          // identical to the last row's:
          if (is_numeric($previous_row) && ($contents->field_date_value_summary === $variables['view']->result[$previous_row]->field_date_value_summary)) {
            // Add THIS ROW's num_records to the PREVIOUS ROW's num_records:
            $variables['view']->result[$previous_row]->num_records += $variables['view']->result[$row]->num_records;
            // Unset THIS ROW:
            unset($variables['view']->result[$row]);
            // Record that we have indeed found a duplicate:
            $duplicates_found = TRUE;
          }
        }
        // Only if a duplicate has been found:
        if ($duplicates_found) {
          // Set the current value of rows to the value of the view re-rendered with the
          // altered result array:
          $variables['rows'] = $variables['view']->style_plugin->render($variables['view']->result); 
        }
      }
      break;
  }
} // ehlbc_preprocess_views_view()

