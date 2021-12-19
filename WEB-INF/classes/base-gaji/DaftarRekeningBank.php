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

  class DaftarRekeningBank extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Asuransi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ASURANSI_ID", $this->getNextId("ASURANSI_ID","PPI_GAJI.ASURANSI")); 
		$str = "
			INSERT INTO PPI_GAJI.DAFTAR_REKENING (JENIS_REKENING, REF_ID, BANK_ID, NAMA_REKENING, NO_REKENING) 
				VALUES ( '".$this->getField("JENIS_REKENING")."',
					  ".$this->getField("REF_ID").",
					  ".$this->getField("BANK_ID").",
					  '".$this->getField("NAMA_REKENING")."',
					  '".$this->getField("NO_REKENING")."'
				)"; 
		$this->id = $this->getField("ASURANSI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.DAFTAR_REKENING
			   SET 
			   		BANK_ID  				= '".$this->getField("BANK_ID")."',
				   	NAMA_REKENING				= '".$this->getField("NAMA_REKENING")."',
					NO_REKENING				= '".$this->getField("NO_REKENING")."'
			 WHERE JENIS_REKENING = '".$this->getField("JENIS_REKENING")."' AND REF_ID = ".$this->getField("REF_ID"); 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.DAFTAR_REKENING
                WHERE 
                  JENIS_REKENING = '".$this->getField("JENIS_REKENING")."' AND REF_ID = ".$this->getField("REF_ID"); 
				  
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
				SELECT ID, JENIS_REKENING, REF_ID, TIPE, NAMA_BANK, BANK_ID, NO_REKENING, NAMA_REKENING
					   FROM PPI_gaji.V_DAFTAR_REKENING_BANK
					   WHERE 0=0 
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
				SELECT ID, JENIS_REKENING, REF_ID, TIPE, NAMA_REFERENSI, NAMA_BANK,BANK_ID, NO_REKENING, NAMA_REKENING
					   FROM PEL_gaji.V_DAFTAR_REKENING_BANK
					   WHERE 0=0 
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY JENIS_REKENING, NAMA_REFERENSI ";
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
		$str = "select COUNT(*) AS ROWCOUNT
					   FROM PPI_gaji.V_DAFTAR_REKENING_BANK
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(*) AS ROWCOUNT FROM PPI_GAJI.V_DAFTAR_REKENING_BANK WHERE 1 = 1 "; 
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