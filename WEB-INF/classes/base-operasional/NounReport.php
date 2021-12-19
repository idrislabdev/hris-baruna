<? 
/* *******************************************************************************************************
MODUL NOUN_REPORT_ID 			: MTSN LAWANG
FILE NOUN_REPORT_ID 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class NounReport extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function NounReport()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("NOUN_REPORT_ID", $this->getNextId("NOUN_REPORT_ID","PPI_OPERASIONAL.NOUN_REPORT"));
		$str = "			
			INSERT INTO PPI_OPERASIONAL.NOUN_REPORT (
  				 NOUN_REPORT_ID, KAPAL_ID, TANGGAL, 
   					KETERANGAN) 
			VALUES ( 
				   ".$this->getField("NOUN_REPORT_ID").",
				   '".$this->getField("KAPAL_ID")."',
				   ".$this->getField("TANGGAL").",
				   '".$this->getField("KETERANGAN")."',
				)"; 
		$this->id = $this->getField("NOUN_REPORT_ID");
		$this->query = $str;
		//$this->mysql_query($str);
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			    UPDATE PPI_OPERASIONAL.NOUN_REPORT
				SET    
					   KAPAL_ID       = '".$this->getField("KAPAL_ID")."',
					   TANGGAL        = ".$this->getField("TANGGAL").",
					   KETERANGAN     = '".$this->getField("KETERANGAN")."'
				WHERE  NOUN_REPORT_ID = '".$this->getField("NOUN_REPORT_ID")."'
				";
		$this->id = $this->getField("NOUN_REPORT_ID"); 
		$this->query = $str;	
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE PPI_OPERASIONAL.NOUN_REPORT
                WHERE 
                  NOUN_REPORT_ID = '".$this->getField("NOUN_REPORT_ID")."'
				  "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "	
				SELECT 
					A.NOUN_REPORT_ID, A.KAPAL_ID, A.NO_TELEPON, B.NAMA KAPAL, A.TANGGAL, 
					A.KETERANGAN
				FROM PPI_OPERASIONAL.NOUN_REPORT A
				INNER JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID=A.KAPAL_ID
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
				SELECT 
					NOUN_REPORT_ID, KAPAL_ID, TANGGAL, 
					KETERANGAN
				FROM PPI_OPERASIONAL.NOUN_REPORT A
				INNER JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID=A.KAPAL_ID
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY NOUN_REPORT_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(NOUN_REPORT_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.NOUN_REPORT A
				INNER JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID=A.KAPAL_ID WHERE 1 = 1 ".$statement; 
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(NOUN_REPORT_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.NOUN_REPORT A
				INNER JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID=A.KAPAL_ID WHERE 1 = 1 "; 
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