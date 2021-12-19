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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_NO_NOTA.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrNoNota extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrNoNota()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KBBR_NO_NOTA_ID", $this->getNextId("KBBR_NO_NOTA_ID","KBBR_NO_NOTA")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_NO_NOTA (
				   KD_CABANG, KD_BUKTI, KET_BUKTI, 
				   KD_PERIODE, AWALAN, NO_START, 
				   NO_STOP, NO_DIPAKAI, KD_AKTIF, 
				   LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME) 
				VALUES ( 95, '".$this->getField("KD_BUKTI")."', '".$this->getField("KET_BUKTI")."',
					'".$this->getField("KD_PERIODE")."', '".$this->getField("AWALAN")."', '".$this->getField("NO_START")."',
					'".$this->getField("NO_STOP")."', '".$this->getField("NO_DIPAKAI")."', '".$this->getField("KD_AKTIF")."',
					".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."'
				)";
				
		$this->id = $this->getField("KBBR_NO_NOTA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function insertCopy()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KBBR_NO_NOTA_ID", $this->getNextId("KBBR_NO_NOTA_ID","KBBR_NO_NOTA")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_NO_NOTA (
				   KD_CABANG, KD_BUKTI, KET_BUKTI, 
				   KD_PERIODE, AWALAN, NO_START, 
				   NO_STOP, NO_DIPAKAI, KD_AKTIF, 
				   LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME) 
				SELECT
				   KD_CABANG, KD_BUKTI, KET_BUKTI, 
				   ".$this->getField("KD_PERIODE_AKHIR").", AWALAN, NO_START, 
				   NO_STOP, 0, KD_AKTIF, 
				   SYSDATE, 'SYSTEM', PROGRAM_NAME
				FROM KBBR_NO_NOTA WHERE KD_PERIODE = ".$this->getField("KD_PERIODE_AWAL")." 
				";
				
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE KBBR_NO_NOTA
				SET    
					   KD_BUKTI         = '".$this->getField("KD_BUKTI")."',
					   KET_BUKTI        = '".$this->getField("KET_BUKTI")."',
					   KD_PERIODE       = '".$this->getField("KD_PERIODE")."',
					   AWALAN           = '".$this->getField("AWALAN")."',
					   NO_START         = '".$this->getField("NO_START")."',
					   NO_STOP          = '".$this->getField("NO_STOP")."',
					   NO_DIPAKAI       = '".$this->getField("NO_DIPAKAI")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."'
				WHERE  KD_BUKTI = '".$this->getField("KD_BUKTI_TEMP")."' AND KD_PERIODE = '".$this->getField("KD_PERIODE_TEMP")."'
			";
			/*KD_CABANG        = '".$this->getField("KD_CABANG")."',
			PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'*/
			
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_NO_NOTA
                WHERE 
				  KD_BUKTI = '".$this->getField("KD_BUKTI")."' AND KD_PERIODE = '".$this->getField("KD_PERIODE")."'
                "; 
		//KBBR_NO_NOTA_ID = ".$this->getField("KBBR_NO_NOTA_ID")."
		$this->query = $str;
        return $this->execQuery($str);
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
				SELECT A.KD_CABANG, A.KD_BUKTI, A.KET_BUKTI, 
				A.KD_PERIODE, AWALAN, NO_START, 
				NO_STOP, NO_DIPAKAI, A.KD_AKTIF, ID_REF_DATA, KET_REF_DATA, 
				A.LAST_UPDATE_DATE, A.LAST_UPDATED_BY, A.PROGRAM_NAME
				FROM KBBR_NO_NOTA A
				LEFT JOIN KBBR_GENERAL_REF_D B ON A.KD_BUKTI = B.ID_REF_DATA
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_BUKTI, KET_BUKTI, 
				KD_PERIODE, AWALAN, NO_START, 
				NO_STOP, NO_DIPAKAI, KD_AKTIF, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME
				FROM KBBR_NO_NOTA
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
		$str = "SELECT COUNT(KD_BUKTI) AS ROWCOUNT 
				FROM KBBR_NO_NOTA A
				LEFT JOIN KBBR_GENERAL_REF_D B ON A.KD_BUKTI = B.ID_REF_DATA
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
    
	function selectByParamsPeriode($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_PERIODE 
				FROM KBBR_NO_NOTA
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." GROUP BY KD_PERIODE ORDER BY SUBSTR(KD_PERIODE, 3, 4) DESC, SUBSTR(KD_PERIODE, 0, 2) DESC ";
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBR_NO_NOTA_ID) AS ROWCOUNT FROM KBBR_NO_NOTA
		        WHERE KBBR_NO_NOTA_ID IS NOT NULL ".$statement; 
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