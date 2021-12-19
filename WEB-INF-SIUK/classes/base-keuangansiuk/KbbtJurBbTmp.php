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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_JUR_BB_TMP.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbtJurBbTmp extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtJurBbTmp()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBT_JUR_BB_TMP_ID", $this->getNextId("KBBT_JUR_BB_TMP_ID","KBBT_JUR_BB_TMP")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_JUR_BB_TMP (
					   KD_CABANG, KD_SUBSIS, TIPE_TRANS, 
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
					   FLAG_SETOR_PAJAK, STATUS_PROSES, VERIFIED, NO_REF_NOTA) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_SUBSIS")."', '".$this->getField("TIPE_TRANS")."',
						'".$this->getField("NO_NOTA")."', '".$this->getField("JEN_JURNAL")."', '".$this->getField("NO_REF1")."',
						'".$this->getField("NO_REF2")."', '".$this->getField("NO_REF3")."', '".$this->getField("JEN_TRANS")."',
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
						'".$this->getField("FLAG_SETOR_PAJAK")."', '".$this->getField("STATUS_PROSES")."', '".$this->getField("VERIFIED")."', '".$this->getField("NO_REF_NOTA")."'
						)";
				
		$this->id = $this->getField("KBBT_JUR_BB_TMP_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE KBBT_JUR_BB_TMP
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
					   FLAG_SETOR_PAJAK = '".$this->getField("FLAG_SETOR_PAJAK")."',
					   STATUS_PROSES    = '".$this->getField("STATUS_PROSES")."',
					   VERIFIED         = '".$this->getField("VERIFIED")."',
					   NO_REF_NOTA      = '".$this->getField("NO_REF_NOTA")."'
				WHERE  NO_NOTA          = '".$this->getField("NO_NOTA")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
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
					TGL_POSTING				= SYSDATE,
					NO_POSTING				= '".$this->getField("NO_POSTING")."',
					PROGRAM_NAME			= '".$this->getField("PROGRAM_NAME")."'
				WHERE NO_NOTA	= '".$this->getField("NO_NOTA")."'
			";
		$this->query = $str;
		return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "DELETE FROM KBBT_JUR_BB_TMP
                WHERE NO_NOTA = '".$this->getField("NO_NOTA")."'
		"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }

	function callPKbbtJurBbToTmp()
	{
        $str = "
				CALL P_KBBT_JUR_BB_TO_TMP_IMAIS('".$this->getField("NO_NOTA")."')
		"; 
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
	function callKopiJurnalBB()
	{
        $str = "
				CALL KOPI_JURNAL_BB('".$this->getField("NO_NOTA")."')
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
                A.NO_NOTA, JEN_JURNAL, NO_REF1, 
                NO_REF2, NVL(NO_REF4, NO_REF3) NO_REF3, JEN_TRANS, 
                KD_SUB_BANTU, KD_UNITK, MPLG_NAMA, KD_KUSTO, 
                KD_KLIENT, KD_ASSET, KD_STOCK, 
                THN_BUKU, BLN_BUKU, TGL_ENTRY,
                BLN_BUKU ||'  '||THN_BUKU BULTAH, 
                TGL_TRANS, KD_VALUTA, NAMA_VALUTA KD_VALUTA_DESC, NAMA_VALUTA, TGL_VALUTA, 
                KD_VALUTA || ' - ' || NAMA_VALUTA INFO_VALUTA,
                KURS_VALUTA, JML_VAL_TRANS, JML_RP_TRANS, 
                KD_BAYAR, A.KD_BANK, C.MBANK_NAMA BANK, NOREK_BANK, 
                NO_CEK_NOTA, A.NO_POSTING, KET_TAMBAH, 
                USER_DATA, ID_KASIR, APPROVER, 
                TANDA_TRANS, A.LAST_UPDATE_DATE, A.LAST_UPDATED_BY, 
                A.PROGRAM_NAME, KD_BUKU_PUSAT, NVL(NM_AGEN_PERUSH2, NM_AGEN_PERUSH) NM_AGEN_PERUSH, 
                NVL(ALMT_AGEN_PERUSH2, ALMT_AGEN_PERUSH) ALMT_AGEN_PERUSH, URAIAN, TGL_POSTING, 
                JML_CETAK, KD_KAS, KD_TERMINAL, 
                NO_SP, TGL_SP, NO_KN_BANK, 
                TGL_KN_BANK, NO_DN, TGL_DN, 
                FLAG_SETOR_PAJAK, STATUS_PROSES, 
                VERIFIED, NO_REF_NOTA
                FROM KBBT_JUR_BB_TMP A
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
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_SUBSIS, A.TIPE_TRANS, D.TIPE_DESC, 
				NO_NOTA, JEN_JURNAL, NO_REF1, 
				NO_REF2, NO_REF3, JEN_TRANS, 
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
				TANDA_TRANS, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, KD_BUKU_PUSAT, NM_AGEN_PERUSH, 
				ALMT_AGEN_PERUSH, URAIAN, TGL_POSTING, 
				JML_CETAK, KD_KAS, KD_TERMINAL, 
				NO_SP, TGL_SP, NO_KN_BANK, 
				TGL_KN_BANK, NO_DN, TGL_DN, 
				FLAG_SETOR_PAJAK, STATUS_PROSES, 
				VERIFIED, NO_REF_NOTA
				FROM KBBT_JUR_BB_TMP A
                LEFT JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
				LEFT JOIN SAFM_BANK C ON A.KD_BANK = C.MBANK_KODE
				LEFT JOIN KBBR_TIPE_TRANS D ON D.TIPE_TRANS = A.TIPE_TRANS
				LEFT JOIN SAFR_VALUTA E ON E.KODE_VALUTA = A.KD_VALUTA
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
		$str = "SELECT COUNT(JEN_JURNAL) AS ROWCOUNT 
				FROM KBBT_JUR_BB_TMP A
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
	
	
	function selectByParamsPeriode($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT BLN_BUKU || THN_BUKU PERIODE 
				FROM KBBT_JUR_BB_TMP
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
		$str = "SELECT COUNT(KBBT_JUR_BB_TMP_ID) AS ROWCOUNT FROM KBBT_JUR_BB_TMP
		        WHERE KBBT_JUR_BB_TMP_ID IS NOT NULL ".$statement; 
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