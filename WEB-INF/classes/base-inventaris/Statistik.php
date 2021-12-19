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

  class Statistik extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Statistik()
	{
      $this->Entity(); 
    }
	
    function selectByParamsJenisInventaris($statement="", $order=" ORDER BY A.JENIS_INVENTARIS_ID ASC ")
	{
		$str = "
				SELECT A.KODE, A.NAMA, COALESCE(JUMLAH, 0) JUMLAH FROM PPI_ASSET.JENIS_INVENTARIS A LEFT JOIN
                (
                SELECT SUBSTR(JENIS_INVENTARIS_ID, 1, 2) JENIS_INVENTARIS_ID, COUNT(1) JUMLAH FROM PPI_ASSET.INVENTARIS_RUANGAN X INNER JOIN PPI_ASSET.INVENTARIS Y ON X.INVENTARIS_ID = Y.INVENTARIS_ID
                WHERE STATUS_HAPUS = '0'
                GROUP BY SUBSTR(JENIS_INVENTARIS_ID, 1, 2)
                ) B ON A.JENIS_INVENTARIS_ID = B.JENIS_INVENTARIS_ID
                WHERE A.JENIS_INVENTARIS_PARENT_ID = 0      				
			"; 
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsJenisInventarisChild($statement="", $order=" ORDER BY A.JENIS_INVENTARIS_ID ASC ")
	{
		$str = "
				SELECT A.KODE, A.NAMA, COALESCE(JUMLAH, 0) JUMLAH FROM PPI_ASSET.JENIS_INVENTARIS A LEFT JOIN
                (
                SELECT JENIS_INVENTARIS_ID JENIS_INVENTARIS_ID, COUNT(1) JUMLAH FROM PPI_ASSET.INVENTARIS_RUANGAN X INNER JOIN PPI_ASSET.INVENTARIS Y ON X.INVENTARIS_ID = Y.INVENTARIS_ID
                WHERE STATUS_HAPUS = '0'
                GROUP BY JENIS_INVENTARIS_ID
                ) B ON A.JENIS_INVENTARIS_ID = B.JENIS_INVENTARIS_ID
                WHERE 1 = 1    				
			"; 
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsKerusakan($statement="", $order=" ORDER BY A.JENIS_INVENTARIS_ID ASC ")
	{
		$str = "
				SELECT A.KODE, A.NAMA, COALESCE(JUMLAH, 0) JUMLAH FROM PPI_ASSET.JENIS_INVENTARIS A LEFT JOIN
                (
                SELECT SUBSTR(JENIS_INVENTARIS_ID, 1, 2) JENIS_INVENTARIS_ID, COUNT(1) JUMLAH 
				FROM PPI_ASSET.INVENTARIS_RUANGAN X 
                INNER JOIN PPI_ASSET.INVENTARIS Y ON X.INVENTARIS_ID = Y.INVENTARIS_ID
                INNER JOIN PPI_ASSET.INVENTARIS_PERBAIKAN Z ON Z.INVENTARIS_RUANGAN_ID = X.INVENTARIS_RUANGAN_ID
                WHERE 1 = 1
                GROUP BY SUBSTR(JENIS_INVENTARIS_ID, 1, 2)
                ) B ON A.JENIS_INVENTARIS_ID = B.JENIS_INVENTARIS_ID
                WHERE A.JENIS_INVENTARIS_PARENT_ID = 0      				
			"; 
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsKerusakanChild($statement="", $order=" ORDER BY A.JENIS_INVENTARIS_ID ASC ")
	{
		$str = "
				SELECT A.KODE, A.NAMA, COALESCE(JUMLAH, 0) JUMLAH FROM PPI_ASSET.JENIS_INVENTARIS A LEFT JOIN
                (
                SELECT JENIS_INVENTARIS_ID JENIS_INVENTARIS_ID, COUNT(1) JUMLAH 
				FROM PPI_ASSET.INVENTARIS_RUANGAN X 
                INNER JOIN PPI_ASSET.INVENTARIS Y ON X.INVENTARIS_ID = Y.INVENTARIS_ID
                INNER JOIN PPI_ASSET.INVENTARIS_PERBAIKAN Z ON Z.INVENTARIS_RUANGAN_ID = X.INVENTARIS_RUANGAN_ID
                WHERE 1 = 1
                GROUP BY JENIS_INVENTARIS_ID
                ) B ON A.JENIS_INVENTARIS_ID = B.JENIS_INVENTARIS_ID
                WHERE 1 = 1    				
			"; 
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }
		
    function getCountInventaris($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_RUANGAN A INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID WHERE STATUS_HAPUS = '0' ".$statement; 
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
	
    function getCountKerusakanInventaris($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM PPI_ASSET.INVENTARIS_RUANGAN A 
                INNER JOIN PPI_ASSET.INVENTARIS B ON A.INVENTARIS_ID = B.INVENTARIS_ID
                INNER JOIN PPI_ASSET.INVENTARIS_PERBAIKAN C ON A.INVENTARIS_RUANGAN_ID = C.INVENTARIS_RUANGAN_ID 
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
	
  } 
?>