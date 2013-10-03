<?php
/**
 * @file
 * Cogito's theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $content: The markup content of the header region. This will be a series
 *   of blocks. Typically it's just the search block.
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity: (These are applied in template.php)
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 * - $hide_site_name: TRUE if the site name has been toggled off on the theme
 *   settings page. If hidden, the "element-invisible" class is added to make
 *   the site name visually hidden, but still accessible.
 * - $hide_site_slogan: TRUE if the site slogan has been toggled off on the
 *   theme settings page. If hidden, the "element-invisible" class is added to
 *   make the site slogan visually hidden, but still accessible.
 *
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 */  ?>

<?php /* MOBILE MENU NAVBAR: a secondary menu intended for devices with with narrow screens. */?>
<div id="mobile-nav-trigger" class="show-for-small row">
  <div class="columns phone-four">
    <a id="menu-link" data-reveal-id="mobile-nav" href="#">Menu</a>
  </div>
</div>

<nav id="mobile-nav" role="navigation" class="reveal-modal">
      <?php print render($page['nav_mobile']); ?>
</nav>

<div id="page" class="hfeed" role="main">

  <?php /* Header */?>
  <div class="header-outer">
    <header id="branding" role="banner" class="row">
      <div class="twelve columns">
       <?php print $cogito_header; ?>
      </div>
    </header>
  </div>

  <?php /* Navbar Menu */?>
  <?php if ($page['nav']): ?>
  <div class="access-outer">
    <nav id="access" role="navigation" class="row hide-for-small">
      <?php print render($page['nav']); ?>
    </nav>
  </div>
  <?php endif; ?>

  <?php /* Slideshow */?>
  <?php if ($page['slideshow']): ?>
    <div id="slideshow" class="row hide-for-small">
          <?php print render($page['slideshow']); ?>
    </div>
  <?php endif; ?>

  <?php /* Main Row */?>
  <div id="main" class="row">

      <?php /* Content Region */?>
      <div id="content" class="<?php print $content_size; ?>" role="main">
          <?php if ($page['highlighted']): ?>
            <?php print render($page['highlighted']); ?>
          <?php endif;
          if ($breadcrumb): ?>
            <div id="breadcrumb" class=""><?php print $breadcrumb; ?></div>
          <?php endif;
          print $messages;
          if ($title && !drupal_is_front_page()): ?>
            <h1 id="page-title"><?php print $title; ?></h1>
          <?php endif; ?>
          <?php
          if ($tabs['#primary'] != ""): ?>
            <div class="drupal_tabs"><?php print render($tabs); ?></div>
          <?php endif; ?>
          <?php print render($page['help']); ?>
          <?php if ($node->type === 'resource'): ?>
          <span id="return-res"><a href="/resources-databases">Return to Resources</a></span>
          <?php endif; ?>
          <?php if ($action_links): ?>
          <dl class="sub-nav action-links"><?php print render($action_links); ?></dl>
          <?php endif; ?>
          <?php print $feed_icons; ?>

         <?php print render($page['pre_content']);?>
         <?php print render($page['content']);?>
         <?php print render($page['post_content']);?>
      </div>

      <?php /* Left Sidebar */?>
      <?php if (isset($page['sidebar_first'])): ?>
        <aside id="sidebar-left" class="<?php print $lsb_size; ?>" role="complementary">
          <?php print render($page['sidebar_first']); ?>
       </aside>
      <?php endif; ?>

      <?php /* Right Sidebar */?>
      <?php if (isset($page['sidebar_second'])): ?>
        <aside id="sidebar-right" class="<?php print $rsb_size; ?>" role="complementary">
          <?php print render($page['sidebar_second']); ?>
        </aside>
      <?php endif; ?>


  </div>


  <?php /* Footer */?>
  <footer id="footer" role="contentinfo" class="row">
      <?php print render($page['footer']); ?>
  </footer>
  
  <?php print render($page['overlay']); ?>

</div>
