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
  * Entity-base class untuk mengimplementasikan tabel KRU_JABATAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class SuratPerintahPegawai extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SuratPerintahPegawai()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURAT_PERINTAH_PEGAWAI_ID", $this->getNextId("SURAT_PERINTAH_PEGAWAI_ID","PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI"));

		$str = "
						INSERT INTO PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI (
				   SURAT_PERINTAH_PEGAWAI_ID, KONTRAK_SBPP_ID, NRP, 
				   NAMA, KELAS, JABATAN_AWAL, 
				   KAPAL_AWAL, JABATAN_AKHIR, KAPAL_AKHIR, 
				   STATUS_MASUK, STATUS_SP, KAPAL_ID_AWAL, KRU_JABATAN_ID_AWAL, KAPAL_ID_TERAKHIR, 
   				   KRU_JABATAN_ID_TERAKHIR, PEGAWAI_ID) 
				VALUES (".$this->getField("SURAT_PERINTAH_PEGAWAI_ID").", ".$this->getField("KONTRAK_SBPP_ID").", '".$this->getField("NRP")."', 
				   '".$this->getField("NAMA")."', '".$this->getField("KELAS")."', (SELECT NAMA FROM PPI_OPERASIONAL.KRU_JABATAN WHERE KRU_JABATAN_ID = '".$this->getField("JABATAN_AWAL")."'), 
				   (SELECT NAMA FROM PPI_OPERASIONAL.KAPAL WHERE KAPAL_ID = '".$this->getField("KAPAL_AWAL")."'), '".$this->getField("JABATAN_AKHIR")."', '".$this->getField("KAPAL_AKHIR")."', 
				   '".$this->getField("STATUS_MASUK")."', '".$this->getField("STATUS_SP")."', '".$this->getField("KAPAL_ID_AWAL")."', '".$this->getField("KRU_JABATAN_ID_AWAL")."', 
				   '".$this->getField("KAPAL_ID_TERAKHIR")."', '".$this->getField("KRU_JABATAN_ID_TERAKHIR")."', (SELECT PEGAWAI_ID FROM PPI_SIMPEG.PEGAWAI WHERE NRP = '".$this->getField("NRP")."'))"; 
		$this->id=$this->getField("SURAT_PERINTAH_PEGAWAI_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function insertUsulan()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURAT_PERINTAH_PEGAWAI_ID", $this->getNextId("SURAT_PERINTAH_PEGAWAI_ID","PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI"));

		$str = "
						INSERT INTO PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI (
				   SURAT_PERINTAH_PEGAWAI_ID, KONTRAK_SBPP_ID, NRP, 
				   NAMA, KELAS, JABATAN_AWAL, 
				   KAPAL_AWAL, JABATAN_AKHIR, KAPAL_AKHIR, 
				   STATUS_MASUK, STATUS_SP, KAPAL_ID_AWAL, KRU_JABATAN_ID_AWAL, KAPAL_ID_TERAKHIR, 
   				   KRU_JABATAN_ID_TERAKHIR, PEGAWAI_ID, KAPAL_KRU_ID, TANGGAL_MASUK) 
				VALUES (".$this->getField("SURAT_PERINTAH_PEGAWAI_ID").", ".$this->getField("KONTRAK_SBPP_ID").", '".$this->getField("NRP")."', 
				   '".$this->getField("NAMA")."', '".$this->getField("KELAS")."', '".$this->getField("JABATAN_AWAL")."', 
				   '".$this->getField("KAPAL_AWAL")."', '".$this->getField("JABATAN_AKHIR")."', '".$this->getField("KAPAL_AKHIR")."', 
				   '".$this->getField("STATUS_MASUK")."', '".$this->getField("STATUS_SP")."', '".$this->getField("KAPAL_ID_AWAL")."', '".$this->getField("KRU_JABATAN_ID_AWAL")."', 
				   '".$this->getField("KAPAL_ID_TERAKHIR")."', '".$this->getField("KRU_JABATAN_ID_TERAKHIR")."', (SELECT PEGAWAI_ID FROM PPI_SIMPEG.PEGAWAI WHERE NRP = '".$this->getField("NRP")."'),
				   '".$this->getField("KAPAL_KRU_ID")."', ".$this->getField("TANGGAL_MASUK").")"; 
		$this->id=$this->getField("SURAT_PERINTAH_PEGAWAI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
		
	function insertKapalPekerjaan()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURAT_PERINTAH_PEGAWAI_ID", $this->getNextId("SURAT_PERINTAH_PEGAWAI_ID","PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI"));

		$str = "
						INSERT INTO PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI (
				   SURAT_PERINTAH_PEGAWAI_ID, KAPAL_PEKERJAAN_ID, NRP, 
				   NAMA, KELAS, JABATAN_AWAL, 
				   KAPAL_AWAL, JABATAN_AKHIR, KAPAL_AKHIR, 
				   STATUS_MASUK, STATUS_SP, KAPAL_ID_AWAL, KRU_JABATAN_ID_AWAL, KAPAL_ID_TERAKHIR, 
   				   KRU_JABATAN_ID_TERAKHIR, PEGAWAI_ID)  
				VALUES (".$this->getField("SURAT_PERINTAH_PEGAWAI_ID").", ".$this->getField("KAPAL_PEKERJAAN_ID").", '".$this->getField("NRP")."', 
				   '".$this->getField("NAMA")."', '".$this->getField("KELAS")."', (SELECT NAMA FROM PPI_OPERASIONAL.KRU_JABATAN WHERE KRU_JABATAN_ID = '".$this->getField("JABATAN_AWAL")."'), 
				   (SELECT NAMA FROM PPI_OPERASIONAL.KAPAL WHERE KAPAL_ID = '".$this->getField("KAPAL_AWAL")."'), '".$this->getField("JABATAN_AKHIR")."', '".$this->getField("KAPAL_AKHIR")."', 
				   '".$this->getField("STATUS_MASUK")."', '".$this->getField("STATUS_SP")."', '".$this->getField("KAPAL_ID_AWAL")."', '".$this->getField("KRU_JABATAN_ID_AWAL")."', 
				   '".$this->getField("KAPAL_ID_TERAKHIR")."', '".$this->getField("KRU_JABATAN_ID_TERAKHIR")."', (SELECT PEGAWAI_ID FROM PPI_SIMPEG.PEGAWAI WHERE NRP = '".$this->getField("NRP")."'))"; 
		$this->id=$this->getField("SURAT_PERINTAH_PEGAWAI_ID");
		$this->query = $str;
		
		return $this->execQuery($str);
    }
	
	function insertKapalPenugasan()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURAT_PERINTAH_PEGAWAI_ID", $this->getNextId("SURAT_PERINTAH_PEGAWAI_ID","PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI"));

		$str = "
						INSERT INTO PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI (
				   SURAT_PERINTAH_PEGAWAI_ID, PENUGASAN_ID, NRP, 
				   NAMA, KELAS, JABATAN_AWAL, 
				   KAPAL_AWAL, JABATAN_AKHIR, KAPAL_AKHIR, 
				   STATUS_MASUK, STATUS_SP, KAPAL_ID_AWAL, KRU_JABATAN_ID_AWAL, KAPAL_ID_TERAKHIR, 
   				   KRU_JABATAN_ID_TERAKHIR, PEGAWAI_ID)  
				VALUES (".$this->getField("SURAT_PERINTAH_PEGAWAI_ID").", ".$this->getField("PENUGASAN_ID").", '".$this->getField("NRP")."', 
				   '".$this->getField("NAMA")."', '".$this->getField("KELAS")."', (SELECT NAMA FROM PPI_OPERASIONAL.KRU_JABATAN WHERE KRU_JABATAN_ID = '".$this->getField("JABATAN_AWAL")."'), 
				   (SELECT NAMA FROM PPI_OPERASIONAL.KAPAL WHERE KAPAL_ID = '".$this->getField("KAPAL_AWAL")."'), '".$this->getField("JABATAN_AKHIR")."', '".$this->getField("KAPAL_AKHIR")."', 
				   '".$this->getField("STATUS_MASUK")."', '".$this->getField("STATUS_SP")."', '".$this->getField("KAPAL_ID_AWAL")."', '".$this->getField("KRU_JABATAN_ID_AWAL")."', 
				   '".$this->getField("KAPAL_ID_TERAKHIR")."', '".$this->getField("KRU_JABATAN_ID_TERAKHIR")."', (SELECT PEGAWAI_ID FROM PPI_SIMPEG.PEGAWAI WHERE NRP = '".$this->getField("NRP")."'))"; 
		$this->id=$this->getField("SURAT_PERINTAH_PEGAWAI_ID");
		$this->query = $str;
		
		return $this->execQuery($str);
    }
	
	function insertKapalKontrakTowing()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SURAT_PERINTAH_PEGAWAI_ID", $this->getNextId("SURAT_PERINTAH_PEGAWAI_ID","PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI"));

		$str = "
						INSERT INTO PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI (
				   SURAT_PERINTAH_PEGAWAI_ID, KONTRAK_TOWING_ID, NRP, 
				   NAMA, KELAS, JABATAN_AWAL, 
				   KAPAL_AWAL, JABATAN_AKHIR, KAPAL_AKHIR, 
				   STATUS_MASUK, STATUS_SP, KAPAL_ID_AWAL, KRU_JABATAN_ID_AWAL, KAPAL_ID_TERAKHIR, 
   				   KRU_JABATAN_ID_TERAKHIR, PEGAWAI_ID)  
				VALUES (".$this->getField("SURAT_PERINTAH_PEGAWAI_ID").", ".$this->getField("KONTRAK_TOWING_ID").", '".$this->getField("NRP")."', 
				   '".$this->getField("NAMA")."', '".$this->getField("KELAS")."', (SELECT NAMA FROM PPI_OPERASIONAL.KRU_JABATAN WHERE KRU_JABATAN_ID = '".$this->getField("JABATAN_AWAL")."'), 
				   (SELECT NAMA FROM PPI_OPERASIONAL.KAPAL WHERE KAPAL_ID = '".$this->getField("KAPAL_AWAL")."'), '".$this->getField("JABATAN_AKHIR")."', '".$this->getField("KAPAL_AKHIR")."', 
				   '".$this->getField("STATUS_MASUK")."', '".$this->getField("STATUS_SP")."', '".$this->getField("KAPAL_ID_AWAL")."', '".$this->getField("KRU_JABATAN_ID_AWAL")."', 
				   '".$this->getField("KAPAL_ID_TERAKHIR")."', '".$this->getField("KRU_JABATAN_ID_TERAKHIR")."', (SELECT PEGAWAI_ID FROM PPI_SIMPEG.PEGAWAI WHERE NRP = '".$this->getField("NRP")."'))"; 
		$this->id=$this->getField("SURAT_PERINTAH_PEGAWAI_ID");
		$this->query = $str;
		echo $str;
		
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI
				SET    
					   JABATAN_AKHIR			= '".$this->getField("JABATAN_AKHIR")."',
					   KAPAL_AKHIR	 		= '".$this->getField("KAPAL_AKHIR")."'
				WHERE  SURAT_PERINTAH_PEGAWAI_ID  	= '".$this->getField("SURAT_PERINTAH_PEGAWAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateUsulan()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI
				SET    
					   JABATAN_AKHIR			= '".$this->getField("JABATAN_AKHIR")."',
					   KAPAL_AKHIR	 		= '".$this->getField("KAPAL_AKHIR")."',
					   KAPAL_ID_TERAKHIR = '".$this->getField("KAPAL_ID_TERAKHIR")."',
					   KRU_JABATAN_ID_TERAKHIR ='".$this->getField("KRU_JABATAN_ID_TERAKHIR")."',
					   KAPAL_KRU_ID = '".$this->getField("KAPAL_KRU_ID")."',
					   TANGGAL_MASUK = ".$this->getField("TANGGAL_MASUK")."
				WHERE  SURAT_PERINTAH_PEGAWAI_ID  	= '".$this->getField("SURAT_PERINTAH_PEGAWAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateStatusSP()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI
				SET    
					   STATUS_SP			= '1'
				WHERE  SURAT_PERINTAH_PEGAWAI_ID  	= '".$this->getField("SURAT_PERINTAH_PEGAWAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateStatusValidasi()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI
				SET    
					   STATUS_VALIDASI			= '".$this->getField("STATUS_VALIDASI")."',
					   PEGAWAI_KAPAL_ID		    = '".$this->getField("PEGAWAI_KAPAL_ID")."'
				WHERE  SURAT_PERINTAH_PEGAWAI_ID  	= '".$this->getField("SURAT_PERINTAH_PEGAWAI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function deleteSPKeluar()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI
                WHERE 
                  NRP IN (".$this->getField("NRP").") AND KONTRAK_SBPP_ID = '".$this->getField("KONTRAK_SBPP_ID")."' AND STATUS_MASUK = 'K' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteSPKapal()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI
                WHERE 
                  NRP IN (".$this->getField("NRP").") AND (KONTRAK_SBPP_ID IS NULL AND KONTRAK_TOWING_ID IS NULL AND KAPAL_PEKERJAAN_ID IS NULL AND PENUGASAN_ID IS NULL) "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	

	function deleteSPKeluarKapalPekerjaan()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI
                WHERE 
                  NRP IN (".$this->getField("NRP").") AND KAPAL_PEKERJAAN_ID = '".$this->getField("KAPAL_PEKERJAAN_ID")."' AND STATUS_MASUK = 'K' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteSPKeluarPenugasan()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI
                WHERE 
                  NRP IN (".$this->getField("NRP").") AND PENUGASAN_ID = '".$this->getField("PENUGASAN_ID")."' AND STATUS_MASUK = 'K' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deleteSPKeluarKontrakTowing()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI
                WHERE 
                  NRP IN (".$this->getField("NRP").") AND KONTRAK_TOWING_ID = '".$this->getField("KONTRAK_TOWING_ID")."' AND STATUS_MASUK = 'K' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI
                WHERE 
                  SURAT_PERINTAH_PEGAWAI_ID = '".$this->getField("SURAT_PERINTAH_PEGAWAI_ID")."' "; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY SURAT_PERINTAH_PEGAWAI_ID ASC")
	{
		$str = "
				SELECT 
				SURAT_PERINTAH_PEGAWAI_ID, KONTRAK_SBPP_ID, NRP, 
				   NAMA, KELAS, JABATAN_AWAL, 
				   KAPAL_AWAL, CASE WHEN X.PEGAWAI_KAPAL_HISTORI_ID IS NULL THEN Z.PEGAWAI_KAPAL_HISTORI_ID ELSE X.PEGAWAI_KAPAL_HISTORI_ID END PEGAWAI_KAPAL_HISTORI_ID_OFF,
                   X.TANGGAL_KELUAR OFF_HIRE, 
                   JABATAN_AKHIR, KAPAL_AKHIR, 
                   Y.PEGAWAI_KAPAL_HISTORI_ID PEGAWAI_KAPAL_HISTORI_ID_ON,
                   Y.TANGGAL_MASUK ON_HIRE, 
				   STATUS_MASUK, STATUS_SP, A.TANGGAL_MASUK, KAPAL_KRU_ID, A.KRU_JABATAN_ID_TERAKHIR, STATUS_VALIDASI, A.PEGAWAI_ID, A.KAPAL_ID_AWAL
				FROM PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI A
                LEFT JOIN (SELECT PEGAWAI_KAPAL_HISTORI_ID, X.KAPAL_ID, X.PEGAWAI_ID, X.KRU_JABATAN_ID, MAX(TANGGAL_KELUAR) TANGGAL_KELUAR FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI X WHERE TANGGAL_KELUAR IS NOT NULL GROUP BY PEGAWAI_KAPAL_HISTORI_ID, X.KAPAL_ID, X.PEGAWAI_ID, X.KRU_JABATAN_ID) X ON   X.KAPAL_ID = A.KAPAL_ID_AWAL AND X.PEGAWAI_ID = A.PEGAWAI_ID AND X.KRU_JABATAN_ID = A.KRU_JABATAN_ID_AWAL 
                LEFT JOIN (SELECT PEGAWAI_KAPAL_HISTORI_ID, X.KAPAL_ID, X.PEGAWAI_ID, X.KRU_JABATAN_ID, MAX(TANGGAL_MASUK)  TANGGAL_MASUK  FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR X WHERE TANGGAL_KELUAR IS NULL GROUP BY PEGAWAI_KAPAL_HISTORI_ID, X.KAPAL_ID, X.PEGAWAI_ID, X.KRU_JABATAN_ID) Y ON  Y.KAPAL_ID = A.KAPAL_ID_TERAKHIR AND Y.PEGAWAI_ID = A.PEGAWAI_ID AND Y.KRU_JABATAN_ID = A.KRU_JABATAN_ID_TERAKHIR 
                LEFT JOIN PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR Z ON A.PEGAWAI_ID = Z.PEGAWAI_ID WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsSuratPerintah($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.SURAT_PERINTAH_PEGAWAI_ID ASC")
	{
		$str = "
				SELECT 
				A.SURAT_PERINTAH_PEGAWAI_ID, KONTRAK_SBPP_ID, NRP, 
				   NAMA, KELAS, JABATAN_AWAL, 
				   KAPAL_AWAL, CASE WHEN X.PEGAWAI_KAPAL_HISTORI_ID IS NULL THEN Z.PEGAWAI_KAPAL_HISTORI_ID ELSE X.PEGAWAI_KAPAL_HISTORI_ID END PEGAWAI_KAPAL_HISTORI_ID_OFF,
                   X.TANGGAL_KELUAR OFF_HIRE, 
                   JABATAN_AKHIR, KAPAL_AKHIR, 
                   Y.PEGAWAI_KAPAL_HISTORI_ID PEGAWAI_KAPAL_HISTORI_ID_ON,
                   Y.TANGGAL_MASUK ON_HIRE, 
				   STATUS_MASUK, STATUS_SP
				FROM PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI A
                LEFT JOIN (SELECT PEGAWAI_KAPAL_HISTORI_ID, X.KAPAL_ID, X.PEGAWAI_ID, X.KRU_JABATAN_ID, MAX(TANGGAL_KELUAR) TANGGAL_KELUAR FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI X WHERE TANGGAL_KELUAR IS NOT NULL GROUP BY PEGAWAI_KAPAL_HISTORI_ID, X.KAPAL_ID, X.PEGAWAI_ID, X.KRU_JABATAN_ID) X ON   X.KAPAL_ID = A.KAPAL_ID_AWAL AND X.PEGAWAI_ID = A.PEGAWAI_ID AND X.KRU_JABATAN_ID = A.KRU_JABATAN_ID_AWAL 
                LEFT JOIN (SELECT PEGAWAI_KAPAL_HISTORI_ID, X.KAPAL_ID, X.PEGAWAI_ID, X.KRU_JABATAN_ID, MAX(TANGGAL_MASUK)  TANGGAL_MASUK  FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR X WHERE TANGGAL_KELUAR IS NULL GROUP BY PEGAWAI_KAPAL_HISTORI_ID, X.KAPAL_ID, X.PEGAWAI_ID, X.KRU_JABATAN_ID) Y ON  Y.KAPAL_ID = A.KAPAL_ID_TERAKHIR AND Y.PEGAWAI_ID = A.PEGAWAI_ID AND Y.KRU_JABATAN_ID = A.KRU_JABATAN_ID_TERAKHIR 
                LEFT JOIN PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR Z ON A.PEGAWAI_ID = Z.PEGAWAI_ID 
                INNER JOIN PPI_OPERASIONAL.SURAT_PERINTAH_USULAN B ON A.SURAT_PERINTAH_PEGAWAI_ID = B.SURAT_PERINTAH_PEGAWAI_ID           
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
				SURAT_PERINTAH_PEGAWAI_ID, NO_SK, TMT_SK, 
				   TANGGAL_SK
				FROM PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI				
				WHERE SURAT_PERINTAH_PEGAWAI_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY SURAT_PERINTAH_PEGAWAI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SURAT_PERINTAH_PEGAWAI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI
		        WHERE SURAT_PERINTAH_PEGAWAI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(SURAT_PERINTAH_PEGAWAI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.SURAT_PERINTAH_PEGAWAI
		        WHERE SURAT_PERINTAH_PEGAWAI_ID IS NOT NULL ".$statement; 
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