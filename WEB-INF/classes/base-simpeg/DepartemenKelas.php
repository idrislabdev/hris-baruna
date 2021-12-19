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
  * Entity-base class untuk mengimplementasikan tabel DEPARTEMEN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class DepartemenKelas extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function DepartemenKelas()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("DEPARTEMEN_KELAS_ID", $this->getNextId("DEPARTEMEN_KELAS_ID","PPI_SIMPEG.DEPARTEMEN_KELAS")); 		
		
		$str = "
				INSERT INTO PPI_SIMPEG.DEPARTEMEN_KELAS (
				   DEPARTEMEN_KELAS_ID, DEPARTEMEN_ID, NAMA, 
				   KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE) 
				VALUES (
				  '".$this->getField("DEPARTEMEN_KELAS_ID")."',
				  '".$this->getField("DEPARTEMEN_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("DEPARTEMEN_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.DEPARTEMEN_KELAS
				SET   
				  NAMA = '".$this->getField("NAMA")."',
				  KETERANGAN = '".$this->getField("KETERANGAN")."',
				  LAST_UPDATE_DATE = SYSDATE
				WHERE  DEPARTEMEN_KELAS_ID	= '".$this->getField("DEPARTEMEN_KELAS_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.DEPARTEMEN_KELAS
                WHERE 
                  DEPARTEMEN_KELAS_ID = ".$this->getField("DEPARTEMEN_KELAS_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteParent()
	{
        $str = "DELETE FROM PPI_SIMPEG.DEPARTEMEN_KELAS
                WHERE 
                  DEPARTEMEN_ID = ".$this->getField("DEPARTEMEN_ID").""; 
				  
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
				SELECT 
					DEPARTEMEN_KELAS_ID, DEPARTEMEN_ID, NAMA, 
					   KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE, 
					   LAST_UPDATE_USER, LAST_UPDATE_DATE
					FROM PPI_SIMPEG.DEPARTEMEN_KELAS
					WHERE 1=1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str . " ORDER BY NAMA ";
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsImport($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order = "ORDER BY DEPARTEMEN_ID, DEPARTEMEN_KELAS_ID ASC ")
	{
		$str = "
				SELECT 
					DEPARTEMEN_KELAS_ID, DEPARTEMEN_ID, NAMA, 
					   KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE, 
					   LAST_UPDATE_USER, LAST_UPDATE_DATE
					FROM PPI_SIMPEG.DEPARTEMEN_KELAS
					WHERE 1=1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement.$order;
		// echo $str;exit();
		$this->query = $str . " ORDER BY DEPARTEMEN_KELAS_ID ";
		return $this->selectLimit($str,$limit,$from); 
    }
	

    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(DEPARTEMEN_ID) AS ROWCOUNT FROM PPI_SIMPEG.DEPARTEMEN_KELAS
		        WHERE 1=1 ".$statement; 
		
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

  } 
?>