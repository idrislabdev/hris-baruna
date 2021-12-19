<? 
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: group_accessBase.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Entity-base class for tabel group_accessimplementation
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel group_access.
  * 
  * @author M Reza Faisal
  * @generated by Entity Generator 5.8.3
  * @generated on 27-Apr-2005,14:15
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class GroupAccessBase extends Entity{ 

	var $query;
    /**
    * Class constructor.
    * @author M Reza Faisal
    **/
    function GroupAccess(){
      $this->Entity(); 
    }

    /**
    * Cek apakah operasi insert dapat dilakukan atau tidak 
    * @author M Reza Faisal
    * @return boolean True jika insert boleh dilakukan, false jika tidak.
    **/
    function canInsert(){
      return true;
    }

    /**
    * Insert record ke database. 
    * @author M Reza Faisal
    * @return boolean True jika insert sukses, false jika tidak.
    **/
    function insert(){
      if(!$this->canInsert())
        showMessageDlg("Data group_access tidak dapat di-insert",true);
      else{
	  	/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("GAID", $this->getNextId("GAID","group_access")); 			
		$str = "INSERT INTO group_access
                (GAID, UGID, id_menu) 
                VALUES(
				  '".$this->getField("GAID")."',
                  '".$this->getField("UGID")."',
				  '".$this->getField("id_menu")."'
                )"; 
		$this->query = $str;
        return $this->execQuery($str);
      }
    }

    /**
    * Cek apakah operasi update dapat dilakukan atau tidak. 
    * @author M Reza Faisal
    * @return boolean True jika update dapat dilakukan, false jika tidak.
    **/
    function canUpdate(){
      return true;
    }

    /**
    * Update record. 
    * @author M Reza Faisal
    * @return boolean True jika update sukses, false jika tidak.
    **/
    function update(){
      if(!$this->canUpdate())
        showMessageDlg("Data group_access tidak dapat diupdate",true);
      else{
        //$this->setField("PASSWORD", md5($this->getField("PASSWORD")."BAKWAN"));
		$str = "UPDATE group_access
                SET 
				  UGID = '".$this->getField("UGID")."',
                  id_menu = '".$this->getField("id_menu")."'
                WHERE 
                  GAID = '".$this->getField("GAID")."'"; 
				  $this->query = $str;
        return $this->execQuery($str);
      }
    }

    /**
    * Cek apakah record dapat dihapus atau tidak. 
    * @author M Reza Faisal
    * @return boolean True jika record dapat dihapus, false jika tidak.
    **/
    function canDelete(){
      return true;
    }

    /**
    * Menghapus record sesuai id-nya. 
    * @author M Reza Faisal
    * @return boolean True jika penghapusan sukses, false jika tidak.
    **/
    function deleteByUGID($UGID){
      if(!$this->canDelete())
        showMessageDlg("Data group_access tidak dapat di-hapus",true);
      else{
        $str = "DELETE FROM group_access
                WHERE 
                  UGID = '".$UGID."'"; 
	  $this->query = $str;
        return $this->execQuery($str);
      }
    }

    /**
    * Cari record berdasarkan id-nya. 
    * @author M Reza Faisal
    * @param string USER_NAME Id record 
    * @return boolean True jika pencarian sukses, false jika tidak.
    **/
    function selectById($GAID){
      $str = "SELECT * FROM group_access
              WHERE 
                GAID = '".$GAID."'"; 
				
		$this->query = $str;
		
      $this->select($str);
	  if($this->firstRow()) 
        return true; 
      else 
         return false; 
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @author M Reza Faisal
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1){
      $str = "SELECT 
				USER_GROUP_ID, AKSES_APP_DATABASE_ID, AKSES_APP_OPERASIONAL_ID, 
				   AKSES_APP_KEPEGAWAIAN_ID, AKSES_APP_PENGHASILAN_ID, AKSES_APP_PRESENSI_ID, 
				   AKSES_APP_PENILAIAN_ID, AKSES_APP_BACKUP_ID, AKSES_ADM_WEBSITE_ID, 
				   AMBIL_GROUP_AKSES_INTRANET(AKSES_ADM_INTRANET_ID) AKSES_ADM_INTRANET
				FROM USER_GROUP WHERE 1 = 1 "; 
      while(list($key,$val)=each($paramsArray)){
        $str .= " AND $key = '$val' ";
      }
      $str .= " ORDER BY USER_GROUP_ID";
	 // echo $str;
	  $this->query = $str;
      return $this->selectLimit($str,$limit,$from); 
    }

    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @author M Reza Faisal
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $varStatement=""){
      $str = "SELECT COUNT(GAID) AS ROWCOUNT FROM group_access WHERE GAID IS NOT NULL ".$varStatement; 
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