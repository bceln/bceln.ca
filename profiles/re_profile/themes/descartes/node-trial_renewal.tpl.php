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
  global $user;

?><div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?> clear-block">
	<?php print $picture; ?>
	<?php if (!$page && $title != ''): ?>
		<h2><a href="<?php print $node_url; ?>" title="<?php print $title; ?>"><?php print $title; ?></a></h2>
	<?php endif; ?>
  <?php print $links; ?>
	<div class="meta">
		<?php if ($submitted): ?>
			<span class="submitted"><?php print $submitted; ?></span>
		<?php endif; ?>
		<?php //if ($terms): ?>
			<!-- <div class="terms terms-inline"><?php //print $terms; ?></div> -->
		<?php //endif; ?>
	</div>
	<div class="content">
    <?php if ($field_private_note[0]['value'] && user_access('view field_private_note', $user)): ?>
			<div class="field private-note">
        <h2>Private Note</h2>
        <?php print $field_private_note [0]['view']; ?>
      </div>
		<?php endif; ?>

		<?php if($tr_resource_name): ?>

			<h2><?php print $tr_resource_name; ?></h2>
		
		<?php endif; ?>
	
	
		<?php if($field_trial_active[0]['value'] == 'N'): ?>
			<div class="trial_active field">
	    	<?php print t('<strong><span class="notice">Please Note</span>: This Renewal is not currently active. This documentation is for reference only.</strong>'); ?>
	    </div>
	  <?php endif; ?>
	 
	 	<?php if($field_trial_deadline[0]['value']): ?>
	  	<div class="trial_deadline field">
		    <?php print t('<div class="deadline"><strong>*** Response Deadline: ' . format_date(strtotime($field_trial_deadline[0]['value']), 'custom', 'F j, Y') . ' ***</strong></div>'); ?>
			</div>
		<?php endif; ?>
	    
	  <?php if($field_trial_preamble[0]['value']): ?>
	    <h2>Preamble</h2>
      <div class="trial_preamble field">
	    	<?php print $field_trial_preamble[0]['value']; ?>
	    </div>
		<?php endif; ?>
	
		<?php if($field_trial_updates[0]['value']): ?>    
	    <h2>Updates</h2>
      <div class="trial_updates field">
	    	<?php print $field_trial_updates[0]['value']; ?>
	    </div>
		<?php endif; ?>
		
		<h2>Vendor Description</h2>
			<div class="trial_overview field">
				<?php print $tr_resource_overview; ?>
			</div>

		<?php if($field_trial_add_desc[0]['value']): ?>   
			<!-- outputting addition description -->
			<h2>Additional Description</h2>
      <div class="trial_add_desc field">
		    <?php print $field_trial_add_desc[0]['value']; ?>	
			</div>
		<?php endif; ?>
			
			<h2>Resource Subscription Options</h2>
      <div class="sub_options field">
		    <?php print $tr_resource_sub_options; ?>
			</div>
					
		<?php if($tr_resource_access): ?> 				
			<h2>Access Details</h2>
			<div class="access_details field">
				Resource Access Details: <?php print $tr_resource_access; ?>
			</div>
		<?php endif; ?>

		<h2>Vendor Information</h2>		
			<div class="vendor_name field">
				Vendor Name: <?php print $tr_vendor_name; ?>
			</div>

		<h2>Subscription Information</h2>
		
			<div class="license_term field">
				<strong>Licence Term: </strong><?php print $field_trial_begins[0]['view'] . ' - ' . $field_trial_ends[0]['view']; ?> 
			</div>
	

		<h2>Response Instructions</h2>
		
		<div class="trial_response_inst field">
		  <?php print $field_trial_response_inst[0]['value']; ?>	
		</div>

    <?php if(!user_access('view field_trial_pricing', $user) && !user_access('view field_trial_access', $user)): ?>
 			<h2>Pricing and Trial Access</h2>
			<div class="trial_pricing field">
        <p>To view pricing info and a link to the free trial, please log into the e-HLbc site using the orange LOGIN button at the top of this page or <a href="/user" title="Link to login page">follow this link.</a></p>
			</div>
    <?php endif; ?>
     
		<?php if($field_trial_pricing[0]['value'] && user_access('view field_trial_pricing', $user)): ?> 
			<h2>Pricing</h2>
			<div class="trial_pricing field">
				<?php print $field_trial_pricing[0]['value']; ?>	
			</div>
		<?php endif; ?>

		<?php if($field_trial_access[0]['value'] && user_access('view field_trial_access', $user)): ?> 
			<h2>Free Trial Access</h2>
			<div class="trial_access field">
				<?php print $field_trial_access[0]['value']; ?>	
			</div>
		<?php endif; ?>


		<h2>License</h2>	
		
		<div class="license_name field">
			License Name: <?php print $tr_license_name; ?>
		</div>
		
		<?php if($field_trial_late_subs[0]['value']): ?> 
			<h2>Late Subscribers</h2>
   		<div class="trial_late field">
    		<?php print $field_trial_late_subs[0]['value']; ?>
   		</div>
		<?php endif; ?>
		
		
		<?php if($field_trial_other[0]['value']): ?> 
			<h2>Other / Miscellaneous</h2>
   		<div class="trial_other field">
    		<?php print $field_trial_other[0]['view']; ?>
   		</div>
		<?php endif; ?>
		
		<?php if($field_trial_staff[0]['view']): ?> 

			<h2>Questions</h2>
   		<div class="trial_staff field">
   			<p><?php print $variables['field_contact_first_name'] . ' ' . $variables['field_contact_last_name']; ?></p>
				<p><?php print $variables['field_contact_jobtitle']; ?></p>
				<p><strong>Phone:</strong> <?php print $variables['field_contact_phone']; ?></p>
				<p><strong>Email:</strong> <a href="mailto:<?php print $variables['user_email']; ?>"><?php print $variables['user_email']; ?></a></p>
    		<?php // print $field_trial_staff[0]['view']; ?>
   		</div>
		<?php endif; ?>
	    
	</div>
    <?php dcpr($node); ?>
</div>
