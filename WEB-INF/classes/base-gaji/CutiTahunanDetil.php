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

  class CutiTahunanDetil extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function CutiTahunanDetil()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("CUTI_TAHUNAN_DETIL_ID", $this->getNextId("CUTI_TAHUNAN_DETIL_ID","PPI_GAJI.CUTI_TAHUNAN_DETIL")); 
		$str = "
				INSERT INTO PPI_GAJI.CUTI_TAHUNAN_DETIL (CUTI_TAHUNAN_DETIL_ID, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, LAMA_CUTI, CUTI_TAHUNAN_ID, LOKASI_CUTI, STATUS_BAYAR_MUTASI) 
				VALUES(
					  ".$this->getField("CUTI_TAHUNAN_DETIL_ID").",
					  ".$this->getField("TANGGAL").",
					  ".$this->getField("TANGGAL_AWAL").",
					  ".$this->getField("TANGGAL_AKHIR").",
					  '".$this->getField("LAMA_CUTI")."',
					  '".$this->getField("CUTI_TAHUNAN_ID")."',
					  '".$this->getField("LOKASI_CUTI")."',
					  '".$this->getField("STATUS_BAYAR_MUTASI")."'			  
				)"; 
		$this->id = $this->getField("CUTI_TAHUNAN_DETIL_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function insertPegawai()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("CUTI_TAHUNAN_DETIL_ID", $this->getNextId("CUTI_TAHUNAN_DETIL_ID","PPI_GAJI.CUTI_TAHUNAN_DETIL")); 
		$str = "
				INSERT INTO PPI_GAJI.CUTI_TAHUNAN_DETIL (CUTI_TAHUNAN_DETIL_ID, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, LAMA_CUTI, CUTI_TAHUNAN_ID, LOKASI_CUTI, TANGGAL_CETAK, TANGGAL_APPROVE, STATUS_BAYAR_MUTASI, LAMA_CUTI_TERBAYAR) 
				VALUES(
					  ".$this->getField("CUTI_TAHUNAN_DETIL_ID").",
					  ".$this->getField("TANGGAL").",
					  ".$this->getField("TANGGAL_AWAL").",
					  ".$this->getField("TANGGAL_AKHIR").",
					  '".$this->getField("LAMA_CUTI")."',
					  '".$this->getField("CUTI_TAHUNAN_ID")."'	,
					  '".$this->getField("LOKASI_CUTI")."', ".$this->getField("TANGGAL_CETAK").", ".$this->getField("TANGGAL_APPROVE").",	
					  '".$this->getField("STATUS_BAYAR_MUTASI")."',
					  '".$this->getField("LAMA_CUTI_TERBAYAR")."'				  
				)"; 
		$this->id = $this->getField("CUTI_TAHUNAN_DETIL_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function insertDetil()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("CUTI_TAHUNAN_DETIL_ID", $this->getNextId("CUTI_TAHUNAN_DETIL_ID","PPI_GAJI.CUTI_TAHUNAN_DETIL")); 
		$str = "
				INSERT INTO PPI_GAJI.CUTI_TAHUNAN_DETIL (
				   CUTI_TAHUNAN_DETIL_ID, TANGGAL, TANGGAL_AWAL, 
				   TANGGAL_AKHIR, LAMA_CUTI, CUTI_TAHUNAN_ID, 
				   KETERANGAN, STATUS_CB) 
				SELECT (SELECT MAX(CUTI_TAHUNAN_DETIL_ID) FROM PPI_GAJI.CUTI_TAHUNAN_DETIL) + ROWNUM ID, SYSDATE TANGGAL, SYSDATE TANGGAL_AWAL, 
				   SYSDATE TANGGAL_AKHIR, '".$this->getField("CUTI_TAHUNAN_ID")."' CUTI_TAHUNAN_ID, (SELECT CASE WHEN SUM(JUMLAH_LIBUR_BULAN_INI + JUMLAH_LIBUR_BULAN_DEPAN) > 6 THEN 6 ELSE SUM(JUMLAH_LIBUR_BULAN_INI + JUMLAH_LIBUR_BULAN_DEPAN) END LAMA_CUTI FROM PPI_ABSENSI.HARI_LIBUR WHERE STATUS_CUTI_BERSAMA = 1 AND TO_CHAR(TANGGAL_AWAL, 'YYYY') = TO_CHAR(SYSDATE, 'YYYY') - 1) JML,  '', 1 FROM DUAL
				"; 
		$this->id = $this->getField("CUTI_TAHUNAN_DETIL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.CUTI_TAHUNAN_DETIL
			   SET 
			   		TANGGAL			= ".$this->getField("TANGGAL").",
				   	TANGGAL_AWAL	= ".$this->getField("TANGGAL_AWAL").",
				   	TANGGAL_AKHIR	= ".$this->getField("TANGGAL_AKHIR").", ";
				   	if($this->getField("STATUS_TUNDA") != 0 || $this->getField("STATUS_TUNDA") != '0') {

				   	} 
				   	else {
				   		$str .= " LAMA_CUTI	= '".$this->getField("LAMA_CUTI")."', ";
				   	}
				   	$str .= " 
					LOKASI_CUTI = '".$this->getField("LOKASI_CUTI")."',
					STATUS_TUNDA = '".$this->getField("STATUS_TUNDA")."',
					NOTA_DINAS_TUNDA = '".$this->getField("NOTA_DINAS_TUNDA")."',
					TANGGAL_NOTA_DINAS_TUNDA = ".$this->getField("TANGGAL_NOTA_DINAS_TUNDA").",
					KETERANGAN_TUNDA = '".$this->getField("KETERANGAN_TUNDA")."' 
			 WHERE CUTI_TAHUNAN_DETIL_ID = ".$this->getField("CUTI_TAHUNAN_DETIL_ID")."
				"; 
				//echo $str; exit;
				$this->query = $str;
		return $this->execQuery($str);
    }

    function updateStatusTundaRealisasi()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.CUTI_TAHUNAN_DETIL
			   SET 
			   		STATUS_TUNDA    = 2
			 WHERE CUTI_TAHUNAN_DETIL_ID = ".$this->getField("CUTI_TAHUNAN_DETIL_ID")."
				"; 
				
				$this->query = $str;
		return $this->execQuery($str);
    }
		
    function updateNota()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.CUTI_TAHUNAN_DETIL
			   SET 
					NO_NOTA = '".$this->getField("NO_NOTA")."',
					TTD_NAMA = '".$this->getField("TTD_NAMA")."',
					TTD_JABATAN = '".$this->getField("TTD_JABATAN")."',
					TANGGAL_CETAK = SYSDATE
			 WHERE CUTI_TAHUNAN_DETIL_ID = ".$this->getField("CUTI_TAHUNAN_DETIL_ID")."
				"; 
				//echo $str;
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.CUTI_TAHUNAN_DETIL
                WHERE 
                  CUTI_TAHUNAN_DETIL_ID = ".$this->getField("CUTI_TAHUNAN_DETIL_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deletePegawai($reqId)
	{
        $str = "DELETE FROM PPI_GAJI.CUTI_TAHUNAN_DETIL A
                WHERE 
                  EXISTS(SELECT 1 FROM PPI_GAJI.CUTI_TAHUNAN X WHERE X.CUTI_TAHUNAN_ID = A.CUTI_TAHUNAN_ID AND X.STATUS_BAYAR_MUTASI IS NOT NULL AND X.PEGAWAI_ID = '".$reqId."')"; 
	  
		$this->query = $str;
        return $this->execQuery($str);
    }	

	function updateStatusTunda()
	{
        $str = "UPDATE PPI_GAJI.CUTI_TAHUNAN_DETIL SET STATUS_TUNDA = '1'
                WHERE 
                  CUTI_TAHUNAN_DETIL_ID = ".$this->getField("CUTI_TAHUNAN_DETIL_ID").""; 
				  
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
				SELECT CUTI_TAHUNAN_DETIL_ID, TANGGAL, TANGGAL_AWAL, TANGGAL_AKHIR, LAMA_CUTI, CUTI_TAHUNAN_ID, KETERANGAN, LOKASI_CUTI, STATUS_TUNDA STATUS_TUNDA_ID, DECODE(STATUS_TUNDA, 0, 'Tidak', 'Ya') STATUS_TUNDA, 
				TANGGAL_CETAK, TANGGAL_APPROVE, NO_NOTA_DINAS, TANGGAL_NOTA_DINAS_TUNDA, KETERANGAN_TUNDA, NOTA_DINAS_TUNDA 
				FROM PPI_GAJI.CUTI_TAHUNAN_DETIL		
				WHERE 1 = 1 AND NOT NVL(STATUS_CB, 0) = 1	
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCetak($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT NRP, NAMA, CUTI_TAHUNAN_DETIL_ID, A.TANGGAL, A.TANGGAL_AWAL, A.TANGGAL_AKHIR, A.LAMA_CUTI, A.CUTI_TAHUNAN_ID, KETERANGAN, LOKASI_CUTI
				FROM PPI_GAJI.CUTI_TAHUNAN_DETIL	 A 
                INNER JOIN PPI_GAJI.CUTI_TAHUNAN B ON A.CUTI_TAHUNAN_ID = B.CUTI_TAHUNAN_ID
                INNER JOIN PPI_SIMPEG.PEGAWAI C ON B.PEGAWAI_ID = C.PEGAWAI_ID	
				WHERE 1 = 1 AND NOT NVL(STATUS_CB, 0) = 1
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
				SELECT CUTI_TAHUNAN_DETIL_ID, KELAS, PERIODE, JUMLAH
				FROM PPI_GAJI.CUTI_TAHUNAN_DETIL		
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY CUTI_TAHUNAN_DETIL_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }		
	function selectJenisPegawaiDanLokasi($id="", $limit=-1,$from=-1)
	{
		$str = "    
				SELECT C.PEGAWAI_ID, C.KELOMPOK, A.KAPAL_ID,  CASE WHEN NVL(B.LOKASI_ID, '01') = NVL(D.LOKASI_ID, '01')  THEN 0 ELSE 1 END LUAR_KOTA , NVL(B.LOKASI_ID, '01') LOKASI_ID
				FROM PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C 
				LEFT JOIN PEL_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR A ON C.PEGAWAI_ID = A.PEGAWAI_ID
				LEFT JOIN PEL_OPERASIONAL.KAPAL_LOKASI_TERAKHIR B ON A.KAPAL_ID = B.KAPAL_ID 
				 LEFT JOIN PPI_SIMPEG.PEGAWAI D ON A.PEGAWAI_ID = D.PEGAWAI_ID  
				WHERE C.PEGAWAI_ID = (SELECT X.PEGAWAI_ID FROM PPI_GAJI.CUTI_TAHUNAN X WHERE X.CUTI_TAHUNAN_ID = ". $id .")
			"; 
		//echo $str;
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
		$str = "SELECT COUNT(CUTI_TAHUNAN_DETIL_ID) AS ROWCOUNT FROM PPI_GAJI.CUTI_TAHUNAN_DETIL WHERE 1 = 1 ".$statement; 
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




    function sumCutiBersama($paramsArray=array(), $statement="")
	{
		$str = "SELECT CASE WHEN SUM(JUMLAH_LIBUR_BULAN_INI + JUMLAH_LIBUR_BULAN_DEPAN) > 6 THEN 6 ELSE SUM(JUMLAH_LIBUR_BULAN_INI + JUMLAH_LIBUR_BULAN_DEPAN) END LAMA_CUTI FROM PPI_ABSENSI.HARI_LIBUR WHERE STATUS_CUTI_BERSAMA = 1 AND TO_CHAR(TANGGAL_AWAL, 'YYYY') = TO_CHAR(SYSDATE, 'YYYY') - 1".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str; exit;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("LAMA_CUTI"); 
		else 
			return 0; 
    }


    function sumByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT SUM(LAMA_CUTI) AS ROWCOUNT FROM PPI_GAJI.CUTI_TAHUNAN_DETIL WHERE 1 = 1 AND STATUS_TUNDA = 0 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str; exit;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(CUTI_TAHUNAN_DETIL_ID) AS ROWCOUNT FROM PPI_GAJI.CUTI_TAHUNAN_DETIL WHERE 1 = 1 "; 
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