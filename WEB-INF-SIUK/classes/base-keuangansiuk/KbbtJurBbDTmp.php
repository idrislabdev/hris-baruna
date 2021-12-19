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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_JUR_BB_D_TMP.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbtJurBbDTmp extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtJurBbDTmp()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KBBT_JUR_BB_D_TMP_ID", $this->getNextId("KBBT_JUR_BB_D_TMP_ID","KBBT_JUR_BB_D_TMP")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_JUR_BB_D_TMP (
					   KD_CABANG, NO_NOTA, NO_SEQ, 
					   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
					   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
					   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
					   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
					   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
					   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
					   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
					   REF_NOTA_JUAL_BELI, BAYAR_VIA) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("NO_NOTA")."', '".$this->getField("NO_SEQ")."',
						'".$this->getField("KD_SUBSIS")."', '".$this->getField("KD_JURNAL")."', '".$this->getField("TIPE_TRANS")."',
						'".$this->getField("KLAS_TRANS")."', '".$this->getField("KD_BUKU_BESAR")."', '".$this->getField("KD_SUB_BANTU")."',
						'".$this->getField("KD_BUKU_PUSAT")."', '".$this->getField("KD_VALUTA")."', ".$this->getField("TGL_VALUTA").",
						'".$this->getField("KURS_VALUTA")."', '".$this->getField("SALDO_VAL_DEBET")."', '".$this->getField("SALDO_VAL_KREDIT")."',
						'".$this->getField("SALDO_RP_DEBET")."', '".$this->getField("SALDO_RP_KREDIT")."', '".$this->getField("KET_TAMBAH")."',
						'".$this->getField("TANDA_TRANS")."', '".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").",
						'".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."', '".$this->getField("PREV_NO_NOTA")."',
						'".$this->getField("REF_NOTA_JUAL_BELI")."', 
						'".$this->getField("BAYAR_VIA")."',
						'".$this->getField("LOKASI_AKTIVA")."'
				)";
				
		$this->id = $this->getField("KBBT_JUR_BB_D_TMP_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBT_JUR_BB_D_TMP
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
					   LOKASI_AKTIVA      = '".$this->getField("LOKASI_AKTIVA")."'
				WHERE  NO_NOTA = '".$this->getField("NO_NOTA")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBT_JUR_BB_D_TMP
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callPKbbtJurBbDToTmp()
	{
        $str = "
				CALL P_KBBT_JUR_BB_D_TO_TMP_IMAIS('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
		// echo $str;exit();
        return $this->execQuery($str);
    }

	function callKopiJurnalBBD()
	{
        $str = "
				CALL KOPI_JURNAL_BB_D('".$this->getField("NO_NOTA")."')
		"; 
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
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
                D.NM_SUB_BANTU NAMA_KK, A.FAKTUR_PAJAK, A.TGL_FAKTUR_PAJAK,A.LOKASI_AKTIVA,
                CASE 
                    WHEN B.POLA_ENTRY = 1 THEN ''
                    WHEN B.POLA_ENTRY = 2 THEN 'DISABLED'
                    WHEN B.POLA_ENTRY = 3 THEN ''
                    ELSE 'DISABLED'
                END DISABLE_KARTU,
                CASE 
                    WHEN B.POLA_ENTRY = 1 THEN 'DISABLED'
                    WHEN B.POLA_ENTRY = 2 THEN ''
                    WHEN B.POLA_ENTRY = 3 THEN ''
                    ELSE 'DISABLED'
                END DISABLE_BPUSAT 
                FROM KBBT_JUR_BB_D_TMP A 
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
		$this->query = $str;
		// echo $str;exit();
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
				REF_NOTA_JUAL_BELI, BAYAR_VIA,LOKASI_AKTIVA
				FROM KBBT_JUR_BB_D_TMP
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
		$str = "SELECT COUNT(NO_NOTA) AS ROWCOUNT FROM KBBT_JUR_BB_D_TMP
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
		$str = "SELECT COUNT(NO_NOTA) AS ROWCOUNT FROM KBBT_JUR_BB_D_TMP
		        WHERE 1 = 1 ".$statement; 
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