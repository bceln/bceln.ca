<?php
/**
 * @file
 * Put yout custom function-y goodness here
 *
 * Contains theme override functions and preprocess functions for the
 * Cogito_child theme theme.
 */

function ehlbc_preprocess_page(&$variables) {
  drupal_add_js('http://w.sharethis.com/button/buttons.js', 'external');
  drupal_add_js('stLight.options({publisher:"4e1667cf-8007-473e-96b5-3eda0d97f1fb"});', 'inline');
}

