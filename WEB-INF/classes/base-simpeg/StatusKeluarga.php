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
  * Entity-base class untuk mengimplementasikan tabel UNIVERSITAS.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class StatusKeluarga extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function StatusKeluarga()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("STATUS_KELUARGA_ID", $this->getNextId("STATUS_KELUARGA_ID","PPI_SIMPEG.STATUS_KELUARGA")); 		

		$str = "
				INSERT INTO PPI_SIMPEG.STATUS_KELUARGA (
				   STATUS_KELUARGA_ID, NAMA, KODE, KETERANGAN) 
 			  	VALUES (
				  ".$this->getField("STATUS_KELUARGA_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KODE")."',
				  '".$this->getField("KETERANGAN")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.STATUS_KELUARGA
				SET    
					   NAMA           = '".$this->getField("NAMA")."',
					   KETERANGAN    = '".$this->getField("KETERANGAN")."',
					   KODE    = '".$this->getField("KODE")."'
				WHERE  STATUS_KELUARGA_ID     = '".$this->getField("STATUS_KELUARGA_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.STATUS_KELUARGA
                WHERE 
                  STATUS_KELUARGA_ID = ".$this->getField("STATUS_KELUARGA_ID").""; 
				  
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
				SELECT STATUS_KELUARGA_ID, NAMA, KETERANGAN, KODE
				FROM PPI_SIMPEG.STATUS_KELUARGA
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY STATUS_KELUARGA_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT STATUS_KELUARGA_ID, NAMA, KETERANGAN, KODE
				FROM PPI_SIMPEG.STATUS_KELUARGA
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
		$str = "SELECT COUNT(STATUS_KELUARGA_ID) AS ROWCOUNT FROM PPI_SIMPEG.STATUS_KELUARGA
		        WHERE STATUS_KELUARGA_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(STATUS_KELUARGA_ID) AS ROWCOUNT FROM PPI_SIMPEG.STATUS_KELUARGA
		        WHERE STATUS_KELUARGA_ID IS NOT NULL ".$statement; 
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