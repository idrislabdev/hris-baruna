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

  class HariLibur extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function HariLibur()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("HARI_LIBUR_ID", $this->getNextId("HARI_LIBUR_ID","PPI_ABSENSI.HARI_LIBUR")); 
		if($this->getField("TANGGAL_FIX") == "")
		{
			$this->setField("JUMLAH_LIBUR_BULAN_INI", "PPI_ABSENSI.AMBIL_SELISIH_TANPA_WEEKEND(".$this->getField("TANGGAL_AWAL").", ".$this->getField("TANGGAL_AKHIR").", 'BULAN_INI')");
			$this->setField("JUMLAH_LIBUR_BULAN_DEPAN", "PPI_ABSENSI.AMBIL_SELISIH_TANPA_WEEKEND(".$this->getField("TANGGAL_AWAL").", ".$this->getField("TANGGAL_AKHIR").", 'BULAN_DEPAN')");			
		}
		else
		{
			$this->setField("JUMLAH_LIBUR_BULAN_INI", 1);
			$this->setField("JUMLAH_LIBUR_BULAN_DEPAN", 0);						
		}
		$str = "
				INSERT INTO PPI_ABSENSI.HARI_LIBUR (
				   HARI_LIBUR_ID, NAMA, KETERANGAN, 
				   TANGGAL_AWAL, TANGGAL_AKHIR, TANGGAL_FIX, JUMLAH_LIBUR_BULAN_INI, JUMLAH_LIBUR_BULAN_DEPAN, STATUS_CUTI_BERSAMA)
				VALUES(
					  ".$this->getField("HARI_LIBUR_ID").",
					  '".$this->getField("NAMA")."',
					  '".$this->getField("KETERANGAN")."',
					  ".$this->getField("TANGGAL_AWAL").",
					  ".$this->getField("TANGGAL_AKHIR").",
					  '".$this->getField("TANGGAL_FIX")."',
					  ".$this->getField("JUMLAH_LIBUR_BULAN_INI").",
					  ".$this->getField("JUMLAH_LIBUR_BULAN_DEPAN").",
					  '".$this->getField("STATUS_CUTI_BERSAMA")."'
				)"; 
		$this->id = $this->getField("HARI_LIBUR_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		if($this->getField("TANGGAL_FIX") == "")
		{
			$this->setField("JUMLAH_LIBUR_BULAN_INI", "PPI_ABSENSI.AMBIL_SELISIH_TANPA_WEEKEND(".$this->getField("TANGGAL_AWAL").", ".$this->getField("TANGGAL_AKHIR").", 'BULAN_INI')");
			$this->setField("JUMLAH_LIBUR_BULAN_DEPAN", "PPI_ABSENSI.AMBIL_SELISIH_TANPA_WEEKEND(".$this->getField("TANGGAL_AWAL").", ".$this->getField("TANGGAL_AKHIR").", 'BULAN_DEPAN')");			
		}
		else
		{
			$this->setField("JUMLAH_LIBUR_BULAN_INI", 1);
			$this->setField("JUMLAH_LIBUR_BULAN_DEPAN", 0);						
		}		
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PPI_ABSENSI.HARI_LIBUR
			   SET NAMA         	= '".$this->getField("NAMA")."',
				   KETERANGAN		= '".$this->getField("KETERANGAN")."',
				   TANGGAL_AWAL		= ".$this->getField("TANGGAL_AWAL").",
				   TANGGAL_AKHIR	= ".$this->getField("TANGGAL_AKHIR").",
				   TANGGAL_FIX= '".$this->getField("TANGGAL_FIX")."',
				   JUMLAH_LIBUR_BULAN_INI = ".$this->getField("JUMLAH_LIBUR_BULAN_INI").",
				   JUMLAH_LIBUR_BULAN_DEPAN = ".$this->getField("JUMLAH_LIBUR_BULAN_DEPAN").",
				   STATUS_CUTI_BERSAMA = '".$this->getField("STATUS_CUTI_BERSAMA")."'
			 WHERE HARI_LIBUR_ID = ".$this->getField("HARI_LIBUR_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_ABSENSI.HARI_LIBUR
                WHERE 
                  HARI_LIBUR_ID = ".$this->getField("HARI_LIBUR_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
				HARI_LIBUR_ID, NAMA, KETERANGAN, 
				   TANGGAL_AWAL, TANGGAL_AKHIR, TANGGAL_FIX, STATUS_CUTI_BERSAMA
				FROM PPI_ABSENSI.HARI_LIBUR
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
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT 
				HARI_LIBUR_ID, NAMA, KETERANGAN, 
				   TANGGAL_AWAL, TANGGAL_AKHIR, TANGGAL_FIX
				FROM PPI_ABSENSI.HARI_LIBUR
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY HARI_LIBUR_ID DESC";
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
		$str = "SELECT COUNT(HARI_LIBUR_ID) AS ROWCOUNT FROM PPI_ABSENSI.HARI_LIBUR WHERE 1 = 1 ".$statement; 
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

   function getLibur($tanggal_fix, $tanggal_penuh)
	{
		$str = " SELECT 1 ROWCOUNT FROM PPI_ABSENSI.HARI_LIBUR WHERE TANGGAL_FIX = '".$tanggal_fix."' OR TO_DATE('".$tanggal_penuh."', 'DDMMYYYY') BETWEEN TANGGAL_AWAL AND TANGGAL_AKHIR "; 
		$this->select($str); 
		//echo $str;
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(HARI_LIBUR_ID) AS ROWCOUNT FROM PPI_ABSENSI.HARI_LIBUR WHERE 1 = 1 "; 
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