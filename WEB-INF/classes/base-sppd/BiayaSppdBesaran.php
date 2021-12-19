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
  * Entity-base class untuk mengimplementasikan tabel PANGKAT.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class BiayaSppdBesaran extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function BiayaSppdBesaran()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BIAYA_SPPD_BESARAN_ID", $this->getNextId("BIAYA_SPPD_BESARAN_ID","PPI_SPPD.BIAYA_SPPD_BESARAN"));
		$str = "
				INSERT INTO PPI_SPPD.BIAYA_SPPD_BESARAN (
				   BIAYA_SPPD_BESARAN_ID, PROVINSI_ID, BIAYA_SPPD_ID, 
				   KELAS_AWAL, KELAS_AKHIR, JUMLAH, JABATAN_ID) 
				VALUES ( ".$this->getField("BIAYA_SPPD_BESARAN_ID").",
						'".$this->getField("PROVINSI_ID")."',
						'".$this->getField("BIAYA_SPPD_ID")."',
						'".$this->getField("KELAS_AWAL")."',
						'".$this->getField("KELAS_AKHIR")."',
						'".$this->getField("JUMLAH")."',
						PPI_SPPD.KONVERSI_JABATAN_TO_ID(UPPER('".$this->getField("JABATAN_ID")."'))					
						)"; 
						
		$this->id = $this->getField("BIAYA_SPPD_BESARAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_SPPD.BIAYA_SPPD_BESARAN
				SET    PROVINSI_ID           = '".$this->getField("PROVINSI_ID")."',
					   BIAYA_SPPD_ID         = '".$this->getField("BIAYA_SPPD_ID")."',
					   KELAS_AWAL            = '".$this->getField("KELAS_AWAL")."',
					   KELAS_AKHIR           = '".$this->getField("KELAS_AKHIR")."',
					   JUMLAH                = '".$this->getField("JUMLAH")."',
					   JABATAN_ID			 = PPI_SPPD.KONVERSI_JABATAN_TO_ID(UPPER('".$this->getField("JABATAN_ID")."'))	
				WHERE  BIAYA_SPPD_BESARAN_ID = '".$this->getField("BIAYA_SPPD_BESARAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.BIAYA_SPPD_BESARAN
                WHERE 
                  BIAYA_SPPD_BESARAN_ID = ".$this->getField("BIAYA_SPPD_BESARAN_ID").""; 
				  
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
		$str = "SELECT 
                    BIAYA_SPPD_BESARAN_ID, A.PROVINSI_ID, A.BIAYA_SPPD_ID, JABATAN_ID, REPLACE(A.JABATAN_ID, ',', ';') JABATAN,
                       KELAS_AWAL, KELAS_AKHIR, A.JUMLAH, B.NAMA PROVINSI, C.NAMA BIAYA_SPPD, PPI_SPPD.AMBIL_JABATAN_BIAYA_SPPD(JABATAN_ID) NAMA_JABATAN
                    FROM PPI_SPPD.BIAYA_SPPD_BESARAN A
                    LEFT JOIN PPI_SPPD.PROVINSI B ON B.PROVINSI_ID=A.PROVINSI_ID
                    LEFT JOIN PPI_SPPD.BIAYA_SPPD C ON C.BIAYA_SPPD_ID=A.BIAYA_SPPD_ID
                WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "SELECT 
				BIAYA_SPPD_BESARAN_ID, PROVINSI_ID, BIAYA_SPPD_ID, 
				   KELAS_AWAL, KELAS_AKHIR, JUMLAH
				FROM PPI_SPPD.BIAYA_SPPD_BESARAN
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
		$str = "SELECT COUNT(BIAYA_SPPD_BESARAN_ID) AS ROWCOUNT FROM PPI_SPPD.BIAYA_SPPD_BESARAN A
					LEFT JOIN PPI_SPPD.PROVINSI B ON B.PROVINSI_ID=A.PROVINSI_ID
                    LEFT JOIN PPI_SPPD.BIAYA_SPPD C ON C.BIAYA_SPPD_ID=A.BIAYA_SPPD_ID
				WHERE 1 = 1".$statement; 
		
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
		$str = "SELECT COUNT(BIAYA_SPPD_BESARAN_ID) AS ROWCOUNT FROM PPI_SPPD.BIAYA_SPPD_BESARAN

		        WHERE PROVINSI_ID IS NOT NULL ".$statement; 
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