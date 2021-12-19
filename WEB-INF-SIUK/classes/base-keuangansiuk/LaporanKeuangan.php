<? 
/* *******************************************************************************************************
MODUL NAME 			: IMASYS
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_JUR_BB.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class LaporanKeuangan extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function LaporanKeuangan()
	{
      $this->EntitySIUK(); 
    }

	function callArusKas()
	{
        $str = "
				CALL Laporan_Keuangan.ARUS_KAS('".$this->getField("BULAN")."', '".$this->getField("TAHUN")."')
		"; 
		
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	
	function callBulan15()
	{
        $str = "
				CALL BULAN_15('".$this->getField("BULAN")."', '".$this->getField("TAHUN")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

	
	function callLb4New()
	{
        $str = "
				CALL Laporan_Keuangan.LB4_NEW('".$this->getField("BULAN")."', '".$this->getField("TAHUN")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callLb4()
	{
        $str = "
				CALL Laporan_Keuangan.LB4('".$this->getField("BULAN")."', '".$this->getField("TAHUN")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function callWlapLabaRugiBiayaPrt()
	{
        $str = "
				CALL WLAP_LABA_RUGI_BIAYA_PRT('".$this->getField("TAHUN")."', '".$this->getField("BULAN")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }


	
	function callWlapLabaRugiBiayaPrtCabang()
	{
        $str = "
				CALL WLAP_LABA_RUGI_BIAYA_PRT_CAB('".$this->getField("TAHUN")."', '".$this->getField("BULAN")."', '".$this->getField("CABANG")."')
		"; 
		
		
		$this->query = $str;
		// echo$str;exit();
        return $this->execQuery($str);
    }
	
	function callWlapLabaRugiBiayaPrt2()
	{
        $str = "
				CALL WLAP_LABA_RUGI_BIAYA_PRT2('".$this->getField("TAHUN")."', '".$this->getField("BULAN")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function callWlapLabaRugiBiayaPrt2Cab()
	{
        $str = "
				CALL WLAP_LABA_RUGI_BIAYA_PRT2_CAB('".$this->getField("TAHUN")."', '".$this->getField("BULAN")."','".$this->getField("CABANG")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callWlapLabaRugiPusatPrt()
	{
        $str = "
				CALL WLAP_LABA_RUGI_PUSAT_PRT('".$this->getField("TAHUN")."', '".$this->getField("BULAN")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callWlapLabaRugiPusatPrtCabang()
	{
        $str = "
				CALL WLAP_LABA_RUGI_PUSAT_PRT_CAB('".$this->getField("TAHUN")."', '".$this->getField("BULAN")."','".$this->getField("CABANG")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function callWlapLabaRugiPusatPrt2()
	{
        $str = "
				CALL WLAP_LABA_RUGI_PUSAT_PRT2('".$this->getField("TAHUN")."', '".$this->getField("BULAN")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	
	
	
	
	function callWlapLabaRugiPusatPrt2Cab()
	{
        $str = "
				CALL WLAP_LABA_RUGI_PUSAT_PRT2_CAB('".$this->getField("TAHUN")."', '".$this->getField("BULAN")."', '".$this->getField("CABANG")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	
	
	function callWlapLabaRugiPusatPrtCab()
	{
        $str = "
				CALL WLAP_LABA_RUGI_PUSAT_PRT_CAB('".$this->getField("TAHUN")."', '".$this->getField("BULAN")."', '".$this->getField("CABANG")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callSummaryNeracaSaldo()
	{
        $str = "
				CALL SUMMARY_NERACA_SALDO('".$this->getField("TAHUN")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	

	function callUpdateLabaRugi()
	{
        $str = "
				CALL UPDATE_LABARUGI('".$this->getField("KD_CABANG")."', '".$this->getField("TAHUN")."', '".$this->getField("BULAN")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	
    function getCountKbbrLaporanLb4($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(*) AS ROWCOUNT FROM KBBR_LAPORAN_LB4
		        WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getKodeCabang($paramsArray=array(), $statement="")
	{
		$str = " SELECT TO_NUMBER(RSYS_SUBKODE1) AS  ROWCOUNT
				 FROM SAFR_SYSPARAM
				 WHERE RSYS_NO = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
				
  } 
?>