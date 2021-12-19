<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: default.func.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle date parameters transactions
***************************************************************************************************** */

include_once("../WEB-INF/lib/kses/kses.php");
include_once("../WEB-INF/functions/encrypt.func.php");

$allowedTagAttributes = array('style' => array(),
						   	  'class' => array());

$allowed = array(
                 'a' => array('href' => array(), 
				 			  'title' => array()),
                 'br' => array(),
				 'p' => array(),
				 'b' => array(),
				 'strong' => array(),
				 'u' => array(),
				 'em' => array(),
				 'ul' => $allowedTagAttributes,
				 'ol' => $allowedTagAttributes,
				 'li' => $allowedTagAttributes,
				 'table' => array('border' => array(),
				 				  'width' => array(),
								  'height' => array(),
								  'style' => array(),
								  'class' => array()),
				 'tr' => array(),
				 'td' => $allowedTagAttributes,
				 'div' => $allowedTagAttributes,
				 'img' => array('src' => array(),
				 				'title' => array(),
								'alt' => array())
				);

$allowedForUser = array(
                 'a' => array('href' => array(), 'title' => array()),
                 'br' => array(),
				 'p' => array(),
				 'b' => array(),
				 'strong' => array(),
				 'u' => array(),
				 'em' => array()
				);

$allowedStrict = array('b' => array(), 'strong' => array());
				
	function formatTextToDb($varText)
	{
		$varText = ltrim($varText);
		
		/*$varText = str_replace("'", "&quote", $varText);
		$varText = str_replace("\\", "&backslash", $varText);*/
		
		$varText = str_replace("\\", "", $varText);
		$varText = str_replace("'", "''", $varText);
		
		return $varText;
	}
	
	/* fungsi untuk memformat tampilan dari database ke html */
	function formatTextToPage($varText)
	{
		$varText = str_replace("&amp;", "&", $varText);
		$varText = str_replace("&quote", "'", $varText);
		$varText = str_replace("&backslash", "\\", $varText);
		
		//$varText = str_replace("\n", "<br />", $varText);
		
		return $varText;
	}
	
	function dropAllHtml($varText)
	{
		$varResult = $varText;
		
		if (get_magic_quotes_gpc())
		  $varResult = stripslashes($varText);
		
		return kses($varResult, $allowedForUser);
	}

	function httpFilterGet($varname,$inputSource = 'admin')
	{
		global $allowed;
		global $allowedForUser;
		
		$varResult = formatTextToDb($_GET[$varname]);
		
		if (get_magic_quotes_gpc())
		  $varResult = stripslashes($varResult);
		
		if($inputSource == 'admin')
			//return kses($varResult, $allowed, false);
			return $varResult;
		else if($inputSource == 'user')
			return kses($varResult, $allowedForUser);
	}
	
	function httpEncryptGet($varname,$inputSource = 'admin')
	{
		global $allowed;
		global $allowedForUser;
		
		$varResult = formatTextToDb($_GET[$varname]);
		
		if (get_magic_quotes_gpc())
		  $varResult = stripslashes($varResult);
		
		if($inputSource == 'admin')
			//return kses($varResult, $allowed, false);
			return mdecrypt($varResult);
		else if($inputSource == 'user')
			return kses($varResult, $allowedForUser);
	}	
	
	function httpFilterPost($varname,$inputSource = 'admin')
	{
		global $allowed;
		global $allowedForUser;
		
		$varResult = formatTextToDb($_POST[$varname]);
		
		if (get_magic_quotes_gpc())
		  $varResult = stripslashes($varResult);
		
		if($inputSource == 'admin')
		{	//return kses($varResult, $allowed, false);
			$varResult = str_replace("\'", "''", $varResult);
			return $varResult;
		}
		else if($inputSource == 'user')
		{
			$varResult = str_replace("\'", "''", $varResult);			
			return kses($varResult, $allowed);
		}
	}
	
	function httpFilterRequest($varname,$inputSource = 'admin')
	{
		global $allowed;
		global $allowedForUser;
		
		$varResult = formatTextToDb($_REQUEST[$varname]);
		
		if (get_magic_quotes_gpc())
		  $varResult = stripslashes($varResult);
		
		if($inputSource == 'admin')
			//return kses($varResult, $allowed, false);
			return $varResult;
		else if($inputSource == 'user')
			return kses($varResult, $allowedForUser);
	}

	function httpEncryptRequest($varname,$inputSource = 'admin')
	{
		global $allowed;
		global $allowedForUser;
		
		$varResult = formatTextToDb($_REQUEST[$varname]);
		
		if (get_magic_quotes_gpc())
		  $varResult = stripslashes($varResult);
		
		if($inputSource == 'admin')
			//return kses($varResult, $allowed, false);
			return mdecrypt($varResult);
		else if($inputSource == 'user')
			return kses($varResult, $allowedForUser);
	}	
	
	function encrypt($var)
	{
		return mencrypt($var);
	}

	function decrypt($var)
	{
		return mdecrypt($var);
	}	
	
	function httpParamGet($varname){
		return $_GET[$varname];
	}
	
	function httpParamPost($varname){
		return $_POST[$varname];
	}
	
	function httpParamGetPost($varname){
		$retval = $_GET[$varname];
		if(!$retval)
			$retval = $_POST[$varname];		
		return $retval;
	}
	
	function httpParamPostGet($varname){
		$retval = $_POST[$varname];
		if(!$retval)
			$retval = $_GET[$varname];		
		return $retval;
	}
	
	function httpParamRequest($varname) {
		$retval = $_REQUEST[$varname];
		return $retval;
	}
	
	function setcookielive($name, $value, $expire, $path='', $domain, $secure=false, $httponly=false) {
		//set a cookie as usual, but ALSO add it to $_COOKIE so the current page load has access
		$_COOKIE[$name] = $value;
		return setcookie($name,$value,$expire,$path,$domain,$secure,$httponly);
	}
	
	function integerToRoman($integer)
{
 // Convert the integer into an integer (just to make sure)
 $integer = intval($integer);
 $result = '';
 
 // Create a lookup array that contains all of the Roman numerals.
 $lookup = array('M' => 1000,
 'CM' => 900,
 'D' => 500,
 'CD' => 400,
 'C' => 100,
 'XC' => 90,
 'L' => 50,
 'XL' => 40,
 'X' => 10,
 'IX' => 9,
 'V' => 5,
 'IV' => 4,
 'I' => 1);
 
 foreach($lookup as $roman => $value){
  // Determine the number of matches
  $matches = intval($integer/$value);
 
  // Add the same number of characters to the string
  $result .= str_repeat($roman,$matches);
 
  // Set the integer to be the remainder of the integer and the value
  $integer = $integer % $value;
 }
 
 // The Roman numeral should be built, return it
 return $result;
}

?>