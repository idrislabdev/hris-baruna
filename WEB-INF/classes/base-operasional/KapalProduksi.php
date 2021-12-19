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

  class KapalProduksi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalProduksi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_PRODUKSI_ID", $this->getNextId("KAPAL_PRODUKSI_ID","PPI_OPERASIONAL.KAPAL_PRODUKSI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_PRODUKSI (
				   KAPAL_PRODUKSI_ID, KAPAL_ID, LOKASI_ID, 
				   PERIODE, TANGGAL_AWAL, TANGGAL_AKHIR, 
				   REALISASI_PRODUKSI, REALISASI_PRODUKSI_MENIT, LAST_CREATE_USER, LAST_CREATE_DATE)   
 			  	VALUES (
				  ".$this->getField("KAPAL_PRODUKSI_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("PERIODE")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  '".$this->getField("REALISASI_PRODUKSI")."',
				  '".$this->getField("REALISASI_PRODUKSI_MENIT")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("KAPAL_PRODUKSI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_PRODUKSI
				SET    
					   KAPAL_ID         	= '".$this->getField("KAPAL_ID")."',
					   LOKASI_ID	 		= '".$this->getField("LOKASI_ID")."',
					   PERIODE	 			= '".$this->getField("PERIODE")."',
					   TANGGAL_AWAL	 		= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR		= ".$this->getField("TANGGAL_AKHIR").",
					   REALISASI_PRODUKSI	= '".$this->getField("REALISASI_PRODUKSI")."',
					   REALISASI_PRODUKSI_MENIT	= '".$this->getField("REALISASI_PRODUKSI_MENIT")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  KAPAL_PRODUKSI_ID 	= '".$this->getField("KAPAL_PRODUKSI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_PRODUKSI
                WHERE 
                  KAPAL_PRODUKSI_ID = ".$this->getField("KAPAL_PRODUKSI_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteRevisi($stat="")
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_PRODUKSI
                WHERE 
                  KAPAL_ID = ".$this->getField("KAPAL_ID")."
				  ".$stat; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_PRODUKSI_ID ASC")
	{
		$str = "
				SELECT KAPAL_PRODUKSI_ID, KAPAL_ID, A.LOKASI_ID, PERIODE, TANGGAL_AWAL, TANGGAL_AKHIR, REALISASI_PRODUKSI, REALISASI_PRODUKSI_MENIT,
				REALISASI_PRODUKSI || ' : ' || REALISASI_PRODUKSI_MENIT REALISASI_PRODUKSI_JAM_MENIT, B.NAMA LOKASI_NAMA
				FROM PPI_OPERASIONAL.KAPAL_PRODUKSI A
				LEFT JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID=B.LOKASI_ID
				WHERE KAPAL_PRODUKSI_ID IS NOT NULL
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
				SELECT KAPAL_PRODUKSI_ID, KAPAL_ID, LOKASI_ID, PERIODE, TANGGAL_AWAL, TANGGAL_AKHIR, REALISASI_PRODUKSI
				FROM PPI_OPERASIONAL.KAPAL_PRODUKSI
				WHERE KAPAL_PRODUKSI_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_PRODUKSI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_PRODUKSI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PRODUKSI
		        WHERE KAPAL_PRODUKSI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_PRODUKSI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_PRODUKSI
		        WHERE KAPAL_PRODUKSI_ID IS NOT NULL ".$statement; 
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