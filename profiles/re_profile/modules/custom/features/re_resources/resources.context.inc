<?php

/**
 * Implementation of hook_context_default_contexts().
 */
function resources_context_default_contexts() {
  $export = array();
  $context = new stdClass;
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'context_ui-section-resources';
  $context->description = 'Resources';
  $context->tag = '';
  $context->conditions = array(
    'node' => array(
      'values' => array(
        0 => 'resource',
      ),
      'options' => array(),
    ),
    'path' => array(
      'values' => array(
        'resources' => 'resources',
      ),
      'options' => array(),
    ),
    'views' => array(
      'values' => array(
        0 => 'resources',
        1 => 'resources:page_1',
        2 => 'resources:page_2',
      ),
      'options' => array(),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'views-resources-block_1' => array(
          'module' => 'views',
          'delta' => 'resources-block_1',
          'weight' => 13,
          'region' => 'right',
          'status' => '0',
          'label' => 'Resources by Taxonomy',
          'type' => 'context_ui',
          'bid' => 'views_resources-block_1',
        ),
        'views-resources-block_2' => array(
          'module' => 'views',
          'delta' => 'resources-block_2',
          'weight' => 14,
          'region' => 'right',
          'status' => '0',
          'label' => 'Resources Archive',
          'type' => 'context_ui',
          'bid' => 'views_resources-block_2',
        ),
      ),
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('Resources');

  $export['context_ui-section-resources'] = $context;
  return $export;
}
