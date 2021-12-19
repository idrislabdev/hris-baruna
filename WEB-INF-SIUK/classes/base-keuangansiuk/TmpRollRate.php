
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
  * EntitySIUK-base class untuk mengimplementasikan tabel TMP_ROLL_RATE.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class TmpRollRate extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TmpRollRate()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("TMP_ROLL_RATE_ID", $this->getNextId("TMP_ROLL_RATE_ID","TMP_ROLL_RATE")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "

				INSERT INTO TMP_ROLL_RATE (
				    KD_CABANG, JENIS_FILE, ID_FILE, 
   					BULTAH, KET_REFERENCE, KD_AKTIF, 
  					LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME)
				VALUES ( '".$this->getField("KD_CABANG")."', '".$this->getField("JENIS_FILE")."', '".$this->getField("ID_FILE")."',
					'".$this->getField("BULTAH")."', '".$this->getField("KET_REFERENCE")."', '".$this->getField("KD_AKTIF")."',
					".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."'
				)";
				
		//$this->id = $this->getField("TMP_ROLL_RATE_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE TMP_ROLL_RATE
				SET    
					   BULTAH      = '".$this->getField("BULTAH")."',
					   KET_REFERENCE    = '".$this->getField("KET_REFERENCE")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."'
				WHERE  BULTAH = '".$this->getField("BULTAH_TEMP")."'
			";
		
		/*KD_CABANG        = '".$this->getField("KD_CABANG")."',
	    JENIS_FILE       = '".$this->getField("JENIS_FILE")."',
	    ID_FILE          = '".$this->getField("ID_FILE")."',
		PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'*/
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM TMP_ROLL_RATE
                WHERE 
                  TMP_ROLL_RATE_ID = ".$this->getField("TMP_ROLL_RATE_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callRollRate()
	{
        $str = "CALL ROLL_RATE_BARU('".$this->getField("PERIODE")."')"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callHitungSummaryRollRate()
	{
		
		$str = $this->PrepareSP("BEGIN HITUNG_SUMMARY_ROLL_RATE(:inPERIODE, :inPKDVALUTA, :inPBADANUSAHA, 
							    :outSUM_CUR, :outSUM_130, :outSUM_3190, :outSUM_181, :outSUM_371, :outSUM_365, :outSUM_A365); END;");
		$this->InParameter($str,$this->getField("PERIODE"),'inPERIODE');
		$this->InParameter($str,$this->getField("KD_VALUTA"),'inPKDVALUTA');
		$this->InParameter($str,$this->getField("BADAN_USAHA"),'inPBADANUSAHA');
		$this->OutParameter($str,$out_sum_cur,'outSUM_CUR');
		$this->OutParameter($str,$out_sum_130,'outSUM_130');
		$this->OutParameter($str,$out_sum_3190,'outSUM_3190');
		$this->OutParameter($str,$out_sum_181,'outSUM_181');
		$this->OutParameter($str,$out_sum_371,'outSUM_371');
		$this->OutParameter($str,$out_sum_365,'outSUM_365');
		$this->OutParameter($str,$out_sum_A365,'outSUM_A365');
		$this->execQuery($str);
		$output[0]["SUM_CUR"]  = $out_sum_cur;
		$output[0]["SUM_130"]  = $out_sum_130;
		$output[0]["SUM_3190"] = $out_sum_3190;
		$output[0]["SUM_181"]  = $out_sum_181;
		$output[0]["SUM_371"]  = $out_sum_371;
		$output[0]["SUM_365"]  = $out_sum_365;
		$output[0]["SUM_A365"] = $out_sum_A365;
		
        return $output;
    }	
		
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT 
				 TO_CHAR(TO_DATE(TO_CHAR(BULTAH),'YYYYMM'),'MON') || ' ' || SUBSTR(BULTAH, 0,4) NM_BULTAH, BULTAH, BADAN_USAHA, VAL_CURRENT, 
				   VAL_30HARI, VAL_90HARI, VAL_180HARI, 
				   VAL_270HARI, VAL_365HARI, VAL_A365HARI, 
				   KD_VALUTA
				FROM TMP_ROLL_RATE A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
 
    function selectByParamsSummary($periode, $valuta, $badan_usaha)
	{
		$str = "
				SELECT SUM(VAL_CURRENT) A,SUM(VAL_30HARI) B,SUM(VAL_90HARI) C,SUM(VAL_180HARI) D,SUM(VAL_270HARI) E,SUM(VAL_365HARI) F
				FROM
				  TMP_ROLL_RATE
					  WHERE PERIODE = '".$periode."'
					  AND KD_VALUTA = '".$valuta."'
					  AND BADAN_USAHA = '".$badan_usaha."'
				"; 
		//, FOTO
		
		$this->query = $str;
		return $this->selectLimit($str, -1, -1); 
    }
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, JENIS_FILE, ID_FILE, 
				BULTAH,  KET_REFERENCE,
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM TMP_ROLL_RATE
				WHERE 1 = 1
			  "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KD_CABANG ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(BULTAH) AS ROWCOUNT FROM TMP_ROLL_RATE
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

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TMP_ROLL_RATE_ID) AS ROWCOUNT FROM TMP_ROLL_RATE
		        WHERE BULTAH IS NOT NULL ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	
  } 
?>