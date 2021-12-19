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

  class PegawaiPenilai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiPenilai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("PEGAWAI_PENILAI_ID", $this->getNextId("PEGAWAI_PENILAI_ID","PPI_PENILAIAN.PEGAWAI_PENILAI")); 
		
		$str = "
				INSERT INTO PPI_PENILAIAN.PEGAWAI_PENILAI (
				   PEGAWAI_PENILAI_ID, PEGAWAI_PENILAI_PARENT_ID, PEGAWAI_ID, 
				   PERIODE, STATUS) 
 			  	VALUES (
				  '".$this->getField("PEGAWAI_PENILAI_ID")."',
				  '".$this->getField("PEGAWAI_PENILAI_PARENT_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("PERIODE")."',
				  '".$this->getField("STATUS")."'
				)"; 
		$this->id = $this->getField("PEGAWAI_PENILAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_PENILAIAN.PEGAWAI_PENILAI
				SET    
					   PEGAWAI_ID					= '".$this->getField("PEGAWAI_ID")."',
					   PERIODE						= '".$this->getField("PERIODE")."',
					   STATUS						= '".$this->getField("STATUS")."'
				WHERE  PEGAWAI_PENILAI_ID  			= '".$this->getField("PEGAWAI_PENILAI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_PENILAIAN.PEGAWAI_PENILAI
                WHERE 
                  PEGAWAI_PENILAI_ID = ".$this->getField("PEGAWAI_PENILAI_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteParent()
	{
        $str = "DELETE FROM PPI_PENILAIAN.PEGAWAI_PENILAI
                WHERE 
                  PEGAWAI_PENILAI_PARENT_ID= ".$this->getField("PEGAWAI_PENILAI_PARENT_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY PEGAWAI_PENILAI_ID ASC")
	{
		$str = "
				SELECT 
				PEGAWAI_PENILAI_ID, PEGAWAI_PENILAI_PARENT_ID, A.PEGAWAI_ID, PERIODE, STATUS, B.NAMA, B.NRP, C.NAMA JABATAN_NAMA 
				FROM PPI_PENILAIAN.PEGAWAI_PENILAI A
				LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
 
    function selectByParamsSemuaPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.PEGAWAI_ID ASC")
	{
		$str = "
				SELECT A.PEGAWAI_ID, A.NAMA || ' (' ||  B.NAMA || ')' AS NAMA 
				FROM PPI_SIMPEG.PEGAWAI A
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID 
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPegawaiMenilai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="", $pegawai_id='')
	{
		$str = "
				SELECT 
			'". $pegawai_id ."' PENILAI, A.PEGAWAI_ID DINILAI,  A.NAMA, 
			CASE WHEN D.JABATAN_ID IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,112,113,114,115,116,117,134,138,139,103) THEN 'S' WHEN D.KELOMPOK = 'K' THEN 'F' ELSE 'P' END TYPE,
			 ( SELECT STATUS FROM PPI_PENILAIAN.PEGAWAI_PENILAI X WHERE X.PEGAWAI_ID = '". $pegawai_id ."' AND NOT X.PEGAWAI_PENILAI_PARENT_ID = 0 AND X.PEGAWAI_PENILAI_PARENT_ID = I.PEGAWAI_PENILAI_ID) STATUS

			FROM PPI_SIMPEG.PEGAWAI A 
			LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
			INNER JOIN PPI_PENILAIAN.PEGAWAI_PENILAI  I  ON A.PEGAWAI_ID = I.PEGAWAI_ID 
			WHERE 1 = 1 AND EXISTS ( SELECT 1 FROM PPI_PENILAIAN.PEGAWAI_PENILAI X WHERE X.PEGAWAI_ID = '". $pegawai_id ."' AND NOT X.PEGAWAI_PENILAI_PARENT_ID = 0 AND X.PEGAWAI_PENILAI_PARENT_ID = I.PEGAWAI_PENILAI_ID) 
			AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) AND ((UPPER(A.NAMA) LIKE '%%') OR (UPPER(A.NIPP) LIKE '%%'))
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDiriSendiri($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "
				SELECT 
				A.PEGAWAI_ID, A.NAMA, A.NRP, B.NAMA JABATAN_NAMA 
				FROM PPI_SIMPEG.PEGAWAI A
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPenilaiImport($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="")
	{
		$str = "SELECT DISTINCT
                A.PEGAWAI_ID_PENILAI PEGAWAI_ID, B.NAMA
                FROM PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI A
                LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID_PENILAI = B.PEGAWAI_ID
                WHERE  1=1 
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."  " .$sOrder ;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	function selectByParamsViewDataPenilai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="", $deptId='')
	{
		$str = "
				SELECT 
				PEGAWAI_ID, NAMA, DEPARTEMEN, PEGAWAI_PENILAI_PARENT_ID, DIRI_SENDIRI, DIRI_SENDIRI_NAMA, ATASAN, ATASAN_NAMA, REKAN, REKAN_NAMA, BAWAHAN, BAWAHAN_NAMA
				/*
				SELECT 
				    PEGAWAI_ID, NAMA, DEPARTEMEN, PEGAWAI_PENILAI_PARENT_ID, DIRI_SENDIRI, DIRI_SENDIRI_NAMA, ATASAN, 
				    CASE WHEN LENGTH(ATASAN) > 4 THEN 'MR X, MR X' WHEN  LENGTH(ATASAN) < 4 THEN '' ELSE 'MR X' END ATASAN_NAMA, 
			        REKAN, 
			        CASE WHEN LENGTH(REKAN) > 4 THEN 'MR X, MR X' WHEN  LENGTH(REKAN) < 4 THEN '' ELSE 'MR X' END REKAN_NAMA, 
			        BAWAHAN, 
			        CASE WHEN LENGTH(BAWAHAN) > 4 THEN 'MR X, MR X' WHEN  LENGTH(BAWAHAN) < 4 THEN '' ELSE 'MR X' END BAWAHAN_NAMA 
			    */
				FROM PPI_PENILAIAN.V_PEGAWAI_PENILAI_DATA A
				WHERE 1 = 1
				/*AND A.DEPARTEMEN_ID NOT LIKE '". $deptId ."%' */ ";
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement;
		/*$str .= "		UNION ALL
				SELECT 
			        PEGAWAI_ID, NAMA, DEPARTEMEN, PEGAWAI_PENILAI_PARENT_ID, DIRI_SENDIRI, DIRI_SENDIRI_NAMA, ATASAN, 
			        CASE WHEN LENGTH(ATASAN) > 4 THEN 'MR X, MR X' WHEN  LENGTH(ATASAN) < 4 THEN '' ELSE 'MR X' END ATASAN_NAMA, 
			        REKAN, 
			        CASE WHEN LENGTH(REKAN) > 4 THEN 'MR X, MR X' WHEN  LENGTH(REKAN) < 4 THEN '' ELSE 'MR X' END REKAN_NAMA, 
			        BAWAHAN, 
			        CASE WHEN LENGTH(BAWAHAN) > 4 THEN 'MR X, MR X' WHEN  LENGTH(BAWAHAN) < 4 THEN '' ELSE 'MR X' END BAWAHAN_NAMA
				FROM PPI_PENILAIAN.V_PEGAWAI_PENILAI_DATA A
				WHERE 1 = 1
				AND A.DEPARTEMEN_ID LIKE '". $deptId ."%' 
				"; */
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		//echo $str . $limit . $from; exit;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsPenilaian($paramsArray=array(),$limit=-1,$from=-1, $statement="", $pegawai_id="", $sOrder="ORDER BY A.PEGAWAI_ID ASC")
	{
		$str = "
				SELECT 
                D.KELAS, D.NAMA JABATAN_NAMA, CASE WHEN UPPER(D.NAMA) LIKE 'DIREKTUR%' 
                       OR UPPER(D.NAMA) LIKE 'MANAGER%' 
                       OR UPPER(D.NAMA) LIKE 'KEPALA%'
                       OR UPPER(D.NAMA) LIKE 'ASISTEN%'
                       OR UPPER(D.NAMA) LIKE 'SUPERVISOR%'
                       THEN 'S' ELSE 'F' END STATUS_JABATAN, A.PEGAWAI_ID, NRP, NIPP, A.NAMA, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, PPI_SIMPEG.AMBIL_STATUS_NIKAH(STATUS_KAWIN) STATUS_KAWIN, STATUS_KAWIN STATUS_KAWIN_ID,GOLONGAN_DARAH, A.ALAMAT, TELEPON, EMAIL,
                A.DEPARTEMEN_ID, PPI_SIMPEG.AMBIL_UNIT_KERJA(NVL(A.DEPARTEMEN_ID,0)) DEPARTEMEN, A.AGAMA_ID, A.STATUS_PEGAWAI_ID, A.BANK_ID, REKENING_NO, REKENING_NAMA, NPWP, E.NAMA STATUS_PEGAWAI_NAMA,
                NVL((SELECT CASE WHEN SUM(1) > 0 THEN 1 ELSE 0 END STATUS FROM PPI_PENILAIAN.PERTANYAAN_PERIODE_PEGAWAI X INNER JOIN PPI_PENILAIAN.PERTANYAAN_PERIODE Y ON X.PERTANYAAN_ID = Y.PERTANYAAN_ID 
                WHERE X.PEGAWAI_ID_PENILAI = ".$pegawai_id." AND X.PEGAWAI_ID_DINILAI = A.PEGAWAI_ID AND Y.PERIODE = I.PERIODE), 0) STATUS
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.STATUS_PEGAWAI E ON A.STATUS_PEGAWAI_ID = E.STATUS_PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR G ON A.PEGAWAI_ID = G.PEGAWAI_ID
                INNER JOIN PPI_PENILAIAN.PEGAWAI_PENILAI I ON A.PEGAWAI_ID = I.PEGAWAI_ID
                WHERE 1 = 1 AND EXISTS (
                                  SELECT 1
                                    FROM PPI_PENILAIAN.PEGAWAI_PENILAI X
                                   WHERE X.PEGAWAI_ID = ".$pegawai_id."
                                     AND NOT X.PEGAWAI_PENILAI_PARENT_ID = 0
                                     AND X.PEGAWAI_PENILAI_PARENT_ID = I.PEGAWAI_PENILAI_ID)
				"; 
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
				SELECT 
				PEGAWAI_PENILAI_ID, PEGAWAI_PENILAI_PARENT_ID, PEGAWAI_ID, PERIODE, STATUS
				FROM PPI_PENILAIAN.PEGAWAI_PENILAI				
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PEGAWAI_PENILAI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	function getCountByParamsGenerate($statement="")
	{
		$str = "SELECT PPI_PENILAIAN.PEGAWAI_PENILAI_ID_GENERATE('".$statement."') AS ROWCOUNT FROM DUAL"; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	

    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_PENILAI_ID) AS ROWCOUNT FROM PPI_PENILAIAN.PEGAWAI_PENILAI
		        WHERE PEGAWAI_PENILAI_ID IS NOT NULL ".$statement; 
		
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

		
    function getCountByParamsDataPenilai($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_PENILAIAN.V_PEGAWAI_PENILAI_DATA
		        WHERE PEGAWAI_ID IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//ECHO $str; exit;
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
									 
    function getCountByParamsPenilaian($paramsArray=array(), $statement="", $pegawai_id= "")
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID)  AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI A 
                INNER JOIN PPI_PENILAIAN.PEGAWAI_PENILAI I ON A.PEGAWAI_ID = I.PEGAWAI_ID
                WHERE 1 = 1 AND EXISTS (
                                  SELECT 1
                                    FROM PPI_PENILAIAN.PEGAWAI_PENILAI X
                                   WHERE X.PEGAWAI_ID = ".$pegawai_id."
                                     AND NOT X.PEGAWAI_PENILAI_PARENT_ID = 0
                                     AND X.PEGAWAI_PENILAI_PARENT_ID = I.PEGAWAI_PENILAI_ID) ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_PENILAI_ID) AS ROWCOUNT FROM PPI_PENILAIAN.PEGAWAI_PENILAI
		        WHERE PEGAWAI_PENILAI_ID IS NOT NULL ".$statement; 
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