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

  class PertanyaanPeriode extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PertanyaanPeriode()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PERTANYAAN_PERIODE_ID", $this->getNextId("PERTANYAAN_PERIODE_ID","PPI_PENILAIAN.PERTANYAAN_PERIODE")); 
		
		$str = "			
				INSERT INTO PPI_PENILAIAN.PERTANYAAN_PERIODE(
				   PERTANYAAN_PERIODE_ID, PERTANYAAN_ID, PERIODE, TIPE) 
 			  	VALUES (
				  ".$this->getField("PERTANYAAN_PERIODE_ID").",
				  '".$this->getField("PERTANYAAN_ID")."',
				  '".$this->getField("PERIODE")."',
				  '".$this->getField("TIPE")."'
				)"; 
		$this->id = $this->getField("PERTANYAAN_PERIODE_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_PENILAIAN.PERTANYAAN_PERIODE
				SET    
					   PERTANYAAN_ID			= '".$this->getField("PERTANYAAN_ID")."',
					   PERIODE					= '".$this->getField("PERIODE")."'
				WHERE  PERTANYAAN_PERIODE_ID  	= '".$this->getField("PERTANYAAN_PERIODE_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
		$str = "DELETE FROM PPI_PENILAIAN.PERTANYAAN_PERIODE
                WHERE 
                  PERIODE = '".$this->getField("PERIODE")."' AND TIPE = '".$this->getField("TIPE")."'
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="GROUP BY PERIODE, TIPE")
	{
		$str = "
				SELECT PERIODE, TIPE, CASE WHEN TIPE = 'S' THEN 'STRUKTURAL' ELSE 'FUNGSIONAL' END TIPE_NAMA
				FROM PPI_PENILAIAN.PERTANYAAN_PERIODE
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
	
    function selectByParamsPenilaian($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY C.NO_URUT, B.NO_URUT ASC")
	{
		$str = "
				SELECT A.PERTANYAAN_PERIODE_ID, A.PERTANYAAN_ID, C.NAMA KATEGORI, PERTANYAAN, (SELECT COUNT(JAWABAN_ID) FROM PPI_PENILAIAN.JAWABAN X WHERE A.PERTANYAAN_ID = X.PERTANYAAN_ID) JUMLAH 
				FROM PPI_PENILAIAN.PERTANYAAN_PERIODE A 
				INNER JOIN PPI_PENILAIAN.PERTANYAAN B ON A.PERTANYAAN_ID = B.PERTANYAAN_ID
				INNER JOIN PPI_PENILAIAN.KATEGORI C ON B.KATEGORI_ID = C.KATEGORI_ID          
				WHERE 1=1 "; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
    
    function selectByParamsStatusPenilai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $pegawaiPenilai="")
	{
		$str = "
				SELECT B.STATUS 
				FROM PPI_PENILAIAN.PEGAWAI_PENILAI A 
				INNER JOIN PPI_PENILAIAN.PEGAWAI_PENILAI B ON A.PEGAWAI_PENILAI_ID = B.PEGAWAI_PENILAI_PARENT_ID 
			    WHERE A.PEGAWAI_PENILAI_PARENT_ID = 0 AND B.PEGAWAI_ID = '". $pegawaiPenilai ."' "; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				PERTANYAAN_PERIODE_ID, PERTANYAAN_ID, PERIODE
				FROM PPI_PENILAIAN.PERTANYAAN_PERIODE				
				WHERE 1 = 1		
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PERTANYAAN_PERIODE_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "
		SELECT COUNT(PERIODE) AS ROWCOUNT
		FROM
		(
		SELECT PERIODE, TIPE,
		CASE WHEN TIPE = 'S' THEN 'STRUKTURAL' ELSE 'FUNGSIONAL' END TIPE_NAMA
		FROM PPI_PENILAIAN.PERTANYAAN_PERIODE
		GROUP BY PERIODE, TIPE
		)
		"; 
		
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
		$str = "SELECT COUNT(PERTANYAAN_PERIODE_ID) AS ROWCOUNT FROM PPI_PENILAIAN.PERTANYAAN_PERIODE
		        WHERE PERTANYAAN_PERIODE_ID IS NOT NULL ".$statement; 
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