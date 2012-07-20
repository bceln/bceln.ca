<?php
/**
 * @file
 * CCK Select Other API Documentation
 */


/**
 * Alter CCK Select Other widget details
 * @param $info The widget $info array.
 * @return A new widget $info array. Hopefully just an addition onto the current one.
 */
function hook_cck_select_other_info_alter($info) {
  // Add a field type to $info and return it.
  $info['field types'][] = 'content_taxonomy';
  return $info;
}

/**
 * Add additional options to the CCK Select Other widget.
 * @param $field The field array
 * @param $options The default options
 * @return An associative array where each element is an array of options to be merged.
 */
function hook_cck_select_other_options($field, $options) {
  if ($field['module'] == 'content_taxonomy']) {
    // Create some more options.
    $options = array(
      'key' => array(
        'value' => t('Value'),
      ),
    );

    return $options;
  }
}

/**
 * Do additional processing or modify the value to be saved.
 * @param $field The field array
 * @param $edit The full edit array. Useful to grab select_other_list and select_other_text_input values.
 * @return NULL if not modifying the value. Otherwise, return the value to be saved.
 */
function hook_cck_select_other_process($field, $edit) {
  if ($edit['select_other_list'] == 'other' && $field['module'] == 'content_taxonomy') {
    // Do somethig like save the actual value as a taxonomy term and return the tid to save.
    $term = array(
      'tid' => NULL,
      'vid' => $field['vid'], // Vocabulary id based on Content Taxonomy Field settings.
      'name' => $edit['select_other_text_input'],
    );
    taxonomy_save_term($term);
    return $term['tid'];
  }
}
