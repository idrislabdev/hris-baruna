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

  class TahunAjaran extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TahunAjaran()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TAHUN_AJARAN_ID", $this->getNextId("TAHUN_AJARAN_ID","PPI_SIMPEG.TAHUN_AJARAN")); 
		$str = "
				INSERT INTO PPI_SIMPEG.TAHUN_AJARAN (
				   TAHUN_AJARAN_ID, PERIODE, LAST_CREATE_USER, 
				   LAST_CREATE_DATE, LAST_UPDATE_USER, LAST_UPDATE_DATE) 
 			  	VALUES (
				  ".$this->getField("TAHUN_AJARAN_ID").",
				  '".$this->getField("PERIODE")."'
				)"; 
		$this->id = $this->getField("TAHUN_AJARAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.TAHUN_AJARAN
				SET    
					   NAMA           = '".$this->getField("NAMA")."'
				WHERE  TAHUN_AJARAN_ID     = '".$this->getField("TAHUN_AJARAN_ID")."'
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY GAJI_PERIODE_ID ASC")
	{
		$str = "
				SELECT 
				TAHUN_AJARAN_ID, PERIODE
				FROM PPI_SIMPEG.TAHUN_AJARAN			
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order ;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function getPeriodeAkhir()
	{
		$str = "
				SELECT 
				TAHUN_AJARAN_ID, PERIODE
				FROM PPI_SIMPEG.TAHUN_AJARAN
				WHERE 1 = 1 ORDER BY TAHUN_AJARAN_ID DESC
				"; 
		$this->select($str);
		if($this->firstRow()) 
			return $this->getField("PERIODE"); 
		else 
			return ""; 

    }
	
	function getPeriodeMax()
	{
		$str = "
				SELECT 
                TO_CHAR(MAX(TO_DATE(PERIODE, 'MMYYYY')), 'MMYYYY') PERIODE
                FROM PPI_SIMPEG.TAHUN_AJARAN
                WHERE 1 = 1
				"; 
		$this->select($str);
		if($this->firstRow()) 
			return $this->getField("PERIODE"); 
		else 
			return ""; 

    }
	
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