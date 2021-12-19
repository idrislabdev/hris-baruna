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
  * EntitySIUK-base class untuk mengimplementasikan tabel SAFM_BANK.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class Pajak extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Pajak()
	{
      $this->EntitySIUK(); 
    }
	
	/** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParamsPph4Ayat2($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ")
	{
		$str = "
				SELECT THN_BUKU, BLN_BUKU, KODE_REKENING, NAMA_REKENING, JKM, 
					 JKK, KETERANGAN, NULL JENIS_JASA, NAMA_WP, NPWP, BP_NOMOR, 
					 BP_TANGGAL, BAHAN, JASA, TOTAL_BIAYA, OBYEK_PPH, 
					 TARIF_EFEKTIF, JUMLAH_PPH_DIPOTONG, NO_POSTING
				FROM LAPORAN_PPH_4_2 
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
	
	function selectByParamsPph15($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ")
	{
		$str = "
				SELECT THN_BUKU, BLN_BUKU, KODE_REKENING, NAMA_REKENING, JKM, 
					 JKK, KETERANGAN, NULL JENIS_JASA, NAMA_WP, NPWP, BP_NOMOR, 
					 BP_TANGGAL, BAHAN, JASA, TOTAL_BIAYA, OBYEK_PPH, 
					 TARIF_EFEKTIF, JUMLAH_PPH_DIPOTONG, NO_POSTING
				FROM LAPORAN_PPH_15
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
	
	function selectByParamsPph23($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ")
	{
		$str = "
				SELECT THN_BUKU, BLN_BUKU, KODE_REKENING, NAMA_REKENING, JKM, 
					 JKK, KETERANGAN, NULL JENIS_JASA, NAMA_WP, NPWP, BP_NOMOR, 
					 BP_TANGGAL, BAHAN, JASA, TOTAL_BIAYA, OBYEK_PPH, 
					 TARIF_EFEKTIF, JUMLAH_PPH_DIPOTONG, NO_POSTING
				FROM LAPORAN_PPH_23
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

	function selectByParamsPph21Pegawai($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ")
	{
		$str = "
				SELECT 
				   A.PEGAWAI_ID, A.NAMA, A.NRP, A.PERIODE, MERIT_PMS + TUNJANGAN_PERBANTUAN PENGHASILAN, TUNJANGAN_JABATAN, TPP_PMS,       
				   JUMLAH_GAJI_KOTOR, POTONGAN_PPH21, 
				   B.JUMLAH UANG_MAKAN, B.BANTUAN_PPH UANG_MAKAN_PPH, 
				   C.JUMLAH UANG_TRANSPORT, C.BANTUAN_PPH UANG_TRANSPORT_PPH,
				   D.JUMLAH UANG_INSENTIF, D.JUMLAH_PPH UANG_INSENTIF_PPH 
				FROM IMASYS_GAJI.GAJI_AWAL_BULAN_REPORT A
				LEFT JOIN IMASYS_GAJI.UANG_MAKAN_KAPAL_REPORT B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND A.PERIODE = B.PERIODE
				LEFT JOIN IMASYS_GAJI.UANG_TRANSPORT_REPORT C ON A.PEGAWAI_ID = C.PEGAWAI_ID AND A.PERIODE = C.PERIODE
				LEFT JOIN IMASYS_GAJI.INSENTIF_REPORT D ON A.PEGAWAI_ID = D.PEGAWAI_ID AND A.PERIODE = D.PERIODE
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
		
	function selectByParamsPpn($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ")
	{
		$str = "
				SELECT 
				KODE_REK, NAMA_REK, NO_NOTA, 
				   KETERANGAN, JENIS_JASA, NAMA_WP, 
				   NPWP_WP, DPP_REK, DPP, DPP_REK_JML, 
				   JUMLAH_PPN, BLN_BUKU, THN_BUKU, 
				   FAKTUR_PAJAK, TGL_FAKTUR_PAJAK, TGL_POSTING, 
				   NO_POSTING
				FROM LAPORAN_PPN
				WHERE 1 = 1 AND DPP > 0
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
				SELECT KD_CABANG, JENIS_TABLE, ID_TABLE, 
				MBANK_KODE, MBANK_NAMA, MBANK_CABANG, 
				MBANK_ALAMAT, MBANK_NO_TELEPON, MBANK_CONT_PERSON_1, 
				MBANK_CONT_PERSON_2, MBANK_CONT_PERSON_3, MBANK_JAB_PERSON_1, 
				MBANK_JAB_PERSON_2, MBANK_JAB_PERSON_3, MBANK_NOTELP_PERSON_1, 
				MBANK_NOTELP_PERSON_2, MBANK_NOTELP_PERSON_3, KD_AKTIF, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
				MBANK_KODE_BB, NO_REK_PELINDO, MBANK_KARTU_BB, 
				NO_URUT
				FROM SAFM_BANK
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY MBANK_KODE ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParamsPph4Ayat2($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(BLN_BUKU) AS ROWCOUNT FROM LAPORAN_PPH_4_2
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
	
	function getCountByParamsPph15($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(BLN_BUKU) AS ROWCOUNT FROM LAPORAN_PPH_15
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

	function getCountByParamsPph21Pegawai($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM IMASYS_GAJI.GAJI_AWAL_BULAN_REPORT A
				LEFT JOIN IMASYS_GAJI.UANG_MAKAN_KAPAL_REPORT B ON A.PEGAWAI_ID = B.PEGAWAI_ID AND A.PERIODE = B.PERIODE
				LEFT JOIN IMASYS_GAJI.UANG_TRANSPORT_REPORT C ON A.PEGAWAI_ID = C.PEGAWAI_ID AND A.PERIODE = C.PERIODE
				LEFT JOIN IMASYS_GAJI.INSENTIF_REPORT D ON A.PEGAWAI_ID = D.PEGAWAI_ID AND A.PERIODE = D.PERIODE
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
	
	function getCountByParamsPph23($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(BLN_BUKU) AS ROWCOUNT FROM LAPORAN_PPH_23
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
	
	function getCountByParamsPpn($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(BLN_BUKU) AS ROWCOUNT FROM LAPORAN_PPN
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

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(SAFM_BANK_ID) AS ROWCOUNT FROM SAFM_BANK
		        WHERE SAFM_BANK_ID IS NOT NULL ".$statement; 
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