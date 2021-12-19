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
  * Entity-base class untuk mengimplementasikan tabel JENIS_PENILAIAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PenilaianPeriode extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PenilaianPeriode()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PENILAIAN_PERIODE_ID", $this->getNextId("PENILAIAN_PERIODE_ID","PPI_PENILAIAN.PENILAIAN_PERIODE")); 
		
		$str = "
				INSERT INTO PPI_PENILAIAN.PENILAIAN_PERIODE (
				   PENILAIAN_PERIODE_ID, PERIODE) 
 			  	VALUES (
				  ".$this->getField("PENILAIAN_PERIODE_ID").",
				  '".$this->getField("PERIODE")."'
				)"; 
		$this->id = $this->getField("PENILAIAN_PERIODE_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_PENILAIAN.PENILAIAN_PERIODE
				SET    
					   PERIODE				= '".$this->getField("PERIODE")."'
				WHERE  PENILAIAN_PERIODE_ID	= '".$this->getField("PENILAIAN_PERIODE_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_PENILAIAN.PENILAIAN_PERIODE
                WHERE 
                  PENILAIAN_PERIODE_ID = ".$this->getField("PENILAIAN_PERIODE_ID").""; 
				  
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
				SELECT 
				PENILAIAN_PERIODE_ID, PERIODE
				FROM PPI_PENILAIAN.PENILAIAN_PERIODE				
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
     
    function selectByParamsDepartemen($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
                'ALL' DEPARTEMEN_ID, 0 CABANG_ID, 'Semua' NAMA FROM DUAL 
                UNION ALL
               	SELECT DEPARTEMEN_ID, CABANG_ID, NAMA
                FROM PPI_SIMPEG.DEPARTEMEN
                WHERE 1=1 AND DEPARTEMEN_PARENT_ID = '0' AND DEPARTEMEN_ID NOT IN ('88','77','07','66')
                ORDER BY CABANG_ID ASC, DEPARTEMEN_ID ASC
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
     
    function selectByParamsDataNilai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqPegId='', $reqPeriode='')
	{
		$str = "
				SELECT ROWNUM AS NO,
				'". $reqPegId ."' PENILAI, A.PEGAWAI_ID DINILAI,  A.NAMA, Y.NAMA DEPARTEMEN,
				 
				CASE WHEN D.JABATAN_ID IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,112,113,114,115,116,117,134,138,139,103) THEN 'S' WHEN D.KELOMPOK = 'K' THEN 'F' ELSE 'P' END JABATAN_DINILAI,
			 	( SELECT STATUS FROM PPI_PENILAIAN.PEGAWAI_PENILAI X WHERE X.PEGAWAI_ID = '". $reqPegId ."' AND NOT X.PEGAWAI_PENILAI_PARENT_ID = 0 AND X.PEGAWAI_PENILAI_PARENT_ID = I.PEGAWAI_PENILAI_ID) STATUS_PENILAI,
				B.STATUS_IMPORT, B.LAST_IMPORTED_BY, 
				B.PERTANYAAN_ID NIL_1, B.RANGE_NILAI RANGE_1,
				C.PERTANYAAN_ID NIL_2, C.RANGE_NILAI RANGE_2,
				E.PERTANYAAN_ID NIL_3, E.RANGE_NILAI RANGE_3,
				F.PERTANYAAN_ID NIL_4, F.RANGE_NILAI RANGE_4,
				(B.RANGE_NILAI + C.RANGE_NILAI + E.RANGE_NILAI + F.RANGE_NILAI) INTEGRITAS,
				G.PERTANYAAN_ID NIL_5, G.RANGE_NILAI RANGE_5,
				H.PERTANYAAN_ID NIL_6, H.RANGE_NILAI RANGE_6,
				J.PERTANYAAN_ID NIL_7, J.RANGE_NILAI RANGE_7,
				K.PERTANYAAN_ID NIL_8 , K.RANGE_NILAI RANGE_8 ,
				(G.RANGE_NILAI + H.RANGE_NILAI + J.RANGE_NILAI + K.RANGE_NILAI) KEAHLIAN,
				L.PERTANYAAN_ID NIL_9 , L.RANGE_NILAI RANGE_9 ,
				M.PERTANYAAN_ID NIL_10, M.RANGE_NILAI RANGE_10,
				(L.RANGE_NILAI + M.RANGE_NILAI) PRIMA,
				N.PERTANYAAN_ID NIL_11, N.RANGE_NILAI RANGE_11,
				O.PERTANYAAN_ID NIL_12, O.RANGE_NILAI RANGE_12,
				P.PERTANYAAN_ID NIL_13, P.RANGE_NILAI RANGE_13,
				Q.PERTANYAAN_ID NIL_14, Q.RANGE_NILAI RANGE_14,
				(N.RANGE_NILAI + O.RANGE_NILAI  + P.RANGE_NILAI  + Q.RANGE_NILAI ) DISIPLIN,
				R.PERTANYAAN_ID NIL_15, R.RANGE_NILAI RANGE_15,
				S.PERTANYAAN_ID NIL_16, S.RANGE_NILAI RANGE_16,
				(R.RANGE_NILAI + S.RANGE_NILAI) INOVASI,
				T.PERTANYAAN_ID NIL_17, T.RANGE_NILAI RANGE_17,
				T.RANGE_NILAI KERJASAMA,
				U.PERTANYAAN_ID NIL_18, U.RANGE_NILAI RANGE_18,
				V.PERTANYAAN_ID NIL_19, V.RANGE_NILAI RANGE_19,
				W.PERTANYAAN_ID NIL_20, W.RANGE_NILAI RANGE_20,
				X.PERTANYAAN_ID NIL_21, X.RANGE_NILAI RANGE_21,
				(U.RANGE_NILAI  + V.RANGE_NILAI  + W.RANGE_NILAI  + X.RANGE_NILAI ) PEMIMPIN 
			FROM PPI_SIMPEG.PEGAWAI A 
			LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
			INNER JOIN PPI_PENILAIAN.PEGAWAI_PENILAI  I  ON A.PEGAWAI_ID = I.PEGAWAI_ID 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID_DINILAI AND B.PERTANYAAN_ID = 1 AND B.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND B.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID_DINILAI AND C.PERTANYAAN_ID = 2 AND C.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND C.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI E ON A.PEGAWAI_ID = E.PEGAWAI_ID_DINILAI AND E.PERTANYAAN_ID = 3 AND E.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND E.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI F ON A.PEGAWAI_ID = F.PEGAWAI_ID_DINILAI AND F.PERTANYAAN_ID = 4 AND F.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND F.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI G ON A.PEGAWAI_ID = G.PEGAWAI_ID_DINILAI AND G.PERTANYAAN_ID = 5 AND G.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND G.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI H ON A.PEGAWAI_ID = H.PEGAWAI_ID_DINILAI AND H.PERTANYAAN_ID = 6 AND H.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND H.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI J ON A.PEGAWAI_ID = J.PEGAWAI_ID_DINILAI AND J.PERTANYAAN_ID = 7 AND J.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND J.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI K ON A.PEGAWAI_ID = K.PEGAWAI_ID_DINILAI AND K.PERTANYAAN_ID = 8 AND K.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND K.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI L ON A.PEGAWAI_ID = L.PEGAWAI_ID_DINILAI AND L.PERTANYAAN_ID = 9 AND L.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND L.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI M ON A.PEGAWAI_ID = M.PEGAWAI_ID_DINILAI AND M.PERTANYAAN_ID = 10 AND M.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND M.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI N ON A.PEGAWAI_ID = N.PEGAWAI_ID_DINILAI AND N.PERTANYAAN_ID = 11 AND N.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND N.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI O ON A.PEGAWAI_ID = O.PEGAWAI_ID_DINILAI AND O.PERTANYAAN_ID = 12 AND O.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND O.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI P ON A.PEGAWAI_ID = P.PEGAWAI_ID_DINILAI AND P.PERTANYAAN_ID = 13 AND P.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND P.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI Q ON A.PEGAWAI_ID = Q.PEGAWAI_ID_DINILAI AND Q.PERTANYAAN_ID = 14 AND Q.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND Q.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI R ON A.PEGAWAI_ID = R.PEGAWAI_ID_DINILAI AND R.PERTANYAAN_ID = 15 AND R.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND R.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI S ON A.PEGAWAI_ID = S.PEGAWAI_ID_DINILAI AND S.PERTANYAAN_ID = 16 AND S.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND S.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI T ON A.PEGAWAI_ID = T.PEGAWAI_ID_DINILAI AND T.PERTANYAAN_ID = 17 AND T.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND T.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI U ON A.PEGAWAI_ID = U.PEGAWAI_ID_DINILAI AND U.PERTANYAAN_ID = 18 AND U.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND U.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI V ON A.PEGAWAI_ID = V.PEGAWAI_ID_DINILAI AND V.PERTANYAAN_ID = 19 AND V.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND V.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI W ON A.PEGAWAI_ID = W.PEGAWAI_ID_DINILAI AND W.PERTANYAAN_ID = 20 AND W.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND W.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI X ON A.PEGAWAI_ID = X.PEGAWAI_ID_DINILAI AND X.PERTANYAAN_ID = 21 AND X.PEGAWAI_ID_PENILAI = '". $reqPegId ."' AND X.PERIODE = '". $reqPeriode ."' 
			LEFT JOIN PPI_SIMPEG.DEPARTEMEN Y ON A.DEPARTEMEN_ID = Y.DEPARTEMEN_ID 

			WHERE 1 = 1 
			 AND I.PERIODE = '". $reqPeriode ."' 
			AND EXISTS ( SELECT 1 FROM PPI_PENILAIAN.PEGAWAI_PENILAI X WHERE X.PEGAWAI_ID = '". $reqPegId ."' AND NOT X.PEGAWAI_PENILAI_PARENT_ID = 0 AND X.PEGAWAI_PENILAI_PARENT_ID = I.PEGAWAI_PENILAI_ID) 
			"; 
		/*while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}*/
		
		//$str .= $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
    function selectByParamsDataNilaiImport($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "SELECT ROWNUM NO, 
				A.PEGAWAI_ID, A.NAMA, C.NAMA DEPARTEMEN,
				CASE WHEN TYPE_PEGAWAI = 'P' THEN 'PELAKSANA' WHEN TYPE_PEGAWAI = 'S' THEN 'STRUKTURAL' ELSE 'FUNGSIONAL' END TYPE_PEGAWAI , 
				PENILAI, TYPE_PENILAI, 
				RANGE_1, RANGE_2, RANGE_3, RANGE_4, (RANGE_1 + RANGE_2 + RANGE_3 + RANGE_4) INTEGRITAS,
				RANGE_5, RANGE_6, RANGE_7, RANGE_8, (RANGE_5 + RANGE_6 + RANGE_7 + RANGE_8) KEAHLIAN,
				RANGE_9, RANGE_10, (RANGE_9 + RANGE_10) PRIMA,
				RANGE_11, RANGE_12, RANGE_13, RANGE_14, (RANGE_11 + RANGE_12 + RANGE_13 + RANGE_14) DISIPLIN,
				RANGE_15, RANGE_16, (RANGE_15 + RANGE_16) INOVASI,
				RANGE_17, RANGE_17 KERJASAMA,
				RANGE_18, RANGE_19, RANGE_20, RANGE_21, (RANGE_18 + RANGE_19 + RANGE_20 + RANGE_21) PEMIMPIN
				FROM PPI_PENILAIAN.V_NILAI_PEGAWAI A	
				LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID 		
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON B.DEPARTEMEN_ID = C.DEPARTEMEN_ID 
				WHERE 1 = 1 
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")	{
		$str = "
				SELECT 
				PENILAIAN_PERIODE_ID, PERIODE
				FROM PPI_PENILAIAN.PENILAIAN_PERIODE				
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PENILAIAN_PERIODE_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	

	function selectByParamsListPeriode($paramsArray=array(),$limit=-1,$from=-1, $statement="")	{
		$str = "
				SELECT A.PERIODE, TO_CHAR(TO_DATE(A.PERIODE, 'MMYYYY'), 'MONTH YYYY', 'NLS_DATE_LANGUAGE=INDONESIAN') PERIODE_NAMA 
				FROM PPI_PENILAIAN.PENILAIAN_PERIODE A  
				WHERE 1=1 
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		//echo $str;
		$str .= $statement." ORDER BY A.PENILAIAN_PERIODE_ID DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 

    function getPeriodeAkhir(){
		$str = "
				SELECT 
				PENILAIAN_PERIODE_ID, PERIODE
				FROM PPI_PENILAIAN.PENILAIAN_PERIODE	
				WHERE 1 = 1 ORDER BY PENILAIAN_PERIODE_ID DESC
				"; 
		$this->select($str);
		if($this->firstRow()) 
			return $this->getField("PERIODE"); 
		else 
			return ""; 
    }	
	
	function getCountByParamsPeriode($paramsArray=array(), $statement="")
	{
		$str = "
		SELECT TANGGAL AS ROWCOUNT FROM PPI_PENILAIAN.MAX_PERIODE
		        WHERE 1=1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return ""; 
    }
	
	function getCountByParamsDataNilai($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.PENILAI) AS ROWCOUNT FROM PPI_PENILAIAN.V_NILAI_PEGAWAI A
		        WHERE 1=1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str; exit;
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return ""; 
    }
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PENILAIAN_PERIODE_ID) AS ROWCOUNT FROM PPI_PENILAIAN.PENILAIAN_PERIODE
		        WHERE PENILAIAN_PERIODE_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PENILAIAN_PERIODE_ID) AS ROWCOUNT FROM PPI_PENILAIAN.PENILAIAN_PERIODE
		        WHERE PENILAIAN_PERIODE_ID IS NOT NULL ".$statement; 
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