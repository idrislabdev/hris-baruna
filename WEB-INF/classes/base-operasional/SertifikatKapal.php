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

  class SertifikatKapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SertifikatKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SERTIFIKAT_KAPAL_ID", $this->getNextId("SERTIFIKAT_KAPAL_ID","PPI_OPERASIONAL.SERTIFIKAT_KAPAL"));

		$str = "
					INSERT INTO PPI_OPERASIONAL.SERTIFIKAT_KAPAL (
					   SERTIFIKAT_KAPAL_ID, NAMA, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE)  
 			  	VALUES (
				  ".$this->getField("SERTIFIKAT_KAPAL_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.SERTIFIKAT_KAPAL
				SET    
					   NAMA         	= '".$this->getField("NAMA")."',
					   KETERANGAN	 	= '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  SERTIFIKAT_KAPAL_ID  = '".$this->getField("SERTIFIKAT_KAPAL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL
                WHERE 
                  SERTIFIKAT_KAPAL_ID = ".$this->getField("SERTIFIKAT_KAPAL_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA ASC")
	{
		$str = "
					SELECT 
					SERTIFIKAT_KAPAL_ID, NAMA, KETERANGAN
					FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL A WHERE SERTIFIKAT_KAPAL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsEdit($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqKapalJenisId="")
	{
		$str = "
				SELECT 
				KAPAL_JENIS_SERTIFIKAT_KPL_ID, B.KAPAL_JENIS_ID, A.SERTIFIKAT_KAPAL_ID, A.NAMA
				FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS_SERTIFIKAT_KPL B ON A.SERTIFIKAT_KAPAL_ID=B.SERTIFIKAT_KAPAL_ID AND B.KAPAL_JENIS_ID='".$reqKapalJenisId."'
				WHERE 1=1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.NAMA ASC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLookup($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqKapalJenisId="")
	{
		$str = "
				SELECT 
				KAPAL_JENIS_SERTIFIKAT_KPL_ID, B.KAPAL_JENIS_ID, A.SERTIFIKAT_KAPAL_ID, A.NAMA
				FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS_SERTIFIKAT_KPL B ON A.SERTIFIKAT_KAPAL_ID=B.SERTIFIKAT_KAPAL_ID AND B.KAPAL_JENIS_ID='".$reqKapalJenisId."'
				WHERE 1=1
				"; 
		//KAPAL_JENIS_SERTIFIKAT_KPL_ID IS NOT NULL
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.NAMA ASC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
					SELECT 
					SERTIFIKAT_KAPAL_ID, NAMA, KETERANGAN
					FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL A WHERE SERTIFIKAT_KAPAL_ID IS NOT NULL
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
		$str = "SELECT COUNT(SERTIFIKAT_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL
		        WHERE SERTIFIKAT_KAPAL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(SERTIFIKAT_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.SERTIFIKAT_KAPAL
		        WHERE SERTIFIKAT_KAPAL_ID IS NOT NULL ".$statement; 
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