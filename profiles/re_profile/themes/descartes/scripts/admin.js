Drupal.behaviors.captureSwitch = function (context) {
	// Create a link in the admin menu to hide-show all other page content
	var $toggle = $('<li class="admin-menu-action off" id="capture-toggle"><a href="#" title="Toggle content for page capture">&diams;</a></li>').click(function() {
			$divs_to_turn_off = $('body').children('div').not('#admin-menu, #lightbox, #overlay');
			$divs_to_turn_off.toggle();
			$(this).toggleClass('off');
		});
	
	// Create the link in the admin menu
	$('#admin-menu > ul').append($toggle);
} /* Drupal.behaviors.captureSwitch() */


/**
 * This function just enables toggling of the node-debug divs that are displayed
 * to debug node data when the devel module is not available.
 *
 * @see dcpr() function in the reyebrow_descartes theme's template.php file.
 */
Drupal.behaviors.dcpr = function(context) {
	var $nodeDataToggleLinks = $('.reyebrow-descartes-dcpr a'); // Look for the toggle link...
	$nodeDataToggleLinks.click(function(){ // Set up the onclick function...
		$link = $(this);
		$togglePre = $(this).parents('.reyebrow-descartes-dcpr').find('pre').toggle(function() { // When the link is clicked, toggle the <pre> element...
			$link.text($(this).is(':visible') ? '[-]' : '[+]'); // Toggle the link text too!
		});
		return false; // Don't follow the link!
	});
} /* Drupal.behaviors.dcpr() */