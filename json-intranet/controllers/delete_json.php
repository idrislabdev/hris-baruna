<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class delete_json extends CI_Controller {

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
	
	
	function delete()
	{
		//include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/functions/default.func.php");

		$reqId = $_GET['id'];
		$reqMode = $_GET['reqMode'];
		$reqPassword = $_GET['reqPassword'];

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/
		if($reqMode == "agenda")
		{
			include_once("../WEB-INF/classes/base/Agenda.php");
			$agenda	= new Agenda();
			$agenda->setField('AGENDA_ID', $reqId);
			if($agenda->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$agenda->getErrorMsg();
		}
		elseif($reqMode == "kata_mutiara")
		{
			include_once("../WEB-INF/classes/base/KataMutiara.php");
			$kata_mutiara	= new KataMutiara();
			$kata_mutiara->setField('KATA_MUTIARA_ID', $reqId);
			if($kata_mutiara->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$kata_mutiara->getErrorMsg();
		}
		elseif($reqMode == "penanda_tangan")
		{
			include_once("../WEB-INF/classes/base/PenandaTangan.php");
			$penanda_tangan	= new PenandaTangan();
			$penanda_tangan->setField('PENANDA_TANGAN_ID', $reqId);
			if($penanda_tangan->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$penanda_tangan->getErrorMsg();
		}
		elseif($reqMode == "faq")
		{
			include_once("../WEB-INF/classes/base/Faq.php");
			$faq	= new Faq();
			$faq->setField('FAQ_ID', $reqId);
			if($faq->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$faq->getErrorMsg();
		}
		elseif($reqMode == "kalender_kerja")
		{
			include_once("../WEB-INF/classes/base/KalenderKerja.php");
			$kalender_kerja	= new KalenderKerja();
			$kalender_kerja->setField('KALENDER_KERJA_ID', $reqId);
			if($kalender_kerja->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$kalender_kerja->getErrorMsg();
		}
		elseif($reqMode == "informasi")
		{
			include_once("../WEB-INF/classes/utils/FileHandler.php");
			include_once("../WEB-INF/classes/base/Informasi.php");

			$file = new FileHandler();
			$informasi	= new Informasi();

			$FILE_DIR = "../main/uploads/informasi/";
			$_THUMB_PREFIX = "z__thumb_";

			$varSource = $FILE_DIR.$informasi->getField('LINK_FOTO');
			$varThumbnail = $FILE_DIR.$_THUMB_PREFIX.$informasi->getField('LINK_FOTO');
			
			// delete the file and the thumbnail. if success, remove the file's related database entry
			//if($file->delete($varSource))
			//{
				//$file->delete($varThumbnail);
				
				$informasi->setField('INFORMASI_ID', $reqId);
			
				if($informasi->delete())
					$alertMsg .= "Data berhasil dihapus";
				else
					$alertMsg .= "Error ".$informasi->getErrorMsg();
			//}

		}
		elseif($reqMode == "hasil_rapat")
		{
			include_once("../WEB-INF/classes/base/HasilRapat.php");
			
			$hasil_rapat = new HasilRapat();
			$hasil_rapat->setField('HASIL_RAPAT_ID', $reqId);
			
			if($hasil_rapat->deleteAttachment())
			{
				$hasil_rapat->setField('HASIL_RAPAT_ID', $reqId);
				if($hasil_rapat->delete())
					$alertMsg .= "Data berhasil dihapus";
				else
					$alertMsg .= "Error ".$hasil_rapat->getErrorMsg();
			}
		}
		elseif($reqMode == "user_login")
		{
			include_once("../WEB-INF/classes/base/UserLoginBase.php");
			
			$user_login = new UserLoginBase();
			$user_login->setField('USER_LOGIN_ID', $reqId);
			
			if($user_login->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$user_login->getErrorMsg();
			
		}
		elseif($reqMode == "user_group")
		{
			include_once("../WEB-INF/classes/base/UserGroup.php");
			
			$user_group = new UserGroup();
			$user_group->setField('USER_GROUP_ID', $reqId);
			
			if($user_group->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$user_group->getErrorMsg();
			
		}
		elseif($reqMode == "cabang")
		{
			include_once("../WEB-INF/classes/base-simpeg/Cabang.php");
			$cabang	= new Cabang();
			$cabang->setField('CABANG_ID', $reqId);
			if($cabang->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$cabang->getErrorMsg();
		}
		elseif($reqMode == "reset_password")
		{
			include_once("../WEB-INF/classes/base/UserLoginBase.php");
			
			$user_login = new UserLoginBase();
			$user_login->setField('USER_LOGIN_ID', $reqId);
			$user_login->setField('USER_PASS', $reqPassword);
			
			if($user_login->resetPassword())
				$alertMsg .= "Data berhasil direset";
			else
				$alertMsg .= "Error ".$user_login->getErrorMsg();
			
		}
	}

}
?>
