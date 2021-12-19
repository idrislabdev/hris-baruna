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

  class Penugasan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Penugasan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PENUGASAN_ID", $this->getNextId("PENUGASAN_ID","PPI_OPERASIONAL.PENUGASAN"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.PENUGASAN (
				   PENUGASAN_ID, KETERANGAN, NOMOR, NAMA, JUMLAH, TANGGAL_AWAL, TANGGAL_AKHIR, TANGGAL_TANDA_TANGAN,
				   LAST_CREATE_USER, LAST_CREATE_DATE, PROSENTASE_PREMI, TANGGAL_AWAL_REALISASI, TANGGAL_AKHIR_REALISASI, LOKASI_ID, MIL) 
 			  	VALUES (
				  ".$this->getField("PENUGASAN_ID").",
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("NOMOR")."',
				  '".$this->getField("NAMA")."',
				  ".$this->getField("JUMLAH").",
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  ".$this->getField("TANGGAL_TANDA_TANGAN").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("PROSENTASE_PREMI")."',
				  ".$this->getField("TANGGAL_AWAL_REALISASI").",
				  ".$this->getField("TANGGAL_AKHIR_REALISASI").",
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("MIL")."'
				)"; 
		$this->id = $this->getField("PENUGASAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.PENUGASAN
				SET    
					   KAPAL_ID			= '".$this->getField("KAPAL_ID")."',
					   LOKASI_ID	 		= '".$this->getField("LOKASI_ID")."',
					   MIL	 		= '".$this->getField("MIL")."',
					   KETERANGAN   		= '".$this->getField("KETERANGAN")."',
					   NOMOR  		= '".$this->getField("NOMOR")."',
					   NAMA	 			= '".$this->getField("NAMA")."',
					   JUMLAH			= ".$this->getField("JUMLAH").",
					   TANGGAL_AWAL		= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR				= ".$this->getField("TANGGAL_AKHIR").",
					   TANGGAL_TANDA_TANGAN= ".$this->getField("TANGGAL_TANDA_TANGAN").",
					   LAST_UPDATE_USER				= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE				= ".$this->getField("LAST_UPDATE_DATE").",
					   PROSENTASE_PREMI 			= '".$this->getField("PROSENTASE_PREMI")."',
					   TANGGAL_AWAL_REALISASI= ".$this->getField("TANGGAL_AWAL_REALISASI").",
				  	   TANGGAL_AKHIR_REALISASI= ".$this->getField("TANGGAL_AKHIR_REALISASI")."
				WHERE  PENUGASAN_ID  = '".$this->getField("PENUGASAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.PENUGASAN
                WHERE 
                  PENUGASAN_ID = ".$this->getField("PENUGASAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.NAMA ASC")
	{
		$str = "
				  SELECT A.PENUGASAN_ID, A.KAPAL_ID, C.NAMA KAPAL_NAMA, A.KETERANGAN, NOMOR, A.NAMA, A.LOKASI_ID, B.NAMA LOKASI,
                  C.KAPAL_JENIS_ID, A.JUMLAH, A.TANGGAL_AWAL, A.TANGGAL_AKHIR, A.PROSENTASE_PREMI, A.TANGGAL_AWAL_REALISASI, A.TANGGAL_AKHIR_REALISASI, A.MIL, A.TANGGAL_TANDA_TANGAN
                  FROM PPI_OPERASIONAL.PENUGASAN A
				  INNER JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID
                  LEFT JOIN PPI_OPERASIONAL.KAPAL C ON C.KAPAL_ID=A.KAPAL_ID
                  WHERE PENUGASAN_ID IS NOT NULL
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
				  SELECT PENUGASAN_ID, KAPAL_ID, KETERANGAN, NOMOR, NAMA
				  FROM PPI_OPERASIONAL.PENUGASAN					
				  WHERE PENUGASAN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PENUGASAN_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.PENUGASAN
		        WHERE PENUGASAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PENUGASAN_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.PENUGASAN
		        WHERE PENUGASAN_ID IS NOT NULL ".$statement; 
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