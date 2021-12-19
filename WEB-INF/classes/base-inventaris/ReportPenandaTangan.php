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

  class ReportPenandaTangan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function ReportPenandaTangan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("REPORT_PENANDA_TANGAN_ID", $this->getNextId("REPORT_PENANDA_TANGAN_ID","PPI_ASSET.REPORT_PENANDA_TANGAN")); 

		$str = "
				INSERT INTO PPI_ASSET.REPORT_PENANDA_TANGAN (
				   REPORT_PENANDA_TANGAN_ID, JENIS_REPORT, NAMA_1, JABATAN_1, NAMA_2, JABATAN_2, NAMA_3, JABATAN_3) 
  			 	VALUES (
				  ".$this->getField("REPORT_PENANDA_TANGAN_ID").",
  				  '".$this->getField("JENIS_REPORT")."',
				  '".$this->getField("NAMA_1")."', 	
    			  '".$this->getField("JABATAN_1")."',
      			  '".$this->getField("NAMA_2")."',
				  '".$this->getField("JABATAN_2")."',
      			  '".$this->getField("NAMA_3")."',
				  '".$this->getField("JABATAN_3")."'
				  )"; 	
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_ASSET.REPORT_PENANDA_TANGAN
				SET     
					   JENIS_REPORT= '".$this->getField("JENIS_REPORT")."',
					   NAMA_1= '".$this->getField("NAMA_1")."',
					   JABATAN_1= '".$this->getField("JABATAN_1")."',
					   NAMA_2= '".$this->getField("NAMA_2")."',
					   JABATAN_2= '".$this->getField("JABATAN_2")."',
					   NAMA_3= '".$this->getField("NAMA_3")."',
					   JABATAN_3= '".$this->getField("JABATAN_3")."'
				WHERE  REPORT_PENANDA_TANGAN_ID   = ".$this->getField("REPORT_PENANDA_TANGAN_ID")."
 				"; 

				$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ASSET.REPORT_PENANDA_TANGAN A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE REPORT_PENANDA_TANGAN_ID = ".$this->getField("REPORT_PENANDA_TANGAN_ID")."
				"; 
				$this->query = $str;
	//echo $str;
		return $this->execQuery($str);
    }		
	
	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.REPORT_PENANDA_TANGAN_USER_LOGIN
                WHERE 
                  REPORT_PENANDA_TANGAN_ID = ".$this->getField("REPORT_PENANDA_TANGAN_ID")."
				  "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","TANGGAL"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder='ORDER BY REPORT_PENANDA_TANGAN_ID ASC')
	{
		$str = "
		SELECT 
			A.REPORT_PENANDA_TANGAN_ID, JABATAN_1, NAMA_1, JENIS_REPORT, NAMA_2, JABATAN_2, NAMA_3, JABATAN_3
			FROM PPI_ASSET.REPORT_PENANDA_TANGAN A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT 
		A.REPORT_PENANDA_TANGAN_ID, JABATAN_1, NAMA_1, JENIS_REPORT, NAMA_2
		FROM PPI_ASSET.REPORT_PENANDA_TANGAN A
		WHERE 1=1"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY JABATAN_1 ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","TANGGAL"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(),$stat="")
	{
		$str = "SELECT COUNT(REPORT_PENANDA_TANGAN_ID) AS ROWCOUNT FROM PPI_ASSET.REPORT_PENANDA_TANGAN A WHERE REPORT_PENANDA_TANGAN_ID IS NOT NULL ".$stat; 
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(REPORT_PENANDA_TANGAN_ID) AS ROWCOUNT FROM PPI_ASSET.REPORT_PENANDA_TANGAN A WHERE REPORT_PENANDA_TANGAN_ID IS NOT NULL "; 
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