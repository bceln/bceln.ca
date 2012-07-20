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
?><div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?> clear-block">
	<?php print $picture; ?>
	<?php if (!$page && $title != ''): ?>
		<h2><a href="<?php print $node_url; ?>" title="<?php print $title; ?>"><?php print $title; ?></a></h2>
	<?php endif; ?>
  <?php print $links; ?>
	<div class="meta">
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

    <?php if ($field_vendor_sales[0]['value']): ?>
			<h2>Sales Contact</h2>
			<div class="field"><?php print $field_vendor_sales[0]['view']; ?></div>
		<?php endif; ?>

    <?php if ($field_tech_contact[0]['value']): ?>
			<h2>Technical Support Contact</h2>
			<div class="field"><?php print $field_tech_contact[0]['view']; ?></div>
		<?php endif; ?>
		
		<?php if($variables['field_location'][0]['lid']): ?>
			<h2>Address</h2>
			<div class="location vcard field">
				<div class="adr"> <span class="fn"></span> 
				<div class="street-address"><?php print $field_location[0]['street'] ?></div> 
				<span class="locality"><?php print $field_location[0]['city'] ?></span> 
				<span class="postal-code"><?php print $field_location[0]['postal_code'] ?></span>
				<div class="country-name"><?php print $field_location[0]['country_name'] ?></div>
				</div> <!-- // close adr -->
			<div class="map-link"> </div> 
			</div> <!-- // close location vcard -->
		<?php endif; ?>
		
		<?php if ($field_vendor_url[0]['url']): ?>
			<h2>URL</h2>
			<div class="field"><?php print $field_vendor_url[0]['view']; ?></div>
		<?php endif; ?>
		
	</div>
    <?php dcpr($node); ?>
</div>
