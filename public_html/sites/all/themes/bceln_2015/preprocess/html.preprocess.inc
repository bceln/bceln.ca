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
	
	// favicons 
	//Add android   type ? image/vnd.microsoft.icon
	drupal_add_html_head_link(array('sizes' => '36x36', 'rel' => 'icon', 'href' =>  $theme_path .'/favicon/android-icon-36x36.png', 'type' => 'image/png'));
	drupal_add_html_head_link(array('sizes' => '48x48', 'rel' => 'icon', 'href' =>  $theme_path .'/favicon/android-icon-48x48.png', 'type' => 'image/png'));
	drupal_add_html_head_link(array('sizes' => '72x72', 'rel' => 'icon', 'href' =>  $theme_path .'/favicon/android-icon-72x72.png', 'type' => 'image/png'));
	drupal_add_html_head_link(array('sizes' => '96x96', 'rel' => 'icon', 'href' =>  $theme_path .'/favicon/android-icon-96x96.png', 'type' => 'image/png'));
	drupal_add_html_head_link(array('sizes' => '144x144', 'rel' => 'icon', 'href' =>  $theme_path .'/favicon/android-icon-144x144.png', 'type' => 'image/png'));
	
	// xml & json
	drupal_add_html_head_link(array( 'rel' => 'manifest', 'href' =>  $theme_path .'/favicon/manifest.json'));
	//ms
	drupal_add_html_head_link(array('name' => 'msapplication-TileImage', 'content' =>  $theme_path .'/favicon/ms-icon-144x144.png'));
	
    // Adding back sidebar classes that were removed on omega preprocess section
    if (empty($variables ['page']['sidebar_first']) && empty($variables ['page']['sidebar_second'])) {
      $variables ['classes_array'][] = 'no-sidebars';
    }
}
