<?php

// make sure to use backslash to escape "?" in referring URL!
if ( preg_match('|^http://gateway.tx.ovid.com/atoz/az/[A-Za-z0-9_-]*\?idtok=1215215486|', $_SERVER['HTTP_REFERER']) ) {

  // link to Ovid fulltext
  if ( preg_match("|^http://gateway.ovid.com/ovidweb.cgi|", $_GET['url']) ) {
    $jumpstart = $_GET['url'];
    foreach ($_GET as $key => $val) {
      $jumpstart .= "&$key=$val";
    }
    $jumpstart .= "&ID=prhc0001&PASSWORD=health";
    header("Location: $jumpstart");
  }

  // link to Ebsco fulltext
  elseif ( preg_match("|^http://search.ebscohost.com|", $_GET['url']) 
    || preg_match("|^http://search.epnet.com|", $_GET['url']) ) {
      $arr = explode("?url=", $_SERVER['REQUEST_URI'], 2);
      header("Location: " . $arr[1] . "&user=ns016225&password=leader");
  }

  // other links
  else {
    $url = $_GET['url'];
    foreach ($_GET as $key => $val) {
      if ($key != 'url') $url .= "&$key=$val";
    }
    header("Location: " . $url);
  }

} else {
  die("You are not authorized to view this page.");
}

?>
