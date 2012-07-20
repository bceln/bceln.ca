// Default js file

/* Enable styleswitcher */
Drupal.behaviors.styleSwitcher = function(context) { $('#text_size').styleSwitcher('small-text','fontSize',365); }

/* Make admin menu draggable */
Drupal.behaviors.adminDrag = function(context) {
  var $block = $('#block-menu-menu-authenticated');
  
  // Hide the content area
  /*$block.find('.content').hide();*/
  // When you hover over the block show the content area
  $block.css('height', '30px');
  $block.find('h3').toggle(
  function(){
    $block.animate({
      right: '-5px',
      height: '230px'
    });
    //$block.find('.content').toggle();
  }, 
  function(){
    $block.animate({
      right: '-164px',
      height: '30px'
    });
    //$block.find('.content').toggle();
  } 
  );

  // Set up floating menu
  function moveFloatMenu() {
		var menuOffset = menuYloc.top + $(this).scrollTop() + "px";
		$block.animate({top:menuOffset},{duration:500,queue:false});
	}
	menuYloc = $block.offset();
	$(window).scroll(moveFloatMenu);
	moveFloatMenu();
}

/* Enable login show/hide */
Drupal.behaviors.loginShow = function(context) { 

  var $lblock = $('#hd #block-user-0');

    $('.login').click(function ( e ) {
    	      $lblock.slideToggle('200');
            return false;
    	    });
    
    $(document).keydown( function( e ) {
     if( e.which == 27) {  // escape, close box
       $lblock.slideToggle('200');
     }
    }); 		    
    
    $(document).click(function( e ){
    
    var $clicked = $(e.target);
      
      //if (! $clicked.parents().hasClass("block-user") && $clicked != $lblock) {
      if (! $clicked.parents().hasClass("block-user") && $clicked.attr('id') != 'block-user-0' ) {
      
        if($lblock.css('display') == 'block') {
          $lblock.slideToggle('200');
        }
      }
        
    });

}

Drupal.behaviors.resourceFilter = function(context) { 

  // If the filter has already been used we need to make sure it's visible.
  if ($(location).attr('search').search(new RegExp(/organization/i)) > 0) {
    $('.view-resources .view-filters').slideToggle('400');
  }

 // if $('#views-exposed-form-resources-page-1').length > 0 {
  
    $('<li />').addClass('btn').appendTo('ul.tabs');
    $('#views-exposed-form-resources-page-1 label').appendTo('li.btn');
  
    $('li.btn label').click(function( e ) {
      $('.view-resources .view-filters').slideToggle('400');  
    });

 // }
  
}

/**
 * Setting button labeles in exposed filters 
 */
Drupal.behaviors.exposedFilters = function(context) { 
  if($('#edit-submit-contacts').length > 0) {
    $('#edit-submit-contacts').val('Search');
  }
}

/**
 * Setting form elements on registration form
 */
Drupal.behaviors.registerForm = function(context) { 
  if($('#user-register').length > 0) {
    $('#user-register #edit-name-wrapper .description').append(
      '<br />Please enter a username in the format first initial-hypen-last name.<br />For example if your name is <em>John Smith</em>, your username should be <em>j-smith</em>.'
    );
  }
}


