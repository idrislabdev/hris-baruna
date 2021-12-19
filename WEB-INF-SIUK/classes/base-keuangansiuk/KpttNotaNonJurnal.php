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

  class KpttNotaNonJurnal extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KpttNotaNonJurnal()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("TIPE_TRANS", $this->getNextId("TIPE_TRANS","KPTT_NOTA")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KPTT_NOTA_NON_JURNAL (
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
					   TGL_POST_BATAL, TGL_VAL_PAJAK, KURS_VAL_PAJAK, FAKTUR_PAJAK, TGL_FAKTUR_PAJAK, FAKTUR_PAJAK_PREFIX, KET_TAMBAHAN2) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_SUBSIS")."', '".$this->getField("JEN_JURNAL")."',
						'".$this->getField("TIPE_TRANS")."', '".$this->getField("NO_NOTA")."', '".$this->getField("NO_NOTA_JUAL")."',
						'".$this->getField("JNS_JUAL")."', '".$this->getField("NO_REF1")."', '".$this->getField("NO_REF2")."',
						'".$this->getField("NO_REF3")."', '".$this->getField("KD_KUSTO")."', '".$this->getField("BADAN_USAHA")."',
						".$this->getField("KD_BB_KUSTO").", '".$this->getField("KD_UNITK")."', '".$this->getField("JEN_TRANS")."',
					    ".$this->getField("TGL_ENTRY").", ".$this->getField("TGL_TRANS").", ".$this->getField("TGL_NOTA_DITERIMA").",
						".$this->getField("TGL_JT_TEMPO").", ".$this->getField("TGL_VALUTA").", '".$this->getField("KD_VALUTA")."',
						'".$this->getField("KURS_VALUTA")."', '".$this->getField("JML_VAL_TRANS")."', '".$this->getField("JML_RP_TRANS")."',
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
						'".$this->getField("KET_TAMBAHAN2")."'
				  )"; 
		$this->id = $this->getField("NO_NOTA");
		$this->query = $str;
		
		
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KPTT_NOTA_NON_JURNAL
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

	function updatePembatalanSudahCetakNota()
	{
        $str = "UPDATE KPTT_NOTA_NON_JURNAL SET
				STATUS_PROSES = 2,
				TGL_BATAL = ".$this->getField("TGL_BATAL").",
    			PREV_NOTA_UPDATE = '".$this->getField("PREV_NOTA_UPDATE")."'
                WHERE 
                NO_NOTA = '".$this->getField("NO_NOTA")."' "; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }

	function updatePembatalanPelunasan()
	{
        $str = "UPDATE KPTT_NOTA_NON_JURNAL SET
				STATUS_PROSES = 2 WHERE
                NO_NOTA = '".$this->getField("NO_NOTA")."' "; 
				  
		$this->query = $str;
		//echo $str;
		
        return $this->execQuery($str);
    }

	function updatePembatalanPelunasanDelete()
	{
        $str = "UPDATE KPTT_NOTA_NON_JURNAL SET
				STATUS_PROSES = 1 WHERE
                NO_NOTA = '".$this->getField("NO_NOTA")."' "; 
				  
		$this->query = $str;
		//echo $str;
		
        return $this->execQuery($str);
    }
			
	function updatePrevNotaSisaTagihan()
	{
        $str = "UPDATE KPTT_NOTA_NON_JURNAL SET
				PREV_NOTA_UPDATE  = '".$this->getField("PREV_NOTA_UPDATE")."'
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."' AND NOT NVL(SISA_TAGIHAN,0) = 0 "; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }

	function updatePrevNota()
	{
        $str = "UPDATE KPTT_NOTA_NON_JURNAL SET
				PREV_NOTA_UPDATE  = '".$this->getField("PREV_NOTA_UPDATE")."'
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."'"; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }
	
	function updateNotaDinas()
	{
        $str = "UPDATE KPTT_NOTA_NON_JURNAL SET
				NO_NOTA_DINAS  = '".$this->getField("NO_NOTA_DINAS")."',
				KET_NOTA_DINAS = '".$this->getField("KET_NOTA_DINAS")."'
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "DELETE FROM KPTT_NOTA_NON_JURNAL
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
                A.TIPE_TRANS, D.TIPE_DESC, A.NO_NOTA, NO_NOTA_JUAL, CASE WHEN A.NO_REF2 IS NOT NULL AND A.KET_TAMBAHAN2 = 'SUDAH_BAYAR' THEN 'SUDAH' ELSE 'BELUM' END STATUS_BAYAR,
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
                A.KD_BANK ||' / '|| C.MBANK_NAMA ||' / '|| KD_BB_BANK REKENING_KAS_BANK,
                NO_REF3 ||' '||  PREV_NOTA_UPDATE NO_1A,
                KD_BB_BANK||' / '||C.MBANK_NAMA BB_KAS_BANK,
                B.MPLG_KODE||' - '||MPLG_NAMA PELANGGAN,
                NO_WD_UPER, JML_WD_UPPER, KD_BB_UPER, 
                KD_BAYAR, NO_CHEQUE, THN_BUKU, 
                BLN_BUKU, /*NVL(A.KET_TAMBAHAN2, A.KET_TAMBAHAN)*/ A.KET_TAMBAHAN, KD_OBYEK, 
                NO_VOYAGE, STATUS_PROSES, NO_POSTING, 
                CETAK_NOTA, LAST_APPROVE_DATE, LAST_APPROVE_BY, 
                PREV_NOTA_UPDATE, REF_NOTA_CICILAN, PERIODE_CICILAN, 
                JML_KALI_CICILAN, CICILAN_KE, JT_TEMPO_CICILAN, 
                ID_KASIR, A.AUTO_MANUAL, PREV_SISA_BAYAR, 
                STAT_RKP_KARTU, TGL_POSTING, NO_FAKT_PAJAK, 
                JML_VAL_PAJAK, JML_RP_PAJAK, JML_WDANA, 
                BULTAH, CETAK_APBMI, NO_WDANA, 
                FLAG_APBMI, TGL_CETAK, KD_TERMINAL, 
                LOKASI, KD_NOTA, FLAG_EKSPEDISI, 
                NO_EKSPEDISI, TGL_EKSPEDISI, NO_SP, 
                TGL_SP, NO_KN_BANK, TGL_KN_BANK, 
                A.LAST_UPDATE_DATE, A.LAST_UPDATED_BY, A.PROGRAM_NAME, 
                NO_REG, FLAG_TUNAI, TGL_BATAL, 
                NO_NOTA_BTL, NO_DN, TGL_DN, 
                FLAG_PUPN, JML_TAGIHAN, SISA_TAGIHAN, 
                KD_PANGKALAN, FLAG_SETOR_PAJAK, KD_PELAYANAN, 
                VERIFIED, NO_APPROVAL, TGL_APPROVAL, 
                TGL_POST_BATAL, TGL_VAL_PAJAK, KURS_VAL_PAJAK, JML_VAL_TRANS JUMLAH, FAKTUR_PAJAK, TGL_FAKTUR_PAJAK, FAKTUR_PAJAK_PREFIX, FAKTUR_PAJAK_PREFIX || '.' || FAKTUR_PAJAK FP 
                FROM KPTT_NOTA_NON_JURNAL A
                INNER JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
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

    function selectByParamsSimple($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "			    
                SELECT  NO_POSTING, PREV_NOTA_UPDATE, NO_FAKT_PAJAK, TGL_TRANS, NO_NOTA_DINAS, KET_NOTA_DINAS
                FROM KPTT_NOTA_NON_JURNAL A
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
    
	function selectByParamsPeriode($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT BLN_BUKU || THN_BUKU PERIODE 
				FROM KPTT_NOTA_NON_JURNAL
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
				FROM KPTT_NOTA_NON_JURNAL
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
    function getNoPosting($no_nota)
	{
		$str = "SELECT NO_POSTING 
		        FROM KPTT_NOTA_NON_JURNAL A
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

    function getCountByParamsPelunasanNotaPencarian($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.NO_REF3) ROWCOUNT
				FROM KPTT_NOTA_NON_JURNAL A, SAFM_PELANGGAN B
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
		
    function getCountByParamsPembatalanNotaPencarianData($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.NO_REF3) ROWCOUNT
                FROM KPTT_NOTA_NON_JURNAL A,
                     SAFM_PELANGGAN B
                WHERE A.KD_KUSTO      = B.MPLG_KODE
                  AND A.JEN_JURNAL       = 'JPJ'
                  AND A.KD_SUBSIS  	  = 'KPT'
				  AND A.STATUS_PROSES = '1'
				  AND SUBSTR(A.TIPE_TRANS,9,10) = SUBSTR('JRR-KPT-01',9,10) 
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

    function getCountByParamsPembatalanPelunasanPencarian($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) ROWCOUNT
				FROM KPTT_NOTA_NON_JURNAL, SAFR_GENERAL_REF_DETAIL 
				WHERE 
				JEN_JURNAL = 'JKM' AND
				STATUS_PROSES = '1' AND
				SAFR_GENERAL_REF_DETAIL.ID_REF_FILE = 'BADAN USAHA' AND
				SAFR_GENERAL_REF_DETAIL.ID_REF_DATA(+) = KPTT_NOTA_NON_JURNAL.BADAN_USAHA ".$statement; 
		
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
		$str = "SELECT COUNT(KD_KUSTO) AS ROWCOUNT 
		        FROM KPTT_NOTA_NON_JURNAL A
                INNER JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
				LEFT JOIN SAFM_BANK C ON A.KD_BANK = C.MBANK_KODE
				LEFT JOIN KBBR_TIPE_TRANS D ON D.TIPE_TRANS = A.TIPE_TRANS
				LEFT JOIN (SELECT NO_NOTA, SUM(HARGA_SATUAN) JUMLAH FROM KPTT_NOTA_NON_JURNAL_D X GROUP BY NO_NOTA) E ON A.NO_NOTA = E.NO_NOTA
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

  } 
?>