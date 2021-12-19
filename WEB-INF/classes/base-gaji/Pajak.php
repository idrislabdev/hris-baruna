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

  class Pajak extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Pajak()
	{
      $this->Entity(); 
    }
	
	function selectByParamsPph21Pegawai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ORDER BY P.NAMA ASC ", $periode="", $periode_lalu="")
	{
		$str = "
				SELECT 
                   P.PEGAWAI_ID, NVL(P.NPWP, '00.000.000.0-000.000') NPWP, P.NAMA, P.NRP, A.PERIODE, F.NAMA JENIS_PEGAWAI, MERIT_PMS + TUNJANGAN_PERBANTUAN PENGHASILAN, TUNJANGAN_JABATAN, TPP_PMS,       
                   MERIT_PMS + TUNJANGAN_PERBANTUAN + TUNJANGAN_JABATAN + TPP_PMS JUMLAH_GAJI_KOTOR, POTONGAN_PPH21, 
                   B.JUMLAH  UANG_MAKAN, 
                   B.BANTUAN_PPH UANG_MAKAN_PPH, 
                   C.JUMLAH UANG_TRANSPORT, C.BANTUAN_PPH UANG_TRANSPORT_PPH,
                   D.JUMLAH UANG_INSENTIF, D.JUMLAH_PPH UANG_INSENTIF_PPH, 
                   E.JUMLAH_INSENTIF UANG_PREMI, E.JUMLAH_PPH UANG_PREMI_PPH,
                   (NVL(MERIT_PMS, 0) + NVL(TUNJANGAN_PERBANTUAN, 0) + NVL(TUNJANGAN_JABATAN, 0) + NVL(TPP_PMS, 0)) + NVL(B.JUMLAH, 0) + NVL(C.JUMLAH, 0) + NVL(D.JUMLAH, 0) + NVL(E.JUMLAH_PPH, 0) + NVL(MOBILITAS, 0) + NVL(PERUMAHAN, 0) + NVL(TELEPON, 0) TOTAL_DPP,
                   NVL(A.POTONGAN_PPH21, 0) + NVL(B.BANTUAN_PPH, 0) + NVL(C.BANTUAN_PPH, 0) + NVL(D.JUMLAH_PPH, 0) + NVL(E.JUMLAH_PPH, 0) TOTAL_PPH,
				   MERIT_PMS, MOBILITAS, PERUMAHAN, TELEPON, POTONGAN_PPH21 POTONGAN_PPH21_DIREKSI, P.JENIS_PEGAWAI_ID       
                FROM (SELECT A.PEGAWAI_ID, PPI_SIMPEG.AMBIL_JENIS_PEGAWAI_PERIODE('".$periode."', A.PEGAWAI_ID) JENIS_PEGAWAI_ID, A.NPWP, A.NAMA, A.NRP, A.STATUS_PEGAWAI_ID FROM PPI_SIMPEG.PEGAWAI A) P
                LEFT JOIN PPI_GAJI.GAJI_AWAL_BULAN_REPORT A ON P.PEGAWAI_ID = A.PEGAWAI_ID AND ((P.JENIS_PEGAWAI_ID IN (2,6,7) AND A.PERIODE = '".$periode."') OR (P.JENIS_PEGAWAI_ID IN (1,3,4,5) AND A.PERIODE = '".$periode_lalu."'))
                LEFT JOIN (SELECT PEGAWAI_ID, PERIODE, SUM(HARI_KERJA) HARI_KERJA, SUM(JUMLAH) JUMLAH, SUM(JUMLAH_POTONGAN_PPH21) BANTUAN_PPH FROM PPI_GAJI.UANG_MAKAN_REPORT X GROUP BY PEGAWAI_ID, PERIODE) B ON P.PEGAWAI_ID = B.PEGAWAI_ID AND B.PERIODE = '".$periode_lalu."'
                LEFT JOIN (SELECT PEGAWAI_ID, PERIODE, SUM(HARI_KERJA) HARI_KERJA, SUM(JUMLAH) JUMLAH, SUM(POTONGAN_PPH) BANTUAN_PPH FROM PPI_GAJI.UANG_TRANSPORT_PENGANTAR_RPT X GROUP BY PEGAWAI_ID, PERIODE) C ON P.PEGAWAI_ID = C.PEGAWAI_ID AND C.PERIODE = '".$periode_lalu."'
                LEFT JOIN PPI_GAJI.INSENTIF_REPORT D ON P.PEGAWAI_ID = D.PEGAWAI_ID AND D.PERIODE = '".$periode_lalu."'
                LEFT JOIN (SELECT PEGAWAI_ID, PERIODE, SUM(TOTAL_INSENTIF) JUMLAH_INSENTIF, SUM(JUMLAH_PPH) JUMLAH_PPH FROM PPI_GAJI.PREMI_REPORT GROUP BY PEGAWAI_ID, PERIODE) E ON P.PEGAWAI_ID = E.PEGAWAI_ID AND E.PERIODE = '".$periode_lalu."'
                LEFT JOIN PPI_SIMPEG.JENIS_PEGAWAI F ON P.JENIS_PEGAWAI_ID = F.JENIS_PEGAWAI_ID
                WHERE P.STATUS_PEGAWAI_ID IN (1,5) AND P.JENIS_PEGAWAI_ID IN (1,2,3,4,5,6,7)
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	

	function getCountByParamsPph21Pegawai($paramsArray=array(), $statement="", $periode="", $periode_lalu="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM (SELECT A.PEGAWAI_ID, PPI_SIMPEG.AMBIL_JENIS_PEGAWAI_PERIODE('".$periode."', A.PEGAWAI_ID) JENIS_PEGAWAI_ID, A.NPWP, A.NAMA, A.NRP, A.STATUS_PEGAWAI_ID FROM PPI_SIMPEG.PEGAWAI A) P
                WHERE P.STATUS_PEGAWAI_ID IN (1,5) AND P.JENIS_PEGAWAI_ID IN (1,2,3,4,5,6,7) ".$statement; 
		
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