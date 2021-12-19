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

  class SppdBantuanPindah extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SppdBantuanPindah()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("SPPD_BANTUAN_PINDAH_ID", $this->getNextId("SPPD_BANTUAN_PINDAH_ID","PPI_SPPD.SPPD_BANTUAN_PINDAH"));
		$str = "
				INSERT INTO PPI_SPPD.SPPD_BANTUAN_PINDAH (
				   SPPD_ID, BIAYA_SPPD_BANTUAN_PINDAH_ID) 
				VALUES ('".$this->getField("SPPD_ID")."', 
						'".$this->getField("BIAYA_SPPD_BANTUAN_PINDAH_ID")."'
						)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD_BANTUAN_PINDAH
				SET    BIAYA_SPPD_BANTUAN_PINDAH_ID  		= '".$this->getField("BIAYA_SPPD_BANTUAN_PINDAH_ID")."',
					   KETERANGAN   = '".$this->getField("KETERANGAN")."',
					   JUMLAH  		= '".$this->getField("JUMLAH")."'
				WHERE  SPPD_BANTUAN_PINDAH_ID = '".$this->getField("SPPD_BANTUAN_PINDAH_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.SPPD_BANTUAN_PINDAH
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
		$str = "
				SELECT 
				A.SPPD_ID, A.BIAYA_SPPD_BANTUAN_PINDAH_ID, B.NAMA
				FROM PPI_SPPD.SPPD_BANTUAN_PINDAH A
				LEFT JOIN PPI_SPPD.BIAYA_SPPD_BANTUAN_PINDAH B ON A.BIAYA_SPPD_BANTUAN_PINDAH_ID = B.BIAYA_SPPD_BANTUAN_PINDAH_ID
				WHERE 1=1
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
				SPPD_BANTUAN_PINDAH_ID, SPPD_ID, BIAYA_SPPD_BANTUAN_PINDAH_ID, 
				   KETERANGAN, JUMLAH
				FROM PPI_SPPD.SPPD_BANTUAN_PINDAH
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY BIAYA_SPPD_BANTUAN_PINDAH_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SPPD_BANTUAN_PINDAH_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD_BANTUAN_PINDAH
		        WHERE SPPD_BANTUAN_PINDAH_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(SPPD_BANTUAN_PINDAH_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD_BANTUAN_PINDAH
		        WHERE SPPD_BANTUAN_PINDAH_ID IS NOT NULL ".$statement; 
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