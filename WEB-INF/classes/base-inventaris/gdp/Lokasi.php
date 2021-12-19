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
  * Entity-base class untuk mengimplementasikan tabel LOKASI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Lokasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Lokasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("LOKASI_ID", $this->getNextId("LOKASI_ID","PPI_ASSET.LOKASI")); 		

		$str = "
				INSERT INTO PPI_ASSET.LOKASI (
				   LOKASI_ID, LOKASI_PARENT_ID, KODE, NAMA, KETERANGAN, X, Y) 
 			  	VALUES (
				  LOKASI_ID_GENERATE('".$this->getField("LOKASI_ID")."'),
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("KODE")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("X")."',
				  '".$this->getField("Y")."'
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_ASSET.LOKASI
				SET    
					   KODE			= '".$this->getField("KODE")."',
				  	   NAMA			= '".$this->getField("NAMA")."',
				  	   KETERANGAN	= '".$this->getField("KETERANGAN")."',
				  	   X	= '".$this->getField("X")."',
				  	   Y	= '".$this->getField("Y")."'				   
				WHERE  LOKASI_ID = '".$this->getField("LOKASI_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ASSET.LOKASI A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE LOKASI_ID = '".$this->getField("LOKASI_ID")."'
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.LOKASI
                WHERE 
                  LOKASI_ID = '".$this->getField("LOKASI_ID")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.LOKASI_ID ASC ")
	{
		$str = "
					SELECT 
						   LOKASI_ID, LOKASI_PARENT_ID, KODE, NAMA, KETERANGAN, X, Y
					FROM PPI_ASSET.LOKASI A WHERE LOKASI_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDenah($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.LOKASI_ID ASC ")
	{
		$str = "
					SELECT 
                           LOKASI_ID, LOKASI_PARENT_ID, KODE, NAMA, KETERANGAN, X, Y, AMBIL_LOKASI_PARENT(A.LOKASI_ID) LOKASI_PARENT,
                           (SELECT COUNT(1) FROM PPI_ASSET.ARSIP X WHERE X.LOKASI_ID = A.LOKASI_ID) TOTAL_ARSIP,
                           (SELECT COUNT(1) FROM PPI_ASSET.ARSIP X WHERE X.LOKASI_ID = A.LOKASI_ID AND EXISTS(SELECT 1 FROM PPI_ASSET.ARSIP_RETENSI Y WHERE X.ARSIP_ID = Y.ARSIP_ID)) TOTAL_RETENSI,
						    AMBIL_LOKASI_KATEGORI(A.LOKASI_ID) KATEGORI_JUMLAH
                    FROM PPI_ASSET.LOKASI A WHERE LOKASI_ID IS NOT NULL
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
						   LOKASI_ID, LOKASI_PARENT_ID, KODE, NAMA, KETERANGAN
					FROM PPI_ASSET.LOKASI A WHERE LOKASI_ID IS NOT NULL
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
		$str = "SELECT COUNT(LOKASI_ID) AS ROWCOUNT FROM PPI_ASSET.LOKASI A
		        WHERE LOKASI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(LOKASI_ID) AS ROWCOUNT FROM PPI_ASSET.LOKASI A
		        WHERE LOKASI_ID IS NOT NULL ".$statement; 
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