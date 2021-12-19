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
  * EntitySIUK-base class untuk mengimplementasikan tabel AKUNTANSI.PENAGIHAN_PIUTANG.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class PenagihanPiutang extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PenagihanPiutang()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KODE", $this->getNextId("KODE","AKUNTANSI.PENAGIHAN_PIUTANG")); 		
		$str = "
				INSERT INTO AKUNTANSI.PENAGIHAN_PIUTANG (
					   KODE, MPLG_KODE, JUMLAH_PIUTANG, TGL_TAGIH, MEDIA, KETERANGAN, TGL_TAGIH_BERIKUT, CREATED_DATE, CREATED_BY, ALAMAT_PENAGIHAN, KONTAK_PERSON, TANGGAPAN) 
				VALUES (".$this->getField("KODE").",'".$this->getField("MPLG_KODE")."',".$this->getField("JUMLAH_PIUTANG").",TO_DATE('".$this->getField("TGL_TAGIH")."','DD-MM-YYYY'),
				'".$this->getField("MEDIA")."','".$this->getField("KETERANGAN")."',TO_DATE('".$this->getField("TGL_TAGIH_BERIKUT")."', 'DD-MM-YYYY'),SYSDATE,
				'".$this->getField("CREATED_BY")."','".$this->getField("ALAMAT_PENAGIHAN")."','".$this->getField("KONTAK_PERSON")."','".$this->getField("TANGGAPAN")."')";
				
		$this->id = $this->getField("KODE");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE AKUNTANSI.PENAGIHAN_PIUTANG
				SET    
					  MPLG_KODE = '".$this->getField("MPLG_KODE")."',
					  JUMLAH_PIUTANG = ".$this->getField("JUMLAH_PIUTANG").",
					  TGL_TAGIH = TO_DATE('".$this->getField("TGL_TAGIH")."','DD-MM-YYYY'),
					  MEDIA = '".$this->getField("MEDIA")."', 
					  KETERANGAN = '".$this->getField("KETERANGAN")."',
					  TGL_TAGIH_BERIKUT = TO_DATE('".$this->getField("TGL_TAGIH_BERIKUT")."','DD-MM-YYYY'),
					  UPDATED_DATE = SYSDATE,
					  UPDATED_BY = '".$this->getField("UPDATED_BY")."',
					  ALAMAT_PENAGIHAN = '".$this->getField("ALAMAT_PENAGIHAN")."',
					  KONTAK_PERSON = '".$this->getField("KONTAK_PERSON")."',
					  TANGGAPAN = '".$this->getField("TANGGAPAN")."'
				WHERE  KODE             = '".$this->getField("KODE")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM AKUNTANSI.PENAGIHAN_PIUTANG
                WHERE 
                  KODE             = '".$this->getField("KODE")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.TGL_TAGIH desc ")
	{
		$str = "
				SELECT A.KODE, MPLG_BADAN_USAHA, A.MPLG_KODE, B.MPLG_NAMA, A.JUMLAH_PIUTANG, TO_CHAR(A.TGL_TAGIH, 'DD-MM-YYYY') TGL_TAGIH, A.MEDIA, A.KETERANGAN, TO_CHAR(A.TGL_TAGIH_BERIKUT, 'DD-MM-YYYY') TGL_TAGIH_BERIKUT, A.CREATED_DATE, A.CREATED_BY, A.UPDATED_DATE, A.UPDATED_BY, A.ALAMAT_PENAGIHAN, A.KONTAK_PERSON, A.TANGGAPAN
                FROM AKUNTANSI.PENAGIHAN_PIUTANG A JOIN SAFM_PELANGGAN B ON A.MPLG_KODE = B.MPLG_KODE
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
	
	function selectByPelangganPiutang($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				select MPLG_KODE, MPLG_NAMA, MPLG_BADAN_USAHA, MPLG_ALAMAT, TOTAL_PIUTANG  from AKUNTANSI.V_PMS_MONITORING_PIUTANG
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
				SELECT A.KODE, MPLG_BADAN_USAHA, A.MPLG_KODE, B.MPLG_NAMA, A.JUMLAH_PIUTANG, A.TGL_TAGIH, A.MEDIA, A.KETERANGAN, A.TGL_TAGIH_BERIKUT, A.CREATED_DATE, A.CREATED_BY, A.UPDATED_DATE, A.UPDATED_BY
                FROM AKUNTANSI.PENAGIHAN_PIUTANG A JOIN SAFM_PELANGGAN B ON A.MPLG_KODE = B.MPLG_KODE
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
		$str = "SELECT COUNT(KODE) AS ROWCOUNT FROM AKUNTANSI.PENAGIHAN_PIUTANG
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
		$str = "SELECT COUNT(KODE) AS ROWCOUNT FROM AKUNTANSI.PENAGIHAN_PIUTANG
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