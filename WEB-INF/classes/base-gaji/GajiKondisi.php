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

  class GajiKondisi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function GajiKondisi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_GAJI.GAJI_KONDISI (
				   GAJI_KONDISI_ID, GAJI_KONDISI_PARENT_ID, NAMA) 
 			  	VALUES (
				  PPI_GAJI.GAJI_KONDISI_ID_GENERATE('".$this->getField("GAJI_KONDISI_ID")."'),
				  '".$this->getField("GAJI_KONDISI_ID")."',
				  '".$this->getField("NAMA")."'
				)"; 
		$this->id = $this->getField("GAJI_KONDISI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_GAJI.GAJI_KONDISI
				SET    
					   NAMA           = '".$this->getField("NAMA")."'
				WHERE  GAJI_KONDISI_ID     = '".$this->getField("GAJI_KONDISI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.GAJI_KONDISI
                WHERE 
                  GAJI_KONDISI_ID = ".$this->getField("GAJI_KONDISI_ID").""; 
				  
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
				SELECT GAJI_KONDISI_ID, GAJI_KONDISI_PARENT_ID, NAMA, (SELECT COUNT(GAJI_KONDISI_ID) FROM PPI_GAJI.GAJI_KONDISI X WHERE X.GAJI_KONDISI_PARENT_ID = A.GAJI_KONDISI_ID) JUMLAH_CHILD
				FROM PPI_GAJI.GAJI_KONDISI A				
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY GAJI_KONDISI_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsEdit($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqJenisPegawaiId="", $reqKelas="", $reqKelompok="")
	{
		$str = "
				SELECT A.GAJI_KONDISI_ID, B.GAJI_KONDISI_ID GAJI_KONDISI_ID_JENIS_PEGAWAI,GAJI_KONDISI_PARENT_ID, NAMA, 
				  (SELECT COUNT(GAJI_KONDISI_ID) FROM PPI_GAJI.GAJI_KONDISI X WHERE X.GAJI_KONDISI_PARENT_ID = A.GAJI_KONDISI_ID) JUMLAH_CHILD, 
				  CASE WHEN PROSENTASE IS NULL THEN '100' ELSE PROSENTASE END PROSENTASE, CASE WHEN KALI IS NULL THEN '1' ELSE KALI END KALI
				FROM PPI_GAJI.GAJI_KONDISI A LEFT JOIN PPI_GAJI.GAJI_KONDISI_JENIS_PEGAWAI B ON A.GAJI_KONDISI_ID = B.GAJI_KONDISI_ID	
				AND B.JENIS_PEGAWAI_ID = '".$reqJenisPegawaiId."' AND B.KELAS = '".$reqKelas."' AND B.KELOMPOK = '".$reqKelompok."'		
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.GAJI_KONDISI_ID, B.GAJI_KONDISI_ID,GAJI_KONDISI_PARENT_ID, NAMA, PROSENTASE, KALI
  							 ORDER BY A.GAJI_KONDISI_ID ASC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsParameterGaji($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.GAJI_KONDISI_ID ASC ")
	{
		$str = "
				SELECT DISTINCT A.GAJI_KONDISI_ID, A.PREFIX, A.NAMA, CASE WHEN GAJI_DIBERIKAN = 'AWAL_BULAN' THEN 'bulan' ELSE 'hari' END GAJI_DIBERIKAN
				FROM PPI_GAJI.GAJI_KONDISI A 
				INNER JOIN PPI_GAJI.GAJI_KONDISI_JENIS_PEGAWAI B ON A.GAJI_KONDISI_ID = B.GAJI_KONDISI_ID
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
				SELECT GAJI_KONDISI_ID, GAJI_KONDISI_PARENT_ID, NAMA
				FROM PPI_GAJI.GAJI_KONDISI				
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
    
	function selectByParamsKondisi($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT GAJI_KONDISI_ID, GAJI_KONDISI_PARENT_ID, NAMA,PREFIX
				FROM PPI_GAJI.GAJI_KONDISI				
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY GAJI_KONDISI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(GAJI_KONDISI_ID) AS ROWCOUNT FROM PPI_GAJI.GAJI_KONDISI
		        WHERE GAJI_KONDISI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(GAJI_KONDISI_ID) AS ROWCOUNT FROM PPI_GAJI.GAJI_KONDISI
		        WHERE GAJI_KONDISI_ID IS NOT NULL ".$statement; 
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