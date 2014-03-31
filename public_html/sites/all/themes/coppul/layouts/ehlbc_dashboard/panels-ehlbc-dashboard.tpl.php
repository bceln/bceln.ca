<?php
/**
 * @file
 * Template for a 2 column panel layout.
 *
 * This template provides a two column 33%-66% panel display layout.
 *
 * Variables:
 * - $id: An optional CSS id to use for the layout.
 * - $content: An array of content, each item in the array is keyed to one
 *   panel of the layout. This layout supports the following sections:
 *   - $content['sidebar_left']: Content in the left sidebar.
 *   - $content['content_main']: Content in the main content area.
 *
 * We've left the basic layout, regardless if there is content to fill it!
 */
?>
<div class="ehlbc_dashboard"<?php if (!empty($css_id)) { print ' id="' . $css_id. '"'; } ?>>
  <div class="row">
    <div class="columns three" id="sidebar-left">
      <?php if ($content['sidebar_left']): ?>
        <?php print $content['sidebar_left']; ?>
      <?php endif; ?>
    </div>
    <div class="columns nine" id="content-main">
      <?php if ($content['content_main']): ?>
        <?php print $content['content_main']; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

