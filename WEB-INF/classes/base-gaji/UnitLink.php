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

  class UnitLink extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function UnitLink()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("UNIT_LINK_ID", $this->getNextId("UNIT_LINK_ID","PPI_GAJI.UNIT_LINK")); 
		$str = "
				INSERT INTO PPI_GAJI.UNIT_LINK (
				   UNIT_LINK_ID, KELAS, JUMLAH) 
				VALUES ( ".$this->getField("UNIT_LINK_ID").",
					  '".$this->getField("KELAS")."',
					  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id = $this->getField("UNIT_LINK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.UNIT_LINK
			   SET 
			   		KELAS  				= '".$this->getField("KELAS")."',
				   	JUMLAH				= '".$this->getField("JUMLAH")."'
			 WHERE UNIT_LINK_ID = ".$this->getField("UNIT_LINK_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.UNIT_LINK
                WHERE 
                  UNIT_LINK_ID = ".$this->getField("UNIT_LINK_ID").""; 
				  
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
				SELECT 
				UNIT_LINK_ID, KELAS, JUMLAH
				FROM PPI_GAJI.UNIT_LINK				
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
				UNIT_LINK_ID, KELAS, JUMLAH
				FROM PPI_GAJI.UNIT_LINK				
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY UNIT_LINK_ID DESC";
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
		$str = "SELECT COUNT(UNIT_LINK_ID) AS ROWCOUNT FROM PPI_GAJI.UNIT_LINK  WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(UNIT_LINK_ID) AS ROWCOUNT FROM PPI_GAJI.UNIT_LINK WHERE 1 = 1 "; 
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