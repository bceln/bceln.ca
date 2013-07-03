<?php
	$themedir = DRUPAL_ROOT . '/' . $directory;
  // page.tpl.php needs $page
  $page = $variables;

	// We're not really sure where the TPL files are so let's see 
	// how agnostic we can be about them.
	function tpl_finder($dir, $file){

	  $locs = Array(
	    $dir . '/' . $file,
	    $dir . '/templates/' . $file,
	    $dir . '/../cogito/' . $file,
	    $dir . '/../cogito/templates/' . $file,
	  );
	  foreach ($locs as $loc){
	    if (file_exists( $loc )){
	      return $loc;
	    }
	  }
	}

	?>

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
	  <head>
	    <title><?php print $head_title; ?></title>
	    <?php print $head; ?>
	    <?php print $styles; ?>
	    <?php print $scripts; ?>
	  </head>
	  <body class="<?php print $classes; ?>">

	      <?php 
	      //Cogito uses a special header;
	      ob_start();
	      include(tpl_finder($themedir, 'header.tpl.php'));
	      $cogito_header = ob_get_clean();

	      // Now just include the page.tpl.php int he usual way
	      include(tpl_finder($themedir, 'page.tpl.php'));
	      ?>

	  </body>
	</html>