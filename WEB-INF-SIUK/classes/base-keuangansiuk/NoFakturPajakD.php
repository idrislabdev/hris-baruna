
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
  * EntitySIUK-base class untuk mengimplementasikan tabel PERPAJAKAN.NO_FAKTUR_PAJAK_D.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");

  class NoFakturPajakD extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function NoFakturPajakD()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PERPAJAKAN.NO_FAKTUR_PAJAK_D (
					   NO_FAKTUR_PAJAK_ID, 
					   NOMOR, STATUS)
				VALUES ('".$this->getField("NO_FAKTUR_PAJAK_ID")."', 
						'".$this->getField("NOMOR")."', 
						'".$this->getField("STATUS")."'
				)";
				
		$this->id = $this->getField("NO_FAKTUR_PAJAK_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PERPAJAKAN.NO_FAKTUR_PAJAK_D
				SET    
					   NOMOR         = '".$this->getField("NOMOR")."',
					   STATUS = '".$this->getField("STATUS")."'
				WHERE  NO_FAKTUR_PAJAK_ID     = ".$this->getField("NO_FAKTUR_PAJAK_ID")."
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateStatus()
	{
		$str = "
				UPDATE PERPAJAKAN.NO_FAKTUR_PAJAK_D
				SET    
					   STATUS    = 1,
					   NO_NOTA   = '".$this->getField("NO_NOTA")."'
				WHERE  NOMOR     = '".$this->getField("NOMOR")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }

    function updateBatal()
	{
		$str = "
				UPDATE PERPAJAKAN.NO_FAKTUR_PAJAK_D
				SET    
					   STATUS    = 0,
					   NO_NOTA   = '',
					   NO_NOTA_LAST = '".$this->getField("NO_NOTA")."'
				WHERE  NO_NOTA     = '".$this->getField("NO_NOTA")."'
			";//FOTO= '".$this->getField("FOTO")."',
		$this->query = $str;
		//echo $str;
		return $this->execQuery($str);
    }
			
	function delete()
	{
        $str = "DELETE FROM PERPAJAKAN.NO_FAKTUR_PAJAK_D
                WHERE 
                  NO_FAKTUR_PAJAK_ID     = ".$this->getField("NO_FAKTUR_PAJAK_ID")."
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="")
	{
		$str = "
				SELECT NO_FAKTUR_PAJAK_ID, 
                       NOMOR,  CASE WHEN B.STATUS_PROSES = 2 THEN '2' ELSE STATUS END STATUS, A.NO_NOTA, CASE WHEN B.STATUS_PROSES = 2 THEN 'Dibatalkan' ELSE CASE WHEN STATUS = 0 THEN 'Belum Dipakai' ELSE 'Sudah Dipakai' END END KETERANGAN,
                       MPLG_NAMA, MPLG_NPWP, JML_VAL_TRANS, JML_RP_TRANS, JML_VAL_PAJAK, JML_RP_PAJAK, NO_NOTA_LAST
                FROM PERPAJAKAN.NO_FAKTUR_PAJAK_D A 
                     LEFT JOIN KPTT_NOTA B ON A.NO_NOTA = B.NO_NOTA 
                     LEFT JOIN SAFM_PELANGGAN C ON B.KD_KUSTO = C.MPLG_KODE                     
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

    function selectByParamsAktif($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NOMOR ASC ")
	{
		$str = "
				SELECT A.NO_FAKTUR_PAJAK_ID, NO_NOTA,
                       NOMOR, STATUS
                FROM PERPAJAKAN.NO_FAKTUR_PAJAK_D A INNER JOIN PERPAJAKAN.NO_FAKTUR_PAJAK B ON A.NO_FAKTUR_PAJAK_ID = B.NO_FAKTUR_PAJAK_ID
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
				SELECT NO_FAKTUR_PAJAK_ID, 
					   NOMOR, STATUS
				FROM PERPAJAKAN.NO_FAKTUR_PAJAK_D
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY TANGGAL_AWAL DESC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(NO_FAKTUR_PAJAK_ID) AS ROWCOUNT FROM PERPAJAKAN.NO_FAKTUR_PAJAK_D
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
		$str = "SELECT COUNT(NO_FAKTUR_PAJAK_ID) AS ROWCOUNT FROM PERPAJAKAN.NO_FAKTUR_PAJAK_D
		        WHERE NO_FAKTUR_PAJAK_ID IS NOT NULL ".$statement; 
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