<?php
/**
 * @todo: combine all admin functions [?]:
 * 
 * 	-- node_debug()
 *	-- descartes_admin_stylesheet()
 *
 * Be sure to distinguish between user 1 and 'administer nodes' users
 */


// Define constants:
define('DESCARTES_DISPLAY_ORDER', '2-1-3');

// Include required libraries:
require 'library/php/jsmin-1.1.1.php';

/**
 * This function loads custom javascript files for admins. 
 *
 * @param object $variables Variables object--needed to add stylesheet to page
 */
function descartes_admin_scripts(&$variables) {
	if(user_access('access administration pages') && user_access('access administration menu')) {
		// If we're using admin menu:
		if(module_exists('admin_menu') || !module_exists('devel')) {
			// Get the path to the script:
			$path_to_theme = path_to_theme();
			if (strpos($path_to_theme, 'descartes/')) {  // If 'descartes/' (instead of 'descartes') appears in this theme, we're in a sub-theme...
				$admin_js_path = str_replace(strrchr($path_to_theme, '/'), '', $path_to_theme) .'/scripts/admin.js';
			} else { // Otherwise, we're in descartes and we don't need to do anything fancy...
				$admin_js_path = $path_to_theme .'/scripts/admin.js';
			}
			// Turn on the toggle for capturing the menus:
  		drupal_add_js($admin_js_path, $type = 'theme', $scope = 'header');
  	}
  }
  return true;
} // descartes_admin_scripts()


/**
 * This function loads a special stylesheet for admins. All styles for administrative activities
 * should be placed in this stylesheet.
 *
 * @param object $variables Variables object--needed to add stylesheet to page
 */
function descartes_admin_stylesheet(&$variables) {
	if(user_access('access administration pages') && user_access('access administration menu')) {
  	//drupal_add_css(path_to_theme() .'/styles/admin.css', $type = 'theme', $media = 'screen');
  	// Get the path to the stylesheet:
		$path_to_theme = path_to_theme();
		if (strpos($path_to_theme, 'descartes/')) {  // If 'descartes/' (instead of 'descartes') appears in this theme, we're in a sub-theme...
			$admin_css_path = str_replace(strrchr($path_to_theme, '/'), '', $path_to_theme) .'/styles/admin.css';
		} else { // Otherwise, we're in descartes and we don't need to do anything fancy...
			$admin_css_path = $path_to_theme .'/styles/admin.css';
		}
		drupal_add_css($admin_css_path, $type = 'theme', $media = 'screen');
  	$variables['styles'] = drupal_get_css();
  }
  return true;
} // descartes_admin_stylesheet()


/**
 * A function for building logo image markup since theme_image() requires
 * the path to image in a different form than is provided by the Drupal themes
 * interface.
 *
 * @param string $logo Path to logo as available from page.tpl.php
 * @return string $img_markup A complete html img element
 */
function descartes_build_logo_img($logo) {
  $img_details = getImageSize(descartes_root_base_path() . $logo);
  $img_markup = '<img src="'. $logo .'" alt="Logo image" '. $img_details[3] .' />';
  return $img_markup;
} // descartes_build_logo_img()


/**
 * A function that takes an array or string of attribute values and an attribute name and returns
 * a properly formatted HTML attribute. This function is more a bit more flexible than Drupal's
 * similar drupal_attributes() function in that this one a) can accept either a string or an array,
 * and b) doesn't require that the keys of the array be named.
 *
 * On the other hand, some other Drupal API functions--notably l()--expect an associative array of
 * attributes. When preparing arrays of attributes, their expected use should be borne in mind.
 *
 * The attribute string is padded with leading spaces so it can be used like this:
 *
 * $link_attributes = get_attribute_string($name, $values);
 * $link_markup = '<p'. $link_attributes .'>'. $link_text .'</p>';
 *
 * @param 		string $name The attribute name
 * @param 		string|array $values The attribute value(s); may be an array or a string
 * @return		string $attribute The complete html attribute, including padding with leading spaces
 */
