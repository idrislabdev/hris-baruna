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

  class PphParameter extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PphParameter()
	{
      $this->Entity(); 
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.PPH_PARAMETER
			   SET 
			   		PROSENTASE_NPWP			= '".$this->getField("PROSENTASE_NPWP")."',
				   	PROSENTASE_TANPA_NPWP	= '".$this->getField("PROSENTASE_TANPA_NPWP")."',
					JUMLAH_NPWP				= ROUND(".$this->getField("JUMLAH_NPWP").",3),
					JUMLAH_TANPA_NPWP		= ROUND(".$this->getField("JUMLAH_TANPA_NPWP").",3)
			 WHERE JENIS_PEGAWAI_ID = '".$this->getField("JENIS_PEGAWAI_ID")."' AND JENIS_PENGHASILAN = '".$this->getField("JENIS_PENGHASILAN")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "
				DELETE FROM PPI_GAJI.PPH_PARAMETER
                WHERE 
				JENIS_PEGAWAI_ID = ".$this->getField("JENIS_PEGAWAI_ID")." AND JENIS_PENGHASILAN = ".$this->getField("JENIS_PENGHASILAN")."
				  "; 
				  
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
				SELECT 
				A.JENIS_PEGAWAI_ID JENIS_PEGAWAI_ID, JENIS_PENGHASILAN, PROSENTASE_NPWP, 
				   PROSENTASE_TANPA_NPWP, JUMLAH_NPWP, JUMLAH_TANPA_NPWP, B.NAMA JENIS_PEGAWAI
				FROM PPI_GAJI.PPH_PARAMETER	A
                LEFT JOIN PPI_SIMPEG.JENIS_PEGAWAI B ON A.JENIS_PEGAWAI_ID = B.JENIS_PEGAWAI_ID	
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
				SELECT 
				JENIS_PEGAWAI_ID, JENIS_PENGHASILAN, PROSENTASE_NPWP, 
				   PROSENTASE_TANPA_NPWP, JUMLAH_NPWP, JUMLAH_TANPA_NPWP
				FROM PPI_GAJI.PPH_PARAMETER		
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY JENIS_PEGAWAI_ID, JENIS_PENGHASILAN ASC";
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
		$str = "SELECT COUNT(JENIS_PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.PPH_PARAMETER WHERE 1 = 1 ".$statement; 
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
		$str = "SELECT COUNT(JENIS_PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.PPH_PARAMETER WHERE 1 = 1 "; 
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