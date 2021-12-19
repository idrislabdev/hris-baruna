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

  class Gaji extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Gaji()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("GAJI_ID", $this->getNextId("GAJI_ID","PPI_GAJI.GAJI")); 
		$str = "
				INSERT INTO PPI_GAJI.GAJI (
				   GAJI_ID, BULANTAHUN, KELAS, 
				   PERIODE, MERIT, TPP, 
				   TUNJANGAN_PERBANTUAN, TUNJANGAN_JABATAN, TOTAL) 
				VALUES(
					  ".$this->getField("GAJI_ID").",
					  '".$this->getField("BULANTAHUN")."',
					  '".$this->getField("KELAS")."',
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("MERIT")."',
					  '".$this->getField("TPP")."',
					  '".$this->getField("TUNJANGAN_PERBANTUAN")."',
					  '".$this->getField("TUNJANGAN_JABATAN")."',
					  '".$this->getField("TOTAL")."'
				)"; 
		$this->id = $this->getField("GAJI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.GAJI
			   SET 
			   		BULANTAHUN  			= '".$this->getField("BULANTAHUN")."',
			   		KELAS  					= '".$this->getField("KELAS")."',
				   	PERIODE					= '".$this->getField("PERIODE")."',
				   	MERIT					= '".$this->getField("MERIT")."',
				   	TPP						= '".$this->getField("TPP")."',
				   	TUNJANGAN_PERBANTUAN	= '".$this->getField("TUNJANGAN_PERBANTUAN")."',
					TUNJANGAN_JABATAN		= '".$this->getField("TUNJANGAN_JABATAN")."',
					TOTAL					= '".$this->getField("TOTAL")."'
			 WHERE GAJI_ID = ".$this->getField("GAJI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

    function updateStatusGaji()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.GAJI
			   SET 
					STATUS_BAYAR = 1
			 WHERE PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."' AND  BULANTAHUN = '".$this->getField("BULANTAHUN")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }	
		
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_GAJI.GAJI A SET
				  ".$this->getField("FIELD")." 		= '".$this->getField("FIELD_VALUE")."',
				  ".$this->getField("FIELD_VALIDATOR")." 	= '".$this->getField("FIELD_VALUE_VALIDATOR")."'
				WHERE GAJI_ID = ".$this->getField("GAJI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }	
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.GAJI
                WHERE 
                  GAJI_ID = ".$this->getField("GAJI_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callGaji()
	{
        $str = "
				CALL PPI_GAJI.PROSES_PERHITUNGAN_GAJI('".$this->getField("PERIODE")."', '".$this->getField("DEPARTEMEN_ID")."')
		"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="", $reqBulan="", $reqTahun="")
	{
		$str = "
				SELECT 
				A.PEGAWAI_ID, NAMA, BULANTAHUN, KELAS, 
				   PERIODE, MERIT, TPP, 
				   TUNJANGAN_PERBANTUAN, TUNJANGAN_JABATAN, TOTAL, STATUS_BAYAR
				FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_GAJI.GAJI B ON  A.PEGAWAI_ID = B.PEGAWAI_ID AND BULANTAHUN = '".$reqBulan.$reqTahun."'			
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT 
				GAJI_ID, BULANTAHUN, KELAS, 
				   PERIODE, MERIT, TPP, 
				   TUNJANGAN_PERBANTUAN, TUNJANGAN_JABATAN, TOTAL
				FROM PPI_GAJI.GAJI	
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY GAJI_ID DESC";
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
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI A WHERE 1 = 1 ".$statement; 
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

    function getItemGajiDiberikan($jenis_pegawai, $diberikan)
	{
		$str = " SELECT PPI_GAJI.AMBIL_ITEM_GAJI_JENIS_DIBERI(".$jenis_pegawai.", '".$diberikan."') JSON_ITEM_GAJI_DIBERIKAN FROM DUAL "; 

		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("JSON_ITEM_GAJI_DIBERIKAN"); 
		else 
			return 0; 
    }

    function getItemPotonganDiberikan($jenis_pegawai)
	{
		$str = " SELECT PPI_GAJI.AMBIL_ITEM_POTONGAN_JENIS(".$jenis_pegawai.") JSON_ITEM_POTONGAN FROM DUAL "; 

		$this->select($str); 
		// echo $str->query;exit();
		if($this->firstRow()) 
			return $this->getField("JSON_ITEM_POTONGAN"); 
		else 
			return 0; 
    }

    function getItemSumbanganDiberikan($jenis_pegawai)
	{
		$str = " SELECT PPI_GAJI.AMBIL_ITEM_SUMBANGAN_JENIS(".$jenis_pegawai.") JSON_ITEM_SUMBANGAN FROM DUAL "; 

		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("JSON_ITEM_SUMBANGAN"); 
		else 
			return 0; 
    }

    function getItemTanggunganDiberikan($jenis_pegawai)
	{
		$str = " SELECT PPI_GAJI.AMBIL_ITEM_TANGGUNGAN_JENIS(".$jenis_pegawai.") JSON_ITEM_TANGGUNGAN FROM DUAL "; 

		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("JSON_ITEM_TANGGUNGAN"); 
		else 
			return 0; 
    }


    function getItemPotonganLain()
	{
		$str = " SELECT PPI_GAJI.AMBIL_ITEM_POTONGAN_LAIN JSON_ITEM_POTONGAN_LAIN FROM DUAL "; 

		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("JSON_ITEM_POTONGAN_LAIN"); 
		else 
			return 0; 
    }
	
    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(GAJI_ID) AS ROWCOUNT FROM PPI_GAJI.GAJI WHERE 1 = 1 "; 
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