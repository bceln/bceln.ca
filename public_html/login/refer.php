<?php

// referring URLs - old method - MP 12/17/2010

// valid referring URLs list - new metod - MP MP 12/17/2010
$refurls = array(
 'http://ehlbc.ca/databases/remoteaccess',
);

// standard components of all Ovid jumpstart URLs for e-HLbc
$ovid_url_base = 'http://ovidsp.ovid.com/ovidweb.cgi?T=JS';
$ovid_login = '&ID=pabc999&PASSWORD=shotwell';

// set jumpstart URL to include which database to login to, if any
if ( preg_match('/^[A-Za-z0-9]+$/', $_GET['db']) ) {
  $db = $_GET['db'];
  $ovid_url = $ovid_url_base . '&MODE=ovid&NEWS=n&PAGE=main&D=' . $db . $ovid_login;
} else {
  $ovid_url = $ovid_url_base . '&PAGE=main' . $ovid_login;
}

// check if coming from the permitted referring URL,
// then pass jumpstart URL (as constructed above) to server
// echo $_SERVER['HTTP_REFERER']."<br>";
// echo strlen($_SERVER['HTTP_REFERER'])."<br>";
// exit;

foreach ($refurls as $ru) {
 //echo "Checking: ".$ru."<br>";
 if (substr($_SERVER['HTTP_REFERER'], 0, strlen($ru)) == $ru) {
 // note: comment out line below when debugging
  header("Location: $ovid_url");
 }
}

die("You are not authorized to view this page.");

// This old code does NOT work correctly! - MP 12/17/2010
// if ( preg_match("|^$refurl1|", $_SERVER['HTTP_REFERER']) || preg_match("|^$refurl2|", $_SERVER['HTTP_REFERER']) ) {
// header("Location: $ovid_url");
// } else {
// die("You are not authorized to view this page.");
// }

?>
