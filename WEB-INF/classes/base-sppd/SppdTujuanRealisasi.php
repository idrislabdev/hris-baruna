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

  class SppdTujuanRealisasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SppdTujuanRealisasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("SPPD_TUJUAN_REALISASI_ID", $this->getNextId("SPPD_TUJUAN_REALISASI_ID","PPI_SPPD.SPPD_TUJUAN_REALISASI"));
		$str = "
				INSERT INTO PPI_SPPD.SPPD_TUJUAN_REALISASI (
				   SPPD_ID, SPPD_PESERTA_ID, KOTA_ID, TANGGAL_BERANGKAT_REALISASI) 
				VALUES (
				  '".$this->getField("SPPD_ID")."',
				  '".$this->getField("SPPD_PESERTA_ID")."',
				  '".$this->getField("KOTA_ID")."',
				  ".$this->getField("TANGGAL_BERANGKAT_REALISASI")."
				)"; 
				
		$this->id = $this->getField("SPPD_TUJUAN_REALISASI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function insertBatal()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("SPPD_TUJUAN_REALISASI_ID", $this->getNextId("SPPD_TUJUAN_REALISASI_ID","PPI_SPPD.SPPD_TUJUAN_REALISASI"));
		$str = "
				INSERT INTO PPI_SPPD.SPPD_TUJUAN_REALISASI (
				   SPPD_PESERTA_ID, KOTA_ID, TANGGAL_BERANGKAT_REALISASI, 
				   SPPD_ID)    
				SELECT 
				SPPD_PESERTA_ID, KOTA_ID, 
				   NULL, A.SPPD_ID 
				FROM PPI_SPPD.SPPD_TUJUAN A INNER JOIN PPI_SPPD.SPPD_PESERTA B ON A.SPPD_ID = B.SPPD_ID WHERE A.SPPD_ID = '".$this->getField("SPPD_ID")."'				
				"; 
				
		$this->id = $this->getField("SPPD_TUJUAN_REALISASI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE PPI_SPPD.SPPD_TUJUAN_REALISASI
				SET    SPPD_PESERTA_ID        = '".$this->getField("SPPD_PESERTA_ID")."',
					   TANGGAL_BERANGKAT_REALISASI  = ".$this->getField("TANGGAL_BERANGKAT_REALISASI")."
				WHERE  KOTA_ID = '".$this->getField("KOTA_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.SPPD_TUJUAN_REALISASI
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
				SELECT  SPPD_PESERTA_ID, KOTA_ID, TANGGAL_BERANGKAT_REALISASI
				FROM PPI_SPPD.SPPD_TUJUAN_REALISASI
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
		$str = "
				SELECT SPPD_PESERTA_ID, KOTA_ID, TANGGAL_BERANGKAT_REALISASI
				FROM PPI_SPPD.SPPD_TUJUAN_REALISASI
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
		$str = "SELECT COUNT(KOTA_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD_TUJUAN_REALISASI
		        WHERE 1=1".$statement; 
		
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
		$str = "SELECT COUNT(KOTA_ID) AS ROWCOUNT FROM PPI_SPPD.SPPD_TUJUAN_REALISASI
		        WHERE 1=1 ".$statement; 
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