function descartes_get_attribute_string($name, $values) {
  // Some variables:
  $attribute_string = '';
  $attribute = '';
  if(is_array($values)) { // If $values is an array...
    if(count($values) == 0) { // If it's an empty array...
      // Quit:
      return;
    } else { // Otherwise...
      // Loop through the array:
      foreach($values as $item => $value) {
        // And add each attribute plus a space to the output string:
        $attribute_string .= $value .' ';
      }
    }
  } else { // Otherwise...
    if($values == '') { // If $values is an empty string...
      // Quit:
      return;
    } else {
      // The attribute string is identical to $values:
      $attribute_string = $values;
    }
  }
  // Build the formatted attribute:
  $attribute = ' '. $name .'="'. rtrim($attribute_string) .'"';
  // Return it:
  return $attribute;
} // descartes_get_attribute_string()


/**
 * A function that takes a file object and a media_mover element array and set the file path to 
 * its media moved path on Amazon S3 or wherever it moved to.
 *
 * It uses the unique file_id identifier to match file with media_mover file.
 *
 * $file = $variables['file_image'][0];
 * $media_mover = $variables['media_mover'][{id of media mover configuration}];
 *
 * @param 		$file A Drupal file array
 * @param 		$media_mover A media_mover file/element array
 */
function descartes_get_media_mover_files(&$file, $media_mover) {	
	if(module_exists('media_mover_api')) { // If media mover is installed...
		foreach($media_mover as $media) { // Loop through each media_moved file...
			if($media['fid'] == $file['fid']) { // If they match (file id is a unique identifier...
				$file['filepath'] = $media['complete_file']; // Replace the attached file path with the media moved file path...
			}
		}
	}
} // descartes_get_media_mover_files()


/**
 * This function builds a set of suggested template names for the current page based on the following criteria:
 *
 * 	-- the current path
 *	-- the content type
 * 	-- whether this is the front page
 *
 * Usually called from descartes_preprocess_page().
 * 
 * @param string $path Path to the current page (ideally, the result of Drupal's drupal_get_path_alias() function)
 * @param string $node_type The type of the current node
 * @return array $suggestions An array containing at least one suggestion
 * @todo Merge with descartes_get_section_class()?
 */
function descartes_get_page_template_suggestions($path, $node_type) {
	$current_path_arguments = explode('/', $path);
  $content_type = $node_type;
  $suggestion_base = 'page';
  $suggestions = array();
  // Generate suggestions based on path:
  foreach($current_path_arguments as $argument) {
  	$suggestions[] = $suggestion_base .'-'. $argument;
  	//if(!is_numeric($argument)) {
  		$suggestion_base .= '-'. $argument;
  	//}
  }
  // Generate more suggestions based on content type:
  if(isset($content_type) && $content_type != $template_filename) {
  	$suggestions[] = 'page-'. $content_type;
  }
  // Generate another in case this is the front page:
  if(drupal_is_front_page()) {
  	$suggestions[] = 'page-front';
  }
  return $suggestions;
} // descartes_get_page_template_suggestions()


/**
* This function gets a class for the current section; usually this will be called by
* descartes_preprocess_page(), but it's sometimes useful to have this logic available outside
* that function (e.g. when building CSS selectors dynamically).
*
* @param $path (string) The current Drupal page path
* @return
* @see get_body_class_and_id()
* @todo merge with descartes_get_page_template_suggestions()?
*/
function descartes_get_section_class($path) {
	// Vars:
	$section_class_segment = '';
	// Get the class for this section:
	list($section_class_segment,) = explode('/', $path, 2);
	// Decide what to do if $section_class_segment is empty:
	if(!$section_class_segment) {
		$section_class_segment = ' home';	
	}
	// Format this class name by adding 'section-' to it:
	$section_class = ' section-' . $section_class_segment;
	// Return a value:
	return $section_class;
} // descartes_get_section_class()


/**
 * A function to generate a delimited line of links
 * 
 * @param array $links An array of items to list; should be one of:
 *												a) an array of arrays suitable for use with l(); or
 *												b) an array of strings 
 * 										 If the array items are found to be arrays, they will be passed to
 *										 l(); if they are not, they will simply be added to the output
 *										 array. We assume that items passed to this function have already
 *										 been passed through t() or l()!
 * @param string $delimiter (default: ' | ') The separator used to 'glue' the items together
 * @return string The formatted list of items
 * @see l()
 */
