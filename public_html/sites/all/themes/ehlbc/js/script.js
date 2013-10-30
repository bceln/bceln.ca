// Default js file
(function ($) {
  

  /* Enable styleswitcher */
  Drupal.behaviors.styleSwitcher = {
    attach: function(context) {
      $('#text_size').styleSwitcher('small-text', 'fontSize', 365);
    }
  };

  /* Make admin menu draggable */
  Drupal.behaviors.adminDrag = {
    attach: function(context) {
      var block = $('#block-menu-menu-authenticated');
      if(block.length > 0) {
        // Hide the content area
        // When you hover over the block show the content area
        block.css('height', '50px');
        
        $('#block-menu-menu-authenticated h2').click(function(e){
          if (block.height() <= 50 )
          {
            block.animate({
              right: '-5px',
              height: '300px'
            });
          }
          else {
            block.animate({
              right: '-162px',
              height: '50px'
            });
          }
        });
          
        /*
        $('h2', block).toggle(
          function() {
            alert('t1');
            
          },
          function() {
            alert('t2');
            block.animate({
              right: '-164px',
              height: '30px'
            });
          }
        );*/

        // Set up floating menu
        /*This needs to be uncommented and made to work. It stopped working after installing
         * the update jquery module */
        function moveFloatMenu() {
          var menuOffset = menuYloc.top + $(this).scrollTop() + "px";
          block.animate({top: menuOffset}, {duration: 500, queue: false});
        }
        menuYloc = block.offset();
        $(window).scroll(moveFloatMenu);
        moveFloatMenu();
      }
    }
  };

  /* Enable login show/hide */
  Drupal.behaviors.loginShow = {
    attach: function (context, settings) {
      var $lblock = $('#block-user-login');

      $('.login').click(function() {
        $lblock.slideToggle('200');
            $('#edit-name').focus();
            console.log('focus set');
        return false;
      });

      $(document).keydown(function(e) {
        if (e.which === 27) {  // escape, close box
          $lblock.slideToggle('200');
        }
      });

      $(document).click(function(e) {
        var $clicked = $(e.target);

        if (!$clicked.parents().hasClass("block-user") && $clicked.attr('id') !== 'block-user-login' ) {

          if ($lblock.css('display') === 'block') {
            $lblock.slideToggle('200');
          }
        }
      });
    }
  };

  Drupal.behaviors.resourceFilter = {
    attach: function(context) {

      // If the filter has already been used we need to make sure it's visible.
      if ($(location).attr('search').search(new RegExp(/organization/i)) == -1) {
        $('.view-resources .view-filters').hide();
      }

      $('#edit-organization-wrapper label').appendTo('.drupal_tabs').addClass('expand-btn');

      $('.expand-btn').click(function() {
        $('.view-resources .view-filters').slideToggle('400');
      });
    }
  };

  /**
   * Setting button labeles in exposed filters 
   */
  Drupal.behaviors.exposedFilters = {
    attach: function(context) {
      if ($('#edit-submit-contacts').length > 0) {
        $('#edit-submit-contacts').val('Search');
      }
    }
  };

  /**
   * Setting form elements on registration form
   */
  Drupal.behaviors.registerForm = {
    attach: function(context) {
      if ($('#user-register').length > 0) {
        $('#user-register #edit-name-wrapper .description').append(
                '<br />Please enter a username in the format first initial-hypen-last name.<br />For example if your name is <em>John Smith</em>, your username should be <em>j-smith</em>.'
                );
      }
    }
  };
})(jQuery);

