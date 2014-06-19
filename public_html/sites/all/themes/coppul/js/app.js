/**
 * @file
 * This file provides whatever javascript logic and functions are necessary for
 * the Foundation Orbit plugin in the re_contextlibraries module.
 *
 * Developed by the Zurb Foundation people.
 *
 * @see http://foundation.zurb.com/docs/orbit.php
 * @see http://www.zurb.com/playground/orbit-jquery-image-slider
 */
(function ($) {

  Drupal.behaviors.init = {
      attach: function(context) {
            // External links, open in a new window
            $('a[rel="external"]').attr('target', '_blank');
            /* DrUPAL HACK*/
            $('nav .menu').addClass('nav-bar');
            $('nav .menu .d7flyout').addClass('flyout');

            $.fn.foundationNavigation  ? $(document).foundationNavigation() : null;
            $.fn.foundationTabs        ? $(document).foundationTabs({callback : $.foundation.customForms.appendCustomMarkup}) : null;
            $.fn.foundationButtons     ? $(document).foundationButtons() : null;
            $.fn.foundationTooltips    ? $(document).foundationTooltips() : null;
            $('print-button').click(function(event){
              event.preventDefault();
              window.print();
            });
            $('.messages .close').click(function(event){
              event.preventDefault();
              $(this).parent().hide();
            });
      }
  };

  Drupal.behaviors.orbit = {
    attach: function(context) {
      $('#slideshow').orbit({
        animation: 'horizontal-slide', // fade, horizontal-slide, vertical-slide, horizontal-push
        animationSpeed: 800, // how fast animtions are
        timer: true, // true or false to have the timer
        advanceSpeed: 800000, // if timer is enabled, time between transitions
        pauseOnHover: true, // if you hover pauses the slider
        startClockOnMouseOut: true, // if clock should start on MouseOut
        startClockOnMouseOutAfter: 1000, // how long after MouseOut should the timer start again
        directionalNav: false, // manual advancing directional navs
        directionalNavRightText: Drupal.t('Next'),
        directionalNavLeftText: Drupal.t('Previous'),
        captions: false, // do you want captions?
        captionAnimation: 'fade', // fade, slideOpen, none
        captionAnimationSpeed: 800, // if so how quickly should they animate in
        bullets: true, // true or false to activate the bullet navigation
        bulletThumbs: false, // thumbnails for the bullets
        bulletThumbLocation: '', // location from this file where thumbs will be
        afterSlideChange: function(){}, // empty function
        fluid: '3x2' // or set a aspect ratio for content slides (ex: '4x3')
      });
    }
  }; /* Drupal.behaviors.orbit */

  // Fix the oembed styling for main body content
  Drupal.behaviors.flexit = {
    attach: function(context) {
      $('div.entry-content div.oembed').removeClass('oembed').addClass('flex-video');
      // Also handle video filter embeds, these were grandfathered in because I didn't want to update all the old videos.
      if($('.entry-content iframe').parent().attr('class') != 'oembed-content') {
        $('.entry-content iframe').wrap('<div class="flex-video" />');
      }
    }
  }

  // Loads random image from a collection of a few on the homepage
  Drupal.behaviors.randomImage = {
    attach: function(context) {
      var random = Math.floor(Math.random() * $('.front .field-name-body img').length);
      $('.front .field-name-body img').hide().eq(random).show();
    }
  }

  // Add an image caption if there is an alt attribute
  Drupal.behaviors.imageCaption = {
    attach: function(context) {
      $("#content .entry-content img").each(function(index) {
        if($(this).attr('alt') != '') {
        	var alt = this.alt;
        	var c_attribute = $(this).attr('class');
          $(this).wrap('<div class="' + $(this).attr('class') + '" />').after($('<div>', {text: alt}).addClass('caption'));
          $(this).removeClass(c_attribute);
        }
      });
    }
  }

})(jQuery);
