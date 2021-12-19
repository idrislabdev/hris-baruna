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

  class Jawaban extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Jawaban()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JAWABAN_ID", $this->getNextId("JAWABAN_ID","PPI_PENILAIAN.JAWABAN")); 
		
		$str = "
				INSERT INTO PPI_PENILAIAN.JAWABAN (
				   JAWABAN_ID, PERTANYAAN_ID, JAWABAN, KETERANGAN,
				   RANGE_1, RANGE_2, RANGE_3, NO_URUT) 
 			  	VALUES (
				  ".$this->getField("JAWABAN_ID").",
				  '".$this->getField("PERTANYAAN_ID")."',
				  '".$this->getField("JAWABAN")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("RANGE_1")."',
				  '".$this->getField("RANGE_2")."',
				  '".$this->getField("RANGE_3")."',
				  '".$this->getField("NO_URUT")."'
				)"; 
		$this->id = $this->getField("JAWABAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_PENILAIAN.JAWABAN
				SET
					   JAWABAN			= '".$this->getField("JAWABAN")."',
					   KETERANGAN		= '".$this->getField("KETERANGAN")."',
					   RANGE_1			= '".$this->getField("RANGE_1")."',
					   RANGE_2			= '".$this->getField("RANGE_2")."',
					   RANGE_3			= '".$this->getField("RANGE_3")."'
				WHERE  JAWABAN_ID     	= '".$this->getField("JAWABAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_PENILAIAN.JAWABAN
                WHERE 
                  JAWABAN_ID = ".$this->getField("JAWABAN_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteParent()
	{
        $str = "DELETE FROM PPI_PENILAIAN.JAWABAN
                WHERE 
                  PERTANYAAN_ID= '".$this->getField("PERTANYAAN_ID")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY NO_URUT ASC")
	{
		$str = "
				SELECT 
				JAWABAN_ID, PERTANYAAN_ID, JAWABAN, KETERANGAN,
				   RANGE_1, RANGE_2, RANGE_3
				FROM PPI_PENILAIAN.JAWABAN			
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				JAWABAN_ID, PERTANYAAN_ID, JAWABAN, KETERANGAN,
				   RANGE_1, RANGE_2, RANGE_3
				FROM PPI_PENILAIAN.JAWABAN			
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY JAWABAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(JAWABAN_ID) AS ROWCOUNT FROM PPI_PENILAIAN.JAWABAN
		        WHERE JAWABAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(JAWABAN_ID) AS ROWCOUNT FROM PPI_PENILAIAN.JAWABAN
		        WHERE JAWABAN_ID IS NOT NULL ".$statement; 
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