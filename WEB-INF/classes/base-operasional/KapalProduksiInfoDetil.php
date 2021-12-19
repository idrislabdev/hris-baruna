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

  class KapalProduksiInfoDetil extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalProduksiInfoDetil()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_PRODUKSI_INFO_DETIL_ID", $this->getNextId("KAPAL_PRODUKSI_INFO_DETIL_ID","PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_DETIL"));
		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_DETIL (
				   KAPAL_PRODUKSI_INFO_DETIL_ID, HARI, KAPAL_ID, LOKASI_ID, 
				   PERIODE, MULAI, SELESAI, DURASI)
 			  	VALUES (
				  ".$this->getField("KAPAL_PRODUKSI_INFO_DETIL_ID").",
				  ".$this->getField("HARI").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("PERIODE")."',
				  '".$this->getField("MULAI")."',
				  '".$this->getField("SELESAI")."',
				  '".$this->getField("DURASI")."'
				)"; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_DETIL 
				SET    
					   MULAI	= '".$this->getField("MULAI")."',
					   SELESAI	 	= '".$this->getField("SELESAI")."'
				WHERE  HARI	= '".$this->getField("HARI")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "
				DELETE FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_DETIL 
                	WHERE 
                  	HARI	= '".$this->getField("HARI")."' AND KAPAL_ID	= '".$this->getField("KAPAL_ID")."' AND PERIODE	= '".$this->getField("PERIODE")."'
					"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_PRODUKSI_INFO_DETIL_ID ASC")
	{
		$str = "
				SELECT 
				KAPAL_ID, LOKASI_ID, 
				   PERIODE, MULAI, SELESAI, KAPAL_PRODUKSI_INFO_DETIL_ID, HARI, DURASI
				FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_DETIL				
				WHERE KAPAL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		//echo $str;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
				SELECT 
				KAPAL_ID, LOKASI_ID, 
				   PERIODE, MULAI, SELESAI, KAPAL_PRODUKSI_INFO_DETIL_ID, HARI
				FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_DETIL
				WHERE KAPAL_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_PRODUKSI_INFO_DETIL_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_PRODUKSI_INFO_DETIL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_DETIL  A
		        WHERE KAPAL_PRODUKSI_INFO_DETIL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_PRODUKSI_INFO_DETIL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_DETIL
		        WHERE KAPAL_PRODUKSI_INFO_DETIL_ID IS NOT NULL ".$statement; 
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