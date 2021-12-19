<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class user_json extends CI_Controller {

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
	
	
	function user_group_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/UserGroup.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$user_group = new UserGroup();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqNama = httpFilterPost("reqNama");
		$reqAksesIntranet = httpFilterPost("reqAksesIntranet");
		$reqAplikasiDatabase = httpFilterPost("reqAplikasiDatabase");
		$reqAplikasiOperasional = httpFilterPost("reqAplikasiOperasional");
		$reqAplikasiKepegawaian = httpFilterPost("reqAplikasiKepegawaian");
		$reqAplikasiPenghasilan = httpFilterPost("reqAplikasiPenghasilan");
		$reqAplikasiPresensi = httpFilterPost("reqAplikasiPresensi");
		$reqAplikasiPenilaian = httpFilterPost("reqAplikasiPenilaian");
		$reqAplikasiKomersial = httpFilterPost("reqAplikasiKomersial");
		$reqAplikasiBackup = httpFilterPost("reqAplikasiBackup");
		$reqAplikasiHukum = httpFilterPost("reqAplikasiHukum");
		$reqAdministrasiWebsite = httpFilterPost("reqAdministrasiWebsite");
		$reqAplikasiSurvey = httpFilterPost("reqAplikasiSurvey");
		$reqAplikasiFileManager = httpFilterPost("reqAplikasiFileManager");
		$reqAplikasiArsip = httpFilterPost("reqAplikasiArsip");
		$reqAplikasiInventaris = httpFilterPost("reqAplikasiInventaris");
		$reqAplikasiNotifikasi = httpFilterPost("reqAplikasiNotifikasi");
		$reqAplikasiSPPD = httpFilterPost("reqAplikasiSPPD");
		$reqPublish = httpFilterPost("reqPublish");
		$reqSMSGateway = httpFilterPost("reqSMSGateway");
		$reqKeuangan = httpFilterPost("reqKeuangan");
		$reqAksesKontrakHukum = httpFilterPost("reqAksesKontrakHukum");
		$reqAplikasiGalangan = httpFilterPost("reqAplikasiGalangan");
		$reqAplikasiAnggaran = httpFilterPost("reqAplikasiAnggaran");
		$reqAplikasiKeuangan = httpFilterPost("reqAplikasiKeuangan");
		//echo "kode:".$reqAplikasiGalangan;

		if(($reqMode == "add") || ($reqMode == "copy"))
		{
			$user_group->setField("NAMA", $reqNama);
			$user_group->setField("AKSES_APP_OPERASIONAL_ID", $reqAplikasiOperasional);
			$user_group->setField("AKSES_APP_ARSIP_ID", $reqAplikasiArsip);
			$user_group->setField("AKSES_APP_INVENTARIS_ID", $reqAplikasiInventaris);
			$user_group->setField("AKSES_APP_SPPD_ID", $reqAplikasiSPPD);
			$user_group->setField("AKSES_APP_KEPEGAWAIAN_ID", $reqAplikasiKepegawaian);
			$user_group->setField("AKSES_APP_PENGHASILAN_ID", $reqAplikasiPenghasilan);
			$user_group->setField("AKSES_APP_PRESENSI_ID", $reqAplikasiPresensi);
			$user_group->setField("AKSES_APP_PENILAIAN_ID", $reqAplikasiPenilaian);
			$user_group->setField("AKSES_APP_BACKUP_ID", $reqAplikasiBackup);
			$user_group->setField("AKSES_APP_HUKUM_ID", $reqAplikasiHukum);
			$user_group->setField("AKSES_APP_KOMERSIAL_ID", $reqAplikasiKomersial);
			$user_group->setField("AKSES_ADM_WEBSITE_ID", $reqAdministrasiWebsite);	
			$user_group->setField("AKSES_ADM_INTRANET_ID", $reqAksesIntranet);	
			$user_group->setField("AKSES_APP_SURVEY_ID", $reqAplikasiSurvey);		
			$user_group->setField("AKSES_APP_FILE_MANAGER_ID", $reqAplikasiFileManager);	
			$user_group->setField("AKSES_SMS_GATEWAY", $reqSMSGateway);		
			$user_group->setField("PUBLISH_KANTOR_PUSAT", $reqPublish);	
			$user_group->setField("AKSES_KEUANGAN", $reqKeuangan);	
			$user_group->setField("AKSES_KONTRAK_HUKUM", $reqAksesKontrakHukum);
			$user_group->setField("AKSES_APP_NOTIFIKASI_ID", $reqAplikasiNotifikasi);
			$user_group->setField("AKSES_APP_GALANGAN_ID", $reqAplikasiGalangan);
			$user_group->setField("AKSES_APP_ANGGARAN_ID", $reqAplikasiAnggaran);
			$user_group->setField("AKSES_APP_KEUANGAN_ID", $reqAplikasiKeuangan);
			
			//echo $user_group->query;
			if($user_group->insert())
			{	echo $user_group->query;
				echo "Data berhasil disimpan.";
			}
		}
		elseif($reqMode == "edit")
		{
			$user_group->setField("USER_GROUP_ID", $reqId);
			$user_group->setField("NAMA", $reqNama);
			$user_group->setField("AKSES_APP_OPERASIONAL_ID", $reqAplikasiOperasional);
			$user_group->setField("AKSES_APP_ARSIP_ID", $reqAplikasiArsip);
			$user_group->setField("AKSES_APP_INVENTARIS_ID", $reqAplikasiInventaris);
			$user_group->setField("AKSES_APP_SPPD_ID", $reqAplikasiSPPD);
			$user_group->setField("AKSES_APP_KEPEGAWAIAN_ID", $reqAplikasiKepegawaian);
			$user_group->setField("AKSES_APP_PENGHASILAN_ID", $reqAplikasiPenghasilan);

			$user_group->setField("AKSES_APP_PRESENSI_ID", $reqAplikasiPresensi);
			$user_group->setField("AKSES_APP_PENILAIAN_ID", $reqAplikasiPenilaian);
			$user_group->setField("AKSES_APP_BACKUP_ID", $reqAplikasiBackup);
			$user_group->setField("AKSES_APP_HUKUM_ID", $reqAplikasiHukum);
			$user_group->setField("AKSES_APP_KOMERSIAL_ID", $reqAplikasiKomersial);
			$user_group->setField("AKSES_ADM_WEBSITE_ID", $reqAdministrasiWebsite);	
			$user_group->setField("AKSES_ADM_INTRANET_ID", $reqAksesIntranet);	
			$user_group->setField("AKSES_APP_SURVEY_ID", $reqAplikasiSurvey);		
			$user_group->setField("AKSES_APP_FILE_MANAGER_ID", $reqAplikasiFileManager);		
			$user_group->setField("AKSES_SMS_GATEWAY", $reqSMSGateway);		
			$user_group->setField("PUBLISH_KANTOR_PUSAT", $reqPublish);		
			$user_group->setField("AKSES_KEUANGAN", $reqKeuangan);	
			$user_group->setField("AKSES_KONTRAK_HUKUM", $reqAksesKontrakHukum);	
			$user_group->setField("AKSES_APP_NOTIFIKASI_ID", $reqAplikasiNotifikasi);
			$user_group->setField("AKSES_APP_GALANGAN_ID", $reqAplikasiGalangan);
			$user_group->setField("AKSES_APP_ANGGARAN_ID", $reqAplikasiAnggaran);
			$user_group->setField("AKSES_APP_KEUANGAN_ID", $reqAplikasiKeuangan);

			if($user_group->update()) { 
				echo "Data berhasil disimpan.";
			}
			
		}
	}
	
	function user_group_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/UserGroup.php");

		$user_group = new UserGroup();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("USER_GROUP_ID", "NAMA", "AKSES_APP_OPERASIONAL", "AKSES_APP_KEPEGAWAIAN", "AKSES_APP_PENGHASILAN", "AKSES_APP_PRESENSI", "AKSES_APP_PENILAIAN", "AKSES_APP_BACKUP", "AKSES_APP_KOMERSIAL", "AKSES_ADM_WEBSITE", "AKSES_ADM_INTRANET", "AKSES_APP_SURVEY", "PUBLISH_KANTOR_PUSAT", "AKSES_APP_FILE_MANAGER", "AKSES_SMS_GATEWAY", "AKSES_APP_ARSIP", "AKSES_APP_INVENTARIS", "AKSES_APP_SPPD", "AKSES_APP_HUKUM", "AKSES_KEUANGAN", "AKSES_KONTRAK_HUKUM", "AKSES_APP_NOTIFIKASI","AKSES_APP_GALANGAN", "AKSES_APP_ANGGARAN");
		$aColumnsAlias = array("USER_GROUP_ID", "NAMA", "AKSES_APP_OPERASIONAL", "AKSES_APP_KEPEGAWAIAN", "AKSES_APP_PENGHASILAN", "AKSES_APP_PRESENSI", "AKSES_APP_PENILAIAN", "AKSES_APP_BACKUP", "AKSES_APP_KOMERSIAL", "AKSES_ADM_WEBSITE", "AKSES_ADM_INTRANET", "AKSES_APP_SURVEY", "PUBLISH_KANTOR_PUSAT", "AKSES_APP_FILE_MANAGER", "AKSES_SMS_GATEWAY", "AKSES_APP_ARSIP", "AKSES_APP_INVENTARIS", "AKSES_APP_SPPD", "AKSES_APP_HUKUM", "AKSES_KEUANGAN", "AKSES_KONTRAK_HUKUM", "AKSES_APP_NOTIFIKASI_ID","AKSES_APP_GALANGAN", "AKSES_APP_ANGGARAN");               

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
			if ( trim($sOrder) == "ORDER BY USER_GROUP_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
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


		$allRecord = $user_group->getCountByParams(array());
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $user_group->getCountByParams(array(), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$user_group->selectByParams(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		


		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($user_group->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($user_group->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($user_group->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $user_group->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function user_login_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/UserLoginBase.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$user_login = new UserLoginBase();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqDepartemen = httpFilterPost("reqDepartemen");
		$reqUserGroup = httpFilterPost("reqUserGroup");
		$reqNama = httpFilterPost("reqNama");
		$reqJabatan = httpFilterPost("reqJabatan");
		$reqEmail = httpFilterPost("reqEmail");
		$reqTelepon = httpFilterPost("reqTelepon");
		$reqUserLogin = httpFilterPost("reqUserLogin");
		$reqUserPassword = httpFilterPost("reqUserPassword");
		$reqSubmit = httpFilterPost("reqSubmit");
		$reqPegawaiId = httpFilterPost("reqPegawaiId");

		if($reqDepartemen == 0)
			$reqDepartemen = "NULL";
		else
			$reqDepartemen = "'".$reqDepartemen."'";

		if($reqMode == "insert")
		{
			if($reqPegawaiId == "")
			{
				echo "Data gagal disimpan. Silahkan pilih pegawai terlebih dahulu.|0";
			}
			else
			{
				$user_login->setField("DEPARTEMEN_ID", $reqDepartemen);
				$user_login->setField("USER_GROUP_ID", $reqUserGroup);
				$user_login->setField("NAMA", $reqNama);
				$user_login->setField("JABATAN", $reqJabatan);
				$user_login->setField("EMAIL", $reqEmail);
				$user_login->setField("TELEPON", $reqTelepon);
				$user_login->setField("USER_LOGIN", $reqUserLogin);
				$user_login->setField("USER_PASS", $reqUserPassword);
				$user_login->setField("STATUS", 1);
				$user_login->setField("LAST_CREATE_USER", $userLogin->UID);
				$user_login->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
				$user_login->setField("PEGAWAI_ID", $reqPegawaiId);	
			
				if($user_login->insert())
				{
					echo "Data berhasil disimpan|" . $user_login->getField('USER_LOGIN_ID'); 
					define("AJXP_EXEC", true);
					$glueCode = "../filemanager/plugins/auth.remote/glueCode.php";
					$secret = "myprivatesecret";
				
					// Initialize the "parameters holder"
					global $AJXP_GLUE_GLOBALS;
					$AJXP_GLUE_GLOBALS = array();
					$AJXP_GLUE_GLOBALS["secret"] = $secret;
					$AJXP_GLUE_GLOBALS["plugInAction"] = "addUser";
					$AJXP_GLUE_GLOBALS["autoCreate"] = true;
				
					// NOTE THE md5() call on the password field.
					$AJXP_GLUE_GLOBALS["user"] = array("name" => $reqUserLogin, "password" => md5($reqUserPassword."valsix"));
					// NOW call glueCode!
					include($glueCode);
				}
			}
			//echo $user_login->query;
		}
		else if($reqMode == "updateIdWeb"){
			$user_login->setField("USER_LOGIN_ID", $reqId);
			$user_login->setField("USER_LOGIN_ID_WEBSITE", $reqIdWebsite);
			if($user_login->updateIdWeb()){
				echo "Data berhasil disimpan."; 
			}
		}
		else
		{
			$user_login->setField("USER_LOGIN_ID", $reqId);
			$user_login->setField("DEPARTEMEN_ID", $reqDepartemen);
			$user_login->setField("USER_GROUP_ID", $reqUserGroup);
			$user_login->setField("NAMA", $reqNama);
			$user_login->setField("JABATAN", $reqJabatan);
			$user_login->setField("EMAIL", $reqEmail);
			$user_login->setField("TELEPON", $reqTelepon);
			$user_login->setField("LAST_UPDATE_USER", $userLogin->UID);
			$user_login->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			$user_login->setField("PEGAWAI_ID", $reqPegawaiId);	
			
			if($user_login->update())
				echo "Data berhasil disimpan|" . $reqId; 
			
		}
	}
	
	function user_login_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/UserLoginBase.php");

		$user_login = new UserLoginBase();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqGroupUser = httpFilterGet("reqGroupUser");
		$reqStatus = httpFilterGet("reqStatus");


		$aColumns = array("USER_LOGIN_ID", "DEPARTEMEN", "USER_GROUP", "NAMA", "USER_LOGIN", "JABATAN", "TELEPON", "STATUS", "STATUS_PEGAWAI");
		$aColumnsAlias = array("USER_LOGIN_ID", "B.NAMA", "C.NAMA", "A.NAMA", "USER_LOGIN", "JABATAN", "TELEPON", "STATUS", "F.NAMA");

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
			if ( trim($sOrder) == "ORDER BY USER_LOGIN_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY C.NAMA ASC";
				 
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


		if($reqGroupUser == "")
		{}
		else
			$statement = " AND A.USER_GROUP_ID = '".$reqGroupUser."' ";

		$arrStatus = explode("-", $reqStatus);

		$statement .= " AND STATUS = '".$arrStatus[0]."' AND F.STATUS_PEGAWAI_ID IN (".$arrStatus[1].") ";

		$allRecord = $user_login->getCountByParams(array(), $statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $user_login->getCountByParams(array(), $statement." AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$user_login->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($user_login->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($user_login->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($user_login->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $user_login->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function user_login_lookup_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/UserLoginBase.php");


		/* create objects */

		$user_login = new UserLoginBase();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$q = isset($_POST['q']) ? $_POST['q'] : ''; 

		if($q == '')
			$statement='';
		else
			$statement=" AND A.NAMA like '".$q."%' ";

		$statement='';
			
		$total= $user_login->getCountByParams(array(),$statement);
		$arr_json['total'] = $total;

			$j=0;
			$user_login->selectByParams(array(),-1,-1,$statement);
			while($user_login->nextRow())
			{
				$arr_parent[$j]['id'] = $user_login->getField("USER_LOGIN_ID");
				$arr_parent[$j]['text'] = $user_login->getField("NAMA");
				$arr_parent[$j]['email'] = $user_login->getField("EMAIL");
				$j++;
			}
			$arr_json['rows'] = $arr_parent;
			
		echo json_encode($arr_json);
	}
	
	function user_login_reset()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base/UserLoginBase.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* create objects */

		$user_login_base = new UserLoginBase();

		$reqId = httpFilterGet("reqId");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		define("AJXP_EXEC", true);
		$glueCode = "../filemanager/plugins/auth.remote/glueCode.php";
		$secret = "myprivatesecret";

		// Initialize the "parameters holder"
		global $AJXP_GLUE_GLOBALS;
		$AJXP_GLUE_GLOBALS = array();
		$AJXP_GLUE_GLOBALS["secret"] = $secret;
		$AJXP_GLUE_GLOBALS["plugInAction"] = "updateUser";
		$AJXP_GLUE_GLOBALS["autoCreate"] = false;

		// NOTE THE md5() call on the password field.
		$AJXP_GLUE_GLOBALS["user"] = array("name" => $userLogin->idUser, "password" => md5($userLogin->idUser."valsix"));
		// NOW call glueCode!
		include($glueCode);

		$user_login_base->setField("FIELD", "USER_PASS");
		$user_login_base->setField("FIELD_VALUE", "MD5(USER_LOGIN)");
		$user_login_base->setField("USER_LOGIN_ID", $reqId);
		$user_login_base->updateByFieldTanpaPetik();
		$met = array();
		$i=0;

		$met[0]['STATUS'] = 1;
		echo json_encode($met);
	}
	
	function user_login_set_status()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base/UserLoginBase.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* create objects */

		$user_login_base = new UserLoginBase();

		$reqId = httpFilterGet("reqId");
		$reqNilai = httpFilterGet("reqNilai");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

			$user_login_base->setField("FIELD", "STATUS");
			$user_login_base->setField("FIELD_VALUE", $reqNilai);
			$user_login_base->setField("USER_LOGIN_ID", $reqId);
			$user_login_base->updateByField();
		$met = array();
		$i=0;

		$met[0]['STATUS'] = 1;
		echo json_encode($met);
	}

}
?>
