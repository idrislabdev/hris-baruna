<?
ob_start(); // new onedha
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: defines.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: define variables and constants that used in all page in application
***************************************************************************************************** */

  	session_start();
	header ("Pragma: no-cache");
	header ("Cache-Control: no-cache, must-revalidate");
	
	/**** DATE/TIME DISPLAY CONFIGURATION *****/
	define("DATE_IN_DB","Y-n-d");         //2002-12-1
	define("DATE_IN_PAGE","d-M-Y");       //11-Dec-2002 : HARUS SAMA
	define("DATE_IN_FIELD","dd-Mon-yyyy"); //11-Dec-2002 : HARUS SAMA
	define("DEFAULT_DB_DATE","1970-1-01");
	
	/**** DIALOG-MESSAGES TYPE ****/
	define("MSG_EXCLAMATION","0");
	define("MSG_INFORMATION","1");
	define("MSG_CRITICAL","2");
	define("MSG_CONFIRMATION","3");
	
	$params = array();		
	
?>