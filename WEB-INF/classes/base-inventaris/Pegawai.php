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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Pegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Pegawai()
	{
      $this->Entity(); 
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
				   PEGAWAI_ID, NRP, NIPP, NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, STATUS_KAWIN, GOLONGAN_DARAH, 
				   ALAMAT, TELEPON, EMAIL, FOTO, DEPARTEMEN_ID, AGAMA_ID, STATUS_PEGAWAI_ID, BANK_ID, REKENING_NO, 
				   REKENING_NAMA, NPWP, TANGGAL_PENSIUN, TANGGAL_MUTASI_KELUAR, TANGGAL_WAFAT, TANGGAL_MPP, 
				   NO_MPP, STATUS_KELUARGA_ID, FINGER_ID, LAST_CREATE_USER, LAST_CREATE_DATE, LAST_UPDATE_USER, 
				   LAST_UPDATE_DATE, JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, HOBBY, NIS, TANGGAL_NPWP, 
				   TINGGI, BERAT_BADAN, MAGANG_TIPE, KTP_NO, TGL_NON_AKTIF
				FROM PPI_ASSET.IMASYS_SIMPEG.PEGAWAI A
                WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		
		//echo $str;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsPegawaiJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
				   A.PEGAWAI_ID, NRP, A.NAMA, C.NAMA JABATAN 
				FROM PPI_ASSET.IMASYS_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_ASSET.IMASYS_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                INNER JOIN PPI_ASSET.IMASYS_SIMPEG.JABATAN C ON B.JABATAN_ID=C.JABATAN_ID
                WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		
		//echo $str;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
				COUNT(A.PEGAWAI_ID) ROWCOUNT
                FROM PPI_ASSET.IMASYS_SIMPEG.PEGAWAI A
                WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsPegawaiJabatan($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
				COUNT(A.PEGAWAI_ID) ROWCOUNT
                FROM PPI_ASSET.IMASYS_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_ASSET.IMASYS_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                INNER JOIN PPI_ASSET.IMASYS_SIMPEG.JABATAN C ON B.JABATAN_ID=C.JABATAN_ID
                WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
		
  } 
?>