function descartes_links_flat(array $links, $delimiter = ' | ') {
	$links_html = array(); // Initialize a bucket to store the list items...
	foreach($links as $link) { // Loop through the array...
		// Arrays get passed through l(); non-arrays don't...
		if(is_array($link)) {
			// Not all links are made the same, some use text and path...
			if($link['text'] && $link['path']) {
				$links_html[] = l($link['text'], $link['path'], $link['options']);
			} elseif($link['title'] && $link['href']) { // other suse title and href...
				$links_html[] = l($link['title'], $link['href'], $link['attributes'] ? $link['attributes'] : array()); // Note that any attributes passed to l() must be an array!
			}
		} else {
			$links_html[] = (string) $link;
		}
	}
	// Glue the array values together with the specified delimiter...
	return implode((string) $delimiter, $links_html);
} // descartes_links_flat()



/** 
 * Implementation of theme_meni_local_task().
 *
 * Remove the forums tab from Groups landing page
 **/
function descartes_menu_local_task($link, $active = FALSE) {
  if(strstr($link, "/og/forum")) {
    return;
  }
  return '<li ' . ($active ? 'class="active" ' : '') . '>' . $link . "</li>\n";
}


/**
 * Implementation of theme_node_submitted()
 **/
function descartes_node_submitted($node) {
  // If the creator of the node has a profile then link to that in the submitted by info...
  if($profile = content_profile_load('contact', $node->uid)) {
    $name = $profile->title . ' ' . $profile->field_contact_last_name[0]['value'];
    $path = $profile->path;
    $link = l($name, $path);
  } else {
    $link = theme('username', $node);
  }  
  return t('Submitted by !username on @datetime', 
    array(
    '!username' => $link, 
    '@datetime' => format_date($node->created),
  ));
}


function descartes_comment_submitted($comment) {
  if($profile = content_profile_load('contact', $comment->uid)) {
    $name = $profile->title . ' ' . $profile->field_contact_last_name[0]['value'];
    $path = $profile->path;
    $link = l($name, $path);
  } else {
    $link = theme('username', $node);
  }  
  return t('Submitted by !username on @datetime.', 
    array(
    '!username' => $link,  
    '@datetime' => format_date($comment->timestamp),
  ));
}



/**
 * Override or insert variables into the block templates.
 *
 * @param array $vars An array of variables to pass to the theme template.
 * @param string $hook The name of the template being rendered ("block" in this case.)
 */
function descartes_preprocess_block(&$vars, $hook) {
  $block = $vars['block'];
  // Set up classes array
  $classes = array('block');
  $classes[] = 'block-' . $block->module;

  //Edit links
  $vars['edit_links_array'] = array();
  $vars['edit_links'] = '';
  if (user_access('administer blocks')) {
    drupal_add_css(path_to_theme(). '/styles/block-editing.css', 'theme', 'screen');
    $vars['styles'] = drupal_get_css();
    include_once './' . drupal_get_path('theme', 'descartes') . '/template.block-editing.inc';
    descartes_preprocess_block_editing($vars, $hook);
    $classes[] = 'with-block-editing';
  }

  // Render block classes.
  $vars['classes'] = implode(' ', $classes);
} // descartes_preprocess_block()

/**
 * Implementation of preprocess_content hook
 */

function descartes_preprocess_content_field(&$variables) {
	//kpr($variables);
}


/**
 * Implementation of preprocess_node hook
 */

