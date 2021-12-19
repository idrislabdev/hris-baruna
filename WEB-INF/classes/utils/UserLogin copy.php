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

include_once("../WEB-INF/classes/utils/GlobalParam.php");
include_once("../WEB-INF/classes/entities/Users.php");
include_once("../WEB-INF/classes/entities/GroupAccess.php");

  class UserLogin{
    /* Properties */
    //-- PERSISTENT IN SESSION
	var $UID;
	var $pegawaiId;
	var $nama;
    var $idUser;
	var $loginTime;
	var $loginTimeStr;
	var $level;
	var $idLevel;
	var $userStatus;
	var $userRekanan;
	var $userKodeRekanan;
	var $idDepartemen;	
	var $departemen; 
	var $idCabang;
	var $userPKP;	 
	var $userNPWP;	 
	var $userStatusPerusahaan;
	var $userAksesIntranet;
	var $userAksesOperasional;
	var $userAksesArsip;
	var $userAksesInventaris;
	var $userAksesSPPD;
	var $userAksesKepegawaian;
	var $userAksesPenghasilan;
	var $userAksesPresensi;
	var $userAksesPenilaian;
	var $userAksesBackup;
	var $userAksesHukum;
	var $userAksesAnggaran;
	var $userAksesKomersial;
	var $userAksesWebsite;
	var $userAksesSurvey;
	var $userAksesFileManager;
	var $userAksesSMSGateway;
	var $userAksesKeuangan;
	var $userAksesDokumenHukum;
	var $userStatusValidasi;
	var $userPublish;
	
	var $pageLevel;
	var $bannedPageLevel;
	
	var $pageId;
		
    //-- NOT PERSISTENT
	var $userSatker;
	var $userJenis;
	var $userEmail;
	var $userHp;
	var $active;
	//-- BUGTRACK
	var $query;

    /******************** CONSTRUCTOR **************************************/
    function UserLogin(){
		/*session_register("ssUsr_UID");
		session_register("ssUsr_pegawaiId");
		session_register("ssUsr_userPublish");
		session_register("ssUsr_idUser");
		session_register("ssUsr_nama");	
		session_register("ssUsr_loginTime");
		session_register("ssUsr_loginTimeStr");					
		session_register("ssUsr_userSatker");
		session_register("ssUsr_userJenis");
		session_register("ssUsr_userEmail");
		session_register("ssUsr_level");		
		session_register("ssUsr_idLevel");		
		session_register("ssUsr_rekanan");
		session_register("ssUsr_idDepartemen");
		session_register("ssUsr_idCabang");
		session_register("ssUsr_departemen");
		session_register("ssUsr_KodeRekanan");
		session_register("ssUsr_userPKP");
		session_register("ssUsr_userNPWP");
		session_register("ssUsr_userStatusPerusahaan");
		session_register("ssUsr_userStatusValidasi");
		session_register("ssUsr_userAksesIntranet");
		session_register("ssUsr_userAksesOperasional");
		session_register("ssUsr_userAksesArsip");
		session_register("ssUsr_userAksesInventaris");
		session_register("ssUsr_userAksesSPPD");
		session_register("ssUsr_userAksesKepegawaian");
		session_register("ssUsr_userAksesPenghasilan");
		session_register("ssUsr_userAksesPresensi");
		session_register("ssUsr_userAksesPenilaian");
		session_register("ssUsr_userAksesBackup");
		session_register("ssUsr_userAksesHukum");
		session_register("ssUsr_userAksesAnggaran");
		session_register("ssUsr_userAksesWebsite");
		session_register("ssUsr_userAksesSurvey");
		session_register("ssUsr_userAksesFileManager");
		session_register("ssUsr_userAksesSMSGateway");
		session_register("ssUsr_userAksesKeuangan");
		session_register("ssUsr_userAksesDokumenHukum");
		session_register("ssUsr_userAksesKomersial");*/
		 $this->emptyProps();
		 $this->setProps();
    }

    /******************** METHODS ************************************/
    /** Empty the properties **/
    function emptyProps(){
		$this->UID = "";
		$this->pegawaiId = "";
		$this->userPublish = "";
		$this->idUser = "";
		$this->nama = "";		
		$this->loginTime = "";
		$this->loginTimeStr = "";
		$this->level = "";
		$this->idLevel = "";
		$this->userStatus = "";
		$this->kelas = "";
		$this->userPKP = "";
		$this->userNPWP = "";
		$this->userStatusPerusahaan = "";
		$this->userAksesIntranet = "";
		$this->userAksesBackup = "";
		$this->userAksesHukum = "";
		$this->userAksesAnggaran = "";
		$this->userAksesKepegawaian = "";
		$this->userAksesArsip = "";
		$this->userAksesInventaris = "";
		$this->userAksesSPPD = "";
		$this->userAksesOperasional = "";
		$this->userAksesPenghasilan = "";
		$this->userAksesPenilaian = "";
		$this->userAksesPresensi = "";
		$this->userAksesWebsite = "";
		$this->userAksesSurvey = "";
		$this->userAksesFileManager = "";
		$this->userAksesSMSGateway = "";
		$this->userAksesKomersial = "";
		$this->userAksesKeuangan = "";
		$this->userAksesDokumenHukum = "";
		$this->pageLevel = false;
			
		$this->active = false;
    }

    /** empty sessions **/
    function emptyUsrSessions(){
		$_SESSION["ssUsr_UID"] = "";
		$_SESSION["ssUsr_pegawaiId"] = "";
		$_SESSION["ssUsr_userPublish"] = "";
		$_SESSION["ssUsr_idUser"] = "";
		$_SESSION["ssUsr_nama"] = "";		
		$_SESSION["ssUsr_loginTime"] = "";
		$_SESSION["ssUsr_loginTimeStr"] = "";		
		$_SESSION["ssUsr_userSatker"] = "";
		$_SESSION["ssUsr_userJenis"] = "";	
		$_SESSION["ssUsr_userEmail"] = "";	
		$_SESSION["ssUsr_level"] = "";		
		$_SESSION["ssUsr_idLevel"] = "";			
		$_SESSION["ssUsr_rekanan"] = "";
		$_SESSION["ssUsr_idDepartemen"] = "";
		$_SESSION["ssUsr_idCabang"] = "";
		$_SESSION["ssUsr_departemen"] = "";
		$_SESSION["ssUsr_KodeRekanan"] = "";
		$_SESSION["ssUsr_userPKP"] = "";
		$_SESSION["ssUsr_userNPWP"] = "";
		$_SESSION["ssUsr_userStatusPerusahaan"] = "";
		$_SESSION["ssUsr_userStatusValidasi"] = "";
		$_SESSION["ssUsr_userAksesIntranet"] = "";
		$_SESSION["ssUsr_userAksesOperasional"] = "";
		$_SESSION["ssUsr_userAksesArsip"] = "";
		$_SESSION["ssUsr_userAksesInventaris"] = "";
		$_SESSION["ssUsr_userAksesSPPD"] = "";
		$_SESSION["ssUsr_userAksesKepegawaian"] = "";
		$_SESSION["ssUsr_userAksesPenghasilan"] = "";
		$_SESSION["ssUsr_userAksesPresensi"] = "";
		$_SESSION["ssUsr_userAksesPenilaian"] = "";
		$_SESSION["ssUsr_userAksesBackup"] = "";
		$_SESSION["ssUsr_userAksesHukum"] = "";
		$_SESSION["ssUsr_userAksesAnggaran"] = "";
		$_SESSION["ssUsr_userAksesWebsite"] = "";		
		$_SESSION["ssUsr_userAksesSurvey"] = "";	
		$_SESSION["ssUsr_userAksesFileManager"] = "";
		$_SESSION["ssUsr_userAksesSMSGateway"] = "";
		$_SESSION["ssUsr_userAksesKeuangan"] = "";
		$_SESSION["ssUsr_userAksesDokumenHukum"] = "";
		$_SESSION["ssUsr_userAksesKomersial"] = "";	
		
    }

	/** reset user information **/
	function resetUserInfo(){
		$this->emptyUsrSessions();
		$this->emptyProps();
	}
		
    /** set properties depends on data from sessions**/
    function setProps(){
		$this->UID = $_SESSION["ssUsr_UID"];
		$this->pegawaiId = $_SESSION["ssUsr_pegawaiId"];
		$this->userPublish = $_SESSION["ssUsr_userPublish"];
		
		$this->idUser = $_SESSION["ssUsr_idUser"];
		$this->nama = $_SESSION["ssUsr_nama"];		
		$this->loginTime = $_SESSION["ssUsr_loginTime"];
		$this->loginTimeStr = $_SESSION["ssUsr_loginTimeStr"];
		$this->level = $_SESSION["ssUsr_level"];
		$this->idLevel = $_SESSION["ssUsr_idLevel"];
		$this->userRekanan = $_SESSION["ssUsr_rekanan"];
		$this->idDepartemen = $_SESSION["ssUsr_idDepartemen"];
		$this->idCabang = $_SESSION["ssUsr_idCabang"];
		$this->departemen = $_SESSION["ssUsr_departemen"];
		$this->userKodeRekanan = $_SESSION["ssUsr_KodeRekanan"];
		$this->userPKP = $_SESSION["ssUsr_userPKP"];
		$this->userNPWP = $_SESSION["ssUsr_userNPWP"];
		$this->userStatusPerusahaan = $_SESSION["ssUsr_userStatusPerusahaan"];
		$this->userStatusValidasi = $_SESSION["ssUsr_userStatusValidasi"];

		$this->arrGroupIntranet = $_SESSION["ssUsr_arrGroupIntranet"];
		$this->userAksesIntranet = $_SESSION["ssUsr_userAksesIntranet"];
		$this->userAksesOperasional = $_SESSION["ssUsr_userAksesOperasional"];
		$this->userAksesArsip = $_SESSION["ssUsr_userAksesArsip"];
		$this->userAksesInventaris = $_SESSION["ssUsr_userAksesInventaris"];
		$this->userAksesSPPD = $_SESSION["ssUsr_userAksesSPPD"];
		$this->userAksesKepegawaian = $_SESSION["ssUsr_userAksesKepegawaian"];
		$this->userAksesPenghasilan = $_SESSION["ssUsr_userAksesPenghasilan"];
		$this->userAksesPresensi = $_SESSION["ssUsr_userAksesPresensi"];
		$this->userAksesPenilaian = $_SESSION["ssUsr_userAksesPenilaian"];
		$this->userAksesBackup = $_SESSION["ssUsr_userAksesBackup"];
		$this->userAksesHukum = $_SESSION["ssUsr_userAksesHukum"];
		$this->userAksesAnggaran = $_SESSION["ssUsr_userAksesAnggaran"];
		$this->userAksesWebsite = $_SESSION["ssUsr_userAksesWebsite"];	
		$this->userAksesSurvey = $_SESSION["ssUsr_userAksesSurvey"];
		$this->userAksesFileManager = $_SESSION["ssUsr_userAksesFileManager"];	
		$this->userAksesSMSGateway = $_SESSION["ssUsr_userAksesSMSGateway"];	
		$this->userAksesKeuangan = $_SESSION["ssUsr_userAksesKeuangan"];	
		$this->userAksesDokumenHukum = $_SESSION["ssUsr_userAksesDokumenHukum"];	
		$this->userAksesKomersial = $_SESSION["ssUsr_userAksesKomersial"];	
		
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
		if(!$usr->selectByIdPassword($usrLogin,md5($password))){
			//echo 'gagal 2<br>'.$usr->query;
			return false;
		}
			
		if($usr->firstRow()){
			$_SESSION["ssUsr_UID"] = $usr->getField("USER_LOGIN_ID");
			$_SESSION["ssUsr_pegawaiId"] = $usr->getField("PEGAWAI_ID");
			$_SESSION["ssUsr_userPublish"] = $usr->getField("PUBLISH_KANTOR_PUSAT");						
			$_SESSION["ssUsr_idUser"] = $usr->getField("USER_LOGIN");
			$_SESSION["ssUsr_nama"] = str_replace("'", "", $usr->getField("NAMA"));
			$_SESSION["ssUsr_loginTime"] = time();
			$_SESSION["ssUsr_loginTimeStr"] = date("l, j M Y, H:i",time());
			$_SESSION["ssUsr_level"] = $usr->getField("USER_GROUP");
			$_SESSION["ssUsr_idLevel"] = $usr->getField("USER_GROUP_ID");
			$_SESSION["ssUsr_idDepartemen"] = $usr->getField("DEPARTEMEN_ID");
			$_SESSION["ssUsr_idCabang"] = $usr->getField("CABANG_ID");		
			$_SESSION["ssUsr_departemen"] = $usr->getField("DEPARTEMEN");
			$_SESSION["ssUsr_userAksesIntranet"] = $usr->getField("AKSES_ADM_INTRANET_ID");
			$_SESSION["ssUsr_userAksesOperasional"] = $usr->getField("AKSES_APP_OPERASIONAL_ID");
			$_SESSION["ssUsr_userAksesArsip"] = $usr->getField("AKSES_APP_ARSIP_ID");
			$_SESSION["ssUsr_userAksesInventaris"] = $usr->getField("AKSES_APP_INVENTARIS_ID");
			$_SESSION["ssUsr_userAksesSPPD"] = $usr->getField("AKSES_APP_SPPD_ID");
			$_SESSION["ssUsr_userAksesKepegawaian"] = $usr->getField("AKSES_APP_KEPEGAWAIAN_ID");
			$_SESSION["ssUsr_userAksesPenghasilan"] = $usr->getField("AKSES_APP_PENGHASILAN_ID");
			$_SESSION["ssUsr_userAksesPresensi"] = $usr->getField("AKSES_APP_PRESENSI_ID");
			$_SESSION["ssUsr_userAksesPenilaian"] = $usr->getField("AKSES_APP_PENILAIAN_ID");
			$_SESSION["ssUsr_userAksesBackup"] = $usr->getField("AKSES_APP_BACKUP_ID");
			$_SESSION["ssUsr_userAksesHukum"] = $usr->getField("AKSES_APP_HUKUM_ID");
			$_SESSION["ssUsr_userAksesAnggaran"] = $usr->getField("AKSES_APP_ANGGARAN_ID");
			$_SESSION["ssUsr_userAksesWebsite"] = $usr->getField("AKSES_ADM_WEBSITE_ID");	
			$_SESSION["ssUsr_userAksesSurvey"] = $usr->getField("AKSES_APP_SURVEY_ID");	
			$_SESSION["ssUsr_userAksesFileManager"] = $usr->getField("AKSES_APP_FILE_MANAGER_ID");	
			$_SESSION["ssUsr_userAksesSMSGateway"] = $usr->getField("AKSES_SMS_GATEWAY");
			$_SESSION["ssUsr_userAksesKeuangan"] = $usr->getField("AKSES_KEUANGAN");
			$_SESSION["ssUsr_userAksesDokumenHukum"] = $usr->getField("AKSES_KONTRAK_HUKUM");
			$_SESSION["ssUsr_userAksesKomersial"] = $usr->getField("AKSES_APP_KOMERSIAL_ID");	
			
			$this->setProps();
		}else{
			return false; //login/password salah								
  	  }
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
			echo 'top.location.href = "../main/login.php";';
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
		$this->UID = $_SESSION["ssUsr_UID"];
		$this->pegawaiId = $_SESSION["ssUsr_pegawaiId"];
		$this->userPublish = $_SESSION["ssUsr_userPublish"];		
		$this->idUser = $_SESSION["ssUsr_idUser"];
		$this->nama = $_SESSION["ssUsr_nama"];
		$this->level = $_SESSION["ssUsr_level"];
		$this->userRekanan = $_SESSION["ssUsr_rekanan"];
		$this->userPKP = $_SESSION["ssUsr_userPKP"];
		$this->userNPWP = $_SESSION["ssUsr_userNPWP"];
		$this->idLevel = $_SESSION["ssUsr_idLevel"];
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
	   # $varBannedLevel : level yang ditolak
	*/
	function setPageLevel($varLevel, $varBannedLevel = "")
	{
		$this->pageLevel = $varLevel;
		$this->bannedPageLevel = $varBannedLevel;
	}
	
	/* mengeset ID halaman yang akan dibandingkan dengan tabel group_access
	   apakah halaman yg bersangkutan boleh diakses oleh level user yg sedang login
	*/
	function setPageId($varId)
	{
		$this->pageId = $varId;
	}
	
	/* Mengecek level akses halaman berdasarkan $pageLevel dan $level. 
	   Jika privilege tepat maka return true.
	   Jika $pageLevel tidak diset maka akan selalu return true 
	   # untuk admin : $this->level = 1
	   # untuk guest : $this->level = 9999
	   # halaman yang boleh diakses user asal sudah login, maka : set $this->pageLevel = 9999 
	 */
	function checkPagePrivileges($autoExit = true)
	{
		$ret = false;
		
		if($this->pageLevel == false)
			$ret = true;
		
		// if admin, bypass checking
		// check whether $pageLevel is array or not
		// jika pageLevel = 9999 (public) then bypass checking
		if(is_array($this->pageLevel))
		{
			foreach($this->pageLevel as $key => $value)
			{
				if($value == $this->level || $this->level == '1'|| $this->level == '2' || $this->pageLevel == '9999')
				{
					$ret = true;
					break;
				}
				else
					$ret = false;
			}
		}
		else
		{
			if($this->pageLevel == $this->level || $this->level == '1'|| $this->level == '2' || $this->pageLevel == '9999')
				$ret = true;
			else
				$ret = false;
		}
		
		// check for any banned level
		if(is_array($this->bannedPageLevel))
		{
			foreach($this->bannedPageLevel as $key => $value)
			{
				if($value == $this->level)
				{
					$ret = false;
					break;
				}
			}
		}
		else
		{
			if($this->bannedPageLevel == $this->level)
			{
				$ret = false;
				//break;
			}
		}
		
		// cek page access
		if($this->checkPageAccess() == false)
			$ret = false;
		
		
		if($autoExit == true)
		{
			if($ret == false) exit;
		}
		else
			return $ret;
	}
	
	/* helper method untuk mengecek apakah halaman yang bersangkutan 
	   boleh dibuka oleh usergroup yg sedang login 
	*/
	function checkPageAccess()
	{
		$gp = new GlobalParam();
		
		$group_access = new GroupAccess();
		
		$group_access->selectByParams(array('UGID' => $this->level, 'id_menu' => $this->pageId));
		
		// bypass if admin
		if($this->level == $gp->usergroupAdmin)
			return true;
		
		if($group_access->firstRow())
			return true;
		else
			return false;
	}
	
	function checkAuthPemeliharaan($nrp="")
	{
		$usr = new Users();
		return $usr->getURLAplikasiPemeliharaan($nrp);
    }
}
	
  /***** INSTANTIATE THE GLOBAL OBJECT */
  $userLogin = new UserLogin();

?>