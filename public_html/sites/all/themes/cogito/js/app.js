jQuery(document).ready(function ($, window, undefined) {
  
  /* DrUPAL HACK*/
  //$('.foundation-menu .menu').addClass('nav-bar');

  //Some foundation loading needs to happen after the document loads.
  //Only load forms on drupal front pages
  if ( $('body.html').length != 0 ){
    //$.fn.foundationCustomForms       ? $(document).foundationCustomForms() : null;
  }
  $.fn.foundationNavigation       ? $(document).foundationNavigation() : null;

  // UNCOMMENT THE LINE YOU WANT BELOW IF YOU WANT IE8 SUPPORT AND ARE USING .block-grids
  // $('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'both'});
  // $('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'both'});
  // $('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'both'});
  // $('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'both'});

});
