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
  * Entity-base class untuk mengimplementasikan tabel KRU_JABATAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class KadetKapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KadetKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KADET_KAPAL_ID", $this->getNextId("KADET_KAPAL_ID","PPI_OPERASIONAL.KADET_KAPAL"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KADET_KAPAL (
				   KADET_KAPAL_ID, PEGAWAI_ID, KAPAL_ID, 
				   TANGGAL_MASUK, TANGGAL_KELUAR, POSISI) 
				VALUES ( ".$this->getField("KADET_KAPAL_ID").", '".$this->getField("PEGAWAI_ID")."', '".$this->getField("KAPAL_ID")."',
					".$this->getField("TANGGAL_MASUK").", ".$this->getField("TANGGAL_KELUAR").", '".$this->getField("POSISI")."'
				)"; 
		$this->id=$this->getField("KADET_KAPAL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KADET_KAPAL
				SET    
					   PEGAWAI_ID     = '".$this->getField("PEGAWAI_ID")."',
					   KAPAL_ID       = '".$this->getField("KAPAL_ID")."',
					   TANGGAL_MASUK  = ".$this->getField("TANGGAL_MASUK").",
					   TANGGAL_KELUAR = ".$this->getField("TANGGAL_KELUAR").",
					   POSISI         = '".$this->getField("POSISI")."'
				WHERE  KADET_KAPAL_ID  	= '".$this->getField("KADET_KAPAL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KADET_KAPAL
                WHERE 
                  KADET_KAPAL_ID = ".$this->getField("KADET_KAPAL_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KADET_KAPAL_ID ASC")
	{
		$str = "
				SELECT 
				A.KADET_KAPAL_ID, A.PEGAWAI_ID, A.KAPAL_ID, 
				A.TANGGAL_MASUK, A.TANGGAL_KELUAR, A.POSISI, B.NAMA AS KAPAL, C.NAMA AS PEGAWAI, C.NIS
				FROM PPI_OPERASIONAL.KADET_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID=A.KAPAL_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI C ON C.PEGAWAI_ID=A.PEGAWAI_ID
				WHERE KADET_KAPAL_ID IS NOT NULL
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
				A.KADET_KAPAL_ID, A.PEGAWAI_ID, A.KAPAL_ID, 
				A.TANGGAL_MASUK, A.TANGGAL_KELUAR, A.POSISI, B.NAMA AS KAPAL, C.NAMA AS PEGAWAI
				FROM PPI_OPERASIONAL.KADET_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID=A.KAPAL_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI C ON C.PEGAWAI_ID=A.PEGAWAI_ID
				WHERE KADET_KAPAL_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KADET_KAPAL_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KADET_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KADET_KAPAL
		        WHERE KADET_KAPAL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KADET_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KADET_KAPAL
		        WHERE KADET_KAPAL_ID IS NOT NULL ".$statement; 
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