<? 
/* *******************************************************************************************************
MODUL NAME 			: PEL
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel PANGKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class AnggaranTgjawab extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AnggaranTgjawab()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ANGGARAN_TGJAWAB_ID", $this->getNextId("ANGGARAN_TGJAWAB_ID","PEL_ANGGARAN.ANGGARAN_TGJAWAB"));
		$str = "INSERT INTO PEL_ANGGARAN.ANGGARAN_TGJAWAB (
				   ANGGARAN_TGJAWAB_ID, ANGGARAN_MUTASI_ID,  
				   TANGGAL, NOMOR, NAMA, 
				   JUMLAH) 
				VALUES (".$this->getField("ANGGARAN_TGJAWAB_ID").",
						'".$this->getField("ANGGARAN_MUTASI_ID")."',
				   		".$this->getField("TANGGAL").",
						'".$this->getField("NOMOR")."',
						'".$this->getField("NAMA")."',
				   		'".$this->getField("JUMLAH")."'
						)"; 
		$this->id = $this->getField("ANGGARAN_TGJAWAB_ID");
		$this->query = $str;
		
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
			UPDATE PEL_ANGGARAN.ANGGARAN_TGJAWAB
			SET    
				   ANGGARAN_MUTASI_ID              = '".$this->getField("ANGGARAN_MUTASI_ID")."',
				   TANGGAL              = ".$this->getField("TANGGAL").",
				   NOMOR                = '".$this->getField("NOMOR")."',
				   NAMA                 = '".$this->getField("NAMA")."',
				   JUMLAH               = '".$this->getField("JUMLAH")."'
			WHERE  ANGGARAN_TGJAWAB_ID = '".$this->getField("ANGGARAN_TGJAWAB_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }
	
	function updateFormat()
	{
		$str = "
				UPDATE SPPD.ANGGARAN_TGJAWAB
				SET    
					  FILE_TIPE=".$this->getField("FILE_TIPE").",
				  	  FILE_UKURAN=".$this->getField("FILE_UKURAN")."
				WHERE  ANGGARAN_TGJAWAB_ID = '".$this->getField("ANGGARAN_TGJAWAB_ID")."'
			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN_TGJAWAB
                WHERE 
                  ANGGARAN_TGJAWAB_ID = ".$this->getField("ANGGARAN_TGJAWAB_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function selectByParamsBlob($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
			SELECT 
				ANGGARAN_TGJAWAB_ID, NOMOR, FILE_TIPE, FILE_UKURAN, FILE_GAMBAR
			FROM PEL_ANGGARAN.ANGGARAN_TGJAWAB
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
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
		$str = "SELECT 
					ANGGARAN_TGJAWAB_ID, ANGGARAN_MUTASI_ID,  
					   TANGGAL, NOMOR, NAMA, 
					   JUMLAH
					FROM PEL_ANGGARAN.ANGGARAN_TGJAWAB
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		echo $str;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "SELECT 
					ANGGARAN_TGJAWAB_ID, ANGGARAN_MUTASI_ID,  
					   TANGGAL, NOMOR, NAMA, 
					   JUMLAH, FILE_GAMBAR, FILE_TIPE, 
					   FILE_UKURAN
					FROM PEL_ANGGARAN.ANGGARAN_TGJAWAB
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ANGGARAN_TGJAWAB_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_TGJAWAB

		        WHERE 1 = 1 ".$statement; 
		
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
		$str = "SELECT COUNT(ANGGARAN_TGJAWAB_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_TGJAWAB

		        WHERE 1 = 1 ".$statement; 
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