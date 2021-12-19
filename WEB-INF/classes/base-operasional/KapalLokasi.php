<? 
/* *******************************************************************************************************
MODUL NAME 			: PPI
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

  class KapalLokasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalLokasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_LOKASI_ID", $this->getNextId("KAPAL_LOKASI_ID","PPI_OPERASIONAL.KAPAL_LOKASI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_LOKASI (
				   KAPAL_LOKASI_ID, KAPAL_ID, LOKASI_ID, 
				   TANGGAL_AWAL, TANGGAL_AKHIR, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("KAPAL_LOKASI_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("LOKASI_ID")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("KAPAL_LOKASI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_LOKASI
				SET    
					   KAPAL_ID         = '".$this->getField("KAPAL_ID")."',
					   LOKASI_ID	 	= '".$this->getField("LOKASI_ID")."',
					   TANGGAL_AWAL	 	= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR	= ".$this->getField("TANGGAL_AKHIR").",
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  KAPAL_LOKASI_ID  = '".$this->getField("KAPAL_LOKASI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_LOKASI
                WHERE 
                  KAPAL_LOKASI_ID = ".$this->getField("KAPAL_LOKASI_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_LOKASI_ID ASC")
	{
		$str = "
				  SELECT KAPAL_LOKASI_ID, KAPAL_ID, A.LOKASI_ID, TANGGAL_AWAL, TANGGAL_AKHIR, B.NAMA LOKASI_NAMA, B.LATITUDE, B.LONGITUDE
				  FROM PPI_OPERASIONAL.KAPAL_LOKASI A
				  LEFT JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID=B.LOKASI_ID
				  WHERE KAPAL_LOKASI_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsTerakhir($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_LOKASI_ID ASC")
	{
		$str = "
				  SELECT KAPAL_LOKASI_ID, KAPAL_ID, A.LOKASI_ID, TANGGAL_AWAL, TANGGAL_AKHIR, B.NAMA LOKASI_NAMA, A.NAMA
				  FROM PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR A
				  LEFT JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID=B.LOKASI_ID
				  WHERE KAPAL_LOKASI_ID IS NOT NULL
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
				  SELECT KAPAL_LOKASI_ID, KAPAL_ID, LOKASI_ID, TANGGAL_AWAL, TANGGAL_AKHIR
				  FROM PPI_OPERASIONAL.KAPAL_LOKASI A			
				  WHERE KAPAL_LOKASI_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_LOKASI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_LOKASI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_LOKASI
		        WHERE KAPAL_LOKASI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_LOKASI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_LOKASI
		        WHERE KAPAL_LOKASI_ID IS NOT NULL ".$statement; 
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