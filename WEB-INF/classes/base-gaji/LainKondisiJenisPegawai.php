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

  class LainKondisiJenisPegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function LainKondisiJenisPegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LAIN_KONDISI_JENIS_PEGAWAI_ID", $this->getNextId("LAIN_KONDISI_JENIS_PEGAWAI_ID","PPI_GAJI.LAIN_KONDISI_JENIS_PEGAWAI")); 
		$str = "
				INSERT INTO PPI_GAJI.LAIN_KONDISI_JENIS_PEGAWAI (
				   LAIN_KONDISI_JENIS_PEGAWAI_ID, JENIS_PEGAWAI_ID, LAIN_KONDISI_ID, 
				   JUMLAH, PROSENTASE, SUMBER, KALI, KELAS, KELOMPOK) 
				VALUES(
					  ".$this->getField("LAIN_KONDISI_JENIS_PEGAWAI_ID").",
					  '".$this->getField("JENIS_PEGAWAI_ID")."',
					  '".$this->getField("LAIN_KONDISI_ID")."',
					  PPI_GAJI.KONVERSI_NAMA_ID_KONDISI(UPPER('".$this->getField("JUMLAH")."')),
					  '".$this->getField("PROSENTASE")."',
					  '".$this->getField("SUMBER")."',
					  '".$this->getField("KALI")."',
					  '".$this->getField("KELAS")."',
					  '".$this->getField("KELOMPOK")."'
				)"; 
		$this->id = $this->getField("LAIN_KONDISI_JENIS_PEGAWAI_ID");
		$this->query = $str;
		
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.LAIN_KONDISI_JENIS_PEGAWAI
			   SET 
			   		JENIS_PEGAWAI_ID	= '".$this->getField("JENIS_PEGAWAI_ID")."',
			   		LAIN_KONDISI_ID  	= '".$this->getField("LAIN_KONDISI_ID")."',
				   	JUMLAH				= '".$this->getField("JUMLAH")."',
				   	PROSENTASE			= '".$this->getField("PROSENTASE")."',
				   	SUMBER				= '".$this->getField("SUMBER")."',
				   	KALI				= '".$this->getField("KALI")."',
					KELAS				= '".$this->getField("KELAS")."'
			 WHERE LAIN_KONDISI_JENIS_PEGAWAI_ID = ".$this->getField("LAIN_KONDISI_JENIS_PEGAWAI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.LAIN_KONDISI_JENIS_PEGAWAI
                WHERE 
                  JENIS_PEGAWAI_ID = '".$this->getField("JENIS_PEGAWAI_ID")."' AND KELAS = '".$this->getField("KELAS")."'
				  AND KELOMPOK = '".$this->getField("KELOMPOK")."'"; 
		//echo $str;
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="", $reqBulan="", $reqTahun="")
	{
		$str = "
				SELECT LAIN_KONDISI_JENIS_PEGAWAI_ID, JENIS_PEGAWAI_ID, LAIN_KONDISI_ID, JUMLAH, PROSENTASE, SUMBER, KALI, KELAS
				FROM PPI_GAJI.LAIN_KONDISI_JENIS_PEGAWAI				
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="", $reqBulan="", $reqTahun="")
	{
		$str = "
				SELECT A.JENIS_PEGAWAI_ID, A.KELOMPOK KELOMPOK_ID, REPLACE(A.KELAS, ',', ';') KELAS_ID, 
				B.NAMA, CASE WHEN A.KELOMPOK = 'D' THEN 'Darat' ELSE 'Kapal' END KELOMPOK, A.KELAS
				FROM PPI_GAJI.LAIN_KONDISI_JENIS_PEGAWAI A INNER JOIN PPI_SIMPEG.JENIS_PEGAWAI B ON A.JENIS_PEGAWAI_ID = B.JENIS_PEGAWAI_ID				
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.JENIS_PEGAWAI_ID, B.NAMA, A.KELOMPOK, A.KELAS ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT LAIN_KONDISI_JENIS_PEGAWAI_ID, JENIS_PEGAWAI_ID, LAIN_KONDISI_ID, JUMLAH, PROSENTASE, SUMBER, KALI, KELAS
				FROM PPI_GAJI.LAIN_KONDISI_JENIS_PEGAWAI				
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY LAIN_KONDISI_JENIS_PEGAWAI_ID DESC";
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
		$str = "SELECT COUNT(*) ROWCOUNT FROM
				(
				SELECT A.JENIS_PEGAWAI_ID, B.NAMA
								FROM PPI_GAJI.LAIN_KONDISI_JENIS_PEGAWAI A INNER JOIN PPI_SIMPEG.JENIS_PEGAWAI B ON A.JENIS_PEGAWAI_ID = B.JENIS_PEGAWAI_ID				
								WHERE 1 = 1 ".$statement."
				"; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= " GROUP BY A.JENIS_PEGAWAI_ID, B.NAMA ORDER BY B.NAMA
				) B ";
				
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(LAIN_KONDISI_JENIS_PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.LAIN_KONDISI_JENIS_PEGAWAI WHERE 1 = 1 "; 
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