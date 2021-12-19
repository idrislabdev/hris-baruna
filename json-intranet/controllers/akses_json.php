<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class akses_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		//kauth
		if (!$this->kauth->getInstance()->hasIdentity())
		{
			// trow to unauthenticated page!
			redirect('app');
		}       
		
		/* GLOBAL VARIABLE */

		$this->UID = $this->kauth->getInstance()->getIdentity()->UID;
		$this->pegawaiId = $this->kauth->getInstance()->getIdentity()->pegawaiId;
		$this->jabatan = $this->kauth->getInstance()->getIdentity()->jabatan;
		$this->cabang = $this->kauth->getInstance()->getIdentity()->cabang;
		$this->cabangP3Id = $this->kauth->getInstance()->getIdentity()->cabangP3Id;
		$this->perusahaanId = $this->kauth->getInstance()->getIdentity()->perusahaanId;
		$this->perusahaanCabangId = $this->kauth->getInstance()->getIdentity()->perusahaanCabangId;
		$this->userPublish = $this->kauth->getInstance()->getIdentity()->userPublish;						
		$this->idUser = $this->kauth->getInstance()->getIdentity()->idUser;
		$this->nama = $this->kauth->getInstance()->getIdentity()->nama;
		$this->loginTime = $this->kauth->getInstance()->getIdentity()->loginTime;
		$this->userNRP = $this->kauth->getInstance()->getIdentity()->userNRP;
		$this->loginTimeStr = $this->kauth->getInstance()->getIdentity()->loginTimeStr;
		$this->level = $this->kauth->getInstance()->getIdentity()->level;
		$this->idLevel = $this->kauth->getInstance()->getIdentity()->idLevel;
		$this->idDepartemen = $this->kauth->getInstance()->getIdentity()->idDepartemen;
		$this->idCabang = $this->kauth->getInstance()->getIdentity()->idCabang;		
		$this->departemen = $this->kauth->getInstance()->getIdentity()->departemen;
		$this->userAksesIntranet = $this->kauth->getInstance()->getIdentity()->userAksesIntranet;
		$this->userAksesOperasional = $this->kauth->getInstance()->getIdentity()->userAksesOperasional;
		$this->userAksesArsip = $this->kauth->getInstance()->getIdentity()->userAksesArsip;
		$this->userAksesInventaris = $this->kauth->getInstance()->getIdentity()->userAksesInventaris;
		$this->userAksesSPPD = $this->kauth->getInstance()->getIdentity()->userAksesSPPD;
		$this->userAksesKepegawaian = $this->kauth->getInstance()->getIdentity()->userAksesKepegawaian;
		$this->userAksesPenghasilan = $this->kauth->getInstance()->getIdentity()->userAksesPenghasilan;
		$this->userAksesPresensi = $this->kauth->getInstance()->getIdentity()->userAksesPresensi;
		$this->userAksesPenilaian = $this->kauth->getInstance()->getIdentity()->userAksesPenilaian;
		$this->userAksesBackup = $this->kauth->getInstance()->getIdentity()->userAksesBackup;
		$this->userAksesHukum = $this->kauth->getInstance()->getIdentity()->userAksesHukum;
		$this->userAksesAnggaran = $this->kauth->getInstance()->getIdentity()->userAksesAnggaran;
		$this->userAksesWebsite = $this->kauth->getInstance()->getIdentity()->userAksesWebsite;	
		$this->userAksesSurvey = $this->kauth->getInstance()->getIdentity()->userAksesSurvey;	
		$this->userAksesFileManager = $this->kauth->getInstance()->getIdentity()->userAksesFileManager;	
		$this->userAksesSMSGateway = $this->kauth->getInstance()->getIdentity()->userAksesSMSGateway;
		$this->userAksesKeuangan = $this->kauth->getInstance()->getIdentity()->userAksesKeuangan;
		$this->userAksesDokumenHukum = $this->kauth->getInstance()->getIdentity()->userAksesDokumenHukum;
		$this->userAksesKomersial = $this->kauth->getInstance()->getIdentity()->userAksesKomersial;	
		$this->userAksesGalangan = $this->kauth->getInstance()->getIdentity()->userAksesGalangan;	
	}	
	
	
	function akses_adm_intranet_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/classes/base/AksesAdmIntranet.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$akses_adm_intranet = new AksesAdmIntranet();

		$reqAksesIntranet = httpFilterPost("reqAksesIntranet");
		$reqMode = httpFilterPost("reqMode");
		$reqNama = httpFilterPost("reqNama");
		$reqInformasi = httpFilterPost("reqInformasi");
		$reqHasilRapat = httpFilterPost("reqHasilRapat");
		$reqAgenda = httpFilterPost("reqAgenda");
		$reqForum = httpFilterPost("reqForum");
		$reqKataMutiara = httpFilterPost("reqKataMutiara");
		$reqKalenderKerja = httpFilterPost("reqKalenderKerja");
		$reqUserGroup = httpFilterPost("reqUserGroup");
		$reqUserApp = httpFilterPost("reqUserApp");
		$reqDepartemen = httpFilterPost("reqDepartemen");

		if($reqMode == "insert")
		{	
			$akses_adm_intranet->setField("NAMA", $reqNama);
			$akses_adm_intranet->setField("INFORMASI", setNULL($reqInformasi));
			$akses_adm_intranet->setField("HASIL_RAPAT", setNULL($reqHasilRapat));
			$akses_adm_intranet->setField("AGENDA", setNULL($reqAgenda));
			$akses_adm_intranet->setField("FORUM", setNULL($reqForum));
			$akses_adm_intranet->setField("KATA_MUTIARA", setNULL($reqKataMutiara));
			$akses_adm_intranet->setField("KALENDER_KERJA", setNULL($reqKalenderKerja));
			$akses_adm_intranet->setField("USER_GROUP", setNULL($reqUserGroup));
			$akses_adm_intranet->setField("USER_APP", setNULL($reqUserApp));
			$akses_adm_intranet->setField("DEPARTEMEN", setNULL($reqDepartemen));	
			
			if($akses_adm_intranet->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$akses_adm_intranet->setField("AKSES_ADM_INTRANET_ID", $reqAksesIntranet);
			$akses_adm_intranet->setField("NAMA", $reqNama);
			$akses_adm_intranet->setField("INFORMASI", setNULL($reqInformasi));
			$akses_adm_intranet->setField("HASIL_RAPAT", setNULL($reqHasilRapat));
			$akses_adm_intranet->setField("AGENDA", setNULL($reqAgenda));
			$akses_adm_intranet->setField("FORUM", setNULL($reqForum));
			$akses_adm_intranet->setField("KATA_MUTIARA", setNULL($reqKataMutiara));
			$akses_adm_intranet->setField("KALENDER_KERJA", setNULL($reqKalenderKerja));
			$akses_adm_intranet->setField("USER_GROUP", setNULL($reqUserGroup));
			$akses_adm_intranet->setField("USER_APP", setNULL($reqUserApp));
			$akses_adm_intranet->setField("DEPARTEMEN", setNULL($reqDepartemen));
			
			if($akses_adm_intranet->update())
				echo "Data berhasil disimpan.";
			
		}
	}
	
	function akses_administrasi_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/classes/base/AksesAdmIntranet.php");
		include_once("../WEB-INF/classes/base/AksesAdmIntranetMenu.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$akses_adm_intranet = new AksesAdmIntranet();
		$akses_adm_intranet_menu = new AksesAdmIntranetMenu();

		$reqMode = httpFilterPost("reqMode");
		$reqMenuId = $_POST["reqMenuId"];
		$reqCheck = $_POST["reqCheck"];
		$reqNama = $_POST["reqNama"];
		$reqAksesIntranet = $_POST["reqAksesIntranet"];
		$reqTable = $_POST["reqTable"];

		if($reqMode == "insert")
		{	
			  $akses_adm_intranet->setField("NAMA", $reqNama);
			  $akses_adm_intranet->setField("TABLE", $reqTable);
			  $akses_adm_intranet->insert();

			  for($i=0;$i<count($reqMenuId);$i++)
			  {
				  $akses_adm_intranet_menu = new AksesAdmIntranetMenu();
			 	  $akses_adm_intranet_menu->setField("AKSES_ADM_INTRANET_ID", $akses_adm_intranet->id);
			 	  $akses_adm_intranet_menu->setField("MENU_ID", $reqMenuId[$i]);
			 	  $akses_adm_intranet_menu->setField("AKSES", $reqCheck[$i]);
			 	  $akses_adm_intranet_menu->setField("TABLE", $reqTable);
				  $akses_adm_intranet_menu->insert();
				  unset($akses_adm_intranet_menu);	  
			  }
				  echo "Data berhasil disimpan.";
		}
		else
		{
			  $akses_adm_intranet->setField("NAMA", $reqNama);
			  $akses_adm_intranet->setField("AKSES_ADM_INTRANET_ID", $reqAksesIntranet);	  
			  $akses_adm_intranet->setField("TABLE", $reqTable);
			  $akses_adm_intranet->update();

			  $akses_adm_intranet_menu->setField("AKSES_ADM_INTRANET_ID", $reqAksesIntranet);
			  $akses_adm_intranet_menu->setField("TABLE", $reqTable);
			  $akses_adm_intranet_menu->delete();
			
			  for($i=0;$i<count($reqMenuId);$i++)
			  {
				  $akses_adm_intranet_menu = new AksesAdmIntranetMenu();
			 	  $akses_adm_intranet_menu->setField("AKSES_ADM_INTRANET_ID", $reqAksesIntranet);
			 	  $akses_adm_intranet_menu->setField("MENU_ID", $reqMenuId[$i]);
			 	  $akses_adm_intranet_menu->setField("AKSES", $reqCheck[$i]);
			 	  $akses_adm_intranet_menu->setField("TABLE", $reqTable);
				  $akses_adm_intranet_menu->insert();
				  unset($akses_adm_intranet_menu);	  
			  }
				  echo "Data berhasil disimpan.";
		}
	}

}
?>
