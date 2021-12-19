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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_TAHUN_BUKU.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrThnBuku extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrThnBuku()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBR_TAHUN_BUKU_ID", $this->getNextId("KBBR_TAHUN_BUKU_ID","KBBR_TAHUN_BUKU")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_THN_BUKU (
				   KD_CABANG, THN_BUKU, NM_THN_BUKU, 
				   STATUS_CLOSING, KALI_CLOSING, LAST_UPDATE_DATE, 
				   LAST_UPDATED_BY, PROGRAM_NAME) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("THN_BUKU")."', '".$this->getField("NM_THN_BUKU")."',
					'".$this->getField("STATUS_CLOSING")."', '".$this->getField("KALI_CLOSING")."', ".$this->getField("LAST_UPDATE_DATE").", 
					'".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."'
				)";
				
		$this->id = $this->getField("KBBR_TAHUN_BUKU_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_THN_BUKU
				SET    
					   
					   THN_BUKU         = '".$this->getField("THN_BUKU")."',
					   NM_THN_BUKU      = '".$this->getField("NM_THN_BUKU")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."'
				WHERE  THN_BUKU = '".$this->getField("THN_BUKU_TEMP")."'
			";
		
		/*KD_CABANG        = '".$this->getField("KD_CABANG")."',
		STATUS_CLOSING   = '".$this->getField("STATUS_CLOSING")."',
		KALI_CLOSING     = '".$this->getField("KALI_CLOSING")."',
		PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'*/
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_TAHUN_BUKU
                WHERE 
                  KBBR_TAHUN_BUKU_ID = '".$this->getField("KBBR_TAHUN_BUKU_ID")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteAll()
	{
		$str1 = "DELETE FROM KBBR_THN_BUKU
                WHERE 
                  THN_BUKU = '".$this->getField("THN_BUKU")."'
		";
				  
		$this->query = $str1;
		$this->execQuery($str1);
		
        $str = "DELETE FROM KBBR_THN_BUKU_D
                WHERE 
                  THN_BUKU = '".$this->getField("THN_BUKU")."'
		";
				  
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
				SELECT KD_CABANG, THN_BUKU, NM_THN_BUKU, 
				STATUS_CLOSING, KALI_CLOSING, LAST_UPDATE_DATE, 
				LAST_UPDATED_BY, PROGRAM_NAME
				FROM KBBR_THN_BUKU
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
	
	
	function selectByParamsCombo($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY THN_BUKU DESC")
	{
		$str = "
				SELECT THN_BUKU, NM_THN_BUKU FROM KBBR_THN_BUKU
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
				SELECT KD_CABANG, THN_BUKU, NM_THN_BUKU, 
				STATUS_CLOSING, KALI_CLOSING, LAST_UPDATE_DATE, 
				LAST_UPDATED_BY, PROGRAM_NAME
				FROM KBBR_THN_BUKU
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
		$str = "SELECT COUNT(NM_THN_BUKU) AS ROWCOUNT FROM KBBR_THN_BUKU
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
		$str = "SELECT COUNT(KBBR_TAHUN_BUKU_ID) AS ROWCOUNT FROM KBBR_TAHUN_BUKU
		        WHERE KBBR_TAHUN_BUKU_ID IS NOT NULL ".$statement; 
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