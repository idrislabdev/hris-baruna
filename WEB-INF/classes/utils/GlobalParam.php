<?
/* *******************************************************************************************************
MODUL NAME 			: SIMKeu
FILE NAME 			: GlobalParam.php
AUTHOR				: Ridwan Rismanto
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: File berisi skrip untuk menghasilkan parameter umum
******************************************************************************************************* */

/* INCLUDE FILES 

include_once("../WEB-INF/classes/entities/BukuKas.php");
*/
include_once("../WEB-INF/classes/entities/Parameters.php");

class GlobalParam
{
	var $currDate;
	var $currIdPeriodeKeuangan;
	var $prevIdPeriodeKeuangan;
	var $currPeriodeKeuangan;
	var $npSaldoAwal;
	var $npSaldoMutasi;
	var $currTglStart;
	var $currTglEnd;
	
	var $noJurnal = array();
	
	var $conf = array();
	
	var $cashId;
	var $RLAKCashId;
	var $idTipeNpHarta;
	var $idTipeNpKewajiban;
	var $idTipeNpPendapatan;
	var $idTipeNpBeban;
	var $idTipeNpModal;
	var $idNpLabaBerjalan;
	
	var $arrTipeNpBeban = array();
	var $arrTipeNpPendapatan = array();
	var $arrTipeNpHarta = array();
	var $arrTipeNpKewajiban = array();
	var $arrTipeNpModal = array();
	
	var $query;
	
	
	// param
	var $usergroupAdmin;
	var $usergroupGuest;
	
	/* Constructor
	 * Execute each class needed
	*/
	function GlobalParam()
	{
		$parameters = new Parameters();
		$this->usergroupAdmin = $parameters->getParamValue('UGID_ADMIN');
		$this->usergroupGuest = $parameters->getParamValue('UGID_GUEST');
	}
	
	/*
	 * fungsi untuk menghilangkan array dengan nilai tertentu
	 * default : kosong ('') --> menghapus array kosong
	 */
	function cleanArray($dirtyArray, $separator = '')
	{
		while(list($key, $val) = each($dirtyArray))
		{
			if($val !== $separator)
				$res[] = $val;
		}
		
		return $res;
	}
	
	/* set parameter untuk session */
	function setSessionVar($sessionVarName, $sessionValue)
	{
		$_SESSION[$sessionVarName] = $sessionValue;
	}
	
	/* get parameter session */
	function getSessionVar($sessionVarName)
	{
		if(session_is_registered($sessionVarName))
			return $_SESSION[$sessionVarName];
		else
			return false;
	}
	
	/* ambil parameter session untuk set view mode user */
	function getUserGroupViewMode($default='AL')
	{
		if(isset($_SESSION['sesUserGroupViewMode']))
		{
			$this->conf['user group view mode'] = $_SESSION['sesUserGroupViewMode'];
			$this->conf['filter group'] = $_SESSION['sesFilterGroup'];
			
			$this->conf['user group search param'] = $_SESSION['sesUserGroupSearchParam'];
			$this->conf['user group search keyword'] = $_SESSION['sesUserGroupSearchKeyword'];
		}
		else
		{
			$this->conf['user group view mode'] = $default;
		}
	}
}
?>