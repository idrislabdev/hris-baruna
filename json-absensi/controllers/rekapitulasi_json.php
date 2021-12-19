<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class rekapitulasi_json extends CI_Controller {

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
	
	
	function rekapitulasi_absensi_import_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiImport.php");

		$set = new AbsensiImport();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array('FINGER_ID', 'NRP', 'NAMA', 'DEPARTEMEN', 'JAM_MONITORING');
		$aColumnsAlias = array('FINGER_ID', 'B.NRP', 'B.NAMA', 'C.NAMA', 'JAM_MONITORING');

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
			if ( trim($sOrder) == "ORDER BY NAMA asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY B.NAMA ASC";
				 
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

		$statement_json= " AND (UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.FINGER_ID) LIKE '%".strtoupper($_GET['sSearch'])."%')";
		$allRecord = $set->getCountByParamsMonitoring(array("USER_LOGIN_ID" => $userLogin->UID));
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $set->getCountByParamsMonitoring(array("USER_LOGIN_ID" => $userLogin->UID), $statement_json);

		$set->selectByParamsMonitoring(array("USER_LOGIN_ID" => $userLogin->UID), $dsplyRange, $dsplyStart, $statement_json, $sOrder);

		//echo "IKI ".$_GET['iDisplayStart'];

			/*
			 * Output 
			 */
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $allRecord,
				"iTotalDisplayRecords" => $allRecordFilter,
				"aaData" => array()
			);
			
			while($set->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if($aColumns[$i] == "JAM")
					{
						$row[] = getFormattedDateTime($set->getField(trim($aColumns[$i])));
					}
					else
					$row[] = $set->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;
				$duk++;
			}
			
			echo json_encode( $output );
	}
	
	function rekapitulasi_absensi_import_proses()
	{
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiImport.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);
		//$reqLinkFile= $_FILES['reqLinkFile'];
		$reqMesin = httpFilterPost("reqMesin");
		//$data = file_get_contents("tes.dat"); //read the file
		$data = file_get_contents($_FILES['reqLinkFile']['tmp_name']); //read the file

		$convert = explode("\n", $data); //create array separate by new line

		$set= new AbsensiImport();
		$set->setField("STATUS", 0);
		$set->setField("USER_LOGIN_ID", $userLogin->UID);
		$set->delete();
		unset($set);

		for ($i=0;$i<count($convert);$i++) 
		{
			$data= explode("	", $convert[$i]);
			
			$reqFinggerId= $data[0];
			$reqJam= $data[1];
			$reqStatus= $data[2];
			
			if($reqStatus == 0)
				$reqStatus = "O";
			else
				$reqStatus = "I";
			
			
			if($reqFinggerId == ""){}
			else
			{
				$reqJam= datetimeToPage($reqJam, "date")." ".datetimeToPage($reqJam,"");
				$set= new AbsensiImport();
				$set->setField("FINGER_ID", $reqFinggerId);
				$set->setField("JAM", dateTimeToDBCheck($reqJam));
				$set->setField("STATUS", $reqStatus);
				$set->setField("USER_LOGIN_ID", $userLogin->UID);
				$set->setField("LAST_CREATE_USER", $userLogin->nama);
				$set->setField("LAST_CREATE_DATE", OCI_SYSDATE);
				$set->setField("MESIN_ID", $reqMesin);
				$set->insert();
				//echo $set->query;
				unset($set);
			}
		}
		echo "Data berhasil diproses.";
	}
	
	function rekapitulasi_absensi_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$absensi_rekap = new AbsensiRekap();

		/* LOGIN CHECK */

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqKeterangan = httpFilterRequest("reqKeterangan");
		$reqId = httpFilterRequest("reqId");
		$reqSearch = httpFilterGet("reqSearch");
		$reqBulan = httpFilterGet("reqBulan");
		$reqTahun = httpFilterGet("reqTahun");
		$reqMode = httpFilterGet("reqMode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqJenisPegawai= httpFilterGet("reqJenisPegawai");

		/*
		$aColumns = array("NRP", "NAMA", "IN_1", "OUT_1", "IN_2", "OUT_2", "IN_3", "OUT_3", "IN_4", "OUT_4", "IN_5", "OUT_5", "IN_6", "OUT_6", "IN_7", "OUT_7", "IN_8", "OUT_8", "IN_9", "OUT_9", "IN_10", "OUT_10", 
		"IN_11", "OUT_11", "IN_12", "OUT_12", "IN_13", "OUT_13", "IN_14", "OUT_14", "IN_15", "OUT_15", "IN_16", "OUT_16", "IN_17", "OUT_17", "IN_18", "OUT_18", "IN_19", "OUT_19", "IN_20", 
		"OUT_20", "IN_21", "OUT_21", "IN_22", "OUT_22", "IN_23", "OUT_23", "IN_24", "OUT_24", "IN_25", "OUT_25", "IN_26", "OUT_26", "IN_27", "OUT_27", "IN_28", "OUT_28", "IN_29", "OUT_29", "IN_30", 
		"OUT_30", "IN_31", "OUT_31");
		*/

		$aColumns = array("NRP", "NAMA", "JABATAN", "KELAS", "IN_1", "OUT_1", "JJ_1", "IN_2", "OUT_2", "JJ_2", "IN_3", "OUT_3", "JJ_3", "IN_4", "OUT_4", "JJ_4", "IN_5", "OUT_5", "JJ_5", "IN_6", "OUT_6", "JJ_6",
		 "IN_7", "OUT_7", "JJ_7", "IN_8", "OUT_8", "JJ_8", "IN_9", "OUT_9", "JJ_9", "IN_10", "OUT_10", "JJ_10", "IN_11", "OUT_11", "JJ_11", "IN_12", "OUT_12", "JJ_12",
		 "IN_13", "OUT_13", "JJ_13", "IN_14", "OUT_14", "JJ_14", "IN_15", "OUT_15", "JJ_15", "IN_16", "OUT_16", "JJ_16", "IN_17", "OUT_17", "JJ_17", "IN_18", "OUT_18", "JJ_18",
		 "IN_19", "OUT_19", "JJ_19", "IN_20", "OUT_20", "JJ_20", "IN_21", "OUT_21", "JJ_21", "IN_22", "OUT_22", "JJ_22", "IN_23", "OUT_23", "JJ_23", "IN_24", "OUT_24", "JJ_24", 
		 "IN_25", "OUT_25", "JJ_25", "IN_26", "OUT_26", "JJ_26", "IN_27", "OUT_27", "JJ_27", "IN_28", "OUT_28", "JJ_28", "IN_29", "OUT_29", "JJ_29", "IN_30", "OUT_30", "JJ_30",
		 "IN_31", "OUT_31", "JJ_31");



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
			if ( trim($sOrder) == " " )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = "  ";
				 
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


		$periode = $reqBulan.$reqTahun;
		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		if($reqJenisPegawai == '')
		{}
		else
			$statement .= 'AND JENIS_PEGAWAI_ID = '.$reqJenisPegawai;
				
				
		$allRecord = $absensi_rekap->getCountByParamsModif(array(), $statement, $periode);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $absensi_rekap->getCountByParamsModif(array(), $statement." AND UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'", $periode);
		//echo $absensi_rekap->query;exit;
		$absensi_rekap->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'", $periode, "ORDER BY KELAS, NAMA");     		
		//echo $absensi_rekap->query;exit;
		//echo "IKI ".$_GET['iDisplayStart'];

			/*
			 * Output 
			 */
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $allRecord,
				"iTotalDisplayRecords" => $allRecordFilter,
				"aaData" => array()
			);
			
			$duk = $dsplyStart + 1;
			while($absensi_rekap->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if($aColumns[$i] == "TTL")
						$row[] = $absensi_rekap->getField("TEMPAT_LAHIR").", ".getFormattedDate($absensi_rekap->getField("TANGGAL_LAHIR"));			
					elseif($aColumns[$i] == "MASA_KERJA")
						$row[] = $absensi_rekap->getField("MASA_KERJA_TAHUN")." - ".$absensi_rekap->getField("MASA_KERJA_BULAN");			
					elseif($aColumns[$i] == "TMT_PANGKAT" || $aColumns[$i] == "TMT_JABATAN" || $aColumns[$i] == "TMT_ESELON")
						$row[] = dateToPage($absensi_rekap->getField(trim($aColumns[$i])));	
					else
						$row[] = $absensi_rekap->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;
				$duk++;
			}
			
			echo json_encode( $output );
	}
	
	function rekapitulasi_jam_kerja_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$absensi_rekap = new AbsensiRekap();

		/* LOGIN CHECK */

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqKeterangan = httpFilterRequest("reqKeterangan");
		$reqId = httpFilterRequest("reqId");
		$reqSearch = httpFilterGet("reqSearch");
		$reqBulan = httpFilterGet("reqBulan");
		$reqTahun = httpFilterGet("reqTahun");
		$reqMode = httpFilterGet("reqMode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqJenisPegawai= httpFilterGet("reqJenisPegawai");

		$aColumns = array("NRP", "NAMA", "HARI_1", "HARI_2", "HARI_3", "HARI_4", "HARI_5", "HARI_6", "HARI_7", "HARI_8", "HARI_9", "HARI_10", 
							"HARI_11", "HARI_12", "HARI_13", "HARI_14", "HARI_15", "HARI_16", "HARI_17", "HARI_18", "HARI_19", "HARI_20", 
							"HARI_21", "HARI_22", "HARI_23", "HARI_24", "HARI_25", "HARI_26", "HARI_27", "HARI_28", "HARI_29", "HARI_30", "HARI_31");

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
			if ( trim($sOrder) == " " )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = "  ";
				 
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


		$periode = $reqBulan.$reqTahun;
		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		if($reqJenisPegawai == '')
		{}
		else
			$statement .= 'AND C.JENIS_PEGAWAI_ID = '.$reqJenisPegawai;
				
		$allRecord = $absensi_rekap->getCountByParams(array(), $statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $absensi_rekap->getCountByParams(array(), $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'");

		$absensi_rekap->selectByParamsRekapJamKerja(array(), $dsplyRange, $dsplyStart, $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'", $periode, "ORDER BY A.NAMA ASC");     		

		//echo "IKI ".$_GET['iDisplayStart'];

			/*
			 * Output 
			 */
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $allRecord,
				"iTotalDisplayRecords" => $allRecordFilter,
				"aaData" => array()
			);
			
			$duk = $dsplyStart + 1;
			while($absensi_rekap->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					$row[] = $absensi_rekap->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;
				$duk++;
			}
			
			echo json_encode( $output );
	}
	
	function rekapitulasi_kehadiran_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$absensi_rekap = new AbsensiRekap();

		/* LOGIN CHECK */

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqKeterangan = httpFilterRequest("reqKeterangan");
		$reqId = httpFilterRequest("reqId");
		$reqSearch = httpFilterGet("reqSearch");
		$reqBulan = httpFilterGet("reqBulan");
		$reqTahun = httpFilterGet("reqTahun");
		$reqMode = httpFilterGet("reqMode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqJenisPegawai= httpFilterGet("reqJenisPegawai");

		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA", "KELOMPOK", "JUMLAH_H", "H", "HT", "HPC", "HTPC", "JUMLAH_S", "STK", "SDK", "JUMLAH_I", "ITK", "IDK", "JUMLAH_C", "CT", "CAP", "CS", "CB", "DL", "JUMLAH_A");

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
			if ( trim($sOrder) == " " )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = "  ";
				 
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
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		$periode = $reqBulan.$reqTahun;

		if($reqJenisPegawai == '')
		{}
		else
			$statement .= 'AND C.JENIS_PEGAWAI_ID = '.$reqJenisPegawai;
			
		$allRecord = $absensi_rekap->getCountByParams(array(), $statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $absensi_rekap->getCountByParams(array(), $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'");

		$absensi_rekap->selectByParamsRekapKehadiranKoreksi($periode, array(), $dsplyRange, $dsplyStart, $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'", "ORDER BY A.NAMA ASC");     		

		//echo "IKI ".$_GET['iDisplayStart'];

			/*
			 * Output 
			 */
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $allRecord,
				"iTotalDisplayRecords" => $allRecordFilter,
				"aaData" => array()
			);
			
			$duk = $dsplyStart + 1;
			while($absensi_rekap->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					$row[] = $absensi_rekap->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;
				$duk++;
			}
			
			echo json_encode( $output );
	}
	
	function rekapitulasi_kehadiran_json_Copy()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$absensi_rekap = new AbsensiRekap();

		/* LOGIN CHECK */

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqKeterangan = httpFilterRequest("reqKeterangan");
		$reqId = httpFilterRequest("reqId");
		$reqSearch = httpFilterGet("reqSearch");
		$reqBulan = httpFilterGet("reqBulan");
		$reqTahun = httpFilterGet("reqTahun");
		$reqMode = httpFilterGet("reqMode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqStatusPegawai= httpFilterGet("reqStatusPegawai");

		$aColumns = array("PEGAWAI_ID","NAMA","HARI_KERJA","MASUK","CUTI","IJIN");

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
			if ( trim($sOrder) == " " )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = "  ";
				 
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
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		$periode = $reqBulan.$reqTahun;

		$reqTanggalAkhir = cal_days_in_month(CAL_GREGORIAN, (int)$reqBulan, $reqTahun);

		if($reqStatusPegawai == '')
			$statement .= 'AND A.STATUS_PEGAWAI_ID = 1';
		else
			$statement .= 'AND A.STATUS_PEGAWAI_ID = '.$reqStatusPegawai;
			
		$allRecord = $absensi_rekap->getCountByParams(array(), $statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $absensi_rekap->getCountByParams(array(), $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'");

		$absensi_rekap->selectByParamsRekapKehadiran($reqTanggalAkhir, $reqBulan, $reqTahun, array(), $dsplyRange, $dsplyStart, $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'", $periode, "ORDER BY A.NAMA ASC");     		

		//echo "IKI ".$_GET['iDisplayStart'];

			/*
			 * Output 
			 */
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $allRecord,
				"iTotalDisplayRecords" => $allRecordFilter,
				"aaData" => array()
			);
			
			$duk = $dsplyStart + 1;
			while($absensi_rekap->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					$row[] = $absensi_rekap->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;
				$duk++;
			}
			
			echo json_encode( $output );
	}
	
	function rekapitulasi_terlambat_pulang_cepat_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$absensi_rekap = new AbsensiRekap();

		/* LOGIN CHECK */

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqKeterangan = httpFilterRequest("reqKeterangan");
		$reqId = httpFilterRequest("reqId");
		$reqSearch = httpFilterGet("reqSearch");
		$reqBulan = httpFilterGet("reqBulan");
		$reqTahun = httpFilterGet("reqTahun");
		$reqMode = httpFilterGet("reqMode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqJenisPegawai= httpFilterGet("reqJenisPegawai");

		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA", "KELOMPOK", "JUMLAH_H", "JUMLAH_HT", "HT", "JUMLAH_HPC", "PC", "JUMLAH_TM", "TM");

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
			if ( trim($sOrder) == " " )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = "  ";
				 
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
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		$periode = $reqBulan.$reqTahun;

		if($reqJenisPegawai == '')
		{}
		else
			$statement .= 'AND C.JENIS_PEGAWAI_ID = '.$reqJenisPegawai;
			
		$allRecord = $absensi_rekap->getCountByParams(array(), $statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $absensi_rekap->getCountByParams(array(), $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'");

		$absensi_rekap->selectByParamsRekapTerlambatPulangKoreksi($periode, array(), $dsplyRange, $dsplyStart, $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'", "ORDER BY A.NAMA ASC");     		

		//echo "IKI ".$_GET['iDisplayStart'];

			/*
			 * Output 
			 */
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $allRecord,
				"iTotalDisplayRecords" => $allRecordFilter,
				"aaData" => array()
			);
			
			$duk = $dsplyStart + 1;
			while($absensi_rekap->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					$row[] = $absensi_rekap->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;
				$duk++;
			}
			
			echo json_encode( $output );
	}
	
	function rekapitulasi_terlambat_pulang_cepat_json_Copy()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$absensi_rekap = new AbsensiRekap();

		/* LOGIN CHECK */

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqKeterangan = httpFilterRequest("reqKeterangan");
		$reqId = httpFilterRequest("reqId");
		$reqSearch = httpFilterGet("reqSearch");
		$reqBulan = httpFilterGet("reqBulan");
		$reqTahun = httpFilterGet("reqTahun");
		$reqMode = httpFilterGet("reqMode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqStatusPegawai= httpFilterGet("reqStatusPegawai");

		$aColumns = array("PEGAWAI_ID","NAMA","MASUK","TERLAMBAT", "TERLAMBAT_HARI", "PULANG_CEPAT", "PULANG_CEPAT_HARI");

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
			if ( trim($sOrder) == " " )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = "  ";
				 
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
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		$periode = $reqBulan.$reqTahun;

		if($reqStatusPegawai == '')
			$statement .= 'AND A.STATUS_PEGAWAI_ID = 1';
		else
			$statement .= 'AND A.STATUS_PEGAWAI_ID = '.$reqStatusPegawai;
			
		$allRecord = $absensi_rekap->getCountByParams(array(), $statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $absensi_rekap->getCountByParams(array(), $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'");

		$absensi_rekap->selectByParamsRekapTerlambatPulangCepat($reqBulan, $reqTahun, array(), $dsplyRange, $dsplyStart, $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'", "ORDER BY A.NAMA ASC");     		

		//echo "IKI ".$_GET['iDisplayStart'];

			/*
			 * Output 
			 */
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $allRecord,
				"iTotalDisplayRecords" => $allRecordFilter,
				"aaData" => array()
			);
			
			$duk = $dsplyStart + 1;
			while($absensi_rekap->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					$row[] = $absensi_rekap->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;
				$duk++;
			}
			
			echo json_encode( $output );
	}

}
?>
