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
  * Entity-base class untuk mengimplementasikan tabel BOKS_PENYIMPANAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class BoksPenyimpanan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function BoksPenyimpanan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BOKS_PENYIMPANAN_ID", $this->getNextId("BOKS_PENYIMPANAN_ID","PPI_ASSET.BOKS_PENYIMPANAN")); 		

		$str = "
				INSERT INTO PPI_ASSET.BOKS_PENYIMPANAN (
				   BOKS_PENYIMPANAN_ID, LOKASI_ID, KODE, NAMA, KETERANGAN) 
 			  	VALUES (
				  ".$this->getField("BOKS_PENYIMPANAN_ID").",
				  '".$this->getField("LOKASI_ID")."',
  				  '".$this->getField("KODE")."',
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
				UPDATE PPI_ASSET.BOKS_PENYIMPANAN
				SET    
					   LOKASI_ID 	= '".$this->getField("LOKASI_ID")."',
					   KODE 		= '".$this->getField("KODE")."',
				  	   NAMA			= '".$this->getField("NAMA")."',
				  	   KETERANGAN	= '".$this->getField("KETERANGAN")."'				   
				WHERE  BOKS_PENYIMPANAN_ID = '".$this->getField("BOKS_PENYIMPANAN_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ASSET.BOKS_PENYIMPANAN A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE BOKS_PENYIMPANAN_ID = ".$this->getField("BOKS_PENYIMPANAN_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.BOKS_PENYIMPANAN
                WHERE 
                  BOKS_PENYIMPANAN_ID = ".$this->getField("BOKS_PENYIMPANAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.BOKS_PENYIMPANAN_ID DESC ")
	{
		$str = "
					SELECT 
						   BOKS_PENYIMPANAN_ID, KODE, LOKASI_ID, NAMA, KETERANGAN
					FROM PPI_ASSET.BOKS_PENYIMPANAN A WHERE BOKS_PENYIMPANAN_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.BOKS_PENYIMPANAN_ID DESC ")
	{
		$str = "
					SELECT 
						   BOKS_PENYIMPANAN_ID, A.KODE, A.LOKASI_ID, A.NAMA, A.KETERANGAN,
                           AMBIL_LOKASI(A.LOKASI_ID) LOKASI
					FROM PPI_ASSET.BOKS_PENYIMPANAN A 
                    LEFT JOIN PPI_ASSET.LOKASI B ON A.LOKASI_ID=B.LOKASI_ID
                    WHERE BOKS_PENYIMPANAN_ID IS NOT NULL
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
						   BOKS_PENYIMPANAN_ID, KODE, LOKASI_ID, NAMA, KETERANGAN
					FROM PPI_ASSET.BOKS_PENYIMPANAN A WHERE BOKS_PENYIMPANAN_ID IS NOT NULL
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
		$str = "SELECT COUNT(BOKS_PENYIMPANAN_ID) AS ROWCOUNT FROM PPI_ASSET.BOKS_PENYIMPANAN A
		        WHERE BOKS_PENYIMPANAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(BOKS_PENYIMPANAN_ID) AS ROWCOUNT FROM PPI_ASSET.BOKS_PENYIMPANAN A 
                LEFT JOIN PPI_ASSET.LOKASI B ON A.LOKASI_ID=B.LOKASI_ID
		        WHERE BOKS_PENYIMPANAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(BOKS_PENYIMPANAN_ID) AS ROWCOUNT FROM PPI_ASSET.BOKS_PENYIMPANAN A
		        WHERE BOKS_PENYIMPANAN_ID IS NOT NULL ".$statement; 
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