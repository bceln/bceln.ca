<div class="<?php print $classes; ?>" id="<?php print "block-$block->module-$block->delta"; ?>">
	<?php print ($block->subject ? '<h3>'. $block->subject .'</h3>' : ''); ?>
	<div class="content"><?php print $block->content; ?></div>
  <?php print $edit_links; ?>
</div>
