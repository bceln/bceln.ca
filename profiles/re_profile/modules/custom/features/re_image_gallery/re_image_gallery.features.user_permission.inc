<?php

/**
 * Implementation of hook_user_default_permissions().
 */
function re_image_gallery_user_default_permissions() {
  $permissions = array();

  // Exported permission: create re_image_gallery content
  $permissions['create re_image_gallery content'] = array(
    'name' => 'create re_image_gallery content',
    'roles' => array(),
  );

  // Exported permission: delete any re_image_gallery content
  $permissions['delete any re_image_gallery content'] = array(
    'name' => 'delete any re_image_gallery content',
    'roles' => array(),
  );

  // Exported permission: delete own re_image_gallery content
  $permissions['delete own re_image_gallery content'] = array(
    'name' => 'delete own re_image_gallery content',
    'roles' => array(),
  );

  // Exported permission: edit any re_image_gallery content
  $permissions['edit any re_image_gallery content'] = array(
    'name' => 'edit any re_image_gallery content',
    'roles' => array(),
  );

  // Exported permission: edit own re_image_gallery content
  $permissions['edit own re_image_gallery content'] = array(
    'name' => 'edit own re_image_gallery content',
    'roles' => array(),
  );

  // Exported permission: view imagecache re_image_gallery_small
  $permissions['view imagecache re_image_gallery_small'] = array(
    'name' => 'view imagecache re_image_gallery_small',
    'roles' => array(),
  );

  // Exported permission: view imagecache re_image_gallery_thumbnail
  $permissions['view imagecache re_image_gallery_thumbnail'] = array(
    'name' => 'view imagecache re_image_gallery_thumbnail',
    'roles' => array(),
  );

  return $permissions;
}
