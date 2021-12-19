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

  class KapalPekerjaanAdendum extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalPekerjaanAdendum()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_PEKERJAAN_ADENDUM_ID", $this->getNextId("KAPAL_PEKERJAAN_ADENDUM_ID","PPI_OPERASIONAL.KAPAL_PEKERJAAN_ADENDUM"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_PEKERJAAN_ADENDUM (
				   KAPAL_PEKERJAAN_ADENDUM_ID, KAPAL_PEKERJAAN_ID, NO_KONTRAK, 
				   TANGGAL_AWAL, TANGGAL_AKHIR, JUMLAH) 
 			  	VALUES (
				  ".$this->getField("KAPAL_PEKERJAAN_ADENDUM_ID").",
				  '".$this->getField("KAPAL_PEKERJAAN_ID")."',
				  '".$this->getField("NO_KONTRAK")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id = $this->getField("KAPAL_PEKERJAAN_ADENDUM_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PEKERJAAN_ADENDUM
				SET    
					   KAPAL_PEKERJAAN_ID   = '".$this->getField("KAPAL_PEKERJAAN_ID")."',
					   NO_KONTRAK	 		= '".$this->getField("NO_KONTRAK")."',
					   TANGGAL_AWAL	 		= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR		= ".$this->getField("TANGGAL_AKHIR").",
					   JUMLAH				= '".$this->getField("JUMLAH")."'
				WHERE  KAPAL_PEKERJAAN_ADENDUM_ID  = '".$this->getField("KAPAL_PEKERJAAN_ADENDUM_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_ADENDUM
                WHERE 
                  KAPAL_PEKERJAAN_ADENDUM_ID = ".$this->getField("KAPAL_PEKERJAAN_ADENDUM_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_PEKERJAAN_ADENDUM_ID ASC")
	{
		$str = "
				  SELECT 
				  KAPAL_PEKERJAAN_ADENDUM_ID, A.KAPAL_PEKERJAAN_ID, NO_KONTRAK, 
					 TANGGAL_AWAL, TANGGAL_AKHIR, JUMLAH
				  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_ADENDUM A				  
				  WHERE KAPAL_PEKERJAAN_ADENDUM_ID IS NOT NULL
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
				  KAPAL_PEKERJAAN_ADENDUM_ID, A.KAPAL_PEKERJAAN_ID, NO_KONTRAK, 
					 TANGGAL_AWAL, TANGGAL_AKHIR, JUMLAH
				  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_ADENDUM A				  
				  WHERE KAPAL_PEKERJAAN_ADENDUM_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_PEKERJAAN_ADENDUM_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_PEKERJAAN_ADENDUM_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_ADENDUM
		        WHERE KAPAL_PEKERJAAN_ADENDUM_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_PEKERJAAN_ADENDUM_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_ADENDUM
		        WHERE KAPAL_PEKERJAAN_ADENDUM_ID IS NOT NULL ".$statement; 
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