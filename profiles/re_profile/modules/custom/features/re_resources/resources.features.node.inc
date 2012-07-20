<?php

/**
 * Helper to implementation of hook_node_info().
 */
function _resources_node_info() {
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
