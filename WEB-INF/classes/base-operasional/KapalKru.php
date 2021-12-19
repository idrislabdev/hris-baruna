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

  class KapalKru extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalKru()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_KRU_ID", $this->getNextId("KAPAL_KRU_ID","PPI_OPERASIONAL.KAPAL_KRU"));
		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_KRU (
				   KAPAL_KRU_ID, KAPAL_ID, KRU_JABATAN_ID, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("KAPAL_KRU_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("KRU_JABATAN_ID")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("KAPAL_KRU_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL
				SET    
					   KAPAL_JENIS_ID       = '".$this->getField("KAPAL_JENIS_ID")."',
					   KAPAL_KEPEMILIKAN_ID	= '".$this->getField("KAPAL_KEPEMILIKAN_ID")."',
					   KODE	 				= '".$this->getField("KODE")."',
					   CALL_SIGN	 		= '".$this->getField("CALL_SIGN")."',
					   IMO_NUMBER	 		= '".$this->getField("IMO_NUMBER")."',
					   NAMA	 				= '".$this->getField("NAMA")."',
					   PERUSAHAAN_BANGUN	= '".$this->getField("PERUSAHAAN_BANGUN")."',
					   TEMPAT_BANGUN	 	= '".$this->getField("TEMPAT_BANGUN")."',
					   TAHUN_BANGUN	 		= '".$this->getField("TAHUN_BANGUN")."',
					   GT	 				= '".$this->getField("GT")."',
					   NT	 				= '".$this->getField("NT")."',
					   LOA	 				= '".$this->getField("LOA")."',
					   BREADTH	 			= '".$this->getField("BREADTH")."',
					   DEPTH	 			= '".$this->getField("DEPTH")."',
					   DRAFT	 			= '".$this->getField("DRAFT")."',
					   MESIN_INDUK	 		= '".$this->getField("MESIN_INDUK")."',
					   MESIN_BANTU	 		= '".$this->getField("MESIN_BANTU")."',
					   MESIN_DAYA	 		= '".$this->getField("MESIN_DAYA")."',
					   MESIN_RPM	 		= '".$this->getField("MESIN_RPM")."',
					   POMPA	 			= '".$this->getField("POMPA")."',
					   ISI_TANGKI	 		= '".$this->getField("ISI_TANGKI")."',
					   AIR_BERSIH	 		= '".$this->getField("AIR_BERSIH")."',
					   KECEPATAN	 		= '".$this->getField("KECEPATAN")."',
					   STATUS_KESIAPAN	 	= '".$this->getField("STATUS_KESIAPAN")."',
					   BENDERA	 			= '".$this->getField("BENDERA")."',
					   JUMLAH_KRU 			= '".$this->getField("JUMLAH_KRU")."'
				WHERE  KAPAL_ID  			= '".$this->getField("KAPAL_ID")."'
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
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_KRU
                WHERE 
                  KAPAL_ID = ".$this->getField("KAPAL_ID")." AND NOT KAPAL_KRU_ID IN (".$this->getField("KAPAL_KRU_ID_NOT_IN").")"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_KRU_ID ASC")
	{
		$str = "SELECT 
				KAPAL_KRU_ID, KAPAL_ID, KRU_JABATAN_ID
				FROM PPI_OPERASIONAL.KAPAL_KRU 
				WHERE KAPAL_KRU_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsKapalKruJabatanCombo($statement="", $order="ORDER BY B.KRU_JABATAN_ID ASC")
	{
		$str = "
				SELECT C.PEGAWAI_ID, A.KAPAL_KRU_ID, B.KRU_JABATAN_ID, B.NAMA JABATAN, D.NAMA NAMA FROM PPI_OPERASIONAL.KAPAL_KRU A
				INNER JOIN PPI_OPERASIONAL.KRU_JABATAN B ON A.KRU_JABATAN_ID = B.KRU_JABATAN_ID
				LEFT JOIN PPI_OPERASIONAL.PEGAWAI_KAPAL C ON A.KAPAL_KRU_ID = C.KAPAL_KRU_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI D ON C.PEGAWAI_ID = D.PEGAWAI_ID 
				WHERE 1 = 1
				".$statement; 
		
		
		$str .= $order;
		$this->query = $str;
		return $this->selectLimit($str, -1, -1); 
    }
	
    function selectByParamsKapalKruJabatan($kapal_id, $order="ORDER BY A.KRU_JABATAN_ID DESC")
	{
		$str = "
				SELECT 
				A.KAPAL_KRU_ID, B.NAMA JABATAN, B.KETERANGAN POSISI, C.PEGAWAI_ID, D.NAMA AWAK_KAPAL, PPI_OPERASIONAL.AMBIL_PEGAWAI_SERTIFIKAT_ID(C.PEGAWAI_ID) SERTIFIKAT, D.NRP, E.KELAS, B.KRU_JABATAN_ID
				FROM PPI_OPERASIONAL.KAPAL_KRU A 
				 INNER JOIN PPI_OPERASIONAL.KRU_JABATAN B ON A.KRU_JABATAN_ID = B.KRU_JABATAN_ID AND A.KAPAL_ID = ".$kapal_id."
				LEFT JOIN PPI_OPERASIONAL.PEGAWAI_KAPAL C ON A.KAPAL_KRU_ID = C.KAPAL_KRU_ID AND C.KAPAL_ID = ".$kapal_id."  AND EXISTS(SELECT 1 FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR X WHERE X.PEGAWAI_ID = C.PEGAWAI_ID AND X.KAPAL_ID = ".$kapal_id.")
                LEFT JOIN PPI_SIMPEG.PEGAWAI D ON C.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR E ON D.PEGAWAI_ID = E.PEGAWAI_ID
                WHERE A.KAPAL_KRU_ID IS NOT NULL
				"; 
		
		
		$str .= $order;
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str, -1, -1); 
    }
	
	function selectByParamsKapalPekerjaanKruJabatan($kapal_pekerjaan_id, $order="ORDER BY A.KRU_JABATAN_ID DESC")
	{
		$str = "
				SELECT 
				A.KAPAL_PEKERJAAN_KRU_ID, B.NAMA JABATAN, B.KETERANGAN POSISI, C.PEGAWAI_ID, D.NAMA AWAK_KAPAL, PPI_OPERASIONAL.AMBIL_PEGAWAI_SERTIFIKAT_ID(C.PEGAWAI_ID) SERTIFIKAT
				FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_KRU A 
				 INNER JOIN PPI_OPERASIONAL.KRU_JABATAN B ON A.KRU_JABATAN_ID = B.KRU_JABATAN_ID AND A.KAPAL_PEKERJAAN_ID = ".$kapal_pekerjaan_id."
                LEFT JOIN PPI_OPERASIONAL.KAPAL_PEKERJAAN_AWAK_KAPAL C ON A.KAPAL_PEKERJAAN_KRU_ID = C.KAPAL_PEKERJAAN_KRU_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI D ON C.PEGAWAI_ID = D.PEGAWAI_ID
                WHERE 1 = 1
				"; 
		
		
		$str .= $order; 
		$this->query = $str;
		return $this->selectLimit($str, -1, -1); 
    }

    function selectByParamsKapalPremi($kapal_id, $periode, $order="ORDER BY D.KRU_JABATAN_ID ASC")
	{
		$str = "
				  SELECT A.PEGAWAI_ID, A.NAMA AWAK_KAPAL, A.NRP, A.NPWP, E.KELAS, D.NAMA JABATAN, REALISASI_PRODUKSI, PRODUKSI_NORMAL, PRODUKSI_MAKSIMAL, INTERVAL_PRODUKSI, TARIF_NORMAL, 
                                TARIF_MAKSIMAL, FAKTOR_KONVERSI, PREMI_JSON, B.PPH, F.NAMA NAMA_KAPAL, MASA_KERJA, MASUK_KERJA
                  FROM PPI_SIMPEG.PEGAWAI A 
                  INNER JOIN PPI_GAJI.PREMI_KAPAL B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                  INNER JOIN PPI_OPERASIONAL.KRU_JABATAN D ON D.KRU_JABATAN_ID = B.KRU_JABATAN_ID
                  LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR E ON E.PEGAWAI_ID = A.PEGAWAI_ID
                  INNER JOIN PPI_OPERASIONAL.KAPAL F ON B.KAPAL_ID = F.KAPAL_ID
                  WHERE B.KAPAL_ID = ".$kapal_id." AND B.PERIODE = '".$periode."'
				"; 
		
		
		$str .= $order;
		$this->query = $str;
		return $this->selectLimit($str, -1, -1); 
    }
	

    function selectByParamsKapalPekerjaanPremi($kapal_pekerjaan_id, $order="ORDER BY C.KRU_JABATAN_ID ASC")
	{
		$str = "
				  SELECT  B.NAMA, NRP, NPWP, C.NAMA JABATAN, JUMLAH, PROSENTASE_POTONGAN, PROSENTASE, JUMLAH_POTONGAN, DIBAYARKAN FROM PPI_GAJI.PREMI_KAPAL_PEKERJAAN A 
				  INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
				  INNER JOIN PPI_OPERASIONAL.KRU_JABATAN C ON A.KRU_JABATAN_ID = C.KRU_JABATAN_ID
				  WHERE A.KAPAL_PEKERJAAN_ID = ".$kapal_pekerjaan_id."
				"; 
		
		
		$str .= $order;
		$this->query = $str;
		return $this->selectLimit($str, -1, -1); 
    }
		
    function selectByParamsKapalKruJabatanHistori($kapal_id, $order="ORDER BY A.KRU_JABATAN_ID ASC")
	{
		$str = "
				SELECT 
				C.PEGAWAI_KAPAL_ID, A.KAPAL_KRU_ID, C.KAPAL_ID, B.NAMA JABATAN, B.KRU_JABATAN_ID, B.KETERANGAN POSISI, C.PEGAWAI_ID, D.NAMA AWAK_KAPAL, PPI_OPERASIONAL.AMBIL_PEGAWAI_SERTIFIKAT_ID(C.PEGAWAI_ID) SERTIFIKAT,
                E.KAPAL KAPAL_LAST, E.KAPAL_ID KAPAL_ID_LAST, E.JABATAN JABATAN_LAST, E.TANGGAL_MASUK TANGGAL_MASUK_LAST, E.TANGGAL_KELUAR TANGGAL_KELUAR_LAST,
                CASE WHEN B.NAMA = E.JABATAN THEN E.PEGAWAI_KAPAL_HISTORI_ID ELSE E.PEGAWAI_KAPAL_HISTORI_ID END PEGAWAI_KAPAL_HISTORI_ID_LAST
				FROM PPI_OPERASIONAL.KAPAL_KRU A 
				 INNER JOIN PPI_OPERASIONAL.KRU_JABATAN B ON A.KRU_JABATAN_ID = B.KRU_JABATAN_ID AND A.KAPAL_ID = ".$kapal_id."
				LEFT JOIN PPI_OPERASIONAL.PEGAWAI_KAPAL C ON A.KAPAL_KRU_ID = C.KAPAL_KRU_ID AND C.KAPAL_ID = ".$kapal_id."
				LEFT JOIN PPI_SIMPEG.PEGAWAI D ON C.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR E ON C.PEGAWAI_ID = E.PEGAWAI_ID
                WHERE A.KAPAL_KRU_ID IS NOT NULL
				"; 
		
		
		$str .= $order;
		$this->query = $str;
		return $this->selectLimit($str, -1, -1); 
    } 
    
	function selectByParamsInsert($paramsArray=array(),$limit=-1,$from=-1, $statement="", $jenis_id='', $kapal_id='', $order="ORDER BY A.KRU_JABATAN_ID ASC")
	{
		$str = "
				SELECT 
				KAPAL_JENIS_KRU_ID, B.KAPAL_JENIS_ID, A.KRU_JABATAN_ID, A.NAMA
				FROM PPI_OPERASIONAL.KRU_JABATAN A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS_KRU B ON A.KRU_JABATAN_ID=B.KRU_JABATAN_ID AND B.KAPAL_JENIS_ID='".$jenis_id."'
				LEFT JOIN PPI_OPERASIONAL.KAPAL_KRU C ON A.KRU_JABATAN_ID=C.KRU_JABATAN_ID AND C.KAPAL_ID = '".$kapal_id."'
				WHERE 1=1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsEdit($paramsArray=array(),$limit=-1,$from=-1, $statement="", $kapal_id='', $order="ORDER BY A.KRU_JABATAN_ID ASC")
	{
		$str = "
				SELECT 
					KAPAL_KRU_ID, A.KRU_JABATAN_ID, A.NAMA
				FROM PPI_OPERASIONAL.KRU_JABATAN A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_KRU C ON A.KRU_JABATAN_ID=C.KRU_JABATAN_ID 
				WHERE 1=1 AND C.KAPAL_ID = '".$kapal_id."'
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
				SELECT 
				KAPAL_ID, KAPAL_JENIS_ID, KAPAL_KEPEMILIKAN_ID, KODE, CALL_SIGN, IMO_NUMBER, 
				   NAMA, PERUSAHAAN_BANGUN, TEMPAT_BANGUN, TAHUN_BANGUN, GT, NT, 
				   LOA, BREADTH, DEPTH, DRAFT, MESIN_INDUK, MESIN_BANTU, 
				   MESIN_DAYA, MESIN_RPM, POMPA, ISI_TANGKI, AIR_BERSIH, KECEPATAN, 
				   FOTO, STATUS_KESIAPAN, BENDERA, JUMLAH_KRU
				FROM PPI_OPERASIONAL.KAPAL A 
				WHERE KAPAL_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
	function getFotoByParams($id="")
	{
		$str = "SELECT FOTO AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL
		        WHERE KAPAL_ID IS NOT NULL AND KAPAL_ID = ".$id; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_KRU
		        WHERE KAPAL_ID IS NOT NULL ".$statement; 
		
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
	
	function getCountByParamsKapalPremi($kapal_id, $periode)
	{
		$str = "
				  SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT
				  FROM PPI_SIMPEG.PEGAWAI A 
				  INNER JOIN PPI_GAJI.PREMI_KAPAL B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				  INNER JOIN PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI C ON B.KAPAL_ID = C.KAPAL_ID AND C.PEGAWAI_ID = B.PEGAWAI_ID AND (TO_CHAR(TANGGAL_MASUK, 'MMYYYY') = B.PERIODE OR TO_DATE(PERIODE, 'MMYYYY') BETWEEN TANGGAL_MASUK AND NVL(TANGGAL_KELUAR, SYSDATE))
				  INNER JOIN PPI_OPERASIONAL.KRU_JABATAN D ON D.KRU_JABATAN_ID = C.KRU_JABATAN_ID
				  LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR E ON E.PEGAWAI_ID = A.PEGAWAI_ID
				  INNER JOIN PPI_OPERASIONAL.KAPAL F ON B.KAPAL_ID = F.KAPAL_ID
				  WHERE B.KAPAL_ID = ".$kapal_id." AND B.PERIODE = '".$periode."'
				"; 
				
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
			
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL
		        WHERE KAPAL_ID IS NOT NULL ".$statement; 
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