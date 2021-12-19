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

  class PegawaiSertifikatAwakKpl extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiSertifikatAwakKpl()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_SERTIFIKAT_AWAK_KPL_ID", $this->getNextId("PEGAWAI_SERTIFIKAT_AWAK_KPL_ID","PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL (
				   PEGAWAI_SERTIFIKAT_AWAK_KPL_ID, PEGAWAI_ID, SERTIFIKAT_AWAK_KAPAL_ID, 
				   TANGGAL_TERBIT, TANGGAL_KADALUARSA, LAST_CREATE_USER, LAST_CREATE_DATE, LOKASI_TERBIT)  
 			  	VALUES (
				  ".$this->getField("PEGAWAI_SERTIFIKAT_AWAK_KPL_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("SERTIFIKAT_AWAK_KAPAL_ID")."',
				  ".$this->getField("TANGGAL_TERBIT").",
				  ".$this->getField("TANGGAL_KADALUARSA").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("LOKASI_TERBIT")."'
				)"; 
		$this->id = $this->getField("PEGAWAI_SERTIFIKAT_AWAK_KPL_ID");
		//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL
				SET    
					   PEGAWAI_ID       		= '".$this->getField("PEGAWAI_ID")."',
					   SERTIFIKAT_AWAK_KAPAL_ID	= '".$this->getField("SERTIFIKAT_AWAK_KAPAL_ID")."',
					   TANGGAL_TERBIT			= ".$this->getField("TANGGAL_TERBIT").",
					   TANGGAL_KADALUARSA		= ".$this->getField("TANGGAL_KADALUARSA").",
					   LOKASI_TERBIT			= '".$this->getField("LOKASI_TERBIT")."'
				WHERE  PEGAWAI_SERTIFIKAT_AWAK_KPL_ID = '".$this->getField("PEGAWAI_SERTIFIKAT_AWAK_KPL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL
                WHERE 
                  PEGAWAI_ID = ".$this->getField("PEGAWAI_ID").""; 
				  
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
	
	function selectByParamsSertifikatAwakKapalKadaluarsa($paramsArray=array(),$limit=-1,$from=-1, $batas_notifikasi="", $statement="", $order="ORDER BY A.NAMA ASC")
	{
		$str = "
				SELECT 
				A.NAMA NAMA_PEGAWAI, B.TANGGAL_TERBIT, B.TANGGAL_KADALUARSA, B.SERTIFIKAT_AWAK_KAPAL_ID, C.NAMA NAMA_SERTIFIKAT,
				SYSDATE TGL_SKARANG, (B.TANGGAL_KADALUARSA - INTERVAL '".$batas_notifikasi."' DAY) BATAS,
				CASE 
					WHEN (B.TANGGAL_KADALUARSA - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND B.TANGGAL_KADALUARSA > SYSDATE THEN 1
					WHEN B.TANGGAL_KADALUARSA <= SYSDATE THEN 2
					ELSE 0
				END STATUS,
                CASE 
					WHEN (B.TANGGAL_KADALUARSA - INTERVAL '".$batas_notifikasi."' DAY) < SYSDATE AND B.TANGGAL_KADALUARSA > SYSDATE THEN 'Masa Berlaku Hampir Habis'
					WHEN B.TANGGAL_KADALUARSA <= SYSDATE THEN 'Masa Berlaku Habis'
					ELSE 'Aktif'
                END STATUS_INFO
				FROM PPI_SIMPEG.PEGAWAI A
				INNER JOIN PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL B ON B.PEGAWAI_ID = A.PEGAWAI_ID AND B.TANGGAL_TERBIT IS NOT NULL AND B.TANGGAL_KADALUARSA IS NOT NULL
				INNER JOIN PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL C ON B.SERTIFIKAT_AWAK_KAPAL_ID = C.SERTIFIKAT_AWAK_KAPAL_ID
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
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY PEGAWAI_SERTIFIKAT_AWAK_KPL_ID ASC")
	{
		$str = "
				SELECT PEGAWAI_SERTIFIKAT_AWAK_KPL_ID, PEGAWAI_ID, SERTIFIKAT_AWAK_KAPAL_ID, TANGGAL_TERBIT, TANGGAL_KADALUARSA
				FROM PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL
				WHERE PEGAWAI_SERTIFIKAT_AWAK_KPL_ID IS NOT NULL
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
				SELECT PEGAWAI_SERTIFIKAT_AWAK_KPL_ID, PEGAWAI_ID, SERTIFIKAT_AWAK_KAPAL_ID, TANGGAL_TERBIT, TANGGAL_KADALUARSA
				FROM PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL
				WHERE PEGAWAI_SERTIFIKAT_AWAK_KPL_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PEGAWAI_SERTIFIKAT_AWAK_KPL_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
	function getCountByParamsSertifikatAwakKapalKadaluarsa($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT 
				FROM PPI_SIMPEG.PEGAWAI A
				INNER JOIN PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL B ON B.PEGAWAI_ID = A.PEGAWAI_ID AND B.TANGGAL_TERBIT IS NOT NULL AND B.TANGGAL_KADALUARSA IS NOT NULL
				INNER JOIN PPI_OPERASIONAL.SERTIFIKAT_AWAK_KAPAL C ON B.SERTIFIKAT_AWAK_KAPAL_ID = C.SERTIFIKAT_AWAK_KAPAL_ID
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
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_SERTIFIKAT_AWAK_KPL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL
		        WHERE PEGAWAI_SERTIFIKAT_AWAK_KPL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_SERTIFIKAT_AWAK_KPL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL
		        WHERE PEGAWAI_SERTIFIKAT_AWAK_KPL_ID IS NOT NULL ".$statement; 
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