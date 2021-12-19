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
  * Entity-base class untuk mengimplementasikan tabel KATEGORI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Kategori extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Kategori()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KATEGORI_ID", $this->getNextId("KATEGORI_ID","PPI_ASSET.KATEGORI")); 		

		$str = "
				INSERT INTO PPI_ASSET.KATEGORI (
				   KATEGORI_ID, BATAS_RETENSI_BULAN, NAMA, KETERANGAN) 
 			  	VALUES (
				  ".$this->getField("KATEGORI_ID").",
				  ".$this->getField("BATAS_RETENSI_BULAN").",
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
				UPDATE PPI_ASSET.KATEGORI
				SET    
					   BATAS_RETENSI_BULAN 	= ".$this->getField("BATAS_RETENSI_BULAN").",
				  	   NAMA			= '".$this->getField("NAMA")."',
				  	   KETERANGAN	= '".$this->getField("KETERANGAN")."'				   
				WHERE  KATEGORI_ID = '".$this->getField("KATEGORI_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ASSET.KATEGORI A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE KATEGORI_ID = ".$this->getField("KATEGORI_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.KATEGORI
                WHERE 
                  KATEGORI_ID = ".$this->getField("KATEGORI_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.KATEGORI_ID DESC ")
	{
		$str = "
					SELECT 
						   KATEGORI_ID, BATAS_RETENSI_BULAN, NAMA, KETERANGAN
					FROM PPI_ASSET.KATEGORI A WHERE KATEGORI_ID IS NOT NULL
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
						   KATEGORI_ID, BATAS_RETENSI_BULAN, NAMA, KETERANGAN
					FROM PPI_ASSET.KATEGORI A WHERE KATEGORI_ID IS NOT NULL
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
		$str = "SELECT COUNT(KATEGORI_ID) AS ROWCOUNT FROM PPI_ASSET.KATEGORI A
		        WHERE KATEGORI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KATEGORI_ID) AS ROWCOUNT FROM PPI_ASSET.KATEGORI A
		        WHERE KATEGORI_ID IS NOT NULL ".$statement; 
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