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
  * Entity-base class untuk mengimplementasikan tabel PEGAWAI_JABATAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PegawaiJabatan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PegawaiJabatan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEGAWAI_JABATAN_ID", $this->getNextId("PEGAWAI_JABATAN_ID","PPI_SIMPEG.PEGAWAI_JABATAN"));
		if ($this->getField("KONDISI_JABATAN") == null) {
		$kondisi = 0;	
		} else {
		$kondisi = $this->getField("KONDISI_JABATAN");
		}
		$str = "
				INSERT INTO PPI_SIMPEG.PEGAWAI_JABATAN (
				   PEGAWAI_JABATAN_ID, NAMA, PEGAWAI_ID, DEPARTEMEN_ID, CABANG_ID, JABATAN_ID, 
				   PEJABAT_PENETAP_ID, NO_SK, TANGGAL_SK, 
   				   TMT_JABATAN, KETERANGAN, LAST_CREATE_USER, LAST_CREATE_DATE, KONDISI_JABATAN
				   ) 
 			  	VALUES (
				  ".$this->getField("PEGAWAI_JABATAN_ID").",
				  (SELECT NAMA FROM PPI_SIMPEG.JABATAN WHERE JABATAN_ID = '".$this->getField("JABATAN_ID")."'),
				  '".$this->getField("PEGAWAI_ID")."',
				  '".$this->getField("DEPARTEMEN_ID")."',
				  '".$this->getField("CABANG_ID")."',
				  '".$this->getField("JABATAN_ID")."',
				  '".$this->getField("PEJABAT_PENETAP_ID")."',
				  '".$this->getField("NO_SK")."',
				  ".$this->getField("TANGGAL_SK").",
				  ".$this->getField("TMT_JABATAN").",
				  '".$this->getField("KETERANGAN")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  ".$kondisi."
				)"; 
		$this->id = $this->getField("PEGAWAI_JABATAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		if ($this->getField("KONDISI_JABATAN") == null) {
		$kondisi = 0;	
		} else {
		$kondisi = $this->getField("KONDISI_JABATAN");
		}
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_JABATAN
				SET    
					   NAMA           		= (SELECT NAMA FROM PPI_SIMPEG.JABATAN WHERE JABATAN_ID = '".$this->getField("JABATAN_ID")."'),
					   PEGAWAI_ID      		= '".$this->getField("PEGAWAI_ID")."',
					   DEPARTEMEN_ID    	= '".$this->getField("DEPARTEMEN_ID")."',
					   CABANG_ID         	= '".$this->getField("CABANG_ID")."',
					   JABATAN_ID			= '".$this->getField("JABATAN_ID")."',
					   PEJABAT_PENETAP_ID	= '".$this->getField("PEJABAT_PENETAP_ID")."',
					   NO_SK				= '".$this->getField("NO_SK")."',
					   TANGGAL_SK			= ".$this->getField("TANGGAL_SK").",
					   TMT_JABATAN			= ".$this->getField("TMT_JABATAN").",
					   KETERANGAN			= '".$this->getField("KETERANGAN")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE").",
					   KONDISI_JABATAN		= ".$kondisi."
				WHERE  PEGAWAI_JABATAN_ID   = '".$this->getField("PEGAWAI_JABATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateTools()
	{
		$str = "
				UPDATE PPI_SIMPEG.PEGAWAI_JABATAN
				SET    
					   DEPARTEMEN_ID    	= '".$this->getField("DEPARTEMEN_ID")."',
					   TMT_JABATAN			= ".$this->getField("TMT_JABATAN")."
				WHERE  PEGAWAI_JABATAN_ID   = '".$this->getField("PEGAWAI_JABATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_SIMPEG.PEGAWAI_JABATAN
                WHERE 
                  PEGAWAI_JABATAN_ID = ".$this->getField("PEGAWAI_JABATAN_ID").""; 
				  
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
					B.KELAS, PEGAWAI_JABATAN_ID, A.NAMA, PEGAWAI_ID, A.DEPARTEMEN_ID, A.CABANG_ID, A.JABATAN_ID, A.PEJABAT_PENETAP_ID,
					NO_SK, TANGGAL_SK, TMT_JABATAN, A.KETERANGAN,
					B.NAMA JABATAN_NAMA, C.NAMA CABANG_NAMA, D.NAMA DEPARTEMEN_NAMA, E.NAMA PEJABAT_PENETAP_NAMA, A.KONDISI_JABATAN
				FROM PPI_SIMPEG.PEGAWAI_JABATAN A
				LEFT JOIN PPI_SIMPEG.JABATAN B ON A.JABATAN_ID=B.JABATAN_ID
				LEFT JOIN PPI_SIMPEG.CABANG C ON A.CABANG_ID=C.CABANG_ID
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN D ON A.DEPARTEMEN_ID=D.DEPARTEMEN_ID
				LEFT JOIN PPI_SIMPEG.PEJABAT_PENETAP E ON A.PEJABAT_PENETAP_ID=E.PEJABAT_PENETAP_ID
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TMT_JABATAN DESC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsTools($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT A.NRP, A.PEGAWAI_ID, B.PEGAWAI_JABATAN_ID, A.NAMA, B.DEPARTEMEN_ID, TMT_JABATAN, CASE WHEN B.DEPARTEMEN_ID IS NOT NULL THEN PPI_SIMPEG.AMBIL_UNIT_KERJA(B.DEPARTEMEN_ID) END NAMA_DEPARTEMEN
				  FROM PPI_SIMPEG.PEGAWAI A INNER JOIN PPI_SIMPEG.PEGAWAI_JABATAN B
					   ON A.PEGAWAI_ID = B.PEGAWAI_ID
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.NAMA ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsToolsJabatanTerakhir($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT A.PEGAWAI_JABATAN_ID, A.PEGAWAI_ID FROM PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR A
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY A.PEGAWAI_JABATAN_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }		
		
	function selectByParamsPegawaiJabatanOperasional($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
               SELECT 
				A.NAMA, A.PEGAWAI_ID, C.NAMA JABATAN_NAMA, C.KELOMPOK
			   FROM PPI_SIMPEG.PEGAWAI A
			   LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID=C.PEGAWAI_ID
			   LEFT JOIN PPI_SIMPEG.JABATAN D ON C.JABATAN_ID=D.JABATAN_ID
			   WHERE 1 = 1
				"; 
		//LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN B ON A.PEGAWAI_ID=B.PEGAWAI_ID
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
		   
	function selectByParamsJabatanTerakhir($paramsArray=array(),$limit=-1,$from=-1, $statement="", $jumlah_penghasilan="0", $periode="0")
	{
		$str = "
                SELECT 
                PEGAWAI_JABATAN_ID, A.PEGAWAI_ID, JABATAN_ID, 
                   PEJABAT_PENETAP_ID, CABANG_ID, DEPARTEMEN_ID, 
                   NO_SK, TANGGAL_SK, TMT_JABATAN, 
                   NAMA, A.KETERANGAN, KELAS, 
                   NO_URUT, PPI_GAJI.AMBIL_GAJI_PER_JENIS(A.PEGAWAI_ID, ".$jumlah_penghasilan.", B.JENIS_PEGAWAI_ID, KELAS, '".$periode."', JABATAN_ID, KELOMPOK) JSON_GAJI,
				   PPI_GAJI.AMBIL_ITEM_GAJI_JENIS_KELAS(B.JENIS_PEGAWAI_ID, KELAS, KELOMPOK) JSON_GAJI_ITEM
                FROM PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR A INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsJabatanTerakhirJenisPegawai($paramsArray=array(), $jenis_pegawai_id="1", $limit=-1,$from=-1, $statement="", $jumlah_penghasilan="0", $periode="0")
	{
		$str = "
                SELECT 
                PEGAWAI_JABATAN_ID, A.PEGAWAI_ID, JABATAN_ID, 
                   PEJABAT_PENETAP_ID, CABANG_ID, DEPARTEMEN_ID, 
                   NO_SK, TANGGAL_SK, TMT_JABATAN, 
                   NAMA, A.KETERANGAN, KELAS, 
                   NO_URUT, PPI_GAJI.AMBIL_GAJI_PER_JENIS(A.PEGAWAI_ID, ".$jumlah_penghasilan.", ".$jenis_pegawai_id.", KELAS, '".$periode."', JABATAN_ID, KELOMPOK) JSON_GAJI,
				   PPI_GAJI.AMBIL_ITEM_GAJI_JENIS_KELAS(".$jenis_pegawai_id.", KELAS, KELOMPOK) JSON_GAJI_ITEM
                FROM PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR A INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	function selectByParamsJabatanTerakhirMPP($paramsArray=array(),$limit=-1,$from=-1, $statement="", $jumlah_penghasilan="0", $periode="0")
	{
		$str = "
                SELECT 
                PEGAWAI_JABATAN_ID, A.PEGAWAI_ID, JABATAN_ID, 
                   PEJABAT_PENETAP_ID, CABANG_ID, DEPARTEMEN_ID, 
                   NO_SK, TANGGAL_SK, TMT_JABATAN, 
                   NAMA, A.KETERANGAN, KELAS, 
                   NO_URUT, PPI_GAJI.AMBIL_GAJI_PER_JENIS_MPP(A.PEGAWAI_ID, ".$jumlah_penghasilan.", B.JENIS_PEGAWAI_ID, KELAS, '".$periode."', JABATAN_ID, KELOMPOK) JSON_GAJI,
				   PPI_GAJI.AMBIL_ITEM_GAJI_JENIS_KELAS(B.JENIS_PEGAWAI_ID, KELAS, KELOMPOK) JSON_GAJI_ITEM
                FROM PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR A INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
                WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsKenaikanJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $jumlah_penghasilan="0", $periode="0")
	{
		$str = "
				SELECT B.KELAS, '' NO_SK, SYSDATE TMT_JABATAN, SYSDATE TANGGAL_SK, B.NAMA JABATAN, B.JABATAN_ID,
                       PPI_GAJI.AMBIL_GAJI_PER_JENIS(A.PEGAWAI_ID, ".$jumlah_penghasilan.", C.JENIS_PEGAWAI_ID, B.KELAS, PERIODE, A.JABATAN_ID_SESUDAH, KELOMPOK) JSON_GAJI,
				       PPI_GAJI.AMBIL_ITEM_GAJI_JENIS_KELAS(C.JENIS_PEGAWAI_ID, B.KELAS, KELOMPOK) JSON_GAJI_ITEM,
                       MASA_KERJA_TAHUN, MASA_KERJA_BULAN, PERIODE, JUMLAH_P3, KELAS_P3, PERIODE_P3, DEPARTEMEN_ID_SESUDAH DEPARTEMEN_ID
                FROM PPI_SIMPEG.KENAIKAN_JABATAN A 
                INNER JOIN PPI_SIMPEG.JABATAN B  ON A.JABATAN_ID_SESUDAH = B.JABATAN_ID
                INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR C ON A.PEGAWAI_ID = C.PEGAWAI_ID
                INNER JOIN PPI_SIMPEG.PEGAWAI_PENGHASILAN_TERAKHIR D ON A.PEGAWAI_ID = D.PEGAWAI_ID
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
//		echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
    }
    
		
	function selectByParamsJsonGaji($paramsArray=array(),$limit=-1,$from=-1, $periode="", $jumlah_penghasilan="0", $kelas="")
	{
		/* remak 21-03-2014 CHANDRA
		$str = "
				SELECT 
				PPI_GAJI.AMBIL_GAJI_PER_JENIS(A.PEGAWAI_ID, ".$jumlah_penghasilan.", B.JENIS_PEGAWAI_ID, KELAS, '".$periode."', JABATAN_ID, KELOMPOK) JSON_GAJI
				FROM PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR A INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				WHERE 1 = 1
				"; 
		*/
		
		$str = "SELECT PPI_GAJI.AMBIL_GAJI_PER_JENIS(A.PEGAWAI_ID, ".$jumlah_penghasilan.", B.JENIS_PEGAWAI_ID,
				NVL('".$kelas."',NVL(DECODE(D.KELAS,A.KELAS,A.KELAS,D.KELAS), A.KELAS)),  '".$periode."', nvl(C.JABATAN_ID_SESUDAH, A.JABATAN_ID) , A.KELOMPOK) JSON_GAJI 
				FROM PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR A INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				LEFT JOIN PPI_SIMPEG.KENAIKAN_JABATAN C ON C.PEGAWAI_ID = A.PEGAWAI_ID AND C.STATUS = 0
				LEFT JOIN PPI_SIMPEG.JABATAN D ON D.JABATAN_ID = C.JABATAN_ID_SESUDAH
				WHERE 1 = 1";
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		//echo $str;exit;
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsJsonGajiMPP($paramsArray=array(),$limit=-1,$from=-1, $periode="", $jumlah_penghasilan="0")
	{
		$str = "
				SELECT 
				PPI_GAJI.AMBIL_GAJI_PER_JENIS_MPP(A.PEGAWAI_ID, ".$jumlah_penghasilan.", B.JENIS_PEGAWAI_ID, KELAS, '".$periode."', JABATAN_ID, KELOMPOK) JSON_GAJI
				FROM PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR A INNER JOIN PPI_SIMPEG.PEGAWAI_JENIS_PEGAWAI_TERAKHIR B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	

	function selectByParamsJsonGajiP3($periode="",$kelas="")
	{
		$str = "
				SELECT JUMLAH FROM PPI_GAJI.MERIT_P3 WHERE KELAS = '".$kelas."' AND PERIODE = '".$periode."'
				"; 
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }

    function selectByParamsJsonGajiTPPP3($kelas="")
	{
		$str = "
				SELECT JUMLAH FROM PPI_GAJI.TPP_P3 WHERE KELAS = '".$kelas."' 
				"; 
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }
	
	function selectByParamsGajiPMS($periode="",$kelas="", $jenispegawai)
	{
		$str = "
				select A.JUMLAH MERIT_PMS, B.JUMLAH TPP_PMS 
				from PPI_GAJI.MERIT_PMS A JOIN PPI_GAJI.TPP_PMS B ON A.KELAS = B.KELAS AND B.JENIS_PEGAWAI_ID LIKE '%2%' 
				WHERE A.KELAS = '".$kelas."' AND A.PERIODE = '".$periode."'
				"; 
		
		$str .= $statement." ";
		$this->query = $str;
		return $this->selectLimit($str,-1,-1); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
					PEGAWAI_JABATAN_ID, A.NAMA, PEGAWAI_ID, A.DEPARTEMEN_ID, A.CABANG_ID, A.JABATAN_ID, A.PEJABAT_PENETAP_ID,
					NO_SK, TANGGAL_SK, TMT_JABATAN, A.KETERANGAN,
					B.NAMA JABATAN_NAMA, C.NAMA CABANG_NAMA, D.NAMA DEPARTEMEN_NAMA, E.NAMA PEJABAT_PENETAP_NAMA
				FROM PPI_SIMPEG.PEGAWAI_JABATAN A
				LEFT JOIN PPI_SIMPEG.JABATAN B ON A.JABATAN_ID=B.JABATAN_ID
				LEFT JOIN PPI_SIMPEG.CABANG C ON A.CABANG_ID=C.CABANG_ID
				LEFT JOIN PPI_SIMPEG.DEPARTEMEN D ON A.DEPARTEMEN_ID=D.DEPARTEMEN_ID
				LEFT JOIN PPI_SIMPEG.PEJABAT_PENETAP E ON A.PEJABAT_PENETAP_ID=E.PEJABAT_PENETAP_ID
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TANGGAL_SK DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
	function getCountByPegawaiJabatanOperasional($paramsArray=array(), $statement="")
	{
		$str = "
			   SELECT 
				COUNT(A.PEGAWAI_ID) AS ROWCOUNT
			   FROM PPI_SIMPEG.PEGAWAI A
			   LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR C ON A.PEGAWAI_ID=C.PEGAWAI_ID
			   LEFT JOIN PPI_SIMPEG.JABATAN D ON C.JABATAN_ID=D.JABATAN_ID
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
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEGAWAI_JABATAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_JABATAN
		        WHERE PEGAWAI_JABATAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEGAWAI_JABATAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI_JABATAN
		        WHERE PEGAWAI_JABATAN_ID IS NOT NULL ".$statement; 
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