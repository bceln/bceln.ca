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
  // Allow for separate theming functions
  $function = 'ehlbc_preprocess_field__' . $variables['element']['#field_name'];
  if(function_exists($function)) {
    $function($variables);
  }
} // ehlbc_preprocess_field()


/**
 * Implements template_preprocess_field() for field_resource_title_lists().
 */
function ehlbc_preprocess_field__field_resource_title_lists(&$variables){
// theme_item_list(array('items' => $variables['items'], 'title' => $variables['label'], 'type' => 'ul'));
// 
} // ehlbc_preprocess_field__field_resource_title_lists()


/**
 * Implements template_preprocess_node().
 */
function ehlbc_preprocess_node(&$variables){
  global $user;
  if (isset($variables['content']['field_private_note']) && !user_access('view field_private_note', $user)){
    hide($variables['content']['field_private_note']);
  }
  switch ($variables['type']) {
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

