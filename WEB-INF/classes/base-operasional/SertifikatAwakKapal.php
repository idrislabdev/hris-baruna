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

  class SertifikatAwakKapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SertifikatAwakKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SERTIFIKAT_AWAK_KAPAL_ID", $this->getNextId("SERTIFIKAT_AWAK_KAPAL_ID","PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL"));

		$str = "
					INSERT INTO PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL (
					   SERTIFIKAT_AWAK_KAPAL_ID, NAMA, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE)  
 			  	VALUES (
				  ".$this->getField("SERTIFIKAT_AWAK_KAPAL_ID").",
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
				UPDATE PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL
				SET    
					   NAMA         	= '".$this->getField("NAMA")."',
					   KETERANGAN	 	= '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  SERTIFIKAT_AWAK_KAPAL_ID  = '".$this->getField("SERTIFIKAT_AWAK_KAPAL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL
                WHERE 
                  SERTIFIKAT_AWAK_KAPAL_ID = ".$this->getField("SERTIFIKAT_AWAK_KAPAL_ID").""; 
				  
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
					SERTIFIKAT_AWAK_KAPAL_ID, NAMA, KETERANGAN
					FROM PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL A WHERE SERTIFIKAT_AWAK_KAPAL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsSertifikatPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqId="")
	{
		$str = "
				SELECT 
				A.SERTIFIKAT_AWAK_KAPAL_ID, NAMA, KETERANGAN, B.SERTIFIKAT_AWAK_KAPAL_ID SERTIFIKAT_AWAK_KAPAL_ID_PEG, TANGGAL_TERBIT, TANGGAL_KADALUARSA, B.PEGAWAI_ID, B.LOKASI_TERBIT
				FROM 
				PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL A LEFT JOIN PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL B 
				ON A.SERTIFIKAT_AWAK_KAPAL_ID = B.SERTIFIKAT_AWAK_KAPAL_ID
				AND B.PEGAWAI_ID = '".$reqId."'
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.SERTIFIKAT_AWAK_KAPAL_ID ASC";
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
    
	function selectByParamsEdit($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqKapalJenisId="")
	{
		$str = "
				SELECT 
				KAPAL_JENIS_SERT_AWAK_KPL_ID, B.KAPAL_JENIS_ID, A.SERTIFIKAT_AWAK_KAPAL_ID, JUMLAH, A.NAMA
				FROM PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL B ON A.SERTIFIKAT_AWAK_KAPAL_ID=B.SERTIFIKAT_AWAK_KAPAL_ID AND B.KAPAL_JENIS_ID='".$reqKapalJenisId."'
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
				KAPAL_JENIS_SERT_AWAK_KPL_ID, B.KAPAL_JENIS_ID, A.SERTIFIKAT_AWAK_KAPAL_ID, JUMLAH, A.NAMA
				FROM PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL B ON A.SERTIFIKAT_AWAK_KAPAL_ID=B.SERTIFIKAT_AWAK_KAPAL_ID AND B.KAPAL_JENIS_ID='".$reqKapalJenisId."'
				WHERE 1=1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//KAPAL_JENIS_SERT_AWAK_KPL_ID IS NOT NULL
		$str .= $statement." ORDER BY A.NAMA ASC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
					SELECT 
					SERTIFIKAT_AWAK_KAPAL_ID, NAMA, KETERANGAN
					FROM PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL A WHERE SERTIFIKAT_AWAK_KAPAL_ID IS NOT NULL
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
	
	function getCountByParamsSertifikatPegawai($paramsArray=array(), $statement="", $reqId="")
	{
		$str = "SELECT COUNT(B.SERTIFIKAT_AWAK_KAPAL_ID) AS ROWCOUNT 
				FROM 
				PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL A LEFT JOIN PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL B 
				ON A.SERTIFIKAT_AWAK_KAPAL_ID = B.SERTIFIKAT_AWAK_KAPAL_ID
				AND B.PEGAWAI_ID = '".$reqId."' ".$statement; 
		
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
		$str = "SELECT COUNT(SERTIFIKAT_AWAK_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL
		        WHERE SERTIFIKAT_AWAK_KAPAL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(SERTIFIKAT_AWAK_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL
		        WHERE SERTIFIKAT_AWAK_KAPAL_ID IS NOT NULL ".$statement; 
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