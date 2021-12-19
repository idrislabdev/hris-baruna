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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_TPP.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiTpp extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiTpp()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_TPP_ID", $this->getNextId("PEGAWAI_TPP_ID","PEGAWAI_TPP"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_TPP (
				   PEGAWAI_TPP_ID, PEGAWAI_ID, NO_SK, TANGGAL_SK, TMT_TPP
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_TPP_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("NO_SK")."',
				  '".$this->getField("TANGGAL_SK")."',
				  '".$this->getField("TMT_TPP")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_TPP
				SET    
					   PEGAWAI_ID      = '".$this->getField("PEGAWAI_ID")."',
					   NO_SK    = '".$this->getField("NO_SK")."',
					   TANGGAL_SK         = '".$this->getField("TANGGAL_SK")."',
					   TMT_TPP= '".$this->getField("TMT_TPP")."'
				WHERE  PEGAWAI_TPP_ID     = '".$this->getField("PEGAWAI_TPP_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_TPP
                WHERE 
                  PEGAWAI_TPP_ID = ".$this->getField("PEGAWAI_TPP_ID").""; 
				  
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
				SELECT PEGAWAI_TPP_ID, PEGAWAI_ID, NO_SK, TANGGAL_SK, TMT_TPP
				FROM PPI_SIMPEG.PEGAWAI_TPP
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY NO_SK DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_TPP_ID, PEGAWAI_ID, NO_SK, TANGGAL_SK, TMT_TPP
				FROM PPI_SIMPEG.PEGAWAI_TPP
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NO_SK ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_TPP_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_TPP
		        WHERE PEGAWAI_TPP_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_TPP_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_TPP
		        WHERE PEGAWAI_TPP_ID IS NOT NULL ".$statement; 
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