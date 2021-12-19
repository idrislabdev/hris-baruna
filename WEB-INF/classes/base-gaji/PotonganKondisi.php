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
  * Entity-base class untuk mengimplementasikan tabel DEPARTEMEN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PotonganKondisi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PotonganKondisi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_GAJI.POTONGAN_KONDISI (
				   POTONGAN_KONDISI_ID, POTONGAN_KONDISI_PARENT_ID, NAMA, STATUS_IMPORT) 
 			  	VALUES (
				  PPI_GAJI.POTONGAN_KONDISI_ID_GENERATE('".$this->getField("POTONGAN_KONDISI_ID")."'),
				  '".$this->getField("POTONGAN_KONDISI_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("STATUS_IMPORT")."'
				)"; 
		$this->id = $this->getField("POTONGAN_KONDISI_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_GAJI.POTONGAN_KONDISI
				SET    
					   NAMA           = '".$this->getField("NAMA")."',
					   STATUS_IMPORT           = '".$this->getField("STATUS_IMPORT")."'
				WHERE  POTONGAN_KONDISI_ID     = '".$this->getField("POTONGAN_KONDISI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.POTONGAN_KONDISI
                WHERE 
                  POTONGAN_KONDISI_ID = ".$this->getField("POTONGAN_KONDISI_ID").""; 
				  
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
				SELECT POTONGAN_KONDISI_ID, POTONGAN_KONDISI_PARENT_ID, NAMA, RUMUS, STATUS_IMPORT,
				(SELECT COUNT(POTONGAN_KONDISI_ID) FROM PPI_GAJI.POTONGAN_KONDISI X WHERE X.POTONGAN_KONDISI_PARENT_ID = A.POTONGAN_KONDISI_ID) JUMLAH_CHILD
				FROM PPI_GAJI.POTONGAN_KONDISI A				
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY POTONGAN_KONDISI_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsPotongan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $jenis_pegawai="", $kelas="", $reqId="")
	{
		$str = "
				 SELECT DISTINCT B.POTONGAN_KONDISI_ID, B.POTONGAN_KONDISI_PARENT_ID, A.JUMLAH JUMLAH_RUMUS, 
						CASE WHEN B.POTONGAN_KONDISI_PARENT_ID = 0 THEN '' ELSE (SELECT NAMA FROM PPI_GAJI.POTONGAN_KONDISI X WHERE X.POTONGAN_KONDISI_ID = B.POTONGAN_KONDISI_PARENT_ID) END PARENT_NAMA, 
						B.NAMA, C.POTONGAN_KONDISI_ID POTONGAN_KONDISI_ID_PEGAWAI, C.JUMLAH, B.PREFIX, STATUS_IMPORT
					FROM PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI A 
					INNER JOIN PPI_GAJI.POTONGAN_KONDISI B
						ON A.POTONGAN_KONDISI_ID = B.POTONGAN_KONDISI_ID AND 
						JENIS_PEGAWAI_ID = ".$jenis_pegawai." AND JENIS_POTONGAN IN ('P') AND
						".$kelas." IN (SELECT REGEXP_SUBSTR(A.KELAS,'[^,]+', 1, LEVEL) FROM DUAL CONNECT BY REGEXP_SUBSTR(A.KELAS, '[^,]+', 1, LEVEL) IS NOT NULL) 
					LEFT JOIN PPI_GAJI.POTONGAN_KONDISI_PEGAWAI C ON A.POTONGAN_KONDISI_ID = C.POTONGAN_KONDISI_ID  AND C.PEGAWAI_ID = '".$reqId."'
					WHERE 1 = 1 
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY B.POTONGAN_KONDISI_ID";
		//echo $str; exit;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsEdit($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqJenisPegawaiId="", $reqKelas="", $reqKelompok="")
	{
		$str = "
				SELECT A.POTONGAN_KONDISI_ID, B.POTONGAN_KONDISI_ID POTONGAN_KONDISI_ID_JP,POTONGAN_KONDISI_PARENT_ID, NAMA, OPSI, RUMUS,
				  (SELECT COUNT(POTONGAN_KONDISI_ID) FROM PPI_GAJI.POTONGAN_KONDISI X WHERE X.POTONGAN_KONDISI_PARENT_ID = A.POTONGAN_KONDISI_ID) JUMLAH_CHILD, 
				  CASE WHEN PROSENTASE IS NULL THEN '100' ELSE PROSENTASE END PROSENTASE, CASE WHEN KALI IS NULL THEN '1' ELSE KALI END KALI, JUMLAH_ENTRI, JENIS_POTONGAN,
				  PPI_GAJI.KONVERSI_ID_NAMA_KONDISI(B.JUMLAH) ISI_JUMLAH, STATUS_IMPORT
				FROM PPI_GAJI.POTONGAN_KONDISI A LEFT JOIN PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI B ON A.POTONGAN_KONDISI_ID = B.POTONGAN_KONDISI_ID	
				AND B.JENIS_PEGAWAI_ID = '".$reqJenisPegawaiId."' AND B.KELAS = '".$reqKelas."' AND B.KELOMPOK = '".$reqKelompok."'		
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.POTONGAN_KONDISI_ID, B.POTONGAN_KONDISI_ID,POTONGAN_KONDISI_PARENT_ID, NAMA, OPSI, RUMUS, PROSENTASE, KALI, JUMLAH_ENTRI, JENIS_POTONGAN, B.JUMLAH, STATUS_IMPORT
  							 ORDER BY A.POTONGAN_KONDISI_ID ASC";
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsEditOpsi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqJenisPegawaiId="", $reqKelas="", $reqKelompok="", $reqPegawaiId)
	{
		$str = "
				 SELECT A.POTONGAN_KONDISI_JENIS_PEGAWAI, NAMA, JUMLAH, CASE WHEN NVL(C.PEGAWAI_ID, 0) = 0 THEN 'checked' ELSE '' END CHECKED, STATUS_IMPORT
				FROM PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI A
				LEFT JOIN PPI_GAJI.POTONGAN_OPSI_TIDAK_PEGAWAI C ON A.POTONGAN_KONDISI_JENIS_PEGAWAI = C.POTONGAN_KONDISI_JENIS_PEGAWAI AND C.PEGAWAI_ID = '".$reqPegawaiId."'
				,PPI_GAJI.POTONGAN_KONDISI B 
				WHERE 
				A.POTONGAN_KONDISI_ID = B.POTONGAN_KONDISI_ID AND KELOMPOK = '".$reqKelompok."' AND
				JENIS_PEGAWAI_ID = ".$reqJenisPegawaiId." AND OPSI = 'Y' AND NOT A.JUMLAH = '03' AND
				".$reqKelas." IN (SELECT REGEXP_SUBSTR(A.KELAS,'[^,]+', 1, LEVEL) FROM DUAL CONNECT BY REGEXP_SUBSTR(A.KELAS, '[^,]+', 1, LEVEL) IS NOT NULL)
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.POTONGAN_KONDISI_ID ASC ";
		//echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
    function selectByParamsParameterPotongan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.POTONGAN_KONDISI_ID ASC ")
	{
		$str = "
				SELECT DISTINCT A.POTONGAN_KONDISI_ID, A.PREFIX, A.NAMA, STATUS_IMPORT
				FROM PPI_GAJI.POTONGAN_KONDISI A 
				INNER JOIN PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI B ON A.POTONGAN_KONDISI_ID = B.POTONGAN_KONDISI_ID
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT POTONGAN_KONDISI_ID, POTONGAN_KONDISI_PARENT_ID, NAMA, STATUS_IMPORT
				FROM PPI_GAJI.POTONGAN_KONDISI				
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
		$str = "SELECT COUNT(POTONGAN_KONDISI_ID) AS ROWCOUNT FROM PPI_GAJI.POTONGAN_KONDISI
		        WHERE POTONGAN_KONDISI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(POTONGAN_KONDISI_ID) AS ROWCOUNT FROM PPI_GAJI.POTONGAN_KONDISI
		        WHERE POTONGAN_KONDISI_ID IS NOT NULL ".$statement; 
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

    function selectByParamsKondisi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY DEPARTEMEN_ID")
	{
		$str = "
			    SELECT POTONGAN_KONDISI_ID, NAMA FROM PPI_GAJI.POTONGAN_KONDISI

			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
  } 
?>