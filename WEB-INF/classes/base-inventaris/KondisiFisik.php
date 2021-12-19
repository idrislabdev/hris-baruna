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

  class KondisiFisik extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KondisiFisik()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KONDISI_FISIK_ID", $this->getNextId("KONDISI_FISIK_ID","PPI_ASSET.KONDISI_FISIK")); 
		$str = "
				INSERT INTO PPI_ASSET.KONDISI_FISIK (
				   KONDISI_FISIK_ID,  NAMA, 
				   KETERANGAN, PROSENTASE) 
				VALUES (
						".$this->getField("KONDISI_FISIK_ID").", 
						'".$this->getField("NAMA")."', 
						'".$this->getField("KETERANGAN")."', 
						".$this->getField("PROSENTASE")."
						)"; 
		$this->id = $this->getField("KONDISI_FISIK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.KONDISI_FISIK
				SET    
					   NAMA                       = '".$this->getField("NAMA")."',
					   KETERANGAN                 = '".$this->getField("KETERANGAN")."',
					   PROSENTASE				  =	".$this->getField("PROSENTASE")."
				WHERE  KONDISI_FISIK_ID       	  = '".$this->getField("KONDISI_FISIK_ID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.KONDISI_FISIK
                WHERE 
                  KONDISI_FISIK_ID = ".$this->getField("KONDISI_FISIK_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY PROSENTASE DESC ")
	{
		$str = "
				SELECT 
				KONDISI_FISIK_ID,  NAMA, KETERANGAN, PROSENTASE
				FROM PPI_ASSET.KONDISI_FISIK
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
				KONDISI_FISIK_ID,  NAMA, KETERANGAN, PROSENTASE
				FROM PPI_ASSET.KONDISI_FISIK
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY KONDISI_FISIK_ID DESC";
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
		$str = "SELECT COUNT(KONDISI_FISIK_ID) AS ROWCOUNT FROM PPI_ASSET.KONDISI_FISIK  WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(KONDISI_FISIK_ID) AS ROWCOUNT FROM PPI_ASSET.KONDISI_FISIK WHERE 1 = 1 "; 
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