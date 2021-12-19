<? 
/* *******************************************************************************************************
MODUL NAME 			: PEL
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Jabatan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Jabatan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JABATAN_ID", $this->getNextId("JABATAN_ID","PPI_SIMPEG.JABATAN")); 		

		$str = "
				INSERT INTO PPI_SIMPEG.JABATAN (
				   JABATAN_ID, NAMA, KODE, NO_URUT, KELAS, STATUS, KELOMPOK, LAST_CREATE_USER, LAST_CREATE_DATE, PPH, NAMA_SLIP, KANDIDAT_USIA, KANDIDAT_PENDIDIKAN_KODE, KANDIDAT_PENGALAMAN, DEPARTEMEN_ID) 
 			  	VALUES (
				  ".$this->getField("JABATAN_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KODE")."',
				  '".$this->getField("NO_URUT")."',
				  '".$this->getField("KELAS")."',
				  ".$this->getField("STATUS").",
				  '".$this->getField("KELOMPOK")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("PPH")."',
				  '".$this->getField("NAMA_SLIP")."',
				  '".$this->getField("KANDIDAT_USIA")."',
				  '".$this->getField("KANDIDAT_PENDIDIKAN_KODE")."',
				  '".$this->getField("KANDIDAT_PENGALAMAN")."',
				  '".$this->getField("DEPARTEMEN_ID")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.JABATAN
				SET    
					   NAMA           	= '".$this->getField("NAMA")."',
					   KODE      		= '".$this->getField("KODE")."',
					   NO_URUT    		= '".$this->getField("NO_URUT")."',
					   KELAS         	= '".$this->getField("KELAS")."',
					   STATUS			= ".$this->getField("STATUS").",
					   KELOMPOK			= '".$this->getField("KELOMPOK")."',
						LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
						LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE").",
						PPH				= '".$this->getField("PPH")."',
						NAMA_SLIP		= '".$this->getField("NAMA_SLIP")."',
						KANDIDAT_USIA= '".$this->getField("KANDIDAT_USIA")."',
					    KANDIDAT_PENDIDIKAN_KODE= '".$this->getField("KANDIDAT_PENDIDIKAN_KODE")."',
					  	KANDIDAT_PENGALAMAN= '".$this->getField("KANDIDAT_PENGALAMAN")."',
				  		DEPARTEMEN_ID 	= '".$this->getField("DEPARTEMEN_ID")."'
				WHERE  JABATAN_ID     = '".$this->getField("JABATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.JABATAN
                WHERE 
                  JABATAN_ID = ".$this->getField("JABATAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY DEPARTEMEN_ID, TO_NUMBER(NO_URUT, '999') ASC ")
	{
		$str = "
				SELECT A.JABATAN_ID, A.NAMA, KODE, NO_URUT, KELAS, NAMA_SLIP, STATUS, PPI_SIMPEG.AMBIL_STATUS_CHEKLIST(STATUS) STATUS_NAMA, KELOMPOK, PPH, KANDIDAT_USIA, KANDIDAT_PENDIDIKAN_KODE, KANDIDAT_PENGALAMAN,
                (SELECT X.NAMA FROM PPI_SIMPEG.PENDIDIKAN X WHERE X.KODE = A.KANDIDAT_PENDIDIKAN_KODE) PENDIDIKAN, A.DEPARTEMEN_ID, B.NAMA NAMA_DEPARTEMEN
                FROM PPI_SIMPEG.JABATAN A
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsKandidatJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT A.JABATAN_ID, A.NAMA JABATAN, A.KELAS, B.PEGAWAI_ID, C.NRP, C.NAMA, A.DEPARTEMEN_ID
				FROM PPI_SIMPEG.JABATAN A
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B  ON A.JABATAN_ID = B.JABATAN_ID AND EXISTS(SELECT 1 FROM PPI_SIMPEG.PEGAWAI X WHERE X.PEGAWAI_ID = B.PEGAWAI_ID AND STATUS_PEGAWAI_ID IN (1, 5))
				LEFT JOIN PPI_SIMPEG.PEGAWAI C ON B.PEGAWAI_ID = C.PEGAWAI_ID
				WHERE 1 = 1 AND A.KELOMPOK = 'D' AND A.KELAS BETWEEN 5 AND 9 
                AND (
                      UPPER(A.NAMA) LIKE 'MANAGER%' OR
                      UPPER(A.NAMA) LIKE 'KEPALA%' OR
                      UPPER(A.NAMA) LIKE 'ASISTEN%' OR
                      UPPER(A.NAMA) LIKE 'SUPERVISOR%'                         
                    )
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	

    function selectByParamsJabatanHasilRapat($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqId="")
	{
		$str = "
				SELECT A.JABATAN_ID, NAMA, KODE, NO_URUT, KELAS, STATUS, B.JABATAN_ID JABATAN_ID_HASIL_RAPAT
				FROM PPI_SIMPEG.JABATAN A LEFT JOIN HASIL_RAPAT_JABATAN B ON A.JABATAN_ID = B.JABATAN_ID AND B.HASIL_RAPAT_ID = '".$reqId."'
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TO_NUMBER(KELAS) ASC, A.JABATAN_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsJabatanDokumen($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqId="")
	{
		$str = "
				SELECT A.JABATAN_ID, NAMA, KODE, NO_URUT, KELAS, STATUS, B.JABATAN_ID JABATAN_ID_DOKUMEN
				FROM PPI_SIMPEG.JABATAN A LEFT JOIN PEL_HUKUM.DOKUMEN_JABATAN B ON A.JABATAN_ID = B.JABATAN_ID AND B.DOKUMEN_ID = '".$reqId."'
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TO_NUMBER(KELAS) ASC, A.JABATAN_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsKelas($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KELAS
				  FROM PPI_SIMPEG.JABATAN
				 WHERE 1 = 1 AND KELOMPOK IN ('D', 'K') 
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."GROUP BY KELAS  ORDER BY TO_NUMBER(KELAS) ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT JABATAN_ID, NAMA, KELAS
				  FROM PPI_SIMPEG.JABATAN
				 WHERE 1 = 1 
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	   
	function selectByParamsCombo($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				 SELECT A.JABATAN_ID,  A.NAMA
						FROM PPI_SIMPEG.JABATAN A
						LEFT JOIN PPI_SIMPEG.DEPARTEMEN B ON A.DEPARTEMEN_ID=B.DEPARTEMEN_ID 
						WHERE 1=1
				"; 
		
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
				SELECT JABATAN_ID, NAMA, KODE, NO_URUT, KELAS, STATUS, PPI_SIMPEG.AMBIL_STATUS_CHEKLIST(STATUS) STATUS_NAMA, PPI_SIMPEG.AMBIL_STATUS_KELOMPOK_JABATAN(KELOMPOK) KELOMPOK
				FROM PPI_SIMPEG.JABATAN
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(JABATAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.JABATAN A 
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN B ON A.DEPARTEMEN_ID = B.DEPARTEMEN_ID
		        WHERE JABATAN_ID IS NOT NULL ".$statement; 
		
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
	
    function getCountByParamsKandidatJabatan($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.JABATAN_ID) ROWCOUNT
				FROM PPI_SIMPEG.JABATAN A
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B  ON A.JABATAN_ID = B.JABATAN_ID AND EXISTS(SELECT 1 FROM PPI_SIMPEG.PEGAWAI X WHERE X.PEGAWAI_ID = B.PEGAWAI_ID AND STATUS_PEGAWAI_ID IN (1, 5))
				LEFT JOIN PPI_SIMPEG.PEGAWAI C ON B.PEGAWAI_ID = C.PEGAWAI_ID
				WHERE 1 = 1 AND A.KELOMPOK = 'D' AND A.KELAS BETWEEN 5 AND 9 
                AND (
                      UPPER(A.NAMA) LIKE 'MANAGER%' OR
                      UPPER(A.NAMA) LIKE 'KEPALA%' OR
                      UPPER(A.NAMA) LIKE 'ASISTEN%' OR
                      UPPER(A.NAMA) LIKE 'SUPERVISOR%'                         
                    ) ".$statement; 
		
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
		$str = "SELECT COUNT(JABATAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.JABATAN
		        WHERE JABATAN_ID IS NOT NULL ".$statement; 
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