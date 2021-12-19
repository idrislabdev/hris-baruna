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

  class KapalPekerjaan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalPekerjaan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_PEKERJAAN_ID", $this->getNextId("KAPAL_PEKERJAAN_ID","PPI_OPERASIONAL.KAPAL_PEKERJAAN"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_PEKERJAAN (
				   KAPAL_PEKERJAAN_ID, LOKASI_ID, NO_KONTRAK, NAMA, JUMLAH, TOTAL_PREMI, TANGGAL_AWAL, TANGGAL_AKHIR, TANGGAL_TANDA_TANGAN,
				   LAST_CREATE_USER, LAST_CREATE_DATE, KAPAL_PEKERJAAN_DITANGANI_ID, PROSENTASE_PREMI) 
 			  	VALUES (
				  ".$this->getField("KAPAL_PEKERJAAN_ID").",
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("NO_KONTRAK")."',
				  '".$this->getField("NAMA")."',
				  ".$this->getField("JUMLAH").",
				  ".$this->getField("TOTAL_PREMI").",
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  ".$this->getField("TANGGAL_TANDA_TANGAN").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("KAPAL_PEKERJAAN_DITANGANI_ID")."',
				  '".$this->getField("PROSENTASE_PREMI")."'
				)"; 
		$this->id = $this->getField("KAPAL_PEKERJAAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PEKERJAAN
				SET    
					   LOKASI_ID   		= '".$this->getField("LOKASI_ID")."',
					   NO_KONTRAK  		= '".$this->getField("NO_KONTRAK")."',
					   NAMA	 			= '".$this->getField("NAMA")."',
					   JUMLAH			= ".$this->getField("JUMLAH").",
					   TOTAL_PREMI		= ".$this->getField("TOTAL_PREMI").",
					   TANGGAL_AWAL		= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR				= ".$this->getField("TANGGAL_AKHIR").",
					   TANGGAL_TANDA_TANGAN= ".$this->getField("TANGGAL_TANDA_TANGAN").",
					   LAST_UPDATE_USER				= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE				= ".$this->getField("LAST_UPDATE_DATE").",
					   KAPAL_PEKERJAAN_DITANGANI_ID = '".$this->getField("KAPAL_PEKERJAAN_DITANGANI_ID")."',
					   PROSENTASE_PREMI 			= '".$this->getField("PROSENTASE_PREMI")."'
				WHERE  KAPAL_PEKERJAAN_ID  = '".$this->getField("KAPAL_PEKERJAAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN
                WHERE 
                  KAPAL_PEKERJAAN_ID = ".$this->getField("KAPAL_PEKERJAAN_ID").""; 
				  
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

	function callHitungPremiKhusus()
	{
        $str = "
				CALL PPI_GAJI.PROSES_HITUNG_PREMI_KHUSUS()
		"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }	
		
    function selectByParamsKapalKhususPremi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA ASC")
	{
		$str = "
                  SELECT A.KAPAL_PEKERJAAN_ID, A.KAPAL_ID, C.NAMA KAPAL_NAMA, A.LOKASI_ID, B.NAMA LOKASI_NAMA, NO_KONTRAK, A.NAMA, 
				  C.KAPAL_JENIS_ID, A.JUMLAH, A.TOTAL_PREMI, A.TANGGAL_AWAL, A.TANGGAL_AKHIR, A.PROSENTASE_PREMI
                  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN A 
                  LEFT JOIN PPI_OPERASIONAL.KAPAL_PEKERJAAN_KAPAL D ON A.KAPAL_PEKERJAAN_ID = D.KAPAL_PEKERJAAN_ID
                  LEFT JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID
                  LEFT JOIN PPI_OPERASIONAL.KAPAL C ON C.KAPAL_ID= D.KAPAL_ID
                  WHERE A.KAPAL_PEKERJAAN_ID IS NOT NULL AND EXISTS(SELECT 1 FROM PPI_GAJI.PREMI_KAPAL_PEKERJAAN X WHERE X.KAPAL_PEKERJAAN_ID = A.KAPAL_PEKERJAAN_ID)
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA ASC")
	{
		$str = "
				  SELECT A.KAPAL_PEKERJAAN_ID, A.KAPAL_ID, C.NAMA KAPAL_NAMA, A.LOKASI_ID, B.NAMA LOKASI_NAMA, NO_KONTRAK, A.NAMA, 
				  C.KAPAL_JENIS_ID, A.JUMLAH, A.TOTAL_PREMI, A.TANGGAL_AWAL, A.TANGGAL_AKHIR, A.PROSENTASE_PREMI, A.KAPAL_PEKERJAAN_DITANGANI_ID, D.NAMA KAPAL_PEKERJAAN_DITANGANI_NAMA, A.TANGGAL_TANDA_TANGAN
                  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN A
                  LEFT JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID=B.LOKASI_ID
                  LEFT JOIN PPI_OPERASIONAL.KAPAL C ON C.KAPAL_ID=A.KAPAL_ID
				  LEFT JOIN PPI_OPERASIONAL.KAPAL_PEKERJAAN_DITANGANI D ON A.KAPAL_PEKERJAAN_DITANGANI_ID=D.KAPAL_PEKERJAAN_DITANGANI_ID
                  WHERE KAPAL_PEKERJAAN_ID IS NOT NULL
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
				  SELECT KAPAL_PEKERJAAN_ID, KAPAL_ID, LOKASI_ID, NO_KONTRAK, NAMA
				  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN					
				  WHERE KAPAL_PEKERJAAN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_PEKERJAAN_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN
		        WHERE KAPAL_PEKERJAAN_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsKapalKhususPremi($paramsArray=array(), $statement="")
	{
		$str = "  SELECT COUNT(A.KAPAL_PEKERJAAN_ID) ROWCOUNT
                  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN A 
                  LEFT JOIN PPI_OPERASIONAL.KAPAL_PEKERJAAN_KAPAL D ON A.KAPAL_PEKERJAAN_ID = D.KAPAL_PEKERJAAN_ID
                  LEFT JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID
                  LEFT JOIN PPI_OPERASIONAL.KAPAL C ON C.KAPAL_ID= D.KAPAL_ID
                  WHERE A.KAPAL_PEKERJAAN_ID IS NOT NULL AND EXISTS(SELECT 1 FROM PPI_GAJI.PREMI_KAPAL_PEKERJAAN X WHERE X.KAPAL_PEKERJAAN_ID = A.KAPAL_PEKERJAAN_ID) ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_PEKERJAAN_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN
		        WHERE KAPAL_PEKERJAAN_ID IS NOT NULL ".$statement; 
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