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
  * Entity-base class untuk mengimplementasikan tabel DEPARTEMEN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class TagihanPeriode extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TagihanPeriode()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TAGIHAN_PERIODE_ID", $this->getNextId("TAGIHAN_PERIODE_ID","PPI_OPERASIONAL.TAGIHAN_PERIODE")); 
		$str = "
				INSERT INTO PPI_OPERASIONAL.TAGIHAN_PERIODE (
				   TAGIHAN_PERIODE_ID, PERIODE) 
 			  	VALUES (
				  ".$this->getField("TAGIHAN_PERIODE_ID").",
				  '".$this->getField("PERIODE")."'
				)"; 
		$this->id = $this->getField("TAGIHAN_PERIODE_ID");
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY TAGIHAN_PERIODE_ID ASC")
	{
		$str = "
				SELECT 
				TAGIHAN_PERIODE_ID, PERIODE
				FROM PPI_OPERASIONAL.TAGIHAN_PERIODE			
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order ;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsTagihanSBPP($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY MPLG_KODE ASC")
	{
		$str = "
				SELECT TO_CHAR(TO_DATE(A.PERIODE, 'MMYYYY'),'MONTHYYYY') PERIODE, B.NO_NOTA, A.MPLG_KODE, A.MPLG_NAMA, A.VALUTA, A.KOTOR TAGIHAN_KOTOR, A.DENDA1+A.DENDA2 TAGIHAN_SELISIH, 
						A.TAGIHAN TAGIHAN_BERSIH
						FROM PPI_OPERASIONAL.REKAP_TAGIHAN_SBPP_REPORT A LEFT JOIN PPI_OPERASIONAL.INVOICE_HEADER B ON A.MPLG_KODE = B.MPLG_KODE AND A.PERIODE = B.PERIODE
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order ;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsDataPelanggan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY MPLG_NAMA ASC")
	{
		$str = "
				select distinct a.lokasi_id, b.mplg_kode, b.mplg_nama from PPI_operasional.KONTRAK_SBPP a left join safm_pelanggan@keuangan b on a.no_kartu = b.mplg_kode
				where a.no_kartu is not null
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order ;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsProduksiPeriode($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		/*$str = "
				SELECT DISTINCT PERIODE FROM (
				SELECT PERIODE FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO
				WHERE PERIODE IS NOT NULL
				GROUP BY PERIODE
				UNION ALL
				SELECT TO_CHAR(ADD_MONTHS(TO_DATE(MAX(PERIODE), 'MMYYYY'), 1), 'MMYYYY') PERIODE FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO
				UNION ALL
				SELECT TO_CHAR(ADD_MONTHS(TO_DATE(MAX(PERIODE), 'MMYYYY'), 2), 'MMYYYY') PERIODE FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO
				UNION ALL
				SELECT TO_CHAR(ADD_MONTHS(TO_DATE(MAX(PERIODE), 'MMYYYY'), 3), 'MMYYYY') PERIODE FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO
				UNION ALL
				SELECT TO_CHAR(ADD_MONTHS(TO_DATE(MAX(PERIODE), 'MMYYYY'), 4), 'MMYYYY') PERIODE FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO
				UNION ALL
				SELECT TO_CHAR(ADD_MONTHS(TO_DATE(MAX(PERIODE), 'MMYYYY'), 5), 'MMYYYY') PERIODE FROM PPI_OPERASIONAL.KAPAL_PRODUKSI_INFO
				) WHERE 1 = 1
				"; 
				*/
		$str = "SELECT DISTINCT PERIODE FROM (
                SELECT 
                PERIODE
                FROM PPI_OPERASIONAL.TAGIHAN_PERIODE            
                WHERE 1 = 1
                UNION ALL
                SELECT TO_CHAR(ADD_MONTHS(MAX(TO_DATE(PERIODE, 'MMYYYY')), 1), 'MMYYYY') PERIODE FROM PPI_OPERASIONAL.TAGIHAN_PERIODE 
                UNION ALL
                SELECT TO_CHAR(ADD_MONTHS(MAX(TO_DATE(PERIODE, 'MMYYYY')), 2), 'MMYYYY') PERIODE FROM PPI_OPERASIONAL.TAGIHAN_PERIODE 
                UNION ALL
                SELECT TO_CHAR(ADD_MONTHS(MAX(TO_DATE(PERIODE, 'MMYYYY')), 3), 'MMYYYY') PERIODE FROM PPI_OPERASIONAL.TAGIHAN_PERIODE 
                UNION ALL
                SELECT TO_CHAR(ADD_MONTHS(MAX(TO_DATE(PERIODE, 'MMYYYY')), 4), 'MMYYYY') PERIODE FROM PPI_OPERASIONAL.TAGIHAN_PERIODE 
                UNION ALL
                SELECT TO_CHAR(ADD_MONTHS(MAX(TO_DATE(PERIODE, 'MMYYYY')), 5), 'MMYYYY') PERIODE FROM PPI_OPERASIONAL.TAGIHAN_PERIODE 
                ) WHERE 1 = 1 ";
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY TO_DATE(PERIODE, 'MMYYYY') DESC ";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function getPeriodeAkhir()
	{
		$str = "
				SELECT 
				TAGIHAN_PERIODE_ID, PERIODE
				FROM PPI_OPERASIONAL.TAGIHAN_PERIODE
				WHERE 1 = 1 ORDER BY TAGIHAN_PERIODE_ID DESC
				"; 
		$this->select($str);
		if($this->firstRow()) 
			return $this->getField("PERIODE"); 
		else 
			return ""; 

    }
	
		function callKirimJurnal($periode, $mplgKode, $userAplikasi)
	{

        $str = "CALL PPI_OPERASIONAL.KIRIM_JURNAL_SBPP('". $periode ."','". $mplgKode ."', '" . $userAplikasi . "')";
  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	
  } 
?>