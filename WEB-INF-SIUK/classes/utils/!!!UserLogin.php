<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: TamuLogin.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Class that responsible to handle process authentication for users on Admin group
***************************************************************************************************** */

/***********************************************************************
class.userlogin.php	
Mengelola informasi tentang user login. Untuk menggunakan kelas ini tidak
perlu di-instansiasi dulu, sudah otomatis.
Priyo Edi Purnomo dimodifikasi M Reza Faisal
************************************************************************/

include_once("../WEB-INF/classes/entities/Users.php");

  class UserLogin{
    /* Properties */
    //-- PERSISTENT IN SESSION
	var $UID;
    var $idUser;
	var $loginTime;
	var $loginTimeStr;
	var $userLevel;
	
	var $pageLevel;
		
    //-- NOT PERSISTENT
	var $admin;
	var $active;
    var $nama;
	var $password;
    var $email;
    var $website;
	
	//-- BUGTRACK
	var $query;

    /******************** CONSTRUCTOR **************************************/
    function UserLogin(){
		session_register("ssUsr_UID");
		session_register("ssUsr_idUser");
		session_register("ssUsr_loginTime");
		session_register("ssUsr_loginTimeStr");			
	
		 $this->emptyProps();
		 $this->setProps();
    }

    /******************** METHODS ************************************/
    /** Empty the properties **/
    function emptyProps(){
		$this->UID = "";
		$this->idUser = "";
		$this->loginTime = "";
		$this->loginTimeStr = "";
		$this->userLevel = "";
		$this->pageLevel = false;
			
		$this->active = false;
    }

    /** empty sessions **/
    function emptyUsrSessions(){
		$_SESSION["ssUsr_UID"] = "";
		$_SESSION["ssUsr_idUser"] = "";
		$_SESSION["ssUsr_loginTime"] = "";
		$_SESSION["ssUsr_loginTimeStr"] = "";
		$_SESSION["ssUsr_level"] = "";
    }

	/** reset user information **/
	function resetUserInfo(){
		$this->emptyUsrSessions();
		$this->emptyProps();
	}
		
    /** set properties depends on data from sessions**/
    function setProps(){
		$this->UID = $_SESSION["ssUsr_UID"];
		$this->idUser = $_SESSION["ssUsr_idUser"];
		$this->loginTime = $_SESSION["ssUsr_loginTime"];
		$this->loginTimeStr = $_SESSION["ssUsr_loginTimeStr"];
		$this->userLevel = $_SESSION["ssUsr_level"];
		if($this->idUser)
			//$this->active = true;
			$this->active = true; //$this->idUser;
    }
    
    /** Verify user login. True when login is valid**/
    function verifyUserLogin($usrLogin,$password){			
		$usr = new Users();

		$this->resetUserInfo();
		if(trim($usrLogin)=="" || trim($password)==""){				
			//echo 'gagal 1<br>';
			return false;        
		}	
		if(!$usr->selectByIdPassword($usrLogin,md5($password.'BAKWAN'))){
			//echo 'gagal 2<br>';
			return false;
		}
			
		if($usr->firstRow()){
			//echo $usr->field("USER_ID").'<br>';
			$_SESSION["ssUsr_UID"] = $usr->getField("UID");
			$_SESSION["ssUsr_idUser"] = $usr->getField("USER_NAME");
			
			$_SESSION["ssUsr_loginTime"] = time();
			$_SESSION["ssUsr_loginTimeStr"] = date("l, j M Y, H:i",time());
			$_SESSION["ssUsr_level"] = $usr->getField("LEVEL");
			$this->setProps();
		}else{
			//echo 'gagal 3<br>';
			//echo "tidak ada user";
			return false; //login/password salah								
  	  }
      unset($usr);
      return true;
    }
		
	//login user without password
	function verifyUserLoginNoPassword($usrLogin){			
      	$usr = new Users();
			
		$this->resetUserInfo();
      	if(trim($usrLogin)==""){				
			return false;        
		}
				
      	if(!$usr->findById($usrLogin)){
        	return false; //login/password salah
      }
			
			//echo $success.NL;		
      if($usr->firstRow()){
				if($usr->field("aktif")){
					$_SESSION["ssUsr_UID"] = $usr->getField("UID");
					$_SESSION["ssUsr_idUser"] = $usr->getField("USER_NAME");
					$_SESSION["ssUsr_loginTime"] = time();
					$_SESSION["ssUsr_loginTimeStr"] = date("l, j M Y, H:i",time());
					//$this->setProps();
				} else
					return false;//user tidak aktif
      }else
				return false; //login/password salah
				
      unset($usr);
      return true;
    }
    
	// added by esa unutk ubah password supaya jika pengisian password salah tidak dilakukan verify user login
	function verifyPassLama($usrLogin,$password){			
      $usr = new Users();
			
	  if(!$usr->selectByIdPassword($usrLogin,$password)){
        return false;
		exit();
      }
					
      if($usr->firstRow()){
        $this->active=true;
		return true;
	  }else {
		return false;
	  }
				
      unset($usr);
      return true;
    }

    /** Reset login information **/
    function resetLogin(){
      $this->emptyUsrSessions();
      $this->emptyProps();
    }

    /** Cek apakah user sudah login atau belum **/
    function checkUserLogin(){
		$usr = new Users();
		
		$statusLogin = false;
		if (trim($_SESSION["ssUsr_idUser"])) {
			$statusLogin = false;
		}
		$usr->selectById($_SESSION["ssUsr_idUser"]);
		if (!$usr->firstRow()) {
			$statusLogin = false;
		} else {
			$statusLogin = true;
		}
		
		if (!$statusLogin) {
			echo '<script language="javascript">';
			echo 'alert("Anda tidak punya hak mengakses halaman ini.\n Silakan login terlebih dahulu.");';
			echo 'document.location = "login.php";';
			echo '</script>';
			
			exit;
		}
		/*
			return true;
      if(!$this->active){
        unset($dbMgr);
        unset($this);
        showMessageDlg("Untuk mengakses halaman ini anda harus login dulu!",false,"../","parent.");
      }
	  */
	  
	  	return $statusLogin;
    }

    /** Cek apakah user memiliki kode akses yang dimaksud **/
    function checkAccessCode($accessCode=""){

      $found=0;

      if($accessCode=="")
        return true;
      else{//ada kode aksesnya
        $usr = new User();
        $usr->load($this->usrID);
        $groupFac=new GrpPrivilege();
        $groupFac->findByIdGroup($usr->idGroup);
        if ($groupFac->firstRow()){
          do{
            if ($groupFac->accessCode==$accessCode)
              $found=1;
          }while($groupFac->goNext() && !$found);
        }
        unset($groupFac);
        unset($usr);
        unset($this);
        if (!$found)
          showMessageDlg("Anda tidak memiliki hak untuk mengakses fasilitas ini.",false,"../main/mainpage.php");
        else
          return true;

      }

    }

	/** Mengambil informasi user yang sedang logged in **/
	function retrieveUserInfo(){
		$usr = new Users();
		$usr->selectById($_SESSION["ssUsr_idUser"]);
		if ($usr->firstRow()) {
			$this->UID = $_SESSION["ssUsr_UID"];
			$this->idUser = $_SESSION["ssUsr_idUser"];
			$this->nama = $usr->getField("NAMA");
			$this->password = $usr->getField("PASSWORD");
		}
		
		$this->query = $usr->query;
		
		unset($usr);
	}
  	
	/* Mengambil informasi tanggal login */  
	function getLoginDateStr(){
		return date("l, j M Y",$this->loginTime);		
	}
		
	/* Mengambil informasi tanggal login */  
	function getLoginTimeStr(){
		return date("H:i",$this->loginTime);		
	}
	
	/* mengeset level akses halaman 
	   isi $varLevel dengan array untuk multilevel
	*/
	function setPageLevel($varLevel)
	{
		$this->pageLevel = $varLevel;
	}
	
	/* Mengecek level akses halaman berdasarkan $pageLevel dan $userLevel. 
	   Jika privilege tepat maka return true.
	   Jika $pageLevel tidak diset maka akan selalu return true */
	function checkPagePrivileges($autoExit = true)
	{
		$ret = false;
		
		if($this->pageLevel == false)
			$ret = true;
		
		// if admin, bypass checking
		// check whether $pageLevel is array or not
		if(is_array($this->pageLevel))
		{
			foreach($this->pageLevel as $key => $value)
			{
				if($value == $this->userLevel || $this->userLevel == '1' || $this->pageLevel == '999')
				{
					$ret = true;
					break;
				}
			}
		}
		else
		{
			if($this->pageLevel == $this->userLevel || $this->userLevel == '1' || $this->pageLevel == '999')
				$ret = true;
			else
				$ret = false;
		}
		
		
		if($autoExit == true)
		{
			if($ret == false) exit;
		}
		else
			return $ret;
	}
}
	
  /***** INSTANTIATE THE GLOBAL OBJECT */
  $userLogin = new UserLogin();

?>