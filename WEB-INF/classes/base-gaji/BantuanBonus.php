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

  class BantuanBonus extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function BantuanBonus()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BANTUAN_BONUS_ID", $this->getNextId("BANTUAN_BONUS_ID","PPI_GAJI.BANTUAN_BONUS")); 
		$str = "
				INSERT INTO PPI_GAJI.BANTUAN_BONUS (
				   BANTUAN_BONUS_ID, TAHUN, KELAS, 
				   JUMLAH, JENIS_PEGAWAI_ID) 
				VALUES ( ".$this->getField("BANTUAN_BONUS_ID").",
					  '".$this->getField("TAHUN")."',
					  '".$this->getField("KELAS")."',
					  ".$this->getField("JUMLAH").",
					  '".$this->getField("JENIS_PEGAWAI_ID")."'
				)"; 
		$this->id = $this->getField("BANTUAN_BONUS_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE PPI_GAJI.BANTUAN_BONUS
			   SET 		   		
					  '".$this->getField("TAHUN")."',
					  '".$this->getField("KELAS")."',
					  '".$this->getField("JUMLAH")."',
					  '".$this->getField("JENIS_PEGAWAI_ID")."'
			   WHERE BANTUAN_BONUS_ID = ".$this->getField("BANTUAN_BONUS_ID")."
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function delete()
	{
        $str = "
				DELETE FROM PPI_GAJI.BANTUAN_BONUS
                WHERE 
                  TAHUN = '".$this->getField("TAHUN")."'
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

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $tahun='', $order="ORDER BY TAHUN")
	{
		$str = "
				SELECT TAHUN FROM
				PPI_GAJI.BANTUAN_BONUS A 
				WHERE 1=1
			   "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."GROUP BY TAHUN ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsBantuanBonusJabatan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $tahun='', $order="ORDER BY TO_NUMBER(KELAS)")
	{
		$str = "
				SELECT KELAS ,         
				(SELECT JUMLAH FROM PPI_GAJI.BANTUAN_BONUS X WHERE X.KELAS = A.KELAS AND X.JENIS_PEGAWAI_ID = 2 AND TAHUN = '".$tahun."') PERBANTUAN,
				(SELECT JUMLAH FROM PPI_GAJI.BANTUAN_BONUS X WHERE X.KELAS = A.KELAS AND X.JENIS_PEGAWAI_ID = 1 AND TAHUN = '".$tahun."') ORGANIK,
				(SELECT JUMLAH FROM PPI_GAJI.BANTUAN_BONUS X WHERE X.KELAS = A.KELAS AND X.JENIS_PEGAWAI_ID = 5 AND TAHUN = '".$tahun."') PTTPK,
				(SELECT JUMLAH FROM PPI_GAJI.BANTUAN_BONUS X WHERE X.KELAS = A.KELAS AND X.JENIS_PEGAWAI_ID = 3 AND TAHUN = '".$tahun."') PKWT,
				(SELECT JUMLAH FROM PPI_GAJI.BANTUAN_BONUS X WHERE X.KELAS = A.KELAS AND X.JENIS_PEGAWAI_ID = 4 AND TAHUN = '".$tahun."') KSO,
				(SELECT JUMLAH FROM PPI_GAJI.BANTUAN_BONUS X WHERE X.KELAS = A.KELAS AND X.JENIS_PEGAWAI_ID = 9 AND TAHUN = '".$tahun."') SATPAM,
				(SELECT JUMLAH FROM PPI_GAJI.BANTUAN_BONUS X WHERE X.KELAS = A.KELAS AND X.JENIS_PEGAWAI_ID = 10 AND TAHUN = '".$tahun."') CS,
				(SELECT JUMLAH FROM PPI_GAJI.BANTUAN_BONUS X WHERE X.KELAS = A.KELAS AND X.JENIS_PEGAWAI_ID = 11 AND TAHUN = '".$tahun."') LAINNYA
				FROM PPI_SIMPEG.JABATAN A 
				WHERE 1=1  
			   "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY KELAS ".$order;
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT A.PEGAWAI_ID, A.NAMA, A.DEPARTEMEN_ID, BULANTAHUN, KELAS, PERIODE, STATUS_BAYAR, GAJI_JSON
                FROM PPI_SIMPEG.PEGAWAI A LEFT JOIN PPI_GAJI.BANTUAN_BONUS B 
                ON A.PEGAWAI_ID = B.PEGAWAI_ID
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
		$str = "
				SELECT COUNT(1) AS ROWCOUNT
                FROM
                (
				SELECT COUNT(TAHUN) 
                FROM PPI_GAJI.BANTUAN_BONUS A
                WHERE 1=1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str.= " 
				GROUP BY TAHUN
				)
		";
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(A.PEGAWAI_ID) AS ROWCOUNT FROM PPI_SIMPEG.PEGAWAI A WHERE 1 = 1 "; 
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