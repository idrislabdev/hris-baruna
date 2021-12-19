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

  class KapalJenisSertAwakKpl extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KapalJenisSertAwakKpl()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KAPAL_JENIS_SERT_AWAK_KPL_ID", $this->getNextId("KAPAL_JENIS_SERT_AWAK_KPL_ID","PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL"));
		$str = "
				INSERT INTO PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL (
				   KAPAL_JENIS_SERT_AWAK_KPL_ID, KAPAL_JENIS_ID, SERTIFIKAT_AWAK_KAPAL_ID, JUMLAH, LAST_CREATE_USER, LAST_CREATE_DATE) 
 			  	VALUES (
				  ".$this->getField("KAPAL_JENIS_SERT_AWAK_KPL_ID").",
				  '".$this->getField("KAPAL_JENIS_ID")."',
				  '".$this->getField("SERTIFIKAT_AWAK_KAPAL_ID")."',
				  ".$this->getField("JUMLAH").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE")."
				)"; 
		$this->id = $this->getField("KAPAL_JENIS_SERT_AWAK_KPL_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL
				SET    
					   NAMA           = '".$this->getField("NAMA")."'
				WHERE  POTONGAN_KONDISI_ID     = '".$this->getField("POTONGAN_KONDISI_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL
                WHERE 
				  KAPAL_JENIS_ID= '".$this->getField("KAPAL_JENIS_ID")."'"; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KAPAL_JENIS_SERT_AWAK_KPL_ID, KAPAL_JENIS_ID, SERTIFIKAT_AWAK_KAPAL_ID, JUMLAH
				FROM PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL A				
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KAPAL_JENIS_SERT_AWAK_KPL_ID ASC";
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsEdit($paramsArray=array(),$limit=-1,$from=-1, $statement="", $reqJenisPegawaiId="", $reqKelas="", $reqKelompok="")
	{
		$str = "
				SELECT A.POTONGAN_KONDISI_ID, B.POTONGAN_KONDISI_ID POTONGAN_KONDISI_ID_JP,POTONGAN_KONDISI_PARENT_ID, NAMA, OPSI,
				  (SELECT COUNT(POTONGAN_KONDISI_ID) FROM PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL X WHERE X.POTONGAN_KONDISI_PARENT_ID = A.POTONGAN_KONDISI_ID) JUMLAH_CHILD, 
				  CASE WHEN PROSENTASE IS NULL THEN '100' ELSE PROSENTASE END PROSENTASE, CASE WHEN KALI IS NULL THEN '1' ELSE KALI END KALI, JUMLAH_ENTRI, JENIS_POTONGAN
				FROM PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL A LEFT JOIN PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL_JENIS_PEGAWAI B ON A.POTONGAN_KONDISI_ID = B.POTONGAN_KONDISI_ID	
				AND B.JENIS_PEGAWAI_ID = '".$reqJenisPegawaiId."' AND B.KELAS = '".$reqKelas."' AND B.KELOMPOK = '".$reqKelompok."'		
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.POTONGAN_KONDISI_ID, B.POTONGAN_KONDISI_ID,POTONGAN_KONDISI_PARENT_ID, NAMA, OPSI, PROSENTASE, KALI, JUMLAH_ENTRI, JENIS_POTONGAN
  							 ORDER BY A.POTONGAN_KONDISI_ID ASC";
		$this->query = $str;
		//echo $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT POTONGAN_KONDISI_ID, POTONGAN_KONDISI_PARENT_ID, NAMA
				FROM PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL				
				WHERE 1 = 1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(POTONGAN_KONDISI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL
		        WHERE POTONGAN_KONDISI_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(POTONGAN_KONDISI_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.KAPAL_JENIS_SERT_AWAK_KPL
		        WHERE POTONGAN_KONDISI_ID IS NOT NULL ".$statement; 
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