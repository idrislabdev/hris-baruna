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
  * Entity-base class untuk mengimplementasikan tabel PANGKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KonsinyeringBesaran extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KonsinyeringBesaran()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KONSINYERING_BESARAN_ID", $this->getNextId("KONSINYERING_BESARAN_ID","PPI_SPPD.KONSINYERING_BESARAN"));
		$str = "
				INSERT INTO PPI_SPPD.KONSINYERING_BESARAN (
				   KONSINYERING_BESARAN_ID, JABATAN_KONSINYERING_ID, KELAS_AWAL, KELAS_AKHIR, JUMLAH) 
				VALUES (
				  ".$this->getField("KONSINYERING_BESARAN_ID").",
				  '".$this->getField("JABATAN_KONSINYERING_ID")."',
				  '".$this->getField("KELAS_AWAL")."',
				  '".$this->getField("KELAS_AKHIR")."',
				  '".$this->getField("JUMLAH")."'
				)"; 
				
		$this->id = $this->getField("KONSINYERING_BESARAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SPPD.KONSINYERING_BESARAN
				SET    
					   JABATAN_KONSINYERING_ID = '".$this->getField("JABATAN_KONSINYERING_ID")."',
					   KELAS_AWAL  = '".$this->getField("KELAS_AWAL")."',
				  	   KELAS_AKHIR = '".$this->getField("KELAS_AKHIR")."',
				  	   JUMLAH = '".$this->getField("JUMLAH")."'
				WHERE  KONSINYERING_BESARAN_ID = '".$this->getField("KONSINYERING_BESARAN_ID")."'
			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.KONSINYERING_BESARAN
                WHERE 
                  KONSINYERING_BESARAN_ID = ".$this->getField("KONSINYERING_BESARAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT KONSINYERING_BESARAN_ID, A.JABATAN_KONSINYERING_ID, KELAS_AWAL, KELAS_AKHIR, JUMLAH, B.NAMA JABATAN_KONSINYERING
				FROM PPI_SPPD.KONSINYERING_BESARAN A
				LEFT JOIN PPI_SPPD.JABATAN_KONSINYERING B ON A.JABATAN_KONSINYERING_ID = B.JABATAN_KONSINYERING_ID
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
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KONSINYERING_BESARAN_ID, JABATAN_KONSINYERING_ID, KELAS_AWAL, KELAS_AKHIR, JUMLAH
				FROM PPI_SPPD.KONSINYERING_BESARAN
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY JABATAN_KONSINYERING_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KONSINYERING_BESARAN_ID) AS ROWCOUNT FROM PPI_SPPD.KONSINYERING_BESARAN A
				LEFT JOIN PPI_SPPD.JABATAN_KONSINYERING B ON A.JABATAN_KONSINYERING_ID = B.JABATAN_KONSINYERING_ID
		        WHERE KONSINYERING_BESARAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KONSINYERING_BESARAN_ID) AS ROWCOUNT FROM PPI_SPPD.KONSINYERING_BESARAN
		        WHERE KONSINYERING_BESARAN_ID IS NOT NULL ".$statement; 
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