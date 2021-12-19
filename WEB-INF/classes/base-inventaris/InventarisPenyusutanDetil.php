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

  class InventarisPenyusutanDetil extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function InventarisPenyusutanDetil()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("INVENTARIS_PENYUSUTAN_DETIL_ID", $this->getNextId("INVENTARIS_PENYUSUTAN_DETIL_ID","PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL")); 
		$str = "
				INSERT INTO PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL (
				   INVENTARIS_PENYUSUTAN_DETIL_ID, INVENTARIS_PENYUSUTAN_ID, INVENTARIS_RUANGAN_ID, PERSETUJUAN, PERSETUJUAN_OLEH) 
				VALUES (
						".$this->getField("INVENTARIS_PENYUSUTAN_DETIL_ID").", 
						'".$this->getField("INVENTARIS_PENYUSUTAN_ID")."', 
						'".$this->getField("INVENTARIS_RUANGAN_ID")."', 
						'".$this->getField("PERSETUJUAN")."', 
						'".$this->getField("PERSETUJUAN_OLEH")."'
						)"; 
		$this->id = $this->getField("INVENTARIS_PENYUSUTAN_DETIL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL
				SET   
					   INVENTARIS_PENYUSUTAN_ID       = '".$this->getField("INVENTARIS_PENYUSUTAN_ID")."',
					   INVENTARIS_RUANGAN_ID          = '".$this->getField("INVENTARIS_RUANGAN_ID")."'
				WHERE  INVENTARIS_PENYUSUTAN_DETIL_ID = '".$this->getField("INVENTARIS_PENYUSUTAN_DETIL_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL
                WHERE 
                  INVENTARIS_PENYUSUTAN_ID = ".$this->getField("INVENTARIS_PENYUSUTAN_ID").""; 
				  
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
				INVENTARIS_PENYUSUTAN_DETIL_ID, A.INVENTARIS_PENYUSUTAN_ID, A.INVENTARIS_RUANGAN_ID, B.NOMOR, B.KETERANGAN, C.NAMA LOKASI, PERSETUJUAN, PERSETUJUAN_OLEH 
				FROM PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL A
				LEFT JOIN PPI_ASSET.INVENTARIS_RUANGAN B ON A.INVENTARIS_RUANGAN_ID = B.INVENTARIS_RUANGAN_ID
                LEFT JOIN PPI_ASSET.LOKASI C ON B.LOKASI_ID = C.LOKASI_ID
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
				INVENTARIS_PENYUSUTAN_DETIL_ID, INVENTARIS_PENYUSUTAN_ID, INVENTARIS_RUANGAN_ID
				FROM PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY INVENTARIS_PENYUSUTAN_DETIL_ID DESC";
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
		$str = "SELECT COUNT(INVENTARIS_PENYUSUTAN_DETIL_ID) AS ROWCOUNT 
				FROM PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL A
				LEFT JOIN PPI_ASSET.INVENTARIS_RUANGAN B ON A.INVENTARIS_RUANGAN_ID = B.INVENTARIS_RUANGAN_ID
				LEFT JOIN PPI_ASSET.LOKASI C ON B.LOKASI_ID = C.LOKASI_ID
				WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(INVENTARIS_PENYUSUTAN_DETIL_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_PENYUSUTAN_DETIL WHERE 1 = 1 "; 
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