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
  * Entity-base class untuk mengimplementasikan tabel JABATAN.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class MenuGroup extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function MenuGroup()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("JABATAN_ID", $this->getNextId("JABATAN_ID","PPI_SIMPEG.JABATAN")); 		

		$str = "
				INSERT INTO (
				   JABATAN_ID) 
 			  	VALUES (
				  ".$this->getField("JABATAN_ID")."
				)"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE 
				SET    
					   NAMA           	= '".$this->getField("NAMA")."',
				WHERE  JABATAN_ID     = '".$this->getField("JABATAN_ID")."'

			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM 
                WHERE 
                  JABATAN_ID = ".$this->getField("JABATAN_ID").""; 
				  
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
				SELECT 
				MENU_GROUP_ID, NAMA, KETERANGAN
				FROM PPI.MENU_GROUP
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
	
	function selectByParamsMenuDokumen($paramsArray=array(),$limit=-1,$from=-1, $statement="", $dokumen_id="")
	{
		$str = "
				SELECT 
				A.MENU_GROUP_ID, A.NAMA, B.MENU_GROUP_ID MENU_GROUP_ID_DOKUMEN
				FROM PPI.MENU_GROUP A 
				LEFT JOIN PPI_HUKUM.KATEGORI_MENU_GROUP B ON A.MENU_GROUP_ID = B.MENU_GROUP_ID AND B.KATEGORI_ID = '".$dokumen_id."'
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				MENU_GROUP_ID, NAMA, KETERANGAN
				FROM PPI.MENU_GROUP
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
		$str = "SELECT COUNT(JABATAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.JABATAN
		        WHERE JABATAN_ID IS NOT NULL ".$statement; 
		
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
	
    function getCountByParamsKandidatMenuGroup($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.JABATAN_ID) ROWCOUNT
				FROM PPI_SIMPEG.JABATAN A
				LEFT JOIN PPI_SIMPEG.PEGAWAI_JABATAN_TERAKHIR B  ON A.JABATAN_ID = B.JABATAN_ID AND EXISTS(SELECT 1 FROM PPI_SIMPEG.PEGAWAI X WHERE X.PEGAWAI_ID = B.PEGAWAI_ID AND STATUS_PEGAWAI_ID IN (1, 5))
				LEFT JOIN PPI_SIMPEG.PEGAWAI C ON B.PEGAWAI_ID = C.PEGAWAI_ID
				WHERE 1 = 1 AND A.KELOMPOK = 'D' AND A.KELAS BETWEEN 5 AND 9 
                AND (
                      UPPER(A.NAMA) LIKE 'MANAGER%' OR
                      UPPER(A.NAMA) LIKE 'KEPALA%' OR
                      UPPER(A.NAMA) LIKE 'ASISTEN%' OR
                      UPPER(A.NAMA) LIKE 'SUPERVISOR%'                         
                    ) ".$statement; 
		
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
		$str = "SELECT COUNT(JABATAN_ID) AS ROWCOUNT FROM PPI_SIMPEG.JABATAN
		        WHERE JABATAN_ID IS NOT NULL ".$statement; 
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