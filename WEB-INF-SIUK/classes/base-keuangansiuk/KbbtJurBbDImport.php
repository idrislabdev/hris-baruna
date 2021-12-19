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

  class KbbtJurBbDImport extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtJurBbDImport()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("NO_NOTA", $this->getNextId("NO_NOTA","KBBT_JUR_BB_D")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_JUR_BB_D_IMPORT (
					   KD_CABANG, NO_NOTA, NO_SEQ, 
					   KD_SUBSIS, KD_JURNAL, TIPE_TRANS, 
					   KLAS_TRANS, KD_BUKU_BESAR, KD_SUB_BANTU, 
					   KD_BUKU_PUSAT, KD_VALUTA, TGL_VALUTA, 
					   KURS_VALUTA, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
					   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH, 
					   TANDA_TRANS, KD_AKTIF, LAST_UPDATE_DATE, 
					   LAST_UPDATED_BY, PROGRAM_NAME, PREV_NO_NOTA, 
					   REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK, FAKTUR_PAJAK, TGL_FAKTUR_PAJAK) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("NO_NOTA")."', '".$this->getField("NO_SEQ")."',
						'".$this->getField("KD_SUBSIS")."', '".$this->getField("KD_JURNAL")."', '".$this->getField("TIPE_TRANS")."',
						'".$this->getField("KLAS_TRANS")."', '".$this->getField("KD_BUKU_BESAR")."', NVL('".$this->getField("KD_SUB_BANTU")."', '00000'),
						NVL('".$this->getField("KD_BUKU_PUSAT")."', '000.00.00'), '".$this->getField("KD_VALUTA")."', ".$this->getField("TGL_VALUTA").",
						'".$this->getField("KURS_VALUTA")."', NVL('".$this->getField("SALDO_VAL_DEBET")."', 0), NVL('".$this->getField("SALDO_VAL_KREDIT")."', 0),
						NVL('".$this->getField("SALDO_RP_DEBET")."', 0), NVL('".$this->getField("SALDO_RP_KREDIT")."', 0), '".$this->getField("KET_TAMBAH")."',
						'".$this->getField("TANDA_TRANS")."', '".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").",
						'".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."', '".$this->getField("PREV_NO_NOTA")."',
						'".$this->getField("REF_NOTA_JUAL_BELI")."', '".$this->getField("BAYAR_VIA")."', '".$this->getField("STATUS_KENA_PAJAK")."', 
						'".$this->getField("FAKTUR_PAJAK")."', ".$this->getField("TGL_FAKTUR_PAJAK")."
				)";
				
		$this->id = $this->getField("NO_NOTA");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE KBBT_JUR_BB_D_IMPORT
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
					   STATUS_KENA_PAJAK  = '".$this->getField("STATUS_KENA_PAJAK")."'
				WHERE  NO_NOTA = '".$this->getField("NO_NOTA")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }


	function delete()
	{
        $str = "DELETE FROM KBBT_JUR_BB_D_IMPORT
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
                A.LAST_UPDATED_BY, A.PROGRAM_NAME, PREV_NO_NOTA, 
                REF_NOTA_JUAL_BELI, BAYAR_VIA, STATUS_KENA_PAJAK, NM_BUKU_BESAR, A.FAKTUR_PAJAK, A.TGL_FAKTUR_PAJAK
                FROM KBBT_JUR_BB_D_IMPORT A INNER JOIN KBBR_BUKU_BESAR B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR
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
                D.NM_SUB_BANTU NAMA_KK
				FROM KBBT_JUR_BB_D_IMPORT A 
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
		return $this->selectLimit($str,$limit,$from); 
    }
		
  } 
?>