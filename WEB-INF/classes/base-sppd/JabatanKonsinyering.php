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

  class JabatanKonsinyering extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function JabatanKonsinyering()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JABATAN_KONSINYERING_ID", $this->getNextId("JABATAN_KONSINYERING_ID","PPI_SPPD.JABATAN_KONSINYERING"));
		$str = "
				INSERT INTO PPI_SPPD.JABATAN_KONSINYERING (
				   JABATAN_KONSINYERING_ID, NAMA, KETERANGAN) 
				VALUES (
				  ".$this->getField("JABATAN_KONSINYERING_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."'
				)"; 
				
		$this->id = $this->getField("JABATAN_KONSINYERING_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SPPD.JABATAN_KONSINYERING
				SET    NAMA        = '".$this->getField("NAMA")."',
					   KETERANGAN  = '".$this->getField("KETERANGAN")."'
				WHERE  JABATAN_KONSINYERING_ID = '".$this->getField("JABATAN_KONSINYERING_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.JABATAN_KONSINYERING
                WHERE 
                  JABATAN_KONSINYERING_ID = ".$this->getField("JABATAN_KONSINYERING_ID").""; 
				  
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
				SELECT JABATAN_KONSINYERING_ID, NAMA, KETERANGAN
				FROM PPI_SPPD.JABATAN_KONSINYERING
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
				SELECT JABATAN_KONSINYERING_ID, NAMA, KETERANGAN
				FROM PPI_SPPD.JABATAN_KONSINYERING
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
		$str = "SELECT COUNT(JABATAN_KONSINYERING_ID) AS ROWCOUNT FROM PPI_SPPD.JABATAN_KONSINYERING
		        WHERE JABATAN_KONSINYERING_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(JABATAN_KONSINYERING_ID) AS ROWCOUNT FROM PPI_SPPD.JABATAN_KONSINYERING
		        WHERE JABATAN_KONSINYERING_ID IS NOT NULL ".$statement; 
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