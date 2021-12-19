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

  class KontrakTowing extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KontrakTowing()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KONTRAK_TOWING_ID", $this->getNextId("KONTRAK_TOWING_ID","PPI_OPERASIONAL.KONTRAK_TOWING"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KONTRAK_TOWING (
				   KONTRAK_TOWING_ID, KAPAL_ID_BEBAN, NOMOR, NAMA, JUMLAH, MUATAN, TONASE, 
				   LAST_CREATE_USER, LAST_CREATE_DATE, PROSENTASE_PREMI, SATUAN, LOKASI_ID, TANGGAL_AWAL, TANGGAL_AKHIR, TANGGAL_TANDA_TANGAN) 
 			  	VALUES (
				  ".$this->getField("KONTRAK_TOWING_ID").",
				  '".$this->getField("KAPAL_ID_BEBAN")."',
				  '".$this->getField("NOMOR")."',
				  '".$this->getField("NAMA")."',
				  ".$this->getField("JUMLAH").",
				  '".$this->getField("MUATAN")."',
				  '".$this->getField("TONASE")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("PROSENTASE_PREMI")."',
				  '".$this->getField("SATUAN")."',
				  '".$this->getField("LOKASI_ID")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  ".$this->getField("TANGGAL_TANDA_TANGAN")."
				)"; 
		$this->id = $this->getField("KONTRAK_TOWING_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KONTRAK_TOWING
				SET    
					   LOKASI_ID	 		= '".$this->getField("LOKASI_ID")."',
					   KAPAL_ID_BEBAN			= '".$this->getField("KAPAL_ID_BEBAN")."',
					   KAPAL_ID_PENARIK   		= '".$this->getField("KAPAL_ID_PENARIK")."',
					   NOMOR  		= '".$this->getField("NOMOR")."',
					   NAMA	 			= '".$this->getField("NAMA")."',
					   JUMLAH			= ".$this->getField("JUMLAH").",
					   MUATAN		= '".$this->getField("MUATAN")."',
					   TONASE				= '".$this->getField("TONASE")."',
					   LAST_UPDATE_USER				= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE				= ".$this->getField("LAST_UPDATE_DATE").",
					   PROSENTASE_PREMI 			= '".$this->getField("PROSENTASE_PREMI")."',
					   SATUAN= '".$this->getField("SATUAN")."',
					   TANGGAL_TANDA_TANGAN= ".$this->getField("TANGGAL_TANDA_TANGAN").",
					   TANGGAL_AWAL		= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR				= ".$this->getField("TANGGAL_AKHIR")."
				WHERE  KONTRAK_TOWING_ID  = '".$this->getField("KONTRAK_TOWING_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KONTRAK_TOWING
                WHERE 
                  KONTRAK_TOWING_ID = ".$this->getField("KONTRAK_TOWING_ID").""; 
				  
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
				  SELECT A.KONTRAK_TOWING_ID, A.LOKASI_ID, B.NAMA LOKASI,
				  A.KAPAL_ID_BEBAN, (SELECT X.NAMA FROM PPI_OPERASIONAL.KAPAL_BEBAN X WHERE X.KAPAL_BEBAN_ID=A.KAPAL_ID_BEBAN) KAPAL_ID_BEBAN_NAMA,
				  A.KAPAL_ID_PENARIK, (SELECT X.NAMA FROM PPI_OPERASIONAL.KAPAL X WHERE X.KAPAL_ID=A.KAPAL_ID_PENARIK) KAPAL_ID_PENARIK_NAMA,
				  NOMOR, A.NAMA, A.JUMLAH, A.MUATAN, A.TONASE, A.PROSENTASE_PREMI, A.SATUAN, A.TANGGAL_AWAL, A.TANGGAL_AKHIR, A.TANGGAL_TANDA_TANGAN
				  FROM PPI_OPERASIONAL.KONTRAK_TOWING A
				  INNER JOIN PPI_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID
				  WHERE KONTRAK_TOWING_ID IS NOT NULL
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
				  SELECT KONTRAK_TOWING_ID, KAPAL_ID_BEBAN, KAPAL_ID_PENARIK, NOMOR, NAMA
				  FROM PPI_OPERASIONAL.KONTRAK_TOWING					
				  WHERE KONTRAK_TOWING_ID IS NOT NULL
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
		$str = "SELECT COUNT(KONTRAK_TOWING_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KONTRAK_TOWING
		        WHERE KONTRAK_TOWING_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KONTRAK_TOWING_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KONTRAK_TOWING
		        WHERE KONTRAK_TOWING_ID IS NOT NULL ".$statement; 
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