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
  * Entity-base class untuk mengimplementasikan tabel PEMINDAHAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Pemindahan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Pemindahan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEMINDAHAN_ID", $this->getNextId("PEMINDAHAN_ID","PPI_ASSET.PEMINDAHAN")); 		

		$str = "
				INSERT INTO PPI_ASSET.PEMINDAHAN (
				   PEMINDAHAN_ID, LOKASI_ID_AKHIR, 
				   KODE, NAMA, TANGGAL, KETERANGAN, UPDATED_BY, UPDATED_DATE) 
 			  	VALUES (
				  ".$this->getField("PEMINDAHAN_ID").",
				  '".$this->getField("LOKASI_ID_AKHIR")."',
				  '".$this->getField("KODE")."',
				  '".$this->getField("NAMA")."',
				  ".$this->getField("TANGGAL").",
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("UPDATED_BY")."',
				  ".$this->getField("UPDATED_DATE")."
				)"; 
		$this->id = $this->getField("PEMINDAHAN_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_ASSET.PEMINDAHAN
				SET    
					LOKASI_ID_AWAL		= '".$this->getField("LOKASI_ID_AWAL")."',
				  	LOKASI_ID_AKHIR		= '".$this->getField("LOKASI_ID_AKHIR")."',
				  	KODE				= '".$this->getField("KODE")."',
				  	NAMA				= '".$this->getField("NAMA")."',
				  	TANGGAL				= ".$this->getField("TANGGAL").",
				  	KETERANGAN			= '".$this->getField("KETERANGAN")."',
				  	UPDATED_DATE		= ".$this->getField("UPDATED_DATE").",
				  	UPDATED_BY			= '".$this->getField("UPDATED_BY")."'					   
				WHERE  PEMINDAHAN_ID     = '".$this->getField("PEMINDAHAN_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ASSET.PEMINDAHAN A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE PEMINDAHAN_ID = ".$this->getField("PEMINDAHAN_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.PEMINDAHAN
                WHERE 
                  PEMINDAHAN_ID = ".$this->getField("PEMINDAHAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PEMINDAHAN_ID DESC ")
	{
		$str = "
					SELECT 
						   PEMINDAHAN_ID, LOKASI_ID_AWAL, LOKASI_ID_AKHIR, 
						   KODE, NAMA, TANGGAL, 
						   KETERANGAN, UPDATED_BY, UPDATED_DATE
					FROM PPI_ASSET.PEMINDAHAN A WHERE PEMINDAHAN_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PEMINDAHAN_ID DESC ")
	{
		$str = "
					SELECT 
                           PEMINDAHAN_ID, A.LOKASI_ID_AWAL, B.NAMA LOKASI_AWAL, A.LOKASI_ID_AKHIR, C.NAMA LOKASI_AKHIR,
                           A.KODE, A.NAMA, TANGGAL,  
                           A.KETERANGAN, UPDATED_BY, UPDATED_DATE
                    FROM PPI_ASSET.PEMINDAHAN A 
                    LEFT JOIN PPI_ASSET.LOKASI B ON A.LOKASI_ID_AWAL=B.LOKASI_ID
                    LEFT JOIN PPI_ASSET.LOKASI C ON A.LOKASI_ID_AKHIR=C.LOKASI_ID
                    WHERE PEMINDAHAN_ID IS NOT NULL
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
						   PEMINDAHAN_ID, LOKASI_ID_AWAL, LOKASI_ID_AKHIR, 
						   KODE, NAMA, TANGGAL, 
						   KETERANGAN, UPDATED_BY, UPDATED_DATE
					FROM PPI_ASSET.PEMINDAHAN A WHERE PEMINDAHAN_ID IS NOT NULL
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
		$str = "SELECT COUNT(PEMINDAHAN_ID) AS ROWCOUNT FROM PPI_ASSET.PEMINDAHAN A
		        WHERE PEMINDAHAN_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEMINDAHAN_ID) AS ROWCOUNT 
				FROM PPI_ASSET.PEMINDAHAN A 
                LEFT JOIN PPI_ASSET.LOKASI B ON A.LOKASI_ID_AWAL=B.LOKASI_ID
                LEFT JOIN PPI_ASSET.LOKASI C ON A.LOKASI_ID_AKHIR=C.LOKASI_ID
                WHERE PEMINDAHAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEMINDAHAN_ID) AS ROWCOUNT FROM PPI_ASSET.PEMINDAHAN A
		        WHERE PEMINDAHAN_ID IS NOT NULL ".$statement; 
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