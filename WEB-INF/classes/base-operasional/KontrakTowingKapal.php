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

  class KontrakTowingKapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KontrakTowingKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KONTRAK_TOWING_KAPAL_ID", $this->getNextId("KONTRAK_TOWING_KAPAL_ID","PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL (
				   KONTRAK_TOWING_KAPAL_ID, KONTRAK_TOWING_ID, KAPAL_ID, 
				   STATUS, KONTRAK_TOWING_KAPAL_ID_GANTI, TEMP_TANGGAL_AWAL, TEMP_TANGGAL_AKHIR)
				VALUES ('".$this->getField("KONTRAK_TOWING_KAPAL_ID")."', '".$this->getField("KONTRAK_TOWING_ID")."', '".$this->getField("KAPAL_ID")."', 
				   '".$this->getField("STATUS")."', '".$this->getField("KONTRAK_TOWING_KAPAL_ID_GANTI")."',
				  ".$this->getField("TEMP_TANGGAL_AWAL").",
				  ".$this->getField("TEMP_TANGGAL_AKHIR")."
				   ) "; 
		$this->id = $this->getField("KONTRAK_TOWING_KAPAL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function insertKapal()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KONTRAK_TOWING_KAPAL_ID", $this->getNextId("KONTRAK_TOWING_KAPAL_ID","PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL"));
		$str = "
				INSERT INTO PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL (
				   KONTRAK_TOWING_KAPAL_ID, KONTRAK_SBPP_ID, KAPAL_ID, STATUS, HP, DAYA) 
 			  	VALUES (
				  ".$this->getField("KONTRAK_TOWING_KAPAL_ID").",
				  '".$this->getField("KONTRAK_SBPP_ID")."',
				  '".$this->getField("KAPAL_ID")."',
				  'A',
				  '".$this->getField("HP")."',
				  '".$this->getField("DAYA")."'
				)"; 
		$this->id = $this->getField("KONTRAK_TOWING_KAPAL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL
				SET    
					   KAPAL_ID	= '".$this->getField("KAPAL_ID")."',
					   TEMP_TANGGAL_AWAL	= ".$this->getField("TEMP_TANGGAL_AWAL").",
					   TEMP_TANGGAL_AKHIR	= ".$this->getField("TEMP_TANGGAL_AKHIR")."
				WHERE  KONTRAK_TOWING_KAPAL_ID	= '".$this->getField("KONTRAK_TOWING_KAPAL_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateStatus()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL
				SET    
					   STATUS	= 'D',
					   KETERANGAN = '".$this->getField("KETERANGAN")."'
				WHERE  KONTRAK_TOWING_KAPAL_ID = '".$this->getField("KONTRAK_TOWING_KAPAL_ID")."' AND KAPAL_ID = '".$this->getField("KAPAL_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL
                WHERE 
                  KONTRAK_SBPP_ID = ".$this->getField("KONTRAK_SBPP_ID")." AND NOT KONTRAK_TOWING_KAPAL_ID IN (".$this->getField("KONTRAK_TOWING_KAPAL_ID_NOT_IN").") "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteKapal()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL
                WHERE 
                  KONTRAK_SBPP_ID = '".$this->getField("KONTRAK_SBPP_ID")."' 
				"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_TOWING_KAPAL_ID ASC")
	{
		$str = "
    			SELECT 
                A.KONTRAK_TOWING_KAPAL_ID, A.KONTRAK_TOWING_KAPAL_ID_GANTI, A.KONTRAK_TOWING_ID, A.KAPAL_ID, B.NAMA KAPAL_NAMA, 
                   A.STATUS,  C.KAPAL_HISTORI_ID, C.KONTRAK_TOWING_ID KONTRAK_TOWING_ID_SEBELUM, 
                   C.TANGGAL_MASUK TANGGAL_MASUK_SEBELUM, C.TANGGAL_KELUAR TANGGAL_KELUAR_SEBELUM, D.NAMA NAMA_KONTRAK_TOWING_SEBELUM, A.TEMP_TANGGAL_AWAL, A.TEMP_TANGGAL_AKHIR
                FROM PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL A
                LEFT JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID = A.KAPAL_ID 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI C ON A.KONTRAK_TOWING_ID = C.KONTRAK_TOWING_ID AND B.KAPAL_ID = C.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.KONTRAK_TOWING D ON C.KONTRAK_TOWING_ID = D.KONTRAK_TOWING_ID
                WHERE A.KONTRAK_TOWING_KAPAL_ID IS NOT NULL AND A.STATUS = 'A'
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsKapalGanti($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_TOWING_KAPAL_ID ASC")
	{
		$str = "
 				SELECT 
                A.KONTRAK_TOWING_KAPAL_ID, A.KONTRAK_SBPP_ID, A.KAPAL_ID, B.NAMA KAPAL_NAMA, 
                   A.STATUS, A.HP, C.KAPAL_HISTORI_ID, C.KONTRAK_SBPP_ID KONTRAK_SBPP_ID_SEBELUM, 
                   C.TANGGAL_MASUK TANGGAL_MASUK_SEBELUM, C.TANGGAL_KELUAR TANGGAL_KELUAR_SEBELUM,
                   A.DAYA, D.KAPAL_ID KAPAL_ID_PENGGANTI, (SELECT NAMA FROM PPI_OPERASIONAL.KAPAL X WHERE D.KAPAL_ID = X.KAPAL_ID) KAPAL_PENGGANTI,
                   D.TANGGAL_MASUK TANGGAL_MASUK_PENGGANTI, D.KAPAL_HISTORI_ID KAPAL_HISTORI_ID_PENGGANTI, D.TANGGAL_KELUAR
                FROM PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL A
                LEFT JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID = A.KAPAL_ID 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR C ON A.KONTRAK_SBPP_ID = C.KONTRAK_SBPP_ID AND B.KAPAL_ID = C.KAPAL_ID
                LEFT JOIN (SELECT KONTRAK_TOWING_KAPAL_ID_GANTI, TANGGAL_KELUAR, KAPAL_HISTORI_ID, TANGGAL_MASUK, X.KAPAL_ID FROM PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL X
                INNER JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR Y ON X.KONTRAK_SBPP_ID = Y.KONTRAK_SBPP_ID AND X.KAPAL_ID = Y.KAPAL_ID  AND Y.TANGGAL_KELUAR IS NULL WHERE X.STATUS = 'C') D ON A.KONTRAK_TOWING_KAPAL_ID = D.KONTRAK_TOWING_KAPAL_ID_GANTI
                WHERE A.KONTRAK_TOWING_KAPAL_ID IS NOT NULL AND A.STATUS = 'A'
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
	

    function selectByParamsKontrakHistori($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_TOWING_KAPAL_ID ASC")
	{
		$str = "
				SELECT 
                A.KONTRAK_TOWING_KAPAL_ID, A.KONTRAK_TOWING_KAPAL_ID_GANTI, A.KONTRAK_TOWING_ID, A.KAPAL_ID, B.NAMA KAPAL_NAMA, 
                   A.STATUS, C.KAPAL_HISTORI_ID, C.KONTRAK_TOWING_ID KONTRAK_TOWING_ID_SEBELUM, 
                   C.TANGGAL_MASUK TANGGAL_MASUK_SEBELUM, C.TANGGAL_KELUAR TANGGAL_KELUAR_SEBELUM,
                   D.KAPAL_ID KAPAL_ID_PENGGANTI, (SELECT NAMA FROM PPI_OPERASIONAL.KAPAL X WHERE D.KAPAL_ID = X.KAPAL_ID) KAPAL_PENGGANTI,
                   E.TANGGAL_MASUK TANGGAL_MASUK_PENGGANTI, E.TANGGAL_KELUAR TANGGAL_KELUAR_PENGGANTI, E.KAPAL_HISTORI_ID KAPAL_HISTORI_ID_PENGGANTI,
				   A.TEMP_TANGGAL_AWAL, A.TEMP_TANGGAL_AKHIR, A.KETERANGAN
				FROM PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID = A.KAPAL_ID 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR C ON A.KONTRAK_TOWING_ID = C.KONTRAK_TOWING_ID AND B.KAPAL_ID = C.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL D ON A.KONTRAK_TOWING_KAPAL_ID = D.KONTRAK_TOWING_KAPAL_ID_GANTI AND D.STATUS = 'C'
                LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR E ON D.KONTRAK_TOWING_ID = E.KONTRAK_TOWING_ID AND D.KAPAL_ID = E.KAPAL_ID
                WHERE A.KONTRAK_TOWING_KAPAL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
		
	function selectByParamsKapal($paramsArray=array(),$limit=-1,$from=-1, $statement="", $groupOrder="GROUP BY KONTRAK_SBPP_ID, STATUS, HP, DAYA")
	{
		$str = "
				SELECT 
                A.KONTRAK_SBPP_ID, STATUS, HP, A.DAYA, COUNT(HP) JUMLAH
                FROM PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL A
                LEFT JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID = A.KAPAL_ID
                WHERE KONTRAK_TOWING_KAPAL_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$groupOrder;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "	
				SELECT 
				KONTRAK_TOWING_KAPAL_ID, KONTRAK_SBPP_ID, KAPAL_ID, 
				   STATUS
				FROM PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL
				WHERE KONTRAK_TOWING_KAPAL_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KONTRAK_TOWING_KAPAL_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KONTRAK_TOWING_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KONTRAK_TOWING_KAPAL
		        WHERE KONTRAK_TOWING_KAPAL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KONTRAK_TOWING_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL
		        WHERE KONTRAK_TOWING_KAPAL_ID IS NOT NULL ".$statement; 
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