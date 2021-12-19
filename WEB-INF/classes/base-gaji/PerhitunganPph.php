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
  * Entity-base class untuk mengimplementasikan tabel PERHITUNGAN_PPH.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PerhitunganPph extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PerhitunganPph()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PERHITUNGAN_PPH_ID", $this->getNextId("PERHITUNGAN_PPH_ID","PPI_GAJI.PERHITUNGAN_PPH")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO PPI_GAJI.PERHITUNGAN_PPH (
				   PERHITUNGAN_PPH_ID, JENIS_PENGHASILAN, KELAS, 
				   JENIS_PEGAWAI_ID, JENIS_PERHITUNGAN, JUMLAH, 
				   PROSENTASE_NPWP, PROSENTASE_TANPA_NPWP, JUMLAH_NPWP, JUMLAH_TANPA_NPWP) 
				VALUES ( ".$this->getField("PERHITUNGAN_PPH_ID").", '".$this->getField("JENIS_PENGHASILAN")."', '".$this->getField("KELAS")."',
					'".$this->getField("JENIS_PEGAWAI_ID")."', '".$this->getField("JENIS_PERHITUNGAN")."', PPI_GAJI.KONVERSI_NAMA_ID_KONDISI(UPPER('".$this->getField("JUMLAH")."')),
					'".$this->getField("PROSENTASE_NPWP")."', '".$this->getField("PROSENTASE_TANPA_NPWP")."', 
					'".$this->getField("JUMLAH_NPWP")."', '".$this->getField("JUMLAH_TANPA_NPWP")."'
				)";
				
		$this->id = $this->getField("PERHITUNGAN_PPH_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		
				UPDATE PPI_GAJI.PERHITUNGAN_PPH
				SET    
					   JENIS_PENGHASILAN     = '".$this->getField("JENIS_PENGHASILAN")."',
					   KELAS                 = '".$this->getField("KELAS")."',
					   JENIS_PEGAWAI_ID      = '".$this->getField("JENIS_PEGAWAI_ID")."',
					   JENIS_PERHITUNGAN     = '".$this->getField("JENIS_PERHITUNGAN")."',
					   JUMLAH                = PPI_GAJI.KONVERSI_NAMA_ID_KONDISI(UPPER('".$this->getField("JUMLAH")."')),
					   PROSENTASE_NPWP       = '".$this->getField("PROSENTASE_NPWP")."',
					   PROSENTASE_TANPA_NPWP = '".$this->getField("PROSENTASE_TANPA_NPWP")."',
					   JUMLAH_NPWP       	 = '".$this->getField("JUMLAH_NPWP")."',
					   JUMLAH_TANPA_NPWP     = '".$this->getField("JUMLAH_TANPA_NPWP")."'
				WHERE  PERHITUNGAN_PPH_ID 	 = '".$this->getField("PERHITUNGAN_PPH_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.PERHITUNGAN_PPH
                WHERE 
                  PERHITUNGAN_PPH_ID = ".$this->getField("PERHITUNGAN_PPH_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT PERHITUNGAN_PPH_ID, JENIS_PENGHASILAN, KELAS, A.JENIS_PEGAWAI_ID,
			    B.NAMA JENIS_PEGAWAI, JENIS_PERHITUNGAN, JUMLAH, 
				PROSENTASE_NPWP, PROSENTASE_TANPA_NPWP, JUMLAH_NPWP, JUMLAH_TANPA_NPWP
				FROM PPI_GAJI.PERHITUNGAN_PPH A INNER JOIN PPI_SIMPEG.JENIS_PEGAWAI B ON A.JENIS_PEGAWAI_ID = B.JENIS_PEGAWAI_ID
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
				SELECT PERHITUNGAN_PPH_ID, JENIS_PENGHASILAN, KELAS, 
			    JENIS_PEGAWAI_ID, JENIS_PERHITUNGAN, JUMLAH, 
				PROSENTASE_NPWP, PROSENTASE_TANPA_NPWP
				FROM PPI_GAJI.PERHITUNGAN_PPH
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KELAS ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PERHITUNGAN_PPH_ID) AS ROWCOUNT FROM PPI_GAJI.PERHITUNGAN_PPH
		        WHERE PERHITUNGAN_PPH_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PERHITUNGAN_PPH_ID) AS ROWCOUNT FROM PPI_GAJI.PERHITUNGAN_PPH
		        WHERE PERHITUNGAN_PPH_ID IS NOT NULL ".$statement; 
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