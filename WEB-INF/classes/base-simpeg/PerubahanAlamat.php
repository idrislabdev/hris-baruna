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
  * Entity-base class untuk mengimplementasikan tabel PERUBAHAN_ALAMAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PerubahanAlamat extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PerubahanAlamat()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PERUBAHAN_ALAMAT_ID", $this->getNextId("PERUBAHAN_ALAMAT_ID","PPI_SIMPEG.PERUBAHAN_ALAMAT")); 		

		$str = "
				INSERT INTO PPI_SIMPEG.PERUBAHAN_ALAMAT (
				   PERUBAHAN_ALAMAT_ID, PEGAWAI_ID, ALAMAT, TMT_PERUBAHAN_ALAMAT) 
 			  	VALUES (
				  ".$this->getField("PERUBAHAN_ALAMAT_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("ALAMAT")."',
				  ".$this->getField("TMT_PERUBAHAN_ALAMAT")."
				)"; 
		$this->query = $str;
		$this->id = $this->getField("PERUBAHAN_ALAMAT_ID");
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PERUBAHAN_ALAMAT
				SET
					   ALAMAT           		= '".$this->getField("ALAMAT")."',
					   TMT_PERUBAHAN_ALAMAT    	= ".$this->getField("TMT_PERUBAHAN_ALAMAT")."
				WHERE  PERUBAHAN_ALAMAT_ID     	= '".$this->getField("PERUBAHAN_ALAMAT_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PERUBAHAN_ALAMAT
                WHERE 
                  PERUBAHAN_ALAMAT_ID = ".$this->getField("PERUBAHAN_ALAMAT_ID").""; 
				  
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
				SELECT PERUBAHAN_ALAMAT_ID, PEGAWAI_ID, ALAMAT, TMT_PERUBAHAN_ALAMAT
				FROM PPI_SIMPEG.PERUBAHAN_ALAMAT
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TMT_PERUBAHAN_ALAMAT DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PERUBAHAN_ALAMAT_ID, PEGAWAI_ID, ALAMAT, TMT_PERUBAHAN_ALAMAT
				FROM PPI_SIMPEG.PERUBAHAN_ALAMAT
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TMT_PERUBAHAN_ALAMAT DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PERUBAHAN_ALAMAT_ID) AS ROWCOUNT FROM PPI_SIMPEG.PERUBAHAN_ALAMAT
		        WHERE PERUBAHAN_ALAMAT_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PERUBAHAN_ALAMAT_ID) AS ROWCOUNT FROM PPI_SIMPEG.PERUBAHAN_ALAMAT
		        WHERE PERUBAHAN_ALAMAT_ID IS NOT NULL ".$statement; 
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