function descartes_preprocess_node(&$variables, $hook) {
	// Determine which Node we are on
	switch ($variables['type']) {
    case 'contact':
      // Get the organization address
      $org = node_load($variables['field_organization_ref'][0]['nid']);
      $variables['location'] = $org->field_location;
      $user = user_load($variables['uid']);
      if(count($user->og_groups) > 0) {
        foreach($user->og_groups as $group) {
          $items[] = l($group['title'], drupal_get_path_alias('groups/' . $group['nid']));
        }      
        $variables['field_groups'] = theme('item_list', $items);
      }
      break;

		// if Blog Node
		case 'trial_renewal':
      // Combine trial begins and trial ends into one output field called licence term
			$variables['license_term'] = $variables['field_trial_begins'][0]['value'] . ' - ' . $variables['field_trial_ends'][0]['value'];
			//
			if ($variables['field_trial_active'][0]['value'] == 'N') {
				$variables['trial_active'] = 'Please Note: This Renewal is not currently active. This documentation is for reference only';
			}
				
			// Load the related resource node, this will be used further down to get Vendor and License Information
			$res_ref = node_load($variables['field_resource_ref'][0]['nid']);
			// Set the overview variable to the Resource body
			$variables['tr_resource_overview'] = $res_ref->body;
			// Set the sub options variable to the Resource sub options
			$variables['tr_resource_sub_options'] = $res_ref->field_resource_sub_options[0]['value'];
			$variables['tr_resource_access'] = $res_ref->field_resource_access[0]['value'];
			$variables['tr_resource_name'] = $res_ref->title;
			
			
			// Load the related vendor node from the Resource Node
			$vend_ref = node_load($res_ref->field_resource_vendor_ref[0]['nid']);
			$variables['tr_vendor_name'] = l($vend_ref->title, drupal_get_path_alias('node/'. $vend_ref->nid));
			
			// Load the related license node from the Resource Node
			$lic_ref = node_load($res_ref->field_resources_license[0]['nid']);
			$variables['tr_license_name'] = l($lic_ref->title, drupal_get_path_alias('node/'. $lic_ref->nid));
		
			if ($variables['field_trial_staff'][0]['uid']) {
				$fullname = content_profile_load('contact',$variables['field_trial_staff'][0]['uid']);
				$variables['field_contact_last_name'] = $fullname->field_contact_last_name[0]['value'];
				$variables['field_contact_first_name'] = $fullname->title;
				$variables['field_contact_jobtitle'] = $fullname->field_contact_jobtitle[0]['value'];
				$variables['field_contact_phone'] = $fullname->field_contact_phone[0]['value'];
				$variables['field_contact_jobtitle'] = $fullname->field_contact_jobtitle[0]['value'];
				$userdet = user_load($variables['field_trial_staff'][0]['uid']);
				$variables['user_email'] = $userdet->mail;
				//kpr($userdet);
			}
		
		break;
		
		case 'resource':
			// create a new array
			$content_types = array();
				// get the values from content_types
				$conttypes = $variables['field_resources_content_types'];
					if ($conttypes) {
						// loop through the array
						foreach($conttypes as $conttype) {
							// confirm that we are in an array
							if(is_array($conttype)) {
								// create an array of content types
								$content_types[] = $conttype['view'];
							}
						}
						// overwrite the variable with the imploded list
						$variables['field_resources_content_types'] = implode(", ", $content_types);
					}
		
			if ($variables['field_resources_license'][0]['nid']) {
				$anode = node_load($variables['field_resources_license'][0]['nid']);
				$variables['licenseinfo'] = node_view($anode, $teaser = FALSE, $page = FALSE, $links = FALSE);
			}

      if($variables['field_resource_vendor_ref'][0]['nid']) {
        $anode = node_load($variables['field_resource_vendor_ref'][0]['nid']);
				$variables['vendorinfo'] = node_view($anode, $teaser = FALSE, $page = FALSE, $links = FALSE);
      }
			
			if ($variables[field_resource_title_lists][0]['url']) {
				// loop through the array
				foreach($variables[field_resource_title_lists] as $attachment) {
		
					// Set the link text to the file's description
					$text = $attachment['data']['description'];
		
					// Create an array of links and add the attachment class
					$items[] = l($text, $attachment['filepath'], $options = array('attributes' => array('class' => 'attachment')));
				}
					// create a new variable using the theme item list function
					$variables['tr_license_attachments'] = theme('item_list', $items);	
			}	

      if($variables['field_organization_ref'][0]['nid']) {
        foreach($variables['field_organization_ref'] as $org) {
          $orgs[] = $org['view'];
        }
        $variables['participating_institutions'] = theme('item_list', $orgs);
      }
					
					
		break;
		
		case 'organization':
			// create a new array
			$ip_addresses = array();
				// get the values from content_types
				$ipaddresses = $variables['field_org_ip'];
					if ($ipaddresses) {
						// loop through the array
						foreach($ipaddresses as $ipaddress) {
							// confirm that we are in an array
							//if(is_array($ipaddress)) {
								// create an array of content types
								$ip_addresses[] = $ipaddress['view'];
							//}
						}
						// overwrite the variable with the imploded list
						$variables['field_org_ip'] = implode("<br>", $ip_addresses);
					}

      // create a new array
			$referring_urls = array();
				// get the values from content_types
				$referring = $variables['field_org_refer_url'];
					if ($referring) {
						// loop through the array
						foreach($referring as $url) {
							// confirm that we are in an array
							//if(is_array($ipaddress)) {
								// create an array of content types
								$referring_urls[] = $url['view'];
							//}
						}
						// overwrite the variable with the imploded list
						$variables['field_org_refer_url'] = implode("<br>", $referring_urls);
					}
		
		break;
		
		case 'event':
		
			/*$dates = array();
			// get the values from content_types
			$events = $variables['field_date'];
				if ($events) {
					// loop through the array
					foreach($events as $event) {
						// create an array of content types
						$dates[] = $event['view'];
					}
					// overwrite the variable with the imploded list
					$variables['field_date'] = implode("<br>", $dates);
				}*/

              	 
			date_default_timezone_set('America/Vancouver'); 
			$variables['from_date'] = date('l, F j, Y', date_convert($variables['field_date'][0]['value'], DATE_DATETIME, DATE_UNIX)); 
			if ($variables['field_date'][0]['value2']) {
				$variables['to_date'] = date('l, F j, Y', date_convert($variables['field_date'][0]['value2'], DATE_DATETIME, DATE_UNIX));
			}

			// If they are the same day then don't disaply the to date
			if($variables['from_date'] === $variables['to_date']) {
				unset($variables['to_date']);	
			}
			
			$variables['from_time'] = date('g:i a', date_convert($variables['field_date'][0]['value'], DATE_DATETIME, DATE_UNIX));
			$variables['to_time'] = date('g:i a', date_convert($variables['field_date'][0]['value2'], DATE_DATETIME, DATE_UNIX));
			
			if($variables['field_date'][0]['value'] === $variables['field_date'][0]['value2']) { 
				$variables['from_time'] = '(All day)'; 
				unset($variables['to_time']);
				unset($variables['to_date']);
			}
			
			$variables['repeat_rule'] = date_repeat_rrule_description($variables['field_date'][0]['rrule'], 'l, F j, Y');


			$variables['maplink'] = l('Map', 'http://maps.google.ca/?q=' . $variables['field_event_location'][0]['street'] . ', ' . $variables['field_event_location'][0]['city'] . ', ' . $variables['field_event_location'][0]['province'], $options = array('attributes' => array('class' => 'maplink', 'target' => '_blank')));
		
		break;
		
		case 'license':
		
			if ($variables['field_attachments'][0]['fid']) {
				// loop through the array
				foreach($variables['field_attachments'] as $attachment) {
		
					// Set the link text to the file's description
					$text = $attachment['data']['description'];
		
					// Create an array of links and add the attachment class
					$items[] = l($text, $attachment['filepath'], $options = array('attributes' => array('class' => 'attachment')));
				}
					// create a new variable using the theme item list function
					$variables['license_attachments'] = theme_item_list($items);	
			}	
		
		break;
		
	}

  // Adding search box to the 404 page not found node
  $error_id = explode('/', variable_get('site_404', ''));
  $denied_id = explode('/', variable_get('site_403', ''));
	if($variables['nid'] == $error_id[1] || $variables['nid'] == $denied_id[1]) {
		$search_form = $search_form = drupal_get_form('search_theme_form'); //descartes_rewrite_search_box(NULL, NULL, FALSE, '<div id="in-content-search">%1$s%2$s</div>');
		$variables['content'] .= $search_form;
	}

} 


