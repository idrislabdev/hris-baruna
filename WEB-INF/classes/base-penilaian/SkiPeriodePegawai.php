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

  class SkiPeriodePegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SkiPeriodePegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SKI_PERIODE_PEGAWAI_ID", $this->getNextId("SKI_PERIODE_PEGAWAI_ID","PPI_PENILAIAN.SKI_PERIODE_PEGAWAI")); 
		
		$str = "			
				INSERT INTO PPI_PENILAIAN.SKI_PERIODE_PEGAWAI (
				   SKI_PERIODE_PEGAWAI_ID, PEGAWAI_ID, PERIODE, NILAI, LAST_CREATED_DATE, LAST_CREATED_BY) 
 			  	VALUES (
				  ".$this->getField("SKI_PERIODE_PEGAWAI_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("PERIODE")."',
				  '".$this->getField("NILAI")."',
				  SYSDATE,
				  '".$this->getField("LAST_CREATED_BY")."'
				)"; 
		$this->id = $this->getField("SKI_PERIODE_PEGAWAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_PENILAIAN.SKI_PERIODE_PEGAWAI
				SET    
					   PERIODE		= '".$this->getField("PERIODE")."',
					   NILAI		= '".$this->getField("NILAI")."',
					   LAST_UPDATED_DATE		= SYSDATE,
					   LAST_UPDATED_BY		= '".$this->getField("LAST_UPDATED_BY")."'
				WHERE  SKI_PERIODE_PEGAWAI_ID  	= '".$this->getField("SKI_PERIODE_PEGAWAI_ID")."' 
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
		$str = "DELETE FROM PPI_PENILAIAN.SKI_PERIODE_PEGAWAI
                WHERE 
                  PERIODE = '".$this->getField("PERIODE")."' AND NILAI = '".$this->getField("NILAI")."'
			"; 
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteAll($reqPeriode='')
	{
		$str = "DELETE FROM PPI_PENILAIAN.SKI_PERIODE_PEGAWAI A WHERE A.PERIODE = '". $reqPeriode ."' "; 
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY SKI_PERIODE_PEGAWAI_ID ASC")
	{
		$str = "
				SELECT 
				SKI_PERIODE_PEGAWAI_ID, A.PEGAWAI_ID,A.NAMA, A.NRP, B.NAMA JABATAN_NAMA, NILAI, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN
                FROM PPI_PENILAIAN.PEGAWAI_PENILAI D 
                LEFT JOIN PPI_SIMPEG.PEGAWAI A ON D.PEGAWAI_ID = A.PEGAWAI_ID 
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                LEFT JOIN PPI_PENILAIAN.SKI_PERIODE_PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsNew($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY SKI_PERIODE_PEGAWAI_ID ASC")
	{
		$str = "
				SELECT 
				A.PEGAWAI_ID, C.SKI_PERIODE_PEGAWAI_ID, B.NAMA, B.NRP, NVL(C.NILAI,0) NILAI, D.NAMA JABATAN_NAMA, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(B.DEPARTEMEN_ID,0)) DEPARTEMEN
				FROM (SELECT DISTINCT PEGAWAI_ID FROM 
				(SELECT Y.PEGAWAI_ID
				FROM PPI_PENILAIAN.PEGAWAI_PENILAI Y
				WHERE Y.PEGAWAI_PENILAI_PARENT_ID = 0
				UNION ALL 
				SELECT DISTINCT A.PEGAWAI_ID
				FROM PPI_SIMPEG.PEGAWAI A
				INNER JOIN (
				    SELECT X.PEGAWAI_ID, MAX(X.TMT_SK) TMT_SK 
				    FROM PPI_SIMPEG.PEGAWAI_STATUS_PEGAWAI X 
				    GROUP BY X.PEGAWAI_ID ) 
				    B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.TMT_SK >= TO_DATE('01012014', 'DDMMYYYY')
				WHERE A.STATUS_PEGAWAI_ID IN (3,5)
				)) A
				LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				LEFT JOIN PPI_PENILAIAN.SKI_PERIODE_PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID  
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
				WHERE D.KELAS > 0 
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsReturnOne($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT 
				SKI_PERIODE_PEGAWAI_ID, PEGAWAI_ID, PERIODE, NILAI, LAST_CREATED_DATE, LAST_CREATED_BY, LAST_UPDATED_DATE, LAST_UPDATED_BY 
                FROM PPI_PENILAIAN.SKI_PERIODE_PEGAWAI A 
                WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsNilai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT ROWNUM NO, C.NAMA,  A.PEGAWAI_ID, E.NAMA DEPARTEMEN, 
				CASE WHEN F.JABATAN_ID IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,112,113,114,115,116,117,134,138,139,103, 136) THEN 'STRUKTURAL' 
        		WHEN F.KELOMPOK = 'D' THEN 'PELAKSANA' ELSE 'FUNGSIONAL' END TYPE_PEGAWAI
				, NVL(B.NILAI,0) NILAI_SKI
                FROM PPI_PENILAIAN.PEGAWAI_PENILAI A
                LEFT JOIN PPI_SIMPEG.PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID 
                LEFT JOIN PPI_PENILAIAN.SKI_PERIODE_PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN E ON SUBSTR(C.DEPARTEMEN_ID, 0,2) = E.DEPARTEMEN_ID 
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR F ON A.PEGAWAI_ID = F.PEGAWAI_ID 
                WHERE A.PEGAWAI_PENILAI_PARENT_ID = 0 
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str;
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				SKI_PERIODE_PEGAWAI_ID, PEGAWAI_ID, PERIODE, NILAI
				FROM PPI_PENILAIAN.SKI_PERIODE_PEGAWAI				
				WHERE 1 = 1	
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY SKI_PERIODE_PEGAWAI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
				COUNT(A.PEGAWAI_ID) ROWCOUNT
				FROM PPI_PENILAIAN.PEGAWAI_PENILAI D 
                LEFT JOIN PPI_SIMPEG.PEGAWAI A ON D.PEGAWAI_ID = A.PEGAWAI_ID 
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				LEFT JOIN PPI_PENILAIAN.SKI_PERIODE_PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				WHERE 1 = 1
				".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		//ECHO $str;exit;
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsNew($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
				COUNT(A.PEGAWAI_ID) ROWCOUNT
				 FROM (SELECT DISTINCT PEGAWAI_ID FROM 
                (SELECT Y.PEGAWAI_ID
                FROM PPI_PENILAIAN.PEGAWAI_PENILAI Y
                WHERE Y.PEGAWAI_PENILAI_PARENT_ID = 0
                UNION ALL 
                SELECT DISTINCT A.PEGAWAI_ID
                FROM PPI_SIMPEG.PEGAWAI A
                INNER JOIN (
                    SELECT X.PEGAWAI_ID, MAX(X.TMT_SK) TMT_SK 
                    FROM PPI_SIMPEG.PEGAWAI_STATUS_PEGAWAI X 
                    GROUP BY X.PEGAWAI_ID ) 
                    B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND B.TMT_SK >= TO_DATE('01012014', 'DDMMYYYY')
                WHERE A.STATUS_PEGAWAI_ID IN (3,5)
                )) A
                LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                LEFT JOIN PPI_PENILAIAN.SKI_PERIODE_PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID  
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                WHERE D.KELAS > 0 
				".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		//ECHO $str;exit;
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsNilai($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
				COUNT(A.PEGAWAI_ID) ROWCOUNT
				 FROM PPI_PENILAIAN.PEGAWAI_PENILAI A
                LEFT JOIN PPI_SIMPEG.PEGAWAI C ON A.PEGAWAI_ID = C.PEGAWAI_ID 
                LEFT JOIN PPI_PENILAIAN.SKI_PERIODE_PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN E ON SUBSTR(C.DEPARTEMEN_ID, 0,2) = E.DEPARTEMEN_ID 
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR F ON A.PEGAWAI_ID = F.PEGAWAI_ID 
                WHERE A.PEGAWAI_PENILAI_PARENT_ID = 0 
				".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		//echo $str;exit;
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SKI_PERIODE_PEGAWAI_ID) AS ROWCOUNT FROM PPI_PENILAIAN.SKI_PERIODE_PEGAWAI
		        WHERE SKI_PERIODE_PEGAWAI_ID IS NOT NULL ".$statement; 
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