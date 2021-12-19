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

  class JenisBiayaSppd extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function JenisBiayaSppd()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JENIS_BIAYA_SPPD_ID", $this->getNextId("JENIS_BIAYA_SPPD_ID","PPI_SPPD.JENIS_BIAYA_SPPD"));
		$str = "INSERT INTO PPI_SPPD.JENIS_BIAYA_SPPD (
				   JENIS_BIAYA_SPPD_ID, JENIS_SPPD_ID, BIAYA_SPPD_ID) 
				VALUES ('".$this->getField("JENIS_BIAYA_SPPD_ID")."', '".$this->getField("JENIS_SPPD_ID")."', '".$this->getField("BIAYA_SPPD_ID")."')
				"; 
		$this->query = $str;
		$this->id = $this->getField("JENIS_BIAYA_SPPD_ID");
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SPPD.JENIS_BIAYA_SPPD
				SET    JENIS_SPPD_ID       = '".$this->getField("JENIS_SPPD_ID ")."',
					   BIAYA_SPPD_ID       = '".$this->getField("BIAYA_SPPD_ID")."',
				WHERE  JENIS_BIAYA_SPPD_ID = '".$this->getField("JENIS_BIAYA_SPPD_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.JENIS_BIAYA_SPPD
                WHERE 
                  JENIS_SPPD_ID = ".$this->getField("JENIS_SPPD_ID").""; 
				  
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
					JENIS_BIAYA_SPPD_ID, JENIS_SPPD_ID, BIAYA_SPPD_ID
					FROM PPI_SPPD.JENIS_BIAYA_SPPD
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

    function selectByParamsBiayaSppd($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.JENIS_BIAYA_SPPD_ID ASC ")
	{
		$str = "SELECT 
                    A.JENIS_BIAYA_SPPD_ID, A.JENIS_SPPD_ID, A.BIAYA_SPPD_ID, B.NAMA, B.PREFIX
                    FROM PPI_SPPD.JENIS_BIAYA_SPPD A 
                    INNER JOIN PPI_SPPD.BIAYA_SPPD B ON A.BIAYA_SPPD_ID = B.BIAYA_SPPD_ID 
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

    function selectByParamsBiayaSppdPrefix($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.JENIS_BIAYA_SPPD_ID ASC ", $sppd_id="")
	{
		$str = "SELECT 
                    A.JENIS_BIAYA_SPPD_ID, A.JENIS_SPPD_ID, A.BIAYA_SPPD_ID, B.NAMA, B.PREFIX, C.PREFIX PREFIX_ESTIMASI, C.PROSENTASE
                    FROM PPI_SPPD.JENIS_BIAYA_SPPD A 
                    INNER JOIN PPI_SPPD.BIAYA_SPPD B ON A.BIAYA_SPPD_ID = B.BIAYA_SPPD_ID 
					LEFT JOIN PPI_SPPD.ESTIMASI_BIAYA_PREFIX C ON B.PREFIX = C.PREFIX AND C.SPPD_ID = '".$sppd_id."'
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
	
    function selectByParamsParameterFasilitasDiklat($id,$limit=-1,$from=-1)
	{
		$str = "SELECT 
                    A.JENIS_BIAYA_SPPD_ID, A.JENIS_SPPD_ID, A.BIAYA_SPPD_ID, B.NAMA, B.PREFIX, C.BIAYA_SPPD_ID BIAYA_SPPD_ID_FASILITAS
                    FROM PPI_SPPD.JENIS_BIAYA_SPPD A 
                    INNER JOIN PPI_SPPD.BIAYA_SPPD B ON A.BIAYA_SPPD_ID = B.BIAYA_SPPD_ID  AND A.JENIS_SPPD_ID = 2
                    LEFT JOIN PPI_SPPD.FASILITAS_DIKLAT_BIAYA_SPPD C ON A.BIAYA_SPPD_ID = C.BIAYA_SPPD_ID AND FASILITAS_DIKLAT_ID = '".$id."'
                WHERE 1 = 1 ORDER BY  A.BIAYA_SPPD_ID
				"; 
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsParameterSerahTerimaPasangan($id,$limit=-1,$from=-1)
	{
		$str = "SELECT 
                    A.JENIS_BIAYA_SPPD_ID, A.JENIS_SPPD_ID, A.BIAYA_SPPD_ID, B.NAMA, B.PREFIX, C.BIAYA_SPPD_ID BIAYA_SPPD_ID_ST, PROSENTASE
                    FROM PPI_SPPD.JENIS_BIAYA_SPPD A 
                    INNER JOIN PPI_SPPD.BIAYA_SPPD B ON A.BIAYA_SPPD_ID = B.BIAYA_SPPD_ID  AND A.JENIS_SPPD_ID = 3
                    LEFT JOIN PPI_SPPD.SERAH_TERIMA_PASANG_BIAYA_SPPD C ON A.BIAYA_SPPD_ID = C.BIAYA_SPPD_ID
                WHERE 1 = 1 ORDER BY  A.BIAYA_SPPD_ID
				"; 
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
			    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "SELECT 
					JENIS_BIAYA_SPPD_ID, JENIS_SPPD_ID, BIAYA_SPPD_ID
					FROM PPI_SPPD.JENIS_BIAYA_SPPD
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
		$str = "SELECT COUNT(JENIS_BIAYA_SPPD_ID) AS ROWCOUNT FROM PPI_SPPD.JENIS_BIAYA_SPPD

		        WHERE JENIS_BIAYA_SPPD_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(JENIS_BIAYA_SPPD_ID) AS ROWCOUNT FROM PPI_SPPD.JENIS_BIAYA_SPPD

		        WHERE JENIS_BIAYA_SPPD_ID IS NOT NULL ".$statement; 
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