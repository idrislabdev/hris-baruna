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

  class KapalDocking extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalDocking()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_DOCKING_ID", $this->getNextId("KAPAL_DOCKING_ID","PPI_OPERASIONAL.KAPAL_DOCKING"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_DOCKING (
				   KAPAL_DOCKING_ID, KAPAL_ID, TANGGAL_AWAL, TANGGAL_AKHIR, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("KAPAL_DOCKING_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("KAPAL_DOCKING_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_DOCKING
				SET    
					   KAPAL_ID         = '".$this->getField("KAPAL_ID")."',
					   TANGGAL_AWAL	 	= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR	= ".$this->getField("TANGGAL_AKHIR").",
					   KETERANGAN		= '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  KAPAL_DOCKING_ID  = '".$this->getField("KAPAL_DOCKING_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_DOCKING
                WHERE 
                  KAPAL_DOCKING_ID = ".$this->getField("KAPAL_DOCKING_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_DOCKING_ID ASC")
	{
		$str = "
				  SELECT KAPAL_DOCKING_ID, KAPAL_ID, TANGGAL_AWAL, TANGGAL_AKHIR, KETERANGAN
				  FROM PPI_OPERASIONAL.KAPAL_DOCKING				  
				  WHERE KAPAL_DOCKING_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDocking($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY TO_DATE(LPAD(A.HARI, 2, '0') || A.PERIODE, 'DDMMYYYY') ASC")
	{
		$str = "
				SELECT TO_DATE(LPAD(A.HARI, 2, '0') || A.PERIODE, 'DDMMYYYY') TANGGAL, KETERANGAN_DOWNTIME, MULAI, SELESAI, DURASI 
				FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO A 
				INNER JOIN PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO_DETIL B ON A.KAPAL_ID = B.KAPAL_ID AND A.LOKASI_ID = B.LOKASI_ID AND A.PERIODE = B.PERIODE AND A.HARI = B.HARI
				WHERE NVL(RUSAK, 0) >= 1
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
				  SELECT KAPAL_DOCKING_ID, KAPAL_ID, TANGGAL_AWAL, TANGGAL_AKHIR, KETERANGAN
				  FROM PPI_OPERASIONAL.KAPAL_DOCKING				  
				  WHERE KAPAL_DOCKING_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_DOCKING_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_DOCKING_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_DOCKING
		        WHERE KAPAL_DOCKING_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_DOCKING_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_DOCKING
		        WHERE KAPAL_DOCKING_ID IS NOT NULL ".$statement; 
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