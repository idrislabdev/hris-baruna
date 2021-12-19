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

  class Instansi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Instansi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("INSTANSI_ID", $this->getNextId("INSTANSI_ID","PPI_SPPD.INSTANSI"));
		$str = "INSERT INTO PPI_SPPD.INSTANSI (
				   INSTANSI_ID, PROVINSI_ID, NAMA, 
				   KETERANGAN, KOTA) 
				VALUES (".$this->getField("INSTANSI_ID").", 
						'".$this->getField("PROVINSI_ID")."', 
						'".$this->getField("NAMA")."', 
				   		'".$this->getField("KETERANGAN")."', 
						'".$this->getField("KOTA")."'
						)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SPPD.INSTANSI
				SET    PROVINSI_ID = '".$this->getField("PROVINSI_ID")."',
				 	   NAMA        = '".$this->getField("NAMA")."',
					   KETERANGAN  = '".$this->getField("KETERANGAN")."',
					   KOTA        = '".$this->getField("KOTA")."'
				WHERE  INSTANSI_ID = '".$this->getField("INSTANSI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.INSTANSI
                WHERE 
                  INSTANSI_ID = ".$this->getField("INSTANSI_ID").""; 
				  
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
					INSTANSI_ID, A.PROVINSI_ID, A.NAMA, 
					   A.KETERANGAN, A.KOTA, B.NAMA PROVINSI
					FROM PPI_SPPD.INSTANSI A
					INNER JOIN PPI_SPPD.PROVINSI B ON B.PROVINSI_ID = A.PROVINSI_ID 
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
					INSTANSI_ID, PROVINSI_ID, NAMA, 
					   KETERANGAN, KOTA
					FROM PPI_SPPD.INSTANSI

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
		$str = "SELECT COUNT(INSTANSI_ID) AS ROWCOUNT FROM PPI_SPPD.INSTANSI
		        WHERE INSTANSI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(INSTANSI_ID) AS ROWCOUNT FROM PPI_SPPD.INSTANSI
		        WHERE INSTANSI_ID IS NOT NULL ".$statement; 
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