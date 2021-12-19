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

  class JabatanGalangan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function JabatanGalangan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JABATAN_GALANGAN_ID", $this->getNextId("JABATAN_GALANGAN_ID","PPI_GALANGAN.JABATAN_GALANGAN"));

		$str = "
				INSERT INTO PPI_GALANGAN.JABATAN_GALANGAN (
				   JABATAN_GALANGAN_ID, NAMA, PROSENTASE_INSENTIF, 
				   PROSENTASE_PPH) 
 			  	VALUES (
				  ".$this->getField("JABATAN_GALANGAN_ID").",
				  '".$this->getField("NAMA")."',
				  ".$this->getField("PROSENTASE_INSENTIF").",
				  ".$this->getField("PROSENTASE_PPH")."
				)"; 
		$this->id = $this->getField("JABATAN_GALANGAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_GALANGAN.JABATAN_GALANGAN
				SET    
					   NAMA         = '".$this->getField("NAMA")."',
					   PROSENTASE_INSENTIF	 	= ".$this->getField("PROSENTASE_INSENTIF").",
					   PROSENTASE_PPH	 	= ".$this->getField("PROSENTASE_PPH")."
				WHERE  JABATAN_GALANGAN_ID  = '".$this->getField("JABATAN_GALANGAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GALANGAN.JABATAN_GALANGAN
                WHERE 
                  JABATAN_GALANGAN_ID = ".$this->getField("JABATAN_GALANGAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY JABATAN_GALANGAN_ID ASC")
	{
		$str = "
				  SELECT JABATAN_GALANGAN_ID, NAMA, A.PROSENTASE_INSENTIF, PROSENTASE_PPH
				  FROM PPI_GALANGAN.JABATAN_GALANGAN A
				  WHERE JABATAN_GALANGAN_ID IS NOT NULL
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
				  SELECT JABATAN_GALANGAN_ID, NAMA, A.PROSENTASE_INSENTIF, PROSENTASE_PPH
				  FROM PPI_GALANGAN.JABATAN_GALANGAN A
				  WHERE JABATAN_GALANGAN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY JABATAN_GALANGAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(JABATAN_GALANGAN_ID) AS ROWCOUNT FROM PPI_GALANGAN.JABATAN_GALANGAN
		        WHERE JABATAN_GALANGAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(JABATAN_GALANGAN_ID) AS ROWCOUNT FROM PPI_GALANGAN.JABATAN_GALANGAN
		        WHERE JABATAN_GALANGAN_ID IS NOT NULL ".$statement; 
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