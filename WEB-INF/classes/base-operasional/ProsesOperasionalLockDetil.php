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

  class ProsesOperasionalLockDetil extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function ProsesOperasionalLockDetil()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_OPERASIONAL.PROSES_OPERASIONAL_LOCK_DETIL (PERIODE, JENIS_PROSES, ID_PROSES) 
				VALUES(
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("JENIS_PROSES")."',
					  '".$this->getField("ID_PROSES")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.PROSES_OPERASIONAL_LOCK_DETIL
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
				SELECT PERIODE, JENIS_PROSES, ID_PROSES
				FROM PPI_OPERASIONAL.PROSES_OPERASIONAL_LOCK_DETIL		
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
				SELECT PERIODE, JENIS_PROSES, ID_PROSES
				FROM PPI_OPERASIONAL.PROSES_OPERASIONAL_LOCK_DETIL		
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY PROSES_OPERASIONAL_LOCK_DETIL_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
    function getProsesOperasionalLockDetil($paramsArray=array(), $statement="")
	{
		$str = "SELECT ID_PROSES
				FROM PPI_OPERASIONAL.PROSES_OPERASIONAL_LOCK_DETIL		
				WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ID_PROSES"); 
		else 
			return 0; 
    }
	
  } 
?>