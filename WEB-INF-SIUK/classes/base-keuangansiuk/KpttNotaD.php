<? 
/* *******************************************************************************************************
MODUL NAME 			: IMASYS
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * EntitySIUK-base class untuk mengimplementasikan tabel KPTT_NOTA_D.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KpttNotaD extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KpttNotaD()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KPTT_NOTA_D_ID", $this->getNextId("KPTT_NOTA_D_ID","KPTT_NOTA_D")); 		
		
		$str = "
				INSERT INTO KPTT_NOTA_D (
					   KD_CABANG, KD_SUBSIS, JEN_JURNAL, 
					   TIPE_TRANS, NO_NOTA, LINE_SEQ, 
					   KLAS_TRANS, KWANTITAS, SATUAN, 
					   HARGA_SATUAN, TGL_VALUTA, KD_VALUTA, 
					   KURS_VALUTA, JML_VAL_TRANS, STATUS_KENA_PAJAK, 
					   JML_VAL_PAJAK, JML_RP_TRANS, JML_RP_PAJAK, 
					   JML_RP_SLSH_KURS, TANDA_TRANS, KD_BUKU_BESAR, 
					   KD_SUB_BANTU, KD_BUKU_PUSAT, KD_D_K, 
					   PREV_NO_NOTA, KET_TAMBAHAN, STATUS_PROSES, 
					   FLAG_JURNAL, NO_REF1, NO_REF2, REF_PEMBATALAN,
					   NO_REF3, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
					   PROGRAM_NAME, KD_TERMINAL, NL_TARIF, TAGIHAN, SISA, PERIODE_PEMBAYARAN) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_SUBSIS")."', '".$this->getField("JEN_JURNAL")."',
						'".$this->getField("TIPE_TRANS")."', '".$this->getField("NO_NOTA")."', '".$this->getField("LINE_SEQ")."',
						'".$this->getField("KLAS_TRANS")."', '".$this->getField("KWANTITAS")."', '".$this->getField("SATUAN")."',
						'".$this->getField("HARGA_SATUAN")."', ".$this->getField("TGL_VALUTA").", '".$this->getField("KD_VALUTA")."',
						".$this->getField("KURS_VALUTA").", ".$this->getField("JML_VAL_TRANS").", '".$this->getField("STATUS_KENA_PAJAK")."',
						'".$this->getField("JML_VAL_PAJAK")."', ".$this->getField("JML_RP_TRANS").", '".$this->getField("JML_RP_PAJAK")."',
						'".$this->getField("JML_RP_SLSH_KURS")."', '".$this->getField("TANDA_TRANS")."', '".$this->getField("KD_BUKU_BESAR")."',
						'".$this->getField("KD_SUB_BANTU")."', '".$this->getField("KD_BUKU_PUSAT")."', '".$this->getField("KD_D_K")."',
						'".$this->getField("PREV_NO_NOTA")."', '".$this->getField("KET_TAMBAHAN")."', '".$this->getField("STATUS_PROSES")."',
						'".$this->getField("FLAG_JURNAL")."', '".$this->getField("NO_REF1")."', '".$this->getField("NO_REF2")."', 
						'".$this->getField("REF_PEMBATALAN")."',
						'".$this->getField("NO_REF3")."', ".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."',
						'".$this->getField("PROGRAM_NAME")."', '".$this->getField("KD_TERMINAL")."', '".$this->getField("NL_TARIF")."', 
						'".$this->getField("TAGIHAN")."', '".$this->getField("SISA")."', '".$this->getField("PERIODE_PEMBAYARAN")."'
						)";
		$this->query = $str;
		//echo $str; exit;
		return $this->execQuery($str);
    }


	function insertSTIAMAK()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("KPTT_NOTA_D_ID", $this->getNextId("KPTT_NOTA_D_ID","KPTT_NOTA_D")); 		
		
		$str = "
				INSERT INTO KPTT_NOTA_D (
					   KD_CABANG, KD_SUBSIS, JEN_JURNAL, 
					   TIPE_TRANS, NO_NOTA, LINE_SEQ, 
					   KLAS_TRANS, KWANTITAS, SATUAN, 
					   HARGA_SATUAN, TGL_VALUTA, KD_VALUTA, 
					   KURS_VALUTA, JML_VAL_TRANS, STATUS_KENA_PAJAK, 
					   JML_VAL_PAJAK, JML_RP_TRANS, JML_RP_PAJAK, 
					   JML_RP_SLSH_KURS, TANDA_TRANS, KD_BUKU_BESAR, 
					   KD_SUB_BANTU, KD_BUKU_PUSAT, KD_D_K, 
					   PREV_NO_NOTA, KET_TAMBAHAN, STATUS_PROSES, 
					   FLAG_JURNAL, NO_REF1, NO_REF2, 
					   NO_REF3, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
					   PROGRAM_NAME, KD_TERMINAL, NL_TARIF, TAGIHAN, SISA, PERIODE_PEMBAYARAN) 
						SELECT '96', 'KPT', 'JPJ',
												'JPJ-KPT-01', '".$this->getField("NO_NOTA")."', '1',
												'SPP', '', '',
												'', TRUNC(SYSDATE), 'IDR',
												1, JUMLAH_SPP, '0',
												'0', JUMLAH_SPP, '0',
												'', '+', KODE_BB_SPP,
												MPLG_KODE, '000.00.00', 'K',
												'', '', '1',
												'', '0020/INV/IX-2019', '',
												'".$this->getField("NO_REF3")."', TRUNC(SYSDATE), 'Administrator',
												'KPTT_ENOTA_BARU_IMAIS', '', '', 
												JUMLAH_SPP, JUMLAH_SPP, '".$this->getField("PERIODE_PEMBAYARAN")."'
						FROM SISWA_SPP_TERAKHIR A 
						WHERE A.DEPARTEMEN_KELAS_ID = '70' 
						AND NOT EXISTS(SELECT 1 FROM KPTT_NOTA_D X WHERE X.KD_SUB_BANTU = A.MPLG_KODE AND X.PERIODE_PEMBAYARAN = '".$this->getField("PERIODE_PEMBAYARAN")."' AND NOT X.NO_NOTA = '".$this->getField("NO_NOTA")."' )
						AND NOT A.MPLG_KODE IN (".$this->getField("MPLG_KODE_HAPUS").")
			"; 									
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }


    function update()
	{
		$str = "
				UPDATE KPTT_NOTA_D
				SET    KD_CABANG         = '".$this->getField("KD_CABANG")."',
					   KD_SUBSIS         = '".$this->getField("KD_SUBSIS")."',
					   JEN_JURNAL        = '".$this->getField("JEN_JURNAL")."',
					   TIPE_TRANS        = '".$this->getField("TIPE_TRANS")."',
					   NO_NOTA           = '".$this->getField("NO_NOTA")."',
					   LINE_SEQ          = '".$this->getField("LINE_SEQ")."',
					   KLAS_TRANS        = '".$this->getField("KLAS_TRANS")."',
					   KWANTITAS         = '".$this->getField("KWANTITAS")."',
					   SATUAN            = '".$this->getField("SATUAN")."',
					   HARGA_SATUAN      = '".$this->getField("HARGA_SATUAN")."',
					   TGL_VALUTA        = ".$this->getField("TGL_VALUTA").",
					   KD_VALUTA         = '".$this->getField("KD_VALUTA")."',
					   KURS_VALUTA       = '".$this->getField("KURS_VALUTA")."',
					   JML_VAL_TRANS     = '".$this->getField("JML_VAL_TRANS")."',
					   STATUS_KENA_PAJAK = '".$this->getField("STATUS_KENA_PAJAK")."',
					   JML_VAL_PAJAK     = '".$this->getField("JML_VAL_PAJAK")."',
					   JML_RP_TRANS      = '".$this->getField("JML_RP_TRANS")."',
					   JML_RP_PAJAK      = '".$this->getField("JML_RP_PAJAK")."',
					   JML_RP_SLSH_KURS  = '".$this->getField("JML_RP_SLSH_KURS")."',
					   TANDA_TRANS       = '".$this->getField("TANDA_TRANS")."',
					   KD_BUKU_BESAR     = '".$this->getField("KD_BUKU_BESAR")."',
					   KD_SUB_BANTU      = '".$this->getField("KD_SUB_BANTU")."',
					   KD_BUKU_PUSAT     = '".$this->getField("KD_BUKU_PUSAT")."',
					   KD_D_K            = '".$this->getField("KD_D_K")."',
					   PREV_NO_NOTA      = '".$this->getField("PREV_NO_NOTA")."',
					   KET_TAMBAHAN      = '".$this->getField("KET_TAMBAHAN")."',
					   STATUS_PROSES     = '".$this->getField("STATUS_PROSES")."',
					   FLAG_JURNAL       = '".$this->getField("FLAG_JURNAL")."',
					   NO_REF1           = '".$this->getField("NO_REF1")."',
					   NO_REF2           = '".$this->getField("NO_REF2")."',
					   NO_REF3           = '".$this->getField("NO_REF3")."',
					   LAST_UPDATE_DATE  = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY   = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME      = '".$this->getField("PROGRAM_NAME")."',
					   KD_TERMINAL       = '".$this->getField("KD_TERMINAL")."',
					   NL_TARIF          = '".$this->getField("NL_TARIF")."'
				WHERE  KPTT_NOTA_D_ID = '".$this->getField("KPTT_NOTA_D_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function updatePembatalanSudahCetakNota()
	{
        $str = "UPDATE KPTT_NOTA_D SET
				STATUS_PROSES = 2
                WHERE 
                NO_NOTA = '".$this->getField("NO_NOTA")."' "; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }
	
	
	function callReportLb9($VBLNBUKU, $VTHNBUKU, $VMULAI, $VSAMPAI)
	{
        $str = "CALL PROSES_REPORT_LB9('$VBLNBUKU', '$VTHNBUKU', '$VMULAI', '$VSAMPAI')"; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }
	
	
	
	function updateRefPelunasan()
	{
        $str = "UPDATE KPTT_NOTA_D SET
				NO_REF_PELUNASAN = '".$this->getField("NO_REF_PELUNASAN")."',
				SISA = 0
                WHERE 
                NO_NOTA = '".$this->getField("NO_NOTA")."' AND 
				KD_SUB_BANTU = '".$this->getField("KD_SUB_BANTU")."' "; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }
		
	
	function updateBatalPelunasan()
	{
        $str = "UPDATE KPTT_NOTA_D A 
				SET SISA = TAGIHAN,
					NO_REF_PELUNASAN = NULL
				WHERE A.NO_REF_PELUNASAN = '".$this->getField("NO_NOTA")."' AND 
				NOT EXISTS(SELECT 1 FROM KPTT_NOTA_D X WHERE X.NO_NOTA = A.NO_REF_PELUNASAN AND X.KD_SUB_BANTU = A.KD_SUB_BANTU) "; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }
		

	
	function updateBatalPelunasanKarenaDiganti()
	{
        $str = "UPDATE KPTT_NOTA_D A 
				SET SISA = TAGIHAN
				WHERE A.NO_REF_PELUNASAN = '".$this->getField("NO_REF_PELUNASAN")."' AND KD_SUB_BANTU = '".$this->getField("KD_SUB_BANTU")."' "; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }
		

	function updateBatalPelunasanKoreksi()
	{
        $str = "UPDATE KPTT_NOTA_D A 
				SET SISA = TAGIHAN,
					NO_REF_PELUNASAN = NULL
				WHERE A.NO_REF_PELUNASAN = '".$this->getField("NO_NOTA")."' AND 
				NOT EXISTS(SELECT 1 FROM KPTT_NOTA_D X WHERE X.NO_NOTA = A.NO_REF_PELUNASAN AND X.NO_REF2 = A.KD_SUB_BANTU) "; 
				  
		$this->query = $str;
		
        return $this->execQuery($str);
    }
		
	function delete()
	{
        $str = "DELETE FROM KPTT_NOTA_D
                WHERE 
                  NO_NOTA = '".$this->getField("NO_NOTA")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY KD_SUBSIS ASC")
	{
		$str = "
				SELECT KD_CABANG, KD_SUBSIS, JEN_JURNAL, 
				A.TIPE_TRANS, NO_NOTA, LINE_SEQ, 
				KLAS_TRANS, KWANTITAS, SATUAN, 
				HARGA_SATUAN, TGL_VALUTA, KD_VALUTA, 
				KURS_VALUTA, JML_VAL_TRANS, CASE WHEN STATUS_KENA_PAJAK = '0' THEN 'N' ELSE 'Y' END STATUS_KENA_PAJAK, 
				CASE WHEN STATUS_KENA_PAJAK = '0' THEN 'TIDAK' ELSE 'YA' END STATUS_KENA_PAJAK_DESC,
				JML_VAL_PAJAK, JML_RP_TRANS, JML_RP_PAJAK, JML_VAL_TRANS + JML_VAL_PAJAK JUMLAH_TOTAL,
				JML_RP_SLSH_KURS, TANDA_TRANS, KD_BUKU_BESAR, 
				KD_SUB_BANTU, KD_BUKU_PUSAT, KD_D_K, 
				PREV_NO_NOTA, KET_TAMBAHAN, STATUS_PROSES, 
				FLAG_JURNAL, NO_REF1, NO_REF2, 
				NO_REF3, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, KD_TERMINAL, NL_TARIF
				FROM KPTT_NOTA_D A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsDaftarSiswa($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.KD_SUB_BANTU ASC")
	{
		$str = "
				SELECT A.NO_NOTA, A.KD_SUB_BANTU, A.KD_SUB_BANTU ||' - ' || C.NM_SUB_BANTU NM_SUB_BANTU, 
				A.KD_SUB_BANTU ||' - ' || C.NM_SUB_BANTU ||' - ' || A.NO_NOTA NM_SUB_BANTU_JPJ
				FROM KPTT_NOTA_D A
                INNER JOIN KPTT_NOTA B ON A.NO_NOTA = B.NO_NOTA
                INNER JOIN KBBR_KARTU_TAMBAH C ON A.KD_SUB_BANTU = C.KD_SUB_BANTU
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsDaftarSiswaBB($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.NIS ASC")
	{
		$str = "
				SELECT 
				NIS KD_SUB_BANTU, NIS || ' - ' || NAMA NM_SUB_BANTU, SEKOLAH
				FROM SISWA_INFORMASI_BB_TAGIHAN A
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectDaftarTagihanSPP($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY NO_NOTA ASC")
	{
		$str = "
			SELECT 
				NO_NOTA, BLN_BUKU, THN_BUKU, BLN_BUKU || THN_BUKU PERIODE,
				   KD_SUB_BANTU, NM_SUB_BANTU, TGL_TRANS, KD_BUKU_BESAR, 
				   TAGIHAN, SISA
			FROM DAFTAR_TAGIHAN_SPP A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectDaftarTagihanSPPKelas($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder= " ORDER BY NM_SUB_BANTU ASC, thn_buku ASC, bln_buku ASC ")
	{
		$str = "
			SELECT 
				NO_NOTA, BLN_BUKU, THN_BUKU, BLN_BUKU || THN_BUKU PERIODE,
				   KD_SUB_BANTU, NM_SUB_BANTU, TGL_TRANS, KD_BUKU_BESAR, 
				   TAGIHAN, SISA
			FROM DAFTAR_TAGIHAN_SPP_KELAS A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
	
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectDaftarTagihanSPPKelasMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder= " ORDER BY NM_SUB_BANTU ASC, thn_buku ASC, bln_buku ASC ")
	{
		$str = "
			SELECT 
				NO_NOTA, BLN_BUKU, THN_BUKU, BLN_BUKU || THN_BUKU PERIODE,
                   KD_SUB_BANTU, NM_SUB_BANTU, TGL_TRANS, A.KD_BUKU_BESAR, 
                   TAGIHAN, SISA, B.NAMA_KELAS, 
                   C.KD_BUKU_BESAR KD_BUKU_BESAR_KAS, C.NM_BUKU_BESAR NM_BUKU_BESAR_KAS, JENIS_TRANSAKSI
            FROM DAFTAR_TAGIHAN_KOMBINASI A
            LEFT JOIN DEPARTEMEN_KELAS B ON A.DEPARTEMEN_KELAS_ID = B.DEPARTEMEN_KELAS_ID
            LEFT JOIN KBBR_BUKU_BESAR C ON REPLACE(A.KD_BUKU_BESAR, SUBSTR(A.KD_BUKU_BESAR,1, 6), '101.02') = C.KD_BUKU_BESAR
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
	//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }


             
    function getCountByParamsDaftarTagihanSPPKelas($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM DAFTAR_TAGIHAN_SPP_KELAS A
		        WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }


    function selectDaftarBayarTagihanSPPKelas($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder= " ORDER BY NM_SUB_BANTU ASC, thn_buku DESC, bln_buku DESC ")
	{
		$str = "
			SELECT 
				NO_NOTA, BLN_BUKU, THN_BUKU, BLN_BUKU || THN_BUKU PERIODE,
				   KD_SUB_BANTU, NM_SUB_BANTU, TGL_TRANS, KD_BUKU_BESAR, 
				   TAGIHAN, SISA, NO_REF_PELUNASAN
			FROM DAFTAR_BAYAR_TAGIHAN_SPP_KELAS A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->query = $str;
	
		$str .= $statement." ".$sOrder;
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectDaftarTagihanNONSPPKelas($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder= " ORDER BY NM_SUB_BANTU ASC, thn_buku ASC, bln_buku ASC ")
	{
		$str = "
			SELECT 
				NO_NOTA, BLN_BUKU, THN_BUKU, BLN_BUKU || THN_BUKU PERIODE,
				   KD_SUB_BANTU, NM_SUB_BANTU, TGL_TRANS, KD_BUKU_BESAR, 
				   TAGIHAN, SISA
			FROM DAFTAR_TAGIHAN_NONSPP_KELAS A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
	
		return $this->selectLimit($str,$limit,$from); 
    }
	
		
    function selectDaftarTagihanJKMPembatalanPelunasan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder= " ORDER BY C.NM_SUB_BANTU ASC ")
	{
		$str = "
			SELECT A.NO_NOTA, B.BLN_BUKU, B.THN_BUKU, B.BLN_BUKU || B.THN_BUKU PERIODE, 
                   A.KD_SUB_BANTU, C.NM_SUB_BANTU, B.TGL_TRANS, A.KD_BUKU_BESAR, 
                   A.TAGIHAN, A.SISA, A.PREV_NO_NOTA, D.KLAS_TRANS, D.KD_BUKU_BESAR KD_BUKU_BESAR_JPJ
                FROM KPTT_NOTA_D A 
                INNER JOIN KPTT_NOTA B ON A.NO_NOTA = B.NO_NOTA 
                INNER JOIN KBBR_KARTU_TAMBAH C ON A.KD_SUB_BANTU = C.KD_SUB_BANTU
        		INNER JOIN KPTT_NOTA_D D ON A.PREV_NO_NOTA = D.NO_NOTA AND A.KD_SUB_BANTU = D.KD_SUB_BANTU
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectDaftarTagihanJPJPembatalanTagihan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder= " ORDER BY C.NM_SUB_BANTU ASC ")
	{
		$str = "
			SELECT A.NO_NOTA, A.KLAS_TRANS, B.BLN_BUKU, B.THN_BUKU, B.BLN_BUKU || B.THN_BUKU PERIODE, 
                   A.KD_SUB_BANTU, C.NM_SUB_BANTU, B.TGL_TRANS, A.KD_BUKU_BESAR, 
                   A.TAGIHAN, A.SISA, (SELECT MAX(X.NO_NOTA) FROM KPTT_NOTA_D X WHERE X.PREV_NO_NOTA = A.NO_NOTA AND X.KD_SUB_BANTU = A.KD_SUB_BANTU) PREV_NO_NOTA
                FROM KPTT_NOTA_D A 
                INNER JOIN KPTT_NOTA B ON A.NO_NOTA = B.NO_NOTA 
                INNER JOIN KBBR_KARTU_TAMBAH C ON A.KD_SUB_BANTU = C.KD_SUB_BANTU
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
	
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectDaftarTagihanSPPKelasV2($noJKM, $paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder= " ORDER BY 6,3,2 ")
	{
		$str = "
			SELECT 
				NO_NOTA, BLN_BUKU, THN_BUKU, BLN_BUKU || THN_BUKU PERIODE,
				   KD_SUB_BANTU, NM_SUB_BANTU, TGL_TRANS, KD_BUKU_BESAR, 
				   TAGIHAN, SISA
			FROM DAFTAR_TAGIHAN_SPP_KELAS A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." 
		
		UNION ALL
		SELECT A.NO_NOTA, B.BLN_BUKU, B.THN_BUKU, B.BLN_BUKU || B.THN_BUKU PERIODE, 
		   A.KD_SUB_BANTU, C.NM_SUB_BANTU, B.TGL_TRANS, A.KD_BUKU_BESAR, 
		   A.TAGIHAN, A.SISA 
		FROM KPTT_NOTA_D A 
		INNER JOIN KPTT_NOTA B ON A.NO_NOTA = B.NO_NOTA 
		INNER JOIN KBBR_KARTU_TAMBAH C ON A.KD_SUB_BANTU = C.KD_SUB_BANTU
		WHERE NO_REF_PELUNASAN = '".$noJKM."'
		";
		$this->query = $str;
	
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
    function selectByParamsJpjPembayaran($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY KD_SUBSIS ASC")
	{
		$str = "
				SELECT A.KD_CABANG, KD_SUBSIS, JEN_JURNAL, MPLG_NAMA,  MPLG_KODE, 
				A.TIPE_TRANS, NO_NOTA, LINE_SEQ, 
				KLAS_TRANS, KWANTITAS, SATUAN, 
				HARGA_SATUAN, TGL_VALUTA, KD_VALUTA, 
				KURS_VALUTA, JML_VAL_TRANS, CASE WHEN STATUS_KENA_PAJAK = '0' THEN 'N' ELSE 'Y' END STATUS_KENA_PAJAK, 
				CASE WHEN STATUS_KENA_PAJAK = '0' THEN 'TIDAK' ELSE 'YA' END STATUS_KENA_PAJAK_DESC,
                JML_VAL_PAJAK, JML_RP_TRANS, JML_RP_PAJAK, JML_VAL_TRANS + JML_VAL_PAJAK JUMLAH_TOTAL,
                JML_RP_SLSH_KURS, TANDA_TRANS, KD_BUKU_BESAR, 
                KD_SUB_BANTU, KD_BUKU_PUSAT, KD_D_K, 
                PREV_NO_NOTA, KET_TAMBAHAN, STATUS_PROSES, 
                FLAG_JURNAL, NO_REF1, NO_REF2, 
                NO_REF3, LAST_UPDATE_DATE, A.LAST_UPDATED_BY, 
                A.PROGRAM_NAME, KD_TERMINAL, NL_TARIF
                FROM KPTT_NOTA_D A
                LEFT JOIN SAFM_PELANGGAN B ON A.KD_SUB_BANTU = B.MPLG_KODE
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPelunasanKasBank($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.KD_SUBSIS ASC")
	{
		$str = "
				SELECT A.KD_CABANG, A.KD_SUBSIS, A.JEN_JURNAL, 
				A.TIPE_TRANS, A.NO_NOTA, LINE_SEQ, 
				KLAS_TRANS, KWANTITAS, SATUAN, 
				HARGA_SATUAN, A.TGL_VALUTA, A.KD_VALUTA, 
				A.KURS_VALUTA, A.JML_VAL_TRANS, CASE WHEN STATUS_KENA_PAJAK = '0' THEN 'N' ELSE 'Y' END STATUS_KENA_PAJAK, 
				A.JML_VAL_PAJAK, A.JML_RP_TRANS, A.JML_RP_PAJAK, A.JML_RP_TRANS + A.JML_RP_PAJAK JUMLAH_TOTAL,
				JML_RP_SLSH_KURS, A.TANDA_TRANS, KD_BUKU_BESAR, 
				KD_SUB_BANTU, KD_BUKU_PUSAT, KD_D_K, 
				PREV_NO_NOTA, A.KET_TAMBAHAN, A.STATUS_PROSES, 
				FLAG_JURNAL, A.NO_REF1, A.NO_REF2, B.TGL_JT_TEMPO,
				A.NO_REF3, NL_TARIF, C.MPLG_NAMA, TGL_TRANS, B.JML_TAGIHAN JML_TAGIHAN, B.KD_BB_KUSTO, SISA_TAGIHAN
				FROM KPTT_NOTA_D A INNER JOIN KPTT_NOTA B ON A.NO_REF3 = B.NO_REF3
                INNER JOIN SAFM_PELANGGAN C ON C.MPLG_KODE = B.KD_KUSTO
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$sOrder;
		//echo $str;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    } 



    function selectByParamsPembatalanKasBank($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.KD_SUBSIS ASC")
	{
		$str = "
				SELECT   DISTINCT A.KD_CABANG, A.KD_SUBSIS, A.JEN_JURNAL, A.TIPE_TRANS, A.NO_NOTA,
				         A.LINE_SEQ, A.KLAS_TRANS, A.KWANTITAS, A.SATUAN, A.HARGA_SATUAN, A.TGL_VALUTA,
				         A.KD_VALUTA, A.KURS_VALUTA, A.JML_VAL_TRANS,
				         CASE
				            WHEN STATUS_KENA_PAJAK = '0'
				               THEN 'N'
				            ELSE 'Y'
				         END STATUS_KENA_PAJAK, A.JML_VAL_PAJAK, A.JML_RP_TRANS,
				         A.JML_RP_PAJAK, A.JML_RP_TRANS + A.JML_RP_PAJAK JUMLAH_TOTAL,
				         A.JML_RP_SLSH_KURS, A.TANDA_TRANS, A.KD_BUKU_BESAR, A.KD_SUB_BANTU,
				         A.KD_BUKU_PUSAT, A.KD_D_K, A.PREV_NO_NOTA, A.KET_TAMBAHAN, A.STATUS_PROSES,
				         FLAG_JURNAL, A.NO_REF1, A.NO_REF2, E.TGL_JT_TEMPO, A.NO_REF3,
				         NL_TARIF, C.MPLG_NAMA, E.TGL_TRANS, D.TAGIHAN JML_TAGIHAN,
				         B.KD_BB_KUSTO, D.TAGIHAN SISA_TAGIHAN
				    FROM KPTT_NOTA_D A INNER JOIN KPTT_NOTA B ON A.NO_NOTA = B.NO_NOTA
				         LEFT JOIN SAFM_PELANGGAN C ON C.MPLG_KODE = B.KD_KUSTO
				         LEFT JOIN KPTT_NOTA_D D ON B.PREV_NOTA_UPDATE = D.NO_NOTA AND A.KD_SUB_BANTU = D.KD_SUB_BANTU
				         LEFT JOIN KPTT_NOTA E ON D.NO_NOTA = E.NO_NOTA
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$sOrder;
		//echo $str;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    } 



    function selectByParamsPelunasanPembayaran($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.KD_SUBSIS ASC")
	{
		$str = "
				SELECT A.KD_CABANG, A.KD_SUBSIS, A.JEN_JURNAL, 
				A.TIPE_TRANS, A.NO_NOTA, LINE_SEQ, 
				KLAS_TRANS, KWANTITAS, SATUAN, 
				HARGA_SATUAN, A.TGL_VALUTA, A.KD_VALUTA, 
				A.KURS_VALUTA, A.JML_VAL_TRANS, CASE WHEN STATUS_KENA_PAJAK = '0' THEN 'N' ELSE 'Y' END STATUS_KENA_PAJAK, 
				A.JML_VAL_PAJAK, A.JML_RP_TRANS, A.JML_RP_PAJAK, A.JML_RP_TRANS + A.JML_RP_PAJAK JUMLAH_TOTAL,
				JML_RP_SLSH_KURS, A.TANDA_TRANS, A.KD_BUKU_BESAR, 
				KD_SUB_BANTU, KD_BUKU_PUSAT, KD_D_K, 
				PREV_NO_NOTA, A.KET_TAMBAHAN, A.STATUS_PROSES, 
				FLAG_JURNAL, A.NO_REF1, A.NO_REF2, B.TGL_JT_TEMPO,
				A.NO_REF3, NL_TARIF, C.MPLG_NAMA, TGL_TRANS, B.JML_TAGIHAN JML_TAGIHAN, B.KD_BB_KUSTO, SISA_TAGIHAN, A.TAGIHAN, A.SISA
				FROM KPTT_NOTA_D A INNER JOIN KPTT_NOTA B ON A.NO_REF3 = B.NO_REF3
                INNER JOIN SAFM_PELANGGAN C ON C.MPLG_KODE = A.KD_SUB_BANTU
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$sOrder;
		//echo $str;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    } 


    function selectByParamsPelunasanPembayaranV2($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.KD_SUBSIS ASC")
	{
		$str = "
				SELECT   A.KD_CABANG, A.KD_SUBSIS, A.JEN_JURNAL, A.TIPE_TRANS, A.NO_NOTA,
				 A.LINE_SEQ, A.KLAS_TRANS, A.KWANTITAS, A.SATUAN, A.HARGA_SATUAN, A.TGL_VALUTA,
				 A.KD_VALUTA, A.KURS_VALUTA, A.JML_VAL_TRANS,
				 CASE
					WHEN A.STATUS_KENA_PAJAK = '0'
					   THEN 'N'
					ELSE 'Y'
				 END STATUS_KENA_PAJAK, A.JML_VAL_PAJAK, A.JML_RP_TRANS,
				 A.JML_RP_PAJAK, A.JML_RP_TRANS + A.JML_RP_PAJAK JUMLAH_TOTAL,
				 A.JML_RP_SLSH_KURS, A.TANDA_TRANS, A.KD_BUKU_BESAR, A.KD_SUB_BANTU,
				 A.KD_BUKU_PUSAT, A.KD_D_K, A.PREV_NO_NOTA, A.KET_TAMBAHAN, A.STATUS_PROSES,
				 A.NO_REF1, A.NO_REF2, A.NO_REF3,
				 A.NL_TARIF, C.MPLG_NAMA, B.TGL_VALUTA TGL_TRANS, B.TAGIHAN JML_TAGIHAN,
				  B.SISA SISA_TAGIHAN, B.TAGIHAN, B.SISA
				FROM KPTT_NOTA_D A INNER JOIN KPTT_NOTA_D B ON A.PREV_NO_NOTA = B.NO_NOTA AND A.KD_SUB_BANTU = B.KD_SUB_BANTU
				 INNER JOIN SAFM_PELANGGAN C ON C.MPLG_KODE = A.KD_SUB_BANTU
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$sOrder;
		//echo $str;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    } 
	
    function getCountByParamsPelunasanPembayaranV2($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KPTT_NOTA_D_ID) AS ROWCOUNT 
				FROM KPTT_NOTA_D A INNER JOIN KPTT_NOTA_D B ON A.PREV_NO_NOTA = B.NO_NOTA AND A.KD_SUB_BANTU = B.KD_SUB_BANTU
				 INNER JOIN SAFM_PELANGGAN C ON C.MPLG_KODE = A.KD_SUB_BANTU
		        WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

	
    function selectByParamsKoreksiPelunasanJRR($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.KD_SUBSIS ASC")
	{
		$str = "
				SELECT   A.KD_CABANG, A.KD_SUBSIS, A.JEN_JURNAL, A.TIPE_TRANS, A.NO_NOTA,
				 A.LINE_SEQ, A.KLAS_TRANS, A.KWANTITAS, A.SATUAN, A.HARGA_SATUAN, A.TGL_VALUTA,
				 A.KD_VALUTA, A.KURS_VALUTA, A.JML_VAL_TRANS,
				 CASE
					WHEN A.STATUS_KENA_PAJAK = '0'
                       THEN 'N'
                    ELSE 'Y'
                 END STATUS_KENA_PAJAK, A.JML_VAL_PAJAK, A.JML_RP_TRANS,
                 A.JML_RP_PAJAK, A.JML_RP_TRANS + A.JML_RP_PAJAK JUMLAH_TOTAL,
                 A.JML_RP_SLSH_KURS, A.TANDA_TRANS, A.KD_BUKU_BESAR, A.KD_SUB_BANTU,
                 A.KD_BUKU_PUSAT, A.KD_D_K, A.PREV_NO_NOTA, A.KET_TAMBAHAN, A.STATUS_PROSES,
                 A.NO_REF1, A.NO_REF2, A.NO_REF3,
                 A.NL_TARIF, C.MPLG_NAMA, A.TGL_VALUTA TGL_TRANS, A.TAGIHAN JML_TAGIHAN,
                  A.SISA SISA_TAGIHAN, A.TAGIHAN, A.SISA, A.REF_PEMBATALAN
                FROM KPTT_NOTA_D A 
                 INNER JOIN SAFM_PELANGGAN C ON C.MPLG_KODE = A.KD_SUB_BANTU
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$sOrder;
		//echo $str;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    } 
		
				
    function selectByParamsKompensasiSisaUperPencarian($paramsArray=array(),$limit=-1,$from=-1, $kusto="", $valuta="", $sOrder=" ORDER BY SISA_TAGIHAN ASC ", $statement="")
	{
		$str = "
				SELECT NO_PPKB, KARTU, NO_REF1, TGL_TRANS, TGL_JT_TEMPO, JML_WD_UPPER, SISA_TAGIHAN, JUMLAH_DIBAYAR, JNS_JUAL, NO_NOTA
				FROM 
				(
				SELECT NO_REF3 NO_PPKB, '00000' KARTU, NO_REF1, TGL_TRANS, TGL_JT_TEMPO, JML_WD_UPPER, SISA_TAGIHAN, SISA_TAGIHAN JUMLAH_DIBAYAR, JNS_JUAL, NO_NOTA
				FROM KPTT_NOTA
				WHERE JEN_JURNAL='JPJ' AND 
				KD_KUSTO  = '".$kusto."' AND
				KD_VALUTA = '".$valuta."' AND NVL(SISA_TAGIHAN,0)>0  AND
				STATUS_PROSES='1' AND
				CETAK_NOTA<>0 
				UNION ALL
				SELECT A.NO_REF3 NO_PPKB, '00000' KARTU, A.NO_REF1, A.TGL_TRANS, A.TGL_JT_TEMPO, A.JML_WD_UPPER, B.SALDO_VAL_KREDIT SISA_VAL_BAYAR, B.SALDO_VAL_KREDIT SISA_VAL_BAYAR, A.JNS_JUAL, A.NO_NOTA
				FROM KPTT_NOTA A, KBBT_JUR_BB_D B
				WHERE JEN_JURNAL='JPJ' AND 
				A.NO_NOTA = B.NO_NOTA AND
				B.KLAS_TRANS = 'SISAUPER' AND   
				A.KD_KUSTO  = '".$kusto."' AND
				A.KD_VALUTA = '".$valuta."' AND
				A.STATUS_PROSES='1' AND
				CETAK_NOTA<>0
				)
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}	
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    } 	
	
    function selectByParamsKompensasiSisaUper($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.KD_SUBSIS ASC")
	{
		$str = "
				SELECT A.KD_CABANG, A.KD_SUBSIS, A.JEN_JURNAL, 
				A.TIPE_TRANS, A.NO_NOTA, LINE_SEQ, 
				KLAS_TRANS, KWANTITAS, SATUAN, 
				HARGA_SATUAN, A.TGL_VALUTA, A.KD_VALUTA, 
				A.KURS_VALUTA, A.JML_VAL_TRANS, CASE WHEN STATUS_KENA_PAJAK = '0' THEN 'N' ELSE 'Y' END STATUS_KENA_PAJAK, 
				A.JML_VAL_PAJAK, A.JML_RP_TRANS, A.JML_RP_PAJAK, A.JML_RP_TRANS + A.JML_RP_PAJAK JUMLAH_TOTAL,
				JML_RP_SLSH_KURS, A.TANDA_TRANS, KD_BUKU_BESAR, 
				KD_SUB_BANTU, KD_BUKU_PUSAT, KD_D_K, 
				PREV_NO_NOTA, A.KET_TAMBAHAN, A.STATUS_PROSES, 
				FLAG_JURNAL, A.NO_REF1, A.NO_REF2, 
				A.NO_REF3, NL_TARIF, TGL_TRANS, JML_TAGIHAN
				FROM KPTT_NOTA_D A INNER JOIN KPTT_NOTA B ON A.NO_NOTA = B.NO_NOTA
                INNER JOIN SAFM_PELANGGAN C ON C.MPLG_KODE = B.KD_KUSTO
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}	
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    } 	
	
	
    function selectByParamsDaftarTitipan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY A.TGL_POSTING ASC")
	{
		$str = "
				SELECT 
					NO_NOTA, KD_BUKU_BESAR, TGL_POSTING, 
					   KD_SUB_BANTU, SISWA, UANG_TITIPAN, 
					   KET_TAMBAH
					FROM DAFTAR_TITIPAN_SISWA A
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}	
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		
		return $this->selectLimit($str,$limit,$from); 
    } 	
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_SUBSIS, JEN_JURNAL, 
				TIPE_TRANS, NO_NOTA, LINE_SEQ, 
				KLAS_TRANS, KWANTITAS, SATUAN, 
				HARGA_SATUAN, TGL_VALUTA, KD_VALUTA, 
				KURS_VALUTA, JML_VAL_TRANS, STATUS_KENA_PAJAK, 
				JML_VAL_PAJAK, JML_RP_TRANS, JML_RP_PAJAK, 
				JML_RP_SLSH_KURS, TANDA_TRANS, KD_BUKU_BESAR, 
				KD_SUB_BANTU, KD_BUKU_PUSAT, KD_D_K, 
				PREV_NO_NOTA, KET_TAMBAHAN, STATUS_PROSES, 
				FLAG_JURNAL, NO_REF1, NO_REF2, 
				NO_REF3, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, KD_TERMINAL, NL_TARIF
				FROM KPTT_NOTA_D
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NO_JUDUL ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
    function getCountByParamsDaftarTitipan($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM DAFTAR_TITIPAN_SISWA A
		        WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }


    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KPTT_NOTA_D_ID) AS ROWCOUNT FROM KPTT_NOTA_D
		        WHERE KPTT_NOTA_D_ID IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsKompensasiSisaUperPencarian($paramsArray=array(), $statement="", $kusto="", $valuta="")
	{
		$str = "
				SELECT COUNT(1) ROWCOUNT FROM
				(
				SELECT NO_REF3 NO_PPKB, '00000' KARTU, NO_REF1, TGL_TRANS, TGL_JT_TEMPO, JML_WD_UPPER, SISA_TAGIHAN, SISA_TAGIHAN JUMLAH_DIBAYAR, JNS_JUAL, NO_NOTA
				FROM KPTT_NOTA
				WHERE JEN_JURNAL='JPJ' AND 
				KD_KUSTO  = '".$kusto."' AND
				KD_VALUTA = '".$valuta."' AND NVL(SISA_TAGIHAN,0)>0  AND
				STATUS_PROSES='1' AND
				CETAK_NOTA<>0 
				UNION ALL
				SELECT A.NO_REF3 NO_PPKB, '00000' KARTU, A.NO_REF1, A.TGL_TRANS, A.TGL_JT_TEMPO, A.JML_WD_UPPER, B.SALDO_VAL_KREDIT SISA_VAL_BAYAR, B.SALDO_VAL_KREDIT SISA_VAL_BAYAR, A.JNS_JUAL, A.NO_NOTA
				FROM KPTT_NOTA A, KBBT_JUR_BB_D B
				WHERE JEN_JURNAL='JPJ' AND 
				A.NO_NOTA = B.NO_NOTA AND
				B.KLAS_TRANS = 'SISAUPER' AND   
				A.KD_KUSTO  = '".$kusto."' AND
				A.KD_VALUTA = '".$valuta."' AND
				A.STATUS_PROSES='1' AND
				CETAK_NOTA<>0 ) WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KPTT_NOTA_D_ID) AS ROWCOUNT FROM KPTT_NOTA_D
		        WHERE KPTT_NOTA_D_ID IS NOT NULL ".$statement; 
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