<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class surat_json extends CI_Controller {

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
	
	
	function surat_perintah_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-operasional/SuratPerintah.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$surat_perintah = new SuratPerintah();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqNomorPenugasan= httpFilterPost("reqNomorPenugasan");
		$reqNomor= httpFilterPost("reqNomor");
		$reqPekerjaan= httpFilterPost("reqPekerjaan");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqLokasi= httpFilterPost("reqLokasi");

		if($reqMode == "update")
		{
			$surat_perintah->setField('SURAT_PERINTAH_ID', $reqId); 
			$surat_perintah->setField('PEKERJAAN', $reqPekerjaan);
			$surat_perintah->setField('NOMOR', $reqNomor);
			$surat_perintah->setField('NOMOR_PENUGASAN', $reqNomorPenugasan);
			$surat_perintah->setField('LOKASI', $reqLokasi);
			$surat_perintah->setField('TANGGAL', dateToDBCheck($reqTanggal));
			$surat_perintah->setField('STATUS', 'C');
			
			
			if($surat_perintah->updateData())
				echo "Data berhasil disimpan.";
			
		}
	}
	
	function surat_perintah_keterangan_tolak()
			{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-operasional/SuratPerintah.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$surat_perintah = new SuratPerintah();

		$reqId = httpFilterPost("reqId");
		$reqKeterangan = httpFilterPost("reqKeterangan");
		$surat_perintah->setField('SURAT_PERINTAH_ID', $reqId); 
		$surat_perintah->setField('KETERANGAN_TOLAK', $reqKeterangan);

		if($surat_perintah->updateKeteranganTolak())
			echo "Data berhasil disimpan.";
	}
	
	function surat_perintah_setujui()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-operasional/PegawaiKapalHistori.php");
		include_once("../WEB-INF/classes/base-operasional/SuratPerintahPegawai.php");
		include_once("../WEB-INF/classes/base-operasional/SuratPerintah.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_kapal_histori = new PegawaiKapalHistori();

		$reqSuratPerintahPegawaiId = $_POST["reqSuratPerintahPegawaiId"];
		$reqPegawaiKapalHistoriIdOff = $_POST["reqPegawaiKapalHistoriIdOff"];
		$reqOffHire  = $_POST["reqOffHire"];
		$reqPegawaiKapalHistoriIdOn = $_POST["reqPegawaiKapalHistoriIdOn"];
		$reqOnHire   = $_POST["reqOnHire"];
		$reqId = httpFilterPost("reqId");


		for($i=0;$i<count($reqSuratPerintahPegawaiId);$i++)
		{
			if($reqPegawaiKapalHistoriIdOff[$i] == "")
			{}
			else
			{
				$pegawai_kapal_histori_off = new PegawaiKapalHistori();
				$pegawai_kapal_histori_off->setField("PEGAWAI_KAPAL_HISTORI_ID", $reqPegawaiKapalHistoriIdOff[$i]);
				$pegawai_kapal_histori_off->setField("TANGGAL_KELUAR_SEBELUM", dateToDBCheck($reqOffHire[$i]));
				$pegawai_kapal_histori_off->updateOffHireLastValidasi();
				unset($pegawai_kapal_histori_off);		
			}
			
			if($reqPegawaiKapalHistoriIdOn[$i] == "")
			{}
			else
			{
				$pegawai_kapal_histori_on = new PegawaiKapalHistori();
				$pegawai_kapal_histori_on->setField("PEGAWAI_KAPAL_HISTORI_ID", $reqPegawaiKapalHistoriIdOn[$i]);
				$pegawai_kapal_histori_on->setField("TANGGAL_MASUK", dateToDBCheck($reqOnHire[$i]));
				$pegawai_kapal_histori_on->updateOnHireValidasi();
				unset($pegawai_kapal_histori_on);		
			}
			
			$surat_perintah_pegawai = new SuratPerintahPegawai();
			$surat_perintah_pegawai->setField("STATUS_VALIDASI", 1);
			$surat_perintah_pegawai->setField("SURAT_PERINTAH_PEGAWAI_ID", $reqSuratPerintahPegawaiId[$i]);
			$surat_perintah_pegawai->updateStatusValidasi();
			
		}

		$surat_perintah = new SuratPerintah();
		$surat_perintah->setField("SURAT_PERINTAH_ID", $reqId);
		$surat_perintah->setField("STATUS", "S");
		$surat_perintah->updateStatus();

		echo "Data berhasil disimpan.";
	}

}
?>
