<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class hari_libur_json extends CI_Controller {

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
	
	
	function hari_libur_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-absensi/HariLibur.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$hari_libur = new HariLibur();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqPilih= httpFilterPost("reqPilih");
		$reqNama= httpFilterPost("reqNama");
		$reqKeterangan= httpFilterPost("reqKeterangan");
		$reqTanggalAwal= httpFilterPost("reqTanggalAwal");
		$reqTanggalAkhir= httpFilterPost("reqTanggalAkhir");
		$reqHari= httpFilterPost("reqHari");
		$reqBulan= httpFilterPost("reqBulan");
		$reqTanggalFix=get_null_10($reqHari).get_null_10($reqBulan);
		$reqStatusCutiBersama = httpFilterPost("reqStatusCutiBersama");

		if($reqMode == "insert")
		{
			$hari_libur->setField('NAMA', $reqNama);
			$hari_libur->setField('KETERANGAN', $reqKeterangan);
			$hari_libur->setField('STATUS_CUTI_BERSAMA', $reqStatusCutiBersama);
				if ($reqPilih == "Statis"){
					$hari_libur->setField('TANGGAL_AWAL', "NULL");
					$hari_libur->setField('TANGGAL_AKHIR', "NULL");
				}elseif ($reqPilih == "Dinamis" && $reqTanggalAkhir == ""){
					$hari_libur->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
					$hari_libur->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAwal));
				}else{
					$hari_libur->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
					$hari_libur->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
					}
			$hari_libur->setField('TANGGAL_FIX', $reqTanggalFix);
			if($hari_libur->insert())
				echo "Data berhasil disimpan.";
				
			
		}
		else
		{
			$hari_libur->setField('HARI_LIBUR_ID', $reqId);
			$hari_libur->setField('NAMA', $reqNama);
			$hari_libur->setField('KETERANGAN', $reqKeterangan);
			$hari_libur->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
			$hari_libur->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
			$hari_libur->setField('STATUS_CUTI_BERSAMA', $reqStatusCutiBersama);

			$hari_libur->setField('TANGGAL_FIX', $reqTanggalFix);
			if($hari_libur->update())
				echo "Data berhasil disimpan.";
		}
	}

}
?>
