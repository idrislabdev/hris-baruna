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

  class MekarputihKegiatanKapal extends Entity{ 

	var $query;
	var $kapalid;
    /**
    * Class constructor.
    **/
    function MekarputihKegiatanKapal()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ID_KEGIATAN", $this->getNextId("ID_KEGIATAN","MEKARPUTIH.XLS_KEGIATAN_KAPAL"));

		$str = " INSERT INTO MEKARPUTIH.XLS_KEGIATAN_KAPAL (PERIODE, KODE_KAPAL, LOA1, GRT1, DWT1, TUBGOAT, LOA2, GRT2, DWT2, NAMA_CARGO, BERAT_CARGO, NOMOR1A_MASUK, NOMOR1A_KELUAR,
					MASUK_TUNDA1, MASUK_TUNDA2, MASUK_TUNDA3, TGL_MASUK_SELESAI, TGL_MASUK_MULAI, PANDU_MASUK, KELUAR_TUNDA1, KELUAR_TUNDA2, KELUAR_TUNDA3, TGL_KELUAR_MULAI, TGL_KELUAR_SELESAI, PANDU_KELUAR, JETY, AGEN,
					STATUS, CREATED_DATE, CREATED_BY,JENIS_LAYANAN, PEL_ASAL, PEL_TUJUAN, BENDERA)
 			  	VALUES (
				  '".$this->getField("PERIODE")."',
				  '".$this->getField("KODE_KAPAL")."',
				  ".($this->getField("LOA1")=="" ? 0 : str_replace(",",".",$this->getField("LOA1"))).",
				  ".($this->getField("GRT1")=="" ? 0 : str_replace(",",".",$this->getField("GRT1"))).",
				  ".($this->getField("DWT1")=="" ? 0 : str_replace(",",".",$this->getField("DWT1"))).",
				  '".$this->getField("TUBGOAT")."',
				  ".($this->getField("LOA2")=="" ? 0 : str_replace(",",".",$this->getField("LOA2"))).",
				  ".($this->getField("GRT2")=="" ? 0 : str_replace(",",".",$this->getField("GRT2"))).",
				  ".($this->getField("DWT2")=="" ? 0 : str_replace(",",".",$this->getField("DWT2"))).",
				  '".$this->getField("NAMA_CARGO")."',
				  ".(str_replace(",",".",$this->getField("BERAT_CARGO")) == "" ? 0 : str_replace(",",".",$this->getField("BERAT_CARGO")) ).",
				  '".$this->getField("NOMOR1A_MASUK")."',
				  '".$this->getField("NOMOR1A_KELUAR")."',
				  ".($this->getField("MASUK_TUNDA1")=="" ? 0 : $this->getField("MASUK_TUNDA1")).",
				  ".($this->getField("MASUK_TUNDA2")=="" ? 0 : $this->getField("MASUK_TUNDA2")).",
				  ".($this->getField("MASUK_TUNDA3")=="" ? 0 : $this->getField("MASUK_TUNDA3")).",
				  ".$this->getField("TGL_MASUK_SELESAI").",
				  ".$this->getField("TGL_MASUK_MULAI").",
				  ".$this->getField("PANDU_MASUK").",
				  ".($this->getField("KELUAR_TUNDA1")=="" ? 0 : $this->getField("KELUAR_TUNDA1")).",
				  ".($this->getField("KELUAR_TUNDA2")=="" ? 0 : $this->getField("KELUAR_TUNDA2")).",
				  ".($this->getField("KELUAR_TUNDA3")=="" ? 0 : $this->getField("KELUAR_TUNDA3")).",
				  ".$this->getField("TGL_KELUAR_MULAI").",
				  ".$this->getField("TGL_KELUAR_SELESAI").",
				  ".$this->getField("PANDU_KELUAR").",
				  '".$this->getField("JETY")."',
				  '".$this->getField("AGEN")."',
				  '".$this->getField("STATUS")."',
				  SYSDATE,
				  '".$this->getField("CREATED_BY")."',
				  '".$this->getField("JENIS_LAYANAN")."',
				  '".$this->getField("PEL_ASAL")."',
				  '".$this->getField("PEL_TUJUAN")."',
				  '".$this->getField("BENDERA")."'
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function insertMasterKapal()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ID_KEGIATAN", $this->getNextId("ID_KEGIATAN","MEKARPUTIH.XLS_KEGIATAN_KAPAL"));
		$str = " INSERT INTO MEKARPUTIH.KAPAL (KODE_KAPAL, JENIS_KAPAL_KODE, JENIS_PELAYARAN, NAMA_KAPAL, BENDERA, CALL_SIGN, GRT, DWT, LOA, HP, TIPE)
 			  	VALUES ('". $this->getField("KODE_KAPAL") ."',3,'Domestik','".$this->getField("NAMA_KAPAL")."','Indonesia',null,0,0,0,0,".$this->getField("TIPE_INSERT").")"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function getKapalId()
	{
		$str = "SELECT LPAD(MAX(KODE_KAPAL)+1,5,'0') AS ROWCOUNT FROM MEKARPUTIH.KAPAL
		        WHERE 0=0 "; 
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function update()
	{
		$str = " UPDATE MEKARPUTIH.XLS_KEGIATAN_KAPAL 
											SET PERIODE='".$this->getField("PERIODE")."',
											JENIS_LAYANAN='".$this->getField("JENIS_LAYANAN")."',
											KODE_KAPAL='".$this->getField("KODE_KAPAL")."',
											LOA1=".($this->getField("LOA1")=="" ? 0 : $this->getField("LOA1")).", 
											GRT1=".($this->getField("GRT1")=="" ? 0 : $this->getField("GRT1")).", 
											DWT1=".($this->getField("DWT1")=="" ? 0 : $this->getField("DWT1")).", 
											TUBGOAT='".$this->getField("TUBGOAT")."', 
											LOA2=".($this->getField("LOA2")=="" ? 0 : $this->getField("LOA2")).", 
											GRT2=".($this->getField("GRT2")=="" ? 0 : $this->getField("GRT2")).",
											DWT2=".($this->getField("DWT2")=="" ? 0 : $this->getField("DWT2")).", 
											NAMA_CARGO='".$this->getField("NAMA_CARGO")."',
											BERAT_CARGO=".$this->getField("BERAT_CARGO").",
											NOMOR1A_MASUK='".$this->getField("NOMOR1A_MASUK")."',
											NOMOR1A_KELUAR='".$this->getField("NOMOR1A_KELUAR")."',
											MASUK_TUNDA1=".($this->getField("MASUK_TUNDA1")=="" ? 0 : $this->getField("MASUK_TUNDA1")).",
											MASUK_TUNDA2=".($this->getField("MASUK_TUNDA2")=="" ? 0 : $this->getField("MASUK_TUNDA2")).",
											MASUK_TUNDA3=".($this->getField("MASUK_TUNDA3")=="" ? 0 : $this->getField("MASUK_TUNDA3")).",
											TGL_MASUK_SELESAI=".$this->getField("TGL_MASUK_SELESAI").",
											TGL_MASUK_MULAI=".$this->getField("TGL_MASUK_MULAI").",
											PANDU_MASUK=".$this->getField("PANDU_MASUK").",
											KELUAR_TUNDA1=".($this->getField("KELUAR_TUNDA1")=="" ? 0 : $this->getField("KELUAR_TUNDA1")).", 
											KELUAR_TUNDA2=".($this->getField("KELUAR_TUNDA2")=="" ? 0 : $this->getField("KELUAR_TUNDA2")).", 
											KELUAR_TUNDA3=".($this->getField("KELUAR_TUNDA3")=="" ? 0 : $this->getField("KELUAR_TUNDA3")).", 
											TGL_KELUAR_MULAI=".$this->getField("TGL_KELUAR_MULAI").",
											TGL_KELUAR_SELESAI=".$this->getField("TGL_KELUAR_SELESAI").", 
											PANDU_KELUAR=".$this->getField("PANDU_KELUAR").", 
											JETY='".$this->getField("JETY")."',
											AGEN='".$this->getField("AGEN")."',
											UPDATED_DATE=SYSDATE,
											UPDATED_BY='".$this->getField("CREATED_BY")."',
											PEL_ASAL='".$this->getField("PEL_ASAL")."',
											PEL_TUJUAN='".$this->getField("PEL_TUJUAN")."',
											JENIS_PELAYARAN = '".$this->getField("JENIS_PELAYARAN")."'
										WHERE ID_KEGIATAN = ".$this->getField("ID_KEGIATAN"); 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
		$str = "DELETE FROM MEKARPUTIH.XLS_KEGIATAN_KAPAL
                WHERE ID_KEGIATAN IN (SELECT ID_KEGIATAN
									FROM MEKARPUTIH.XLS_KEGIATAN_KAPAL A 
									LEFT JOIN MEKARPUTIH.V_PERMOHONAN_PPJP C ON A.NOMOR1A_MASUK = C.NO_PPKB1A_SANDAR AND A.NOMOR1A_KELUAR = C.NO_PPKB1A_LABUH
									WHERE ID_KEGIATAN = ".$this->getField("ID_KEGIATAN"). " AND C.NO_PERMOHONAN IS NULL) "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function approveOperasional()
	{
		$str = " UPDATE MEKARPUTIH.XLS_KEGIATAN_KAPAL 
											SET VERIFY_OPERASI_DATE=SYSDATE,
											VERIFY_OPERASI_BY = '".$this->getField("CREATED_BY")."'
										WHERE VERIFY_OPERASI_DATE IS NULL AND ID_KEGIATAN = ".$this->getField("ID_KEGIATAN"); 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function approveKomersial()
	{
		$str = " UPDATE MEKARPUTIH.XLS_KEGIATAN_KAPAL 
											SET VERIFY_KOMERSIAL_DATE=SYSDATE,
											VERIFY_KOMERSIAL_BY = '".$this->getField("CREATED_BY")."'
										WHERE VERIFY_KOMERSIAL_DATE IS NULL AND ID_KEGIATAN = ".$this->getField("ID_KEGIATAN"); 
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KODE_KAPAL ASC")
	{
		$str = "
					SELECT A.ID_KEGIATAN, C.NO_PERMOHONAN,
                    PERIODE, A.KODE_KAPAL, B.NAMA_KAPAL, LOA1, GRT1, DWT1, TUBGOAT TUGBOAT, LOA2, GRT2, DWT2, NAMA_CARGO, BERAT_CARGO, NOMOR1A_MASUK, NOMOR1A_KELUAR,
                    MASUK_TUNDA1, MASUK_TUNDA2, MASUK_TUNDA3, TO_CHAR(TGL_MASUK_SELESAI,'YYYY-MM-DD HH24:MI:SS') TGL_MASUK_SELESAI, TO_CHAR(TGL_MASUK_MULAI,'YYYY-MM-DD HH24:MI:SS') TGL_MASUK_MULAI,
                    PANDU_MASUK, KELUAR_TUNDA1, KELUAR_TUNDA2, KELUAR_TUNDA3, TO_CHAR(TGL_KELUAR_MULAI,'YYYY-MM-DD HH24:MI:SS') TGL_KELUAR_MULAI, 
                    TO_CHAR(TGL_KELUAR_SELESAI,'YYYY-MM-DD HH24:MI:SS') TGL_KELUAR_SELESAI,
                    PANDU_KELUAR, JETY, A.AGEN,
                    A.VERIFY_KOMERSIAL_DATE, A.VERIFY_KOMERSIAL_BY, A.VERIFY_OPERASI_DATE, A.VERIFY_OPERASI_BY,
                    a.CREATED_DATE, a.CREATED_BY, JENIS_LAYANAN,
                    ( SELECT SUM(X.JUMLAH) FROM MEKARPUTIH.V_TAGIHAN_REALISASI X WHERE X.NO_PERMOHONAN = C.NO_PERMOHONAN) JUMLAH,
                    CASE WHEN A.KODE_KAPAL IS NULL OR NAMA_CARGO IS NULL OR NVL(BERAT_CARGO,0) <=0 OR JETY IS NULL OR A.AGEN IS NULL OR JENIS_LAYANAN IS NULL OR A.VERIFY_OPERASI_BY IS NULL THEN
'TIDAK' ELSE 'YA' END VALID,
                    DECODE(D.NO_PERMOHONAN, null, 
                    decode(( SELECT SUM(X.JUMLAH) FROM MEKARPUTIH.V_TAGIHAN_REALISASI X WHERE X.NO_PERMOHONAN = C.NO_PERMOHONAN), null, 'Baru', 'Kalkulasi')
                    , 'Approve') STATUS, c.NAMA_AGEN, A.PEL_ASAL, A.PEL_TUJUAN, A.MASUK_KONDISI, A.KELUAR_KONDISI, A.BENDERA, D.NO_NOTA, C.VALUTA,
					D.KD_PELANGGAN, D.NAMA_PELANGGAN, A.JENIS_PELAYARAN
                    FROM MEKARPUTIH.XLS_KEGIATAN_KAPAL A 
                    LEFT JOIN MEKARPUTIH.V_MASTER_KAPAL B ON A.KODE_KAPAL = B.KODE_KAPAL
                    LEFT JOIN MEKARPUTIH.V_PERMOHONAN_PPJP C ON A.NOMOR1A_MASUK = C.NO_PPKB1A_SANDAR AND A.NOMOR1A_KELUAR = C.NO_PPKB1A_LABUH
                    LEFT JOIN MEKARPUTIH.INVOICE_HEADER D ON C.NO_PERMOHONAN = D.NO_PERMOHONAN
                    WHERE 0=0
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		//echo $str; exit;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByKapalPelanggan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KODE_KAPAL ASC")
	{
		$str = "
					SELECT KODE_KAPAL, NAMA_KAPAL, JENIS_KAPAL_KODE, JENIS_PELAYARAN, BENDERA, CALL_SIGN, GRT, DWT, LOA, HP 
						   FROM MEKARPUTIH.KAPAL
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
	
	function selectByPelanggan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY MPLG_NAMA ASC")
	{
		$str = "
					SELECT MPLG_KODE, MPLG_NAMA
						   FROM MEKARPUTIH.SIUK_PELANGGAN
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
	
	function selectByJetty($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KODE_JETI ASC")
	{
		$str = "
					SELECT KODE_JETI, NAMA_JETI, KETERANGAN
						   FROM MEKARPUTIH.JETI
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
	
	function selectByJenisKegiatan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY KODE_KEGIATAN ASC")
	{
		$str = "
					SELECT KODE_KEGIATAN, NAMA_KEGIATAN 
							FROM MEKARPUTIH.KEGIATAN
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
	
	function selectByPelabuhan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY NAMA_PELABUHAN ASC")
	{
		$str = "
					SELECT KODE_PELABUHAN, NAMA_PELABUHAN 
							FROM MEKARPUTIH.DAFTAR_PELABUHAN
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
	
	function selectByBarang($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY JENIS_MUATAN_KODE ASC")
	{
		$str = "
					SELECT JENIS_MUATAN_KODE, NAMA, KETERANGAN
						   FROM MEKARPUTIH.JENIS_MUATAN
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
	
	function selectByKondisiCuaca($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY nilai desc")
	{
		$str = "
					select nilai kode, nama from MEKARPUTIH.SISTEM_PARAMETER
					where kode = 'KONDISI_CUACA'
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
					SELECT ID_KEGIATAN,
					PERIODE, KODE_KAPAL, LOA1, GRT1, DWT1, TUBGOAT, LOA2, GRT2, DWT2, NAMA_CARGO, BERAT_CARGO, NOMOR1A_MASUK, NOMOR1A_KELUAR,
					MASUK_TUNDA1, MASUK_TUNDA2, TGL_MASUK_SELESAI, TGL_MASUK_MULAI, PANDU_MASUK, KELUAR_TUNDA1, KELUAR_TUNDA2, TGL_KELUAR_MULAI, TGL_KELUAR_SELESAI, PANDU_KELUAR, JETY, AGEN,
					STATUS, CREATED_DATE, CREATED_BY
					FROM MEKARPUTIH.XLS_KEGIATAN_KAPAL
					WHERE 0=0
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KODE_KAPAL ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.ID_KEGIATAN) AS ROWCOUNT FROM MEKARPUTIH.XLS_KEGIATAN_KAPAL A
				LEFT JOIN MEKARPUTIH.V_PERMOHONAN_PPJP D ON A.NOMOR1A_MASUK = D.NO_PPKB1A_SANDAR AND A.NOMOR1A_KELUAR = D.NO_PPKB1A_LABUH
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

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(ID_KEGIATAN) AS ROWCOUNT FROM IMEKARPUTIH.XLS_KEGIATAN_KAPAL
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
	
	function callPerhitunganMekarputih($periode, $userAction)
	{
		$str = "CALL MEKARPUTIH.GENERATE_DATA_REALISASI('". $periode ."', '".$userAction."')";
  
		$this->query = $str;
		$this->execQuery($str);

        $str = "CALL MEKARPUTIH.KALKULASI_PERIODE('". $periode ."')";
  
		$this->query = $str;
		//echo $str;
        return $this->execQuery($str);
    }
	
		function callForceKalkulasi($noPermohonan)
	{

        $str = "CALL MEKARPUTIH.KALKULASI_REALISASI_BIAYA('". $noPermohonan ."')";
  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function callKirimJurnal($periode, $noPermohonan, $noJPJ, $customerID, $userAction)
	{

        $str = "CALL MEKARPUTIH.KIRIM_JURNAL('". $periode ."','". $noPermohonan ."', '" . $noJPJ . "', '" . $customerID . "', substr('". $userAction ."',0,20))";
  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
		
  } 
?>