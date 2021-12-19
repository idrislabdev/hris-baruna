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
  * Entity-base class untuk mengimplementasikan tabel KAPAL_SERTIFIKAT_AWAK_KAPAL.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KapalSertifikatAwakKapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalSertifikatAwakKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_SERTIFIKAT_AWAK_KAPAL_ID", $this->getNextId("KAPAL_SERTIFIKAT_AWAK_KAPAL_ID","PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL"));

		$str = "
					INSERT INTO PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL (
					   KAPAL_SERTIFIKAT_AWAK_KAPAL_ID, KAPAL_ID, SERTIFIKAT_AWAK_KAPAL_ID, JUMLAH, LAST_CREATE_USER, LAST_CREATE_DATE)
 			  	VALUES (
				  ".$this->getField("KAPAL_SERTIFIKAT_AWAK_KAPAL_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("SERTIFIKAT_AWAK_KAPAL_ID")."',
				  ".$this->getField("JUMLAH").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id=$this->getField("KAPAL_SERTIFIKAT_AWAK_KAPAL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL
				SET    
					   KAPAL_ID         	= '".$this->getField("KAPAL_ID")."',
					   SERTIFIKAT_AWAK_KAPAL_ID	 	= '".$this->getField("SERTIFIKAT_AWAK_KAPAL_ID")."'
					   JUMLAH= ".$this->getField("JUMLAH")."
				WHERE  KAPAL_SERTIFIKAT_AWAK_KAPAL_ID  = '".$this->getField("KAPAL_SERTIFIKAT_AWAK_KAPAL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateByField()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL
				SET    
					   ".$this->getField("FIELD_NAME")." = '".$this->getField("FIELD_VALUE")."'
				WHERE  KAPAL_SERTIFIKAT_AWAK_KAPAL_ID  = '".$this->getField("KAPAL_SERTIFIKAT_AWAK_KAPAL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL
                WHERE 
                  KAPAL_ID = ".$this->getField("KAPAL_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_ID ASC")
	{
		$str = "
					SELECT 
					KAPAL_SERTIFIKAT_AWAK_KAPAL_ID, KAPAL_ID, SERTIFIKAT_AWAK_KAPAL_ID, JUMLAH
					FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL A WHERE KAPAL_SERTIFIKAT_AWAK_KAPAL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsSertifikatAwakKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.SERTIFIKAT_AWAK_KAPAL_ID ASC")
	{
		$str = "
					SELECT 
					A.KAPAL_SERTIFIKAT_AWAK_KAPAL_ID, B.NAMA, JUMLAH, (SELECT COUNT(SERTIFIKAT_AWAK_KAPAL_ID) FROM PPI_OPERASIONAL.PEGAWAI_KAPAL X INNER JOIN PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID 
                    WHERE A.KAPAL_ID = X.KAPAL_ID AND B.SERTIFIKAT_AWAK_KAPAL_ID = Y.SERTIFIKAT_AWAK_KAPAL_ID) JUMLAH_DIPENUHI
					FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL A 
					INNER JOIN PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL B ON A.SERTIFIKAT_AWAK_KAPAL_ID = B.SERTIFIKAT_AWAK_KAPAL_ID
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
		
	function selectByParamsPekerjaanSertifikatAwakKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.SERTIFIKAT_AWAK_KAPAL_ID ASC")
	{
		$str = "
     				SELECT 
					A.KAPAL_PEKERJAAN_SERT_AWAK_ID, B.NAMA, A.JUMLAH, A.JUMLAH_DIPENUHI
					FROM PPI_OPERASIONAL.KAPAL_PEKERJAAN_SERT_AWAK A 
					INNER JOIN PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL B ON A.SERTIFIKAT_AWAK_KAPAL_ID = B.SERTIFIKAT_AWAK_KAPAL_ID
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

	function selectByParamsAwakKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_ID ASC")
	{
		$str = "
					SELECT 
					KAPAL_SERTIFIKAT_AWAK_KAPAL_ID, KAPAL_ID, A.SERTIFIKAT_AWAK_KAPAL_ID, JUMLAH, B.NAMA
					FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL A
					LEFT JOIN PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL B ON A.SERTIFIKAT_AWAK_KAPAL_ID = B.SERTIFIKAT_AWAK_KAPAL_ID
					WHERE KAPAL_SERTIFIKAT_AWAK_KAPAL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsInsert($paramsArray=array(),$limit=-1,$from=-1, $statement="", $jenis_id='', $kapal_id='', $order="ORDER BY A.NAMA ASC")
	{
		$str = "
				SELECT 
					KAPAL_JENIS_SERT_AWAK_KPL_ID, B.KAPAL_JENIS_ID, A.SERTIFIKAT_AWAK_KAPAL_ID, B.JUMLAH, A.NAMA
				FROM PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL B ON A.SERTIFIKAT_AWAK_KAPAL_ID=B.SERTIFIKAT_AWAK_KAPAL_ID AND B.KAPAL_JENIS_ID='".$jenis_id."'
				LEFT JOIN PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL C ON A.SERTIFIKAT_AWAK_KAPAL_ID=C.SERTIFIKAT_AWAK_KAPAL_ID AND C.KAPAL_ID = '".$kapal_id."'
				WHERE KAPAL_JENIS_SERT_AWAK_KPL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsSertifikatAwakKpl($paramsArray=array(),$limit=-1,$from=-1, $statement="", $kapal_id='', $order="ORDER BY A.NAMA ASC")
	{
		$str = "
				SELECT 
					KAPAL_SERTIFIKAT_AWAK_KAPAL_ID, A.SERTIFIKAT_AWAK_KAPAL_ID, C.JUMLAH, A.NAMA
				FROM PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL C ON A.SERTIFIKAT_AWAK_KAPAL_ID=C.SERTIFIKAT_AWAK_KAPAL_ID AND C.KAPAL_ID = '".$kapal_id."'
				WHERE KAPAL_SERTIFIKAT_AWAK_KAPAL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsEdit($paramsArray=array(),$limit=-1,$from=-1, $statement="", $kapal_id='', $order="ORDER BY A.NAMA ASC")
	{
		$str = "
				SELECT 
					KAPAL_SERTIFIKAT_AWAK_KAPAL_ID, A.SERTIFIKAT_AWAK_KAPAL_ID, C.JUMLAH, A.NAMA
				FROM PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL C ON A.SERTIFIKAT_AWAK_KAPAL_ID=C.SERTIFIKAT_AWAK_KAPAL_ID AND C.KAPAL_ID = '".$kapal_id."'
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
					KAPAL_SERTIFIKAT_AWAK_KAPAL_ID, KAPAL_ID, SERTIFIKAT_AWAK_KAPAL_ID
					FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL A WHERE KAPAL_SERTIFIKAT_AWAK_KAPAL_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
	function getCountByParamsInsert($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.KAPAL_JENIS_ID) AS ROWCOUNT 
				FROM PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL A
				LEFT JOIN PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL B ON A.SERTIFIKAT_AWAK_KAPAL_ID=B.SERTIFIKAT_AWAK_KAPAL_ID
				WHERE 1=1 ".$statement; 
		
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
	
	function getCountByParamsSertifikatAwakKpl($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_SERTIFIKAT_AWAK_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL
		        WHERE KAPAL_SERTIFIKAT_AWAK_KAPAL_ID IS NOT NULL ".$statement; 
		
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
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_SERTIFIKAT_AWAK_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL
		        WHERE KAPAL_SERTIFIKAT_AWAK_KAPAL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_SERTIFIKAT_AWAK_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_AWAK_KAPAL
		        WHERE KAPAL_SERTIFIKAT_AWAK_KAPAL_ID IS NOT NULL ".$statement; 
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