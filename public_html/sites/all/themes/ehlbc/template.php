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
  }
} // ehlbc_preprocess_field()


/**
 *
 */
function ehlbc_preprocess_field__field_resources_generic_url(&$variables) {
  // There's a help message as part of the field--insert it here:
  $variables['items'][0]['#suffix'] = '<div class="help">'
             . l(t("Why can't I connect to the database?"), 'node/114')
             . '</div>';
} // ehlbc_preprocess_field__field_resources_generic_url()


/**
 * Implements template_preprocess_node().
 */
function ehlbc_preprocess_node(&$variables){
  global $user;
  //if (isset($variables['content']['field_private_note']) && !user_access('view field_private_note', $user)){
  //  hide($variables['content']['field_private_note']);
  //}
  switch ($variables['type']) {
    case 'license': 
      break;

    case 'resource':

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

