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
  * Entity-base class untuk mengimplementasikan tabel DIREKTORAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Direktorat extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Direktorat()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("DIREKTORAT_ID", $this->getNextId("DIREKTORAT_ID","DIREKTORAT")); 		

		$str = "
				INSERT INTO PPI_SIMPEG.DIREKTORAT (
				   DIREKTORAT_ID, NAMA, PELABUHAN_ID, DIREKTORAT_PARENT_ID, KETERANGAN) 
 			  	VALUES (
				  ".$this->getField("DIREKTORAT_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("PELABUHAN_ID")."',
				  '".$this->getField("DIREKTORAT_PARENT_ID")."',
				  '".$this->getField("KETERANGAN")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.DIREKTORAT
				SET    
					   NAMA           = '".$this->getField("NAMA")."',
					   PELABUHAN_ID      = '".$this->getField("PELABUHAN_ID")."',
					   DIREKTORAT_PARENT_ID    = '".$this->getField("DIREKTORAT_PARENT_ID")."',
					   KETERANGAN         = '".$this->getField("KETERANGAN")."'	   
				WHERE  DIREKTORAT_ID     = '".$this->getField("DIREKTORAT_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.DIREKTORAT
                WHERE 
                  DIREKTORAT_ID = ".$this->getField("DIREKTORAT_ID").""; 
				  
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
				SELECT DIREKTORAT_ID, NAMA, PELABUHAN_ID, DIREKTORAT_PARENT_ID, KETERANGAN
				FROM PPI_SIMPEG.DIREKTORAT
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY NAMA DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT DIREKTORAT_ID, NAMA, PELABUHAN_ID, DIREKTORAT_PARENT_ID, KETERANGAN
				FROM PPI_SIMPEG.DIREKTORAT
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(DIREKTORAT_ID) AS ROWCOUNT FROM PPI_SIMPEG.DIREKTORAT
		        WHERE DIREKTORAT_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(DIREKTORAT_ID) AS ROWCOUNT FROM PPI_SIMPEG.DIREKTORAT
		        WHERE DIREKTORAT_ID IS NOT NULL ".$statement; 
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