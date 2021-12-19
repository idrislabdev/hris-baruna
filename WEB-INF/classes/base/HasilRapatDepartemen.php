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
  * Entity-base class untuk mengimplementasikan tabel HASIL_RAPAT_DEPARTEMEN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class HasilRapatDepartemen extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function HasilRapatDepartemen()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
	
		$str = "
				INSERT INTO HASIL_RAPAT_DEPARTEMEN (
				   HASIL_RAPAT_ID, DEPARTEMEN_ID) 
 			  	SELECT '".$this->getField("HASIL_RAPAT_ID")."' HASIL_RAPAT_ID, DEPARTEMEN_ID FROM PPI_SIMPEG.DEPARTEMEN WHERE  NAMA IN 
				(SELECT REGEXP_SUBSTR('".$this->getField("DEPARTEMEN")."','[^,]+', 1, LEVEL) FROM DUAL CONNECT BY 
				REGEXP_SUBSTR('".$this->getField("DEPARTEMEN")."', '[^,]+', 1, LEVEL) IS NOT NULL)	
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE HASIL_RAPAT_DEPARTEMEN
				SET    
					   HASIL_RAPAT_ID	= '".$this->getField("HASIL_RAPAT_ID")."',
					   DEPARTEMEN_ID	 	= '".$this->getField("DEPARTEMEN_ID")."'
				WHERE  DEPARTEMEN_ID  		= '".$this->getField("DEPARTEMEN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM HASIL_RAPAT_DEPARTEMEN
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY DEPARTEMEN_ID ASC")
	{
		$str = "
					SELECT HASIL_RAPAT_ID, DEPARTEMEN_ID
					FROM HASIL_RAPAT_DEPARTEMEN A WHERE 1 = 1
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
					SELECT HASIL_RAPAT_ID, DEPARTEMEN_ID
					FROM HASIL_RAPAT_DEPARTEMEN A WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY DEPARTEMEN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(DEPARTEMEN_ID) AS ROWCOUNT FROM HASIL_RAPAT_DEPARTEMEN
		        WHERE 1 = 1 ".$statement; 
		
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
		$str = "SELECT COUNT(DEPARTEMEN_ID) AS ROWCOUNT FROM HASIL_RAPAT_DEPARTEMEN
		        WHERE 1 = 1 ".$statement; 
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