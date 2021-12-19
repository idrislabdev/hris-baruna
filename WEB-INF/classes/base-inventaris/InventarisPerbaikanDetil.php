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

  class InventarisPerbaikanDetil extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function InventarisPerbaikanDetil()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("INVENTARIS_PERBAIKAN_DETIL_ID", $this->getNextId("INVENTARIS_PERBAIKAN_DETIL_ID","PPI_ASSET.INVENTARIS_PERBAIKAN_DETIL")); 
		$str = "
				INSERT INTO PPI_ASSET.INVENTARIS_PERBAIKAN_DETIL (
				   INVENTARIS_PERBAIKAN_DETIL_ID, INVENTARIS_PERBAIKAN_ID, NAMA, 
				   KETERANGAN, TIPE, 
				   UKURAN) 
				VALUES (
						".$this->getField("INVENTARIS_PERBAIKAN_DETIL_ID").", 
						'".$this->getField("INVENTARIS_PERBAIKAN_ID")."', 
						'".$this->getField("NAMA")."', 
						'".$this->getField("KETERANGAN")."', 
						".$this->getField("TIPE").", 
						".$this->getField("UKURAN")."
						)"; 
		$this->id = $this->getField("INVENTARIS_PERBAIKAN_DETIL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_PERBAIKAN_DETIL
				SET    
					   NAMA                          = '".$this->getField("NAMA")."',
					   KETERANGAN                    = '".$this->getField("KETERANGAN")."'
				WHERE  INVENTARIS_PERBAIKAN_DETIL_ID = '".$this->getField("INVENTARIS_PERBAIKAN_DETIL_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }
	
	function updateFormat()
	{
		$str = "
				UPDATE PPI_ASSET.INVENTARIS_PERBAIKAN_DETIL
				SET    
					  TIPE=".$this->getField("TIPE").",
				  	  UKURAN=".$this->getField("UKURAN")."
				WHERE  INVENTARIS_PERBAIKAN_DETIL_ID     = '".$this->getField("INVENTARIS_PERBAIKAN_DETIL_ID")."'
			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.INVENTARIS_PERBAIKAN_DETIL
                WHERE 
                  INVENTARIS_PERBAIKAN_DETIL_ID = ".$this->getField("INVENTARIS_PERBAIKAN_DETIL_ID").""; 
				  
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
				INVENTARIS_PERBAIKAN_DETIL_ID, INVENTARIS_PERBAIKAN_ID, NAMA, 
				   KETERANGAN, TIPE, FILE_GAMBAR,
				   UKURAN
				FROM PPI_ASSET.INVENTARIS_PERBAIKAN_DETIL
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
				INVENTARIS_PERBAIKAN_DETIL_ID, INVENTARIS_PERBAIKAN_ID, NAMA, 
				   KETERANGAN, FILE_GAMBAR, TIPE, 
				   UKURAN
				FROM PPI_ASSET.INVENTARIS_PERBAIKAN_DETIL
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY INVENTARIS_PERBAIKAN_DETIL_ID DESC";
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
		$str = "SELECT COUNT(INVENTARIS_PERBAIKAN_DETIL_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_PERBAIKAN_DETIL  WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(INVENTARIS_PERBAIKAN_DETIL_ID) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_PERBAIKAN_DETIL WHERE 1 = 1 "; 
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