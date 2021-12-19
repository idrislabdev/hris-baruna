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

  class KapalKontrak extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalKontrak()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KAPAL_KONTRAK_ID", $this->getNextId("KAPAL_KONTRAK_ID","PPI_OPERASIONAL.KAPAL_KONTRAK"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_KONTRAK (
				   KAPAL_KONTRAK_ID, KAPAL_KONTRAK_PARENT_ID, KAPAL_ID, 
				   NAMA, NOMER, NILAI_PER_BULAN, 
				   JENIS_KONTRAK, TANGGAL_AWAL, TANGGAL_AKHIR, 
				   NILAI_TOTAL, TANDA_TANGAN_PENYEWA, TANDA_TANGAN_PEMINJAM, 
				   TANDA_TANGAN_PEJABAT, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE)
 			  	VALUES (
				  PPI_OPERASIONAL.KAPAL_KONTRAK_ID_GENERATE('".$this->getField("KAPAL_KONTRAK_ID")."'),
				  '".$this->getField("KAPAL_KONTRAK_PARENT_ID")."',
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("NOMER")."',
				  '".$this->getField("NILAI_PER_BULAN")."',
				  '".$this->getField("JENIS_KONTRAK")."',
				  ".$this->getField("TANGGAL_AWAL").",
				  ".$this->getField("TANGGAL_AKHIR").",
				  '".$this->getField("NILAI_TOTAL")."',
				  '".$this->getField("TANDA_TANGAN_PENYEWA")."',
				  '".$this->getField("TANDA_TANGAN_PEMINJAM")."',
				  '".$this->getField("TANDA_TANGAN_PEJABAT")."',
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("KAPAL_KONTRAK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_KONTRAK
				SET    
					   NAMA	 					= '".$this->getField("NAMA")."',
					   NOMER	 				= '".$this->getField("NOMER")."',
					   NILAI_PER_BULAN	 		= '".$this->getField("NILAI_PER_BULAN")."',
					   JENIS_KONTRAK	 		= '".$this->getField("JENIS_KONTRAK")."',
					   TANGGAL_AWAL	 			= ".$this->getField("TANGGAL_AWAL").",
					   TANGGAL_AKHIR	 		= ".$this->getField("TANGGAL_AKHIR").",
					   NILAI_TOTAL	 			= '".$this->getField("NILAI_TOTAL")."',
					   TANDA_TANGAN_PENYEWA	 	= '".$this->getField("TANDA_TANGAN_PENYEWA")."',
					   TANDA_TANGAN_PEMINJAM	= '".$this->getField("TANDA_TANGAN_PEMINJAM")."',
					   TANDA_TANGAN_PEJABAT	 	= '".$this->getField("TANDA_TANGAN_PEJABAT")."',
					   KETERANGAN				= '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER			= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE			= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  KAPAL_KONTRAK_ID  		= '".$this->getField("KAPAL_KONTRAK_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_KONTRAK
                WHERE 
                  KAPAL_KONTRAK_ID = ".$this->getField("KAPAL_KONTRAK_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KAPAL_KONTRAK_ID ASC")
	{
		$str = "
				SELECT 
				KAPAL_KONTRAK_ID, KAPAL_KONTRAK_PARENT_ID, KAPAL_ID, 
				   NAMA, NOMER, NILAI_PER_BULAN, 
				   JENIS_KONTRAK, TANGGAL_AWAL, TANGGAL_AKHIR, 
				   NILAI_TOTAL, TANDA_TANGAN_PENYEWA, TANDA_TANGAN_PEMINJAM, 
				   TANDA_TANGAN_PEJABAT, A.KETERANGAN
				FROM PPI_OPERASIONAL.KAPAL_KONTRAK A 
				WHERE KAPAL_KONTRAK_ID IS NOT NULL
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
				KAPAL_KONTRAK_ID, KAPAL_KONTRAK_PARENT_ID, KAPAL_ID, 
				   NAMA, NOMER, NILAI_PER_BULAN, 
				   JENIS_KONTRAK, TANGGAL_AWAL, TANGGAL_AKHIR, 
				   NILAI_TOTAL, TANDA_TANGAN_PENYEWA, TANDA_TANGAN_PEMINJAM, 
				   TANDA_TANGAN_PEJABAT, A.KETERANGAN
				FROM PPI_OPERASIONAL.KAPAL_KONTRAK A 
				WHERE KAPAL_KONTRAK_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KAPAL_KONTRAK_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KAPAL_KONTRAK_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_KONTRAK
		        WHERE KAPAL_KONTRAK_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KAPAL_KONTRAK_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_KONTRAK
		        WHERE KAPAL_KONTRAK_ID IS NOT NULL ".$statement; 
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