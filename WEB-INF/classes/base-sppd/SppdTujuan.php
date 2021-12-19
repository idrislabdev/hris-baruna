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
  * Entity-base class untuk mengimplementasikan tabel PANGKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class SppdTujuan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SppdTujuan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SPPD_TUJUAN_ID", $this->getNextId("SPPD_TUJUAN_ID","PPI_SPPD.SPPD_TUJUAN"));
		$str = "INSERT INTO PPI_SPPD.SPPD_TUJUAN (
				   SPPD_TUJUAN_ID, SPPD_ID, KOTA_ID, TANGGAL_BERANGKAT, AIRPORT_TAX) 
				VALUES ('".$this->getField("SPPD_TUJUAN_ID")."', 
						'".$this->getField("SPPD_ID")."', 
						'".$this->getField("KOTA_ID")."',
						".$this->getField("TANGGAL_BERANGKAT").",
						'".$this->getField("AIRPORT_TAX")."'
						)"; 
		$this->id = $this->getField("SPPD_TUJUAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD_TUJUAN
				SET    SPPD_ID        = '".$this->getField("SPPD_ID")."',
					   INSTANSI_ID    = '".$this->getField("INSTANSI_ID")."'
				WHERE  SPPD_TUJUAN_ID = '".$this->getField("SPPD_TUJUAN_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.SPPD_TUJUAN
                WHERE 
                  SPPD_ID = ".$this->getField("SPPD_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "SELECT 
                    A.SPPD_TUJUAN_ID, A.SPPD_ID, A.TANGGAL_BERANGKAT, B.NAMA KOTA, B.KOTA_ID, C.NAMA PROVINSI, C.PROVINSI_ID, A.AIRPORT_TAX
                    FROM PPI_SPPD.SPPD_TUJUAN A
                    LEFT JOIN PPI_SPPD.KOTA B ON B.KOTA_ID=A.KOTA_ID
                    LEFT JOIN PPI_SPPD.PROVINSI C ON B.PROVINSI_ID = C.PROVINSI_ID
                WHERE 1 = 1
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
		$str = "SELECT 
					SPPD_TUJUAN_ID, SPPD_ID, INSTANSI_ID
					FROM PPI_SPPD.SPPD_TUJUAN
				WHERE 1 = 1
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
		$str = "SELECT COUNT(SPPD_TUJUAN_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD_TUJUAN

		        WHERE 1 = 1 ".$statement; 
		
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
		$str = "SELECT COUNT(SPPD_TUJUAN_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD_TUJUAN

		        WHERE SPPD_TUJUAN_ID IS NOT NULL ".$statement; 
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