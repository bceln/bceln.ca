<?php

/**
 * Implementation of hook_context_default_contexts().
 */
function events_context_default_contexts() {
  $export = array();
  $context = new stdClass;
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'context_ui-section-events';
  $context->description = 'Events Context. Sets menu item and sidebar blocks';
  $context->tag = 'Events';
  $context->conditions = array(
    'node' => array(
      'values' => array(
        'event' => 'event',
      ),
      'options' => array(
        'node_form' => '1',
      ),
    ),
    'path' => array(
      'values' => array(
        'events' => 'events',
        'events/*' => 'events/*',
      ),
    ),
    'views' => array(
      'values' => array(
        'events' => 'events',
        'events:page_1' => 'events:page_1',
        'events:page_2' => 'events:page_2',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'views-events-block_1' => array(
          'module' => 'views',
          'delta' => 'events-block_1',
          'region' => 'right',
          'weight' => 0,
        ),
        'views-events-block_2' => array(
          'module' => 'views',
          'delta' => 'events-block_2',
          'region' => 'right',
          'weight' => 1,
        ),
      ),
    ),
    'menu' => 'events',
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('Events');
  t('Events Context. Sets menu item and sidebar blocks');

  $export['context_ui-section-events'] = $context;
  return $export;
}
