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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_GROUP_REK.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrGroupRek extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrGroupRek()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBR_GROUP_REK_ID", $this->getNextId("KBBR_GROUP_REK_ID","KBBR_GROUP_REK")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_GROUP_REK (
				   KD_CABANG, ID_GROUP, NAMA_GROUP, 
				   TIPE_NOREK, MULAI_REKENING, SAMPAI_REKENING, 
				   KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				   PROGRAM_NAME) 
				VALUES ( '".$this->getField("KD_CABANG")."', '".$this->getField("ID_GROUP")."', '".$this->getField("NAMA_GROUP")."',
					'".$this->getField("TIPE_NOREK")."', '".$this->getField("MULAI_REKENING")."', '".$this->getField("SAMPAI_REKENING")."',
					'".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."', 
					'".$this->getField("PROGRAM_NAME")."'
				)";
				
		$this->id = $this->getField("KBBR_GROUP_REK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_GROUP_REK
				SET    
					   ID_GROUP         = '".$this->getField("ID_GROUP")."',
					   NAMA_GROUP       = '".$this->getField("NAMA_GROUP")."',
					   TIPE_NOREK       = '".$this->getField("TIPE_NOREK")."',
					   MULAI_REKENING   = '".$this->getField("MULAI_REKENING")."',
					   SAMPAI_REKENING  = '".$this->getField("SAMPAI_REKENING")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."'
				WHERE  ID_GROUP = '".$this->getField("ID_GROUP_TEMP")."'
			";
		/*KD_CABANG        = '".$this->getField("KD_CABANG")."',
		PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'*/
					   
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_GROUP_REK
                WHERE 
                  ID_GROUP = '".$this->getField("ID_GROUP")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY TIPE_NOREK ASC")
	{
		$str = "
				SELECT KD_CABANG, ID_GROUP, NAMA_GROUP, 
				TIPE_NOREK, MULAI_REKENING, SAMPAI_REKENING, 
				KD_AKTIF, DECODE(KD_AKTIF,'A', 'AKTIF', 'TIDAK AKTIF') KD_AKTIF_KET, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM KBBR_GROUP_REK
				WHERE 1 = 1
				"; 
				
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
				SELECT KD_CABANG, ID_GROUP, NAMA_GROUP, 
				TIPE_NOREK, MULAI_REKENING, SAMPAI_REKENING, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM KBBR_GROUP_REK
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
		$str = "SELECT COUNT(ID_GROUP) AS ROWCOUNT FROM KBBR_GROUP_REK
		        WHERE ID_GROUP IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(ID_GROUP) AS ROWCOUNT FROM KBBR_GROUP_REK
		        WHERE ID_GROUP IS NOT NULL ".$statement; 
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