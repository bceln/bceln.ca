<?php
// $Id: template.php,v 1.10 2010/10/17 11:01:51 mcrittenden Exp $

/**
 * Override or insert variables into the page template.
 */
function seven_preprocess_page(&$vars) {
  $vars['primary_local_tasks'] = menu_primary_local_tasks();
  $vars['secondary_local_tasks'] = menu_secondary_local_tasks();

  // get all the current css information into an array
  $css = drupal_add_css();

  // Removing the css files of vertical tabs module because and use the seven style instead.
  unset($css['all']['module'][drupal_get_path('module','vertical_tabs'). '/vertical_tabs.css']);

  // now place the remaining css files back into the template variable for rendering
  $vars['styles'] = drupal_get_css($css);
}

/**
 * Display the list of available node types for node creation.
 */
function seven_node_add_list($content) {
  $output = '';
  if ($content) {
    $output = '<ul class="node-type-list">';
    foreach ($content as $item) {
      $output .= '<li class="clearfix">';
      $output .= '<span class="label">' . l($item['title'], $item['href'], $item['localized_options']) . '</span>';
      $output .= '<div class="description">' . filter_xss_admin($item['description']) . '</div>';
      $output .= '</li>';
    }
    $output .= '</ul>';
  }
  return $output;
}

/**
 * Override of theme_admin_block_content().
 *
 * Use unordered list markup in both compact and extended move.
 */
function seven_admin_block_content($content) {
  $output = '';
  if (!empty($content)) {
    $output = system_admin_compact_mode() ? '<ul class="admin-list compact">' : '<ul class="admin-list">';
    foreach ($content as $item) {
      $output .= '<li class="leaf">';
      $output .= l($item['title'], $item['href'], $item['localized_options']);
      if (!system_admin_compact_mode()) {
        $output .= '<div class="description">' . filter_xss_admin($item['description']) . '</div>';
      }
      $output .= '</li>';
    }
    $output .= '</ul>';
  }
  return $output;
}

/**
 * Override of theme_tablesort_indicator().
 *
 * Use our own image versions, so they show up as black and not gray on gray.
 */
function seven_tablesort_indicator($style) {
  $theme_path = drupal_get_path('theme', 'seven');
  if ($style == 'asc') {
    return theme('image', $theme_path . '/images/arrow-asc.png');
  } else {
    return theme('image', $theme_path . '/images/arrow-desc.png');
  }
}

/**
 * Override of theme_fieldset().
 *
 * Add span to legend tag, so we can style it to be inside the fieldset.
 */
function seven_fieldset($element) {
  if (!empty($element['#collapsible'])) {
    drupal_add_js('misc/collapse.js');

    if (!isset($element['#attributes']['class'])) {
      $element['#attributes']['class'] = '';
    }

    $element['#attributes']['class'] .= ' collapsible';
    if (!empty($element['#collapsed'])) {
      $element['#attributes']['class'] .= ' collapsed';
    }
  }

  $output = '<fieldset' . drupal_attributes($element['#attributes']) . '>';
  if (!empty($element['#title'])) {
    // Always wrap fieldset legends in a SPAN for CSS positioning.
    $output .= '<legend><span class="fieldset-legend">' . $element['#title'] . '</span></legend>';
  }
  // Add a wrapper if this fieldset is not collapsible.
  // theme_fieldset() in D7 adds a wrapper to all fieldsets, however in D6 this
  // wrapper is added by Drupal.behaviors.collapse(), but only to collapsible
  // fieldsets. So to ensure the wrapper is consistantly added here we add the
  // wrapper to the markup, but only for non collapsible fieldsets.
  if (empty($element['#collapsible'])) {
    $output .= '<div class="fieldset-wrapper">';
  }
  if (!empty($element['#description'])) {
    $output .= '<div class="description">' . $element['#description'] . '</div>';
  }
  if (isset($element['#children'])) {
    $output .= $element['#children'];
  }
  if (isset($element['#value'])) {
    $output .= $element['#value'];
  }
  if (empty($element['#collapsible'])) {
    $output .= '</div>';
  }
  $output .= "</fieldset>\n";
  return $output;
}

/**
 * Implements theme_userplus_admin_usergroups
 */
function seven_userplus_admin_usergroups($form) {
  $rows = array();

  // Render group overview:
  $header = array(t('User'));
  foreach ($form['groups']['#value'] as $nid => $name) {
    $header[] = l($name, 'node/'. $nid);
  }
  foreach (element_children($form['user']) as $uid) {
    unset($row);
    $profile = content_profile_load('contact', $uid); 
    $row[] = array('data' => l($profile->title . ' '. $profile->field_contact_last_name[0]['value'], "user/$uid/edit") . ' (' . $form['usernames']['#value'][$uid] . ')', 'class' => 'username');
    foreach (element_children($form['user'][$uid]) as $nid) {
      unset($form['user'][$uid][$nid]['#title']);
      $row[] = drupal_render($form['user'][$uid][$nid]);
    }

    $rows[] = $row;
  }

  $output = theme('table', $header, $rows, array('id' => 'users-groups'));
  $output .= '<br \>';
  $output .= drupal_render($form['submit']);
  $output .= theme('pager', NULL, variable_get('userplus_max_show_user_groups', 25));

  $output .= drupal_render($form['usersgroups']);

  // Don't forget the dreaded form_id -- http://drupal.org/node/38926 -- or
  // the values won't be there when you get to your _submit handler...
  $output .= drupal_render($form['form_id']);

  // Form_token is necessary to pass validation -- see
  // http://drupal.org/node/89999 for more information.
  $output .= drupal_render($form['form_token']);

  return $output;
}