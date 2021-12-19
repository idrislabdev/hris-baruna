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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBT_NERACA_SALDO.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbtNeracaSaldo extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbtNeracaSaldo()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBT_NERACA_SALDO_ID", $this->getNextId("KBBT_NERACA_SALDO_ID","KBBT_NERACA_SALDO")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBT_NERACA_SALDO (
					   KD_CABANG, THN_BUKU, KD_BUKU_BESAR, 
					   KD_SUB_BANTU, KD_BUKU_PUSAT, KD_VALUTA, 
					   AWAL_DEBET, AWAL_KREDIT, P01_DEBET, 
					   P01_KREDIT, P02_DEBET, P02_KREDIT, 
					   P03_DEBET, P03_KREDIT, P04_DEBET, 
					   P04_KREDIT, P05_DEBET, P05_KREDIT, 
					   P06_DEBET, P06_KREDIT, P07_DEBET, 
					   P07_KREDIT, P08_DEBET, P08_KREDIT, 
					   P09_DEBET, P09_KREDIT, P10_DEBET, 
					   P10_KREDIT, P11_DEBET, P11_KREDIT, 
					   P12_DEBET, P12_KREDIT, P13_DEBET, 
					   P13_KREDIT, P14_DEBET, P14_KREDIT, 
					   STATUS_CLOSING, TGL_CLOSING, LAST_UPDATE_DATE, 
					   LAST_UPDATED_BY, PROGRAM_NAME, P15_DEBET, 
					   P15_KREDIT, P16_DEBET, P16_KREDIT, 
					   P17_DEBET, P17_KREDIT, P18_DEBET, 
					   P18_KREDIT) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("THN_BUKU")."', '".$this->getField("KD_BUKU_BESAR")."',
						'".$this->getField("KD_SUB_BANTU")."', '".$this->getField("KD_BUKU_PUSAT")."', '".$this->getField("KD_VALUTA")."', 
						'".$this->getField("AWAL_DEBET")."', '".$this->getField("AWAL_KREDIT")."', '".$this->getField("P01_DEBET")."',
						'".$this->getField("P01_KREDIT")."', '".$this->getField("P02_DEBET")."', '".$this->getField("P02_KREDIT")."', 
						'".$this->getField("P03_DEBET")."', '".$this->getField("P03_KREDIT")."', '".$this->getField("P04_DEBET")."',
						'".$this->getField("P04_KREDIT")."', '".$this->getField("P05_DEBET")."', '".$this->getField("P05_KREDIT")."', 
						'".$this->getField("P06_DEBET")."', '".$this->getField("P06_KREDIT")."', '".$this->getField("P07_DEBET")."',
						'".$this->getField("P07_KREDIT")."', '".$this->getField("P08_DEBET")."', '".$this->getField("P08_KREDIT")."', 
						'".$this->getField("P09_DEBET")."', '".$this->getField("P09_KREDIT")."', '".$this->getField("P10_DEBET")."',
						'".$this->getField("P10_KREDIT")."', '".$this->getField("P11_DEBET")."', '".$this->getField("P11_KREDIT")."', 
						'".$this->getField("P12_DEBET")."', '".$this->getField("P12_KREDIT")."', '".$this->getField("P13_DEBET")."',
						'".$this->getField("P13_KREDIT")."', '".$this->getField("P14_DEBET")."', '".$this->getField("P14_KREDIT")."', 
						'".$this->getField("STATUS_CLOSING")."', ".$this->getField("TGL_CLOSING").", ".$this->getField("LAST_UPDATE_DATE").",
						'".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."', '".$this->getField("P15_DEBET")."', 
						'".$this->getField("P15_KREDIT")."', '".$this->getField("P16_DEBET")."', '".$this->getField("P16_KREDIT")."',
						'".$this->getField("P17_DEBET")."', '".$this->getField("P17_KREDIT")."', '".$this->getField("P18_DEBET")."',
						'".$this->getField("P18_KREDIT")."'
				)";
				
		$this->id = $this->getField("KBBT_NERACA_SALDO_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBT_NERACA_SALDO
				SET    
					   KD_CABANG        = '".$this->getField("KD_CABANG")."',
					   THN_BUKU         = '".$this->getField("THN_BUKU")."',
					   KD_BUKU_BESAR    = '".$this->getField("KD_BUKU_BESAR")."',
					   KD_SUB_BANTU     = '".$this->getField("KD_SUB_BANTU")."',
					   KD_BUKU_PUSAT    = '".$this->getField("KD_BUKU_PUSAT")."',
					   KD_VALUTA        = '".$this->getField("KD_VALUTA")."',
					   AWAL_DEBET       = '".$this->getField("AWAL_DEBET")."',
					   AWAL_KREDIT      = '".$this->getField("AWAL_KREDIT")."',
					   P01_DEBET        = '".$this->getField("P01_DEBET")."',
					   P01_KREDIT       = '".$this->getField("P01_KREDIT")."',
					   P02_DEBET        = '".$this->getField("P02_DEBET")."',
					   P02_KREDIT       = '".$this->getField("P02_KREDIT")."',
					   P03_DEBET        = '".$this->getField("P03_DEBET")."',
					   P03_KREDIT       = '".$this->getField("P03_KREDIT")."',
					   P04_DEBET        = '".$this->getField("P04_DEBET")."',
					   P04_KREDIT       = '".$this->getField("P04_KREDIT")."',
					   P05_DEBET        = '".$this->getField("P05_DEBET")."',
					   P05_KREDIT       = '".$this->getField("P05_KREDIT")."',
					   P06_DEBET        = '".$this->getField("P06_DEBET")."',
					   P06_KREDIT       = '".$this->getField("P06_KREDIT")."',
					   P07_DEBET        = '".$this->getField("P07_DEBET")."',
					   P07_KREDIT       = '".$this->getField("P07_KREDIT")."',
					   P08_DEBET        = '".$this->getField("P08_DEBET")."',
					   P08_KREDIT       = '".$this->getField("P08_KREDIT")."',
					   P09_DEBET        = '".$this->getField("P09_DEBET")."',
					   P09_KREDIT       = '".$this->getField("P09_KREDIT")."',
					   P10_DEBET        = '".$this->getField("P10_DEBET")."',
					   P10_KREDIT       = '".$this->getField("P10_KREDIT")."',
					   P11_DEBET        = '".$this->getField("P11_DEBET")."',
					   P11_KREDIT       = '".$this->getField("P11_KREDIT")."',
					   P12_DEBET        = '".$this->getField("P12_DEBET")."',
					   P12_KREDIT       = '".$this->getField("P12_KREDIT")."',
					   P13_DEBET        = '".$this->getField("P13_DEBET")."',
					   P13_KREDIT       = '".$this->getField("P13_KREDIT")."',
					   P14_DEBET        = '".$this->getField("P14_DEBET")."',
					   P14_KREDIT       = '".$this->getField("P14_KREDIT")."',
					   STATUS_CLOSING   = '".$this->getField("STATUS_CLOSING")."',
					   TGL_CLOSING      = ".$this->getField("TGL_CLOSING").",
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."',
					   P15_DEBET        = '".$this->getField("P15_DEBET")."',
					   P15_KREDIT       = '".$this->getField("P15_KREDIT")."',
					   P16_DEBET        = '".$this->getField("P16_DEBET")."',
					   P16_KREDIT       = '".$this->getField("P16_KREDIT")."',
					   P17_DEBET        = '".$this->getField("P17_DEBET")."',
					   P17_KREDIT       = '".$this->getField("P17_KREDIT")."',
					   P18_DEBET        = '".$this->getField("P18_DEBET")."',
					   P18_KREDIT       = '".$this->getField("P18_KREDIT")."'
				WHERE  KBBT_NERACA_SALDO_ID = '".$this->getField("KBBT_NERACA_SALDO_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateBatalProses()
	{
		$str = "
				UPDATE KBBT_NERACA_SALDO
				SET    
					   AWAL_DEBET       = 0,
					   AWAL_KREDIT      = 0
				WHERE  THN_BUKU = '".$this->getField("THN_BUKU")."'
			";
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "DELETE FROM KBBT_NERACA_SALDO
                WHERE 
                  KBBT_NERACA_SALDO_ID = ".$this->getField("KBBT_NERACA_SALDO_ID").""; 
				  
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
				SELECT KD_CABANG, THN_BUKU, KD_BUKU_BESAR, 
				KD_SUB_BANTU, KD_BUKU_PUSAT, KD_VALUTA, 
				AWAL_DEBET, AWAL_KREDIT, P01_DEBET, 
				P01_KREDIT, P02_DEBET, P02_KREDIT, 
				P03_DEBET, P03_KREDIT, P04_DEBET, 
				P04_KREDIT, P05_DEBET, P05_KREDIT, 
				P06_DEBET, P06_KREDIT, P07_DEBET, 
				P07_KREDIT, P08_DEBET, P08_KREDIT, 
				P09_DEBET, P09_KREDIT, P10_DEBET, 
				P10_KREDIT, P11_DEBET, P11_KREDIT, 
				P12_DEBET, P12_KREDIT, P13_DEBET, 
				P13_KREDIT, P14_DEBET, P14_KREDIT, 
				STATUS_CLOSING, TGL_CLOSING, LAST_UPDATE_DATE, 
				LAST_UPDATED_BY, PROGRAM_NAME, P15_DEBET, 
				P15_KREDIT, P16_DEBET, P16_KREDIT, 
				P17_DEBET, P17_KREDIT, P18_DEBET, 
				P18_KREDIT
				FROM KBBT_NERACA_SALDO
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KBBT_NERACA_SALDO_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsMonitoringTransaksiTahunan($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT TGL_TRANS, NO_REF1, FAKTUR_PAJAK_PREFIX || '.' || FAKTUR_PAJAK NO_FAKTUR_PAJAK, NO_NOTA, KD_KUSTO, B.MPLG_NAMA, A.KET_TAMBAHAN, KD_VALUTA, TRIM(TO_CHAR(JML_TAGIHAN, '999,999,999,999.99')) JML_TAGIHAN,
				AMBIL_PELUNASAN_NOTA(NO_NOTA, 'TGL_TRANS') TGL_PELUNASAN, AMBIL_PELUNASAN_NOTA(NO_NOTA, 'NO_NOTA') NOTA_PELUNASAN, 
				AMBIL_PELUNASAN_NOTA(NO_NOTA, 'JML_VAL_TRANS') JUMLAH_PELUNASAN, 
				AMBIL_PELUNASAN_NOTA(NO_NOTA, 'NO_POSTING') NO_POSTING 
				FROM KPTT_NOTA A 
				INNER JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TGL_TRANS ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsSaldoPiutangNeracaIDR($paramsArray=array(),$limit=-1,$from=-1, $statement="", $tahun_bulan="")
	{
		$str = "
        SELECT XX.BADAN_USAHA, XX.KARTU, XX.NAMA, XX.SALDO_NERACA, XX.SALDO_KARTU, XX.SELISIH
           FROM
           (
                    SELECT AA.KD_BUKU_BESAR,DECODE(AA.KD_BUKU_BESAR,'104.01.00','01 - A B R I',
                                                                  '104.02.00','02 - PEMERINTAH',
                                                                                '104.03.00','03 - B U M N',
                                                                               '104.04.00','04 - SWASTA',
                                                                               '104.05.00','05 - PERORANGAN') BADAN_USAHA, 
                             AA.KARTU, AA.NAMA, AA.SALDO_AKHIR SALDO_NERACA, BB.SALDO_AKHIR SALDO_KARTU,
                           AA.SALDO_AKHIR-BB.SALDO_AKHIR SELISIH  
                      FROM
                      (
                    SELECT X.KD_BUKU_BESAR, X.KARTU, X.NAMA, ((X.SALDO_AWAL)+X.MUT_DEBET-X.MUT_KREDIT) SALDO_AKHIR
                      FROM
                      (
                    SELECT KD_SUB_BANTU KARTU, B.MPLG_NAMA NAMA, A.KD_BUKU_BESAR, 
                           DECODE(SUBSTR('". $tahun_bulan."',5,2),
                           '01',SUM(AWAL_DEBET-AWAL_KREDIT),
                           '02',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT),
                           '03',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT),
                           '04',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT),
                           '05',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT),
                           '06',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT),
                           '07',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT),
                           '08',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT),
                           '09',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT),
                           '10',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT),
                           '11',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT),
                           '12',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT+P11_DEBET-P11_KREDIT),
                           '13',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT+P11_DEBET-P11_KREDIT+P12_DEBET-P12_KREDIT),
                           '14',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT+P11_DEBET-P11_KREDIT+P12_DEBET-P12_KREDIT+P13_DEBET-P13_KREDIT)) SALDO_AWAL,
                           DECODE(SUBSTR('". $tahun_bulan."',5,2),
                           '01',SUM(P01_DEBET),'02',SUM(P02_DEBET),'03',SUM(P03_DEBET),'04',SUM(P04_DEBET),'05',SUM(P05_DEBET),'06',SUM(P06_DEBET),    '07',SUM(P07_DEBET), '08',SUM(P08_DEBET), '09',SUM(P09_DEBET), '10',SUM(P10_DEBET),'11',SUM(P11_DEBET), '12',SUM(P12_DEBET), '13',SUM(P13_DEBET), '14',SUM(P14_DEBET)) MUT_DEBET,
                           DECODE(SUBSTR('". $tahun_bulan."',5,2),
                           '01',SUM(P01_KREDIT),'02',SUM(P02_KREDIT),'03',SUM(P03_KREDIT),'04',SUM(P04_KREDIT),'05',SUM(P05_KREDIT),'06',SUM(P06_KREDIT),    '07',SUM(P07_KREDIT), '08',SUM(P08_KREDIT), '09',SUM(P09_KREDIT), '10',SUM(P10_KREDIT),'11',SUM(P11_KREDIT), '12',SUM(P12_KREDIT), '13',SUM(P13_KREDIT), '14',SUM(P14_KREDIT)) MUT_KREDIT
                      FROM KBBT_NERACA_SALDO A, 
                             SAFM_PELANGGAN B
                     WHERE KD_SUB_BANTU = B.MPLG_KODE(+)
                       AND THN_BUKU     = SUBSTR('". $tahun_bulan."',1,4)
                       AND KD_VALUTA    = 'IDR'
                       AND KD_BUKU_BESAR BETWEEN '104.01.00' AND '104.05.00' 
                    GROUP BY KD_SUB_BANTU, B.MPLG_NAMA, A.KD_BUKU_BESAR ) X   
                    WHERE (X.SALDO_AWAL)+X.MUT_DEBET-X.MUT_KREDIT <> 0) AA,
                    (
                    SELECT A.KD_BB_KUSTO, A.KD_KUSTO KARTU, B.MPLG_NAMA NAMA, SUM(JML_SALDO_AKHIR) SALDO_AKHIR 
                      FROM KPTT_NOTA_LAP A,
                             SAFM_PELANGGAN B
                     WHERE A.BULTAH   = '". $tahun_bulan."'
                       AND ( A.FLAG_PUPN IS NULL OR A.FLAG_PUPN = 'K' )  
                       AND A.KD_KUSTO = B.MPLG_KODE(+)
                       AND A.KD_VALUTA = 'IDR'
                       AND A.KD_BB_KUSTO BETWEEN '104.01.00' AND '104.05.00'
                       AND A.JML_SALDO_AKHIR <> 0
                    GROUP BY A.KD_BB_KUSTO, A.KD_KUSTO, B.MPLG_NAMA
                    ) BB
                    WHERE AA.KD_BUKU_BESAR = BB.KD_BB_KUSTO(+)
                      AND AA.KARTU         = BB.KARTU(+)) XX
					  WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
                      ORDER BY XX.KD_BUKU_BESAR, XX.KARTU ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsSaldoPiutangNeracaUSD($paramsArray=array(),$limit=-1,$from=-1, $statement="", $tahun_bulan="")
	{
		$str = "
        SELECT XX.BADAN_USAHA, XX.KARTU, XX.NAMA, XX.SALDO_NERACA, XX.SALDO_KARTU, XX.SELISIH
           FROM
           (
					SELECT AA.KD_BUKU_BESAR,DECODE(AA.KD_BUKU_BESAR,'104.21.00','06 - A B R I',
						   						               '104.22.00','07 - PEMERINTAH',
												   							 '104.23.00','08 - B U M N',
																			   '104.24.00','09 - SWASTA',
																			   '104.25.00','10 - PERORANGAN') BADAN_USAHA, 
							 AA.KARTU, AA.NAMA, AA.SALDO_AKHIR SALDO_NERACA, BB.SALDO_AKHIR SALDO_KARTU,
						   AA.SALDO_AKHIR-BB.SALDO_AKHIR SELISIH  
					  FROM
					  (
					SELECT X.KD_BUKU_BESAR, X.KARTU, X.NAMA, ((X.SALDO_AWAL)+X.MUT_DEBET-X.MUT_KREDIT) SALDO_AKHIR
					  FROM
					  (
					SELECT KD_SUB_BANTU KARTU, B.MPLG_NAMA NAMA, A.KD_BUKU_BESAR, 
						   DECODE(SUBSTR('".$tahun_bulan."',5,2),
						   '01',SUM(AWAL_DEBET-AWAL_KREDIT),
						   '02',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT),
						   '03',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT),
						   '04',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT),
						   '05',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT),
						   '06',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT),
						   '07',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT),
						   '08',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT),
						   '09',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT),
						   '10',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT),
						   '11',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT),
						   '12',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT+P11_DEBET-P11_KREDIT),
						   '13',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT+P11_DEBET-P11_KREDIT+P12_DEBET-P12_KREDIT),
						   '14',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT+P11_DEBET-P11_KREDIT+P12_DEBET-P12_KREDIT+P13_DEBET-P13_KREDIT)) SALDO_AWAL,
						   DECODE(SUBSTR('".$tahun_bulan."',5,2),
						   '01',SUM(P01_DEBET),'02',SUM(P02_DEBET),'03',SUM(P03_DEBET),'04',SUM(P04_DEBET),'05',SUM(P05_DEBET),'06',SUM(P06_DEBET),	'07',SUM(P07_DEBET), '08',SUM(P08_DEBET), '09',SUM(P09_DEBET), '10',SUM(P10_DEBET),'11',SUM(P11_DEBET), '12',SUM(P12_DEBET), '13',SUM(P13_DEBET), '14',SUM(P14_DEBET)) MUT_DEBET,
						   DECODE(SUBSTR('".$tahun_bulan."',5,2),
						   '01',SUM(P01_KREDIT),'02',SUM(P02_KREDIT),'03',SUM(P03_KREDIT),'04',SUM(P04_KREDIT),'05',SUM(P05_KREDIT),'06',SUM(P06_KREDIT),	'07',SUM(P07_KREDIT), '08',SUM(P08_KREDIT), '09',SUM(P09_KREDIT), '10',SUM(P10_KREDIT),'11',SUM(P11_KREDIT), '12',SUM(P12_KREDIT), '13',SUM(P13_KREDIT), '14',SUM(P14_KREDIT)) MUT_KREDIT
					  FROM KBBT_NERACA_SALDO A, 
					  	   SAFM_PELANGGAN B
					 WHERE KD_SUB_BANTU = B.MPLG_KODE(+)
					   AND THN_BUKU     = SUBSTR('".$tahun_bulan."',1,4)
					   AND KD_VALUTA    = 'USD'
					   AND KD_BUKU_BESAR BETWEEN '104.20.00' AND '104.99.00'
					GROUP BY KD_SUB_BANTU, B.MPLG_NAMA, A.KD_BUKU_BESAR ) X   
					WHERE (X.SALDO_AWAL)+X.MUT_DEBET-X.MUT_KREDIT <> 0) AA,
					(
					SELECT A.KD_BB_KUSTO, A.KD_KUSTO KARTU, B.MPLG_NAMA NAMA, SUM(JML_SALDO_AKHIR) SALDO_AKHIR 
					  FROM KPTT_NOTA_LAP A,
					  	   SAFM_PELANGGAN B
					 WHERE A.BULTAH   = '".$tahun_bulan."'
					   AND ( A.FLAG_PUPN IS NULL OR A.FLAG_PUPN = 'K' )  
					   AND A.KD_KUSTO = B.MPLG_KODE(+)
					   AND A.KD_VALUTA = 'USD'
					   AND A.KD_BB_KUSTO BETWEEN '104.20.00' AND '104.99.00'
					   AND A.JML_SALDO_AKHIR <> 0
					GROUP BY A.KD_BB_KUSTO, A.KD_KUSTO, B.MPLG_NAMA
					) BB
					WHERE AA.KD_BUKU_BESAR = BB.KD_BB_KUSTO(+)
					  AND AA.KARTU         = BB.KARTU(+)) XX
					WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
                       ORDER BY XX.KD_BUKU_BESAR, XX.KARTU ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsSaldoNeracaBantu($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqKodeValuta="", $reqPeriode="")
	{
		$str = "
				      SELECT Z.MPLG_KODE KD_KUSTO, Z.MPLG_NAMA NAMA, NVL(X.SALDO,0) NERACA
							 , NVL(Y.SALDO_AKHIR,0) KARTU, NVL(X.SALDO,0)-NVL(Y.SALDO_AKHIR,0) SELISIH
					  FROM (
						SELECT A.KD_KUSTO, A.NAMA, A.SALDO SALDO
						  FROM (
							SELECT A.KD_SUB_BANTU KD_KUSTO, C.MPLG_NAMA NAMA, DECODE(SUBSTR('".$reqPeriode."',5,6),'01', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)),
								   '02', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)),
								   '03', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)),
								   '04', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)),
								   '05', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)),
								   '06', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)),
								   '07', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)+NVL(P07_DEBET,0)-NVL(P07_KREDIT,0)),
								   '08', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)+NVL(P07_DEBET,0)-NVL(P07_KREDIT,0)+NVL(P08_DEBET,0)-NVL(P08_KREDIT,0)),
								   '09', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)+NVL(P07_DEBET,0)-NVL(P07_KREDIT,0)+NVL(P08_DEBET,0)-NVL(P08_KREDIT,0)+NVL(P09_DEBET,0)-NVL(P09_KREDIT,0)),
								   '10', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)+NVL(P07_DEBET,0)-NVL(P07_KREDIT,0)+NVL(P08_DEBET,0)-NVL(P08_KREDIT,0)+NVL(P09_DEBET,0)-NVL(P09_KREDIT,0)+NVL(P10_DEBET,0)-NVL(P10_KREDIT,0)),
								   '11', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)+NVL(P07_DEBET,0)-NVL(P07_KREDIT,0)+NVL(P08_DEBET,0)-NVL(P08_KREDIT,0)+NVL(P09_DEBET,0)-NVL(P09_KREDIT,0)+NVL(P10_DEBET,0)-NVL(P10_KREDIT,0)+NVL(P11_DEBET,0)-NVL(P11_KREDIT,0)),
								   '12', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)+NVL(P07_DEBET,0)-NVL(P07_KREDIT,0)+NVL(P08_DEBET,0)-NVL(P08_KREDIT,0)+NVL(P09_DEBET,0)-NVL(P09_KREDIT,0)+NVL(P10_DEBET,0)-NVL(P10_KREDIT,0)+NVL(P11_DEBET,0)-NVL(P11_KREDIT,0)+NVL(P12_DEBET,0)-NVL(P12_KREDIT,0))) SALDO  
							  FROM KBBT_NERACA_SALDO A, KBBR_BUKU_BESAR B, SAFM_PELANGGAN C
							 WHERE A.KD_BUKU_BESAR = B.KD_BUKU_BESAR
							   AND DECODE('".$reqKodeValuta."','IDR',B.KODE_VALUTA,A.KD_VALUTA) = '".$reqKodeValuta."'
							   AND A.KD_BUKU_BESAR 
								   BETWEEN DECODE('".$reqKodeValuta."','IDR',(SELECT MIN(COA1) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = '1'), (SELECT MIN(COA2) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = '1'))
											AND DECODE('".$reqKodeValuta."','IDR',(SELECT MAX(COA1) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = '1'), (SELECT MAX(COA2) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = '1'))
							   AND A.THN_BUKU       = SUBSTR('".$reqPeriode."',1,4)
							   AND A.KD_SUB_BANTU  = C.MPLG_KODE(+)
							   AND A.KD_SUB_BANTU  <> '00000'
							GROUP BY A.KD_SUB_BANTU, C.MPLG_NAMA ) A ) X,
						  (     
						SELECT A.KD_KUSTO, B.MPLG_NAMA, NVL(SUM(NVL(A.JML_SALDO_AKHIR,0)),0) SALDO_AKHIR
						  FROM KPTT_NOTA_LAP A, SAFM_PELANGGAN B
						 WHERE A.KD_KUSTO   = B.MPLG_KODE(+)
						   AND A.BULTAH     = '".$reqPeriode."'
						   AND A.KD_VALUTA  = '".$reqKodeValuta."'
						   AND ( A.FLAG_PUPN IS NULL OR A.FLAG_PUPN = 'K' )
						   AND ( A.JML_SALDO_AWAL  <>  0  OR  A.JML_DEBET <>  0  OR  A.JML_KREDIT <>  0  OR  A.JML_SALDO_AKHIR  <>  0  )
						GROUP BY A.KD_KUSTO, B.MPLG_NAMA ) Y,
						SAFM_PELANGGAN Z
					  WHERE X.KD_KUSTO(+) = Z.MPLG_KODE
						AND Y.KD_KUSTO(+) = Z.MPLG_KODE
						AND ( X.SALDO <> 0 OR NVL(Y.SALDO_AKHIR,0) <> 0)
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
						ORDER BY  Z.MPLG_KODE    ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsSaldoNeracaBantuRincian($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT NO_NOTA, NO_REF3, TGL_TRANS, JML_SALDO_AKHIR
					  FROM KPTT_NOTA_LAP
					 WHERE 1 = 1
					   AND ( FLAG_PUPN IS NULL OR FLAG_PUPN = 'K' )
					   AND JML_SALDO_AKHIR <> 0
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TGL_TRANS";
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMonitoringKasBankKasirDenganNeraca($paramsArray=array(),$limit=-1,$from=-1, $statement="", $bulan="", $tahun="", $valuta="")
	{
		$str = "
			SELECT AA.KD_BUKU_BESAR, AA.KD_SUB_BANTU, NVL(BB.DEBET_KASIR,0) DEBET_KASIR, NVL(AA.DEBET_NERACA,0) DEBET_NERACA, 
				   NVL(AA.DEBET_NERACA,0)-NVL(BB.DEBET_KASIR,0) SELISIH_D,
				   NVL(BB.KREDIT_KASIR,0) KREDIT_KASIR, NVL(AA.KREDIT_NERACA,0) KREDIT_NERACA, NVL(AA.KREDIT_NERACA,0)-NVL(BB.KREDIT_KASIR,0) SELISIH_K
			  FROM
				(
				SELECT B.KD_BUKU_BESAR, B.KD_SUB_BANTU, SUM(B.SALDO_VAL_DEBET) DEBET_NERACA, SUM(B.SALDO_VAL_KREDIT) KREDIT_NERACA
				  FROM KBBT_JUR_BB A,
				  	   KBBT_JUR_BB_D B
				 WHERE A.NO_NOTA = B.NO_NOTA
				   AND A.JEN_JURNAL IN ('JKM','JKK')
				   AND A.BLN_BUKU  = '".$bulan."'
				   AND A.THN_BUKU  = ".$tahun."
				   AND A.KD_VALUTA = '".$valuta."'
				   AND A.NO_POSTING IS NOT NULL
                   AND B.KD_BUKU_BESAR LIKE '101%'       
                GROUP BY B.KD_BUKU_BESAR, B.KD_SUB_BANTU    
                ) AA,
                (
                SELECT B.KD_BUKU_BESAR, B.KD_SUB_BANTU, SUM(B.SALDO_VAL_DEBET) DEBET_KASIR, SUM(B.SALDO_VAL_KREDIT) KREDIT_KASIR
                  FROM PERBENDAHARAAN.KBBT_JUR_BB_KASIR A,
                         PERBENDAHARAAN.KBBT_JUR_BB_KASIR_D B
                 WHERE A.NO_NOTA = B.NO_NOTA
                   AND A.JEN_JURNAL IN ('JKM','JKK')
                   AND A.BLN_BUKU  = '".$bulan."'
                   AND A.THN_BUKU  = ".$tahun."
                   AND A.KD_VALUTA = '".$valuta."'
                   AND A.NO_POSTING IS NOT NULL
                   AND B.KD_BUKU_BESAR LIKE '101%'       
                GROUP BY B.KD_BUKU_BESAR, B.KD_SUB_BANTU
                ) BB    
              WHERE AA.KD_BUKU_BESAR = BB.KD_BUKU_BESAR(+)
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY AA.KD_BUKU_BESAR";
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
													
    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_BUKU_BESAR, A.KD_SUB_BANTU, NM_SUB_BANTU, KD_BUKU_PUSAT
				FROM KBBT_NERACA_SALDO A
                LEFT JOIN KBBR_KARTU_TAMBAH B ON A.KD_SUB_BANTU = B.KD_SUB_BANTU
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY KD_BUKU_BESAR, A.KD_SUB_BANTU, NM_SUB_BANTU, KD_BUKU_PUSAT ORDER BY KD_BUKU_BESAR ASC ";
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsLihatDebet($bulan, $tahun, $bb, $bt, $valuta)
	{
		$str = "
				SELECT DISTINCT A.NO_NOTA,A.JEN_JURNAL,A.TGL_TRANS,
											DECODE('".$valuta."','IDR',SUM(B.SALDO_RP_DEBET),SUM(B.SALDO_VAL_DEBET)) JML_VAL_TRANS 
											FROM   KBBT_JUR_BB A , KBBT_JUR_BB_D B
											WHERE  A.BLN_BUKU = '".$bulan."'
											AND		 A.THN_BUKU 	= ".$tahun."
											AND    A.KD_VALUTA      = decode('".$valuta."', 'IDR', A.KD_VALUTA, '".$valuta."')
											AND		 A.NO_POSTING     IS NOT NULL
											AND    A.NO_NOTA  	    = B.NO_NOTA
											AND    B.KD_BUKU_BESAR  = '".$bb."'
											AND    B.KD_SUB_BANTU   = '".$bt."'
											AND    B.SALDO_RP_DEBET > 0
											GROUP BY A.NO_NOTA,A.JEN_JURNAL,A.TGL_TRANS
				"; 
		
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsLihatKredit($bulan, $tahun, $bb, $bt, $valuta)
	{
		$str = "
				SELECT DISTINCT A.NO_NOTA,A.JEN_JURNAL,A.TGL_TRANS,
											DECODE('".$valuta."','IDR',SUM(B.SALDO_RP_KREDIT),SUM(B.SALDO_VAL_KREDIT)) JML_VAL_TRANS 
											FROM   KBBT_JUR_BB A , KBBT_JUR_BB_D B
											WHERE  A.BLN_BUKU = '".$bulan."'
											AND		 A.THN_BUKU 		  = ".$tahun."
											AND    A.KD_VALUTA      = decode('".$valuta."', 'IDR', A.KD_VALUTA, '".$valuta."')
											AND		 A.NO_POSTING     IS NOT NULL
											AND    A.NO_NOTA  	    = B.NO_NOTA
											AND    B.KD_BUKU_BESAR  = '".$bb."'
											AND    B.KD_SUB_BANTU   = '".$bt."'
											AND    B.SALDO_RP_KREDIT > 0
											GROUP BY A.NO_NOTA,A.JEN_JURNAL,A.TGL_TRANS
				"; 
		
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }
		
    function selectByParamsDetil($tahun="", $kd_valuta="NULL", $kd_buku_besar="NULL", $kd_sub_bantu="NULL")
	{
		$str = "
				  SELECT PERIODE, ROUND(DEBET, 2) DEBET, ROUND(KREDIT, 2) KREDIT, BULAN, DEBET - KREDIT SALDO_AKHIR FROM (
				  SELECT '00' PERIODE, 'SALDO AWAL' BULAN,SUM(AWAL_DEBET) DEBET,SUM(AWAL_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)        
				  UNION ALL
				  SELECT '01' PERIODE, 'JULI' BULAN,SUM(P01_DEBET) DEBET,SUM(P01_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)    
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)        
				  UNION ALL
				  SELECT '02' PERIODE, 'AGUSTUS' BULAN,SUM(P02_DEBET) DEBET,SUM(P02_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)            
				  UNION ALL
				  SELECT '03' PERIODE, 'SEPTEMBER' BULAN,SUM(P03_DEBET) DEBET,SUM(P03_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)            
				  UNION ALL
				  SELECT '04' PERIODE, 'OKTOBER' BULAN,SUM(P04_DEBET) DEBET,SUM(P04_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)            
				  UNION ALL
				  SELECT '05' PERIODE, 'NOVEMBER' BULAN,SUM(P05_DEBET) DEBET,SUM(P05_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)            
				  UNION ALL
				  SELECT '06' PERIODE, 'DESEMBER' BULAN,SUM(P06_DEBET) DEBET,SUM(P06_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)            
				  UNION ALL
				  SELECT '07' PERIODE, 'JANUARI' BULAN,SUM(P07_DEBET) DEBET,SUM(P07_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)            
				  UNION ALL
				  SELECT '08' PERIODE, 'FEBRUARI' BULAN,SUM(P08_DEBET) DEBET,SUM(P08_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)            
				  UNION ALL
				  SELECT '09' PERIODE, 'MARET' BULAN,SUM(P09_DEBET) DEBET,SUM(P09_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)            
				  UNION ALL
				  SELECT '10' PERIODE, 'APRIL' BULAN,SUM(P10_DEBET) DEBET,SUM(P10_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)            
				  UNION ALL
				  SELECT '11' PERIODE, 'MEI' BULAN,SUM(P11_DEBET) DEBET,SUM(P11_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)            
				  UNION ALL
				  SELECT '12' PERIODE, 'JUNI' BULAN,SUM(P12_DEBET) DEBET,SUM(P12_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)            
				  UNION ALL
				  SELECT '13' PERIODE, 'JUNI AJP' BULAN,SUM(P13_DEBET) DEBET,SUM(P13_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU)            
				  UNION ALL
				  SELECT '14' PERIODE, 'JUNI AJT' BULAN,SUM(P14_DEBET) DEBET,SUM(P14_KREDIT) KREDIT
				  FROM   KBBT_NERACA_SALDO
				  WHERE  THN_BUKU  = NVL(".$tahun.",THN_BUKU)
				  AND       KD_VALUTA = NVL('".$kd_valuta."',KD_VALUTA)
				  AND         KD_BUKU_BESAR = NVL('".$kd_buku_besar."',KD_BUKU_BESAR)
				  AND         KD_SUB_BANTU = NVL('".$kd_sub_bantu."',KD_SUB_BANTU))
				"; 
		
		$str .= $statement;
		$this->query = $str;
		return $this->selectLimit($str, -1, -1); 
    }	
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, THN_BUKU, KD_BUKU_BESAR, 
				KD_SUB_BANTU, KD_BUKU_PUSAT, KD_VALUTA, 
				AWAL_DEBET, AWAL_KREDIT, P01_DEBET, 
				P01_KREDIT, P02_DEBET, P02_KREDIT, 
				P03_DEBET, P03_KREDIT, P04_DEBET, 
				P04_KREDIT, P05_DEBET, P05_KREDIT, 
				P06_DEBET, P06_KREDIT, P07_DEBET, 
				P07_KREDIT, P08_DEBET, P08_KREDIT, 
				P09_DEBET, P09_KREDIT, P10_DEBET, 
				P10_KREDIT, P11_DEBET, P11_KREDIT, 
				P12_DEBET, P12_KREDIT, P13_DEBET, 
				P13_KREDIT, P14_DEBET, P14_KREDIT, 
				STATUS_CLOSING, TGL_CLOSING, LAST_UPDATE_DATE, 
				LAST_UPDATED_BY, PROGRAM_NAME, P15_DEBET, 
				P15_KREDIT, P16_DEBET, P16_KREDIT, 
				P17_DEBET, P17_KREDIT, P18_DEBET, 
				P18_KREDIT
				FROM KBBT_NERACA_SALDO
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
		$str = "SELECT COUNT(KD_BUKU_BESAR) AS ROWCOUNT FROM KBBT_NERACA_SALDO
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

    function getCountByParamsSaldoPiutangNeracaUSD($paramsArray=array(), $statement="", $tahun_bulan="")
	{
		$str = "   SELECT COUNT(BADAN_USAHA) ROWCOUNT FROM (     
        SELECT XX.BADAN_USAHA, XX.KARTU, XX.NAMA, XX.SALDO_NERACA, XX.SALDO_KARTU, XX.SELISIH
           FROM
           (
					SELECT AA.KD_BUKU_BESAR,DECODE(AA.KD_BUKU_BESAR,'104.21.00','06 - A B R I',
						   						               '104.22.00','07 - PEMERINTAH',
												   							 '104.23.00','08 - B U M N',
																			   '104.24.00','09 - SWASTA',
																			   '104.25.00','10 - PERORANGAN') BADAN_USAHA, 
							 AA.KARTU, AA.NAMA, AA.SALDO_AKHIR SALDO_NERACA, BB.SALDO_AKHIR SALDO_KARTU,
						   AA.SALDO_AKHIR-BB.SALDO_AKHIR SELISIH  
					  FROM
					  (
					SELECT X.KD_BUKU_BESAR, X.KARTU, X.NAMA, ((X.SALDO_AWAL)+X.MUT_DEBET-X.MUT_KREDIT) SALDO_AKHIR
					  FROM
					  (
					SELECT KD_SUB_BANTU KARTU, B.MPLG_NAMA NAMA, A.KD_BUKU_BESAR, 
						   DECODE(SUBSTR('".$tahun_bulan."',5,2),
						   '01',SUM(AWAL_DEBET-AWAL_KREDIT),
						   '02',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT),
						   '03',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT),
						   '04',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT),
						   '05',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT),
						   '06',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT),
						   '07',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT),
						   '08',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT),
						   '09',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT),
						   '10',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT),
						   '11',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT),
						   '12',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT+P11_DEBET-P11_KREDIT),
						   '13',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT+P11_DEBET-P11_KREDIT+P12_DEBET-P12_KREDIT),
						   '14',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT+P11_DEBET-P11_KREDIT+P12_DEBET-P12_KREDIT+P13_DEBET-P13_KREDIT)) SALDO_AWAL,
						   DECODE(SUBSTR('".$tahun_bulan."',5,2),
						   '01',SUM(P01_DEBET),'02',SUM(P02_DEBET),'03',SUM(P03_DEBET),'04',SUM(P04_DEBET),'05',SUM(P05_DEBET),'06',SUM(P06_DEBET),	'07',SUM(P07_DEBET), '08',SUM(P08_DEBET), '09',SUM(P09_DEBET), '10',SUM(P10_DEBET),'11',SUM(P11_DEBET), '12',SUM(P12_DEBET), '13',SUM(P13_DEBET), '14',SUM(P14_DEBET)) MUT_DEBET,
						   DECODE(SUBSTR('".$tahun_bulan."',5,2),
						   '01',SUM(P01_KREDIT),'02',SUM(P02_KREDIT),'03',SUM(P03_KREDIT),'04',SUM(P04_KREDIT),'05',SUM(P05_KREDIT),'06',SUM(P06_KREDIT),	'07',SUM(P07_KREDIT), '08',SUM(P08_KREDIT), '09',SUM(P09_KREDIT), '10',SUM(P10_KREDIT),'11',SUM(P11_KREDIT), '12',SUM(P12_KREDIT), '13',SUM(P13_KREDIT), '14',SUM(P14_KREDIT)) MUT_KREDIT
					  FROM KBBT_NERACA_SALDO A, 
					  	   SAFM_PELANGGAN B
					 WHERE KD_SUB_BANTU = B.MPLG_KODE(+)
					   AND THN_BUKU     = SUBSTR('".$tahun_bulan."',1,4)
					   AND KD_VALUTA    = 'USD'
					   AND KD_BUKU_BESAR BETWEEN '104.20.00' AND '104.99.00'
					GROUP BY KD_SUB_BANTU, B.MPLG_NAMA, A.KD_BUKU_BESAR ) X   
					WHERE (X.SALDO_AWAL)+X.MUT_DEBET-X.MUT_KREDIT <> 0) AA,
					(
					SELECT A.KD_BB_KUSTO, A.KD_KUSTO KARTU, B.MPLG_NAMA NAMA, SUM(JML_SALDO_AKHIR) SALDO_AKHIR 
					  FROM KPTT_NOTA_LAP A,
					  	   SAFM_PELANGGAN B
					 WHERE A.BULTAH   = '".$tahun_bulan."'
					   AND ( A.FLAG_PUPN IS NULL OR A.FLAG_PUPN = 'K' )  
					   AND A.KD_KUSTO = B.MPLG_KODE(+)
					   AND A.KD_VALUTA = 'USD'
					   AND A.KD_BB_KUSTO BETWEEN '104.20.00' AND '104.99.00'
					   AND A.JML_SALDO_AKHIR <> 0
					GROUP BY A.KD_BB_KUSTO, A.KD_KUSTO, B.MPLG_NAMA
					) BB
					WHERE AA.KD_BUKU_BESAR = BB.KD_BB_KUSTO(+)
					  AND AA.KARTU         = BB.KARTU(+)) XX
					WHERE 1 = 1
					 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= " ) A ";
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsSaldoPiutangNeracaIDR($paramsArray=array(), $statement="", $tahun_bulan="")
	{
		$str = "   SELECT COUNT(BADAN_USAHA) ROWCOUNT FROM (     
		SELECT XX.BADAN_USAHA, XX.KARTU, XX.NAMA, XX.SALDO_NERACA, XX.SALDO_KARTU, XX.SELISIH
           FROM
           (
                    SELECT AA.KD_BUKU_BESAR,DECODE(AA.KD_BUKU_BESAR,'104.01.00','01 - A B R I',
                                                                  '104.02.00','02 - PEMERINTAH',
                                                                                '104.03.00','03 - B U M N',
                                                                               '104.04.00','04 - SWASTA',
                                                                               '104.05.00','05 - PERORANGAN') BADAN_USAHA, 
                             AA.KARTU, AA.NAMA, AA.SALDO_AKHIR SALDO_NERACA, BB.SALDO_AKHIR SALDO_KARTU,
                           AA.SALDO_AKHIR-BB.SALDO_AKHIR SELISIH  
                      FROM
                      (
                    SELECT X.KD_BUKU_BESAR, X.KARTU, X.NAMA, ((X.SALDO_AWAL)+X.MUT_DEBET-X.MUT_KREDIT) SALDO_AKHIR
                      FROM
                      (
                    SELECT KD_SUB_BANTU KARTU, B.MPLG_NAMA NAMA, A.KD_BUKU_BESAR, 
                           DECODE(SUBSTR('". $tahun_bulan."',5,2),
                           '01',SUM(AWAL_DEBET-AWAL_KREDIT),
                           '02',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT),
                           '03',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT),
                           '04',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT),
                           '05',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT),
                           '06',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT),
                           '07',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT),
                           '08',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT),
                           '09',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT),
                           '10',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT),
                           '11',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT),
                           '12',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT+P11_DEBET-P11_KREDIT),
                           '13',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT+P11_DEBET-P11_KREDIT+P12_DEBET-P12_KREDIT),
                           '14',SUM(AWAL_DEBET-AWAL_KREDIT+P01_DEBET-P01_KREDIT+P02_DEBET-P02_KREDIT+P03_DEBET-P03_KREDIT+P04_DEBET-P04_KREDIT+P05_DEBET-P05_KREDIT+P06_DEBET-P06_KREDIT+P07_DEBET-P07_KREDIT+P08_DEBET-P08_KREDIT+P09_DEBET-P09_KREDIT+P10_DEBET-P10_KREDIT+P11_DEBET-P11_KREDIT+P12_DEBET-P12_KREDIT+P13_DEBET-P13_KREDIT)) SALDO_AWAL,
                           DECODE(SUBSTR('". $tahun_bulan."',5,2),
                           '01',SUM(P01_DEBET),'02',SUM(P02_DEBET),'03',SUM(P03_DEBET),'04',SUM(P04_DEBET),'05',SUM(P05_DEBET),'06',SUM(P06_DEBET),    '07',SUM(P07_DEBET), '08',SUM(P08_DEBET), '09',SUM(P09_DEBET), '10',SUM(P10_DEBET),'11',SUM(P11_DEBET), '12',SUM(P12_DEBET), '13',SUM(P13_DEBET), '14',SUM(P14_DEBET)) MUT_DEBET,
                           DECODE(SUBSTR('". $tahun_bulan."',5,2),
                           '01',SUM(P01_KREDIT),'02',SUM(P02_KREDIT),'03',SUM(P03_KREDIT),'04',SUM(P04_KREDIT),'05',SUM(P05_KREDIT),'06',SUM(P06_KREDIT),    '07',SUM(P07_KREDIT), '08',SUM(P08_KREDIT), '09',SUM(P09_KREDIT), '10',SUM(P10_KREDIT),'11',SUM(P11_KREDIT), '12',SUM(P12_KREDIT), '13',SUM(P13_KREDIT), '14',SUM(P14_KREDIT)) MUT_KREDIT
                      FROM KBBT_NERACA_SALDO A, 
                             SAFM_PELANGGAN B
                     WHERE KD_SUB_BANTU = B.MPLG_KODE(+)
                       AND THN_BUKU     = SUBSTR('". $tahun_bulan."',1,4)
                       AND KD_VALUTA    = 'IDR'
                       AND KD_BUKU_BESAR BETWEEN '104.01.00' AND '104.05.00' 
                    GROUP BY KD_SUB_BANTU, B.MPLG_NAMA, A.KD_BUKU_BESAR ) X   
                    WHERE (X.SALDO_AWAL)+X.MUT_DEBET-X.MUT_KREDIT <> 0) AA,
                    (
                    SELECT A.KD_BB_KUSTO, A.KD_KUSTO KARTU, B.MPLG_NAMA NAMA, SUM(JML_SALDO_AKHIR) SALDO_AKHIR 
                      FROM KPTT_NOTA_LAP A,
                             SAFM_PELANGGAN B
                     WHERE A.BULTAH   = '". $tahun_bulan."'
                       AND ( A.FLAG_PUPN IS NULL OR A.FLAG_PUPN = 'K' )  
                       AND A.KD_KUSTO = B.MPLG_KODE(+)
                       AND A.KD_VALUTA = 'IDR'
                       AND A.KD_BB_KUSTO BETWEEN '104.01.00' AND '104.05.00'
                       AND A.JML_SALDO_AKHIR <> 0
                    GROUP BY A.KD_BB_KUSTO, A.KD_KUSTO, B.MPLG_NAMA
                    ) BB
                    WHERE AA.KD_BUKU_BESAR = BB.KD_BB_KUSTO(+)
                      AND AA.KARTU         = BB.KARTU(+)) XX
					WHERE 1 = 1  
					 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= " ) A ";
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsSaldoNeracaBantuRincian($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(NO_NOTA) AS ROWCOUNT FROM KPTT_NOTA_LAP
					 WHERE 1 = 1
					   AND ( FLAG_PUPN IS NULL OR FLAG_PUPN = 'K' )
					   AND JML_SALDO_AKHIR <> 0 ".$statement; 
		
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

    function getSumByParamsSaldoPiutangNeraca($paramsArray=array(), $statement="")
	{
		$str = "
				SELECT NVL(SUM(JML_SALDO_AKHIR), 0) ROWCOUNT
				  FROM KPTT_NOTA_LAP A,
				  	   SAFM_PELANGGAN B
				 WHERE 
				   ( A.FLAG_PUPN IS NULL OR A.FLAG_PUPN = 'K' )  
				   AND A.KD_KUSTO = B.MPLG_KODE(+)
				   AND A.JML_SALDO_AKHIR <> 0		
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

    function getSumByParamsSaldoNeracaBantuRincian($paramsArray=array(), $statement="")
	{
		$str = "SELECT SUM(JML_SALDO_AKHIR) AS ROWCOUNT FROM KPTT_NOTA_LAP
					 WHERE 1 = 1
					   AND ( FLAG_PUPN IS NULL OR FLAG_PUPN = 'K' )
					   AND JML_SALDO_AKHIR <> 0 ".$statement; 
		
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
				
    function getCountByParamsSaldoNeracaBantu($paramsArray=array(), $statement="", $reqKodeValuta="", $reqPeriode="")
	{
		$str = " SELECT COUNT(1) ROWCOUNT
					  FROM (
						SELECT A.KD_KUSTO, A.NAMA, A.SALDO SALDO
						  FROM (
							SELECT A.KD_SUB_BANTU KD_KUSTO, C.MPLG_NAMA NAMA, DECODE(SUBSTR('".$reqPeriode."',5,6),'01', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)),
								   '02', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)),
								   '03', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)),
								   '04', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)),
								   '05', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)),
								   '06', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)),
								   '07', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)+NVL(P07_DEBET,0)-NVL(P07_KREDIT,0)),
								   '08', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)+NVL(P07_DEBET,0)-NVL(P07_KREDIT,0)+NVL(P08_DEBET,0)-NVL(P08_KREDIT,0)),
								   '09', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)+NVL(P07_DEBET,0)-NVL(P07_KREDIT,0)+NVL(P08_DEBET,0)-NVL(P08_KREDIT,0)+NVL(P09_DEBET,0)-NVL(P09_KREDIT,0)),
								   '10', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)+NVL(P07_DEBET,0)-NVL(P07_KREDIT,0)+NVL(P08_DEBET,0)-NVL(P08_KREDIT,0)+NVL(P09_DEBET,0)-NVL(P09_KREDIT,0)+NVL(P10_DEBET,0)-NVL(P10_KREDIT,0)),
								   '11', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)+NVL(P07_DEBET,0)-NVL(P07_KREDIT,0)+NVL(P08_DEBET,0)-NVL(P08_KREDIT,0)+NVL(P09_DEBET,0)-NVL(P09_KREDIT,0)+NVL(P10_DEBET,0)-NVL(P10_KREDIT,0)+NVL(P11_DEBET,0)-NVL(P11_KREDIT,0)),
								   '12', SUM(NVL(AWAL_DEBET,0)-NVL(AWAL_KREDIT,0)+NVL(P01_DEBET,0)-NVL(P01_KREDIT,0)+NVL(P02_DEBET,0)-NVL(P02_KREDIT,0)+NVL(P03_DEBET,0)-NVL(P03_KREDIT,0)+NVL(P04_DEBET,0)-NVL(P04_KREDIT,0)+NVL(P05_DEBET,0)-NVL(P05_KREDIT,0)+NVL(P06_DEBET,0)-NVL(P06_KREDIT,0)+NVL(P07_DEBET,0)-NVL(P07_KREDIT,0)+NVL(P08_DEBET,0)-NVL(P08_KREDIT,0)+NVL(P09_DEBET,0)-NVL(P09_KREDIT,0)+NVL(P10_DEBET,0)-NVL(P10_KREDIT,0)+NVL(P11_DEBET,0)-NVL(P11_KREDIT,0)+NVL(P12_DEBET,0)-NVL(P12_KREDIT,0))) SALDO  
							  FROM KBBT_NERACA_SALDO A, KBBR_BUKU_BESAR B, SAFM_PELANGGAN C
							 WHERE A.KD_BUKU_BESAR = B.KD_BUKU_BESAR
							   AND DECODE('".$reqKodeValuta."','IDR',B.KODE_VALUTA,A.KD_VALUTA) = '".$reqKodeValuta."'
							   AND A.KD_BUKU_BESAR 
								   BETWEEN DECODE('".$reqKodeValuta."','IDR',(SELECT MIN(COA1) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = '1'), (SELECT MIN(COA2) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = '1'))
											AND DECODE('".$reqKodeValuta."','IDR',(SELECT MAX(COA1) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = '1'), (SELECT MAX(COA2) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = '1'))
							   AND A.THN_BUKU       = SUBSTR('".$reqPeriode."',1,4)
							   AND A.KD_SUB_BANTU  = C.MPLG_KODE(+)
							   AND A.KD_SUB_BANTU  <> '00000'
							GROUP BY A.KD_SUB_BANTU, C.MPLG_NAMA ) A ) X,
						  (     
						SELECT A.KD_KUSTO, B.MPLG_NAMA, NVL(SUM(NVL(A.JML_SALDO_AKHIR,0)),0) SALDO_AKHIR
						  FROM KPTT_NOTA_LAP A, SAFM_PELANGGAN B
						 WHERE A.KD_KUSTO   = B.MPLG_KODE(+)
						   AND A.BULTAH     = '".$reqPeriode."'
						   AND A.KD_VALUTA  = '".$reqKodeValuta."'
						   AND ( A.FLAG_PUPN IS NULL OR A.FLAG_PUPN = 'K' )
						   AND ( A.JML_SALDO_AWAL  <>  0  OR  A.JML_DEBET <>  0  OR  A.JML_KREDIT <>  0  OR  A.JML_SALDO_AKHIR  <>  0  )
						GROUP BY A.KD_KUSTO, B.MPLG_NAMA ) Y,
						SAFM_PELANGGAN Z
					  WHERE X.KD_KUSTO(+) = Z.MPLG_KODE
						AND Y.KD_KUSTO(+) = Z.MPLG_KODE
						AND ( X.SALDO <> 0 OR NVL(Y.SALDO_AKHIR,0) <> 0) ".$statement; 
		
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
    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = " SELECT COUNT(ROWCOUNT) ROWCOUNT FROM (SELECT COUNT(KD_BUKU_BESAR) AS ROWCOUNT FROM KBBT_NERACA_SALDO
		        WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= " GROUP BY KD_BUKU_BESAR, KD_SUB_BANTU, KD_BUKU_PUSAT) A ";
		$this->select($str);
		//echo $str;
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsMonitoringTransaksiTahunan($paramsArray=array(), $statement="")
	{
		$str = " SELECT COUNT(1) ROWCOUNT FROM KPTT_NOTA A 
				INNER JOIN SAFM_PELANGGAN B ON A.KD_KUSTO = B.MPLG_KODE
				WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		//echo $str;
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
					
    function getCountByParamsMonitoringKasBankKasirDenganNeraca($paramsArray=array(), $statement="", $bulan="", $tahun="", $valuta="")
	{
		$str = " SELECT COUNT(ROWCOUNT) ROWCOUNT FROM (
			 SELECT 1 ROWCOUNT
			  FROM
				(
				SELECT B.KD_BUKU_BESAR, B.KD_SUB_BANTU, SUM(B.SALDO_VAL_DEBET) DEBET_NERACA, SUM(B.SALDO_VAL_KREDIT) KREDIT_NERACA
				  FROM KBBT_JUR_BB A,
				  	   KBBT_JUR_BB_D B
				 WHERE A.NO_NOTA = B.NO_NOTA
				   AND A.JEN_JURNAL IN ('JKM','JKK')
				   AND A.BLN_BUKU  = '".$bulan."'
				   AND A.THN_BUKU  = ".$tahun."
				   AND A.KD_VALUTA = '".$valuta."'
				   AND A.NO_POSTING IS NOT NULL
                   AND B.KD_BUKU_BESAR LIKE '101%'       
                GROUP BY B.KD_BUKU_BESAR, B.KD_SUB_BANTU    
                ) AA,
                (
                SELECT B.KD_BUKU_BESAR, B.KD_SUB_BANTU, SUM(B.SALDO_VAL_DEBET) DEBET_KASIR, SUM(B.SALDO_VAL_KREDIT) KREDIT_KASIR
                  FROM PERBENDAHARAAN.KBBT_JUR_BB_KASIR A,
                         PERBENDAHARAAN.KBBT_JUR_BB_KASIR_D B
                 WHERE A.NO_NOTA = B.NO_NOTA
                   AND A.JEN_JURNAL IN ('JKM','JKK')
                   AND A.BLN_BUKU  = '".$bulan."'
                   AND A.THN_BUKU  = ".$tahun."
                   AND A.KD_VALUTA = '".$valuta."'
                   AND A.NO_POSTING IS NOT NULL
                   AND B.KD_BUKU_BESAR LIKE '101%'       
                GROUP BY B.KD_BUKU_BESAR, B.KD_SUB_BANTU
                ) BB    
              WHERE AA.KD_BUKU_BESAR = BB.KD_BUKU_BESAR(+)) AA
			  WHERE 1 = 1	
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
	
		

			  
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBT_NERACA_SALDO_ID) AS ROWCOUNT FROM KBBT_NERACA_SALDO
		        WHERE KBBT_NERACA_SALDO_ID IS NOT NULL ".$statement; 
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