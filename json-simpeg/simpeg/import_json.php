<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class import_json extends CI_Controller {

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
	
	
	function import_data_keluarga()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiKeluarga.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		include "../operasional/excel/excel_reader2.php";

		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
		$pegawai_keluarga = new PegawaiKeluarga();
		$pegawai = new Pegawai();

		$reqId = httpFilterPost("reqId");
		//$reqPeriode = httpFilterPost("reqPeriode");
		//$reqLokasi = httpFilterPost("reqLokasi");

		$bulan = substr($reqPeriode, 0,2);
		$tahun = substr($reqPeriode, 2,4);
		$date=$tahun.'-'.$bulan;
		$reqTanggalAwal= dateToPageCheck($tahun.'-'.$bulan.'-01');
		$reqTanggalAkhir= dateToPageCheck(date("Y-m-t",strtotime($date)));

		$baris = $data->rowcount($sheet_index=0);

		//$check = $pegawai_keluarga->getCountByParamsKapalProduksi(array("PERIODE" => $reqPeriode, "PEGAWAI_ID" => $reqId));
		//unset($pegawai_keluarga);

		// import data excel mulai baris ke-4 (karena baris pertama adalah nama kolom)
		for ($i=2; $i<=$baris; $i++)
		{
			$reqNRP = $data->val($i, 1);
			$reqHubunganKeluargaId = $data->val($i, 2);
			$reqStatusTunjangan = $data->val($i, 3);
			$reqStatusKawin = $data->val($i, 4);
			$reqStatusTanggung = $data->val($i, 5);
			$reqNama = $data->val($i, 6);
			$reqJenisKelamin = $data->val($i, 7);

			$pegawai = new Pegawai();
			$pegawai->selectByParams(array("NRP" => $reqNRP));
			$pegawai->firstRow();
			$reqId = $pegawai->getField("PEGAWAI_ID");
			
			$pegawai_keluarga = new PegawaiKeluarga();	
			$pegawai_keluarga->setField('HUBUNGAN_KELUARGA_ID', $reqHubunganKeluargaId);
			$pegawai_keluarga->setField('STATUS_KAWIN', setNULL($reqStatusKawin));
			$pegawai_keluarga->setField('JENIS_KELAMIN', $reqJenisKelamin);
			$pegawai_keluarga->setField('STATUS_TUNJANGAN', setNULL($reqStatusTunjangan));
			$pegawai_keluarga->setField('NAMA', $reqNama);
			$pegawai_keluarga->setField('TANGGAL_WAFAT', dateToDBCheck($reqTanggalWafat));
			$pegawai_keluarga->setField('TANGGAL_LAHIR', dateToDBCheck($reqTanggalLahir));
			$pegawai_keluarga->setField('STATUS_TANGGUNG', setNULL($reqStatusTanggung));
			$pegawai_keluarga->setField('TEMPAT_LAHIR', $reqTempatLahir);
			$pegawai_keluarga->setField('PENDIDIKAN_ID', $reqPendidikanId);
			$pegawai_keluarga->setField('PEKERJAAN', $reqPekerjaan);
			$pegawai_keluarga->setField('PEGAWAI_ID', $reqId);
			
			$pegawai_keluarga->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_keluarga->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			
			if($reqNama==""){}
			else
			{
				$pegawai_keluarga->insert();
				//echo $pegawai_keluarga->query;
			}
			
			unset($pegawai_keluarga);
			unset($pegawai);	
			
		}

		echo "Data berhasil disimpan.";
		//echo $temp;

	}

	function import_data_pendidikan()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikan.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		include "../operasional/excel/excel_reader2.php";

		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
		$pegawai_pendidikan = new PegawaiPendidikan();
		$pegawai = new Pegawai();

		$reqId = httpFilterPost("reqId");
		//$reqPeriode = httpFilterPost("reqPeriode");
		//$reqLokasi = httpFilterPost("reqLokasi");

		$bulan = substr($reqPeriode, 0,2);
		$tahun = substr($reqPeriode, 2,4);
		$date=$tahun.'-'.$bulan;
		$reqTanggalAwal= dateToPageCheck($tahun.'-'.$bulan.'-01');
		$reqTanggalAkhir= dateToPageCheck(date("Y-m-t",strtotime($date)));

		$baris = $data->rowcount($sheet_index=0);

		//$check = $pegawai_pendidikan->getCountByParamsKapalProduksi(array("PERIODE" => $reqPeriode, "PEGAWAI_ID" => $reqId));
		//unset($pegawai_pendidikan);

		// import data excel mulai baris ke-4 (karena baris pertama adalah nama kolom)
		for ($i=2; $i<=$baris; $i++)
		{
			$reqNRP = $data->val($i, 1);
			$reqPendidikanId = $data->val($i, 2);
			$reqPendidikanBiayaId = $data->val($i, 3);
			$reqNama = $data->val($i, 4);
			$reqKota = $data->val($i, 5);
			$reqUniversitasId = $data->val($i, 6);
			$reqLulus = $data->val($i, 7);
			$reqNoIjasah = $data->val($i, 8);
			
			$pegawai = new Pegawai();
			$pegawai->selectByParams(array("NRP" => $reqNRP));
			$pegawai->firstRow();
			$reqId = $pegawai->getField("PEGAWAI_ID");

			$pegawai_pendidikan = new PegawaiPendidikan();
			$pegawai_pendidikan->setField('PEGAWAI_ID', $reqId);
			$pegawai_pendidikan->setField('PENDIDIKAN_ID', $reqPendidikanId);
			$pegawai_pendidikan->setField('PENDIDIKAN_BIAYA_ID', $reqPendidikanBiayaId);
			$pegawai_pendidikan->setField('NAMA', $reqNama);
			$pegawai_pendidikan->setField('KOTA', $reqKota);
			$pegawai_pendidikan->setField('UNIVERSITAS_ID', $reqUniversitasId);
			$pegawai_pendidikan->setField('LULUS', $reqLulus);
			$pegawai_pendidikan->setField('NO_IJASAH', $reqNoIjasah);
			$pegawai_pendidikan->setField('TANGGAL_ACC', dateToDBCheck($reqTanggalAcc));
			$pegawai_pendidikan->setField('TANGGAL_IJASAH', dateToDBCheck($reqTanggalIjasah));
			
			$pegawai_pendidikan->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_pendidikan->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			
			if($reqNama==""){}
			else
			{
				$pegawai_pendidikan->insert();
				//echo $pegawai_pendidikan->query;
			}
			/*
				if($i==1)
				$temp= $pegawai_pendidikan->query;
			*/
			unset($pegawai_pendidikan);
			unset($pegawai);	
			
		}

		echo "Data berhasil disimpan.";
		//echo $temp;
	}
	
	function import_data_pendidikan_perjenjangan()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikanPerjenjangan.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		include "../operasional/excel/excel_reader2.php";

		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
		$pegawai_pendidikan_perjenjangan = new PegawaiPendidikanPerjenjangan();
		$pegawai = new Pegawai();

		$reqId = httpFilterPost("reqId");
		//$reqPeriode = httpFilterPost("reqPeriode");
		//$reqLokasi = httpFilterPost("reqLokasi");

		$bulan = substr($reqPeriode, 0,2);
		$tahun = substr($reqPeriode, 2,4);
		$date=$tahun.'-'.$bulan;
		$reqTanggalAwal= dateToPageCheck($tahun.'-'.$bulan.'-01');
		$reqTanggalAkhir= dateToPageCheck(date("Y-m-t",strtotime($date)));

		$baris = $data->rowcount($sheet_index=0);

		//$check = $pegawai_pendidikan_perjenjangan->getCountByParamsKapalProduksi(array("PERIODE" => $reqPeriode, "PEGAWAI_ID" => $reqId));
		//unset($pegawai_pendidikan_perjenjangan);

		// import data excel mulai baris ke-4 (karena baris pertama adalah nama kolom)
		for ($i=2; $i<=$baris; $i++)
		{

		//$tempPegawaiId=$data->val($i, 1);
		//$reqPerjenjanganId = $data->val($i, 2);
		//$reqTotalJamOps = setTime($data->raw($i, '6'), $data->val($i, 6));
		//$reqHari = $data->val($i, 21);
			
			$reqNRP = $data->val($i, 1);
			$reqNama = $data->val($i, 2);
			$reqTanggalAwal = $data->val($i, 3);
			$reqTanggalAkhir = $data->val($i, 4);
			
			$pegawai = new Pegawai();
			$pegawai->selectByParams(array("NRP" => $reqNRP));
			$pegawai->firstRow();
			$reqId = $pegawai->getField("PEGAWAI_ID");

			$pegawai_pendidikan_perjenjangan = new PegawaiPendidikanPerjenjangan();
			$pegawai_pendidikan_perjenjangan->setField('PEGAWAI_ID', $reqId);
			$pegawai_pendidikan_perjenjangan->setField('NAMA', $reqNama);
			$pegawai_pendidikan_perjenjangan->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
			$pegawai_pendidikan_perjenjangan->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
			
			$pegawai_pendidikan_perjenjangan->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_pendidikan_perjenjangan->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			
			
			if($reqNama==""){}
			else
			{
				$pegawai_pendidikan_perjenjangan->insert();
				//echo $pegawai_pendidikan_perjenjangan->query;
			}
			//echo $pegawai_pendidikan_perjenjangan->query;
			
			/*if($i==1)
				$temp= $pegawai_pendidikan_perjenjangan->query;
			*/
			unset($pegawai_pendidikan_perjenjangan);
			unset($pegawai);
			
		}

		echo "Data berhasil disimpan.";
		//echo $temp;
	}
	
	function import_data_pendidikan_substansial()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikanSubstansial.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		include "../operasional/excel/excel_reader2.php";

		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
		$pegawai_pendidikan_substansial = new PegawaiPendidikanSubstansial();
		$pegawai = new Pegawai();

		$reqId = httpFilterPost("reqId");
		//$reqPeriode = httpFilterPost("reqPeriode");
		//$reqLokasi = httpFilterPost("reqLokasi");

		$bulan = substr($reqPeriode, 0,2);
		$tahun = substr($reqPeriode, 2,4);
		$date=$tahun.'-'.$bulan;
		$reqTanggalAwal= dateToPageCheck($tahun.'-'.$bulan.'-01');
		$reqTanggalAkhir= dateToPageCheck(date("Y-m-t",strtotime($date)));

		$baris = $data->rowcount($sheet_index=0);

		//$check = $pegawai_pendidikan_substansial->getCountByParamsKapalProduksi(array("PERIODE" => $reqPeriode, "PEGAWAI_ID" => $reqId));
		//unset($pegawai_pendidikan_substansial);

		// import data excel mulai baris ke-4 (karena baris pertama adalah nama kolom)
		for ($i=2; $i<=$baris; $i++)
		{

		//$tempPegawaiId=$data->val($i, 1);
		//$reqPerjenjanganId = $data->val($i, 2);
		//$reqTotalJamOps = setTime($data->raw($i, '6'), $data->val($i, 6));
		//$reqHari = $data->val($i, 21);

			$reqNRP = $data->val($i, 1);
			$reqNama = $data->val($i, 2);
			$reqTanggalAwal = $data->val($i, 3);
			$reqTanggalAkhir = $data->val($i, 4);
			
			$pegawai = new Pegawai();
			$pegawai->selectByParams(array("NRP" => $reqNRP));
			$pegawai->firstRow();
			$reqId = $pegawai->getField("PEGAWAI_ID");
			
			$pegawai_pendidikan_substansial = new PegawaiPendidikanSubstansial();
			$pegawai_pendidikan_substansial->setField('PEGAWAI_ID', $reqId);
			$pegawai_pendidikan_substansial->setField('NAMA', $reqNama);
			$pegawai_pendidikan_substansial->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
			$pegawai_pendidikan_substansial->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
			
			$pegawai_pendidikan_substansial->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_pendidikan_substansial->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			
			
			if($reqNama==""){}
			else
			{
				$pegawai_pendidikan_substansial->insert();
				//echo $pegawai_pendidikan_substansial->query;
			}
			//echo $pegawai_pendidikan_substansial->query;
			
			/*if($i==1)
				$temp= $pegawai_pendidikan_substansial->query;
			*/
			unset($pegawai_pendidikan_substansial);
			unset($pegawai);
			
		}

		echo "Data berhasil disimpan.";
		//echo $temp;
	}
	
	function import_data_sertifikat()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiSertifikat.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		include "../operasional/excel/excel_reader2.php";

		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
		$pegawai_sertifikat = new PegawaiSertifikat();
		$pegawai = new Pegawai();

		$reqId = httpFilterPost("reqId");
		//$reqPeriode = httpFilterPost("reqPeriode");
		//$reqLokasi = httpFilterPost("reqLokasi");

		$bulan = substr($reqPeriode, 0,2);
		$tahun = substr($reqPeriode, 2,4);
		$date=$tahun.'-'.$bulan;
		$reqTanggalAwal= dateToPageCheck($tahun.'-'.$bulan.'-01');
		$reqTanggalAkhir= dateToPageCheck(date("Y-m-t",strtotime($date)));

		$baris = $data->rowcount($sheet_index=0);

		//$check = $pegawai_sertifikat->getCountByParamsKapalProduksi(array("PERIODE" => $reqPeriode, "PEGAWAI_ID" => $reqId));
		//unset($pegawai_sertifikat);

		// import data excel mulai baris ke-4 (karena baris pertama adalah nama kolom)
		for ($i=2; $i<=$baris; $i++)
		{

		//$tempPegawaiId=$data->val($i, 1);
		//$reqPerjenjanganId = $data->val($i, 2);
		//$reqTotalJamOps = setTime($data->raw($i, '6'), $data->val($i, 6));
		//$reqHari = $data->val($i, 21);

				$reqNRP = $data->val($i, 1);	
				$reqPegawaiSertifikatId = $data->val($i, 2);
				$reqTanggalTerbit = $data->val($i, 3);
				$reqTanggalKadaluarsa = $data->val($i, 4);
				$reqGroupKapal = $data->val($i, 5);
				$reqKeterangan = $data->val($i, 6);

				$pegawai = new Pegawai();
				$pegawai->selectByParams(array("NRP" => $reqNRP));
				$pegawai->firstRow();
				$reqId = $pegawai->getField("PEGAWAI_ID");

				$pegawai_sertifikat = new PegawaiSertifikat();
				$pegawai_sertifikat->setField("NAMA", $reqPegawaiSertifikatId);
				$pegawai_sertifikat->setField("TANGGAL_TERBIT", dateToDBCheck($reqTanggalTerbit));
				$pegawai_sertifikat->setField("TANGGAL_KADALUARSA", dateToDBCheck($reqTanggalKadaluarsa));
				$pegawai_sertifikat->setField("GROUP_SERTIFIKAT", $reqGroupKapal);
				$pegawai_sertifikat->setField("KETERANGAN", $reqKeterangan);
				$pegawai_sertifikat->setField("PEGAWAI_ID", $reqId);
				
				$pegawai_sertifikat->setField("LAST_CREATE_USER", $userLogin->nama);
				$pegawai_sertifikat->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			
			
			if($reqPegawaiSertifikatId==""){}
			else
			{
				$pegawai_sertifikat->insert();
				//echo $pegawai_sertifikat->query;
			}
			/*if($i==1)
				$temp= $pegawai_sertifikat->query;*/
			unset($pegawai_sertifikat);
			unset($pegawai);
			
		}

		echo "Data berhasil disimpan.";
		//echo $temp;

	}
	
	function import_data_status_nikah()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusNikah.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		include "../operasional/excel/excel_reader2.php";

		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
		$pegawai_status_nikah = new PegawaiStatusNikah();
		$pegawai = new Pegawai();

		$reqId = httpFilterPost("reqId");
		//$reqPeriode = httpFilterPost("reqPeriode");
		//$reqLokasi = httpFilterPost("reqLokasi");

		$bulan = substr($reqPeriode, 0,2);
		$tahun = substr($reqPeriode, 2,4);
		$date=$tahun.'-'.$bulan;
		$reqTanggalAwal= dateToPageCheck($tahun.'-'.$bulan.'-01');
		$reqTanggalAkhir= dateToPageCheck(date("Y-m-t",strtotime($date)));

		$baris = $data->rowcount($sheet_index=0);

		//$check = $pegawai_status_nikah->getCountByParamsKapalProduksi(array("PERIODE" => $reqPeriode, "PEGAWAI_ID" => $reqId));
		//unset($pegawai_status_nikah);

		// import data excel mulai baris ke-4 (karena baris pertama adalah nama kolom)
		for ($i=2; $i<=$baris; $i++)
		{

		//$tempPegawaiId=$data->val($i, 1);
		//$reqPerjenjanganId = $data->val($i, 2);
		//$reqTotalJamOps = setTime($data->raw($i, '6'), $data->val($i, 6));
		//$reqHari = $data->val($i, 21);
			
			$reqNRP = $data->val($i, 1);			
			$reqTanggalNikah = $data->val($i, 2);
			$reqStatusNikah = $data->val($i, 3);
			$reqTempat = $data->val($i, 4);
			$reqNoSK = $data->val($i, 5);
			$reqHubungan = $data->val($i, 6);

			$pegawai = new Pegawai();
			$pegawai->selectByParams(array("NRP" => $reqNRP));
			$pegawai->firstRow();
			$reqId = $pegawai->getField("PEGAWAI_ID");

			$pegawai_status_nikah = new PegawaiStatusNikah();
			$pegawai_status_nikah->setField('TANGGAL_NIKAH', dateToDBCheck($reqTanggalNikah));
			$pegawai_status_nikah->setField('STATUS_NIKAH', $reqStatusNikah);
			$pegawai_status_nikah->setField('TEMPAT', $reqTempat);
			$pegawai_status_nikah->setField('NO_SK', $reqNoSK);
			$pegawai_status_nikah->setField('HUBUNGAN', $reqHubungan);
			$pegawai_status_nikah->setField('PEGAWAI_ID', $reqId);
			
			$pegawai_status_nikah->setField("LAST_CREATE_USER", $userLogin->nama);
			$pegawai_status_nikah->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			
			
			if($reqStatusNikah==""){}
			else
			{
				$pegawai_status_nikah->insert();
				//echo $pegawai_status_nikah->query;
			}
			//echo $pegawai_status_nikah->query;
			
			/*if($i==1)
				$temp= $pegawai_status_nikah->query;
			*/
			unset($pegawai_status_nikah);
			unset($pegawai);
			
		}

		echo "Data berhasil disimpan.";
		//echo $temp;
	}

}
?>
