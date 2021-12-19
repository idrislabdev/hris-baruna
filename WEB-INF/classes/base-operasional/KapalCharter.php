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

  class KapalCharter extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalCharter()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_CHARTER_ID", $this->getNextId("KAPAL_CHARTER_ID","PPI_OPERASIONAL.KAPAL_CHARTER"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_CHARTER (
				   KAPAL_CHARTER_ID, KAPAL_JENIS_ID, KAPAL_KEPEMILIKAN_ID, 
				   KODE, CALL_SIGN, IMO_NUMBER, 
				   NAMA, PERUSAHAAN_BANGUN, TEMPAT_BANGUN, 
				   TAHUN_BANGUN, GT, NT, 
				   LOA, BREADTH, DEPTH, 
				   DRAFT, MESIN_INDUK, MESIN_BANTU, 
				   MESIN_DAYA, MESIN_RPM, POMPA, 
				   ISI_TANGKI, AIR_BERSIH, KECEPATAN, 
				   STATUS_KESIAPAN, BENDERA, JUMLAH_KRU, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("KAPAL_CHARTER_ID").",
				  '".$this->getField("KAPAL_JENIS_ID")."',
				  '".$this->getField("KAPAL_KEPEMILIKAN_ID")."',
				  '".$this->getField("KODE")."',
				  '".$this->getField("CALL_SIGN")."',
				  '".$this->getField("IMO_NUMBER")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("PERUSAHAAN_BANGUN")."',
				  '".$this->getField("TEMPAT_BANGUN")."',
				  '".$this->getField("TAHUN_BANGUN")."',
				  '".$this->getField("GT")."',
				  '".$this->getField("NT")."',
				  '".$this->getField("LOA")."',
				  '".$this->getField("BREADTH")."',
				  '".$this->getField("DEPTH")."',
				  '".$this->getField("DRAFT")."',
				  '".$this->getField("MESIN_INDUK")."',
				  '".$this->getField("MESIN_BANTU")."',
				  '".$this->getField("MESIN_DAYA")."',
				  '".$this->getField("MESIN_RPM")."',
				  '".$this->getField("POMPA")."',
				  '".$this->getField("ISI_TANGKI")."',
				  '".$this->getField("AIR_BERSIH")."',
				  '".$this->getField("KECEPATAN")."',
				  '".$this->getField("STATUS_KESIAPAN")."',
				  '".$this->getField("BENDERA")."',
				  '".$this->getField("JUMLAH_KRU")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("KAPAL_CHARTER_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_CHARTER
				SET    
					   KAPAL_JENIS_ID       = '".$this->getField("KAPAL_JENIS_ID")."',
					   KAPAL_KEPEMILIKAN_ID	= '".$this->getField("KAPAL_KEPEMILIKAN_ID")."',
					   KODE	 				= '".$this->getField("KODE")."',
					   CALL_SIGN	 		= '".$this->getField("CALL_SIGN")."',
					   IMO_NUMBER	 		= '".$this->getField("IMO_NUMBER")."',
					   NAMA	 				= '".$this->getField("NAMA")."',
					   PERUSAHAAN_BANGUN	= '".$this->getField("PERUSAHAAN_BANGUN")."',
					   TEMPAT_BANGUN	 	= '".$this->getField("TEMPAT_BANGUN")."',
					   TAHUN_BANGUN	 		= '".$this->getField("TAHUN_BANGUN")."',
					   GT	 				= '".$this->getField("GT")."',
					   NT	 				= '".$this->getField("NT")."',
					   LOA	 				= '".$this->getField("LOA")."',
					   BREADTH	 			= '".$this->getField("BREADTH")."',
					   DEPTH	 			= '".$this->getField("DEPTH")."',
					   DRAFT	 			= '".$this->getField("DRAFT")."',
					   MESIN_INDUK	 		= '".$this->getField("MESIN_INDUK")."',
					   MESIN_BANTU	 		= '".$this->getField("MESIN_BANTU")."',
					   MESIN_DAYA	 		= '".$this->getField("MESIN_DAYA")."',
					   MESIN_RPM	 		= '".$this->getField("MESIN_RPM")."',
					   POMPA	 			= '".$this->getField("POMPA")."',
					   ISI_TANGKI	 		= '".$this->getField("ISI_TANGKI")."',
					   AIR_BERSIH	 		= '".$this->getField("AIR_BERSIH")."',
					   KECEPATAN	 		= '".$this->getField("KECEPATAN")."',
					   STATUS_KESIAPAN	 	= '".$this->getField("STATUS_KESIAPAN")."',
					   BENDERA	 			= '".$this->getField("BENDERA")."',
					   JUMLAH_KRU 			= '".$this->getField("JUMLAH_KRU")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  KAPAL_CHARTER_ID  			= '".$this->getField("KAPAL_CHARTER_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_CHARTER
                WHERE 
                  KAPAL_CHARTER_ID = ".$this->getField("KAPAL_CHARTER_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callHitungPremi()
	{
        $str = "
				CALL PPI_GAJI.PROSES_HITUNG_PREMI()
		"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.KAPAL_CHARTER_ID ASC")
	{
		$str = "
                SELECT 
                A.KAPAL_CHARTER_ID, A.KAPAL_JENIS_ID, KAPAL_KEPEMILIKAN_ID, KODE, CALL_SIGN, IMO_NUMBER, 
                   A.NAMA, PERUSAHAAN_BANGUN, TEMPAT_BANGUN, TAHUN_BANGUN, GT, NT, 
                   LOA, BREADTH, DEPTH, DRAFT, MESIN_INDUK, MESIN_BANTU, 
                   MESIN_DAYA, MESIN_RPM, POMPA, ISI_TANGKI, AIR_BERSIH, KECEPATAN, 
                   FOTO, STATUS_KESIAPAN, BENDERA, B.NAMA KAPAL_JENIS_NAMA, JUMLAH_KRU
                FROM PPI_OPERASIONAL.KAPAL_CHARTER A 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS B ON B.KAPAL_JENIS_ID=A.KAPAL_JENIS_ID             
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
    
	function selectByParamsSertifikatKapalKadaluarsa($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.NAMA ASC")
	{
		$str = "
				SELECT 
				A.NAMA NAMA_KAPAL, B.TANGGAL_TERBIT, B.TANGGAL_KADALUARSA, B.SERTIFIKAT_KAPAL_CHARTER_ID, C.NAMA NAMA_SERTIFIKAT,
				SYSDATE TGL_SKARANG, (B.TANGGAL_KADALUARSA - INTERVAL '15' DAY) BATAS,
				CASE 
					WHEN (B.TANGGAL_KADALUARSA - INTERVAL '15' DAY) < SYSDATE AND B.TANGGAL_KADALUARSA > SYSDATE THEN 1
					WHEN B.TANGGAL_KADALUARSA <= SYSDATE THEN 2
					ELSE 0
				END STATUS
				FROM PPI_OPERASIONAL.KAPAL_CHARTER A
				INNER JOIN PPI_OPERASIONAL.KAPAL_CHARTER_SERTIFIKAT_KAPAL B ON B.KAPAL_CHARTER_ID = A.KAPAL_CHARTER_ID AND B.TANGGAL_TERBIT IS NOT NULL AND B.TANGGAL_KADALUARSA IS NOT NULL
				INNER JOIN PPI_OPERASIONAL.SERTIFIKAT_KAPAL C ON B.SERTIFIKAT_KAPAL_CHARTER_ID = C.SERTIFIKAT_KAPAL_CHARTER_ID
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
				KAPAL_CHARTER_ID, KAPAL_JENIS_ID, KAPAL_KEPEMILIKAN_ID, KODE, CALL_SIGN, IMO_NUMBER, 
				   NAMA, PERUSAHAAN_BANGUN, TEMPAT_BANGUN, TAHUN_BANGUN, GT, NT, 
				   LOA, BREADTH, DEPTH, DRAFT, MESIN_INDUK, MESIN_BANTU, 
				   MESIN_DAYA, MESIN_RPM, POMPA, ISI_TANGKI, AIR_BERSIH, KECEPATAN, 
				   FOTO, STATUS_KESIAPAN, BENDERA, JUMLAH_KRU
				FROM PPI_OPERASIONAL.KAPAL_CHARTER A 
				WHERE KAPAL_CHARTER_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_CHARTER_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
	function getFotoByParams($id="")
	{
		$str = "SELECT FOTO AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_CHARTER
		        WHERE KAPAL_CHARTER_ID IS NOT NULL AND KAPAL_CHARTER_ID = ".$id; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_CHARTER_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_CHARTER
		        WHERE KAPAL_CHARTER_ID IS NOT NULL ".$statement; 
		
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
	
	function getCountByParamsSertifikatKapalKadaluarsa($paramsArray=array(), $statement="")
	{
		$str = "
				SELECT 
				COUNT(A.KAPAL_CHARTER_ID) AS ROWCOUNT
				FROM PPI_OPERASIONAL.KAPAL_CHARTER A
				INNER JOIN PPI_OPERASIONAL.KAPAL_CHARTER_SERTIFIKAT_KAPAL B ON B.KAPAL_CHARTER_ID = A.KAPAL_CHARTER_ID AND B.TANGGAL_TERBIT IS NOT NULL AND B.TANGGAL_KADALUARSA IS NOT NULL
				INNER JOIN PPI_OPERASIONAL.SERTIFIKAT_KAPAL C ON B.SERTIFIKAT_KAPAL_CHARTER_ID = C.SERTIFIKAT_KAPAL_CHARTER_ID
				WHERE 1=1 
				".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_CHARTER_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_CHARTER
		        WHERE KAPAL_CHARTER_ID IS NOT NULL ".$statement; 
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