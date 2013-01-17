<?php


/**
 * @file
 * The Droptor bridge module  
 * Droptor.com - Drupal site organization, monitoring, management and best practices
 * 
 * For more information, see:
 * - http://www.droptor.com
 * - http://drupal.org/project/droptor
 */

/**
 * Main feed wrapper routine, which calls all of the functions that gather data for returning to Droptor
 *
 * @param n/a
 *
 * @return
 *   A great big serialized set of data that Droptor improts
 */
function droptor_feed() {
  // We only show the feed if the hash key is passed in and if the request comes from droptor.com 
  // (headers can be spoofed, so we use the hash keys too). It's not paranoia if they're really after you.
  $correct_hash = droptor_check_hash();
  $correct_host = droptor_check_domain();
  $correct_security = droptor_check_connection_security();

  if ( $correct_hash && $correct_host && $correct_security ) {
    $data = array();
    $data['droptor-data-feed']['droptor_feed_version'] = '180';
    $data['droptor-data-feed']['monitor_text_match'] = variable_get('droptor_monitor_text_match', NULL);
    $data['droptor-data-feed']['ssl_login'] = droptor_ssl_login();
    $data['droptor-data-feed']['ssl_enabled'] = droptor_ssl_enabled();
    $data['droptor-data-feed']['settings_permissions_read_only'] = droptor_settings_permissions_read_only();
    $data['droptor-data-feed']['extra_files_removed'] = droptor_extra_files_removed();
    $data['droptor-data-feed']['node_statistics'] = droptor_node_statistics();
    $data['droptor-data-feed']['user_statistics'] = droptor_user_statistics();
    $data['droptor-data-feed']['statistics'] = droptor_statistics();
    $data['droptor-data-feed']['last_nodes'] = droptor_last_nodes();
    $data['droptor-data-feed']['last_users'] = droptor_last_users();
    $data['droptor-data-feed']['watchdog_size'] = droptor_watchdog_size();
    $data['droptor-data-feed']['site_name'] = variable_get('site_name', '{unknown}');
    $data['droptor-data-feed']['modules'] = droptor_modules();
    $data['droptor-data-feed']['variables_data'] = droptor_variables_data();
    $data['droptor-data-feed']['recent_pages_not_found'] = droptor_recent_pages_not_found();
    $data['droptor-data-feed']['last_logins'] = droptor_last_logins();
    $data['droptor-data-feed']['feed_over_ssl'] = variable_get('droptor_ssl_feed', 0);
    $data['droptor-data-feed']['memory_monitoring_status'] = droptor_memory_monitoring_status();
    $data['droptor-data-feed']['memory_monitoring_logs'] = droptor_memory_monitoring_logs();
    $data['droptor-data-feed']['user_1_name'] = droptor_user_1_name();
    $data['droptor-data-feed']['high_permission_count'] = droptor_high_permission_count();
    $data['droptor-data-feed']['module_update_data'] = droptor_module_update_data();
    $data['droptor-data-feed']['trends'] = droptor_get_trends();
    
    if (variable_get('droptor_debug_mode', 0) == 1) {
      $data['droptor-data-feed']['debug_remote_addr'] = ip_address();
    }

    // Add in custom checklists that other modules have defined.
    $data['droptor-data-feed']['custom_checklists'] = droptor_get_custom_checklists();
  
    print serialize($data);
  }
  elseif (!$correct_hash)
    echo t('Invalid hash');
  elseif (!$correct_host)
    echo t('Invalid host') . '(' . ip_address() . ')';
  elseif (!$correct_security)
    echo t('Invalid security');
  
  exit; // http://stackoverflow.com/questions/2102688/how-do-you-replace-the-page-tpl-php-that-loads-from-a-module-in-drupal
}

/**
 * Gather up custom checklists defined by other modules and send to Droptor.
 * See droptor.api.inc for implementation instructions.
 *
 * @return
 *  An array of custom chechklists to pass to Droptor.
 */
