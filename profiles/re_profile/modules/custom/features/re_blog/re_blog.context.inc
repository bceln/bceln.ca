<?php

/**
 * Implementation of hook_context_default_contexts().
 */
function re_blog_context_default_contexts() {
  $export = array();
  $context = new stdClass;
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'blog';
  $context->description = 'Blog';
  $context->tag = 'Blog';
  $context->conditions = array(
    'menu' => array(
      'values' => array(
        'blog' => 'blog',
      ),
    ),
    'node' => array(
      'values' => array(
        'blog' => 'blog',
      ),
      'options' => array(
        'node_form' => '1',
      ),
    ),
    'path' => array(
      'values' => array(
        'blog' => 'blog',
        'blog/*' => 'blog/*',
      ),
    ),
    'views' => array(
      'values' => array(
        'Blog' => 'Blog',
        'Blog:page_1' => 'Blog:page_1',
        'Blog:page_2' => 'Blog:page_2',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'views-Blog-block_2' => array(
          'module' => 'views',
          'delta' => 'Blog-block_2',
          'region' => 'right',
          'weight' => 0,
        ),
        'views-Blog-block_3' => array(
          'module' => 'views',
          'delta' => 'Blog-block_3',
          'region' => 'right',
          'weight' => 1,
        ),
      ),
    ),
    'menu' => 'blog',
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('Blog');

  $export['blog'] = $context;
  return $export;
}
