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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_PARAM_REK.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrParamRek extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrParamRek()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBR_PARAM_REK_ID", $this->getNextId("KBBR_PARAM_REK_ID","KBBR_PARAM_REK")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_PARAM_REK (
				   KD_CABANG, JENIS, PARAM1, 
				   PARAM2, PARAM3, PARAM4, 
				   PARAM5, PARAM6, PARAM7, 
				   PARAM8, PARAM9, PARAM10, 
				   KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				   PROGRAM_NAME, PARAM11, PARAM12, 
				   PARAM13, PARAM14, PARAM15, 
				   PARAM16, PARAM17, PARAM18) 
				VALUES ( '".$this->getField("KD_CABANG")."', '".$this->getField("JENIS")."', '".$this->getField("PARAM1")."',
					'".$this->getField("PARAM2")."', '".$this->getField("PARAM3")."', '".$this->getField("PARAM4")."',
					'".$this->getField("PARAM5")."', '".$this->getField("PARAM6")."', '".$this->getField("PARAM7")."',
					'".$this->getField("PARAM8")."', '".$this->getField("PARAM9")."', '".$this->getField("PARAM10")."',
					'".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."',
					'".$this->getField("PROGRAM_NAME")."', '".$this->getField("PARAM11")."', '".$this->getField("PARAM12")."',
					'".$this->getField("PARAM13")."', '".$this->getField("PARAM14")."', '".$this->getField("PARAM15")."',
					'".$this->getField("PARAM16")."', '".$this->getField("PARAM17")."', '".$this->getField("PARAM18")."'
				)";
				
		$this->id = $this->getField("KBBR_PARAM_REK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_PARAM_REK
				SET    
					   KD_CABANG        = '".$this->getField("KD_CABANG")."',
					   JENIS            = '".$this->getField("JENIS")."',
					   PARAM1           = '".$this->getField("PARAM1")."',
					   PARAM2           = '".$this->getField("PARAM2")."',
					   PARAM3           = '".$this->getField("PARAM3")."',
					   PARAM4           = '".$this->getField("PARAM4")."',
					   PARAM5           = '".$this->getField("PARAM5")."',
					   PARAM6           = '".$this->getField("PARAM6")."',
					   PARAM7           = '".$this->getField("PARAM7")."',
					   PARAM8           = '".$this->getField("PARAM8")."',
					   PARAM9           = '".$this->getField("PARAM9")."',
					   PARAM10          = '".$this->getField("PARAM10")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."',
					   PARAM11          = '".$this->getField("PARAM11")."',
					   PARAM12          = '".$this->getField("PARAM12")."',
					   PARAM13          = '".$this->getField("PARAM13")."',
					   PARAM14          = '".$this->getField("PARAM14")."',
					   PARAM15          = '".$this->getField("PARAM15")."',
					   PARAM16          = '".$this->getField("PARAM16")."',
					   PARAM17          = '".$this->getField("PARAM17")."',
					   PARAM18          = '".$this->getField("PARAM18")."'
				WHERE  KBBR_PARAM_REK_ID = '".$this->getField("KBBR_PARAM_REK_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_PARAM_REK
                WHERE 
                  KBBR_PARAM_REK_ID = ".$this->getField("KBBR_PARAM_REK_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, JENIS, PARAM1, 
				PARAM2, PARAM3, PARAM4, 
				PARAM5, PARAM6, PARAM7, 
				PARAM8, PARAM9, PARAM10, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, PARAM11, PARAM12, 
				PARAM13, PARAM14, PARAM15, 
				PARAM16, PARAM17, PARAM18
				FROM KBBR_PARAM_REK
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KBBR_PARAM_REK_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, JENIS, PARAM1, 
				PARAM2, PARAM3, PARAM4, 
				PARAM5, PARAM6, PARAM7, 
				PARAM8, PARAM9, PARAM10, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, PARAM11, PARAM12, 
				PARAM13, PARAM14, PARAM15, 
				PARAM16, PARAM17, PARAM18
				FROM KBBR_PARAM_REK
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
		$str = "SELECT COUNT(KBBR_PARAM_REK_ID) AS ROWCOUNT FROM KBBR_PARAM_REK
		        WHERE KBBR_PARAM_REK_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KBBR_PARAM_REK_ID) AS ROWCOUNT FROM KBBR_PARAM_REK
		        WHERE KBBR_PARAM_REK_ID IS NOT NULL ".$statement; 
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