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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_KEY_TABEL.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrKeyTabel extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrKeyTabel()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("ID_TABEL", $this->getNextId("ID_TABEL","KBBR_KEY_TABEL")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_KEY_TABEL (
				   KD_CABANG, KD_SUBSIS, ID_TABEL, 
				   KD_TABEL, NM_KET1, NM_KET2, 
				   NM_KET3, NM_NUM1, NM_NUM2, 
				   NM_NUM3, NM_VAL, KD_AKTIF, 
				   LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
				   LEVEL_OPERATOR, PASSW) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_SUBSIS")."', '".$this->getField("ID_TABEL")."',
					'".$this->getField("KD_TABEL")."', '".$this->getField("NM_KET1")."', '".$this->getField("NM_KET2")."',
					'".$this->getField("NM_KET3")."', '".$this->getField("NM_NUM1")."', '".$this->getField("NM_NUM2")."',
					'".$this->getField("NM_NUM3")."', '".$this->getField("NM_VAL")."', '".$this->getField("KD_AKTIF")."',
					".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."',
					'".$this->getField("LEVEL_OPERATOR")."', '".$this->getField("PASSW")."'
				)";
				
		$this->id = $this->getField("ID_TABEL");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_KEY_TABEL
				SET    
					   KD_CABANG        = '".$this->getField("KD_CABANG")."',
					   KD_SUBSIS        = '".$this->getField("KD_SUBSIS")."',
					   ID_TABEL         = '".$this->getField("ID_TABEL")."',
					   KD_TABEL         = '".$this->getField("KD_TABEL")."',
					   NM_KET1          = '".$this->getField("NM_KET1")."',
					   NM_KET2          = '".$this->getField("NM_KET2")."',
					   NM_KET3          = '".$this->getField("NM_KET3")."',
					   NM_NUM1          = '".$this->getField("NM_NUM1")."',
					   NM_NUM2          = '".$this->getField("NM_NUM2")."',
					   NM_NUM3          = '".$this->getField("NM_NUM3")."',
					   NM_VAL           = '".$this->getField("NM_VAL")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."',
					   LEVEL_OPERATOR   = '".$this->getField("LEVEL_OPERATOR")."',
					   PASSW            = '".$this->getField("PASSW")."'
				WHERE  ID_TABEL = '".$this->getField("ID_TABEL_ID")."'
				AND KD_TABEL = '".$this->getField("KD_TABEL_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	
	function delete()
	{
        $str = "DELETE FROM KBBR_KEY_TABEL
                WHERE 
                  KD_TABEL = '".$this->getField("KD_TABEL")."'"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
	function deleteByParams()
	{
        $str = "DELETE FROM KBBR_KEY_TABEL
                WHERE 
                  KD_TABEL = '".$this->getField("KD_TABEL")."' AND ID_TABEL = '".$this->getField("ID_TABEL")."' "; 
				  
		$this->query = $str;
		//echo $str;
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
				SELECT KD_CABANG, KD_SUBSIS, ID_TABEL, 
			    KD_TABEL, NM_KET1, NM_KET2, 
			    NM_KET3, NM_NUM1, NM_NUM2, 
			    NM_NUM3, NM_VAL, KD_AKTIF, 
			    LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
			    LEVEL_OPERATOR, PASSW
				FROM KBBR_KEY_TABEL
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
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_SUBSIS, ID_TABEL, 
			    KD_TABEL, NM_KET1, NM_KET2, 
			    NM_KET3, NM_NUM1, NM_NUM2, 
			    NM_NUM3, NM_VAL, KD_AKTIF, 
			    LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
			    LEVEL_OPERATOR, PASSW
				FROM KBBR_KEY_TABEL
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

    function getMaterai($jumlah)
	{
		$str = "SELECT AMBIL_MATERAI(".$jumlah.") ROWCOUNT FROM DUAL "; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }


    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KD_TABEL) AS ROWCOUNT FROM KBBR_KEY_TABEL
		        WHERE 1=1 ".$statement; 
		
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
		$str = "SELECT COUNT(KD_TABEL) AS ROWCOUNT FROM KBBR_KEY_TABEL
		        WHERE 1=1 ".$statement; 
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