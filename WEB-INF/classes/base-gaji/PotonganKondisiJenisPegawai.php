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

  class PotonganKondisiJenisPegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PotonganKondisiJenisPegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("POTONGAN_KONDISI_JENIS_PEGAWAI", $this->getNextId("POTONGAN_KONDISI_JENIS_PEGAWAI","PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI")); 
		$str = "
				INSERT INTO PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI (
				   POTONGAN_KONDISI_JENIS_PEGAWAI, JENIS_PEGAWAI_ID, POTONGAN_KONDISI_ID, 
				   JUMLAH, PROSENTASE, SUMBER, KALI, KELAS, KELOMPOK, JENIS_POTONGAN, JUMLAH_ENTRI, OPSI) 
				VALUES(
					  ".$this->getField("POTONGAN_KONDISI_JENIS_PEGAWAI").",
					  '".$this->getField("JENIS_PEGAWAI_ID")."',
					  '".$this->getField("POTONGAN_KONDISI_ID")."',
					  PPI_GAJI.KONVERSI_NAMA_ID_KONDISI(UPPER('".$this->getField("JUMLAH")."')),
					  '".$this->getField("PROSENTASE")."',
					  '".$this->getField("SUMBER")."',
					  '".$this->getField("KALI")."',
					  '".$this->getField("KELAS")."',
					  '".$this->getField("KELOMPOK")."',
					  '".$this->getField("JENIS_POTONGAN")."',
					  '".$this->getField("JUMLAH_ENTRI")."',
					  '".$this->getField("OPSI")."'					  
				)"; 
		$this->id = $this->getField("POTONGAN_KONDISI_JENIS_PEGAWAI");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI
			   SET 
			   		JENIS_PEGAWAI_ID	= '".$this->getField("JENIS_PEGAWAI_ID")."',
			   		POTONGAN_KONDISI_ID = '".$this->getField("POTONGAN_KONDISI_ID")."',
				   	JUMLAH				= '".$this->getField("JUMLAH")."',
				   	PROSENTASE			= '".$this->getField("PROSENTASE")."',
				   	SUMBER				= '".$this->getField("SUMBER")."',
				   	KALI				= '".$this->getField("KALI")."',
					KELAS				= '".$this->getField("KELAS")."',
					JENIS_POTONGAN		= '".$this->getField("JENIS_POTONGAN")."'
			 WHERE POTONGAN_KONDISI_JENIS_PEGAWAI = ".$this->getField("POTONGAN_KONDISI_JENIS_PEGAWAI")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI
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
				SELECT POTONGAN_KONDISI_JENIS_PEGAWAI, JENIS_PEGAWAI_ID, POTONGAN_KONDISI_ID, JUMLAH, PROSENTASE, SUMBER, KALI, KELAS, JENIS_POTONGAN
				FROM PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI				
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
				B.NAMA, A.KELOMPOK, A.KELAS
				FROM PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI A INNER JOIN PPI_SIMPEG.JENIS_PEGAWAI B ON A.JENIS_PEGAWAI_ID = B.JENIS_PEGAWAI_ID				
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
				SELECT POTONGAN_KONDISI_JENIS_PEGAWAI, JENIS_PEGAWAI_ID, POTONGAN_KONDISI_ID, JUMLAH, PROSENTASE, SUMBER, KALI, KELAS, JENIS_POTONGAN
				FROM PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI				
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY POTONGAN_KONDISI_JENIS_PEGAWAI DESC";
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
		$str = "SELECT COUNT(JENIS_PEGAWAI_ID) ROWCOUNT FROM
				(
				SELECT A.JENIS_PEGAWAI_ID, B.NAMA
								FROM PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI A INNER JOIN PPI_SIMPEG.JENIS_PEGAWAI B ON A.JENIS_PEGAWAI_ID = B.JENIS_PEGAWAI_ID				
								WHERE 1 = 1 ".$statement."
				"; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= " GROUP BY A.JENIS_PEGAWAI_ID, B.NAMA, A.KELOMPOK, A.KELAS ORDER BY B.NAMA
				) B ";
				
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(POTONGAN_KONDISI_JENIS_PEGAWAI) AS ROWCOUNT FROM PPI_GAJI.POTONGAN_KONDISI_JENIS_PEGAWAI WHERE 1 = 1 "; 
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