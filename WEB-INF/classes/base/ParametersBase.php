<? 
/* *******************************************************************************************************
MODUL NAME 			: SIMKeu
FILE NAME 			: ParametersBase.php
AUTHOR				: Ridwan Rismanto
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Entity-base class for tabel parameters implementation
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel parameters.
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class ParametersBase extends Entity{ 
	
	var $baseQuery;
    /**
    * Class constructor.
    **/
    function ParametersBase(){
      $this->Entity(); 
    }

    /**
    * Cek apakah operasi insert dapat dilakukan atau tidak 
	* @author Wawan
    * @return boolean True jika insert boleh dilakukan, false jika tidak.
    **/
    function canInsert(){
      return true;
    }

    /**
    * Insert record ke database. 
	* @author Wawan
    * @return boolean True jika insert sukses, false jika tidak.
    **/
    function insert(){
      if(!$this->canInsert())
        showMessageDlg("Data parameters tidak dapat di-insert",true);
      else{ 
        /*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("ID_PARAMETERS",$this->getNextId("ID_PARAMETERS","parameters")); 
        $str = "INSERT INTO parameters 
                (ID_PARAMETERS,PARAM_KEY,VALUE,MEMBER_OF,KETERANGAN) 
                VALUES(
				  ".$this->getField("ID_PARAMETERS").",
                  '".$this->getField("PARAM_KEY")."',
				  '".$this->getField("VALUE")."',
				  '".$this->getField("MEMBER_OF")."',
                  '".$this->getField("KETERANGAN")."'
                )"; 
		$this->baseQuery = $str;
		
        return $this->execQuery($str);
      }
    }

    /**
    * Cek apakah operasi update dapat dilakukan atau tidak. 
    * @author Wawan
    * @return boolean True jika update dapat dilakukan, false jika tidak.
    **/
    function canUpdate(){
      return true;
    }

    /**
    * Update record. 
    * @author Wawan
    * @return boolean True jika update sukses, false jika tidak.
    **/
    function update(){
      if(!$this->canUpdate())
        showMessageDlg("Data parameters tidak dapat diupdate",true);
      else{
        $str = "UPDATE parameters 
                SET 
                  PARAM_KEY = '".$this->getField("PARAM_KEY")."',
                  VALUE = '".$this->getField("VALUE")."',
				  MEMBER_OF = '".$this->getField("MEMBER_OF")."',
				  KETERANGAN = '".$this->getField("KETERANGAN")."'
                WHERE 
                  ID_PARAMETERS = '".$this->getField("ID_PARAMETERS")."'"; 
		$this->baseQuery = $str;
        return $this->execQuery($str);
      }
    }

    /**
    * Cek apakah record dapat dihapus atau tidak. 
    * @author Wawan
    * @return boolean True jika record dapat dihapus, false jika tidak.
    **/
    function canDelete(){
      return true;
    }

    /**
    * Menghapus record sesuai id-nya. 
    * @author Wawan
    * @return boolean True jika penghapusan sukses, false jika tidak.
    **/
    function delete(){
      if(!$this->canDelete())
        showMessageDlg("Data parameters tidak dapat di-hapus",true);
      else{
        $str = "DELETE FROM parameters 
                WHERE 
                  ID_PARAMETERS = '".$this->getField("ID_PARAMETERS")."'"; 
        return $this->execQuery($str);
      }
    }

    /**
    * Cari record berdasarkan id-nya. 
    * @author Wawan
    * @param int ID_PARAMETERS Id record 
    * @return boolean True jika pencarian sukses, false jika tidak.
    **/
    function selectById($ID_PARAMETERS){
      $str = "SELECT * FROM parameters
              WHERE 
                ID_PARAMETERS = '".$ID_PARAMETERS."'"; 
      return $this->select($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @author Wawan
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
	* $orderKey : order berdasarkan ...
	* $orderMethod : metode order (ASC, DESC)
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$orderKey="ID_PARAMETERS",$orderMethod="ASC"){
      $str = "SELECT * FROM parameters WHERE ID_PARAMETERS IS NOT NULL "; 
      while(list($key,$val)=each($paramsArray)){
        $str .= " AND $key = '$val' ";
      }
      $str .= " ORDER BY";
	  $str .= " ".$orderKey;
	  $str .= " ".$orderMethod;
	  
	  $this->baseQuery = $str;
      return $this->selectLimit($str,$limit,$from); 
    }

    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @author Wawan
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array()){
      $str = "SELECT COUNT(ID_PARAMETERS) AS ROWCOUNT FROM parameters WHERE ID_PARAMETERS IS NOT NULL "; 
      while(list($key,$val)=each($paramsArray)){
        $str .= " AND $key = '$val' ";
      }
      $this->select($str); 
      if($this->firstRow()) 
        return $this->getField("ROWCOUNT"); 
      else 
         return 0; 
    }
  } 
?>