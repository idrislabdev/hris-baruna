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

  class TgJawabNotaSppdNomor extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function TgJawabNotaSppdNomor()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("TGJAWAB_NOTA_SPPD_NOMOR_ID", $this->getNextId("TGJAWAB_NOTA_SPPD_NOMOR_ID","PPI_SPPD.TGJAWAB_NOTA_SPPD_NOMOR"));
		$str = "INSERT INTO PPI_SPPD.TGJAWAB_NOTA_SPPD_NOMOR (
				   TGJAWAB_NOTA_SPPD_NOMOR_ID, SPPD_ID, PEGAWAI_ID, 
				   TANGGAL, NOMOR, NAMA, 
				   JUMLAH,  STATUS_ADA_NOTA) 
				VALUES (".$this->getField("TGJAWAB_NOTA_SPPD_NOMOR_ID").",
						'".$this->getField("SPPD_ID")."',
						'".$this->getField("PEGAWAI_ID")."', 
				   		".$this->getField("TANGGAL").",
						'".$this->getField("NOMOR")."',
						'".$this->getField("NAMA")."',
				   		'".$this->getField("JUMLAH")."',
						'".$this->getField("STATUS_ADA_NOTA")."'
						)"; 
		$this->id = $this->getField("TGJAWAB_NOTA_SPPD_NOMOR_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
			UPDATE PPI_SPPD.TGJAWAB_NOTA_SPPD_NOMOR
			SET    
				   SPPD_ID              = '".$this->getField("SPPD_ID")."',
				   TANGGAL              = ".$this->getField("TANGGAL").",
				   NOMOR                = '".$this->getField("NOMOR")."',
				   NAMA                 = '".$this->getField("NAMA")."',
				   JUMLAH               = '".$this->getField("JUMLAH")."',
				   STATUS_ADA_NOTA      = '".$this->getField("STATUS_ADA_NOTA")."'
			WHERE  TGJAWAB_NOTA_SPPD_NOMOR_ID = '".$this->getField("TGJAWAB_NOTA_SPPD_NOMOR_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }
	
	function updateFormat()
	{
		$str = "
				UPDATE PPI_SPPD.TGJAWAB_NOTA_SPPD_NOMOR
				SET    
					  TIPE=".$this->getField("TIPE").",
				  	  UKURAN=".$this->getField("UKURAN")."
				WHERE  TGJAWAB_NOTA_SPPD_NOMOR_ID = '".$this->getField("TGJAWAB_NOTA_SPPD_NOMOR_ID")."'
			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM PPI_SPPD.TGJAWAB_NOTA_SPPD_NOMOR
                WHERE 
                  TGJAWAB_NOTA_SPPD_NOMOR_ID = ".$this->getField("TGJAWAB_NOTA_SPPD_NOMOR_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }
	
	function selectByParamsBlob($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
			SELECT 
				TGJAWAB_NOTA_SPPD_NOMOR_ID, NOMOR, TIPE, UKURAN, FILE_GAMBAR
			FROM PPI_SPPD.TGJAWAB_NOTA_SPPD_NOMOR
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ";
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
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
					TGJAWAB_NOTA_SPPD_NOMOR_ID, SPPD_ID, A.PEGAWAI_ID, 
					   TANGGAL, NOMOR, A.NAMA, 
					   JUMLAH, FILE_GAMBAR, TIPE, 
					   UKURAN, STATUS_ADA_NOTA, B.NAMA PEGAWAI, B.NRP
					FROM PPI_SPPD.TGJAWAB_NOTA_SPPD_NOMOR A INNER JOIN PPI_SIMPEG.PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
				WHERE 1 = 1
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
		$str = "SELECT 
					TGJAWAB_NOTA_SPPD_NOMOR_ID, SPPD_ID, PEGAWAI_ID, 
					   TANGGAL, NOMOR, NAMA, 
					   JUMLAH, FILE_GAMBAR, TIPE, 
					   UKURAN, STATUS_ADA_NOTA
					FROM PPI_SPPD.TGJAWAB_NOTA_SPPD_NOMOR
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
		$str = "SELECT COUNT(TGJAWAB_NOTA_SPPD_NOMOR_ID) AS ROWCOUNT FROM PPI_SPPD.TGJAWAB_NOTA_SPPD_NOMOR

		        WHERE 1 = 1 ".$statement; 
		
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
		$str = "SELECT COUNT(TGJAWAB_NOTA_SPPD_NOMOR_ID) AS ROWCOUNT FROM PPI_SPPD.TGJAWAB_NOTA_SPPD_NOMOR

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