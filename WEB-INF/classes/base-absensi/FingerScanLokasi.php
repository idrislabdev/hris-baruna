<? 
/* *******************************************************************************************************
MODUL NAME 			: PEL
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel KAPAL_JENIS.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class FingerScanLokasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function FingerScanLokasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BENDERA_ID", $this->getNextId("BENDERA_ID","PPI_ABSENSI.FINGERSCAN_LOKASI"));

		$str = "
				INSERT INTO PPI_ABSENSI.FINGERSCAN_LOKASI (
				   BENDERA_ID, KODE, NAMA) 
 			  	VALUES (
				  ".$this->getField("BENDERA_ID").",
				  '".$this->getField("KODE")."',
				  '".$this->getField("NAMA")."'
				)"; 
		$this->id = $this->getField("BENDERA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_ABSENSI.FINGERSCAN_LOKASI
				SET    
					   KODE     	= '".$this->getField("KODE")."',
					   NAMA	 		= '".$this->getField("NAMA")."'
				WHERE  BENDERA_ID  	= '".$this->getField("BENDERA_ID")."'
			 "; 
		$this->query = $str;
		echo $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ABSENSI.FINGERSCAN_LOKASI
                WHERE 
                  BENDERA_ID = ".$this->getField("BENDERA_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY MESIN_ID ASC")
	{
		$str = "
				 SELECT DISTINCT MESIN_ID, NAMA_LOKASI, IP_ADDRESS, PORT, KETERANGAN
				  FROM PPI_ABSENSI.FINGERSCAN_LOKASI                  
				  WHERE 0=0
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
				  SELECT MESIN_ID, NAMA_LOKASI, IP_ADDRESS, PORT
				  FROM PPI_ABSENSI.FINGERSCAN_LOKASI                  
				  WHERE 0=0
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY MESIN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(MESIN_ID) AS ROWCOUNT FROM PPI_ABSENSI.FINGERSCAN_LOKASI 
		        WHERE 0=0 ".$statement; 
		
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
		$str = "SELECT COUNT(MESIN_ID) AS ROWCOUNT FROM PPI_ABSENSI.FINGERSCAN_LOKASI 
		        WHERE 0=0 ".$statement; 
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