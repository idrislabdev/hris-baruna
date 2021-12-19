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

  class LainKondisi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function LainKondisi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_GAJI.LAIN_KONDISI (
				   LAIN_KONDISI_ID, LAIN_KONDISI_PARENT_ID, NAMA) 
 			  	VALUES (
				  PPI_GAJI.LAIN_KONDISI_ID_GENERATE('".$this->getField("LAIN_KONDISI_ID")."'),
				  '".$this->getField("LAIN_KONDISI_ID")."',
				  '".$this->getField("NAMA")."'
				)"; 
		$this->id = $this->getField("LAIN_KONDISI_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_GAJI.LAIN_KONDISI
				SET    
					   NAMA           = '".$this->getField("NAMA")."'
				WHERE  LAIN_KONDISI_ID     = '".$this->getField("LAIN_KONDISI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.LAIN_KONDISI
                WHERE 
                  LAIN_KONDISI_ID = ".$this->getField("LAIN_KONDISI_ID").""; 
				  
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
	
	function selectByParamsSimple($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqId="")
	{
		$str = "
				SELECT 
				A.LAIN_KONDISI_ID, LAIN_KONDISI_PARENT_ID, CASE WHEN LAIN_KONDISI_PARENT_ID = 0 THEN '>> ' || A.NAMA ELSE '- ' || A.NAMA END NAMA, PREFIX, LAST_CREATE_USER, LAST_CREATE_DATE, LAST_UPDATE_USER, LAST_UPDATE_DATE
				FROM PPI_GAJI.LAIN_KONDISI A
				 WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY LAIN_KONDISI_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqId="")
	{
		$str = "
				SELECT A.LAIN_KONDISI_ID, LAIN_KONDISI_PARENT_ID, NAMA, B.LAIN_KONDISI_ID LAIN_KONDISI_ID_PEGAWAI,
						JUMLAH_TOTAL, ANGSURAN, BULAN_MULAI, JUMLAH_AWAL_ANGSURAN, JUMLAH_ANGSURAN,	ANGSURAN_TERBAYAR, BULAN_AKHIR_BAYAR,
						A.NAMA LAIN_KONDISI_NAMA, B.KETERANGAN, B.LAIN_KONDISI_PEGAWAI_ID, CASE WHEN ANGSURAN_TERBAYAR = ANGSURAN THEN 1 ELSE 0 END URUT
				  FROM PPI_GAJI.LAIN_KONDISI A LEFT JOIN PPI_GAJI.LAIN_KONDISI_PEGAWAI B ON A.LAIN_KONDISI_ID = B.LAIN_KONDISI_ID AND B.PEGAWAI_ID = '".$reqId."'
				 WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY URUT ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsEdit($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqJenisPegawaiId="", $reqKelas="", $reqKelompok="")
	{
		$str = "
				SELECT A.LAIN_KONDISI_ID, B.LAIN_KONDISI_ID LAIN_KONDISI_ID_JENIS_PEGAWAI,LAIN_KONDISI_PARENT_ID, NAMA, 
				  (SELECT COUNT(LAIN_KONDISI_ID) FROM PPI_GAJI.LAIN_KONDISI X WHERE X.LAIN_KONDISI_PARENT_ID = A.LAIN_KONDISI_ID) JUMLAH_CHILD, 
				  CASE WHEN PROSENTASE IS NULL THEN '100' ELSE PROSENTASE END PROSENTASE, CASE WHEN KALI IS NULL THEN '1' ELSE KALI END KALI
				FROM PPI_GAJI.LAIN_KONDISI A LEFT JOIN PPI_GAJI.LAIN_KONDISI_JENIS_PEGAWAI B ON A.LAIN_KONDISI_ID = B.LAIN_KONDISI_ID	
				AND B.JENIS_PEGAWAI_ID = '".$reqJenisPegawaiId."' AND B.KELAS = '".$reqKelas."' AND B.KELOMPOK = '".$reqKelompok."'		
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.LAIN_KONDISI_ID, B.LAIN_KONDISI_ID,LAIN_KONDISI_PARENT_ID, NAMA, PROSENTASE, KALI
  							 ORDER BY A.LAIN_KONDISI_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT LAIN_KONDISI_ID, LAIN_KONDISI_PARENT_ID, NAMA
				FROM PPI_GAJI.LAIN_KONDISI				
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
		$str = "SELECT COUNT(LAIN_KONDISI_ID) AS ROWCOUNT FROM PPI_GAJI.LAIN_KONDISI
		        WHERE LAIN_KONDISI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(LAIN_KONDISI_ID) AS ROWCOUNT FROM PPI_GAJI.LAIN_KONDISI
		        WHERE LAIN_KONDISI_ID IS NOT NULL ".$statement; 
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