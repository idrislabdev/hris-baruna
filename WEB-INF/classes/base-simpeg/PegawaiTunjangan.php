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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_TUNJANGAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiTunjangan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiTunjangan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_TUNJANGAN_ID", $this->getNextId("PEGAWAI_TUNJANGAN_ID","PEGAWAI_TUNJANGAN"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_TUNJANGAN (
				   PEGAWAI_TUNJANGAN_ID, TANGGAL_SK, PEGAWAI_ID, NO_SK, TMT_TUNJANGAN, JUMLAH
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_TUNJANGAN_ID").",
				  '".$this->getField("TANGGAL_SK")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("NO_SK")."',
				  '".$this->getField("TMT_TUNJANGAN")."',
				  '".$this->getField("JUMLAH")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_TUNJANGAN
				SET    
					   TANGGAL_SK           = '".$this->getField("TANGGAL_SK")."',
					   PEGAWAI_ID      = '".$this->getField("PEGAWAI_ID")."',
					   NO_SK    = '".$this->getField("NO_SK")."',
					   TMT_TUNJANGAN         = '".$this->getField("TMT_TUNJANGAN")."',
					   JUMLAH= '".$this->getField("JUMLAH")."'
				WHERE  PEGAWAI_TUNJANGAN_ID     = '".$this->getField("PEGAWAI_TUNJANGAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_TUNJANGAN
                WHERE 
                  PEGAWAI_TUNJANGAN_ID = ".$this->getField("PEGAWAI_TUNJANGAN_ID").""; 
				  
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
				SELECT PEGAWAI_TUNJANGAN_ID, TANGGAL_SK, PEGAWAI_ID, NO_SK, TMT_TUNJANGAN, JUMLAH
				FROM PPI_SIMPEG.PEGAWAI_TUNJANGAN
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TANGGAL_SK DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_TUNJANGAN_ID, TANGGAL_SK, PEGAWAI_ID, NO_SK, TMT_TUNJANGAN, JUMLAH
				FROM PPI_SIMPEG.PEGAWAI_TUNJANGAN
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TANGGAL_SK ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_TUNJANGAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_TUNJANGAN
		        WHERE PEGAWAI_TUNJANGAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_TUNJANGAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_TUNJANGAN
		        WHERE PEGAWAI_TUNJANGAN_ID IS NOT NULL ".$statement; 
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