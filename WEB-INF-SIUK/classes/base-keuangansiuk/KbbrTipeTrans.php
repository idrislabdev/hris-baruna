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
  * EntitySIUK-base class untuk mengimplementasikan tabel KBBR_TIPE_TRANS.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class KbbrTipeTrans extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function KbbrTipeTrans()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KBBR_TIPE_TRANS_ID", $this->getNextId("KBBR_TIPE_TRANS_ID","KBBR_TIPE_TRANS")); 		
		//'".$this->getField("FOTO")."',  FOTO,
		$str = "
					INSERT INTO KBBR_TIPE_TRANS (
					   KD_CABANG, KD_SUBSIS, KD_JURNAL, 
					   TIPE_TRANS, TIPE_DESC, AKRONIM_DESC, 
					   ID_REF_JURNAL, AUTO_MANUAL, POST_JURNAL, 
					   CONTRA_JURNAL, CLOSING_JURNAL, ADA_PAJAK, 
					   KD_PAJAK1, KD_PAJAK2, KD_PAJAK3, 
					   BB_GAIN_VALAS, BB_LOSS_VALAS, BB_GAIN_LOSS, 
					   KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
					   PROGRAM_NAME, TIPE_LR_VALAS, FLAG_METERAI) 
					VALUES ('".$this->getField("KD_CABANG")."', '".$this->getField("KD_SUBSIS")."', '".$this->getField("KD_JURNAL")."',
						'".$this->getField("TIPE_TRANS")."', '".$this->getField("TIPE_DESC")."', '".$this->getField("AKRONIM_DESC")."',
						'".$this->getField("ID_REF_JURNAL")."', '".$this->getField("AUTO_MANUAL")."', '".$this->getField("POST_JURNAL")."',
						'".$this->getField("CONTRA_JURNAL")."', '".$this->getField("CLOSING_JURNAL")."', '".$this->getField("ADA_PAJAK")."',
						'".$this->getField("KD_PAJAK1")."', '".$this->getField("KD_PAJAK2")."', '".$this->getField("KD_PAJAK3")."',
						'".$this->getField("BB_GAIN_VALAS")."', '".$this->getField("BB_LOSS_VALAS")."', '".$this->getField("BB_GAIN_LOSS")."',
						'".$this->getField("KD_AKTIF")."', ".$this->getField("LAST_UPDATE_DATE").", '".$this->getField("LAST_UPDATED_BY")."',
						'".$this->getField("PROGRAM_NAME")."', '".$this->getField("TIPE_LR_VALAS")."', '".$this->getField("FLAG_METERAI")."'
					)";
				
		$this->id = $this->getField("KBBR_TIPE_TRANS_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE KBBR_TIPE_TRANS
				SET    
					   TIPE_TRANS       = '".$this->getField("TIPE_TRANS")."',
					   TIPE_DESC        = '".$this->getField("TIPE_DESC")."',
					   AKRONIM_DESC     = '".$this->getField("AKRONIM_DESC")."',
					   POST_JURNAL      = '".$this->getField("POST_JURNAL")."',
					   FLAG_METERAI     = '".$this->getField("FLAG_METERAI")."',
					   ADA_PAJAK        = '".$this->getField("ADA_PAJAK")."',
					   KD_PAJAK1        = '".$this->getField("KD_PAJAK1")."',
					   KD_PAJAK2        = '".$this->getField("KD_PAJAK2")."',
					   LAST_UPDATE_DATE = ".$this->getField("LAST_UPDATE_DATE").",
					   LAST_UPDATED_BY  = '".$this->getField("LAST_UPDATED_BY")."'
				WHERE  TIPE_TRANS= '".$this->getField("TIPE_TRANS_ID")."'
			";
		
		/*KD_CABANG        = '".$this->getField("KD_CABANG")."',
		CONTRA_JURNAL    = '".$this->getField("CONTRA_JURNAL")."',
	    CLOSING_JURNAL   = '".$this->getField("CLOSING_JURNAL")."',
	    KD_SUBSIS        = '".$this->getField("KD_SUBSIS")."',
	    KD_JURNAL        = '".$this->getField("KD_JURNAL")."',
	    ID_REF_JURNAL    = '".$this->getField("ID_REF_JURNAL")."',
	    AUTO_MANUAL      = '".$this->getField("AUTO_MANUAL")."',
	    PROGRAM_NAME     = '".$this->getField("PROGRAM_NAME")."',
	    TIPE_LR_VALAS    = '".$this->getField("TIPE_LR_VALAS")."',
	    KD_PAJAK3        = '".$this->getField("KD_PAJAK3")."',
	    BB_GAIN_VALAS    = '".$this->getField("BB_GAIN_VALAS")."',
	    BB_LOSS_VALAS    = '".$this->getField("BB_LOSS_VALAS")."',
	    BB_GAIN_LOSS     = '".$this->getField("BB_GAIN_LOSS")."',
	    KD_AKTIF         = '".$this->getField("KD_AKTIF")."',*/
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM KBBR_TIPE_TRANS
                WHERE 
                  KD_SUBSIS= '".$this->getField("KD_SUBSIS")."' AND KD_JURNAL= '".$this->getField("KD_JURNAL")."' AND TIPE_TRANS= '".$this->getField("TIPE_TRANS")."'
				"; 
				  
		$this->query = $str;
        $this->execQuery($str);
		
		$str1 = "DELETE FROM KBBR_TIPE_TRANS_D
                WHERE 
                  KD_SUBSIS= '".$this->getField("KD_SUBSIS")."' AND KD_JURNAL= '".$this->getField("KD_JURNAL")."' AND TIPE_TRANS= '".$this->getField("TIPE_TRANS")."'
				"; 
				  
		$this->query = $str1;
        return $this->execQuery($str1);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder="ORDER BY TIPE_TRANS ASC")
	{
		$str = "
				SELECT KD_CABANG, A.KD_SUBSIS, A.KD_JURNAL, 
				TIPE_TRANS, TIPE_DESC, AKRONIM_DESC, 
				ID_REF_JURNAL, AUTO_MANUAL, POST_JURNAL, 
				CONTRA_JURNAL, CLOSING_JURNAL, ADA_PAJAK, 
				KD_PAJAK1, KD_PAJAK2, KD_PAJAK3, 
				BB_GAIN_VALAS, BB_LOSS_VALAS, BB_GAIN_LOSS, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, TIPE_LR_VALAS, FLAG_METERAI
				FROM KBBR_TIPE_TRANS A
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

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT KD_SUBSIS || ' - ' || B.KET_REF_DATA MODUL, KD_SUBSIS, KD_JURNAL, C.KET_REF_DATA JURNAL FROM KBBR_TIPE_TRANS A
                INNER JOIN KBBR_GENERAL_REF_D B ON KD_SUBSIS = B.ID_REF_DATA AND B.ID_REF_FILE = 'MODULSIUK'    
                INNER JOIN KBBR_GENERAL_REF_D C ON KD_JURNAL = C.ID_REF_DATA AND C.ID_REF_FILE = 'JENISJURNAL'                    
                WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY KD_SUBSIS, B.KET_REF_DATA, KD_JURNAL, C.KET_REF_DATA ".$order;
		
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }	
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT KD_CABANG, KD_SUBSIS, KD_JURNAL, 
				TIPE_TRANS, TIPE_DESC, AKRONIM_DESC, 
				ID_REF_JURNAL, AUTO_MANUAL, POST_JURNAL, 
				CONTRA_JURNAL, CLOSING_JURNAL, ADA_PAJAK, 
				KD_PAJAK1, KD_PAJAK2, KD_PAJAK3, 
				BB_GAIN_VALAS, BB_LOSS_VALAS, BB_GAIN_LOSS, 
				KD_AKTIF, LAST_UPDATE_DATE, LAST_UPDATED_BY, 
				PROGRAM_NAME, TIPE_LR_VALAS, FLAG_METERAI
				FROM KBBR_TIPE_TRANS
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
		$str = "SELECT COUNT(KBBR_TIPE_TRANS_ID) AS ROWCOUNT FROM KBBR_TIPE_TRANS
		        WHERE KBBR_TIPE_TRANS_ID IS NOT NULL ".$statement; 
		
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

    function getCountByParamsMonitoring($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(*) ROWCOUNT FROM (SELECT KD_SUBSIS || ' - ' || B.KET_REF_DATA MODUL, KD_SUBSIS, KD_JURNAL, C.KET_REF_DATA JURNAL FROM KBBR_TIPE_TRANS A
                INNER JOIN KBBR_GENERAL_REF_D B ON KD_SUBSIS = B.ID_REF_DATA AND B.ID_REF_FILE = 'MODULSIUK'    
                INNER JOIN KBBR_GENERAL_REF_D C ON KD_JURNAL = C.ID_REF_DATA AND C.ID_REF_FILE = 'JENISJURNAL'                    
                WHERE 1 = 1 GROUP BY KD_SUBSIS, B.KET_REF_DATA, KD_JURNAL, C.KET_REF_DATA ORDER BY KD_SUBSIS) A WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= " ";
		
		//echo $str;
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KBBR_TIPE_TRANS_ID) AS ROWCOUNT FROM KBBR_TIPE_TRANS
		        WHERE KBBR_TIPE_TRANS_ID IS NOT NULL ".$statement; 
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