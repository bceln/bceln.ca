<?php

/**
 * Implements hook_preprocess_page().
 */
function bceln_2015_preprocess_html(&$variables) {
	// You can use preprocess hooks to modify the variables before they are passed
	// to the theme function or template file.
	// Add Lato font face drom goodle WebFonts
	drupal_add_css('//fonts.googleapis.com/css?family=Lato:100italic,100,300italic,300,400italic,400,700italic,700,900italic,900',array('type' => 'external'));
    $theme_path = drupal_get_path('theme', variable_get('theme_default', NULL));
    drupal_add_css($theme_path . '/fonts/bceln-fontello/css/bceln-fontello.css', array('group' => CSS_THEME));
	
	
    // Adding back sidebar classes that were removed on omega preprocess section
    if (empty($variables ['page']['sidebar_first']) && empty($variables ['page']['sidebar_second'])) {
      $variables ['classes_array'][] = 'no-sidebars';
    }
}
