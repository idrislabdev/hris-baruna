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
  * Entity-base class untuk mengimplementasikan tabel JENIS_PEGAWAI.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiPengalamanKerja extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiPengalamanKerja()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_PENGALAMAN_KERJA_ID", $this->getNextId("PEGAWAI_PENGALAMAN_KERJA_ID","PPI_SIMPEG.PEGAWAI_PENGALAMAN_KERJA"));

		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_PENGALAMAN_KERJA (
				   PEGAWAI_PENGALAMAN_KERJA_ID, PEGAWAI_ID, NAMA_PERUSAHAAN, JABATAN, MASUK_KERJA, KELUAR_KERJA, GAJI, FASILITAS, CREATED_DATE, CREATED_BY) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_PENGALAMAN_KERJA_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("NAMA_PERUSAHAAN")."',
				  '".$this->getField("JABATAN")."',
				  '".$this->getField("MASUK_KERJA")."',
				  '".$this->getField("KELUAR_KERJA")."',
				  '".$this->getField("GAJI")."',
				  '".$this->getField("FASILITAS")."',
				  SYSDATE,
				  '".$this->getField("CREATED_BY")."'
				)"; 
		$this->query = $str;
		//echo $str; exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_PENGALAMAN_KERJA
				SET    
					   NAMA_PERUSAHAAN           = '".$this->getField("NAMA_PERUSAHAAN")."',
					   JABATAN           = '".$this->getField("JABATAN")."',
					   MASUK_KERJA      = '".$this->getField("MASUK_KERJA")."',
					   KELUAR_KERJA      = '".$this->getField("KELUAR_KERJA")."',
					   GAJI      = '".$this->getField("GAJI")."',
					   FASILITAS      = '".$this->getField("FASILITAS")."', 
					   UPDATED_BY      = '".$this->getField("UPDATED_BY")."',
					   UPDATED_DATE = SYSDATE 
				WHERE  PEGAWAI_PENGALAMAN_KERJA_ID     = '".$this->getField("PEGAWAI_PENGALAMAN_KERJA_ID")."'

			 "; 
		$this->query = $str;
		//echo $str; exit;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_PENGALAMAN_KERJA
                WHERE 
                  PEGAWAI_PENGALAMAN_KERJA_ID = ".$this->getField("PEGAWAI_PENGALAMAN_KERJA_ID").""; 
				  
		$this->query = $str;
		//echo $str; exit;
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
				SELECT PEGAWAI_PENGALAMAN_KERJA_ID, PEGAWAI_ID, NAMA_PERUSAHAAN, JABATAN, 
				INITCAP(TO_CHAR(TO_DATE(MASUK_KERJA, 'MMYYYY'), 'MONTH YYYY', 'NLS_DATE_LANGUAGE = INDONESIAN' )) AS MASUK_KERJA_TEK, 
				INITCAP(TO_CHAR(TO_DATE(KELUAR_KERJA, 'MMYYYY'), 'MONTH YYYY', 'NLS_DATE_LANGUAGE = INDONESIAN' )) AS KELUAR_KERJA_TEK, 
				GAJI, FASILITAS, MASUK_KERJA, KELUAR_KERJA,
				CREATED_DATE, CREATED_BY, UPDATED_BY, UPDATED_DATE 
				FROM PPI_SIMPEG.PEGAWAI_PENGALAMAN_KERJA
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY PEGAWAI_PENGALAMAN_KERJA_ID ASC";

		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	 
  } 
?>