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

  class JamKerjaJenis extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function JamKerjaJenis()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JAM_KERJA_JENIS_ID", $this->getNextId("JAM_KERJA_JENIS_ID","PPI_ABSENSI.JAM_KERJA_JENIS")); 
		$str = "
				INSERT INTO PPI_ABSENSI.JAM_KERJA_JENIS (
				   JAM_KERJA_JENIS_ID, NAMA, KETERANGAN, WARNA, KELOMPOK) 
				VALUES(
					  ".$this->getField("JAM_KERJA_JENIS_ID").",
					  '".$this->getField("NAMA")."',
					  '".$this->getField("KETERANGAN")."',
					  '".$this->getField("WARNA")."',
					  '".$this->getField("KELOMPOK")."'
				)"; 
		$this->id = $this->getField("JAM_KERJA_JENIS_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PPI_ABSENSI.JAM_KERJA_JENIS
			   SET 
			   	   NAMA         = '".$this->getField("NAMA")."',
				   KETERANGAN   = '".$this->getField("KETERANGAN")."',
				   WARNA        = '".$this->getField("WARNA")."',
				   KELOMPOK     = '".$this->getField("KELOMPOK")."'
			 WHERE JAM_KERJA_JENIS_ID = ".$this->getField("JAM_KERJA_JENIS_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ABSENSI.JAM_KERJA_JENIS A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

    function updateByFieldStatus()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ABSENSI.JAM_KERJA_JENIS A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE JAM_KERJA_JENIS_ID = ".$this->getField("JAM_KERJA_JENIS_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	
	
	function delete()
	{
        $str = "DELETE FROM PPI_ABSENSI.JAM_KERJA_JENIS
                WHERE 
                  JAM_KERJA_JENIS_ID = ".$this->getField("JAM_KERJA_JENIS_ID").""; 
				  
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
				JAM_KERJA_JENIS_ID, NAMA, KETERANGAN, WARNA, KELOMPOK
				FROM PPI_ABSENSI.JAM_KERJA_JENIS
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
				JAM_KERJA_JENIS_ID, NAMA, KETERANGAN, WARNA, KELOMPOK
				FROM PPI_ABSENSI.JAM_KERJA_JENIS
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY JAM_KERJA_JENIS_ID DESC";
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
		$str = "SELECT COUNT(JAM_KERJA_JENIS_ID) AS ROWCOUNT FROM PPI_ABSENSI.JAM_KERJA_JENIS WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(JAM_KERJA_JENIS_ID) AS ROWCOUNT FROM PPI_ABSENSI.JAM_KERJA_JENIS WHERE 1 = 1 "; 
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