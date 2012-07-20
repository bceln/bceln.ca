<?php

/**
 * Helper to implementation of hook_context_default_contexts().
 */
function _re_blog_context_default_contexts() {
  $items = array();

  $items[] = array(
    'namespace' => 'context_ui',
    'attribute' => 'section',
    'value' => 'blog',
    'description' => 'Blog',
    'node' => array(
      '0' => 'blog',
    ),
    'path' => array(
      'blog' => 'blog',
      'blog/*' => 'blog/*',
    ),
    'menu' => 'blog',
    'block' => array(
      'views_Blog-block_3' => array(
        'module' => 'views',
        'delta' => 'Blog-block_3',
        'weight' => -15,
        'region' => 'right',
        'status' => '0',
        'label' => 'Blog Archive',
        'type' => 'context_ui',
      ),
    ),
  );
  return $items;
}
