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

  class KbbtJurBbImport extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtJurBbImport()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_JUR_BB_IMPORT (
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
					   VERIFIED, NO_URUT_UPER, NO_FAKT_PAJAK, NO_REF_NOTA) 
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
						'".$this->getField("NO_REG_KASIR")."', '".$this->getField("FLAG_SETOR_PAJAK")."', '".$this->getField("STATUS_PROSES")."',
						'".$this->getField("VERIFIED")."', '".$this->getField("NO_URUT_UPER")."', '".$this->getField("NO_FAKT_PAJAK")."', 
						'".$this->getField("NO_REF_NOTA")."'
				)";
		$this->query = $str;
		return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "DELETE FROM KBBT_JUR_BB_IMPORT
                WHERE NO_NOTA  = '".$this->getField("NO_NOTA")."'
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY TGL_TRANS DESC")
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
				NO_REG_KASIR, FLAG_SETOR_PAJAK, STATUS_PROSES, 
				VERIFIED, NO_URUT_UPER, NO_FAKT_PAJAK, NO_REF_NOTA
				FROM KBBT_JUR_BB_IMPORT A
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
				FROM KBBT_JUR_BB_IMPORT
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
	

  } 
?>