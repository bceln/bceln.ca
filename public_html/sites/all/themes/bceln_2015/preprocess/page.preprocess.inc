<?php

/**
 * Implements hook_preprocess_page().
 */
function bceln_2015_preprocess_page(&$variables) {
	// You can use preprocess hooks to modify the variables before they are passed
	// to the theme function or template file.
	// Add Lato font face drom goodle WebFonts
	drupal_add_css('http:////fonts.googleapis.com/css?family=Lato:100italic,100,300italic,300,400italic,400,700italic,700,900italic,900',array('type' => 'external'));

  
}
