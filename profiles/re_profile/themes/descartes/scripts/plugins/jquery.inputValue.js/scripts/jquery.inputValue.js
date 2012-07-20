/**
 * inputValue jQuery plugin
 * 
 * @name          inputValue
 * @descripton    intelligently sets, clears and resets the default value attribute
 *								of an input element                                   
 * @version       1.0
 * @requires      jQuery 1.2.6 +
 * @author        Christopher Torgalson manager@bedlamhotel.com
 * @license       GPL 3
 * @param         string d Default input field value
 *
 * Example usage:
 *
 * $('input[id^=edit-search-theme-form-1]').inputValue('Search this site');
 *
 */
(function($){
  $.fn.inputValue = function(d) {
    return this.each(function(){
    	// First, work with the default value:
    	d = (d ? d : $(this)[0].defaultValue); // Use the default form value if no argument is passed to the function...
      if(d.length < 1) { return; } // Halt execution if there is no default value of any kind...
      // Set up needed vars:
      var $i = $(this), // Store the current input element...
          $f = $i.parents('form'); // Store the parent form of that element...
      // Work on the input element:
      $i.val(d)
        .focus(function(){ // Set up the focus handler...
          if($(this).val() == d) { $(this).val(''); } // Unset field if it contains the default value...
        })
        .blur(function(){ // Set up the blur handler...
          if($(this).val().length < 1) { $(this).val(d); } // If the field is empty, insert the default value...
        });
      // Work on the form element:
      $f.submit(function(){ // Set up the submit handler on the form...
        if($i.val() == d) { $i.val(''); } // Unset field if it contains the default value...
      });
    });
  }
})(jQuery);