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
		if($reqMode == "hubungan_keluarga")
		{
			include_once("../WEB-INF/classes/base-simpeg/HubunganKeluarga.php");
			$hubungan_keluarga	= new HubunganKeluarga();
			$hubungan_keluarga->setField('HUBUNGAN_KELUARGA_ID', $reqId);
			if($hubungan_keluarga->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$hubungan_keluarga->getErrorMsg();
		}elseif($reqMode == "universitas")
		{
			include_once("../WEB-INF/classes/base-simpeg/Universitas.php");
			$universitas	= new Universitas();
			$universitas->setField('UNIVERSITAS_ID', $reqId);
			if($universitas->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$universitas->getErrorMsg();
		}
		elseif($reqMode == "pendidikan_biaya")
		{
			include_once("../WEB-INF/classes/base-simpeg/PendidikanBiaya.php");
			$pendidikan_biaya= new PendidikanBiaya();
			$pendidikan_biaya->setField('PENDIDIKAN_BIAYA_ID', $reqId);
			if($pendidikan_biaya->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$pendidikan_biaya->getErrorMsg();
		}
		elseif($reqMode == "pendidikan")
		{
			include_once("../WEB-INF/classes/base-simpeg/Pendidikan.php");
			$pendidikan= new Pendidikan();
			$pendidikan->setField('PENDIDIKAN_ID', $reqId);
			if($pendidikan->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$pendidikan->getErrorMsg();
		}
		elseif($reqMode == "pejabat_penetap")
		{
			include_once("../WEB-INF/classes/base-simpeg/PejabatPenetap.php");
			$pejabat_penetap= new PejabatPenetap();
			$pejabat_penetap->setField('PEJABAT_PENETAP_ID', $reqId);
			if($pejabat_penetap->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$pejabat_penetap->getErrorMsg();
		}
		elseif($reqMode == "pangkat_perubahan_kode")
		{
			include_once("../WEB-INF/classes/base-simpeg/PangkatPerubahanKode.php");
			$pangkat_perubahan_kode= new PangkatPerubahanKode();
			$pangkat_perubahan_kode->setField('PANGKAT_PERUBAHAN_KODE_ID', $reqId);
			if($pangkat_perubahan_kode->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$pangkat_perubahan_kode->getErrorMsg();
		}
		elseif($reqMode == "pangkat_kode")
		{
			include_once("../WEB-INF/classes/base-simpeg/PangkatKode.php");
			$pangkat_kode= new PangkatKode();
			$pangkat_kode->setField('PANGKAT_KODE_ID', $reqId);
			if($pangkat_kode->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$pangkat_kode->getErrorMsg();
		}elseif($reqMode == "pangkat")
		{
			include_once("../WEB-INF/classes/base-simpeg/Pangkat.php");
			$pangkat= new Pangkat();
			$pangkat->setField('PANGKAT_ID', $reqId);
			if($pangkat->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$pangkat->getErrorMsg();
		}
		elseif($reqMode == "jabatan")
		{
			include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
			$jabatan= new Jabatan();
			$jabatan->setField('JABATAN_ID', $reqId);
			if($jabatan->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$jabatan->getErrorMsg();
		}
		elseif($reqMode == "agama")
		{
			include_once("../WEB-INF/classes/base-simpeg/Agama.php");
			$agama= new Agama();
			$agama->setField('AGAMA_ID', $reqId);
			if($agama->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$agama->getErrorMsg();
		}
		elseif($reqMode == "bank")
		{
			include_once("../WEB-INF/classes/base-simpeg/Bank.php");
			$bank	= new Bank();
			$bank->setField('BANK_ID', $reqId);
			if($bank->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$bank->getErrorMsg();
		}
		elseif($reqMode == "status_pegawai")
		{
			include_once("../WEB-INF/classes/base-simpeg/StatusPegawai.php");
			$status_pegawai	= new StatusPegawai();
			$status_pegawai->setField('STATUS_PEGAWAI_ID', $reqId);
			if($status_pegawai->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$status_pegawai->getErrorMsg();
		}
		elseif($reqMode == "pegawai")
		{
			include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
			$pegawai	= new Pegawai();
			$pegawai->setField('PEGAWAI_ID', $reqId);
			if($pegawai->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$pegawai->getErrorMsg();
		}
		elseif($reqMode == "cuti_tahunan")
		{
			include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
			$cuti_tahunan	= new CutiTahunan();
			$cuti_tahunan->setField('CUTI_TAHUNAN_ID', $reqId);
			if($cuti_tahunan->delete())
				$alertMsg .= "Data berhasil dihapus";
			else
				$alertMsg .= "Error ".$cuti_tahunan->getErrorMsg();
		}
	}

}
?>
