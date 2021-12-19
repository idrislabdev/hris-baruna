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

  class PotonganOpsiTidakPegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PotonganOpsiTidakPegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("POTONGAN_OPSI_TIDAK_PEGAWAI_ID", $this->getNextId("POTONGAN_OPSI_TIDAK_PEGAWAI_ID","PPI_GAJI.POTONGAN_OPSI_TIDAK_PEGAWAI")); 
		$str = "
				INSERT INTO PPI_GAJI.POTONGAN_OPSI_TIDAK_PEGAWAI (
				   POTONGAN_OPSI_TIDAK_PEGAWAI_ID, POTONGAN_KONDISI_JENIS_PEGAWAI, PEGAWAI_ID) 
				VALUES(
					  ".$this->getField("POTONGAN_OPSI_TIDAK_PEGAWAI_ID").",
					  '".$this->getField("POTONGAN_KONDISI_JENIS_PEGAWAI")."',
					  '".$this->getField("PEGAWAI_ID")."'
				)"; 
		$this->id = $this->getField("PPI_GAJI.POTONGAN_OPSI_TIDAK_PEGAWAI");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.POTONGAN_OPSI_TIDAK_PEGAWAI
			   SET 
			   		POTONGAN_KONDISI_JENIS_PEGAWAI	= '".$this->getField("POTONGAN_KONDISI_JENIS_PEGAWAI")."',
				   	PEGAWAI_ID						= '".$this->getField("PEGAWAI_ID")."'
			 WHERE POTONGAN_OPSI_TIDAK_PEGAWAI_ID 	= ".$this->getField("POTONGAN_OPSI_TIDAK_PEGAWAI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.POTONGAN_OPSI_TIDAK_PEGAWAI
                WHERE 
                  PEGAWAI_ID = ".$this->getField("PEGAWAI_ID").""; 
				  
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
				SELECT POTONGAN_OPSI_TIDAK_PEGAWAI_ID, POTONGAN_KONDISI_JENIS_PEGAWAI, PEGAWAI_ID
				FROM PPI_GAJI.POTONGAN_OPSI_TIDAK_PEGAWAI		
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
				SELECT POTONGAN_OPSI_TIDAK_PEGAWAI_ID, POTONGAN_KONDISI_JENIS_PEGAWAI, PEGAWAI_ID
				FROM PPI_GAJI.POTONGAN_OPSI_TIDAK_PEGAWAI		
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY POTONGAN_OPSI_TIDAK_PEGAWAI_ID DESC";
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
		$str = "SELECT COUNT(POTONGAN_OPSI_TIDAK_PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.POTONGAN_OPSI_TIDAK_PEGAWAI WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(POTONGAN_OPSI_TIDAK_PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.POTONGAN_OPSI_TIDAK_PEGAWAI WHERE 1 = 1 "; 
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