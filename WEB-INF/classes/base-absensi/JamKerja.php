<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
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

  class JamKerja extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function JamKerja()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JAM_KERJA_ID", $this->getNextId("JAM_KERJA_ID","PPI_ABSENSI.JAM_KERJA")); 
		$str = "
				INSERT INTO PPI_ABSENSI.JAM_KERJA (
				   JAM_KERJA_ID, JAM_KERJA_JENIS_ID, NAMA, JAM_AWAL, 
				   JAM_AKHIR, TERLAMBAT_AWAL, TERLAMBAT_AKHIR, 
				   STATUS) 
				VALUES(
					  ".$this->getField("JAM_KERJA_ID").",
					  '".$this->getField("JAM_KERJA_JENIS_ID")."',
					  '".$this->getField("NAMA")."',
					  '".$this->getField("JAM_AWAL")."',	
					  '".$this->getField("JAM_AKHIR")."',
					  '".$this->getField("TERLAMBAT_AWAL")."',
					  '".$this->getField("TERLAMBAT_AKHIR")."',
					  '".$this->getField("STATUS")."'
				)"; 
		$this->id = $this->getField("JAM_KERJA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PPI_ABSENSI.JAM_KERJA
			   SET 
			   	   JAM_KERJA_JENIS_ID = '".$this->getField("JAM_KERJA_JENIS_ID")."',
				   NAMA         	  = '".$this->getField("NAMA")."',
				   JAM_AWAL           = '".$this->getField("JAM_AWAL")."',
				   JAM_AKHIR          = '".$this->getField("JAM_AKHIR")."',
				   TERLAMBAT_AWAL     = '".$this->getField("TERLAMBAT_AWAL")."',
				   TERLAMBAT_AKHIR    = '".$this->getField("TERLAMBAT_AKHIR")."',
				   STATUS         	  = '".$this->getField("STATUS")."'
			 WHERE JAM_KERJA_ID = ".$this->getField("JAM_KERJA_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ABSENSI.JAM_KERJA A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

    function updateByFieldWhereClause()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ABSENSI.JAM_KERJA A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."' WHERE ".$this->getField("CONDITION")." = '".$this->getField("CONDITION_VALUE")."'
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	


    function updateByFieldStatus()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ABSENSI.JAM_KERJA A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE JAM_KERJA_ID = ".$this->getField("JAM_KERJA_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	
	
	function delete()
	{
        $str = "DELETE FROM PPI_ABSENSI.JAM_KERJA
                WHERE 
                  JAM_KERJA_ID = ".$this->getField("JAM_KERJA_ID").""; 
				  
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
                JAM_KERJA_ID, A.NAMA, B.NAMA JENIS, JAM_AWAL, 
                   JAM_AKHIR, TERLAMBAT_AWAL, TERLAMBAT_AKHIR, 
                   STATUS, B.JAM_KERJA_JENIS_ID JAM_KERJA_JENIS_ID
                FROM PPI_ABSENSI.JAM_KERJA A INNER JOIN PPI_ABSENSI.JAM_KERJA_JENIS B ON A.JAM_KERJA_JENIS_ID = B.JAM_KERJA_JENIS_ID
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
				SELECT 
				JAM_KERJA_ID, JAM_KERJA_JENIS_ID, NAMA, JAM_AWAL, 
				   JAM_AKHIR, TERLAMBAT_AWAL, TERLAMBAT_AKHIR, 
				   STATUS
				FROM PPI_ABSENSI.JAM_KERJA
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY JAM_KERJA_ID DESC";
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
		$str = "SELECT COUNT(JAM_KERJA_ID) AS ROWCOUNT FROM PPI_ABSENSI.JAM_KERJA WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(JAM_KERJA_ID) AS ROWCOUNT FROM PPI_ABSENSI.JAM_KERJA WHERE 1 = 1 "; 
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