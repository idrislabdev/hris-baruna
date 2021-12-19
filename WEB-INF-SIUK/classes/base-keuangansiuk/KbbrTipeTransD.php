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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_TIPE_TRANS_D.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrTipeTransD extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrTipeTransD()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBR_TIPE_TRANS_D_ID", $this->getNextId("KBBR_TIPE_TRANS_D_ID","KBBR_TIPE_TRANS_D")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
				INSERT INTO KBBR_TIPE_TRANS_D (
					   KD_CABANG, KD_SUBSIS, KD_JURNAL, 
					   TIPE_TRANS, KLAS_TRANS, KETK_TRANS, 
					   GLREK_COAID, KD_BUKU_BESAR1, KD_BUKU_BESAR2, 
					   KD_BUKU_BESAR3, KD_DK, KD_AKTIF, 
					   LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
					   TIPE_LR_VALAS, STATUS_KENA_PAJAK, FLAG_JURNAL) 
				VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_SUBSIS")."', '".$this->getField("KD_JURNAL")."',
						'".$this->getField("TIPE_TRANS")."', '".$this->getField("KLAS_TRANS")."', '".$this->getField("KETK_TRANS")."',
						'".$this->getField("GLREK_COAID")."', '".$this->getField("KD_BUKU_BESAR1")."', '".$this->getField("KD_BUKU_BESAR2")."',
						'".$this->getField("KD_BUKU_BESAR3")."', '".$this->getField("KD_DK")."', '".$this->getField("KD_AKTIF")."',
						".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."', '".$this->getField("PROGRAM_NAME")."',
						'".$this->getField("TIPE_LR_VALAS")."', '".$this->getField("STATUS_KENA_PAJAK")."', '".$this->getField("FLAG_JURNAL")."'
				)";
				
		$this->id = $this->getField("KBBR_TIPE_TRANS_D_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_TIPE_TRANS_D
				SET    
					   KLAS_TRANS        =  '".$this->getField("KLAS_TRANS")."',
					   KETK_TRANS        =  '".$this->getField("KETK_TRANS")."',
					   GLREK_COAID       =  '".$this->getField("GLREK_COAID")."',
					   KD_BUKU_BESAR1    =  '".$this->getField("KD_BUKU_BESAR1")."',
					   KD_BUKU_BESAR2    =  '".$this->getField("KD_BUKU_BESAR2")."',
					   KD_DK             =  '".$this->getField("KD_DK")."',
					   LAST_UPDATE_DATE  =  ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY   =  '".$this->getField("LAST_UPDATED_BY")."',
					   STATUS_KENA_PAJAK =  '".$this->getField("STATUS_KENA_PAJAK")."',
					   FLAG_JURNAL       =  '".$this->getField("FLAG_JURNAL")."'
				WHERE  KLAS_TRANS = '".$this->getField("KLAS_TRANS_ID")."' AND KD_SUBSIS = '".$this->getField("KD_SUBSIS")."' AND KD_JURNAL = '".$this->getField("KD_JURNAL")."' AND TIPE_TRANS = '".$this->getField("TIPE_TRANS")."'
			";
			
		   /*KD_CABANG         =  '".$this->getField("KD_CABANG")."',
		   KD_SUBSIS         =  '".$this->getField("KD_SUBSIS")."',
		   KD_JURNAL         =  '".$this->getField("KD_JURNAL")."',
		   TIPE_TRANS        =  '".$this->getField("TIPE_TRANS")."',
		   KD_BUKU_BESAR3    =  '".$this->getField("KD_BUKU_BESAR3")."',
		   KD_AKTIF          =  '".$this->getField("KD_AKTIF")."',
		   PROGRAM_NAME      =  '".$this->getField("PROGRAM_NAME")."',
		   TIPE_LR_VALAS     =  '".$this->getField("TIPE_LR_VALAS")."',*/
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function updateTipeTrans()
	{
		$str = "
				UPDATE KBBR_TIPE_TRANS_D
				SET    
					   TIPE_TRANS        =  '".$this->getField("TIPE_TRANS")."',
					   LAST_UPDATE_DATE  =  ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY   =  '".$this->getField("LAST_UPDATED_BY")."'
				WHERE  TIPE_TRANS = '".$this->getField("TIPE_TRANS_ID")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_TIPE_TRANS_D
                WHERE 
                  KLAS_TRANS = '".$this->getField("KLAS_TRANS_ID")."' AND KD_SUBSIS = '".$this->getField("KD_SUBSIS")."' AND KD_JURNAL = '".$this->getField("KD_JURNAL")."' AND TIPE_TRANS = '".$this->getField("TIPE_TRANS")."'
			   "; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY KD_BUKU_BESAR1 ASC")
	{
		$str = "
				SELECT KD_CABANG, KD_SUBSIS, KD_JURNAL, 
				A.TIPE_TRANS, KLAS_TRANS, KETK_TRANS, 
				GLREK_COAID, KD_BUKU_BESAR1, KD_BUKU_BESAR2, 
				KD_BUKU_BESAR3, KD_DK, KD_AKTIF, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
				TIPE_LR_VALAS, STATUS_KENA_PAJAK, FLAG_JURNAL
				FROM KBBR_TIPE_TRANS_D A
				WHERE 1 = 1
				"; 
				
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
				SELECT KD_CABANG, KD_SUBSIS, KD_JURNAL, 
				TIPE_TRANS, KLAS_TRANS, KETK_TRANS, 
				GLREK_COAID, KD_BUKU_BESAR1, KD_BUKU_BESAR2, 
				KD_BUKU_BESAR3, KD_DK, KD_AKTIF, 
				LAST_UPDATE_DATE, LAST_UPDATED_BY, PROGRAM_NAME, 
				TIPE_LR_VALAS, STATUS_KENA_PAJAK, FLAG_JURNAL
				FROM KBBR_TIPE_TRANS_D
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KD_CABANG ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBR_TIPE_TRANS_D_ID) AS ROWCOUNT FROM KBBR_TIPE_TRANS_D
		        WHERE KBBR_TIPE_TRANS_D_ID IS NOT NULL ".$statement; 
		
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

    function getKlasTrans($paramsArray=array(), $statement="")
	{
		$str = "SELECT 
				KLAS_TRANS
				FROM KBBR_TIPE_TRANS_D
				WHERE 1 = 1
				 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("KLAS_TRANS"); 
		else 
			return ""; 
    }
	
    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBR_TIPE_TRANS_D_ID) AS ROWCOUNT FROM KBBR_TIPE_TRANS_D
		        WHERE KBBR_TIPE_TRANS_D_ID IS NOT NULL ".$statement; 
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