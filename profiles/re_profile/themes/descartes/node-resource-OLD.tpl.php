<?php
	// Source: http://api.drupal.org/api/file/modules/node/node.tpl.php/6/source

	/**
	 * @file node.tpl.php
	 *
	 * Theme implementation to display a node.
	 *
	 * Available variables:
	 * - $title: the (sanitized) title of the node.
	 * - $content: Node body or teaser depending on $teaser flag.
	 * - $picture: The authors picture of the node output from
	 *   theme_user_picture().
	 * - $date: Formatted creation date (use $created to reformat with
	 *   format_date()).
	 * - $links: Themed links like "Read more", "Add new comment", etc. output
	 *   from theme_links().
	 * - $name: Themed username of node author output from theme_user().
	 * - $node_url: Direct url of the current node.
	 * - $terms: the themed list of taxonomy term links output from theme_links().
	 * - $submitted: themed submission information output from
	 *   theme_node_submitted().
	 *
	 * Other variables:
	 * - $node: Full node object. Contains data that may not be safe.
	 * - $type: Node type, i.e. story, page, blog, etc.
	 * - $comment_count: Number of comments attached to the node.
	 * - $uid: User ID of the node author.
	 * - $created: Time the node was published formatted in Unix timestamp.
	 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
	 *   teaser listings.
	 * - $id: Position of the node. Increments each time it's output.
	 *
	 * Node status variables:
	 * - $teaser: Flag for the teaser state.
	 * - $page: Flag for the full page state.
	 * - $promote: Flag for front page promotion state.
	 * - $sticky: Flags for sticky post setting.
	 * - $status: Flag for published status.
	 * - $comment: State of comment settings for the node.
	 * - $readmore: Flags true if the teaser content of the node cannot hold the
	 *   main body content.
	 * - $is_front: Flags true when presented in the front page.
	 * - $logged_in: Flags true when the current user is a logged-in member.
	 * - $is_admin: Flags true when the current user is an administrator.
	 *
	 * @see template_preprocess()
	 * @see template_preprocess_node()
	 */
?>
  <span id="return-res"><?php print l('Return to Resources', 'resources-databases'); ?></span>
  <div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?> clear-block">
	<?php print $picture; ?>
	<?php if (!$page && $title != ''): ?>
		<h2><a href="<?php print $node_url; ?>" title="<?php print $title; ?>"><?php print $title; ?></a></h2>
	<?php endif; ?>
  <?php print $links; ?>
	<div class="meta">
		<?php if ($submitted): ?>
			<span class="submitted"><?php print $submitted; ?></span>
		<?php endif; ?>
		<?php if ($terms): ?>
			<div class="terms terms-inline"><?php print $terms; ?></div>
		<?php endif; ?>
	</div>
	<div class="content">
    <?php if ($field_private_note[0]['value'] && user_access('view field_private_note', $user)): ?>
			<div class="field private-note">
        <h2>Private Note</h2>
        <?php print $field_private_note [0]['view']; ?>
      </div>
		<?php endif; ?>

    <?php if ($licenseinfo): ?>
    <fieldset class="fieldgroup group-license collapsible collapsed">
    <legend>View License Details</legend>
    <?php print $licenseinfo; ?>
    </fieldset>
    <?php endif; ?>
		
    <div class="row">
      <div class="col">
  		<?php if ($field_resource_license_begins[0]['value']): ?> 
  			<h2>License Begins</h2>
  				<div class="field"><?php print $field_resource_license_begins[0]['view']; ?></div>
  		<?php endif; ?>
      </div>
      <div class="col">
  		<?php if ($field_resource_license_ends[0]['value']): ?> 
  			<h2>License Ends</h2>
  				<div class="field"><?php print $field_resource_license_ends[0]['view']; ?></div>
  		<?php endif; ?>
      </div>
    </div>

    <div class="inset">
  		<?php if ($field_resource_vendor_ref[0]['nid']): ?> 
  			<h2>Vendor </h2>
  		  <div class="field"><?php print $field_resource_vendor_ref[0]['view']; ?></div>
  		<?php endif; ?>
  		
  		<?php if ($field_resource_vend_desc[0]['value']): ?> 
  			<h2>Vendor Description URL</h2>
  			<div class="field"><?php print $field_resource_vend_desc[0]['view']; ?></div>
  		<?php endif; ?>
  		
  		<?php if ($field_resource_content_producer[0]['value']): ?> 
  			<h2>Content Producer</h2>
  			<div class="field"><?php print $field_resource_content_producer[0]['view']; ?></div>
  		<?php endif; ?>
    </div>

		<?php if ($node->content['body']['#value']): ?> 
			<h2>Description</h2>
				<div class="field"><?php print $node->content['body']['#value']; ?></div>
		<?php endif; ?>

		<?php if ($field_resources_generic_url[0]['url']): ?> 
			<h2>Connect to the Database</h2>
			<div class="field">
        <?php print $field_resources_generic_url[0]['view']; ?>
        <div class="help"><a href="/home/do-i-have-access-e-hlbc" title="Why can't I connect to the database?">Why can't I connect to the database?</a></div>
      </div>
		<?php endif; ?>

		<?php if ($field_resource_sub_options[0]['value']): ?> 
			<h2>Subscription Options</h2>
				<div class="field"><?php print $field_resource_sub_options[0]['view']; ?></div>
		<?php endif; ?>

    <div class="row">
      <div class="col">
  		<?php if ($field_resource_godot[0]['value']): ?> 
  			<h2>GODOT Enabled</h2>
  			<div class="field"><?php print $field_resource_godot[0]['view']; ?></div>
  		<?php endif; ?>
  		</div>

  		<div class="col">
  		<?php if ($field_resources_chron_coverage[0]['value']): ?> 
  			<h2>Chron Coverage</h2>
  			<div class="field"><?php print $field_resources_chron_coverage[0]['view']; ?></div>
  		<?php endif; ?>
  		</div>

  		<div class="col">
  		<?php if ($field_resources_db_updates[0]['value']): ?> 
  			<h2>Updates</h2>
  			<div class="field"><?php print $field_resources_db_updates[0]['view']; ?></div>
  		<?php endif; ?>
  		</div>

      <div class="col">
  		<?php if ($field_resources_ft_titles[0]['value']): ?> 
  			<h2>FT Titles</h2>
  			<div class="field"><?php print $field_resources_ft_titles[0]['view']; ?></div>
  		<?php endif; ?>
  		</div>
		</div>

		<?php if ($field_resource_title_lists[0]['url']): ?> 
			<h2>Title Lists</h2>
        <ul class="field">
        <?php foreach($field_resource_title_lists as $title) { ?>
			   <li><?php print $title['view']; ?></li>
        <?php } ?>
      </ul>
		<?php endif; ?>

		<?php if ($field_resources_content_types): ?> 
			<h2>Content Types</h2>
			<div class="field"><?php print $field_resources_content_types; ?></div>
		<?php endif; ?>

		<?php if ($field_resource_access[0]['value']): ?> 
			<h2>Access Details</h2>
			<div class="field"><?php print $field_resource_access[0]['view']; ?></div>
		<?php endif; ?>
	
		<?php if ($field_resources_usage_stats[0]['value']): ?> 
			<h2>Usage Stats</h2>
			<div class="field"><?php print $field_resources_usage_stats[0]['view']; ?></div>
		<?php endif; ?>

    <?php if ($participating_institutions): ?> 
			<h2>Participating Institutions</h2>
			<div class="field"><?php print $participating_institutions; ?></div>
		<?php endif; ?>
									
	</div>
    <?php //dcpr($node); ?>
</div>
