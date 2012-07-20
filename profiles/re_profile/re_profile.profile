<?php
// $Id$

/**
 * Return a description of the profile for the initial installation screen.
 *
 * @return
 *   An array with keys 'name' and 'description' describing this profile,
 *   and optional 'language' to override the language selection for
 *   language-specific profiles.
 */
function re_profile_profile_details() {
  return array(
    'name' => 'RE Profile',
    'description' => 'Raised Eyebrow installation profile.'
  );
}

/**
 * Return an array of the modules to be enabled when this profile is installed.
 *
 * @return
 *   An array of modules to enable.
 */
function re_profile_profile_modules() {
  return array(
  // Core
  'block', 'comment', 'dblog', 'filter', 'help', 'menu', 'node', 'path',
  'system', 'taxonomy', 'php', 'update',
  
  // CONTRIB - add your own favourite contrib here, order is important
  // I've tried to keep to the basic minimum contrib for this profile
  // admin helper stuff
  'admin_menu', 'backup_migrate', 'devel',
  
  // cck
  'content', 'filefield', 'fieldgroup', 'nodereference', 'number', 'optionwidgets', 'text', 'imagefield', 'link', 'content_copy',
  
  // date/time
  'date_api', 'date_timezone', 'date', 'date_popup',
  
  // images
  'imageapi', 'imagecache', 'imagecache_ui', 'imageapi_gd', 'imce',
  
  // views
  'views', 'views_ui',
  
  // paths
  'token', 'pathauto', 'taxonomy_redirect', 

  // user interface
  'wysiwyg', 'imce_wysiwyg', 'jquery_update', 'jquery_ui',
  
  //menu stuff
  'menu_block', 'menu_breadcrumb', 

  // mapping
  'gmap', 'location', 'location_cck', 'gmap_location', 

  // other
  'ctools', 'context', 'context_ui', 'install_profile_api', 'features', 'googleanalytics', 'webform', 'video_filter', 'site_map', 'porterstemmer', 'xmlsitemap',
  );
}

/**
 * Return a list of tasks that this profile supports.
 *
 * @return
 *   A keyed array of tasks the profile will perform during
 *   the final stage. The keys of the array will be used internally,
 *   while the values will be displayed to the user in the installer
 *   task list.
 */
function re_profile_profile_task_list() {
  return array();
}

/**
 * Perform any final installation tasks for this profile.
 *
 * The installer goes through the profile-select -> locale-select
 * -> requirements -> database -> profile-install-batch
 * -> locale-initial-batch -> configure -> locale-remaining-batch
 * -> finished -> done tasks, in this order, if you don't implement
 * this function in your profile.
 *
 * If this function is implemented, you can have any number of
 * custom tasks to perform after 'configure', implementing a state
 * machine here to walk the user through those tasks. First time,
 * this function gets called with $task set to 'profile', and you
 * can advance to further tasks by setting $task to your tasks'
 * identifiers, used as array keys in the hook_profile_task_list()
 * above. You must avoid the reserved tasks listed in
 * install_reserved_tasks(). If you implement your custom tasks,
 * this function will get called in every HTTP request (for form
 * processing, printing your information screens and so on) until
 * you advance to the 'profile-finished' task, with which you
 * hand control back to the installer. Each custom page you
 * return needs to provide a way to continue, such as a form
 * submission or a link. You should also set custom page titles.
 *
 * You should define the list of custom tasks you implement by
 * returning an array of them in hook_profile_task_list(), as these
 * show up in the list of tasks on the installer user interface.
 *
 * Remember that the user will be able to reload the pages multiple
 * times, so you might want to use variable_set() and variable_get()
 * to remember your data and control further processing, if $task
 * is insufficient. Should a profile want to display a form here,
 * it can; the form should set '#redirect' to FALSE, and rely on
 * an action in the submit handler, such as variable_set(), to
 * detect submission and proceed to further tasks. See the configuration
 * form handling code in install_tasks() for an example.
 *
 * Important: Any temporary variables should be removed using
 * variable_del() before advancing to the 'profile-finished' phase.
 *
 * @param $task
 *   The current $task of the install system. When hook_profile_tasks()
 *   is first called, this is 'profile'.
 * @param $url
 *   Complete URL to be used for a link or form action on a custom page,
 *   if providing any, to allow the user to proceed with the installation.
 *
 * @return
 *   An optional HTML string to display to the user. Only used if you
 *   modify the $task, otherwise discarded.
 */
