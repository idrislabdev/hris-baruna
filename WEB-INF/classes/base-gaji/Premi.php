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

  class Premi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Premi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PREMI_ID", $this->getNextId("PREMI_ID","PPI_GAJI.PREMI")); 
		$str = "
				INSERT INTO PPI_GAJI.PREMI (
				   PREMI_ID, KAPAL_JENIS_ID, KRU_JABATAN_ID, 
				   LOKASI_ID, PRODUKSI_NORMAL, PRODUKSI_MAKSIMAL, 
				   INTERVAL_PRODUKSI, TARIF_NORMAL, TARIF_MAKSIMAL) 
				VALUES (
				  ".$this->getField("PREMI_ID").",
				  '".$this->getField("KAPAL_JENIS_ID")."',
				  '".$this->getField("KRU_JABATAN_ID")."',
				  '".$this->getField("LOKASI_ID")."',
				  '".$this->getField("PRODUKSI_NORMAL")."',
				  '".$this->getField("PRODUKSI_MAKSIMAL")."',
				  '".$this->getField("INTERVAL_PRODUKSI")."',
				  '".$this->getField("TARIF_NORMAL")."',
				  '".$this->getField("TARIF_MAKSIMAL")."'
				)"; 
		$this->id = $this->getField("PREMI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.PREMI
			   SET 
			   		LOKASI_ID			= '".$this->getField("LOKASI_ID")."',
			   		KAPAL_JENIS_ID  	= '".$this->getField("KAPAL_JENIS_ID")."',
					KRU_JABATAN_ID 		= '".$this->getField("KRU_JABATAN_ID")."',
					PRODUKSI_NORMAL  	= '".$this->getField("PRODUKSI_NORMAL")."',
					PRODUKSI_MAKSIMAL  	= '".$this->getField("PRODUKSI_MAKSIMAL")."',
				   	INTERVAL_PRODUKSI	= '".$this->getField("INTERVAL_PRODUKSI")."',
					TARIF_NORMAL		= '".$this->getField("TARIF_NORMAL")."',
					TARIF_MAKSIMAL		= '".$this->getField("TARIF_MAKSIMAL")."'
			 WHERE PREMI_ID = ".$this->getField("PREMI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.PREMI
                WHERE 
                  PREMI_ID = ".$this->getField("PREMI_ID").""; 
				  
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
                PREMI_ID, A.LOKASI_ID, A.KAPAL_JENIS_ID, A.KRU_JABATAN_ID, PRODUKSI_NORMAL, PRODUKSI_MAKSIMAL, INTERVAL_PRODUKSI, 
				TARIF_NORMAL, TARIF_MAKSIMAL, B.NAMA LOKASI, D.NAMA KAPAL_JENIS, C.NAMA JABATAN 
				FROM PPI_GAJI.PREMI A
				LEFT JOIN PEL_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID 
				LEFT JOIN PEL_OPERASIONAL.KRU_JABATAN  C ON A.KRU_JABATAN_ID = C.KRU_JABATAN_ID
                LEFT JOIN PEL_OPERASIONAL.KAPAL_JENIS D ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
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
	
	function selectByParamsPremiReport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
                SELECT  KRU_JABATAN_ID,
				  KAPAL_ID, PEGAWAI_ID, AWAK_KAPAL, NRP, NPWP, KELAS,
				  JABATAN, REALISASI_PRODUKSI, PRODUKSI_NORMAL, PRODUKSI_MAKSIMAL,
				  INTERVAL_PRODUKSI, TARIF_NORMAL, TARIF_MAKSIMAL,
				  FAKTOR_KONVERSI, PREMI_JSON, PPH,
				  NAMA_KAPAL, MASA_KERJA, MASUK_KERJA, JUMLAH,
				  JAM_INSENTIF_KELEBIHAN, JUMLAH_DITERIMA, 
				  JUMLAH_PPH,TOTAL_INSENTIF,JUMLAH_INSENTIF, PERIODE
				  FROM PPI_GAJI.PREMI_REPORT
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


		  
    function selectByParamsReportRekap($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$str = "SELECT 
				PERIODE, NAMA_KAPAL, SUM(JUMLAH) JUMLAH, 
				   SUM(POTONGAN) POTONGAN, SUM(TOTAL) TOTAL
				FROM PPI_GAJI.PREMI_REKAP_REPORT
				WHERE 1 = 1 AND PERIODE LIKE '%".$periode."' GROUP BY PERIODE, NAMA_KAPAL "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsReportKeuangan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $periode="", $order="")
	{
		$str = "
				SELECT AWAK_KAPAL, NRP, REKENING_NO, NAMA_BANK, TOTAL_INSENTIF, PPH, JUMLAH_PPH, JUMLAH_DITERIMA, JENIS_PEGAWAI, JENIS_PEGAWAI_ID  FROM PPI_GAJI.PREMI_REPORT
				WHERE 1 = 1 AND PERIODE = '".$periode."' "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str;
		//exit;
		return $this->selectLimit($str,$limit,$from); 
    }		
	
	    function selectByParamsReportKeuanganCSVHeader($statement="", $periode="")
	{
		$str = "
				SELECT TO_CHAR(sysdate,'dd/mm/yyyy hh24:mi:ss') TANGGAL_BUAT, COUNT(JUMLAH_DITERIMA) TOTAL, SUM(JUMLAH_DITERIMA) SUM_PREMI, SUM(substr(A.REKENING_NO, -4)) CEK_AKUN FROM PPI_GAJI.PREMI_REPORT
				WHERE 1 = 1 AND PERIODE = '".$periode."' "; 
		
		$str .= $statement;
		$this->query = $str;
		//echo $str;
		//exit;
		return $this->selectLimit($str,-1,-1); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
                SELECT 
                PREMI_ID, A.LOKASI_ID, A.KAPAL_JENIS_ID, 
                   A.JABATAN_ID, PRODUKSI_NORMAL, PRODUKSI_MAKSIMAL, 
                   INTERVAL_PRODUKSI, TARIF_NORMAL, TARIF_MAKSIMAL
                FROM PPI_GAJI.PREMI A 
				INNER JOIN PPI_SIMPEG.DEPARTEMEN B ON A.LOKASI_ID = B.DEPARTEMEN_ID
                INNER JOIN PPI_SIMPEG.JABATAN C ON A.JABATAN_ID = C.JABATAN_ID
                INNER JOIN PEL_OPERASIONAL.KAPAL_JENIS D ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
				WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY PREMI_ID DESC";
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
		$str = "
				SELECT COUNT(PREMI_ID) AS ROWCOUNT 
				FROM PPI_GAJI.PREMI A
				INNER JOIN PEL_OPERASIONAL.LOKASI B ON A.LOKASI_ID = B.LOKASI_ID 
				INNER JOIN PEL_OPERASIONAL.KRU_JABATAN  C ON A.KRU_JABATAN_ID = C.KRU_JABATAN_ID
                INNER JOIN PEL_OPERASIONAL.KAPAL_JENIS D ON A.KAPAL_JENIS_ID = D.KAPAL_JENIS_ID
			 ".$statement; 
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
		$str = "SELECT COUNT(PREMI_ID) AS ROWCOUNT FROM PPI_GAJI.PREMI WHERE 1 = 1 "; 
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
	
	function replaceSpecialCharacter($strVariable="")
		{
			$strRestrict = array(",", "`", "~", "!", "@", "#", "$", "%", "^", "&", "*", "_", "{", "}", "<", ">", "[", "]", "=", "\\", ";", "'");
			$result = str_replace($strRestrict, " ", $strVariable);
			return $result;
		}
  } 
?>