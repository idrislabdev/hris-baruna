<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class GajiAwalBulanLog extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function GajiAwalBulanLog()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
				INSERT INTO PPI_GAJI.GAJI_AWAL_BULAN_LOG (
				   PERIODE, TANGGAL_PROSES, PROSES_BY, JENIS_PROSES) 
				VALUES ( '".$this->getField("PERIODE")."',
						  SYSDATE,
						  '".$this->getField("PROSES_BY")."',
						  '".$this->getField("JENIS_PROSES")."'
				)"; 
		$this->id = $this->getField("ASURANSI_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

  } 
?>