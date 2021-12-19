<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: TamuLogin.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Class that responsible to handle process authentication for users on Tamu group
***************************************************************************************************** */

/***********************************************************************
class.TamuLogin.php	
Mengelola informasi tentang user login. Untuk menggunakan kelas ini tidak
perlu di-instansiasi dulu, sudah otomatis.
Priyo Edi Purnomo dimodifikasi M Reza Faisal
************************************************************************/

include_once("../WEB-INF/classes/entities/Tamu.php");

  class TamuLogin{
    /* Properties */
    //-- PERSISTENT IN SESSION
    var $idUser;
	var $loginTime;
	var $loginTimeStr;
		
		
    //-- NOT PERSISTENT
	var $admin;
	var $active;
    var $nama;
    var $email;
    var $website;

    /******************** CONSTRUCTOR **************************************/
    function TamuLogin(){
		session_register("ssTamu_idUser");
		session_register("ssTamu_loginTime");
		session_register("ssTamu_loginTimeStr");			
	
		 $this->emptyProps();
		 $this->setProps();
    }

    /******************** METHODS ************************************/
    /** Empty the properties **/
    function emptyProps(){
		$this->idUser = "";
		$this->loginTime = "";
		$this->loginTimeStr = "";
			
		$this->active = false;
    }

    /** empty sessions **/
    function emptyUsrSessions(){
		$_SESSION["ssTamu_idUser"] = "";
		$_SESSION["ssTamu_loginTime"] = "";
		$_SESSION["ssTamu_loginTimeStr"] = "";
    }

	/** reset user information **/
	function resetUserInfo(){
		$this->emptyUsrSessions();
		$this->emptyProps();
	}
		
    /** set properties depends on data from sessions**/
    function setProps(){
		$this->idUser = $_SESSION["ssTamu_idUser"];
		$this->loginTime = $_SESSION["ssTamu_loginTime"];
		$this->loginTimeStr = $_SESSION["ssTamu_loginTimeStr"];
		if($this->idUser)
			//$this->active = true;
			$this->active = true; //$this->idUser;
    }
    
    /** Verify user login. True when login is valid**/
    function verifyTamuLogin($usrLogin,$password){			
		$usr = new Tamu();
		
		$statusLogin = false;
		$this->resetUserInfo();
		if(trim($usrLogin)=="" || trim($password)==""){				
			//echo 'gagal 1<br>';
			$statusLogin = false;      
		}	
		if(!$usr->selectByIdPassword($usrLogin,$password)){
			//echo 'gagal 2<br>';
			$statusLogin = false;
		}
			
		if($usr->firstRow()){
			//echo $usr->getField("USER_NAME").'<br>';
			$_SESSION["ssTamu_idUser"] = $usr->getField("USER_NAME");
			
			$_SESSION["ssTamu_loginTime"] = time();
			$_SESSION["ssTamu_loginTimeStr"] = date("l, j M Y, H:i",time());
			$this->setProps();
			$statusLogin = true;
		}else{
			//echo 'gagal 3<br>';
			//echo "tidak ada user";
			$statusLogin = false; //login/password salah								
  	  }
      unset($usr);
      return $statusLogin;
    }

    /** Reset login information **/
    function resetLogin(){
      $this->emptyUsrSessions();
      $this->emptyProps();
    }

    /** Cek apakah user sudah login atau belum **/
    function checkTamuLogin(){
		$usr = new Tamu();
		
		$statusLogin = false;
		if (trim($_SESSION["ssTamu_idUser"])) {
			$statusLogin = false;
		}
		$usr->selectById($_SESSION["ssTamu_idUser"]);
		if (!$usr->firstRow()) {
			$statusLogin = false;
		} else {
			$statusLogin = true;
		}
		
		return $statusLogin;
    }
	
	function showMsgErrorLogin($_page) {
		echo '<script language="javascript">';
		echo 'alert("Username atau Password yang dimasukkan salah");';
		echo 'document.location = "'.$_page.'";';
		echo '</script>';
	}
	
	function showMsgErrorAccessPage() {
		echo '<script language="javascript">';
		echo 'alert("Anda tidak punya hak mengakses halaman ini.\n Silakan login terlebih dahulu.");';
		echo 'document.location = "../main/index.php";';
		echo '</script>';
	}

	/** Mengambil informasi user yang sedang logged in **/
	function retrieveUserInfo(){
		$usr = new Tamu();
		$usr->selectById($_SESSION["ssTamu_idUser"]);
		if ($usr->firstRow()) {
			$this->idUser = $_SESSION["ssTamu_idUser"];
			$this->nama = $usr->getField("NAMA");
		}
	}
  	
	/* Mengambil informasi tanggal login */  
	function getLoginDateStr(){
		return date("l, j M Y",$this->loginTime);		
	}
		
	/* Mengambil informasi tanggal login */  
	function getLoginTimeStr(){
		return date("H:i",$this->loginTime);		
	}
}
	
  /***** INSTANTIATE THE GLOBAL OBJECT */
  $tamuLogin = new TamuLogin();

?>