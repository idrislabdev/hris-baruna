<? 
/* *******************************************************************************************************
MODUL NAME 			: PEL
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel CABANG.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class SettingAplikasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SettingAplikasi()
	{
      $this->Entity(); 
    }
	
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("CABANG_ID", $this->getNextId("CABANG_ID","PPI.SETTING_APLIKASI")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO PPI.SETTING_APLIKASI (
				   KODE, KETERANGAN, NILAI
				   ) 
 			  	VALUES (
				  '".$this->getField("KODE")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("NILAI")."'
				)"; 
		$this->id = $this->getField("KODE");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI.SETTING_APLIKASI
				SET    
					   KODE    			= '".$this->getField("KODE")."',
					   KETERANGAN       = '".$this->getField("KETERANGAN")."',
					   NILAI		    = '".$this->getField("NILAI")."'
				WHERE  KODE 	    	= '".$this->getField("KODE_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function updateNilai()
	{
		$str = "
				UPDATE PPI.SETTING_APLIKASI
				SET    
					   NILAI		    = '".$this->getField("NILAI")."'
				WHERE  KODE 	    	= '".$this->getField("KODE_ID")."'
			 "; //FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI.SETTING_APLIKASI
                WHERE 
                  KODE 	    	= '".$this->getField("KODE_ID")."'"; 
				  
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
	
	function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "	
				SELECT 
				KODE, KETERANGAN, NILAI
				FROM PPI.SETTING_APLIKASI
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
	
	function selectByParamsHukum($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "	
				SELECT 
                KODE, A.KETERANGAN, NILAI, B.NAMA KATEGORI
                FROM PPI.SETTING_APLIKASI A
                LEFT JOIN PEL_HUKUM.KATEGORI B ON A.NILAI = B.KATEGORI_ID
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
				KODE, KETERANGAN, NILAI
				FROM PPI.SETTING_APLIKASI
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KODE ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KODE) AS ROWCOUNT FROM PPI.SETTING_APLIKASI
		        WHERE KODE IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getNilai($kode)
	{
		$str = "SELECT NILAI FROM PPI.SETTING_APLIKASI
		        WHERE KODE IS NOT NULL AND KODE = '".$kode."' "; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("NILAI"); 
		else 
			return 0; 
    }
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KODE) AS ROWCOUNT FROM PPI.SETTING_APLIKASI
		        WHERE KODE IS NOT NULL ".$statement; 
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