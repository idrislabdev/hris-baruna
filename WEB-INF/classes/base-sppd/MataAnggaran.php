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
  * Entity-base class untuk mengimplementasikan tabel PANGKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class MataAnggaran extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function MataAnggaran()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("MATA_ANGGARAN_ID", $this->getNextId("MATA_ANGGARAN_ID","PPI_SPPD.MATA_ANGGARAN"));
		$str = "INSERT INTO PPI_SPPD.MATA_ANGGARAN (
				   MATA_ANGGARAN_ID, MATA_ANGGARAN_PARENT_ID, KODE, 
				   NAMA, KETERANGAN) 
				VALUES (PPI_SPPD.MATA_ANGGARAN_ID_GENERATE('".$this->getField("MATA_ANGGARAN_ID")."'),
						'".$this->getField("MATA_ANGGARAN_ID")."',
						'".$this->getField("KODE")."', 
				   		'".$this->getField("NAMA")."',
						'".$this->getField("KETERANGAN")."'
						)";						 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SPPD.MATA_ANGGARAN
				SET    KODE              = '".$this->getField("KODE")."',
					   NAMA              = '".$this->getField("NAMA")."',
					   KETERANGAN        = '".$this->getField("KETERANGAN")."'
				WHERE  MATA_ANGGARAN_ID  = '".$this->getField("MATA_ANGGARAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.MATA_ANGGARAN
                WHERE 
                  MATA_ANGGARAN_ID = ".$this->getField("MATA_ANGGARAN_ID").""; 
				  
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
		$str = "SELECT 
					MATA_ANGGARAN_ID, MATA_ANGGARAN_PARENT_ID, KODE, 
					   NAMA, KETERANGAN
					FROM PPI_SPPD.MATA_ANGGARAN
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
		$str = "SELECT 
					MATA_ANGGARAN_ID, MATA_ANGGARAN_PARENT_ID, KODE, 
					   NAMA, KETERANGAN
					FROM PPI_SPPD.MATA_ANGGARAN
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
		$str = "SELECT COUNT(MATA_ANGGARAN_ID) AS ROWCOUNT FROM PPI_SPPD.JENIS_SPPD

		        WHERE MATA_ANGGARAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(MATA_ANGGARAN_ID) AS ROWCOUNT FROM PPI_SPPD.JENIS_SPPD

		        WHERE MATA_ANGGARAN_ID IS NOT NULL ".$statement; 
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