/**
 * Implementation of preprocess_page hook
 */
function descartes_preprocess_page(&$variables) {
  // Cache frequently used variables:
	$current_page_path = drupal_get_path_alias($_GET['q']);
	$node_type = $variables['node']->type;
  // Remove all sidebars from block admin page and content edit page
	if($current_page_path == 'admin/build/block' || $current_page_path == 'admin/build/block/list' || strstr($current_page_path,  'admin/build/views/edit'))  {
		unset($variables['left']);
		unset($variables['right']);
	}
  // Removes the Users tab from the Search page.
  descartes_removetab('Users', $variables);
  // Figure out sidebars:
  descartes_set_source_order($variables);
  // Load admin stylesheet for all admin access:
  descartes_admin_stylesheet($variables);
  // Get body classes per section:
  $variables['body_classes'] .= descartes_get_section_class($current_page_path);
  // Get page template name suggestions:
  $variables['template_files'] = descartes_get_page_template_suggestions($current_page_path, $node_type);
  // Load admin javascript:
  descartes_admin_scripts($variables);
  // If there are features on this site
  if(module_exists('features')) {
    // Get list of features
    $features = features_get_features();
    // Loop through the features
    foreach($features as $feature) {
      // If the feature is enabled
      if($feature->status) {
        // If the feature has a CSS file
        if(file_exists(path_to_theme() . '/styles/features/' . $feature->name . '.css')) {
          // Load the CSS file
          drupal_add_css(path_to_theme() . '/styles/features/' . $feature->name . '.css');
        }
      }
    }
  }
  // If this is a panels page load the panels styles
  if(module_exists('page_manager') && page_manager_get_current_page()){
    drupal_add_css(path_to_theme() . '/styles/panels.css');
  }
	
  // Set up template variables:
  $variables['styles'] = drupal_get_css();
  $variables['scripts'] = drupal_get_js();
} // descartes_preprocess_page()


