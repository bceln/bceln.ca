/* Make admin menu draggable */
Drupal.behaviors.adminDrag = function(context) {
  var $block = $('#block-menu-menu-authenticated');
  
  // Hide the content area
  /*$block.find('.content').hide();*/
  // When you hover over the block show the content area
  $block.css('height', '30px');
  $block.find('h2').toggle(
  function(){
    $block.animate({
      right: '-5px',
      height: '280px'
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