function droptor_get_custom_checklists() {
  // Load from cache if we can.
  $cache = cache_get('droptor-custom-checklists', 'cache');
  if(!empty($cache->data)) {
    return $cache->data;
  }

  // Since we don't have hook_hook_info() like in D7, we manually sniff out if
  // module.droptor.inc files exist in our modules and include that file before
  // invoking the hook.
  $list = module_list(FALSE, TRUE);
  foreach ($list as $module) {
    if(file_exists(drupal_get_path('module', $module) . "/$module.droptor.inc")) {
      module_load_include('inc', $module, "$module.droptor");
    }
  }

  // Get all of the custom checklists defined by other modules.
  $module_checklists = array();
  foreach(module_implements('droptor_checklists') as $module) {
    $function = "{$module}_droptor_checklists";
    $module_checklists += $function();
  }

  $custom_checklists = array();
  foreach($module_checklists as $machine_name => $module_checklist) {
    // If we don't have a 'checked' value provided in the array we look for
    // a callback function using the machine name of the checklist item. This
    // function should return a TRUE or FALSE that we can set to the checked
    // value.
    if(!isset($module_checklist['checked'])) {
      if(($function = str_replace('-', '_', $machine_name)) && function_exists($function)) {
        $module_checklist['checked'] = (bool)$function();
      }
      else {
        $message = t('Cannot find callback function <em>@function()</em> for custom checklist item @machine_name. Checklist will not be sent to Droptor. Ensure you either have a key "checked" defined in your hook_droptor_checklists() returned array or a callback function that matches the array index of the checklist item.');
        $data = array('@function' => $function, '@machine_name' => $machine_name);
        watchdog('droptor', $message, $data, WATCHDOG_ERROR);
      }
    }

    // We don't need the machine name, so strip that out. Also, if we still
    // don't have a checked value, we don't use it.
    if(isset($module_checklist['checked'])) {
      $custom_checklists[] = $module_checklist;
    }
  }

  cache_set('droptor-custom-checklists', $custom_checklists, 'cache');

  return $custom_checklists;
}

/**
 * The total number of users and nodes created in the last hour, for proactive alerts
 *
 * @param n/a
 *
 * @return
 *   A serialized array of the total new users and nodes in the last hour
 */
function droptor_get_trends() {
   $total_users_created_last_hour = 0;
   $total_nodes_created_last_hour = 0;
   
   // get the total user count for the last hour
   $user_query = 'SELECT count(*) as usercount FROM {users} WHERE %d - 60*60 < created ORDER BY created DESC';
   $user_results = db_query($user_query, time());
   while ($user_result = db_fetch_array($user_results)) {
      $total_users_created_last_hour = $user_result['usercount'];
      break;
   }
   
   // get the total node count for the last hour
   $node_query = 'SELECT count(*) as nodecount FROM {node} WHERE %d - 60*60 < created ORDER BY created DESC';
   $node_results = db_query($node_query, time());
   while ($node_result = db_fetch_array($node_results)) {
      $total_nodes_created_last_hour = $node_result['nodecount'];
      break;
   }
   
   return array('new_users'=>$total_users_created_last_hour, 'new_nodes'=>$total_nodes_created_last_hour);
}

/**
 * Get the full module update status data for all modules
 *
 * @param n/a
 *
 * @return
 *   A serialized dump of the module update array data
 */
function droptor_module_update_data() {
  $module_meta_data = update_get_available(TRUE);
  return serialize(update_calculate_project_data($module_meta_data));
}

/**
 * The number of users who have admin user role.
 *
 * @param n/a
 *
 * @return
 *   A number
 */
function droptor_high_permission_count() {
   $count = null;
   $sql = 'SELECT COUNT(DISTINCT u.uid) as count FROM {users} u JOIN {users_roles} ur ON u.uid = ur.uid JOIN {permission} p ON ur.rid = p.rid WHERE u.status = 1 AND p.perm LIKE \'%administer permissions%\' OR p.perm LIKE \'%administer users%\'';
   $result = db_query($sql);
   while ($r = db_fetch_array($result)) {
      $count = $r['count'];      
      break;
   }
   
   return is_numeric($count) ? $count : null;
}

/**
 * The username of the Drupal super-duper user
 *
 * @param n/a
 *
 * @return
 *   The username field for user id = 1
 */
