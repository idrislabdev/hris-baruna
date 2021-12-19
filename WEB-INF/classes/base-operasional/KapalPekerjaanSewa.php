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

  class KapalPekerjaanSewa extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalPekerjaanSewa()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_PEKERJAAN_SEWA_ID", $this->getNextId("KAPAL_PEKERJAAN_SEWA_ID","PPI_OPERASIONAL.KAPAL_PEKERJAAN_SEWA"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_PEKERJAAN_SEWA (
				   KAPAL_PEKERJAAN_SEWA_ID, LOKASI_ID, PELANGGAN_ID, NO_KONTRAK, NAMA, JUMLAH, TANGGAL_AWAL, TANGGAL_AKHIR, TANGGAL_TANDA_TANGAN, TANGGAL_KONTRAK,
				   LAST_CREATE_USER, LAST_CREATE_DATE, KAPAL_ID_KONTRAK_1, KAPAL_ID_KONTRAK_2, JUMLAH_2, TANGGAL_ADENDUM_1, TANGGAL_ADENDUM_2, TANGGAL_ADENDUM_3,
				   NO_KONTRAK_ADENDUM_1, TANGGAL_AWAL_ADENDUM_1, TANGGAL_AKHIR_ADENDUM_1,
				   NO_KONTRAK_ADENDUM_2, TANGGAL_AWAL_ADENDUM_2, TANGGAL_AKHIR_ADENDUM_2,
				   NO_KONTRAK_ADENDUM_3, TANGGAL_AWAL_ADENDUM_3, TANGGAL_AKHIR_ADENDUM_3,
				   NO_NOVASI_1, NO_NOVASI_2, DOKUMEN_ID)
 			  	VALUES (
				  ".$this->getField("KAPAL_PEKERJAAN_SEWA_ID").",
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("PELANGGAN_ID")."',
				  '".$this->getField("NO_KONTRAK")."',
				  '".$this->getField("NAMA")."',
				  ".$this->getField("JUMLAH").",
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  ".$this->getField("TANGGAL_TANDA_TANGAN").",
				  ".$this->getField("TANGGAL_KONTRAK").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("KAPAL_ID_KONTRAK_1")."',
				  '".$this->getField("KAPAL_ID_KONTRAK_2")."',
				  ".$this->getField("JUMLAH_2").",
				  ".$this->getField("TANGGAL_ADENDUM_1").",
				  ".$this->getField("TANGGAL_ADENDUM_2").",
				  ".$this->getField("TANGGAL_ADENDUM_3").",
				  '".$this->getField("NO_KONTRAK_ADENDUM_1")."',
				  ".$this->getField("TANGGAL_AWAL_ADENDUM_1").",
				  ".$this->getField("TANGGAL_AKHIR_ADENDUM_1").",
				  '".$this->getField("NO_KONTRAK_ADENDUM_2")."',
				  ".$this->getField("TANGGAL_AWAL_ADENDUM_2").",
				  ".$this->getField("TANGGAL_AKHIR_ADENDUM_2").",
				  '".$this->getField("NO_KONTRAK_ADENDUM_3")."',
				  ".$this->getField("TANGGAL_AWAL_ADENDUM_3").",
				  ".$this->getField("TANGGAL_AKHIR_ADENDUM_3").",
				  '".$this->getField("NO_NOVASI_1")."',
				  '".$this->getField("NO_NOVASI_2")."',
				  '".$this->getField("DOKUMEN_ID")."'
				)"; 
		$this->id = $this->getField("KAPAL_PEKERJAAN_SEWA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PEKERJAAN_SEWA
				SET    
					   LOKASI_ID   		= '".$this->getField("LOKASI_ID")."',
					   PELANGGAN_ID   		= '".$this->getField("PELANGGAN_ID")."',
					   NO_KONTRAK  		= '".$this->getField("NO_KONTRAK")."',
					   NAMA	 			= '".$this->getField("NAMA")."',
					   JUMLAH			= ".$this->getField("JUMLAH").",
					   TANGGAL_AWAL		= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR				= ".$this->getField("TANGGAL_AKHIR").",
					   TANGGAL_TANDA_TANGAN= ".$this->getField("TANGGAL_TANDA_TANGAN").",
					   TANGGAL_KONTRAK= ".$this->getField("TANGGAL_KONTRAK").",
					   LAST_UPDATE_USER				= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE				= ".$this->getField("LAST_UPDATE_DATE").",
					   KAPAL_ID_KONTRAK_1= '".$this->getField("KAPAL_ID_KONTRAK_1")."',
					   KAPAL_ID_KONTRAK_2= '".$this->getField("KAPAL_ID_KONTRAK_2")."',
					   JUMLAH_2= ".$this->getField("JUMLAH_2").",
					   TANGGAL_ADENDUM_1= ".$this->getField("TANGGAL_ADENDUM_1").",
					   TANGGAL_ADENDUM_2= ".$this->getField("TANGGAL_ADENDUM_2").",
					   TANGGAL_ADENDUM_3= ".$this->getField("TANGGAL_ADENDUM_3").",
					   NO_KONTRAK_ADENDUM_1= '".$this->getField("NO_KONTRAK_ADENDUM_1")."',
					   TANGGAL_AWAL_ADENDUM_1= ".$this->getField("TANGGAL_AWAL_ADENDUM_1").",
					   TANGGAL_AKHIR_ADENDUM_1= ".$this->getField("TANGGAL_AKHIR_ADENDUM_1").",
					   NO_KONTRAK_ADENDUM_2= '".$this->getField("NO_KONTRAK_ADENDUM_2")."',
					   TANGGAL_AWAL_ADENDUM_2= ".$this->getField("TANGGAL_AWAL_ADENDUM_2").",
					   TANGGAL_AKHIR_ADENDUM_2= ".$this->getField("TANGGAL_AKHIR_ADENDUM_2").",
					   NO_KONTRAK_ADENDUM_3= '".$this->getField("NO_KONTRAK_ADENDUM_3")."',
					   TANGGAL_AWAL_ADENDUM_3= ".$this->getField("TANGGAL_AWAL_ADENDUM_3").",
					   TANGGAL_AKHIR_ADENDUM_3= ".$this->getField("TANGGAL_AKHIR_ADENDUM_3").",
					   NO_NOVASI_1= '".$this->getField("NO_NOVASI_1")."',
				  	   NO_NOVASI_2= '".$this->getField("NO_NOVASI_2")."',
					   DOKUMEN_ID= '".$this->getField("DOKUMEN_ID")."'
				WHERE  KAPAL_PEKERJAAN_SEWA_ID  = '".$this->getField("KAPAL_PEKERJAAN_SEWA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_SEWA
                WHERE 
                  KAPAL_PEKERJAAN_SEWA_ID = ".$this->getField("KAPAL_PEKERJAAN_SEWA_ID").""; 
				  
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
                  SELECT KAPAL_PEKERJAAN_SEWA_ID, A.KAPAL_ID, C.NAMA KAPAL_NAMA, A.LOKASI_ID, B.NAMA LOKASI_NAMA, NO_KONTRAK, A.NAMA, 
				  C.KAPAL_JENIS_ID, A.JUMLAH, A.TOTAL_PREMI, A.TANGGAL_AWAL, A.TANGGAL_AKHIR, A.PROSENTASE_PREMI
                  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_SEWA A
                  LEFT JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID=B.LOKASI_ID
                  LEFT JOIN PPI_OPERASIONAL.KAPAL C ON C.KAPAL_ID=A.KAPAL_ID
                  WHERE KAPAL_PEKERJAAN_SEWA_ID IS NOT NULL AND EXISTS(SELECT 1 FROM PPI_GAJI.PREMI_KAPAL_PEKERJAAN_SEWA X WHERE X.KAPAL_PEKERJAAN_SEWA_ID = A.KAPAL_PEKERJAAN_SEWA_ID)
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
				  SELECT A.KAPAL_PEKERJAAN_SEWA_ID, JUMLAH, A.KAPAL_ID, C.NAMA KAPAL_NAMA, A.LOKASI_ID, B.NAMA LOKASI_NAMA, NO_KONTRAK, A.NAMA, DOKUMEN_ID,
				  C.KAPAL_JENIS_ID, A.TANGGAL_AWAL, A.TANGGAL_AKHIR, D.NAMA PELANGGAN, D.NPWP, A.PELANGGAN_ID, A.TANGGAL_TANDA_TANGAN, A.TANGGAL_KONTRAK,
				  A.KAPAL_ID_KONTRAK_1, A.KAPAL_ID_KONTRAK_2, A.JUMLAH_2, TANGGAL_ADENDUM_1, TANGGAL_ADENDUM_2, TANGGAL_ADENDUM_3,
				  NO_KONTRAK_ADENDUM_1, TANGGAL_AWAL_ADENDUM_1, TANGGAL_AKHIR_ADENDUM_1,
				  NO_KONTRAK_ADENDUM_2, TANGGAL_AWAL_ADENDUM_2, TANGGAL_AKHIR_ADENDUM_2,
				  NO_KONTRAK_ADENDUM_3, TANGGAL_AWAL_ADENDUM_3, TANGGAL_AKHIR_ADENDUM_3,
				  (SELECT X.NAMA FROM PPI_OPERASIONAL.KAPAL X WHERE X.KAPAL_ID = A.KAPAL_ID_KONTRAK_1) KAPAL_ID_KONTRAK_1_NAMA,
				  (SELECT X.NAMA FROM PPI_OPERASIONAL.KAPAL X WHERE X.KAPAL_ID = A.KAPAL_ID_KONTRAK_2) KAPAL_ID_KONTRAK_2_NAMA,
                  CASE WHEN JUMLAH IS NULL THEN '' ELSE 'Rp ' || PPI_GAJI.KONVERSI_MATA_UANG(JUMLAH)  || '<br>' END || 
				  (SELECT X.NAMA FROM PPI_OPERASIONAL.KAPAL X WHERE X.KAPAL_ID = A.KAPAL_ID_KONTRAK_1) || 
				  CASE WHEN JUMLAH_2 IS NULL THEN '' ELSE '<br><br>Rp ' || PPI_GAJI.KONVERSI_MATA_UANG(JUMLAH_2)|| '<br>' END || 
				  (SELECT X.NAMA FROM PPI_OPERASIONAL.KAPAL X WHERE X.KAPAL_ID = A.KAPAL_ID_KONTRAK_2)  NILAI_KONTRAK,
                  CASE WHEN NO_KONTRAK_ADENDUM_1 IS NULL THEN '' ELSE 'No :<br>' END || NO_KONTRAK_ADENDUM_1 || CASE WHEN TANGGAL_ADENDUM_1 IS NULL THEN '' ELSE '<br>Tanggal Adendum :<br>' END || TANGGAL_ADENDUM_1 || CASE WHEN TANGGAL_AWAL_ADENDUM_1 IS NULL THEN '' ELSE 'Tanggal awal' END || TANGGAL_AWAL_ADENDUM_1 ||  CASE WHEN TANGGAL_AKHIR_ADENDUM_1 IS NULL THEN '' ELSE 'Tanggal akhir' END || TANGGAL_AKHIR_ADENDUM_1 INFO_TANGGAL_ADENDUM_1,
                  CASE WHEN NO_KONTRAK_ADENDUM_2 IS NULL THEN '' ELSE 'No :<br>' END || NO_KONTRAK_ADENDUM_2 || CASE WHEN TANGGAL_ADENDUM_2 IS NULL THEN '' ELSE '<br>Tanggal Adendum :<br>' END || TANGGAL_ADENDUM_2 || CASE WHEN TANGGAL_AWAL_ADENDUM_2 IS NULL THEN '' ELSE 'Tanggal awal' END || TANGGAL_AWAL_ADENDUM_2 ||  CASE WHEN TANGGAL_AKHIR_ADENDUM_2 IS NULL THEN '' ELSE 'Tanggal akhir' END || TANGGAL_AKHIR_ADENDUM_2 INFO_TANGGAL_ADENDUM_2,
                  CASE WHEN NO_KONTRAK_ADENDUM_3 IS NULL THEN '' ELSE 'No :<br>' END || NO_KONTRAK_ADENDUM_3 || CASE WHEN TANGGAL_ADENDUM_3 IS NULL THEN '' ELSE '<br>Tanggal Adendum :<br>' END || TANGGAL_ADENDUM_3 || CASE WHEN TANGGAL_AWAL_ADENDUM_3 IS NULL THEN '' ELSE 'Tanggal awal' END || TANGGAL_AWAL_ADENDUM_3 ||  CASE WHEN TANGGAL_AKHIR_ADENDUM_3 IS NULL THEN '' ELSE 'Tanggal akhir' END || TANGGAL_AKHIR_ADENDUM_3 INFO_TANGGAL_ADENDUM_3,
				  NO_NOVASI_1, NO_NOVASI_2
                  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_SEWA A
                  LEFT JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID=B.LOKASI_ID
                  LEFT JOIN PPI_OPERASIONAL.KAPAL C ON C.KAPAL_ID=A.KAPAL_ID
                  LEFT JOIN PPI_OPERASIONAL.PELANGGAN D ON A.PELANGGAN_ID = D.PELANGGAN_ID
                  WHERE KAPAL_PEKERJAAN_SEWA_ID IS NOT NULL
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
				  SELECT KAPAL_PEKERJAAN_SEWA_ID, KAPAL_ID, LOKASI_ID, NO_KONTRAK, NAMA
				  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_SEWA					
				  WHERE KAPAL_PEKERJAAN_SEWA_ID IS NOT NULL
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
		$str = "SELECT COUNT(KAPAL_PEKERJAAN_SEWA_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_SEWA
		        WHERE KAPAL_PEKERJAAN_SEWA_ID IS NOT NULL ".$statement; 
		
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
		$str = "  SELECT COUNT(A.KAPAL_PEKERJAAN_SEWA_ID) ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_SEWA A
                  LEFT JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID=B.LOKASI_ID
                  LEFT JOIN PPI_OPERASIONAL.KAPAL C ON C.KAPAL_ID=A.KAPAL_ID
                  WHERE KAPAL_PEKERJAAN_SEWA_ID IS NOT NULL AND EXISTS(SELECT 1 FROM PPI_GAJI.PREMI_KAPAL_PEKERJAAN_SEWA X WHERE X.KAPAL_PEKERJAAN_SEWA_ID = A.KAPAL_PEKERJAAN_SEWA_ID) ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_PEKERJAAN_SEWA_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_SEWA
		        WHERE KAPAL_PEKERJAAN_SEWA_ID IS NOT NULL ".$statement; 
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