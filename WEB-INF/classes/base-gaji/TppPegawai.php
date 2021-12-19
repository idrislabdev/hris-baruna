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

  class TppPegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TppPegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TPP_PEGAWAI_ID", $this->getNextId("TPP_PEGAWAI_ID","PPI_GAJI.TPP_PEGAWAI")); 
		$str = "
				INSERT INTO PPI_GAJI.TPP_PEGAWAI (
				   TPP_PEGAWAI_ID, 
				   JABATAN_ID, 
				   DIBAYAR_LUMPSUM, 
				   DIBAYAR_JAM, 
				   TARIF_KELEBIHAN_REGULER, 
				   TARIF_KELEBIHAN_D3_KPNK, 
				   TUNJANGAN_DT_REGULER, 
				   TUNJANGAN_DT_D3_KPNK, 
				   TARIF_DL_REGULER, 
				   TARIF_DL_D3_KPNK,
				   TARIF_JAM_WAJIB, 
				   TARIF_JAM_TAMBAHAN, 
   				   MIN_JAM_MENGAJAR) 
				VALUES ( 
				'".$this->getField("TPP_PEGAWAI_ID")."', 
				'".$this->getField("JABATAN_ID")."', 
				'".$this->getField("DIBAYAR_LUMPSUM")."',
				'".$this->getField("DIBAYAR_JAM")."', 
				'".$this->getField("TARIF_KELEBIHAN_REGULER")."', 
				'".$this->getField("TARIF_KELEBIHAN_D3_KPNK")."',
				'".$this->getField("TUNJANGAN_DT_REGULER")."', 
				'".$this->getField("TUNJANGAN_DT_D3_KPNK")."', 
				'".$this->getField("TARIF_DL_REGULER")."', 
				'".$this->getField("TARIF_DL_D3_KPNK")."', 
				'".$this->getField("TARIF_JAM_WAJIB")."', 
				'".$this->getField("TARIF_JAM_TAMBAHAN")."', 
				'".$this->getField("MIN_JAM_MENGAJAR")."' )
				"; 
		$this->id = $this->getField("PPI_GAJI.TPP_PEGAWAI_ID");
		$this->query = $str;
		// echo $str; exit();
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				UPDATE PPI_GAJI.TPP_PEGAWAI
				SET    JABATAN_ID              = '".$this->getField("JABATAN_ID")."',
				       DIBAYAR_LUMPSUM         = '".$this->getField("DIBAYAR_LUMPSUM")."',
				       DIBAYAR_JAM             = '".$this->getField("DIBAYAR_JAM")."',
				       TARIF_KELEBIHAN_REGULER = '".$this->getField("TARIF_KELEBIHAN_REGULER")."',
				       TARIF_KELEBIHAN_D3_KPNK = '".$this->getField("TARIF_KELEBIHAN_D3_KPNK")."',
				       TUNJANGAN_DT_REGULER    = '".$this->getField("TUNJANGAN_DT_REGULER")."',
				       TUNJANGAN_DT_D3_KPNK    = '".$this->getField("TUNJANGAN_DT_D3_KPNK")."',
				       TARIF_DL_REGULER        = '".$this->getField("TARIF_DL_REGULER")."',
				       TARIF_DL_D3_KPNK        = '".$this->getField("TARIF_DL_D3_KPNK")."'
				       TARIF_JAM_WAJIB         = '".$this->getField("TARIF_JAM_WAJIB")."'
				       TARIF_JAM_TAMBAHAN      = '".$this->getField("TARIF_JAM_TAMBAHAN")."'
				       MIN_JAM_MENGAJAR        = '".$this->getField("MIN_JAM_MENGAJAR")."'
				WHERE  TPP_PEGAWAI_ID          = '".$this->getField("TPP_PEGAWAI_ID")."'

				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.TPP_PEGAWAI
                WHERE 
                  TPP_PEGAWAI_ID = ".$this->getField("TPP_PEGAWAI_ID").""; 
				  
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
					TPP_PEGAWAI_ID, JABATAN_ID, DIBAYAR_LUMPSUM, 
					   DIBAYAR_JAM, TARIF_KELEBIHAN_REGULER, TARIF_KELEBIHAN_D3_KPNK, 
					   TUNJANGAN_DT_REGULER, TUNJANGAN_DT_D3_KPNK, TARIF_DL_REGULER, 
					   TARIF_DL_D3_KPNK
					FROM PPI_GAJI.TPP_PEGAWAI A
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

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
					TPP_PEGAWAI_ID, A.JABATAN_ID, DIBAYAR_LUMPSUM, 
					   DIBAYAR_JAM, TARIF_KELEBIHAN_REGULER, TARIF_KELEBIHAN_D3_KPNK, 
					   TUNJANGAN_DT_REGULER, TUNJANGAN_DT_D3_KPNK, TARIF_DL_REGULER, 
					   TARIF_DL_D3_KPNK, B.NAMA NAMA_JABATAN,TARIF_JAM_WAJIB, TARIF_JAM_TAMBAHAN, 
   					   MIN_JAM_MENGAJAR
					FROM PPI_GAJI.TPP_PEGAWAI A
					LEFT JOIN PPI_SIMPEG.JABATAN B ON A.JABATAN_ID = B.JABATAN_ID
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str; exit();
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT 
					 TPP_PEGAWAI_ID, JABATAN_ID, DIBAYAR_LUMPSUM, 
					   DIBAYAR_JAM, TARIF_KELEBIHAN_REGULER, TARIF_KELEBIHAN_D3_KPNK, 
					   TUNJANGAN_DT_REGULER, TUNJANGAN_DT_D3_KPNK, TARIF_DL_REGULER, 
					   TARIF_DL_D3_KPNK
					FROM PPI_GAJI.TPP_PEGAWAI A
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY TPP_PEGAWAI_ID DESC";
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
		$str = "SELECT COUNT(TPP_PEGAWAI_ID) AS ROWCOUNT 
				FROM PPI_GAJI.TPP_PEGAWAI A 	 WHERE 1 = 1 ".$statement; 
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

    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(TPP_PEGAWAI_ID) AS ROWCOUNT 
				FROM PPI_GAJI.TPP_PEGAWAI A 
				LEFT JOIN PPI_SIMPEG.JABATAN B ON A.JABATAN_ID = B.JABATAN_ID
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

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(TPP_PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.TPP_PEGAWAI WHERE 1 = 1 "; 
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