function droptor_user_1_name() {
   $return = null;
   $sql = 'SELECT name from {users} WHERE uid = 1 LIMIT 1';
   $result = db_query($sql);
   while ($r = db_fetch_array($result)) {
      $return = $r['name'];      
      break;
   }
   
   return $return;
}

/**
 * Memory monitoring has three states: on, off or not supported
 *
 * @param n/a
 *
 * @return
 *   The status of memory monitoring: 1, 0 or unsupported
 */
function droptor_memory_monitoring_status() {
	return !droptor_has_memory_management() ? 'unsupported' : variable_get('droptor_memory_monitoring',0);
}

/**
 * Pulls the memory usage logs from the database and cleans out the old ones
 *
 * @param n/a
 *
 * @return
 *   An array of memory log data or FALSE if turned off
 */
function droptor_memory_monitoring_logs() {
   $logs = false;
   if(variable_get('droptor_memory_monitoring',0) == 1) {
		$logs = array();
		// pull it out
		$query = 'SELECT q, dt, memory, execution_time FROM {droptor_memory} ORDER BY dt';
  		$results = db_query($query);
		while ($result = db_fetch_array($results)) {
		   $logs[] = array('q'=>$result['q'],'dt'=>$result['dt'],'memory'=>$result['memory'],'execution_time'=>$result['execution_time']);  			
		}
		// delete the data now that we have it
		$delete_query = 'DELETE FROM {droptor_memory}';
		db_query($delete_query);	
	}
	
	return $logs;
}

/**
 * Grabs the failed logins in the last hour
 *
 * @param n/a
 *
 * @return
 *   An array of who and when of failed logins
 */
function droptor_last_logins() {
  $query = "SELECT message, variables, timestamp FROM {watchdog} WHERE message LIKE 'login attempt failed%' AND %d - 60*60 < timestamp ORDER BY timestamp DESC";
  $results = db_query($query, time());
  $last_logins = array();
  
  while ($result = db_fetch_array($results)) {
    $variables = unserialize($result['variables']);
    $last_logins['failed'][$result['timestamp']] = $variables['%user'];
  }
  return $last_logins;
}

/**
 * Grabs all system variables
 *
 * @param n/a
 *
 * @return
 *   An array of all of the variables for the site
 */
function droptor_variables_data() {
  $variables = array();
  $results = db_query('SELECT name, value FROM {variable} ORDER BY name');
  
  while ($result = db_fetch_array($results)) {
    $variables[$result['name']] = unserialize($result['value']);
  }
  return serialize($variables);
}

/**
 * Grabs the last 404 errors in logs, excluding the checks we run for drupal files like README
 *
 * @param n/a
 *
 * @return
 *   An array of the pages not found and some associated data
 */
function droptor_recent_pages_not_found() {
  $data = array();
  $row = 0;
  
  $results = db_query_range('SELECT message, hostname, referer, timestamp FROM {watchdog} WHERE type = "page not found" AND message NOT IN("UPGRADE.txt", "MAINTAINERS.txt", "README.txt", "INSTALL.pgsql.txt", "INSTALL.txt", "LICENSE.txt", "INSTALL.mysql.txt", "COPYRIGHT.txt", "CHANGELOG.txt") ORDER BY timestamp DESC', 0, 10);
  
  while ($result = db_fetch_array($results)) {
    $data[$row]['message'] = $result['message'];
    $data[$row]['hostname'] = $result['hostname'];
    $data[$row]['referer'] = $result['referer'];
    $data[$row]['timestamp'] = $result['timestamp'];
    
    $row++;
  }
  
  return $data;
}

/**
 * Grabs all system variables
 *
 * @param n/a
 *
 * @return
 *   An array of all of the variables for the site
 */
function droptor_watchdog_size() {
  return db_result(db_query('SELECT COUNT(*) FROM {watchdog}'));
}

/**
 * Get total nodes created by day, for the last 30 days, for charting
 *
 * @param n/a
 *
 * @return
 *   An array of total nodes created each day for the last month
 */
