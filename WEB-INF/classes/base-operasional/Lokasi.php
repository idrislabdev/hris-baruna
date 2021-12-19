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

  class Lokasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Lokasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("LOKASI_ID", $this->getNextId("LOKASI_ID","PPI_OPERASIONAL.LOKASI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.LOKASI (
				   LOKASI_ID, LOKASI_PARENT_ID, NAMA, 
				   KETERANGAN, LATITUDE, LONGITUDE, 
				   LEBAR_ALUR, KEDALAMAN_ALUR, LEBAR_KOLAM,
				   KEDALAMAN_KOLAM, KECEPATAN_ARUS, TIPE_KOLAM, BEAUFORT_ID, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  PPI_OPERASIONAL.LOKASI_ID_GENERATE('".$this->getField("LOKASI_ID")."'),
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("LATITUDE")."',
				  '".$this->getField("LONGITUDE")."',
				  '".$this->getField("LEBAR_ALUR")."',
				  '".$this->getField("KEDALAMAN_ALUR")."',
				  '".$this->getField("LEBAR_KOLAM")."',
				  '".$this->getField("KEDALAMAN_KOLAM")."',
				  '".$this->getField("KECEPATAN_ARUS")."',
				  '".$this->getField("TIPE_KOLAM")."',
				  '".$this->getField("BEAUFORT_ID")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.LOKASI
				SET    
					   NAMA         	= '".$this->getField("NAMA")."',
					   KETERANGAN		= '".$this->getField("KETERANGAN")."',
					   LATITUDE         = '".$this->getField("LATITUDE")."',
					   LONGITUDE        = '".$this->getField("LONGITUDE")."',
					   LEBAR_ALUR       = '".$this->getField("LEBAR_ALUR")."',
					   KEDALAMAN_ALUR   = '".$this->getField("KEDALAMAN_ALUR")."',
					   LEBAR_KOLAM      = '".$this->getField("LEBAR_KOLAM")."',
					   KEDALAMAN_KOLAM  = '".$this->getField("KEDALAMAN_KOLAM")."',
					   KECEPATAN_ARUS   = '".$this->getField("KECEPATAN_ARUS")."',
					   TIPE_KOLAM		= '".$this->getField("TIPE_KOLAM")."',
					   BEAUFORT_ID		= '".$this->getField("BEAUFORT_ID")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  LOKASI_ID  		= '".$this->getField("LOKASI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateBatasMaks()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.LOKASI
				SET    
					   BATAS_MAKS       = '".$this->getField("BATAS_MAKS")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  LOKASI_ID  		= '".$this->getField("LOKASI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.LOKASI
                WHERE 
                  LOKASI_ID = ".$this->getField("LOKASI_ID").""; 
				  
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
	
	function selectByParamsRealisasiLokasiKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY B.LOKASI_ID DESC")
	{
		$str = "
			SELECT CASE WHEN B.LOKASI_ID IS NULL THEN 'Belum Ditentukan' ELSE C.NAMA END LOKASI_TERAKHIR, A.KAPAL_ID, A.KODE, A.NAMA KAPAL,  
				   D.NAMA JENIS_KAPAL, CASE WHEN A.HORSE_POWER_ID IS NULL THEN MESIN_DAYA ELSE MESIN_DAYA || ' x ' || E.NAMA END HP
			FROM PPI_OPERASIONAL.KAPAL A
			LEFT JOIN PPI_OPERASIONAL.KAPAL_LOKASI_TERAKHIR B ON A.KAPAL_ID = B.KAPAL_ID
			LEFT JOIN PPI_OPERASIONAL.LOKASI C ON B.LOKASI_ID = C.LOKASI_ID
			LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS D ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
			LEFT JOIN PPI_OPERASIONAL.HORSE_POWER E ON A.HORSE_POWER_ID = E.HORSE_POWER_ID
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY LOKASI_ID ASC")
	{
		$str = "
				SELECT 
				LOKASI_ID, LOKASI_PARENT_ID, NAMA, KETERANGAN, LATITUDE, LONGITUDE, BATAS_MAKS,
				LEBAR_ALUR, KEDALAMAN_ALUR, LEBAR_KOLAM, KEDALAMAN_KOLAM, KECEPATAN_ARUS,
				CASE 
				WHEN TIPE_KOLAM = 'D' THEN 'Dalam Kolam'
				WHEN TIPE_KOLAM = 'L' THEN 'Luar Kolam'
				ELSE ''
				END TIPE_KOLAM_NAMA, TIPE_KOLAM, A.BEAUFORT_ID, B.BEAUFORT_NUMBER BEAUFORT_NAMA
				FROM PPI_OPERASIONAL.LOKASI A
				LEFT JOIN PPI_OPERASIONAL.BEAUFORT B ON A.BEAUFORT_ID = B.BEAUFORT_ID
				WHERE LOKASI_ID IS NOT NULL
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
				LOKASI_ID, LOKASI_PARENT_ID, NAMA, KETERANGAN, LATITUDE, LONGITUDE, 
				LEBAR_ALUR, KEDALAMAN_ALUR, LEBAR_KOLAM, KEDALAMAN_KOLAM, KECEPATAN_ARUS
				FROM PPI_OPERASIONAL.LOKASI A					
				WHERE LOKASI_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY LOKASI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	function getCountByParamsRealisasiLokasiKapal($paramsArray=array(), $statement="")
	{
		$str = "
		SELECT COUNT(A.KAPAL_ID) AS ROWCOUNT 
		FROM PPI_OPERASIONAL.KAPAL A
		WHERE A.KAPAL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(LOKASI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.LOKASI
		        WHERE LOKASI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(LOKASI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.LOKASI
		        WHERE LOKASI_ID IS NOT NULL ".$statement; 
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