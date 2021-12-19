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

  class PenanggungJawab extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PenanggungJawab()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PENANGGUNG_JAWAB_ID", $this->getNextId("PENANGGUNG_JAWAB_ID","PPI_ASSET.PENANGGUNG_JAWAB")); 
		$str = "
				INSERT INTO PPI_ASSET.PENANGGUNG_JAWAB (
				   PENANGGUNG_JAWAB_ID,  PEGAWAI_ID, 
				   KETERANGAN) 
				VALUES (
						".$this->getField("PENANGGUNG_JAWAB_ID").", 
						'".$this->getField("PEGAWAI_ID")."', 
						'".$this->getField("KETERANGAN")."'
						)"; 
		$this->id = $this->getField("PENANGGUNG_JAWAB_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.PENANGGUNG_JAWAB
				SET    
					   PEGAWAI_ID                       = '".$this->getField("PEGAWAI_ID")."',
					   KETERANGAN                 = '".$this->getField("KETERANGAN")."'
				WHERE  PENANGGUNG_JAWAB_ID       	  = '".$this->getField("PENANGGUNG_JAWAB_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.PENANGGUNG_JAWAB
                WHERE 
                  PENANGGUNG_JAWAB_ID = ".$this->getField("PENANGGUNG_JAWAB_ID").""; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","PEGAWAI_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				A.PENANGGUNG_JAWAB_ID,  A.PEGAWAI_ID, KETERANGAN, B.NAMA, B.NRP
				FROM PPI_ASSET.PENANGGUNG_JAWAB A INNER JOIN PPI_ASSET.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
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
				PENANGGUNG_JAWAB_ID,  PEGAWAI_ID, KETERANGAN
				FROM PPI_ASSET.PENANGGUNG_JAWAB
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY PENANGGUNG_JAWAB_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","PEGAWAI_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PENANGGUNG_JAWAB_ID) AS ROWCOUNT FROM PPI_ASSET.PENANGGUNG_JAWAB  WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(PENANGGUNG_JAWAB_ID) AS ROWCOUNT FROM PPI_ASSET.PENANGGUNG_JAWAB WHERE 1 = 1 "; 
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