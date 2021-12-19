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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_PENDIDIKAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiPendidikan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiPendidikan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_PENDIDIKAN_ID", $this->getNextId("PEGAWAI_PENDIDIKAN_ID","PPI_SIMPEG.PEGAWAI_PENDIDIKAN"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_PENDIDIKAN (
				   PEGAWAI_PENDIDIKAN_ID, PENDIDIKAN_ID, PEGAWAI_ID, NAMA, KOTA, LULUS, 
				   TANGGAL_IJASAH, NO_IJASAH, TTD_IJASAH,
				   TANGGAL_ACC, NO_ACC, UNIVERSITAS_ID, PENDIDIKAN_BIAYA_ID, LAST_CREATE_USER, LAST_CREATE_DATE
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_PENDIDIKAN_ID").",
				  '".$this->getField("PENDIDIKAN_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("NAMA")."',
				  '".$this->getField("KOTA")."',
				  '".$this->getField("LULUS")."',
				  ".$this->getField("TANGGAL_IJASAH").",
				  '".$this->getField("NO_IJASAH")."',
				  '".$this->getField("TTD_IJASAH")."',
				  ".$this->getField("TANGGAL_ACC").",
				  '".$this->getField("NO_ACC")."',
				  '".$this->getField("UNIVERSITAS_ID")."',
				  '".$this->getField("PENDIDIKAN_BIAYA_ID")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("PEGAWAI_PENDIDIKAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_PENDIDIKAN
				SET    
					   PENDIDIKAN_ID           	= '".$this->getField("PENDIDIKAN_ID")."',
					   PEGAWAI_ID      			= '".$this->getField("PEGAWAI_ID")."',
					   NAMA    					= '".$this->getField("NAMA")."',
					   KOTA         			= '".$this->getField("KOTA")."',
					   LULUS					= '".$this->getField("LULUS")."',
					   TANGGAL_IJASAH			= ".$this->getField("TANGGAL_IJASAH").",
					   NO_IJASAH				= '".$this->getField("NO_IJASAH")."',
					   TTD_IJASAH				= '".$this->getField("TTD_IJASAH")."',
					   TANGGAL_ACC				= ".$this->getField("TANGGAL_ACC").",
					   NO_ACC					= '".$this->getField("NO_ACC")."',
					   UNIVERSITAS_ID			= '".$this->getField("UNIVERSITAS_ID")."',
					   PENDIDIKAN_BIAYA_ID		= '".$this->getField("PENDIDIKAN_BIAYA_ID")."',
					   LAST_UPDATE_USER			= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE			= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_PENDIDIKAN_ID    = '".$this->getField("PEGAWAI_PENDIDIKAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_PENDIDIKAN
                WHERE 
                  PEGAWAI_PENDIDIKAN_ID = ".$this->getField("PEGAWAI_PENDIDIKAN_ID").""; 
				  
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
					PEGAWAI_PENDIDIKAN_ID, A.PENDIDIKAN_ID, PEGAWAI_ID, A.NAMA, KOTA, LULUS,
					TANGGAL_IJASAH, NO_IJASAH, TTD_IJASAH, TANGGAL_ACC, NO_ACC, A.UNIVERSITAS_ID, A.PENDIDIKAN_BIAYA_ID,
					B.NAMA PENDIDIKAN_NAMA, C.NAMA UNIVERSITAS_NAMA, D.NAMA PENDIDIKAN_BIAYA_NAMA
				FROM PPI_SIMPEG.PEGAWAI_PENDIDIKAN A
				LEFT JOIN PPI_SIMPEG.PENDIDIKAN B ON A.PENDIDIKAN_ID=B.PENDIDIKAN_ID
				LEFT JOIN PPI_SIMPEG.UNIVERSITAS C ON A.UNIVERSITAS_ID=C.UNIVERSITAS_ID
				LEFT JOIN PPI_SIMPEG.PENDIDIKAN_BIAYA D ON A.PENDIDIKAN_BIAYA_ID=D.PENDIDIKAN_BIAYA_ID
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TANGGAL_IJASAH DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_PENDIDIKAN_ID, PENDIDIKAN_ID, PEGAWAI_ID, NAMA, KOTA, LULUS,
				TANGGAL_IJASAH, NO_IJASAH, TTD_IJASAH, TANGGAL_ACC, NO_ACC, UNIVERSITAS_ID, PENDIDIKAN_BIAYA_ID
				FROM PPI_SIMPEG.PEGAWAI_PENDIDIKAN
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PENDIDIKAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_PENDIDIKAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_PENDIDIKAN
		        WHERE PEGAWAI_PENDIDIKAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_PENDIDIKAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_PENDIDIKAN
		        WHERE PEGAWAI_PENDIDIKAN_ID IS NOT NULL ".$statement; 
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