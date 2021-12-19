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

  class TunjanganJabatan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TunjanganJabatan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TUNJANGAN_JABATAN_ID", $this->getNextId("TUNJANGAN_JABATAN_ID","PPI_GAJI.TUNJANGAN_JABATAN")); 
		$str = "
				INSERT INTO PPI_GAJI.TUNJANGAN_JABATAN (TUNJANGAN_JABATAN_ID, KELAS, JUMLAH) 
				VALUES(
					  ".$this->getField("TUNJANGAN_JABATAN_ID").",
					  ".$this->getField("KELAS").",
					  '".$this->getField("JUMLAH")."'
				)"; 
		$this->id = $this->getField("PPI_GAJI.TUNJANGAN_JABATAN");
				// echo $str;exit;
		//exit;
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.TUNJANGAN_JABATAN
			   SET 
			   		KELAS	= '".$this->getField("KELAS")."',
				   	JUMLAH	= '".$this->getField("JUMLAH")."'
			 WHERE TUNJANGAN_JABATAN_ID = ".$this->getField("TUNJANGAN_JABATAN_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.TUNJANGAN_JABATAN
                WHERE 
                  TUNJANGAN_JABATAN_ID = ".$this->getField("TUNJANGAN_JABATAN_ID").""; 
				  
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
			    SELECT TUNJANGAN_JABATAN_ID, A.KELAS, JUMLAH, A.JENIS_PEGAWAI_ID
                	FROM PPI_GAJI.TUNJANGAN_JABATAN A         
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
			    SELECT TUNJANGAN_JABATAN_ID, A.KELAS, JUMLAH, A.JENIS_PEGAWAI_ID
                	FROM PPI_GAJI.TUNJANGAN_JABATAN A         
                WHERE 1=1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY TUNJANGAN_JABATAN_ID DESC";
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
		$str = "SELECT COUNT(TUNJANGAN_JABATAN_ID) AS ROWCOUNT 
		FROM PPI_GAJI.TUNJANGAN_JABATAN WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(TUNJANGAN_JABATAN_ID) AS ROWCOUNT FROM PPI_GAJI.TUNJANGAN_JABATAN WHERE 1 = 1 "; 
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