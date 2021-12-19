<? 
/* *******************************************************************************************************
MODUL NAME 			: IMASYS
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * EntitySIUK-base class untuk mengimplementasikan tabel PERPAJAKAN.NO_FAKTUR_PAJAK.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class NoFakturPajak extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function NoFakturPajak()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("NO_FAKTUR_PAJAK_ID", $this->getNextId("NO_FAKTUR_PAJAK_ID","PERPAJAKAN.NO_FAKTUR_PAJAK")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO PERPAJAKAN.NO_FAKTUR_PAJAK (
					   NO_FAKTUR_PAJAK_ID,NOMOR_SURAT, TANGGAL,  
					   NOMOR_FAKTUR_AWAL, NOMOR_FAKTUR_AKHIR, 
					   LAST_CREATED_DATE, LAST_CREATED_BY, FILE_UPLOAD, FILE_UKURAN, FILE_NAMA, FILE_FORMAT) 
				VALUES ('".$this->getField("NO_FAKTUR_PAJAK_ID")."',  
						'".$this->getField("NOMOR_SURAT")."',
						".$this->getField("TANGGAL").", 
						'".$this->getField("NOMOR_FAKTUR_AWAL")."', 
						'".$this->getField("NOMOR_FAKTUR_AKHIR")."',
						SYSDATE, 
						'".$this->getField("LAST_CREATED_BY")."', 
						'".$this->getField("FILE_UPLOAD")."', 
						'".$this->getField("FILE_UKURAN")."', 
						'".$this->getField("FILE_NAMA")."', 
						'".$this->getField("FILE_FORMAT")."'
				)";
				
		$this->id = $this->getField("NO_FAKTUR_PAJAK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateFileFormat()
	{
		$str = "
				UPDATE PERPAJAKAN.NO_FAKTUR_PAJAK
				SET    
					   FILE_FORMAT     		  = '".$this->getField("FILE_FORMAT")."'
				WHERE  NO_FAKTUR_PAJAK_ID     = ".$this->getField("NO_FAKTUR_PAJAK_ID")."
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE PERPAJAKAN.NO_FAKTUR_PAJAK
				SET    
					   NOMOR_SURAT     		  = '".$this->getField("NOMOR_SURAT")."',
					   TANGGAL     			  = ".$this->getField("TANGGAL").",
					   NOMOR_FAKTUR_AWAL      = '".$this->getField("NOMOR_FAKTUR_AWAL")."',
					   NOMOR_FAKTUR_AKHIR 	  = '".$this->getField("NOMOR_FAKTUR_AKHIR")."',
					   LAST_CREATED_DATE      = SYSDATE,
					   LAST_CREATED_BY  	  = '".$this->getField("LAST_CREATED_BY")."'
				WHERE  NO_FAKTUR_PAJAK_ID     = ".$this->getField("NO_FAKTUR_PAJAK_ID")."
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		echo $str;
		return $this->execQuery($str);
    }

		
	function delete()
	{
        $str = "DELETE FROM PERPAJAKAN.NO_FAKTUR_PAJAK
                WHERE 
                  NO_FAKTUR_PAJAK_ID     = ".$this->getField("NO_FAKTUR_PAJAK_ID")."
				  "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteAll()
	{
		$str = "DELETE FROM PERPAJAKAN.NO_FAKTUR_PAJAK_D
                WHERE 
                  NO_FAKTUR_PAJAK_ID     = ".$this->getField("NO_FAKTUR_PAJAK_ID")."
				  "; 
				  
		$this->execQuery($str);
		 		  
        $str = "DELETE FROM PERPAJAKAN.NO_FAKTUR_PAJAK
                WHERE 
                  NO_FAKTUR_PAJAK_ID     = ".$this->getField("NO_FAKTUR_PAJAK_ID")."
				  "; 				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }
	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT 
				NO_FAKTUR_PAJAK_ID, NOMOR_SURAT, TANGGAL, 
				   NOMOR_FAKTUR_AWAL, NOMOR_FAKTUR_AKHIR, FILE_UPLOAD, 
				   FILE_NAMA, FILE_UKURAN, FILE_FORMAT, 
				   LAST_CREATED_BY, LAST_CREATED_DATE,
				   (SELECT COUNT(1) FROM PERPAJAKAN.NO_FAKTUR_PAJAK_D X WHERE X.NO_FAKTUR_PAJAK_ID = A.NO_FAKTUR_PAJAK_ID AND STATUS = 1) JUMLAH_AKTIF
				FROM PERPAJAKAN.NO_FAKTUR_PAJAK A
				WHERE 1 = 1
				"; 
		//, FOTO
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
				SELECT FILE_FORMAT, FILE_NAMA, FILE_UKURAN, FILE_UPLOAD, LAST_CREATED_BY, LAST_CREATED_DATE, 
					NOMOR_FAKTUR_AKHIR, NOMOR_FAKTUR_AWAL, NOMOR_SURAT, 
					NO_FAKTUR_PAJAK_ID, TANGGAL
					FROM PERPAJAKAN.NO_FAKTUR_PAJAK 
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TANGGAL_AWAL DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(NO_FAKTUR_PAJAK_ID) AS ROWCOUNT FROM PERPAJAKAN.NO_FAKTUR_PAJAK
		        WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getLastFakturPajak($tanggal)
	{
		$str = "SELECT MIN(NOMOR) ROWCOUNT FROM PERPAJAKAN.NO_FAKTUR_PAJAK_D A INNER JOIN PERPAJAKAN.NO_FAKTUR_PAJAK B ON A.NO_FAKTUR_PAJAK_ID = B.NO_FAKTUR_PAJAK_ID 
				WHERE STATUS = '0' "; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return ""; 
    }
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(NO_FAKTUR_PAJAK_ID) AS ROWCOUNT FROM PERPAJAKAN.NO_FAKTUR_PAJAK
		        WHERE NO_FAKTUR_PAJAK_ID IS NOT NULL ".$statement; 
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