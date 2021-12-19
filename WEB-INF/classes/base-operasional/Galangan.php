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

  class Galangan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Galangan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("GALANGAN_ID", $this->getNextId("GALANGAN_ID","PPI_OPERASIONAL.GALANGAN"));

		$str = "
				INSERT INTO PPI_GALANGAN.GALANGAN (
				   GALANGAN_ID, LOKASI_ID, KODE, NAMA, LENGTH_OVER_PONTON, LENGTH_OVER_ALL, 
				   BREADTH_INTERNAL, BREADTH_EXTERNAL, DEPTH_UPPER_DECK, 
				   DEPTH_SAFETY_DECK, DRAFT_MAX_VESSEL, DRAFT_MAX_DOCK, CAPACITY, LAST_CREATE_USER, LAST_CREATE_DATE)  
 			  	VALUES (
				  ".$this->getField("GALANGAN_ID").",
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("KODE")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("LENGTH_OVER_PONTON")."',
				  '".$this->getField("LENGTH_OVER_ALL")."',
				  '".$this->getField("BREADTH_INTERNAL")."',
				  '".$this->getField("BREADTH_EXTERNAL")."',
				  '".$this->getField("DEPTH_UPPER_DECK")."',
				  '".$this->getField("DEPTH_SAFETY_DECK")."',
				  '".$this->getField("DRAFT_MAX_VESSEL")."',
				  '".$this->getField("DRAFT_MAX_DOCK")."',
				  '".$this->getField("CAPACITY")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id=$this->getField("GALANGAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }

    function update()
	{
		$str = "
				UPDATE PPI_GALANGAN.GALANGAN
				SET    
					   LOKASI_ID         	= '".$this->getField("LOKASI_ID")."',
					   KODE         		= '".$this->getField("KODE")."',
					   NAMA         		= '".$this->getField("NAMA")."',
					   LENGTH_OVER_PONTON   = '".$this->getField("LENGTH_OVER_PONTON")."',
					   LENGTH_OVER_ALL      = '".$this->getField("LENGTH_OVER_ALL")."',
					   BREADTH_INTERNAL     = '".$this->getField("BREADTH_INTERNAL")."',
					   BREADTH_EXTERNAL     = '".$this->getField("BREADTH_EXTERNAL")."',
					   DEPTH_UPPER_DECK     = '".$this->getField("DEPTH_UPPER_DECK")."',
					   DEPTH_SAFETY_DECK    = '".$this->getField("DRAFT_MAX_VESSEL")."',
					   DRAFT_MAX_VESSEL     = '".$this->getField("DRAFT_MAX_VESSEL")."',
					   DRAFT_MAX_DOCK       = '".$this->getField("DRAFT_MAX_DOCK")."',
					   CAPACITY	 			= '".$this->getField("CAPACITY")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  GALANGAN_ID  		= '".$this->getField("GALANGAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GALANGAN.GALANGAN
                WHERE 
                  GALANGAN_ID = ".$this->getField("GALANGAN_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function callHitungInsentifGalangan()
	{
        $str = "
				CALL PPI_GAJI.PROSES_HITUNG_INSENTIF_KHUSUS()
		"; 
				  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA ASC")
	{
		$str = "
                SELECT 
                   GALANGAN_ID, A.LOKASI_ID, KODE, A.NAMA, LENGTH_OVER_PONTON, LENGTH_OVER_ALL, 
                   BREADTH_INTERNAL, BREADTH_EXTERNAL, DEPTH_UPPER_DECK, 
                   DEPTH_SAFETY_DECK, DRAFT_MAX_VESSEL, DRAFT_MAX_DOCK, CAPACITY, FOTO, B.NAMA LOKASI
                FROM PPI_GALANGAN.GALANGAN A INNER JOIN PPI_OPERASIONAL.LOKASI B 
                ON A.LOKASI_ID = B.LOKASI_ID                     
                WHERE GALANGAN_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsInsetifGalangan($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
					SELECT 
					A.PEGAWAI_ID, B.NAMA, PERIODE, PROSENTASE_POTONGAN_PPH, 
					   PENDAPATAN_GALANGAN, JUMLAH_INSENTIF, JUMLAH_POTONGAN_PPH, 
					   JUMLAH_DITERIMA, PROSENTASE_INSENTIF, JABATAN, 
					   GALANGAN, JABATAN_GALANGAN_ID, POTONGAN_KEHADIRAN
					FROM PPI_GAJI.INSENTIF_KHUSUS A INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY JABATAN_GALANGAN_ID ASC";
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsGalanganPendapatan($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
			SELECT B.NAMA, JUMLAH 
			FROM PPI_GALANGAN.GALANGAN_PENDAPATAN A INNER JOIN PPI_GALANGAN.GALANGAN B ON A.GALANGAN_ID = B.GALANGAN_ID
			WHERE 1 = 1					
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY NAMA ASC";
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
    
	    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
				SELECT 
				   GALANGAN_ID, LOKASI_ID, KODE, NAMA, LENGTH_OVER_PONTON, LENGTH_OVER_ALL, 
				   BREADTH_INTERNAL, BREADTH_EXTERNAL, DEPTH_UPPER_DECK, 
				   DEPTH_SAFETY_DECK, DRAFT_MAX_VESSEL, DRAFT_MAX_DOCK, CAPACITY, FOTO
				FROM PPI_GALANGAN.GALANGAN					
				WHERE GALANGAN_ID IS NOT NULL

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

	function getFotoByParams($id="")
	{
		$str = "SELECT FOTO AS ROWCOUNT FROM PPI_GALANGAN.GALANGAN
		        WHERE GALANGAN_ID IS NOT NULL AND GALANGAN_ID = ".$id; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	
	


    function getCountByParamsInsentifGalangan($paramsArray=array(), $statement="")
	{
		$str = "
					SELECT 
					COUNT(A.PEGAWAI_ID) ROWCOUNT
					FROM PPI_GAJI.INSENTIF_KHUSUS A INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID WHERE 1 = 1
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

					
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(GALANGAN_ID) AS ROWCOUNT FROM PPI_GALANGAN.GALANGAN
		        WHERE GALANGAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(GALANGAN_ID) AS ROWCOUNT FROM PPI_GALANGAN.GALANGAN
		        WHERE GALANGAN_ID IS NOT NULL ".$statement; 
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