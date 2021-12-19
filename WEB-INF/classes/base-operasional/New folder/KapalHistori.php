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

  class KapalHistori extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalHistori()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_HISTORI_ID", $this->getNextId("KAPAL_HISTORI_ID","PPI_OPERASIONAL.KAPAL_HISTORI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_HISTORI (
				   KAPAL_HISTORI_ID, KAPAL_ID, KONTRAK_SBPP_ID, 
				   TANGGAL_MASUK, TANGGAL_KELUAR) 
 			  	VALUES (
				  ".$this->getField("KAPAL_HISTORI_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("KONTRAK_SBPP_ID")."',
				  ".$this->getField("TANGGAL_MASUK").",
				  ".$this->getField("TANGGAL_KELUAR")."
				)"; 
		$this->id = $this->getField("KAPAL_HISTORI_ID");
		$this->query = $str;
		
		return $this->execQuery($str);
    }
	
	function insertHistori()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_HISTORI_ID", $this->getNextId("KAPAL_HISTORI_ID","PPI_OPERASIONAL.KAPAL_HISTORI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_HISTORI (
				   KAPAL_HISTORI_ID, KAPAL_ID, KONTRAK_SBPP_ID, 
				   TANGGAL_MASUK, TANGGAL_KELUAR, KONTRAK_ID, HISTORI_ID, HISTORI_PARENT_ID, KAPAL_ID_GANTI) 
 			  	VALUES (
				  ".$this->getField("KAPAL_HISTORI_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("KONTRAK_SBPP_ID")."',
				  ".$this->getField("TANGGAL_MASUK").",
				  ".$this->getField("TANGGAL_KELUAR").",
				  '".$this->getField("KONTRAK_ID")."',
				  PPI_OPERASIONAL.HISTORI_ID_GENERATE('".$this->getField("HISTORI_PARENT_ID")."', '".$this->getField("KONTRAK_ID")."'),
				  '".$this->getField("HISTORI_PARENT_ID")."',
				  '".$this->getField("KAPAL_ID_GANTI")."'
				)"; 
		$this->id = $this->getField("KAPAL_HISTORI_ID");
		$this->query = $str;
		
		return $this->execQuery($str);
    }
	
	function insertKapalPenugasan()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_HISTORI_ID", $this->getNextId("KAPAL_HISTORI_ID","PPI_OPERASIONAL.KAPAL_HISTORI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_HISTORI (
				   KAPAL_HISTORI_ID, KAPAL_ID, PENUGASAN_ID, 
				   TANGGAL_MASUK, TANGGAL_KELUAR) 
 			  	VALUES (
				  ".$this->getField("KAPAL_HISTORI_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("PENUGASAN_ID")."',
				  ".$this->getField("TANGGAL_MASUK").",
				  ".$this->getField("TANGGAL_KELUAR")."
				)"; 
		$this->id = $this->getField("KAPAL_HISTORI_ID");
		$this->query = $str;
		
		return $this->execQuery($str);
    }
	
	function insertKapalTowing()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_HISTORI_ID", $this->getNextId("KAPAL_HISTORI_ID","PPI_OPERASIONAL.KAPAL_HISTORI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_HISTORI (
				   KAPAL_HISTORI_ID, KAPAL_ID, KONTRAK_TOWING_ID, 
				   TANGGAL_MASUK, TANGGAL_KELUAR) 
 			  	VALUES (
				  ".$this->getField("KAPAL_HISTORI_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("KONTRAK_TOWING_ID")."',
				  ".$this->getField("TANGGAL_MASUK").",
				  ".$this->getField("TANGGAL_KELUAR")."
				)"; 
		$this->id = $this->getField("KAPAL_HISTORI_ID");
		$this->query = $str;
		
		return $this->execQuery($str);
    }
	
	function insertKapalPekerjaan()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_HISTORI_ID", $this->getNextId("KAPAL_HISTORI_ID","PPI_OPERASIONAL.KAPAL_HISTORI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_HISTORI (
				   KAPAL_HISTORI_ID, KAPAL_ID, KAPAL_PEKERJAAN_ID, 
				   TANGGAL_MASUK, TANGGAL_KELUAR) 
 			  	VALUES (
				  ".$this->getField("KAPAL_HISTORI_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("KAPAL_PEKERJAAN_ID")."',
				  ".$this->getField("TANGGAL_MASUK").",
				  ".$this->getField("TANGGAL_KELUAR")."
				)"; 
		$this->id = $this->getField("KAPAL_HISTORI_ID");
		$this->query = $str;
		
		return $this->execQuery($str);
    }
	
	function insertKapalPekerjaanSewa()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_HISTORI_ID", $this->getNextId("KAPAL_HISTORI_ID","PPI_OPERASIONAL.KAPAL_HISTORI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_HISTORI (
				   KAPAL_HISTORI_ID, KAPAL_ID, KAPAL_PEKERJAAN_SEWA_ID, 
				   TANGGAL_MASUK, TANGGAL_KELUAR) 
 			  	VALUES (
				  ".$this->getField("KAPAL_HISTORI_ID").",
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("KAPAL_PEKERJAAN_SEWA_ID")."',
				  ".$this->getField("TANGGAL_MASUK").",
				  ".$this->getField("TANGGAL_KELUAR")."
				)"; 
		$this->id = $this->getField("KAPAL_HISTORI_ID");
		$this->query = $str;
		
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_HISTORI
				SET    
					   TANGGAL_MASUK	 	= ".$this->getField("TANGGAL_MASUK").",
					   TANGGAL_KELUAR		= ".$this->getField("TANGGAL_KELUAR")."
				WHERE  KAPAL_HISTORI_ID  = '".$this->getField("KAPAL_HISTORI_ID")."'

			 "; 
		//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateRevisi()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_HISTORI
				SET    
					   TANGGAL_MASUK	 	= ".$this->getField("TANGGAL_MASUK").",
					   TANGGAL_KELUAR		= ".$this->getField("TANGGAL_KELUAR").",
					   KAPAL_ID				= '".$this->getField("KAPAL_ID")."'
				WHERE  KAPAL_HISTORI_ID  = '".$this->getField("KAPAL_HISTORI_ID")."'

			 "; 
		//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateTanggalMasukKontrakSbpp()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL
				SET    
					   TEMP_TANGGAL_AWAL		= ".$this->getField("TEMP_TANGGAL_AWAL")."
				WHERE  KONTRAK_SBPP_KAPAL_ID  = '".$this->getField("KONTRAK_SBPP_KAPAL_ID")."'
			 "; 
		//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateTanggalKeluarKontrakSbpp()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL
				SET    
					   TEMP_TANGGAL_AKHIR		= ".$this->getField("TEMP_TANGGAL_AKHIR")."
				WHERE  KONTRAK_SBPP_KAPAL_ID  = '".$this->getField("KONTRAK_SBPP_KAPAL_ID")."'
			 "; 
		//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateTanggalMasuk()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_HISTORI
				SET    
					   TANGGAL_MASUK		= ".$this->getField("TANGGAL_MASUK")."
				WHERE  KAPAL_HISTORI_ID  = '".$this->getField("KAPAL_HISTORI_ID")."'

			 "; 
		//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateTanggalKeluar()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_HISTORI
				SET    
					   TANGGAL_KELUAR		= ".$this->getField("TANGGAL_KELUAR")."
				WHERE  KAPAL_HISTORI_ID  = '".$this->getField("KAPAL_HISTORI_ID")."'

			 "; 
		//echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_HISTORI
                WHERE 
                 KONTRAK_SBPP_ID = ".$this->getField("KONTRAK_SBPP_ID")." AND NOT KAPAL_HISTORI_ID IN (".$this->getField("KAPAL_HISTORI_ID_NOT_IN").")"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteKontrakSbpp()
	{
        $str = "
				 UPDATE PPI_OPERASIONAL.KAPAL_HISTORI SET STATUS = 0
				 WHERE  KONTRAK_SBPP_ID	= '".$this->getField("KONTRAK_SBPP_ID")."' AND KAPAL_ID = '".$this->getField("KAPAL_ID")."' AND STATUS = 1
				"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteKapalPekerjaan()
	{
        $str = " UPDATE PPI_OPERASIONAL.KAPAL_HISTORI SET STATUS = 0
				 WHERE  KAPAL_PEKERJAAN_ID	= '".$this->getField("KAPAL_PEKERJAAN_ID")."' AND KAPAL_ID = '".$this->getField("KAPAL_ID")."' AND STATUS = 1
				"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteKontrakTowing()
	{
        $str = " UPDATE PPI_OPERASIONAL.KAPAL_HISTORI SET STATUS = 0
				 WHERE  KONTRAK_TOWING_ID	= '".$this->getField("KONTRAK_TOWING_ID")."' AND KAPAL_ID = '".$this->getField("KAPAL_ID")."' AND STATUS = 1
				"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deletePenugasan()
	{
        $str = " UPDATE PPI_OPERASIONAL.KAPAL_HISTORI SET STATUS = 0
				 WHERE  PENUGASAN_ID	= '".$this->getField("PENUGASAN_ID")."' AND KAPAL_ID = '".$this->getField("KAPAL_ID")."' AND STATUS = 1
				"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_HISTORI_ID ASC")
	{
		$str = "
				  SELECT 
				  KAPAL_HISTORI_ID, KAPAL_ID, KONTRAK_SBPP_ID, 
					 TANGGAL_MASUK, TANGGAL_KELUAR
				  FROM PPI_OPERASIONAL.KAPAL_HISTORI				  
				  WHERE KAPAL_HISTORI_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsHistori($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_HISTORI_ID ASC")
	{
		$str = "
				  SELECT 
					KAPAL_HISTORI_ID, A.KAPAL_ID, A.KONTRAK_SBPP_ID, B.NAMA KONTRAK_SBPP_NAMA, C.NAMA LOKASI_NAMA, D.KODE, D.NAMA KAPAL_NAMA,
					   A.TANGGAL_MASUK, TANGGAL_KELUAR
					FROM PPI_OPERASIONAL.KAPAL_HISTORI A
				  LEFT JOIN PPI_OPERASIONAL.KONTRAK_SBPP B ON A.KONTRAK_SBPP_ID = B.KONTRAK_SBPP_ID
				  LEFT JOIN PPI_OPERASIONAL.LOKASI C ON C.LOKASI_ID = B.LOKASI_ID
				  LEFT JOIN PPI_OPERASIONAL.KAPAL D ON A.KAPAL_ID=D.KAPAL_ID
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
				  KAPAL_HISTORI_ID, KAPAL_ID, KONTRAK_SBPP_ID, 
					 TANGGAL_MASUK, TANGGAL_KELUAR
				  FROM PPI_OPERASIONAL.KAPAL_HISTORI				  
				  WHERE KAPAL_HISTORI_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_HISTORI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_HISTORI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_HISTORI
		        WHERE KAPAL_HISTORI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_HISTORI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_HISTORI
		        WHERE KAPAL_HISTORI_ID IS NOT NULL ".$statement; 
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