function droptor_node_statistics() {
  $results = db_query_range("SELECT COUNT(*) AS total, DATE_FORMAT(FROM_UNIXTIME(created), '%m/%%d/%Y') AS dt FROM {node} GROUP BY DATE_FORMAT(FROM_UNIXTIME(created), '%m/%%d/%Y') ORDER BY created DESC", 0, 30);
  $data = array();
  while ($result = db_fetch_array($results)) {
    $data[$result['dt']] = $result['total'];
  }
  
  return $data;
}

/**
 * Get total users created by day, for the last 30 days, for charting
 *
 * @param n/a
 *
 * @return
 *   An array of total users created each day for the last month
 */
function droptor_user_statistics() {
  $results = db_query_range("SELECT COUNT(*) AS total, DATE_FORMAT(FROM_UNIXTIME(created), '%m/%%d/%Y') AS dt FROM {users} GROUP BY DATE_FORMAT(FROM_UNIXTIME(created), '%m/%%d/%Y') ORDER BY created DESC", 0, 30);
  $data = array();
  while ($result = db_fetch_array($results)) {
    $data[$result['dt']] = $result['total'];
  }
  
  return $data;
}

/**
 * Get lsat 15 nodes created
 *
 * @param n/a
 *
 * @return
 *   An array of the details of last 15 nodes created
 */
function droptor_last_nodes() {
  $last_five_nodes = array();
  $query = db_query_range('SELECT title, nid, created FROM {node} ORDER BY created DESC', 0, 15);

  $count = 0;
  while ($data = db_fetch_array($query)) {
    $last_five_nodes[$count]['url'] = drupal_get_path_alias('node/' . $data['nid']);
    $last_five_nodes[$count]['title'] = $data['title'];
    $last_five_nodes[$count]['created'] = $data['created'];
    $count++;
  }
  
  return $last_five_nodes;
  
}

/**
 * Get lsat 15 users created
 *
 * @param n/a
 *
 * @return
 *   An array of the details of last 15 users created
 */
function droptor_last_users() {
  $last_five_users = array();
  $query = db_query_range('SELECT uid, mail, name, created FROM {users} ORDER BY created DESC', 0, 15);

  $count = 0;
  while ($data = db_fetch_array($query)) {
    $last_five_users[$count]['uid'] = $data['uid'];
    $last_five_users[$count]['name'] = $data['name'];
    $last_five_users[$count]['email'] = $data['mail'];
    $last_five_users[$count]['created'] = $data['created'];
    $count++;
  }
  
  return $last_five_users;
}

/**
 * Wrapper function to get node and user stats
 *
 * @param n/a
 *
 * @return
 *   An array of various node and user statistics
 */  
function droptor_statistics() {
   return droptor_node_and_user_totals();
}

/**
 * A list of every module in the system
 *
 * @param n/a
 *
 * @return
 *   A serialized list of module details array
 */
function droptor_modules() {
  $query_result = db_query('SELECT name, status, info, type FROM {system} ORDER BY status DESC, name');
  $modules = array();
    
  while ($data = db_fetch_object($query_result)) {
    $info = unserialize($data->info);
    $modules[$data->name]['version'] = $info['version'];
    $modules[$data->name]['status'] = $data->status;
    $modules[$data->name]['name'] = $info['name'];
    $modules[$data->name]['project'] = isset($info['project']) ? $info['project'] : NULL;
    $modules[$data->name]['type'] = $data->type;
  }

  return serialize($modules);
}

/**
 * Check to see if the unneeded release files with Drupal are removed
 *
 * @param n/a
 *
 * @return
 *   True if they are removed, false if they aren't
 */
function droptor_extra_files_removed() {
  $clean_codebase = TRUE;
  $url = url(NULL, array('absolute' => TRUE));
  $files_to_remove = array('CHANGELOG.txt', 'COPYRIGHT.txt', 'INSTALL.mysql.txt', 'INSTALL.pgsql.txt', 'INSTALL.txt', 'LICENSE.txt', 
    'MAINTAINERS.txt', 'README.txt', 'UPGRADE.txt');
  
  foreach ($files_to_remove as $file) {
    $path = $_SERVER{'DOCUMENT_ROOT'} . base_path() . $file;
    if (file_exists($path))
      $clean_codebase = FALSE;
  }
  
  return $clean_codebase ? 1 : 0;
}

