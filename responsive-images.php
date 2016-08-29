<?php

// Valid constant names
define("SCREEN_XS", "480");
define("SCREEN_SM", "768");
define("SCREEN_MD", "1024");
define("SCREEN_LG", "1400");

define("UPLOAD_DIR","Upload_2000px");

function compareMediaQueries($y) {
	$y = str_replace("px","",$y);


	if ($y > SCREEN_LG):
		return "(min-width: ". SCREEN_LG ."px )";

	elseif ($y > SCREEN_MD):
		return "(min-width: ". SCREEN_MD ."px )";

	elseif ($y > SCREEN_SM):
		return "(min-width: ". SCREEN_SM ."px )";

	else: 
		return null;
	endif;
}

function setMediaQueriesBreakpoints($y,$all_sizes) {
	$y = str_replace("px","",$y);

	$showpoints ="";

	if ($y > SCREEN_LG) {
		$showpoints = "show-lg";
	} elseif ($y > SCREEN_MD) {
		$showpoints = "show-md";
		if ($y == end($all_sizes)) {
			$showpoints .= " show-lg";
		}
	} elseif ($y > SCREEN_SM) {
		$showpoints = "show-sm";
		if ($y == end($all_sizes)) {
			$showpoints .= " show-md show-lg";
		}
	} else {
		$showpoints = "show-xs";
	}

 	return $showpoints;
}

function createPictureSources($originalURL, $originalSizes) {
	/* takes an unaltered URL, and swaps out the image's folder (against the UPLOAD_DIR constant), for each one in the OriginalSizes array. */
	/* The developer should match the supplied originalSizes to the sizes defined as constants */
	$sizes = explode(", ", $originalSizes);
	$arrlength=count($sizes);
	$srcset = array();

	for($x=0; $x<$arrlength; $x++) {
		$srcset[] = "<source media='". compareMediaQueries($sizes[$x]) ."' srcset='". str_replace(UPLOAD_DIR, $sizes[$x]."px", $originalURL ) ."'>";
	}

	$srcset = implode(" ", $srcset);

	return $srcset;
}


function createBackgroundSources($originalURL, $originalSizes) {
	/* takes an unaltered URL, and swaps out the image's folder (against the UPLOAD_DIR constant), for each one in the OriginalSizes array. */
	/* The developer should match the supplied originalSizes to the sizes defined as constants */
	/* This function inserts a set of spans (per the MQ constants) into HTML, with an updated image URL set as the background-image */

	$sizes = explode(", ", $originalSizes);
	sort($sizes,SORT_NUMERIC);

	$arrlength=count($sizes);
	$srcset = array();
	
	for($x=0; $x<$arrlength; $x++) {
		$srcset[] = "<span class='responsive-background ". setMediaQueriesBreakpoints($sizes[$x],$sizes) ."' style='background-image: url(". str_replace(UPLOAD_DIR, $sizes[$x]."px", $originalURL ) .")'></span>";
	}

	$srcset = implode(" ", $srcset);

	return $srcset;
}




function createPictureSourcesSVG($originalURL, $originalSize, $organiseFormat) {
	$sizes = explode(", ", $originalSize);
	$arrlength=count($sizes);
	$srcset = array();

	for($x=0; $x<$arrlength; $x++) {
		$srcset[] = "<source media='". compareMediaQueries($sizes[$x]) ."' srcset='". str_replace(".png",".".$organiseFormat, $originalURL ) ."'>";
	}

	$srcset = implode(" ", $srcset);

	return $srcset;
}

function createImageSrc($originalURL, $originalSizes, $classes = "", $alt = "") {
	/* Only the img tag receives CSS and Alt attributes, as the browser only looks for them as part of the Img tag */

	$sizes = explode(", ", $originalSizes);
	$arrlength=count($sizes);
	$srcset = array();

	for($x=0; $x<$arrlength;$x++) {
		$srcset[] = str_replace("Upload_2000px",$sizes[$x]."px", $originalURL );
	}

	$srcset = implode(", ", $srcset);

	return "<img src=". $srcset ." class='". $classes ."' alt='". $alt ."'>";
}

