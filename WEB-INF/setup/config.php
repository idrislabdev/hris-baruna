<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: config.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: this file handle to get value of configuration from web.xml 
***************************************************************************************************** */

	include_once("../WEB-INF/setup/defines.php");
	include_once("../WEB-INF/functions/dialogs.func.php");
	include_once("../WEB-INF/functions/default.func.php");
	include_once("../WEB-INF/lib/path/patConfiguration.php" );
	
	$conf = new patConfiguration();
  	$conf->parseConfigFile("../WEB-INF/web.xml" );
	$datasource = $conf->getConfigValue("datasource.default");
		
	/**** DATABASE CONFIGURATION *****/
	$confDbType = $conf->getConfigValue("datasource.".$datasource.".driver");
	$confDbServer = $conf->getConfigValue("datasource.".$datasource.".server");
	$confDbName = $conf->getConfigValue("datasource.".$datasource.".database");
	$confDbUserName = $conf->getConfigValue("datasource.".$datasource.".username");
	$confDbPassword = $conf->getConfigValue("datasource.".$datasource.".password");
	$confDbTrusted = $conf->getConfigValue("datasource.".$datasource.".trusted_connection");
	
	//echo $confDbPassword;
	
	include_once("../WEB-INF/classes/db/DBManager.php");
	$dbDefault = new DBManager();
	$dbDefault->connect();
?>
