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
  * Entity-base class untuk mengimplementasikan tabel PEMINDAHAN_ARSIP.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class PemindahanArsip extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function PemindahanArsip()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PEMINDAHAN_ARSIP_ID", $this->getNextId("PEMINDAHAN_ARSIP_ID","PPI_ASSET.PEMINDAHAN_ARSIP")); 		

		$str = "
				INSERT INTO PPI_ASSET.PEMINDAHAN_ARSIP (
				   PEMINDAHAN_ARSIP_ID, PEMINDAHAN_ID, ARSIP_ID, BOKS_PENYIMPANAN_ID_TUJUAN) 
 			  	VALUES (
				  ".$this->getField("PEMINDAHAN_ARSIP_ID").",
				  ".$this->getField("PEMINDAHAN_ID").",
  				  ".$this->getField("ARSIP_ID").",
  				  ".$this->getField("BOKS_PENYIMPANAN_ID_TUJUAN")."
				)"; 
		$this->id = $this->getField("PEMINDAHAN_ARSIP_ID");
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_ASSET.PEMINDAHAN_ARSIP
				SET    
					   PEMINDAHAN_ID 	= ".$this->getField("PEMINDAHAN_ID").",
					   ARSIP_ID 		= ".$this->getField("ARSIP_ID").",
  				  	   BOKS_PENYIMPANAN_ID_TUJUAN = ".$this->getField("BOKS_PENYIMPANAN_ID_TUJUAN")."				   
				WHERE  PEMINDAHAN_ARSIP_ID     = '".$this->getField("PEMINDAHAN_ARSIP_ID")."'

			 "; 
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
    function updateByField()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE PPI_ASSET.PEMINDAHAN_ARSIP A SET
				  ".$this->getField("FIELD")." = '".$this->getField("FIELD_VALUE")."'
				WHERE PEMINDAHAN_ARSIP_ID = ".$this->getField("PEMINDAHAN_ARSIP_ID")."
				"; 
				$this->query = $str;
	
		return $this->execQuery($str);
    }	

	function delete()
	{
        $str = "DELETE FROM PPI_ASSET.PEMINDAHAN_ARSIP
                WHERE 
                  PEMINDAHAN_ID = ".$this->getField("PEMINDAHAN_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PEMINDAHAN_ARSIP_ID ASC")
	{
		$str = "
					SELECT 
						   PEMINDAHAN_ARSIP_ID, ARSIP_ID, PEMINDAHAN_ID, BOKS_PENYIMPANAN_ID_TUJUAN
					FROM PPI_ASSET.PEMINDAHAN_ARSIP A WHERE PEMINDAHAN_ARSIP_ID IS NOT NULL
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.PEMINDAHAN_ARSIP_ID DESC ")
	{
		$str = "
					SELECT 
						   PEMINDAHAN_ARSIP_ID, A.ARSIP_ID, C.NAMA || ' - ' || D.NAMA ARSIP_BOKS, PEMINDAHAN_ID, A.BOKS_PENYIMPANAN_ID_TUJUAN
                    FROM PPI_ASSET.PEMINDAHAN_ARSIP A 
                    LEFT JOIN PPI_ASSET.BOKS_PENYIMPANAN B ON A.BOKS_PENYIMPANAN_ID_TUJUAN=B.BOKS_PENYIMPANAN_ID
                    LEFT JOIN PPI_ASSET.ARSIP C ON A.ARSIP_ID=C.ARSIP_ID
                    LEFT JOIN PPI_ASSET.BOKS_PENYIMPANAN D ON C.BOKS_PENYIMPANAN_ID=D.BOKS_PENYIMPANAN_ID
                    WHERE PEMINDAHAN_ARSIP_ID IS NOT NULL
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
		$str = "	SELECT 
						   PEMINDAHAN_ARSIP_ID, ARSIP_ID, PEMINDAHAN_ID, BOKS_PENYIMPANAN_ID_TUJUAN
					FROM PPI_ASSET.PEMINDAHAN_ARSIP A WHERE PEMINDAHAN_ARSIP_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY A.NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(PEMINDAHAN_ARSIP_ID) AS ROWCOUNT FROM PPI_ASSET.PEMINDAHAN_ARSIP A
		        WHERE PEMINDAHAN_ARSIP_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(PEMINDAHAN_ARSIP_ID) AS ROWCOUNT FROM PPI_ASSET.PEMINDAHAN_ARSIP A
		        WHERE PEMINDAHAN_ARSIP_ID IS NOT NULL ".$statement; 
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