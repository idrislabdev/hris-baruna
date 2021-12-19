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

  class KapalPekerjaanKapalGanti extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalPekerjaanKapalGanti()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_PEKERJAAN_KAPAL_GANTI_ID", $this->getNextId("KAPAL_PEKERJAAN_KAPAL_GANTI_ID","PPI_OPERASIONAL.KAPAL_PEKERJAAN_KAPAL_GANTI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_PEKERJAAN_KAPAL_GANTI (
				   KAPAL_PEKERJAAN_KAPAL_GANTI_ID, KAPAL_PEKERJAAN_ID, TANGGAL_AWAL, 
				   TANGGAL_AKHIR, KETERANGAN_PENGGANTIAN) 
 			  	VALUES (
				  ".$this->getField("KAPAL_PEKERJAAN_KAPAL_GANTI_ID").",
				  '".$this->getField("KAPAL_PEKERJAAN_ID")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  '".$this->getField("KETERANGAN_PENGGANTIAN")."'
				)"; 
		$this->id = $this->getField("KAPAL_PEKERJAAN_KAPAL_GANTI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PEKERJAAN_KAPAL_GANTI
				SET    
					   KAPAL_PEKERJAAN_ID   	= '".$this->getField("KAPAL_PEKERJAAN_ID")."',
					   TANGGAL_AWAL	 			= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR			= ".$this->getField("TANGGAL_AKHIR").",
					   KETERANGAN_PENGGANTIAN	= '".$this->getField("KETERANGAN_PENGGANTIAN")."'
				WHERE  KAPAL_PEKERJAAN_KAPAL_GANTI_ID  = '".$this->getField("KAPAL_PEKERJAAN_KAPAL_GANTI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "
			DELETE FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_KAPAL_GANTI
                WHERE 
                  KAPAL_PEKERJAAN_KAPAL_GANTI_ID = ".$this->getField("KAPAL_PEKERJAAN_KAPAL_GANTI_ID")."
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_PEKERJAAN_KAPAL_GANTI_ID ASC")
	{
		$str = "
				  SELECT 
				  KAPAL_PEKERJAAN_KAPAL_GANTI_ID, KAPAL_PEKERJAAN_ID, TANGGAL_AWAL, 
					 TANGGAL_AKHIR, KETERANGAN_PENGGANTIAN
				  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_KAPAL_GANTI A			  
				  WHERE KAPAL_PEKERJAAN_KAPAL_GANTI_ID IS NOT NULL
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
				  KAPAL_PEKERJAAN_KAPAL_GANTI_ID, KAPAL_PEKERJAAN_ID, TANGGAL_AWAL, 
					 TANGGAL_AKHIR, KETERANGAN_PENGGANTIAN
				  FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_KAPAL_GANTI A			  
				  WHERE KAPAL_PEKERJAAN_KAPAL_GANTI_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_PEKERJAAN_KAPAL_GANTI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_PEKERJAAN_KAPAL_GANTI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_KAPAL_GANTI
		        WHERE KAPAL_PEKERJAAN_KAPAL_GANTI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_PEKERJAAN_KAPAL_GANTI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_KAPAL_GANTI
		        WHERE KAPAL_PEKERJAAN_KAPAL_GANTI_ID IS NOT NULL ".$statement; 
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