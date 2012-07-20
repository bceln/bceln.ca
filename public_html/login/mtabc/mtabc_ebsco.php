<?php

// referring URLs
$refurl1 = 'http://www.massagetherapy.bc.ca/members';
$refurl2 = 'http://massagetherapy.bc.ca/members';

// Ebsco URL
$ebsco_url = 'http://search.ebscohost.com/login.aspx?authtype=url';

// check if coming from the permitted referring URL,
// then pass jumpstart URL (as constructed above) to server
if ( preg_match("|^$refurl1|", $_SERVER['HTTP_REFERER']) || preg_match("|^$refurl2|", $_SERVER['HTTP_REFERER']) ) {
  header("Location: $ebsco_url");
} else {
  die("You are not authorized to view this page.");
}

?>
