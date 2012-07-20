<?php

/**
 * Implementation of hook_context_default_contexts().
 */
function news_context_default_contexts() {
  $export = array();
  $context = new stdClass;
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'context_ui-section-news';
  $context->description = 'News';
  $context->tag = '';
  $context->conditions = array(
    'node' => array(
      'values' => array(
        'news' => 'news',
      ),
      'options' => array(
        'node_form' => '1',
      ),
    ),
    'path' => array(
      'values' => array(
        'news' => 'news',
        'news/*' => 'news/*',
      ),
    ),
    'views' => array(
      'values' => array(
        'News' => 'News',
        'News:page_1' => 'News:page_1',
        'News:page_2' => 'News:page_2',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'views-News-block_1' => array(
          'module' => 'views',
          'delta' => 'News-block_1',
          'region' => 'right',
          'weight' => 0,
        ),
        'views-News-block_2' => array(
          'module' => 'views',
          'delta' => 'News-block_2',
          'region' => 'right',
          'weight' => 1,
        ),
      ),
    ),
    'menu' => 'news',
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('News');

  $export['context_ui-section-news'] = $context;
  return $export;
}
