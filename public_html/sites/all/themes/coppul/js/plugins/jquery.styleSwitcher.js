/**
 * This function creates a cookie with the specified name, value and expiry date.
 *
 * @param string name The name of the cookie to be created
 * @param string value The value for the cookie
 * @param int days The lifetime, in days, of the cookie
 * @see http://www.quirksmode.org/js/cookies.html
 * @author Peter-Paul Koch
 */
function createCookie(name, value, days) {
	if(days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = '; expires='+ date.toGMTString();
	}
	else var expires = '';
	document.cookie = name +'='+ value + expires +'; path=/';
} /* function createCookie() */


/**
 * This function reads the value of a specified cookie.
 *
 * @param string name The name of the cookie to be read
 * @return string|null The value of the cookie or null
 * @see http://www.quirksmode.org/js/cookies.html
 * @author Peter-Paul Koch
 */
function readCookie(name) {
	var nameEQ = name + '=';
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while(c.charAt(0)==' ') {
			c = c.substring(1,c.length);
		}
		if(c.indexOf(nameEQ) == 0) {
			return c.substring(nameEQ.length,c.length);
		}
	}
	return null;
} /* function readCookie() */


/**
 * This function destroys a cookie by creating it with an expiry date one day in the past.
 *
 * @param string name The name of the cookie to be destroyed
 * @see function createCookie();
 * @see http://www.quirksmode.org/js/cookies.html
 * @author Peter-Paul Koch
 */
function eraseCookie(name) {
	createCookie(name,'',-1);
} /* function createCookie() */


/**
 * Jquery style switcher
 *
 * This function is the behaviour layer of a style-switcher. It assumes the element to which it is applied
 * contains several links (ALL of which are used for the style switcher). When one of these links is clicked,
 * the style function assigns a class to the body element that's identical to that element's id attribute. At
 * the same time, it creates a cookie containing the same value. This cookie is checked every time the function
 * is invoked (in other words, at every page load and at every click of one of the links).
 * 
 * Note that, since this function changes a class on the body, it can effectively be used to switch the style
 * of anything on the page--not just font sizes. That being said, if the use case involves completely altering
 * the layout and design treatment of a page, it might be better to use a style switcher that calls a completely
 * separate stylesheet.
 *
 * Example use:
 *
 *	NON-DRUPAL SCRIPT:
 *	
 *	$(function(){ $('#utilities').styleSwitcher('small-text','fontSize',365) });
 *
 *	DRUPAL SCRIPT:
 *
 *	Drupal.behaviors.styleSwitcher = function(context) { $('#utilities').styleSwitcher('small-text','fontSize',365); }
 *
 * 	HTML:
 *		
 *		<div id="utilities">
 *			<a href="#" id="small-fonts">Small</a> |
 *			<a href="#" id="medium-fonts">Medium</a> |
 *			<a href="#" id="large-fonts">Large</a>
 *		</div>
 * 
 * @param string defaultBodyClass Default class for the body element--should be one of the classes that can be added by the styleswitcher
 * @param string cookieName The name of the cookie to be set
 * @param int lifetime The lifetime, in days, of the cookie to be created.
 * @see function createCookie()
 * @see function eraseCookie()
 * @see function readCookie()
 */
jQuery.fn.styleSwitcher = function(defaultBodyClass, cookieName, cookieLifetime) {
	return this.each(function(){
		var $bodyClassList = '', $body = $('body'), currentBodyClass = readCookie(cookieName), $switcherLinks = $(this).find('a'); // Initialize and populate some needed variables...
		$switcherLinks.each(function(){ // Loop through the links in the element...
			$bodyClassList += $(this).attr('id') + ' '; // And build a list of their id attributes; we'll add these to the cookie and the body element when these links are clicked...
		});
		$(this).show();	// Unhide the current element...
		if(!currentBodyClass) { // If the cookie did not exist or was empty...
			currentBodyClass = defaultBodyClass; // The current will be the default...
			createCookie(cookieName, currentBodyClass, cookieLifetime); // Create the cookie...
		} else if(!$body.hasClass(currentBodyClass)) { // On the other hand, if the cookie exists, but the body doesn't have the appropriate class...
			$body.addClass(currentBodyClass); // Add that class...
		}
		$switcherLinks.click(function(){ // Add event listeners...
			var $selectedBodyClass = $(this).attr('id'); // Get the class to add to the body from the id attribute of the clicked element...
			if(!$body.hasClass($selectedBodyClass)) { // If the body does not already have this class...
				eraseCookie(cookieName); // Erase the existing cookie...
				createCookie(cookieName, $selectedBodyClass, cookieLifetime); // Create a new one...
				$body.removeClass($bodyClassList); // Remove any relevant classes the body already has...
				$body.addClass($selectedBodyClass); // Add the new one...
			}
			return false; // Don't follow the link--even if we haven't done anything!
		});
	});
}; /* jQuery.fn.styleSwitcher */


// Uncomment or add to page head to enable styleswitcher:
// Drupal.behaviors.styleSwitcher = function(context) { $('#utilities').styleSwitcher('small-text','fontSize',365); }