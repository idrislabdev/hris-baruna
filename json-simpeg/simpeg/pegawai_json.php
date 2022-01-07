<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class pegawai_json extends CI_Controller {

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
	
	
	function pegawai_add_cv()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPengalamanKerja.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pengalaman_kerja = new PegawaiPengalamanKerja();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$nama_perusahaan= httpFilterPost("nama_perusahaan");
		$jabatan= httpFilterPost("jabatan");
		$masuk_kerja = httpFilterPost("mulai_bulan") . httpFilterPost("mulai_tahun");
		$keluar_kerja = httpFilterPost("selesai_bulan") . httpFilterPost("selesai_tahun");
		$gaji = httpFilterPost("gaji");
		$fasilitas_lain = httpFilterPost("fasilitas_lain");

		$pengalaman_kerja->setField('PEGAWAI_ID', $reqId);
		$pengalaman_kerja->setField('NAMA_PERUSAHAAN', $nama_perusahaan);
		$pengalaman_kerja->setField('JABATAN', $jabatan);
		$pengalaman_kerja->setField('MASUK_KERJA', $masuk_kerja);
		$pengalaman_kerja->setField('KELUAR_KERJA', $keluar_kerja);
		$pengalaman_kerja->setField('GAJI', $gaji);
		$pengalaman_kerja->setField('FASILITAS', $fasilitas_lain);

		if($reqMode == "insert")
		{
			$pengalaman_kerja->setField("CREATED_BY", $userLogin->nama);
			$pengalaman_kerja->setField("CREATED_DATE", OCI_SYSDATE);	
			if($pengalaman_kerja->insert()){
				$reqRowId = $pengalaman_kerja->id;
				echo $reqId . "-Data berhasil disimpan.-".$reqRowId;
			}
			echo $pengalaman_kerja->query;
		}
		else
		{
			$pengalaman_kerja->setField("UPDATED_BY", $userLogin->nama);
			$pengalaman_kerja->setField("UPDATED_DATE", OCI_SYSDATE);		
			$pengalaman_kerja->setField("PEGAWAI_PENGALAMAN_KERJA_ID", $reqRowId);		
			if($pengalaman_kerja->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pengalaman_kerja->query;
		}
	}
	
	function pegawai_add_data()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/base/UserLoginBase.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai = new Pegawai();
		$user_login = new UserLoginBase();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqNPP= httpFilterPost("reqNPP");
		$reqNama= httpFilterPost("reqNama");
		$reqAgamaId= httpFilterPost("reqAgamaId");
		$reqJenisKelamin= httpFilterPost("reqJenisKelamin");
		$reqAsalPelabuhanId= httpFilterPost("reqAsalPelabuhanId");
		$reqDepartemen = httpFilterPost("reqDepartemen");
		$reqTempat= httpFilterPost("reqTempat");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqTanggalNpwp= httpFilterPost("reqTanggalNpwp");
		$reqAlamat= httpFilterPost("reqAlamat");
		$reqTelepon== httpFilterPost("reqTelepon");
		$reqEmail= httpFilterPost("reqEmail");
		$reqGolDarah= httpFilterPost("reqGolDarah");
		$reqStatusPernikahan= httpFilterPost("reqStatusPernikahan");
		$reqNRP= httpFilterPost("reqNRP");
		$reqLinkFile = $_FILES["reqLinkFile"];
		$reqFingerId= httpFilterPost("reqFingerId");

		$reqStatusPegawai= httpFilterPost("reqStatusPegawai");
		$reqStatusKeluarga= httpFilterPost("reqStatusKeluarga");
		$reqBankId= httpFilterPost("reqBankId");
		$reqRekeningNo= httpFilterPost("reqRekeningNo");
		$reqRekeningNama= httpFilterPost("reqRekeningNama");
		$reqNPWP= httpFilterPost("reqNPWP");
		$reqTglPensiun= httpFilterPost("reqTglPensiun");
		$reqTglMutasiKeluar= httpFilterPost("reqTglMutasiKeluar");
		$reqTglWafat= httpFilterPost("reqTglWafat");
		$reqNoSKMPP= httpFilterPost("reqNoSKMPP");
		$reqTMTMPP= httpFilterPost("reqTMTMPP");
		$reqHobby= httpFilterPost("reqHobby");
		$reqFingerId= httpFilterPost("reqFingerId");
		$reqKtpNo= httpFilterPost("reqKtpNo");
		$reqTMTNONAKTIF= httpFilterPost("reqTMTNONAKTIF");

		$reqTinggi= httpFilterPost("reqTinggi");
		$reqBeratBadan= httpFilterPost("reqBeratBadan");

		$reqJamsostek = httpFilterPost("reqJamsostek");
		$reqJamsostekTanggal = httpFilterPost("reqJamsostekTanggal");
		$reqHomeBase = httpFilterPost("reqHomeBase");

		$reqBidang_studi = httpFilterPost("reqBidang_studi");
		$reqLineritas = httpFilterPost("reqLineritas");
		$reqSpesifikasi_prestasi_karya = httpFilterPost("reqSpesifikasi_prestasi_karya");
		$reqTugas_pembimbingan = httpFilterPost("reqTugas_pembimbingan");

		if($reqDepartemen == 0)
			$reqDepartemen = "NULL";
		else
			$reqDepartemen = "'".$reqDepartemen."'";


		$pegawai->setField('LOKASI_ID', $reqHomeBase);
		$pegawai->setField('PEGAWAI_ID', $reqId);
		$pegawai->setField('DEPARTEMEN_ID', $reqDepartemen);
		$pegawai->setField('NRP', $reqNRP);
		$pegawai->setField('NIPP', $reqNPP);
		$pegawai->setField('NAMA', $reqNama);
		$pegawai->setField('AGAMA_ID', $reqAgamaId);
		$pegawai->setField('JENIS_KELAMIN', $reqJenisKelamin);
		$pegawai->setField('PELABUHAN_ID', $reqAsalPelabuhanId);
		$pegawai->setField('TEMPAT_LAHIR', $reqTempat);
		$pegawai->setField('TANGGAL_LAHIR', dateToDBCheck($reqTanggal));
		$pegawai->setField('ALAMAT', $reqAlamat);
		$pegawai->setField('TELEPON', $reqTelepon);
		$pegawai->setField('EMAIL', $reqEmail);
		$pegawai->setField('GOLONGAN_DARAH', $reqGolDarah);
		$pegawai->setField('STATUS_KAWIN', $reqStatusPernikahan);
		$pegawai->setField('STATUS_PEGAWAI_ID', $reqStatusPegawai);
		$pegawai->setField('BANK_ID', $reqBankId);
		$pegawai->setField('REKENING_NO', $reqRekeningNo);
		$pegawai->setField('REKENING_NAMA', $reqRekeningNama);
		$pegawai->setField('NPWP', $reqNPWP);
		$pegawai->setField('STATUS_KELUARGA_ID', $reqStatusKeluarga);
		$pegawai->setField('JAMSOSTEK_NO', $reqJamsostek);
		$pegawai->setField('JAMSOSTEK_TANGGAL', dateToDBCheck($reqJamsostekTanggal));
		$pegawai->setField('HOBBY', $reqHobby);
		$pegawai->setField('FINGER_ID', $reqFingerId);
		$pegawai->setField('TANGGAL_NPWP', dateToDBCheck($reqTanggalNpwp));
		$pegawai->setField('TINGGI', $reqTinggi);
		$pegawai->setField('BERAT_BADAN', $reqBeratBadan);
		$pegawai->setField('KTP_NO', $reqKtpNo);
		$pegawai->setField('BIDANG_STUDI', $reqBidang_studi);
		$pegawai->setField('LINERITAS', $reqLineritas);
		$pegawai->setField('SPESIFIKASI_PRESTASI_KARYA', $reqSpesifikasi_prestasi_karya);
		$pegawai->setField('TUGAS_PEMBIMBINGAN', $reqTugas_pembimbingan);


				if($reqStatusPegawai == 1)
				{
					$pegawai->setField('TANGGAL_PENSIUN', 'NULL');
					$pegawai->setField('TANGGAL_MUTASI_KELUAR', 'NULL');
					$pegawai->setField('TANGGAL_WAFAT', 'NULL');
					
					$pegawai->setField('NO_MPP', 'NULL');
					$pegawai->setField('TANGGAL_MPP', 'NULL');
					$pegawai->setField('TGL_NON_AKTIF', 'NULL');
				}
				else
				{
					$pegawai->setField('TANGGAL_PENSIUN', dateToDBCheck($reqTglPensiun));
					$pegawai->setField('TANGGAL_MUTASI_KELUAR', dateToDBCheck($reqTglMutasiKeluar));
					$pegawai->setField('TANGGAL_WAFAT', dateToDBCheck($reqTglWafat));
					
					$pegawai->setField('NO_MPP', $reqNoSKMPP);
					$pegawai->setField('TANGGAL_MPP', dateToDBCheck($reqTMTMPP));
					$pegawai->setField('TGL_NON_AKTIF', dateToDBCheck($reqTMTNONAKTIF));
				}

		//$pegawai->setField("NAMA", $_FILES['reqLinkFile']['name']);
		//$pegawai->setField("HASIL_RAPAT_ID", $reqId);
		//$pegawai->setField("FILE_NAMA", $_FILES['reqLinkFile']['name']);
		//$pegawai->setField("UKURAN", $_FILES['reqLinkFile']['size']);
		//$pegawai->setField("FORMAT", $_FILES['reqLinkFile']['type']);
			
		if($reqMode == "insert")
		{
			$pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	

			//PEGAWAI_ID, FOTO, 
			if($pegawai->insert()){
				$id = $pegawai->id;
				if($reqLinkFile['tmp_name'])
					$pegawai->upload("PPI_SIMPEG.PEGAWAI", "FOTO", $reqLinkFile['tmp_name'], "PEGAWAI_ID = ".$id);

				/* CREATE USER_LOGIN */
				$user_login->setField("DEPARTEMEN_ID", $reqDepartemen);
				$user_login->setField("USER_GROUP_ID", 2);
				$user_login->setField("NAMA", $reqNama);
				$user_login->setField("JABATAN", "");
				$user_login->setField("EMAIL", $reqEmail);
				$user_login->setField("TELEPON", $reqTelepon);
				$user_login->setField("USER_LOGIN", substr($reqNRP, -5));
				$user_login->setField("USER_PASS", substr($reqNRP, -5));
				$user_login->setField("STATUS", 1);
				$user_login->setField("LAST_CREATE_USER", $userLogin->UID);
				$user_login->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
				$user_login->setField("PEGAWAI_ID", $id);	
			
				if($user_login->insert())
				{
				}
						
				echo $id."-Data berhasil disimpan.";
			}
			//echo $pegawai->query;
		}
		else
		{

			$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			if($pegawai->update()){
				$id = $reqId;
				
				if($reqLinkFile['tmp_name'])
					$pegawai->upload("PPI_SIMPEG.PEGAWAI", "FOTO", $reqLinkFile['tmp_name'], "PEGAWAI_ID = ".$id);
				
				/* JIKA NON AKTIF, NON AKTIFKAN JUGA USER LOGIN */
				if($reqStatusPegawai == 6)
				{
					$user_login->setField("STATUS", 0);
					$user_login->setField("PEGAWAI_ID", $reqId);
					$user_login->updateStatusAktif();	
				}
				
				echo $id."-Data berhasil disimpan.";
			}
		}
	}

	
	function pegawai_add_data_0406()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai = new Pegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqNPP= httpFilterPost("reqNPP");
		$reqNama= httpFilterPost("reqNama");
		$reqAgamaId= httpFilterPost("reqAgamaId");
		$reqJenisKelamin= httpFilterPost("reqJenisKelamin");
		$reqAsalPelabuhanId= httpFilterPost("reqAsalPelabuhanId");
		$reqDepartemen = httpFilterPost("reqDepartemen");
		$reqTempat= httpFilterPost("reqTempat");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqTanggalNpwp= httpFilterPost("reqTanggalNpwp");
		$reqAlamat= httpFilterPost("reqAlamat");
		$reqTelepon== httpFilterPost("reqTelepon");
		$reqEmail= httpFilterPost("reqEmail");
		$reqGolDarah= httpFilterPost("reqGolDarah");
		$reqStatusPernikahan= httpFilterPost("reqStatusPernikahan");
		$reqNRP= httpFilterPost("reqNRP");
		$reqLinkFile = $_FILES["reqLinkFile"];
		$reqFingerId= httpFilterPost("reqFingerId");

		$reqStatusPegawai= httpFilterPost("reqStatusPegawai");
		$reqStatusKeluarga= httpFilterPost("reqStatusKeluarga");
		$reqBankId= httpFilterPost("reqBankId");
		$reqRekeningNo= httpFilterPost("reqRekeningNo");
		$reqRekeningNama= httpFilterPost("reqRekeningNama");
		$reqNPWP= httpFilterPost("reqNPWP");
		$reqTglPensiun= httpFilterPost("reqTglPensiun");
		$reqTglMutasiKeluar= httpFilterPost("reqTglMutasiKeluar");
		$reqTglWafat= httpFilterPost("reqTglWafat");
		$reqNoSKMPP= httpFilterPost("reqNoSKMPP");
		$reqTMTMPP= httpFilterPost("reqTMTMPP");
		$reqHobby= httpFilterPost("reqHobby");
		$reqFingerId= httpFilterPost("reqFingerId");

		$reqJamsostek = httpFilterPost("reqJamsostek");
		$reqJamsostekTanggal = httpFilterPost("reqJamsostekTanggal");

		$reqBidang_studi = httpFilterPost("reqBidang_studi");
		$reqLineritas = httpFilterPost("reqLineritas");
		$reqSpesifikasi_prestasi_karya = httpFilterPost("reqSpesifikasi_prestasi_karya");
		$reqTugas_pembimbingan = httpFilterPost("reqTugas_pembimbingan");

		if($reqDepartemen == 0)
			$reqDepartemen = "NULL";
		else
			$reqDepartemen = "'".$reqDepartemen."'";

		$pegawai->setField('PEGAWAI_ID', $reqId);
		$pegawai->setField('DEPARTEMEN_ID', $reqDepartemen);
		$pegawai->setField('NRP', $reqNRP);
		$pegawai->setField('NIPP', $reqNPP);
		$pegawai->setField('NAMA', $reqNama);
		$pegawai->setField('AGAMA_ID', $reqAgamaId);
		$pegawai->setField('JENIS_KELAMIN', $reqJenisKelamin);
		$pegawai->setField('PELABUHAN_ID', $reqAsalPelabuhanId);
		$pegawai->setField('TEMPAT_LAHIR', $reqTempat);
		$pegawai->setField('TANGGAL_LAHIR', dateToDBCheck($reqTanggal));
		$pegawai->setField('ALAMAT', $reqAlamat);
		$pegawai->setField('TELEPON', $reqTelepon);
		$pegawai->setField('EMAIL', $reqEmail);
		$pegawai->setField('GOLONGAN_DARAH', $reqGolDarah);
		$pegawai->setField('STATUS_KAWIN', $reqStatusPernikahan);
		$pegawai->setField('STATUS_PEGAWAI_ID', $reqStatusPegawai);
		$pegawai->setField('BANK_ID', $reqBankId);
		$pegawai->setField('REKENING_NO', $reqRekeningNo);
		$pegawai->setField('REKENING_NAMA', $reqRekeningNama);
		$pegawai->setField('NPWP', $reqNPWP);
		$pegawai->setField('STATUS_KELUARGA_ID', $reqStatusKeluarga);
		$pegawai->setField('JAMSOSTEK_NO', $reqJamsostek);
		$pegawai->setField('JAMSOSTEK_TANGGAL', dateToDBCheck($reqJamsostekTanggal));
		$pegawai->setField('HOBBY', $reqHobby);
		$pegawai->setField('FINGER_ID', $reqFingerId);
		$pegawai->setField('TANGGAL_NPWP', dateToDBCheck($reqTanggalNpwp));

		$pegawai->setField('BIDANG_STUDI', $reqBidang_studi);
		$pegawai->setField('LINERITAS', $reqLineritas);
		$pegawai->setField('SPESIFIKASI_PRESTASI_KARYA', $reqSpesifikasi_prestasi_karya);
		$pegawai->setField('TUGAS_PEMBIMBINGAN', $reqTugas_pembimbingan);


				if($reqStatusPegawai == 1)
				{
					$pegawai->setField('TANGGAL_PENSIUN', 'NULL');
					$pegawai->setField('TANGGAL_MUTASI_KELUAR', 'NULL');
					$pegawai->setField('TANGGAL_WAFAT', 'NULL');
					
					$pegawai->setField('NO_MPP', 'NULL');
					$pegawai->setField('TANGGAL_MPP', 'NULL');
				}
				else
				{
					$pegawai->setField('TANGGAL_PENSIUN', dateToDBCheck($reqTglPensiun));
					$pegawai->setField('TANGGAL_MUTASI_KELUAR', dateToDBCheck($reqTglMutasiKeluar));
					$pegawai->setField('TANGGAL_WAFAT', dateToDBCheck($reqTglWafat));
					
					$pegawai->setField('NO_MPP', $reqNoSKMPP);
					$pegawai->setField('TANGGAL_MPP', dateToDBCheck($reqTMTMPP));
				}

		//$pegawai->setField("NAMA", $_FILES['reqLinkFile']['name']);
		//$pegawai->setField("HASIL_RAPAT_ID", $reqId);
		//$pegawai->setField("FILE_NAMA", $_FILES['reqLinkFile']['name']);
		//$pegawai->setField("UKURAN", $_FILES['reqLinkFile']['size']);
		//$pegawai->setField("FORMAT", $_FILES['reqLinkFile']['type']);
			
		if($reqMode == "insert")
		{
			$pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			//PEGAWAI_ID, FOTO, 
			if($pegawai->insert()){
				$id = $pegawai->id;
				
				if($reqLinkFile['tmp_name'])
					$pegawai->upload("PPI_SIMPEG.PEGAWAI", "FOTO", $reqLinkFile['tmp_name'], "PEGAWAI_ID = ".$id);
				
				echo $id."-Data berhasil disimpan.";
			}
			//echo $pegawai->query;
		}
		else
		{

			$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			if($pegawai->update()){
				$id = $reqId;
				
				if($reqLinkFile['tmp_name'])
					$pegawai->upload("PPI_SIMPEG.PEGAWAI", "FOTO", $reqLinkFile['tmp_name'], "PEGAWAI_ID = ".$id);
				
				
				echo $id."-Data berhasil disimpan.";
			}
		}
	}

	
	function pegawai_add_hukuman()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiHukuman.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_hukuman = new PegawaiHukuman();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqKategoriHukumanId = httpFilterPost("reqKategoriHukumanId");
		$reqJenisHukumanId = httpFilterPost("reqJenisHukumanId");
		$reqPejabatPenetapId = httpFilterPost("reqPejabatPenetapId");
		$reqTanggalSK = httpFilterPost("reqTanggalSK");
		$reqTMTSK = httpFilterPost("reqTMTSK");
		$reqNoSK = httpFilterPost("reqNoSK");
		$reqKasus = httpFilterPost("reqKasus");

		$reqAkhirTMT = httpFilterPost("reqAkhirTMT");

		$pegawai_hukuman->setField('KATEGORI_HUKUMAN_ID', $reqKategoriHukumanId);
		$pegawai_hukuman->setField('JENIS_HUKUMAN_ID', $reqJenisHukumanId);
		$pegawai_hukuman->setField('PEJABAT_PENETAP_ID', $reqPejabatPenetapId);
		$pegawai_hukuman->setField('NO_SK', $reqNoSK);
		$pegawai_hukuman->setField('TMT_SK', dateToDBCheck($reqTMTSK));
		$pegawai_hukuman->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSK));
		$pegawai_hukuman->setField('KASUS', $reqKasus);
		$pegawai_hukuman->setField('PEGAWAI_HUKUMAN_ID', $reqRowId);
		$pegawai_hukuman->setField('PEGAWAI_ID', $reqId);
		$pegawai_hukuman->setField('AKHIR_TMT', dateToDBCheck($reqAkhirTMT));

		if($reqMode == "insert")
		{
			$pegawai_hukuman->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_hukuman->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			if($pegawai_hukuman->insert()){
				$reqRowId= $pegawai_hukuman->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_hukuman->query;
		}
		else
		{
			$pegawai_hukuman->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_hukuman->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			if($pegawai_hukuman->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_hukuman->query;
		}
	}

	
	function pegawai_add_jabatan()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
		include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_jabatan = new PegawaiJabatan();
		$departemen_cabang = new Departemen();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId= httpFilterPost("reqRowId");
		$reqKondisiJabatan = httpFilterPost("reqKondisiJabatan");

		$reqTanggal= httpFilterPost("reqTanggal");
		$reqTMT= httpFilterPost("reqTMT");
		$reqNoSK= httpFilterPost("reqNoSK");
		$reqCabang= httpFilterPost("reqCabang");
		$reqDepartemen= httpFilterPost("reqDepartemen");
		//$reqSubDepartemen= httpFilterPost("reqSubDepartemen");
		//$reqSubDepartemen= httpFilterPost("reqSubDepartemen");
		$reqJabatan= httpFilterPost("reqJabatan");
		$reqNoUrut= httpFilterPost("reqNoUrut");
		$reqKelas= httpFilterPost("reqKelas");
		$reqNama= httpFilterPost("reqNama");
		$reqKeterangan= httpFilterPost("reqKeterangan");
		$reqPejabat= httpFilterPost("reqPejabat");

		$departemen_cabang->selectByParams(array('DEPARTEMEN_ID'=>$reqDepartemen));
		$departemen_cabang->firstRow();
		$reqCabang= $departemen_cabang->getField('CABANG_ID');

		$pegawai_jabatan->setField('PEGAWAI_ID', $reqId);
		$pegawai_jabatan->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
		$pegawai_jabatan->setField('TMT_JABATAN', dateToDBCheck($reqTMT));
		$pegawai_jabatan->setField('NO_SK', $reqNoSK);
		$pegawai_jabatan->setField('CABANG_ID', $reqCabang);
		$pegawai_jabatan->setField('DEPARTEMEN_ID', $reqDepartemen);
		//$pegawai_jabatan->setField('', $reqSubDepartemen);
		$pegawai_jabatan->setField('JABATAN_ID', $reqJabatan);
		//$pegawai_jabatan->setField('', $reqNoUrut);
		//$pegawai_jabatan->setField('', $reqKelas);
		$pegawai_jabatan->setField('NAMA', $reqNama);
		$pegawai_jabatan->setField('KETERANGAN', $reqKeterangan);
		$pegawai_jabatan->setField('PEJABAT_PENETAP_ID', $reqPejabat);
		$pegawai_jabatan->setField('PEGAWAI_JABATAN_ID', $reqRowId);
		$pegawai_jabatan->setField('KONDISI_JABATAN', $reqKondisiJabatan);

		if($reqMode == "insert")
		{
			$pegawai_jabatan->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_jabatan->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			if($pegawai_jabatan->insert()){
				$reqRowId= $pegawai_jabatan->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_jabatan->query;
		}
		else
		{
			$pegawai_jabatan->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_jabatan->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			if($pegawai_jabatan->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_jabatan->query;
		}
	}

	
	function pegawai_add_jabatan_perbantuan()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatanP3.php");
		include_once("../WEB-INF/classes/base-simpeg/DirektoratP3.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_jabatan_p3 = new PegawaiJabatanP3();
		$departemen_cabang = new DirektoratP3();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId= httpFilterPost("reqRowId");

		$reqTanggal= httpFilterPost("reqTanggal");
		$reqTMT= httpFilterPost("reqTMT");
		$reqNoSK= httpFilterPost("reqNoSK");
		$reqCabang= httpFilterPost("reqCabang");
		$reqDirektoratP3= httpFilterPost("reqDirektoratP3");
		//$reqSubDirektoratP3= httpFilterPost("reqSubDirektoratP3");
		//$reqSubDirektoratP3= httpFilterPost("reqSubDirektoratP3");
		$reqJabatanId= httpFilterPost("reqJabatanId");
		$reqNoUrut= httpFilterPost("reqNoUrut");
		$reqKelas= httpFilterPost("reqKelas");
		$reqNama= httpFilterPost("reqNama");
		$reqKeterangan= httpFilterPost("reqKeterangan");
		$reqPejabat= httpFilterPost("reqPejabat");

		$reqCabangId= httpFilterPost("reqCabangId");
		$reqDirektorat= httpFilterPost("reqDirektorat");
		$reqSubDirektorat= httpFilterPost("reqSubDirektorat");
		$reqSeksi= httpFilterPost("reqSeksi");

		$reqCabang= $reqCabangId;
		//reqCabangId reqDirektorat reqSubDirektorat reqSeksi
		$reqDirektoratP3= $reqDirektorat.$reqSubDirektorat.$reqSeksi;

		/*$departemen_cabang->selectByParams(array('DIREKTORAT_P3_ID'=>$reqDirektoratP3));
		$departemen_cabang->firstRow();
		$reqCabang= $departemen_cabang->getField('CABANG_P3_ID');*/

		$pegawai_jabatan_p3->setField('PEGAWAI_ID', $reqId);
		$pegawai_jabatan_p3->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
		$pegawai_jabatan_p3->setField('TMT_JABATAN', dateToDBCheck($reqTMT));
		$pegawai_jabatan_p3->setField('NO_SK', $reqNoSK);
		$pegawai_jabatan_p3->setField('CABANG_P3_ID', $reqCabang);
		$pegawai_jabatan_p3->setField('DIREKTORAT_P3_ID', $reqDirektoratP3);
		//$pegawai_jabatan_p3->setField('', $reqSubDirektoratP3);
		$pegawai_jabatan_p3->setField('JABATAN_ID', $reqJabatanId);
		//$pegawai_jabatan_p3->setField('', $reqNoUrut);
		//$pegawai_jabatan_p3->setField('', $reqKelas);
		$pegawai_jabatan_p3->setField('NAMA', $reqNama);
		$pegawai_jabatan_p3->setField('KETERANGAN', $reqKeterangan);
		$pegawai_jabatan_p3->setField('PEJABAT_PENETAP_ID', $reqPejabat);
		$pegawai_jabatan_p3->setField('PEGAWAI_JABATAN_P3_ID', $reqRowId);

		if($reqMode == "insert")
		{
			$pegawai_jabatan_p3->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_jabatan_p3->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			if($pegawai_jabatan_p3->insert()){
				$reqRowId= $pegawai_jabatan_p3->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_jabatan_p3->query;
		}
		else
		{
			$pegawai_jabatan_p3->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_jabatan_p3->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			if($pegawai_jabatan_p3->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_jabatan_p3->query;
		}
	}

	
	function pegawai_add_jabatan_perbantuan_tmt_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatanP3.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");

		$pegawai_jabatan_p3 = new PegawaiJabatanP3();

		$reqId= httpFilterGet("reqId");
		$reqTMT= httpFilterGet("reqTMT");
		$reqTMTTemp= httpFilterGet("reqTMTTemp");

		if($reqTMTTemp == "")
		{
			$pegawai_jabatan_p3->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_JABATAN, 'DD-MM-YYYY')"=>$reqTMT));
		}
		else
		{
			$pegawai_jabatan_p3->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_JABATAN, 'DD-MM-YYYY')"=>$reqTMT, "NOT TO_CHAR(A.TMT_JABATAN, 'DD-MM-YYYY')" => $reqTMTTemp));
		}

		$pegawai_jabatan_p3->firstRow();

		$arrFinal = array("PEGAWAI_JABATAN_P3_ID" => $pegawai_jabatan_p3->getField("PEGAWAI_JABATAN_P3_ID"));

		echo json_encode($arrFinal);
	}

	
	function pegawai_add_jabatan_tmt_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");

		$pegawai_jabatan = new PegawaiJabatan();

		$reqId= httpFilterGet("reqId");
		$reqTMT= httpFilterGet("reqTMT");
		$reqTMTTemp= httpFilterGet("reqTMTTemp");

		if($reqTMTTemp == "")
		{
			$pegawai_jabatan->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_JABATAN, 'DD-MM-YYYY')"=>$reqTMT));
		}
		else
		{
			$pegawai_jabatan->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_JABATAN, 'DD-MM-YYYY')"=>$reqTMT, "NOT TO_CHAR(A.TMT_JABATAN, 'DD-MM-YYYY')" => $reqTMTTemp));
		}

		$pegawai_jabatan->firstRow();

		$arrFinal = array("PEGAWAI_JABATAN_ID" => $pegawai_jabatan->getField("PEGAWAI_JABATAN_ID"));

		echo json_encode($arrFinal);
	}

	
	function pegawai_add_jenis_pegawai()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_jenis_pegawai = new PegawaiJenisPegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqTMT= httpFilterPost("reqTMT");
		$reqJenisPegawai= httpFilterPost("reqJenisPegawai");
		$reqKeterangan= httpFilterPost("reqKeterangan");
		$reqJenisPegawaiPerubahanKode= httpFilterPost("reqJenisPegawaiPerubahanKode");
		$reqMPP= httpFilterPost("reqMPP");
		$reqAsalPerusahaan= httpFilterPost("reqAsalPerusahaan");
		$reqNoSKMPP= httpFilterPost("reqNoSKMPP");
		$reqTMTMPP= httpFilterPost("reqTMTMPP");
		$reqKontrakAwal= httpFilterPost("reqKontrakAwal");
		$reqKontrakAkhir= httpFilterPost("reqKontrakAkhir");
		$reqDokumenId = httpFilterPost("reqDokumenId");


		$pegawai_jenis_pegawai->setField('NO_SK_MPP', setNULL($reqNoSKMPP));
		$pegawai_jenis_pegawai->setField('TMT_MPP', dateToDBCheck($reqTMTMPP));
		$pegawai_jenis_pegawai->setField('TANGGAL_KONTRAK_AWAL', dateToDBCheck($reqKontrakAwal));
		$pegawai_jenis_pegawai->setField('TANGGAL_KONTRAK_AKHIR', dateToDBCheck($reqKontrakAkhir));
		$pegawai_jenis_pegawai->setField('ASAL_PERUSAHAAN', $reqAsalPerusahaan);
		$pegawai_jenis_pegawai->setField('MPP', setNULL($reqMPP));
		$pegawai_jenis_pegawai->setField('TMT_JENIS_PEGAWAI', dateToDBCheck($reqTMT));
		$pegawai_jenis_pegawai->setField('JENIS_PEGAWAI_ID', $reqJenisPegawai);
		$pegawai_jenis_pegawai->setField('KETERANGAN', $reqKeterangan);
		$pegawai_jenis_pegawai->setField('JENIS_PEGAWAI_PERUBAH_KODE_ID', $reqJenisPegawaiPerubahanKode);
		$pegawai_jenis_pegawai->setField('PEGAWAI_JENIS_PEGAWAI_ID', $reqRowId);
		$pegawai_jenis_pegawai->setField('PEGAWAI_ID', $reqId);
		$pegawai_jenis_pegawai->setField('DOKUMEN_ID', $reqDokumenId);

		if($reqMode == "insert")
		{
			$pegawai_jenis_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_jenis_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			if($pegawai_jenis_pegawai->insert()){
				$reqRowId= $pegawai_jenis_pegawai->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_jenis_pegawai->query;
		}
		else
		{
			$pegawai_jenis_pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_jenis_pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
			if($pegawai_jenis_pegawai->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_jenis_pegawai->query;
		}
	}

	
	function pegawai_add_jenis_pegawai_cek()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* create objects */

		$pegawai_jenis_pegawai = new PegawaiJenisPegawai();

		$reqId = httpFilterGet("reqId");

		/* LOGIN CHECK 
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}
		*/

		$pegawai_jenis_pegawai->selectByParamsPegawaiJenisPegawaiTerakhir(array('PEGAWAI_ID'=>$reqId));
		$pegawai_jenis_pegawai->firstRow();

		$arrFinal = array("reqId" => $reqId, "jenis_pegawai_id" => $pegawai_jenis_pegawai->getField('JENIS_PEGAWAI_ID'));
		echo json_encode($arrFinal);
	}

	
	function pegawai_add_jenis_pegawai_tmt_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");

		$pegawai_jenis_pegawai = new PegawaiJenisPegawai();

		$reqId= httpFilterGet("reqId");
		$reqTMT= httpFilterGet("reqTMT");
		$reqTMTTemp= httpFilterGet("reqTMTTemp");

		if($reqTMTTemp == "")
		{
			$pegawai_jenis_pegawai->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_JENIS_PEGAWAI, 'DD-MM-YYYY')"=>$reqTMT));
		}
		else
		{
			$pegawai_jenis_pegawai->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_JENIS_PEGAWAI, 'DD-MM-YYYY')"=>$reqTMT, "NOT TO_CHAR(A.TMT_JENIS_PEGAWAI, 'DD-MM-YYYY')" => $reqTMTTemp));
		}

		$pegawai_jenis_pegawai->firstRow();

		$arrFinal = array("PEGAWAI_JENIS_PEGAWAI_ID" => $pegawai_jenis_pegawai->getField("PEGAWAI_JENIS_PEGAWAI_ID"));

		echo json_encode($arrFinal);
	}

	
	function pegawai_add_keluarga()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiKeluarga.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_keluarga = new PegawaiKeluarga();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqHubunganKeluargaId= httpFilterPost("reqHubunganKeluargaId");
		$reqStatusKawin= httpFilterPost("reqStatusKawin");
		$reqJenisKelamin= httpFilterPost("reqJenisKelamin");
		$reqStatusTunjangan= httpFilterPost("reqStatusTunjangan");
		$reqNama= httpFilterPost("reqNama");
		$reqNik= httpFilterPost("reqNik");
		$reqTanggalWafat= httpFilterPost("reqTanggalWafat");
		$reqTanggalLahir= httpFilterPost("reqTanggalLahir");
		$reqStatusTanggung= httpFilterPost("reqStatusTanggung");
		$reqTempatLahir= httpFilterPost("reqTempatLahir");
		$reqPendidikanId= httpFilterPost("reqPendidikanId");
		$reqPekerjaan= httpFilterPost("reqPekerjaan");

		$pegawai_keluarga->setField('HUBUNGAN_KELUARGA_ID', $reqHubunganKeluargaId);
		$pegawai_keluarga->setField('STATUS_KAWIN', setNULL($reqStatusKawin));
		$pegawai_keluarga->setField('JENIS_KELAMIN', $reqJenisKelamin);
		$pegawai_keluarga->setField('STATUS_TUNJANGAN', setNULL($reqStatusTunjangan));
		$pegawai_keluarga->setField('NAMA', $reqNama);
		$pegawai_keluarga->setField('NIK', $reqNik);
		$pegawai_keluarga->setField('TANGGAL_WAFAT', dateToDBCheck($reqTanggalWafat));
		$pegawai_keluarga->setField('TANGGAL_LAHIR', dateToDBCheck($reqTanggalLahir));
		$pegawai_keluarga->setField('STATUS_TANGGUNG', setNULL($reqStatusTanggung));
		$pegawai_keluarga->setField('TEMPAT_LAHIR', $reqTempatLahir);
		$pegawai_keluarga->setField('PENDIDIKAN_ID', $reqPendidikanId);
		$pegawai_keluarga->setField('PEKERJAAN', $reqPekerjaan);
		$pegawai_keluarga->setField('PEGAWAI_KELUARGA_ID', $reqRowId);
		$pegawai_keluarga->setField('PEGAWAI_ID', $reqId);

		if($reqMode == "insert")
		{
			$pegawai_keluarga->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_keluarga->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			if($pegawai_keluarga->insert()){
				$reqRowId= $pegawai_keluarga->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_keluarga->query;
		}
		else
		{
			$pegawai_keluarga->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_keluarga->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			if($pegawai_keluarga->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_keluarga->query;
		}
	}

	
	function pegawai_add_mpp()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusPegawai.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPenghasilan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_penghasilan = new PegawaiPenghasilan();
		$pegawai_status_pegawai = new PegawaiStatusPegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqTMTPenghasilan= httpFilterPost("reqTMTPenghasilan");
		$reqPeriode= httpFilterPost("reqPeriode");
		$reqKelas= httpFilterPost("reqKelas");
		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqPejabat= httpFilterPost("reqPejabat");
		$reqTahun= httpFilterPost("reqTahun");
		$reqBulan= httpFilterPost("reqBulan");
		$reqJumlahPenghasilan= httpFilterPost("reqJumlahPenghasilan");
		$reqJumlahTPP= httpFilterPost("reqJumlahTPP");
		$reqJumlahTunjanganJabatan= httpFilterPost("reqJumlahTunjanganJabatan");
		$reqJumlahTunjanganSelisih= httpFilterPost("reqJumlahTunjanganSelisih");
		$reqJumlahTransportasi= httpFilterPost("reqJumlahTransportasi");
		$reqJumlahUangMakan= httpFilterPost("reqJumlahUangMakan");
		$reqJumlahInsentif= httpFilterPost("reqJumlahInsentif");
		$reqProsentasePenghasilan= httpFilterPost("reqProsentasePenghasilan");
		$reqProsentaseTunjanganJabatan= httpFilterPost("reqProsentaseTunjanganJabatan");

		$reqProsentaseUangMakan= httpFilterPost("reqProsentaseUangMakan");
		$reqProsentaseTransportasi= httpFilterPost("reqProsentaseTransportasi");
		$reqProsentaseInsentif= httpFilterPost("reqProsentaseInsentif");

		$reqJumlahUangKehadiran= httpFilterPost("reqJumlahUangKehadiran");
		$reqProsentaseUangKehadiran= httpFilterPost("reqProsentaseUangKehadiran");
		$reqProsentaseTPP= httpFilterPost("reqProsentaseTPP");

		$reqKelasP3= httpFilterPost("reqKelasP3");
		$reqPeriodeP3= httpFilterPost("reqPeriodeP3");
		$reqJumlahP3= httpFilterPost("reqJumlahP3");

		$reqJumlahMobilitas= httpFilterPost("reqJumlahMobilitas");
		$reqProsentaseMobilitas = httpFilterPost("reqProsentaseMobilitas");
		$reqJumlahPerumahan = httpFilterPost("reqJumlahPerumahan");
		$reqProsentasePerumahan = httpFilterPost("reqProsentasePerumahan");
		$reqJumlahBBM = httpFilterPost("reqJumlahBBM");
		$reqProsentaseBBM = httpFilterPost("reqProsentaseBBM");
		$reqJumlahTelepon = httpFilterPost("reqJumlahTelepon");
		$reqProsentaseTelepon = httpFilterPost("reqProsentaseTelepon");
		$reqNoSKMPP= httpFilterPost("reqNoSKMPP");
		$reqTMTMPP= httpFilterPost("reqTMTMPP");

		$pegawai_penghasilan->setField('PROSENTASE_TPP', $reqProsentaseTPP);

		$pegawai_penghasilan->setField('JUMLAH_P3', setNULL(dotToNo($reqJumlahP3)));
		$pegawai_penghasilan->setField('KELAS_P3', setNULL($reqKelasP3));
		$pegawai_penghasilan->setField('PERIODE_P3', setNULL($reqPeriodeP3));

		$pegawai_penghasilan->setField('KELAS', $reqKelas);
		$pegawai_penghasilan->setField('TMT_PENGHASILAN', dateToDBCheck($reqTMTPenghasilan));
		$pegawai_penghasilan->setField('PERIODE', $reqPeriode);
		$pegawai_penghasilan->setField('NO_SK', $reqNoSK);
		$pegawai_penghasilan->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
		$pegawai_penghasilan->setField('PEJABAT_PENETAP_ID', $reqPejabat);
		$pegawai_penghasilan->setField('MASA_KERJA_TAHUN', $reqTahun);
		$pegawai_penghasilan->setField('MASA_KERJA_BULAN', $reqBulan);
		$pegawai_penghasilan->setField('JUMLAH_PENGHASILAN', dotToNo($reqJumlahPenghasilan));
		$pegawai_penghasilan->setField('JUMLAH_TPP', dotToNo($reqJumlahTPP));
		$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_JABATAN', dotToNo($reqJumlahTunjanganJabatan));
		$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_SELISIH', dotToNo($reqJumlahTunjanganSelisih));
		$pegawai_penghasilan->setField('JUMLAH_TRANSPORTASI', dotToNo($reqJumlahTransportasi));
		$pegawai_penghasilan->setField('JUMLAH_UANG_MAKAN', dotToNo($reqJumlahUangMakan));
		$pegawai_penghasilan->setField('JUMLAH_INSENTIF', dotToNo($reqJumlahInsentif));
		$pegawai_penghasilan->setField('PROSENTASE_PENGHASILAN', $reqProsentasePenghasilan);
		$pegawai_penghasilan->setField('PROSENTASE_TUNJANGAN_JABATAN', $reqProsentaseTunjanganJabatan);

		$pegawai_penghasilan->setField('PROSENTASE_UANG_MAKAN', $reqProsentaseUangMakan);
		$pegawai_penghasilan->setField('PROSENTASE_TRANSPORTASI', $reqProsentaseTransportasi);
		$pegawai_penghasilan->setField('PROSENTASE_INSENTIF', $reqProsentaseInsentif);

		$pegawai_penghasilan->setField('JUMLAH_UANG_KEHADIRAN', dotToNo($reqJumlahUangKehadiran));
		$pegawai_penghasilan->setField('PROSENTASE_UANG_KEHADIRAN', $reqProsentaseUangKehadiran);

		$pegawai_penghasilan->setField('PEGAWAI_PENGHASILAN_ID', $reqRowId);
		$pegawai_penghasilan->setField('PEGAWAI_ID', $reqId);

		$pegawai_penghasilan->setField('JUMLAH_MOBILITAS', dotToNo($reqJumlahMobilitas));
		$pegawai_penghasilan->setField('PROSENTASE_MOBILITAS', $reqProsentaseMobilitas);
		$pegawai_penghasilan->setField('JUMLAH_PERUMAHAN',  dotToNo($reqJumlahPerumahan));
		$pegawai_penghasilan->setField('PROSENTASE_PERUMAHAN', $reqProsentasePerumahan);
		$pegawai_penghasilan->setField('JUMLAH_BBM', dotToNo($reqJumlahBBM));
		$pegawai_penghasilan->setField('PROSENTASE_BBM', $reqProsentaseBBM);
		$pegawai_penghasilan->setField('JUMLAH_TELEPON', dotToNo($reqJumlahTelepon));
		$pegawai_penghasilan->setField('PROSENTASE_TELEPON', $reqProsentaseTelepon);
		$pegawai_penghasilan->setField('KETERANGAN_PERUBAHAN', 'MPP');

		if($reqMode == "insert")
		{
			$pegawai_penghasilan->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_penghasilan->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			if($pegawai_penghasilan->insert()){
				$reqRowId= $pegawai_penghasilan->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
				
				$pegawai_status_pegawai->setField('NO_SK', $reqNoSK);
				$pegawai_status_pegawai->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
				$pegawai_status_pegawai->setField('TMT_SK', dateToDBCheck($reqTMTMPP));
				$pegawai_status_pegawai->setField('PEJABAT_PENETAP_ID', $reqPejabat);
				$pegawai_status_pegawai->setField('PEGAWAI_ID', $reqId);
				$pegawai_status_pegawai->setField('STATUS_PEGAWAI_ID', 5);
				$pegawai_status_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
				$pegawai_status_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
				$pegawai_status_pegawai->insert();
				
				$pegawai = new Pegawai();
				$pegawai->setField('PEGAWAI_ID', $reqId);
				$pegawai->setField('NO_MPP', $reqNoSKMPP);
				$pegawai->setField('TANGGAL_MPP', dateToDBCheck($reqTMTMPP));
				$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
				$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
				if($pegawai->updateMPP()){}
			}
			//echo $pegawai_penghasilan->query;
		}
	}

	
	function pegawai_add_mpp_data()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai = new Pegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqNoSKMPP= httpFilterPost("reqNoSKMPP");
		$reqTMTMPP= httpFilterPost("reqTMTMPP");

		if($reqMode == "update")
		{
			$pegawai->setField('PEGAWAI_ID', $reqId);
			$pegawai->setField('NO_MPP', $reqNoSKMPP);
			$pegawai->setField('TANGGAL_MPP', dateToDBCheck($reqTMTMPP));
			$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			if($pegawai->updateMPP())
			{
				$id = $reqId;
				echo $id."-Data berhasil disimpan.";
			}
		}
	}

	
	function pegawai_add_mutasi()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiMutasi.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_mutasi = new PegawaiMutasi();
		$pegawai_jabatan = new PegawaiJabatan();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId= httpFilterPost("reqRowId");

		$reqDepartemenLama= httpFilterPost("reqDepartemenLama");
		$reqDepartemen= httpFilterPost("reqDepartemen");
		$reqJabatan= httpFilterPost("reqJabatan");
		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqTMT= httpFilterPost("reqTMT");
		$reqPejabat= httpFilterPost("reqPejabat");
		$reqKeterangan = httpFilterPost("reqKeterangan");



		if($reqMode == "insert")
		{
			$pegawai_mutasi->setField('DEPARTEMEN_ID_LAMA', $reqDepartemenLama);
			$pegawai_mutasi->setField('DEPARTEMEN_ID_BARU', $reqDepartemen);
			$pegawai_mutasi->setField('NO_SK', $reqNoSK);
			$pegawai_mutasi->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
			$pegawai_mutasi->setField('TMT_SK', dateToDBCheck($reqTMT));
			$pegawai_mutasi->setField('PEJABAT_PENETAP_ID', $reqPejabat);
			$pegawai_mutasi->setField('PEGAWAI_ID', $reqId);
			$pegawai_mutasi->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_mutasi->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			
			if($pegawai_mutasi->insert())
			{

				$pegawai_jabatan->setField('PEGAWAI_ID', $reqId);
				$pegawai_jabatan->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
				$pegawai_jabatan->setField('TMT_JABATAN', dateToDBCheck($reqTMT));
				$pegawai_jabatan->setField('NO_SK', $reqNoSK);
				$pegawai_jabatan->setField('CABANG_ID', 1);
				$pegawai_jabatan->setField('DEPARTEMEN_ID', $reqDepartemen);
				$pegawai_jabatan->setField('JABATAN_ID', $reqJabatan);
				$pegawai_jabatan->setField('KETERANGAN', $reqKeterangan);
				$pegawai_jabatan->setField('PEJABAT_PENETAP_ID', $reqPejabat);

				$pegawai_jabatan->setField("LAST_CREATE_USER", $userLogin->nama);
				$pegawai_jabatan->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
				$pegawai_jabatan->insert();

				$pegawai = new Pegawai();
				$pegawai->setField('DEPARTEMEN_ID', $reqDepartemen);
				$pegawai->setField('PEGAWAI_ID', $reqId);
				$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
				$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			
				if($pegawai->updateDepartemen())
				{
					$reqRowId= $pegawai_mutasi->id;
					echo $reqId."-Data berhasil disimpan.-".$reqRowId;
				}
				//echo $pegawai->query;
			}
			//echo $pegawai_mutasi->query;
		}
	}

	
	function pegawai_add_mutasi_keluar()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/base/UserLoginBase.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_status_pegawai = new PegawaiStatusPegawai();
		$user_login = new UserLoginBase();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId= httpFilterPost("reqRowId");

		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqTMT= httpFilterPost("reqTMT");
		$reqPejabat= httpFilterPost("reqPejabat");

		if($reqMode == "insert")
		{
			$pegawai_status_pegawai->setField('NO_SK', $reqNoSK);
			$pegawai_status_pegawai->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
			$pegawai_status_pegawai->setField('TMT_SK', dateToDBCheck($reqTMT));
			$pegawai_status_pegawai->setField('PEJABAT_PENETAP_ID', $reqPejabat);
			$pegawai_status_pegawai->setField('PEGAWAI_ID', $reqId);
			$pegawai_status_pegawai->setField('STATUS_PEGAWAI_ID', 3);
			$pegawai_status_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_status_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			
			if($pegawai_status_pegawai->insert())
			{
				$pegawai = new Pegawai();
				$pegawai->setField('TANGGAL_MUTASI_KELUAR', dateToDBCheck($reqTMT));
				$pegawai->setField('PEGAWAI_ID', $reqId);
				$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
				$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			
				if($pegawai->updateMutasiKeluar())
				{
					$reqRowId= $pegawai_status_pegawai->id;
					echo $reqId."-Data berhasil disimpan.-".$reqRowId;
				}
				
				$user_login->setField("STATUS", 0);
				$user_login->setField("PEGAWAI_ID", $reqId);
				$user_login->updateStatusAktif();
				
				//echo $pegawai->query;
			}
			//echo $pegawai_status_pegawai->query;
		}
	}

	
	function pegawai_add_mutasi_masuk()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/base/UserLoginBase.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$user_login = new UserLoginBase();
		$pegawai_status_pegawai = new PegawaiStatusPegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId= httpFilterPost("reqRowId");

		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqTMT= httpFilterPost("reqTMT");
		$reqPejabat= httpFilterPost("reqPejabat");

		if($reqMode == "insert")
		{
			$pegawai_status_pegawai->setField('NO_SK', $reqNoSK);
			$pegawai_status_pegawai->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
			$pegawai_status_pegawai->setField('TMT_SK', dateToDBCheck($reqTMT));
			$pegawai_status_pegawai->setField('PEJABAT_PENETAP_ID', $reqPejabat);
			$pegawai_status_pegawai->setField('PEGAWAI_ID', $reqId);
			$pegawai_status_pegawai->setField('STATUS_PEGAWAI_ID', 1);
			$pegawai_status_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_status_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			
			if($pegawai_status_pegawai->insert())
			{
				$pegawai = new Pegawai();
				$pegawai->setField('TANGGAL_MUTASI_KELUAR', "NULL");
				$pegawai->setField('PEGAWAI_ID', $reqId);
				$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
				$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			
				if($pegawai->updateMutasiMasuk())
				{
					$reqRowId= $pegawai_status_pegawai->id;
					echo $reqId."-Data berhasil disimpan.-".$reqRowId;
				}

				$user_login->setField("STATUS", 1);
				$user_login->setField("PEGAWAI_ID", $reqId);
				$user_login->updateStatusAktif();
						
				//echo $pegawai->query;
			}
			//echo $pegawai_status_pegawai->query;
		}
	}

	
	function pegawai_add_nrp_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");

		$pegawai = new Pegawai();

		$reqNRP= httpFilterGet("reqNRP");
		$reqNRPTemp= httpFilterGet("reqNRPTemp");

		if($reqNRPTemp == "")
		{
			$pegawai->selectByParams(array('A.NRP'=>$reqNRP));
		}
		else
		{
			$pegawai->selectByParams(array('A.NRP'=>$reqNRP, "NOT A.NRP" => $reqNRPTemp));
		}

		$pegawai->firstRow();

		$arrFinal = array("NRP" => $pegawai->getField("NRP"));

		echo json_encode($arrFinal);
	}

	
	function pegawai_add_pangkat()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPangkat.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_pangkat = new PegawaiPangkat();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqTMT= httpFilterPost("reqTMT");
		$reqPangkat= httpFilterPost("reqPangkat");
		$reqPangkatKode= httpFilterPost("reqPangkatKode");
		$reqPangkatPerubahanKode= httpFilterPost("reqPangkatPerubahanKode");
		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqGaji= httpFilterPost("reqGaji");
		$reqTahun= httpFilterPost("reqTahun");
		$reqBulan= httpFilterPost("reqBulan");
		$reqPejabat= httpFilterPost("reqPejabat");
		$reqUraian= httpFilterPost("reqUraian");
		$reqJabatan= httpFilterPost("reqJabatan");

		$pegawai_pangkat->setField('TMT_PANGKAT', dateToDBCheck($reqTMT));
		$pegawai_pangkat->setField('PANGKAT_ID', $reqPangkat);
		$pegawai_pangkat->setField('PANGKAT_KODE_ID', $reqPangkatKode);
		$pegawai_pangkat->setField('PANGKAT_PERUBAHAN_KODE_ID', $reqPangkatPerubahanKode);
		$pegawai_pangkat->setField('NO_SK', $reqNoSK);
		$pegawai_pangkat->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
		$pegawai_pangkat->setField('GAJI_POKOK', dotToNo($reqGaji));
		$pegawai_pangkat->setField('MASA_KERJA_TAHUN', $reqTahun);
		$pegawai_pangkat->setField('MASA_KERJA_BULAN', $reqBulan);
		$pegawai_pangkat->setField('PEJABAT_PENETAP_ID', $reqPejabat);
		$pegawai_pangkat->setField('KETERANGAN', $reqUraian);
		$pegawai_pangkat->setField('JABATAN_ID', $reqJabatan);
		$pegawai_pangkat->setField('PEGAWAI_PANGKAT_ID', $reqRowId);
		$pegawai_pangkat->setField('PEGAWAI_ID', $reqId);

		if($reqMode == "insert")
		{
			$pegawai_pangkat->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_pangkat->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			if($pegawai_pangkat->insert()){
				$reqRowId= $pegawai_pangkat->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_pangkat->query;
		}
		else
		{
			$pegawai_pangkat->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_pangkat->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
			if($pegawai_pangkat->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_pangkat->query;
		}
	}

	
	function pegawai_add_pangkat_tmt_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPangkat.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");

		$pegawai_pangkat = new PegawaiPangkat();

		$reqId= httpFilterGet("reqId");
		$reqTMT= httpFilterGet("reqTMT");
		$reqTMTTemp= httpFilterGet("reqTMTTemp");

		if($reqTMTTemp == "")
		{
			$pegawai_pangkat->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_PANGKAT, 'DD-MM-YYYY')"=>$reqTMT));
		}
		else
		{
			$pegawai_pangkat->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_PANGKAT, 'DD-MM-YYYY')"=>$reqTMT, "NOT TO_CHAR(A.TMT_PANGKAT, 'DD-MM-YYYY')" => $reqTMTTemp));
		}

		$pegawai_pangkat->firstRow();

		$arrFinal = array("PEGAWAI_PANGKAT_ID" => $pegawai_pangkat->getField("PEGAWAI_PANGKAT_ID"));

		echo json_encode($arrFinal);
	}

	
	function pegawai_add_pendidikan()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_pendidikan = new PegawaiPendidikan();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqPendidikanId= httpFilterPost("reqPendidikanId");
		$reqPendidikanBiayaId= httpFilterPost("reqPendidikanBiayaId");
		$reqNama= httpFilterPost("reqNama");
		$reqKota= httpFilterPost("reqKota");
		$reqUniversitasId= httpFilterPost("reqUniversitasId");
		$reqTanggalIjasah= httpFilterPost("reqTanggalIjasah");
		$reqLulus= httpFilterPost("reqLulus");
		$reqNoIjasah= httpFilterPost("reqNoIjasah");
		$reqTtdIjazah= httpFilterPost("reqTtdIjazah");
		$reqNoAcc= httpFilterPost("reqNoAcc");
		$reqTanggalAcc= httpFilterPost("reqTanggalAcc");

		$pegawai_pendidikan->setField('PENDIDIKAN_ID', $reqPendidikanId);
		$pegawai_pendidikan->setField('PENDIDIKAN_BIAYA_ID', $reqPendidikanBiayaId);
		$pegawai_pendidikan->setField('NAMA', $reqNama);
		$pegawai_pendidikan->setField('KOTA', $reqKota);
		$pegawai_pendidikan->setField('UNIVERSITAS_ID', $reqUniversitasId);
		$pegawai_pendidikan->setField('TANGGAL_IJASAH', dateToDBCheck($reqTanggalIjasah));
		$pegawai_pendidikan->setField('LULUS', $reqLulus);
		$pegawai_pendidikan->setField('NO_IJASAH', $reqNoIjasah);
		$pegawai_pendidikan->setField('TTD_IJASAH', $reqTtdIjazah);
		$pegawai_pendidikan->setField('NO_ACC', $reqNoAcc);
		$pegawai_pendidikan->setField('TANGGAL_ACC', dateToDBCheck($reqTanggalAcc));
		$pegawai_pendidikan->setField('PEGAWAI_PENDIDIKAN_ID', $reqRowId);
		$pegawai_pendidikan->setField('PEGAWAI_ID', $reqId);

		if($reqMode == "insert")
		{
			$pegawai_pendidikan->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_pendidikan->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			if($pegawai_pendidikan->insert()){
				$reqRowId= $pegawai_pendidikan->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_pendidikan->query;
		}
		else
		{
			$pegawai_pendidikan->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_pendidikan->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			if($pegawai_pendidikan->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_pendidikan->query;
		}
	}

	
	function pegawai_add_pendidikan_perjenjangan()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikanPerjenjangan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_pendidikan = new PegawaiPendidikanPerjenjangan();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqNama= httpFilterPost("reqNama");
		$reqTanggalAwal= httpFilterPost("reqTanggalAwal");
		$reqTanggalAkhir= httpFilterPost("reqTanggalAkhir");

		$pegawai_pendidikan->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
		$pegawai_pendidikan->setField('NAMA', $reqNama);
		$pegawai_pendidikan->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
		$pegawai_pendidikan->setField('PEGAWAI_PEND_PERJENJANGAN_ID', $reqRowId);
		$pegawai_pendidikan->setField('PEGAWAI_ID', $reqId);

		if($reqMode == "insert")
		{
			$pegawai_pendidikan->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_pendidikan->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			if($pegawai_pendidikan->insert()){
				$reqRowId= $pegawai_pendidikan->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_pendidikan->query;
		}
		else
		{
			$pegawai_pendidikan->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_pendidikan->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			if($pegawai_pendidikan->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_pendidikan->query;
		}
	}

	
	function pegawai_add_pendidikan_substansial()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikanSubstansial.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_pendidikan_substansial = new PegawaiPendidikanSubstansial();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqNama= httpFilterPost("reqNama");
		$reqTanggalAwal= httpFilterPost("reqTanggalAwal");
		$reqTanggalAkhir= httpFilterPost("reqTanggalAkhir");

		$pegawai_pendidikan_substansial->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
		$pegawai_pendidikan_substansial->setField('NAMA', $reqNama);
		$pegawai_pendidikan_substansial->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
		$pegawai_pendidikan_substansial->setField('PEGAWAI_PEND_SUBSTANSIAL_ID', $reqRowId);
		$pegawai_pendidikan_substansial->setField('PEGAWAI_ID', $reqId);

		if($reqMode == "insert")
		{
			$pegawai_pendidikan_substansial->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_pendidikan_substansial->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			if($pegawai_pendidikan_substansial->insert()){
				$reqRowId= $pegawai_pendidikan_substansial->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_pendidikan_substansial->query;
		}
		else
		{
			$pegawai_pendidikan_substansial->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_pendidikan_substansial->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			if($pegawai_pendidikan_substansial->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_pendidikan_substansial->query;
		}
	}

	
	function pegawai_add_penghasilan()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPenghasilan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_penghasilan = new PegawaiPenghasilan();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqTMTPenghasilan= httpFilterPost("reqTMTPenghasilan");
		$reqPeriode= httpFilterPost("reqPeriode");
		$reqKelas= httpFilterPost("reqKelas");
		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqPejabat= httpFilterPost("reqPejabat");
		$reqTahun= httpFilterPost("reqTahun");
		$reqBulan= httpFilterPost("reqBulan");
		$reqJumlahPenghasilan= httpFilterPost("reqJumlahPenghasilan");
		$reqJumlahTPP= httpFilterPost("reqJumlahTPP");
		$reqJumlahTunjanganJabatan= httpFilterPost("reqJumlahTunjanganJabatan");
		$reqJumlahTunjanganSelisih= httpFilterPost("reqJumlahTunjanganSelisih");
		$reqJumlahTransportasi= httpFilterPost("reqJumlahTransportasi");
		$reqJumlahUangMakan= httpFilterPost("reqJumlahUangMakan");
		$reqJumlahInsentif= httpFilterPost("reqJumlahInsentif");
		$reqProsentasePenghasilan= httpFilterPost("reqProsentasePenghasilan");
		$reqProsentaseTunjanganJabatan= httpFilterPost("reqProsentaseTunjanganJabatan");

		$reqProsentaseUangMakan= httpFilterPost("reqProsentaseUangMakan");
		$reqProsentaseTransportasi= httpFilterPost("reqProsentaseTransportasi");
		$reqProsentaseInsentif= httpFilterPost("reqProsentaseInsentif");

		$reqJumlahUangKehadiran= httpFilterPost("reqJumlahUangKehadiran");
		$reqProsentaseUangKehadiran= httpFilterPost("reqProsentaseUangKehadiran");
		$reqProsentaseTPP= httpFilterPost("reqProsentaseTPP");

		$reqKelasP3= httpFilterPost("reqKelasP3");
		$reqPeriodeP3= httpFilterPost("reqPeriodeP3");
		$reqJumlahP3= httpFilterPost("reqJumlahP3");

		$reqJumlahMobilitas= httpFilterPost("reqJumlahMobilitas");
		$reqProsentaseMobilitas = httpFilterPost("reqProsentaseMobilitas");
		$reqJumlahPerumahan = httpFilterPost("reqJumlahPerumahan");
		$reqProsentasePerumahan = httpFilterPost("reqProsentasePerumahan");
		$reqJumlahBBM = httpFilterPost("reqJumlahBBM");
		$reqProsentaseBBM = httpFilterPost("reqProsentaseBBM");
		$reqJumlahTelepon = httpFilterPost("reqJumlahTelepon");
		$reqProsentaseTelepon = httpFilterPost("reqProsentaseTelepon");

		if (isset($_POST["reqLumpMakan"]))
		$reqLumpMakan = httpFilterPost("reqLumpMakan");	
		else
		$reqLumpMakan = 0;

		if (isset($_POST["reqLumpTransport"]))
		$reqLumpTransport = httpFilterPost("reqLumpTransport");
		else
		$reqLumpTransport = 0;

		$pegawai_penghasilan->setField('LUMPSUM_MAKAN', $reqLumpMakan);
		$pegawai_penghasilan->setField('LUMPSUM_TRANSPORT', $reqLumpTransport);


		$pegawai_penghasilan->setField('PROSENTASE_TPP', $reqProsentaseTPP);

		$pegawai_penghasilan->setField('JUMLAH_P3', setNULL(dotToNo($reqJumlahP3)));
		$pegawai_penghasilan->setField('KELAS_P3', setNULL($reqKelasP3));
		$pegawai_penghasilan->setField('PERIODE_P3', setNULL($reqPeriodeP3));

		$pegawai_penghasilan->setField('KELAS', $reqKelas);
		$pegawai_penghasilan->setField('TMT_PENGHASILAN', dateToDBCheck($reqTMTPenghasilan));
		$pegawai_penghasilan->setField('PERIODE', $reqPeriode);
		$pegawai_penghasilan->setField('NO_SK', $reqNoSK);
		$pegawai_penghasilan->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
		$pegawai_penghasilan->setField('PEJABAT_PENETAP_ID', $reqPejabat);
		$pegawai_penghasilan->setField('MASA_KERJA_TAHUN', $reqTahun);
		$pegawai_penghasilan->setField('MASA_KERJA_BULAN', $reqBulan);
		$pegawai_penghasilan->setField('JUMLAH_PENGHASILAN', dotToNo($reqJumlahPenghasilan));
		$pegawai_penghasilan->setField('JUMLAH_TPP', dotToNo($reqJumlahTPP));
		$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_JABATAN', dotToNo($reqJumlahTunjanganJabatan));
		$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_SELISIH', dotToNo($reqJumlahTunjanganSelisih));
		$pegawai_penghasilan->setField('JUMLAH_TRANSPORTASI', dotToNo($reqJumlahTransportasi));
		$pegawai_penghasilan->setField('JUMLAH_UANG_MAKAN', dotToNo($reqJumlahUangMakan));
		$pegawai_penghasilan->setField('JUMLAH_INSENTIF', dotToNo($reqJumlahInsentif));
		$pegawai_penghasilan->setField('PROSENTASE_PENGHASILAN', $reqProsentasePenghasilan);
		$pegawai_penghasilan->setField('PROSENTASE_TUNJANGAN_JABATAN', $reqProsentaseTunjanganJabatan);

		$pegawai_penghasilan->setField('PROSENTASE_UANG_MAKAN', $reqProsentaseUangMakan);
		$pegawai_penghasilan->setField('PROSENTASE_TRANSPORTASI', $reqProsentaseTransportasi);
		$pegawai_penghasilan->setField('PROSENTASE_INSENTIF', $reqProsentaseInsentif);

		$pegawai_penghasilan->setField('JUMLAH_UANG_KEHADIRAN', dotToNo($reqJumlahUangKehadiran));
		$pegawai_penghasilan->setField('PROSENTASE_UANG_KEHADIRAN', $reqProsentaseUangKehadiran);

		$pegawai_penghasilan->setField('PEGAWAI_PENGHASILAN_ID', $reqRowId);
		$pegawai_penghasilan->setField('PEGAWAI_ID', $reqId);

		$pegawai_penghasilan->setField('JUMLAH_MOBILITAS', dotToNo($reqJumlahMobilitas));
		$pegawai_penghasilan->setField('PROSENTASE_MOBILITAS', $reqProsentaseMobilitas);
		$pegawai_penghasilan->setField('JUMLAH_PERUMAHAN',  dotToNo($reqJumlahPerumahan));
		$pegawai_penghasilan->setField('PROSENTASE_PERUMAHAN', $reqProsentasePerumahan);
		$pegawai_penghasilan->setField('JUMLAH_BBM', dotToNo($reqJumlahBBM));
		$pegawai_penghasilan->setField('PROSENTASE_BBM', $reqProsentaseBBM);
		$pegawai_penghasilan->setField('JUMLAH_TELEPON', dotToNo($reqJumlahTelepon));
		$pegawai_penghasilan->setField('PROSENTASE_TELEPON', $reqProsentaseTelepon);
		$pegawai_penghasilan->setField('KETERANGAN_PERUBAHAN', 'Penetapan Awal Merit');


		if($reqMode == "insert")
		{
			$pegawai_penghasilan->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_penghasilan->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			if($pegawai_penghasilan->insert()){
				$reqRowId= $pegawai_penghasilan->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_penghasilan->query;
		}
		else
		{
			$pegawai_penghasilan->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_penghasilan->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
			if($pegawai_penghasilan->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_penghasilan->query;
		}
	}

	
	function pegawai_add_penghasilan_tmt_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPenghasilan.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");

		$pegawai_penghasilan = new PegawaiPenghasilan();

		$reqId= httpFilterGet("reqId");
		$reqTMT= httpFilterGet("reqTMT");
		$reqTMTTemp= httpFilterGet("reqTMTTemp");

		if($reqTMTTemp == "")
		{
			$pegawai_penghasilan->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_PENGHASILAN, 'DD-MM-YYYY')"=>$reqTMT));
		}
		else
		{
			$pegawai_penghasilan->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_PENGHASILAN, 'DD-MM-YYYY')"=>$reqTMT, "NOT TO_CHAR(A.TMT_PENGHASILAN, 'DD-MM-YYYY')" => $reqTMTTemp));
		}

		$pegawai_penghasilan->firstRow();

		$arrFinal = array("PEGAWAI_PENGHASILAN_ID" => $pegawai_penghasilan->getField("PEGAWAI_PENGHASILAN_ID"));

		echo json_encode($arrFinal);
	}

	
	function pegawai_add_pensiun()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base/UserLoginBase.php");

		$pegawai_status_pegawai = new PegawaiStatusPegawai();
		$user_login = new UserLoginBase();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId= httpFilterPost("reqRowId");

		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqTMT= httpFilterPost("reqTMT");
		$reqPejabat= httpFilterPost("reqPejabat");

		if($reqMode == "insert")
		{
			$pegawai_status_pegawai->setField('NO_SK', $reqNoSK);
			$pegawai_status_pegawai->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
			$pegawai_status_pegawai->setField('TMT_SK', dateToDBCheck($reqTMT));
			$pegawai_status_pegawai->setField('PEJABAT_PENETAP_ID', $reqPejabat);
			$pegawai_status_pegawai->setField('PEGAWAI_ID', $reqId);
			$pegawai_status_pegawai->setField('STATUS_PEGAWAI_ID', 2);
			$pegawai_status_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_status_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			
			if($pegawai_status_pegawai->insert())
			{
				$pegawai = new Pegawai();
				$pegawai->setField('TANGGAL_PENSIUN', dateToDBCheck($reqTMT));
				$pegawai->setField('PEGAWAI_ID', $reqId);
				$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
				$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			
				if($pegawai->updatePensiun())
				{
					$reqRowId= $pegawai_status_pegawai->id;
					echo $reqId."-Data berhasil disimpan.-".$reqRowId;
				}
				$user_login->setField("STATUS", 0);
				$user_login->setField("PEGAWAI_ID", $reqId);
				$user_login->updateStatusAktif();
				
				//echo $pegawai->query;
			}
			//echo $pegawai_status_pegawai->query;
		}
	}

	
	function pegawai_add_perpanjangan_kontrak()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusPegawai.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPenghasilan.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiKontrakPkwt.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_penghasilan = new PegawaiPenghasilan();
		$pegawai_status_pegawai = new PegawaiStatusPegawai();
		$pegawai_jenis_pegawai = new PegawaiJenisPegawai();
		$pegawai_kontrak_pkwt = new PegawaiKontrakPkwt();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqTMTPenghasilan= httpFilterPost("reqTMTPenghasilan");
		$reqPeriode= httpFilterPost("reqPeriode");
		$reqKelas= httpFilterPost("reqKelas");
		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqPejabat= httpFilterPost("reqPejabat");
		$reqTahun= httpFilterPost("reqTahun");
		$reqBulan= httpFilterPost("reqBulan");
		$reqJumlahPenghasilan= httpFilterPost("reqJumlahPenghasilan");
		$reqJumlahTPP= httpFilterPost("reqJumlahTPP");
		$reqJumlahTunjanganJabatan= httpFilterPost("reqJumlahTunjanganJabatan");
		$reqJumlahTunjanganSelisih= httpFilterPost("reqJumlahTunjanganSelisih");
		$reqJumlahTransportasi= httpFilterPost("reqJumlahTransportasi");
		$reqJumlahUangMakan= httpFilterPost("reqJumlahUangMakan");
		$reqJumlahInsentif= httpFilterPost("reqJumlahInsentif");
		$reqProsentasePenghasilan= httpFilterPost("reqProsentasePenghasilan");
		$reqProsentaseTunjanganJabatan= httpFilterPost("reqProsentaseTunjanganJabatan");
		$reqProsentaseUangMakan= httpFilterPost("reqProsentaseUangMakan");
		$reqProsentaseTransportasi= httpFilterPost("reqProsentaseTransportasi");
		$reqProsentaseInsentif= httpFilterPost("reqProsentaseInsentif");

		$reqJumlahUangKehadiran= httpFilterPost("reqJumlahUangKehadiran");
		$reqProsentaseUangKehadiran= httpFilterPost("reqProsentaseUangKehadiran");
		$reqProsentaseTPP= httpFilterPost("reqProsentaseTPP");

		$reqKelasP3= httpFilterPost("reqKelasP3");
		$reqPeriodeP3= httpFilterPost("reqPeriodeP3");
		$reqJumlahP3= httpFilterPost("reqJumlahP3");

		$reqJumlahMobilitas= httpFilterPost("reqJumlahMobilitas");
		$reqProsentaseMobilitas = httpFilterPost("reqProsentaseMobilitas");
		$reqJumlahPerumahan = httpFilterPost("reqJumlahPerumahan");
		$reqProsentasePerumahan = httpFilterPost("reqProsentasePerumahan");
		$reqJumlahBBM = httpFilterPost("reqJumlahBBM");
		$reqProsentaseBBM = httpFilterPost("reqProsentaseBBM");
		$reqJumlahTelepon = httpFilterPost("reqJumlahTelepon");
		$reqProsentaseTelepon = httpFilterPost("reqProsentaseTelepon");
		$reqNoSKMPP= httpFilterPost("reqNoSKMPP");
		$reqTMTMPP= httpFilterPost("reqTMTMPP");
		$reqJenisPegawaiId = httpFilterPost("reqJenisPegawaiId");
		$reqNoKontrak = httpFilterPost("reqNoKontrak");
		$reqTanggalKontrakAwal  = httpFilterPost("reqTanggalKontrakAwal");
		$reqTanggalKontrakAkhir = httpFilterPost("reqTanggalKontrakAkhir");
		$reqPegawaiJenisPegawaiId = httpFilterPost("reqPegawaiJenisPegawaiId");

		$pegawai_penghasilan->setField('PROSENTASE_TPP', $reqProsentaseTPP);

		$pegawai_penghasilan->setField('JUMLAH_P3', setNULL(dotToNo($reqJumlahP3)));
		$pegawai_penghasilan->setField('KELAS_P3', setNULL($reqKelasP3));
		$pegawai_penghasilan->setField('PERIODE_P3', setNULL($reqPeriodeP3));

		$pegawai_penghasilan->setField('KELAS', $reqKelas);
		$pegawai_penghasilan->setField('TMT_PENGHASILAN', dateToDBCheck($reqTMTPenghasilan));
		$pegawai_penghasilan->setField('PERIODE', $reqPeriode);
		$pegawai_penghasilan->setField('NO_SK', $reqNoSK);
		$pegawai_penghasilan->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
		$pegawai_penghasilan->setField('PEJABAT_PENETAP_ID', $reqPejabat);
		$pegawai_penghasilan->setField('MASA_KERJA_TAHUN', $reqTahun);
		$pegawai_penghasilan->setField('MASA_KERJA_BULAN', $reqBulan);
		$pegawai_penghasilan->setField('JUMLAH_PENGHASILAN', dotToNo($reqJumlahPenghasilan));
		$pegawai_penghasilan->setField('JUMLAH_TPP', dotToNo($reqJumlahTPP));
		$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_JABATAN', dotToNo($reqJumlahTunjanganJabatan));
		$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_SELISIH', dotToNo($reqJumlahTunjanganSelisih));
		$pegawai_penghasilan->setField('JUMLAH_TRANSPORTASI', dotToNo($reqJumlahTransportasi));
		$pegawai_penghasilan->setField('JUMLAH_UANG_MAKAN', dotToNo($reqJumlahUangMakan));
		$pegawai_penghasilan->setField('JUMLAH_INSENTIF', dotToNo($reqJumlahInsentif));
		$pegawai_penghasilan->setField('PROSENTASE_PENGHASILAN', $reqProsentasePenghasilan);
		$pegawai_penghasilan->setField('PROSENTASE_TUNJANGAN_JABATAN', $reqProsentaseTunjanganJabatan);

		$pegawai_penghasilan->setField('PROSENTASE_UANG_MAKAN', $reqProsentaseUangMakan);
		$pegawai_penghasilan->setField('PROSENTASE_TRANSPORTASI', $reqProsentaseTransportasi);
		$pegawai_penghasilan->setField('PROSENTASE_INSENTIF', $reqProsentaseInsentif);

		$pegawai_penghasilan->setField('JUMLAH_UANG_KEHADIRAN', dotToNo($reqJumlahUangKehadiran));
		$pegawai_penghasilan->setField('PROSENTASE_UANG_KEHADIRAN', $reqProsentaseUangKehadiran);

		$pegawai_penghasilan->setField('PEGAWAI_PENGHASILAN_ID', $reqRowId);
		$pegawai_penghasilan->setField('PEGAWAI_ID', $reqId);

		$pegawai_penghasilan->setField('JUMLAH_MOBILITAS', dotToNo($reqJumlahMobilitas));
		$pegawai_penghasilan->setField('PROSENTASE_MOBILITAS', $reqProsentaseMobilitas);
		$pegawai_penghasilan->setField('JUMLAH_PERUMAHAN',  dotToNo($reqJumlahPerumahan));
		$pegawai_penghasilan->setField('PROSENTASE_PERUMAHAN', $reqProsentasePerumahan);
		$pegawai_penghasilan->setField('JUMLAH_BBM', dotToNo($reqJumlahBBM));
		$pegawai_penghasilan->setField('PROSENTASE_BBM', $reqProsentaseBBM);
		$pegawai_penghasilan->setField('JUMLAH_TELEPON', dotToNo($reqJumlahTelepon));
		$pegawai_penghasilan->setField('PROSENTASE_TELEPON', $reqProsentaseTelepon);
		$pegawai_penghasilan->setField('KETERANGAN_PERUBAHAN', 'Perpanjangan Masa Kontrak');


		if($reqMode == "insert")
		{
			$pegawai_penghasilan->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_penghasilan->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			if($pegawai_penghasilan->insert()){
				$pegawai_jenis_pegawai->setField('TANGGAL_KONTRAK_AWAL', dateToDBCheck($reqTanggalKontrakAwal));
				$pegawai_jenis_pegawai->setField('TANGGAL_KONTRAK_AKHIR', dateToDBCheck($reqTanggalKontrakAkhir));
				$pegawai_jenis_pegawai->setField('KETERANGAN', $reqNoKontrak);		
				$pegawai_jenis_pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
				$pegawai_jenis_pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
				$pegawai_jenis_pegawai->setField("PEGAWAI_JENIS_PEGAWAI_ID", $reqPegawaiJenisPegawaiId);
				$pegawai_jenis_pegawai->updateKontrak();
				
				$pegawai_kontrak_pkwt->setField("PEGAWAI_ID", $reqId);
				$pegawai_kontrak_pkwt->setField("NOMOR", $reqNoKontrak);
				$pegawai_kontrak_pkwt->setField("TANGGAL_AWAL", dateToDBCheck($reqTanggalKontrakAwal));
				$pegawai_kontrak_pkwt->setField("TANGAL_AKHIR", dateToDBCheck($reqTanggalKontrakAkhir));
				$pegawai_kontrak_pkwt->insert();
				
				$reqRowId= $pegawai_penghasilan->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;

			}
			//echo $pegawai_penghasilan->query;
		}
	}

	
	function pegawai_add_perubahan_alamat()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PerubahanAlamat.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$perubahan_alamat = new PerubahanAlamat();

		$reqId = httpFilterPost("reqId");
		$reqRowId = httpFilterPost("reqRowId");
		$reqMode = httpFilterPost("reqMode");
		$reqTMT= httpFilterPost("reqTMT");
		$reqAlamat= httpFilterPost("reqAlamat");


		if($reqMode == "insert")
		{
			$perubahan_alamat->setField('PEGAWAI_ID', $reqId);
			$perubahan_alamat->setField('TMT_PERUBAHAN_ALAMAT', dateToDBCheck($reqTMT));
			$perubahan_alamat->setField('ALAMAT', $reqAlamat);
			if($perubahan_alamat->insert())
			{
				$reqRowId= $perubahan_alamat->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
		}
		else
		{
			$perubahan_alamat->setField('PERUBAHAN_ALAMAT_ID', $reqRowId); 
			$perubahan_alamat->setField('TMT_PERUBAHAN_ALAMAT', dateToDBCheck($reqTMT));
			$perubahan_alamat->setField('ALAMAT', $reqAlamat);
			if($perubahan_alamat->update())
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			
		}
	}

	
	function pegawai_add_perubahan_jenis_pegawai()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusPegawai.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPenghasilan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_penghasilan = new PegawaiPenghasilan();
		$pegawai_status_pegawai = new PegawaiStatusPegawai();
		$pegawai_jenis_pegawai = new PegawaiJenisPegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqTMTPenghasilan= httpFilterPost("reqTMTPenghasilan");
		$reqPeriode= httpFilterPost("reqPeriode");
		$reqKelas= httpFilterPost("reqKelas");
		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqPejabat= httpFilterPost("reqPejabat");
		$reqTahun= httpFilterPost("reqTahun");
		$reqBulan= httpFilterPost("reqBulan");
		$reqJumlahPenghasilan= httpFilterPost("reqJumlahPenghasilan");
		$reqJumlahTPP= httpFilterPost("reqJumlahTPP");
		$reqJumlahTunjanganJabatan= httpFilterPost("reqJumlahTunjanganJabatan");
		$reqJumlahTunjanganSelisih= httpFilterPost("reqJumlahTunjanganSelisih");
		$reqJumlahTransportasi= httpFilterPost("reqJumlahTransportasi");
		$reqJumlahUangMakan= httpFilterPost("reqJumlahUangMakan");
		$reqJumlahInsentif= httpFilterPost("reqJumlahInsentif");
		$reqProsentasePenghasilan= httpFilterPost("reqProsentasePenghasilan");
		$reqProsentaseTunjanganJabatan= httpFilterPost("reqProsentaseTunjanganJabatan");
		$reqProsentaseUangMakan= httpFilterPost("reqProsentaseUangMakan");
		$reqProsentaseTransportasi= httpFilterPost("reqProsentaseTransportasi");
		$reqProsentaseInsentif= httpFilterPost("reqProsentaseInsentif");

		$reqJumlahUangKehadiran= httpFilterPost("reqJumlahUangKehadiran");
		$reqProsentaseUangKehadiran= httpFilterPost("reqProsentaseUangKehadiran");
		$reqProsentaseTPP= httpFilterPost("reqProsentaseTPP");

		$reqKelasP3= httpFilterPost("reqKelasP3");
		$reqPeriodeP3= httpFilterPost("reqPeriodeP3");
		$reqJumlahP3= httpFilterPost("reqJumlahP3");

		$reqJumlahMobilitas= httpFilterPost("reqJumlahMobilitas");
		$reqProsentaseMobilitas = httpFilterPost("reqProsentaseMobilitas");
		$reqJumlahPerumahan = httpFilterPost("reqJumlahPerumahan");
		$reqProsentasePerumahan = httpFilterPost("reqProsentasePerumahan");
		$reqJumlahBBM = httpFilterPost("reqJumlahBBM");
		$reqProsentaseBBM = httpFilterPost("reqProsentaseBBM");
		$reqJumlahTelepon = httpFilterPost("reqJumlahTelepon");
		$reqProsentaseTelepon = httpFilterPost("reqProsentaseTelepon");
		$reqNoSKMPP= httpFilterPost("reqNoSKMPP");
		$reqTMTMPP= httpFilterPost("reqTMTMPP");

		$reqJenisPegawaiId = httpFilterPost("reqJenisPegawaiId");


		$pegawai_penghasilan->setField('PROSENTASE_TPP', $reqProsentaseTPP);

		$pegawai_penghasilan->setField('JUMLAH_P3', setNULL(dotToNo($reqJumlahP3)));
		$pegawai_penghasilan->setField('KELAS_P3', setNULL($reqKelasP3));
		$pegawai_penghasilan->setField('PERIODE_P3', setNULL($reqPeriodeP3));

		$pegawai_penghasilan->setField('KELAS', $reqKelas);
		$pegawai_penghasilan->setField('TMT_PENGHASILAN', dateToDBCheck($reqTMTPenghasilan));
		$pegawai_penghasilan->setField('PERIODE', $reqPeriode);
		$pegawai_penghasilan->setField('NO_SK', $reqNoSK);
		$pegawai_penghasilan->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
		$pegawai_penghasilan->setField('PEJABAT_PENETAP_ID', $reqPejabat);
		$pegawai_penghasilan->setField('MASA_KERJA_TAHUN', $reqTahun);
		$pegawai_penghasilan->setField('MASA_KERJA_BULAN', $reqBulan);
		$pegawai_penghasilan->setField('JUMLAH_PENGHASILAN', dotToNo($reqJumlahPenghasilan));
		$pegawai_penghasilan->setField('JUMLAH_TPP', dotToNo($reqJumlahTPP));
		$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_JABATAN', dotToNo($reqJumlahTunjanganJabatan));
		$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_SELISIH', dotToNo($reqJumlahTunjanganSelisih));
		$pegawai_penghasilan->setField('JUMLAH_TRANSPORTASI', dotToNo($reqJumlahTransportasi));
		$pegawai_penghasilan->setField('JUMLAH_UANG_MAKAN', dotToNo($reqJumlahUangMakan));
		$pegawai_penghasilan->setField('JUMLAH_INSENTIF', dotToNo($reqJumlahInsentif));
		$pegawai_penghasilan->setField('PROSENTASE_PENGHASILAN', $reqProsentasePenghasilan);
		$pegawai_penghasilan->setField('PROSENTASE_TUNJANGAN_JABATAN', $reqProsentaseTunjanganJabatan);

		$pegawai_penghasilan->setField('PROSENTASE_UANG_MAKAN', $reqProsentaseUangMakan);
		$pegawai_penghasilan->setField('PROSENTASE_TRANSPORTASI', $reqProsentaseTransportasi);
		$pegawai_penghasilan->setField('PROSENTASE_INSENTIF', $reqProsentaseInsentif);

		$pegawai_penghasilan->setField('JUMLAH_UANG_KEHADIRAN', dotToNo($reqJumlahUangKehadiran));
		$pegawai_penghasilan->setField('PROSENTASE_UANG_KEHADIRAN', $reqProsentaseUangKehadiran);

		$pegawai_penghasilan->setField('PEGAWAI_PENGHASILAN_ID', $reqRowId);
		$pegawai_penghasilan->setField('PEGAWAI_ID', $reqId);

		$pegawai_penghasilan->setField('JUMLAH_MOBILITAS', dotToNo($reqJumlahMobilitas));
		$pegawai_penghasilan->setField('PROSENTASE_MOBILITAS', $reqProsentaseMobilitas);
		$pegawai_penghasilan->setField('JUMLAH_PERUMAHAN',  dotToNo($reqJumlahPerumahan));
		$pegawai_penghasilan->setField('PROSENTASE_PERUMAHAN', $reqProsentasePerumahan);
		$pegawai_penghasilan->setField('JUMLAH_BBM', dotToNo($reqJumlahBBM));
		$pegawai_penghasilan->setField('PROSENTASE_BBM', $reqProsentaseBBM);
		$pegawai_penghasilan->setField('JUMLAH_TELEPON', dotToNo($reqJumlahTelepon));
		$pegawai_penghasilan->setField('PROSENTASE_TELEPON', $reqProsentaseTelepon);
		$pegawai_penghasilan->setField('KETERANGAN_PERUBAHAN', 'Pengangkatan Pegawai');


		if($reqMode == "insert")
		{
			$pegawai_penghasilan->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_penghasilan->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			if($pegawai_penghasilan->insert()){
			
			$pegawai_jenis_pegawai->setField('NO_SK_MPP', "NULL");
			$pegawai_jenis_pegawai->setField('TMT_MPP', "NULL");
			$pegawai_jenis_pegawai->setField('TANGGAL_KONTRAK_AWAL', "NULL");
			$pegawai_jenis_pegawai->setField('TANGGAL_KONTRAK_AKHIR', "NULL");
			$pegawai_jenis_pegawai->setField('ASAL_PERUSAHAAN', '');
			$pegawai_jenis_pegawai->setField('MPP', "NULL");
			$pegawai_jenis_pegawai->setField('TMT_JENIS_PEGAWAI', dateToDBCheck($reqTMTPenghasilan));
			$pegawai_jenis_pegawai->setField('JENIS_PEGAWAI_ID', $reqJenisPegawaiId);
			$pegawai_jenis_pegawai->setField('KETERANGAN', '');
			$pegawai_jenis_pegawai->setField('JENIS_PEGAWAI_PERUBAH_KODE_ID', 1);
			$pegawai_jenis_pegawai->setField('PEGAWAI_ID', $reqId);

			$pegawai_jenis_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_jenis_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			$pegawai_jenis_pegawai->insert();

				$reqRowId= $pegawai_penghasilan->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			
			}
			//echo $pegawai_penghasilan->query;
		}
	}

	
	function pegawai_add_puspel()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPuspel.php");
		include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_puspel = new PegawaiPuspel();
		$departemen_cabang = new Departemen();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqTMTPuspel= httpFilterPost("reqTMTPuspel");
		$reqKodePuspel1= httpFilterPost("reqKodePuspel1");
		$reqKodePuspel2= httpFilterPost("reqKodePuspel2");
		$reqKodePuspel3= httpFilterPost("reqKodePuspel3");
		$reqCabang= httpFilterPost("reqCabang");
		$reqDepartemen= httpFilterPost("reqDepartemen");
		$reqTanggalPuspel= httpFilterPost("reqTanggalPuspel");

		$departemen_cabang->selectByParams(array('DEPARTEMEN_ID'=>$reqDepartemen));
		$departemen_cabang->firstRow();
		$reqCabang= $departemen_cabang->getField('CABANG_ID');

		$pegawai_puspel->setField('TMT_PUSPEL', dateToDBCheck($reqTMTPuspel));
		$pegawai_puspel->setField('KODE_PUSPEL1', $reqKodePuspel1);
		$pegawai_puspel->setField('KODE_PUSPEL2', $reqKodePuspel2);
		$pegawai_puspel->setField('KODE_PUSPEL3', $reqKodePuspel3);
		$pegawai_puspel->setField('TANGGAL_PUSPEL', dateToDBCheck($reqTanggalPuspel));
		$pegawai_puspel->setField('CABANG_ID', $reqCabang);
		$pegawai_puspel->setField('DEPARTEMEN_ID', $reqDepartemen);
		$pegawai_puspel->setField('PEGAWAI_PUSPEL_ID', $reqRowId);
		$pegawai_puspel->setField('PEGAWAI_ID', $reqId);

		if($reqMode == "insert")
		{
			$pegawai_puspel->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_puspel->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			if($pegawai_puspel->insert()){
				$reqRowId= $pegawai_puspel->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_puspel->query;
		}
		else
		{
			$pegawai_puspel->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_puspel->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			if($pegawai_puspel->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_puspel->query;
		}
	}

	
	function pegawai_add_sertifikat()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiSertifikat.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_sertifikat = new PegawaiSertifikat();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqTanggalTerbit 			= $_POST["reqTanggalTerbit"];
		$reqTanggalKadaluarsa 		= $_POST["reqTanggalKadaluarsa"];
		$reqJumlah = $_POST["reqJumlah"];
		$reqGroupKapal= $_POST["reqGroupKapal"];
		$reqKeterangan= $_POST["reqKeterangan"];
		$reqPegawaiSertifikatId = $_POST["reqPegawaiSertifikatId"];
		$reqArrayIndex= $_POST["reqArrayIndex"];

		$set_loop= $reqArrayIndex;

		if($reqMode == "insert")
		{
			$pegawai_sertifikat->setField("PEGAWAI_ID", $reqId);
			$pegawai_sertifikat->delete();
			unset($pegawai_sertifikat);
			
			for($i=0;$i<=$set_loop;$i++)
			{
				if($reqPegawaiSertifikatId[$i] == "")
				{}
				else
				{
				$index = $i;
				$pegawai_sertifikat = new PegawaiSertifikat();
				$pegawai_sertifikat->setField("NAMA", $reqPegawaiSertifikatId[$index]);
				$pegawai_sertifikat->setField("TANGGAL_TERBIT", dateToDBCheck($reqTanggalTerbit[$index]));
				$pegawai_sertifikat->setField("TANGGAL_KADALUARSA", dateToDBCheck($reqTanggalKadaluarsa[$index]));
				$pegawai_sertifikat->setField("GROUP_SERTIFIKAT", $reqGroupKapal[$index]);
				$pegawai_sertifikat->setField("KETERANGAN", $reqKeterangan[$index]);
				$pegawai_sertifikat->setField("PEGAWAI_ID", $reqId);
				$pegawai_sertifikat->setField("LAST_CREATE_USER", $userLogin->nama);
				$pegawai_sertifikat->setField("LAST_CREATE_DATE", OCI_SYSDATE);			
				
				$pegawai_sertifikat->insert();
				//echo $pegawai_sertifikat->query;
				unset($pegawai_sertifikat);
				}
			}
			echo "Data berhasil disimpan.";
		}
	}

	
	function pegawai_add_sk_calon_pegawai()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiSKCalonPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_sk_calon_pegawai = new PegawaiSKCalonPegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTMT= httpFilterPost("reqTMT");
		$reqTanggalSK= httpFilterPost("reqTanggalSK");
		$reqPendidikan= httpFilterPost("reqPendidikan");
		$reqTahun= httpFilterPost("reqTahun");
		$reqBulan= httpFilterPost("reqBulan");
		$reqPangkat= httpFilterPost("reqPangkat");
		$reqPangkatKode= httpFilterPost("reqPangkatKode");
		$reqPejabat= httpFilterPost("reqPejabat");
		$reqTMTP3= httpFilterPost("reqTMTP3");
		$reqPegawaiSKCalonPegawaiId= httpFilterPost("reqPegawaiSKCalonPegawaiId");

		$pegawai_sk_calon_pegawai->setField('NO_SK', $reqNoSK);
		$pegawai_sk_calon_pegawai->setField('TMT_SK', dateToDBCheck($reqTMT));
		$pegawai_sk_calon_pegawai->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSK));
		//$pegawai_sk_calon_pegawai->setField('', $reqPendidikanId);
		$pegawai_sk_calon_pegawai->setField('PENDIDIKAN_ID', $reqPendidikan);
		$pegawai_sk_calon_pegawai->setField('MASA_KERJA_TAHUN', $reqTahun);
		$pegawai_sk_calon_pegawai->setField('MASA_KERJA_BULAN', $reqBulan);
		$pegawai_sk_calon_pegawai->setField('PANGKAT_ID', $reqPangkat);
		//$pegawai_sk_calon_pegawai->setField('', $reqPangkatKodeId);
		$pegawai_sk_calon_pegawai->setField('PANGKAT_KODE_ID', $reqPangkatKode);
		$pegawai_sk_calon_pegawai->setField('PEJABAT_PENETAP_ID', $reqPejabat);
		$pegawai_sk_calon_pegawai->setField('TMT_P3', dateToDBCheck($reqTMTP3));
		$pegawai_sk_calon_pegawai->setField('PEGAWAI_SK_CALON_PEGAWAI_ID', $reqPegawaiSKCalonPegawaiId);
		$pegawai_sk_calon_pegawai->setField('PEGAWAI_ID', $reqId);
			
		//echo $reqPegawaiSKCalonPegawaiId.'---'.$reqMode;

		if($reqMode == "insert")
		{
			$pegawai_sk_calon_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_sk_calon_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			if($pegawai_sk_calon_pegawai->insert()){
				echo $reqId."-Data berhasil disimpan.";
			}
			//echo $pegawai_sk_calon_pegawai->query;
		}
		else
		{
			$pegawai_sk_calon_pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_sk_calon_pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
			if($pegawai_sk_calon_pegawai->update()){
				echo $reqId."-Data berhasil disimpan.";
			}
			//echo $pegawai_sk_calon_pegawai->query;
		}
	}

	
	function pegawai_add_sk_pegawai()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiSKPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_sk_pegawai = new PegawaiSKPegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqPegawaiSkPegawaiId= httpFilterPost("reqPegawaiSkPegawaiId");
		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTanggalSK= httpFilterPost("reqTanggalSK");
		$reqTanggalMulai= httpFilterPost("reqTanggalMulai");
		$reqPejabat= httpFilterPost("reqPejabat");

		$pegawai_sk_pegawai->setField('PEGAWAI_SK_PEGAWAI_ID', $reqPegawaiSkPegawaiId);
		$pegawai_sk_pegawai->setField('NO_SK', $reqNoSK);
		$pegawai_sk_pegawai->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSK));
		$pegawai_sk_pegawai->setField('TMT_SK', dateToDBCheck($reqTanggalMulai));
		$pegawai_sk_pegawai->setField('PEJABAT_PENETAP_ID', $reqPejabat);
		$pegawai_sk_pegawai->setField('PEGAWAI_ID', $reqId);
			
		//echo $reqPegawaiSkPegawaiId.'---'.$reqMode;

		if($reqMode == "insert")
		{
			$pegawai_sk_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_sk_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			if($pegawai_sk_pegawai->insert()){
				echo $reqId."-Data berhasil disimpan.";
			}
			//echo $pegawai_sk_pegawai->query;
		}
		else
		{
			$pegawai_sk_pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_sk_pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			if($pegawai_sk_pegawai->update()){
				echo $reqId."-Data berhasil disimpan.";
			}
			//echo $pegawai_sk_pegawai->query;
		}
	}

	
	function pegawai_add_status_cuti_tahunan()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
		include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$cuti_tahunan = new CutiTahunan();
		$cuti_tahunan_detil = new CutiTahunanDetil();
		$pegawai_jabatan = new PegawaiJabatan();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqLamaCuti = httpFilterPost("reqLamaCuti");
		$reqLamaCutiTerbayar = httpFilterPost("reqLamaCutiTerbayar");
		$reqPeriode = httpFilterPost("reqPeriode");
		$reqStatus =httpFilterPost("reqStatus");		



		$cuti_tahunan_detil->deletePegawai($reqId);
		$cuti_tahunan->setField('PEGAWAI_ID', $reqId);
		$cuti_tahunan->deletePegawai();

		$cuti_tahunan->setField('PEGAWAI_ID', $reqId);
		$cuti_tahunan->setField('PERIODE', $reqPeriode);
		$cuti_tahunan->setField('LAMA_CUTI', $reqLamaCuti);
		$cuti_tahunan->setField('TANGGAL', dateToDBCheck(""));
		$cuti_tahunan->setField('TANGGAL_AWAL', dateToDBCheck(""));
		$cuti_tahunan->setField('TANGGAL_AKHIR', dateToDBCheck(""));
		$cuti_tahunan->setField('STATUS_BAYAR_MUTASI', "D");
		if ($cuti_tahunan->insertPegawai())
		{
			$cuti_tahunan_detil->setField('CUTI_TAHUNAN_ID', $cuti_tahunan->id);
			$cuti_tahunan_detil->setField('LAMA_CUTI', $reqLamaCuti);
			$cuti_tahunan_detil->setField('LOKASI_CUTI', "");
			$cuti_tahunan_detil->setField('TANGGAL', dateToDBCheck(""));
			$cuti_tahunan_detil->setField('TANGGAL_AWAL', dateToDBCheck(""));
			$cuti_tahunan_detil->setField('TANGGAL_AKHIR', dateToDBCheck(""));
			$cuti_tahunan_detil->setField('TANGGAL_CETAK', dateToDBCheck(date("01-02-Y")));
			$cuti_tahunan_detil->setField('TANGGAL_APPROVE', dateToDBCheck(date("01-02-Y")));
			$cuti_tahunan_detil->setField('STATUS_BAYAR_MUTASI', "D");
			$cuti_tahunan_detil->setField('LAMA_CUTI_TERBAYAR', $reqLamaCutiTerbayar);
			$cuti_tahunan_detil->insertPegawai();

			echo $reqId."-Data berhasil disimpan.";
		}
	}

	
	function pegawai_add_status_nikah()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusNikah.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_status_nikah = new PegawaiStatusNikah();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqTanggalNikah= httpFilterPost("reqTanggalNikah");
		$reqStatusNikah= httpFilterPost("reqStatusNikah");
		$reqTempat= httpFilterPost("reqTempat");
		$reqNoSK= httpFilterPost("reqNoSK");
		$reqHubungan= httpFilterPost("reqHubungan");

		$pegawai_status_nikah->setField('TANGGAL_NIKAH', dateToDBCheck($reqTanggalNikah));
		$pegawai_status_nikah->setField('STATUS_NIKAH', $reqStatusNikah);
		$pegawai_status_nikah->setField('TEMPAT', $reqTempat);
		$pegawai_status_nikah->setField('NO_SK', $reqNoSK);
		$pegawai_status_nikah->setField('HUBUNGAN', $reqHubungan);
		$pegawai_status_nikah->setField('PEGAWAI_STATUS_NIKAH_ID', $reqRowId);
		$pegawai_status_nikah->setField('PEGAWAI_ID', $reqId);

		if($reqMode == "insert")
		{
			$pegawai_status_nikah->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_status_nikah->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			if($pegawai_status_nikah->insert()){
				$reqRowId= $pegawai_status_nikah->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_status_nikah->query;
		}
		else
		{
			$pegawai_status_nikah->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_status_nikah->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
			if($pegawai_status_nikah->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_status_nikah->query;
		}
	}

	
	function pegawai_add_usulan_kenaikan_jabatan()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/KenaikanJabatan.php");
		include_once("../WEB-INF/classes/base/UserLoginBase.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$kenaikan_jabatan = new KenaikanJabatan();
		$UserLoginBase = new UserLoginBase();

		$reqId = httpFilterPost("reqId");

		$reqDepartemenLama= httpFilterPost("reqDepartemenLama");
		$reqJabatanLama= httpFilterPost("reqJabatanLama");
		$reqDepartemenBaru= httpFilterPost("reqDepartemenBaru");
		$reqJabatanBaru= httpFilterPost("reqJabatanBaru");

		$kenaikan_jabatan->setField('PEGAWAI_ID', $reqId);
		$kenaikan_jabatan->setField('TANGGAL', OCI_SYSDATE);
		$kenaikan_jabatan->setField('DEPARTEMEN_ID_SEBELUM', $reqDepartemenLama);
		$kenaikan_jabatan->setField('JABATAN_ID_SEBELUM', $reqJabatanLama);
		$kenaikan_jabatan->setField('DEPARTEMEN_ID_SESUDAH', $reqDepartemenBaru);
		$kenaikan_jabatan->setField('JABATAN_ID_SESUDAH', $reqJabatanBaru);

		if($kenaikan_jabatan->insert())
		{
			$UserLoginBase->updateByQuery("UPDATE PPI.USER_LOGIN 
				SET USER_GROUP_ID = (
					SELECT USER_GROUP_ID FROM PPI.USER_GROUP 
					WHERE DEPARTEMEN_ID = '".$reqDepartemenBaru."' 
					AND ((SELECT KELAS FROM PPI_SIMPEG.JABATAN WHERE JABATAN_ID = '". $reqJabatanBaru ."') BETWEEN PEGAWAI_KELAS_MAX AND PEGAWAI_KELAS_MIN) AND ROWNUM = 1
				),
				LAST_UPDATE_DATE = SYSDATE, 
				LAST_UPDATE_USER = '". $userLogin->pegawaiId ."' 
				WHERE PEGAWAI_ID = " . $reqId );
			echo "Data berhasil disimpan.";
		}
	}

	
	function pegawai_add_usulan_kenaikan_jabatan_realisasi()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPenghasilan.php");
		include_once("../WEB-INF/classes/base-simpeg/KenaikanJabatan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

		$pegawai_penghasilan = new PegawaiPenghasilan();


		$reqId = httpFilterPost("reqId");
		$reqKenaikanJabatanId = httpFilterPost("reqKenaikanJabatanId");
		$reqDepartemenId = httpFilterPost("reqDepartemenId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqTMTPenghasilan= httpFilterPost("reqTMTPenghasilan");
		$reqPeriode= httpFilterPost("reqPeriode");
		$reqKelas= httpFilterPost("reqKelas");
		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqPejabat= httpFilterPost("reqPejabat");
		$reqTahun= httpFilterPost("reqTahun");
		$reqBulan= httpFilterPost("reqBulan");
		$reqJumlahPenghasilan= httpFilterPost("reqJumlahPenghasilan");
		$reqJumlahTPP= httpFilterPost("reqJumlahTPP");
		$reqJumlahTunjanganJabatan= httpFilterPost("reqJumlahTunjanganJabatan");
		$reqJumlahTunjanganSelisih= httpFilterPost("reqJumlahTunjanganSelisih");
		$reqJumlahTransportasi= httpFilterPost("reqJumlahTransportasi");
		$reqJumlahUangMakan= httpFilterPost("reqJumlahUangMakan");
		$reqJumlahInsentif= httpFilterPost("reqJumlahInsentif");
		$reqProsentasePenghasilan= httpFilterPost("reqProsentasePenghasilan");
		$reqProsentaseTunjanganJabatan= httpFilterPost("reqProsentaseTunjanganJabatan");

		$reqProsentaseUangMakan= httpFilterPost("reqProsentaseUangMakan");
		$reqProsentaseTransportasi= httpFilterPost("reqProsentaseTransportasi");
		$reqProsentaseInsentif= httpFilterPost("reqProsentaseInsentif");

		$reqJumlahUangKehadiran= httpFilterPost("reqJumlahUangKehadiran");
		$reqProsentaseUangKehadiran= httpFilterPost("reqProsentaseUangKehadiran");
		$reqProsentaseTPP= httpFilterPost("reqProsentaseTPP");

		$reqKelasP3= httpFilterPost("reqKelasP3");
		$reqPeriodeP3= httpFilterPost("reqPeriodeP3");
		$reqJumlahP3= httpFilterPost("reqJumlahP3");

		$reqJumlahMobilitas= httpFilterPost("reqJumlahMobilitas");
		$reqProsentaseMobilitas = httpFilterPost("reqProsentaseMobilitas");
		$reqJumlahPerumahan = httpFilterPost("reqJumlahPerumahan");
		$reqProsentasePerumahan = httpFilterPost("reqProsentasePerumahan");
		$reqJumlahBBM = httpFilterPost("reqJumlahBBM");
		$reqProsentaseBBM = httpFilterPost("reqProsentaseBBM");
		$reqJumlahTelepon = httpFilterPost("reqJumlahTelepon");
		$reqProsentaseTelepon = httpFilterPost("reqProsentaseTelepon");
		$reqNoSKMPP= httpFilterPost("reqNoSKMPP");
		$reqTMTMPP= httpFilterPost("reqTMTMPP");
		$reqJabatanId = httpFilterPost("reqJabatanId");


		$pegawai_penghasilan->setField('PROSENTASE_TPP', $reqProsentaseTPP);

		$pegawai_penghasilan->setField('JUMLAH_P3', setNULL(dotToNo($reqJumlahP3)));
		$pegawai_penghasilan->setField('KELAS_P3', setNULL($reqKelasP3));
		$pegawai_penghasilan->setField('PERIODE_P3', setNULL($reqPeriodeP3));

		$pegawai_penghasilan->setField('KELAS', $reqKelas);
		$pegawai_penghasilan->setField('TMT_PENGHASILAN', dateToDBCheck($reqTMTPenghasilan));
		$pegawai_penghasilan->setField('PERIODE', $reqPeriode);
		$pegawai_penghasilan->setField('NO_SK', $reqNoSK);
		$pegawai_penghasilan->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
		$pegawai_penghasilan->setField('PEJABAT_PENETAP_ID', $reqPejabat);
		$pegawai_penghasilan->setField('MASA_KERJA_TAHUN', $reqTahun);
		$pegawai_penghasilan->setField('MASA_KERJA_BULAN', $reqBulan);
		$pegawai_penghasilan->setField('JUMLAH_PENGHASILAN', dotToNo($reqJumlahPenghasilan));
		$pegawai_penghasilan->setField('JUMLAH_TPP', dotToNo($reqJumlahTPP));
		$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_JABATAN', dotToNo($reqJumlahTunjanganJabatan));
		$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_SELISIH', dotToNo($reqJumlahTunjanganSelisih));
		$pegawai_penghasilan->setField('JUMLAH_TRANSPORTASI', dotToNo($reqJumlahTransportasi));
		$pegawai_penghasilan->setField('JUMLAH_UANG_MAKAN', dotToNo($reqJumlahUangMakan));
		$pegawai_penghasilan->setField('JUMLAH_INSENTIF', dotToNo($reqJumlahInsentif));
		$pegawai_penghasilan->setField('PROSENTASE_PENGHASILAN', $reqProsentasePenghasilan);
		$pegawai_penghasilan->setField('PROSENTASE_TUNJANGAN_JABATAN', $reqProsentaseTunjanganJabatan);

		$pegawai_penghasilan->setField('PROSENTASE_UANG_MAKAN', $reqProsentaseUangMakan);
		$pegawai_penghasilan->setField('PROSENTASE_TRANSPORTASI', $reqProsentaseTransportasi);
		$pegawai_penghasilan->setField('PROSENTASE_INSENTIF', $reqProsentaseInsentif);

		$pegawai_penghasilan->setField('JUMLAH_UANG_KEHADIRAN', dotToNo($reqJumlahUangKehadiran));
		$pegawai_penghasilan->setField('PROSENTASE_UANG_KEHADIRAN', $reqProsentaseUangKehadiran);

		$pegawai_penghasilan->setField('PEGAWAI_PENGHASILAN_ID', $reqRowId);
		$pegawai_penghasilan->setField('PEGAWAI_ID', $reqId);

		$pegawai_penghasilan->setField('JUMLAH_MOBILITAS', dotToNo($reqJumlahMobilitas));
		$pegawai_penghasilan->setField('PROSENTASE_MOBILITAS', $reqProsentaseMobilitas);
		$pegawai_penghasilan->setField('JUMLAH_PERUMAHAN',  dotToNo($reqJumlahPerumahan));
		$pegawai_penghasilan->setField('PROSENTASE_PERUMAHAN', $reqProsentasePerumahan);
		$pegawai_penghasilan->setField('JUMLAH_BBM', dotToNo($reqJumlahBBM));
		$pegawai_penghasilan->setField('PROSENTASE_BBM', $reqProsentaseBBM);
		$pegawai_penghasilan->setField('JUMLAH_TELEPON', dotToNo($reqJumlahTelepon));
		$pegawai_penghasilan->setField('PROSENTASE_TELEPON', $reqProsentaseTelepon);
		$pegawai_penghasilan->setField('KETERANGAN_PERUBAHAN', 'Kenaikan Jabatan');


		if($reqMode == "insert")
		{
			$pegawai_penghasilan->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_penghasilan->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			if($pegawai_penghasilan->insert()){
				$reqRowId= $pegawai_penghasilan->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;	
				
				$pegawai_jabatan = new PegawaiJabatan();
				$pegawai_jabatan->setField('PEGAWAI_ID', $reqId);
				$pegawai_jabatan->setField('JABATAN_ID', $reqJabatanId);
				$pegawai_jabatan->setField('DEPARTEMEN_ID', $reqDepartemenId);
				$pegawai_jabatan->setField('CABANG_ID', '1');
				$pegawai_jabatan->setField('PEJABAT_PENETAP_ID', $reqPejabat);
				$pegawai_jabatan->setField('NO_SK', $reqNoSK);
				$pegawai_jabatan->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
				$pegawai_jabatan->setField('TMT_JABATAN', dateToDBCheck($reqTMTPenghasilan));
				$pegawai_jabatan->setField('KETERANGAN', '');
				$pegawai_jabatan->setField("LAST_CREATE_USER", $userLogin->nama);
				$pegawai_jabatan->setField("LAST_CREATE_DATE", OCI_SYSDATE);
				if($pegawai_jabatan->insert())
				{
					$kenaikan_jabatan = new KenaikanJabatan();
					$kenaikan_jabatan->setField("KENAIKAN_JABATAN_ID", $reqKenaikanJabatanId);
					$kenaikan_jabatan->setField("STATUS", 1);
					$kenaikan_jabatan->updateStatus();
					
				}
				
				$pegawai = new Pegawai();
				$pegawai->setField('DEPARTEMEN_ID',$reqDepartemenId);
				$pegawai->setField('LAST_UPDATE_USER',$userLogin->nama);
				$pegawai->setField('LAST_UPDATE_DATE',OCI_SYSDATE);
				$pegawai->setField('PEGAWAI_ID',$reqId);
				$pegawai->updateDepartemen();
			}
			//echo $pegawai_penghasilan->query;
		}
	}

	
	function pegawai_cuti_tahunan_pencarian_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

		$pegawai = new Pegawai();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqStatusPegawai= httpFilterGet("reqStatusPegawai");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA", "LAMA_CUTI", "JABATAN", "DEPARTEMEN");
		$aColumnsAlias = array("A.PEGAWAI_ID", "NRP", "NAMA", "LAMA_CUTI", "JABATAN", "DEPARTEMEN");

		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = " ORDER BY ";
			 
			//Go over all sorting cols
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				//If need to sort by current col
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					//Add to the order by clause
					$sOrder .= $aColumnsAlias[ intval( $_GET['iSortCol_'.$i] ) ];
					 
					//Determine if it is sorted asc or desc
					if (strcasecmp(( $_GET['sSortDir_'.$i] ), "asc") == 0)
					{
						$sOrder .=" asc, ";
					}else
					{
						$sOrder .=" desc, ";
					}
				}
			}
			
			 
			//Remove the last space / comma
			$sOrder = substr_replace( $sOrder, "", -2 );
			
			//Check if there is an order by clause
			if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				//$sOrder = " ORDER BY PEGAWAI_ID DESC";
				$sOrder = " ORDER BY TO_NUMBER(B.KELAS) ASC, TO_NUMBER(B.NO_URUT) ASC";
			}
		}
		 
		 
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables.
		 */
		$sWhere = "";
		$nWhereGenearalCount = 0;
		if (isset($_GET['sSearch']))
		{
			$sWhereGenearal = $_GET['sSearch'];
		}
		else
		{
			$sWhereGenearal = '';
		}

		if ( $_GET['sSearch'] != "" )
		{
			//Set a default where clause in order for the where clause not to fail
			//in cases where there are no searchable cols at all.
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumnsAlias)+1 ; $i++ )
			{
				//If current col has a search param
				if ( $_GET['bSearchable_'.$i] == "true" )
				{
					//Add the search to the where clause
					$sWhere .= $aColumnsAlias[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
					$nWhereGenearalCount += 1;
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		 
		/* Individual column filtering */
		$sWhereSpecificArray = array();
		$sWhereSpecificArrayCount = 0;
		for ( $i=0 ; $i<count($aColumnsAlias) ; $i++ )
		{
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				//If there was no where clause
				if ( $sWhere == "" )
				{
					$sWhere = "AND ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				 
				//Add the clause of the specific col to the where clause
				$sWhere .= $aColumnsAlias[$i]." LIKE '%' || :whereSpecificParam".$sWhereSpecificArrayCount." || '%' ";
				 
				//Inc sWhereSpecificArrayCount. It is needed for the bind var.
				//We could just do count($sWhereSpecificArray) - but that would be less efficient.
				$sWhereSpecificArrayCount++;
				 
				//Add current search param to the array for later use (binding).
				$sWhereSpecificArray[] =  $_GET['sSearch_'.$i];
				 
			}
		}
		 
		//If there is still no where clause - set a general - always true where clause
		if ( $sWhere == "" )
		{
			$sWhere = " AND 1=1";
		}
		//Bind variables.
		if ( isset( $_GET['iDisplayStart'] ))
		{
			$dsplyStart = $_GET['iDisplayStart'];
		}
		else{
			$dsplyStart = 0;
		}
		 
		if ( isset( $_GET['iDisplayLength'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$dsplyRange = $_GET['iDisplayLength'];
			if ($dsplyRange > (2147483645 - intval($dsplyStart)))
			{
				$dsplyRange = 2147483645;
			}
			else
			{
				$dsplyRange = intval($dsplyRange);
			}
		}
		else
		{
			$dsplyRange = 2147483645;
		}

		if($reqJenisPegawai == "")
			$statement .= "";
		else
			$statement .= "AND D.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;

		$allRecord = $pegawai->getCountByParamsCutiTahunan(array(),$statement);
		//echo $pegawai->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $pegawai->getCountByParamsCutiTahunan(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ");

		//echo $pegawai->query;
		$pegawai->selectByParamsCutiTahunan(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder);
		//" AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') AND (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%') "

		//echo $pegawai->query;

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($pegawai->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($pegawai->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($pegawai->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $pegawai->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

	
	function pegawai_gaji_berkala_add_penghasilan()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPenghasilan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai_penghasilan = new PegawaiPenghasilan();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqTMTPenghasilan= httpFilterPost("reqTMTPenghasilan");
		$reqPeriode= httpFilterPost("reqPeriode");
		$reqKelas= httpFilterPost("reqKelas");
		$reqNoSK= httpFilterPost("reqNoSK");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqPejabat= httpFilterPost("reqPejabat");
		$reqTahun= httpFilterPost("reqTahun");
		$reqBulan= httpFilterPost("reqBulan");
		$reqJumlahPenghasilan= httpFilterPost("reqJumlahPenghasilan");
		$reqJumlahTPP= httpFilterPost("reqJumlahTPP");
		$reqJumlahTunjanganJabatan= httpFilterPost("reqJumlahTunjanganJabatan");
		$reqJumlahTunjanganSelisih= httpFilterPost("reqJumlahTunjanganSelisih");
		$reqJumlahTransportasi= httpFilterPost("reqJumlahTransportasi");
		$reqJumlahUangMakan= httpFilterPost("reqJumlahUangMakan");
		$reqJumlahInsentif= httpFilterPost("reqJumlahInsentif");
		$reqProsentasePenghasilan= httpFilterPost("reqProsentasePenghasilan");
		$reqProsentaseTunjanganJabatan= httpFilterPost("reqProsentaseTunjanganJabatan");

		$reqProsentaseUangMakan= httpFilterPost("reqProsentaseUangMakan");
		$reqProsentaseTransportasi= httpFilterPost("reqProsentaseTransportasi");
		$reqProsentaseInsentif= httpFilterPost("reqProsentaseInsentif");

		$reqJumlahUangKehadiran= httpFilterPost("reqJumlahUangKehadiran");
		$reqProsentaseUangKehadiran= httpFilterPost("reqProsentaseUangKehadiran");
		$reqProsentaseTPP= httpFilterPost("reqProsentaseTPP");

		$reqKelasP3= httpFilterPost("reqKelasP3");
		$reqPeriodeP3= httpFilterPost("reqPeriodeP3");
		$reqJumlahP3= httpFilterPost("reqJumlahP3");

		$reqJumlahMobilitas= httpFilterPost("reqJumlahMobilitas");
		$reqProsentaseMobilitas = httpFilterPost("reqProsentaseMobilitas");
		$reqJumlahPerumahan = httpFilterPost("reqJumlahPerumahan");
		$reqProsentasePerumahan = httpFilterPost("reqProsentasePerumahan");
		$reqJumlahBBM = httpFilterPost("reqJumlahBBM");
		$reqProsentaseBBM = httpFilterPost("reqProsentaseBBM");
		$reqJumlahTelepon = httpFilterPost("reqJumlahTelepon");
		$reqProsentaseTelepon = httpFilterPost("reqProsentaseTelepon");

		$pegawai_penghasilan->setField('PROSENTASE_TPP', $reqProsentaseTPP);

		$pegawai_penghasilan->setField('JUMLAH_P3', setNULL(dotToNo($reqJumlahP3)));
		$pegawai_penghasilan->setField('KELAS_P3', setNULL($reqKelasP3));
		$pegawai_penghasilan->setField('PERIODE_P3', setNULL($reqPeriodeP3));

		$pegawai_penghasilan->setField('KELAS', $reqKelas);
		$pegawai_penghasilan->setField('TMT_PENGHASILAN', dateToDBCheck($reqTMTPenghasilan));
		$pegawai_penghasilan->setField('PERIODE', $reqPeriode);
		$pegawai_penghasilan->setField('NO_SK', $reqNoSK);
		$pegawai_penghasilan->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
		$pegawai_penghasilan->setField('PEJABAT_PENETAP_ID', $reqPejabat);
		$pegawai_penghasilan->setField('MASA_KERJA_TAHUN', $reqTahun);
		$pegawai_penghasilan->setField('MASA_KERJA_BULAN', $reqBulan);
		$pegawai_penghasilan->setField('JUMLAH_PENGHASILAN', dotToNo($reqJumlahPenghasilan));
		$pegawai_penghasilan->setField('JUMLAH_TPP', dotToNo($reqJumlahTPP));
		$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_JABATAN', dotToNo($reqJumlahTunjanganJabatan));
		$pegawai_penghasilan->setField('JUMLAH_TUNJANGAN_SELISIH', dotToNo($reqJumlahTunjanganSelisih));
		$pegawai_penghasilan->setField('JUMLAH_TRANSPORTASI', dotToNo($reqJumlahTransportasi));
		$pegawai_penghasilan->setField('JUMLAH_UANG_MAKAN', dotToNo($reqJumlahUangMakan));
		$pegawai_penghasilan->setField('JUMLAH_INSENTIF', dotToNo($reqJumlahInsentif));
		$pegawai_penghasilan->setField('PROSENTASE_PENGHASILAN', $reqProsentasePenghasilan);
		$pegawai_penghasilan->setField('PROSENTASE_TUNJANGAN_JABATAN', $reqProsentaseTunjanganJabatan);

		$pegawai_penghasilan->setField('PROSENTASE_UANG_MAKAN', $reqProsentaseUangMakan);
		$pegawai_penghasilan->setField('PROSENTASE_TRANSPORTASI', $reqProsentaseTransportasi);
		$pegawai_penghasilan->setField('PROSENTASE_INSENTIF', $reqProsentaseInsentif);

		$pegawai_penghasilan->setField('JUMLAH_UANG_KEHADIRAN', dotToNo($reqJumlahUangKehadiran));
		$pegawai_penghasilan->setField('PROSENTASE_UANG_KEHADIRAN', $reqProsentaseUangKehadiran);

		$pegawai_penghasilan->setField('PEGAWAI_PENGHASILAN_ID', $reqRowId);
		$pegawai_penghasilan->setField('PEGAWAI_ID', $reqId);

		$pegawai_penghasilan->setField('JUMLAH_MOBILITAS', dotToNo($reqJumlahMobilitas));
		$pegawai_penghasilan->setField('PROSENTASE_MOBILITAS', $reqProsentaseMobilitas);
		$pegawai_penghasilan->setField('JUMLAH_PERUMAHAN',  dotToNo($reqJumlahPerumahan));
		$pegawai_penghasilan->setField('PROSENTASE_PERUMAHAN', $reqProsentasePerumahan);
		$pegawai_penghasilan->setField('JUMLAH_BBM', dotToNo($reqJumlahBBM));
		$pegawai_penghasilan->setField('PROSENTASE_BBM', $reqProsentaseBBM);
		$pegawai_penghasilan->setField('JUMLAH_TELEPON', dotToNo($reqJumlahTelepon));
		$pegawai_penghasilan->setField('PROSENTASE_TELEPON', $reqProsentaseTelepon);
		$pegawai_penghasilan->setField('KETERANGAN_PERUBAHAN', 'Kenaikan Periodik');


		if($reqMode == "insert")
		{
			$pegawai_penghasilan->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_penghasilan->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			if($pegawai_penghasilan->insert()){
				$reqRowId= $pegawai_penghasilan->id;
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_penghasilan->query;
		}
		else
		{
			$pegawai_penghasilan->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai_penghasilan->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
			if($pegawai_penghasilan->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
			//echo $pegawai_penghasilan->query;
		}
	}

	
	function pegawai_gaji_berkala_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/KenaikanGajiBerkala.php");

		$kenaikan_gaji_berkala = new KenaikanGajiBerkala();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqTahun= httpFilterGet("reqTahun");
		$reqBulan= httpFilterGet("reqBulan");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqMode = httpFilterGet("reqMode");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "PERIODE_BARU", "MKT_BARU", "MKB_BARU", "NRP", "NAMA", "KELAS", "PERIODE_LAMA", "MKT_LAMA", "MKB_LAMA", "TMT_LAMA", "PERIODE_BARU", "MKT_BARU", "MKB_BARU");
		$aColumnsAlias = array("PEGAWAI_ID", "PERIODE_BARU", "MKT_BARU", "MKB_BARU", "NRP", "NAMA", "KELAS", "PERIODE_LAMA", "MKT_LAMA", "MKB_LAMA", "TMT_LAMA", "PERIODE_BARU", "MKT_BARU", "MKB_BARU");

		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = " ORDER BY ";
			 
			//Go over all sorting cols
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				//If need to sort by current col
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					//Add to the order by clause
					$sOrder .= $aColumnsAlias[ intval( $_GET['iSortCol_'.$i] ) ];
					 
					//Determine if it is sorted asc or desc
					if (strcasecmp(( $_GET['sSortDir_'.$i] ), "asc") == 0)
					{
						$sOrder .=" asc, ";
					}else
					{
						$sOrder .=" desc, ";
					}
				}
			}
			
			 
			//Remove the last space / comma
			$sOrder = substr_replace( $sOrder, "", -2 );
			
			//Check if there is an order by clause
			if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				//$sOrder = " ORDER BY PEGAWAI_ID DESC";
				$sOrder = " ORDER BY A.NAMA ASC";
			}
		}
		 
		 
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables.
		 */
		$sWhere = "";
		$nWhereGenearalCount = 0;
		if (isset($_GET['sSearch']))
		{
			$sWhereGenearal = $_GET['sSearch'];
		}
		else
		{
			$sWhereGenearal = '';
		}

		if ( $_GET['sSearch'] != "" )
		{
			//Set a default where clause in order for the where clause not to fail
			//in cases where there are no searchable cols at all.
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumnsAlias)+1 ; $i++ )
			{
				//If current col has a search param
				if ( $_GET['bSearchable_'.$i] == "true" )
				{
					//Add the search to the where clause
					$sWhere .= $aColumnsAlias[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
					$nWhereGenearalCount += 1;
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		 
		/* Individual column filtering */
		$sWhereSpecificArray = array();
		$sWhereSpecificArrayCount = 0;
		for ( $i=0 ; $i<count($aColumnsAlias) ; $i++ )
		{
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				//If there was no where clause
				if ( $sWhere == "" )
				{
					$sWhere = "AND ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				 
				//Add the clause of the specific col to the where clause
				$sWhere .= $aColumnsAlias[$i]." LIKE '%' || :whereSpecificParam".$sWhereSpecificArrayCount." || '%' ";
				 
				//Inc sWhereSpecificArrayCount. It is needed for the bind var.
				//We could just do count($sWhereSpecificArray) - but that would be less efficient.
				$sWhereSpecificArrayCount++;
				 
				//Add current search param to the array for later use (binding).
				$sWhereSpecificArray[] =  $_GET['sSearch_'.$i];
				 
			}
		}
		 
		//If there is still no where clause - set a general - always true where clause
		if ( $sWhere == "" )
		{
			$sWhere = " AND 1=1";
		}
		//Bind variables.
		if ( isset( $_GET['iDisplayStart'] ))
		{
			$dsplyStart = $_GET['iDisplayStart'];
		}
		else{
			$dsplyStart = 0;
		}
		 
		if ( isset( $_GET['iDisplayLength'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$dsplyRange = $_GET['iDisplayLength'];
			if ($dsplyRange > (2147483645 - intval($dsplyStart)))
			{
				$dsplyRange = 2147483645;
			}
			else
			{
				$dsplyRange = intval($dsplyRange);
			}
		}
		else
		{
			$dsplyRange = 2147483645;
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		if($reqStatusPegawai == '')
			$statement .= 'AND A.STATUS_PEGAWAI_ID = 1';
		else
			$statement .= 'AND A.STATUS_PEGAWAI_ID = '.$reqStatusPegawai;

		if($reqJenisPegawai == "")
			$statement .= "";
		else
			$statement .= "AND C.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;
			
		$statement .= " AND PERIODE_PROSES = '".$reqBulan.$reqTahun."' ";

		if($reqMode == "proses")
		{
			$kenaikan_gaji_berkala_proses = new KenaikanGajiBerkala();
			$kenaikan_gaji_berkala_proses->setField("PERIODE", $reqBulan.$reqTahun);
			$kenaikan_gaji_berkala_proses->callProsesKGB();		
			unset($kenaikan_gaji_berkala_proses);
				
		}

		$allRecord = $kenaikan_gaji_berkala->getCountByParams(array(), $statement);
		//echo $kenaikan_gaji_berkala->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $kenaikan_gaji_berkala->getCountByParams(array(), $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' ");

		//echo $kenaikan_gaji_berkala->query;
		$kenaikan_gaji_berkala->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' ", $sOrder);

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($kenaikan_gaji_berkala->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TMT_LAMA")
					$row[] = getFormattedDate($kenaikan_gaji_berkala->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($kenaikan_gaji_berkala->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $kenaikan_gaji_berkala->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

	
	function pegawai_jabatan_tools()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* create objects */

		$pegawai = new Pegawai();
		$pegawai_jabatan = new PegawaiJabatan();
		$pegawai_jabatan_terakhir = new PegawaiJabatan();

		$reqId = httpFilterGet("reqId");
		$reqTanggal = httpFilterGet("reqTanggal");
		$reqDepartemen = httpFilterGet("reqDepartemen");


		$pegawai_jabatan->setField("DEPARTEMEN_ID", $reqDepartemen);
		$pegawai_jabatan->setField("TMT_JABATAN", dateToDBCheck($reqTanggal));
		$pegawai_jabatan->setField("PEGAWAI_JABATAN_ID", $reqId);
		$pegawai_jabatan->updateTools();

		$pegawai_jabatan_terakhir->selectByParamsToolsJabatanTerakhir(array("PEGAWAI_JABATAN_ID" => $reqId));
		$pegawai_jabatan_terakhir->firstRow();

		if($pegawai_jabatan_terakhir->getField("PEGAWAI_JABATAN_ID") == $reqId)
		{

			$pegawai->setField("DEPARTEMEN_ID", $reqDepartemen);
			$pegawai->setField("LAST_UPDATE_USER", "PERBAIKAN DATA");
			$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			$pegawai->setField("PEGAWAI_ID", $pegawai_jabatan_terakhir->getField("PEGAWAI_ID"));
			$pegawai->updateDepartemen();
		}

		$met = array();
		$i=0;

		$met[0]['STATUS'] = 1;
		echo json_encode($met);
	}

	
	function json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

		$pegawai = new Pegawai();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqStatusPegawai= httpFilterGet("reqStatusPegawai");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqKelompok = httpFilterGet("reqKelompok");
		$reqPeriode = httpFilterGet("reqPeriode");

		$reqPeriode = ($reqPeriode == '') ? date('dmY') : $reqPeriode;

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA", "JABATAN_NAMA", "KELAS", "TANGGAL_KONTRAK_AWAL", "TANGGAL_KONTRAK_AKHIR", "MKP", "DEPARTEMEN", "PENDIDIKAN_TERAKHIR", "JENIS_KELAMIN", "TANGGAL_LAHIR","UMUR", "ZODIAC", "STATUS_KAWIN", "STATUS_PEGAWAI_NAMA", "GOLONGAN_DARAH", "ALAMAT", "TELEPON", "EMAIL", "HOBBY", "NIS", "STATUS_PEGAWAI_ID", "JENIS_PEGAWAI_ID");
		$aColumnsAlias = array("A.PEGAWAI_ID", "F.NRP", "F.NAMA", "E.NAMA", "E.KELAS", "J.TANGGAL_AWAL", "J.TANGAL_AKHIR", "B.TMT_JENIS_PEGAWAI", "DEPARTEMEN", "PENDIDIKAN_TERAKHIR", "JENIS_KELAMIN", "TANGGAL_LAHIR", "UMUR", "STATUS_KAWIN", "H.NAMA", "GOLONGAN_DARAH", "ALAMAT", "TELEPON", "EMAIL", "HOBBY", "F.NIS", "STATUS_PEGAWAI_ID", "JENIS_PEGAWAI_ID");

		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = " ORDER BY ";
			 
			//Go over all sorting cols
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				//If need to sort by current col
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					//Add to the order by clause
					$sOrder .= $aColumnsAlias[ intval( $_GET['iSortCol_'.$i] ) ];
					 
					//Determine if it is sorted asc or desc
					if (strcasecmp(( $_GET['sSortDir_'.$i] ), "asc") == 0)
					{
						$sOrder .=" asc, ";
					}else
					{
						$sOrder .=" desc, ";
					}
				}
			}
			
			 
			//Remove the last space / comma
			$sOrder = substr_replace( $sOrder, "", -2 );
			
			//Check if there is an order by clause
			if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				//$sOrder = " ORDER BY PEGAWAI_ID DESC";
				$sOrder = " ORDER BY TO_NUMBER(E.KELAS) ASC, TO_NUMBER(E.NO_URUT) ASC";
			}
		}
		 
		 
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables.
		 */
		$sWhere = "";
		$nWhereGenearalCount = 0;
		if (isset($_GET['sSearch']))
		{
			$sWhereGenearal = $_GET['sSearch'];
		}
		else
		{
			$sWhereGenearal = '';
		}

		if ( $_GET['sSearch'] != "" )
		{
			//Set a default where clause in order for the where clause not to fail
			//in cases where there are no searchable cols at all.
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumnsAlias)+1 ; $i++ )
			{
				//If current col has a search param
				if ( $_GET['bSearchable_'.$i] == "true" )
				{
					//Add the search to the where clause
					$sWhere .= $aColumnsAlias[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
					$nWhereGenearalCount += 1;
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		 
		/* Individual column filtering */
		$sWhereSpecificArray = array();
		$sWhereSpecificArrayCount = 0;
		for ( $i=0 ; $i<count($aColumnsAlias) ; $i++ )
		{
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				//If there was no where clause
				if ( $sWhere == "" )
				{
					$sWhere = "AND ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				 
				//Add the clause of the specific col to the where clause
				$sWhere .= $aColumnsAlias[$i]." LIKE '%' || :whereSpecificParam".$sWhereSpecificArrayCount." || '%' ";
				 
				//Inc sWhereSpecificArrayCount. It is needed for the bind var.
				//We could just do count($sWhereSpecificArray) - but that would be less efficient.
				$sWhereSpecificArrayCount++;
				 
				//Add current search param to the array for later use (binding).
				$sWhereSpecificArray[] =  $_GET['sSearch_'.$i];
				 
			}
		}
		 
		//If there is still no where clause - set a general - always true where clause
		if ( $sWhere == "" )
		{
			$sWhere = " AND 1=1";
		}
		//Bind variables.
		if ( isset( $_GET['iDisplayStart'] ))
		{
			$dsplyStart = $_GET['iDisplayStart'];
		}
		else{
			$dsplyStart = 0;
		}
		 
		if ( isset( $_GET['iDisplayLength'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$dsplyRange = $_GET['iDisplayLength'];
			if ($dsplyRange > (2147483645 - intval($dsplyStart)))
			{
				$dsplyRange = 2147483645;
			}
			else
			{
				$dsplyRange = intval($dsplyRange);
			}
		}
		else
		{
			$dsplyRange = 2147483645;
		}

		if(substr($reqDepartemen, 0, 3) == "CAB"){}

			/*if($reqJenisPegawai == 4 )
				$statement = " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE ((D.DEPARTEMEN_ID = X.DEPARTEMEN_ID OR F.DEPARTEMEN_ID = X.DEPARTEMEN_ID) AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') OR D.DEPARTEMEN_ID IS NULL) ";
			else if($reqStatusPegawai != 1)
				$statement = " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE F.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
			
			else 
				$statement = " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE (D.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') OR D.DEPARTEMEN_ID IS NULL ) ";
				*/
		else
			$statement = " AND D.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		if($reqStatusPegawai == '')
			$statement .= 'AND F.STATUS_PEGAWAI_ID = 1';
		else
			$statement .= 'AND F.STATUS_PEGAWAI_ID = '.$reqStatusPegawai;

		if($reqJenisPegawai == "")
			$statement .= " AND NOT NVL(B.JENIS_PEGAWAI_ID, 1) = 8 ";
		else
			$statement .= "AND (B.JENIS_PEGAWAI_ID = ".$reqJenisPegawai . " OR B.JENIS_PEGAWAI_ID IS NULL)";
			
		$allRecord = $pegawai->getCountByParamsNew(array(),$statement, $reqPeriode);
		//echo $pegawai->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $pegawai->getCountByParamsNew(array(), $statement." AND ((UPPER(F.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(F.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

		//echo $pegawai->query;
		$pegawai->selectByParamsNew(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(F.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(F.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder, $reqPeriode, $reqStatusPegawai);
		//" AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') AND (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%') "

		//echo $pegawai->query;

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($pegawai->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{

				if($aColumns[$i] == "TANGGAL_LAHIR" || $aColumns[$i] == "TANGGAL_KONTRAK_AWAL" || $aColumns[$i] == "TANGGAL_KONTRAK_AKHIR")
					$row[] = getFormattedDate($pegawai->getField($aColumns[$i]));
				else if($aColumns[$i] == "ZODIAC")
					$row[] = getZodiac((int)getDay($pegawai->getField("TANGGAL_LAHIR")), (int)getMonth($pegawai->getField("TANGGAL_LAHIR")));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($pegawai->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $pegawai->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

	
	function pegawai_json_set_mpp()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* create objects */

		$pegawai = new Pegawai();

		$reqId = httpFilterGet("reqId");
		$reqNilai = httpFilterGet("reqNilai");

		/* LOGIN CHECK 
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}
		*/
			$pegawai->setField('PEGAWAI_ID', $reqId);
			$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			$pegawai->updateStatusMPP();
			
			if($pegawai->updateStatusMPP())
			{
				$alertMsg .= "Data berhasil diubah";
			}
			else
				$alertMsg .= "Error ".$pegawai->getErrorMsg();
	}

	
	function pegawai_json_OLD()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

		$pegawai = new Pegawai();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqStatusPegawai= httpFilterGet("reqStatusPegawai");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqKelompok = httpFilterGet("reqKelompok");
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA", "JABATAN_NAMA", "KELAS", "TANGGAL_KONTRAK_AWAL", "TANGGAL_KONTRAK_AKHIR", "MKP", "DEPARTEMEN", "PENDIDIKAN_TERAKHIR", "JENIS_KELAMIN", "TANGGAL_LAHIR","UMUR", "ZODIAC", "STATUS_KAWIN", "STATUS_PEGAWAI_NAMA", "GOLONGAN_DARAH", "ALAMAT", "TELEPON", "EMAIL", "HOBBY", "NIS", "STATUS_PEGAWAI_ID", "JENIS_PEGAWAI_ID");
		$aColumnsAlias = array("A.PEGAWAI_ID", "NRP", "A.NAMA", "D.NAMA", "D.KELAS", "G.TANGGAL_KONTRAK_AWAL", "G.TANGGAL_KONTRAK_AKHIR", "MASA_KERJA_TAHUN", "DEPARTEMEN", "PENDIDIKAN_TERAKHIR", "JENIS_KELAMIN", "TANGGAL_LAHIR", "UMUR", "STATUS_KAWIN", "E.NAMA", "GOLONGAN_DARAH", "ALAMAT", "TELEPON", "EMAIL", "HOBBY", "A.NIS", "STATUS_PEGAWAI_ID", "JENIS_PEGAWAI_ID");

		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = " ORDER BY ";
			 
			//Go over all sorting cols
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				//If need to sort by current col
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					//Add to the order by clause
					$sOrder .= $aColumnsAlias[ intval( $_GET['iSortCol_'.$i] ) ];
					 
					//Determine if it is sorted asc or desc
					if (strcasecmp(( $_GET['sSortDir_'.$i] ), "asc") == 0)
					{
						$sOrder .=" asc, ";
					}else
					{
						$sOrder .=" desc, ";
					}
				}
			}
			
			 
			//Remove the last space / comma
			$sOrder = substr_replace( $sOrder, "", -2 );
			
			//Check if there is an order by clause
			if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				//$sOrder = " ORDER BY PEGAWAI_ID DESC";
				$sOrder = " ORDER BY TO_NUMBER(D.KELAS) ASC, TO_NUMBER(D.NO_URUT) ASC";
			}
		}
		 
		 
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables.
		 */
		$sWhere = "";
		$nWhereGenearalCount = 0;
		if (isset($_GET['sSearch']))
		{
			$sWhereGenearal = $_GET['sSearch'];
		}
		else
		{
			$sWhereGenearal = '';
		}

		if ( $_GET['sSearch'] != "" )
		{
			//Set a default where clause in order for the where clause not to fail
			//in cases where there are no searchable cols at all.
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumnsAlias)+1 ; $i++ )
			{
				//If current col has a search param
				if ( $_GET['bSearchable_'.$i] == "true" )
				{
					//Add the search to the where clause
					$sWhere .= $aColumnsAlias[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
					$nWhereGenearalCount += 1;
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		 
		/* Individual column filtering */
		$sWhereSpecificArray = array();
		$sWhereSpecificArrayCount = 0;
		for ( $i=0 ; $i<count($aColumnsAlias) ; $i++ )
		{
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				//If there was no where clause
				if ( $sWhere == "" )
				{
					$sWhere = "AND ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				 
				//Add the clause of the specific col to the where clause
				$sWhere .= $aColumnsAlias[$i]." LIKE '%' || :whereSpecificParam".$sWhereSpecificArrayCount." || '%' ";
				 
				//Inc sWhereSpecificArrayCount. It is needed for the bind var.
				//We could just do count($sWhereSpecificArray) - but that would be less efficient.
				$sWhereSpecificArrayCount++;
				 
				//Add current search param to the array for later use (binding).
				$sWhereSpecificArray[] =  $_GET['sSearch_'.$i];
				 
			}
		}
		 
		//If there is still no where clause - set a general - always true where clause
		if ( $sWhere == "" )
		{
			$sWhere = " AND 1=1";
		}
		//Bind variables.
		if ( isset( $_GET['iDisplayStart'] ))
		{
			$dsplyStart = $_GET['iDisplayStart'];
		}
		else{
			$dsplyStart = 0;
		}
		 
		if ( isset( $_GET['iDisplayLength'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$dsplyRange = $_GET['iDisplayLength'];
			if ($dsplyRange > (2147483645 - intval($dsplyStart)))
			{
				$dsplyRange = 2147483645;
			}
			else
			{
				$dsplyRange = intval($dsplyRange);
			}
		}
		else
		{
			$dsplyRange = 2147483645;
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		if($reqStatusPegawai == '')
			$statement .= 'AND A.STATUS_PEGAWAI_ID = 1';
		else
			$statement .= 'AND A.STATUS_PEGAWAI_ID = '.$reqStatusPegawai;

		if($reqJenisPegawai == "")
			$statement .= " AND NOT NVL(G.JENIS_PEGAWAI_ID, 1) = 8 ";
		else
			$statement .= "AND G.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;

		if($reqKelompok == "")
			$statement .= "";
		else
			$statement .= "AND KELOMPOK = '".$reqKelompok."'";

			
		$allRecord = $pegawai->getCountByParams(array(),$statement);
		//echo $pegawai->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $pegawai->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ");

		//echo $pegawai->query;
		$pegawai->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder);
		//" AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') AND (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%') "

		//echo $pegawai->query;

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($pegawai->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{

				if($aColumns[$i] == "TANGGAL_LAHIR" || $aColumns[$i] == "TANGGAL_KONTRAK_AWAL" || $aColumns[$i] == "TANGGAL_KONTRAK_AKHIR")
					$row[] = getFormattedDate($pegawai->getField($aColumns[$i]));
				else if($aColumns[$i] == "ZODIAC")
					$row[] = getZodiac((int)getDay($pegawai->getField("TANGGAL_LAHIR")), (int)getMonth($pegawai->getField("TANGGAL_LAHIR")));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($pegawai->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $pegawai->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

	
	function pegawai_kadet_add_data()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai = new Pegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqNPP= httpFilterPost("reqNPP");
		$reqNama= httpFilterPost("reqNama");
		$reqAgamaId= httpFilterPost("reqAgamaId");
		$reqJenisKelamin= httpFilterPost("reqJenisKelamin");
		$reqAsalPelabuhanId= httpFilterPost("reqAsalPelabuhanId");
		$reqDepartemen = httpFilterPost("reqDepartemen");
		$reqTempat= httpFilterPost("reqTempat");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqAlamat= httpFilterPost("reqAlamat");
		$reqTelepon== httpFilterPost("reqTelepon");
		$reqEmail= httpFilterPost("reqEmail");
		$reqNIS= httpFilterPost("reqNIS");
		$reqLinkFile = $_FILES["reqLinkFile"];

		$reqStatusPegawai= httpFilterPost("reqStatusPegawai");

		$reqKelasSekolah= httpFilterPost("reqKelasSekolah");
		$reqAsalSekolah= httpFilterPost("reqAsalSekolah");
		$reqJurusanSekolah= httpFilterPost("reqJurusanSekolah");
		$reqTanggalAwal= httpFilterPost("reqTanggalAwal");
		$reqTanggalAkhir= httpFilterPost("reqTanggalAkhir");
		$reqJenisMagang = httpFilterPost("reqJenisMagang");
		if($reqDepartemen == 0)
			$reqDepartemen = "NULL";
		else
			$reqDepartemen = "'".$reqDepartemen."'";

		$pegawai->setField("DEPARTEMEN_ID", $reqDepartemen);
		$pegawai->setField("NIS", $reqNIS);
		$pegawai->setField("NAMA", $reqNama);
		$pegawai->setField("AGAMA_ID", $reqAgamaId);
		$pegawai->setField("JENIS_KELAMIN", $reqJenisKelamin);
		$pegawai->setField("TEMPAT_LAHIR", $reqTempat);
		$pegawai->setField("TANGGAL_LAHIR", dateToDBCheck($reqTanggal));
		$pegawai->setField("ALAMAT", $reqAlamat);
		$pegawai->setField("TELEPON", $reqTelepon);
		$pegawai->setField("EMAIL", $reqEmail);
		$pegawai->setField("STATUS_PEGAWAI_ID", "1");
		$pegawai->setField("MAGANG_TIPE", $reqJenisMagang);
				
		if($reqMode == "insert")
		{
			$pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	

			if($pegawai->insertKadet())
			{
				$id = $pegawai->id;
				
				if($reqLinkFile['tmp_name'])
					$pegawai->upload("PPI_SIMPEG.PEGAWAI", "FOTO", $reqLinkFile['tmp_name'], "PEGAWAI_ID = ".$id);
				
				$pegawai_jenis_pegawai= new PegawaiJenisPegawai();
				$pegawai_jenis_pegawai->setField("KELAS_SEKOLAH",$reqKelasSekolah);
				$pegawai_jenis_pegawai->setField("ASAL_SEKOLAH",$reqAsalSekolah);
				$pegawai_jenis_pegawai->setField("JURUSAN",$reqJurusanSekolah);
				$pegawai_jenis_pegawai->setField("PEGAWAI_ID",$id);
				$pegawai_jenis_pegawai->setField("JENIS_PEGAWAI_ID",'8');
				$pegawai_jenis_pegawai->setField("TANGGAL_KONTRAK_AWAL", dateToDBCheck($reqTanggalAwal));
				$pegawai_jenis_pegawai->setField("TANGGAL_KONTRAK_AKHIR", dateToDBCheck($reqTanggalAkhir));
				$pegawai_jenis_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
				$pegawai_jenis_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
				if($pegawai_jenis_pegawai->insertKadet()){}
				
				echo $id."-Data berhasil disimpan.";
			}
		}
		else
		{
			$pegawai->setField("PEGAWAI_ID", $reqId);
			$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			if($pegawai->updateKadet())
			{
				$id = $reqId;
				
				if($reqLinkFile['tmp_name'])
					$pegawai->upload("PPI_SIMPEG.PEGAWAI", "FOTO", $reqLinkFile['tmp_name'], "PEGAWAI_ID = ".$id);
				
				$pegawai_jenis_pegawai= new PegawaiJenisPegawai();
				$pegawai_jenis_pegawai->setField("KELAS_SEKOLAH",$reqKelasSekolah);
				$pegawai_jenis_pegawai->setField("ASAL_SEKOLAH",$reqAsalSekolah);
				$pegawai_jenis_pegawai->setField("JURUSAN",$reqJurusanSekolah);
				$pegawai_jenis_pegawai->setField("PEGAWAI_JENIS_PEGAWAI_ID",$reqRowId);
				$pegawai_jenis_pegawai->setField("TANGGAL_KONTRAK_AWAL", dateToDBCheck($reqTanggalAwal));
				$pegawai_jenis_pegawai->setField("TANGGAL_KONTRAK_AKHIR", dateToDBCheck($reqTanggalAkhir));
				$pegawai_jenis_pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
				$pegawai_jenis_pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
				if($pegawai_jenis_pegawai->updateKadet()){}
				
				echo $id."-Data berhasil disimpan.";
			}
		}
	}

	
	function pegawai_kenaikan_jabatan_set_tolak()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/KenaikanJabatan.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* create objects */

		$kenaikan_jabatan = new KenaikanJabatan();

		$reqId = httpFilterGet("reqId");

		$kenaikan_jabatan->setField('KENAIKAN_JABATAN_ID', $reqId);
		$kenaikan_jabatan->setField('STATUS', 2);
		$kenaikan_jabatan->updateStatus();
		$met[0]['STATUS'] = 1;
		echo json_encode($met);

	}

	
	function pegawai_non_add_data()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pegawai = new Pegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqNPP= httpFilterPost("reqNPP");
		$reqNama= httpFilterPost("reqNama");
		$reqAgamaId= httpFilterPost("reqAgamaId");
		$reqJenisKelamin= httpFilterPost("reqJenisKelamin");
		$reqStatusPegawai= httpFilterPost("reqStatusPegawai");
		$reqDepartemen = httpFilterPost("reqDepartemen");
		$reqTempat= httpFilterPost("reqTempat");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqAlamat= httpFilterPost("reqAlamat");
		$reqTelepon== httpFilterPost("reqTelepon");
		$reqEmail= httpFilterPost("reqEmail");
		$reqNIS= httpFilterPost("reqNIS");
		$reqJenisPegawai= httpFilterPost("reqJenisPegawai");
		$reqLinkFile = $_FILES["reqLinkFile"];

		$reqStatusPegawai= httpFilterPost("reqStatusPegawai");

		$reqTMT= httpFilterPost("reqTMT");
		if($reqDepartemen == 0)
			$reqDepartemen = "NULL";
		else
			$reqDepartemen = "'".$reqDepartemen."'";

		$pegawai->setField("DEPARTEMEN_ID", $reqDepartemen);
		$pegawai->setField("NIS", $reqNIS);
		$pegawai->setField("NAMA", $reqNama);
		$pegawai->setField("AGAMA_ID", $reqAgamaId);
		$pegawai->setField("JENIS_KELAMIN", $reqJenisKelamin);
		$pegawai->setField("TEMPAT_LAHIR", $reqTempat);
		$pegawai->setField("TANGGAL_LAHIR", dateToDBCheck($reqTanggal));
		$pegawai->setField("ALAMAT", $reqAlamat);
		$pegawai->setField("TELEPON", $reqTelepon);
		$pegawai->setField("EMAIL", $reqEmail);
		$pegawai->setField("STATUS_PEGAWAI_ID", $reqStatusPegawai);
				
		if($reqMode == "insert")
		{
			$pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	

			if($pegawai->insertKadet())
			{
				$id = $pegawai->id;
				
				if($reqLinkFile['tmp_name'])
					$pegawai->upload("PPI_SIMPEG.PEGAWAI", "FOTO", $reqLinkFile['tmp_name'], "PEGAWAI_ID = ".$id);
				
				$pegawai_jenis_pegawai= new PegawaiJenisPegawai();
				$pegawai_jenis_pegawai->setField("PEGAWAI_ID",$id);
				$pegawai_jenis_pegawai->setField("JENIS_PEGAWAI_ID",$reqJenisPegawai);
				$pegawai_jenis_pegawai->setField("TMT_JENIS_PEGAWAI", dateToDBCheck($reqTMT));
				$pegawai_jenis_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
				$pegawai_jenis_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
				if($pegawai_jenis_pegawai->insertNonPegawai()){}
				
				echo $id."-Data berhasil disimpan.";
			}
		}
		else
		{
			$pegawai->setField("PEGAWAI_ID", $reqId);
			$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
			$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			if($pegawai->updateKadet())
			{
				$id = $reqId;
				
				if($reqLinkFile['tmp_name'])
					$pegawai->upload("PPI_SIMPEG.PEGAWAI", "FOTO", $reqLinkFile['tmp_name'], "PEGAWAI_ID = ".$id);
				
				$pegawai_jenis_pegawai= new PegawaiJenisPegawai();
				$pegawai_jenis_pegawai->setField("JENIS_PEGAWAI_ID",$reqJenisPegawai);
				$pegawai_jenis_pegawai->setField("TMT_JENIS_PEGAWAI", dateToDBCheck($reqTMT));
				$pegawai_jenis_pegawai->setField("PEGAWAI_JENIS_PEGAWAI_ID",$reqRowId);
				$pegawai_jenis_pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
				$pegawai_jenis_pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
				if($pegawai_jenis_pegawai->updateNonPegawai()){}
				
				echo $id."-Data berhasil disimpan.";
			}
		}
	}

	
	function pegawai_non_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

		$pegawai = new Pegawai();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqStatusPegawai= httpFilterGet("reqStatusPegawai");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqKelompok = httpFilterGet("reqKelompok");
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "NIS", "NAMA", "AGAMA_NAMA", "JENIS_KELAMIN", "TEMPAT_LAHIR", "TANGGAL_LAHIR", "JENIS_PEGAWAI", "DEPARTEMEN" );
		$aColumnsAlias = array("PEGAWAI_ID", "NIS", "NAMA", "AGAMA_NAMA", "JENIS_KELAMIN", "TEMPAT_LAHIR", "TANGGAL_LAHIR", "JENIS_PEGAWAI", "DEPARTEMEN");

		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = " ORDER BY ";
			 
			//Go over all sorting cols
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				//If need to sort by current col
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					//Add to the order by clause
					$sOrder .= $aColumnsAlias[ intval( $_GET['iSortCol_'.$i] ) ];
					 
					//Determine if it is sorted asc or desc
					if (strcasecmp(( $_GET['sSortDir_'.$i] ), "asc") == 0)
					{
						$sOrder .=" asc, ";
					}else
					{
						$sOrder .=" desc, ";
					}
				}
			}
			
			 
			//Remove the last space / comma
			$sOrder = substr_replace( $sOrder, "", -2 );
			
			//Check if there is an order by clause
			if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				//$sOrder = " ORDER BY PEGAWAI_ID DESC";
				$sOrder = " ORDER BY TO_NUMBER(D.KELAS) ASC, TO_NUMBER(D.NO_URUT) ASC";
			}
		}
		 
		 
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables.
		 */
		$sWhere = "";
		$nWhereGenearalCount = 0;
		if (isset($_GET['sSearch']))
		{
			$sWhereGenearal = $_GET['sSearch'];
		}
		else
		{
			$sWhereGenearal = '';
		}

		if ( $_GET['sSearch'] != "" )
		{
			//Set a default where clause in order for the where clause not to fail
			//in cases where there are no searchable cols at all.
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumnsAlias)+1 ; $i++ )
			{
				//If current col has a search param
				if ( $_GET['bSearchable_'.$i] == "true" )
				{
					//Add the search to the where clause
					$sWhere .= $aColumnsAlias[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
					$nWhereGenearalCount += 1;
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		 
		/* Individual column filtering */
		$sWhereSpecificArray = array();
		$sWhereSpecificArrayCount = 0;
		for ( $i=0 ; $i<count($aColumnsAlias) ; $i++ )
		{
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				//If there was no where clause
				if ( $sWhere == "" )
				{
					$sWhere = "AND ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				 
				//Add the clause of the specific col to the where clause
				$sWhere .= $aColumnsAlias[$i]." LIKE '%' || :whereSpecificParam".$sWhereSpecificArrayCount." || '%' ";
				 
				//Inc sWhereSpecificArrayCount. It is needed for the bind var.
				//We could just do count($sWhereSpecificArray) - but that would be less efficient.
				$sWhereSpecificArrayCount++;
				 
				//Add current search param to the array for later use (binding).
				$sWhereSpecificArray[] =  $_GET['sSearch_'.$i];
				 
			}
		}
		 
		//If there is still no where clause - set a general - always true where clause
		if ( $sWhere == "" )
		{
			$sWhere = " AND 1=1";
		}
		//Bind variables.
		if ( isset( $_GET['iDisplayStart'] ))
		{
			$dsplyStart = $_GET['iDisplayStart'];
		}
		else{
			$dsplyStart = 0;
		}
		 
		if ( isset( $_GET['iDisplayLength'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$dsplyRange = $_GET['iDisplayLength'];
			if ($dsplyRange > (2147483645 - intval($dsplyStart)))
			{
				$dsplyRange = 2147483645;
			}
			else
			{
				$dsplyRange = intval($dsplyRange);
			}
		}
		else
		{
			$dsplyRange = 2147483645;
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND (EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') OR A.DEPARTEMEN_ID IS NULL) ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";


		$statement .= " AND JENIS_PEGAWAI_ID IN (9,10,11) ";

		$allRecord = $pegawai->getCountByParams(array(),$statement);
		//echo $pegawai->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $pegawai->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')) ");

		//echo $pegawai->query;
		$pegawai->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder);
		//" AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') AND (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%') "

		//echo $pegawai->query;

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($pegawai->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{

				if($aColumns[$i] == "TANGGAL_LAHIR" || $aColumns[$i] == "TANGGAL_KONTRAK_AWAL" || $aColumns[$i] == "TANGGAL_KONTRAK_AKHIR")
					$row[] = getFormattedDate($pegawai->getField($aColumns[$i]));
				else if($aColumns[$i] == "ZODIAC")
					$row[] = getZodiac((int)getDay($pegawai->getField("TANGGAL_LAHIR")), (int)getMonth($pegawai->getField("TANGGAL_LAHIR")));
				else if($aColumns[$i] == "DEPARTEMEN")
				{
					if($pegawai->getField($aColumns[$i]) == "")
						$row[] = "Kantor Pusat PT. PMS";			
					else
						$row[] = $pegawai->getField($aColumns[$i]);
				}
				else
					$row[] = $pegawai->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

	
	function pegawai_pencarian_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

		$pegawai = new Pegawai();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqStatusPegawai= httpFilterGet("reqStatusPegawai");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA", "LAMA_CUTI", "JABATAN", "DEPARTEMEN");
		$aColumnsAlias = array("A.PEGAWAI_ID", "NRP", "NAMA", "LAMA_CUTI", "JABATAN", "DEPARTEMEN");

		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = " ORDER BY ";
			 
			//Go over all sorting cols
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				//If need to sort by current col
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					//Add to the order by clause
					$sOrder .= $aColumnsAlias[ intval( $_GET['iSortCol_'.$i] ) ];
					 
					//Determine if it is sorted asc or desc
					if (strcasecmp(( $_GET['sSortDir_'.$i] ), "asc") == 0)
					{
						$sOrder .=" asc, ";
					}else
					{
						$sOrder .=" desc, ";
					}
				}
			}
			
			 
			//Remove the last space / comma
			$sOrder = substr_replace( $sOrder, "", -2 );
			
			//Check if there is an order by clause
			if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				//$sOrder = " ORDER BY PEGAWAI_ID DESC";
				$sOrder = " ORDER BY TO_NUMBER(B.KELAS) ASC, TO_NUMBER(B.NO_URUT) ASC";
			}
		}
		 
		 
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables.
		 */
		$sWhere = "";
		$nWhereGenearalCount = 0;
		if (isset($_GET['sSearch']))
		{
			$sWhereGenearal = $_GET['sSearch'];
		}
		else
		{
			$sWhereGenearal = '';
		}

		if ( $_GET['sSearch'] != "" )
		{
			//Set a default where clause in order for the where clause not to fail
			//in cases where there are no searchable cols at all.
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumnsAlias)+1 ; $i++ )
			{
				//If current col has a search param
				if ( $_GET['bSearchable_'.$i] == "true" )
				{
					//Add the search to the where clause
					$sWhere .= $aColumnsAlias[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
					$nWhereGenearalCount += 1;
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		 
		/* Individual column filtering */
		$sWhereSpecificArray = array();
		$sWhereSpecificArrayCount = 0;
		for ( $i=0 ; $i<count($aColumnsAlias) ; $i++ )
		{
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				//If there was no where clause
				if ( $sWhere == "" )
				{
					$sWhere = "AND ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				 
				//Add the clause of the specific col to the where clause
				$sWhere .= $aColumnsAlias[$i]." LIKE '%' || :whereSpecificParam".$sWhereSpecificArrayCount." || '%' ";
				 
				//Inc sWhereSpecificArrayCount. It is needed for the bind var.
				//We could just do count($sWhereSpecificArray) - but that would be less efficient.
				$sWhereSpecificArrayCount++;
				 
				//Add current search param to the array for later use (binding).
				$sWhereSpecificArray[] =  $_GET['sSearch_'.$i];
				 
			}
		}
		 
		//If there is still no where clause - set a general - always true where clause
		if ( $sWhere == "" )
		{
			$sWhere = " AND 1=1";
		}
		//Bind variables.
		if ( isset( $_GET['iDisplayStart'] ))
		{
			$dsplyStart = $_GET['iDisplayStart'];
		}
		else{
			$dsplyStart = 0;
		}
		 
		if ( isset( $_GET['iDisplayLength'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$dsplyRange = $_GET['iDisplayLength'];
			if ($dsplyRange > (2147483645 - intval($dsplyStart)))
			{
				$dsplyRange = 2147483645;
			}
			else
			{
				$dsplyRange = intval($dsplyRange);
			}
		}
		else
		{
			$dsplyRange = 2147483645;
		}

		if($reqJenisPegawai == "")
			$statement .= "";
		else
			$statement .= "AND D.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;

		$allRecord = $pegawai->getCountByParamsCutiTahunan(array(),$statement);
		//echo $pegawai->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $pegawai->getCountByParamsCutiTahunan(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ");

		//echo $pegawai->query;
		$pegawai->selectByParamsPegawai(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder);
		//" AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') AND (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%') "

		//echo $pegawai->query;

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($pegawai->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($pegawai->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($pegawai->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $pegawai->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}


}
?>
