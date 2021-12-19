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
		$reqRowId = $_GET['reqRowId'];
		$reqMode = $_GET['reqMode'];


		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/
		if($reqMode == "merit_p3")
		{
			include_once("../WEB-INF/classes/base-gaji/MeritP3.php");
			$merit_p3	= new MeritP3();
			$merit_p3->setField('MERIT_P3_ID', $reqId);
			if($merit_p3->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$merit_p3->getErrorMsg();
		}
		else if($reqMode == "merit_pms")
		{
			include_once("../WEB-INF/classes/base-gaji/MeritPMS.php");
			$merit_pms	= new MeritPMS();
			$merit_pms->setField('MERIT_PMS_ID', $reqId);
			if($merit_pms->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$merit_pms->getErrorMsg();
		}
		else if($reqMode == "tpp_p3")
		{
			include_once("../WEB-INF/classes/base-gaji/TppP3.php");
			$tpp_p3	= new TppP3();
			$tpp_p3->setField('TPP_P3_ID', $reqId);
			if($tpp_p3->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$tpp_p3->getErrorMsg();
		}
		else if($reqMode == "tpp_pms")
		{
			include_once("../WEB-INF/classes/base-gaji/TppPMS.php");
			$tpp_pms = new TppPMS();
			$tpp_pms->setField('TPP_PMS_ID', $reqId);
			if($tpp_pms->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$tpp_pms->getErrorMsg();
		}
		else if($reqMode == "tunjangan_jabatan")
		{
			include_once("../WEB-INF/classes/base-gaji/TunjanganJabatan.php");
			$tunjangan_jabatan = new TunjanganJabatan();
			$tunjangan_jabatan->setField('TUNJANGAN_JABATAN_ID', $reqId);
			if($tunjangan_jabatan->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$tunjangan_jabatan->getErrorMsg();
		}
		else if($reqMode == "tunjangan_perbantuan_a")
		{
			include_once("../WEB-INF/classes/base-gaji/TunjanganPerbantuanA.php");
			$tunjangan_perbantuan_a = new TunjanganPerbantuanA();
			$tunjangan_perbantuan_a->setField('TUNJANGAN_PERBANTUAN_A_ID', $reqId);
			if($tunjangan_perbantuan_a->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$tunjangan_perbantuan_a->getErrorMsg();
		}
		else if($reqMode == "tunjangan_perbantuan_b")
		{
			include_once("../WEB-INF/classes/base-gaji/TunjanganPerbantuanB.php");
			$tunjangan_perbantuan_b = new TunjanganPerbantuanB();
			$tunjangan_perbantuan_b->setField('TUNJANGAN_PERBANTUAN_B_ID', $reqId);
			if($tunjangan_perbantuan_b->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$tunjangan_perbantuan_b->getErrorMsg();
		}
		elseif($reqMode == "insentif")
		{
			include_once("../WEB-INF/classes/base-gaji/Insentif.php");
			$insentif	= new Insentif();
			$insentif->setField('INSENTIF_ID', $reqId);
			if($insentif->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$insentif->getErrorMsg();
		}
		elseif($reqMode == "premi")
		{
			include_once("../WEB-INF/classes/base-gaji/Premi.php");
			$premi	= new Premi();
			$premi->setField('PREMI_ID', $reqId);
			if($premi->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$premi->getErrorMsg();
		}
		elseif($reqMode == "unit_link")
		{
			include_once("../WEB-INF/classes/base-gaji/UnitLink.php");
			$unit_link	= new UnitLink();
			$unit_link->setField('UNIT_LINK_ID', $reqId);
			if($unit_link->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$unit_link->getErrorMsg();
		}
		elseif($reqMode == "parameter_potongan_wajib")
		{
			include_once("../WEB-INF/classes/base-gaji/ParameterPotonganWajib.php");
			$parameter_potongan_wajib	= new ParameterPotonganWajib();
			$parameter_potongan_wajib->setField('JENIS_POTONGAN_ID', $reqId);
			$parameter_potongan_wajib->setField('KELAS_ID', $reqRowId);
			if($parameter_potongan_wajib->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$parameter_potongan_wajib->getErrorMsg();
		}
		elseif($reqMode == "asuransi")
		{
			include_once("../WEB-INF/classes/base-gaji/Asuransi.php");
			$asuransi	= new Asuransi();
			$asuransi->setField('ASURANSI_ID', $reqId);
			if($asuransi->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$asuransi->getErrorMsg();
		}
	}

}
?>
