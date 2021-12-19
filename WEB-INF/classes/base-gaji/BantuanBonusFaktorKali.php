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

  class BantuanBonusFaktorKali extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function BantuanBonusFaktorKali()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BANTUAN_BONUS_FAKTOR_KALI_ID", $this->getNextId("BANTUAN_BONUS_FAKTOR_KALI_ID","PPI_GAJI.BANTUAN_BONUS_FAKTOR_KALI")); 
		$str = "
				INSERT INTO PPI_GAJI.BANTUAN_BONUS_FAKTOR_KALI (
					   BANTUAN_BONUS_FAKTOR_KALI_ID, JENIS_PEGAWAI_ID, JUMLAH, 
					   TAHUN) 
				VALUES ( ".$this->getField("BANTUAN_BONUS_FAKTOR_KALI_ID").",
					  '".$this->getField("JENIS_PEGAWAI_ID")."',
					  '".$this->getField("JUMLAH")."',
					  '".$this->getField("TAHUN")."'
				)"; 
		$this->id = $this->getField("BANTUAN_BONUS_FAKTOR_KALI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.BANTUAN_BONUS_FAKTOR_KALI
			   SET 		   		
					  JENIS_PEGAWAI_ID = '".$this->getField("JENIS_PEGAWAI_ID")."',
					  JUMLAH = '".$this->getField("JUMLAH")."',
					  TAHUN = '".$this->getField("TAHUN")."'
			   WHERE BANTUAN_BONUS_FAKTOR_KALI_ID = ".$this->getField("BANTUAN_BONUS_FAKTOR_KALI_ID")."
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "
				DELETE FROM PPI_GAJI.BANTUAN_BONUS_FAKTOR_KALI
                WHERE 
                  TAHUN = ".$this->getField("TAHUN")."
			"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    } 
	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT JENIS_PEGAWAI_ID, NAMA, 
					(SELECT JUMLAH FROM PPI_GAJI.BANTUAN_BONUS_FAKTOR_KALI X WHERE X.JENIS_PEGAWAI_ID = A.JENIS_PEGAWAI_ID AND TAHUN = '".$periode."') JUMLAH,
					(SELECT BANTUAN_BONUS_FAKTOR_KALI_ID FROM PPI_GAJI.BANTUAN_BONUS_FAKTOR_KALI X WHERE X.JENIS_PEGAWAI_ID = A.JENIS_PEGAWAI_ID AND TAHUN = '".$periode."') BANTUAN_BONUS_FAKTOR_KALI_ID
				FROM PPI_SIMPEG.JENIS_PEGAWAI A
				WHERE 1=1
			   "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode='', $order="")
	{
		$str = "
				SELECT TAHUN  FROM PPI_GAJI.BANTUAN_BONUS_FAKTOR_KALI
				WHERE 1=1
			   "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."GROUP BY TAHUN".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT JENIS_PEGAWAI_ID, NAMA, 
					(SELECT JUMLAH FROM PPI_GAJI.BANTUAN_BONUS_FAKTOR_KALI X WHERE X.JENIS_PEGAWAI_ID = A.JENIS_PEGAWAI_ID AND TAHUN = '".$periode."') JUMLAH 
				FROM PPI_SIMPEG.JENIS_PEGAWAI A
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY PEGAWAI_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }

    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="", $periode='')
	{
		$str = "SELECT COUNT(A.JENIS_PEGAWAI_ID) AS ROWCOUNT
				FROM PPI_GAJI.BANTUAN_BONUS_FAKTOR_KALI ".$statement; 
				
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
	function getCountByParamsMonitoring($paramsArray=array(), $statement="", $periode='')
	{
		$str = "
				SELECT COUNT(1) AS ROWCOUNT
                FROM
                (
				SELECT COUNT(TAHUN) 
                FROM PPI_GAJI.BANTUAN_BONUS_FAKTOR_KALI A
                WHERE 1=1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str.= " 
				GROUP BY TAHUN
				)
		";
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI A WHERE 1 = 1 "; 
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