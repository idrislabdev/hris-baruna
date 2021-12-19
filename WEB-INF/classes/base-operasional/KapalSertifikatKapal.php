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
  * Entity-base class untuk mengimplementasikan tabel KAPAL_SERTIFIKAT_KAPAL.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KapalSertifikatKapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalSertifikatKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_SERTIFIKAT_KAPAL_ID", $this->getNextId("KAPAL_SERTIFIKAT_KAPAL_ID","PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL"));

		$str = "
					INSERT INTO PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL (
					   KAPAL_SERTIFIKAT_KAPAL_ID, KAPAL_ID, SERTIFIKAT_KAPAL_ID, TANGGAL_TERBIT, TANGGAL_KADALUARSA, GROUP_KAPAL, KETERANGAN, STATUS_PERLU, LAST_CREATE_USER, LAST_CREATE_DATE)
 			  	VALUES (
				  ".$this->getField("KAPAL_SERTIFIKAT_KAPAL_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("SERTIFIKAT_KAPAL_ID")."',
				  ".$this->getField("TANGGAL_TERBIT").",
				  ".$this->getField("TANGGAL_KADALUARSA").",
				  '".$this->getField("GROUP_KAPAL")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("STATUS_PERLU")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id=$this->getField("KAPAL_SERTIFIKAT_KAPAL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL
				SET    
					   KAPAL_ID         	= '".$this->getField("KAPAL_ID")."',
					   SERTIFIKAT_KAPAL_ID	 	= '".$this->getField("SERTIFIKAT_KAPAL_ID")."'
				WHERE  KAPAL_SERTIFIKAT_KAPAL_ID  = '".$this->getField("KAPAL_SERTIFIKAT_KAPAL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL
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
					KAPAL_SERTIFIKAT_KAPAL_ID, KAPAL_ID, SERTIFIKAT_KAPAL_ID
					FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL A WHERE KAPAL_SERTIFIKAT_KAPAL_ID IS NOT NULL
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
					KAPAL_SERTIFIKAT_KAPAL_ID, KAPAL_ID, A.SERTIFIKAT_KAPAL_ID, B.NAMA
					FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL A
					LEFT JOIN PPI_OPERASIONAL.SERTIFIKAT_KAPAL B ON A.SERTIFIKAT_KAPAL_ID = B.SERTIFIKAT_KAPAL_ID
					WHERE KAPAL_SERTIFIKAT_KAPAL_ID IS NOT NULL
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
					KAPAL_JENIS_SERTIFIKAT_KPL_ID, B.KAPAL_JENIS_ID, A.SERTIFIKAT_KAPAL_ID, A.NAMA
				FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS_SERTIFIKAT_KPL B ON A.SERTIFIKAT_KAPAL_ID=B.SERTIFIKAT_KAPAL_ID AND B.KAPAL_JENIS_ID='".$jenis_id."'
				LEFT JOIN PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL C ON A.SERTIFIKAT_KAPAL_ID=C.SERTIFIKAT_KAPAL_ID AND C.KAPAL_ID = '".$kapal_id."'
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
	
	function selectByParamsSertifikatKapalInsert($paramsArray=array(),$limit=-1,$from=-1, $statement="", $jenis_id='', $kapal_id='', $order="ORDER BY A.NAMA ASC")
	{
		$str = "
				SELECT 
					KAPAL_JENIS_SERTIFIKAT_KPL_ID, B.KAPAL_JENIS_ID, A.SERTIFIKAT_KAPAL_ID, A.NAMA, C.GROUP_KAPAL, C.KETERANGAN, C.STATUS_PERLU 
				FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS_SERTIFIKAT_KPL B ON A.SERTIFIKAT_KAPAL_ID=B.SERTIFIKAT_KAPAL_ID AND B.KAPAL_JENIS_ID='".$jenis_id."'
				LEFT JOIN PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL C ON A.SERTIFIKAT_KAPAL_ID=C.SERTIFIKAT_KAPAL_ID AND C.KAPAL_ID = '".$kapal_id."'
				WHERE KAPAL_JENIS_SERTIFIKAT_KPL_ID IS NOT NULL
				"; 
		//
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsSertifikatKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $kapal_id='', $order="ORDER BY A.NAMA ASC")
	{
		$str = "
				SELECT 
					KAPAL_SERTIFIKAT_KAPAL_ID, A.SERTIFIKAT_KAPAL_ID, A.NAMA, C.TANGGAL_TERBIT, C.TANGGAL_KADALUARSA, C.GROUP_KAPAL, C.KETERANGAN, C.STATUS_PERLU 
				FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL C ON A.SERTIFIKAT_KAPAL_ID=C.SERTIFIKAT_KAPAL_ID AND C.KAPAL_ID = '".$kapal_id."'
				WHERE KAPAL_SERTIFIKAT_KAPAL_ID IS NOT NULL
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
					KAPAL_SERTIFIKAT_KAPAL_ID, A.SERTIFIKAT_KAPAL_ID, A.NAMA, C.TANGGAL_TERBIT, C.TANGGAL_KADALUARSA
				FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL C ON A.SERTIFIKAT_KAPAL_ID=C.SERTIFIKAT_KAPAL_ID AND C.KAPAL_ID = '".$kapal_id."'
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
					KAPAL_SERTIFIKAT_KAPAL_ID, KAPAL_ID, SERTIFIKAT_KAPAL_ID
					FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL A WHERE KAPAL_SERTIFIKAT_KAPAL_ID IS NOT NULL
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
				FROM PPI_OPERASIONAL.KAPAL_JENIS_SERTIFIKAT_KPL A
				LEFT JOIN PPI_OPERASIONAL.SERTIFIKAT_KAPAL B ON A.SERTIFIKAT_KAPAL_ID=B.SERTIFIKAT_KAPAL_ID
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
	
	function getCountByParamsSertifikatKapal($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_SERTIFIKAT_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL
		        WHERE KAPAL_SERTIFIKAT_KAPAL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_SERTIFIKAT_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL
		        WHERE KAPAL_SERTIFIKAT_KAPAL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_SERTIFIKAT_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_SERTIFIKAT_KAPAL
		        WHERE KAPAL_SERTIFIKAT_KAPAL_ID IS NOT NULL ".$statement; 
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