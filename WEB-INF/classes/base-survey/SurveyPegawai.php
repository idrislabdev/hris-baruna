<? 
/* *******************************************************************************************************
MODUL NAME 			: PPI
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel SURVEY.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class SurveyPegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SurveyPegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURVEY_PEGAWAI_ID", $this->getNextId("SURVEY_PEGAWAI_ID","PPI_SURVEY.SURVEY_PEGAWAI"));

		$str = "
				INSERT INTO PPI_SURVEY.SURVEY_PEGAWAI (
				   SURVEY_PEGAWAI_ID, SURVEY_ID, PEGAWAI_ID, 
				   NILAI_KENYATAAN, NILAI_HARAPAN, PERIODE, LAST_CREATE_USER, LAST_CREATE_DATE)   
 			  	VALUES (
				  ".$this->getField("SURVEY_PEGAWAI_ID").",
				  '".$this->getField("SURVEY_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("NILAI_KENYATAAN")."',
				  '".$this->getField("NILAI_HARAPAN")."',
				  (SELECT PERIODE FROM PPI_SURVEY.SURVEY_PERIODE_TERAKHIR),
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id=$this->getField("SURVEY_PEGAWAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SURVEY.SURVEY_PEGAWAI
				SET    
					   SURVEY_ID 			= '".$this->getField("SURVEY_ID")."',
					   PEGAWAI_ID 			= '".$this->getField("PEGAWAI_ID")."',
					   NILAI_KENYATAAN 		= '".$this->getField("NILAI_KENYATAAN")."',
					   NILAI_HARAPAN 		= '".$this->getField("NILAI_HARAPAN")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  SURVEY_PEGAWAI_ID  	= '".$this->getField("SURVEY_PEGAWAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SURVEY.SURVEY_PEGAWAI
                WHERE 
                  SURVEY_PEGAWAI_ID = ".$this->getField("SURVEY_PEGAWAI_ID").""; 
				  
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
	
	function selectByParamsRekap($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY PEGAWAI_ID ASC", $arrSurveyId=array())
	{
		$str = "
				SELECT PEGAWAI_ID 
				"; 
		for($i=0;$i<count($arrSurveyId);$i++)
		{
			$str .= ",  MAX(DECODE(SURVEY_ID, '".$arrSurveyId[$i]."', NILAI_KENYATAAN)) NILAI_KENYATAAN".$arrSurveyId[$i].", ";
			$str .= "  MAX(DECODE(SURVEY_ID, '".$arrSurveyId[$i]."', NILAI_HARAPAN)) NILAI_HARAPAN".$arrSurveyId[$i]." ";
		}
		$str .= "  FROM PPI_SURVEY.SURVEY_PEGAWAI A WHERE 1 = 1 ";
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY PEGAWAI_ID ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsRekapJenisPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY PEGAWAI_ID ASC", $arrSurveyId=array(), $jenis_pegawai="")
	{
		$str = "
				SELECT A.PEGAWAI_ID 
				"; 
		for($i=0;$i<count($arrSurveyId);$i++)
		{
			$str .= ",  MAX(DECODE(SURVEY_ID, '".$arrSurveyId[$i]."', NILAI_KENYATAAN)) NILAI_KENYATAAN".$arrSurveyId[$i].", ";
			$str .= "  MAX(DECODE(SURVEY_ID, '".$arrSurveyId[$i]."', NILAI_HARAPAN)) NILAI_HARAPAN".$arrSurveyId[$i]." ";
		}
		$str .= "  FROM PPI_SURVEY.SURVEY_PEGAWAI A INNER JOIN PPI_SURVEY.PEGAWAI_SURVEY_DATA B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." WHERE 1 = 1 ";
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PEGAWAI_ID ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsRekapTotal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY PEGAWAI_ID ASC", $arrSurveyId=array())
	{
		$str = "
				SELECT 1 
				"; 
		for($i=0;$i<count($arrSurveyId);$i++)
		{
			$str .= ",  SUM(DECODE(SURVEY_ID, '".$arrSurveyId[$i]."', NILAI_KENYATAAN)) NILAI_KENYATAAN".$arrSurveyId[$i].", ";
			$str .= "  SUM(DECODE(SURVEY_ID, '".$arrSurveyId[$i]."', NILAI_HARAPAN)) NILAI_HARAPAN".$arrSurveyId[$i]." ";
		}
		$str .= "  FROM PPI_SURVEY.SURVEY_PEGAWAI WHERE 1 = 1 ";
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsRekapTotalJenisPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY PEGAWAI_ID ASC", $arrSurveyId=array(), $jenis_pegawai=2)
	{
		$str = "
				SELECT 1 
				"; 
		for($i=0;$i<count($arrSurveyId);$i++)
		{
			$str .= ",  SUM(DECODE(SURVEY_ID, '".$arrSurveyId[$i]."', NILAI_KENYATAAN)) NILAI_KENYATAAN".$arrSurveyId[$i].", ";
			$str .= "  SUM(DECODE(SURVEY_ID, '".$arrSurveyId[$i]."', NILAI_HARAPAN)) NILAI_HARAPAN".$arrSurveyId[$i]." ";
		}
		$str .= "  FROM PPI_SURVEY.SURVEY_PEGAWAI A INNER JOIN PPI_SURVEY.PEGAWAI_SURVEY_DATA B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." WHERE 1 = 1 ";
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY SURVEY_PEGAWAI_ID ASC")
	{
		$str = "
				SELECT 
                A.SURVEY_PEGAWAI_ID, A.SURVEY_ID, A.PEGAWAI_ID, 
                   A.NILAI_KENYATAAN, A.NILAI_HARAPAN
                FROM PPI_SURVEY.SURVEY_PEGAWAI A LEFT JOIN PPI_SURVEY.SURVEY B ON A.SURVEY_ID = B.SURVEY_ID       
                WHERE A.SURVEY_PEGAWAI_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	 function selectNilaiIndividu($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY SURVEY_PARENT_ID ASC")
	{
		$str = " SELECT A.*, B.KETERANGAN FROM ( SELECT 
                    PERIODE, NAMA, SURVEY_PARENT_ID, COUNT( DISTINCT PEGAWAI_ID) RESPONDEN, JML_PERTANYAAN,
                    SUM(SS) SS, SUM(S) S, SUM(TS) TS, SUM(STS) STS, SUM(S_TT) S_TT, SUM(SP) SP, SUM(P) P, SUM(TP) TP, SUM(STP) STP, SUM(P_TT) P_TT, 
                    SUM(SI) SI, SUM(RSI) RSI, SUM(USI) USI, SUM(NI) NI, SUM(B_SS) B_SS, 
                    SUM(B_S) B_S, SUM(B_TS) B_TS, SUM(B_STS) B_STS, SUM(B_S_TT) B_S_TT, SUM(B_SP) B_SP, SUM(B_P) B_P, SUM(B_TP) B_TP, SUM(B_STP) B_STP, SUM(B_P_TT) B_P_TT,
					ROUND(( SUM(SI) / (COUNT( DISTINCT PEGAWAI_ID) * JML_PERTANYAAN) ) * 100, 2) PROFIL_KEPUASAN_SI,
                    ROUND(( SUM(RSI) / (COUNT( DISTINCT PEGAWAI_ID) * JML_PERTANYAAN) ) * 100, 2) PROFIL_KEPUASAN_RSI,
                    ROUND(( SUM(USI) / (COUNT( DISTINCT PEGAWAI_ID) * JML_PERTANYAAN) ) * 100, 2) PROFIL_KEPUASAN_USI,
                    ROUND(( SUM(NI) / (COUNT( DISTINCT PEGAWAI_ID) * JML_PERTANYAAN) ) * 100, 2) PROFIL_KEPUASAN_NI,
					ROUND( (SUM(B_SS + B_S) / ( COUNT( DISTINCT PEGAWAI_ID)*JML_PERTANYAAN*5 )) * 100, 2) PERFORMANCE,
                    ROUND( (SUM(B_SP + B_P) / ( COUNT( DISTINCT PEGAWAI_ID)*JML_PERTANYAAN*5 )) * 100, 2) IMPORTANCE,
					CASE
                        WHEN ROUND( (SUM(B_SP + B_P) / ( COUNT( DISTINCT PEGAWAI_ID)*JML_PERTANYAAN*5 )) * 100, 2) >= 80 AND 
                        ROUND( (SUM(B_SS + B_S) / ( COUNT( DISTINCT PEGAWAI_ID)*JML_PERTANYAAN*5 )) * 100, 2) < 80 THEN 'A'
                        WHEN  ROUND( (SUM(B_SP + B_P) / ( COUNT( DISTINCT PEGAWAI_ID)*JML_PERTANYAAN*5 )) * 100, 2) >= 80 AND
                        ROUND( (SUM(B_SS + B_S) / ( COUNT( DISTINCT PEGAWAI_ID)*JML_PERTANYAAN*5 )) * 100, 2) >= 80 THEN 'B'
                        WHEN ROUND( (SUM(B_SP + B_P) / ( COUNT( DISTINCT PEGAWAI_ID)*JML_PERTANYAAN*5 )) * 100, 2) < 80 AND
                        ROUND( (SUM(B_SS + B_S) / ( COUNT( DISTINCT PEGAWAI_ID)*JML_PERTANYAAN*5 )) * 100, 2) >= 80 THEN 'C'
                        WHEN ROUND( (SUM(B_SP + B_P) / ( COUNT( DISTINCT PEGAWAI_ID)*JML_PERTANYAAN*5 )) * 100, 2) < 80 AND
                        ROUND( (SUM(B_SS + B_S) / ( COUNT( DISTINCT PEGAWAI_ID)*JML_PERTANYAAN*5 )) * 100, 2) < 80 THEN 'D'
                        ELSE ''
                    END KUADRAN
                    FROM PPI_SURVEY.V_NILAI_INDIVIDU
                 WHERE 0=0  
                  "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY PERIODE, NAMA, SURVEY_PARENT_ID, JML_PERTANYAAN) A LEFT JOIN SETTING_APLIKASI B ON A.KUADRAN = B.NILAI AND B.KODE = 'KUADRAN' ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function getCountNilaiIndividu($paramsArray=array(), $statement="")
	{
		$str = "SELECT SUM(COUNT(DISTINCT PERIODE)) AS ROWCOUNT FROM PPI_SURVEY.V_NILAI_INDIVIDU WHERE 0=0 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str . " GROUP BY PERIODE, NAMA, SURVEY_PARENT_ID, JML_PERTANYAAN "); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
	function selectGambaranUmumPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.NAMA ASC")
	{
		$str = " SELECT A.PERIODE, A.NAMA, COUNT(A.PEGAWAI_ID) RESPONDEN, 
					SUM(SPU) SPU, SUM(PU) PU, SUM(TPU) TPU, SUM(STPU) STPU, SUM(TT) TT,
					ROUND((SUM(SPU)/COUNT(A.PEGAWAI_ID)) * 100,2) PERSEN_SPU,
					ROUND((SUM(PU)/COUNT(A.PEGAWAI_ID)) * 100,2) PERSEN_PU, 
					ROUND((SUM(TPU)/COUNT(A.PEGAWAI_ID)) * 100,2) PERSEN_TPU, 
					ROUND((SUM(STPU)/COUNT(A.PEGAWAI_ID)) * 100,2) PERSEN_STPU,
					ROUND((SUM(TT)/COUNT(A.PEGAWAI_ID)) * 100,2) PERSEN_TT
					FROM PPI_SURVEY.V_NILAI_GAMBARAN_UMUM A
                 WHERE 0=0  
                  "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PERIODE, A.NAMA ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectEngagementPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY C.PERIODE, B.NO_URUT")
	{
		$str = " /* Formatted on 3/12/2015 10:10:10 AM (QP5 v5.115.810.9015) */
  SELECT   C.PERIODE,
           A.NAMA INDIKATOR,
           B.NAMA,
           COUNT (DISTINCT C.PEGAWAI_ID) RESPONDEN,
           SUM (DECODE (C.NILAI_KENYATAAN, 5, 1, 0)) SS,
           SUM (DECODE (C.NILAI_KENYATAAN, 4, 1, 0)) S,
           SUM (DECODE (C.NILAI_KENYATAAN, 3, 1, 0)) TS,
           SUM (DECODE (C.NILAI_KENYATAAN, 2, 1, 0)) STS,
           SUM (DECODE (C.NILAI_KENYATAAN, 1, 1, 0)) S_TT,
           SUM (DECODE (C.NILAI_KENYATAAN, 5, 1, 4, 1, 0)) SI,
           SUM (DECODE (C.NILAI_KENYATAAN, 5, 1, 0)) RSI,
           SUM (DECODE (C.NILAI_KENYATAAN, 3, 1, 2, 1, 0)) USI,
           SUM (DECODE (C.NILAI_KENYATAAN, 1, 1, 0)) NI,
           ROUND(SUM (DECODE (C.NILAI_KENYATAAN, 5, 1, 4, 1, 0)) /  (COUNT (DISTINCT C.PEGAWAI_ID) * COUNT(DISTINCT A.SURVEY_ID)) * 100, 2) PERSEN_SI,
           ROUND(SUM (DECODE (C.NILAI_KENYATAAN, 5, 1, 0)) /  (COUNT (DISTINCT C.PEGAWAI_ID) * COUNT(DISTINCT A.SURVEY_ID)) * 100, 2) PERSEN_RSI,
           ROUND(SUM (DECODE (C.NILAI_KENYATAAN, 3, 1, 2, 1, 0)) /  (COUNT (DISTINCT C.PEGAWAI_ID) * COUNT(DISTINCT A.SURVEY_ID)) * 100, 2) PERSEN_USI,
           ROUND(SUM (DECODE (C.NILAI_KENYATAAN, 1, 1, 0)) /  (COUNT (DISTINCT C.PEGAWAI_ID) * COUNT(DISTINCT A.SURVEY_ID)) * 100, 2) PERSEN_NI
    FROM                     PPI_SURVEY.SURVEY A
                          JOIN
                             PPI_SURVEY.SURVEY B
                          ON A.SURVEY_ID = '09'
                             AND A.SURVEY_ID = B.SURVEY_PARENT_ID
                       LEFT JOIN
                          PPI_SURVEY.SURVEY_PEGAWAI C
                       ON C.SURVEY_ID = B.SURVEY_ID
                    JOIN
                       PPI_SURVEY.PEGAWAI_SURVEY_DATA D
                    ON C.PEGAWAI_ID = D.PEGAWAI_ID AND C.PERIODE = D.PERIODE
                 LEFT JOIN
                    PPI_SIMPEG.JENIS_PEGAWAI E
                 ON D.JENIS_PEGAWAI_ID = E.JENIS_PEGAWAI_ID
              LEFT JOIN
                 PPI_SIMPEG.DEPARTEMEN F
              ON D.DEPARTEMEN_ID = F.DEPARTEMEN_ID
           LEFT JOIN
              PPI_OPERASIONAL.LOKASI G
           ON D.LOKASI_ID = G.LOKASI_ID
   WHERE   0=0
                  "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY   A.NAMA, B.NAMA, B.NO_URUT, C.PERIODE ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function getCountGambaranUmumPegawai($paramsArray=array(), $statement="")
	{
		$str = "SELECT SUM(COUNT(DISTINCT PERIODE)) AS ROWCOUNT FROM PPI_SURVEY.V_NILAI_GAMBARAN_UMUM WHERE 0=0 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str . " GROUP BY PERIODE, NAMA, "); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function selectByParamsPegawaiIsian($paramsArray=array())
	{
		$str = "
				SELECT 
				PEGAWAI_ID, ISI_DATA_PRIBADI, ISI_PENDAPAT, ISI_KUESIONER		
				FROM PPI_SURVEY.PEGAWAI_ISIAN_PERIODE_AKHIR A
 				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->query = $str;
		
		return $this->selectLimit($str,-1, -1); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
				SELECT 
				SURVEY_PEGAWAI_ID, SURVEY_ID, PEGAWAI_ID, 
				    NILAI_KENYATAAN, NILAI_HARAPAN
				FROM PPI_SURVEY.SURVEY_PEGAWAI		
				WHERE SURVEY_PEGAWAI_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY SURVEY_PEGAWAI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
	function getCountByParamsRekap($paramsArray=array(), $statement="", $periode)
	{
		$str = "
		SELECT
			COUNT(PEGAWAI_ID) AS ROWCOUNT
		FROM(
			SELECT PEGAWAI_ID 
			FROM PPI_SURVEY.SURVEY_PEGAWAI 
			WHERE PERIODE = '".$periode."'
			GROUP BY PEGAWAI_ID
			)
		WHERE 1=1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		//$str .= ' GROUP BY PEGAWAI_ID';
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

	function getCountByParamsRekapJenisPegawai($paramsArray=array(), $statement="", $periode="", $jenis_pegawai="")
	{
		$str = "
		SELECT
			COUNT(PEGAWAI_ID) AS ROWCOUNT
		FROM(
			SELECT A.PEGAWAI_ID 
			FROM PPI_SURVEY.SURVEY_PEGAWAI A INNER JOIN PPI_SURVEY.PEGAWAI_SURVEY_DATA B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.JENIS_PEGAWAI_ID = ".$jenis_pegawai."
			WHERE A.PERIODE = '".$periode."'
			GROUP BY A.PEGAWAI_ID
			)
		WHERE 1=1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		//$str .= ' GROUP BY PEGAWAI_ID';
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsPegawaiSurveyPeriode($paramsArray=array(), $statement="")
	{
		$str = "SELECT JUMLAH FROM PPI_SURVEY.PEGAWAI_SURVEY_JUMLAH_PERIODE WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("JUMLAH"); 
		else 
			return 0; 
    }
	    
    function getCountByParamsPegawaiSurveyPeriodeJenisPegawai($paramsArray=array(), $statement="", $jenis_pegawai=2)
	{
		$str = "SELECT COUNT(DISTINCT A.PEGAWAI_ID) JUMLAH FROM PPI_SURVEY.SURVEY_PEGAWAI A
			   INNER JOIN PPI_SURVEY.PEGAWAI_SURVEY_DATA B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND JENIS_PEGAWAI_ID = ".$jenis_pegawai." WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("JUMLAH"); 
		else 
			return 0; 
    }
	

    function getCountByParamsSurveyPeriode($paramsArray=array(), $statement="")
	{
		$str = "SELECT JUMLAH FROM PPI_SURVEY.SURVEY_JUMLAH_PERIODE WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("JUMLAH"); 
		else 
			return 0; 
    }
		
							
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SURVEY_PEGAWAI_ID) AS ROWCOUNT FROM PPI_SURVEY.SURVEY_PEGAWAI WHERE SURVEY_PEGAWAI_ID IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SURVEY_PEGAWAI_ID) AS ROWCOUNT FROM PPI_SURVEY.SURVEY_PEGAWAI WHERE SURVEY_PEGAWAI_ID IS NOT NULL ".$statement; 
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