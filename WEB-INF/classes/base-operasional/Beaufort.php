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

  class Beaufort extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function Beaufort()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("BEAUFORT_ID", $this->getNextId("BEAUFORT_ID","PPI_OPERASIONAL.BEAUFORT"));

		$str = "
				INSERT INTO PPI_OPERASIONAL.BEAUFORT (
				   BEAUFORT_ID, BEAUFORT_NUMBER, KEADAAN_ANGIN_KNOTS, 
				   KEADAAN_ANGIN_MPH, KETINGGIAN_GELOMBANG_METER, KETINGGIAN_GELOMBANG_FEET, 
				   GEJALA_DIAMATI_DARAT, GEJALA_DIAMATI_LAUT, KEADAAN_ANGIN) 
 			  	VALUES (
				  ".$this->getField("BEAUFORT_ID").",
				  '".$this->getField("BEAUFORT_NUMBER")."',
				  '".$this->getField("KEADAAN_ANGIN_KNOTS")."',
				  '".$this->getField("KEADAAN_ANGIN_MPH")."',
				  '".$this->getField("KETINGGIAN_GELOMBANG_METER")."',
				  '".$this->getField("KETINGGIAN_GELOMBANG_FEET")."',
				  '".$this->getField("GEJALA_DIAMATI_DARAT")."',
				  '".$this->getField("GEJALA_DIAMATI_LAUT")."',
				  '".$this->getField("KEADAAN_ANGIN")."'		  
				)"; 
		$this->id = $this->getField("BEAUFORT_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE PPI_OPERASIONAL.BEAUFORT
				SET    
					   BEAUFORT_NUMBER       = '".$this->getField("BEAUFORT_NUMBER")."',
					   KEADAAN_ANGIN_KNOTS	= '".$this->getField("KEADAAN_ANGIN_KNOTS")."',
					   KEADAAN_ANGIN_MPH	 				= '".$this->getField("KEADAAN_ANGIN_MPH")."',
					   KETINGGIAN_GELOMBANG_METER	 		= '".$this->getField("KETINGGIAN_GELOMBANG_METER")."',
					   KETINGGIAN_GELOMBANG_FEET	 		= '".$this->getField("KETINGGIAN_GELOMBANG_FEET")."',
					   GEJALA_DIAMATI_DARAT	 				= '".$this->getField("GEJALA_DIAMATI_DARAT")."',
					   GEJALA_DIAMATI_LAUT	= '".$this->getField("GEJALA_DIAMATI_LAUT")."',
					   KEADAAN_ANGIN	 	= '".$this->getField("KEADAAN_ANGIN")."'
				WHERE  BEAUFORT_ID  			= '".$this->getField("BEAUFORT_ID")."'
			 "; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function upload($table, $column, $blob, $id)
	{
		return $this->uploadBlob($table, $column, $blob, $id);
    }
	
	function delete()
	{
        $str = "DELETE FROM PPI_OPERASIONAL.BEAUFORT
                WHERE 
                  BEAUFORT_ID = ".$this->getField("BEAUFORT_ID").""; 
				  
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
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order="ORDER BY BEAUFORT_ID ASC")
	{
		$str = "
				SELECT 
				BEAUFORT_ID, BEAUFORT_NUMBER, KEADAAN_ANGIN_KNOTS, 
				   KEADAAN_ANGIN_MPH, KETINGGIAN_GELOMBANG_METER, KETINGGIAN_GELOMBANG_FEET, 
				   GEJALA_DIAMATI_DARAT, GEJALA_DIAMATI_LAUT, ILUSTRASI_KEADAAN_LAUT, 
				   ILUSTRASI_KEADAAN_DARAT, BENDERA_PERINGATAN, KEADAAN_ANGIN
				FROM PPI_OPERASIONAL.BEAUFORT
                WHERE 1=1
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
				BEAUFORT_ID, BEAUFORT_NUMBER, KEADAAN_ANGIN_KNOTS, 
				   KEADAAN_ANGIN_MPH, KETINGGIAN_GELOMBANG_METER, KETINGGIAN_GELOMBANG_FEET, 
				   GEJALA_DIAMATI_DARAT, GEJALA_DIAMATI_LAUT, ILUSTRASI_KEADAAN_LAUT, 
				   ILUSTRASI_KEADAAN_DARAT, BENDERA_PERINGATAN
				FROM PPI_OPERASIONAL.BEAUFORT
                WHERE 1=1
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY BEAUFORT_ID ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
	
	function getDynaByParams($id="",$field="")
	{
		$str = "SELECT ".$field." AS ROWCOUNT FROM PPI_OPERASIONAL.BEAUFORT
		        WHERE BEAUFORT_ID IS NOT NULL AND BEAUFORT_ID = ".$id; 
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(BEAUFORT_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.BEAUFORT
		        WHERE BEAUFORT_ID IS NOT NULL ".$statement; 
		
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
		$str = "SELECT COUNT(BEAUFORT_ID) AS ROWCOUNT FROM PPI_OPERASIONAL.BEAUFORT
		        WHERE BEAUFORT_ID IS NOT NULL ".$statement; 
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