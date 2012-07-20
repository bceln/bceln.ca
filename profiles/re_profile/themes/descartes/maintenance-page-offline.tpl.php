<?php
	/**
	 * Template for instance where database is not available. Will not take effect
	 *	unless the following line is added to settings.php:
	 *
	 *	$conf['maintenance_theme'] = 'descartes';
	 * 
	 * @see maintenance-page.tpl.php
	 * @see http://drupal.org/node/195435
	 */
	$head_title = 'Title Element:';
	//$site_name = '';
	//$logo = '';
	//$site_slogan = '';
	$content = '<p>This site is currently off-line for maintenance. We should be back shortly. Thank you for your patience.</p>';
	include_once('page.tpl.php');
?>