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
  * Entity-base class untuk mengimplementasikan tabel KAPAL_JENIS.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiKapalHistori extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiKapalHistori()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_KAPAL_HISTORI_ID", $this->getNextId("PEGAWAI_KAPAL_HISTORI_ID","PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI (
				   PEGAWAI_KAPAL_HISTORI_ID, PEGAWAI_ID, KAPAL_ID, KRU_JABATAN_ID, TANGGAL_MASUK, TANGGAL_KELUAR, LAST_CREATE_USER, LAST_CREATE_DATE, VALIDASI_MASUK, VALIDASI_KELUAR) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_KAPAL_HISTORI_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("KRU_JABATAN_ID")."',
				  ".$this->getField("TANGGAL_MASUK").",
				  ".$this->getField("TANGGAL_KELUAR").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").", 0, 0
				)"; 
		//".$this->getField("TANGGAL_MASUK")."
		$this->id = $this->getField("PEGAWAI_KAPAL_HISTORI_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function insertByPegawaiKapal()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_KAPAL_HISTORI_ID", $this->getNextId("PEGAWAI_KAPAL_HISTORI_ID","PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI (
				   PEGAWAI_KAPAL_HISTORI_ID, PEGAWAI_ID, KAPAL_ID, KRU_JABATAN_ID, TANGGAL_MASUK, TANGGAL_KELUAR, LAST_CREATE_USER, LAST_CREATE_DATE, VALIDASI_MASUK, VALIDASI_KELUAR) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_KAPAL_HISTORI_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("KAPAL_ID")."',
				  (SELECT KRU_JABATAN_ID FROM PPI_OPERASIONAL.KAPAL_KRU WHERE KAPAL_KRU_ID = '".$this->getField("KAPAL_KRU_ID")."'),
				  ".$this->getField("TANGGAL_MASUK").",
				  ".$this->getField("TANGGAL_KELUAR").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").", 0, 0
				)"; 
		//".$this->getField("TANGGAL_MASUK")."
		$this->id = $this->getField("PEGAWAI_KAPAL_HISTORI_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
		
	function insertKadet()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_KAPAL_HISTORI_ID", $this->getNextId("PEGAWAI_KAPAL_HISTORI_ID","PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI (
				   PEGAWAI_KAPAL_HISTORI_ID, PEGAWAI_ID, KAPAL_ID, TANGGAL_MASUK, TANGGAL_KELUAR, LAST_CREATE_USER, LAST_CREATE_DATE, KADET_KAPAL_ID) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_KAPAL_HISTORI_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("KAPAL_ID")."',
				  ".$this->getField("TANGGAL_MASUK").",
				  ".$this->getField("TANGGAL_KELUAR").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  ".$this->getField("KADET_KAPAL_ID")."				  
				)"; 
		//".$this->getField("TANGGAL_MASUK")."
		$this->id = $this->getField("PEGAWAI_KAPAL_HISTORI_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }	
	

    function updatePerbaikan()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI
				SET    
					   KAPAL_ID			= ".$this->getField("KAPAL_ID").",
					   KRU_JABATAN_ID	= ".$this->getField("KRU_JABATAN_ID").",
					   TANGGAL_MASUK	= ".$this->getField("TANGGAL_MASUK").",
					   TANGGAL_KELUAR	= ".$this->getField("TANGGAL_KELUAR")."
				WHERE  PEGAWAI_KAPAL_HISTORI_ID = '".$this->getField("PEGAWAI_KAPAL_HISTORI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
		
    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI
				SET    
					   TANGGAL_MASUK	= ".$this->getField("TANGGAL_MASUK")."
				WHERE  PEGAWAI_KAPAL_HISTORI_ID = '".$this->getField("PEGAWAI_KAPAL_HISTORI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	

	function updateOffHireLast()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI
				SET    
					   TANGGAL_KELUAR	= ".$this->getField("TANGGAL_KELUAR_SEBELUM").",
					   VALIDASI_KELUAR = 0
				WHERE  PEGAWAI_KAPAL_HISTORI_ID = '".$this->getField("PEGAWAI_KAPAL_HISTORI_ID")."'

			 "; 
			 //echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateOnHireValidasi()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI
				SET    
					   TANGGAL_MASUK	= ".$this->getField("TANGGAL_MASUK").",
					   VALIDASI_MASUK = 1
				WHERE  PEGAWAI_KAPAL_HISTORI_ID = '".$this->getField("PEGAWAI_KAPAL_HISTORI_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	
	function updateOffHireLastValidasi()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI
				SET    
					   TANGGAL_KELUAR	= ".$this->getField("TANGGAL_KELUAR_SEBELUM").",
					   VALIDASI_KELUAR  = 1
				WHERE  PEGAWAI_KAPAL_HISTORI_ID = '".$this->getField("PEGAWAI_KAPAL_HISTORI_ID")."'

			 "; 
			 //echo $str;
		$this->query = $str;
		return $this->execQuery($str);
    }	
	
	function insert_kapal_histori_update_pegawai_kapal()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_KAPAL_HISTORI_ID", $this->getNextId("PEGAWAI_KAPAL_HISTORI_ID","PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI (
				   PEGAWAI_KAPAL_HISTORI_ID, PEGAWAI_ID, KAPAL_ID, KRU_JABATAN_ID, TANGGAL_MASUK, TANGGAL_KELUAR) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_KAPAL_HISTORI_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("KRU_JABATAN_ID")."',
				  ".$this->getField("TANGGAL_MASUK").",
				  ".$this->getField("TANGGAL_KELUAR")."
				)"; 
		//".$this->getField("TANGGAL_MASUK")."
		$this->id = $this->getField("PEGAWAI_KAPAL_HISTORI_ID");
		$this->query = $str;
		$this->execQuery($str);
		
		$str1 = "
				UPDATE PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI
				SET    
					   TANGGAL_KELUAR	= ".$this->getField("TANGGAL_KELUAR_SEBELUM")."
				WHERE  PEGAWAI_KAPAL_HISTORI_ID = '".$this->getField("PEGAWAI_KAPAL_HISTORI_ID_LAST")."'

			 "; 
		$this->query = $str1;
		return $this->execQuery($str1);
		
    }
	
	function update_dyna()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE ".$this->getField("TABLE")." SET
				  ".$this->getField("FIELD")." = ".$this->getField("FIELD_VALUE")."
				WHERE ".$this->getField("FIELD_ID")." = ".$this->getField("FIELD_ID_VALUE")."
				"; 
				$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI
                WHERE 
                  PEGAWAI_KAPAL_HISTORI_ID = ".$this->getField("PEGAWAI_KAPAL_HISTORI_ID").""; 
				  
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
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY PEGAWAI_KAPAL_HISTORI_ID ASC")
	{
		$str = "
				SELECT PEGAWAI_KAPAL_HISTORI_ID, A.PEGAWAI_ID, KAPAL_ID, TANGGAL_MASUK, B.NRP, B.NIPP, B.NAMA, C.NAMA JABATAN_NAMA
				FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI A
				LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID=B.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON B.PEGAWAI_ID = C.PEGAWAI_ID 
				WHERE PEGAWAI_KAPAL_HISTORI_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsHistoriTakSesuai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY D.NAMA ASC")
	{
		$str = "
				SELECT D.PEGAWAI_ID, D.NRP, D.NAMA, B.NAMA KAPAL, C.NAMA KRU_JABATAN, TANGGAL_MASUK, TANGGAL_KELUAR  FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI A
				INNER JOIN PPI_OPERASIONAL.KAPAL B ON A.KAPAL_ID = B.KAPAL_ID
				INNER JOIN PPI_OPERASIONAL.KRU_JABATAN C ON A.KRU_JABATAN_ID = C.KRU_JABATAN_ID
				INNER JOIN PPI_SIMPEG.PEGAWAI D ON A.PEGAWAI_ID = D.PEGAWAI_ID
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
    
	function selectByParamsHistoriTerakhir($paramsArray=array(),$limit=-1,$from=-1, $mil="0", $statement="", $order="ORDER BY A.KRU_JABATAN_ID ASC")
	{
		$str = "
				SELECT PEGAWAI_KAPAL_HISTORI_ID, A.PEGAWAI_ID, A.KAPAL_ID, A.TANGGAL_MASUK, B.NRP, B.NIPP, B.NAMA, A.JABATAN, A.KRU_JABATAN_ID,
                PPI_GAJI.HITUNG_MIL(".(int)$mil.", A.KRU_JABATAN_ID, C.KAPAL_JENIS_ID) JUMLAH_MIL
                FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR A
                LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID=B.PEGAWAI_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL C ON A.KAPAL_ID = C.KAPAL_ID
                WHERE PEGAWAI_KAPAL_HISTORI_ID IS NOT NULL

				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = $val ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
			
		return $this->selectLimit($str,$limit,$from); 
    }
    

	
	function selectByParamsRiwayatPegawaiKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY TANGGAL_MASUK DESC")
	{
		$str = "
				SELECT PEGAWAI_KAPAL_HISTORI_ID, A.KRU_JABATAN_ID, A.PEGAWAI_ID, A.KAPAL_ID, A.TANGGAL_MASUK, A.TANGGAL_KELUAR, B.NRP, B.NIPP, B.NAMA, C.NAMA KAPAL_NAMA, C.KODE, D.NAMA KRU_JABATAN_NAMA, E.NAMA KAPAL_JENIS_NAMA 
				FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI A
				LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID=B.PEGAWAI_ID
				LEFT JOIN PPI_OPERASIONAL.KAPAL C ON A.KAPAL_ID=C.KAPAL_ID
				LEFT JOIN PPI_OPERASIONAL.KRU_JABATAN D ON A.KRU_JABATAN_ID=D.KRU_JABATAN_ID
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS E ON C.KAPAL_JENIS_ID=E.KAPAL_JENIS_ID
				WHERE PEGAWAI_KAPAL_HISTORI_ID IS NOT NULL
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
				SELECT PEGAWAI_KAPAL_HISTORI_ID, PEGAWAI_ID, KAPAL_ID, TANGGAL_MASUK
				FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI A					
				WHERE PEGAWAI_KAPAL_HISTORI_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PEGAWAI_KAPAL_HISTORI_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_KAPAL_HISTORI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI
		        WHERE PEGAWAI_KAPAL_HISTORI_ID IS NOT NULL ".$statement; 
		
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
	
    function getCountByParamsHistoriTakSesuai($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.PEGAWAI_KAPAL_HISTORI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI A
				INNER JOIN PPI_OPERASIONAL.KAPAL B ON A.KAPAL_ID = B.KAPAL_ID
				INNER JOIN PPI_OPERASIONAL.KRU_JABATAN C ON A.KRU_JABATAN_ID = C.KRU_JABATAN_ID
				INNER JOIN PPI_SIMPEG.PEGAWAI D ON A.PEGAWAI_ID = D.PEGAWAI_ID
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
		
    function getCountByParamsPencarianAwakKapal($paramsArray=array(), $statement="",$statementKelompok="")
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT
				FROM PPI_SIMPEG.PEGAWAI A 
				INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID ".$statementKelompok."
				LEFT JOIN PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID WHERE 1 = 1 ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_KAPAL_HISTORI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI
		        WHERE PEGAWAI_KAPAL_HISTORI_ID IS NOT NULL ".$statement; 
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