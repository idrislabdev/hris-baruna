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

  class IjinKoreksi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function IjinKoreksi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("IJIN_ID", $this->getNextId("IJIN_ID","PPI_ABSENSI.IJIN")); 
		$str = "
				INSERT INTO PPI_ABSENSI.IJIN (
				   IJIN_ID, NAMA, KETERANGAN) 
				VALUES(
					  ".$this->getField("IJIN_ID").",
					  '".$this->getField("NAMA")."',
					  '".$this->getField("KETERANGAN")."'
				)"; 
		$this->id = $this->getField("IJIN_ID");
		$this->query = $str;
		echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PPI_ABSENSI.IJIN
			   SET NAMA         = '".$this->getField("NAMA")."',
				   KETERANGAN	= '".$this->getField("KETERANGAN")."'
			 WHERE IJIN_ID = ".$this->getField("IJIN_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_ABSENSI.IJIN
                WHERE 
                  IJIN_ID = ".$this->getField("IJIN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY IJIN_KOREKSI_ID ASC")
	{
		$str = "
				SELECT 
				IJIN_KOREKSI_ID, KODE, NAMA
				FROM PPI_ABSENSI.IJIN_KOREKSI
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
				IJIN_ID, NAMA, KETERANGAN
				FROM PPI_ABSENSI.IJIN
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY IJIN_ID DESC";
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
		$str = "SELECT COUNT(IJIN_ID) AS ROWCOUNT FROM PPI_ABSENSI.IJIN WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		$this->query = $str;
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(IJIN_ID) AS ROWCOUNT FROM PPI_ABSENSI.IJIN WHERE 1 = 1 "; 
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