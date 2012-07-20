<?php
/**
 * @file
 */


/**
 * Implementation of hook_views_data_alter().
 */
function cck_select_other_views_data_alter(&$data) {
  $fields = content_fields();
  foreach ($fields as $field) {
    if ($field['widget']['type'] == 'cck_select_other') {
      $field_name = $field['field_name'];
      $table = 'node_data_' . $field_name;
      $views_field = $field_name . '_value';

      if (isset($data[$table])) {
        $data[$table][$views_field]['field']['handler'] = 'cck_select_other_handler_field';
        $data[$table][$views_field]['filter']['handler'] = 'cck_select_other_handler_filter';
      }
    }
  }
}

/**
 * Implementation of hook_views_handlers().
 */
function cck_select_other_views_handlers() {
  return array(
    'info' => array(
      'path' => drupal_get_path('module', 'cck_select_other') . '/views',
    ),
    'handlers' => array(
      'cck_select_other_handler_field' => array(
        'parent' => 'content_handler_field',
      ),
      'cck_select_other_handler_filter' => array(
        'parent' => 'content_handler_filter_many_to_one', 
      ),
    ),

  );
}
