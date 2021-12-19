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

  class Satker extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Satker()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SATKER_ID", $this->getNextId("SATKER_ID","SATKER")); 
		$str = "
			INSERT INTO SATKER (
			   SATKER_ID, SATKER_ID_PARENT, KODE, 
			   NAMA, SIFAT, ALAMAT, 
			   TELEPON, FAXIMILE, KODEPOS, 
			   EMAIL) 
		  	VALUES(
				  SATKER_GENERATE('".$this->getField("SATKER_ID_PARENT")."'),
				  '".$this->getField("SATKER_ID_PARENT")."',
				  '".$this->getField("KODE")."',	
				  '".$this->getField("NAMA")."',
				  '".$this->getField("SIFAT")."',
				  '".$this->getField("ALAMAT")."',
				  '".$this->getField("TELEPON")."',
				  '".$this->getField("FAXIMILE")."',
				  '".$this->getField("KODEPOS")."',
				  '".$this->getField("EMAIL")."'
				)"; 
		$this->id = $this->getField("SATKER_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  SATKER
			   SET SATKER_ID_PARENT		= ".$this->getField("SATKER_ID_PARENT").",
				   KODE					= '".$this->getField("KODE")."',
				   NAMA					= '".$this->getField("NAMA")."',
				   SIFAT				= '".$this->getField("SIFAT")."',
				   ALAMAT				= '".$this->getField("ALAMAT")."',
				   TELEPON				= '".$this->getField("TELEPON")."',
				   FAXIMILE				= '".$this->getField("FAXIMILE")."',
				   KODEPOS				= '".$this->getField("KODEPOS")."',
				   EMAIL				= '".$this->getField("EMAIL")."'
			 WHERE SATKER_ID = ".$this->getField("SATKER_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM SATKER
                WHERE 
                  SATKER_ID_PARENT = '".$this->getField("SATKER_ID")."'"; 
		
		if($this->execQuery($str))
		{
			$str = "DELETE FROM SATKER
					WHERE 
					  SATKER_ID = '".$this->getField("SATKER_ID")."'"; 
					  
			$this->query = $str;
			return $this->execQuery($str);
		}
		else
			return false;
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
				SATKER_ID, SATKER_ID_PARENT, KODE, 
				   NAMA, SIFAT, ALAMAT, 
				   TELEPON, FAXIMILE, KODEPOS, 
				   EMAIL
				FROM SATKER
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
				SATKER_ID, SATKER_ID_PARENT, KODE, 
				   NAMA, SIFAT, ALAMAT, 
				   TELEPON, FAXIMILE, KODEPOS, 
				   EMAIL
				FROM SATKER
				WHERE 1 = 1				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY SATKER_ID DESC";
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
		$str = "SELECT COUNT(SATKER_ID) AS ROWCOUNT FROM SATKER WHERE 1 = 1 ".$statement; 
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
	
	function getSatkerById($satker_id)
	{
		$str = "SELECT NAMA AS SATKER FROM SATKER WHERE SATKER_ID = '".$satker_id."'"; 
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("SATKER"); 
		else 
			return ""; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(SATKER_ID) AS ROWCOUNT FROM SATKER WHERE 1 = 1 "; 
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