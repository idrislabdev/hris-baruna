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
  * EntitySIUK-base class untuk mengimplementasikan tabel SAFM_PELANGGAN.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class SafmPelanggan extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function SafmPelanggan()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("SAFM_PELANGGAN_ID", $this->getNextId("SAFM_PELANGGAN_ID","SAFM_PELANGGAN")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO SAFM_PELANGGAN (
					   KD_CABANG, JENIS_TABLE, ID_TABLE, 
					   MPLG_KODE, MPLG_NAMA, MPLG_ALAMAT, 
					   MPLG_KOTA, MPLG_JENIS_USAHA, MPLG_BADAN_USAHA, 
					   MPLG_CONT_PERSON, MPLG_TELEPON, MPLG_EMAIL_ADDRESS, 
					   MPLG_FAX, MPLG_NPWP, MPLG_SIUP, 
					   MPLG_TGL_SIUP, MPLG_STATUS_HUTANG, MPLG_SALDO_HUTANG, 
					   MPLG_SALDO_HUTANG_USD, MPLG_SALDO_UPER_IDR, MPLG_SALDO_UPER_USD, 
					   MPLG_MAKSIMUM_HUTANG, MPLG_MIN_WD_SEDIA, MPLG_LIMIT_WD, 
					   MPLG_PRKT_KLAS_USAHA, MPLG_PRKT_NILAI_ASET, MPLG_PRKT_NILAI_TRANS, 
					   MPLG_PRKT_WKT_LUNAS, MPLG_TEGURAN, MPLG_JML_DENDA, 
					   LAST_UPDATED_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
					   MPLG_SISA_UPER_IDR, MPLG_SISA_UPER_USD, MPLG_TITIPAN_LAIN_IDR, 
					   MPLG_TITIPAN_LAIN_USD, MPLG_JNS_WD, MPLG_NO_WD, 
					   FLAG_KAPAL, FLAG_BARANG, FLAG_UST, 
					   FLAG_PROP, FLAG_PAS, FLAG_RUPA, 
					   FLAG_KSU, FLAG_KEU, FLAG_WD_UPER, 
					   MBANK_KODE_RUPIAH, MBANK_KODE_VALAS, MPLG_KODE_BARU, 
					   MBANK_KODE, FLAG_GROUP_PIUTANG) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("JENIS_TABLE")."', '".$this->getField("ID_TABLE")."',
						(SELECT LPAD(MAX(TO_NUMBER(MPLG_KODE)) + 1, 5, '0') FROM SAFM_PELANGGAN), '".$this->getField("MPLG_NAMA")."', '".$this->getField("MPLG_ALAMAT")."',
						'".$this->getField("MPLG_KOTA")."', '".$this->getField("MPLG_JENIS_USAHA")."', '".$this->getField("MPLG_BADAN_USAHA")."',
						'".$this->getField("MPLG_CONT_PERSON")."', '".$this->getField("MPLG_TELEPON")."', '".$this->getField("MPLG_EMAIL_ADDRESS")."',
						'".$this->getField("MPLG_FAX")."', '".$this->getField("MPLG_NPWP")."', '".$this->getField("MPLG_SIUP")."',
						".$this->getField("MPLG_TGL_SIUP").", '".$this->getField("MPLG_STATUS_HUTANG")."', '".$this->getField("MPLG_SALDO_HUTANG")."',
						'".$this->getField("MPLG_SALDO_HUTANG_USD")."', '".$this->getField("MPLG_SALDO_UPER_IDR")."', '".$this->getField("MPLG_SALDO_UPER_USD")."',
						'".$this->getField("MPLG_MAKSIMUM_HUTANG")."', '".$this->getField("MPLG_MIN_WD_SEDIA")."', '".$this->getField("MPLG_LIMIT_WD")."',
						'".$this->getField("MPLG_PRKT_KLAS_USAHA")."', '".$this->getField("MPLG_PRKT_NILAI_ASET")."', '".$this->getField("MPLG_PRKT_NILAI_TRANS")."',
						'".$this->getField("MPLG_PRKT_WKT_LUNAS")."', '".$this->getField("MPLG_TEGURAN")."', '".$this->getField("MPLG_JML_DENDA")."',
						".$this->getField("LAST_UPDATED_DATE").", '".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."',
						'".$this->getField("MPLG_SISA_UPER_IDR")."', '".$this->getField("MPLG_SISA_UPER_USD")."', '".$this->getField("MPLG_TITIPAN_LAIN_IDR")."',
						'".$this->getField("MPLG_TITIPAN_LAIN_USD")."', '".$this->getField("MPLG_JNS_WD")."', '".$this->getField("MPLG_NO_WD")."',
						'".$this->getField("FLAG_KAPAL")."', '".$this->getField("FLAG_BARANG")."', '".$this->getField("FLAG_UST")."',
						'".$this->getField("FLAG_PROP")."', '".$this->getField("FLAG_PAS")."', '".$this->getField("FLAG_RUPA")."',
						'".$this->getField("FLAG_KSU")."', '".$this->getField("FLAG_KEU")."', '".$this->getField("FLAG_WD_UPER")."',
						'".$this->getField("MBANK_KODE_RUPIAH")."', '".$this->getField("MBANK_KODE_VALAS")."', '".$this->getField("MPLG_KODE_BARU")."',
						'".$this->getField("MBANK_KODE")."', '".$this->getField("FLAG_GROUP_PIUTANG")."'
					)";
				
		$this->id = $this->getField("SAFM_PELANGGAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE SAFM_PELANGGAN
				SET    
					   KD_CABANG             = '".$this->getField("KD_CABANG")."',
					   JENIS_TABLE           = '".$this->getField("JENIS_TABLE")."',
					   ID_TABLE              = '".$this->getField("ID_TABLE")."',
					   MPLG_NAMA             = '".$this->getField("MPLG_NAMA")."',
					   MPLG_ALAMAT           = '".$this->getField("MPLG_ALAMAT")."',
					   MPLG_KOTA             = '".$this->getField("MPLG_KOTA")."',
					   MPLG_JENIS_USAHA      = '".$this->getField("MPLG_JENIS_USAHA")."',
					   MPLG_BADAN_USAHA      = '".$this->getField("MPLG_BADAN_USAHA")."',
					   MPLG_CONT_PERSON      = '".$this->getField("MPLG_CONT_PERSON")."',
					   MPLG_TELEPON          = '".$this->getField("MPLG_TELEPON")."',
					   MPLG_EMAIL_ADDRESS    = '".$this->getField("MPLG_EMAIL_ADDRESS")."',
					   MPLG_FAX              = '".$this->getField("MPLG_FAX")."',
					   MPLG_NPWP             = '".$this->getField("MPLG_NPWP")."',
					   MPLG_SIUP             = '".$this->getField("MPLG_SIUP")."',
					   MPLG_TGL_SIUP         = ".$this->getField("MPLG_TGL_SIUP").",
					   MPLG_STATUS_HUTANG    = '".$this->getField("MPLG_STATUS_HUTANG")."',
					   MPLG_SALDO_HUTANG     = '".$this->getField("MPLG_SALDO_HUTANG")."',
					   MPLG_SALDO_HUTANG_USD = '".$this->getField("MPLG_SALDO_HUTANG_USD")."',
					   MPLG_SALDO_UPER_IDR   = '".$this->getField("MPLG_SALDO_UPER_IDR")."',
					   MPLG_SALDO_UPER_USD   = '".$this->getField("MPLG_SALDO_UPER_USD")."',
					   MPLG_MAKSIMUM_HUTANG  = '".$this->getField("MPLG_MAKSIMUM_HUTANG")."',
					   MPLG_MIN_WD_SEDIA     = '".$this->getField("MPLG_MIN_WD_SEDIA")."',
					   MPLG_LIMIT_WD         = '".$this->getField("MPLG_LIMIT_WD")."',
					   MPLG_PRKT_KLAS_USAHA  = '".$this->getField("MPLG_PRKT_KLAS_USAHA")."',
					   MPLG_PRKT_NILAI_ASET  = '".$this->getField("MPLG_PRKT_NILAI_ASET")."',
					   MPLG_PRKT_NILAI_TRANS = '".$this->getField("MPLG_PRKT_NILAI_TRANS")."',
					   MPLG_PRKT_WKT_LUNAS   = '".$this->getField("MPLG_PRKT_WKT_LUNAS")."',
					   MPLG_TEGURAN          = '".$this->getField("MPLG_TEGURAN")."',
					   MPLG_JML_DENDA        = '".$this->getField("MPLG_JML_DENDA")."',
					   LAST_UPDATED_DATE     = ".$this->getField("LAST_UPDATED_DATE").",
					   LAST_UPDATED_BY       = '".$this->getField("LAST_UPDATED_BY")."',
					   PROGRAM_NAME          = '".$this->getField("PROGRAM_NAME")."',
					   MPLG_SISA_UPER_IDR    = '".$this->getField("MPLG_SISA_UPER_IDR")."',
					   MPLG_SISA_UPER_USD    = '".$this->getField("MPLG_SISA_UPER_USD")."',
					   MPLG_TITIPAN_LAIN_IDR = '".$this->getField("MPLG_TITIPAN_LAIN_IDR")."',
					   MPLG_TITIPAN_LAIN_USD = '".$this->getField("MPLG_TITIPAN_LAIN_USD")."',
					   MPLG_JNS_WD           = '".$this->getField("MPLG_JNS_WD")."',
					   MPLG_NO_WD            = '".$this->getField("MPLG_NO_WD")."',
					   FLAG_KAPAL            = '".$this->getField("FLAG_KAPAL")."',
					   FLAG_BARANG           = '".$this->getField("FLAG_BARANG")."',
					   FLAG_UST              = '".$this->getField("FLAG_UST")."',
					   FLAG_PROP             = '".$this->getField("FLAG_PROP")."',
					   FLAG_PAS              = '".$this->getField("FLAG_PAS")."',
					   FLAG_RUPA             = '".$this->getField("FLAG_RUPA")."',
					   FLAG_KSU              = '".$this->getField("FLAG_KSU")."',
					   FLAG_KEU              = '".$this->getField("FLAG_KEU")."',
					   FLAG_WD_UPER          = '".$this->getField("FLAG_WD_UPER")."',
					   MBANK_KODE_RUPIAH     = '".$this->getField("MBANK_KODE_RUPIAH")."',
					   MBANK_KODE_VALAS      = '".$this->getField("MBANK_KODE_VALAS")."',
					   MPLG_KODE_BARU        = '".$this->getField("MPLG_KODE_BARU")."',
					   MBANK_KODE            = '".$this->getField("MBANK_KODE")."',
					   FLAG_GROUP_PIUTANG    = '".$this->getField("FLAG_GROUP_PIUTANG")."'
				WHERE  MPLG_KODE             = '".$this->getField("MPLG_KODE")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM SAFM_PELANGGAN
                WHERE 
                  MPLG_KODE             = '".$this->getField("MPLG_KODE")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT KD_CABANG, JENIS_TABLE, ID_TABLE, 
				MPLG_KODE, MPLG_NAMA, MPLG_ALAMAT, 
				MPLG_KOTA, MPLG_JENIS_USAHA, MPLG_BADAN_USAHA, 
				MPLG_CONT_PERSON, MPLG_TELEPON, MPLG_EMAIL_ADDRESS, 
				MPLG_FAX, MPLG_NPWP, MPLG_SIUP, 
				MPLG_TGL_SIUP, MPLG_STATUS_HUTANG, MPLG_SALDO_HUTANG, 
				MPLG_SALDO_HUTANG_USD, MPLG_SALDO_UPER_IDR, MPLG_SALDO_UPER_USD, 
				MPLG_MAKSIMUM_HUTANG, MPLG_MIN_WD_SEDIA, MPLG_LIMIT_WD, 
				MPLG_PRKT_KLAS_USAHA, MPLG_PRKT_NILAI_ASET, MPLG_PRKT_NILAI_TRANS, 
				MPLG_PRKT_WKT_LUNAS, MPLG_TEGURAN, MPLG_JML_DENDA, 
				LAST_UPDATED_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
				MPLG_SISA_UPER_IDR, MPLG_SISA_UPER_USD, MPLG_TITIPAN_LAIN_IDR, 
				MPLG_TITIPAN_LAIN_USD, MPLG_JNS_WD, MPLG_NO_WD, 
				FLAG_KAPAL, FLAG_BARANG, FLAG_UST, 
				FLAG_PROP, FLAG_PAS, FLAG_RUPA, 
				FLAG_KSU, FLAG_KEU, FLAG_WD_UPER, 
				MBANK_KODE_RUPIAH, MBANK_KODE_VALAS, MPLG_KODE_BARU, 
				MBANK_KODE, FLAG_GROUP_PIUTANG
				FROM SAFM_PELANGGAN
				WHERE 1 = 1
				"; 
		//, FOTO
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
				SELECT KD_CABANG, JENIS_TABLE, ID_TABLE, 
				MPLG_KODE, MPLG_NAMA, MPLG_ALAMAT, 
				MPLG_KOTA, MPLG_JENIS_USAHA, MPLG_BADAN_USAHA, 
				MPLG_CONT_PERSON, MPLG_TELEPON, MPLG_EMAIL_ADDRESS, 
				MPLG_FAX, MPLG_NPWP, MPLG_SIUP, 
				MPLG_TGL_SIUP, MPLG_STATUS_HUTANG, MPLG_SALDO_HUTANG, 
				MPLG_SALDO_HUTANG_USD, MPLG_SALDO_UPER_IDR, MPLG_SALDO_UPER_USD, 
				MPLG_MAKSIMUM_HUTANG, MPLG_MIN_WD_SEDIA, MPLG_LIMIT_WD, 
				MPLG_PRKT_KLAS_USAHA, MPLG_PRKT_NILAI_ASET, MPLG_PRKT_NILAI_TRANS, 
				MPLG_PRKT_WKT_LUNAS, MPLG_TEGURAN, MPLG_JML_DENDA, 
				LAST_UPDATED_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
				MPLG_SISA_UPER_IDR, MPLG_SISA_UPER_USD, MPLG_TITIPAN_LAIN_IDR, 
				MPLG_TITIPAN_LAIN_USD, MPLG_JNS_WD, MPLG_NO_WD, 
				FLAG_KAPAL, FLAG_BARANG, FLAG_UST, 
				FLAG_PROP, FLAG_PAS, FLAG_RUPA, 
				FLAG_KSU, FLAG_KEU, FLAG_WD_UPER, 
				MBANK_KODE_RUPIAH, MBANK_KODE_VALAS, MPLG_KODE_BARU, 
				MBANK_KODE, FLAG_GROUP_PIUTANG
				FROM SAFM_PELANGGAN
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY MPLG_NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(MPLG_KODE) AS ROWCOUNT FROM SAFM_PELANGGAN
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
		$str = "SELECT COUNT(MPLG_KODE) AS ROWCOUNT FROM SAFM_PELANGGAN
		        WHERE 1 = 1 ".$statement; 
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