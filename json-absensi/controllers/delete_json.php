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

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/
		if($reqMode == "master_jam_kerja")
		{
			include_once("../WEB-INF/classes/base-absensi/JamKerja.php");
			$jam_kerja	= new JamKerja();
			$jam_kerja->setField('JAM_KERJA_ID', $reqId);
			if($jam_kerja->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$jam_kerja->getErrorMsg();
		}
		elseif($reqMode == "master_hari_libur")
		{
			include_once("../WEB-INF/classes/base-absensi/HariLibur.php");
			$hari_libur	= new HariLibur();
			$hari_libur->setField('HARI_LIBUR_ID', $reqId);
			if($hari_libur->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$hari_libur->getErrorMsg();
		}
		elseif($reqMode == "absensi")
		{
			include_once("../WEB-INF/classes/base-absensi/Absensi.php");
			$absensi = new Absensi();
			$absensi->setField('ABSENSI_ID', $reqId);
			if($absensi->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$absensi->getErrorMsg();
		}
		elseif($reqMode == "absensi_ijin_cuti")
		{
			include_once("../WEB-INF/classes/base-absensi/AbsensiIjin.php");
			$absensi_ijin = new AbsensiIjin();
			$absensi_ijin->setField('ABSENSI_IJIN_ID', $reqId);
			if($absensi_ijin->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$absensi_ijin->getErrorMsg();
		}
		elseif($reqMode == "absensi_lembur")
		{
			include_once("../WEB-INF/classes/base-absensi/Lembur.php");
			$lembur = new Lembur();
			$lembur->setField('LEMBUR_ID', $reqId);
			if($lembur->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$lembur->getErrorMsg();
		}
		elseif($reqMode == "master_jam_kerja_jenis")
		{
			include_once("../WEB-INF/classes/base-absensi/JamKerjaJenis.php");
			$jam_kerja_jenis = new JamKerjaJenis();
			$jam_kerja_jenis->setField('JAM_KERJA_JENIS_ID', $reqId);
			if($jam_kerja_jenis->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$jam_kerja_jenis->getErrorMsg();
		}
	}

}
?>
