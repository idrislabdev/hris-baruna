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
  * EntitySIUK-base class untuk mengimplementasikan tabel KPTT_NOTA_SPP.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KpttNotaSpp extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KpttNotaSpp()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("TIPE_TRANS", $this->getNextId("TIPE_TRANS","KPTT_NOTA_SPP")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KPTT_NOTA_SPP (
					   KD_CABANG, KD_SUBSIS, JEN_JURNAL, 
					   TIPE_TRANS, NO_NOTA, NO_NOTA_JUAL, 
					   JNS_JUAL, NO_REF1, NO_REF2, 
					   NO_REF3, KD_KUSTO, BADAN_USAHA, 
					   KD_BB_KUSTO, KD_UNITK, JEN_TRANS, 
					   TGL_ENTRY, TGL_TRANS, TGL_NOTA_DITERIMA, 
					   TGL_JT_TEMPO, TGL_VALUTA, KD_VALUTA, 
					   KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
					   TANDA_TRANS, KD_BB_PAJAK1, PPN1_PERSEN, 
					   KD_BB_PAJAK2, PPN2_PERSEN, METERAI, 
					   KD_BB_METERAI, PPN_PEM_PERSEN, BAGIHASIL_PERSEN, 
					   JML_VAL_REDUKSI, JML_VAL_BAYAR, SISA_VAL_BAYAR, 
					   KD_BANK, REK_BANK, KD_BB_BANK, 
					   NO_WD_UPER, JML_WD_UPPER, KD_BB_UPER, 
					   KD_BAYAR, NO_CHEQUE, THN_BUKU, 
					   BLN_BUKU, KET_TAMBAHAN, KD_OBYEK, 
					   NO_VOYAGE, STATUS_PROSES, NO_POSTING, 
					   CETAK_NOTA, LAST_APPROVE_DATE, LAST_APPROVE_BY, 
					   PREV_NOTA_UPDATE, REF_NOTA_CICILAN, PERIODE_CICILAN, 
					   JML_KALI_CICILAN, CICILAN_KE, JT_TEMPO_CICILAN, 
					   ID_KASIR, AUTO_MANUAL, PREV_SISA_BAYAR, 
					   STAT_RKP_KARTU, TGL_POSTING, NO_FAKT_PAJAK, 
					   JML_VAL_PAJAK, JML_RP_PAJAK, JML_WDANA, 
					   BULTAH, CETAK_APBMI, NO_WDANA, 
					   FLAG_APBMI, TGL_CETAK, KD_TERMINAL, 
					   LOKASI, KD_NOTA, FLAG_EKSPEDISI, 
					   NO_EKSPEDISI, TGL_EKSPEDISI, NO_SP, 
					   TGL_SP, NO_KN_BANK, TGL_KN_BANK, 
					   LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
					   NO_REG, FLAG_TUNAI, TGL_BATAL, 
					   NO_NOTA_BTL, NO_DN, TGL_DN, 
					   FLAG_PUPN, JML_TAGIHAN, SISA_TAGIHAN, 
					   KD_PANGKALAN, FLAG_SETOR_PAJAK, KD_PELAYANAN, 
					   VERIFIED, NO_APPROVAL, TGL_APPROVAL, 
					   TGL_POST_BATAL, TGL_VAL_PAJAK, KURS_VAL_PAJAK, FAKTUR_PAJAK, TGL_FAKTUR_PAJAK, FAKTUR_PAJAK_PREFIX, KET_TAMBAHAN2, 
					   DEPARTEMEN_ID, DEPARTEMEN_KELAS_ID, DEPARTEMEN_KELAS, PERIODE_PEMBAYARAN) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_SUBSIS")."', '".$this->getField("JEN_JURNAL")."',
						'".$this->getField("TIPE_TRANS")."', '".$this->getField("NO_NOTA")."', '".$this->getField("NO_NOTA_JUAL")."',
						'".$this->getField("JNS_JUAL")."', '".$this->getField("NO_REF1")."', '".$this->getField("NO_REF2")."',
						'".$this->getField("NO_REF3")."', '".$this->getField("KD_KUSTO")."', '".$this->getField("BADAN_USAHA")."',
						".$this->getField("KD_BB_KUSTO").", '".$this->getField("KD_UNITK")."', '".$this->getField("JEN_TRANS")."',
					    ".$this->getField("TGL_ENTRY").", ".$this->getField("TGL_TRANS").", ".$this->getField("TGL_NOTA_DITERIMA").",
						".$this->getField("TGL_JT_TEMPO").", ".$this->getField("TGL_VALUTA").", '".$this->getField("KD_VALUTA")."',
						'".$this->getField("KURS_VALUTA")."', ".$this->getField("JML_VAL_TRANS").", '".$this->getField("JML_RP_TRANS")."',
						'".$this->getField("TANDA_TRANS")."', '".$this->getField("KD_BB_PAJAK1")."', '".$this->getField("PPN1_PERSEN")."',
						'".$this->getField("KD_BB_PAJAK2")."', '".$this->getField("PPN2_PERSEN")."', '".$this->getField("METERAI")."',
						'".$this->getField("KD_BB_METERAI")."', '".$this->getField("PPN_PEM_PERSEN")."', '".$this->getField("BAGIHASIL_PERSEN")."',
					    '".$this->getField("JML_VAL_REDUKSI")."', '".$this->getField("JML_VAL_BAYAR")."', '".$this->getField("SISA_VAL_BAYAR")."',
						'".$this->getField("KD_BANK")."', '".$this->getField("REK_BANK")."', '".$this->getField("KD_BB_BANK")."',
						'".$this->getField("NO_WD_UPER")."', '".$this->getField("JML_WD_UPPER")."', '".$this->getField("KD_BB_UPER")."',
						'".$this->getField("KD_BAYAR")."', '".$this->getField("NO_CHEQUE")."', '".$this->getField("THN_BUKU")."',
						'".$this->getField("BLN_BUKU")."', '".$this->getField("KET_TAMBAHAN")."', '".$this->getField("KD_OBYEK")."',
						'".$this->getField("NO_VOYAGE")."', '".$this->getField("STATUS_PROSES")."', '".$this->getField("NO_POSTING")."',
						'".$this->getField("CETAK_NOTA")."', ".$this->getField("LAST_APPROVE_DATE").", '".$this->getField("LAST_APPROVE_BY")."',
						'".$this->getField("PREV_NOTA_UPDATE")."', '".$this->getField("REF_NOTA_CICILAN")."', '".$this->getField("PERIODE_CICILAN")."',
						'".$this->getField("JML_KALI_CICILAN")."', '".$this->getField("CICILAN_KE")."', ".$this->getField("JT_TEMPO_CICILAN").",
						'".$this->getField("ID_KASIR")."', '".$this->getField("AUTO_MANUAL")."', '".$this->getField("PREV_SISA_BAYAR")."',
						'".$this->getField("STAT_RKP_KARTU")."', ".$this->getField("TGL_POSTING").", '".$this->getField("NO_FAKT_PAJAK")."',
						'".$this->getField("JML_VAL_PAJAK")."', '".$this->getField("JML_RP_PAJAK")."', '".$this->getField("JML_WDANA")."',
						'".$this->getField("BULTAH")."', '".$this->getField("CETAK_APBMI")."', '".$this->getField("NO_WDANA")."',
						'".$this->getField("FLAG_APBMI")."', ".$this->getField("TGL_CETAK").", '".$this->getField("KD_TERMINAL")."',
						'".$this->getField("LOKASI")."', '".$this->getField("KD_NOTA")."', '".$this->getField("FLAG_EKSPEDISI")."',
						'".$this->getField("NO_EKSPEDISI")."', ".$this->getField("TGL_EKSPEDISI").", '".$this->getField("NO_SP")."',
						".$this->getField("TGL_SP").", '".$this->getField("NO_KN_BANK")."', ".$this->getField("TGL_KN_BANK").",
						".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."',
						'".$this->getField("NO_REG")."', '".$this->getField("FLAG_TUNAI")."', ".$this->getField("TGL_BATAL").",
						'".$this->getField("NO_NOTA_BTL")."', '".$this->getField("NO_DN")."', ".$this->getField("TGL_DN").",
						'".$this->getField("FLAG_PUPN")."', '".$this->getField("JML_TAGIHAN")."', '".$this->getField("SISA_TAGIHAN")."',
						'".$this->getField("KD_PANGKALAN")."', '".$this->getField("FLAG_SETOR_PAJAK")."', '".$this->getField("KD_PELAYANAN")."',
						'".$this->getField("VERIFIED")."', '".$this->getField("NO_APPROVAL")."', ".$this->getField("TGL_APPROVAL").",
						".$this->getField("TGL_POST_BATAL").", ".$this->getField("TGL_VAL_PAJAK").", '".$this->getField("KURS_VAL_PAJAK")."', 
						'".$this->getField("FAKTUR_PAJAK")."', ".$this->getField("TGL_FAKTUR_PAJAK").", '".$this->getField("FAKTUR_PAJAK_PREFIX")."', 
						'".$this->getField("KET_TAMBAHAN2")."', 
						'".$this->getField("DEPARTEMEN_ID")."', '".$this->getField("DEPARTEMEN_KELAS_ID")."', '".$this->getField("DEPARTEMEN_KELAS")."', '".$this->getField("PERIODE_PEMBAYARAN")."'
				  )"; 
		$this->id = $this->getField("NO_NOTA");
		// echo $str;exit();
		$this->query = $str;
		
		
		return $this->execQuery($str);
    }

    function koreksi()
    {
    	$str = " INSERT INTO KPTT_NOTA_SPP_BAK
    			 SELECT * FROM KPTT_NOTA_SPP WHERE NO_NOTA= '".$this->getField("NO_NOTA")."' ";
    	$this->execQuery($str);
    	$str = " INSERT INTO KPTT_NOTA_SPP_D_BAK
    			 SELECT * FROM KPTT_NOTA_SPP_D WHERE NO_NOTA= '".$this->getField("NO_NOTA")."' ";
    	$this->execQuery($str);
    	
    	$str = " DELETE  FROM KPTT_NOTA_SPP_D WHERE NO_NOTA= '".$this->getField("NO_NOTA")."' ";
    	$this->execQuery($str);

    	$str = " DELETE  FROM KPTT_NOTA_SPP WHERE NO_NOTA= '".$this->getField("NO_NOTA")."' ";
		return $this->execQuery($str);

    }

    function batalkan()
    {

		$str = "
				UPDATE KPTT_NOTA_SPP
				SET    
					   NO_POSTING = NULL,
					   TGL_POSTING =  NULL
				WHERE  NO_POSTING			 = '".$this->getField("NO_NOTA")."'				
			";
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KPTT_NOTA_SPP
				SET    
					   KD_CABANG         = '".$this->getField("KD_CABANG")."',
					   KD_SUBSIS         = '".$this->getField("KD_SUBSIS")."',
					   JEN_JURNAL        = '".$this->getField("JEN_JURNAL")."',
					   TIPE_TRANS        = '".$this->getField("TIPE_TRANS")."',
					   NO_NOTA           = '".$this->getField("NO_NOTA")."',
					   NO_NOTA_JUAL      = '".$this->getField("NO_NOTA_JUAL")."',
					   JNS_JUAL          = '".$this->getField("JNS_JUAL")."',
					   NO_REF1           = '".$this->getField("NO_REF1")."',
					   NO_REF2           = '".$this->getField("NO_REF2")."',
					   NO_REF3           = '".$this->getField("NO_REF3")."',
					   KD_KUSTO          = '".$this->getField("KD_KUSTO")."',
					   BADAN_USAHA       = '".$this->getField("BADAN_USAHA")."',
					   KD_BB_KUSTO       = '".$this->getField("KD_BB_KUSTO")."',
					   KD_UNITK          = '".$this->getField("KD_UNITK")."',
					   JEN_TRANS         = '".$this->getField("JEN_TRANS")."',
					   TGL_ENTRY         = ".$this->getField("TGL_ENTRY").",
					   TGL_TRANS         = ".$this->getField("TGL_TRANS").",
					   TGL_NOTA_DITERIMA = ".$this->getField("TGL_NOTA_DITERIMA").",
					   TGL_JT_TEMPO      = ".$this->getField("TGL_JT_TEMPO").",
					   TGL_VALUTA        = ".$this->getField("TGL_VALUTA").",
					   KD_VALUTA         = '".$this->getField("KD_VALUTA")."',
					   KURS_VALUTA       = '".$this->getField("KURS_VALUTA")."',
					   JML_VAL_TRANS     = '".$this->getField("JML_VAL_TRANS")."',
					   JML_RP_TRANS      = '".$this->getField("JML_RP_TRANS")."',
					   TANDA_TRANS       = '".$this->getField("TANDA_TRANS")."',
					   KD_BB_PAJAK1      = '".$this->getField("KD_BB_PAJAK1")."',
					   PPN1_PERSEN       = '".$this->getField("PPN1_PERSEN")."',
					   KD_BB_PAJAK2      = '".$this->getField("KD_BB_PAJAK2")."',
					   PPN2_PERSEN       = '".$this->getField("PPN2_PERSEN")."',
					   METERAI           = '".$this->getField("METERAI")."',
					   KD_BB_METERAI     = '".$this->getField("KD_BB_METERAI")."',
					   PPN_PEM_PERSEN    = '".$this->getField("PPN_PEM_PERSEN")."',
					   BAGIHASIL_PERSEN  = '".$this->getField("BAGIHASIL_PERSEN")."',
					   JML_VAL_REDUKSI   = '".$this->getField("JML_VAL_REDUKSI")."',
					   JML_VAL_BAYAR     = '".$this->getField("JML_VAL_BAYAR")."',
					   SISA_VAL_BAYAR    = '".$this->getField("SISA_VAL_BAYAR")."',
					   KD_BANK           = '".$this->getField("KD_BANK")."',
					   REK_BANK          = '".$this->getField("REK_BANK")."',
					   KD_BB_BANK        = '".$this->getField("KD_BB_BANK")."',
					   NO_WD_UPER        = '".$this->getField("NO_WD_UPER")."',
					   JML_WD_UPPER      = '".$this->getField("JML_WD_UPPER")."',
					   KD_BB_UPER        = '".$this->getField("KD_BB_UPER")."',
					   KD_BAYAR          = '".$this->getField("KD_BAYAR")."',
					   NO_CHEQUE         = '".$this->getField("NO_CHEQUE")."',
					   THN_BUKU          = '".$this->getField("THN_BUKU")."',
					   BLN_BUKU          = '".$this->getField("BLN_BUKU")."',
					   KET_TAMBAHAN      = '".$this->getField("KET_TAMBAHAN")."',
					   KD_OBYEK          = '".$this->getField("KD_OBYEK")."',
					   NO_VOYAGE         = '".$this->getField("NO_VOYAGE")."',
					   STATUS_PROSES     = '".$this->getField("STATUS_PROSES")."',
					   NO_POSTING        = '".$this->getField("NO_POSTING")."',
					   CETAK_NOTA        = '".$this->getField("CETAK_NOTA")."',
					   LAST_APPROVE_DATE = ".$this->getField("LAST_APPROVE_DATE").",
					   LAST_APPROVE_BY   = '".$this->getField("LAST_APPROVE_BY")."',
					   PREV_NOTA_UPDATE  = '".$this->getField("PREV_NOTA_UPDATE")."',
					   REF_NOTA_CICILAN  = '".$this->getField("REF_NOTA_CICILAN")."',
					   PERIODE_CICILAN   = '".$this->getField("PERIODE_CICILAN")."',
					   JML_KALI_CICILAN  = '".$this->getField("JML_KALI_CICILAN")."',
					   CICILAN_KE        = '".$this->getField("CICILAN_KE")."',
					   JT_TEMPO_CICILAN  = ".$this->getField("JT_TEMPO_CICILAN").",
					   ID_KASIR          = '".$this->getField("ID_KASIR")."',
					   AUTO_MANUAL       = '".$this->getField("AUTO_MANUAL")."',
					   PREV_SISA_BAYAR   = '".$this->getField("PREV_SISA_BAYAR")."',
					   STAT_RKP_KARTU    = '".$this->getField("STAT_RKP_KARTU")."',
					   TGL_POSTING       = ".$this->getField("TGL_POSTING").",
					   NO_FAKT_PAJAK     = '".$this->getField("NO_FAKT_PAJAK")."',
					   JML_VAL_PAJAK     = '".$this->getField("JML_VAL_PAJAK")."',
					   JML_RP_PAJAK      = '".$this->getField("JML_RP_PAJAK")."',
					   JML_WDANA         = '".$this->getField("JML_WDANA")."',
					   BULTAH            = '".$this->getField("BULTAH")."',
					   CETAK_APBMI       = '".$this->getField("CETAK_APBMI")."',
					   NO_WDANA          = '".$this->getField("NO_WDANA")."',
					   FLAG_APBMI        = '".$this->getField("FLAG_APBMI")."',
					   TGL_CETAK         = ".$this->getField("TGL_CETAK").",
					   KD_TERMINAL       = '".$this->getField("KD_TERMINAL")."',
					   LOKASI            = '".$this->getField("LOKASI")."',
					   KD_NOTA           = '".$this->getField("KD_NOTA")."',
					   FLAG_EKSPEDISI    = '".$this->getField("FLAG_EKSPEDISI")."',
					   NO_EKSPEDISI      = '".$this->getField("NO_EKSPEDISI")."',
					   TGL_EKSPEDISI     = ".$this->getField("TGL_EKSPEDISI").",
					   NO_SP             = '".$this->getField("NO_SP")."',
					   TGL_SP            = ".$this->getField("TGL_SP").",
					   NO_KN_BANK        = '".$this->getField("NO_KN_BANK")."',
					   TGL_KN_BANK       = ".$this->getField("TGL_KN_BANK").",
					   LAST_UPDATE_DATE  = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY   = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME      = '".$this->getField("PROGRAM_NAME")."',
					   NO_REG            = '".$this->getField("NO_REG")."',
					   FLAG_TUNAI        = '".$this->getField("FLAG_TUNAI")."',
					   TGL_BATAL         = ".$this->getField("TGL_BATAL").",
					   NO_NOTA_BTL       = '".$this->getField("NO_NOTA_BTL")."',
					   NO_DN             = '".$this->getField("NO_DN")."',
					   TGL_DN            = ".$this->getField("TGL_DN").",
					   FLAG_PUPN         = '".$this->getField("FLAG_PUPN")."',
					   JML_TAGIHAN       = '".$this->getField("JML_TAGIHAN")."',
					   SISA_TAGIHAN      = '".$this->getField("SISA_TAGIHAN")."',
					   KD_PANGKALAN      = '".$this->getField("KD_PANGKALAN")."',
					   FLAG_SETOR_PAJAK  = '".$this->getField("FLAG_SETOR_PAJAK")."',
					   KD_PELAYANAN      = '".$this->getField("KD_PELAYANAN")."',
					   VERIFIED          = '".$this->getField("VERIFIED")."',
					   NO_APPROVAL       = '".$this->getField("NO_APPROVAL")."',
					   TGL_APPROVAL      = ".$this->getField("TGL_APPROVAL").",
					   TGL_POST_BATAL    = ".$this->getField("TGL_POST_BATAL").",
					   TGL_VAL_PAJAK     = ".$this->getField("TGL_VAL_PAJAK").",
					   KURS_VAL_PAJAK    = '".$this->getField("KURS_VAL_PAJAK")."',
					   FAKTUR_PAJAK      = '".$this->getField("FAKTUR_PAJAK")."',
					   TGL_FAKTUR_PAJAK  = ".$this->getField("TGL_FAKTUR_PAJAK").",
					   FAKTUR_PAJAK_PREFIX = '".$this->getField("FAKTUR_PAJAK_PREFIX")."',
					   KET_TAMBAHAN2 =  '".$this->getField("KET_TAMBAHAN2")."'
				WHERE  NO_NOTA			 = '".$this->getField("NO_NOTA")."'				
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function updateValBayar()
	{
        $str = "UPDATE KPTT_NOTA_SPP SET
				JML_VAL_BAYAR = JML_VAL_BAYAR - NVL((SELECT SUM(JML_VAL_TRANS) FROM KPTT_NOTA_SPP_D X WHERE NO_NOTA = '".$this->getField("NO_NOTA_JKM")."'), 0)
				WHERE 
                NO_NOTA = '".$this->getField("NO_NOTA_JPJ")."' "; 
				  
		$this->query = $str;
				  
        return $this->execQuery($str);
    }

	function insertPelunasanGL()
	{
        $str = "INSERT INTO KPTT_NOTA_SPP_PELUNASAN_GL (
					   NO_NOTA, KD_SUB_BANTU, LAST_CREATE_USER, LAST_CREATE_DATE) 
					VALUES ('".$this->getField("NO_NOTA")."', '".$this->getField("KD_SUB_BANTU")."', '".$this->getField("LAST_CREATE_USER")."', SYSDATE)"; 
				  
		$this->query = $str;
				  
        return $this->execQuery($str);
    }


	function updatePembatalanSudahCetakNota()
	{
        $str = "UPDATE KPTT_NOTA_SPP SET
				STATUS_PROSES = 2,
				TGL_BATAL = ".$this->getField("TGL_BATAL").",
    			PREV_NOTA_UPDATE = '".$this->getField("PREV_NOTA_UPDATE")."'
                WHERE 
                NO_NOTA = '".$this->getField("NO_NOTA")."' "; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }

	function updatePembatalanFakturPajak()
	{
        $str = "UPDATE KPTT_NOTA_SPP SET
				FAKTUR_PAJAK = '',
				FAKTUR_PAJAK_PREFIX = ''
                WHERE 
                NO_NOTA = '".$this->getField("NO_NOTA")."' "; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }
	
	function updatePembatalanPelunasan()
	{
        $str = "UPDATE KPTT_NOTA_SPP SET
				STATUS_PROSES = 2 WHERE
                NO_NOTA = '".$this->getField("NO_NOTA")."' "; 
				  
		$this->query = $str;
		//echo $str;
		
        return $this->execQuery($str);
    }

	function updatePembatalanPelunasanDelete()
	{
        $str = "UPDATE KPTT_NOTA_SPP SET
				STATUS_PROSES = 1 WHERE
                NO_NOTA = '".$this->getField("NO_NOTA")."' "; 
				  
		$this->query = $str;
		//echo $str;
		
        return $this->execQuery($str);
    }
			
	function updatePrevNotaSisaTagihan()
	{
        $str = "UPDATE KPTT_NOTA_SPP SET
				PREV_NOTA_UPDATE  = '".$this->getField("PREV_NOTA_UPDATE")."'
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."' AND NOT NVL(SISA_TAGIHAN,0) = 0 "; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }

	function updatePrevNota()
	{
        $str = "UPDATE KPTT_NOTA_SPP SET
				PREV_NOTA_UPDATE  = '".$this->getField("PREV_NOTA_UPDATE")."'
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."'"; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }
	
	function updateNotaDinas()
	{
        $str = "UPDATE KPTT_NOTA_SPP SET
				NO_NOTA_DINAS  = '".$this->getField("NO_NOTA_DINAS")."',
				KET_NOTA_DINAS = '".$this->getField("KET_NOTA_DINAS")."'
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
		


	function updateNoPosting()
	{
        $str = "UPDATE KPTT_NOTA_SPP SET
				NO_POSTING     = '".$this->getField("NO_POSTING")."',
				TGL_POSTING    = TRUNC(SYSDATE)
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
		

	function delete()
	{

        $str = "DELETE FROM KPTT_NOTA_SPP_D
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."'"; 
				  

        $str = "DELETE FROM KPTT_NOTA_SPP
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function callGenerateJrrNota()
	{
        $str = "
				CALL GENERATE_JRR_NOTA('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }			

	function callGenerateFakturPajak()
	{
        $str = "
				CALL GENERATE_FAKTUR_PAJAK('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	

	function callFlagSetorPajak()
	{
        $str = "
				CALL FLAG_SETOR_PAJAK('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }
		
	function callDeleteNotaSuspend()
	{
        $str = "
				CALL DEL_NOTA_SUSPEND('".$this->getField("KD_BUKTI")."', ".$this->getField("TANGGAL_TRANS").", '".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	

	function callAddCekJurVals()
	{
        $str = "
				CALL ADD_CEK_JUR_VALS_IMAIS('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }			

	function callInsertJmlTagihan()
	{
        $str = "
				CALL INSERT_JML_TAGIHAN('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }			
	
	function callProsesCetakNotaPenjualan()
	{
        $str = "
				CALL PROSES_CETAK_NOTA_PENJUALAN('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
		
        return $this->execQuery($str);
    }		

	function callProsesCetakNotaPenjualanUlang()
	{
        $str = "
				CALL PROSES_CETAK_NOTA_PENJUALAN_UL('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	

	function callAutoPostingPembatalanNota()
	{
        $str = "
				CALL AUTO_POSTING_PEMBATALAN_NOTA('".$this->getField("KD_SUBSIS")."', '".$this->getField("NO_NOTA")."', ".$this->getField("TGL_TRANS").", '".$this->getField("PREV_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	

	function callUpdStsNotaUsaha()
	{
        $str = "
				CALL UPD_STSNOTA_USAHA('".$this->getField("NO_NOTA")."', '2')
		"; 
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
		$str = "			    
                SELECT B.MPLG_NPWP, B.MPLG_ALAMAT, B.MPLG_JENIS_USAHA, A.KD_CABANG, A.KD_SUBSIS, JEN_JURNAL, 
                A.TIPE_TRANS, D.TIPE_DESC, A.NO_NOTA, NO_NOTA_JUAL, 
                JNS_JUAL, NO_REF1, NO_REF2, D.AKRONIM_DESC,
                NO_REF3, MPLG_NAMA, KD_KUSTO, BADAN_USAHA, 
                KD_BB_KUSTO, KD_UNITK, JEN_TRANS, 
                TGL_ENTRY, TGL_TRANS, TGL_NOTA_DITERIMA, 
                TGL_JT_TEMPO, TGL_VALUTA, KD_VALUTA, 
                KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
                TANDA_TRANS, KD_BB_PAJAK1, PPN1_PERSEN, 
                KD_BB_PAJAK2, PPN2_PERSEN, METERAI, NVL(METERAI, 9999999) METERAI_PILIH, 
                KD_BB_METERAI, PPN_PEM_PERSEN, BAGIHASIL_PERSEN, 
                JML_VAL_REDUKSI, JML_VAL_BAYAR, SISA_VAL_BAYAR, 
                A.KD_BANK, C.MBANK_NAMA BANK, REK_BANK, A.KD_BB_BANK, F.NM_BUKU_BESAR,
                THN_BUKU ||' / '||BLN_BUKU PERIODE,
                A.KD_BB_BANK ||' / '|| A.REK_BANK REKENING_KAS_BANK,
				KD_BB_BANK REKUTIP, 
                NO_REF3 ||' '||  PREV_NOTA_UPDATE NO_1A,
                KD_BB_BANK||' / '||C.MBANK_NAMA BB_KAS_BANK,
                B.MPLG_KODE||' - '||MPLG_NAMA PELANGGAN,
                NO_WD_UPER, JML_WD_UPPER, KD_BB_UPER, 
                KD_BAYAR, NO_CHEQUE, THN_BUKU, 
                BLN_BUKU, NVL(A.KET_TAMBAHAN2, A.KET_TAMBAHAN) KET_TAMBAHAN, KD_OBYEK, 
                NO_VOYAGE, STATUS_PROSES, NO_POSTING, 
                CETAK_NOTA, LAST_APPROVE_DATE, LAST_APPROVE_BY, 
                PREV_NOTA_UPDATE, REF_NOTA_CICILAN, PERIODE_CICILAN, 
                JML_KALI_CICILAN, CICILAN_KE, JT_TEMPO_CICILAN, 
                ID_KASIR, AUTO_MANUAL, PREV_SISA_BAYAR, 
                STAT_RKP_KARTU, TGL_POSTING, NO_FAKT_PAJAK, 
                JML_VAL_PAJAK, JML_RP_PAJAK, JML_WDANA, 
                BULTAH, CETAK_APBMI, NO_WDANA, 
                FLAG_APBMI, TGL_CETAK, KD_TERMINAL, 
                LOKASI, KD_NOTA, FLAG_EKSPEDISI, 
                NO_EKSPEDISI, TGL_EKSPEDISI, NO_SP, 
                TGL_SP, NO_KN_BANK, TGL_KN_BANK, 
                LAST_UPDATE_DATE, A.LAST_UPDATED_BY, A.PROGRAM_NAME, 
                NO_REG, FLAG_TUNAI, TGL_BATAL, 
                NO_NOTA_BTL, NO_DN, TGL_DN, 
                FLAG_PUPN, JML_TAGIHAN, SISA_TAGIHAN, 
                KD_PANGKALAN, FLAG_SETOR_PAJAK, KD_PELAYANAN, 
                VERIFIED, NO_APPROVAL, TGL_APPROVAL, 
                TGL_POST_BATAL, TGL_VAL_PAJAK, KURS_VAL_PAJAK, JML_VAL_TRANS JUMLAH, FAKTUR_PAJAK, TGL_FAKTUR_PAJAK, FAKTUR_PAJAK_PREFIX, 
				FAKTUR_PAJAK_PREFIX || '.' || FAKTUR_PAJAK FP,
				A.DEPARTEMEN_ID, A.DEPARTEMEN_KELAS_ID, A.DEPARTEMEN_KELAS, A.PERIODE_PEMBAYARAN
                FROM KPTT_NOTA_SPP A
                LEFT JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
                LEFT JOIN SAFM_BANK C ON A.KD_BANK = C.MBANK_KODE
                LEFT JOIN KBBR_TIPE_TRANS D ON D.TIPE_TRANS = A.TIPE_TRANS
                LEFT JOIN KBBR_BUKU_BESAR F ON F.KD_BUKU_BESAR=A.KD_BB_BANK
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str; exit();
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsBak($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "			    
                SELECT B.MPLG_NPWP, B.MPLG_ALAMAT, B.MPLG_JENIS_USAHA, A.KD_CABANG, A.KD_SUBSIS, JEN_JURNAL, 
                A.TIPE_TRANS, D.TIPE_DESC, A.NO_NOTA, NO_NOTA_JUAL, 
                JNS_JUAL, NO_REF1, NO_REF2, D.AKRONIM_DESC,
                NO_REF3, MPLG_NAMA, KD_KUSTO, BADAN_USAHA, 
                KD_BB_KUSTO, KD_UNITK, JEN_TRANS, 
                TGL_ENTRY, TGL_TRANS, TGL_NOTA_DITERIMA, 
                TGL_JT_TEMPO, TGL_VALUTA, KD_VALUTA, 
                KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
                TANDA_TRANS, KD_BB_PAJAK1, PPN1_PERSEN, 
                KD_BB_PAJAK2, PPN2_PERSEN, METERAI, NVL(METERAI, 9999999) METERAI_PILIH, 
                KD_BB_METERAI, PPN_PEM_PERSEN, BAGIHASIL_PERSEN, 
                JML_VAL_REDUKSI, JML_VAL_BAYAR, SISA_VAL_BAYAR, 
                A.KD_BANK, C.MBANK_NAMA BANK, REK_BANK, A.KD_BB_BANK, F.NM_BUKU_BESAR,
                THN_BUKU ||' / '||BLN_BUKU PERIODE,
                A.KD_BB_BANK ||' / '|| A.REK_BANK REKENING_KAS_BANK,
				KD_BB_BANK REKUTIP, 
                NO_REF3 ||' '||  PREV_NOTA_UPDATE NO_1A,
                KD_BB_BANK||' / '||C.MBANK_NAMA BB_KAS_BANK,
                B.MPLG_KODE||' - '||MPLG_NAMA PELANGGAN,
                NO_WD_UPER, JML_WD_UPPER, KD_BB_UPER, 
                KD_BAYAR, NO_CHEQUE, THN_BUKU, 
                BLN_BUKU, NVL(A.KET_TAMBAHAN2, A.KET_TAMBAHAN) KET_TAMBAHAN, KD_OBYEK, 
                NO_VOYAGE, STATUS_PROSES, NO_POSTING, 
                CETAK_NOTA, LAST_APPROVE_DATE, LAST_APPROVE_BY, 
                PREV_NOTA_UPDATE, REF_NOTA_CICILAN, PERIODE_CICILAN, 
                JML_KALI_CICILAN, CICILAN_KE, JT_TEMPO_CICILAN, 
                ID_KASIR, AUTO_MANUAL, PREV_SISA_BAYAR, 
                STAT_RKP_KARTU, TGL_POSTING, NO_FAKT_PAJAK, 
                JML_VAL_PAJAK, JML_RP_PAJAK, JML_WDANA, 
                BULTAH, CETAK_APBMI, NO_WDANA, 
                FLAG_APBMI, TGL_CETAK, KD_TERMINAL, 
                LOKASI, KD_NOTA, FLAG_EKSPEDISI, 
                NO_EKSPEDISI, TGL_EKSPEDISI, NO_SP, 
                TGL_SP, NO_KN_BANK, TGL_KN_BANK, 
                LAST_UPDATE_DATE, A.LAST_UPDATED_BY, A.PROGRAM_NAME, 
                NO_REG, FLAG_TUNAI, TGL_BATAL, 
                NO_NOTA_BTL, NO_DN, TGL_DN, 
                FLAG_PUPN, JML_TAGIHAN, SISA_TAGIHAN, 
                KD_PANGKALAN, FLAG_SETOR_PAJAK, KD_PELAYANAN, 
                VERIFIED, NO_APPROVAL, TGL_APPROVAL, 
                TGL_POST_BATAL, TGL_VAL_PAJAK, KURS_VAL_PAJAK, JML_VAL_TRANS JUMLAH, FAKTUR_PAJAK, TGL_FAKTUR_PAJAK, FAKTUR_PAJAK_PREFIX, 
				FAKTUR_PAJAK_PREFIX || '.' || FAKTUR_PAJAK FP,
				A.DEPARTEMEN_ID, A.DEPARTEMEN_KELAS_ID, A.DEPARTEMEN_KELAS, A.PERIODE_PEMBAYARAN
                FROM KPTT_NOTA_SPP_BAK A
                LEFT JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
                LEFT JOIN SAFM_BANK C ON A.KD_BANK = C.MBANK_KODE
                LEFT JOIN KBBR_TIPE_TRANS D ON D.TIPE_TRANS = A.TIPE_TRANS
                LEFT JOIN KBBR_BUKU_BESAR F ON F.KD_BUKU_BESAR=A.KD_BB_BANK
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str; exit();
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsReport($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY B.MPLG_NAMA ASC ")
	{
		$str = "			    
                SELECT A.NO_NOTA, A.NO_REF1, A.NO_REF2, A.TGL_TRANS, A.KD_KUSTO, UPPER(B.MPLG_NAMA) MPLG_NAMA, NVL(AA.DEPARTEMEN_KELAS, A.DEPARTEMEN_KELAS) DEPARTEMEN_KELAS, A.JML_VAL_TRANS, AA.TGL_TRANS TANGGAL_TAGIHAN
				FROM KPTT_NOTA_SPP A
				LEFT JOIN KPTT_NOTA AA ON A.NO_REF1 = AA.NO_NOTA
                LEFT JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
                LEFT JOIN SAFM_BANK C ON A.KD_BANK = C.MBANK_KODE
                LEFT JOIN KBBR_TIPE_TRANS D ON D.TIPE_TRANS = A.TIPE_TRANS
                LEFT JOIN KBBR_BUKU_BESAR F ON F.KD_BUKU_BESAR=A.KD_BB_BANK
                WHERE 1 = 1
				"; 
				
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsDepartemen($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY B.DEPARTEMEN_ID ASC ")
	{
		$str = "			    
                SELECT DISTINCT B.DEPARTEMEN_ID, C.NAMA
				FROM KPTT_NOTA_SPP A 
				INNER JOIN KPTT_NOTA B ON A.NO_REF1 = B.NO_NOTA
				INNER JOIN PPI_SIMPEG.DEPARTEMEN C ON B.DEPARTEMEN_ID = C.DEPARTEMEN_ID
                WHERE 1 = 1
				"; 
				
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
	
    function getCountByParamsReport($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
				FROM KPTT_NOTA_SPP A
				INNER JOIN KPTT_NOTA AA ON A.NO_REF1 = AA.NO_NOTA
                LEFT JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
                LEFT JOIN SAFM_BANK C ON A.KD_BANK = C.MBANK_KODE
                LEFT JOIN KBBR_TIPE_TRANS D ON D.TIPE_TRANS = A.TIPE_TRANS
                LEFT JOIN KBBR_BUKU_BESAR F ON F.KD_BUKU_BESAR=A.KD_BB_BANK
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
	
	

    function selectByParamsSimple($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "			    
                SELECT  NO_POSTING, PREV_NOTA_UPDATE, NO_FAKT_PAJAK, TGL_TRANS, NO_NOTA_DINAS, KET_NOTA_DINAS, TO_CHAR(TGL_TRANS, 'DD-MM-YYYY') TGL_TRANS_INA
                FROM KPTT_NOTA_SPP A
                WHERE 1 = 1
				"; 
				
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsRekapPostingUlang($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "			    
               SELECT  SUM(JML_VAL_TRANS) JML_VAL_TRANS FROM KPTT_NOTA_SPP  A
   				INNER JOIN KBBR_BUKU_BESAR B ON A.KD_BB_BANK = B.KD_BUKU_BESAR
                WHERE 1 = 1 
				"; 
				
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
			".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsRekapPosting($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "			    
               SELECT  SUM(JML_VAL_TRANS) JML_VAL_TRANS FROM KPTT_NOTA_SPP  A
   				INNER JOIN KBBR_BUKU_BESAR B ON A.KD_BB_BANK = B.KD_BUKU_BESAR
                WHERE 1 = 1 AND NO_POSTING IS NULL
				"; 
				
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
			".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsRekapPostingBak($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "			    
               SELECT A.NO_REF2, KD_BB_BANK, B.NM_BUKU_BESAR, SUM(JML_VAL_TRANS) JML_VAL_TRANS FROM KPTT_NOTA_SPP  A
   				INNER JOIN KBBR_BUKU_BESAR B ON A.KD_BB_BANK = B.KD_BUKU_BESAR
                WHERE 1 = 1 AND NO_POSTING IS NULL
				"; 
				
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
                GROUP BY A.NO_REF2, KD_BB_BANK, B.NM_BUKU_BESAR
			".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsPembatalanNotaPencarian($pNoRef3, $pKodeKusto, $pKdValuta, $pTglTrans)
	{
		$str = "			    
                 SELECT TO_CHAR(TGL_POSTING,'DDMMYYYY') TGL_POSTING, NVL(JML_VAL_BAYAR, 0) JML_VAL_BAYAR, NVL(STATUS_PROSES, 1) STATUS_PROSES, 
				 PREV_NOTA_UPDATE, NO_NOTA, METERAI, JML_TAGIHAN, GET_KURS_VALAS_IMAIS(TO_CHAR(TO_DATE('".$pTglTrans."', 'DD-MM-YYYY'),'DDMMRR'),'".$pKdValuta."') KURS
				 FROM KPTT_NOTA_SPP A
				 WHERE A.JEN_JURNAL = 'JPJ' AND A.KD_SUBSIS = 'KPT'
                      AND A.NO_REF3 = '".$pNoRef3."'
                      AND A.TIPE_TRANS = NVL(NULL, A.TIPE_TRANS)                    
                      AND A.KD_KUSTO = NVL('".$pKodeKusto."', A.KD_KUSTO)
                      AND A.KD_VALUTA = NVL('".$pKdValuta."', A.KD_VALUTA)
                      AND A.NO_NOTA = NVL(NULL, A.NO_NOTA)
                      AND NVL(CETAK_NOTA,0) > 0   
				"; 
		//, FOTO
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsPembatalanNotaPencarianData($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "			    
                SELECT A.NO_REF3 NO_PPKB,
                        B.MPLG_NAMA PELANGGAN,
                        A.TGL_TRANS TGL_NOTA,
                       A.JML_TAGIHAN TOT_TAGIHAN,
                       A.JML_VAL_BAYAR BAYAR, 
                       A.SISA_TAGIHAN SISA_TAGIHAN,
                       B.MPLG_KODE, B.MPLG_BADAN_USAHA
                FROM KPTT_NOTA_SPP A,
                     SAFM_PELANGGAN B
                WHERE A.KD_KUSTO      = B.MPLG_KODE
                  AND A.JEN_JURNAL       = 'JPJ'
                  AND A.KD_SUBSIS  	  = 'KPT'
				  AND A.STATUS_PROSES = '1'
				  AND NVL(A.CETAK_NOTA,0) > 0
				  AND NVL(A.SISA_VAL_BAYAR,0) > 0 
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsSurcharge($pNoRef3, $pKodeKusto)
	{
		$str = "			    
                 SELECT NO_NOTA, NO_POSTING, NO_REF3
								  	  FROM KPTT_NOTA_SPP
								  	 WHERE NO_REF3 LIKE '".$pNoRef3."' ||'%' 
								  	   AND STATUS_PROSES = 1
								  	   AND JEN_JURNAL = 'JPJ' 
								  	   AND INSTR(NO_REF3,'S') > 0
								  	   AND NO_REF3 <> '".$pNoRef3."'
								  	   AND TIPE_TRANS = 'JPJ-KPT-01'
                                       AND KD_KUSTO = '".$pKodeKusto."'
				"; 
		//, FOTO
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,-1,-1); 
    }
	
								  	
									   
    function selectByParamsPembatalanKompensasiPencarian($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "			    
                 SELECT A.NO_REF3 NO_PPKB, A.NO_NOTA,
						B.MPLG_NAMA PELANGGAN,
						A.TGL_TRANS TGL_NOTA,
						C.SALDO_VAL_KREDIT TOT_TAGIHAN,
						C.SALDO_VAL_KREDIT BAYAR
						FROM  KPTT_NOTA_SPP A,
						SAFM_PELANGGAN B,
						KBBT_JUR_BB_D C
						WHERE A.KD_KUSTO      	= B.MPLG_KODE
						AND A.JEN_JURNAL 	  	= 'JPJ'
						AND A.KD_SUBSIS  	    = 'KPT'
						AND A.STATUS_PROSES     = '1'
						AND A.NO_NOTA			= C.PREV_NO_NOTA
						AND C.TIPE_TRANS        IN ('JKM-KPT-01','JRR-KPT-04')
						AND NVL(A.CETAK_NOTA,0) > 0
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsPembatalanPelunasan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "			    
                 SELECT KD_BAYAR,KD_BANK,REK_BANK,KD_BB_BANK, KD_KUSTO,
					   (SELECT UPPER(NM_BUKU_BESAR) 
									 FROM KBBR_BUKU_BESAR X 
						   WHERE X.KD_BUKU_BESAR = A.KD_BB_BANK) MBANK_NAMA,
					   NO_CHEQUE,KD_VALUTA,
					   JML_VAL_TRANS,BADAN_USAHA,KD_BB_KUSTO,NO_POSTING
				FROM   KPTT_NOTA_SPP A 
				WHERE  1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    

    function selectByParamsPembatalanPelunasanPencarianv2($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY 1")
	{
		$str = "			    
					SELECT  A.NO_NOTA,     
					A.TGL_TRANS, 
					A.THN_BUKU||' / '||A.BLN_BUKU BULAN_BUKU,
					A.KD_VALUTA, 
					A.JML_VAL_TRANS JML_TRANS
					FROM KPTT_NOTA_SPP A 
					WHERE 
					JEN_JURNAL = 'JKM' AND
					STATUS_PROSES = '1' 
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPembatalanPelunasanPencarian($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY 1")
	{
		$str = "			    
					SELECT ALL KPTT_NOTA_SPP.NO_NOTA,     
					SAFR_GENERAL_REF_DETAIL.KET_REF_DATA,
					KPTT_NOTA_SPP.TGL_TRANS, 
					KPTT_NOTA_SPP.THN_BUKU||' / '||KPTT_NOTA_SPP.BLN_BUKU BULAN_BUKU,
					KPTT_NOTA_SPP.KD_VALUTA, 
					KPTT_NOTA_SPP.JML_VAL_TRANS JML_TRANS
					FROM KPTT_NOTA_SPP, SAFR_GENERAL_REF_DETAIL 
					WHERE 
					JEN_JURNAL = 'JKM' AND
					STATUS_PROSES = '1' AND
					SAFR_GENERAL_REF_DETAIL.ID_REF_FILE = 'BADAN USAHA' AND
					SAFR_GENERAL_REF_DETAIL.ID_REF_DATA(+) = KPTT_NOTA_SPP.BADAN_USAHA
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsPelunasanNotaPencarian($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NO_FAKTUR")
	{
		$str = "			    
				SELECT A.NO_FAKT_PAJAK NO_FAKTUR, A.NO_REF3 NO_PPKB, B.MPLG_NAMA PELANGGAN, B.MPLG_KODE KODE, A.KET_TAMBAHAN,
                       DECODE(A.TGL_TRANS, NULL, A.TGL_TRANS, A.TGL_TRANS) TGL_NOTA,
                       NVL(A.JML_TAGIHAN, 0) TOT_TAGIHAN, NVL(A.JML_VAL_BAYAR, 0) BAYAR, 
                       NVL(A.SISA_TAGIHAN, 0) SISA_TAGIHAN, A.NO_NOTA, KD_BB_KUSTO
                FROM KPTT_NOTA_SPP A, SAFM_PELANGGAN B
                WHERE A.KD_KUSTO = B.MPLG_KODE AND A.JEN_JURNAL = 'JPJ' AND 
                      A.KD_SUBSIS = 'KPT' AND A.STATUS_PROSES = '1' AND 
                      NVL(A.CETAK_NOTA,0) > 0 AND NVL(A.SISA_TAGIHAN,0) > 0 AND
                      A.NO_POSTING IS NOT NULL
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsPelunasanPembayaranPencarian($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.TGL_TRANS")
	{
		$str = "			    
				SELECT A.NO_FAKT_PAJAK NO_FAKTUR, A.NO_REF3 NO_PPKB, KET_TAMBAHAN PELANGGAN,
					   DECODE(A.TGL_TRANS, NULL, A.TGL_TRANS, A.TGL_TRANS) TGL_NOTA,
					   NVL(A.JML_TAGIHAN, 0) TOT_TAGIHAN, NVL(A.JML_VAL_BAYAR, 0) BAYAR, 
					   NVL(A.SISA_TAGIHAN, 0) SISA_TAGIHAN, A.NO_NOTA, KD_BB_KUSTO
				FROM KPTT_NOTA_SPP A
				WHERE A.JEN_JURNAL = 'JPJ' AND TIPE_TRANS = 'JPJ-KPT-01' AND
					  A.KD_SUBSIS = 'KPT' AND A.STATUS_PROSES = '1' AND 
					  NVL(A.SISA_TAGIHAN,0) > 0 AND
					  A.NO_POSTING IS NOT NULL
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
	
    function selectByParamsPelunasanPembayaranPencarianV2($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.DEPARTEMEN_KELAS ASC ")
	{
		$str = "			    
				SELECT A.DEPARTEMEN_ID, A.DEPARTEMEN_KELAS_ID, DEPARTEMEN_KELAS, 
        			   SUM(NVL(A.JML_TAGIHAN, 0)) TOT_TAGIHAN, SUM(NVL(A.JML_VAL_BAYAR, 0)) BAYAR, 
                       SUM(NVL(A.SISA_TAGIHAN, 0)) SISA_TAGIHAN
                FROM KPTT_NOTA_SPP A
                WHERE A.JEN_JURNAL = 'JPJ' AND TIPE_TRANS = 'JPJ-KPT-01' AND
                      A.KD_SUBSIS = 'KPT' AND A.STATUS_PROSES = '1' AND 
                      NVL(A.SISA_TAGIHAN,0) > 0 AND
                      A.NO_POSTING IS NOT NULL
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.DEPARTEMEN_ID, A.DEPARTEMEN_KELAS_ID, DEPARTEMEN_KELAS ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsPembatalanPelunasanJRR($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.TGL_TRANS DESC ")
	{
		$str = "			    
				SELECT NO_NOTA, KD_BANK, KD_BB_BANK, TGL_TRANS, TGL_POSTING, KET_TAMBAHAN, JML_VAL_TRANS
                FROM KPTT_NOTA_SPP A
                WHERE A.JEN_JURNAL = 'JKM' AND TIPE_TRANS = 'JKM-KPT-01' AND
                      A.KD_SUBSIS = 'KPT'  AND A.NO_POSTING IS NOT NULL
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsPembatalanTagihanJRR($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.TGL_TRANS DESC ")
	{
		$str = "			    
				SELECT NO_NOTA, KD_BANK, KD_BB_BANK, TGL_TRANS, TGL_POSTING, KET_TAMBAHAN, JML_VAL_TRANS
                FROM KPTT_NOTA_SPP A
                WHERE A.JEN_JURNAL = 'JPJ' AND TIPE_TRANS = 'JPJ-KPT-01' AND
                      A.KD_SUBSIS = 'KPT'   AND A.NO_POSTING IS NOT NULL  AND A.THN_BUKU > 2018
					  AND EXISTS(SELECT 1 FROM KPTT_NOTA_SPP_D X WHERE X.NO_NOTA = A.NO_NOTA AND X.KLAS_TRANS = 'SPP')
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsJPJSiswa($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.TGL_TRANS DESC ")
	{
		$str = "			    
				SELECT A.NO_NOTA, B.KD_SUB_BANTU, A.TGL_TRANS, A.TGL_POSTING, C.MPLG_NAMA, B.JML_VAL_TRANS, B.KD_BUKU_BESAR, B.KLAS_TRANS
                FROM KPTT_NOTA_SPP A
                INNER JOIN KPTT_NOTA_SPP_D B ON A.NO_NOTA = B.NO_NOTA
                INNER JOIN SAFM_PELANGGAN C ON B.KD_SUB_BANTU = C.MPLG_KODE
                WHERE A.JEN_JURNAL = 'JPJ' AND A.TIPE_TRANS = 'JPJ-KPT-01' AND
                      A.KD_SUBSIS = 'KPT'   AND A.NO_POSTING IS NOT NULL  AND A.THN_BUKU > 2018 AND (B.NO_REF_PELUNASAN IS NULL AND
                       NOT EXISTS(SELECT 1 FROM KPTT_NOTA_SPP_D X WHERE JEN_JURNAL = 'JKM' AND X.PREV_NO_NOTA = B.NO_NOTA AND X.KD_SUB_BANTU = B.KD_SUB_BANTU))
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
	
    function selectByParamsSiswaBB($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.DEPARTEMEN_ID, A.DEPARTEMEN_KELAS_ID, A.NAMA ASC ")
	{
		$str = "			    
				SELECT 
					JENIS, DEPARTEMEN_ID, DEPARTEMEN_KELAS_ID, 
					   NIS, NAMA, SEKOLAH, 
					   KELAS, KODE_BB, SEKOLAH || ' ' || KELAS KETERANGAN
					FROM SISWA_INFORMASI_BB_TAGIHAN A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
				
    function selectByParamsPembatalanPelunasanDetil($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY LINE_SEQ")
	{
		$str = "SELECT   A.LINE_SEQ, A.NO_REF3, A.PREV_NO_NOTA, A.KLAS_TRANS, A.JML_VAL_TRANS,
					         B.TGL_TRANS, B.TGL_JT_TEMPO,
					         'KOREKSI ' || A.KET_TAMBAHAN KET_TAMBAHAN, A.KD_BUKU_BESAR,
					         A.KD_SUB_BANTU, A.TAGIHAN JML_TAGIHAN, A.NO_NOTA
					    FROM KPTT_NOTA_SPP_D A INNER JOIN KPTT_NOTA_SPP B ON A.PREV_NO_NOTA = B.NO_NOTA
					   WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	 
    
	function selectByParamsGenerateKode($jenis_jurnal="")
	{
		$str = "
		SELECT Get_Kode('".$jenis_jurnal."', SYSDATE) NO_NOTA FROM DUAL	"; 
		return $this->selectLimit($str,-1,-1); 
    }	
    
	function selectByParamsTes($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT A.NO_NOTA, A.TGL_TRANS, A.JML_VAL_TRANS, A.JML_RP_TRANS, A.NM_AGEN_PERUSH, A.ALMT_AGEN_PERUSH, A.KET_TAMBAH KETERANGAN_UTAMA, 
				A.NO_REF3 BUKTI_PENDUKUNG, LPAD(TO_CHAR(B.NO_SEQ), 3, '0') NOMOR, B.KD_BUKU_BESAR, B.KD_SUB_BANTU, B.KD_BUKU_PUSAT, AMBIL_BUKU_BESAR_NAMA(B.KD_BUKU_BESAR) NM_BUKU_BESAR_WITH_PARENT, C.NM_BUKU_BESAR, E.MPLG_NAMA NM_SUB_BANTU, D.NM_BUKU_BESAR NM_BUKU_PUSAT,
				B.KET_TAMBAH KETERANGAN_DETIL, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, SALDO_RP_DEBET, SALDO_RP_KREDIT, A.KD_VALUTA
				FROM KBBT_JUR_BB A 
				INNER JOIN KBBT_JUR_BB_D B ON A.NO_NOTA = B.NO_NOTA 
				INNER JOIN KBBR_BUKU_BESAR C ON C.KD_BUKU_BESAR = B.KD_BUKU_BESAR
				INNER JOIN KBBR_BUKU_PUSAT D ON D.KD_BUKU_BESAR = B.KD_BUKU_PUSAT
				INNER JOIN SAFM_PELANGGAN E ON E.MPLG_KODE = B.KD_SUB_BANTU  WHERE A.NO_NOTA IN ('001324/JKK/2013')
				ORDER BY A.NO_NOTA, B.NO_SEQ
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsPeriode($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT DISTINCT TO_CHAR(TGL_TRANS, 'MMYYYY') PERIODE 
				FROM KPTT_NOTA_SPP
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TO_DATE(TO_CHAR(TGL_TRANS, 'MMYYYY'), 'MMYYYY') DESC ";
		return $this->selectLimit($str,$limit,$from); 
    }


	function selectByParamsPeriodeBak($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT BLN_BUKU || THN_BUKU PERIODE 
				FROM KPTT_NOTA_SPP
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." GROUP BY BLN_BUKU, THN_BUKU ORDER BY THN_BUKU DESC,  BLN_BUKU DESC ";
		return $this->selectLimit($str,$limit,$from); 
    }
		
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_SUBSIS, JEN_JURNAL, 
				TIPE_TRANS, NO_NOTA, NO_NOTA_JUAL, 
				JNS_JUAL, NO_REF1, NO_REF2, 
				NO_REF3, KD_KUSTO, BADAN_USAHA, 
				KD_BB_KUSTO, KD_UNITK, JEN_TRANS, 
				TGL_ENTRY, TGL_TRANS, TGL_NOTA_DITERIMA, 
				TGL_JT_TEMPO, TGL_VALUTA, KD_VALUTA, 
				KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
				TANDA_TRANS, KD_BB_PAJAK1, PPN1_PERSEN, 
				KD_BB_PAJAK2, PPN2_PERSEN, METERAI, 
				KD_BB_METERAI, PPN_PEM_PERSEN, BAGIHASIL_PERSEN, 
				JML_VAL_REDUKSI, JML_VAL_BAYAR, SISA_VAL_BAYAR, 
				KD_BANK, REK_BANK, KD_BB_BANK, 
				NO_WD_UPER, JML_WD_UPPER, KD_BB_UPER, 
				KD_BAYAR, NO_CHEQUE, THN_BUKU, 
				BLN_BUKU, KET_TAMBAHAN, KD_OBYEK, 
				NO_VOYAGE, STATUS_PROSES, NO_POSTING, 
				CETAK_NOTA, LAST_APPROVE_DATE, LAST_APPROVE_BY, 
				PREV_NOTA_UPDATE, REF_NOTA_CICILAN, PERIODE_CICILAN, 
				JML_KALI_CICILAN, CICILAN_KE, JT_TEMPO_CICILAN, 
				ID_KASIR, AUTO_MANUAL, PREV_SISA_BAYAR, 
				STAT_RKP_KARTU, TGL_POSTING, NO_FAKT_PAJAK, 
				JML_VAL_PAJAK, JML_RP_PAJAK, JML_WDANA, 
				BULTAH, CETAK_APBMI, NO_WDANA, 
				FLAG_APBMI, TGL_CETAK, KD_TERMINAL, 
				LOKASI, KD_NOTA, FLAG_EKSPEDISI, 
				NO_EKSPEDISI, TGL_EKSPEDISI, NO_SP, 
				TGL_SP, NO_KN_BANK, TGL_KN_BANK, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
				NO_REG, FLAG_TUNAI, TGL_BATAL, 
				NO_NOTA_BTL, NO_DN, TGL_DN, 
				FLAG_PUPN, JML_TAGIHAN, SISA_TAGIHAN, 
				KD_PANGKALAN, FLAG_SETOR_PAJAK, KD_PELAYANAN, 
				VERIFIED, NO_APPROVAL, TGL_APPROVAL, 
				TGL_POST_BATAL, TGL_VAL_PAJAK, KURS_VAL_PAJAK
				FROM KPTT_NOTA_SPP
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NO_JUDUL ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
	function selectByParamsMaintenanceSPP($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				PERIODE, DEPARTEMEN_ID, DEPARTEMEN_KELAS_ID, 
				   DEPARTEMEN_KELAS, NO_NOTA, KD_SUB_BANTU, 
				   NM_SUB_BANTU, KD_BUKU_BESAR, TGL_TRANS, 
				   TAGIHAN, SISA, NO_REF_PELUNASAN
				FROM MAINTENANCE_SPP A
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		//echo $str;  exit;
		$this->query = $str;
		$str .= $statement." ORDER BY PERIODE ASC ";
		return $this->selectLimit($str,$limit,$from); 
    }
		
	function selectByParamsMaintenanceNonSPP($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				PERIODE, DEPARTEMEN_ID, DEPARTEMEN_KELAS_ID, 
				   DEPARTEMEN_KELAS, NO_NOTA, KD_SUB_BANTU, 
				   NM_SUB_BANTU, KD_BUKU_BESAR, TGL_TRANS, 
				   TAGIHAN, SISA, NO_REF_PELUNASAN
				FROM MAINTENANCE_NONSPP A
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PERIODE ASC ";
		return $this->selectLimit($str,$limit,$from); 
    }
		
	
    function getCountByParamsMaintenanceSPP($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		        FROM MAINTENANCE_SPP_COUNT A
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
	
	
	
    function getCountByParamsMaintenanceNonSPP($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		        FROM MAINTENANCE_NONSPP A
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
	
	
	
    function getNoPosting($no_nota)
	{
		$str = "SELECT NO_POSTING 
		        FROM KPTT_NOTA_SPP A
                WHERE NO_NOTA = '".$no_nota."' "; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("NO_POSTING"); 
		else 
			return ""; 
    }

    function getKode($no_bukti, $tanggal_trans)
	{
		$str = "SELECT GET_KODE_FOR_IMAIS('".$no_bukti."', ".$tanggal_trans.") KODE 
		        FROM DUAL "; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("KODE"); 
		else 
			return ""; 
    }

    function getInvoiceNo($bulan, $tahun)
	{
		$str = "SELECT GENERATE_INVOICE_IMAIS('".$bulan."', ".$tahun.") KODE 
		        FROM DUAL "; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("KODE"); 
		else 
			return ""; 
    }

    function getCountByParamsPembatalanPelunasanJRR($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) ROWCOUNT
				FROM KPTT_NOTA_SPP A
                WHERE A.JEN_JURNAL = 'JKM' AND TIPE_TRANS = 'JKM-KPT-01' AND
                      A.KD_SUBSIS = 'KPT'   AND A.NO_POSTING IS NOT NULL  ".$statement; 
		
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
	
	
    function getCountByParamsPembatalanTagihanJRR($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) ROWCOUNT
				FROM KPTT_NOTA_SPP A
                WHERE A.JEN_JURNAL = 'JPJ' AND TIPE_TRANS = 'JPJ-KPT-01' AND
                      A.KD_SUBSIS = 'KPT'   AND A.NO_POSTING IS NOT NULL   AND A.THN_BUKU > 2018
					  AND EXISTS(SELECT 1 FROM KPTT_NOTA_SPP_D X WHERE X.NO_NOTA = A.NO_NOTA AND X.KLAS_TRANS = 'SPP') ".$statement; 
		
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
	
    function getCountByParamsPelunasanNotaPencarian($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.NO_REF3) ROWCOUNT
				FROM KPTT_NOTA_SPP A, SAFM_PELANGGAN B
				WHERE A.KD_KUSTO = B.MPLG_KODE AND A.JEN_JURNAL = 'JPJ' AND 
					  A.KD_SUBSIS = 'KPT' AND A.STATUS_PROSES = '1' AND 
					  NVL(A.CETAK_NOTA,0) > 0 AND NVL(A.SISA_TAGIHAN,0) > 0  ".$statement; 
		
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

    function getCountByParamsPelunasanPembayaranPencarian($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.NO_REF3) ROWCOUNT
				FROM KPTT_NOTA_SPP A
				WHERE A.JEN_JURNAL = 'JPJ' AND 
					  A.KD_SUBSIS = 'KPT' AND A.STATUS_PROSES = '1' AND  TIPE_TRANS = 'JPJ-KPT-01' AND
					  NVL(A.CETAK_NOTA,0) > 0 AND NVL(A.SISA_TAGIHAN,0) > 0  ".$statement; 
		
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
	
	

    function getCountByParamsPelunasanPembayaranPencarianV2($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) ROWCOUNT
				FROM
				(
				SELECT A.DEPARTEMEN_ID, A.DEPARTEMEN_KELAS_ID, DEPARTEMEN_KELAS, 
        			   SUM(NVL(A.JML_TAGIHAN, 0)) TOT_TAGIHAN, SUM(NVL(A.JML_VAL_BAYAR, 0)) BAYAR, 
                       SUM(NVL(A.SISA_TAGIHAN, 0)) SISA_TAGIHAN
                FROM KPTT_NOTA_SPP A
                WHERE A.JEN_JURNAL = 'JPJ' AND TIPE_TRANS = 'JPJ-KPT-01' AND
                      A.KD_SUBSIS = 'KPT' AND A.STATUS_PROSES = '1' AND 
                      NVL(A.SISA_TAGIHAN,0) > 0 AND
                      A.NO_POSTING IS NOT NULL  ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= "  GROUP BY A.DEPARTEMEN_ID, A.DEPARTEMEN_KELAS_ID, DEPARTEMEN_KELAS ) A WHERE 1 = 1 ";
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
		
    function getCountByParamsPembatalanNotaPencarianData($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) ROWCOUNT
                FROM KPTT_NOTA_SPP A,
                     SAFM_PELANGGAN B
                WHERE A.KD_KUSTO      = B.MPLG_KODE
                  AND A.JEN_JURNAL       = 'JPJ'
                  AND A.KD_SUBSIS  	  = 'KPT'
				  AND A.STATUS_PROSES = '1'
				  AND NVL(A.CETAK_NOTA,0) > 0
				  AND NVL(A.SISA_VAL_BAYAR,0) > 0 ".$statement; 
		
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


    function getCountByParamsPembatalanPelunasanPencarianv2($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) ROWCOUNT
				FROM KPTT_NOTA_SPP A
				WHERE 
				JEN_JURNAL = 'JKM' AND
				STATUS_PROSES = '1' ".$statement; 
		
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
		

    function getCountByParamsPembatalanPelunasanPencarian($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) ROWCOUNT
				FROM KPTT_NOTA_SPP, SAFR_GENERAL_REF_DETAIL 
				WHERE 
				JEN_JURNAL = 'JKM' AND
				STATUS_PROSES = '1' AND
				SAFR_GENERAL_REF_DETAIL.ID_REF_FILE = 'BADAN USAHA' AND
				SAFR_GENERAL_REF_DETAIL.ID_REF_DATA(+) = KPTT_NOTA_SPP.BADAN_USAHA ".$statement; 
		
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
						
    function getCountByParamsBak($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		        FROM KPTT_NOTA_SPP_BAK A
                LEFT JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
				LEFT JOIN SAFM_BANK C ON A.KD_BANK = C.MBANK_KODE
				LEFT JOIN KBBR_TIPE_TRANS D ON D.TIPE_TRANS = A.TIPE_TRANS
				LEFT JOIN (SELECT NO_NOTA, SUM(HARGA_SATUAN) JUMLAH FROM KPTT_NOTA_SPP_D_BAK X GROUP BY NO_NOTA) E ON A.NO_NOTA = E.NO_NOTA
				LEFT JOIN KBBR_BUKU_BESAR F ON F.KD_BUKU_BESAR=A.KD_BB_BANK
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
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		        FROM KPTT_NOTA_SPP A
                LEFT JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
				LEFT JOIN SAFM_BANK C ON A.KD_BANK = C.MBANK_KODE
				LEFT JOIN KBBR_TIPE_TRANS D ON D.TIPE_TRANS = A.TIPE_TRANS
				LEFT JOIN (SELECT NO_NOTA, SUM(HARGA_SATUAN) JUMLAH FROM KPTT_NOTA_SPP_D X GROUP BY NO_NOTA) E ON A.NO_NOTA = E.NO_NOTA
				LEFT JOIN KBBR_BUKU_BESAR F ON F.KD_BUKU_BESAR=A.KD_BB_BANK
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
			
    function getCountByParamsSiswaBB($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		        FROM SISWA_INFORMASI_BB_TAGIHAN A
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
	
    function getCountByParamsJPJSiswa($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		        FROM KPTT_NOTA_SPP A
                INNER JOIN KPTT_NOTA_SPP_D B ON A.NO_NOTA = B.NO_NOTA
                INNER JOIN SAFM_PELANGGAN C ON B.KD_SUB_BANTU = C.MPLG_KODE
                WHERE A.JEN_JURNAL = 'JPJ' AND A.TIPE_TRANS = 'JPJ-KPT-01' AND
                      A.KD_SUBSIS = 'KPT'   AND A.NO_POSTING IS NOT NULL  AND A.THN_BUKU > 2018 AND (B.NO_REF_PELUNASAN IS NULL AND
                       NOT EXISTS(SELECT 1 FROM KPTT_NOTA_SPP_D X WHERE JEN_JURNAL = 'JKM' AND X.PREV_NO_NOTA = B.NO_NOTA AND X.KD_SUB_BANTU = B.KD_SUB_BANTU))
				 ".$statement; 
		
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
	

    function getSaldoUangTitipan($pBulan, $pTahun, $pKodeKusto)
	{
		$str = "
                        SELECT DECODE('".$pBulan."',
					   '01',SUM(AWAL_DEBET+P01_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT),
					   '02',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT),
					   '03',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET+P03_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT+P03_KREDIT),
					   '04',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET+P03_DEBET+P04_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT+P03_KREDIT+P04_KREDIT),
					   '05',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET+P03_DEBET+P04_DEBET+P05_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT+P03_KREDIT+P04_KREDIT+P05_KREDIT),
					   '06',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET+P03_DEBET+P04_DEBET+P05_DEBET+P06_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT+P03_KREDIT+P04_KREDIT+P05_KREDIT+P06_KREDIT),
					   '07',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET+P03_DEBET+P04_DEBET+P05_DEBET+P06_DEBET+P07_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT+P03_KREDIT+P04_KREDIT+P05_KREDIT+P06_KREDIT+P07_KREDIT),
					   '08',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET+P03_DEBET+P04_DEBET+P05_DEBET+P06_DEBET+P07_DEBET+P08_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT+P03_KREDIT+P04_KREDIT+P05_KREDIT+P06_KREDIT+P07_KREDIT+P08_KREDIT),
					   '09',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET+P03_DEBET+P04_DEBET+P05_DEBET+P06_DEBET+P07_DEBET+P08_DEBET+P09_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT+P03_KREDIT+P04_KREDIT+P05_KREDIT+P06_KREDIT+P07_KREDIT+P08_KREDIT+P09_KREDIT),
					   '10',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET+P03_DEBET+P04_DEBET+P05_DEBET+P06_DEBET+P07_DEBET+P08_DEBET+P09_DEBET+P10_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT+P03_KREDIT+P04_KREDIT+P05_KREDIT+P06_KREDIT+P07_KREDIT+P08_KREDIT+P09_KREDIT+P10_KREDIT),
					   '11',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET+P03_DEBET+P04_DEBET+P05_DEBET+P06_DEBET+P07_DEBET+P08_DEBET+P09_DEBET+P10_DEBET+P11_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT+P03_KREDIT+P04_KREDIT+P05_KREDIT+P06_KREDIT+P07_KREDIT+P08_KREDIT+P09_KREDIT+P10_KREDIT+P11_KREDIT),
					   '12',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET+P03_DEBET+P04_DEBET+P05_DEBET+P06_DEBET+P07_DEBET+P08_DEBET+P09_DEBET+P10_DEBET+P11_DEBET+P12_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT+P03_KREDIT+P04_KREDIT+P05_KREDIT+P06_KREDIT+P07_KREDIT+P08_KREDIT+P09_KREDIT+P10_KREDIT+P11_KREDIT+P12_KREDIT),
					   '13',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET+P03_DEBET+P04_DEBET+P05_DEBET+P06_DEBET+P07_DEBET+P08_DEBET+P09_DEBET+P10_DEBET+P11_DEBET+P12_DEBET+P13_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT+P03_KREDIT+P04_KREDIT+P05_KREDIT+P06_KREDIT+P07_KREDIT+P08_KREDIT+P09_KREDIT+P10_KREDIT+P11_KREDIT+P12_KREDIT+P13_KREDIT),
					   '14',SUM(AWAL_DEBET+P01_DEBET+P02_DEBET+P03_DEBET+P04_DEBET+P05_DEBET+P06_DEBET+P07_DEBET+P08_DEBET+P09_DEBET+P10_DEBET+P11_DEBET+P12_DEBET+P13_DEBET+P14_DEBET)-SUM(AWAL_KREDIT+P01_KREDIT+P02_KREDIT+P03_KREDIT+P04_KREDIT+P05_KREDIT+P06_KREDIT+P07_KREDIT+P08_KREDIT+P09_KREDIT+P10_KREDIT+P11_KREDIT+P12_KREDIT+P13_KREDIT+P14_KREDIT))
                        SALDO
                        FROM   KBBT_NERACA_SALDO
                        WHERE  KD_BUKU_BESAR LIKE '404%'
                        AND    THN_BUKU     = ".$pTahun."
                        AND    KD_SUB_BANTU = ".$pKodeKusto." 
		 "; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KPTT_NOTA_SPP_ID) AS ROWCOUNT FROM KPTT_NOTA_SPP
		        WHERE KPTT_NOTA_SPP_ID IS NOT NULL ".$statement; 
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