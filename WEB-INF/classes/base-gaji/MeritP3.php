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

  class MeritP3 extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function MeritP3()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("MERIT_P3_ID", $this->getNextId("MERIT_P3_ID","PPI_GAJI.MERIT_P3")); 
		$str = "
				INSERT INTO PPI_GAJI.MERIT_P3 (MERIT_P3_ID, KELAS, PERIODE, JUMLAH) 
				VALUES(
					  ".$this->getField("MERIT_P3_ID").",
					  '".$this->getField("KELAS")."',
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id = $this->getField("PPI_GAJI.MERIT_P3");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.MERIT_P3
			   SET 
			   		KELAS	= '".$this->getField("KELAS")."',
				   	PERIODE	= '".$this->getField("PERIODE")."',
				   	JUMLAH	= '".$this->getField("JUMLAH")."'
			 WHERE MERIT_P3_ID = ".$this->getField("MERIT_P3_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.MERIT_P3
                WHERE 
                  MERIT_P3_ID = ".$this->getField("MERIT_P3_ID").""; 
				  
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
				SELECT MERIT_P3_ID, KELAS, PERIODE, JUMLAH
				FROM PPI_GAJI.MERIT_P3		
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
				SELECT MERIT_P3_ID, KELAS, PERIODE, JUMLAH
				FROM PPI_GAJI.MERIT_P3		
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY MERIT_P3_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(MERIT_P3_ID) AS ROWCOUNT FROM PPI_GAJI.MERIT_P3 WHERE 1 = 1 ".$statement; 
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(MERIT_P3_ID) AS ROWCOUNT FROM PPI_GAJI.MERIT_P3 WHERE 1 = 1 "; 
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