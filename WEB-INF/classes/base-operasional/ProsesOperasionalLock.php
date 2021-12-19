<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class ProsesOperasionalLock extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function ProsesOperasionalLock()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_OPERASIONAL.PROSES_OPERASIONAL_LOCK (PERIODE, JENIS_PROSES, STATUS) 
				VALUES(
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("JENIS_PROSES")."',
					  '".$this->getField("STATUS")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.PROSES_OPERASIONAL_LOCK
                WHERE 
                  PERIODE = '".$this->getField("PERIODE")."' AND JENIS_PROSES = '".$this->getField("JENIS_PROSES")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT PERIODE, JENIS_PROSES, STATUS
				FROM PPI_OPERASIONAL.PROSES_OPERASIONAL_LOCK		
				WHERE 1 = 1
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
				SELECT PERIODE, JENIS_PROSES, STATUS
				FROM PPI_OPERASIONAL.PROSES_OPERASIONAL_LOCK		
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY PROSES_OPERASIONAL_LOCK_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
    function getProsesOperasionalLock($paramsArray=array(), $statement="")
	{
		$str = "SELECT STATUS
				FROM PPI_OPERASIONAL.PROSES_OPERASIONAL_LOCK		
				WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("STATUS"); 
		else 
			return 0; 
    }
	
	function getProsesOperasionalLockNew($statement="")
	{
		$str = "select PPI_OPERASIONAL.STATUS_LOCK_REALISASI('" . $statement ."') from dual "; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("STATUS"); 
		else 
			return 0; 
    }
	
  } 
?>