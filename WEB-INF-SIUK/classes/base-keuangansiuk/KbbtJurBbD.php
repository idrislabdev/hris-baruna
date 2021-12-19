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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_JUR_BB_D.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbtJurBbD extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtJurBbD()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("NO_NOTA", $this->getNextId("NO_NOTA","KBBT_JUR_BB_D")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_JUR_BB_D (
					   KD_CABANG, NO_NOTA, NO_SEQ, 
					   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
					   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
					   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
					   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
					   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
					   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
					   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
					   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK, FAKTUR_PAJAK, TGL_FAKTUR_PAJAK, LOKASI_AKTIVA) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("NO_NOTA")."', '".$this->getField("NO_SEQ")."',
						'".$this->getField("KD_SUBSIS")."', '".$this->getField("KD_JURNAL")."', '".$this->getField("TIPE_TRANS")."',
						'".$this->getField("KLAS_TRANS")."', '".$this->getField("KD_BUKU_BESAR")."', NVL('".$this->getField("KD_SUB_BANTU")."', '00000'),
						NVL('".$this->getField("KD_BUKU_PUSAT")."', '000.00.00'), '".$this->getField("KD_VALUTA")."', ".$this->getField("TGL_VALUTA").",
						'".$this->getField("KURS_VALUTA")."', NVL('".$this->getField("SALDO_VAL_DEBET")."', 0), NVL('".$this->getField("SALDO_VAL_KREDIT")."', 0),
						NVL('".$this->getField("SALDO_RP_DEBET")."', 0), NVL('".$this->getField("SALDO_RP_KREDIT")."', 0), '".$this->getField("KET_TAMBAH")."',
						'".$this->getField("TANDA_TRANS")."', '".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").",
						'".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."', '".$this->getField("PREV_NO_NOTA")."',
						'".$this->getField("REF_NOTA_JUAL_BELI")."', '".$this->getField("BAYAR_VIA")."', '".$this->getField("STATUS_KENA_PAJAK")."', 
						'".$this->getField("FAKTUR_PAJAK")."',
						".$this->getField("TGL_FAKTUR_PAJAK").",
						'".$this->getField("LOKASI_AKTIVA")."'
				)";
				
		$this->id = $this->getField("NO_NOTA");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE KBBT_JUR_BB_D
				SET    
					   KD_CABANG          = '".$this->getField("KD_CABANG")."',
					   NO_NOTA            = '".$this->getField("NO_NOTA")."',
					   NO_SEQ             = '".$this->getField("NO_SEQ")."',
					   KD_SUBSIS          = '".$this->getField("KD_SUBSIS")."',
					   KD_JURNAL          = '".$this->getField("KD_JURNAL")."',
					   TIPE_TRANS         = '".$this->getField("TIPE_TRANS")."',
					   KLAS_TRANS         = '".$this->getField("KLAS_TRANS")."',
					   KD_BUKU_BESAR      = '".$this->getField("KD_BUKU_BESAR")."',
					   KD_SUB_BANTU       = '".$this->getField("KD_SUB_BANTU")."',
					   KD_BUKU_PUSAT      = '".$this->getField("KD_BUKU_PUSAT")."',
					   KD_VALUTA          = '".$this->getField("KD_VALUTA")."',
					   TGL_VALUTA         = ".$this->getField("TGL_VALUTA").",
					   KURS_VALUTA        = '".$this->getField("KURS_VALUTA")."',
					   SALDO_VAL_DEBET    = '".$this->getField("SALDO_VAL_DEBET")."',
					   SALDO_VAL_KREDIT   = '".$this->getField("SALDO_VAL_KREDIT")."',
					   SALDO_RP_DEBET     = '".$this->getField("SALDO_RP_DEBET")."',
					   SALDO_RP_KREDIT    = '".$this->getField("SALDO_RP_KREDIT")."',
					   KET_TAMBAH         = '".$this->getField("KET_TAMBAH")."',
					   TANDA_TRANS        = '".$this->getField("TANDA_TRANS")."',
					   KD_AKTIF           = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE   = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY    = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME       = '".$this->getField("PROGRAM_NAME")."',
					   PREV_NO_NOTA       = '".$this->getField("PREV_NO_NOTA")."',
					   REF_NOTA_JUAL_BELI = '".$this->getField("REF_NOTA_JUAL_BELI")."',
					   BAYAR_VIA          = '".$this->getField("BAYAR_VIA")."',
					   STATUS_KENA_PAJAK  = '".$this->getField("STATUS_KENA_PAJAK")."',
					   LOKASI_AKTIVA      = '".$this->getField("LOKASI_AKTIVA")."'
				WHERE  NO_NOTA = '".$this->getField("NO_NOTA")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateJurnal()
	{
		$str = "
				UPDATE KBBT_JUR_BB_D
				SET    
					   KD_BUKU_BESAR      = '".$this->getField("KD_BUKU_BESAR")."',
					   KD_SUB_BANTU       = '".$this->getField("KD_SUB_BANTU")."',
					   KD_BUKU_PUSAT      = '".$this->getField("KD_BUKU_PUSAT")."',
					   SALDO_VAL_DEBET    = '".$this->getField("SALDO_VAL_DEBET")."',
					   SALDO_VAL_KREDIT   = '".$this->getField("SALDO_VAL_KREDIT")."',
					   SALDO_RP_DEBET     = '".$this->getField("SALDO_RP_DEBET")."',
					   SALDO_RP_KREDIT    = '".$this->getField("SALDO_RP_KREDIT")."'
					   LOKASI_AKTIVA      = '".$this->getField("LOKASI_AKTIVA")."'
				WHERE  NO_NOTA = '".$this->getField("NO_NOTA")."' AND NO_SEQ = '".$this->getField("NO_SEQ")."' 
			";
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateJurnalRegisterKasir()
	{
		$str = "
				UPDATE KBBT_JUR_BB_D
				SET    
					   KD_BUKU_BESAR      = '".$this->getField("KD_BUKU_BESAR")."',
					   KD_SUB_BANTU       = '".$this->getField("KD_SUB_BANTU")."',
					   KD_BUKU_PUSAT      = '".$this->getField("KD_BUKU_PUSAT")."'
					   LOKASI_AKTIVA      = '".$this->getField("LOKASI_AKTIVA")."'
				WHERE  NO_NOTA = '".$this->getField("NO_NOTA")."' AND NO_SEQ = '".$this->getField("NO_SEQ")."' 
			";
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
			
	function updatePembatalanSudahCetakNota()
	{
        $str = "UPDATE KBBT_JUR_BB_D SET
				PREV_NO_NOTA = '".$this->getField("PREV_NO_NOTA")."'
                WHERE 
                NO_NOTA = '".$this->getField("NO_NOTA")."' AND KD_BUKU_BESAR LIKE '104%' "; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "DELETE FROM KBBT_JUR_BB_D
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."'"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY NO_NOTA ASC ")
	{
		$str = "
				SELECT A.KD_CABANG, A.NO_NOTA, NO_SEQ, 
                KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
                KLAS_TRANS, A.KD_BUKU_BESAR, KD_SUB_BANTU, 
                A.KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
                KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
                TANDA_TRANS, A.KD_AKTIF, A.LAST_UPDATE_DATE, 
                A.LAST_UPDATED_BY, A.PROGRAM_NAME, PREV_NO_NOTA, LOKASI_AKTIVA,
                REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK, NM_BUKU_BESAR, A.FAKTUR_PAJAK, A.TGL_FAKTUR_PAJAK
                FROM KBBT_JUR_BB_D A INNER JOIN KBBR_BUKU_BESAR B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR
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

    function selectByParamsJurnal($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT A.KD_CABANG, A.NO_NOTA, A.NO_SEQ, 
				KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
				KLAS_TRANS, A.KD_BUKU_BESAR, KD_SUB_BANTU, 
				A.KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
				KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
				SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
				TANDA_TRANS, A.KD_AKTIF, A.LAST_UPDATE_DATE, 
				A.LAST_UPDATED_BY, A.PROGRAM_NAME, PREV_NO_NOTA, 
				REF_NOTA_JUAL_BELI, BAYAR_VIA,
                B.NM_BUKU_BESAR NAMA_BB,
                C.NM_BUKU_BESAR NAMA_BP,
                D.NM_SUB_BANTU NAMA_KK,LOKASI_AKTIVA
				FROM KBBT_JUR_BB_D A 
                LEFT JOIN KBBR_BUKU_BESAR B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR
                LEFT JOIN KBBR_BUKU_PUSAT C ON A.KD_BUKU_PUSAT = C.KD_BUKU_BESAR
                LEFT JOIN KBBR_KARTU_TAMBAH D ON A.KD_SUB_BANTU = D.KD_SUB_BANTU
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY NO_NOTA DESC, A.NO_SEQ ASC ";
		
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJurnalPelunasan($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT   A.KD_CABANG, A.NO_NOTA, A.NO_SEQ, A.KD_SUBSIS, A.KD_JURNAL, A.TIPE_TRANS,
						 KLAS_TRANS, A.KD_BUKU_BESAR, A.KD_SUB_BANTU, A.KD_BUKU_PUSAT,
						 KD_VALUTA, TGL_VALUTA, KURS_VALUTA, SALDO_VAL_DEBET - NVL(SUDAH_BAYAR, 0) SALDO_VAL_DEBET,
						 SALDO_VAL_KREDIT, SALDO_RP_DEBET - NVL(SUDAH_BAYAR, 0) SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH,
						 TANDA_TRANS, A.KD_AKTIF, A.LAST_UPDATE_DATE, A.LAST_UPDATED_BY,
						 A.PROGRAM_NAME, PREV_NO_NOTA, REF_NOTA_JUAL_BELI, BAYAR_VIA,
						 B.NM_BUKU_BESAR NAMA_BB, C.NM_BUKU_BESAR NAMA_BP,
						 D.NM_SUB_BANTU NAMA_KK, LOKASI_AKTIVA
					FROM KBBT_JUR_BB_D A LEFT JOIN KBBR_BUKU_BESAR B
						 ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR
						 LEFT JOIN KBBR_BUKU_PUSAT C ON A.KD_BUKU_PUSAT = C.KD_BUKU_BESAR
						 LEFT JOIN KBBR_KARTU_TAMBAH D ON A.KD_SUB_BANTU = D.KD_SUB_BANTU
						 LEFT JOIN DAFTAR_PEMBAYARAN_SPP E ON E.PREV_NO_NOTA = A.NO_NOTA AND E.KD_SUB_BANTU = A.KD_SUB_BANTU
				   WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY NO_NOTA DESC, A.NO_SEQ ASC ";
		
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsSiswaSpp($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
					DEPARTEMEN_KELAS_ID, MPLG_KODE, MPLG_NAMA, JUMLAH_SPP, 
					   KODE_BB_SPP, KODE_BP_SPP
					FROM SISWA_SPP_TERAKHIR A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY MPLG_KODE ASC ";
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		
				
    function selectByParamsPostingJurnal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY NO_SEQ ASC ")
	{
		$str = "
				SELECT NO_SEQ, A.KD_BUKU_BESAR || ' - ' || B.NM_BUKU_BESAR BUKU_BESAR, 
				   A.KD_SUB_BANTU || ' - ' || D.NM_SUB_BANTU SUB_BANTU, 
				   A.KD_BUKU_PUSAT || ' - ' || C.NM_BUKU_BESAR BUKU_PUSAT, 
				   A.KD_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, SALDO_RP_DEBET, SALDO_RP_KREDIT, LOKASI_AKTIVA, A.KET_TAMBAH FROM KBBT_JUR_BB_D A
			   INNER JOIN KBBR_BUKU_BESAR B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR 
			   INNER JOIN KBBR_BUKU_PUSAT C ON A.KD_BUKU_PUSAT = C.KD_BUKU_BESAR
			   INNER JOIN KBBR_KARTU_TAMBAH D ON A.KD_SUB_BANTU = D.KD_SUB_BANTU
			   WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, NO_NOTA, NO_SEQ, 
				KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
				KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
				KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
				KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
				SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
				TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
				LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
				REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK,LOKASI_AKTIVA
				FROM KBBT_JUR_BB_D
				WHERE 1 = 1
			   "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KD_CABANG ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(NO_NOTA) AS ROWCOUNT FROM KBBT_JUR_BB_D A INNER JOIN KBBR_BUKU_BESAR B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR
		        WHERE 1=1 ".$statement; 
		
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
    function getSumDebet($paramsArray=array(), $statement="")
	{
		$str = "SELECT NVL(SUM(SALDO_RP_DEBET),0) AS ROWCOUNT FROM KBBT_JUR_BB_D
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

    function getSumKredit($paramsArray=array(), $statement="")
	{
		$str = "SELECT NVL(SUM(SALDO_RP_KREDIT), 0) AS ROWCOUNT FROM KBBT_JUR_BB_D
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
	
	
    function getValidasiPosting($noNota)
	{
		$str = "SELECT COUNT(NO_NOTA) AS ROWCOUNT 
				FROM KBBT_JUR_BB_D A 				
				WHERE NO_NOTA = '".$noNota."' AND 
				(KD_BUKU_BESAR LIKE '5%' AND KD_BUKU_PUSAT = '000.00.00' OR
				 KD_BUKU_BESAR LIKE '4%' AND KD_BUKU_PUSAT = '000.00.00' OR
                 NOT EXISTS(SELECT 1 FROM KBBR_BUKU_BESAR X WHERE X.KD_BUKU_BESAR = A.KD_BUKU_BESAR) OR
                 NOT EXISTS(SELECT 1 FROM KBBR_BUKU_PUSAT X WHERE X.KD_BUKU_BESAR = A.KD_BUKU_PUSAT)) "; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
    function getSumDebetVal($paramsArray=array(), $statement="")
	{
		$str = "SELECT NVL(SUM(SALDO_VAL_DEBET),0) AS ROWCOUNT FROM KBBT_JUR_BB_D
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
	
	function getSumKreditVal($paramsArray=array(), $statement="")
	{
		$str = "SELECT NVL(SUM(SALDO_VAL_KREDIT),0) AS ROWCOUNT FROM KBBT_JUR_BB_D
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
	
    function getCountByParamsPostingJurnal($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(NO_NOTA) AS ROWCOUNT FROM KBBT_JUR_BB_D A
		        WHERE NO_NOTA IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(NO_NOTA) AS ROWCOUNT FROM KBBT_JUR_BB_D
		        WHERE NO_NOTA IS NOT NULL ".$statement; 
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