<?php

/**
 * Implementation of hook_ctools_plugin_api().
 */
function resources_ctools_plugin_api() {
  list($module, $api) = func_get_args();
  if ($module == "context" && $api == "context") {
    return array("version" => 3);
  }
}

/**
 * Implementation of hook_node_info().
 */
function resources_node_info() {
  $items = array(
    'resource' => array(
      'name' => t('Resource'),
      'module' => 'features',
      'description' => t('A content type that can be used as a publication. Contains a download-able attachment.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'has_body' => '1',
      'body_label' => t('Summary'),
      'min_word_count' => '0',
      'help' => '',
    ),
  );
  return $items;
}

/**
 * Implementation of hook_views_api().
 */
function resources_views_api() {
  return array(
    'api' => '2',
  );
}
