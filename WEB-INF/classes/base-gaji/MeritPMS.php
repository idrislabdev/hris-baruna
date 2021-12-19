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

  class MeritPMS extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function MeritPMS()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("MERIT_PMS_ID", $this->getNextId("MERIT_PMS_ID","PPI_GAJI.MERIT_PMS")); 
		$str = "
				INSERT INTO PPI_GAJI.MERIT_PMS (MERIT_PMS_ID, PENDIDIKAN_ID, PERIODE, JUMLAH) 
				VALUES(
					  ".$this->getField("MERIT_PMS_ID").",
					  '".$this->getField("PENDIDIKAN_ID")."',
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id = $this->getField("PPI_GAJI.MERIT_PMS");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.MERIT_PMS
			   SET 
			   		PENDIDIKAN_ID	= '".$this->getField("PENDIDIKAN_ID")."',
				   	PERIODE	= '".$this->getField("PERIODE")."',
				   	JUMLAH	= '".$this->getField("JUMLAH")."'
			 WHERE MERIT_PMS_ID = ".$this->getField("MERIT_PMS_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.MERIT_PMS
                WHERE 
                  MERIT_PMS_ID = ".$this->getField("MERIT_PMS_ID").""; 
				  
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
				SELECT MERIT_PMS_ID, A.PENDIDIKAN_ID, PERIODE, JUMLAH, B.NAMA NAMA_PENDIDIKAN
				FROM PPI_GAJI.MERIT_PMS A
				LEFT JOIN PPI_SIMPEG.PENDIDIKAN B ON A.PENDIDIKAN_ID = B.PENDIDIKAN_ID 		
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
				SELECT MERIT_PMS_ID, PENDIDIKAN_ID, PERIODE, JUMLAH
				FROM PPI_GAJI.MERIT_PMS		
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY MERIT_PMS_ID DESC";
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
		$str = "SELECT COUNT(MERIT_PMS_ID) AS ROWCOUNT 
				FROM PPI_GAJI.MERIT_PMS A
				LEFT JOIN PPI_SIMPEG.PENDIDIKAN B ON A.PENDIDIKAN_ID = B.PENDIDIKAN_ID 	 WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(MERIT_PMS_ID) AS ROWCOUNT FROM PPI_GAJI.MERIT_PMS WHERE 1 = 1 "; 
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