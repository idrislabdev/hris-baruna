<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class jam_json extends CI_Controller {

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
	
	
	function jam_kerja_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-absensi/JamKerja.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$jam_kerja = new JamKerja();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqNama= httpFilterPost("reqNama");
		$reqJamAwal= httpFilterPost("reqJamAwal");
		$reqJamAkhir= httpFilterPost("reqJamAkhir");
		$reqTerlambatAwal= httpFilterPost("reqTerlambatAwal");
		$reqTerlambatAkhir= httpFilterPost("reqTerlambatAkhir");
		$reqJamKerjaJenis= httpFilterPost("reqJamKerjaJenis");

		if($reqMode == "insert")
		{
			$jam_kerja->setField('JAM_KERJA_JENIS_ID', $reqJamKerjaJenis);
			$jam_kerja->setField('NAMA', $reqNama);
			$jam_kerja->setField('JAM_AWAL', $reqJamAwal);
			$jam_kerja->setField('JAM_AKHIR', $reqJamAkhir);
			$jam_kerja->setField('TERLAMBAT_AWAL', $reqTerlambatAwal);
			$jam_kerja->setField('TERLAMBAT_AKHIR', $reqTerlambatAkhir);
			$jam_kerja->setField('STATUS', 0);
			if($jam_kerja->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$jam_kerja->setField('JAM_KERJA_ID', $reqId); 
			$jam_kerja->setField('JAM_KERJA_JENIS_ID', $reqJamKerjaJenis);
			$jam_kerja->setField('NAMA', $reqNama);
			$jam_kerja->setField('JAM_AWAL', $reqJamAwal);
			$jam_kerja->setField('JAM_AKHIR', $reqJamAkhir);
			$jam_kerja->setField('TERLAMBAT_AWAL', $reqTerlambatAwal);
			$jam_kerja->setField('TERLAMBAT_AKHIR', $reqTerlambatAkhir);
			$jam_kerja->setField('STATUS', 0);
			if($jam_kerja->update())
				echo "Data berhasil disimpan.";
			
		}
	}

	function jam_kerja_jenis_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-absensi/JamKerjaJenis.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$jam_kerja_jenis = new JamKerjaJenis();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqNama = httpFilterPost("reqNama");
		$reqKeterangan = httpFilterPost("reqKeterangan");
		$reqKelompok = httpFilterPost("reqKelompok");
		$reqWarna = httpFilterPost("reqWarna");

		if($reqMode == "insert")
		{
			$jam_kerja_jenis->setField("NAMA", $reqNama);
			$jam_kerja_jenis->setField("KETERANGAN", $reqKeterangan);
			$jam_kerja_jenis->setField("WARNA", $reqWarna);
			$jam_kerja_jenis->setField("KELOMPOK", $reqKelompok);
			if($jam_kerja_jenis->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$jam_kerja_jenis->setField("JAM_KERJA_JENIS_ID", $reqId);
			$jam_kerja_jenis->setField("NAMA", $reqNama);
			$jam_kerja_jenis->setField("KETERANGAN", $reqKeterangan);
			$jam_kerja_jenis->setField("KELOMPOK", $reqKelompok);
			$jam_kerja_jenis->setField("WARNA", $reqWarna);
			if($jam_kerja_jenis->update())
				echo "Data berhasil disimpan.";
			
		}
	}
	
}
?>
