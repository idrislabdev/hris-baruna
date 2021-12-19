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
  * EntitySIUK-base class untuk mengimplementasikan tabel KPTT_NOTA_D.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KpttNotaNonJurnalD extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KpttNotaNonJurnalD()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KPTT_NOTA_D_ID", $this->getNextId("KPTT_NOTA_D_ID","KPTT_NOTA_D")); 		
		
		$str = "
				INSERT INTO KPTT_NOTA_NON_JURNAL_D (
					   KD_CABANG, KD_SUBSIS, JEN_JURNAL, 
					   TIPE_TRANS, NO_NOTA, LINE_SEQ, 
					   KLAS_TRANS, KWANTITAS, SATUAN, 
					   HARGA_SATUAN, TGL_VALUTA, KD_VALUTA, 
					   KURS_VALUTA, JML_VAL_TRANS, STATUS_KENA_PAJAK, 
					   JML_VAL_PAJAK, JML_RP_TRANS, JML_RP_PAJAK, 
					   JML_RP_SLSH_KURS, TANDA_TRANS, KD_BUKU_BESAR, 
					   KD_SUB_BANTU, KD_BUKU_PUSAT, KD_D_K, 
					   PREV_NO_NOTA, KET_TAMBAHAN, STATUS_PROSES, 
					   FLAG_JURNAL, NO_REF1, NO_REF2, 
					   NO_REF3, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
					   PROGRAM_NAME, KD_TERMINAL, NL_TARIF) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_SUBSIS")."', '".$this->getField("JEN_JURNAL")."',
						'".$this->getField("TIPE_TRANS")."', '".$this->getField("NO_NOTA")."', '".$this->getField("LINE_SEQ")."',
						'".$this->getField("KLAS_TRANS")."', '".$this->getField("KWANTITAS")."', '".$this->getField("SATUAN")."',
						'".$this->getField("HARGA_SATUAN")."', ".$this->getField("TGL_VALUTA").", '".$this->getField("KD_VALUTA")."',
						".$this->getField("KURS_VALUTA").", '".$this->getField("JML_VAL_TRANS")."', '".$this->getField("STATUS_KENA_PAJAK")."',
						'".$this->getField("JML_VAL_PAJAK")."', '".$this->getField("JML_RP_TRANS")."', '".$this->getField("JML_RP_PAJAK")."',
						'".$this->getField("JML_RP_SLSH_KURS")."', '".$this->getField("TANDA_TRANS")."', '".$this->getField("KD_BUKU_BESAR")."',
						'".$this->getField("KD_SUB_BANTU")."', '".$this->getField("KD_BUKU_PUSAT")."', '".$this->getField("KD_D_K")."',
						'".$this->getField("PREV_NO_NOTA")."', '".$this->getField("KET_TAMBAHAN")."', '".$this->getField("STATUS_PROSES")."',
						'".$this->getField("FLAG_JURNAL")."', '".$this->getField("NO_REF1")."', '".$this->getField("NO_REF2")."',
						'".$this->getField("NO_REF3")."', SYSDATE, '".$this->getField("LAST_UPDATED_BY")."',
						'".$this->getField("PROGRAM_NAME")."', '".$this->getField("KD_TERMINAL")."', '".$this->getField("NL_TARIF")."'
						)";
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KPTT_NOTA_NON_JURNAL_D
				SET    KD_CABANG         = '".$this->getField("KD_CABANG")."',
					   KD_SUBSIS         = '".$this->getField("KD_SUBSIS")."',
					   JEN_JURNAL        = '".$this->getField("JEN_JURNAL")."',
					   TIPE_TRANS        = '".$this->getField("TIPE_TRANS")."',
					   NO_NOTA           = '".$this->getField("NO_NOTA")."',
					   LINE_SEQ          = '".$this->getField("LINE_SEQ")."',
					   KLAS_TRANS        = '".$this->getField("KLAS_TRANS")."',
					   KWANTITAS         = '".$this->getField("KWANTITAS")."',
					   SATUAN            = '".$this->getField("SATUAN")."',
					   HARGA_SATUAN      = '".$this->getField("HARGA_SATUAN")."',
					   TGL_VALUTA        = ".$this->getField("TGL_VALUTA").",
					   KD_VALUTA         = '".$this->getField("KD_VALUTA")."',
					   KURS_VALUTA       = '".$this->getField("KURS_VALUTA")."',
					   JML_VAL_TRANS     = '".$this->getField("JML_VAL_TRANS")."',
					   STATUS_KENA_PAJAK = '".$this->getField("STATUS_KENA_PAJAK")."',
					   JML_VAL_PAJAK     = '".$this->getField("JML_VAL_PAJAK")."',
					   JML_RP_TRANS      = '".$this->getField("JML_RP_TRANS")."',
					   JML_RP_PAJAK      = '".$this->getField("JML_RP_PAJAK")."',
					   JML_RP_SLSH_KURS  = '".$this->getField("JML_RP_SLSH_KURS")."',
					   TANDA_TRANS       = '".$this->getField("TANDA_TRANS")."',
					   KD_BUKU_BESAR     = '".$this->getField("KD_BUKU_BESAR")."',
					   KD_SUB_BANTU      = '".$this->getField("KD_SUB_BANTU")."',
					   KD_BUKU_PUSAT     = '".$this->getField("KD_BUKU_PUSAT")."',
					   KD_D_K            = '".$this->getField("KD_D_K")."',
					   PREV_NO_NOTA      = '".$this->getField("PREV_NO_NOTA")."',
					   KET_TAMBAHAN      = '".$this->getField("KET_TAMBAHAN")."',
					   STATUS_PROSES     = '".$this->getField("STATUS_PROSES")."',
					   FLAG_JURNAL       = '".$this->getField("FLAG_JURNAL")."',
					   NO_REF1           = '".$this->getField("NO_REF1")."',
					   NO_REF2           = '".$this->getField("NO_REF2")."',
					   NO_REF3           = '".$this->getField("NO_REF3")."',
					   LAST_UPDATE_DATE  = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY   = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME      = '".$this->getField("PROGRAM_NAME")."',
					   KD_TERMINAL       = '".$this->getField("KD_TERMINAL")."',
					   NL_TARIF          = '".$this->getField("NL_TARIF")."'
				WHERE  NO_NOTA = '".$this->getField("NO_NOTA")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function updatePembatalanSudahCetakNota()
	{
        $str = "UPDATE KPTT_NOTA_NON_JURNAL_D SET
				STATUS_PROSES = 2
                WHERE 
                NO_NOTA = '".$this->getField("NO_NOTA")."' "; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "DELETE FROM KPTT_NOTA_NON_JURNAL_D
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY KD_SUBSIS ASC")
	{
		$str = "
				SELECT KD_CABANG, KD_SUBSIS, JEN_JURNAL, 
				A.TIPE_TRANS, NO_NOTA, LINE_SEQ, 
				KLAS_TRANS, KWANTITAS, SATUAN, 
				HARGA_SATUAN, TGL_VALUTA, KD_VALUTA, 
				KURS_VALUTA, JML_VAL_TRANS, CASE WHEN nvl(STATUS_KENA_PAJAK, '0') = '0' THEN 'N' ELSE 'Y' END STATUS_KENA_PAJAK, 
				JML_VAL_PAJAK, JML_RP_TRANS, JML_RP_PAJAK, JML_VAL_TRANS + JML_VAL_PAJAK JUMLAH_TOTAL,
				JML_RP_SLSH_KURS, TANDA_TRANS, KD_BUKU_BESAR, 
				KD_SUB_BANTU, KD_BUKU_PUSAT, KD_D_K, 
				PREV_NO_NOTA, KET_TAMBAHAN, STATUS_PROSES, 
				FLAG_JURNAL, NO_REF1, NO_REF2, 
				NO_REF3, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, KD_TERMINAL, NL_TARIF
				FROM KPTT_NOTA_NON_JURNAL_D A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_SUBSIS, JEN_JURNAL, 
				TIPE_TRANS, NO_NOTA, LINE_SEQ, 
				KLAS_TRANS, KWANTITAS, SATUAN, 
				HARGA_SATUAN, TGL_VALUTA, KD_VALUTA, 
				KURS_VALUTA, JML_VAL_TRANS, STATUS_KENA_PAJAK, 
				JML_VAL_PAJAK, JML_RP_TRANS, JML_RP_PAJAK, 
				JML_RP_SLSH_KURS, TANDA_TRANS, KD_BUKU_BESAR, 
				KD_SUB_BANTU, KD_BUKU_PUSAT, KD_D_K, 
				PREV_NO_NOTA, KET_TAMBAHAN, STATUS_PROSES, 
				FLAG_JURNAL, NO_REF1, NO_REF2, 
				NO_REF3, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, KD_TERMINAL, NL_TARIF
				FROM KPTT_NOTA_NON_JURNAL_D
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
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM KPTT_NOTA_NON_JURNAL_D
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