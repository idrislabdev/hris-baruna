<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class sekolah_json extends CI_Controller {

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
	
	
	function sekolah_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/DataSekolah.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$sekolah = new DataSekolah();

		$reqId = httpFilterPost("SEKOLAH_ID");

		$reqNama	= httpFilterPost("NAMA");
		$reqTelpon 	= httpFilterPost("TELPON");
		$reqFax 	= httpFilterPost("FAX");
		$reqKota 	= httpFilterPost("KOTA");
		$reqWebsite = httpFilterPost("WEBSITE");
		$reqEmail 	= httpFilterPost("EMAIL");
		$reqAlamat 	= httpFilterPost("ALAMAT");
		$reqRekomN 	= httpFilterPost("REKOMENDASI_N");
		$reqRekomT 	= httpFilterPost("REKOMENDASI_T");
		$reqSertifikat 	= httpFilterPost("SERTIFIKAT");
		$reqTglSertifikat 	= httpFilterPost("TGL_SERTIFIKAT");
		$reqApproval 	= httpFilterPost("APPROVAL_DESC");

		if($reqId == ""){
			$sekolah->setField('NAMA', $reqNama);
			$sekolah->setField('TELPON', $reqTelpon);
			$sekolah->setField('FAX', $reqFax);
			$sekolah->setField('KOTA', $reqKota);
			$sekolah->setField('EMAIL', $reqEmail);
			$sekolah->setField('WEBSITE', $reqWebsite);
			$sekolah->setField('ALAMAT', $reqAlamat);
			$sekolah->setField('APPROVAL_DESC', $reqApproval);
			$sekolah->setField('REKOMENDASI_N', $reqRekomN);
			$sekolah->setField('REKOMENDASI_T', $reqRekomT);
			$sekolah->setField('SERTIFIKAT', $reqSertifikat);
			$sekolah->setField('TGL_SERTIFIKAT', dateToDBCheck($reqTglSertifikat));
			$sekolah->setField("LAST_CREATE_USER", $userLogin->nama);
			$sekolah->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			if($sekolah->insert())
				echo '{success:true, error:null, "keterangan":"Data berhasil disimpan!"}';
		}
		else{
			$sekolah->setField('SEKOLAH_ID', $reqId);
			$sekolah->setField('NAMA', $reqNama);
			$sekolah->setField('TELPON', $reqTelpon);
			$sekolah->setField('FAX', $reqFax);
			$sekolah->setField('KOTA', $reqKota);
			$sekolah->setField('EMAIL', $reqEmail);
			$sekolah->setField('WEBSITE', $reqWebsite);
			$sekolah->setField('ALAMAT', $reqAlamat);
			$sekolah->setField('APPROVAL_DESC', $reqApproval);
			$sekolah->setField('REKOMENDASI_N', $reqRekomN);
			$sekolah->setField('REKOMENDASI_T', $reqRekomT);
			$sekolah->setField('SERTIFIKAT', $reqSertifikat);
			$sekolah->setField('TGL_SERTIFIKAT', dateToDBCheck($reqTglSertifikat));
			$sekolah->setField("LAST_UPDATE_USER", $userLogin->nama);
			$sekolah->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			if($sekolah->update())
				echo '{success:true, error:null, "keterangan":"Data berhasil disimpan!"}';
		}
	}
	
	function json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/DataSekolah.php");

		$sekolah = new DataSekolah();
		$reqKeyword = httpFilterPost("query");
		$reqLimit = httpFilterPost("limit");
		$reqPage = httpFilterPost("page");
		$reqStart = httpFilterPost("start");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);
		$where ="";
		if($reqKeyword != ""){
			$where = " AND (UPPER(NAMA) LIKE UPPER('%". $reqKeyword ."%') OR UPPER(ALAMAT) LIKE UPPER('%". $reqKeyword ."%') OR UPPER(KOTA) LIKE UPPER('%". $reqKeyword ."%') OR UPPER(EMAIL) LIKE UPPER('%". $reqKeyword ."%')) ";
		}
		$totalRecord = $sekolah->getCountByParams(array(), $where);
		$sekolah->selectByParams(array(), $reqLimit, $reqStart, $where, " ORDER BY LAST_CREATE_DATE DESC");     		
		$kolom = array('SEKOLAH_ID','NAMA', 'EMAIL', 'WEBSITE', 'TELPON','ALAMAT','FAX','REKOMENDASI_N','REKOMENDASI_T','SERTIFIKAT','TGL_SERTIFIKAT', 'TEXT_TGL_SERTIFIKAT', 'APPROVAL_DESC','KOTA');
		/* Output */
		$data = array();
		while($sekolah->nextRow()){	
			$row = array();
			for ( $i=0 ; $i<count($kolom) ; $i++ ){
				$row[$kolom[$i]] = $sekolah->getField($kolom[$i]);
			}
			$data['hasil'][] = $row;
		}
		echo '({"TOTAL":"'.$totalRecord.'","ISI_DATA":'.json_encode($data['hasil']).'})';
	}

}
?>
