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
  * EntitySIUK-base class untuk mengimplementasikan tabel KPTT_NOTA.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class ReportPrint extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function ReportPrint()
	{
      $this->EntitySIUK(); 
    }
	
	function selectByParamsJKM($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.NO_NOTA, B.NO_SEQ")
	{
		$str = "
				SELECT A.NO_NOTA, A.TGL_TRANS, A.JML_VAL_TRANS, A.JML_RP_TRANS, A.NM_AGEN_PERUSH, A.ALMT_AGEN_PERUSH, A.KET_TAMBAH KETERANGAN_UTAMA, 
				A.NO_REF3 BUKTI_PENDUKUNG, LPAD(TO_CHAR(B.NO_SEQ), 3, '0') NOMOR, B.KD_BUKU_BESAR, B.KD_SUB_BANTU, B.KD_BUKU_PUSAT, AMBIL_BUKU_BESAR_NAMA(B.KD_BUKU_BESAR) NM_BUKU_BESAR_WITH_PARENT, C.NM_BUKU_BESAR, E.MPLG_NAMA NM_SUB_BANTU, D.NM_BUKU_BESAR NM_BUKU_PUSAT,
				B.KET_TAMBAH KETERANGAN_DETIL, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, SALDO_RP_DEBET, SALDO_RP_KREDIT, A.KD_VALUTA, NO_POSTING, TGL_POSTING
				FROM KBBT_JUR_BB A 
				INNER JOIN KBBT_JUR_BB_D B ON A.NO_NOTA = B.NO_NOTA 
				INNER JOIN KBBR_BUKU_BESAR C ON C.KD_BUKU_BESAR = B.KD_BUKU_BESAR
				INNER JOIN KBBR_BUKU_PUSAT D ON D.KD_BUKU_BESAR = B.KD_BUKU_PUSAT
				INNER JOIN SAFM_PELANGGAN E ON E.MPLG_KODE = B.KD_SUB_BANTU  
				WHERE 1=1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJPJ_bak($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.NO_NOTA, B.NO_SEQ")
	{
		$str = "SELECT A.NO_NOTA, A.TGL_TRANS, A.JML_VAL_TRANS,  A.JML_RP_TRANS,  E.MPLG_NAMA NM_AGEN_PERUSH, E.MPLG_ALAMAT ALMT_AGEN_PERUSH, A.KET_TAMBAH KETERANGAN_UTAMA, 
				A.NO_REF3 BUKTI_PENDUKUNG, LPAD(TO_CHAR(B.NO_SEQ), 2, '0') NOMOR, B.KD_BUKU_BESAR, B.KD_SUB_BANTU, B.KD_BUKU_PUSAT, AMBIL_BUKU_BESAR_NAMA(B.KD_BUKU_BESAR) NM_BUKU_BESAR_WITH_PARENT, C.NM_BUKU_BESAR, E.MPLG_NAMA NM_SUB_BANTU, D.NM_BUKU_BESAR NM_BUKU_PUSAT,
				B.KET_TAMBAH KETERANGAN_DETIL, SALDO_RP_DEBET, SALDO_RP_KREDIT, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, NO_POSTING, TGL_POSTING, A.KD_VALUTA, A.KURS_VALUTA, A.TGL_VALUTA
				FROM KBBT_JUR_BB A 
				INNER JOIN KBBT_JUR_BB_D B ON A.NO_NOTA = B.NO_NOTA 
				INNER JOIN KBBR_BUKU_BESAR C ON C.KD_BUKU_BESAR = B.KD_BUKU_BESAR
				INNER JOIN KBBR_BUKU_PUSAT D ON D.KD_BUKU_BESAR = B.KD_BUKU_PUSAT
				INNER JOIN SAFM_PELANGGAN E ON E.MPLG_KODE = A.KD_KUSTO
				WHERE 1=1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsJPJ($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.NO_NOTA, B.NO_SEQ")
	{
		$str = "
				SELECT A.NO_NOTA, A.TGL_TRANS, A.KD_VALUTA, A.JML_VAL_TRANS, A.JML_RP_TRANS, A.NM_AGEN_PERUSH, A.ALMT_AGEN_PERUSH, A.KET_TAMBAH KETERANGAN_UTAMA, 
				A.NO_REF3 BUKTI_PENDUKUNG,  LPAD(TO_CHAR(B.NO_SEQ), 3, '0') NOMOR,  B.KD_BUKU_BESAR, B.KD_SUB_BANTU, B.KD_BUKU_PUSAT, A.NO_REF2,
				AMBIL_BUKU_BESAR_NAMA(B.KD_BUKU_BESAR) NM_BUKU_BESAR_WITH_PARENT, C.NM_BUKU_BESAR, E.MPLG_NAMA NM_SUB_BANTU, D.NM_BUKU_BESAR NM_BUKU_PUSAT,
				B.KET_TAMBAH KETERANGAN_DETIL, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, SALDO_RP_DEBET, SALDO_RP_KREDIT, NO_POSTING, TGL_POSTING
				FROM KBBT_JUR_BB A 
				INNER JOIN KBBT_JUR_BB_D B ON A.NO_NOTA = B.NO_NOTA 
				INNER JOIN KBBR_BUKU_BESAR C ON C.KD_BUKU_BESAR = B.KD_BUKU_BESAR
				INNER JOIN KBBR_BUKU_PUSAT D ON D.KD_BUKU_BESAR = B.KD_BUKU_PUSAT
				INNER JOIN SAFM_PELANGGAN E ON E.MPLG_KODE = B.KD_SUB_BANTU 
				WHERE 1=1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJKK($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.NO_NOTA, B.NO_SEQ")
	{
		$str = "
				SELECT A.NO_NOTA, A.TGL_TRANS, A.KD_VALUTA, A.JML_VAL_TRANS, A.JML_RP_TRANS, A.NM_AGEN_PERUSH, A.ALMT_AGEN_PERUSH, A.KET_TAMBAH KETERANGAN_UTAMA, 
				A.NO_REF3 BUKTI_PENDUKUNG,  LPAD(TO_CHAR(B.NO_SEQ), 3, '0') NOMOR,  B.KD_BUKU_BESAR, B.KD_SUB_BANTU, B.KD_BUKU_PUSAT, A.NO_REF2,
				AMBIL_BUKU_BESAR_NAMA(B.KD_BUKU_BESAR) NM_BUKU_BESAR_WITH_PARENT, C.NM_BUKU_BESAR, E.MPLG_NAMA NM_SUB_BANTU, D.NM_BUKU_BESAR NM_BUKU_PUSAT,
				B.KET_TAMBAH KETERANGAN_DETIL, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, SALDO_RP_DEBET, SALDO_RP_KREDIT, NO_POSTING, TGL_POSTING
				FROM KBBT_JUR_BB A 
				INNER JOIN KBBT_JUR_BB_D B ON A.NO_NOTA = B.NO_NOTA 
				INNER JOIN KBBR_BUKU_BESAR C ON C.KD_BUKU_BESAR = B.KD_BUKU_BESAR
				INNER JOIN KBBR_BUKU_PUSAT D ON D.KD_BUKU_BESAR = B.KD_BUKU_PUSAT
				INNER JOIN SAFM_PELANGGAN E ON E.MPLG_KODE = B.KD_SUB_BANTU 
				WHERE 1=1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
	function selectByParamsJRR($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.NO_NOTA, B.NO_SEQ")
	{
		$str = "
				SELECT A.NO_NOTA, A.KD_VALUTA, A.TGL_TRANS, A.JML_VAL_TRANS, A.JML_RP_TRANS, NVL(A.NM_AGEN_PERUSH, E.MPLG_NAMA) NM_AGEN_PERUSH, NVL(A.ALMT_AGEN_PERUSH, E.MPLG_ALAMAT) ALMT_AGEN_PERUSH, A.KET_TAMBAH KETERANGAN_UTAMA, 
				A.NO_REF3 BUKTI_PENDUKUNG, LPAD(TO_CHAR(B.NO_SEQ), 3, '0') NOMOR, B.KD_BUKU_BESAR, B.KD_SUB_BANTU, B.KD_BUKU_PUSAT, AMBIL_BUKU_BESAR_NAMA(B.KD_BUKU_BESAR) NM_BUKU_BESAR_WITH_PARENT, C.NM_BUKU_BESAR, E.MPLG_NAMA NM_SUB_BANTU, D.NM_BUKU_BESAR NM_BUKU_PUSAT,
				B.KET_TAMBAH KETERANGAN_DETIL, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, SALDO_RP_DEBET, SALDO_RP_KREDIT, NO_POSTING, TGL_POSTING
				FROM KBBT_JUR_BB A 
				INNER JOIN KBBT_JUR_BB_D B ON A.NO_NOTA = B.NO_NOTA 
				INNER JOIN KBBR_BUKU_BESAR C ON C.KD_BUKU_BESAR = B.KD_BUKU_BESAR
				INNER JOIN KBBR_BUKU_PUSAT D ON D.KD_BUKU_BESAR = B.KD_BUKU_PUSAT
				INNER JOIN SAFM_PELANGGAN E ON E.MPLG_KODE = B.KD_SUB_BANTU 
				WHERE 1=1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	

	
	function selectByParamsJPB($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.NO_NOTA, B.NO_SEQ")
	{
		$str = "SELECT A.NO_NOTA, A.TGL_TRANS, A.KD_VALUTA, A.JML_VAL_TRANS, A.JML_RP_TRANS, A.NM_AGEN_PERUSH, A.ALMT_AGEN_PERUSH, A.KET_TAMBAH KETERANGAN_UTAMA, 
				A.NO_REF3 NO_BUKTI, A.NO_REF2 BUKTI_PENDUKUNG, LPAD(TO_CHAR(B.NO_SEQ), 3, '0') NOMOR,  B.KD_BUKU_BESAR, B.KD_SUB_BANTU, B.KD_BUKU_PUSAT, 
				AMBIL_BUKU_BESAR_NAMA(B.KD_BUKU_BESAR) NM_BUKU_BESAR_WITH_PARENT, C.NM_BUKU_BESAR, E.MPLG_NAMA NM_SUB_BANTU, D.NM_BUKU_BESAR NM_BUKU_PUSAT,
                B.KET_TAMBAH KETERANGAN_DETIL, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, SALDO_RP_DEBET, SALDO_RP_KREDIT, NO_POSTING, TGL_POSTING
                FROM KBBT_JUR_BB A 
                INNER JOIN KBBT_JUR_BB_D B ON A.NO_NOTA = B.NO_NOTA 
                INNER JOIN KBBR_BUKU_BESAR C ON C.KD_BUKU_BESAR = B.KD_BUKU_BESAR
                INNER JOIN KBBR_BUKU_PUSAT D ON D.KD_BUKU_BESAR = B.KD_BUKU_PUSAT
                INNER JOIN SAFM_PELANGGAN E ON E.MPLG_KODE = B.KD_SUB_BANTU 
                WHERE 1=1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsJPP($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.NO_NOTA, B.NO_SEQ")
	{
		$str = "SELECT A.NO_NOTA, A.TGL_TRANS, A.JML_VAL_TRANS,  A.JML_RP_TRANS,  NVL(E.MPLG_NAMA, NM_AGEN_PERUSH) NM_AGEN_PERUSH, NVL(E.MPLG_ALAMAT, ALMT_AGEN_PERUSH) ALMT_AGEN_PERUSH, A.KET_TAMBAH KETERANGAN_UTAMA, 
                A.NO_REF3 BUKTI_PENDUKUNG, LPAD(TO_CHAR(B.NO_SEQ), 2, '0') NOMOR, B.KD_BUKU_BESAR, B.KD_SUB_BANTU, B.KD_BUKU_PUSAT, AMBIL_BUKU_BESAR_NAMA(B.KD_BUKU_BESAR) NM_BUKU_BESAR_WITH_PARENT, C.NM_BUKU_BESAR, E.MPLG_NAMA NM_SUB_BANTU, D.NM_BUKU_BESAR NM_BUKU_PUSAT,
                B.KET_TAMBAH KETERANGAN_DETIL, SALDO_RP_DEBET, SALDO_RP_KREDIT, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, NO_POSTING, TGL_POSTING, A.KD_VALUTA, A.KURS_VALUTA, A.TGL_VALUTA
                FROM KBBT_JUR_BB A 
                INNER JOIN KBBT_JUR_BB_D B ON A.NO_NOTA = B.NO_NOTA 
                INNER JOIN KBBR_BUKU_BESAR C ON C.KD_BUKU_BESAR = B.KD_BUKU_BESAR
                INNER JOIN KBBR_BUKU_PUSAT D ON D.KD_BUKU_BESAR = B.KD_BUKU_PUSAT
                LEFT JOIN SAFM_PELANGGAN E ON E.MPLG_KODE = A.KD_KUSTO
                WHERE 1=1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsAJP($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.NO_NOTA, B.NO_SEQ")
	{
		$str = "SELECT A.KD_SUBSIS,A.NO_NOTA NO_BUKTI, TO_CHAR(A.TGL_TRANS,'DD-MM-YYYY') TGL_BUKTI, A.NM_AGEN_PERUSH DARI, 
					   A.ALMT_AGEN_PERUSH ALAMAT, A.KET_TAMBAH URAIAN, A.NO_REF3 BUKTI_PENDUKUNG, 
					   TO_CHAR(A.TGL_TRANS,'DD-MM-YYYY') TANGGAL, B.NO_SEQ NOMOR,
					   (B.KD_BUKU_BESAR ||  '  ' || B.KD_SUB_BANTU || '  ' ||  B.KD_BUKU_PUSAT) MUTASI_JURNAL, 
					   AMBIL_KET_KBB_BKT_JRR_ENTRY(B.KD_BUKU_BESAR ||  '  ' || B.KD_SUB_BANTU || '  ' ||  B.KD_BUKU_PUSAT) KETERANGAN,
					   B.SALDO_RP_DEBET DEBET, B.SALDO_RP_KREDIT KREDIT,B.PREV_NO_NOTA,B.TIPE_TRANS, B.KD_BUKU_BESAR BB,
					   A.NO_POSTING, A.TGL_POSTING, B.KET_TAMBAH KET_JUR, A.JML_VAL_TRANS,  A.JML_RP_TRANS
				FROM   KBBT_JUR_BB A, KBBT_JUR_BB_D B
				WHERE  A.JEN_JURNAL='JRR' 
				AND A.NO_NOTA=B.NO_NOTA 
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsAJT($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.NO_NOTA, B.NO_SEQ")
	{
		$str = "SELECT A.KD_SUBSIS,A.NO_NOTA NO_BUKTI, TO_CHAR(A.TGL_TRANS,'DD-MM-YYYY') TGL_BUKTI, A.NM_AGEN_PERUSH DARI, 
					   A.ALMT_AGEN_PERUSH ALAMAT, A.KET_TAMBAH URAIAN, A.NO_REF3 BUKTI_PENDUKUNG, 
					   TO_CHAR(A.TGL_TRANS,'DD-MM-YYYY') TANGGAL, B.NO_SEQ NOMOR,
					   (B.KD_BUKU_BESAR ||  '  ' || B.KD_SUB_BANTU || '  ' ||  B.KD_BUKU_PUSAT) MUTASI_JURNAL, 
					   AMBIL_KET_KBB_BKT_JRR_ENTRY(B.KD_BUKU_BESAR ||  '  ' || B.KD_SUB_BANTU || '  ' ||  B.KD_BUKU_PUSAT) KETERANGAN,
					   B.SALDO_RP_DEBET DEBET, B.SALDO_RP_KREDIT KREDIT,B.PREV_NO_NOTA,B.TIPE_TRANS, B.KD_BUKU_BESAR BB,
					   A.NO_POSTING, A.TGL_POSTING, B.KET_TAMBAH KET_JUR, A.JML_VAL_TRANS,  A.JML_RP_TRANS
				FROM   KBBT_JUR_BB A, KBBT_JUR_BB_D B
				WHERE  A.JEN_JURNAL='JRR' 
				 AND A.NO_NOTA=B.NO_NOTA 
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
	function selectByParamsJKMPemindahbukuan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.NO_NOTA, B.NO_SEQ")
	{
		$str = "SELECT A.NO_NOTA, A.TGL_TRANS, A.JML_VAL_TRANS, A.NM_AGEN_PERUSH, A.ALMT_AGEN_PERUSH, A.KET_TAMBAH KETERANGAN_UTAMA, 
					A.NO_REF3 BUKTI_PENDUKUNG, B.NO_SEQ NOMOR, B.KD_BUKU_BESAR, B.KD_SUB_BANTU, B.KD_BUKU_PUSAT, AMBIL_BUKU_BESAR_NAMA(B.KD_BUKU_BESAR) NM_BUKU_BESAR_WITH_PARENT, C.NM_BUKU_BESAR, E.MPLG_NAMA NM_SUB_BANTU, D.NM_BUKU_BESAR NM_BUKU_PUSAT,
					B.KET_TAMBAH KETERANGAN_DETIL, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, SALDO_VAL_DEBET SALDO_RP_DEBET, SALDO_VAL_KREDIT SALDO_RP_KREDIT, 
					A.JML_RP_TRANS, A.NO_POSTING, A.TGL_POSTING
				FROM KBBT_JUR_BB A 
				INNER JOIN KBBT_JUR_BB_D B ON A.NO_NOTA = B.NO_NOTA 
				INNER JOIN KBBR_BUKU_BESAR C ON C.KD_BUKU_BESAR = B.KD_BUKU_BESAR
				INNER JOIN KBBR_BUKU_PUSAT D ON D.KD_BUKU_BESAR = B.KD_BUKU_PUSAT
				INNER JOIN SAFM_PELANGGAN E ON E.MPLG_KODE = B.KD_SUB_BANTU 
				WHERE 1=1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
  } 
?>