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

  class KontrakSbppKapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KontrakSbppKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KONTRAK_SBPP_KAPAL_ID", $this->getNextId("KONTRAK_SBPP_KAPAL_ID","PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL"));
		$str = "
				INSERT INTO PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL (
				   KONTRAK_SBPP_KAPAL_ID, KONTRAK_SBPP_ID, KAPAL_ID, 
				   STATUS, HP, DAYA, KONTRAK_SBPP_KAPAL_ID_GANTI, TEMP_TANGGAL_AWAL, TEMP_TANGGAL_AKHIR)
 			  	VALUES (
				  ".$this->getField("KONTRAK_SBPP_KAPAL_ID").",
				  '".$this->getField("KONTRAK_SBPP_ID")."',
				  '".$this->getField("KAPAL_ID")."',
				  '".$this->getField("STATUS")."',
				  '".$this->getField("HP")."',
				  '".$this->getField("DAYA")."',
				  '".$this->getField("KONTRAK_SBPP_KAPAL_ID_GANTI")."',
				  ".$this->getField("TEMP_TANGGAL_AWAL").",
				  ".$this->getField("TEMP_TANGGAL_AKHIR")."
				)"; 
		$this->id = $this->getField("KONTRAK_SBPP_KAPAL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function insertKapal()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KONTRAK_SBPP_KAPAL_ID", $this->getNextId("KONTRAK_SBPP_KAPAL_ID","PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL"));
		$str = "
				INSERT INTO PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL (
				   KONTRAK_SBPP_KAPAL_ID, KONTRAK_SBPP_ID, KAPAL_ID, STATUS, HP, DAYA) 
 			  	VALUES (
				  ".$this->getField("KONTRAK_SBPP_KAPAL_ID").",
				  '".$this->getField("KONTRAK_SBPP_ID")."',
				  '".$this->getField("KAPAL_ID")."',
				  'A',
				  '".$this->getField("HP")."',
				  '".$this->getField("DAYA")."'
				)"; 
		$this->id = $this->getField("KONTRAK_SBPP_KAPAL_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL
				SET    
					   KAPAL_ID				= '".$this->getField("KAPAL_ID")."',
					   HP	 				= '".$this->getField("HP")."',
					   TEMP_TANGGAL_AWAL	= ".$this->getField("TEMP_TANGGAL_AWAL").",
					   TEMP_TANGGAL_AKHIR	= ".$this->getField("TEMP_TANGGAL_AKHIR")."
				WHERE  KONTRAK_SBPP_KAPAL_ID	= '".$this->getField("KONTRAK_SBPP_KAPAL_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateTempTanggalAkhir()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL
				SET    
					   TEMP_TANGGAL_AKHIR	= ".$this->getField("TEMP_TANGGAL_AKHIR")."
				WHERE  KONTRAK_SBPP_KAPAL_ID	= '".$this->getField("KONTRAK_SBPP_KAPAL_ID")."'
			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }	
	
	function updateHpKapalAktif()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL
				SET    
					   DAYA				= '".$this->getField("DAYA")."',
					   HP	 				= '".$this->getField("HP")."'
				WHERE  KONTRAK_SBPP_ID	= '".$this->getField("KONTRAK_SBPP_ID")."' AND  DAYA = '".$this->getField("DAYA_TEMP")."' AND STATUS = 'A'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function updateStatus()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL
				SET    
					   STATUS	= 'D',
					   KETERANGAN = '".$this->getField("KETERANGAN")."'
				WHERE  KONTRAK_SBPP_KAPAL_ID	= '".$this->getField("KONTRAK_SBPP_KAPAL_ID")."' AND KAPAL_ID = '".$this->getField("KAPAL_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL
                WHERE 
                  KONTRAK_SBPP_ID = ".$this->getField("KONTRAK_SBPP_ID")." AND NOT KONTRAK_SBPP_KAPAL_ID IN (".$this->getField("KONTRAK_SBPP_KAPAL_ID_NOT_IN").") "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteKapal()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL
                WHERE 
                  KONTRAK_SBPP_ID = '".$this->getField("KONTRAK_SBPP_ID")."' 
				"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
    function deleteSbppKapal()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL
                WHERE 
                  KONTRAK_SBPP_KAPAL_ID = '".$this->getField("KONTRAK_SBPP_KAPAL_ID")."' 
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_SBPP_KAPAL_ID ASC")
	{
		$str = "
    			SELECT 
                A.KONTRAK_SBPP_KAPAL_ID, A.KONTRAK_SBPP_KAPAL_ID_GANTI, A.KONTRAK_SBPP_ID, A.KAPAL_ID, B.NAMA KAPAL_NAMA, 
                   A.STATUS, A.HP, C.KAPAL_HISTORI_ID, C.KONTRAK_SBPP_ID KONTRAK_SBPP_ID_SEBELUM, 
                   TO_CHAR(C.TANGGAL_MASUK, 'YYYY-MM-DD HH24:MI:SS') TANGGAL_MASUK_SEBELUM, TO_CHAR(C.TANGGAL_KELUAR, 'YYYY-MM-DD HH24:MI:SS') TANGGAL_KELUAR_SEBELUM,
                   A.DAYA, TO_CHAR(A.TEMP_TANGGAL_AWAL, 'YYYY-MM-DD HH24:MI:SS') TEMP_TANGGAL_AWAL, TO_CHAR(A.TEMP_TANGGAL_AKHIR, 'YYYY-MM-DD HH24:MI:SS') TEMP_TANGGAL_AKHIR,
                   CASE WHEN FOTO IS NULL THEN 0 ELSE 1 END FOTO
				FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID = A.KAPAL_ID 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR C ON A.KONTRAK_SBPP_ID = C.KONTRAK_SBPP_ID AND B.KAPAL_ID = C.KAPAL_ID
				WHERE A.KONTRAK_SBPP_KAPAL_ID IS NOT NULL AND A.STATUS = 'A' AND TANGGAL_KELUAR_KONTRAK IS NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsKirimDowntime($paramsArray=array(),$limit=-1,$from=-1, $statement="", $periode="", $order="ORDER BY NVL(A.KONTRAK_SBPP_KAPAL_ID_GANTI, A.KONTRAK_SBPP_KAPAL_ID) ASC, A.STATUS ASC, TANGGAL_MASUK ASC")
	{
		$str = "
		SELECT  NVL(A.KONTRAK_SBPP_KAPAL_ID_GANTI, A.KONTRAK_SBPP_KAPAL_ID) KONTRAK_SBPP_KAPAL_ID, JUMLAH_SUB,
        B.KAPAL_HISTORI_ID, A.KAPAL_ID, C.KODE, C.NAMA KAPAL, B.TANGGAL_MASUK, B.TANGGAL_KELUAR, A.STATUS,
        PPI_OPERASIONAL.AMBIL_REALISASI_DT_RATA_CHECK(A.KAPAL_ID, TO_NUMBER(CASE WHEN TO_CHAR(TANGGAL_MASUK, 'MMYYYY') = '".$periode."' THEN TO_CHAR(TANGGAL_MASUK, 'DD') ELSE '1' END), TO_NUMBER(CASE WHEN TO_CHAR(TANGGAL_KELUAR, 'MMYYYY') = '".$periode."' THEN TO_CHAR(TANGGAL_KELUAR, 'DD') ELSE TO_CHAR(LAST_DAY(TO_DATE('".$periode."','MMYYYY')), 'DD') END), '".$periode."') JAM_TSO
        FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL A 
				INNER JOIN PPI_OPERASIONAL.KAPAL_HISTORI B ON A.KAPAL_ID = B.KAPAL_ID AND 
                          ((NVL(A.KONTRAK_SBPP_KAPAL_ID_GANTI, A.KONTRAK_SBPP_KAPAL_ID) = B.KAPAL_ID_GANTI AND A.STATUS = 'C') OR (A.KONTRAK_SBPP_KAPAL_ID_GANTI IS NULL AND A.KONTRAK_SBPP_KAPAL_ID = B.KAPAL_ID_GANTI)) AND 
                          A.KONTRAK_SBPP_ID = B.KONTRAK_SBPP_ID AND 
                          (TANGGAL_KELUAR IS NULL OR TO_DATE('".$periode."', 'MMYYYY') BETWEEN TANGGAL_MASUK AND NVL(TANGGAL_KELUAR, SYSDATE) OR TO_CHAR(TANGGAL_KELUAR, 'MMYYYY') = '".$periode."')
				INNER JOIN PPI_OPERASIONAL.KAPAL C ON A.KAPAL_ID = C.KAPAL_ID
                INNER JOIN (
                            SELECT  NVL(A.KONTRAK_SBPP_KAPAL_ID_GANTI, A.KONTRAK_SBPP_KAPAL_ID) KONTRAK_SBPP_KAPAL_ID, COUNT(NVL(A.KONTRAK_SBPP_KAPAL_ID_GANTI, A.KONTRAK_SBPP_KAPAL_ID)) JUMLAH_SUB FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL A 
                            				INNER JOIN PPI_OPERASIONAL.KAPAL_HISTORI B ON A.KAPAL_ID = B.KAPAL_ID AND 
                                                      ((NVL(A.KONTRAK_SBPP_KAPAL_ID_GANTI, A.KONTRAK_SBPP_KAPAL_ID) = B.KAPAL_ID_GANTI AND A.STATUS = 'C') OR (A.KONTRAK_SBPP_KAPAL_ID_GANTI IS NULL AND A.KONTRAK_SBPP_KAPAL_ID = B.KAPAL_ID_GANTI)) AND 
                                                      A.KONTRAK_SBPP_ID = B.KONTRAK_SBPP_ID AND 
                                                      (TANGGAL_KELUAR IS NULL OR TO_DATE('".$periode."', 'MMYYYY') BETWEEN TANGGAL_MASUK AND NVL(TANGGAL_KELUAR, SYSDATE) OR TO_CHAR(TANGGAL_KELUAR, 'MMYYYY') = '".$periode."')
                        				INNER JOIN PPI_OPERASIONAL.KAPAL C ON A.KAPAL_ID = C.KAPAL_ID     
                                        GROUP BY NVL(A.KONTRAK_SBPP_KAPAL_ID_GANTI, A.KONTRAK_SBPP_KAPAL_ID)             
                ) D ON NVL(A.KONTRAK_SBPP_KAPAL_ID_GANTI, A.KONTRAK_SBPP_KAPAL_ID) = D.KONTRAK_SBPP_KAPAL_ID
				WHERE 1 = 1
				"; 
		
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
	
    function selectByParamsKapalGanti($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_SBPP_KAPAL_ID ASC")
	{
		$str = "
                SELECT 
				C.HISTORI_ID, D.HISTORI_ID_PARENT,
                A.KONTRAK_SBPP_KAPAL_ID, A.KONTRAK_SBPP_ID, A.KAPAL_ID, B.NAMA KAPAL_NAMA, 
                   A.STATUS, A.HP, C.KAPAL_HISTORI_ID, C.KONTRAK_SBPP_ID KONTRAK_SBPP_ID_SEBELUM, 
                   TO_CHAR(C.TANGGAL_MASUK, 'YYYY-MM-DD HH24:MI:SS') TANGGAL_MASUK_SEBELUM, TO_CHAR(C.TANGGAL_KELUAR, 'YYYY-MM-DD HH24:MI:SS') TANGGAL_KELUAR_SEBELUM,
                   A.DAYA, D.KAPAL_ID KAPAL_ID_PENGGANTI, (SELECT NAMA FROM PPI_OPERASIONAL.KAPAL X WHERE D.KAPAL_ID = X.KAPAL_ID) KAPAL_PENGGANTI, D.KONTRAK_SBPP_KAPAL_ID_GANTI, KONTRAK_SBPP_KAPAL_ID_CADANGAN,
                   TO_CHAR(D.TANGGAL_MASUK, 'YYYY-MM-DD HH24:MI:SS') TANGGAL_MASUK_PENGGANTI, D.KAPAL_HISTORI_ID KAPAL_HISTORI_ID_PENGGANTI, TO_CHAR(D.TANGGAL_KELUAR, 'YYYY-MM-DD HH24:MI:SS') TANGGAL_KELUAR,
				   CASE WHEN FOTO IS NULL THEN 0 ELSE 1 END FOTO
                FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL A
                LEFT JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID = A.KAPAL_ID 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI C ON A.KONTRAK_SBPP_ID = C.KONTRAK_SBPP_ID AND B.KAPAL_ID = C.KAPAL_ID AND TANGGAL_KELUAR IS NULL
                LEFT JOIN (SELECT SUBSTR(Y.HISTORI_ID,0,2) HISTORI_ID_PARENT, KONTRAK_SBPP_KAPAL_ID KONTRAK_SBPP_KAPAL_ID_CADANGAN, KONTRAK_SBPP_KAPAL_ID_GANTI, TANGGAL_KELUAR, KAPAL_HISTORI_ID, TANGGAL_MASUK, X.KAPAL_ID FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL X
                INNER JOIN PPI_OPERASIONAL.KAPAL_HISTORI Y ON X.KONTRAK_SBPP_ID = Y.KONTRAK_SBPP_ID AND X.KAPAL_ID = Y.KAPAL_ID  AND Y.TANGGAL_KELUAR IS NULL WHERE X.STATUS = 'C' AND X.TEMP_TANGGAL_AKHIR IS NULL) D ON A.KONTRAK_SBPP_KAPAL_ID = D.KONTRAK_SBPP_KAPAL_ID_GANTI
                WHERE A.KONTRAK_SBPP_KAPAL_ID IS NOT NULL AND A.STATUS = 'A'
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
	

    function selectByParamsKontrakHistoriLama($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_SBPP_KAPAL_ID ASC")
	{
		$str = "
				SELECT 
                A.KONTRAK_SBPP_KAPAL_ID, A.KONTRAK_SBPP_KAPAL_ID_GANTI, A.KONTRAK_SBPP_ID, A.KAPAL_ID, B.NAMA KAPAL_NAMA, 

                   A.STATUS, A.HP, C.KAPAL_HISTORI_ID, C.KONTRAK_SBPP_ID KONTRAK_SBPP_ID_SEBELUM, 
                   C.TANGGAL_MASUK TANGGAL_MASUK_SEBELUM, C.TANGGAL_KELUAR TANGGAL_KELUAR_SEBELUM,
                   A.DAYA, D.KAPAL_ID KAPAL_ID_PENGGANTI, (SELECT NAMA FROM PPI_OPERASIONAL.KAPAL X WHERE D.KAPAL_ID = X.KAPAL_ID) KAPAL_PENGGANTI,
                   E.TANGGAL_MASUK TANGGAL_MASUK_PENGGANTI, E.TANGGAL_KELUAR TANGGAL_KELUAR_PENGGANTI, E.KAPAL_HISTORI_ID KAPAL_HISTORI_ID_PENGGANTI
				FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID = A.KAPAL_ID 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR C ON A.KONTRAK_SBPP_ID = C.KONTRAK_SBPP_ID AND B.KAPAL_ID = C.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL D ON A.KONTRAK_SBPP_KAPAL_ID = D.KONTRAK_SBPP_KAPAL_ID_GANTI AND D.STATUS = 'C'
                LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR E ON D.KONTRAK_SBPP_ID = E.KONTRAK_SBPP_ID AND D.KAPAL_ID = E.KAPAL_ID
				WHERE A.KONTRAK_SBPP_KAPAL_ID IS NOT NULL AND A.STATUS = 'A'
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	function selectByParamsKontrakHistori($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.KAPAL_ID_GANTI, A.HISTORI_ID, A.TANGGAL_MASUK")
	{
		$str = "
				SELECT 
				CASE WHEN A.HISTORI_PARENT_ID = 0 AND SUBSTR(A.HISTORI_ID,2,1) > 1 THEN NULL ELSE A.KONTRAK_ID END KONTRAK_ID_UPDATE,
				A.KAPAL_HISTORI_ID, A.KAPAL_ID, A.KONTRAK_SBPP_ID, 
			    TO_CHAR(A.TANGGAL_MASUK, 'YYYY-MM-DD HH24:MI:SS') TANGGAL_MASUK, TO_CHAR(A.TANGGAL_KELUAR, 'YYYY-MM-DD HH24:MI:SS') TANGGAL_KELUAR, A.KONTRAK_ID, 
			    A.HISTORI_ID, A.HISTORI_PARENT_ID, A.KAPAL_ID_GANTI,
				C.NAMA KAPAL_NAMA, B.HP, B.DAYA, DECODE(HISTORI_PARENT_ID, 0, 'Kapal Utama', 'Kapal Cadangan') INFO_STATUS
				FROM PPI_OPERASIONAL.KAPAL_HISTORI A
				LEFT JOIN PPI_OPERASIONAL.KAPAL C ON C.KAPAL_ID = A.KAPAL_ID 
				LEFT JOIN PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL B ON A.KAPAL_ID_GANTI = B.KONTRAK_SBPP_KAPAL_ID AND B.STATUS = 'A'
				WHERE 1=1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsKontrakPengawakan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KONTRAK_SBPP_KAPAL_ID ASC")
	{
		$str = "
				SELECT 
                A.KONTRAK_SBPP_KAPAL_ID, A.KONTRAK_SBPP_KAPAL_ID_GANTI, A.KONTRAK_SBPP_ID, A.KAPAL_ID, B.NAMA KAPAL_NAMA, 
                   A.STATUS, A.HP, C.KAPAL_HISTORI_ID, C.KONTRAK_SBPP_ID KONTRAK_SBPP_ID_SEBELUM, 
                   C.TANGGAL_MASUK TANGGAL_MASUK_SEBELUM, C.TANGGAL_KELUAR TANGGAL_KELUAR_SEBELUM,
                   A.DAYA, D.KAPAL_ID KAPAL_ID_PENGGANTI, (SELECT NAMA FROM PPI_OPERASIONAL.KAPAL X WHERE D.KAPAL_ID = X.KAPAL_ID) KAPAL_PENGGANTI,
                   E.TANGGAL_MASUK TANGGAL_MASUK_PENGGANTI, E.TANGGAL_KELUAR TANGGAL_KELUAR_PENGGANTI, E.KAPAL_HISTORI_ID KAPAL_HISTORI_ID_PENGGANTI,
				   A.TEMP_TANGGAL_AWAL, A.TEMP_TANGGAL_AKHIR, A.KETERANGAN
				FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL A
				LEFT JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID = A.KAPAL_ID 
                LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR C ON A.KONTRAK_SBPP_ID = C.KONTRAK_SBPP_ID AND B.KAPAL_ID = C.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL D ON A.KONTRAK_SBPP_KAPAL_ID = D.KONTRAK_SBPP_KAPAL_ID_GANTI AND D.STATUS = 'C'
                LEFT JOIN PPI_OPERASIONAL.KAPAL_HISTORI_TERAKHIR E ON D.KONTRAK_SBPP_ID = E.KONTRAK_SBPP_ID AND D.KAPAL_ID = E.KAPAL_ID
				WHERE A.KONTRAK_SBPP_KAPAL_ID IS NOT NULL
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
                FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL A
                LEFT JOIN PPI_OPERASIONAL.KAPAL B ON B.KAPAL_ID = A.KAPAL_ID
                WHERE KONTRAK_SBPP_KAPAL_ID IS NOT NULL
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
				KONTRAK_SBPP_KAPAL_ID, KONTRAK_SBPP_ID, KAPAL_ID, 
				   STATUS
				FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL
				WHERE KONTRAK_SBPP_KAPAL_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KONTRAK_SBPP_KAPAL_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KONTRAK_SBPP_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KONTRAK_SBPP_KAPAL
		        WHERE KONTRAK_SBPP_KAPAL_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(KONTRAK_SBPP_KAPAL_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL
		        WHERE KONTRAK_SBPP_KAPAL_ID IS NOT NULL ".$statement; 
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