/**
 * Remove undesired local task tabs.
 **/
function descartes_removetab($label, &$variables) {
  $tabs = explode("\n", $variables['tabs']);
  $variables['tabs'] = '';

  foreach ($tabs as $tab) {
    if (strpos($tab, '>' . $label . '<') === FALSE) {
      $variables['tabs'] .= $tab . "\n";
    }
  }
} // descartes_removetab()


/**
 * A function for determining the base path from root.
 *
 * @param boolean $add_final_slash Drupal usually doesn't want a final slash, but we might sometimes need one
 * @return string $server_path Path from root
 */
function descartes_root_base_path($add_final_slash = FALSE) {
  $cwd = getcwd();
  $base_path = rtrim(base_path(), '/');
  $server_path = str_replace($base_path, '', $cwd) . ($add_final_slash ? '/' : '');
  return $server_path;
} // descartes_server_path()


/**
 * Uses the display order specified in descartes_DISPLAY_ORDER to populate the
 * various div elements in page.tpl.php with the correct sidebar contents; also
 * changes layout class attribute accordingly.
 *
 * @param array $variables
 */
function descartes_set_source_order(&$variables) {
  // Figure out sidebars:
  if($variables['left'] && $variables['right']) { // If both sidebars are present...
    $layout_class_order = DESCARTES_DISPLAY_ORDER;
    $source_order = explode('-', $layout_class_order);
    if($source_order[0] == '2') { // If the first column displayed is second in the source-order...
      $variables['secondary'] = $variables['left'];
      $variables['tertiary'] = $variables['right'];
    } else if($source_order[0] == 3) { // If the first column displayed is third in the source order...
      $variables['secondary'] = $variables['right'];
      $variables['tertiary'] = $variables['left'];
    }
  } else if($variables['left'] && !$variables['right']) { // If only the left sidebar is present...
    $layout_class_order = '2-1';
    $variables['secondary'] = '';
    $variables['tertiary'] = $variables['left'];
  } else if(!$variables['left'] && $variables['right']) { // If only the right sidebar is present...
    $layout_class_order = '1-2';
    $variables['secondary'] = '';
    $variables['tertiary'] = $variables['right'];
  } else { // If neither sidebar is present...
    $layout_class_order = '1';
  }
  $variables['layout_class_attribute'] = descartes_get_attribute_string('class', 'layout-'. $layout_class_order);
} // descartes_source_order()


/**
 * descartes_taxonomy_links function. Outputs a list of taxonomy term links
 * 
 * @param mixed $nid Id of the current node
 * @param mixed $vid Id of the vocabulary of interest
 * @param string $label_override. (default: 'none') Override the default label (the vocabulary name)
 * @param string $format. (default: '%1$s: %2$s') Output format for the list of links
 * @param array $options Options for l() function
 * @return string
 * @see l()
 * @see sprintf()
 * @see descartes_links_flat()
 */
