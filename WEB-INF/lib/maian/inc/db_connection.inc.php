<?php

/*---------------------------------------------
  MAIAN SEARCH v1.1
  Written by David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Website: www.maianscriptworld.co.uk
  This File: Database Connection File
----------------------------------------------*/

$database = array();

//========================================================================================================
//NOTE: EDIT YOUR SQL CONNECTION INFORMATION BELOW. THE VARIABLES ARE ARRAY VARIABLES AND MUST NOT
//BE CHANGED. IE: $database['username']. DO NOT CHANGE THESE NAMES. ONLY THE VALUES SHOULD BE CHANGED
//========================================================================================================

//------------------------------------------------------
//HOST
//This is usually localhost or your server ip address
//Example: $database['host'] = 'localhost';
//------------------------------------------------------

$database['host']          = 'localhost';

//----------------------------------------------
//USERNAME
//Username assigned to database
//Example: $database['username'] = 'david';
//----------------------------------------------

$database['username']      = 'root';

//----------------------------------------------
//PASSWORD
//Password assigned to database
//Example: $database['password'] = 'abc1234';
//----------------------------------------------

$database['password']      = '';

//----------------------------------------------
//DATABASE NAME
//Name of Database that holds tables
//Example: $database['database'] = 'search';
//----------------------------------------------

$database['database']      = 'db_maian';

//----------------------------------------------
//TABLE PREFIX
//For people with only 1 database
//Example: $database['prefix'] = 'ms_';
//DO NOT comment this line out. It is important
// to the script.
//----------------------------------------------

$database['prefix']        = 'ms_';

//================================
//DO NOT EDIT BELOW THIS LINE
//================================

$connect = @mysql_connect($database['host'] , $database['username'] , $database['password']);

if (!$connect)
{
	die (mysql_error());
}
@mysql_select_db($database['database'], $connect) or die (mysql_error());

?>
