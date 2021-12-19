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

  class InventarisPenanggungJawab extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function InventarisPenanggungJawab()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("INVENTARIS_PENANGGUNG_JAWAB_ID", $this->getNextId("INVENTARIS_PENANGGUNG_JAWAB_ID","PPI_ASSET.INVENTARIS_PENANGGUNG_JAWAB")); 
		$str = "
				INSERT INTO PPI_ASSET.INVENTARIS_PENANGGUNG_JAWAB (
				   INVENTARIS_PENANGGUNG_JAWAB_ID,  INVENTARIS_RUANGAN_ID, 
				   PEGAWAI_ID, LOKASI_ID, TMT) 
				VALUES (
						".$this->getField("INVENTARIS_PENANGGUNG_JAWAB_ID").", 
						".$this->getField("INVENTARIS_RUANGAN_ID").", 
						".$this->getField("PEGAWAI_ID").", 
						'".$this->getField("LOKASI_ID")."', 
						".$this->getField("TMT")."
						)"; 
		$this->id = $this->getField("INVENTARIS_PENANGGUNG_JAWAB_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_PENANGGUNG_JAWAB
				SET    
					   INVENTARIS_RUANGAN_ID                       = '".$this->getField("INVENTARIS_RUANGAN_ID")."',
					   PEGAWAI_ID                 = '".$this->getField("PEGAWAI_ID")."',
					   TMT                 = ".$this->getField("TMT")."
				WHERE  INVENTARIS_PENANGGUNG_JAWAB_ID       	  = '".$this->getField("INVENTARIS_PENANGGUNG_JAWAB_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.INVENTARIS_PENANGGUNG_JAWAB
                WHERE 
                  INVENTARIS_PENANGGUNG_JAWAB_ID = ".$this->getField("INVENTARIS_PENANGGUNG_JAWAB_ID").""; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","INVENTARIS_RUANGAN_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				A.INVENTARIS_PENANGGUNG_JAWAB_ID,  A.INVENTARIS_RUANGAN_ID, A.PEGAWAI_ID, TMT, B.NRP, B.NAMA PEGAWAI, 
				AMBIL_LOKASI_INVENTARIS(A.LOKASI_ID) LOKASI
				FROM PPI_ASSET.INVENTARIS_PENANGGUNG_JAWAB A 
                INNER JOIN PPI_ASSET.IMASYS_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
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
				INVENTARIS_PENANGGUNG_JAWAB_ID,  INVENTARIS_RUANGAN_ID, PEGAWAI_ID
				FROM PPI_ASSET.INVENTARIS_PENANGGUNG_JAWAB
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY INVENTARIS_PENANGGUNG_JAWAB_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","INVENTARIS_RUANGAN_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(INVENTARIS_PENANGGUNG_JAWAB_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_PENANGGUNG_JAWAB  WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(INVENTARIS_PENANGGUNG_JAWAB_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_PENANGGUNG_JAWAB WHERE 1 = 1 "; 
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