function descartes_taxonomy_links($node, $vid, $label_override = 'none', $format = '%1$s: %2$s', $options = array()) {
	// Get output var ready:
	$term_links = array();
	// First, find out everything we can about this vocabulary:
	$vocabulary = taxonomy_vocabulary_load($vid);
	// Then, get all its terms:
	$terms = taxonomy_node_get_terms_by_vocabulary($node, $vid);
	// Then, prepare an array of link info (structured suitable for use with l()):
	$term_links_data = array();
	foreach($terms as $term) {
		$term_links_data[$term->tid] = array(
			'text' => $term->name,
			'path' => drupal_get_path_alias('taxonomy/term/'. $term->tid),
			'options' => $options,
		);
	}
	// Get the list of links:
	$term_links = descartes_links_flat($term_links_data, ', ');
	// If there ARE term links:
	if($term_links != '') {
		// Return a value:
		return sprintf($format, $label_override != 'none' ? $label_override : $vocabulary->name, $term_links);
	} else {
		return;
	}
} // descartes_taxonomy_list()


/**
 * This function returns the cached value for a given cache entry. If the entry does not exist, or if
 * the entry is empty, this function executes the passed function, caches the result and returns it.
 * This function should only be used with database or resource-intensive functions.
 * 
 * @param string $cache_entry The full name of the cache entry--remember the namespace (e.g. descartes_theme:some_cache_entry_name)!
 * @param array $function An array with two keys:
 *													string $function['name'] The name of the function
 *													string $function['parameters'] A comma-separated list of parameters
 * @param string $table The name of the cache table to use (see cache_set())
 * @param CACHE_PERMANENT|CACHE_TEMPORARY|unix timestamp $expire Expiry period for this cache entry
 * @param boolean $reset If true, regenerate cache entry; if false, check first
 * @return string|array|object $cache_data The contents of the relevant row in the cache table
 * @see http://api.drupal.org/api/function/cache_set/6
 * @see http://api.drupal.org/api/function/cache_get/6
 */
function descartes_theme_cache($cache_entry, $function, $table = 'cache', $expire = CACHE_PERMANENT, $reset = FALSE) {
  static $cache_data; // Establish the $cache_data variable for this page load...
  if(!isset($cache_data) || $reset) { // If the variable is not set, or if a cache reset has been requested...
  	if(!$reset && ($cache = cache_get($cache_entry)) && !empty($cache->data)) { // If $cache->data is set and reset not requested...
  		$cache_data = $cache->data; // Store the current value of $cache->data...
  	} else { // If we need to (re) generate the cache...
  		$function_name = $function['name']; // Get the function name to call..
  		$function_parameters = $function['parameters']; // Get the parameters for the function...
  		$cache_data = $function_name($function_parameters); // Set cache data to the return value of the function...
  		cache_set($cache_entry, $cache_data, $table, $expire); // Cache the resulting value...
  	}
  }
  return $cache_data; // Return the cached value...
} // descartes_theme_cache()


/**
 * Provides a collapsible display of node data after each node on a page
 *
 * OBSOLETE
 *
 * @param object $nodeThe node object
 * @return string collapsible node data
 */
function node_debug($node) {
	dcpr($node);
} // node_debug()


/**
 * Abbreviated replacement for node_deubg() function. This function's basic job
 * is to not break sites if the Devel module is removed. Use instead of kpr().
 *
 * Possibly this, along with numerous other functions in this theme, belongs in
 * a module.
 *
 * @param mixed The variable to be debugged.
 * @return string collapsible node data
 * @see scripts/admin.js in reyebrow_descartes theme.
 */
function dcpr($content) {
	if (!module_exists('devel')) {
		global $user;
		if ($user->uid == 1) {
			printf('<div class="reyebrow-descartes-dcpr"><h4><a href="#">[+]</a> Data</h4><pre style="display:none;">%s</pre></div>', htmlspecialchars(print_r($content, TRUE)));
		}
	}
	else {
		kpr($content);
	}
	return;
} // dcpr()
?>