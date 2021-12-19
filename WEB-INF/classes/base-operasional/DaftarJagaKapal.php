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

  class DaftarJagaKapal extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function DaftarJagaKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PKT_ID", $this->getNextId("PKT_ID","PPI_OPERASIONAL.DaftarJagaKapal"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.KRU_JADWAL_PIKET (
				   PKT_ID, KAPAL_ID, KRU_JABATAN_ID, LOKASI_ID, TANGGAL, SHIFT, LAST_CREATE_USER, LAST_CREATE_DATE)  
 			  	VALUES (
				  ".$this->getField("PKT_ID").",
				  ".$this->getField("KAPAL_ID").",
				  ".$this->getField("KRU_JABATAN_ID").",
				  '".$this->getField("LOKASI_ID")."',
				  TO_DATE('".$this->getField("TANGGAL")."', 'DD-MM-YYYY'),
				  '".$this->getField("SHIFT")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id=$this->getField("PKT_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KRU_JADWAL_PIKET
				SET    
					   KAPAL_ID         	= ".$this->getField("KAPAL_ID").",
					   KRU_JABATAN_ID         		= ".$this->getField("KRU_JABATAN_ID").",
					   LOKASI_ID         		= '".$this->getField("LOKASI_ID")."',
					   TANGGAL   = TO_DATE('".$this->getField("TANGGAL")."', 'DD-MM-YYYY'),
					   SHIFT      = '".$this->getField("SHIFT")."',
					   LAST_UPDATE_USER		= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE		= ".$this->getField("LAST_UPDATE_DATE")."
				WHERE  PKT_ID  		= ".$this->getField("PKT_ID")."

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KRU_JADWAL_PIKET
                WHERE 
                  KAPAL_ID = ".$this->getField("KAPAL_ID")."
				  AND TO_CHAR(TANGGAL, 'MM-YYYY') = '".$this->getField("PERIODE")."' "; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA ASC")
	{
		$str = "
                SELECT A.PKT_ID,A.KRU_JABATAN_ID, A.KAPAL_ID,C.NAMA KAPAL_NAMA, D.NAMA KRU_NAMA, TANGGAL, TO_CHAR(A.TANGGAL, 'fmDD') TGL, SHIFT, A.LOKASI_ID
                FROM PPI_OPERASIONAL.KRU_JADWAL_PIKET A LEFT JOIN PPI_OPERASIONAL.LOKASI B 
                ON A.LOKASI_ID = B.LOKASI_ID
                LEFT JOIN PPI_OPERASIONAL.KAPAL C ON A.KAPAL_ID = C.KAPAL_ID
                LEFT JOIN PPI_OPERASIONAL.KRU_JABATAN D ON A.KRU_JABATAN_ID = D.KRU_JABATAN_ID
                WHERE 0=0
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	   function selectByParamsHeader($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA ASC")
		{
			$str = "
					select DISTINCT a.kapal_id, B.NAMA NAMA_KAPAL, TO_CHAR(a.tanggal, 'MMYYYY') PERIODE 
					from PPI_operasional.KRU_JADWAL_PIKET a, PPI_operasional.kapal b
					where a.kapal_id = b.kapal_id
					"; 
			
			while(list($key,$val) = each($paramsArray))
			{
				$str .= " AND $key = '$val' ";
			}
			
			$str .= $statement." group by a.kapal_id, B.NAMA, TO_CHAR(a.tanggal, 'MMYYYY') ".$order;
			$this->query = $str;

			return $this->selectLimit($str,$limit,$from); 
		}
		
	function selectDaftarJaga($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.KETERANGAN DESC, A.NAMA, TANGGAL")
	{
		$str = "
                SELECT A.KRU_JABATAN_ID, A.NAMA, TO_CHAR(B.TANGGAL,'FMDD') TANGGAL, SHIFT, C.NAMA NAMA_LOKASI 
				FROM PPI_OPERASIONAL.KRU_JABATAN A LEFT JOIN PPI_OPERASIONAL.KRU_JADWAL_PIKET B ON A.KRU_JABATAN_ID=B.KRU_JABATAN_ID
				LEFT JOIN PPI_OPERASIONAL.LOKASI C ON B.LOKASI_ID = C.LOKASI_ID
                WHERE 0=0
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectDaftarJagaRealisasi($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY A.KETERANGAN DESC, A.NAMA, TANGGAL")
	{
		$str = "
                SELECT A.KRU_JABATAN_ID, A.NAMA, TO_CHAR(B.TANGGAL,'FMDD') TANGGAL, SHIFT, C.NAMA NAMA_LOKASI 
				FROM PPI_OPERASIONAL.KRU_JABATAN A LEFT JOIN PPI_OPERASIONAL.KRU_JADWAL_PIKET_REALISASI B ON A.KRU_JABATAN_ID=B.KRU_JABATAN_ID
				LEFT JOIN PPI_OPERASIONAL.LOKASI C ON B.LOKASI_ID = C.LOKASI_ID
                WHERE 0=0
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KETERANGAN DESC")
	{
		$str = "
               SELECT KRU_JABATAN_ID, NAMA 
                FROM PPI_OPERASIONAL.KRU_JABATAN 
                WHERE 0=0
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
	function selectKrewAwak($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY   a.KRU_JABATAN_ID ASC", $periode)
	{
		$str = "SELECT B.NAMA,
				  C.NAMA JABATAN,
				  TANGGAL_MASUK,
				  TANGGAL_KELUAR,
				  TO_CHAR(
				  CASE WHEN TANGGAL_MASUK < TO_DATE('01'||'". $periode ."', 'DDMMYYYY') THEN
				  TO_DATE('01'||'".$periode."', 'DDMMYYYY')
				  ELSE
				  TANGGAL_MASUK
				  END
              , 'DD MON YYYY') || ' - ' || NVL(TO_CHAR(TANGGAL_KELUAR, 'DD MON YYYY'), TO_CHAR(LAST_dAY(TO_DATE('01'||'".$periode."', 'DDMMYYYY')), 'DD MON YYYY')) TGL
		   FROM      PPI_OPERASIONAL.PEGAWAI_KAPAL_HISTORI A
				  INNER JOIN
					 PPI_SIMPEG.PEGAWAI B
				  ON A.PEGAWAI_ID = B.PEGAWAI_ID
				   INNER JOIN
					  PPI_OPERASIONAL.KRU_JABATAN C
				   ON A.KRU_JABATAN_ID = C.KRU_JABATAN_ID
				   WHERE 0=0
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
				SELECT PKT_ID, KAPAL_ID, KRU_JABATAN_ID, TANGGAL, SHIFT, A.LOKASI_ID
                FROM PPI_OPERASIONAL.KRU_JADWAL_PIKET A INNER JOIN PPI_OPERASIONAL.LOKASI B 
                ON A.LOKASI_ID = B.LOKASI_ID
                WHERE 0=0

			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PKT_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KRU_JADWAL_PIKET
		        WHERE 0=0 ".$statement; 
		
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
	
	 function getCountByParamsHeader($paramsArray=array(), $statement="")
	{
		$str = "select count(DISTINCT a.kapal_id) as ROWCOUNT
					from PPI_operasional.KRU_JADWAL_PIKET a, PPI_operasional.kapal b
					where a.kapal_id = b.kapal_id ".$statement; 
		
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
		$str = "SELECT COUNT(PKT_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KRU_JADWAL_PIKET
		        WHERE 0=0 ".$statement; 
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
	
	function getCountKruKapal()
	{
		$str = "SELECT COUNT(KRU_JABATAN_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KRU_JABATAN
		        WHERE 0=0 ";
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	
	
	function getStatusPeriode($periode)
	{
		$str = "select STATUS from PPI_OPERASIONAL.KRU_JADWAL_PIKET
				where to_char(tanggal, 'DD-MM-YYYY') = '". $periode ."'
				group by STATUS ";
		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("STATUS"); 
		else 
			return 'O'; 
    }
	
	function callCloseJadwalPiket($periode)
	{

        $str = "UPDATE PPI_OPERASIONAL.KRU_JADWAL_PIKET SET STATUS = 'C' 
				WHERE STATUS = 'O' AND TO_CHAR(TANGGAL, 'MMYYYY') = '". $periode ."'";
  
		$this->query = $str;
        return $this->execQuery($str);
    }		
  } 
?>