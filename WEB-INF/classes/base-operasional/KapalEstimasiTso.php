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

  class KapalEstimasiTso extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalEstimasiTso()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_ESTIMASI_TSO_ID", $this->getNextId("KAPAL_ESTIMASI_TSO_ID","PPI_OPERASIONAL.KAPAL_ESTIMASI_TSO"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_ESTIMASI_TSO (
				   KAPAL_ESTIMASI_TSO_ID, KAPAL_ID, PERIODE, JUMLAH_JAM, JUMLAH_MENIT,
				   LAST_CREATE_USER, LAST_CREATE_DATE, TANGGAL_MASUK, TANGGAL_KELUAR) 
 			  	VALUES (
				  ".$this->getField("KAPAL_ESTIMASI_TSO_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("PERIODE")."',
				  '".$this->getField("JUMLAH_JAM")."',
				  '".$this->getField("JUMLAH_MENIT")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  ".$this->getField("TANGGAL_MASUK").",
				  ".$this->getField("TANGGAL_KELUAR")."
				)"; 
		$this->query = $str;
		$this->id = $this->getField("KAPAL_ESTIMASI_TSO_ID");

		return $this->execQuery($str);
    }

	function insertPenuh()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_ESTIMASI_TSO_ID", $this->getNextId("KAPAL_ESTIMASI_TSO_ID","PPI_OPERASIONAL.KAPAL_ESTIMASI_TSO"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_ESTIMASI_TSO (
                   KAPAL_ESTIMASI_TSO_ID, KAPAL_ID, PERIODE, JUMLAH_JAM, JUMLAH_MENIT,
                   LAST_CREATE_USER, LAST_CREATE_DATE, TANGGAL_MASUK, TANGGAL_KELUAR)
				   SELECT ".$this->getField("KAPAL_ESTIMASI_TSO_ID").", '".$this->getField("KAPAL_ID")."', '".$this->getField("PERIODE")."', 
				   0, 0, '".$this->getField("LAST_CREATE_USER")."', SYSDATE, 
				   TO_DATE('".$this->getField("PERIODE")." 00:00', 'MMYYYY HH24:MI'), LAST_DAY(TO_DATE('".$this->getField("PERIODE")." 23:59', 'MMYYYY HH24:MI')) FROM DUAL 	
				"; 
		$this->query = $str;
		$this->id = $this->getField("KAPAL_ESTIMASI_TSO_ID");

		return $this->execQuery($str);
    }



    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_ESTIMASI_TSO
				SET    
					   KAPAL_ID         	= '".$this->getField("KAPAL_ID")."',
					   PERIODE         	= '".$this->getField("PERIODE")."',
					   JUMLAH_JAM         	= '".$this->getField("JUMLAH_JAM")."',
					   JUMLAH_MENIT         	= '".$this->getField("JUMLAH_MENIT")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE").",
					   TANGGAL_MASUK= ".$this->getField("TANGGAL_MASUK").",
				  	   TANGGAL_KELUAR= ".$this->getField("TANGGAL_KELUAR")."
				WHERE  KAPAL_ESTIMASI_TSO_ID  	= '".$this->getField("KAPAL_ESTIMASI_TSO_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_ESTIMASI_TSO
                WHERE 
                  KAPAL_ESTIMASI_TSO_ID = ".$this->getField("KAPAL_ESTIMASI_TSO_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deletePenuh()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_ESTIMASI_TSO
                WHERE 
                  KAPAL_ID = ".$this->getField("KAPAL_ID")." AND PERIODE = '".$this->getField("PERIODE")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_ESTIMASI_TSO_ID ASC")
	{
		$str = "
				SELECT 
				   KAPAL_ESTIMASI_TSO_ID, KAPAL_ID, PERIODE, JUMLAH_JAM, JUMLAH_MENIT, JUMLAH_JAM || ':' || JUMLAH_MENIT JUMLAH,
				   TO_CHAR(TANGGAL_MASUK, 'YYYY-MM-DD HH24:MI') TANGGAL_MASUK, TO_CHAR(TANGGAL_KELUAR, 'YYYY-MM-DD HH24:MI') TANGGAL_KELUAR
				FROM PPI_OPERASIONAL.KAPAL_ESTIMASI_TSO A
				WHERE KAPAL_ESTIMASI_TSO_ID IS NOT NULL
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
				   KAPAL_ESTIMASI_TSO_ID, KAPAL_ID, PERIODE, JUMLAH
				FROM PPI_OPERASIONAL.KAPAL_ESTIMASI_TSO				
				WHERE KAPAL_ESTIMASI_TSO_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_ESTIMASI_TSO_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_ESTIMASI_TSO_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_ESTIMASI_TSO
		        WHERE KAPAL_ESTIMASI_TSO_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_ESTIMASI_TSO_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_ESTIMASI_TSO
		        WHERE KAPAL_ESTIMASI_TSO_ID IS NOT NULL ".$statement; 
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