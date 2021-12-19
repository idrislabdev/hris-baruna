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

  class AsuransiPegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AsuransiPegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ASURANSI_PEGAWAI_ID", $this->getNextId("ASURANSI_PEGAWAI_ID","PPI_GAJI.ASURANSI_PEGAWAI")); 
		$str = "
				INSERT INTO PPI_GAJI.ASURANSI_PEGAWAI (
				   ASURANSI_PEGAWAI_ID, ASURANSI_ID, PEGAWAI_ID, JUMLAH) 
				VALUES ( ".$this->getField("ASURANSI_PEGAWAI_ID").",
					  '".$this->getField("ASURANSI_ID")."',
					  '".$this->getField("PEGAWAI_ID")."',					  
					  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id = $this->getField("ASURANSI_PEGAWAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.ASURANSI_PEGAWAI
			   SET 
			   		ASURANSI_ID  			= '".$this->getField("ASURANSI_ID")."',
				   	JUMLAH					= '".$this->getField("JUMLAH")."'
			 WHERE PEGAWAI_ID				= '".$this->getField("PEGAWAI_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.ASURANSI_PEGAWAI
                WHERE 
                  PEGAWAI_ID = ".$this->getField("PEGAWAI_ID").""; 
				  
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
				ASURANSI_PEGAWAI_ID, ASURANSI_ID, PEGAWAI_ID, JUMLAH
				FROM PPI_GAJI.ASURANSI_PEGAWAI				
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
				ASURANSI_PEGAWAI_ID, ASURANSI_ID, PEGAWAI_ID, JUMLAH
				FROM PPI_GAJI.ASURANSI_PEGAWAI				
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY ASURANSI_PEGAWAI_ID DESC";
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
		$str = "SELECT COUNT(ASURANSI_PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.ASURANSI_PEGAWAI  WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(ASURANSI_PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.ASURANSI_PEGAWAI WHERE 1 = 1 "; 
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