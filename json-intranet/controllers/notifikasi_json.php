<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class notifikasi_json extends CI_Controller {

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
	
	
	function notifikasi_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/Notifikasi.php");
		include_once("../WEB-INF/classes/base/NotifikasiUserLogin.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$notifikasi = new Notifikasi();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqUserLogin= $_POST['reqUserLogin'];
		$reqEmailUserTerkait= httpFilterPost("reqEmailUserTerkait");
		$reqNama= httpFilterPost("reqNama");
		$reqKeterangan= httpFilterPost("reqKeterangan");
		$reqKirim= httpFilterPost("reqKirim");
		$reqUserLoginId= httpFilterPost("reqUserLoginId");
		$reqUserLogin= httpFilterPost("reqUserLogin");

		if($reqMode == "update")
		{
			//echo $reqUserLogin.'---';
			//$notifikasi->setField("NOTIFIKASI_ID", $reqId);
			//$notifikasi->delete();
			
			$notifikasi->setField("NOTIFIKASI_ID", $reqId);
			$notifikasi->setField("EMAIL_USER_TERKAIT", setNULL($reqEmailUserTerkait));
			$notifikasi->setField("NAMA", $reqNama);
			$notifikasi->setField("KIRIM_HARI_MINUS", setNULL($reqKirim));
			$notifikasi->setField("KETERANGAN", $reqKeterangan);
			
			if($notifikasi->update())
			{
				$set=new Notifikasi();
				$set->setField("NOTIFIKASI_ID", $reqId);
				if($set->delete())
				{
					$arrUserLogin=explode(',',$reqUserLoginId);
					for($i=0;$i<count($arrUserLogin);$i++)
					{
						$child=new NotifikasiUserLogin();
						$child->setField('USER_LOGIN_ID',$arrUserLogin[$i]);
						$child->setField('NOTIFIKASI_ID',$reqId);
						$child->insert();
					}
				}
				
				
				echo "Data berhasil disimpan.";
			}
		}
	}
	
	function json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/Notifikasi.php");

		$notifikasi = new Notifikasi();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("NOTIFIKASI_ID", "NAMA", "KETERANGAN", "EMAIL_USER_TERKAIT", "KIRIM_HARI_MINUS", "NOTIFIKASI_USER_LOGIN");
		$aColumnsAlias = array("NOTIFIKASI_ID", "A.NAMA", "A.KETERANGAN", "A.EMAIL_USER_TERKAIT", "A.KIRIM_HARI_MINUS", "NOTIFIKASI_USER_LOGIN");

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
			if ( trim($sOrder) == "ORDER BY NOTIFIKASI_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY NAMA ASC";
				 
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


		$allRecord = $notifikasi->getCountByParams(array());
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $notifikasi->getCountByParams(array(), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$notifikasi->selectByParams(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		

		//echo $notifikasi->query;
		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($notifikasi->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($notifikasi->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($notifikasi->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $notifikasi->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function notifikasi_setting()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/UserLoginBase.php");


		/* create objects */
		$reqEmail= httpFilterPost("reqEmail");

		$headerSettingEmail = array();
		function start_element($parser, $name, $attrs)
		{
			global $headerSettingEmail;
			if($name == "settingEmail")
			{
				array_push($headerSettingEmail, $attrs);
			}
		}
		function end_element ($parser, $name){}

		$playlist_string = file_get_contents("../WEB-INF/setting_email.xml");
		$parser = xml_parser_create();
		xml_set_element_handler($parser, "start_element", "end_element");
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parse($parser, $playlist_string) or die("Error parsing XML document.");

		$headerSettingEmail_final = array();
		foreach($headerSettingEmail as $settingEmail){
			if($settingEmail['title'] == 'Email'){}
			else
			{
				array_push($headerSettingEmail_final, $settingEmail);
			}
		}

		array_push($headerSettingEmail_final, array(
						"title" => 'Email',
						"path" => $reqEmail
						)
					);

		$write_string = "<headerSettingEmail>";
		foreach($headerSettingEmail_final as $settingEmail){
			$write_string .= "<settingEmail title=\"$settingEmail[title]\" path=\"$settingEmail[path]\" />";
		}
		$write_string .= "</headerSettingEmail>";
		//$fp = fopen("setting_email.xml", "w+");
		$fp = fopen("../WEB-INF/setting_email.xml", "w+");
		fwrite($fp, $write_string) or die("Error writing to file");
		fclose($fp);

		echo '1';
	}

}
?>
