<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class TarifTransport extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TarifTransport()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TARIF_TRANSPORT_ID", $this->getNextId("TARIF_TRANSPORT_ID","PPI_GAJI.TARIF_TRANSPORT"));

		$str = "
				INSERT INTO PPI_GAJI.TARIF_TRANSPORT (TARIF_TRANSPORT_ID, JENIS_PEGAWAI_ID , DEPARTEMEN_ID, NILAI) 
				VALUES(
					  '".$this->getField("TARIF_TRANSPORT_ID")."',
					  '".$this->getField("JENIS_PEGAWAI_ID")."',
					  '".$this->getField("DEPARTEMEN_ID")."',
					  '".$this->getField("NILAI")."'
				)"; 
		$this->id = $this->getField("PPI_GAJI.TARIF_TRANSPORT");
		$this->query = $str;
		// echo $str; exit();
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.TARIF_TRANSPORT
			   SET 
			   		NILAI	= '".$this->getField("NILAI")."',
				   	JENIS_PEGAWAI_ID 	= '".$this->getField("JENIS_PEGAWAI_ID ")."',
				   	DEPARTEMEN_ID	= '".$this->getField("DEPARTEMEN_ID")."'
			 WHERE TARIF_TRANSPORT_ID = ".$this->getField("TARIF_TRANSPORT_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.TARIF_TRANSPORT
                WHERE 
                  TARIF_TRANSPORT_ID = ".$this->getField("TARIF_TRANSPORT_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT A.TARIF_TRANSPORT_ID, A.NILAI, A.JENIS_PEGAWAI_ID , A.DEPARTEMEN_ID, B.NAMA JENIS_PEGAWAI_NAMA, C.NAMA DEPARTEMEN_NAMA
				FROM PPI_GAJI.TARIF_TRANSPORT A
                LEFT JOIN PPI_SIMPEG.JENIS_PEGAWAI B ON A.JENIS_PEGAWAI_ID=B.JENIS_PEGAWAI_ID
                LEFT JOIN PPI_SIMPEG.DEPARTEMEN C ON C.DEPARTEMEN_ID=A.DEPARTEMEN_ID
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		// echo $str->query; exit();
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT MERIT_PMS_ID, PENDIDIKAN_ID, PERIODE, JUMLAH
				FROM PPI_GAJI.MERIT_PMS		
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY MERIT_PMS_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TARIF_TRANSPORT_ID) AS ROWCOUNT 
				FROM PPI_GAJI.TARIF_TRANSPORT  	 WHERE 1 = 1 ".$statement; 
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(MERIT_PMS_ID) AS ROWCOUNT FROM PPI_GAJI.MERIT_PMS WHERE 1 = 1 "; 
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