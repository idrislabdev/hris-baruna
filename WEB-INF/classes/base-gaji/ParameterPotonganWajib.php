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

  class ParameterPotonganWajib extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function ParameterPotonganWajib()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("JENIS_POTONGAN", $this->getNextId("JENIS_POTONGAN","PPI_GAJI.PARAMETER_POTONGAN_WAJIB")); 
		$str = "
				INSERT INTO PPI_GAJI.PARAMETER_POTONGAN_WAJIB (
				   JENIS_POTONGAN, KELAS, JUMLAH) 
				VALUES ( ".$this->getField("JENIS_POTONGAN").",
					  '".$this->getField("KELAS")."',
					  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id = $this->getField("JENIS_POTONGAN");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.PARAMETER_POTONGAN_WAJIB
			   SET 
			   		JENIS_POTONGAN 		= '".$this->getField("JENIS_POTONGAN")."',
			   		KELAS  				= '".$this->getField("KELAS")."',
				   	JUMLAH				= ".$this->getField("JUMLAH")."
  			   WHERE JENIS_POTONGAN 	= '".$this->getField("JENIS_POTONGAN_ID")."'
			   AND KELAS            	= '".$this->getField("KELAS_ID")."'
				"; 
		
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.PARAMETER_POTONGAN_WAJIB
                WHERE JENIS_POTONGAN 	= '".$this->getField("JENIS_POTONGAN_ID")."'
			   	AND KELAS            	= '".$this->getField("KELAS_ID")."'
			   "; 
				  
		$this->query = $str;
		//echo $str;
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
				JENIS_POTONGAN, KELAS, JUMLAH
				FROM PPI_GAJI.PARAMETER_POTONGAN_WAJIB				
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
				JENIS_POTONGAN, KELAS, JUMLAH
				FROM PPI_GAJI.PARAMETER_POTONGAN_WAJIB				
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY JENIS_POTONGAN DESC";
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
		$str = "SELECT COUNT(JENIS_POTONGAN) AS ROWCOUNT FROM PPI_GAJI.PARAMETER_POTONGAN_WAJIB  WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(JENIS_POTONGAN) AS ROWCOUNT FROM PPI_GAJI.PARAMETER_POTONGAN_WAJIB WHERE 1 = 1 "; 
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