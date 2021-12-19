<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class direktorat_json extends CI_Controller {

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
	
	
	function direktorat_p3_combo_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/DirektoratP3.php");
		include_once("../WEB-INF/classes/base-simpeg/CabangP3.php");


		/* create objects */

		$direktorat_p3 = new DirektoratP3();
		$cabang_p3 = new CabangP3();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$cabang_p3->selectByParams(array());
		$arr_json = array();
		$i = 0;
		while($cabang_p3->nextRow())
		{
			$arr_json[$i]['id'] = "CAB".$cabang_p3->getField("CABANG_P3_ID");
			$arr_json[$i]['text'] = $cabang_p3->getField("NAMA");

			$j=0;
			$direktorat_p3->selectByParams(array("CABANG_P3_ID" => $cabang_p3->getField("CABANG_P3_ID"), "DIREKTORAT_P3_PARENT_ID" => 0));
			while($direktorat_p3->nextRow())
			{
				$arr_parent[$j]['id'] = $direktorat_p3->getField("DIREKTORAT_P3_ID");
				$arr_parent[$j]['text'] = $direktorat_p3->getField("NAMA");
				$k = 0;
				$child = new DirektoratP3();
				$child->selectByParams(array("DIREKTORAT_P3_PARENT_ID" => $direktorat_p3->getField("DIREKTORAT_P3_ID")));
				while($child->nextRow())
				{
					$arr_child[$k]['id'] = $child->getField("DIREKTORAT_P3_ID");
					$arr_child[$k]['text'] = $child->getField("NAMA");
					
					$l = 0;
					$sub = new DirektoratP3();
					$sub->selectByParams(array("DIREKTORAT_P3_PARENT_ID" => $child->getField("DIREKTORAT_P3_ID")));
					while($sub->nextRow())
					{
						$arr_sub[$l]['id'] = $sub->getField("DIREKTORAT_P3_ID");
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
			unset($direktorat_p3);	
			unset($arr_parent);
			$i++;
		}

		echo json_encode($arr_json);
	}

}
?>
