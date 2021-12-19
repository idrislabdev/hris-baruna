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

  class GalanganKru extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function GalanganKru()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("GALANGAN_KRU_ID", $this->getNextId("GALANGAN_KRU_ID","PPI_GALANGAN.GALANGAN_KRU"));

		$str = "
				INSERT INTO PPI_GALANGAN.GALANGAN_KRU (
				   GALANGAN_KRU_ID, PEGAWAI_ID, JABATAN_GALANGAN_ID, GALANGAN_ID, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("GALANGAN_KRU_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("JABATAN_GALANGAN_ID")."',
				  '".$this->getField("GALANGAN_ID")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("GALANGAN_KRU_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_GALANGAN.GALANGAN_KRU
				SET    
					   PEGAWAI_ID         	= '".$this->getField("PEGAWAI_ID")."',
					   JABATAN_GALANGAN_ID	= '".$this->getField("JABATAN_GALANGAN_ID")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  GALANGAN_KRU_ID  = '".$this->getField("GALANGAN_KRU_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GALANGAN.GALANGAN_KRU
                WHERE 
                  GALANGAN_KRU_ID = ".$this->getField("GALANGAN_KRU_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY GALANGAN_KRU_ID ASC")
	{
		$str = "
				  SELECT GALANGAN_KRU_ID, A.PEGAWAI_ID, A.JABATAN_GALANGAN_ID, B.NAMA, C.NAMA JABATAN_NAMA, A.GALANGAN_ID
				  FROM PPI_GALANGAN.GALANGAN_KRU A
                  LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID=B.PEGAWAI_ID
                  LEFT JOIN PPI_GALANGAN.JABATAN_GALANGAN C ON A.JABATAN_GALANGAN_ID = C.JABATAN_GALANGAN_ID
				  WHERE GALANGAN_KRU_ID IS NOT NULL
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
				  SELECT GALANGAN_KRU_ID, PEGAWAI_ID, A.JABATAN_GALANGAN_ID
				  FROM PPI_GALANGAN.GALANGAN_KRU A
				  WHERE GALANGAN_KRU_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY GALANGAN_KRU_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(GALANGAN_KRU_ID) AS ROWCOUNT FROM PPI_GALANGAN.GALANGAN_KRU
		        WHERE GALANGAN_KRU_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(GALANGAN_KRU_ID) AS ROWCOUNT FROM PPI_GALANGAN.GALANGAN_KRU
		        WHERE GALANGAN_KRU_ID IS NOT NULL ".$statement; 
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