<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: TamuLogin.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Class that responsible to handle process authentication for users on Admin group
***************************************************************************************************** */

/***********************************************************************
class.userlogin.php	
Mengelola informasi tentang user login. Untuk menggunakan kelas ini tidak
perlu di-instansiasi dulu, sudah otomatis.
Priyo Edi Purnomo dimodifikasi M Reza Faisal
************************************************************************/

include_once("../WEB-INF/classes/utils/GlobalParam.php");
include_once("../WEB-INF/classes/base/RekananIjinUsaha.php");

  class RekananIjinUsahaInfo{
	var $id_ijin_usaha;
	var $masa_berakhir;
    /******************** CONSTRUCTOR **************************************/
    function RekananIjinUsahaInfo(){
	
		 $this->emptyProps();
    }

    /******************** METHODS ************************************/
    /** Empty the properties **/
    function emptyProps(){
		$this->id_ijin_usaha = "";
		$this->masa_berakhir = "";				
    }
		
    
    /** Verify user login. True when login is valid**/
    function getRekananIjinUsaha($rekanan_id){			
		$rekanan_ijin_usaha = new RekananIjinUsaha();
		$rekanan_ijin_usaha->selectByParams(array("REKANAN_ID" => $rekanan_id));
		if ($rekanan_ijin_usaha->firstRow()) {           
			$this->id_ijin_usaha = $rekanan_ijin_usaha->getField("REKANAN_IJIN_USAHA_ID");
			$this->masa_berakhir_ijin_usaha = $rekanan_ijin_usaha->getField("INFO_TANGGAL_BERAKHIR");
		}
		
		$this->query = $rekanan_ijin_usaha->query;
		
		unset($rekanan_ijin_usaha);
    }
		   
}
	
  /***** INSTANTIATE THE GLOBAL OBJECT */
  $ijin_usaha_tanggal_berakhir = new RekananIjinUsahaInfo();

?>