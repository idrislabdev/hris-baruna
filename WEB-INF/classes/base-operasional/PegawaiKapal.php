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

  class PegawaiKapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_KAPAL_ID", $this->getNextId("PEGAWAI_KAPAL_ID","PPI_OPERASIONAL.PEGAWAI_KAPAL"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.PEGAWAI_KAPAL (
				   PEGAWAI_KAPAL_ID, PEGAWAI_ID, KAPAL_ID, TANGGAL_MASUK, KAPAL_KRU_ID, LAST_CREATE_USER, LAST_CREATE_DATE)  
 			  	VALUES (
				  ".$this->getField("PEGAWAI_KAPAL_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("KAPAL_ID")."',
				  SYSDATE,
				  '".$this->getField("KAPAL_KRU_ID")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		//".$this->getField("TANGGAL_MASUK")."
		$this->id = $this->getField("PEGAWAI_KAPAL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function insert_mutasi()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_KAPAL_ID", $this->getNextId("PEGAWAI_KAPAL_ID","PPI_OPERASIONAL.PEGAWAI_KAPAL"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.PEGAWAI_KAPAL (
				   PEGAWAI_KAPAL_ID, PEGAWAI_ID, KAPAL_ID, 
				   TANGGAL_MASUK) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_KAPAL_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("KAPAL_ID")."',
				  SYSDATE
				)"; 
		$this->id = $this->getField("PEGAWAI_KAPAL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.PEGAWAI_KAPAL
				SET    
					   PEGAWAI_ID       = '".$this->getField("PEGAWAI_ID")."',
					   KAPAL_ID	 		= '".$this->getField("KAPAL_ID")."',
					   TANGGAL_MASUK	= ".$this->getField("TANGGAL_MASUK").",
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PEGAWAI_KAPAL_ID = '".$this->getField("PEGAWAI_KAPAL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function update_mutasi()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.PEGAWAI_KAPAL
				SET    
					   PEGAWAI_ID       = '".$this->getField("PEGAWAI_ID")."',
					   KAPAL_ID	 		= '".$this->getField("KAPAL_ID")."',
					   TANGGAL_MASUK	= SYSDATE
				WHERE  PEGAWAI_KAPAL_ID = '".$this->getField("PEGAWAI_KAPAL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function updateKeluar()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.PEGAWAI_KAPAL
				SET    
					   KAPAL_ID         = '".$this->getField("KAPAL_ID")."',
					   TANGGAL_KELUAR	= ".$this->getField("TANGGAL_KELUAR")."
				WHERE  PEGAWAI_KAPAL_ID = '".$this->getField("PEGAWAI_KAPAL_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function updateKeluarByParam()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.PEGAWAI_KAPAL
				SET    
					   KAPAL_ID         = '".$this->getField("KAPAL_ID")."',
					   TANGGAL_KELUAR	= ".$this->getField("TANGGAL_KELUAR")."
				WHERE  PEGAWAI_KAPAL_ID = (SELECT PEGAWAI_KAPAL_ID FROM PPI_OPERASIONAL.PEGAWAI_KAPAL WHERE KAPAL_ID = '".$this->getField("KAPAL_ID")."' AND PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."')
			 "; 
		$this->execQuery($str);
		 	 
		$str = "DELETE FROM PPI_OPERASIONAL.PEGAWAI_KAPAL
				WHERE  PEGAWAI_KAPAL_ID = (SELECT PEGAWAI_KAPAL_ID FROM PPI_OPERASIONAL.PEGAWAI_KAPAL WHERE KAPAL_ID = '".$this->getField("KAPAL_ID")."' AND PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."')
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
			
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.PEGAWAI_KAPAL
                WHERE 
                  PEGAWAI_KAPAL_ID = ".$this->getField("PEGAWAI_KAPAL_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function delete_pegawai_kapal()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.PEGAWAI_KAPAL
                WHERE 
                  KAPAL_ID = ".$this->getField("KAPAL_ID").""; 
				  
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
	
	function selectByParamsPegawaiKapalSertifikat($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.NAMA ASC")
	{
		$str = "
				SELECT 
				A.NAMA, A.PEGAWAI_ID, C.NAMA JABATAN_NAMA, C.KELOMPOK
			   FROM PPI_SIMPEG.PEGAWAI A
			   LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID=C.PEGAWAI_ID
			   LEFT JOIN PPI_SIMPEG.JABATAN D ON C.JABATAN_ID=D.JABATAN_ID
			   WHERE 1 = 1
				"; 
		/*SELECT 
					A.NAMA, A.PEGAWAI_ID, C.NAMA JABATAN_NAMA, C.KELOMPOK
				FROM PPI_SIMPEG.PEGAWAI A
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID=C.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.JABATAN D ON C.JABATAN_ID=D.JABATAN_ID
				LEFT JOIN PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL D ON D.PEGAWAI_ID=A.PEGAWAI_ID
				WHERE 1=1*/
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsPencarianAwakKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $statementKelompok="", $order="ORDER BY JABATAN_ID ASC")
	{
		$str = "
			    SELECT A.PEGAWAI_ID, A.NRP, A.NAMA, B.KELAS, B.NAMA JABATAN, PPI_OPERASIONAL.AMBIL_PEGAWAI_SERTIFIKAT_ID(A.PEGAWAI_ID) SERTIFIKAT, KAPAL, TANGGAL_MASUK, C.JABATAN POSISI, C.KAPAL_ID, C.KRU_JABATAN_ID
                FROM PPI_SIMPEG.PEGAWAI A 
                LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID 
                LEFT JOIN PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID           
                WHERE 1 = 1 AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5)
				".$statementKelompok; 
		
                
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		//echo $str;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsPencarianGalanganAwakKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $statementKelompok="", $order="ORDER BY A.NAMA ASC")
	{
		$str = "
				SELECT A.PEGAWAI_ID, A.NAMA, PPI_OPERASIONAL.AMBIL_PEGAWAI_SERTIFIKAT_ID(A.PEGAWAI_ID) SERTIFIKAT
				FROM PPI_SIMPEG.PEGAWAI A 
				WHERE 1 = 1
				".$statementKelompok; 
		
                
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		//echo $str;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY PEGAWAI_KAPAL_ID ASC")
	{
		$str = "
				SELECT PEGAWAI_KAPAL_ID, A.PEGAWAI_ID, KAPAL_ID, TANGGAL_MASUK, B.NRP, B.NIPP, B.NAMA, C.NAMA JABATAN_NAMA
				FROM PPI_OPERASIONAL.PEGAWAI_KAPAL A
				LEFT JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID=B.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON B.PEGAWAI_ID = C.PEGAWAI_ID 
				WHERE PEGAWAI_KAPAL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPosisiTerakhir($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY K.KAPAL_ID,  B.KRU_JABATAN_ID ASC")
	{
		$str = "
				SELECT PEGAWAI_KAPAL_ID, K.KAPAL_ID, A.KAPAL_KRU_ID, B.KRU_JABATAN_ID, K.NAMA KAPAL, B.NAMA JABATAN, D.NAMA NAMA, D.PEGAWAI_ID 
				FROM PPI_OPERASIONAL.KAPAL K
				INNER JOIN PPI_OPERASIONAL.KAPAL_KRU A ON A.KAPAL_ID = K.KAPAL_ID
				INNER JOIN PPI_OPERASIONAL.KRU_JABATAN B ON A.KRU_JABATAN_ID = B.KRU_JABATAN_ID
				LEFT JOIN PPI_OPERASIONAL.PEGAWAI_KAPAL C ON A.KAPAL_KRU_ID = C.KAPAL_KRU_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI D ON C.PEGAWAI_ID = D.PEGAWAI_ID 
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
	    

	function selectByParamsRiwayatKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY TANGGAL_MASUK ASC")
	{
		$str = "
				SELECT B.KODE, B.NAMA, C.NAMA KAPAL_JENIS_NAMA, PEGAWAI_KAPAL_ID, A.PEGAWAI_ID, A.KAPAL_ID, TANGGAL_MASUK, TANGGAL_KELUAR, A.KRU_JABATAN_ID, D.NAMA KRU_JABATAN_NAMA
				FROM PPI_OPERASIONAL.PEGAWAI_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL B ON A.KAPAL_ID=B.KAPAL_ID
				LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS C ON B.KAPAL_JENIS_ID=C.KAPAL_JENIS_ID
				LEFT JOIN PPI_OPERASIONAL.KRU_JABATAN D ON A.KRU_JABATAN_ID=D.KRU_JABATAN_ID 
				WHERE PEGAWAI_KAPAL_ID IS NOT NULL
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
				SELECT PEGAWAI_KAPAL_ID, PEGAWAI_ID, KAPAL_ID, TANGGAL_MASUK
				FROM PPI_OPERASIONAL.PEGAWAI_KAPAL A					
				WHERE PEGAWAI_KAPAL_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PEGAWAI_KAPAL_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
	
	function getCountByPosisiTerakhir($paramsArray=array(), $statement="")
	{
		$str = "
				SELECT 
				COUNT(1) AS ROWCOUNT
			   FROM PPI_OPERASIONAL.KAPAL K
				INNER JOIN PPI_OPERASIONAL.KAPAL_KRU A ON A.KAPAL_ID = K.KAPAL_ID
				INNER JOIN PPI_OPERASIONAL.KRU_JABATAN B ON A.KRU_JABATAN_ID = B.KRU_JABATAN_ID
				LEFT JOIN PPI_OPERASIONAL.PEGAWAI_KAPAL C ON A.KAPAL_KRU_ID = C.KAPAL_KRU_ID
				LEFT JOIN PPI_SIMPEG.PEGAWAI D ON C.PEGAWAI_ID = D.PEGAWAI_ID 
				WHERE 1 = 1
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
					
	function getCountByPegawaiKapalSertifikat($paramsArray=array(), $statement="")
	{
		$str = "
				SELECT 
				COUNT(A.PEGAWAI_ID) AS ROWCOUNT
			   FROM PPI_SIMPEG.PEGAWAI A
			   LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID=C.PEGAWAI_ID
			   LEFT JOIN PPI_SIMPEG.JABATAN D ON C.JABATAN_ID=D.JABATAN_ID
			   WHERE 1 = 1
				".$statement; 
		/*SELECT 
					COUNT(A.PEGAWAI_ID) AS ROWCOUNT
				FROM PPI_SIMPEG.PEGAWAI A
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID=C.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.JABATAN D ON C.JABATAN_ID=D.JABATAN_ID
				LEFT JOIN PPI_OPERASIONAL.PEGAWAI_SERTIFIKAT_AWAK_KPL D ON D.PEGAWAI_ID=A.PEGAWAI_ID 
				WHERE 1=1*/
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
				
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.PEGAWAI_KAPAL
		        WHERE PEGAWAI_KAPAL_ID IS NOT NULL ".$statement; 
		
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
	
	function getCountByParamsPencarianGalanganAwakKapal($paramsArray=array(), $statement="",$statementKelompok="")
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT
				FROM PPI_SIMPEG.PEGAWAI A 
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
				LEFT JOIN PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID WHERE 1 = 1  AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.PEGAWAI_KAPAL
		        WHERE PEGAWAI_KAPAL_ID IS NOT NULL ".$statement; 
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