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

  class Kondisi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Kondisi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_GAJI.KONDISI (
				   KONDISI_ID, KONDISI_PARENT_ID, NAMA) 
 			  	VALUES (
				  PPI_GAJI.KONDISI_ID_GENERATE('".$this->getField("KONDISI_ID")."'),
				  '".$this->getField("KONDISI_ID")."',
				  '".$this->getField("NAMA")."'
				)"; 
		$this->id = $this->getField("KONDISI_ID");
		$this->query = $str;
		echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_GAJI.KONDISI
				SET    
					   NAMA           = '".$this->getField("NAMA")."'
				WHERE  KONDISI_ID     = '".$this->getField("KONDISI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.KONDISI
                WHERE 
                  KONDISI_ID = ".$this->getField("KONDISI_ID").""; 
				  
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
				SELECT KONDISI_ID, KONDISI_PARENT_ID, NAMA, (SELECT COUNT(KONDISI_ID) FROM PPI_GAJI.KONDISI X WHERE X.KONDISI_PARENT_ID = A.KONDISI_ID) JUMLAH_CHILD
				FROM PPI_GAJI.KONDISI A				
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KONDISI_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsEdit($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqJenisPegawaiId="", $reqKelas="", $reqKelompok="")
	{
		$str = "
				SELECT A.KONDISI_ID, B.KONDISI_ID KONDISI_ID_JENIS_PEGAWAI,KONDISI_PARENT_ID, NAMA, 
				  (SELECT COUNT(KONDISI_ID) FROM PPI_GAJI.KONDISI X WHERE X.KONDISI_PARENT_ID = A.KONDISI_ID) JUMLAH_CHILD, 
				  CASE WHEN PROSENTASE IS NULL THEN '100' ELSE PROSENTASE END PROSENTASE, CASE WHEN KALI IS NULL THEN '1' ELSE KALI END KALI
				FROM PPI_GAJI.KONDISI A LEFT JOIN PPI_GAJI.KONDISI_JENIS_PEGAWAI B ON A.KONDISI_ID = B.KONDISI_ID	
				AND B.JENIS_PEGAWAI_ID = '".$reqJenisPegawaiId."' AND B.KELAS = '".$reqKelas."' AND B.KELOMPOK = '".$reqKelompok."'		
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.KONDISI_ID, B.KONDISI_ID,KONDISI_PARENT_ID, NAMA, PROSENTASE, KALI
  							 ORDER BY A.KONDISI_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KONDISI_ID, KONDISI_PARENT_ID, NAMA
				FROM PPI_GAJI.KONDISI				
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
		$str = "SELECT COUNT(KONDISI_ID) AS ROWCOUNT FROM PPI_GAJI.KONDISI
		        WHERE KONDISI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KONDISI_ID) AS ROWCOUNT FROM PPI_GAJI.KONDISI
		        WHERE KONDISI_ID IS NOT NULL ".$statement; 
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