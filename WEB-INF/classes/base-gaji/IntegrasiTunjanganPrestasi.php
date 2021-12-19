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

  class IntegrasiTunjanganPrestasi extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function IntegrasiTunjanganPrestasi()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		// $this->setField("TUNJANGAN_JABATAN_ID", $this->getNextId("TUNJANGAN_JABATAN_ID","PPI_GAJI.TUNJANGAN_JABATAN")); 
		$str = "
				INSERT INTO PPI_GAJI.INTEGRASI_TUNJANGAN_PRESTASI(
					   PEGAWAI_ID, PERIODE, JUMLAH_JAM_MENGAJAR, JUMLAH_JAM_LEBIH, TARIF_MENGAJAR, TARIF_LEBIH, 
					   LAST_CREATE_USER, LAST_CREATE_DATE) 
				VALUES(
					  '".$this->getField("PEGAWAI_ID")."',
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("JUMLAH_JAM_MENGAJAR")."',
					  '".$this->getField("JUMLAH_JAM_LEBIH")."',
					  '".$this->getField("TARIF_MENGAJAR")."',
					  '".$this->getField("TARIF_LEBIH")."',
					  '".$this->getField("LAST_CREATE_USER")."',
					  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		// $this->id = $this->getField("PPI_GAJI.TUNJANGAN_JABATAN");
		//echo $str;exit;
		$this->query = $str;
		return $this->execQuery($str);
    }

	function import()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		// $this->setField("TUNJANGAN_JABATAN_ID", $this->getNextId("TUNJANGAN_JABATAN_ID","PPI_GAJI.TUNJANGAN_JABATAN")); 
		$str = "
				INSERT INTO PPI_GAJI.INTEGRASI_TUNJANGAN_PRESTASI(
					   PEGAWAI_ID, PERIODE, JUMLAH_JAM_MENGAJAR,
					   JUMLAH_POTONGAN, LAST_CREATE_USER, LAST_CREATE_DATE) 
				VALUES(
					  '".$this->getField("PEGAWAI_ID")."',
					  '".$this->getField("PERIODE")."',
					  '".$this->getField("JUMLAH_JAM_MENGAJAR")."',
					  '".$this->getField("JUMLAH_POTONGAN")."',
					  '".$this->getField("LAST_CREATE_USER")."',
					  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		// $this->id = $this->getField("PPI_GAJI.TUNJANGAN_JABATAN");
		// echo $str;exit;
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.INTEGRASI_TUNJANGAN_PRESTASI
			   SET 
			   		PERIODE				= '".$this->getField("PERIODE")."',
			   		JUMLAH_JAM_MENGAJAR	= ".$this->getField("JUMLAH_JAM_MENGAJAR").",
				   	JUMLAH_JAM_LEBIH	= ".$this->getField("JUMLAH_JAM_LEBIH").",
			   		TARIF_MENGAJAR	= ".$this->getField("TARIF_MENGAJAR").",
			   		TARIF_LEBIH	= ".$this->getField("TARIF_LEBIH").",
				   	LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
				   	LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE").",
			 WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_GAJI.INTEGRASI_TUNJANGAN_PRESTASI
                WHERE 
                  PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."' AND
                  PERIODE = '".$this->getField("PERIODE")."' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function deletePeriode()
	{
        $str = "DELETE FROM PPI_GAJI.INTEGRASI_TUNJANGAN_PRESTASI
                WHERE 
                  PERIODE = '".$this->getField("PERIODE")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY B.PEGAWAI_ID ")
	{
		$str = "
			    SELECT A.PEGAWAI_ID, A.PERIODE, A.MIN_JAM_MENGAJAR, 
			    A.JUMLAH_JAM_MENGAJAR, A.JUMLAH_JAM_LEBIH, A.TARIF_MENGAJAR, 
			    A.TARIF_LEBIH, B.NAMA NAMA_PEGAWAI,
			    B.JENIS_PEGAWAI_ID, A.KELAS, A.JUMLAH_POTONGAN, PEMBAGI_POTONGAN, TUNJANGAN_PRESTASI 
			    FROM PPI_GAJI.INTEGRASI_TUNJANGAN_PRESTASI A 
				LEFT JOIN PPI_GAJI.PEGAWAI B ON A.PEGAWAI_ID=B.PEGAWAI_ID AND A.PERIODE = B.PERIODE
				WHERE 1=1   
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str; exit();
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsImport($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="ORDER BY A.PEGAWAI_ID, DEPARTEMEN_ID")
	{
		$str = "
			    SELECT A.PEGAWAI_ID, NAMA, JABATAN NAMA_JABATAN, KATEGORI_SEKOLAH, JUMLAH_JAM_MENGAJAR, JUMLAH_POTONGAN  FROM PPI_GAJI.PEGAWAI A
                LEFT JOIN PPI_GAJI.INTEGRASI_TUNJANGAN_PRESTASI E ON A.PEGAWAI_ID = E.PEGAWAI_ID AND A.PERIODE = E.PERIODE
				WHERE JENIS_PEGAWAI_ID <> '8'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."ORDER BY PEGAWAI_ID";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
			     SELECT A.PEGAWAI_ID, A.PERIODE, A.MIN_JAM_MENGAJAR, A.JUMLAH_JAM_MENGAJAR, A.JUMLAH_JAM_LEBIH, A.TARIF_MENGAJAR, A.TARIF_LEBIH,  A.LAST_CREATE_USER, A.LAST_CREATE_DATE, A.LAST_UPDATE_USER, A.LAST_UPDATE_DATE
                	FROM PPI_GAJI.INTEGRASI_TUNJANGAN_PRESTASI A         
                WHERE 1=1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY PEGAWAI_ID DESC";
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
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT 
		FROM PPI_GAJI.INTEGRASI_TUNJANGAN_PRESTASI A
		LEFT JOIN PPI_GAJI.PEGAWAI B ON A.PEGAWAI_ID=B.PEGAWAI_ID AND A.PERIODE = B.PERIODE
		WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		// echo $str; exit();
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(PEGAWAI_ID) AS ROWCOUNT FROM PPI_GAJI.INTEGRASI_TUNJANGAN_PRESTASI WHERE 1 = 1 "; 
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