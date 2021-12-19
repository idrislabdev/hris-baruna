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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_RULE_MODUL.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrRuleModul extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrRuleModul()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBR_RULE_MODUL_ID", $this->getNextId("KBBR_RULE_MODUL_ID","KBBR_RULE_MODUL")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_RULE_MODUL (
				   KD_CABANG, KD_SUBSIS, KD_RULE, 
				   ID_REF_SUBSYS, KET_RULE, PILIHAN, 
				   STATUS, KD_AKTIF, KET_TAMBAHAN, 
				   LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_SUBSIS")."', '".$this->getField("KD_RULE")."',
					'".$this->getField("ID_REF_SUBSYS")."', '".$this->getField("KET_RULE")."', '".$this->getField("PILIHAN")."',
					'".$this->getField("STATUS")."', '".$this->getField("KD_AKTIF")."', '".$this->getField("KET_TAMBAHAN")."',
					".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."'
				)";
						
		$this->id = $this->getField("KBBR_RULE_MODUL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_RULE_MODUL
				SET    
					   STATUS           = ".$this->getField("STATUS").",
					   KD_AKTIF         = ".$this->getField("KD_AKTIF").",
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."'
				WHERE  KD_RULE = '".$this->getField("KD_RULE")."' AND KD_SUBSIS = '".$this->getField("KD_SUBSIS")."'
			";
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_RULE_MODUL
                WHERE 
                  KBBR_RULE_MODUL_ID = ".$this->getField("KBBR_RULE_MODUL_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY KD_SUBSIS ASC")
	{
		$str = "
				SELECT KD_CABANG, KD_SUBSIS, KD_RULE, 
				ID_REF_SUBSYS, KET_RULE, PILIHAN, 
				STATUS, KD_AKTIF, KET_TAMBAHAN, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME
				FROM KBBR_RULE_MODUL A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_SUBSIS, KD_RULE, 
				ID_REF_SUBSYS, KET_RULE, PILIHAN, 
				STATUS, KD_AKTIF, KET_TAMBAHAN, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME
				FROM KBBR_RULE_MODUL
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

    function getStatus($paramsArray=array())
	{
		$str = "SELECT STATUS AS ROWCOUNT FROM KBBR_RULE_MODUL
		        WHERE 1 = 1 "; 
		
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
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBR_RULE_MODUL_ID) AS ROWCOUNT FROM KBBR_RULE_MODUL
		        WHERE KBBR_RULE_MODUL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KBBR_RULE_MODUL_ID) AS ROWCOUNT FROM KBBR_RULE_MODUL
		        WHERE KBBR_RULE_MODUL_ID IS NOT NULL ".$statement; 
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