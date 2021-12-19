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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_JUR_BB.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbtJurBb extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtJurBb()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_JUR_BB (
					   KD_CABANG, KD_SUBSIS, TIPE_TRANS, 
					   NO_NOTA, JEN_JURNAL, NO_REF1, 
					   NO_REF2, NO_REF3, NO_REF4, JEN_TRANS, 
					   KD_SUB_BANTU, KD_UNITK, KD_KUSTO, 
					   KD_KLIENT, KD_ASSET, KD_STOCK, 
					   THN_BUKU, BLN_BUKU, TGL_ENTRY, 
					   TGL_TRANS, KD_VALUTA, TGL_VALUTA, 
					   KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
					   KD_BAYAR, KD_BANK, NOREK_BANK, 
					   NO_CEK_NOTA, NO_POSTING, KET_TAMBAH, 
					   USER_DATA, ID_KASIR, APPROVER, 
					   TANDA_TRANS, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
					   PROGRAM_NAME, KD_BUKU_PUSAT, NM_AGEN_PERUSH, 
					   ALMT_AGEN_PERUSH, URAIAN, TGL_POSTING, 
					   JML_CETAK, KD_KAS, KD_TERMINAL, 
					   NO_SP, TGL_SP, NO_KN_BANK, 
					   TGL_KN_BANK, NO_DN, TGL_DN, 
					   NO_REG_KASIR, FLAG_SETOR_PAJAK, STATUS_PROSES, 
					   VERIFIED, NO_URUT_UPER, NO_FAKT_PAJAK, NO_REF_NOTA,NM_AGEN_PERUSH2, 
					   ALMT_AGEN_PERUSH2) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_SUBSIS")."', '".$this->getField("TIPE_TRANS")."',
						'".$this->getField("NO_NOTA")."', '".$this->getField("JEN_JURNAL")."', '".$this->getField("NO_REF1")."',
						'".$this->getField("NO_REF2")."', '".$this->getField("NO_REF3")."', '".$this->getField("NO_REF4")."', '".$this->getField("JEN_TRANS")."',
						'".$this->getField("KD_SUB_BANTU")."', '".$this->getField("KD_UNITK")."', '".$this->getField("KD_KUSTO")."',
						'".$this->getField("KD_KLIENT")."', '".$this->getField("KD_ASSET")."', '".$this->getField("KD_STOCK")."',
						'".$this->getField("THN_BUKU")."', '".$this->getField("BLN_BUKU")."', ".$this->getField("TGL_ENTRY").",
						".$this->getField("TGL_TRANS").", '".$this->getField("KD_VALUTA")."', ".$this->getField("TGL_VALUTA").",
						'".$this->getField("KURS_VALUTA")."', '".$this->getField("JML_VAL_TRANS")."', '".$this->getField("JML_RP_TRANS")."',
						'".$this->getField("KD_BAYAR")."', '".$this->getField("KD_BANK")."', '".$this->getField("NOREK_BANK")."',
						'".$this->getField("NO_CEK_NOTA")."', '".$this->getField("NO_POSTING")."', '".$this->getField("KET_TAMBAH")."',
						'".$this->getField("USER_DATA")."', '".$this->getField("ID_KASIR")."', '".$this->getField("APPROVER")."',
						'".$this->getField("TANDA_TRANS")."', ".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."',
						'".$this->getField("PROGRAM_NAME")."', '".$this->getField("KD_BUKU_PUSAT")."', '".$this->getField("NM_AGEN_PERUSH")."',
						'".$this->getField("ALMT_AGEN_PERUSH")."', '".$this->getField("URAIAN")."', ".$this->getField("TGL_POSTING").",
						'".$this->getField("JML_CETAK")."', '".$this->getField("KD_KAS")."', '".$this->getField("KD_TERMINAL")."',
						'".$this->getField("NO_SP")."', ".$this->getField("TGL_SP").", '".$this->getField("NO_KN_BANK")."',
						".$this->getField("TGL_KN_BANK").", '".$this->getField("NO_DN")."', ".$this->getField("TGL_DN").",
						'".$this->getField("NO_REG_KASIR")."', '".$this->getField("FLAG_SETOR_PAJAK")."', '".$this->getField("STATUS_PROSES")."',
						'".$this->getField("VERIFIED")."', '".$this->getField("NO_URUT_UPER")."', '".$this->getField("NO_FAKT_PAJAK")."', 
						'".$this->getField("NO_REF_NOTA")."', '".$this->getField("NM_AGEN_PERUSH2")."', 
						'".$this->getField("ALMT_AGEN_PERUSH2")."'
				)";
		$this->query = $str;
	
		return $this->execQuery($str);
    }

	
	function insertLogHapus()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO HAPUS_JURNAL (
				   NO_NOTA, CREATED_BY, CREATED_DATE) 
				VALUES ('".$this->getField("NO_NOTA")."', '".$this->getField("CREATED_BY")."', SYSDATE)
						";
		$this->query = $str;
	
		return $this->execQuery($str);
    }

	
    function updateRegisterKasir()
	{
		$str = "
				UPDATE KBBT_JUR_BB
				SET    
					NO_REG_KASIR 			    = '".$this->getField("NO_REG_KASIR")."',
					TGL_POSTING 			    = ".$this->getField("TGL_POSTING").",
					BLN_BUKU					= TO_CHAR(SYSDATE,'MM'),
					THN_BUKU					= TO_CHAR(SYSDATE,'RRRR'),
					APPROVER					= 'KASIR',
					LAST_UPDATE_DATE			= SYSDATE,
					LAST_UPDATED_BY				= 'KASIR',
					PROGRAM_NAME				= 'KPT_KASIR_REG_IMAIS',
					TGL_TRANS					= ".$this->getField("TGL_TRANS").",					
					NM_AGEN_PERUSH				= '".$this->getField("NM_AGEN_PERUSH")."',
					ALMT_AGEN_PERUSH			= '".$this->getField("ALMT_AGEN_PERUSH")."',
					KD_VALUTA					= '".$this->getField("KD_VALUTA")."',
					KET_TAMBAH					= '".$this->getField("KET_TAMBAH")."'
				WHERE NO_NOTA	= '".$this->getField("NO_NOTA")."'
			";
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updatePosting()
	{
		$str = "
				UPDATE KBBT_JUR_BB
				SET    
					TGL_POSTING 			    = ".$this->getField("TGL_POSTING").",
					BLN_BUKU 			    	= '".$this->getField("BLN_BUKU")."',
					THN_BUKU 			    	= '".$this->getField("THN_BUKU")."'
				WHERE NO_NOTA	= '".$this->getField("NO_NOTA")."'
			";
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updatePostingKoreksiAudit()
	{
		$str = "
				UPDATE KBBT_JUR_BB
				SET    
					TGL_POSTING  = ".$this->getField("TGL_POSTING")."
				WHERE NO_NOTA	= '".$this->getField("NO_NOTA")."'
			";
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateAfterPostingKoreksiAudit()
	{
		$str = "
				UPDATE KBBT_JUR_BB
				SET    
					NO_REG_KASIR 			    = '".$this->getField("NO_REG_KASIR")."',
					TGL_POSTING 			    = ".$this->getField("TGL_POSTING").",
					NO_POSTING					= '".$this->getField("NO_POSTING")."',
					APPROVER					= 'KASIR',
					LAST_UPDATE_DATE			= SYSDATE,
					LAST_UPDATED_BY				= 'KASIR',
					PROGRAM_NAME				= '".$this->getField("PROGRAM_NAME")."'
				WHERE NO_NOTA	= '".$this->getField("NO_NOTA")."'
			";
		$this->query = $str;
		return $this->execQuery($str);
    }
						
    function updatePostingAjpAjt()
	{
		$str = "
				UPDATE KBBT_JUR_BB
				SET    
					TGL_POSTING 			    = ".$this->getField("TGL_POSTING")."
				WHERE NO_NOTA	= '".$this->getField("NO_NOTA")."'
			";
		$this->query = $str;
	
		return $this->execQuery($str);
    }

    function updateAfterPostingAjpAjt()
	{
		$str = "
				UPDATE KBBT_JUR_BB
				SET    
					APPROVER 			    = 'KASIR',
					LAST_UPDATE_DATE		= SYSDATE,
					LAST_UPDATED_BY			= 'KASIR',
					NO_REG_KASIR			= '".$this->getField("NO_REG_KASIR")."',
					PROGRAM_NAME			= '".$this->getField("PROGRAM_NAME")."'
				WHERE NO_NOTA	= '".$this->getField("NO_NOTA")."'
			";
		$this->query = $str;
		return $this->execQuery($str);
    }
		
    function updateAfterPosting()
	{
		$str = "
				UPDATE KBBT_JUR_BB
				SET    
					APPROVER 			    = 'KASIR',
					LAST_UPDATE_DATE		= SYSDATE,
					LAST_UPDATED_BY			= 'KASIR',
					TGL_POSTING			    = ".$this->getField("TGL_POSTING").",
					NO_POSTING				= '".$this->getField("NO_POSTING")."',
					PROGRAM_NAME			= 'KBB_INQ_POST_NEW_IMAIS'
				WHERE NO_NOTA	= '".$this->getField("NO_NOTA")."'
			";
		$this->query = $str;
		return $this->execQuery($str);
    }
		
    function updateJmlCetak()
	{
		$str = "
				UPDATE KBBT_JUR_BB
				SET    
					JML_CETAK   = NVL(JML_CETAK, 0) + 1
				WHERE NO_NOTA	= '".$this->getField("NO_NOTA")."'
			";
		$this->query = $str;
		return $this->execQuery($str);
    }
		
    function update()
	{
		$str = "
				UPDATE KBBT_JUR_BB
				SET    
					   KD_CABANG        = '".$this->getField("KD_CABANG")."',
					   KD_SUBSIS        = '".$this->getField("KD_SUBSIS")."',
					   TIPE_TRANS       = '".$this->getField("TIPE_TRANS")."',
					   NO_NOTA          = '".$this->getField("NO_NOTA")."',
					   JEN_JURNAL       = '".$this->getField("JEN_JURNAL")."',
					   NO_REF1          = '".$this->getField("NO_REF1")."',
					   NO_REF2          = '".$this->getField("NO_REF2")."',
					   NO_REF3          = '".$this->getField("NO_REF3")."',
					   JEN_TRANS        = '".$this->getField("JEN_TRANS")."',
					   KD_SUB_BANTU     = '".$this->getField("KD_SUB_BANTU")."',
					   KD_UNITK         = '".$this->getField("KD_UNITK")."',
					   KD_KUSTO         = '".$this->getField("KD_KUSTO")."',
					   KD_KLIENT        = '".$this->getField("KD_KLIENT")."',
					   KD_ASSET         = '".$this->getField("KD_ASSET")."',
					   KD_STOCK         = '".$this->getField("KD_STOCK")."',
					   THN_BUKU         = '".$this->getField("THN_BUKU")."',
					   BLN_BUKU         = '".$this->getField("BLN_BUKU")."',
					   TGL_ENTRY        = ".$this->getField("TGL_ENTRY").",
					   TGL_TRANS        = ".$this->getField("TGL_TRANS").",
					   KD_VALUTA        = '".$this->getField("KD_VALUTA")."',
					   TGL_VALUTA       = ".$this->getField("TGL_VALUTA").",
					   KURS_VALUTA      = '".$this->getField("KURS_VALUTA")."',
					   JML_VAL_TRANS    = '".$this->getField("JML_VAL_TRANS")."',
					   JML_RP_TRANS     = '".$this->getField("JML_RP_TRANS")."',
					   KD_BAYAR         = '".$this->getField("KD_BAYAR")."',
					   KD_BANK          = '".$this->getField("KD_BANK")."',
					   NOREK_BANK       = '".$this->getField("NOREK_BANK")."',
					   NO_CEK_NOTA      = '".$this->getField("NO_CEK_NOTA")."',
					   NO_POSTING       = '".$this->getField("NO_POSTING")."',
					   KET_TAMBAH       = '".$this->getField("KET_TAMBAH")."',
					   USER_DATA        = '".$this->getField("USER_DATA")."',
					   ID_KASIR         = '".$this->getField("ID_KASIR")."',
					   APPROVER         = '".$this->getField("APPROVER")."',
					   TANDA_TRANS      = '".$this->getField("TANDA_TRANS")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."',
					   KD_BUKU_PUSAT    = '".$this->getField("KD_BUKU_PUSAT")."',
					   NM_AGEN_PERUSH   = '".$this->getField("NM_AGEN_PERUSH")."',
					   ALMT_AGEN_PERUSH = '".$this->getField("ALMT_AGEN_PERUSH")."',
					   URAIAN           = '".$this->getField("URAIAN")."',
					   TGL_POSTING      = ".$this->getField("TGL_POSTING").",
					   JML_CETAK        = '".$this->getField("JML_CETAK")."',
					   KD_KAS           = '".$this->getField("KD_KAS")."',
					   KD_TERMINAL      = '".$this->getField("KD_TERMINAL")."',
					   NO_SP            = '".$this->getField("NO_SP")."',
					   TGL_SP           = ".$this->getField("TGL_SP").",
					   NO_KN_BANK       = '".$this->getField("NO_KN_BANK")."',
					   TGL_KN_BANK      = ".$this->getField("TGL_KN_BANK").",
					   NO_DN            = '".$this->getField("NO_DN")."',
					   TGL_DN           = ".$this->getField("TGL_DN").",
					   NO_REG_KASIR     = '".$this->getField("NO_REG_KASIR")."',
					   FLAG_SETOR_PAJAK = '".$this->getField("FLAG_SETOR_PAJAK")."',
					   STATUS_PROSES    = '".$this->getField("STATUS_PROSES")."',
					   VERIFIED         = '".$this->getField("VERIFIED")."',
					   NO_URUT_UPER     = '".$this->getField("NO_URUT_UPER")."',
					   NO_FAKT_PAJAK    = '".$this->getField("NO_FAKT_PAJAK")."',
					   NO_REF_NOTA      = '".$this->getField("NO_REF_NOTA")."'
				WHERE  NO_NOTA          = '".$this->getField("NO_NOTA")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBT_JUR_BB
                WHERE NO_NOTA  = '".$this->getField("NO_NOTA")."'
		"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
	function selectByParamsGenerateKode($jenis_jurnal="")
	{
		$str = "
		SELECT Get_Kode('".$jenis_jurnal."', SYSDATE) NO_NOTA FROM DUAL	"; 
		return $this->selectLimit($str,-1,-1); 
    }

	function callCopyJurnal()
	{
		$str = $this->PrepareSP("BEGIN KBBP_COPY_JURNAL(:inNOJUR, :inJENJUR, :inBLN, :inTHN, :inTGLTR, :inKET, :outNEWJUR); END;");
		$this->InParameter($str,$this->getField("NOJUR"),'inNOJUR');
		$this->InParameter($str,$this->getField("JENJUR"),'inJENJUR');
		$this->InParameter($str,$this->getField("BLN"),'inBLN');
		$this->InParameter($str,$this->getField("THN"),'inTHN');
		$this->InParameter($str,$this->getField("TGLTR"),'inTGLTR');
		$this->InParameter($str,$this->getField("KET"),'inKET');
		$this->OutParameter($str,$output,'outNEWJUR');
		$this->execQuery($str);
        return $output;
    }	

	function callPosting()
	{
		
		$str = $this->PrepareSP("BEGIN POSTING(:inKDSUBSIS, :inNONOTA, :outNOPOSTING); END;");
		$this->InParameter($str,$this->getField("KD_SUBSIS"),'inKDSUBSIS');
		$this->InParameter($str,$this->getField("NO_NOTA"),'inNONOTA');
		$this->OutParameter($str,$output,'outNOPOSTING');
		$this->execQuery($str);
        return $output;
    }	

	function callKbbPindahSaldoTahun()
	{
        $str = "
				CALL KBB_PINDAH_SALDO_TAHUN('".$this->getField("TAHUN")."', '".$this->getField("BULAN")."', '".$this->getField("KD_CABANG")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function callInsertHistory()
	{
        $str = "
				CALL P_INSERT_HIST('".$this->getField("TAHUN").$this->getField("BULAN")."', 'PSAT', '".$this->getField("KD_CABANG")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callProsesMutTahun()
	{
        $str = "
				CALL PROSES_MUT_TAHUN('".$this->getField("THNBLN_BUKU")."', '".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	


	function callRefreshTotal()
	{
        $str = "
				CALL REFRESH_TOTAL_JURNAL('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	


	function callProsesAjtTahunan()
	{
        $str = "
				CALL PROSES_AJT_TAHUNAN('".$this->getField("TAHUN")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callKbbPindahAnggaranAwlThn()
	{
        $str = "
				CALL KBB_PINDAH_ANGGARAN_AWLTHN('".$this->getField("KD_CABANG")."', ".$this->getField("TAHUN").")
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }
		
	function callInsertJurKasir()
	{
        $str = "
				CALL INSERT_JUR_KASIR('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	

	function callBlcJurBb()
	{
        $str = "
				CALL BLC_JUR_BB('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	
			
	function callGenerateJurnal()
	{
        $str = "
				CALL GENERATE_JURNAL('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	
	
			
	function callGenerateJurnalNonSPP()
	{
        $str = "
				CALL GENERATE_JURNAL_NONSPP('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	
			
	function callGenerateJurnalPembayaran()
	{
        $str = "
				CALL GENERATE_JURNAL_PEMBAYARAN('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	
	
	function callGenerateJurnalUsd()
	{
        $str = "
				CALL GENERATE_JURNAL_USD('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	
			

	function callGenerateJurnalPembatalanNotaTagih()
	{
        $str = "
				CALL GENERATE_JUR_PEMBATALAN_NTAGIH('".$this->getField("NO_NOTA")."', '".$this->getField("PREV_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	
	
	function callGenerateJurnalKompensasi()
	{
        $str = "
				CALL GENERATE_JUR_KOMPENSASI('".$this->getField("NO_NOTA")."', '')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }		
	


	function callGenerateJurnalKnDnSpp()
	{
        $str = "
				CALL GENERATE_JURNAL_KN_DN_SPP('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }			

	function callGenerateJurnalKnDn()
	{
        $str = "
				CALL GENERATE_JURNAL_KN_DN('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callGenerateJurnalKnDnPiut()
	{
        $str = "
				CALL GENERATE_JURNAL_KN_DN_PIUT('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }				
	
	function callGenerateJurnalPenjualanTunai()
	{
        $str = "
				CALL GEN_JURNAL_PENJUALAN_TUNAI('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callSelisihRp()
	{
        $str = "
				CALL SELISIH_RP_IMAIS('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callPreTransRegKasirUsd()
	{
        $str = "
				CALL PRE_TRANS_REG_KASIR_USD_IMAIS('".$this->getField("NO_NOTA")."', '".$this->getField("PERIODE")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }		

	function callPostingKartuRekap()
	{
        $str = "
				CALL POSTING_KARTU_REKAP('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }	
		
	function selectByParamsSimple($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "			    
                SELECT NO_POSTING, TGL_POSTING, KD_KUSTO, KD_SUBSIS, BLN_BUKU, NO_REG_KASIR, JEN_JURNAL, PROGRAM_NAME, KET_TAMBAH FROM KBBT_JUR_BB A
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
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY TGL_TRANS DESC")
	{
		$str = "
				SELECT A.KD_CABANG, A.KD_SUBSIS, A.TIPE_TRANS, D.TIPE_DESC, 
                NO_NOTA, JEN_JURNAL, NO_REF1, 
                NO_REF2, NVL(NO_REF4, NO_REF3) NO_REF3, JEN_TRANS, 
                KD_SUB_BANTU, KD_UNITK, MPLG_NAMA, KD_KUSTO, 
                KD_KLIENT, KD_ASSET, KD_STOCK, 
                THN_BUKU, BLN_BUKU, TGL_ENTRY,
                BLN_BUKU ||'  '||THN_BUKU BULTAH, 
                TGL_TRANS, KD_VALUTA, NAMA_VALUTA KD_VALUTA_DESC, NAMA_VALUTA, TGL_VALUTA, 
                KD_VALUTA || ' - ' || NAMA_VALUTA INFO_VALUTA,
                KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
                KD_BAYAR, A.KD_BANK, C.MBANK_NAMA BANK, NOREK_BANK, 
                NO_CEK_NOTA, NO_POSTING, KET_TAMBAH, 
                USER_DATA, ID_KASIR, APPROVER, 
                TANDA_TRANS, A.LAST_UPDATE_DATE, A.LAST_UPDATED_BY, 
                A.PROGRAM_NAME, KD_BUKU_PUSAT, NVL(NM_AGEN_PERUSH2, NM_AGEN_PERUSH) NM_AGEN_PERUSH, 
                NVL(ALMT_AGEN_PERUSH2, ALMT_AGEN_PERUSH) ALMT_AGEN_PERUSH, URAIAN, TGL_POSTING, 
                JML_CETAK, KD_KAS, KD_TERMINAL, 
                NO_SP, TGL_SP, NO_KN_BANK, 
                TGL_KN_BANK, NO_DN, TGL_DN, 
                NO_REG_KASIR, FLAG_SETOR_PAJAK, STATUS_PROSES, 
                VERIFIED, NO_URUT_UPER, NO_FAKT_PAJAK, NO_REF_NOTA
                FROM KBBT_JUR_BB A
                LEFT JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
                LEFT JOIN SAFM_BANK C ON A.KD_BANK = C.MBANK_KODE
                LEFT JOIN KBBR_TIPE_TRANS D ON D.TIPE_TRANS = A.TIPE_TRANS
                LEFT JOIN SAFR_VALUTA E ON E.KODE_VALUTA = A.KD_VALUTA
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		// echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	 function selectByParamsGetNota($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY TGL_TRANS DESC")
	{
		$str = "
				SELECT A.NO_NOTA, TGL_POSTING, KET_TAMBAH, STATUS_CLOSING
                FROM KBBT_JUR_BB A
                INNER JOIN KBBR_THN_BUKU_D B ON A.BLN_BUKU = B.BLN_BUKU AND A.THN_BUKU = B.THN_BUKU
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		// echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_SUBSIS, TIPE_TRANS, 
				NO_NOTA, JEN_JURNAL, NO_REF1, 
				NO_REF2, NO_REF3, JEN_TRANS, 
				KD_SUB_BANTU, KD_UNITK, KD_KUSTO, 
				KD_KLIENT, KD_ASSET, KD_STOCK, 
				THN_BUKU, BLN_BUKU, TGL_ENTRY, 
				TGL_TRANS, KD_VALUTA, TGL_VALUTA, 
				KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
				KD_BAYAR, KD_BANK, NOREK_BANK, 
				NO_CEK_NOTA, NO_POSTING, KET_TAMBAH, 
				USER_DATA, ID_KASIR, APPROVER, 
				TANDA_TRANS, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, KD_BUKU_PUSAT, NM_AGEN_PERUSH, 
				ALMT_AGEN_PERUSH, URAIAN, TGL_POSTING, 
				JML_CETAK, KD_KAS, KD_TERMINAL, 
				NO_SP, TGL_SP, NO_KN_BANK, 
				TGL_KN_BANK, NO_DN, TGL_DN, 
				NO_REG_KASIR, FLAG_SETOR_PAJAK, STATUS_PROSES, 
				VERIFIED, NO_URUT_UPER, NO_FAKT_PAJAK, NO_REF_NOTA
				FROM KBBT_JUR_BB
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
	
    function getKode($kode_bukti, $tgl_transaksi="SYSDATE")
	{
		$str = "SELECT GET_KODE_FOR_IMAIS('".$kode_bukti."', ".$tgl_transaksi.") AS ROWCOUNT FROM DUAL"; 	
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

	function getKodeNota($paramsArray=array(), $statement="")
	{
		$str = "SELECT GET_KODE_FOR_IMAIS('JKK', SYSDATE) AS ROWCOUNT FROM DUAL
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
	
    function getKodeNotaJKM($paramsArray=array(), $statement="")
	{
		$str = "SELECT GET_KODE_FOR_IMAIS('JKM', SYSDATE) AS ROWCOUNT FROM DUAL
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

    function getKodeNotaJRR($paramsArray=array(), $statement="")
	{
		$str = "SELECT GET_KODE_FOR_IMAIS('JRR', SYSDATE) AS ROWCOUNT FROM DUAL
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
		$str = "SELECT NVL(NO_POSTING,0) NO_POSTING FROM KBBT_JUR_BB WHERE NO_NOTA = '".$no_nota."' "; 	
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("NO_POSTING"); 
		else 
			return 0; 
    }
	
    function getNoRegKasir($jen_jurnal)
	{
		$str = "
				SELECT NVL(MAX(TO_NUMBER(SUBSTR(NO_REG_KASIR, 1, 4))), 0) + 1 NO_MAX
									FROM KBBT_JUR_BB
									WHERE JEN_JURNAL = UPPER('".$jen_jurnal."') 
									AND SUBSTR(NO_REG_KASIR, 10, 2) = TO_CHAR(SYSDATE, 'MM')
									AND SUBSTR(NO_REG_KASIR, 13, 2) = TO_CHAR(SYSDATE, 'RR')		
		"; 	
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("NO_MAX"); 
		else 
			return 1; 
    }
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(JEN_JURNAL) AS ROWCOUNT 
				FROM KBBT_JUR_BB A
                LEFT JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
				LEFT JOIN SAFM_BANK C ON A.KD_BANK = C.MBANK_KODE
				LEFT JOIN KBBR_TIPE_TRANS D ON D.TIPE_TRANS = A.TIPE_TRANS
				LEFT JOIN SAFR_VALUTA E ON E.KODE_VALUTA = A.KD_VALUTA
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
	
    function getNoDokumen($pJenisJurnal)
	{
		$str = " SELECT GENERATE_NO_DOCUM('".$pJenisJurnal."') AS NO_DOK FROM DUAL ";
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("NO_DOK"); 
		else 
			return ""; 
    }

	
	
	function selectByParamsPeriode($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT BLN_BUKU || THN_BUKU PERIODE 
				FROM KBBT_JUR_BB
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
	

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBT_JUR_BB_ID) AS ROWCOUNT FROM KBBT_JUR_BB
		        WHERE KBBT_JUR_BB_ID IS NOT NULL ".$statement; 
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

    function callRefreshPiutang($periode)
	{
        $str = "
				CALL refresh_piutang('".$periode."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }
  } 
?>