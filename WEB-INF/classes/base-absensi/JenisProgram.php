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

  class JenisProgram extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function JenisProgram()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JENIS_PROGRAM_ID", $this->getNextId("JENIS_PROGRAM_ID","jenis_program")); 
		$str = "
				INSERT INTO jenis_program
				(JENIS_PROGRAM_ID, PROGRAM_STUDI_ID, NAMA, TAHUN, UNIT_COST, KETERANGAN) 
				VALUES(
				  ".$this->getField("JENIS_PROGRAM_ID").",
				  '".$this->getField("PROGRAM_STUDI_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("TAHUN")."',
				  '".$this->getField("UNIT_COST")."',
				  '".$this->getField("KETERANGAN")."' 
				)"; 
		$this->id = $this->getField("JENIS_PROGRAM_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function insertImpor()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JENIS_PROGRAM_ID", $this->getNextId("JENIS_PROGRAM_ID","jenis_program")); 
		$str = "
				INSERT INTO jenis_program
				(JENIS_PROGRAM_ID, PROGRAM_STUDI_ID, NAMA, TAHUN, UNIT_COST, KETERANGAN) 
				VALUES(
				  ".$this->getField("JENIS_PROGRAM_ID").",
				   (SELECT PROGRAM_STUDI_ID FROM PROGRAM_STUDI WHERE NAMA = '".$this->getField("PROGRAM_STUDI")."'),
				  '".$this->getField("NAMA")."',
				  '".$this->getField("TAHUN")."',
				  '".$this->getField("UNIT_COST")."',
				  '".$this->getField("KETERANGAN")."' 
				)"; 
		$this->id = $this->getField("JENIS_PROGRAM_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }	

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE jenis_program SET
				  PROGRAM_STUDI_ID = '".$this->getField("PROGRAM_STUDI_ID")."',
				  NAMA = '".$this->getField("NAMA")."',
				  TAHUN = '".$this->getField("TAHUN")."',
				  UNIT_COST = '".$this->getField("UNIT_COST")."',
				  KETERANGAN = '".$this->getField("KETERANGAN")."'
				WHERE JENIS_PROGRAM_ID = '".$this->getField("JENIS_PROGRAM_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM jenis_program
                WHERE 
                  JENIS_PROGRAM_ID = '".$this->getField("JENIS_PROGRAM_ID")."'"; 
				  
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
				SELECT JENIS_PROGRAM_ID, a.PROGRAM_STUDI_ID PROGRAM_STUDI_ID, a.NAMA NAMA, b.NAMA PROGRAM_STUDI, TAHUN, UNIT_COST, a.KETERANGAN 
				FROM jenis_program a, program_studi b WHERE 1 = 1 AND a.PROGRAM_STUDI_ID = b.PROGRAM_STUDI_ID
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
				SELECT JENIS_PROGRAM_ID, a.PROGRAM_STUDI_ID PROGRAM_STUDI_ID, a.NAMA NAMA, b.nama PROGRAM_STUDI, TAHUN, UNIT_COST, a.KETERANGAN KETERANGAN 
				FROM jenis_program a, program_studi b WHERE 1 = 1 AND a.PROGRAM_STUDI_ID = b.PROGRAM_STUDI_ID
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY JENIS_PROGRAM_ID DESC";
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
		$str = "SELECT COUNT(JENIS_PROGRAM_ID) AS ROWCOUNT FROM jenis_program	WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(JENIS_PROGRAM_ID) AS ROWCOUNT FROM jenis_program WHERE 1 = 1 "; 
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