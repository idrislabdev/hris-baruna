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

  class UangMil extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function UangMil()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("UANG_MIL_ID", $this->getNextId("UANG_MIL_ID","PPI_GAJI.UANG_MIL")); 
		$str = "
				INSERT INTO PPI_GAJI.UANG_MIL (UANG_MIL_ID, MIL_AWAL, MIL_AKHIR, JUMLAH) 
				VALUES(
					  ".$this->getField("UANG_MIL_ID").",
					  '".$this->getField("MIL_AWAL")."',
					  '".$this->getField("MIL_AKHIR")."',
					  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id = $this->getField("PPI_GAJI.UANG_MIL");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.UANG_MIL
			   SET 
			   		MIL_AWAL	= '".$this->getField("MIL_AWAL")."',
				   	MIL_AKHIR	= '".$this->getField("MIL_AKHIR")."',
				   	JUMLAH		= '".$this->getField("JUMLAH")."'
			 WHERE UANG_MIL_ID 	= ".$this->getField("UANG_MIL_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.UANG_MIL
                WHERE 
                  UANG_MIL_ID = ".$this->getField("UANG_MIL_ID").""; 
				  
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
				SELECT UANG_MIL_ID, MIL_AWAL, MIL_AKHIR, JUMLAH
				FROM PPI_GAJI.UANG_MIL		
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
				SELECT UANG_MIL_ID, MIL_AWAL, MIL_AKHIR, JUMLAH
				FROM PPI_GAJI.UANG_MIL		
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY UANG_MIL_ID DESC";
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
		$str = "SELECT COUNT(UANG_MIL_ID) AS ROWCOUNT FROM PPI_GAJI.UANG_MIL WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(UANG_MIL_ID) AS ROWCOUNT FROM PPI_GAJI.UANG_MIL WHERE 1 = 1 "; 
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