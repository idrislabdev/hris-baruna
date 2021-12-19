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

  class PerhitunganPrestasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PerhitunganPrestasi()
	{
      $this->Entity(); 
    }

    function callSinkronisasiPrestasi()
	{
        $str = "
				CALL PPI_GAJI.KALKULASI_PRESTASI('".$this->getField("PERIODE")."')
		"; 
				  
		$this->query = $str;
		// echo $str; exit;
        return $this->execQuery($str);
    }	

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY B.PEGAWAI_ID ")
	{
		$str = "
                SELECT 
                A.PEGAWAI_ID, A.PERIODE, A.KELAS, 
                   MIN_JAM_MENGAJAR, JUMLAH_JAM_MENGAJAR, JUMLAH_JAM_LEBIH, 
                   TARIF_MENGAJAR, TARIF_LEBIH, TOTAL_TUNJANGAN, 
                   JUMLAH_POTONGAN, PEMBAGI_POTONGAN, TUNJANGAN_PRESTASI, 
                   TOTAL_POTONGAN, A.STATUS_CALPEG, A.LAST_CREATE_USER, 
                   A.LAST_CREATE_DATE, A.LAST_UPDATE_USER, A.LAST_UPDATE_DATE, 
				   B.NAMA NAMA_PEGAWAI
                FROM PPI_GAJI.PERHITUNGAN_PRESTASI A
                LEFT JOIN PPI_GAJI.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND A.PERIODE = B.PERIODE
                WHERE 1=1   
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str; exit();
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
			     SELECT 
				PEGAWAI_ID, PERIODE, KELAS, 
				   MIN_JAM_MENGAJAR, JUMLAH_JAM_MENGAJAR, JUMLAH_JAM_LEBIH, 
				   TARIF_MENGAJAR, TARIF_LEBIH, TOTAL_TUNJANGAN, 
				   JUMLAH_POTONGAN, PEMBAGI_POTONGAN, TUNJANGAN_PRESTASI, 
				   TOTAL_POTONGAN, STATUS_CALPEG, LAST_CREATE_USER, 
				   LAST_CREATE_DATE, LAST_UPDATE_USER, LAST_UPDATE_DATE
				FROM PPI_GAJI.PERHITUNGAN_PRESTASI A
				WHERE 1=1 
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY PEGAWAI_ID DESC";
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
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT 
		FROM PPI_GAJI.PERHITUNGAN_PRESTASI A
		LEFT JOIN PPI_GAJI.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND A.PERIODE = B.PERIODE
		WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		// echo $str; exit();
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.PERHITUNGAN_PRESTASI WHERE 1 = 1 "; 
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