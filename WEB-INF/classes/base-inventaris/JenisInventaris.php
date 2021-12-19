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

  class JenisInventaris extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function JenisInventaris()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("JENIS_INVENTARIS_ID", $this->getNextId("JENIS_INVENTARIS_ID","PPI_ASSET.JENIS_INVENTARIS")); 
		$str = "
				INSERT INTO PPI_ASSET.JENIS_INVENTARIS (
				   JENIS_INVENTARIS_ID,  JENIS_INVENTARIS_PARENT_ID, NAMA, KETERANGAN, KODE,KODE_GL_DEBET,KODE_GL_KREDIT,NILAI_RESIDU) 
				VALUES (
						PPI_ASSET.JENIS_INVENTARIS_ID_GENERATE('".$this->getField("JENIS_INVENTARIS_ID")."'),
						'".$this->getField("JENIS_INVENTARIS_ID")."', 
						'".$this->getField("NAMA")."', 
						'".$this->getField("KETERANGAN")."',
						'".$this->getField("KODE")."',
						'".$this->getField("KODE_GL_DEBET")."',
						'".$this->getField("KODE_GL_KREDIT")."',
						".$this->getField("NILAI_RESIDU")."
						)"; 
		//$this->id = $this->getField("JENIS_INVENTARIS_ID");
		$this->query = $str;
		// echo $str;exit();
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.JENIS_INVENTARIS
				SET    
					   NAMA                       = '".$this->getField("NAMA")."',
					   KETERANGAN                 = '".$this->getField("KETERANGAN")."',
					   KODE		                  = '".$this->getField("KODE")."',
					   KODE_GL_DEBET		      = '".$this->getField("KODE_GL_DEBET")."',
					   KODE_GL_KREDIT		      = '".$this->getField("KODE_GL_KREDIT")."'
					   NILAI_RESIDU		     	  = '".$this->getField("NILAI_RESIDU")."'
				WHERE  JENIS_INVENTARIS_ID        = '".$this->getField("JENIS_INVENTARIS_ID")."'

				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.JENIS_INVENTARIS
                WHERE 
                  JENIS_INVENTARIS_ID LIKE '".$this->getField("JENIS_INVENTARIS_ID")."%'"; 
				  
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
				JENIS_INVENTARIS_ID, JENIS_INVENTARIS_PARENT_ID, NAMA, KODE || ' - ' || NAMA  NAMA_KODE,
				   KETERANGAN, KODE, KODE_GL_DEBET, KODE_GL_KREDIT, NILAI_RESIDU
				FROM PPI_ASSET.JENIS_INVENTARIS
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
				JENIS_INVENTARIS_ID, JENIS_INVENTARIS_PARENT_ID, NAMA, 
				   KETERANGAN, KODE, KODE_GL_DEBET, KODE_GL_KREDIT, NILAI_RESIDU
				FROM PPI_ASSET.JENIS_INVENTARIS
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY JENIS_INVENTARIS_ID DESC";
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
		$str = "SELECT COUNT(JENIS_INVENTARIS_ID) AS ROWCOUNT FROM PPI_ASSET.JENIS_INVENTARIS  WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(JENIS_INVENTARIS_ID) AS ROWCOUNT FROM PPI_ASSET.JENIS_INVENTARIS WHERE 1 = 1 "; 
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