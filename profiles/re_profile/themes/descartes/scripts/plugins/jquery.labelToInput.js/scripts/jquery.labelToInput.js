/**
 * labelToInput jQuery plugin
 * 
 * @name          inputValue
 * @descripton    Applied to an input element, this function takes the text value
 *                of the associated label element, hides that label, modifies the
 *                text if needed, and passes that text to jquery.inputValue.js                                   
 * @version       1.01
 * @requires      jQuery 1.2.6 +, jquery.inputValue.js
 * @author        Christopher Torgalson manager@bedlamhotel.com
 * @license       GPL 3
 * @param         string p Regex pattern for characters to replace in label; useful
 *								for removing colons etc. Default value restricts defaults to alpha-
 *								numeric characters and spaces. Might need rejiggering with cjk
 *								languages etc!
 * @see           jquery.inputValue.js
 *
 * Example usage:
 *
 * $('#edit-search-theme-form-1').labelToInput(/:/g);
 *
 */
(function($){
  $.fn.labelToInput = function(p) {
    p = (p ? p : /[^A-Za-z0-9\s]/); // If we don't receive a regex argument, just limit the label to alphanumeric and space characters...
    return this.each(function(){
      $e = $(this); // Cache the current item...
      $l = $('label[for='+ $e.attr('id') +']').hide(); // Get the label associated with this input, and hide it...
      $t = $l.text().replace(p, ''); // Figure out the exact text we want as the default value for the input...
      $e.inputValue($t); // Pass that value to the inputValue function...
    });
  }
})(jQuery);