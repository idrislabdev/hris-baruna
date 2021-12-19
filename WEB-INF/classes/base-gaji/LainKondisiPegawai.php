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

  class LainKondisiPegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function LainKondisiPegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("LAIN_KONDISI_PEGAWAI_ID", $this->getNextId("LAIN_KONDISI_PEGAWAI_ID","PPI_GAJI.LAIN_KONDISI_PEGAWAI")); 
		$str = "
				INSERT INTO PPI_GAJI.LAIN_KONDISI_PEGAWAI (
				   LAIN_KONDISI_PEGAWAI_ID, LAIN_KONDISI_ID, PEGAWAI_ID, 
				   JUMLAH_TOTAL, ANGSURAN, BULAN_MULAI, 
				   JUMLAH_AWAL_ANGSURAN, JUMLAH_ANGSURAN, ANGSURAN_TERBAYAR, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE) 
				VALUES(
					  ".$this->getField("LAIN_KONDISI_PEGAWAI_ID").",
					  '".$this->getField("LAIN_KONDISI_ID")."',
					  '".$this->getField("PEGAWAI_ID")."',
					  '".$this->getField("JUMLAH_TOTAL")."',
					  '".$this->getField("ANGSURAN")."',
					  '".$this->getField("BULAN_MULAI")."',
					  '".$this->getField("JUMLAH_AWAL_ANGSURAN")."',
					  '".$this->getField("JUMLAH_ANGSURAN")."',
					  NVL('".$this->getField("ANGSURAN_TERBAYAR")."',0),
					  '".$this->getField("KETERANGAN")."', '".$this->getField("LAST_CREATE_USER")."',
					  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("LAIN_KONDISI_PEGAWAI_ID");
		$this->query = $str;
		
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.LAIN_KONDISI_PEGAWAI
			   SET 
				   	JUMLAH_TOTAL			= '".$this->getField("JUMLAH_TOTAL")."',
				   	ANGSURAN				= '".$this->getField("ANGSURAN")."',
				   	BULAN_MULAI				= '".$this->getField("BULAN_MULAI")."',
					ANGSURAN_TERBAYAR		= '".$this->getField("ANGSURAN_TERBAYAR")."',
					KETERANGAN				= '".$this->getField("KETERANGAN")."',
					JUMLAH_ANGSURAN			= '".$this->getField("JUMLAH_ANGSURAN")."',
					LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."					
			 WHERE LAIN_KONDISI_PEGAWAI_ID = ".$this->getField("LAIN_KONDISI_PEGAWAI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
		
    }



    function updateSetLunasPeriode()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.LAIN_KONDISI_PEGAWAI
			   SET 
					ANGSURAN_TERBAYAR		= ANGSURAN,
					BULAN_AKHIR_BAYAR		= '".$this->getField("BULAN_AKHIR_BAYAR")."'
			 WHERE LAIN_KONDISI_PEGAWAI_ID = ".$this->getField("LAIN_KONDISI_PEGAWAI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }


    function updateSetLunas()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.LAIN_KONDISI_PEGAWAI
			   SET 
					ANGSURAN_TERBAYAR		= ANGSURAN
			 WHERE LAIN_KONDISI_PEGAWAI_ID = ".$this->getField("LAIN_KONDISI_PEGAWAI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "
		DELETE FROM PPI_GAJI.LAIN_KONDISI_PEGAWAI
                WHERE 
                  PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."' 
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="", $reqBulan="", $reqTahun="")
	{
		$str = "
				SELECT 
				LAIN_KONDISI_PEGAWAI_ID, LAIN_KONDISI_ID, PEGAWAI_ID, JUMLAH_TOTAL, ANGSURAN, BULAN_MULAI, JUMLAH_AWAL_ANGSURAN, JUMLAH_ANGSURAN, ANGSURAN_TERBAYAR, BULAN_AKHIR_BAYAR,
				KETERANGAN
				FROM PPI_GAJI.LAIN_KONDISI_PEGAWAI				
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

    function selectByParamsGajiPotongan($reqId)
	{
		$str = "
				SELECT A.NAMA, A.NRP, PPI_GAJI.AMBIL_GAJI_POTONGAN(A.PEGAWAI_ID) PERHITUNGAN_GAJI FROM PPI_SIMPEG.PEGAWAI A WHERE A.PEGAWAI_ID = '".$reqId."'
			"; 
		
		$this->query = $str;
		return $this->selectLimit($str, -1, -1); 
    }
		
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT 
				LAIN_KONDISI_PEGAWAI_ID, LAIN_KONDISI_ID, PEGAWAI_ID, JUMLAH_TOTAL, ANGSURAN, BULAN_MULAI, JUMLAH_AWAL_ANGSURAN, JUMLAH_ANGSURAN, ANGSURAN_TERBAYAR
				FROM PPI_GAJI.LAIN_KONDISI_PEGAWAI				
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY LAIN_KONDISI_PEGAWAI_ID DESC";
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
		$str = "SELECT COUNT(LAIN_KONDISI_PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.LAIN_KONDISI_PEGAWAI WHERE 1 = 1 "; 
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
		$str = "SELECT COUNT(LAIN_KONDISI_PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.LAIN_KONDISI_PEGAWAI WHERE 1 = 1 "; 
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