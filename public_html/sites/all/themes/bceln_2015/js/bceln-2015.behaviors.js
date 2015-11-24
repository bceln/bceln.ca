(function($,sr){

  // debouncing function from John Hann
  // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
  var debounce = function (func, threshold, execAsap) {
      var timeout;

      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null;
          };

          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 100);
      };
  }
  // smartresize 
  jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');

(function ($) {

  /**
   * The recommended way for producing HTML markup through JavaScript is to write
   * theming functions. These are similiar to the theming functions that you might
   * know from 'phptemplate' (the default PHP templating engine used by most
   * Drupal themes including Omega). JavaScript theme functions accept arguments
   * and can be overriden by sub-themes.
   *
   * In most cases, there is no good reason to NOT wrap your markup producing
   * JavaScript in a theme function.
   */
  Drupal.theme.prototype.bceln2015ExampleButton = function (path, title) {
    // Create an anchor element with jQuery.
    return $('<a href="' + path + '" title="' + title + '">' + title + '</a>');
  };

  // Drupal.theme.prototype.blockHeightAdjsut = function (firstBlockId, secondBlockId, thirdBlockId) {
  //   // Sets the hight of all three blocks to be the same
  // 		console.log('here');
  // 		var h1,h2,h3;
  // 		hightOne = $(firstBlockId + ' .block__content > div');
  // 		heightTwo = $(secondBlockId + ' .block__content > div');
  // 		heightThree = $(thirdBlockId + ' .block__content > div');
  // 		if(hightOne >= heightTwo && hightOne >= heightThree){// height 1 bigger than the other 2
  // 				$(secondBlockId + ' .block__content > div').height(hightOne);
  // 				$(thirdBlockId + ' .block__content > div').height(hightOne);
  // 			}
  // 			else if (hightTwo >= heightOne && hightTwo >= heightThree){//Height 2 bigger than the other 2
  // 				$(firstBlockId + ' .block__content > div').height(hightTwo);
  // 				$(thirdBlockId + ' .block__content > div').height(hightTwo);
  // 			}
  // 			else {//Height 3 bigger than the other 2
  // 				$(firstBlockId + ' .block__content > div').height(hightThree);
  // 				$(thirdBlockId + ' .block__content > div').height(hightThree);
  // 			}
  // };

  /**
   * Behaviors are Drupal's way of applying JavaScript to a page. In short, the
   * advantage of Behaviors over a simple 'document.ready()' lies in how it
   * interacts with content loaded through Ajax. Opposed to the
   * 'document.ready()' event which is only fired once when the page is
   * initially loaded, behaviors get re-executed whenever something is added to
   * the page through Ajax.
   *
   * You can attach as many behaviors as you wish. In fact, instead of overloading
   * a single behavior with multiple, completely unrelated tasks you should create
   * a separate behavior for every separate task.
   *
   * In most cases, there is no good reason to NOT wrap your JavaScript code in a
   * behavior.
   *
   * @param context
   *   The context for which the behavior is being executed. This is either the
   *   full page or a piece of HTML that was just added through Ajax.
   * @param settings
   *   An array of settings (added through drupal_add_js()). Instead of accessing
   *   Drupal.settings directly you should use this because of potential
   *   modifications made by the Ajax callback that also produced 'context'.
   */
  Drupal.behaviors.bceln2015ExampleBehavior = {
    attach: function (context, settings) {
      // By using the 'context' variable we make sure that our code only runs on
      // the relevant HTML. Furthermore, by using jQuery.once() we make sure that
      // we don't run the same piece of code for an HTML snippet that we already
      // processed previously. By using .once('foo') all processed elements will
      // get tagged with a 'foo-processed' class, causing all future invocations
      // of this behavior to ignore them.
      $('.some-selector', context).once('foo', function () {
        // Now, we are invoking the previously declared theme function using two
        // settings as arguments.
        var $anchor = Drupal.theme('bceln2015ExampleButton', settings.myExampleLinkPath, settings.myExampleLinkTitle);

        // The anchor is then appended to the current element.
        $anchor.appendTo(this);
      });
    }
  };
  Drupal.behaviors.blockHeightAdjust= {
    attach: function (context, settings) {
			//kepping home page blocks all at the same height
			$(window).smartresize(function(){
				var h1,h2,h3;
				hightOne = $('#block-views-trials-offers-renewals .block__content > div').height();
				heightTwo = $('#block-views-blog-latest-news .block__content > div').height();
				heightThree = $('#block-views-blog-connect-newsletter-block .block__content > div').height(); 
				
				if(hightOne > heightTwo) {
					$('#block-views-blog-latest-news .block__content > div').height(heightOne);
					} 
					else{
						$('#block-views-trials-offers-renewals .block__content > div').height(heightTwo);
				}
				
				if(hightOne > heightThree) {
						$('#block-views-blog-connect-newsletter-block .block__content > div').height(hightOne);
					} 
					else{
						$('#block-views-trials-offers-renewals .block__content > div').height(heightThree);
				}
				if(heightTwo > heightThree) {
						 $('#block-views-blog-connect-newsletter-block .block__content > div').height(heightTwo);
					}
					else{
						$('#block-views-blog-latest-news .block__content > div').height(heightThree);
				}
			});
    }
  };

})(jQuery);
