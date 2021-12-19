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
  * Entity-base class untuk mengimplementasikan tabel FAQ.
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
	
	function insertJurnal()
	{
		$str = "
				INSERT INTO KBBT_JUR_BB (
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
					   NO_REG_KASIR, FLAG_SETOR_PAJAK, STATUS_PROSES, 
					   VERIFIED, NO_URUT_UPER, NO_FAKT_PAJAK) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_SUBSIS")."', '".$this->getField("TIPE_TRANS")."',
						'".$this->getField("NO_NOTA")."', '".$this->getField("JEN_JURNAL")."', '".$this->getField("NO_REF1")."',
						'".$this->getField("NO_REF2")."', '".$this->getField("NO_REF3")."', '".$this->getField("JEN_TRANS")."',
						'".$this->getField("KD_SUB_BANTU")."', '".$this->getField("KD_UNITK")."', '".$this->getField("KD_KUSTO")."',
						'".$this->getField("KD_KLIENT")."', '".$this->getField("KD_ASSET")."', '".$this->getField("KD_STOCK")."',
						'".$this->getField("THN_BUKU")."', '".$this->getField("BLN_BUKU")."', ".$this->getField("TGL_ENTRY").",
						".$this->getField("TGL_TRANS").", '".$this->getField("KD_VALUTA")."', ".$this->getField("TGL_VALUTA").",
						".$this->getField("KURS_VALUTA").", ".$this->getField("JML_VAL_TRANS").", ".$this->getField("JML_RP_TRANS").",
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
						'".$this->getField("VERIFIED")."', '".$this->getField("NO_URUT_UPER")."', '".$this->getField("NO_FAKT_PAJAK")."'
				)";
			
		$this->query = $str;
		return $this->execQuery($str);
    }

	function insertJurnalTemp($reqNota)
	{
		/*Auto-generate primary key(s) by next max value (integer) */
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
				   FLAG_SETOR_PAJAK, STATUS_PROSES, VERIFIED) 
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
				   FLAG_SETOR_PAJAK, STATUS_PROSES, VERIFIED FROM KBBT_JUR_BB WHERE NO_NOTA = '".$reqNota."'
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
					   NO_FAKT_PAJAK    = '".$this->getField("NO_FAKT_PAJAK")."'
				WHERE  KBBT_JUR_BB_ID   = '".$this->getField("KBBT_JUR_BB_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBT_JUR_BB
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."'"; 
		$this->execQuery($str);
        
		$str = "DELETE FROM KBBT_JUR_BB_TMP
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG
				FROM KBBT_JUR_BB A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TGL_TRANS DESC";
		$this->query = $str;
		echo $str;exit();
		return $this->selectLimit($str,$limit,$from); 
    }
    
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(JEN_JURNAL) AS ROWCOUNT FROM KBBT_JUR_BB
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
  } 
?>