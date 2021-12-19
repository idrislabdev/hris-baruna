<? 
/* *******************************************************************************************************
MODUL NAME 			: PEL
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel HASIL_RAPAT_JABATAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class HasilRapatJabatan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function HasilRapatJabatan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
	
		$str = "
				INSERT INTO HASIL_RAPAT_JABATAN (
				   HASIL_RAPAT_ID, JABATAN_ID) 
 			  	SELECT '".$this->getField("HASIL_RAPAT_ID")."' HASIL_RAPAT_ID, JABATAN_ID FROM PPI_SIMPEG.JABATAN WHERE  NAMA IN 
				(SELECT REGEXP_SUBSTR('".$this->getField("JABATAN")."','[^,]+', 1, LEVEL) FROM DUAL CONNECT BY 
				REGEXP_SUBSTR('".$this->getField("JABATAN")."', '[^,]+', 1, LEVEL) IS NOT NULL)	
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE HASIL_RAPAT_JABATAN
				SET    
					   HASIL_RAPAT_ID	= '".$this->getField("HASIL_RAPAT_ID")."',
					   JABATAN_ID	 	= '".$this->getField("JABATAN_ID")."'
				WHERE  JABATAN_ID  		= '".$this->getField("JABATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM HASIL_RAPAT_JABATAN
                WHERE 
                  HASIL_RAPAT_ID = ".$this->getField("HASIL_RAPAT_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY JABATAN_ID ASC")
	{
		$str = "
					SELECT HASIL_RAPAT_ID, JABATAN_ID
					FROM HASIL_RAPAT_JABATAN A WHERE 1 = 1
				"; 
		
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
					SELECT HASIL_RAPAT_ID, JABATAN_ID
					FROM HASIL_RAPAT_JABATAN A WHERE JABATAN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY JABATAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(JABATAN_ID) AS ROWCOUNT FROM HASIL_RAPAT_JABATAN
		        WHERE JABATAN_ID IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(JABATAN_ID) AS ROWCOUNT FROM HASIL_RAPAT_JABATAN
		        WHERE JABATAN_ID IS NOT NULL ".$statement; 
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