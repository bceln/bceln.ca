<?php

/**
 * Implementation of hook_imagecache_default_presets().
 */
function re_image_gallery_imagecache_default_presets() {
  $items = array(
    're_image_gallery_small' => array(
      'presetname' => 're_image_gallery_small',
      'actions' => array(
        '0' => array(
          'weight' => '0',
          'module' => 'imagecache',
          'action' => 'imagecache_scale_and_crop',
          'data' => array(
            'width' => '150',
            'height' => '150',
          ),
        ),
      ),
    ),
    're_image_gallery_thumbnail' => array(
      'presetname' => 're_image_gallery_thumbnail',
      'actions' => array(
        '0' => array(
          'weight' => '0',
          'module' => 'imagecache',
          'action' => 'imagecache_scale_and_crop',
          'data' => array(
            'width' => '50',
            'height' => '50',
          ),
        ),
      ),
    ),
  );
  return $items;
}

/**
 * Implementation of hook_node_info().
 */
function re_image_gallery_node_info() {
  $items = array(
    're_image_gallery' => array(
      'name' => t('RE Image Gallery'),
      'module' => 'features',
      'description' => t('This content type allows the creation of simple one-page galleries including any number of images.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'has_body' => '1',
      'body_label' => t('Body'),
      'min_word_count' => '0',
      'help' => '',
    ),
  );
  return $items;
}

/**
 * Implementation of hook_views_api().
 */
function re_image_gallery_views_api() {
  return array(
    'api' => '2',
  );
}
