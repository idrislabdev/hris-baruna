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

  class PembayaranManfaat extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TunjanganHariRaya()
	{
      $this->Entity(); 
    }
	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = " SELECT * FROM (
								  SELECT a.pegawai_id ID,
										 a.nrp,
										 a.nama,
										 DECODE (A.JENIS_KELAMIN,  'L', 'Laki-Laki',  'P', 'Perempuan') GENDER,
										 D.NAMA status,
										 PPI_SIMPEG.AMBIL_JENIS_PEGAWAI_PERIODE (TO_CHAR(NVL(NVL (A.TANGGAL_PENSIUN, A.TANGGAL_MUTASI_KELUAR), SYSDATE), 'MMYYYY'), A.PEGAWAI_ID) JENIS_PEGAWAI_ID,
										 b.nama jabatan,
										 B.DEPARTEMEN_ID,
										 b.nama_departemen DIVISI,
										 A.TANGGAL_LAHIR TGL_LAHIR,
										 '' TGL_MULAI_BEKERJA_P3,
										 '' TGL_MULAI_BEKERJA_PMS,
										 NVL (A.TANGGAL_PENSIUN, A.TANGGAL_MUTASI_KELUAR) TGL_BERHENTI_BEKERJA,
										 SUM (c.MERIT_PMS) MERIT_PMS,
										 SUM (c.TPP_PMS) TPP_PMS,
										 SUM (c.tunjangan_perbantuan) tunjangan_perbantuan,
										 SUM (c.tunjangan_jabatan) tunjangan_jabatan,
										 SUM (
											  c.JUMLAH_GAJI_KOTOR
											- c.JUMLAH_POTONGAN_LAIN
											+ c.JUMLAH_POTONGAN_WAJIB)
											TOTAL_UPAH_GROSS,
										 SUM (c.IURAN_PURNA_BAKTI) TOTAL_PURNA_BAKTI,
										 0 SALDO_DPLK_SAAT_BERHENTI,
										 0 PHDP_SAAT_BERHENTI,
										 0 BESAR_MANFAAT_PERUSAHAAN,
										 0 UANG_DUKA,
										 CASE
											WHEN A.TANGGAL_PENSIUN IS NOT NULL THEN 'PENSIUN'
											WHEN A.TANGGAL_MUTASI_KELUAR IS NOT NULL THEN 'MUTASI'
											ELSE ''
										 END
											ALASAN_BERHENTI
									FROM PPI_SIMPEG.PEGAWAI_VIEW a
										 LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR b
											ON A.PEGAWAI_ID = B.PEGAWAI_ID(+)
										 LEFT JOIN PPI_GAJI.GAJI_AWAL_BULAN_REPORT c
											ON C.PEGAWAI_ID = A.PEGAWAI_ID AND SUBSTR (C.PERIODE, 3) = '".$periode."'
										 LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI d
											ON A.STATUS_PEGAWAI_ID = D.STATUS_PEGAWAI_ID
								   WHERE 0 = 0
								GROUP BY a.pegawai_id,
										 a.nrp,
										 a.nama,
										 b.nama,
										 B.DEPARTEMEN_ID,
										 b.nama_departemen,
										 A.TANGGAL_LAHIR,
										 NVL (A.TANGGAL_PENSIUN, A.TANGGAL_MUTASI_KELUAR),
										 DECODE (A.JENIS_KELAMIN,  'L', 'Laki-Laki',  'P', 'Perempuan'),
										 D.NAMA,
										 CASE
											WHEN A.TANGGAL_PENSIUN IS NOT NULL THEN 'PENSIUN'
											WHEN A.TANGGAL_MUTASI_KELUAR IS NOT NULL THEN 'MUTASI'
											ELSE ''
										 END ) A WHERE 0=0 ";
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsReport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = " SELECT * FROM (
								SELECT a.pegawai_id ID,
									 a.nrp,
									 a.nama,
									 DECODE (A.JENIS_KELAMIN,  'L', 'Laki-Laki',  'P', 'Perempuan') GENDER,
									 D.NAMA status,
									 PPI_SIMPEG.AMBIL_JENIS_PEGAWAI_PERIODE (TO_CHAR(NVL(NVL (A.TANGGAL_PENSIUN, A.TANGGAL_MUTASI_KELUAR), SYSDATE), 'MMYYYY'), A.PEGAWAI_ID) JENIS_PEGAWAI_ID,
									 b.nama jabatan,
									 b.kelas,
									 B.DEPARTEMEN_ID,
									 b.root_departemen,
									 b.nama_departemen DIVISI,
									 A.TANGGAL_LAHIR TGL_LAHIR,
									 '' TGL_MULAI_BEKERJA_P3,
									 '' TGL_MULAI_BEKERJA_PMS,
									 NVL (A.TANGGAL_PENSIUN, A.TANGGAL_MUTASI_KELUAR) TGL_BERHENTI_BEKERJA,
									 SUM (c.MERIT_PMS) MERIT_PMS,
									 SUM (c.TPP_PMS) TPP_PMS,
									 SUM (c.tunjangan_perbantuan) tunjangan_perbantuan,
									 SUM (c.tunjangan_jabatan) tunjangan_jabatan,
									 SUM (
										  c.JUMLAH_GAJI_KOTOR
										- c.JUMLAH_POTONGAN_LAIN
										+ c.JUMLAH_POTONGAN_WAJIB)
										TOTAL_UPAH_GROSS,
									 SUM (c.IURAN_PURNA_BAKTI) TOTAL_PURNA_BAKTI,
									 0 SALDO_DPLK_SAAT_BERHENTI,
									 0 PHDP_SAAT_BERHENTI,
									 0 BESAR_MANFAAT_PERUSAHAAN,
									 0 UANG_DUKA,
									 CASE
										WHEN A.TANGGAL_PENSIUN IS NOT NULL THEN 'PENSIUN'
										WHEN A.TANGGAL_MUTASI_KELUAR IS NOT NULL THEN 'MUTASI'
										ELSE ''
									 END
										ALASAN_BERHENTI
								FROM PPI_SIMPEG.PEGAWAI_VIEW a
									 LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR b
										ON A.PEGAWAI_ID = B.PEGAWAI_ID(+)
									 LEFT JOIN PPI_GAJI.GAJI_AWAL_BULAN_REPORT c
										ON C.PEGAWAI_ID = A.PEGAWAI_ID AND SUBSTR (C.PERIODE, 3) = '2013'
									 LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI d
										ON A.STATUS_PEGAWAI_ID = D.STATUS_PEGAWAI_ID
								WHERE 0 = 0
								GROUP BY a.pegawai_id,
									 a.nrp,
									 a.nama,
									 b.kelas,
									 b.nama,
									 B.DEPARTEMEN_ID,
									 b.root_departemen,
									 b.nama_departemen,
									 A.TANGGAL_LAHIR,
									 NVL (A.TANGGAL_PENSIUN, A.TANGGAL_MUTASI_KELUAR),
									 DECODE (A.JENIS_KELAMIN,  'L', 'Laki-Laki',  'P', 'Perempuan'),
									 D.NAMA,
									 CASE
										WHEN A.TANGGAL_PENSIUN IS NOT NULL THEN 'PENSIUN'
										WHEN A.TANGGAL_MUTASI_KELUAR IS NOT NULL THEN 'MUTASI'
										ELSE ''
									 END ) A WHERE 0=0 ";
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="", $periode='')
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT
				FROM PPI_SIMPEG.PEGAWAI A 
				INNER JOIN PPI_GAJI.TUNJANGAN_HARI_RAYA B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND PERIODE = '".$periode."'
                WHERE (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI A WHERE 1 = 1 "; 
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