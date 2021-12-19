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

  class KapalPekerjaanAwakKapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalPekerjaanAwakKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_PEKERJAAN_AWAK_KAPAL_ID", $this->getNextId("KAPAL_PEKERJAAN_AWAK_KAPAL_ID","PPI_OPERASIONAL.KAPAL_PEKERJAAN_AWAK_KAPAL"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_PEKERJAAN_AWAK_KAPAL(
				   KAPAL_PEKERJAAN_AWAK_KAPAL_ID, KAPAL_PEKERJAAN_ID, JUMLAH_PREMI, KAPAL_PEKERJAAN_KRU_ID, PEGAWAI_ID, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("KAPAL_PEKERJAAN_AWAK_KAPAL_ID").",
				  '".$this->getField("KAPAL_PEKERJAAN_ID")."',
				  '".$this->getField("JUMLAH_PREMI")."',
				  '".$this->getField("KAPAL_PEKERJAAN_KRU_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PEKERJAAN_AWAK_KAPAL
				SET    
					   KAPAL_PEKERJAAN_ID	= '".$this->getField("KAPAL_PEKERJAAN_ID")."',
					   JUMLAH_PREMI   		= '".$this->getField("JUMLAH_PREMI")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  KAPAL_PEKERJAAN_AWAK_KAPAL_ID  = '".$this->getField("KAPAL_PEKERJAAN_AWAK_KAPAL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_AWAK_KAPAL
                WHERE 
                  KAPAL_PEKERJAAN_AWAK_KAPAL_ID = ".$this->getField("KAPAL_PEKERJAAN_AWAK_KAPAL_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function delete_pegawai_kapal()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_AWAK_KAPAL
                WHERE 
                  KAPAL_PEKERJAAN_ID = ".$this->getField("KAPAL_PEKERJAAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_PEKERJAAN_AWAK_KAPAL_ID ASC")
	{
		$str = "
				  SELECT KAPAL_PEKERJAAN_AWAK_KAPAL_ID, KAPAL_PEKERJAAN_ID, JUMLAH_PREMI
				  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_AWAK_KAPAL				  
				  WHERE KAPAL_PEKERJAAN_AWAK_KAPAL_ID IS NOT NULL
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
				  SELECT KAPAL_PEKERJAAN_AWAK_KAPAL_ID, KAPAL_PEKERJAAN_ID, JUMLAH_PREMI
				  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_AWAK_KAPAL				  
				  WHERE KAPAL_PEKERJAAN_AWAK_KAPAL_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_PEKERJAAN_AWAK_KAPAL_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_PEKERJAAN_AWAK_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_AWAK_KAPAL
		        WHERE KAPAL_PEKERJAAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_PEKERJAAN_AWAK_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_AWAK_KAPAL
		        WHERE KAPAL_PEKERJAAN_AWAK_KAPAL_ID IS NOT NULL ".$statement; 
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