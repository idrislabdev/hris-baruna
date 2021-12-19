<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: LogCounter.php
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Class that responsible to record hit from visitor
***************************************************************************************************** */

include_once("../WEB-INF/classes/entities/LogPengunjung.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

class LogCounter {
	var $ipAddress = "";
	var $tanggal = "";
	
	function LogCounter() {
		//session_start();
		$this->ipAddress = $_SERVER['REMOTE_ADDR'];
		$this->tanggal = date('Y-m-d H:i:s');
	}
	
	function writeLog() {
		$log_pengunjung = new LogPengunjung();
		
		if (!session_is_registered("sessLog")) {
			$log_pengunjung->setField("TANGGAL", $this->tanggal);
			$log_pengunjung->setField("IP_ADDRESS", $this->ipAddress);
			$log_pengunjung->setField("LOGIN_UID", '0');
			$log_pengunjung->setField("ACTION", 'visit');
			$log_pengunjung->insert();
			
			session_register("sessLog");
		}
	}
	
	// added by Ridwan Rismanto, mencatat kegiatan user yang sudah login
	function writeLoginLog($userLogin, $action='visit') {
		$userLogin->retrieveUserInfo();  
		$log_pengunjung = new LogPengunjung();
		
		if($userLogin->userLevel >= 1)
		{
			$log_pengunjung->setField("TANGGAL", $this->tanggal);
			$log_pengunjung->setField("IP_ADDRESS", $this->ipAddress);
			$log_pengunjung->setField("LOGIN_UID", $userLogin->UID);
			$log_pengunjung->setField("ACTION", $action);
			$log_pengunjung->insert();
			
		}
	}
	
	function getCounter($mode='all') {
		$log_pengunjung = new LogPengunjung();
		
		if($mode == 'all')
			$_pengunjung = $log_pengunjung->getCountByParams(array('ACTION' => 'visit'));
		else if($mode == 'daily')
			$_pengunjung = $log_pengunjung->getCountByParams(array('ACTION' => 'visit', 'DATE(TANGGAL)' => date('Y-m-d')));
		
		return $_pengunjung;
	}
}

$log = new LogCounter();
?>