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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_BUKU_BESAR.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KeuanganPusat extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KeuanganPusat()
	{
      $this->EntitySIUK(); 
    }

	function callCreateMaster()
	{
        $str = "
				CALL KNV_CREATE_MASTER_FOXPRO_IMAIS('".$this->getField("BULAN")."', '".$this->getField("TAHUN")."', '".$this->getField("DELETE")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callCreateTranb()
	{
        $str = "
				CALL KNV_CREATE_TRANB_FOXPRO_IMAIS('".$this->getField("BULAN")."', '".$this->getField("TAHUN")."', '".$this->getField("DELETE")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callPiutangMaster()
	{
        $str = "
				CALL KNV_PIUTANG_MASTER_IMAIS('".$this->getField("BULAN")."', '".$this->getField("TAHUN")."', '".$this->getField("DELETE")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callMasters()
	{
        $str = "
				CALL KNV_MASTERS_IMAIS('".$this->getField("BULAN")."', '".$this->getField("TAHUN")."', '".$this->getField("DELETE")."')
		"; 
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callControlData()
	{
        $str = "
				CALL KNV_CONTROLDATA_IMAIS('".$this->getField("BULAN")."', '".$this->getField("TAHUN")."', '".$this->getField("DELETE")."')
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
    function selectByParamsTmpMasterFoxpro($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY DIRECT_NAME,1,2,3")
	{
		$str = "
				SELECT
					KDBB01,KDBB02,KDBB03,KD_VALUTA,AWSALD,AWSMUT,MUDBLL,MUKRLL,MUDBIN,
					MUKRIN,AKSALD,AKSMUT,AKDBSI,AKKRSI,ANGTHN,ANTR01,ANTR02,
					ANTR03,ANTR04,JUMLAH,DIRECT_NAME
				FROM TMP_MASTER_FOXPRO
				WHERE 1=1
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
	
	function selectByParamsTmpTranbFoxpro($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY DIRECT_NAME,1,3,2,STAT01")
	{
		$str = "
				SELECT NOMOR,NOBUKTIPENDUKUNG, INDEKS,JUN,KDBB01,KDBB02,KDBB03,RLBB01,RLBB02,RLBB03,
               		RKBB01,STAT01,FSTATUS,TO_DATE(TGL, 'DD-MM-YYYY') TGL,AGEN,URAI01,URAI02,URAI03,URAI04,
               		URAI05,BDUK01,TO_DATE(BDUK02, 'DD-MM-YYYY') BDUK02,JUMLAH,BNOPOS,TO_DATE(BTGPOS, 'DD-MM-YYYY') BTGPOS,
                    DEBET, KREDIT, DIRECT_NAME
    			FROM TMP_TRANB_FOXPRO
				WHERE 1=1
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
	
	function selectByParamsTmpPiutangMaster($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY DIRECT_NAME")
	{
		$str = "
				SELECT KD_CABANG, BADAN_USAHA, KD_PELAYANAN, KD_KUSTO, MPLG_NAMA, NO_NOTA, BULTAH, TO_DATE(TGL_TRANS, 'DD-MM-YYYY') TGL_TRANS, 
                	TIPE_TRANS, NO_REF_UTAMA, NO_REF3, PREV_NO_NOTA, KET_NOTA, JML_SALDO_AWAL, JML_DEBET, 
                    JML_KREDIT, JML_SALDO_AKHIR, KD_VALUTA,KURS_VALUTA,KD_BB_KUSTO,DIRECT_NAME 
				FROM TMP_PIUTANG_MASTER
				WHERE 1=1
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
	
	function selectByParamsTmpMastersMach($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY DIRECT_NAME")
	{
		$str = "
				SELECT KODE, KD_BUKU_BESAR, NM_BUKU_BESAR, TIPE_REKENING, POLA_ENTRY, KODE_VALUTA, COA_ID, KD_AKTIF,DIRECT_NAME 
				FROM TMP_MASTERS_MACH
				WHERE 1=1
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
	
	function selectByParamsTmpControlDataFoxpro($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY DIRECTOR")
	{
		$str = "
				SELECT KODE1, KODE2, KD_VALUTA, 
                       KARTU, PUSAT, DIRECTOR, SALDO 
				FROM TMP_CONTROLDATA_FOXPRO
				WHERE 1=1
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
	
	
    function selectByParamsLH1ToExcel($reqBulan, $reqTahun, $reqDrKodeRekening, $reqSmpKodeRekening)
	{
		$str = "
				SELECT KD_BUKU_BESAR, KD_SUB_BANTU, KD_BUKU_PUSAT, NM_BUKU_BESAR, TGL_ENTRY, NOMOR_BUKTI, NO_POSTING, KET_TAMBAH, RP_DEBET, RP_KREDIT, RINCIAN_KETERANGAN FROM
                              (     
                                SELECT DISTINCT B.KD_BUKU_BESAR,  B.KD_SUB_BANTU, B.KD_BUKU_PUSAT, AMBIL_BUKU_BESAR_NAMA(B.KD_BUKU_BESAR) NM_BUKU_BESAR,
                                       TO_DATE('01/01/2019','DD/MM/RRRR') TGL_ENTRY, 
                                       '' NOMOR_BUKTI,
                                       '' NO_POSTING,
                                       '' KET_TAMBAH,
                                       0  RP_DEBET,
                                       0  RP_KREDIT,
                                       '' RINCIAN_KETERANGAN
                                FROM     KBBT_NERACA_SALDO B
								WHERE  B.KD_BUKU_BESAR >= NVL('".trim($reqDrKodeRekening)."',B.KD_BUKU_BESAR) 
								AND    B.KD_BUKU_BESAR <= NVL('".trim($reqSmpKodeRekening)."',B.KD_BUKU_BESAR)
								AND    B.THN_BUKU      = ".$reqTahun."
                                UNION ALL
                               SELECT D.KD_BUKU_BESAR, D.KD_SUB_BANTU, D.KD_BUKU_PUSAT, AMBIL_BUKU_BESAR_NAMA(D.KD_BUKU_BESAR) NM_BUKU_BESAR,
                                             C.TGL_POSTING            TGL_ENTRY, 
                                             C.NO_NOTA                                NOMOR_BUKTI,
                                             C.NO_POSTING                NO_POSTING,
                                             E.NM_BUKU_BESAR     KET_TAMBAH,
                                             NVL(D.SALDO_RP_DEBET,0)           RP_DEBET,
                                             NVL(D.SALDO_RP_KREDIT,0)          RP_KREDIT,
                                             nvl(d.ket_tambah,' ') RINCIAN_KETERANGAN
                                FROM   KBBT_JUR_BB C,
                                           KBBT_JUR_BB_D D,
                                           KBBR_BUKU_BESAR E
								WHERE  D.KD_BUKU_BESAR >= NVL('".trim($reqDrKodeRekening)."',D.KD_BUKU_BESAR)
								AND    D.KD_BUKU_BESAR <= NVL('".trim($reqSmpKodeRekening)."',D.KD_BUKU_BESAR)
								AND    D.NO_NOTA  = C.NO_NOTA  
								AND    C.THN_BUKU = ".$reqTahun."
								AND    C.BLN_BUKU = '".$reqBulan."'
                                AND    C.NO_POSTING IS NOT NULL
                                AND    D.KD_BUKU_BESAR = E.KD_BUKU_BESAR
                                )
                                WHERE  NVL(RP_DEBET,0) <> 0 OR NVL(RP_KREDIT,0) <> 0
								ORDER BY TGL_ENTRY ASC, NOMOR_BUKTI ASC, RP_DEBET DESC, RP_KREDIT ASC
				"; 
	
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }	

    function selectByParamsLH2ToExcel($reqBulan, $reqTahun, $reqDrKodeRekening, $reqSmpKodeRekening, $reqDrBukuBantu, $reqSmpBukuBantu)
	{
		$str = "
				SELECT  DISTINCT
								  P.KD_BUKU_BESAR 			KD_REKENING,
								  P.NM_BUKU_BESAR	 			NM_REKENING,
								  Q.KD_SUB_BANTU  			KD_KARTU,
								  ''                          NM_KARTU,
								  TO_DATE('01/01/".$reqTahun."','DD/MM/RRRR') TGL_ENTRY, 
								  ''	NO_BUKTI,  
								  ''	NO_POSTING,
								  ''	KET_TAMBAH,
								  0			RP_DEBET,
								  0			RP_KREDIT
				  FROM		KBBR_BUKU_BESAR P,
								  KBBT_NERACA_SALDO Q,
								  KBBR_KARTU_TAMBAH R
				  WHERE 	P.KD_BUKU_BESAR = Q.KD_BUKU_BESAR
				  AND 		Q.KD_SUB_BANTU = R.KD_SUB_BANTU(+)
				  AND 		Q.THN_BUKU = ".$reqTahun."
				  AND 		Q.KD_BUKU_BESAR >= NVL('".$reqDrKodeRekening."',Q.KD_BUKU_BESAR)
				  AND 		Q.KD_BUKU_BESAR <= NVL('".$reqSmpKodeRekening."',Q.KD_BUKU_BESAR)  
				  AND 		Q.KD_SUB_BANTU  >= NVL('".$reqDrBukuBantu."',Q.KD_SUB_BANTU)
				  AND 		Q.KD_SUB_BANTU  <= NVL('".$reqSmpBukuBantu."',Q.KD_SUB_BANTU)
				  AND 		Q.KD_SUB_BANTU <> '00000'
				  UNION ALL
				  SELECT
								  A.KD_BUKU_BESAR 			KD_REKENING,
								  A.NM_BUKU_BESAR 			NM_REKENING,
								  D.KD_SUB_BANTU  			KD_KARTU,
								  E.NM_SUB_BANTU  			NM_KARTU,
								  C.TGL_POSTING	   			TGL_ENTRY,
								  D.NO_NOTA 				NO_BUKTI,  
								  C.NO_POSTING	   			NO_POSTING,
								  UPPER(C.KET_TAMBAH) || ' - ' || C.NM_AGEN_PERUSH	   		KET_TAMBAH,
								  NVL(D.SALDO_RP_DEBET,0) 	RP_DEBET,
								  NVL(D.SALDO_RP_KREDIT,0) 	RP_KREDIT
				  FROM		KBBR_BUKU_BESAR A,
								  KBBT_JUR_BB C,
								  KBBT_JUR_BB_D D,
								  KBBR_KARTU_TAMBAH E,
								  KBBR_GENERAL_REF_D F
				  WHERE   A.KD_BUKU_BESAR = D.KD_BUKU_BESAR
				  AND 		D.KD_SUB_BANTU = E.KD_SUB_BANTU(+)
				  AND 		D.NO_NOTA = C.NO_NOTA
				  AND 		C.THN_BUKU = ".$reqTahun."
				  AND 		C.BLN_BUKU = '".$reqBulan."'		
				  AND 		C.NO_POSTING IS NOT NULL
				  AND 		F.ID_REF_FILE   = 'URUT JURNAL'
				  AND 		F. ID_REF_DATA  = D.KD_JURNAL
				  AND 		D.KD_BUKU_BESAR >= NVL('".$reqDrKodeRekening."',D.KD_BUKU_BESAR)
				  AND 		D.KD_BUKU_BESAR <= NVL('".$reqSmpKodeRekening."',D.KD_BUKU_BESAR)  
				  AND         D.KD_SUB_BANTU  >= NVL('".$reqDrBukuBantu."',D.KD_SUB_BANTU)
				  AND         D.KD_SUB_BANTU  <= NVL('".$reqSmpBukuBantu."',D.KD_SUB_BANTU)
				  AND         D.KD_SUB_BANTU <> '00000'
				"; 
	
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }			
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KD_BUKU_BESAR) AS ROWCOUNT FROM KBBR_BUKU_BESAR
		        WHERE KD_BUKU_BESAR IS NOT NULL ".$statement; 
		
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