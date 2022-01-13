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
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_ID", $this->getNextId("PEGAWAI_ID","PPI_SIMPEG.PEGAWAI")); 		
		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI (
				   PEGAWAI_ID, NAMA, NIPP, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, TANGGAL_MASUK, 
				   STATUS_KAWIN, GOLONGAN_DARAH, ALAMAT, 
   				   TELEPON, EMAIL, NRP, DEPARTEMEN_ID, AGAMA_ID, STATUS_PEGAWAI_ID, BANK_ID, REKENING_NO, REKENING_NAMA, NPWP, TANGGAL_PENSIUN, TANGGAL_MUTASI_KELUAR, TANGGAL_WAFAT, TANGGAL_MPP, NO_MPP, STATUS_KELUARGA_ID, LAST_CREATE_USER, LAST_CREATE_DATE,
				   JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, HOBBY, FINGER_ID, TANGGAL_NPWP, TINGGI, BERAT_BADAN, KTP_NO, TGL_NON_AKTIF, LOKASI_ID,
				   BIDANG_STUDI, LINERITAS, SPESIFIKASI_PRESTASI_KARYA,TUGAS_PEMBIMBINGAN) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NIPP")."',
				  '".$this->getField("JENIS_KELAMIN")."',
				  '".$this->getField("TEMPAT_LAHIR")."',
				  ".$this->getField("TANGGAL_LAHIR").",
				    ".$this->getField("TANGGAL_MASUK").",
				  '".$this->getField("STATUS_KAWIN")."',
				  '".$this->getField("GOLONGAN_DARAH")."',
				  '".$this->getField("ALAMAT")."',
				  '".$this->getField("TELEPON")."',
				  '".$this->getField("EMAIL")."',
				  '".$this->getField("NRP")."',
				  ".$this->getField("DEPARTEMEN_ID").",
				  '".$this->getField("AGAMA_ID")."',
				  '".$this->getField("STATUS_PEGAWAI_ID")."',
				  '".$this->getField("BANK_ID")."',
				  '".$this->getField("REKENING_NO")."',
				  '".$this->getField("REKENING_NAMA")."',
				  '".$this->getField("NPWP")."',
				  ".$this->getField("TANGGAL_PENSIUN").",
				  ".$this->getField("TANGGAL_MUTASI_KELUAR").",
				  ".$this->getField("TANGGAL_WAFAT").",
				  ".$this->getField("TANGGAL_MPP").",
				  '".$this->getField("NO_MPP")."',
				  ".$this->getField("STATUS_KELUARGA_ID").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("JAMSOSTEK_NO")."',
				  ".$this->getField("JAMSOSTEK_TANGGAL").",
				  '".$this->getField("HOBBY")."',
				  '".$this->getField("FINGER_ID")."',
				  ".$this->getField("TANGGAL_NPWP").",
				  '".$this->getField("TINGGI")."',
				  '".$this->getField("BERAT_BADAN")."',
				  '".$this->getField("KTP_NO")."',
				  ".$this->getField("TGL_NON_AKTIF").",
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("BIDANG_STUDI")."',
				  '".$this->getField("LINERITAS")."',
				  '".$this->getField("SPESIFIKASI_PRESTASI_KARYA")."',
				  '".$this->getField("TUGAS_PEMBIMBINGAN")."'
				)"; 
		$this->id = $this->getField("PEGAWAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function insertKadet()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_ID", $this->getNextId("PEGAWAI_ID","PPI_SIMPEG.PEGAWAI")); 		
		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI (
				   PEGAWAI_ID, NAMA, NIS, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, 
				   ALAMAT, 
   				   TELEPON, EMAIL, DEPARTEMEN_ID, AGAMA_ID, STATUS_PEGAWAI_ID, BANK_ID, MAGANG_TIPE, LAST_CREATE_USER, LAST_CREATE_DATE
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NIS")."',
				  '".$this->getField("JENIS_KELAMIN")."',
				  '".$this->getField("TEMPAT_LAHIR")."',
				  ".$this->getField("TANGGAL_LAHIR").",
				  '".$this->getField("ALAMAT")."',
				  '".$this->getField("TELEPON")."',
				  '".$this->getField("EMAIL")."',
				  ".$this->getField("DEPARTEMEN_ID").",
				  '".$this->getField("AGAMA_ID")."',
				  '".$this->getField("STATUS_PEGAWAI_ID")."',
				  '".$this->getField("BANK_ID")."',
				  '".$this->getField("MAGANG_TIPE")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."	  
				)"; 
		$this->id = $this->getField("PEGAWAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function importKadet()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_ID", $this->getNextId("PEGAWAI_ID","PPI_SIMPEG.PEGAWAI")); 		
		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI (
				   PEGAWAI_ID, NAMA, NIS, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, TANGGAL_MASUK, 
				   ALAMAT, 
   				   TELEPON, EMAIL, DEPARTEMEN_ID, AGAMA_ID, STATUS_PEGAWAI_ID, BANK_ID, MAGANG_TIPE
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NIS")."',
				  '".$this->getField("JENIS_KELAMIN")."',
				  '".$this->getField("TEMPAT_LAHIR")."',
				  ".$this->getField("TANGGAL_LAHIR").",
				  ".$this->getField("TANGGAL_MASUK").",
				  '".$this->getField("ALAMAT")."',
				  '".$this->getField("TELEPON")."',
				  '".$this->getField("EMAIL")."',
				  ".$this->getField("DEPARTEMEN_ID").",
				  '".$this->getField("AGAMA_ID")."',
				  '".$this->getField("STATUS_PEGAWAI_ID")."',
				  '".$this->getField("BANK_ID")."',
				  '".$this->getField("MAGANG_TIPE")."'	  
				)"; 
		$this->id = $this->getField("PEGAWAI_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI
				SET    
					   NAMA           			= '".$this->getField("NAMA")."',
					   NIPP      				= '".$this->getField("NIPP")."',
					   JENIS_KELAMIN    		= '".$this->getField("JENIS_KELAMIN")."',
					   TEMPAT_LAHIR     		= '".$this->getField("TEMPAT_LAHIR")."',
					   TANGGAL_LAHIR			= ".$this->getField("TANGGAL_LAHIR").",
					   TANGGAL_MASUK			= ".$this->getField("TANGGAL_MASUK").",
					   STATUS_KAWIN				= '".$this->getField("STATUS_KAWIN")."',
					   GOLONGAN_DARAH			= '".$this->getField("GOLONGAN_DARAH")."',
					   ALAMAT					= '".$this->getField("ALAMAT")."',
					   TELEPON					= '".$this->getField("TELEPON")."',
					   EMAIL					= '".$this->getField("EMAIL")."',
					   NRP						= '".$this->getField("NRP")."',
					   DEPARTEMEN_ID			= ".$this->getField("DEPARTEMEN_ID").",
					   AGAMA_ID					= '".$this->getField("AGAMA_ID")."',
					   STATUS_PEGAWAI_ID		= '".$this->getField("STATUS_PEGAWAI_ID")."',
					   BANK_ID					= '".$this->getField("BANK_ID")."',
					   REKENING_NO				= '".$this->getField("REKENING_NO")."',
					   REKENING_NAMA			= '".$this->getField("REKENING_NAMA")."',
					   NPWP						= '".$this->getField("NPWP")."',
					   TANGGAL_PENSIUN			= ".$this->getField("TANGGAL_PENSIUN").",
					   TANGGAL_MUTASI_KELUAR	= ".$this->getField("TANGGAL_MUTASI_KELUAR").",
					   TANGGAL_WAFAT			= ".$this->getField("TANGGAL_WAFAT").",
					   TANGGAL_MPP				= ".$this->getField("TANGGAL_MPP").",
				  	   NO_MPP					= '".$this->getField("NO_MPP")."',
					   STATUS_KELUARGA_ID		= ".$this->getField("STATUS_KELUARGA_ID").",
						LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
						LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE").",
						JAMSOSTEK_NO			= '".$this->getField("JAMSOSTEK_NO")."',
						JAMSOSTEK_TANGGAL		= ".$this->getField("JAMSOSTEK_TANGGAL").",
					   HOBBY					= '".$this->getField("HOBBY")."',
					   FINGER_ID					= '".$this->getField("FINGER_ID")."',
					   TANGGAL_NPWP				= ".$this->getField("TANGGAL_NPWP").",
					   TINGGI= '".$this->getField("TINGGI")."',
				  	   BERAT_BADAN= '".$this->getField("BERAT_BADAN")."',
					   KTP_NO= '".$this->getField("KTP_NO")."',
					   TGL_NON_AKTIF = ".$this->getField("TGL_NON_AKTIF").",
					   LOKASI_ID = '".$this->getField("LOKASI_ID")."',
					   BIDANG_STUDI					= '".$this->getField("BIDANG_STUDI")."',
					   LINERITAS					= '".$this->getField("LINERITAS")."',
					   SPESIFIKASI_PRESTASI_KARYA					= '".$this->getField("SPESIFIKASI_PRESTASI_KARYA")."',
					   TUGAS_PEMBIMBINGAN					= '".$this->getField("TUGAS_PEMBIMBINGAN")."' 
				WHERE  PEGAWAI_ID     			= '".$this->getField("PEGAWAI_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		return $this->execQuery($str);
    }


	function updateKadetDepartemen()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI
				SET    
					   DEPARTEMEN_ID			= '".$this->getField("DEPARTEMEN_ID")."',
					   STATUS_PEGAWAI_ID		= '1'
				WHERE  PEGAWAI_ID     			= '".$this->getField("PEGAWAI_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		return $this->execQuery($str);
    }

	
	
	
	function updateKadet()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI
				SET    
					   NAMA           			= '".$this->getField("NAMA")."',
					   NIS      				= '".$this->getField("NIS")."',
					   JENIS_KELAMIN    		= '".$this->getField("JENIS_KELAMIN")."',
					   TEMPAT_LAHIR     		= '".$this->getField("TEMPAT_LAHIR")."',
					   TANGGAL_LAHIR			= ".$this->getField("TANGGAL_LAHIR").",
					   TANGGAL_MASUK		= ".$this->getField("TANGGAL_MASUK").",
					   ALAMAT					= '".$this->getField("ALAMAT")."',
					   TELEPON					= '".$this->getField("TELEPON")."',
					   EMAIL					= '".$this->getField("EMAIL")."',
					   DEPARTEMEN_ID			= ".$this->getField("DEPARTEMEN_ID").",
					   AGAMA_ID					= '".$this->getField("AGAMA_ID")."',
					   STATUS_PEGAWAI_ID		= '".$this->getField("STATUS_PEGAWAI_ID")."',
					   BANK_ID					= '".$this->getField("BANK_ID")."',
					   MAGANG_TIPE				= '".$this->getField("MAGANG_TIPE")."',
						LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
						LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_ID     			= '".$this->getField("PEGAWAI_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateStatusMPP()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI
				SET
					   STATUS_PEGAWAI_ID	= 5,
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_ID     		= '".$this->getField("PEGAWAI_ID")."'
			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateMPP()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI
				SET
					   STATUS_PEGAWAI_ID		= 5,
					   TANGGAL_MPP				= ".$this->getField("TANGGAL_MPP").",
				  	   NO_MPP					= '".$this->getField("NO_MPP")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_ID     		= '".$this->getField("PEGAWAI_ID")."'
			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateDepartemen()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI
				SET
					   DEPARTEMEN_ID		= '".$this->getField("DEPARTEMEN_ID")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_ID     		= '".$this->getField("PEGAWAI_ID")."'
			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }

	function updateMutasiKeluar()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI
				SET
					   STATUS_PEGAWAI_ID	 = 3,
					   TANGGAL_MUTASI_KELUAR = ".$this->getField("TANGGAL_MUTASI_KELUAR").",
					   LAST_UPDATE_USER		 = '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		 = ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_ID     		 = '".$this->getField("PEGAWAI_ID")."'
			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }	
	

	function updateStatus()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI
				SET
					   STATUS_PEGAWAI_ID	 = '".$this->getField("STATUS_PEGAWAI_ID")."'
				WHERE  PEGAWAI_ID     		 = '".$this->getField("PEGAWAI_ID")."'
			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }	

	function updateMutasiMasuk()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI
				SET
					   STATUS_PEGAWAI_ID	 = 1,
					   TANGGAL_MUTASI_KELUAR = NULL,
					   LAST_UPDATE_USER		 = '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		 = ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_ID     		 = '".$this->getField("PEGAWAI_ID")."'
			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }	
		

	function updatePensiun()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI
				SET
					   STATUS_PEGAWAI_ID	 = 2,
					   TANGGAL_PENSIUN 	     = ".$this->getField("TANGGAL_PENSIUN").",
					   LAST_UPDATE_USER		 = '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		 = ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_ID     		 = '".$this->getField("PEGAWAI_ID")."'
			 ";
		$this->query = $str;
		return $this->execQuery($str);
    }	
		
				
	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI
                WHERE 
                  PEGAWAI_ID = ".$this->getField("PEGAWAI_ID").""; 
				  
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
	
	function selectByParamsDepartemen($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
					A.PEGAWAI_ID, A.DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN
            	FROM PPI_SIMPEG.PEGAWAI A
            	WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
	
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsFoto($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
					FOTO, JENIS_KELAMIN
            	FROM PPI_SIMPEG.PEGAWAI A
            	WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		
	function selectByParamsPotonganPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		/*$str = "
			SELECT PEGAWAI_ID, NRP, NIPP, NAMA, JABATAN, KELAS, JENIS_PEGAWAI_ID, KELOMPOK,  NO_URUT, STATUS_PEGAWAI_ID,
				   PPI_SIMPEG.AMBIL_UNIT_KERJA (DEPARTEMEN_ID) DEPARTEMEN,
					   LTRIM(MAX( SYS_CONNECT_BY_PATH ( POTONGAN, ', ')),', ') POTONGAN
				FROM
				(SELECT A.PEGAWAI_ID, NRP, NIPP, A.NAMA, B.NAMA JABATAN, B.KELAS,
                   E.JENIS_PEGAWAI_ID, B.KELOMPOK, NO_URUT, STATUS_PEGAWAI_ID,
                   A.DEPARTEMEN_ID, D.NAMA POTONGAN, row_number() OVER ( PARTITION BY A.PEGAWAI_ID  ORDER BY rownum) rn 
				  FROM PPI_SIMPEG.PEGAWAI A 
				  INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				  LEFT JOIN PPI_GAJI.POTONGAN_KONDISI_PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				  LEFT JOIN PPI_GAJI.POTONGAN_KONDISI D ON C.POTONGAN_KONDISI_ID = D.POTONGAN_KONDISI_ID
				  INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR E ON A.PEGAWAI_ID = E.PEGAWAI_ID
				  INNER JOIN PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI F ON F.POTONGAN_KONDISI_ID = C.POTONGAN_KONDISI_ID AND 
                                                                             E.JENIS_PEGAWAI_ID = F.JENIS_PEGAWAI_ID AND 
                                                                             F.KELOMPOK = B.KELOMPOK 
                                                                             AND JENIS_POTONGAN = 'P'
				) A WHERE 1 = 1
			"; */
			$str = "
			SELECT PEGAWAI_ID, NRP, NIPP, NAMA, JABATAN, KELAS, JENIS_PEGAWAI_ID, KELOMPOK,  NO_URUT, STATUS_PEGAWAI_ID,
				   PPI_SIMPEG.AMBIL_UNIT_KERJA (DEPARTEMEN_ID) DEPARTEMEN,
					   '' POTONGAN
				FROM
				(SELECT A.PEGAWAI_ID, NRP, NIPP, A.NAMA, B.NAMA JABATAN, B.KELAS,
                   E.JENIS_PEGAWAI_ID, B.KELOMPOK, NO_URUT, STATUS_PEGAWAI_ID,
                   A.DEPARTEMEN_ID, D.NAMA POTONGAN, row_number() OVER ( PARTITION BY A.PEGAWAI_ID  ORDER BY rownum) rn 
				  FROM PPI_SIMPEG.PEGAWAI A 
				  LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				  LEFT JOIN PPI_GAJI.POTONGAN_KONDISI_PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				  LEFT JOIN PPI_GAJI.POTONGAN_KONDISI D ON C.POTONGAN_KONDISI_ID = D.POTONGAN_KONDISI_ID
				  LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR E ON A.PEGAWAI_ID = E.PEGAWAI_ID
				  LEFT JOIN PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI F ON F.POTONGAN_KONDISI_ID = C.POTONGAN_KONDISI_ID AND 
                                                                             E.JENIS_PEGAWAI_ID = F.JENIS_PEGAWAI_ID AND 
                                                                             F.KELOMPOK = B.KELOMPOK 
                                                                             AND JENIS_POTONGAN = 'P'
				) A WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
/*		$str .= " CONNECT  BY  PEGAWAI_ID = PRIOR PEGAWAI_ID
							AND  rn     = PRIOR rn+1
					START WITH rn =1
				   GROUP BY PEGAWAI_ID, NRP, NIPP, NAMA, JABATAN, DEPARTEMEN_ID, NO_URUT, STATUS_PEGAWAI_ID, KELAS, JENIS_PEGAWAI_ID, KELOMPOK ".$sOrder;
	*/	$str .= " GROUP BY PEGAWAI_ID, NRP, NIPP, NAMA, JABATAN, DEPARTEMEN_ID, NO_URUT, STATUS_PEGAWAI_ID, KELAS, JENIS_PEGAWAI_ID, KELOMPOK ".$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		//echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	function selectByParamsDepartemenJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
					A.PEGAWAI_ID, A.DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN, B.JABATAN_ID, B.NAMA JABATAN
            	FROM PPI_SIMPEG.PEGAWAI A INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
            	WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
                D.KELAS, D.NAMA JABATAN_NAMA, MASA_KERJA_TAHUN || '-' || MASA_KERJA_BULAN MKP, A.PEGAWAI_ID, NRP, NIPP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, PPI_SIMPEG.AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN, STATUS_KAWIN STATUS_KAWIN_ID,GOLONGAN_DARAH, A.ALAMAT, TELEPON, EMAIL,
                A.DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN, A.AGAMA_ID, C.NAMA AGAMA_NAMA, A.STATUS_PEGAWAI_ID, A.BANK_ID, REKENING_NO, REKENING_NAMA, NPWP, E.NAMA STATUS_PEGAWAI_NAMA,
                TANGGAL_PENSIUN as TANGGAL_PENSIUNold, TANGGAL_MUTASI_KELUAR, TANGGAL_WAFAT, TANGGAL_MPP, NO_MPP, STATUS_KELUARGA_ID, JENIS_PEGAWAI_ID, G.JENIS_PEGAWAI_NAMA, KELOMPOK, JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, HOBBY, A.NIS, FINGER_ID, TANGGAL_NPWP,
                TINGGI, BERAT_BADAN, TANGGAL_KONTRAK_AWAL, TANGGAL_KONTRAK_AKHIR, G.PEGAWAI_JENIS_PEGAWAI_ID, MAGANG_TIPE, G.JENIS_PEGAWAI_NAMA JENIS_PEGAWAI, KTP_NO, TGL_NON_AKTIF,
                '' ASAL_SEKOLAH, '' KELAS_SEKOLAH, JURUSAN, TRIM(I.TINGKAT_PENDIDIKAN) AS PENDIDIKAN_TERAKHIR, TRUNC (MONTHS_BETWEEN (SYSDATE, TANGGAL_LAHIR) / 12)  AS UMUR,
                TO_CHAR(TANGGAL_LAHIR, 'DD MONTH YYYY', 'NLS_DATE_LANGUAGE = INDONESIAN') AS TANGGAL_LAHIR_TEK, A.LOKASI_ID, TANGGAL_MASUK  ,BIDANG_STUDI , LINERITAS , SPESIFIKASI_PRESTASI_KARYA , TUGAS_PEMBIMBINGAN   , F.NAMA NAMA_BANK   
				, CAST(  COALESCE ((CASE WHEN ISNUMERIC(A.HOBBY)=1 THEN A.HOBBY ELSE '0'  END),'0')   AS INT) UMUR_PENSIUN , 
				ADD_MONTHS(TANGGAL_LAHIR, CAST(  COALESCE ((CASE WHEN ISNUMERIC(A.HOBBY)=1 THEN A.HOBBY ELSE '0'  END),'0')   AS INT)  *12) TANGGAL_PENSIUN, 
				  TRUNC( MONTHS_BETWEEN (TO_DATE (CURRENT_DATE), TO_DATE (TANGGAL_MASUK)) /12)   MASA_KERJA    
				FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PENGHASILAN_TERAKHIR H ON A.PEGAWAI_ID = H.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PENDIDIKAN_TERAKHIR I ON A.PEGAWAI_ID = I.PEGAWAI_ID 
                WHERE 1 = 1 
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }


 

    function selectByParamsSiswa($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
                D.KELAS, D.NAMA JABATAN_NAMA, MASA_KERJA_TAHUN || '-' || MASA_KERJA_BULAN MKP, A.PEGAWAI_ID, NRP, NIPP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, PPI_SIMPEG.AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN, STATUS_KAWIN STATUS_KAWIN_ID,GOLONGAN_DARAH, A.ALAMAT, TELEPON, EMAIL,
                A.DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN, A.AGAMA_ID, C.NAMA AGAMA_NAMA, A.STATUS_PEGAWAI_ID, A.BANK_ID, REKENING_NO, REKENING_NAMA, NPWP, E.NAMA STATUS_PEGAWAI_NAMA,
                TANGGAL_PENSIUN, TANGGAL_MUTASI_KELUAR, TANGGAL_WAFAT, TANGGAL_MPP, NO_MPP, STATUS_KELUARGA_ID, JENIS_PEGAWAI_ID, G.JENIS_PEGAWAI_NAMA, KELOMPOK, JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, HOBBY, A.NIS, FINGER_ID, TANGGAL_NPWP,
                TINGGI, BERAT_BADAN, TANGGAL_KONTRAK_AWAL, TANGGAL_KONTRAK_AKHIR, G.PEGAWAI_JENIS_PEGAWAI_ID, KELAS_SEKOLAH, G.JENIS_PEGAWAI_NAMA JENIS_PEGAWAI, KTP_NO, TGL_NON_AKTIF,
                '' ASAL_SEKOLAH, JURUSAN, TRIM(I.TINGKAT_PENDIDIKAN) AS PENDIDIKAN_TERAKHIR, TRUNC (MONTHS_BETWEEN (SYSDATE, TANGGAL_LAHIR) / 12)  AS UMUR,
                TO_CHAR(TANGGAL_LAHIR, 'DD MONTH YYYY', 'NLS_DATE_LANGUAGE = INDONESIAN') AS TANGGAL_LAHIR_TEK, A.LOKASI_ID, TO_CHAR(TANGGAL_LAHIR, 'YYYYMMDD') TANGGAL_LAHIR_EKS,
                TO_CHAR(G.TMT_JENIS_PEGAWAI, 'YYYYMMDD') TMT_JENIS_PEGAWAI_EKS, G.DEPARTEMEN_KELAS_ID, J.NAMA DEPARTEMEN_KELAS, G.JUMLAH_SPP
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PENGHASILAN_TERAKHIR H ON A.PEGAWAI_ID = H.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PENDIDIKAN_TERAKHIR I ON A.PEGAWAI_ID = I.PEGAWAI_ID 
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN_KELAS J ON A.DEPARTEMEN_ID = J.DEPARTEMEN_ID AND G.DEPARTEMEN_KELAS_ID = J.DEPARTEMEN_KELAS_ID
                WHERE 1 = 1 
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		// echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsNew($paramsArray=array(), $limit=-1, $from=-1, $statement="", $sOrder="", $periode='', $reqStatus='')
	{
		$str = "
				SELECT distinct E.KELAS, E.NAMA AS JABATAN_NAMA, F.PEGAWAI_ID, F.NRP, F.NIPP, F.NAMA, F.JENIS_KELAMIN,
				F.TEMPAT_LAHIR, F.TANGGAL_LAHIR, PPI_SIMPEG.AMBIL_STATUS_NIKAH(F.STATUS_KAWIN) STATUS_KAWIN, F.STATUS_KAWIN STATUS_KAWIN_ID, F.GOLONGAN_DARAH,
				F.ALAMAT, F.TELEPON, F.EMAIL, 
				F.DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(F.DEPARTEMEN_ID, 0)) DEPARTEMEN, 
				F.AGAMA_ID, G.NAMA AS AGAMA_NAMA, F.STATUS_PEGAWAI_ID, F.BANK_ID, F.REKENING_NO, F.REKENING_NAMA, F.NPWP, H.NAMA AS STATUS_PEGAWAI_NAMA,
				F.TANGGAL_PENSIUN, F.TANGGAL_MUTASI_KELUAR, F.TANGGAL_WAFAT, F.TANGGAL_MPP, F.NO_MPP, F.STATUS_KELUARGA_ID, B.JENIS_PEGAWAI_ID, 
				I.NAMA AS JENIS_PEGAWAI_NAMA, KELOMPOK, F.JAMSOSTEK_NO, F.JAMSOSTEK_TANGGAL, F.HOBBY, F.NIS, F.FINGER_ID, F.TANGGAL_NPWP,
				F.TINGGI, F.BERAT_BADAN,
				B.PEGAWAI_JENIS_PEGAWAI_ID, '' AS MAGANG_TIPE, I.NAMA AS JENIS_PEGAWAI, F.KTP_NO, F.TGL_NON_AKTIF,
				 L.NAMA AS ASAL_SEKOLAH, '' AS  KELAS_SEKOLAH,'' AS JURUSAN,  TRIM(L.TINGKAT_PENDIDIKAN) AS PENDIDIKAN_TERAKHIR, 
				TRUNC (MONTHS_BETWEEN (SYSDATE, F.TANGGAL_LAHIR) / 12)  AS UMUR,
				B.TMT_JENIS_PEGAWAI, D.PEGAWAI_JABATAN_ID, D.TMT_JABATAN,
				TRUNC(TRUNC( MONTHS_BETWEEN(SYSDATE, B.TMT_JENIS_PEGAWAI)) / 12) || '-' ||  MOD(TRUNC( MONTHS_BETWEEN(SYSDATE, B.TMT_JENIS_PEGAWAI)), 12) AS MKP,
				NO_URUT   ,   TANGGAL_MASUK  ,BIDANG_STUDI , LINERITAS , SPESIFIKASI_PRESTASI_KARYA , TUGAS_PEMBIMBINGAN   
				FROM PPI_SIMPEG.PEGAWAI F 
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR A ON A.PEGAWAI_ID = F.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C
				        ON A.PEGAWAI_ID = C.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI B    ON B.PEGAWAI_ID = A.PEGAWAI_ID AND B.TMT_JENIS_PEGAWAI = A.TMT_JENIS_PEGAWAI 
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN D    ON D.PEGAWAI_ID = A.PEGAWAI_ID AND D.TMT_JABATAN = C.TMT_JABATAN
				LEFT JOIN PPI_SIMPEG.JABATAN E    ON E.JABATAN_ID = D.JABATAN_ID
				LEFT JOIN PPI_SIMPEG.AGAMA G    ON G.AGAMA_ID = F.AGAMA_ID
				LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI H     ON H.STATUS_PEGAWAI_ID = F.STATUS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.JENIS_PEGAWAI I     ON I.JENIS_PEGAWAI_ID = B.JENIS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_PENDIDIKAN_TERAKHIR L ON L.PEGAWAI_ID = C.PEGAWAI_ID
                WHERE 1 = 1 
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsUntukPenilaian($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
                D.KELAS, D.NAMA JABATAN_NAMA,  A.PEGAWAI_ID, NRP, NIPP, A.NAMA, D.JABATAN_ID, A.NPWP, D.KELAS ,
                CASE WHEN D.JABATAN_ID IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,112,113,114,115,116,117,134,138,139,103,136) 
                    THEN 'S' 
                WHEN D.KELOMPOK = 'K'
                    THEN 'F'
                ELSE 'P'
                    END
                TYPE ,
                CASE WHEN D.JABATAN_ID IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,112,113,114,115,116,117,134,138,139,103,136) 
                    THEN 'STRUKTURAL' 
                WHEN D.KELOMPOK = 'K'
                    THEN 'FUNGSIONAL'
                ELSE 'PELAKSANA'
                    END
                TYPE_NAMA  
                FROM PPI_SIMPEG.PEGAWAI A               
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                WHERE 1 = 1 
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//echo $str; exit;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsDataKeluarga($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				  SELECT   NRP,
						   A.NAMA,
						   D.KELAS,
						   D.NAMA JABATAN_NAMA,
						   A.JENIS_KELAMIN,
						   I.JENIS_KELAMIN JENIS_KELAMIN_KELUARGA,
						   PPI_SIMPEG.AMBIL_STATUS_NIKAH (A.STATUS_KAWIN) STATUS_KAWIN,
						   A.DEPARTEMEN_ID,
						   PPI_SIMPEG.AMBIL_UNIT_KERJA (NVL (A.DEPARTEMEN_ID, 0)) DEPARTEMEN,
						   KELOMPOK,
						   G.JENIS_PEGAWAI_NAMA JENIS_PEGAWAI,
						   NVL (I.NAMA, A.NAMA) NAMA_KELUARGA,
						   NVL (I.TANGGAL_LAHIR, A.TANGGAL_LAHIR) TANGGAL_LAHIR_KELUARGA,
						   A.TANGGAL_LAHIR,
						   NVL (J.NAMA, 'Diri Sendiri') HUBUNGAN_KELUARGA,
						   TO_CHAR (SYSDATE, 'YYYY') - TO_CHAR (A.TANGGAL_LAHIR, 'YYYY') USIA,
						   TO_CHAR (SYSDATE, 'YYYY') - TO_CHAR (I.TANGGAL_LAHIR, 'YYYY') USIA_KELUARGA
					FROM                  PPI_SIMPEG.PEGAWAI A
									   LEFT JOIN
										  PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D
									   ON A.PEGAWAI_ID = D.PEGAWAI_ID
									LEFT JOIN
									   PPI_SIMPEG.STATUS_PEGAWAI E
									ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
								 LEFT JOIN
									PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G
								 ON A.PEGAWAI_ID = G.PEGAWAI_ID
							  LEFT JOIN
								 PPI_SIMPEG.PEGAWAI_KELUARGA I
							  ON A.PEGAWAI_ID = I.PEGAWAI_ID and I.HUBUNGAN_KELUARGA_ID <> '00'
						   LEFT JOIN
							  PPI_SIMPEG.HUBUNGAN_KELUARGA J
						   ON I.HUBUNGAN_KELUARGA_ID = J.HUBUNGAN_KELUARGA_ID
				   WHERE   1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		
		//echo $str;exit;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsGetInfo($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
				D.KELAS, D.NAMA JABATAN_NAMA, A.PEGAWAI_ID, NRP, NIPP, REPLACE(A.NAMA, ',', '') NAMA, (CASE WHEN JENIS_KELAMIN='L' THEN 'Laki-Laki' ELSE 'Perempuan' END)JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, PPI_SIMPEG.AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN, STATUS_KAWIN STATUS_KAWIN_ID,GOLONGAN_DARAH, REPLACE(A.ALAMAT, ',', '') ALAMAT, TELEPON, EMAIL,
                A.DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN, A.AGAMA_ID, C.NAMA AGAMA_NAMA, A.STATUS_PEGAWAI_ID, A.BANK_ID, REKENING_NO, REPLACE(A.REKENING_NAMA, ',', '') REKENING_NAMA, NPWP, E.NAMA STATUS_PEGAWAI_NAMA,
				TANGGAL_PENSIUN, TANGGAL_MUTASI_KELUAR, TANGGAL_WAFAT, TANGGAL_MPP, NO_MPP, STATUS_KELUARGA_ID, PPI_SIMPEG.AMBIL_JENIS_PEGAWAI_PERIODE(TO_CHAR(SYSDATE, 'MMYYYY'), A.PEGAWAI_ID) JENIS_PEGAWAI_ID, HOBBY, TANGGAL_NPWP, A.NIS, TANGGAL_MASUK  ,BIDANG_STUDI , LINERITAS , SPESIFIKASI_PRESTASI_KARYA , TUGAS_PEMBIMBINGAN  
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_KELAS D ON A.PEGAWAI_ID = D.PEGAWAI_ID AND D.PEGAWAI_JABATAN_ID = PPI_SIMPEG.AMBIL_JABATAN_ID_PERIODE(TO_CHAR(SYSDATE, 'MMYYYY'), A.PEGAWAI_ID)
                LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PENGHASILAN_TERAKHIR H ON A.PEGAWAI_ID = H.PEGAWAI_ID
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
	
	function selectByParamsCV($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		/* || TO_DATE(TANGGAL_LAHIR, 'DD MM YYYY') */
		$str = "
				SELECT 
				A.NAMA, NRP, NIPP, A.ALAMAT, J.ALAMAT KOTA, TELEPON, DECODE(JENIS_KELAMIN, 'L', 'Laki-laki', 'Perempuan') JENIS_KELAMIN,
				C.NAMA AGAMA_NAMA, TEMPAT_LAHIR || ', ' || TO_CHAR(TANGGAL_LAHIR, 'DD-MM-YYYY') TTL, 
				PPI_SIMPEG.AMBIL_STATUS_NIKAH(STATUS_KAWIN) || ', ' || SUBSTR(I.KODE, 3,1) || ' Anak' STATUS_PERNIKAHAN,
				GOLONGAN_DARAH, '' TINGGIBB, D.NAMA JABATAN_NAMA, E.NAMA STATUS_PEGAWAI,
				PPI_SIMPEG.AMBIL_PEGAWAI_PENDIDIKAN(A.PEGAWAI_ID) PENDIDIKAN_FORMAL, HOBBY, FOTO,
				TINGGI || ' / ' || BERAT_BADAN TINGGIBB
				FROM PPI_SIMPEG.PEGAWAI A 
				LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_PENGHASILAN_TERAKHIR H ON A.PEGAWAI_ID = H.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.STATUS_KELUARGA I ON A.STATUS_KELUARGA_ID = I.STATUS_KELUARGA_ID
				LEFT JOIN PPI_SIMPEG.PERUBAHAN_ALAMAT_TERAKHIR J ON A.PEGAWAI_ID = J.PEGAWAI_ID
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsKandidatJabatanKosongPilih($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
				PPI_SIMPEG.AMBIL_UMUR(I.TMT_JABATAN) PENGALAMAN, PPI_SIMPEG.AMBIL_UMUR(A.TANGGAL_LAHIR) UMUR, J.PENDIDIKAN,
				D.KELAS, D.NAMA JABATAN_NAMA, MASA_KERJA_TAHUN || '-' || MASA_KERJA_BULAN MKP, A.PEGAWAI_ID, NRP, NIPP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, PPI_SIMPEG.AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN, STATUS_KAWIN STATUS_KAWIN_ID,GOLONGAN_DARAH, A.ALAMAT, TELEPON, EMAIL,
                A.DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN, A.AGAMA_ID, C.NAMA AGAMA_NAMA, A.STATUS_PEGAWAI_ID, A.BANK_ID, REKENING_NO, REKENING_NAMA, NPWP, E.NAMA STATUS_PEGAWAI_NAMA,
				TANGGAL_PENSIUN, TANGGAL_MUTASI_KELUAR, TANGGAL_WAFAT, TANGGAL_MPP, NO_MPP, STATUS_KELUARGA_ID, JENIS_PEGAWAI_ID, G.JENIS_PEGAWAI_NAMA, KELOMPOK, JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, HOBBY, A.NIS, FINGER_ID, TANGGAL_NPWP
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_PENGHASILAN_TERAKHIR H ON A.PEGAWAI_ID = H.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_AWAL I ON A.PEGAWAI_ID = I.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_PENDIDIKAN_TERAKHIR J ON A.PEGAWAI_ID = J.PEGAWAI_ID
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
	
    function selectByParamsKontrakPKWT($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
			    D.KELAS, 
                CASE 
                    WHEN (G.TANGGAL_KONTRAK_AKHIR - INTERVAL '30' DAY) < SYSDATE AND G.TANGGAL_KONTRAK_AKHIR > SYSDATE THEN 1
                    WHEN G.TANGGAL_KONTRAK_AKHIR <= SYSDATE THEN 2
					ELSE 0
				END STATUS_KONTRAK, 
                CASE 
                    WHEN (G.TANGGAL_KONTRAK_AKHIR - INTERVAL '30' DAY) < SYSDATE AND G.TANGGAL_KONTRAK_AKHIR > SYSDATE THEN 'Masa Berlaku Hampir Habis'
                    WHEN G.TANGGAL_KONTRAK_AKHIR <= SYSDATE THEN 'Masa Berlaku Habis'
                    ELSE 'Aktif'
                END STATUS_INFO,
				G.TANGGAL_KONTRAK_AKHIR, G.TANGGAL_KONTRAK_AWAL,
                D.NAMA JABATAN_NAMA, MASA_KERJA_TAHUN || '-' || MASA_KERJA_BULAN MKP, A.PEGAWAI_ID, NRP, NIPP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, PPI_SIMPEG.AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN, STATUS_KAWIN STATUS_KAWIN_ID,GOLONGAN_DARAH, A.ALAMAT, TELEPON, EMAIL,
                A.DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN, A.AGAMA_ID, C.NAMA AGAMA_NAMA, A.STATUS_PEGAWAI_ID, A.BANK_ID, REKENING_NO, REKENING_NAMA, NPWP, E.NAMA STATUS_PEGAWAI_NAMA,
                TANGGAL_PENSIUN, TANGGAL_MUTASI_KELUAR, TANGGAL_WAFAT, TANGGAL_MPP, NO_MPP, STATUS_KELUARGA_ID, JENIS_PEGAWAI_ID, KELOMPOK, JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, HOBBY, A.NIS, FINGER_ID, TANGGAL_NPWP
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PENGHASILAN_TERAKHIR H ON A.PEGAWAI_ID = H.PEGAWAI_ID
                WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsAwakKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
				D.KELAS, D.NAMA JABATAN_NAMA, MASA_KERJA_TAHUN || '-' || MASA_KERJA_BULAN MKP, A.PEGAWAI_ID, NRP, NIPP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, PPI_SIMPEG.AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN, STATUS_KAWIN STATUS_KAWIN_ID,GOLONGAN_DARAH, A.ALAMAT, TELEPON, EMAIL,
                A.DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN, A.AGAMA_ID, C.NAMA AGAMA_NAMA, A.STATUS_PEGAWAI_ID, A.BANK_ID, REKENING_NO, REKENING_NAMA, NPWP, E.NAMA STATUS_PEGAWAI_NAMA,
				JENIS_PEGAWAI_ID, KELOMPOK, I.KAPAL, I.TANGGAL_MASUK, I.TANGGAL_KELUAR, MAGANG_TIPE
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PENGHASILAN_TERAKHIR H ON A.PEGAWAI_ID = H.PEGAWAI_ID
                LEFT JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR I ON A.PEGAWAI_ID = I.PEGAWAI_ID
                WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		
    function selectByParamsMonitoringHistoriMutasi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
                SELECT 
                D.KELAS, D.NAMA JABATAN_NAMA, MASA_KERJA_TAHUN || '-' || MASA_KERJA_BULAN MKP, A.PEGAWAI_ID, NRP, NIPP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, PPI_SIMPEG.AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN, STATUS_KAWIN STATUS_KAWIN_ID,GOLONGAN_DARAH, A.ALAMAT, TELEPON, EMAIL,
                A.DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN, A.AGAMA_ID, C.NAMA AGAMA_NAMA, A.STATUS_PEGAWAI_ID, A.BANK_ID, REKENING_NO, REKENING_NAMA, NPWP, E.NAMA STATUS_PEGAWAI_NAMA,
                TANGGAL_PENSIUN, TANGGAL_MUTASI_KELUAR, TANGGAL_WAFAT, TANGGAL_MPP, NO_MPP, STATUS_KELUARGA_ID, JENIS_PEGAWAI_ID, KELOMPOK, JAMSOSTEK_NO, JAMSOSTEK_TANGGAL, HOBBY
                FROM PPI_SIMPEG.PEGAWAI_MUTASI_TERAKHIR B
                INNER JOIN PPI_SIMPEG.PEGAWAI A ON A.PEGAWAI_ID = B.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_PENGHASILAN_TERAKHIR H ON A.PEGAWAI_ID = H.PEGAWAI_ID
                WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
    
    function selectByParamsHistoriMutasi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
				PEGAWAI_MUTASI_ID, PEGAWAI_ID, PEJABAT_PENETAP_ID, 
				   NO_SK, TMT_SK, TANGGAL_SK, 
				   (SELECT NAMA FROM PPI_SIMPEG.DEPARTEMEN WHERE DEPARTEMEN_ID = DEPARTEMEN_ID_LAMA) DEPARTEMEN_LAMA,
				   (SELECT NAMA FROM PPI_SIMPEG.DEPARTEMEN WHERE DEPARTEMEN_ID = DEPARTEMEN_ID_BARU) DEPARTEMEN_BARU
				FROM PPI_SIMPEG.PEGAWAI_MUTASI
                WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function selectByParamsReplaceNama($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
                    
                    				SELECT 
				D.KELAS, D.NAMA JABATAN_NAMA, A.PEGAWAI_ID, NRP, NIPP, REPLACE(A.NAMA, ',', '') NAMA, (CASE WHEN JENIS_KELAMIN='L' THEN 'Laki-Laki' ELSE 'Perempuan' END)JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, PPI_SIMPEG.AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN, STATUS_KAWIN STATUS_KAWIN_ID,GOLONGAN_DARAH, REPLACE(A.ALAMAT, ',', '') ALAMAT, TELEPON, EMAIL,
                A.DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN, A.AGAMA_ID, C.NAMA AGAMA_NAMA, A.STATUS_PEGAWAI_ID, A.BANK_ID, REKENING_NO, REPLACE(A.REKENING_NAMA, ',', '') REKENING_NAMA, NPWP, E.NAMA STATUS_PEGAWAI_NAMA,
				TANGGAL_PENSIUN, TANGGAL_MUTASI_KELUAR, TANGGAL_WAFAT, TANGGAL_MPP, NO_MPP, STATUS_KELUARGA_ID, JENIS_PEGAWAI_ID, KELOMPOK, HOBBY, TANGGAL_NPWP, A.NIS
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
                WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCutiTahunan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "                    
                SELECT A.PEGAWAI_ID, A.NRP, REPLACE(A.NAMA, ',', '') NAMA, B.NAMA JABATAN, PPI_SIMPEG.AMBIL_UNIT_KERJA(A.DEPARTEMEN_ID) DEPARTEMEN, NVL(LAMA_CUTI, 0) LAMA_CUTI     
				 FROM PPI_SIMPEG.PEGAWAI A 
                 LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                 LEFT JOIN (SELECT PEGAWAI_ID, SUM(LAMA_CUTI) LAMA_CUTI FROM PPI_GAJI.CUTI_TAHUNAN WHERE TO_CHAR(TANGGAL, 'YYYY') = TO_CHAR(SYSDATE, 'YYYY') GROUP BY PEGAWAI_ID) C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				 LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                WHERE 1 = 1 AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) AND NOT EXISTS(SELECT 1 FROM PPI_GAJI.CUTI_TAHUNAN X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID AND X.PERIODE = TO_CHAR(SYSDATE, 'YYYY'))
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "                    
                SELECT A.PEGAWAI_ID, A.NRP, REPLACE(A.NAMA, ',', '') NAMA, B.NAMA JABATAN, PPI_SIMPEG.AMBIL_UNIT_KERJA(A.DEPARTEMEN_ID) DEPARTEMEN, NVL(LAMA_CUTI, 0) LAMA_CUTI     
				 FROM PPI_SIMPEG.PEGAWAI A 
                 LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                 LEFT JOIN (SELECT PEGAWAI_ID, SUM(LAMA_CUTI) LAMA_CUTI FROM PPI_GAJI.CUTI_TAHUNAN WHERE TO_CHAR(TANGGAL, 'YYYY') = TO_CHAR(SYSDATE, 'YYYY') GROUP BY PEGAWAI_ID) C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				 LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                WHERE 1 = 1 AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) 
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		

    function selectByParamsPegawaiAgama($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT MAX(DECODE(AGAMA_ID, 1, JUMLAH)) ISLAM, 
					   NVL(MAX(DECODE(AGAMA_ID, 2, JUMLAH)), 0) PROTESTAN, 
					   NVL(MAX(DECODE(AGAMA_ID, 3, JUMLAH)), 0) KATOLIK, 
					   NVL(MAX(DECODE(AGAMA_ID, 4, JUMLAH)), 0) HINDU, 
					   NVL(MAX(DECODE(AGAMA_ID, 5, JUMLAH)), 0) BUDHA,
					   NVL(MAX(DECODE(AGAMA_ID, 0, JUMLAH)), 0) BELUM_DIKETAHUI
				FROM (
				SELECT NVL(AGAMA_ID, 0) AGAMA_ID, COUNT(PEGAWAI_ID) JUMLAH FROM PPI_SIMPEG.PEGAWAI A WHERE STATUS_PEGAWAI_ID = 1 OR STATUS_PEGAWAI_ID = 5 GROUP BY AGAMA_ID
				) A WHERE 1 = 1                                 
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsPegawaiJenis($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT MAX(DECODE(JENIS_PEGAWAI_ID, 1, JUMLAH)) ORGANIK, 
					   NVL(MAX(DECODE(JENIS_PEGAWAI_ID, 2, JUMLAH)), 0) PERBANTUAN, 
					   NVL(MAX(DECODE(JENIS_PEGAWAI_ID, 3, JUMLAH)), 0) PKWT, 
					   NVL(MAX(DECODE(JENIS_PEGAWAI_ID, 4, JUMLAH)), 0) KSO
				FROM (
				SELECT NVL(JENIS_PEGAWAI_ID, 0) JENIS_PEGAWAI_ID, COUNT(A.PEGAWAI_ID) JUMLAH FROM PPI_SIMPEG.PEGAWAI A INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE STATUS_PEGAWAI_ID = 1 OR STATUS_PEGAWAI_ID = 5 GROUP BY JENIS_PEGAWAI_ID
				) WHERE 1 = 1                        
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	 function selectHomeBase($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				select lokasi_id, nama, keterangan from PEL_operasional.lokasi
				where keterangan is not null
				and lokasi_id not in ('_1102', '1101')                       
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPegawaiStatus($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT MAX(DECODE(STATUS_PEGAWAI_ID, 1, JUMLAH)) AKTIF, 
					   NVL(MAX(DECODE(STATUS_PEGAWAI_ID, 5, JUMLAH)), 0) MPP
				FROM (
				SELECT NVL(STATUS_PEGAWAI_ID, 0) STATUS_PEGAWAI_ID, COUNT(PEGAWAI_ID) JUMLAH FROM PPI_SIMPEG.PEGAWAI A WHERE STATUS_PEGAWAI_ID = 1 OR STATUS_PEGAWAI_ID = 5 GROUP BY STATUS_PEGAWAI_ID
				) WHERE 1 = 1     
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$sOrder;
		//" ORDER BY A.NAMA ASC"
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
					
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				PEGAWAI_ID, NRP, NIPP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, STATUS_KAWIN, GOLONGAN_DARAH, ALAMAT, TELEPON, EMAIL,
				A.DEPARTEMEN_ID, B.NAMA DEPARTEMEN
				FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN DEPARTEMEN B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY A.NAMA DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
	function getFotoByParams($id="")
	{
		$str = "SELECT FOTO AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI
		        WHERE PEGAWAI_ID IS NOT NULL AND PEGAWAI_ID = ".$id; 
		
		$this->select($str);
		$this->query = $str; 
		
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
	function getCountByParamsPegawaiPotongan($paramsArray=array(), $statement="")
	{
		$str = "
			SELECT COUNT(PEGAWAI_ID) ROWCOUNT FROM (
			SELECT PEGAWAI_ID, NRP, NIPP, NAMA, JABATAN, KELAS, JENIS_PEGAWAI_ID, KELOMPOK,  NO_URUT, STATUS_PEGAWAI_ID
				FROM
				(SELECT A.PEGAWAI_ID, NRP, NIPP, A.NAMA, B.NAMA JABATAN, B.KELAS,
                   E.JENIS_PEGAWAI_ID, B.KELOMPOK, NO_URUT, STATUS_PEGAWAI_ID,
                   A.DEPARTEMEN_ID, D.NAMA POTONGAN, row_number() OVER ( PARTITION BY PEGAWAI_ID  ORDER BY rownum) rn 
				  FROM PPI_SIMPEG.PEGAWAI A 
				  INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				  LEFT JOIN PPI_GAJI.POTONGAN_KONDISI_PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				  LEFT JOIN PPI_GAJI.POTONGAN_KONDISI D ON C.POTONGAN_KONDISI_ID = D.POTONGAN_KONDISI_ID
				  INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR E ON A.PEGAWAI_ID = E.PEGAWAI_ID
				  INNER JOIN PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI F ON F.POTONGAN_KONDISI_ID = C.POTONGAN_KONDISI_ID AND 
                                                                             E.JENIS_PEGAWAI_ID = F.JENIS_PEGAWAI_ID AND 
                                                                             F.KELOMPOK = B.KELOMPOK 
                                                                             AND JENIS_POTONGAN = 'P'
				) A WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$str .= " CONNECT  BY  PEGAWAI_ID = PRIOR PEGAWAI_ID
							AND  rn     = PRIOR rn+1
					START WITH rn =1
				   GROUP BY PEGAWAI_ID, NRP, NIPP, NAMA, JABATAN, DEPARTEMEN_ID, NO_URUT, STATUS_PEGAWAI_ID, KELAS, JENIS_PEGAWAI_ID, KELOMPOK ) A WHERE 1 = 1 ";
		$this->select($str);
		$this->query = $str; 
		
		
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }		

	function getCountByParamsCutiTahunan($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) ROWCOUNT   
				 FROM PPI_SIMPEG.PEGAWAI A 
                 LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                 LEFT JOIN (SELECT PEGAWAI_ID, SUM(LAMA_CUTI) LAMA_CUTI FROM PPI_GAJI.CUTI_TAHUNAN WHERE TO_CHAR(TANGGAL, 'YYYY') = TO_CHAR(SYSDATE, 'YYYY') GROUP BY PEGAWAI_ID) C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				 LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                WHERE 1 = 1 AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5)   AND NOT EXISTS(SELECT 1 FROM PPI_GAJI.CUTI_TAHUNAN X WHERE X.PEGAWAI_ID = A.PEGAWAI_ID AND X.PERIODE = TO_CHAR(SYSDATE, 'YYYY')) ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

	
	function getCountByParamsMonitoringHistoriMutasi($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
				COUNT(A.PEGAWAI_ID) ROWCOUNT
                FROM PPI_SIMPEG.PEGAWAI_MUTASI_TERAKHIR B
                INNER JOIN PPI_SIMPEG.PEGAWAI A ON A.PEGAWAI_ID = B.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_PENGHASILAN_TERAKHIR H ON A.PEGAWAI_ID = H.PEGAWAI_ID
                WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
				COUNT(A.PEGAWAI_ID) ROWCOUNT
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
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


	
    function getPegawaiId($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
				A.PEGAWAI_ID ROWCOUNT
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
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


    function getCountByParamsNew($paramsArray=array(), $statement="", $periode='')
	{
		$str = "SELECT 
				COUNT(F.PEGAWAI_ID) ROWCOUNT 
				FROM PPI_SIMPEG.PEGAWAI F 
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR A ON A.PEGAWAI_ID = F.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C
				        ON A.PEGAWAI_ID = C.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI B    ON B.PEGAWAI_ID = A.PEGAWAI_ID AND B.TMT_JENIS_PEGAWAI = A.TMT_JENIS_PEGAWAI 
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN D    ON D.PEGAWAI_ID = A.PEGAWAI_ID AND D.TMT_JABATAN = C.TMT_JABATAN
				LEFT JOIN PPI_SIMPEG.JABATAN E    ON E.JABATAN_ID = D.JABATAN_ID
				LEFT JOIN PPI_SIMPEG.AGAMA G    ON G.AGAMA_ID = F.AGAMA_ID
				LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI H     ON H.STATUS_PEGAWAI_ID = F.STATUS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.JENIS_PEGAWAI I     ON I.JENIS_PEGAWAI_ID = B.JENIS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_PENDIDIKAN_TERAKHIR L ON L.PEGAWAI_ID = C.PEGAWAI_ID
                WHERE 1 = 1   ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str; exit;
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getUrut()
	{
		$str = "SELECT MAX(TO_NUMBER(SUBSTR(NIS, 5, 3))) ROWCOUNT FROM PPI_SIMPEG.PEGAWAI WHERE NIS IS NOT NULL AND SUBSTR(NIS, 0, 4) = TO_CHAR(SYSDATE, 'YYYY') "; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	
	
	function getCountByParamsKandidatJabatanKosongPilih($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
				COUNT(A.PEGAWAI_ID) ROWCOUNT
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_PENGHASILAN_TERAKHIR H ON A.PEGAWAI_ID = H.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_AWAL I ON A.PEGAWAI_ID = I.PEGAWAI_ID
                WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
	function getCountByParamsAwakKapal($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
				COUNT(A.PEGAWAI_ID) ROWCOUNT
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.AGAMA C ON A.AGAMA_ID = C.AGAMA_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.BANK F ON A.BANK_ID = F.BANK_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_PENGHASILAN_TERAKHIR H ON A.PEGAWAI_ID = H.PEGAWAI_ID
                LEFT JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR I ON A.PEGAWAI_ID = I.PEGAWAI_ID
                WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI
		        WHERE PEGAWAI_ID IS NOT NULL ".$statement; 
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