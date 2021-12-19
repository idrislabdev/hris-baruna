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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_PENGHASILAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiPenghasilan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiPenghasilan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_PENGHASILAN_ID", $this->getNextId("PEGAWAI_PENGHASILAN_ID","PPI_SIMPEG.PEGAWAI_PENGHASILAN"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_PENGHASILAN (
				   PEGAWAI_PENGHASILAN_ID, PEJABAT_PENETAP_ID, PEGAWAI_ID, PERIODE, TMT_PENGHASILAN, JUMLAH_PENGHASILAN, 
				   NO_SK, TANGGAL_SK, MASA_KERJA_TAHUN, MASA_KERJA_BULAN,
				   JUMLAH_TPP, JUMLAH_TUNJANGAN_JABATAN, JUMLAH_TUNJANGAN_SELISIH, JUMLAH_TRANSPORTASI, JUMLAH_UANG_MAKAN, JUMLAH_INSENTIF, JUMLAH_MOBILITAS,
				   PROSENTASE_PENGHASILAN, PROSENTASE_TUNJANGAN_JABATAN, KELAS, PROSENTASE_UANG_MAKAN, PROSENTASE_TRANSPORTASI, PROSENTASE_INSENTIF,
				   JUMLAH_UANG_KEHADIRAN, PROSENTASE_UANG_KEHADIRAN, KELAS_P3, PERIODE_P3, JUMLAH_P3, PROSENTASE_TPP, LAST_CREATE_USER, LAST_CREATE_DATE,
				   PROSENTASE_MOBILITAS, JUMLAH_PERUMAHAN, PROSENTASE_PERUMAHAN, JUMLAH_BBM, PROSENTASE_BBM, JUMLAH_TELEPON, PROSENTASE_TELEPON, KETERANGAN_PERUBAHAN
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_PENGHASILAN_ID").",
				  '".$this->getField("PEJABAT_PENETAP_ID")."',
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("PERIODE")."',
				  ".$this->getField("TMT_PENGHASILAN").",
				  '".$this->getField("JUMLAH_PENGHASILAN")."',
				  '".$this->getField("NO_SK")."',
				  ".$this->getField("TANGGAL_SK").",
				  '".$this->getField("MASA_KERJA_TAHUN")."',
				  '".$this->getField("MASA_KERJA_BULAN")."',
				  '".$this->getField("JUMLAH_TPP")."',
				  '".$this->getField("JUMLAH_TUNJANGAN_JABATAN")."',
				  '".$this->getField("JUMLAH_TUNJANGAN_SELISIH")."',
				  '".$this->getField("JUMLAH_TRANSPORTASI")."',
				  '".$this->getField("JUMLAH_UANG_MAKAN")."',
				  '".$this->getField("JUMLAH_INSENTIF")."',
				  '".$this->getField("JUMLAH_MOBILITAS")."',
				  '".$this->getField("PROSENTASE_PENGHASILAN")."',
				  '".$this->getField("PROSENTASE_TUNJANGAN_JABATAN")."',
				  '".$this->getField("KELAS")."',
				  '".$this->getField("PROSENTASE_UANG_MAKAN")."',
				  '".$this->getField("PROSENTASE_TRANSPORTASI")."',
				  '".$this->getField("PROSENTASE_INSENTIF")."',
				  '".$this->getField("JUMLAH_UANG_KEHADIRAN")."',
				  '".$this->getField("PROSENTASE_UANG_KEHADIRAN")."',
				  ".$this->getField("KELAS_P3").",
				  ".$this->getField("PERIODE_P3").",
				  ".$this->getField("JUMLAH_P3").",
				  '".$this->getField("PROSENTASE_TPP")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("PROSENTASE_MOBILITAS")."',
				  '".$this->getField("JUMLAH_PERUMAHAN")."',
				  '".$this->getField("PROSENTASE_PERUMAHAN")."', 
				  '".$this->getField("JUMLAH_BBM")."',
				  '".$this->getField("PROSENTASE_BBM")."',
				  '".$this->getField("JUMLAH_TELEPON")."',
				  '".$this->getField("PROSENTASE_TELEPON")."',
				  '".$this->getField("KETERANGAN_PERUBAHAN")."'
				)"; 
		$this->id = $this->getField("PEGAWAI_PENGHASILAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_PENGHASILAN
				SET    
					   PEJABAT_PENETAP_ID           = '".$this->getField("PEJABAT_PENETAP_ID")."',
					   PERIODE    = '".$this->getField("PERIODE")."',
					   TMT_PENGHASILAN         = ".$this->getField("TMT_PENGHASILAN").",
					   JUMLAH_PENGHASILAN= '".$this->getField("JUMLAH_PENGHASILAN")."',
					   NO_SK= '".$this->getField("NO_SK")."',
					   TANGGAL_SK= ".$this->getField("TANGGAL_SK").",
					   MASA_KERJA_TAHUN= '".$this->getField("MASA_KERJA_TAHUN")."',
					   MASA_KERJA_BULAN= '".$this->getField("MASA_KERJA_BULAN")."',
					   JUMLAH_TPP= '".$this->getField("JUMLAH_TPP")."',
					   JUMLAH_TUNJANGAN_JABATAN= '".$this->getField("JUMLAH_TUNJANGAN_JABATAN")."',
					   JUMLAH_TUNJANGAN_SELISIH= '".$this->getField("JUMLAH_TUNJANGAN_SELISIH")."',
					   JUMLAH_TRANSPORTASI= '".$this->getField("JUMLAH_TRANSPORTASI")."',
					   JUMLAH_UANG_MAKAN= '".$this->getField("JUMLAH_UANG_MAKAN")."',
					   JUMLAH_INSENTIF= '".$this->getField("JUMLAH_INSENTIF")."',
					   JUMLAH_MOBILITAS= '".$this->getField("JUMLAH_MOBILITAS")."',
					   PROSENTASE_PENGHASILAN= '".$this->getField("PROSENTASE_PENGHASILAN")."',
					   PROSENTASE_TUNJANGAN_JABATAN= '".$this->getField("PROSENTASE_TUNJANGAN_JABATAN")."',
					   KELAS= '".$this->getField("KELAS")."',
					   PROSENTASE_UANG_MAKAN= '".$this->getField("PROSENTASE_UANG_MAKAN")."',
					   PROSENTASE_TRANSPORTASI= '".$this->getField("PROSENTASE_TRANSPORTASI")."',
					   PROSENTASE_INSENTIF= '".$this->getField("PROSENTASE_INSENTIF")."',
					   PROSENTASE_TPP= '".$this->getField("PROSENTASE_TPP")."',
					   JUMLAH_UANG_KEHADIRAN= '".$this->getField("JUMLAH_UANG_KEHADIRAN")."',
					   PROSENTASE_UANG_KEHADIRAN= '".$this->getField("PROSENTASE_UANG_KEHADIRAN")."',
					   KELAS_P3=".$this->getField("KELAS_P3").",
				  	   PERIODE_P3=".$this->getField("PERIODE_P3").",
				       JUMLAH_P3=".$this->getField("JUMLAH_P3").",
					   LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE").",
					   PROSENTASE_MOBILITAS = '".$this->getField("PROSENTASE_MOBILITAS")."', 
					   JUMLAH_PERUMAHAN = '".$this->getField("JUMLAH_PERUMAHAN")."', 
					   PROSENTASE_PERUMAHAN = '".$this->getField("PROSENTASE_PERUMAHAN")."', 
					   JUMLAH_BBM = '".$this->getField("JUMLAH_BBM")."', 
					   PROSENTASE_BBM = '".$this->getField("PROSENTASE_BBM")."', 
					   JUMLAH_TELEPON = '".$this->getField("JUMLAH_TELEPON")."', 
					   PROSENTASE_TELEPON = '".$this->getField("PROSENTASE_TELEPON")."',
					   LUMPSUM_MAKAN = '".$this->getField("LUMPSUM_MAKAN")."',
					   LUMPSUM_TRANSPORT = '".$this->getField("LUMPSUM_TRANSPORT")."'
				WHERE  PEGAWAI_PENGHASILAN_ID     = '".$this->getField("PEGAWAI_PENGHASILAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_PENGHASILAN
                WHERE 
                  PEGAWAI_PENGHASILAN_ID = ".$this->getField("PEGAWAI_PENGHASILAN_ID").""; 
				  
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
                    PEGAWAI_PENGHASILAN_ID, A.PEJABAT_PENETAP_ID, a.PEGAWAI_ID, PERIODE, TMT_PENGHASILAN, JUMLAH_PENGHASILAN,
                    a.NO_SK, a.TANGGAL_SK, MASA_KERJA_TAHUN, MASA_KERJA_BULAN,
                    JUMLAH_TPP, JUMLAH_TUNJANGAN_JABATAN, JUMLAH_TUNJANGAN_SELISIH, JUMLAH_TRANSPORTASI, JUMLAH_UANG_MAKAN, JUMLAH_INSENTIF, JUMLAH_MOBILITAS,
                    PROSENTASE_PENGHASILAN, PROSENTASE_TUNJANGAN_JABATAN, B.NAMA PEJABAT_PENETAP_NAMA, KELAS,
                    PROSENTASE_UANG_MAKAN, PROSENTASE_TRANSPORTASI, PROSENTASE_INSENTIF, JUMLAH_UANG_KEHADIRAN, PROSENTASE_UANG_KEHADIRAN, KELAS_P3, PERIODE_P3, JUMLAH_P3,
                    PROSENTASE_TPP, PROSENTASE_MOBILITAS, JUMLAH_PERUMAHAN, PROSENTASE_PERUMAHAN, JUMLAH_BBM, PROSENTASE_BBM, JUMLAH_TELEPON, PROSENTASE_TELEPON,
					NVL(C.KETERANGAN,KETERANGAN_PERUBAHAN) KETERANGAN_PERUBAHAN, LUMPSUM_MAKAN, LUMPSUM_TRANSPORT
                FROM PPI_SIMPEG.PEGAWAI_PENGHASILAN A
                LEFT JOIN PPI_SIMPEG.PEJABAT_PENETAP B ON A.PEJABAT_PENETAP_ID=B.PEJABAT_PENETAP_ID
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN C ON A.PEGAWAI_ID = C.PEGAWAI_ID AND A.NO_SK = C.NO_SK AND A.TMT_PENGHASILAN = C.TMT_JABATAN AND A.TANGGAL_SK = C.TANGGAL_SK  
                WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TMT_PENGHASILAN DESC";
//		echo $str;exit;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsListKelas($tempKelas="", $tempPeriode="0")
	{
		$str = "
				SELECT
				(
					SELECT JUMLAH
					FROM PPI_GAJI.MERIT_PMS        
					WHERE 1 = 1 AND KELAS = ".$tempKelas." AND PERIODE = ".$tempPeriode."
				) PENGHASILAN_MERIT,
				(
					SELECT JUMLAH 
					FROM PPI_GAJI.TPP_PMS
					WHERE 1 = 1 AND KELAS = ".$tempKelas."
				) TUNJANGAN_KEHADIRAN,
				(
					SELECT A.JUMLAH
					FROM PPI_GAJI.TUNJANGAN_JABATAN A
					INNER JOIN PPI_SIMPEG.JABATAN B ON A.JABATAN_ID = B.JABATAN_ID          
					WHERE  1=1 AND B.KELOMPOK = 'D' AND B.KELAS = ".$tempKelas."
				) TUNJANGAN_JABATAN
				FROM DUAL
				"; 
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT PEGAWAI_PENGHASILAN_ID, PEJABAT_PENETAP_ID, PEGAWAI_ID, PERIODE, TMT_PENGHASILAN, JUMLAH_PENGHASILAN,
				NO_SK, TANGGAL_SK, MASA_KERJA_TAHUN, MASA_KERJA_BULAN,
				JUMLAH_TPP, JUMLAH_TUNJANGAN_JABATAN, JUMLAH_TUNJANGAN_SELISIH, JUMLAH_TRANSPORTASI, JUMLAH_UANG_MAKAN, JUMLAH_INSENTIF, JUMLAH_MOBILITAS,
				PROSENTASE_PENGHASILAN, PROSENTASE_TUNJANGAN_JABATAN, JUMLAH_UANG_KEHADIRAN, PROSENTASE_UANG_KEHADIRAN, PROSENTASE_TPP
				FROM PPI_SIMPEG.PEGAWAI_PENGHASILAN
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PEJABAT_PENETAP_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_PENGHASILAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_PENGHASILAN
		        WHERE PEGAWAI_PENGHASILAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_PENGHASILAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_PENGHASILAN
		        WHERE PEGAWAI_PENGHASILAN_ID IS NOT NULL ".$statement; 
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