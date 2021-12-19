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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_SK_PEGAWAI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiSKPegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiSKPegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_SK_PEGAWAI_ID", $this->getNextId("PEGAWAI_SK_PEGAWAI_ID","PPI_SIMPEG.PEGAWAI_SK_PEGAWAI"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_SK_PEGAWAI (
				   PEGAWAI_SK_PEGAWAI_ID, PEJABAT_PENETAP_ID, PEGAWAI_ID, NO_SK, TANGGAL_SK, TMT_SK, LAST_CREATE_USER, LAST_CREATE_DATE
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_SK_PEGAWAI_ID").",
				  '".$this->getField("PEJABAT_PENETAP_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("NO_SK")."',
				  ".$this->getField("TANGGAL_SK").",
				  ".$this->getField("TMT_SK").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_SK_PEGAWAI
				SET    
					   PEJABAT_PENETAP_ID   = '".$this->getField("PEJABAT_PENETAP_ID")."',
					   NO_SK   				= '".$this->getField("NO_SK")."',
					   TANGGAL_SK         	= ".$this->getField("TANGGAL_SK").",
					   TMT_SK				= ".$this->getField("TMT_SK").",
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_SK_PEGAWAI_ID     = '".$this->getField("PEGAWAI_SK_PEGAWAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_SK_PEGAWAI
                WHERE 
                  PEGAWAI_SK_PEGAWAI_ID = ".$this->getField("PEGAWAI_SK_PEGAWAI_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_SK_PEGAWAI_ID, PEJABAT_PENETAP_ID, PEGAWAI_ID, NO_SK, TANGGAL_SK, TMT_SK
				FROM PPI_SIMPEG.PEGAWAI_SK_PEGAWAI
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY PEJABAT_PENETAP_ID DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_SK_PEGAWAI_ID, PEJABAT_PENETAP_ID, PEGAWAI_ID, NO_SK, TANGGAL_SK, TMT_SK
				FROM PPI_SIMPEG.PEGAWAI_SK_PEGAWAI
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PEJABAT_PENETAP_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_SK_PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_SK_PEGAWAI
		        WHERE PEGAWAI_SK_PEGAWAI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_SK_PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_SK_PEGAWAI
		        WHERE PEGAWAI_SK_PEGAWAI_ID IS NOT NULL ".$statement; 
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