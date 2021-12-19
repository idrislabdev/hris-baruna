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

  class JenisSusut extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function JenisSusut()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JENIS_SUSUT_ID", $this->getNextId("JENIS_SUSUT_ID","PPI_ASSET.JENIS_SUSUT")); 
		$str = "
				INSERT INTO PPI_ASSET.JENIS_SUSUT (
				   JENIS_SUSUT_ID,  NAMA, 
				   KETERANGAN) 
				VALUES (
						".$this->getField("JENIS_SUSUT_ID").", 
						'".$this->getField("NAMA")."', 
						'".$this->getField("KETERANGAN")."'
						)"; 
		$this->id = $this->getField("JENIS_SUSUT_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.JENIS_SUSUT
				SET    
					   NAMA                       = '".$this->getField("NAMA")."',
					   KETERANGAN                 = '".$this->getField("KETERANGAN")."'
				WHERE  JENIS_SUSUT_ID        = '".$this->getField("JENIS_SUSUT_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.JENIS_SUSUT
                WHERE 
                  JENIS_SUSUT_ID = ".$this->getField("JENIS_SUSUT_ID").""; 
				  
		$this->query = $str;
		//echo $str;
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
				SELECT 
				JENIS_SUSUT_ID,  NAMA, KETERANGAN
				FROM PPI_ASSET.JENIS_SUSUT
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
				SELECT 
				JENIS_SUSUT_ID,  NAMA, KETERANGAN
				FROM PPI_ASSET.JENIS_SUSUT
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY JENIS_SUSUT_ID DESC";
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
		$str = "SELECT COUNT(JENIS_SUSUT_ID) AS ROWCOUNT FROM PPI_ASSET.JENIS_SUSUT  WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(JENIS_SUSUT_ID) AS ROWCOUNT FROM PPI_ASSET.JENIS_SUSUT WHERE 1 = 1 "; 
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