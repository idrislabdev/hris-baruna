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
  * Entity-base class untuk mengimplementasikan tabel AGAMA.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class WorkOrder extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function WorkOrder()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("WORK_ORDER_ID", $this->getNextId("WORK_ORDER_ID","PPI_SIMPEG.WORK_ORDER")); 		
		$str = "
				INSERT INTO PPI_SIMPEG.WORK_ORDER (
				   WORK_ORDER_ID, PEGAWAI_ID_PENGIRIM, PEGAWAI_ID_PENERIMA, 
				   NAMA, KETERANGAN, TANGGAL, 
				   TANGGAL_PEKERJAAN, STATUS_PEKERJAAN) 
 			  	VALUES (
				  ".$this->getField("WORK_ORDER_ID").",
				  '".$this->getField("PEGAWAI_ID_PENGIRIM")."',
				  '".$this->getField("PEGAWAI_ID_PENERIMA")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KETERANGAN")."',
				  ".$this->getField("TANGGAL").",
				  ".$this->getField("TANGGAL_PEKERJAAN").",
				  '".$this->getField("STATUS_PEKERJAAN")."'
				)"; 
		$this->id = $this->getField("WORK_ORDER_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.WORK_ORDER
				SET    
					   PEGAWAI_ID_PENGIRIM	= '".$this->getField("PEGAWAI_ID_PENGIRIM")."',
					   PEGAWAI_ID_PENERIMA	= '".$this->getField("PEGAWAI_ID_PENERIMA")."',
					   NAMA					= '".$this->getField("NAMA")."',
					   KETERANGAN			= '".$this->getField("KETERANGAN")."',
					   TANGGAL				= ".$this->getField("TANGGAL").",
					   TANGGAL_PEKERJAAN	= ".$this->getField("TANGGAL_PEKERJAAN").",
					   STATUS_PEKERJAAN		= '".$this->getField("STATUS_PEKERJAAN")."'
				WHERE  WORK_ORDER_ID     	= '".$this->getField("WORK_ORDER_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.WORK_ORDER
                WHERE 
                  WORK_ORDER_ID = ".$this->getField("WORK_ORDER_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				WORK_ORDER_ID, 
                (SELECT NAMA FROM PPI_SIMPEG.PEGAWAI B WHERE B.PEGAWAI_ID = A.PEGAWAI_ID_PENGIRIM) NAMA_PENGIRIM,PEGAWAI_ID_PENGIRIM PEGAWAI_ID_PENGIRIM, 
                (SELECT NAMA FROM PPI_SIMPEG.PEGAWAI B WHERE B.PEGAWAI_ID = A.PEGAWAI_ID_PENERIMA) NAMA_PENERIMA, PEGAWAI_ID_PENERIMA, 
				   NAMA, KETERANGAN, TANGGAL, 
				   TANGGAL_PEKERJAAN, STATUS_PEKERJAAN
                FROM PPI_SIMPEG.WORK_ORDER A       
                WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY WORK_ORDER_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				WORK_ORDER_ID, PEGAWAI_ID_PENGIRIM, PEGAWAI_ID_PENERIMA, 
				   NAMA, KETERANGAN, TANGGAL, 
				   TANGGAL_PEKERJAAN, STATUS_PEKERJAAN
				FROM PPI_SIMPEG.WORK_ORDER		
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY WORK_ORDER_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(WORK_ORDER_ID) AS ROWCOUNT FROM PPI_SIMPEG.WORK_ORDER
		        WHERE WORK_ORDER_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(WORK_ORDER_ID) AS ROWCOUNT FROM PPI_SIMPEG.WORK_ORDER
		        WHERE WORK_ORDER_ID IS NOT NULL ".$statement; 
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