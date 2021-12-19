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
  * Entity-base class untuk mengimplementasikan tabel KAPAL_JENIS.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class Kategori extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Kategori()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KATEGORI_ID", $this->getNextId("KATEGORI_ID","PPI_HUKUM.KATEGORI"));
        //PPI_HUKUM.KATEGORI_ID_GENERATE('".$this->getField("KATEGORI_ID")."'),
		$str = "
				INSERT INTO PPI_HUKUM.KATEGORI (
				   KATEGORI_ID, KATEGORI_PARENT_ID, 
				   NAMA, KETERANGAN, URUT, STATUS_TMT) 
 			  	VALUES (
				  '".$this->getField("ID")."',
				  '".$this->getField("KATEGORI_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("URUT")."',
				  '".$this->getField("STATUS_TMT")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function insertPindah()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KATEGORI_ID", $this->getNextId("KATEGORI_ID","PPI_HUKUM.KATEGORI"));
        //PPI_HUKUM.KATEGORI_ID_GENERATE('".$this->getField("KATEGORI_ID")."'),
		$str = "
				INSERT INTO PPI_HUKUM.KATEGORI (
				   KATEGORI_ID, KATEGORI_PARENT_ID, 
				   NAMA, KETERANGAN, URUT, STATUS_TMT, LINK_FILE) 
 			  	SELECT '".$this->getField("ID")."', '".$this->getField("KATEGORI_ID")."', NAMA, KETERANGAN, URUT, STATUS_TMT, LINK_FILE FROM
				PPI_HUKUM.KATEGORI WHERE KATEGORI_ID = '".$this->getField("KATEGORI_ID_LAMA")."'
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE PPI_HUKUM.KATEGORI
				SET    
					   NAMA         	= '".$this->getField("NAMA")."',
					   KETERANGAN		= '".$this->getField("KETERANGAN")."',
					   URUT				= '".$this->getField("URUT")."',
					   STATUS_TMT				= '".$this->getField("STATUS_TMT")."'
				WHERE  KATEGORI_ID  		= '".$this->getField("KATEGORI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
		$str1= "DELETE FROM PPI_HUKUM.KATEGORI_MENU_GROUP
                WHERE 
                  KATEGORI_ID = '".$this->getField("KATEGORI_ID")."'"; 
				  
		$this->query = $str1;
        $this->execQuery($str1);
		
        $str = "DELETE FROM PPI_HUKUM.KATEGORI
                WHERE 
                  KATEGORI_ID = '".$this->getField("KATEGORI_ID")."'"; 
				  
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
	
	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY URUT ASC, NAMA ASC")
	{
		$str = "
				SELECT 
				KATEGORI_ID, KATEGORI_PARENT_ID, NAMA, KETERANGAN, URUT,
				PPI_HUKUM.AMBIL_MENU_GROUP(KATEGORI_ID) MENU_GROUP, STATUS_TMT
				FROM PPI_HUKUM.KATEGORI
				WHERE KATEGORI_ID IS NOT NULL
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
				KATEGORI_ID, KATEGORI_PARENT_ID, NAMA, KETERANGAN
				FROM PPI_HUKUM.KATEGORI
				WHERE KATEGORI_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KATEGORI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	function getCountTreeByParams($id="")
	{
		$str = "
		SELECT PPI_HUKUM.KATEGORI_ID_GENERATE('".$id."') AS ROWCOUNT FROM DUAL"; 
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

	function getKategori($kategori_id)
	{
		$str = "SELECT PPI_HUKUM.AMBIL_KATEGORI('".$kategori_id."') KATEGORI FROM DUAL "; 
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("KATEGORI"); 
		else 
			return ""; 
    }	
	
	function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KATEGORI_ID) AS ROWCOUNT FROM PPI_HUKUM.KATEGORI
		        WHERE KATEGORI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KATEGORI_ID) AS ROWCOUNT FROM PPI_HUKUM.KATEGORI
		        WHERE KATEGORI_ID IS NOT NULL ".$statement; 
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