function re_profile_profile_tasks(&$task, $url) {
  // Include all the modules, particulary install_profile_api
  install_include(re_profile_profile_modules()); 
  
  // Set up input format filters
  re_profile_setup_filters();
  // Set up Wysiwyg
  re_profile_setup_wysiswyg();
  
  // Clear caches.
  drupal_flush_all_caches();

  // Enable default theme
  db_query("UPDATE {blocks} SET status = 0, region = ''");
  db_query("UPDATE {system} SET status = 0 WHERE type = 'theme'");
  variable_set('theme_default', 'descartes');

  // Insert default user-defined node types into the database. For a complete
  // list of available node type attributes, refer to the node type API
  // documentation at: http://api.drupal.org/api/HEAD/function/hook_node_info.
  $types = array(
    array(
      'type' => 'page',
      'name' => st('Page'),
      'module' => 'node',
      'description' => st("A <em>page</em>, similar in form to a <em>story</em>, is a simple method for creating and displaying information that rarely changes, such as an \"About us\" section of a website. By default, a <em>page</em> entry does not allow visitor comments and is not featured on the site's initial home page."),
      'custom' => TRUE,
      'modified' => TRUE,
      'locked' => FALSE,
      'help' => '',
      'min_word_count' => '',
    ),
  );

  foreach ($types as $type) {
    $type = (object) _node_type_set_defaults($type);
    node_type_save($type);
  }

  // Default page to not be promoted and have comments disabled.
  variable_set('node_options_page', array('status'));
  variable_set('comment_page', COMMENT_NODE_DISABLED);

  // Create the CSS Test Page
  install_create_node('CSS Test Page', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas nec pede id lectus volutpat sollicitudin. Proin at velit in ipsum ullamcorper viverra. Fusce id odio. Fusce lorem. This is a link. Phasellus non felis at velit volutpat accumsan. Duis in quam. Duis urna. Donec vel odio at orci dignissim interdum.</p> <ul> <li>Nunc pellentesque nisi ornare nequeMorbi mauris nulla, ultrices ut, aliquam vel, pretium ut, metus. </li> <li>Donec eleifed magna.</li> <li>Duis mattis.</li> </ul> <ol> <li>Nunc pellentesque nisi ornare nequeMorbi mauris nulla, ultrices ut, aliquam vel, pretium ut, metus. </li> <li>Donec eleifed magna.</li> <li>Duis mattis.</li> </ol> <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut pretium. Here’s an active link. Nunc ullamcorper elit in nulla.</p> <h2>Heading Two</h2> <p>Pellentesque risus purus, sagittis sit amet, feugiat nec, rhoncus eget, orci. Nunc orci risus, sodales in, sodales sit amet, tempor vel, nulla.</p> <h3>Heading Three</h3> <p>Pellentesque habitant <a href="/&lt;front&gt;">morbi tristique</a> senectus et netus et malesuada fames ac turpis egestas. Nunc vestibulum euismod sapien. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p> <h4>Heading Four</h4> <p><span class="dark-blue">Dark Blue text</span>. Ut aliquam egestas lectus. <span class="light-blue">Light blue text</span>. Mauris orci mi, <span class="orange">orange/yellow text</span>, cursus.</p> <h5>Heading Five</h5> <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas nec pede id lectus volutpat sollicitudin. Proin at velit in ipsum ullamcorper viverra. Fusce id odio. Fusce lorem. Proin eros.</p> <h6>Heading Six</h6> <p>Phasellus non felis at velit volutpat accumsan. Duis in quam. Duis urna. Donec vel odio at orci dignissim interdum.</p> <table border="0"><caption>Caption goes here </caption> <tbody><tr><td>Colin Calnan</td> <td>Something</td> <td>something else</td></tr> <tr class="even"><td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td></tr> <tr><td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td></tr> <tr class="even"><td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td></tr> <tr><td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td></tr> <tr class="even"><td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td></tr> <tr><td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td></tr> <tr class="even"><td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td></tr> <tr><td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td></tr> <tr class="even"><td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td></tr> <tr><td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td></tr> <tr class="even"><td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td></tr></tbody></table>
', array('type' => 'page', 'format' => 2));
  // Set up path aliases for the css test page
  install_menu_create_url_alias('node/1', 'csstestpage');
  // Set the default homepage to the above
  variable_set('site_frontpage', 'csstestpage');
  
  // Don't display date and author information for page nodes by default.
  $theme_settings = variable_get('theme_settings', array());
  $theme_settings['toggle_node_info_page'] = FALSE;
  variable_set('theme_settings', $theme_settings);

  // Update the menu router information.
  menu_rebuild();
  
  // Admin theme
  variable_set('admin_theme', 'garland');

  // Create the admin and editor roles.
  db_query("INSERT INTO {role} (name) VALUES ('%s')", 'site admin');
  db_query("INSERT INTO {role} (name) VALUES ('%s')", 'site editor');

  // Other variables worth setting.
  variable_set('site_footer', '<a href="http://www.raisedeyebrow.com/">Site design and development by Raised Eyebrow Web Studio, Inc.</a>');
  variable_set('date_default_timezone_name', 'America/Vancouver');

  // Set up custom date formats
  date_format_save(array('format' => 'F j, Y', 'type' => 'custom', 'locked' => 0, 'is_new' => 1));
  date_format_type_save(array('title' => 'Event View', 'type' => 'event_view', 'locked' => 0, 'is_new' => 1));
  variable_set('date_format_event_view', 'F j, Y');

  date_format_save(array('format' => 'F j, Y g:ia', 'type' => 'custom', 'locked' => 0, 'is_new' => 1));
  date_format_type_save(array('title' => 'Event View Time', 'type' => 'event_view_time', 'locked' => 0, 'is_new' => 1));
  variable_set('date_format_event_view_time', 'F j, Y g:ia');

}

/**
 * Implementation of hook_form_alter().
 *
 * Allows the profile to alter the site-configuration form. This is
 * called through custom invocation, so $form_state is not populated.
 */
function re_profile_form_alter(&$form, $form_state, $form_id) {
  if ($form_id == 'install_configure') {
    // Set default for site name field.
    $form['site_information']['site_name']['#default_value'] = $_SERVER['SERVER_NAME'];
    $form['site_information']['site_mail']['#default_value'] = 'admin@'. $_SERVER['HTTP_HOST'];
    $form['admin_account']['account']['name']['#default_value'] = 'admin';
    $form['admin_account']['account']['mail']['#default_value'] = 'webmaster@raisedeyebrow.com';   
  }
}

function re_profile_setup_filters() {
  db_query("update {filters} set weight=-10 where format=2 and module='filter' and delta=3");
  db_query("insert into {filters} (format, module, delta, weight) values (2, 'spamspan', 0, -9)");
  db_query("update {filters} set weight=-10 where format=2 and module='filter' and delta=2");
  db_query("delete from {filters} where format=2 and module='filter' and delta=1"); // line break converter
}

function re_profile_setup_wysiswyg() {
  $settings = array (
    'default' => 1,
    'user_choose' => 0,
    'show_toggle' => 1,
    'theme' => 'advanced',
    'language' => 'en',
    'buttons' => array (
      'default' => array (
        'bold' => 1,
        'italic' => 1,
        'underline' => 1,
        'strikethrough' => 1,
        'justifyleft' => 1,
        'justifycenter' => 1,
        'justifyright' => 1,
        'justifyfull' => 1,
        'bullist' => 1,
        'numlist' => 1,
        'outdent' => 1,
        'indent' => 1,
        'undo' => 1,
        'redo' => 1,
        'link' => 1,
        'unlink' => 1,
        'anchor' => 1,
        'image' => 1,
        'cleanup' => 1,
        'sup' => 1,
        'sub' => 1,
        'blockquote' => 1,
        'code' => 1,
        'cut' => 1,
        'copy' => 1,
        'paste' => 1,
      ),
      'font' => array (
        'formatselect' => 1,
      ),
      'paste' => array (
        'pasteword' => 1,
        'pastetext' => 1,
      ),
      'table' => array (
        'tablecontrols' => 1,
      ),
      'imce' => array (
        'imce' => 1,
      ),
      'wysiwyg' => array (
        'break' => 1,
      ),
    ),
    'toolbar_loc' => 'top',
    'toolbar_align' => 'left',
    'path_loc' => 'bottom',
    'resizing' => 1,
    'verify_html' => 1,
    'preformatted' => 0,
    'convert_fonts_to_spans' => 1,
    'remove_linebreaks' => 0,
    'apply_source_formatting' => 0,
    'paste_auto_cleanup_on_paste' => 1,
    'block_formats' => 'p,address,pre,h2,h3,h4,h5,h6,div',
    'css_setting' => 'none',
    'css_path' => '',
    'css_classes' => '',
  );
  
  $settings = serialize($settings);
  
  if (db_result(db_query("select count(*) as num from {wysiwyg} where format=2"))) {
    db_query("update {wysiwyg} set editor='tinymce', settings='%s where format=2", $settings);
  }
  else {
    db_query("insert into {wysiwyg} (format, editor, settings) values(2, 'tinymce', '%s')", $settings);
  }
}
