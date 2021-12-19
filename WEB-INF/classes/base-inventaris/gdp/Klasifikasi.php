<? 
/* *******************************************************************************************************
MODUL NAME 			: IMASYS
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel KLASIFIKASI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Klasifikasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Klasifikasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KLASIFIKASI_ID", $this->getNextId("KLASIFIKASI_ID","PPI_ASSET.KLASIFIKASI")); 		

		$str = "
				INSERT INTO PPI_ASSET.KLASIFIKASI (
				   KLASIFIKASI_ID, KLASIFIKASI_PARENT_ID, NAMA, KETERANGAN) 
 			  	VALUES (
				  KLASIFIKASI_ID_GENERATE('".$this->getField("KLASIFIKASI_ID")."'),
				  '".$this->getField("KLASIFIKASI_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."'
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_ASSET.KLASIFIKASI
				SET    
					   NAMA			= '".$this->getField("NAMA")."',
				  	   KETERANGAN	= '".$this->getField("KETERANGAN")."'				   
				WHERE  KLASIFIKASI_ID = '".$this->getField("KLASIFIKASI_ID")."'"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ASSET.KLASIFIKASI A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE KLASIFIKASI_ID = '".$this->getField("KLASIFIKASI_ID")."'
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.KLASIFIKASI
                WHERE 
                  KLASIFIKASI_ID = '".$this->getField("KLASIFIKASI_ID")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.KLASIFIKASI_ID DESC ")
	{
		$str = "
					SELECT 
						   KLASIFIKASI_ID, KLASIFIKASI_PARENT_ID, NAMA, KETERANGAN
					FROM PPI_ASSET.KLASIFIKASI A WHERE KLASIFIKASI_ID IS NOT NULL
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
		$str = "	SELECT 
						   KLASIFIKASI_ID, KLASIFIKASI_PARENT_ID, NAMA, KETERANGAN
					FROM PPI_ASSET.KLASIFIKASI A WHERE KLASIFIKASI_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY A.NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KLASIFIKASI_ID) AS ROWCOUNT FROM PPI_ASSET.KLASIFIKASI A
		        WHERE KLASIFIKASI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KLASIFIKASI_ID) AS ROWCOUNT FROM PPI_ASSET.KLASIFIKASI A
		        WHERE KLASIFIKASI_ID IS NOT NULL ".$statement; 
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