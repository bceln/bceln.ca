<?php

// Plugin definition
$plugin = array(
  'title' => t('EHLBC Dashboard'),
  'category' => t('EHLBC'),
  'icon' => 'ehlbc_dashboard.png',
  'theme' => 'panels_ehlbc_dashboard',
  'css' => 'ehlbc_dashboard.css',
  'regions' => array(
    'sidebar_left' => t('Left sidebar'),
    'content_main' => t('Main content'),
  ),
);

