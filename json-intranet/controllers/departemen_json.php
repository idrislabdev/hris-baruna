<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class departemen_json extends CI_Controller {

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
	
	
	function departemen_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$departemen = new Departemen();

		$reqId = httpFilterPost("reqId");
		$reqCabangId = httpFilterPost("reqCabangId");
		$reqMode = httpFilterPost("reqMode");
		$reqNama = httpFilterPost("reqNama");
		$reqKeterangan = httpFilterPost("reqKeterangan");
		$reqPuspel = httpFilterPost("reqPuspel");
		$reqStatus= httpFilterPost("reqStatus");
		$reqTmtAktif= httpFilterPost("reqTmtAktif");
		$reqTmtNonAktif= httpFilterPost("reqTmtNonAktif");
		$reqKodeSubBantu = httpFilterPost("reqKodeSubBantu");

		if($reqMode == "insert")
		{
			$departemen->setField("DEPARTEMEN_ID", $reqId);
			$departemen->setField("CABANG_ID", 1);
			$departemen->setField("NAMA", $reqNama);
			$departemen->setField("KETERANGAN", $reqKeterangan);
			$departemen->setField("PUSPEL", $reqPuspel);
			$departemen->setField("STATUS_AKTIF", $reqStatus);
			$departemen->setField("TMT_AKTIF", dateToDBCheck($reqTmtAktif));
			$departemen->setField("TMT_NON_AKTIF", dateToDBCheck($reqTmtNonAktif));
			$departemen->setField("KODE_SUB_BANTU", $reqKodeSubBantu);
			if($departemen->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$departemen->setField("DEPARTEMEN_ID", $reqId);
			$departemen->setField("NAMA", $reqNama);
			$departemen->setField("KETERANGAN", $reqKeterangan);
			$departemen->setField("PUSPEL", $reqPuspel);
			$departemen->setField("STATUS_AKTIF", $reqStatus);
			$departemen->setField("TMT_AKTIF", dateToDBCheck($reqTmtAktif));
			$departemen->setField("TMT_NON_AKTIF", dateToDBCheck($reqTmtNonAktif));
			$departemen->setField("KODE_SUB_BANTU", $reqKodeSubBantu);		
			if($departemen->update())
				echo "Data berhasil disimpan.";
			
		}
	}
	
	function departemen_combo_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
		include_once("../WEB-INF/classes/base-simpeg/Cabang.php");


		/* create objects */

		$departemen = new Departemen();
		$cabang = new Cabang();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$cabang->selectByParams(array());
		$arr_json = array();
		$i = 0;
		while($cabang->nextRow())
		{
			$arr_json[$i]['id'] = "CAB".$cabang->getField("CABANG_ID");
			$arr_json[$i]['text'] = $cabang->getField("NAMA");

			$j=0;
			$departemen = new Departemen();
			$departemen->selectByParams(array("STATUS_AKTIF" => 1, "CABANG_ID" => $cabang->getField("CABANG_ID"), "DEPARTEMEN_PARENT_ID" => 0));
			while($departemen->nextRow())
			{
				$arr_parent[$j]['id'] = $departemen->getField("DEPARTEMEN_ID");
				$arr_parent[$j]['text'] = $departemen->getField("NAMA");
				$k = 0;
				$child = new Departemen();
				$child->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => $departemen->getField("DEPARTEMEN_ID")));
				while($child->nextRow())
				{
					$arr_child[$k]['id'] = $child->getField("DEPARTEMEN_ID");
					$arr_child[$k]['text'] = $child->getField("NAMA");
					
					$l = 0;
					$sub = new Departemen();
					$sub->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => $child->getField("DEPARTEMEN_ID")));
					while($sub->nextRow())
					{
						$arr_sub[$l]['id'] = $sub->getField("DEPARTEMEN_ID");
						$arr_sub[$l]['text'] = $sub->getField("NAMA");	
						$l++;
					}
					
					$arr_child[$k]['children'] = $arr_sub;
					unset($sub);
					unset($arr_sub);
					$k++;
				}
				$arr_parent[$j]['children'] = $arr_child;
				
				unset($child);
				unset($arr_child);
				
				$j++;
			}
			
			$arr_json[$i]['children'] = $arr_parent;
			unset($departemen);	
			unset($arr_parent);
			$i++;
		}

		echo json_encode($arr_json);
	}
	
	function departemen_combotree_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Departemen.php");


		/* create objects */

		$departemen = new Departemen();

		$reqId = httpFilterGet("reqId");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqDepartemenId = httpFilterGet("reqDepartemenId");
		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$j=0;
		while($j < 1)
		{
			$arr_parent[$j]['id'] = "CAB1";
			$arr_parent[$j]['text'] = "Kantor Pusat PT. PMS";
			if($reqDepartemenId == "CAB1")
				$arr_parent[$j]['checked'] = true;
			$k = 0;
			
			$k = 0;
			$child = new Departemen();
			$child->selectByParamsDepartemenHasilRapat(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => 0), -1, -1, "", $reqId);
			while($child->nextRow())
			{
				$arr_child[$k]['id'] = $child->getField("DEPARTEMEN_ID");
				$arr_child[$k]['text'] = $child->getField("NAMA");
				if($child->getField("DEPARTEMEN_ID") == $child->getField("DEPARTEMEN_ID_HASIL_RAPAT"))
					$arr_child[$k]['checked'] = true;
				
				$k++;
			}
			$arr_parent[$j]['children'] = $arr_child;
			
			unset($child);
			unset($arr_child);
			
			$j++;
		}

		echo json_encode($arr_parent);
	}
	
	function departemen_detil_combo_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
		include_once("../WEB-INF/classes/base-simpeg/Cabang.php");


		/* create objects */

		$reqDepartemen = httpFilterGet("reqDepartemen");

		$departemen_awal = new Departemen();
		$cabang = new Cabang();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$departemen_awal->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_ID" => substr($reqDepartemen, 0, 2)));
		$arr_json = array();
		$i = 0;
		while($departemen_awal->nextRow())
		{
			$arr_json[$i]['id'] = $departemen_awal->getField("DEPARTEMEN_ID");
			$arr_json[$i]['text'] = $departemen_awal->getField("NAMA");

			$j=0;
			$departemen = new Departemen();
			$departemen->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => $departemen_awal->getField("DEPARTEMEN_ID")));
			while($departemen->nextRow())
			{
				$arr_parent[$j]['id'] = $departemen->getField("DEPARTEMEN_ID");
				$arr_parent[$j]['text'] = $departemen->getField("NAMA");
				$k = 0;
				$child = new Departemen();
				$child->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => $departemen->getField("DEPARTEMEN_ID")));
				while($child->nextRow())
				{
					$arr_child[$k]['id'] = $child->getField("DEPARTEMEN_ID");
					$arr_child[$k]['text'] = $child->getField("NAMA");
					
					$l = 0;
					$sub = new Departemen();
					$sub->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => $child->getField("DEPARTEMEN_ID")));
					while($sub->nextRow())
					{
						$arr_sub[$l]['id'] = $sub->getField("DEPARTEMEN_ID");
						$arr_sub[$l]['text'] = $sub->getField("NAMA");	
						$l++;
					}
					
					$arr_child[$k]['children'] = $arr_sub;
					unset($sub);
					unset($arr_sub);
					$k++;
				}
				$arr_parent[$j]['children'] = $arr_child;
				
				unset($child);
				unset($arr_child);
				
				$j++;
			}
			
			$arr_json[$i]['children'] = $arr_parent;
			unset($departemen);	
			unset($arr_parent);
			$i++;
		}

		echo json_encode($arr_json);
	}
	
	function departemen_pusat_combo_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
		include_once("../WEB-INF/classes/base-simpeg/Cabang.php");


		/* create objects */

		$departemen = new Departemen();
		$cabang = new Cabang();

		$reqDepartemen = httpFilterGet("reqDepartemen");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$cabang->selectByParams(array());
		$arr_json = array();
		$i = 0;
		while($cabang->nextRow())
		{
			$arr_json[$i]['id'] = "CAB".$cabang->getField("CABANG_ID");
			$arr_json[$i]['text'] = $cabang->getField("NAMA");

			$j=0;
			$departemen = new Departemen();
			$departemen->selectByParams(array("STATUS_AKTIF" => 1, "CABANG_ID" => $cabang->getField("CABANG_ID"), "DEPARTEMEN_ID" => substr($reqDepartemen, 0, 2)));
			while($departemen->nextRow())
			{
				$arr_parent[$j]['id'] = $departemen->getField("DEPARTEMEN_ID");
				$arr_parent[$j]['text'] = $departemen->getField("NAMA");
				$k = 0;
				$child = new Departemen();
				$child->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => $departemen->getField("DEPARTEMEN_ID")));
				while($child->nextRow())
				{
					$arr_child[$k]['id'] = $child->getField("DEPARTEMEN_ID");
					$arr_child[$k]['text'] = $child->getField("NAMA");
					
					$l = 0;
					$sub = new Departemen();
					$sub->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => $child->getField("DEPARTEMEN_ID")));
					while($sub->nextRow())
					{
						$arr_sub[$l]['id'] = $sub->getField("DEPARTEMEN_ID");
						$arr_sub[$l]['text'] = $sub->getField("NAMA");	
						$l++;
					}
					
					$arr_child[$k]['children'] = $arr_sub;
					unset($sub);
					unset($arr_sub);
					$k++;
				}
				$arr_parent[$j]['children'] = $arr_child;
				
				unset($child);
				unset($arr_child);
				
				$j++;
			}
			
			$arr_json[$i]['children'] = $arr_parent;
			unset($departemen);	
			unset($arr_parent);
			$i++;
		}

		echo json_encode($arr_json);
	}

}
?>
