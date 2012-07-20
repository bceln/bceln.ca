<?php

/**
 * Implementation of hook_taxonomy_default_vocabularies().
 */
function re_blog_taxonomy_default_vocabularies() {
  return array(
    'categories' => array(
      'name' => 'Categories',
      'description' => 'Blog Categories',
      'help' => '',
      'relations' => '1',
      'hierarchy' => '1',
      'multiple' => '1',
      'required' => '0',
      'tags' => '0',
      'module' => 'features_categories',
      'weight' => '0',
      'nodes' => array(
        'blog' => 'blog',
      ),
    ),
  );
}
