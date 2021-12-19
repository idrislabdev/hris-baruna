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

  class KpttNotaLap extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KpttNotaLap()
	{
      $this->EntitySIUK(); 
    }
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "			    
                SELECT A.KD_KUSTO,     A.KD_VALUTA, A.NO_REF1 NO_NOTA_JUAL, A.NO_REF3,
                A.TGL_TRANS, A.KET_TAMBAHAN,    A.TGL_JT_TEMPO, A.JML_SALDO_AKHIR SISA_TAGIHAN, 
                A.TIPE_TRANS, B.MPLG_NAMA, 
                E.NAMA_KOTA, (SELECT akronim_DESC
            	FROM KBBR_TIPE_TRANS X
            	WHERE X.TIPE_TRANS = A.TIPE_TRANS) SEGMEN
			   FROM SIMKEU.KPTT_NOTA_LAP A, SAFM_PELANGGAN B,  
					SAFR_CABANG D,
					   (SELECT RSYS_KETKODE3 NAMA_KOTA 
						  FROM SAFR_SYSPARAM
						   WHERE RSYS_NO = 1) E
			  WHERE  A.BULTAH  = (SELECT MAX(BULTAH)    
												  FROM KPTT_NOTA_LAP
													WHERE BULTAH = TO_NUMBER(TO_CHAR(SYSDATE, 'YYYYMM')))
				  AND (FLAG_PUPN IS NULL OR FLAG_PUPN = 'K')                     
				  AND  NVL(JML_SALDO_AKHIR,0) <> 0                        
				  AND  A.KD_KUSTO  = B.MPLG_KODE(+)                        
				  AND  A.KD_CABANG = D.KODE_CABANG(+)
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

    function selectByParamsTransaksi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "			    
                SELECT A.BULTAH, A.KD_KUSTO,     A.KD_VALUTA, A.NO_REF1 NO_NOTA_JUAL, A.NO_REF3,
                A.TGL_TRANS, A.KET_TAMBAHAN,    A.TGL_JT_TEMPO, CASE WHEN A.JML_SALDO_AKHIR = 0 THEN A.JML_TAGIHAN ELSE A.JML_SALDO_AKHIR END SISA_TAGIHAN, 
                A.TIPE_TRANS, B.MPLG_NAMA, 
                E.NAMA_KOTA, (SELECT akronim_DESC
            	FROM KBBR_TIPE_TRANS X
            	WHERE X.TIPE_TRANS = A.TIPE_TRANS) SEGMEN,
				CASE WHEN NVL(JML_SALDO_AKHIR,0) = 0 THEN 'Lunas' ELSE 'Belum' END PELUNASAN
			   FROM KPTT_NOTA_LAP A, SAFM_PELANGGAN B,  
					SAFR_CABANG D,
					   (SELECT RSYS_KETKODE3 NAMA_KOTA 
						  FROM SAFR_SYSPARAM
						   WHERE RSYS_NO = 1) E
			  WHERE  (FLAG_PUPN IS NULL OR FLAG_PUPN = 'K')               
				  AND  A.KD_KUSTO  = B.MPLG_KODE(+)                        
				  AND  A.KD_CABANG = D.KODE_CABANG(+)
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
	
    function selectByParamsSummary($kd_kusto)
	{
		$str = "		
				SELECT 
				(
				SELECT NVL(AA.SALDO,0)
				FROM
				(
				SELECT SUM(A.JML_SALDO_AKHIR) SALDO
				 FROM  KPTT_NOTA_LAP A, SAFM_PELANGGAN B,  
					   UPKM_KAPAL C, SAFR_CABANG D,
					   (SELECT RSYS_KETKODE3 NAMA_KOTA 
						  FROM SAFR_SYSPARAM
						 WHERE RSYS_NO = 1) E
				WHERE  A.BULTAH  = (SELECT MAX(BULTAH)    
												  FROM KPTT_NOTA_LAP
													WHERE BULTAH = TO_NUMBER(TO_CHAR(SYSDATE, 'YYYYMM')))
				  AND (FLAG_PUPN IS NULL OR FLAG_PUPN = 'K')    
				  AND  KD_VALUTA   = 'IDR'                 
				  AND  A.KD_KUSTO   = '".$kd_kusto."'                         
				  AND  NVL(JML_SALDO_AKHIR,0) <> 0                        
				  AND  A.KD_KUSTO  = B.MPLG_KODE(+)                     
				  AND  A.KD_OBYEK  = C.MKPL_KODE(+)                      
				  AND  A.KD_CABANG = D.KODE_CABANG(+)) AA
				) IDR,
				(  
				SELECT NVL(AA.SALDO,0)
				FROM
				(
				SELECT SUM(A.JML_SALDO_AKHIR) SALDO
				 FROM  KPTT_NOTA_LAP A, SAFM_PELANGGAN B,  
					   UPKM_KAPAL C, SAFR_CABANG D,
					   (SELECT RSYS_KETKODE3 NAMA_KOTA 
						  FROM SAFR_SYSPARAM
						 WHERE RSYS_NO = 1) E
				WHERE  A.BULTAH  = (SELECT MAX(BULTAH)	
											FROM KPTT_NOTA_LAP
													WHERE BULTAH = TO_NUMBER(TO_CHAR(SYSDATE, 'YYYYMM')))
				  AND (FLAG_PUPN IS NULL OR FLAG_PUPN = 'K')	
				  AND  KD_VALUTA   = 'USD' 				              
				  AND  A.KD_KUSTO   = '".$kd_kusto."'    	
				  AND  NVL(JML_SALDO_AKHIR,0) <> 0 	   				
				  AND  A.KD_KUSTO  = B.MPLG_KODE(+) 					
				  AND  A.KD_OBYEK  = C.MKPL_KODE(+)  					
				  AND  A.KD_CABANG = D.KODE_CABANG(+)) AA
			   ) USD FROM DUAL   
				"; 
				
		$this->query = $str;
		return $this->select($str); 
    }

    function selectByParamsSummaryTransaksi($kd_kusto, $statement)
	{
		$str = "		
				SELECT 
				(
				SELECT NVL(AA.SALDO,0)
				FROM
				(
				SELECT SUM(CASE WHEN A.JML_SALDO_AKHIR = 0 THEN A.JML_KREDIT ELSE A.JML_SALDO_AKHIR END) SALDO
				 FROM  KPTT_NOTA_LAP A, SAFM_PELANGGAN B,  
					   UPKM_KAPAL C, SAFR_CABANG D,
					   (SELECT RSYS_KETKODE3 NAMA_KOTA 
						  FROM SAFR_SYSPARAM
						 WHERE RSYS_NO = 1) E
				WHERE (FLAG_PUPN IS NULL OR FLAG_PUPN = 'K')    
				  AND  KD_VALUTA   = 'IDR'     
			";
		if($kd_kusto == "")
		{}
		else
		{	
			$str .= "	            
					  AND  A.KD_KUSTO   = '".$kd_kusto."'                     
					";
		}
		$str .= "				  
				  AND  A.KD_KUSTO  = B.MPLG_KODE(+)                     
				  AND  A.KD_OBYEK  = C.MKPL_KODE(+)                      
				  AND  A.KD_CABANG = D.KODE_CABANG(+)
				  ".$statement.") AA
				) IDR,
				(  
				SELECT NVL(AA.SALDO,0)
				FROM
				(
				SELECT SUM(CASE WHEN A.JML_SALDO_AKHIR = 0 THEN A.JML_KREDIT ELSE A.JML_SALDO_AKHIR END) SALDO
				 FROM  KPTT_NOTA_LAP A, SAFM_PELANGGAN B,  
					   UPKM_KAPAL C, SAFR_CABANG D,
					   (SELECT RSYS_KETKODE3 NAMA_KOTA 
						  FROM SAFR_SYSPARAM
						 WHERE RSYS_NO = 1) E
				WHERE  (FLAG_PUPN IS NULL OR FLAG_PUPN = 'K')	
				  AND  KD_VALUTA   = 'USD' 				              
				  AND  A.KD_KUSTO   = '".$kd_kusto."'  				
				  AND  A.KD_KUSTO  = B.MPLG_KODE(+) 					
				  AND  A.KD_OBYEK  = C.MKPL_KODE(+)  					
				  AND  A.KD_CABANG = D.KODE_CABANG(+)
				  ".$statement.") AA
			   ) USD FROM DUAL   
				"; 
				
		$this->query = $str;
		return $this->select($str); 
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
				FROM KPTT_NOTA
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
		$str = "SELECT COUNT(1) ROWCOUNT
			   FROM KPTT_NOTA_LAP A, SAFM_PELANGGAN B,  
					SAFR_CABANG D,
					   (SELECT RSYS_KETKODE3 NAMA_KOTA 
						  FROM SAFR_SYSPARAM
						   WHERE RSYS_NO = 1) E
			  WHERE  A.BULTAH  = (SELECT MAX(BULTAH)    
												  FROM KPTT_NOTA_LAP
													WHERE BULTAH = TO_NUMBER(TO_CHAR(SYSDATE, 'YYYYMM')))
				  AND (FLAG_PUPN IS NULL OR FLAG_PUPN = 'K')                     
				  AND  NVL(JML_SALDO_AKHIR,0) <> 0                        
				  AND  A.KD_KUSTO  = B.MPLG_KODE(+)                        
				  AND  A.KD_CABANG = D.KODE_CABANG(+)      ".$statement; 
		
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

    function getCountByParamsTransaksi($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) ROWCOUNT
			   FROM KPTT_NOTA_LAP A, SAFM_PELANGGAN B,  
					SAFR_CABANG D,
					   (SELECT RSYS_KETKODE3 NAMA_KOTA 
						  FROM SAFR_SYSPARAM
						   WHERE RSYS_NO = 1) E
			  WHERE  (FLAG_PUPN IS NULL OR FLAG_PUPN = 'K')              
				  AND  A.KD_KUSTO  = B.MPLG_KODE(+)                        
				  AND  A.KD_CABANG = D.KODE_CABANG(+)      ".$statement; 
		
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
		$str = "SELECT COUNT(KPTT_NOTA_ID) AS ROWCOUNT FROM KPTT_NOTA
		        WHERE KPTT_NOTA_ID IS NOT NULL ".$statement; 
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