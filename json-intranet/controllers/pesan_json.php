<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class pesan_json extends CI_Controller {

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
	
	
	function pesan_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/Pesan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$pesan = new Pesan();

		$reqKepada = httpFilterPost("reqKepada");
		$reqJudul = httpFilterPost("reqJudul");
		$reqPesan = httpFilterPost("reqPesan");
		$reqParentId = httpFilterPost("reqParentId");

		if($reqParentId == "")
		{
			$pesan->setField("NAMA", $reqJudul);
			$pesan->setField("USER_LOGIN_ID_PENGIRIM", $userLogin->UID);
			$pesan->setField("USER_LOGIN_ID_PENERIMA", $reqKepada);
			$pesan->setField("KETERANGAN", $reqPesan);
			
			if($pesan->insert())
				echo "Pesan telah terkirim.";
		}
		else
		{
			$pesan->setField("NAMA", $reqJudul);
			$pesan->setField("USER_LOGIN_ID_PENGIRIM", $userLogin->UID);
			$pesan->setField("USER_LOGIN_ID_PENERIMA", $reqKepada);
			$pesan->setField("KETERANGAN", $reqPesan);
			$pesan->setField("PESAN_PARENT_ID", $reqParentId);
			
			if($pesan->insertParentId())
				echo "Pesan telah terkirim.";	
		}
	}
	
	function pesan_masuk_baru_jumlah_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base/Pesan.php");

		/* create objects */

		$pesan = new Pesan();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$jumlah_pesan = $pesan->getCountByParams(array("USER_LOGIN_ID_PENERIMA" => $userLogin->UID, "STATUS" => 0));
		$arr_json = array();
		$i=0;

		$arr_json[$i]['JUMLAH_PESAN'] = $jumlah_pesan;

		echo json_encode($arr_json);
	}
	
	function pesan_masuk_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base/Pesan.php");

		/* create objects */

		$pesan = new Pesan();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$pesan->selectByParamsMonitoring(array("USER_LOGIN_ID_PENERIMA" => $userLogin->UID), 5, 0);
		$arr_json = array();
		$i=0;
		while($pesan->nextRow())
		{
			$arr_json[$i]['NAMA'] = $pesan->getField("NAMA");
			$arr_json[$i]['USER_LOGIN'] = $pesan->getField("USER_LOGIN");
			$arr_json[$i]['TANGGAL'] = getFormattedDateTime($pesan->getField("TANGGAL"));
			$arr_json[$i]['DEPARTEMEN'] = $pesan->getField("DEPARTEMEN");
			$arr_json[$i]['PESAN_ID'] = $pesan->getField("PESAN_ID");	
			$arr_json[$i]['PESAN_PARENT_ID'] = $pesan->getField("PESAN_PARENT_ID");	
			$arr_json[$i]['STATUS'] = $pesan->getField("STATUS");	
			$arr_json[$i]['USER_LOGIN_ID_PENGIRIM'] = $pesan->getField("USER_LOGIN_ID_PENGIRIM");	
			$i++;
		}
		echo json_encode($arr_json);
	}

}
?>