/**
 * Determines if settings.php is read-only
 *
 * @param n/a
 *
 * @return
 *   TRUE if the settings file is read-only, and FALSE if it isn't.
 */
function droptor_settings_permissions_read_only() {
  $settings_permissions_read_only = TRUE;
  $writes = array('2', '3', '6', '7'); // http://en.wikipedia.org/wiki/File_system_permissions
  $settings_file = './'. conf_path(FALSE, TRUE) .'/settings.php';
  $permissions = drupal_substr(sprintf('%o', fileperms($settings_file)), -4);  
  
  foreach ($writes as $bit) {
    if (strpos($permissions, $bit)) {
      $settings_permissions_read_only = FALSE;      
      break;
    }
  }
  
  return $settings_permissions_read_only;
  
}

/**
 * Checks to see if SSL login is required
 *
 * @param n/a
 *
 * @return
 *   True if login is secure, false if not
 */
function droptor_ssl_login() {
  $login_safe = 0;
  $securepages_login_query = db_query('SELECT value FROM {variable} WHERE name = "%s"', 'securepages_pages');
  while ($securepages_login_results = db_fetch_object($securepages_login_query)) {
    $pages = $securepages_login_results->value;
    if (strpos($pages, 'user*') > 0) // 'user/* ' is invalid! see http://www.droptor.com/support/#ssl-login
      $login_safe = 1; // @todo - check the ignore pages field      
  }

  // If we don't see SecurePages, let's see if they hard
  // redirect the /user page to https to ensure the login is secure
  if ($login_safe === 0) {
    // Make sure we are getting to non-SSL
    $login_url = url('user', array('absolute' => TRUE));
    $login_url = str_replace('https://', 'http://', $login_url);
    $request = drupal_http_request($login_url, array(
      // we don't let us move along, we just want to see if we do
      'max_redirects' => 0,
      'timeout' => 2,
    ));
    $login_safe = isset($request->code) && in_array($request->code, array(301, 302, 303)) &&
      isset($request->redirect_url) && strpos($request->redirect_url, 'https://') !== FALSE ? 1 : 0;
  }
  
  return $login_safe;
}

/* INTERNALS */
/* INTERNALS */
/* INTERNALS */

/**
 * Quickly check if a URL exists
 * b/c drupal_http_request() is wicked slow compared to straight curl
 *
 * @param n/a
 *
 * @return
 *   True if the URL exists, false otherwise
 */
function droptor_fast_url_check($url) {
  $valid = FALSE;
  
  if (in_array('curl', get_loaded_extensions())) {
    $curl = curl_init();  
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_exec($curl);
    $result = curl_getinfo($curl);
    curl_close($curl);
    $valid = $result['http_code'] == '200' ? TRUE : FALSE;
  } 
  else {
    $result = drupal_http_request($url);
    $valid = $result->code == 200 ? TRUE : FALSE;
  }  
  
  return $valid;
}

/**
 * Total number of nodes (and by type) and total user count
 *
 * @param n/a
 *
 * @return
 *   An array of user and node stats
 */
function droptor_node_and_user_totals() {
  $stats = array();
    
  // total users
  $total_users_query = db_query('SELECT COUNT(*) as total_users FROM {users}');
  $total_users_result = db_fetch_array($total_users_query);
  $stats = is_array($total_users_result) && count($total_users_result) == 1 ? array_merge($stats, $total_users_result) : $stats;

  // total nodes
  $total_nodes_query = db_query('SELECT COUNT(*) as total_nodes, nt.name as type FROM {node} n JOIN {node_type} nt ON n.type = nt.type GROUP BY type ORDER BY nt.name');
  $total_nodes = 0;
  $nodes_by_type = array();
  
  while ($node_type_data = db_fetch_array($total_nodes_query)) {
    $nodes_by_type[$node_type_data['type']] = $node_type_data['total_nodes'];
    $total_nodes += $node_type_data['total_nodes'];
  }
  
  $stats['total_nodes'] = $total_nodes;
  $stats['total_nodes_by_type'] = $nodes_by_type;
    
  return $stats;
}

