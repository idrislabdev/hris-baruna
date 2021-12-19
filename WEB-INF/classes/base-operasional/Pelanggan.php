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

  class Pelanggan extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Pelanggan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PELANGGAN_ID", $this->getNextId("PELANGGAN_ID","PPI_OPERASIONAL.PELANGGAN"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.PELANGGAN (
				   PELANGGAN_ID, NAMA, ALAMAT, 
				   NPWP, PEMILIK, NO_TELP, 
				   JENIS_USAHA, ALAMAT_SURAT, 
				   LAST_CREATE_USER, LAST_CREATE_DATE, NO_FAX, KODE, 
				   KOTA, WEBSITE, KONTAK_NAMA, 
				   KONTAK_TELEPON, KONTAK_EMAIL, SIUP, 
				   TANGGAL_SIUP, BANK_USD, BANK_RUPIAH, 
				   JENIS_USAHA_ID, BADAN_USAHA_ID) 
 			  	VALUES (
				  ".$this->getField("PELANGGAN_ID").",
				  '".$this->getField("NAMA")."',
				  '".$this->getField("ALAMAT")."',
				  '".$this->getField("NPWP")."',
				  '".$this->getField("PEMILIK")."',
				  '".$this->getField("NO_TELP")."',
				  '".$this->getField("EMAIL")."',
				  '".$this->getField("ALAMAT_SURAT")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("NO_FAX")."',
				  '".$this->getField("KODE")."',
				  '".$this->getField("KOTA")."',
				  '".$this->getField("WEBSITE")."',
				  '".$this->getField("KONTAK_NAMA")."',
				  '".$this->getField("KONTAK_TELEPON")."',
				  '".$this->getField("KONTAK_EMAIL")."',
				  '".$this->getField("SIUP")."',
				  ".$this->getField("TANGGAL_SIUP").",
				  '".$this->getField("BANK_USD")."',
				  '".$this->getField("BANK_RUPIAH")."',
				  '".$this->getField("JENIS_USAHA_ID")."',
				  '".$this->getField("BADAN_USAHA_ID")."'
				)"; 
		$this->query = $str;
		$this->id = $this->getField("PELANGGAN_ID");
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.PELANGGAN
				SET    
					   NAMA         	= '".$this->getField("NAMA")."',
					   ALAMAT         	= '".$this->getField("ALAMAT")."',
					   NPWP         	= '".$this->getField("NPWP")."',
					   PEMILIK         	= '".$this->getField("PEMILIK")."',
					   NO_TELP         	= '".$this->getField("NO_TELP")."',
					   EMAIL         	= '".$this->getField("EMAIL")."',
					   ALAMAT_SURAT	 	= '".$this->getField("ALAMAT_SURAT")."',
					   LAST_UPDATE_USER	= '".$this->getField("LAST_UPDATE_USER")."',
					   LAST_UPDATE_DATE	= ".$this->getField("LAST_UPDATE_DATE").",
					   NO_FAX         	= '".$this->getField("NO_FAX")."',
					   KODE         	= '".$this->getField("KODE")."',
					   KOTA         	= '".$this->getField("KOTA")."',
					   WEBSITE         	= '".$this->getField("WEBSITE")."',
					   KONTAK_NAMA      = '".$this->getField("KONTAK_NAMA")."',
					   KONTAK_TELEPON   = '".$this->getField("KONTAK_TELEPON")."',
					   KONTAK_EMAIL     = '".$this->getField("KONTAK_EMAIL")."',
					   SIUP         	= '".$this->getField("SIUP")."',
					   TANGGAL_SIUP     = ".$this->getField("TANGGAL_SIUP").",
					   BANK_USD         = '".$this->getField("BANK_USD")."',
					   BANK_RUPIAH      = '".$this->getField("BANK_RUPIAH")."',
					   JENIS_USAHA_ID   = '".$this->getField("JENIS_USAHA_ID")."',
					   BADAN_USAHA_ID   = '".$this->getField("BADAN_USAHA_ID")."'
				WHERE  PELANGGAN_ID  	= '".$this->getField("PELANGGAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.PELANGGAN
                WHERE 
                  PELANGGAN_ID = ".$this->getField("PELANGGAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY PELANGGAN_ID ASC")
	{
		$str = "
				SELECT 
				   PELANGGAN_ID, NAMA, ALAMAT, 
				   NPWP, PEMILIK, NO_TELP, 
				   EMAIL, ALAMAT_SURAT, NO_FAX, KODE, 
				   KOTA, WEBSITE, KONTAK_NAMA, 
				   KONTAK_TELEPON, KONTAK_EMAIL, SIUP, 
				   TANGGAL_SIUP, BANK_USD, BANK_RUPIAH, 
				   JENIS_MATA_UANG, JENIS_USAHA_ID, BADAN_USAHA_ID,
				   (SELECT X.NAMA FROM PPI_OPERASIONAL.JENIS_USAHA X WHERE X.JENIS_USAHA_ID = A.JENIS_USAHA_ID) JENIS_USAHA
				FROM PPI_OPERASIONAL.PELANGGAN A
				WHERE PELANGGAN_ID IS NOT NULL
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
				SELECT 
				   PELANGGAN_ID, NAMA, ALAMAT, 
				   NPWP, PEMILIK, NO_TELP, 
				   EMAIL, ALAMAT_SURAT, NO_FAX, KODE, 
				   KOTA, WEBSITE, KONTAK_NAMA, 
				   KONTAK_TELEPON, KONTAK_EMAIL, SIUP, 
				   TANGGAL_SIUP, BANK_USD, BANK_RUPIAH, 
				   JENIS_MATA_UANG, JENIS_USAHA_ID, BADAN_USAHA_ID				
				FROM PPI_OPERASIONAL.PELANGGAN				
				WHERE PELANGGAN_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY PELANGGAN_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PELANGGAN_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.PELANGGAN
		        WHERE PELANGGAN_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PELANGGAN_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.PELANGGAN
		        WHERE PELANGGAN_ID IS NOT NULL ".$statement; 
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