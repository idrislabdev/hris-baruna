<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class kalkulasi_json extends CI_Controller {

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
	
	
	function kalkulasi_penghasilan()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();

		$reqGajiPerbantuan = httpFilterPost("reqGajiPerbantuan");
		$reqGajiDewanDireksi = httpFilterPost("reqGajiDewanDireksi");
		$reqGajiPttpk = httpFilterPost("reqGajiPttpk");
		$reqGajiPkwt = httpFilterPost("reqGajiPkwt");
		$reqGajiPkwtKhusus= httpFilterPost("reqGajiPkwtKhusus");
		$reqBayarAwal = httpFilterPost("reqBayarAwal");
		$reqBayarAkhir = httpFilterPost("reqBayarAkhir");
		$reqGajiOrganik =httpFilterPost("reqGajiOrganik");

		if($reqGajiPerbantuan == 1)
		{
			$gaji_awal_bulan_proses = new GajiAwalBulan();
			$gaji_awal_bulan_proses->setField("PERIODE", $reqBayarAwal);
			$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "2");		
			$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();
			//echo $gaji_awal_bulan_proses->query;exit;
			unset($gaji_awal_bulan_proses);
			//echo 'Gaji Berhasil Diproses ';
		}

		if($reqGajiDewanDireksi == 1)
		{
			$gaji_awal_bulan_proses = new GajiAwalBulan();
			$gaji_awal_bulan_proses->setField("PERIODE", $reqBayarAwal);
			$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "6,7");		
			$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();		
			//echo $gaji_awal_bulan_proses->query;exit;
			unset($gaji_awal_bulan_proses);
			//echo 'Gaji Berhasil Diproses ';
		}

		if($reqGajiOrganik == 1)
		{
			$gaji_awal_bulan_proses = new GajiAwalBulan();
			$gaji_awal_bulan_proses->setField("PERIODE", $reqBayarAkhir);
			$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "1");		
			$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();		
			//echo $gaji_awal_bulan_proses->query;exit;
			unset($gaji_awal_bulan_proses);
			//echo 'Gaji Berhasil Diproses ';
		}

		if($reqGajiPttpk == 1)
		{
			$gaji_awal_bulan_proses = new GajiAwalBulan();
			$gaji_awal_bulan_proses->setField("PERIODE", $reqBayarAkhir);
			$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "5");		
			$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();
			//echo $gaji_awal_bulan_proses->query;exit;
			unset($gaji_awal_bulan_proses);
			//echo 'Gaji Berhasil Diproses ';
		}

		if($reqGajiPkwt == 1)
		{
			$gaji_awal_bulan_proses = new GajiAwalBulan();
			$gaji_awal_bulan_proses->setField("PERIODE", $reqBayarAkhir);
			$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "3");		
			$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();
			//echo $gaji_awal_bulan_proses->query;exit;
			unset($gaji_awal_bulan_proses);
			
		}

		if($reqGajiPkwtKhusus == 1)
		{
			$gaji_awal_bulan_proses = new GajiAwalBulan();
			$gaji_awal_bulan_proses->setField("PERIODE", $reqBayarAkhir);
			$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "12");		
			$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();
			//echo $gaji_awal_bulan_proses->query;exit;
			unset($gaji_awal_bulan_proses);
			
		}

			echo 'Gaji Berhasil Diproses ';
	}

}
?>
