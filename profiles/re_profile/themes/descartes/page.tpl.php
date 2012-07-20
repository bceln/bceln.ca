<?php
	// Source: http://api.drupal.org/api/file/modules/system/page.tpl.php/6/source 

	/**
	 * @file page.tpl.php
	 *
	 * Theme implementation to display a single Drupal page.
	 *
	 * Available variables:
	 *
	 * General utility variables:
	 * - $base_path: The base URL path of the Drupal installation. At the very
	 *   least, this will always default to /.
	 * - $css: An array of CSS files for the current page.
	 * - $directory: The directory the theme is located in, e.g. themes/garland or
	 *   themes/garland/minelli.
	 * - $is_front: TRUE if the current page is the front page. Used to toggle the mission statement.
	 * - $logged_in: TRUE if the user is registered and signed in.
	 * - $is_admin: TRUE if the user has permission to access administration pages.
	 *
	 * Page metadata:
	 * - $language: (object) The language the site is being displayed in.
	 *   $language->language contains its textual representation.
	 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
	 * - $head_title: A modified version of the page title, for use in the TITLE tag.
	 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
	 *   so on).
	 * - $styles: Style tags necessary to import all CSS files for the page.
	 * - $scripts: Script tags necessary to load the JavaScript files and settings
	 *   for the page.
	 * - $body_classes: A set of CSS classes for the BODY tag. This contains flags
	 *   indicating the current layout (multiple columns, single column), the current
	 *   path, whether the user is logged in, and so on.
	 *
	 * Site identity:
	 * - $front_page: The URL of the front page. Use this instead of $base_path,
	 *   when linking to the front page. This includes the language domain or prefix.
	 * - $logo: The path to the logo image, as defined in theme configuration.
	 * - $site_name: The name of the site, empty when display has been disabled
	 *   in theme settings.
	 * - $site_slogan: The slogan of the site, empty when display has been disabled
 	 *   in theme settings.
	 * - $mission: The text of the site mission, empty when display has been disabled
	 *   in theme settings.
	 *
	 * Navigation:
	 * - $search_box: HTML to display the search box, empty if search has been disabled.
	 * - $primary_links (array): An array containing primary navigation links for the
	 *   site, if they have been configured.
	 * - $secondary_links (array): An array containing secondary navigation links for
	 *   the site, if they have been configured.
	 *
	 * Page content (in order of occurrance in the default page.tpl.php):
	 * - $left: The HTML for the left sidebar.
	 *
	 * - $breadcrumb: The breadcrumb trail for the current page.
	 * - $title: The page title, for use in the actual HTML content.
	 * - $help: Dynamic help text, mostly for admin pages.
	 * - $messages: HTML for status and error messages. Should be displayed prominently.
	 * - $tabs: Tabs linking to any sub-pages beneath the current page (e.g., the view
	 *   and edit tabs when displaying a node).
	 *
	 * - $content: The main content of the current Drupal page.
	 *
	 * - $right: The HTML for the right sidebar.
	 *
	 * Footer/closing data:
	 * - $feed_icons: A string of all feed icons for the current page.
	 * - $footer_message: The footer message as defined in the admin settings.
	 * - $footer : The footer region.
	 * - $closure: Final closing markup from any modules that have altered the page.
	 *   This variable should always be output last, after all other dynamic content.
	 *
	 * @see template_preprocess()
	 * @see template_preprocess_page()
	 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
<head>
	<title><?php print $head_title; ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<?php print $head; ?>
	<?php print $styles; ?>
	<?php print $scripts; ?>
  <style type="text/css" media="print">@import "/<?php print $directory; ?>/styles/print.css";</style>
  <!--[if lte IE 7]><link type="text/css" rel="stylesheet" media="all" href="/<?php print $directory; ?>/styles/if_IE.css" /><![endif]-->
   <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'4e1667cf-8007-473e-96b5-3eda0d97f1fb'});</script>
</head>
<body class="<?php print $body_classes; ?>">
	<p id="skip-to-content"><a href="#bd">Skip to main content</a></p>
  <p id="skip-to-nav"><a href="#navigation">Skip to main navigation</a></p>
  <div id="dc-container">
  	<?php
  	// Notice [block region]
  	if(!empty($notice)) { print '<div id="notice-region">'. $notice .'</div>'. chr(10); }
  	?>
    <div id="hd">
      <div id="hd-wrapper">
      
        <div id="site-name">
        	<?php
        	// Logo
          if(!empty($logo)) { print l(descartes_build_logo_img($logo), '<front>', $options = array('attributes' => array('title' => 'Go to home page...'), 'html' => TRUE)) . chr(10); }
          
          // Site Name
          if(!empty($site_name)) { print l($site_name, '<front>', $options = array('attributes' => array('title' => 'Go to home page...'))) . chr(10); }
          ?>
        </div><!-- /site-name -->
        <?php 
        // Site Slogan
        if(!empty($site_slogan)) { print $site_slogan . chr(10); }
        
        // Search Box
        if(!empty($search_box)) { print $search_box; }
        
        // Header [block region]
        if(!empty($header)) { print $header . chr(10); }
        
        ?>
      </div> <!-- /hd-wrapper -->
      <?php
      // Primary Links
      if(!empty($primary_links)) { print '<div id="navigation">'. theme('links', $primary_links, array('class' => 'links primary-links')) .'</div>'. chr(10); }
      
      // Secondary Links
      if(!empty($secondary_links)) { print theme('links', $secondary_links, array('class' => 'links secondary-links')) . chr(10); }
      
      // Mission
      if(!empty($mission)) { print '<div id="mission">'. $mission .'</div>'. chr(10); } 
      ?>
    </div><!-- /hd -->
    <div id="bd"<?php print $layout_class_attribute; ?>>
      <div class="dc-main">
        <div class="dc-div">
          <div id="utilities">
					</div>
          <?php if (!empty($secondary)): ?>
          <div class="dc-main">
            <div class="dc-div">
          <?php endif; ?>
              <?php if (!$is_front): if (!empty($title)): ?><h1 class="title" id="page-title"><?php print $title; ?></h1><?php endif; endif;?>
              <?php if (!empty($tabs)): ?><div class="tabs"><?php print $tabs; ?></div><?php endif; ?>
              <?php if (!empty($messages)): print $messages; endif; ?>
              <?php if (!empty($help)): print $help; endif; ?>
              <?php print $pre_content; ?>
              <?php print $content; ?>
              <?php print $post_content; ?>
              <?php
								if(!empty($in_content_left) || !empty($in_content_right)):
									print '<div id="in-content-blocks">'. chr(10);
									print '<div id="in-content-left"';
										if (empty($in_content_right)): print ' class="no_content_right"'; endif;
									print '>'. $in_content_left .'</div>'. chr(10);
									print '<div id="in-content-right"';
										if (empty($in_content_left)): print ' class="no_content_left"'; endif;
									print '>'. $in_content_right .'</div>'. chr(10);
									print '</div>'. chr(10);
								endif;
							?>
              <?php print $feed_icons; ?>
          <?php if (!empty($secondary)): ?>
              </div><!-- /dc-div -->
          </div><!-- /dc-main -->
          <?php endif; ?>

          <?php if (!empty($secondary)): ?>
            <div class="dc-sub" id="sub-1">
            <?php print $secondary; ?>
            </div><!-- /dc-sub -->
          <?php endif; ?>

        </div><!-- /dc-div -->
      </div><!-- /dc-main -->

      <?php if (!empty($tertiary)): ?>
        <div class="dc-sub" id="sub-2">
        <?php print $tertiary; ?>
        </div><!-- /dc-sub -->
      <?php endif; ?>
    </div><!-- /bd -->
    <div id="ft">
      <?php print $footer_message; ?>
      <?php if (!empty($footer)): print $footer; endif; ?>
    </div><!-- /ft -->
  </div><!-- /dc-container -->
  <?php if($development): print $development; endif; ?>
  <?php print $closure; ?>
</body>
</html>