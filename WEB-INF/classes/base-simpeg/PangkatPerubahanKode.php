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
  * Entity-base class untuk mengimplementasikan tabel PANGKAT_PERUBAHAN_KODE.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PangkatPerubahanKode extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PangkatPerubahanKode()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PANGKAT_PERUBAHAN_KODE_ID", $this->getNextId("PANGKAT_PERUBAHAN_KODE_ID","PPI_SIMPEG.PANGKAT_PERUBAHAN_KODE")); 		

		$str = "
				INSERT INTO PPI_SIMPEG.PANGKAT_PERUBAHAN_KODE (
				   PANGKAT_PERUBAHAN_KODE_ID, NAMA, KODE, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE)   
 			  	VALUES (
				  ".$this->getField("PANGKAT_PERUBAHAN_KODE_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KODE")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PANGKAT_PERUBAHAN_KODE
				SET    
					   NAMA           = '".$this->getField("NAMA")."',
					   KODE      = '".$this->getField("KODE")."',
					   KETERANGAN    = '".$this->getField("KETERANGAN")."',
					LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PANGKAT_PERUBAHAN_KODE_ID     = '".$this->getField("PANGKAT_PERUBAHAN_KODE_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PANGKAT_PERUBAHAN_KODE
                WHERE 
                  PANGKAT_PERUBAHAN_KODE_ID = ".$this->getField("PANGKAT_PERUBAHAN_KODE_ID").""; 
				  
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
				SELECT PANGKAT_PERUBAHAN_KODE_ID, NAMA, KODE, KETERANGAN
				FROM PPI_SIMPEG.PANGKAT_PERUBAHAN_KODE
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
				SELECT PANGKAT_PERUBAHAN_KODE_ID, NAMA, KODE, KETERANGAN
				FROM PPI_SIMPEG.PANGKAT_PERUBAHAN_KODE
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PANGKAT_PERUBAHAN_KODE_ID) AS ROWCOUNT FROM PPI_SIMPEG.PANGKAT_PERUBAHAN_KODE
		        WHERE PANGKAT_PERUBAHAN_KODE_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PANGKAT_PERUBAHAN_KODE_ID) AS ROWCOUNT FROM PPI_SIMPEG.PANGKAT_PERUBAHAN_KODE
		        WHERE PANGKAT_PERUBAHAN_KODE_ID IS NOT NULL ".$statement; 
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