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
  * Entity-base class untuk mengimplementasikan tabel PANGKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Sppd extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Sppd()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		
		if($this->getField("TANGGAL_SURAT") == "")
			$this->setField("TANGGAL_SURAT", "SYSDATE");
			
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SPPD_ID", $this->getNextId("SPPD_ID","PPI_SPPD.SPPD"));
		$str = "INSERT INTO PPI_SPPD.SPPD (
				   SPPD_ID, PEGAWAI_ID, ANGKUTAN_ID, 
				   MATA_ANGGARAN_ID, JENIS_SPPD_ID, BERANGKAT_DARI, 
				   TANGGAL_BERANGKAT, TANGGAL_KEMBALI, NOPOL, 
				   LAMA_PERJALANAN, KETERANGAN, JUMLAH_ANAK, 
				   STATUS_BAWA_ISTRI, DASAR_SPPD, KOTA_ID_TUJUAN, KOTA_ID_BERANGKAT, 
				   FASILITAS_DIKLAT_ID, STATUS_AJAK_PASANGAN,
				   PENUGASAN_ID, PREFIX_SPPD_AWAK_KAPAL, 
				   LOKASI_ID_AWAL, LOKASI_ID_AKHIR, KOTA_ID_TUJUAN_BERIKUTNYA, 
				   TANGGAL_BERANGKAT_BERIKUTNYA, JENIS_DETASERING,
				   NAMA_PENGGANTI, KELAS_PENGGANTI, AIRPORT_TAX_BERANGKAT, JABATAN_ID_PENGGANTI, 
				   JABATAN_NAMA_PENGGANTI, TANGGAL_SURAT, LAST_CREATE_USER, LAST_CREATE_DATE) 
				VALUES (".$this->getField("SPPD_ID").", 
						'".$this->getField("PEGAWAI_ID")."',
						'".$this->getField("ANGKUTAN_ID")."',
						'".$this->getField("MATA_ANGGARAN_ID")."', 
				   		'".$this->getField("JENIS_SPPD_ID")."',
						'".$this->getField("BERANGKAT_DARI")."',
						".$this->getField("TANGGAL_BERANGKAT").", 
				   		".$this->getField("TANGGAL_KEMBALI").", 
						'".$this->getField("NOPOL")."',
						'".$this->getField("LAMA_PERJALANAN")."', 
				   		'".$this->getField("KETERANGAN")."',
						'".$this->getField("JUMLAH_ANAK")."',
						'".$this->getField("STATUS_BAWA_ISTRI")."',
						'".$this->getField("DASAR_SPPD")."',
						'".$this->getField("KOTA_ID_TUJUAN")."',
						'".$this->getField("KOTA_ID_BERANGKAT")."',
						'".$this->getField("FASILITAS_DIKLAT_ID")."',
						'".$this->getField("STATUS_AJAK_PASANGAN")."',
						'".$this->getField("PENUGASAN_ID")."',
						'".$this->getField("PREFIX_SPPD_AWAK_KAPAL")."',
						'".$this->getField("LOKASI_ID_AWAL")."',
						'".$this->getField("LOKASI_ID_AKHIR")."',
						'".$this->getField("KOTA_ID_TUJUAN_BERIKUTNYA")."',
						".$this->getField("TANGGAL_BERANGKAT_BERIKUTNYA").",
						'".$this->getField("JENIS_DETASERING")."',
						'".$this->getField("NAMA_PENGGANTI")."',
						'".$this->getField("KELAS_PENGGANTI")."',
						'".$this->getField("AIRPORT_TAX_BERANGKAT")."',
						'".$this->getField("JABATAN_ID_PENGGANTI")."',
						'".$this->getField("JABATAN_NAMA_PENGGANTI")."',
				   		".$this->getField("TANGGAL_SURAT").",
				   		'".$this->getField("LAST_CREATE_USER")."',
				   		SYSDATE 
						)"; 
						
		$this->id = $this->getField("SPPD_ID");
		//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }

	function insertPerpanjangan()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SPPD_ID", $this->getNextId("SPPD_ID","PPI_SPPD.SPPD"));
		$str = "INSERT INTO PPI_SPPD.SPPD (
				   SPPD_ID, PEGAWAI_ID, ANGKUTAN_ID, 
				   MATA_ANGGARAN_ID, JENIS_SPPD_ID, BERANGKAT_DARI, 
				   TANGGAL_BERANGKAT, TANGGAL_KEMBALI, NOPOL, 
				   LAMA_PERJALANAN, KETERANGAN, JUMLAH_ANAK, 
				   STATUS_BAWA_ISTRI, DASAR_SPPD, KOTA_ID_TUJUAN, KOTA_ID_BERANGKAT, 
				   FASILITAS_DIKLAT_ID, STATUS_AJAK_PASANGAN,
				   PENUGASAN_ID, PREFIX_SPPD_AWAK_KAPAL,
				   LOKASI_ID_AWAL, LOKASI_ID_AKHIR, KOTA_ID_TUJUAN_BERIKUTNYA, TANGGAL_BERANGKAT_BERIKUTNYA, JENIS_DETASERING)
				SELECT ".$this->getField("SPPD_ID")." SPPD_ID, PEGAWAI_ID, ANGKUTAN_ID, 
				   MATA_ANGGARAN_ID, JENIS_SPPD_ID, BERANGKAT_DARI, 
				   ".$this->getField("TANGGAL_BERANGKAT")." TANGGAL_BERANGKAT, ".$this->getField("TANGGAL_KEMBALI")." TANGGAL_KEMBALI, NOPOL, 
				   '".$this->getField("LAMA_PERJALANAN")."' LAMA_PERJALANAN, KETERANGAN, JUMLAH_ANAK, 
				   STATUS_BAWA_ISTRI, DASAR_SPPD, KOTA_ID_TUJUAN, KOTA_ID_BERANGKAT, 
				   FASILITAS_DIKLAT_ID, STATUS_AJAK_PASANGAN,
				   PENUGASAN_ID, PREFIX_SPPD_AWAK_KAPAL,
				   LOKASI_ID_AWAL, LOKASI_ID_AKHIR, KOTA_ID_TUJUAN_BERIKUTNYA, TANGGAL_BERANGKAT_BERIKUTNYA, 'PERPANJANGAN' JENIS_DETASERING
				 FROM PPI_SPPD.SPPD WHERE SPPD_ID = '".$this->getField("SPPD_ID_LAST")."'
				"; 
		$this->id = $this->getField("SPPD_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function callProsesLockDepartemen()	{
		$str = " CALL PPI_SPPD.PROSES_LOCK_DEPARTEMEN() ";		
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callProsesUnLockDepartemen()	{
		$str = " CALL PPI_SPPD.PROSES_UNLOCK_DEPARTEMEN() ";		
		$this->query = $str;
        return $this->execQuery($str);
    }		


    function update()
	{
		if($this->getField("TANGGAL_SURAT") == "")
			$this->setField("TANGGAL_SURAT", "SYSDATE");
			
		$str = "
				UPDATE PPI_SPPD.SPPD
				SET    PEGAWAI_ID        = '".$this->getField("PEGAWAI_ID")."',
					   ANGKUTAN_ID       = '".$this->getField("ANGKUTAN_ID")."',
					   MATA_ANGGARAN_ID  = '".$this->getField("MATA_ANGGARAN_ID")."',
					   JENIS_SPPD_ID     = '".$this->getField("JENIS_SPPD_ID")."',
					   BERANGKAT_DARI    = '".$this->getField("BERANGKAT_DARI")."',
					   TANGGAL_BERANGKAT = ".$this->getField("TANGGAL_BERANGKAT").",
					   TANGGAL_KEMBALI   = ".$this->getField("TANGGAL_KEMBALI").",
					   NOPOL             = '".$this->getField("NOPOL")."',
					   LAMA_PERJALANAN   = '".$this->getField("LAMA_PERJALANAN")."',
					   KETERANGAN        = '".$this->getField("KETERANGAN")."',
					   JUMLAH_ANAK       = '".$this->getField("JUMLAH_ANAK")."',
					   STATUS_BAWA_ISTRI = '".$this->getField("STATUS_BAWA_ISTRI")."',
					   DASAR_SPPD		 = '".$this->getField("DASAR_SPPD")."',
					   KOTA_ID_TUJUAN	 = '".$this->getField("KOTA_ID_TUJUAN")."',
					   KOTA_ID_BERANGKAT = '".$this->getField("KOTA_ID_BERANGKAT")."',
					   FASILITAS_DIKLAT_ID 			= '".$this->getField("FASILITAS_DIKLAT_ID")."',
					   STATUS_AJAK_PASANGAN 		= '".$this->getField("STATUS_AJAK_PASANGAN")."',
					   PENUGASAN_ID 				= '".$this->getField("PENUGASAN_ID")."',
					   PREFIX_SPPD_AWAK_KAPAL 		= '".$this->getField("PREFIX_SPPD_AWAK_KAPAL")."',
					   LOKASI_ID_AWAL				= '".$this->getField("LOKASI_ID_AWAL")."',
					   LOKASI_ID_AKHIR				= '".$this->getField("LOKASI_ID_AKHIR")."',
					   JENIS_DETASERING				= '".$this->getField("JENIS_DETASERING")."',
					   NAMA_PENGGANTI				= '".$this->getField("NAMA_PENGGANTI")."',
					   KELAS_PENGGANTI				= '".$this->getField("KELAS_PENGGANTI")."',
					   AIRPORT_TAX_BERANGKAT= '".$this->getField("AIRPORT_TAX_BERANGKAT")."',
					   JABATAN_ID_PENGGANTI= '".$this->getField("JABATAN_ID_PENGGANTI")."',
					   JABATAN_NAMA_PENGGANTI= '".$this->getField("JABATAN_NAMA_PENGGANTI")."',
					   TANGGAL_SURAT = ".$this->getField("TANGGAL_SURAT").",
					   LAST_UPDATE_USER = '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE =  SYSDATE 
				WHERE  SPPD_ID 			 = '".$this->getField("SPPD_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateKirimJurnal()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD
				SET    STATUS_KIRIM_JURNAL = 1, NO_JURNAL = '". $this->getField("NO_JURNAL") ."' 
				WHERE  SPPD_ID 			 = '". $this->getField("SPPD_ID") ."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateRealisasi()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD
				SET    TANGGAL_BERANGKAT_REALISASI = ".$this->getField("TANGGAL_BERANGKAT_REALISASI").",
					   TANGGAL_KEMBALI_REALISASI   = ".$this->getField("TANGGAL_KEMBALI_REALISASI").",
					   LAMA_PERJALANAN_REALISASI   = '".$this->getField("LAMA_PERJALANAN_REALISASI")."'
				WHERE  SPPD_ID 			 = '".$this->getField("SPPD_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateBatal()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD
				SET    STATUS_BATAL = 1,
					   ALASAN_BATAL   = '".$this->getField("ALASAN_BATAL")."'
				WHERE  SPPD_ID 			 = '".$this->getField("SPPD_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateStatusRealisasi(){
    	$str = "
				UPDATE PPI_SPPD.SPPD
					   STATUS_REALISASI   = '".$this->getField("STATUS_REALISASI")."'
				WHERE  SPPD_ID 			 = '".$this->getField("SPPD_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
		$str1 = "DELETE FROM PPI_SPPD.SPPD_MAKSUD
                WHERE 
                  SPPD_ID = ".$this->getField("SPPD_ID").""; 
				  
		$this->query = $str1;
        $this->execQuery($str1);
		
		$str2 = "DELETE FROM PPI_SPPD.SPPD_TUJUAN
                WHERE 
                  SPPD_ID = ".$this->getField("SPPD_ID").""; 
				  
		$this->query = $str2;
        $this->execQuery($str2);
		
		$str3 = "DELETE FROM PPI_SPPD.SPPD_PESERTA
                WHERE 
                  SPPD_ID = ".$this->getField("SPPD_ID").""; 
				  
		$this->query = $str3;
        $this->execQuery($str3);
		
		$str4 = "DELETE FROM PPI_SPPD.TGJAWAB_LAPORAN_SPPD
                WHERE 
                  SPPD_ID = ".$this->getField("SPPD_ID").""; 
				  
		$this->query = $str4;
        $this->execQuery($str4);
		
		$str5 = "DELETE FROM PPI_SPPD.TGJAWAB_NOTA_SPPD
                WHERE 
                  SPPD_ID = ".$this->getField("SPPD_ID").""; 
				  
		$this->query = $str5;
        $this->execQuery($str5);
		
        $str = "DELETE FROM PPI_SPPD.SPPD
                WHERE 
                  SPPD_ID = ".$this->getField("SPPD_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT 
                A.SPPD_ID, A.JENIS_SPPD_ID, A.ANGKUTAN_ID, A.MATA_ANGGARAN_ID, A.LAMA_PERJALANAN, A.NO_NOTA, A.NO_JURNAL, 
                A.PEGAWAI_ID, BERANGKAT_DARI, PPI_SPPD.AMBIL_TANGGAL_BERANGKAT_SPPD(A.SPPD_ID) TANGGAL_BERANGKAT, TANGGAL_KEMBALI, NOPOL,
                B.NAMA JENIS_SPPD,  C.NAMA ANGKUTAN, D.NAMA MATA_ANGGARAN, PPI_SPPD.AMBIL_MAKSUD_SPPD(A.SPPD_ID)MAKSUD_SPPD, 
                NVL(E.NAMA, A.NAMA_PENGGANTI) PEGAWAI, NVL(F.KELAS, A.KELAS_PENGGANTI) KELAS, NVL(F.NAMA, A.JABATAN_NAMA_PENGGANTI) JABATAN, CASE WHEN E.DEPARTEMEN_ID IS NOT NULL THEN PPI_SIMPEG.AMBIL_UNIT_KERJA(E.DEPARTEMEN_ID) END DEPARTEMEN,
                A.KETERANGAN, JUMLAH_ANAK, STATUS_BAWA_ISTRI, E.NRP, G.NAMA KOTA_BERANGKAT, PPI_SPPD.AMBIL_TUJUAN_SPPD(A.SPPD_ID) KOTA_TUJUAN, A.DASAR_SPPD,
                A.KOTA_ID_BERANGKAT, I.PROVINSI_ID PROVINSI_ID_BERANGKAT, I.NAMA PROVINSI_BERANGKAT, LOKASI_ID_AWAL, LOKASI_ID_AKHIR,
                K.NAMA LOKASI_AWAL, L.NAMA LOKASI_AKHIR,
                PPI_SPPD.AMBIL_KOTA_ID_TUJUAN_SPPD(A.SPPD_ID) KOTA_ID_TUJUAN,  
                PPI_SPPD.AMBIL_PROV_ID_TUJUAN_SPPD(A.SPPD_ID) PROVINSI_ID_TUJUAN,  
                PPI_SPPD.AMBIL_PROV_TUJUAN_SPPD(A.SPPD_ID) PROVINSI_TUJUAN, A.FASILITAS_DIKLAT_ID, A.STATUS_AJAK_PASANGAN,
                NVL(TANGGAL_BERANGKAT_REALISASI, TANGGAL_BERANGKAT) TANGGAL_BERANGKAT_REALISASI, 
                NVL(TANGGAL_KEMBALI_REALISASI, TANGGAL_KEMBALI) TANGGAL_KEMBALI_REALISASI, TANGGAL_SURAT,
                NVL(LAMA_PERJALANAN_REALISASI, LAMA_PERJALANAN) LAMA_PERJALANAN_REALISASI, A.JENIS_DETASERING, A.NAMA_PENGGANTI, A.KELAS_PENGGANTI, A.AIRPORT_TAX_BERANGKAT
                FROM PPI_SPPD.SPPD A 
                INNER JOIN PPI_SPPD.JENIS_SPPD B ON A.JENIS_SPPD_ID = B.JENIS_SPPD_ID
                INNER JOIN PPI_SPPD.ANGKUTAN C ON A.ANGKUTAN_ID = C.ANGKUTAN_ID
                INNER JOIN PPI_SPPD.MATA_ANGGARAN D ON A.MATA_ANGGARAN_ID = D.MATA_ANGGARAN_ID       
                LEFT JOIN PPI_SIMPEG.PEGAWAI E ON A.PEGAWAI_ID = E.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR F ON E.PEGAWAI_ID = F.PEGAWAI_ID
                LEFT JOIN PPI_SPPD.KOTA G ON A.KOTA_ID_BERANGKAT = G.KOTA_ID
                LEFT JOIN PPI_SPPD.PROVINSI I ON  G.PROVINSI_ID = I.PROVINSI_ID
                LEFT JOIN PPI_OPERASIONAL.LOKASI K ON A.LOKASI_ID_AWAL=K.LOKASI_ID
                LEFT JOIN PPI_OPERASIONAL.LOKASI L ON A.LOKASI_ID_AKHIR=L.LOKASI_ID
                WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsPengganti($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT 
                A.SPPD_ID, A.JENIS_SPPD_ID, A.ANGKUTAN_ID, A.MATA_ANGGARAN_ID, A.LAMA_PERJALANAN,
                A.PEGAWAI_ID, BERANGKAT_DARI, TANGGAL_BERANGKAT, TANGGAL_KEMBALI, NOPOL,
                B.NAMA JENIS_SPPD,  C.NAMA ANGKUTAN, D.NAMA MATA_ANGGARAN, PPI_SPPD.AMBIL_MAKSUD_SPPD(SPPD_ID) MAKSUD_SPPD, 
                A.KETERANGAN, JUMLAH_ANAK, STATUS_BAWA_ISTRI, G.NAMA KOTA_BERANGKAT, H.NAMA KOTA_TUJUAN, M.NAMA KOTA_TUJUAN_BERIKUTNYA, A.DASAR_SPPD,
                A.KOTA_ID_BERANGKAT, I.PROVINSI_ID PROVINSI_ID_BERANGKAT, I.NAMA PROVINSI_BERANGKAT, LOKASI_ID_AWAL, LOKASI_ID_AKHIR,
                K.NAMA LOKASI_AWAL, L.NAMA LOKASI_AKHIR,
                A.KOTA_ID_TUJUAN, J.PROVINSI_ID PROVINSI_ID_TUJUAN, A.KOTA_ID_TUJUAN_BERIKUTNYA, N.PROVINSI_ID PROVINSI_ID_TUJUAN_BERIKUTNYA, 
                J.NAMA PROVINSI_TUJUAN, N.NAMA PROVINSI_TUJUAN_BERIKUTNYA, A.FASILITAS_DIKLAT_ID, A.STATUS_AJAK_PASANGAN,
                NVL(TANGGAL_BERANGKAT_REALISASI, TANGGAL_BERANGKAT) TANGGAL_BERANGKAT_REALISASI, 
                NVL(TANGGAL_KEMBALI_REALISASI, TANGGAL_KEMBALI) TANGGAL_KEMBALI_REALISASI, 
                NVL(LAMA_PERJALANAN_REALISASI, LAMA_PERJALANAN) LAMA_PERJALANAN_REALISASI, TANGGAL_SURAT,
                A.TANGGAL_BERANGKAT_BERIKUTNYA, A.JENIS_DETASERING, A.NAMA_PENGGANTI, A.KELAS_PENGGANTI, A.JABATAN_ID_PENGGANTI, A.JABATAN_NAMA_PENGGANTI, A.AIRPORT_TAX_BERANGKAT
                FROM PPI_SPPD.SPPD A 
                INNER JOIN PPI_SPPD.JENIS_SPPD B ON A.JENIS_SPPD_ID = B.JENIS_SPPD_ID
                INNER JOIN PPI_SPPD.ANGKUTAN C ON A.ANGKUTAN_ID = C.ANGKUTAN_ID
                INNER JOIN PPI_SPPD.MATA_ANGGARAN D ON A.MATA_ANGGARAN_ID = D.MATA_ANGGARAN_ID       
               	LEFT JOIN PPI_SPPD.KOTA G ON A.KOTA_ID_BERANGKAT = G.KOTA_ID
                LEFT JOIN PPI_SPPD.KOTA H ON  A.KOTA_ID_TUJUAN = H.KOTA_ID
                LEFT JOIN PPI_SPPD.PROVINSI I ON  G.PROVINSI_ID = I.PROVINSI_ID
                LEFT JOIN PPI_SPPD.PROVINSI J ON  H.PROVINSI_ID = J.PROVINSI_ID
                LEFT JOIN PPI_OPERASIONAL.LOKASI K ON A.LOKASI_ID_AWAL=K.LOKASI_ID
                LEFT JOIN PPI_OPERASIONAL.LOKASI L ON A.LOKASI_ID_AKHIR=L.LOKASI_ID
                LEFT JOIN PPI_SPPD.KOTA M ON A.KOTA_ID_TUJUAN_BERIKUTNYA = M.KOTA_ID
                LEFT JOIN PPI_SPPD.PROVINSI N ON M.PROVINSI_ID = N.PROVINSI_ID
                WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsAwakKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT 
                A.SPPD_ID, A.JENIS_SPPD_ID, A.ANGKUTAN_ID, A.MATA_ANGGARAN_ID, A.LAMA_PERJALANAN,
                A.PEGAWAI_ID, BERANGKAT_DARI, TANGGAL_BERANGKAT, TANGGAL_KEMBALI, NOPOL, TANGGAL_SURAT,
                B.NAMA JENIS_SPPD,  C.NAMA ANGKUTAN, D.NAMA MATA_ANGGARAN, PPI_SPPD.AMBIL_MAKSUD_SPPD(SPPD_ID)MAKSUD_SPPD, 
                NVL(E.NAMA, K.NAMA)  PEGAWAI, F.KELAS, F.NAMA JABATAN, CASE WHEN E.DEPARTEMEN_ID IS NULL THEN NULL ELSE PPI_SIMPEG.AMBIL_UNIT_KERJA(E.DEPARTEMEN_ID) END DEPARTEMEN,
                A.KETERANGAN, JUMLAH_ANAK, STATUS_BAWA_ISTRI, E.NRP, G.NAMA KOTA_BERANGKAT, H.NAMA KOTA_TUJUAN, A.DASAR_SPPD,
                A.KOTA_ID_BERANGKAT, I.PROVINSI_ID PROVINSI_ID_BERANGKAT, I.NAMA PROVINSI_BERANGKAT, 
                A.KOTA_ID_TUJUAN, J.PROVINSI_ID PROVINSI_ID_TUJUAN, J.NAMA PROVINSI_TUJUAN, A.FASILITAS_DIKLAT_ID, A.STATUS_AJAK_PASANGAN, A.PENUGASAN_ID, A.PREFIX_SPPD_AWAK_KAPAL,
				K.NOMOR
                FROM PPI_SPPD.SPPD A 
                INNER JOIN PPI_SPPD.JENIS_SPPD B ON A.JENIS_SPPD_ID = B.JENIS_SPPD_ID
                INNER JOIN PPI_SPPD.ANGKUTAN C ON A.ANGKUTAN_ID = C.ANGKUTAN_ID
                INNER JOIN PPI_SPPD.MATA_ANGGARAN D ON A.MATA_ANGGARAN_ID = D.MATA_ANGGARAN_ID       
                LEFT JOIN PPI_SIMPEG.PEGAWAI E ON A.PEGAWAI_ID = E.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR F ON E.PEGAWAI_ID = F.PEGAWAI_ID
                LEFT JOIN PPI_SPPD.KOTA G ON A.KOTA_ID_BERANGKAT = G.KOTA_ID
                LEFT JOIN PPI_SPPD.KOTA H ON  A.KOTA_ID_TUJUAN = H.KOTA_ID
                LEFT JOIN PPI_SPPD.PROVINSI I ON  G.PROVINSI_ID = I.PROVINSI_ID
                LEFT JOIN PPI_SPPD.PROVINSI J ON  H.PROVINSI_ID = J.PROVINSI_ID
                LEFT JOIN PPI_OPERASIONAL.PENUGASAN K ON A.PENUGASAN_ID = K.PENUGASAN_ID
                WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    } 
    
	function selectByParamsPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT A.SPPD_ID, C.NAMA JENIS_SPPD, PPI_SPPD.AMBIL_TUJUAN_SPPD(A.SPPD_ID) KOTA, A.TANGGAL_BERANGKAT_BERIKUTNYA, JENIS_DETASERING, C.PREFIX
                FROM PPI_SPPD.SPPD A
                   INNER JOIN PPI_SPPD.SPPD_PESERTA B ON A.SPPD_ID = B.SPPD_ID
                   INNER JOIN PPI_SPPD.JENIS_SPPD C ON A.JENIS_SPPD_ID = C.JENIS_SPPD_ID
                WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

    function cekDepartemenLockedByPegawai($pegawai_id=''){
    	$str = "SELECT  A.NAMA, B.NAMA AS DEPARTEMEN, D.NAMA AS JABATAN_NAMA, C.KELAS,   B.STATUS_LOCK_SPPD,
			    E.SPPD_ID, E.KETERANGAN
			FROM PPI_SIMPEG.PEGAWAI A
			LEFT JOIN PPI_SIMPEG.DEPARTEMEN B ON SUBSTR(A.DEPARTEMEN_ID,0,2) = B.DEPARTEMEN_ID
			LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_KELAS C ON A.PEGAWAI_ID = C.PEGAWAI_ID
			LEFT JOIN PPI_SIMPEG.JABATAN D ON C.JABATAN_ID = D.JABATAN_ID 
			LEFT JOIN (SELECT X.SPPD_ID, X.DEPARTEMEN_ID, 
			    Z.NAMA ||' telah terlock dengan SPPD dari ' || YY.NAMA || ' ' || Y.NAMA || ' yang harus dipertanggungjawabkan pada tanggal ' || TRIM(TO_CHAR(X.LOCKED_DATE, 'DD-MM-YYYY')) KETERANGAN
			    FROM PPI_SPPD.SPPD_LOCKED X
			    LEFT JOIN PPI_SPPD.SPPD_MAKSUD Y ON X.SPPD_ID = Y.SPPD_ID
			    LEFT JOIN PPI_SIMPEG.DEPARTEMEN Z ON Z.DEPARTEMEN_ID = X.DEPARTEMEN_ID
			    LEFT JOIN PPI_SPPD.SPPD_PESERTA ZZ ON ZZ.SPPD_ID = X.SPPD_ID AND ZZ.STATUS = 'U'
			    LEFT JOIN PPI_SIMPEG.PEGAWAI YY ON ZZ.PEGAWAI_ID = YY.PEGAWAI_ID
			    WHERE X.UNLOCKED_DATE IS NULL  ) E ON E.DEPARTEMEN_ID =  SUBSTR(A.DEPARTEMEN_ID,0,2) 
			WHERE A.PEGAWAI_ID = ". $pegawai_id ."  AND ROWNUM = 1 ";
        $this->query = $str;	
		return $this->selectLimit($str,-1,-1); 
    }
	function selectByParamsKadaluarsa($paramsArray=array(),$limit=-1,$from=-1, $batas_notifikasi=5, $statement="", $order="")
	{
		$str = "SELECT 
                A.SPPD_ID, A.LAMA_PERJALANAN,
                TANGGAL_BERANGKAT, NVL(A.TANGGAL_KEMBALI, A.TANGGAL_BERANGKAT) TANGGAL_KEMBALI, 
                B.NAMA JENIS_SPPD,  C.NAMA ANGKUTAN, D.NAMA MATA_ANGGARAN, PPI_SPPD.AMBIL_MAKSUD_SPPD(SPPD_ID)MAKSUD_SPPD, 
                E.NAMA PEGAWAI, F.KELAS, F.NAMA JABATAN, PPI_SIMPEG.AMBIL_UNIT_KERJA(E.DEPARTEMEN_ID) DEPARTEMEN,
                E.NRP, G.NAMA KOTA_BERANGKAT, H.NAMA KOTA_TUJUAN, M.NAMA KOTA_TUJUAN_BERIKUTNYA, A.DASAR_SPPD,
                A.KOTA_ID_BERANGKAT, I.PROVINSI_ID PROVINSI_ID_BERANGKAT, I.NAMA PROVINSI_BERANGKAT, LOKASI_ID_AWAL, LOKASI_ID_AKHIR,
                K.NAMA LOKASI_AWAL, L.NAMA LOKASI_AKHIR, TANGGAL_SURAT,
                A.KOTA_ID_TUJUAN, J.PROVINSI_ID PROVINSI_ID_TUJUAN, A.KOTA_ID_TUJUAN_BERIKUTNYA, N.PROVINSI_ID PROVINSI_ID_TUJUAN_BERIKUTNYA, 
                J.NAMA PROVINSI_TUJUAN, N.NAMA PROVINSI_TUJUAN_BERIKUTNYA, A.FASILITAS_DIKLAT_ID, A.STATUS_AJAK_PASANGAN,
                NVL(TANGGAL_BERANGKAT_REALISASI, TANGGAL_BERANGKAT) TANGGAL_BERANGKAT_REALISASI, 
                NVL(TANGGAL_KEMBALI_REALISASI, TANGGAL_KEMBALI) TANGGAL_KEMBALI_REALISASI, 
                NVL(LAMA_PERJALANAN_REALISASI, LAMA_PERJALANAN) LAMA_PERJALANAN_REALISASI,
                A.TANGGAL_BERANGKAT_BERIKUTNYA, A.JENIS_DETASERING,
                CASE 
                 WHEN SYSDATE BETWEEN NVL(A.TANGGAL_KEMBALI, A.TANGGAL_BERANGKAT) AND (NVL(A.TANGGAL_KEMBALI, A.TANGGAL_BERANGKAT) + INTERVAL '".$batas_notifikasi."' DAY) THEN 1
                 WHEN (NVL(A.TANGGAL_KEMBALI, A.TANGGAL_BERANGKAT) + INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE THEN 2
                 ELSE 0
                END STATUS,
                CASE 
                     WHEN (NVL(A.TANGGAL_KEMBALI, A.TANGGAL_BERANGKAT) + INTERVAL '7' DAY - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND (NVL(A.TANGGAL_KEMBALI, A.TANGGAL_BERANGKAT) + INTERVAL '7' DAY) > SYSDATE THEN 'Hampir batas laporan'
                     WHEN (NVL(A.TANGGAL_KEMBALI, A.TANGGAL_BERANGKAT) + INTERVAL '7' DAY)  <= SYSDATE THEN 'Batas pelaporan habis'
                    ELSE 'Aktif'
                END STATUS_INFO
                FROM PPI_SPPD.SPPD A 
                INNER JOIN PPI_SPPD.JENIS_SPPD B ON A.JENIS_SPPD_ID = B.JENIS_SPPD_ID
                INNER JOIN PPI_SPPD.ANGKUTAN C ON A.ANGKUTAN_ID = C.ANGKUTAN_ID
                INNER JOIN PPI_SPPD.MATA_ANGGARAN D ON A.MATA_ANGGARAN_ID = D.MATA_ANGGARAN_ID       
                INNER JOIN PPI_SIMPEG.PEGAWAI E ON A.PEGAWAI_ID = E.PEGAWAI_ID
                INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR F ON E.PEGAWAI_ID = F.PEGAWAI_ID
                LEFT JOIN PPI_SPPD.KOTA G ON A.KOTA_ID_BERANGKAT = G.KOTA_ID
                LEFT JOIN PPI_SPPD.KOTA H ON  A.KOTA_ID_TUJUAN = H.KOTA_ID
                LEFT JOIN PPI_SPPD.PROVINSI I ON  G.PROVINSI_ID = I.PROVINSI_ID
                LEFT JOIN PPI_SPPD.PROVINSI J ON  H.PROVINSI_ID = J.PROVINSI_ID
                LEFT JOIN PPI_OPERASIONAL.LOKASI K ON A.LOKASI_ID_AWAL=K.LOKASI_ID
                LEFT JOIN PPI_OPERASIONAL.LOKASI L ON A.LOKASI_ID_AKHIR=L.LOKASI_ID
                LEFT JOIN PPI_SPPD.KOTA M ON A.KOTA_ID_TUJUAN_BERIKUTNYA = M.KOTA_ID
                LEFT JOIN PPI_SPPD.PROVINSI N ON M.PROVINSI_ID = N.PROVINSI_ID
                WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsCheckPeserta($sppd_id, $pegawai_id,$limit=-1,$from=-1)
	{
		$str = "SELECT A.SPPD_ID, C.NAMA JENIS_SPPD, D.NAMA KOTA FROM PPI_SPPD.SPPD A 
								INNER JOIN PPI_SPPD.SPPD_PESERTA B ON A.SPPD_ID = B.SPPD_ID
								INNER JOIN PPI_SPPD.JENIS_SPPD C ON A.JENIS_SPPD_ID = C.JENIS_SPPD_ID
								INNER JOIN PPI_SPPD.KOTA D ON A.KOTA_ID_TUJUAN = D.KOTA_ID
								INNER JOIN PPI_SPPD.SPPD E ON E.SPPD_ID = '".$sppd_id."' AND
                                (E.TANGGAL_BERANGKAT BETWEEN A.TANGGAL_BERANGKAT AND A.TANGGAL_KEMBALI OR 
                                 E.TANGGAL_KEMBALI BETWEEN A.TANGGAL_BERANGKAT AND A.TANGGAL_KEMBALI OR
                                 A.TANGGAL_BERANGKAT BETWEEN E.TANGGAL_BERANGKAT AND E.TANGGAL_KEMBALI OR
                                 A.TANGGAL_KEMBALI BETWEEN E.TANGGAL_BERANGKAT AND E.TANGGAL_KEMBALI
                                ) AND NOT A.SPPD_ID = '".$sppd_id."'
				 WHERE B.PEGAWAI_ID = '".$pegawai_id."' 
				"; 
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "SELECT 
					SPPD_ID, PEGAWAI_ID, ANGKUTAN_ID, 
				   MATA_ANGGARAN_ID, JENIS_SPPD_ID, BERANGKAT_DARI, 
				   TANGGAL_BERANGKAT, TANGGAL_KEMBALI, NOPOL, 
				   LAMA_PERJALANAN, KETERANGAN, JUMLAH_ANAK, 
				   STATUS_BAWA_ISTRI
				FROM PPI_SPPD.SPPD
				WHERE 1 = 1
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
		$str = "SELECT COUNT(A.SPPD_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD A 
                INNER JOIN PPI_SPPD.JENIS_SPPD B ON A.JENIS_SPPD_ID = B.JENIS_SPPD_ID
                INNER JOIN PPI_SPPD.ANGKUTAN C ON A.ANGKUTAN_ID = C.ANGKUTAN_ID
                INNER JOIN PPI_SPPD.MATA_ANGGARAN D ON A.MATA_ANGGARAN_ID = D.MATA_ANGGARAN_ID       
                LEFT JOIN PPI_SIMPEG.PEGAWAI E ON A.PEGAWAI_ID = E.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR F ON E.PEGAWAI_ID = F.PEGAWAI_ID
                LEFT JOIN PPI_SPPD.KOTA G ON A.KOTA_ID_BERANGKAT = G.KOTA_ID
                LEFT JOIN PPI_SPPD.KOTA H ON  A.KOTA_ID_TUJUAN = H.KOTA_ID
                LEFT JOIN PPI_SPPD.PROVINSI I ON  G.PROVINSI_ID = I.PROVINSI_ID
                LEFT JOIN PPI_SPPD.PROVINSI J ON  H.PROVINSI_ID = J.PROVINSI_ID
                LEFT JOIN PPI_OPERASIONAL.LOKASI K ON A.LOKASI_ID_AWAL=K.LOKASI_ID
                LEFT JOIN PPI_OPERASIONAL.LOKASI L ON A.LOKASI_ID_AKHIR=L.LOKASI_ID
                LEFT JOIN PPI_SPPD.KOTA M ON A.KOTA_ID_TUJUAN_BERIKUTNYA = M.KOTA_ID
                LEFT JOIN PPI_SPPD.PROVINSI N ON M.PROVINSI_ID = N.PROVINSI_ID
                WHERE 1 = 1 ".$statement; 
		
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

    function getCountByParamsAwakKapal($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.SPPD_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD A 
                INNER JOIN PPI_SPPD.JENIS_SPPD B ON A.JENIS_SPPD_ID = B.JENIS_SPPD_ID
                INNER JOIN PPI_SPPD.ANGKUTAN C ON A.ANGKUTAN_ID = C.ANGKUTAN_ID
                INNER JOIN PPI_SPPD.MATA_ANGGARAN D ON A.MATA_ANGGARAN_ID = D.MATA_ANGGARAN_ID       
                LEFT JOIN PPI_SIMPEG.PEGAWAI E ON A.PEGAWAI_ID = E.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR F ON E.PEGAWAI_ID = F.PEGAWAI_ID
                LEFT JOIN PPI_SPPD.KOTA G ON A.KOTA_ID_BERANGKAT = G.KOTA_ID
                LEFT JOIN PPI_SPPD.KOTA H ON  A.KOTA_ID_TUJUAN = H.KOTA_ID
                LEFT JOIN PPI_SPPD.PROVINSI I ON  G.PROVINSI_ID = I.PROVINSI_ID
                LEFT JOIN PPI_SPPD.PROVINSI J ON  H.PROVINSI_ID = J.PROVINSI_ID
                LEFT JOIN PPI_OPERASIONAL.PENUGASAN K ON A.PENUGASAN_ID = K.PENUGASAN_ID
                WHERE 1 = 1 ".$statement; 
		
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
		$str = "SELECT COUNT(SPPD_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD

		        WHERE SPPD_ID IS NOT NULL ".$statement; 
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