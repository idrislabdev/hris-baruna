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

  class AnggaranMutasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AnggaranMutasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ANGGARAN_MUTASI_ID", $this->getNextId("ANGGARAN_MUTASI_ID","PEL_ANGGARAN.ANGGARAN_MUTASI")); 
		$str = "
				INSERT INTO PEL_ANGGARAN.ANGGARAN_MUTASI (
				   ANGGARAN_MUTASI_ID, NO_NOTA, PEGAWAI_ID, 
				   THN_BUKU, BLN_BUKU, TGL_TRANS, 
				   TGL_ENTRY, KD_VALUTA, TGL_VALUTA, 
				   KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
				   KET_TAMBAH, NO_POSTING, TGL_POSTING, 
				   JML_CETAK, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				   PROGRAM_NAME, NO_REF1, NO_REF2, 
				   NO_REF3, PAJAK, UANG_MUKA, JENIS_ANGGARAN_ID, PUSPEL, PUSPEL_NAMA, STATUS_PERMOHONAN, 
				   JML_VAL_PAJAK, JML_VAL_REALISASI, JML_VAL_LEBIH_KURANG, PUSPEL_SUB_BANTU, SUPPLIER)
				VALUES(
					  ".$this->getField("ANGGARAN_MUTASI_ID").",
					  '".$this->getField("NO_NOTA")."',
					  '".$this->getField("PEGAWAI_ID")."',
					  '".$this->getField("THN_BUKU")."',
					  '".$this->getField("BLN_BUKU")."',
					  ".$this->getField("TGL_TRANS").",
					  ".$this->getField("TGL_ENTRY").",
					  '".$this->getField("KD_VALUTA")."',
					  ".$this->getField("TGL_VALUTA").",
					  '".$this->getField("KURS_VALUTA")."',
					  '".$this->getField("JML_VAL_TRANS")."',
					  '".$this->getField("JML_RP_TRANS")."',
					  '".$this->getField("KET_TAMBAH")."',
					  '".$this->getField("NO_POSTING")."',
					  ".$this->getField("TGL_POSTING").",
					  '".$this->getField("JML_CETAK")."',
					  ".$this->getField("LAST_UPDATE_DATE").",
					  '".$this->getField("LAST_UPDATED_BY")."',
					  '".$this->getField("PROGRAM_NAME")."',
					  '".$this->getField("NO_REF1")."',
					  '".$this->getField("NO_REF2")."',
					  '".$this->getField("NO_REF3")."',
					  '".$this->getField("PAJAK")."',
					  '".$this->getField("UANG_MUKA")."',
					  '".$this->getField("JENIS_ANGGARAN_ID")."',
					  '".$this->getField("PUSPEL")."',
					  '".$this->getField("PUSPEL_NAMA")."',
					  '".$this->getField("STATUS_PERMOHONAN")."',
					  '".$this->getField("JML_VAL_PAJAK")."',
					  '".$this->getField("JML_VAL_REALISASI")."',
					  '".$this->getField("JML_VAL_LEBIH_KURANG")."',
					  '".$this->getField("PUSPEL_SUB_BANTU")."',
					  '".$this->getField("SUPPLIER")."'
				)"; 
		$this->id = $this->getField("ANGGARAN_MUTASI_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET 
					  NO_NOTA = '".$this->getField("NO_NOTA")."',
					  PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."',
					  THN_BUKU = '".$this->getField("THN_BUKU")."',
					  BLN_BUKU = '".$this->getField("BLN_BUKU")."',
					  TGL_TRANS = ".$this->getField("TGL_TRANS").",
					  TGL_ENTRY = ".$this->getField("TGL_ENTRY").",
					  KD_VALUTA = '".$this->getField("KD_VALUTA")."',
					  TGL_VALUTA = ".$this->getField("TGL_VALUTA").",
					  KURS_VALUTA = '".$this->getField("KURS_VALUTA")."',
					  JML_VAL_TRANS = '".$this->getField("JML_VAL_TRANS")."',
					  JML_RP_TRANS = '".$this->getField("JML_RP_TRANS")."',
					  KET_TAMBAH = '".$this->getField("KET_TAMBAH")."',
					  NO_POSTING = '".$this->getField("NO_POSTING")."',
					  TGL_POSTING = ".$this->getField("TGL_POSTING").",
					  JML_CETAK = '".$this->getField("JML_CETAK")."',
					  LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					  LAST_UPDATED_BY = '".$this->getField("LAST_UPDATED_BY")."',
					  PROGRAM_NAME = '".$this->getField("PROGRAM_NAME")."',
					  NO_REF1 = '".$this->getField("NO_REF1")."',
					  NO_REF2 = '".$this->getField("NO_REF2")."',
					  NO_REF3 = '".$this->getField("NO_REF3")."',
					  PAJAK = '".$this->getField("PAJAK")."',
					  UANG_MUKA = '".$this->getField("UANG_MUKA")."',
					  JML_VAL_PAJAK = '".$this->getField("JML_VAL_PAJAK")."',
					  JML_VAL_REALISASI = '".$this->getField("JML_VAL_REALISASI")."',
					  JML_VAL_LEBIH_KURANG = '".$this->getField("JML_VAL_LEBIH_KURANG")."',
					  PUSPEL_SUB_BANTU = '".$this->getField("PUSPEL_SUB_BANTU")."',
					  PUSPEL = '".$this->getField("PUSPEL")."',
					  PUSPEL_NAMA = '".$this->getField("PUSPEL_NAMA")."',
					  SUPPLIER = '".$this->getField("SUPPLIER")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateStatus()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET VERIFIKASI= '".$this->getField("VERIFIKASI")."',
			   	   VERIFIKASI_ALASAN = '".$this->getField("VERIFIKASI_ALASAN")."',
			   	   VERIFIKASI_MANKEU_BY = '".$this->getField("VERIFIKASI_MANKEU_BY")."',
			   	   VERIFIKASI_MANKEU_DATE = SYSDATE,
				   UANG_MUKA = '".$this->getField("UANG_MUKA")."',
				   JML_VAL_PAJAK = '".$this->getField("JML_VAL_PAJAK")."',
				   JML_VAL_TRANS = '".$this->getField("JML_VAL_TRANS")."',
				   JML_RP_TRANS = '".$this->getField("JML_RP_TRANS")."',
				   KD_BUKU_BESAR_UM = '".$this->getField("KD_BUKU_BESAR_UM")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function updateStatusVerifikasiStaff()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET VERIFIKASI_ALASAN = '".$this->getField("VERIFIKASI_ALASAN")."',
				   JML_VAL_PAJAK = '".$this->getField("JML_VAL_PAJAK")."',
				   JML_VAL_TRANS = '".$this->getField("JML_VAL_TRANS")."',
				   JML_RP_TRANS = '".$this->getField("JML_RP_TRANS")."',
				   KD_BUKU_BESAR_UM = '".$this->getField("KD_BUKU_BESAR_UM")."',
			   	   VERIFIKASI_STAFF_DATE = SYSDATE,
				   VERIFIKASI_STAFF_BY = '".$this->getField("VERIFIKASI_STAFF_BY")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }


	function updateStatusVerifikasiAsman()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET VERIFIKASI_ALASAN = '".$this->getField("VERIFIKASI_ALASAN")."',
				   JML_VAL_PAJAK = '".$this->getField("JML_VAL_PAJAK")."',
				   JML_VAL_TRANS = '".$this->getField("JML_VAL_TRANS")."',
				   JML_RP_TRANS = '".$this->getField("JML_RP_TRANS")."',
				   KD_BUKU_BESAR_UM = '".$this->getField("KD_BUKU_BESAR_UM")."',
			   	   VERIFIKASI_DATE = SYSDATE,
				   VERIFIKASI_BY = '".$this->getField("VERIFIKASI_BY")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function updateStatusVerifikasiTgjawabStaff()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET VERIFIKASI_TGJAWAB_STAFF_DATE = SYSDATE,
				   VERIFIKASI_TGJAWAB_STAFF_BY = '".$this->getField("VERIFIKASI_TGJAWAB_STAFF_BY")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateStatusVerifikasiTgjawabAsman()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET VERIFIKASI_TGJAWAB_DATE = SYSDATE,
				   VERIFIKASI_TGJAWAB_BY = '".$this->getField("VERIFIKASI_TGJAWAB_BY")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
			
	function updateNotaDinas()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET NOTA_DINAS_1  = '".$this->getField("NOTA_DINAS_1")."',
			   	   NOTA_DINAS_2  = '".$this->getField("NOTA_DINAS_2")."',
				   NOTA_DINAS_3  = '".$this->getField("NOTA_DINAS_3")."',
				   NO_REF3		 = '".$this->getField("NO_REF3")."',
				   TTD_1		 = '".$this->getField("TTD_1")."',
				   TTD_JABATAN_1 = '".$this->getField("TTD_JABATAN_1")."',
				   TTD_2		 = '".$this->getField("TTD_2")."',
				   TTD_JABATAN_2 = '".$this->getField("TTD_JABATAN_2")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }	

	function updateApproved()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET APPROVED_BY   = '".$this->getField("APPROVED_BY")."',
			   	   APPROVED_DATE = SYSDATE,
				   APPROVED_JABATAN = '".$this->getField("APPROVED_JABATAN")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function updateApprovedKadiv()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET APPROVED_KADIV_BY   = '".$this->getField("APPROVED_KADIV_BY")."',
			   	   APPROVED_KADIV_DATE = SYSDATE
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
		
	function update_file()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PEL_ANGGARAN.ANGGARAN_MUTASI 
				SET
				  	NOTA_DINAS_UPLOAD = '".$this->getField("NOTA_DINAS_UPLOAD")."'
				WHERE ANGGARAN_MUTASI_ID = '".$this->getField("ANGGARAN_MUTASI_ID")."'
				"; 
				
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function update_file_tgjawab()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PEL_ANGGARAN.ANGGARAN_MUTASI 
				SET
				  	TGJAWAB_UPLOAD = '".$this->getField("TGJAWAB_UPLOAD")."'
				WHERE ANGGARAN_MUTASI_ID = '".$this->getField("ANGGARAN_MUTASI_ID")."'
				"; 
				
				$this->query = $str;
		return $this->execQuery($str);
    }

	function updateApprovedPertanggungjawaban()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET APPROVED_TGJAWAB_BY   = '".$this->getField("APPROVED_TGJAWAB_BY")."',
			   	   APPROVED_TGJAWAB_DATE = SYSDATE
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function updateApprovedPertanggungjawabanKadiv()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET APPROVED_TGJAWAB_KADIV_BY   = '".$this->getField("APPROVED_TGJAWAB_KADIV_BY")."',
			   	   APPROVED_TGJAWAB_KADIV_DATE = SYSDATE
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				//echo $str;
				$this->query = $str;
		return $this->execQuery($str);
    }
		
	function updatePertanggungjawaban()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET NO_REF2				  = '".$this->getField("NO_REF2")."',
			   	   TGL_PERTANGGUNGJAWABAN = SYSDATE,
				   JML_VAL_REALISASI	  = '".$this->getField("JML_VAL_REALISASI")."',
				   TG_JAWAB_BY	  		  = '".$this->getField("TG_JAWAB_BY")."',
				   JML_VAL_LEBIH_KURANG   = '".$this->getField("JML_VAL_LEBIH_KURANG")."',
				   PUSPEL_SUB_BANTU   = '".$this->getField("PUSPEL_SUB_BANTU")."',
				   SUPPLIER			  = '".$this->getField("SUPPLIER")."',
				   JML_VAL_PAJAK_REALISASI = '".$this->getField("JML_VAL_PAJAK_REALISASI")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateStatusKirimLebihKurang()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET 
				   STATUS_KIRIM_LEBIH_KURANG = 1,
				   NO_NOTA_TANGGUNGJAWAB   = '".$this->getField("NO_NOTA_TANGGUNGJAWAB")."',
				   TG_JAWAB_MANKEU_BY   = '".$this->getField("TG_JAWAB_MANKEU_BY")."',
				   TG_JAWAB_MANKEU_DATE   = SYSDATE,
				   NO_NOTA_TANGGUNGJAWAB_SISA   = '".$this->getField("NO_NOTA_TANGGUNGJAWAB_SISA")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function updateNoNotaUM()
	{
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI
			   SET 
				   NO_NOTA_UM = '".$this->getField("NO_NOTA_UM")."'
			   WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	
	function getStatusBolehDelete()
	{
        $str = "SELECT CASE WHEN APPROVED_KADIV_DATE IS NULL THEN 'BOLEH' ELSE 'TIDAK' END STATUS_DELETE FROM PEL_ANGGARAN.ANGGARAN_MUTASI
                WHERE 
                  ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID").""; 
				  
		$this->query = $str;
        return $this->selectLimit($str,-1,-1); 
    }

	
	function delete()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN_MUTASI
                WHERE 
                  ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
	function selectByParamsAnggaran($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT THN_BUKU, KD_BUKU_BESAR, KD_BUKU_BESAR || ' - ' || NM_BUKU_BESAR NM_BUKU_BESAR, KD_SUB_BANTU, 
				KD_BUKU_PUSAT, KD_BUKU_PUSAT || ' - ' || NM_BUKU_PUSAT NM_BUKU_PUSAT, NVL(ANGG_TAHUNAN, 0) ANGG_TAHUNAN, 
				NVL(ANGG_TRW1, 0) ANGG_TRW1, NVL(ANGG_TRW2, 0) ANGG_TRW2, NVL(ANGG_TRW3, 0) ANGG_TRW3, NVL(ANGG_TRW4, 0) ANGG_TRW4,
                 NVL(JUMLAH_MUTASI, 0) JUMLAH_MUTASI, NVL(JUMLAH_MUTASI_REAL, 0) JUMLAH_MUTASI_REAL, 
                 NVL(ANGG_TAHUNAN, 0) - NVL(JUMLAH_MUTASI_REAL, 0) SISA, D_K, REALISASI FROM MAINTENANCE_ANGGARAN_TAHUNAN@KEUANGAN
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				ANGGARAN_MUTASI_ID, NO_NOTA, A.PEGAWAI_ID,
				   THN_BUKU, BLN_BUKU, TGL_TRANS, 
				   /*BLN_BUKU || ' ' || THN_BUKU  PERIODE,*/
				   TO_CHAR(TO_DATE( BLN_BUKU || THN_BUKU, 'MMYYYY'), 'MONTH YYYY') PERIODE, 
				   TGL_ENTRY, KD_VALUTA, TGL_VALUTA, 
				   KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
				   KET_TAMBAH, NO_POSTING, TGL_POSTING, 
				   JML_CETAK, A.LAST_UPDATE_DATE, A.LAST_UPDATED_BY, 
				   A.PROGRAM_NAME, B.NAMA PEGAWAI, B.NRP, C.NAMA JABATAN, NO_REF1, NO_REF2, NO_REF3, PAJAK, VERIFIKASI, 
                   CASE WHEN VERIFIKASI = 'S' THEN 'Anggaran telah disetujui.' ELSE 'Anggaran ditolak.' END VERIFIKASI_STATUS, VERIFIKASI_ALASAN, UANG_MUKA,
                   D.NAMA JENIS_ANGGARAN, A.JENIS_ANGGARAN_ID, PUSPEL, PUSPEL_NAMA, PUSPEL_SUB_BANTU, 
                   (SELECT SUM(NVL(REALISASI, 0)) FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D X WHERE X.ANGGARAN_MUTASI_ID = A.ANGGARAN_MUTASI_ID) REALISASI,
				   NVL(STATUS_KIRIM_LEBIH_KURANG, 0) STATUS_KIRIM_LEBIH_KURANG, NO_NOTA_UM, NO_NOTA_TANGGUNGJAWAB, JML_VAL_REALISASI, JML_VAL_LEBIH_KURANG,
				   JML_VAL_PAJAK, SUPPLIER, PUSPEL || ' ' || NM_BUKU_BESAR NM_BUKU_BESAR, JML_VAL_PAJAK_REALISASI, TGJAWAB_UPLOAD, KD_BUKU_BESAR_UM
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI A 
                    INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                    INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                    INNER JOIN PEL_ANGGARAN.JENIS_ANGGARAN D ON A.JENIS_ANGGARAN_ID = D.JENIS_ANGGARAN_ID					
					LEFT JOIN KBBR_BUKU_PUSAT@KEUANGAN E ON A.PUSPEL = E.KD_BUKU_BESAR 
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsRealisasiAnggaran($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				ANGGARAN_MUTASI_ID, NO_NOTA, A.PEGAWAI_ID, 
				   THN_BUKU, BLN_BUKU, TGL_TRANS, BLN_BUKU || ' ' || THN_BUKU  PERIODE,
				   TGL_ENTRY, KD_VALUTA, TGL_VALUTA, 
				   KURS_VALUTA, COALESCE(JML_VAL_REALISASI, JML_VAL_TRANS) JML_VAL_TRANS, COALESCE(JML_VAL_REALISASI, JML_RP_TRANS) JML_RP_TRANS, 
				   KET_TAMBAH, NO_POSTING, TGL_POSTING, 
				   JML_CETAK, A.LAST_UPDATE_DATE, A.LAST_UPDATED_BY, 
				   A.PROGRAM_NAME, B.NAMA PEGAWAI, B.NRP, C.NAMA JABATAN, NO_REF1, NO_REF2, NO_REF3, PAJAK, VERIFIKASI, 
                   CASE WHEN VERIFIKASI = 'S' THEN 'Anggaran telah disetujui.' ELSE 'Anggaran ditolak.' END VERIFIKASI_STATUS, VERIFIKASI_ALASAN, UANG_MUKA,
                   D.NAMA JENIS_ANGGARAN, A.JENIS_ANGGARAN_ID, PUSPEL, PUSPEL_NAMA, PUSPEL_SUB_BANTU, 
                   (SELECT SUM(NVL(REALISASI, 0)) FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D X WHERE X.ANGGARAN_MUTASI_ID = A.ANGGARAN_MUTASI_ID) REALISASI,
				   NVL(STATUS_KIRIM_LEBIH_KURANG, 0) STATUS_KIRIM_LEBIH_KURANG, NO_NOTA_UM, NO_NOTA_TANGGUNGJAWAB, JML_VAL_REALISASI, JML_VAL_LEBIH_KURANG,
				   JML_VAL_PAJAK, SUPPLIER, PUSPEL || ' ' || NM_BUKU_BESAR NM_BUKU_BESAR, JML_VAL_PAJAK_REALISASI, TGJAWAB_UPLOAD
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI A 
                    INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                    INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                    INNER JOIN PEL_ANGGARAN.JENIS_ANGGARAN D ON A.JENIS_ANGGARAN_ID = D.JENIS_ANGGARAN_ID					
					LEFT JOIN KBBR_BUKU_PUSAT@KEUANGAN E ON A.PUSPEL = E.KD_BUKU_BESAR 
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
	
    function selectByParamsSimple($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT NO_NOTA, TO_CHAR(A.TGL_ENTRY, 'DD/MM/YYYY')  TGL_ENTRY, A.LAST_UPDATED_BY DICETAK_OLEH, TO_CHAR(SYSDATE, 'DD/MM/YYYY') TGL_CETAK,
				ANGGARAN_MUTASI_ID, NOTA_DINAS_1, NOTA_DINAS_2, NOTA_DINAS_3, NO_REF3, APPROVED_JABATAN, KET_TAMBAH, TGL_TRANS,
				APPROVED_BY, JML_VAL_TRANS, JML_VAL_PAJAK, PPI_GAJI.NOMINAL_TERBILANG(JML_VAL_TRANS) TERBILANG,
				TTD_1, TTD_JABATAN_1, TTD_2, TTD_JABATAN_2, NOTA_DINAS_UPLOAD, THN_BUKU
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI A 
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
	
    function selectByParamsPertanggungjawaban($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
                SELECT 
                ANGGARAN_MUTASI_ID, A.NO_NOTA, A.PEGAWAI_ID, 
                   THN_BUKU, BLN_BUKU, TGL_TRANS, BLN_BUKU || ' ' || THN_BUKU  PERIODE,
                   TGL_ENTRY, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
                   KET_TAMBAH, E.NO_POSTING, E.TGL_POSTING, 
                   JML_CETAK, A.LAST_UPDATE_DATE, A.LAST_UPDATED_BY, 
                   A.PROGRAM_NAME, B.NAMA PEGAWAI, B.NRP, C.NAMA JABATAN, NO_REF1, NO_REF2, NO_REF3, PAJAK, VERIFIKASI, 
                   CASE WHEN VERIFIKASI = 'S' THEN 'Anggaran telah disetujui.' ELSE 'Anggaran ditolak.' END VERIFIKASI_STATUS, VERIFIKASI_ALASAN, UANG_MUKA,
                   D.NAMA JENIS_ANGGARAN, A.JENIS_ANGGARAN_ID, PUSPEL, PUSPEL_NAMA, 
                   (SELECT SUM(NVL(REALISASI, 0)) FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D X WHERE X.ANGGARAN_MUTASI_ID = A.ANGGARAN_MUTASI_ID) REALISASI,
                   CASE WHEN A.JENIS_ANGGARAN_ID IN (3,6) THEN
                   ABS((SELECT SUM(NVL(LEBIH_KURANG, 0)) FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D X WHERE X.ANGGARAN_MUTASI_ID = A.ANGGARAN_MUTASI_ID)) 
                   ELSE
                   (SELECT SUM(NVL(REALISASI, 0)) FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D X WHERE X.ANGGARAN_MUTASI_ID = A.ANGGARAN_MUTASI_ID) END
                   LEBIH_KURANG,
                   NVL(STATUS_KIRIM_LEBIH_KURANG, 0) STATUS_KIRIM_LEBIH_KURANG, PEL_ANGGARAN.AMBIL_KELENGKAPAN_DOKUMEN(A.ANGGARAN_MUTASI_ID) KELENGKAPAN_DOKUMEN,
                   NO_NOTA_UM, NO_NOTA_TANGGUNGJAWAB, JML_VAL_REALISASI, NVL(ABS(JML_VAL_LEBIH_KURANG), 0) JML_VAL_LEBIH_KURANG,
                   CASE WHEN JML_VAL_LEBIH_KURANG IS NULL THEN 'JKK' 
                        WHEN NVL(JML_VAL_LEBIH_KURANG, 0) = 0 THEN '' 
                        WHEN NVL(JML_VAL_LEBIH_KURANG, 0) > 0 THEN 'JKM'
                        ELSE 'JKK'
                   END STATUS_PENGEMBALIAN, PUSPEL_SUB_BANTU, NO_NOTA_TANGGUNGJAWAB_SISA, SUPPLIER, E.NO_POSTING, TGJAWAB_UPLOAD
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI A 
                    INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                    INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                    INNER JOIN PEL_ANGGARAN.JENIS_ANGGARAN D ON A.JENIS_ANGGARAN_ID = D.JENIS_ANGGARAN_ID
                    LEFT JOIN (SELECT NO_NOTA, NO_POSTING, TGL_POSTING FROM KBBT_JUR_BB@KEUANGAN) E ON A.NO_NOTA_TANGGUNGJAWAB = E.NO_NOTA
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

    function selectByParamsPosisiNew($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="  ORDER BY A.TGL_ENTRY DESC ")
	{
		$str = "
			SELECT                    
			ANGGARAN_MUTASI_ID, NO_NOTA, PEGAWAI_ID, LAST_UPDATED_BY PEMOHON, TO_CHAR(TGL_ENTRY, 'DD-MM-YYYY') TGL_ENTRY,  JML_RP_TRANS JUMLAH, REALISASI, KET_TAMBAH, JENIS_ANGGARAN, 
			PUSPEL, PUSPEL_NAMA, STATUS_PERMOHONAN, STATUS_KIRIM_LEBIH_KURANG, 
			CASE 
				WHEN APPROVED_TGJAWAB_MANKEU_DATE IS NOT NULL THEN 'Terakhir realisasi di approve oleh Manajer Keuangan tanggal ' || TO_CHAR(APPROVED_TGJAWAB_MANKEU_DATE, 'DD-MM-YYYY')
				WHEN APPROVED_TGJAWAB_ASSKEU_DATE IS NOT NULL THEN 'Terakhir realisasi di approve oleh Asman Keuangan tanggal ' || TO_CHAR(APPROVED_TGJAWAB_ASSKEU_DATE, 'DD-MM-YYYY')
				WHEN APPROVED_TGJAWAB_STAFFKEU_DATE IS NOT NULL THEN 'Terakhir realisasi di approve oleh Staf Keuangan tanggal ' || TO_CHAR(APPROVED_TGJAWAB_STAFFKEU_DATE, 'DD-MM-YYYY')
				WHEN APPROVED_TGJAWAB_MANAGER_DATE IS NOT NULL THEN 'Terakhir realisasi di approve oleh Manajer Departemen tanggal ' || TO_CHAR(APPROVED_TGJAWAB_MANAGER_DATE, 'DD-MM-YYYY')
				WHEN APPROVED_TGJAWAB_MANAGER_DATE IS NOT NULL THEN 'Terakhir realisasi di approve oleh Manajer Departemen tanggal ' || TO_CHAR(APPROVED_TGJAWAB_MANAGER_DATE, 'DD-MM-YYYY')
				WHEN APPROVED_TGJAWAB_KADIV_DATE IS NOT NULL THEN 'Terakhir realisasi di approve oleh Kadiv Departemen tanggal ' || TO_CHAR(APPROVED_TGJAWAB_KADIV_DATE, 'DD-MM-YYYY')
				WHEN TG_JAWAB_DATE IS NOT NULL THEN 'Terakhir direalisasi oleh staff ' || TG_JAWAB_BY || ' tanggal ' || TO_CHAR(TG_JAWAB_DATE, 'DD-MM-YYYY')
				WHEN VERIFY_MAN_KEUANGAN_DATE IS NOT NULL THEN 'Terakhir permohonan diapprove oleh Manajer Keuangan ' || VERIFY_MAN_KEUANGAN_BY || ' tanggal ' || TO_CHAR(VERIFY_MAN_KEUANGAN_DATE, 'DD-MM-YYYY')
				WHEN VERIFY_ASMAN_KEUANGAN_DATE IS NOT NULL THEN 'Terakhir permohonan diapprove oleh Asman Keuangan ' || VERIFY_ASMAN_KEUANGAN_BY || ' tanggal ' || TO_CHAR(VERIFY_ASMAN_KEUANGAN_DATE, 'DD-MM-YYYY')
				WHEN VERIFY_STAF_KEUANGAN_DATE IS NOT NULL THEN 'Terakhir permohonan diapprove oleh Staff Keuangan ' || VERIFY_STAF_KEUANGAN_BY || ' tanggal ' || TO_CHAR(VERIFY_STAF_KEUANGAN_DATE, 'DD-MM-YYYY')
				WHEN VERIFY_STAF_KEUANGAN_DATE IS NOT NULL THEN 'Terakhir permohonan diapprove oleh Staff Keuangan ' || VERIFY_STAF_KEUANGAN_BY || ' tanggal ' || TO_CHAR(VERIFY_STAF_KEUANGAN_DATE, 'DD-MM-YYYY')
				WHEN APPROVED_MANAGER_DATE IS NOT NULL THEN 'Terakhir permohonan diapprove oleh Manajer Departemen ' || APPROVED_MANAGER_BY || ' tanggal ' || TO_CHAR(APPROVED_MANAGER_DATE, 'DD-MM-YYYY')
				WHEN APPROVED_KADIV_DATE IS NOT NULL THEN 'Terakhir permohonan diapprove oleh Kabid Departemen ' || APPROVED_KADIV_BY || ' tanggal ' || TO_CHAR(APPROVED_KADIV_DATE, 'DD-MM-YYYY')
				ELSE 'Permohonan dientry oleh ' || LAST_UPDATE_DATE || ' tanggal ' || TO_CHAR(LAST_UPDATE_DATE, 'DD-MM-YYYY') END  STATUS_APPROVE,
			 STATUS, STATUS_SELESAI
			FROM PEL_ANGGARAN.POSISI_ANGGARAN A
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

    function selectByParamsPosisi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="  ORDER BY A.TGL_ENTRY DESC ")
	{
		$str = "
				SELECT                    
                CASE WHEN APPROVED_KADIV_DATE IS NULL THEN 
                    'Permohonan belum di approve kadiv pemohon' 
                    WHEN APPROVED_DATE IS NULL THEN 
                    'Permohonan belum di approve manager'
                    WHEN VERIFIKASI_STAFF_DATE IS NULL THEN
                    'Permohonan belum di verifikasi oleh staf keuangan'
                    WHEN VERIFIKASI_DATE IS NULL THEN
                    'Permohonan belum di verifikasi oleh asman keuangan'
                    WHEN VERIFIKASI IS NULL THEN
                    'Permohonan belum di verifikasi oleh manager keuangan'
                    WHEN VERIFIKASI_ALASAN IS NOT NULL THEN
                    'Permohonan anda ditolak dengan alasan : ' || VERIFIKASI_ALASAN
                    WHEN JML_VAL_REALISASI IS NULL THEN
                        CASE WHEN A.JENIS_ANGGARAN_ID = 1 OR A.JENIS_ANGGARAN_ID = 5 THEN
                        'Permohonan belum direalisasikan'
                        ELSE
                        'Permohonan belum dipertanggungjawabkan'                        
                        END    
                    WHEN APPROVED_TGJAWAB_KADIV_DATE IS NULL THEN
                    'Realisasi/Pertanggungjawaban belum di approve kadiv'         
                    WHEN APPROVED_TGJAWAB_DATE IS NULL THEN
                    'Realisasi/Pertanggungjawaban belum di approve manager'
                    WHEN VERIFIKASI_TGJAWAB_STAFF_DATE IS NULL THEN
                    'Realisasi/Pertanggungjawaban belum di verifikasi oleh staf keuangan'
                    WHEN VERIFIKASI_TGJAWAB_DATE IS NULL THEN
                    'Realisasi/Pertanggungjawaban belum di verifikasi oleh asman keuangan'
                    WHEN (NO_NOTA_TANGGUNGJAWAB_SISA IS NULL AND NO_NOTA_UM IS NULL AND NO_NOTA_TANGGUNGJAWAB IS NULL) THEN
                    'Realisasi/Pertanggungjawaban belum di verifikasi oleh manager keuangan'
                    ELSE
                    'Proses permohonan selesai'                                          
                END STATUS,                                
                ANGGARAN_MUTASI_ID, NO_NOTA, A.PEGAWAI_ID, 
                   THN_BUKU, BLN_BUKU, TGL_TRANS, BLN_BUKU || ' ' || THN_BUKU  PERIODE,
                   TGL_ENTRY, KD_VALUTA, TGL_VALUTA, 
                   KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
                   KET_TAMBAH, NO_POSTING, TGL_POSTING, 
                   JML_CETAK, A.LAST_UPDATE_DATE, A.LAST_UPDATED_BY, 
                   A.PROGRAM_NAME, B.NAMA PEGAWAI, B.NRP, C.NAMA JABATAN, NO_REF1, NO_REF2, NO_REF3, PAJAK, VERIFIKASI, 
                   CASE WHEN VERIFIKASI = 'S' THEN 'Anggaran telah disetujui.' ELSE 'Anggaran ditolak.' END VERIFIKASI_STATUS, VERIFIKASI_ALASAN, UANG_MUKA,
                   D.NAMA JENIS_ANGGARAN, A.JENIS_ANGGARAN_ID, PUSPEL, PUSPEL || ' ' || NM_BUKU_BESAR  PUSPEL_NAMA, 
                   (SELECT SUM(NVL(REALISASI, 0)) FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D X WHERE X.ANGGARAN_MUTASI_ID = A.ANGGARAN_MUTASI_ID) REALISASI,
                   NVL(STATUS_KIRIM_LEBIH_KURANG, 0) STATUS_KIRIM_LEBIH_KURANG
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI A 
                    INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                    INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                    INNER JOIN PEL_ANGGARAN.JENIS_ANGGARAN D ON A.JENIS_ANGGARAN_ID = D.JENIS_ANGGARAN_ID
                    LEFT JOIN KBBR_BUKU_PUSAT@KEUANGAN E ON A.PUSPEL = E.KD_BUKU_BESAR 
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

    function selectByParamsPembukuan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT ANGGARAN_MUTASI_ID, NO_NOTA, JENIS_ANGGARAN, KET_TAMBAH, JML_VAL_TRANS, NO_NOTA_UM, NO_POSTING, TGL_POSTING, STATUS  FROM
                (
                SELECT D.NAMA || CASE WHEN A.JENIS_ANGGARAN_ID = 3 THEN ' (Permintaan)' END  JENIS_ANGGARAN, PUSPEL, 
                A.PEGAWAI_ID, A.ANGGARAN_MUTASI_ID, A.NO_NOTA, A.KET_TAMBAH, A.JML_VAL_TRANS, A.NO_NOTA_UM, B.NO_POSTING, B.TGL_POSTING,
                CASE WHEN B.NO_POSTING IS NULL THEN '<span style=color:#F00>Anda belum menerima uang muka dari keuangan (+)</span>' ELSE '<span style=color:#360>Anda sudah menerima permohonan anggaran dari keuangan</span>' END STATUS 
                FROM  PEL_ANGGARAN.ANGGARAN_MUTASI A 
                INNER JOIN KBBT_JUR_BB@KEUANGAN B ON B.NO_NOTA = A.NO_NOTA_UM
                INNER JOIN PEL_ANGGARAN.JENIS_ANGGARAN D ON A.JENIS_ANGGARAN_ID = D.JENIS_ANGGARAN_ID
                UNION ALL
                SELECT D.NAMA || CASE WHEN A.JENIS_ANGGARAN_ID = 3 THEN ' (Pertanggungjawaban)' END JENIS_ANGGARAN, 
                PUSPEL, A.PEGAWAI_ID, A.ANGGARAN_MUTASI_ID, A.NO_NOTA,  A.KET_TAMBAH, CASE WHEN A.JENIS_ANGGARAN_ID IN (1,2,5,6) THEN A.JML_VAL_TRANS ELSE ABS(A.JML_VAL_LEBIH_KURANG) END, 
                A.NO_NOTA_TANGGUNGJAWAB_SISA, B.NO_POSTING, B.TGL_POSTING,
                CASE WHEN B.NO_POSTING IS NULL THEN 
                    CASE WHEN A.NO_NOTA_TANGGUNGJAWAB_SISA LIKE '%JKM%' THEN
                        '<span style=color:#F00>Anda belum mengembalikan kelebihan uang muka pada keuangan (-)</span>'
                    ELSE
                        '<span style=color:#F00>Anda belum menerima uang pertanggungjawaban dari keuangan (+)</span>'                
                    END 
                ELSE
                    CASE WHEN A.NO_NOTA_TANGGUNGJAWAB_SISA LIKE '%JKM%' THEN
                        '<span style=color:#360>Anda sudah mengembalikan kelebihan uang muka pada keuangan</span>'
                    ELSE
                        '<span style=color:#360>Anda sudah menerima uang pertanggungjawaban pada keuangan</span>'                
                    END 
                END STATUS  
                FROM  PEL_ANGGARAN.ANGGARAN_MUTASI A 
                INNER JOIN KBBT_JUR_BB@KEUANGAN B ON B.NO_NOTA = A.NO_NOTA_TANGGUNGJAWAB_SISA
                INNER JOIN PEL_ANGGARAN.JENIS_ANGGARAN D ON A.JENIS_ANGGARAN_ID = D.JENIS_ANGGARAN_ID
                ) A
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
			
    function selectByParamsValidasi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				ANGGARAN_MUTASI_ID, NO_NOTA, A.PEGAWAI_ID, 
				   THN_BUKU, BLN_BUKU, TGL_TRANS, BLN_BUKU || ' ' || THN_BUKU  PERIODE,
				   TGL_ENTRY, KD_VALUTA, TGL_VALUTA, 
				   KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
				   KET_TAMBAH, NO_POSTING, TGL_POSTING, 
				   JML_CETAK, A.LAST_UPDATE_DATE, A.LAST_UPDATED_BY, 
				   A.PROGRAM_NAME, B.NAMA PEGAWAI, B.NRP, C.NAMA JABATAN, NO_REF1, NO_REF2, NO_REF3, PAJAK, VERIFIKASI, 
                   CASE WHEN VERIFIKASI = 'S' THEN 'Anggaran telah disetujui.' ELSE 'Anggaran ditolak.' END VERIFIKASI_STATUS, VERIFIKASI_ALASAN, UANG_MUKA,
                   D.NAMA JENIS_ANGGARAN, A.JENIS_ANGGARAN_ID, PUSPEL, PUSPEL || ' ' || NM_BUKU_BESAR  PUSPEL_NAMA, 
                   (SELECT SUM(NVL(REALISASI, 0)) FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D X WHERE X.ANGGARAN_MUTASI_ID = A.ANGGARAN_MUTASI_ID) REALISASI,
				   NVL(STATUS_KIRIM_LEBIH_KURANG, 0) STATUS_KIRIM_LEBIH_KURANG,
				   CASE WHEN (NVL(STATUS_PERMOHONAN, 0) = 1 AND APPROVED_DATE IS NULL) THEN 'Permohonan' ELSE 'Pertanggungjawaban' END STATUS, 
				   CASE WHEN (NVL(STATUS_PERMOHONAN, 0) = 1 AND APPROVED_DATE IS NOT NULL) THEN 'Permohonan' ELSE 'Pertanggungjawaban' END STATUS_KEUANGAN				   
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI A 
                    INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                    INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                    INNER JOIN PEL_ANGGARAN.JENIS_ANGGARAN D ON A.JENIS_ANGGARAN_ID = D.JENIS_ANGGARAN_ID
					LEFT JOIN KBBR_BUKU_PUSAT@KEUANGAN E ON A.PUSPEL = E.KD_BUKU_BESAR 
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;  exit;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsTggJawab($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				ANGGARAN_MUTASI_ID, NO_NOTA, A.PEGAWAI_ID, 
				   THN_BUKU, BLN_BUKU, TGL_TRANS, BLN_BUKU || ' ' || THN_BUKU  PERIODE,
				   TGL_ENTRY, KD_VALUTA, TGL_VALUTA, 
				   KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
				   KET_TAMBAH, NO_POSTING, TGL_POSTING, 
				   JML_CETAK, A.LAST_UPDATE_DATE, A.LAST_UPDATED_BY, 
				   A.PROGRAM_NAME, B.NAMA PEGAWAI, B.NRP, C.NAMA JABATAN, NO_REF1, NO_REF2, NO_REF3, PAJAK, VERIFIKASI, 
				   CASE WHEN VERIFIKASI = 'S' THEN 'Anggaran telah disetujui.' ELSE 'Anggaran ditolak.' END VERIFIKASI_STATUS, VERIFIKASI_ALASAN, UANG_MUKA,
				   (SELECT SUM(JUMLAH) FROM PEL_ANGGARAN.ANGGARAN_TGJAWAB X WHERE X.ANGGARAN_MUTASI_ID = A.ANGGARAN_MUTASI_ID) JUMLAH_TGJAWAB
				FROM PEL_ANGGARAN.ANGGARAN_MUTASI A 
					INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
					INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
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
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT 
				ANGGARAN_MUTASI_ID, ANGGARAN_ID, PERIODE, TANGGAL, PPH, JUMLAH, TOTAL, STATUS_VERIFIKASI
				FROM PEL_ANGGARAN.ANGGARAN_MUTASI
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY ANGGARAN_MUTASI_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParamsPembukuan($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) ROWCOUNT  FROM
                (
                SELECT D.NAMA || CASE WHEN A.JENIS_ANGGARAN_ID = 3 THEN ' (Permintaan)' END  JENIS_ANGGARAN, PUSPEL, 
                A.PEGAWAI_ID, A.ANGGARAN_MUTASI_ID, A.NO_NOTA, A.KET_TAMBAH, A.JML_VAL_TRANS, A.NO_NOTA_UM, B.NO_POSTING, B.TGL_POSTING,
                CASE WHEN B.NO_POSTING IS NULL THEN '<span style=color:#F00>Anda belum menerima uang muka dari keuangan (+)</span>' ELSE '<span style=color:#360>Anda sudah menerima permohonan anggaran dari keuangan</span>' END STATUS 
                FROM  PEL_ANGGARAN.ANGGARAN_MUTASI A 
                INNER JOIN KBBT_JUR_BB@KEUANGAN B ON B.NO_NOTA = A.NO_NOTA_UM
                INNER JOIN PEL_ANGGARAN.JENIS_ANGGARAN D ON A.JENIS_ANGGARAN_ID = D.JENIS_ANGGARAN_ID
                UNION ALL
                SELECT D.NAMA || CASE WHEN A.JENIS_ANGGARAN_ID = 3 THEN ' (Pertanggungjawaban)' END JENIS_ANGGARAN, 
                PUSPEL, A.PEGAWAI_ID, A.ANGGARAN_MUTASI_ID, A.NO_NOTA,  A.KET_TAMBAH, CASE WHEN A.JENIS_ANGGARAN_ID IN (1,2,5,6) THEN A.JML_VAL_TRANS ELSE ABS(A.JML_VAL_LEBIH_KURANG) END, 
                A.NO_NOTA_TANGGUNGJAWAB_SISA, B.NO_POSTING, B.TGL_POSTING,
                CASE WHEN B.NO_POSTING IS NULL THEN 
                    CASE WHEN A.NO_NOTA_TANGGUNGJAWAB_SISA LIKE '%JKM%' THEN
                        '<span style=color:#F00>Anda belum mengembalikan kelebihan uang muka pada keuangan (-)</span>'
                    ELSE
                        '<span style=color:#F00>Anda belum menerima uang pertanggungjawaban dari keuangan (+)</span>'                
                    END 
                ELSE
                    CASE WHEN A.NO_NOTA_TANGGUNGJAWAB_SISA LIKE '%JKM%' THEN
                        '<span style=color:#360>Anda sudah mengembalikan kelebihan uang muka pada keuangan</span>'
                    ELSE
                        '<span style=color:#360>Anda sudah menerima uang pertanggungjawaban pada keuangan</span>'                
                    END 
                END STATUS  
                FROM  PEL_ANGGARAN.ANGGARAN_MUTASI A 
                INNER JOIN KBBT_JUR_BB@KEUANGAN B ON B.NO_NOTA = A.NO_NOTA_TANGGUNGJAWAB_SISA
                INNER JOIN PEL_ANGGARAN.JENIS_ANGGARAN D ON A.JENIS_ANGGARAN_ID = D.JENIS_ANGGARAN_ID
                ) A
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
	
    function getCountByParamsNew($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ANGGARAN_MUTASI_ID) AS ROWCOUNT FROM PEL_ANGGARAN.POSISI_ANGGARAN A 
                WHERE 1 = 1 ".$statement; 
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

    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ANGGARAN_MUTASI_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_MUTASI A 
					INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
					INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
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

    function getCountByParamsValidasi($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ANGGARAN_MUTASI_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_MUTASI A 
                    INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                    INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                    INNER JOIN PEL_ANGGARAN.JENIS_ANGGARAN D ON A.JENIS_ANGGARAN_ID = D.JENIS_ANGGARAN_ID
					LEFT JOIN KBBR_BUKU_PUSAT@KEUANGAN E ON A.PUSPEL = E.KD_BUKU_BESAR 
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

    function getKode($paramsArray=array(), $statement="")
	{
		$str = "SELECT PEL_ANGGARAN.GENERATE_KODE('".date("Y")."') ROWCOUNT FROM DUAL ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		$this->query = $str;
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return ""; 
    }
	
    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(ANGGARAN_MUTASI_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_MUTASI WHERE 1 = 1 "; 
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

    function selectByParamsMaintenanceAnggaranTriwulan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")	{
		$str = "
				SELECT A.THN_BUKU, A.ANGG_TAHUNAN, A.KD_BUKU_BESAR || ' - ' || A.NM_BUKU_BESAR KD_BUKU_BESAR, A.KD_SUB_BANTU || ' - ' || A.NM_SUB_BANTU KD_SUB_BANTU,  A.KD_BUKU_PUSAT || ' - ' || A.NM_BUKU_BESAR KD_BUKU_PUSAT, 
					NVL(ANGG_TRW1, 0) ANGG_TRW1, NVL(ABS(MUTASI_TRW1), 0) MUTASI_TRW1, 
					D_K_TRW1, REALISASI_TRW1,
					NVL(ANGG_TRW2, 0) ANGG_TRW2, NVL(ABS(MUTASI_TRW2), 0) MUTASI_TRW2, 
					D_K_TRW2, REALISASI_TRW2,
					NVL(ANGG_TRW3, 0) ANGG_TRW3, NVL(ABS(MUTASI_TRW3), 0) MUTASI_TRW3, 
					D_K_TRW3, REALISASI_TRW3,
					NVL(ANGG_TRW4, 0) ANGG_TRW4, NVL(ABS(MUTASI_TRW4), 0) MUTASI_TRW4, 
					D_K_TRW4, REALISASI_TRW4
				FROM MAINTENANCE_ANGGARAN_TAHUNAN@KEUANGAN A            
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    function getCountByParamsMaintenanceAnggaranTriwulan($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) ROWCOUNT
				FROM MAINTENANCE_ANGGARAN_TAHUNAN@KEUANGAN A                 
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

  } 
?>