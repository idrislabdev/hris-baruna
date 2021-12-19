<?php
/***********************
 thumbnail creator or image resizer v.0.4
 author : renxe
 
 this version only support jpeg, gif anda png
 I will try to expand more image support in further development
 
 RETURN :
 TRUE, if creation succeeded
 FALSE, if creation failed
 
 PARAMETERS :
 $fileSource : full path of input file
 $fileDestination : output file. 
	commonly : "z__thumb_".$fileSource
 $thumbMaxSize : the size of generated thumbnail. this can be its width or height or mixed depends on $fitSizeMode parameter
 $fitSizeMode : whether the thumbnail will be reduced based on its width or height or auto switching
	param : "FIT_WIDTH" : fit size based on width. this will be the default if you skipped this param
			"FIT_HEIGHT" : fit size based on height
			"FIT_AUTO_SWITCH" : fit size looking for which side is bigger
************************/
function createThumbnail($fileSource, $fileDestination, $thumbMaxSize = 150, $fitSizeMode = "FIT_WIDTH")
{
	// Get new sizes
	list($width, $height) = getimagesize($fileSource);
	
	if($fitSizeMode == "FIT_WIDTH")
	{
		$resizeFactor = $thumbMaxSize / $width;
	}
	else if($fitSizeMode == "FIT_HEIGHT")
	{
		$resizeFactor = $thumbMaxSize / $height;
	}
	else
	{
		if($width > $height)
		{
			$resizeFactor = $thumbMaxSize / $width;
		}
		else if($height > $width)
		{
			$resizeFactor = $thumbMaxSize / $height;
		}
	}
	
	$newWidth = $width * $resizeFactor;
	$newHeight = $height * $resizeFactor;
	
	// Create canvas
	$thumb = imagecreatetruecolor($newWidth, $newHeight);
	
	// Get image extension
	$imageExtension = strtolower(getImageExtension($fileSource));
	
	// Load the image, resize and then output it into the proper image type
	if($imageExtension == "jpg" || $imageExtension == "jpeg")
	{
		$source = @imagecreatefromjpeg($fileSource);
		@imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		$output = imagejpeg($thumb, $fileDestination);
	}
	else if($imageExtension == "gif")
	{
		$source = @imagecreatefromgif($fileSource);
		@imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		$output = imagegif($thumb, $fileDestination);
	}
	else if($imageExtension == "png")
	{
		$source = @imagecreatefrompng($fileSource);
		@imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		$output = imagepng($thumb, $fileDestination);
	}
	else
		$output = false;	
	
	return $output;
}

// an helper function to get the image extension
/*
1 : IMAGETYPE_GIF 
2 : IMAGETYPE_JPEG 
3 : IMAGETYPE_PNG 
*/
function getImageExtension($varSource)
{
	$imageData = getimagesize($varSource);
	
	if($imageData[2] == 1)
		return "gif";	
	else if($imageData[2] == 2)
		return "jpeg";
	else if($imageData[2] == 3)
		return "png";
	else
	{
		$temp = explode(".", $varSource);
		return end($temp);
	}
}

// an helper function to strip the image extension
function stripImageExtension($varSource)
{
	$temp = str_replace(".".getImageExtension($varSource), $varSource);
	return $temp;
}


function getImageWidth($varSource, $max=0, $tolerance=20)
{
	list($width, $height) = getimagesize($varSource);

	if ($max == 0)
		$res = $width;
	else
	{
		if($width > $max)
			$res = $max;
		else 
			$res = $width;
	}
	
	return $res + $tolerance;
}

function getImageHeight($varSource, $max=0, $tolerance=20)
{
	list($width, $height) = getimagesize($varSource);
	
	if ($max == 0)
		$res = $height;
	else
	{
		if($height > $max)
			$res = $max;
		else 
			$res = $height;
	}
	
	return $res + $tolerance;
}
?>
