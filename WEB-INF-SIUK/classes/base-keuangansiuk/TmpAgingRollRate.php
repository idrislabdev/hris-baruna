
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
  * EntitySIUK-base class untuk mengimplementasikan tabel TMP_AGING_ROLL_RATE.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class TmpAgingRollRate extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TmpAgingRollRate()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("TMP_AGING_ROLL_RATE_ID", $this->getNextId("TMP_AGING_ROLL_RATE_ID","TMP_AGING_ROLL_RATE")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "

				INSERT INTO TMP_AGING_ROLL_RATE (
				    KD_CABANG, JENIS_FILE, ID_FILE, 
   					BULTAH, KET_REFERENCE, KD_AKTIF, 
  					LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME)
				VALUES ( '".$this->getField("KD_CABANG")."', '".$this->getField("JENIS_FILE")."', '".$this->getField("ID_FILE")."',
					'".$this->getField("BULTAH")."', '".$this->getField("KET_REFERENCE")."', '".$this->getField("KD_AKTIF")."',
					".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."'
				)";
				
		//$this->id = $this->getField("TMP_AGING_ROLL_RATE_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE TMP_AGING_ROLL_RATE
				SET    
					   BULTAH      = '".$this->getField("BULTAH")."',
					   KET_REFERENCE    = '".$this->getField("KET_REFERENCE")."',
					   KD_AKTIF         = '".$this->getField("KD_AKTIF")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."'
				WHERE  BULTAH = '".$this->getField("BULTAH_TEMP")."'
			";
		
		/*KD_CABANG        = '".$this->getField("KD_CABANG")."',
	    JENIS_FILE       = '".$this->getField("JENIS_FILE")."',
	    ID_FILE          = '".$this->getField("ID_FILE")."',
		PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."'*/
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM TMP_AGING_ROLL_RATE
                WHERE 
                  TMP_AGING_ROLL_RATE_ID = ".$this->getField("TMP_AGING_ROLL_RATE_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callIsiAgingRollRate()
	{
        $str = "
				CALL ISI_AGING_ROLL_RATE_BARU('".$this->getField("PERIODE")."')
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY BULTAH ")
	{
		$str = "
				SELECT TO_CHAR(TO_DATE(TO_CHAR(BULTAH),'YYYYMM'),'MON') || ' ' || SUBSTR(BULTAH, 0,4) NM_BULTAH, 
				BULTAH, BADAN_USAHA, VAL_CURRENT, 
				   VAL_30HARI, VAL_90HARI, VAL_180HARI, 
				   VAL_270HARI, VAL_365HARI, VAL_A365HARI, 
				   KD_VALUTA,
				   NVL(VAL_CURRENT,0)+NVL(VAL_30HARI,0)+NVL(VAL_90HARI,0)+NVL(VAL_180HARI,0)+NVL(VAL_270HARI,0)+NVL(VAL_365HARI,0)+NVL(VAL_A365HARI,0) JUMLAH
				FROM TMP_AGING_ROLL_RATE A
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

    function selectByParamsAgingPiutang($paramsArray=array(),$reqTanggal="", $reqTahunBulan="", $reqKodeValuta="", $limit=-1,$from=-1, $statement="", $order=" ORDER BY BADAN_USAHA,KD_KUSTO,MPLG_NAMA ")
	{
		$str = "
					SELECT BADAN_USAHA,KD_KUSTO,MPLG_NAMA,  
						   SUM(THN_366)VAL_A365HARI,
						   SUM(THN_271365)VAL_365HARI,
						   SUM(THN_181270)VAL_270HARI,
						   SUM(THN_91180)VAL_180HARI,
						   SUM(THN_3190)VAL_90HARI,
						   SUM(THN_130)VAL_30HARI,
						   SUM(THN_366) + SUM(THN_271365) + SUM(THN_181270) + SUM(THN_91180) + SUM(THN_3190) + SUM(THN_130) JUMLAH
					FROM 
					(
					SELECT BADAN_USAHA,KD_KUSTO,MPLG_NAMA,
						   DECODE(A,'5',SALDO,0)THN_366,
						   DECODE(A,'4',SALDO,0)THN_271365,
						   DECODE(A,'3',SALDO,0)THN_181270,
						   DECODE(A,'2',SALDO,0)THN_91180,
						   DECODE(A,'1',SALDO,0)THN_3190,
						   DECODE(A,'0',SALDO,0)THN_130 
					FROM 
					(
							SELECT DISTINCT '0'A, 
								   DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ) BADAN_USAHA,
									R.KD_KUSTO,P.MPLG_NAMA,
									SUM(NVL( JML_SALDO_AKHIR, 0 )) SALDO
							FROM	KPTT_NOTA_LAP R, SAFM_PELANGGAN P
							WHERE	TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 30  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY')
									AND BULTAH = '".$reqTahunBulan."'
									AND	KD_VALUTA = '".$reqKodeValuta."' 
									AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
									AND R.KD_KUSTO = P.MPLG_KODE   
									AND	  R.BADAN_USAHA <> 'WARKATDANA' 
									AND	  R.KD_VALUTA = '".$reqKodeValuta."'
							GROUP BY DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ), 
									R.KD_KUSTO,P.MPLG_NAMA		           	                	
					UNION ALL
							SELECT DISTINCT '1' A,
									DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ) BADAN_USAHA,
									R.KD_KUSTO,P.MPLG_NAMA,
									SUM(NVL( JML_SALDO_AKHIR, 0 )) SALDO
							FROM	KPTT_NOTA_LAP R, SAFM_PELANGGAN P
							WHERE	TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 90  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 31
									AND BULTAH = '".$reqTahunBulan."'
									AND	KD_VALUTA = '".$reqKodeValuta."' 
									AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
									AND R.KD_KUSTO = P.MPLG_KODE   
									AND	  R.BADAN_USAHA <> 'WARKATDANA' 
									AND	  R.KD_VALUTA = '".$reqKodeValuta."'
							GROUP BY DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ), 
									R.KD_KUSTO,P.MPLG_NAMA               
					UNION ALL
							SELECT DISTINCT '2' A,
									DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ) BADAN_USAHA,
									R.KD_KUSTO,P.MPLG_NAMA,
									SUM(NVL( JML_SALDO_AKHIR, 0 )) SALDO
							FROM	KPTT_NOTA_LAP R, SAFM_PELANGGAN P
							WHERE	TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 180  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 91
									AND BULTAH = '".$reqTahunBulan."'
									AND	KD_VALUTA = '".$reqKodeValuta."' 
									AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
									AND R.KD_KUSTO = P.MPLG_KODE   
									AND	  R.BADAN_USAHA <> 'WARKATDANA' 
									AND	  R.KD_VALUTA = '".$reqKodeValuta."'
							GROUP BY DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ), 
									R.KD_KUSTO,P.MPLG_NAMA               
					UNION ALL
							SELECT DISTINCT '3' A,
									DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ) BADAN_USAHA,
									R.KD_KUSTO,P.MPLG_NAMA,
									SUM(NVL( JML_SALDO_AKHIR, 0 )) SALDO
							FROM	KPTT_NOTA_LAP R, SAFM_PELANGGAN P
							WHERE	TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 270  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 181	 
									AND BULTAH = '".$reqTahunBulan."'
									AND	KD_VALUTA = '".$reqKodeValuta."' 
									AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
									AND R.KD_KUSTO = P.MPLG_KODE   
									AND	  R.BADAN_USAHA <> 'WARKATDANA' 
									AND	  R.KD_VALUTA = '".$reqKodeValuta."'
							GROUP BY DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ), 
									R.KD_KUSTO,P.MPLG_NAMA		         																 
					UNION ALL
							SELECT DISTINCT '4' A,
									DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ) BADAN_USAHA,
									R.KD_KUSTO,P.MPLG_NAMA,
									SUM(NVL( JML_SALDO_AKHIR, 0 )) SALDO
							FROM	KPTT_NOTA_LAP R, SAFM_PELANGGAN P
							WHERE	TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 365  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 271		
									AND BULTAH = '".$reqTahunBulan."' 
									AND	KD_VALUTA = '".$reqKodeValuta."' 
									AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
									AND R.KD_KUSTO = P.MPLG_KODE   
									AND	  R.BADAN_USAHA <> 'WARKATDANA' 
									AND	  R.KD_VALUTA = '".$reqKodeValuta."'
							GROUP BY DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ), 
									R.KD_KUSTO,P.MPLG_NAMA
					UNION ALL
							SELECT DISTINCT '5' A,
									DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ) BADAN_USAHA,
									R.KD_KUSTO,P.MPLG_NAMA,
									SUM(NVL( JML_SALDO_AKHIR, 0 )) SALDO
							FROM	KPTT_NOTA_LAP R, SAFM_PELANGGAN P
							WHERE	TGL_POSTING BETWEEN TO_DATE('31121900', 'DDMMYYYY')  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 366	
									AND BULTAH = '".$reqTahunBulan."'	 
									AND	KD_VALUTA = '".$reqKodeValuta."' 
									AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
									AND R.KD_KUSTO = P.MPLG_KODE   
									AND	  R.BADAN_USAHA <> 'WARKATDANA' 
									AND	  R.KD_VALUTA = '".$reqKodeValuta."'
							GROUP BY DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ), 
									R.KD_KUSTO,P.MPLG_NAMA                      
					)
					)
					WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." 
					GROUP BY BADAN_USAHA,KD_KUSTO,MPLG_NAMA ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsAgingPiutangRincian($paramsArray=array(),$reqTanggal="", $reqTahunBulan="", $reqKodeValuta="", $limit=-1,$from=-1, $statement="", $order=" ORDER BY 1 ")
	{
		$str = "

					SELECT KD_KUSTO, KETERANGAN, NO_NOTA, NO_REF3, NO_POSTING, KET_TAMBAHAN, JML_SALDO_AWAL, JML_DEBET, JML_KREDIT, SALDO
                    FROM
                    (     
                            SELECT '1 - 30 Hari' KETERANGAN, KD_KUSTO, NO_NOTA, NO_REF3, NO_POSTING, KET_TAMBAHAN,
                             JML_SALDO_AWAL, JML_DEBET, JML_KREDIT, (NVL( JML_SALDO_AKHIR, 0 )) SALDO
                            FROM    KPTT_NOTA_LAP R, SAFM_PELANGGAN P
                            WHERE    TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 30  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY')
                                    AND BULTAH = '".$reqTahunBulan."'
                                    AND    KD_VALUTA = '".$reqKodeValuta."' 
                                    AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
                                    AND R.KD_KUSTO = P.MPLG_KODE   
                                    AND      R.BADAN_USAHA <> 'WARKATDANA' 
                                    AND      R.KD_VALUTA = '".$reqKodeValuta."'
                            UNION ALL
                            SELECT '31 - 90 Hari' KETERANGAN, KD_KUSTO, NO_NOTA, NO_REF3, NO_POSTING, KET_TAMBAHAN,
                             JML_SALDO_AWAL, JML_DEBET, JML_KREDIT, (NVL( JML_SALDO_AKHIR, 0 )) SALDO
                            FROM    KPTT_NOTA_LAP R, SAFM_PELANGGAN P
                            WHERE    TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 90  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 31
                                    AND BULTAH = '".$reqTahunBulan."'
                                    AND    KD_VALUTA = '".$reqKodeValuta."' 
                                    AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
                                    AND R.KD_KUSTO = P.MPLG_KODE   
                                    AND      R.BADAN_USAHA <> 'WARKATDANA' 
                                    AND      R.KD_VALUTA = '".$reqKodeValuta."'
                            UNION ALL
                            SELECT '91 - 180 Hari' KETERANGAN, KD_KUSTO, NO_NOTA, NO_REF3, NO_POSTING, KET_TAMBAHAN,
                             JML_SALDO_AWAL, JML_DEBET, JML_KREDIT, (NVL( JML_SALDO_AKHIR, 0 )) SALDO
                            FROM    KPTT_NOTA_LAP R, SAFM_PELANGGAN P
                            WHERE    TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 180  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 91
                                    AND BULTAH = '".$reqTahunBulan."'
                                    AND    KD_VALUTA = '".$reqKodeValuta."' 
                                    AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
                                    AND R.KD_KUSTO = P.MPLG_KODE   
                                    AND      R.BADAN_USAHA <> 'WARKATDANA' 
                                    AND      R.KD_VALUTA = '".$reqKodeValuta."'
                            UNION ALL
                            SELECT '181 - 270 Hari' KETERANGAN, KD_KUSTO, NO_NOTA, NO_REF3, NO_POSTING, KET_TAMBAHAN,
                             JML_SALDO_AWAL, JML_DEBET, JML_KREDIT, (NVL( JML_SALDO_AKHIR, 0 )) SALDO
                            FROM    KPTT_NOTA_LAP R, SAFM_PELANGGAN P
                            WHERE    TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 270  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 181
                                    AND BULTAH = '".$reqTahunBulan."'
                                    AND    KD_VALUTA = '".$reqKodeValuta."' 
                                    AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
                                    AND R.KD_KUSTO = P.MPLG_KODE   
                                    AND      R.BADAN_USAHA <> 'WARKATDANA' 
                                    AND      R.KD_VALUTA = '".$reqKodeValuta."'
                            UNION ALL                
                            SELECT '271 - 365 Hari' KETERANGAN, KD_KUSTO, NO_NOTA, NO_REF3, NO_POSTING, KET_TAMBAHAN,
                             JML_SALDO_AWAL, JML_DEBET, JML_KREDIT, (NVL( JML_SALDO_AKHIR, 0 )) SALDO
                            FROM    KPTT_NOTA_LAP R, SAFM_PELANGGAN P
                            WHERE    TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 365  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 271  
                                    AND BULTAH = '".$reqTahunBulan."'
                                    AND    KD_VALUTA = '".$reqKodeValuta."' 
                                    AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
                                    AND R.KD_KUSTO = P.MPLG_KODE   
                                    AND      R.BADAN_USAHA <> 'WARKATDANA' 
                                    AND      R.KD_VALUTA = '".$reqKodeValuta."'
                            UNION ALL                
                            SELECT '>365 Hari' KETERANGAN, KD_KUSTO, NO_NOTA, NO_REF3, NO_POSTING, KET_TAMBAHAN,
                             JML_SALDO_AWAL, JML_DEBET, JML_KREDIT, (NVL( JML_SALDO_AKHIR, 0 )) SALDO
                            FROM    KPTT_NOTA_LAP R, SAFM_PELANGGAN P
                            WHERE    TGL_POSTING BETWEEN TO_DATE('31121900', 'DDMMYYYY')  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 366  
                                    AND BULTAH = '".$reqTahunBulan."'
                                    AND    KD_VALUTA = '".$reqKodeValuta."' 
                                    AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
                                    AND R.KD_KUSTO = P.MPLG_KODE   
                                    AND      R.BADAN_USAHA <> 'WARKATDANA' 
                                    AND      R.KD_VALUTA = '".$reqKodeValuta."'
                     ) A WHERE SALDO > 0
					 					
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
		    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, JENIS_FILE, ID_FILE, 
				BULTAH,  KET_REFERENCE,
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME
				FROM TMP_AGING_ROLL_RATE
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
		$str = "SELECT COUNT(BULTAH) AS ROWCOUNT FROM TMP_AGING_ROLL_RATE
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

    function getCountByParamsAgingPiutang($paramsArray=array(), $reqTanggal="", $reqTahunBulan="", $reqKodeValuta="", $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM 
				(
				SELECT BADAN_USAHA,KD_KUSTO,MPLG_NAMA,  
						   SUM(THN_366)VAL_A365HARI,
						   SUM(THN_271365)VAL_365HARI,
						   SUM(THN_181270)VAL_270HARI,
						   SUM(THN_91180)VAL_180HARI,
						   SUM(THN_3190)VAL_90HARI,
						   SUM(THN_130)VAL_30HARI,
						   SUM(THN_366) + SUM(THN_271365) + SUM(THN_181270) + SUM(THN_91180) + SUM(THN_3190) + SUM(THN_130) JUMLAH
					FROM 
					(
					SELECT BADAN_USAHA,KD_KUSTO,MPLG_NAMA,
						   DECODE(A,'5',SALDO,0)THN_366,
						   DECODE(A,'4',SALDO,0)THN_271365,
						   DECODE(A,'3',SALDO,0)THN_181270,
						   DECODE(A,'2',SALDO,0)THN_91180,
						   DECODE(A,'1',SALDO,0)THN_3190,
						   DECODE(A,'0',SALDO,0)THN_130 
					FROM 
					(
							SELECT DISTINCT '0'A, 
								   DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ) BADAN_USAHA,
									R.KD_KUSTO,P.MPLG_NAMA,
									SUM(NVL( JML_SALDO_AKHIR, 0 )) SALDO
							FROM	KPTT_NOTA_LAP R, SAFM_PELANGGAN P
							WHERE	TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 30  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY')
									AND BULTAH = '".$reqTahunBulan."'
									AND	KD_VALUTA = '".$reqKodeValuta."' 
									AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
									AND R.KD_KUSTO = P.MPLG_KODE   
									AND	  R.BADAN_USAHA <> 'WARKATDANA' 
									AND	  R.KD_VALUTA = '".$reqKodeValuta."'
							GROUP BY DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ), 
									R.KD_KUSTO,P.MPLG_NAMA		           	                	
					UNION ALL
							SELECT DISTINCT '1' A,
									DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ) BADAN_USAHA,
									R.KD_KUSTO,P.MPLG_NAMA,
									SUM(NVL( JML_SALDO_AKHIR, 0 )) SALDO
							FROM	KPTT_NOTA_LAP R, SAFM_PELANGGAN P
							WHERE	TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 90  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 31
									AND BULTAH = '".$reqTahunBulan."'
									AND	KD_VALUTA = '".$reqKodeValuta."' 
									AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
									AND R.KD_KUSTO = P.MPLG_KODE   
									AND	  R.BADAN_USAHA <> 'WARKATDANA' 
									AND	  R.KD_VALUTA = '".$reqKodeValuta."'
							GROUP BY DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ), 
									R.KD_KUSTO,P.MPLG_NAMA               
					UNION ALL
							SELECT DISTINCT '2' A,
									DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ) BADAN_USAHA,
									R.KD_KUSTO,P.MPLG_NAMA,
									SUM(NVL( JML_SALDO_AKHIR, 0 )) SALDO
							FROM	KPTT_NOTA_LAP R, SAFM_PELANGGAN P
							WHERE	TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 180  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 91
									AND BULTAH = '".$reqTahunBulan."'
									AND	KD_VALUTA = '".$reqKodeValuta."' 
									AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
									AND R.KD_KUSTO = P.MPLG_KODE   
									AND	  R.BADAN_USAHA <> 'WARKATDANA' 
									AND	  R.KD_VALUTA = '".$reqKodeValuta."'
							GROUP BY DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ), 
									R.KD_KUSTO,P.MPLG_NAMA               
					UNION ALL
							SELECT DISTINCT '3' A,
									DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ) BADAN_USAHA,
									R.KD_KUSTO,P.MPLG_NAMA,
									SUM(NVL( JML_SALDO_AKHIR, 0 )) SALDO
							FROM	KPTT_NOTA_LAP R, SAFM_PELANGGAN P
							WHERE	TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 270  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 181	 
									AND BULTAH = '".$reqTahunBulan."'
									AND	KD_VALUTA = '".$reqKodeValuta."' 
									AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
									AND R.KD_KUSTO = P.MPLG_KODE   
									AND	  R.BADAN_USAHA <> 'WARKATDANA' 
									AND	  R.KD_VALUTA = '".$reqKodeValuta."'
							GROUP BY DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ), 
									R.KD_KUSTO,P.MPLG_NAMA		         																 
					UNION ALL
							SELECT DISTINCT '4' A,
									DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ) BADAN_USAHA,
									R.KD_KUSTO,P.MPLG_NAMA,
									SUM(NVL( JML_SALDO_AKHIR, 0 )) SALDO
							FROM	KPTT_NOTA_LAP R, SAFM_PELANGGAN P
							WHERE	TGL_POSTING BETWEEN TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 365  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 271		
									AND BULTAH = '".$reqTahunBulan."' 
									AND	KD_VALUTA = '".$reqKodeValuta."' 
									AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
									AND R.KD_KUSTO = P.MPLG_KODE   
									AND	  R.BADAN_USAHA <> 'WARKATDANA' 
									AND	  R.KD_VALUTA = '".$reqKodeValuta."'
							GROUP BY DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ), 
									R.KD_KUSTO,P.MPLG_NAMA
					UNION ALL
							SELECT DISTINCT '5' A,
									DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ) BADAN_USAHA,
									R.KD_KUSTO,P.MPLG_NAMA,
									SUM(NVL( JML_SALDO_AKHIR, 0 )) SALDO
							FROM	KPTT_NOTA_LAP R, SAFM_PELANGGAN P
							WHERE	TGL_POSTING BETWEEN TO_DATE('31121900', 'DDMMYYYY')  AND TO_DATE('".$reqTanggal."', 'DD-MM-YYYY') - 366	
									AND BULTAH = '".$reqTahunBulan."'	 
									AND	KD_VALUTA = '".$reqKodeValuta."' 
									AND         (  FLAG_PUPN IS NULL  OR  FLAG_PUPN = 'K'  )
									AND R.KD_KUSTO = P.MPLG_KODE   
									AND	  R.BADAN_USAHA <> 'WARKATDANA' 
									AND	  R.KD_VALUTA = '".$reqKodeValuta."'
							GROUP BY DECODE(R.BADAN_USAHA, 
											   'ABRI', '01 - ABRI',
											   'PEMERINTAH', '02 - PEMERINTAH',
											   'BUMN', '03 - BUMN',
											   'SWASTA', '04 - SWASTA',
											   'PERORANGAN', '05 - PERORANGAN', 
											   'TIDAKADA', '11 - PELRA',
											   'WARKATDANA','12 - WARKATDANA', R.BADAN_USAHA  ), 
									R.KD_KUSTO,P.MPLG_NAMA                      
					)
					)
					WHERE 1 = 1
					GROUP BY BADAN_USAHA,KD_KUSTO,MPLG_NAMA
				)
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
		$str = "SELECT COUNT(TMP_AGING_ROLL_RATE_ID) AS ROWCOUNT FROM TMP_AGING_ROLL_RATE
		        WHERE BULTAH IS NOT NULL ".$statement; 
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