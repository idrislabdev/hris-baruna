<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class tpp_json extends CI_Controller {

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
	
	
	function tpp_p3_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/TppP3.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$tpp_p3 = new TppP3();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqKelas = httpFilterPost("reqKelas");
		$reqPeriode = httpFilterPost("reqPeriode");
		$reqJumlah = httpFilterPost("reqJumlah");

		if($reqMode == "insert")
		{
			$tpp_p3->setField("KELAS", $reqKelas);
			$tpp_p3->setField("JUMLAH", dotToNo($reqJumlah));
			
			if($tpp_p3->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$tpp_p3->setField("TPP_P3_ID", $reqId);
			$tpp_p3->setField("KELAS", $reqKelas);
			$tpp_p3->setField("JUMLAH", dotToNo($reqJumlah));
			
			if($tpp_p3->update())
				echo "Data berhasil disimpan.";
			
		}
	}
	
	function tpp_p3_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/TppP3.php");

		$tpp_p3 = new TppP3();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("TPP_P3_ID", "KELAS", "JUMLAH");
		$aColumnsAlias = array("TPP_P3_ID", "KELAS", "JUMLAH");

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
			if ( trim($sOrder) == "ORDER BY TPP_P3_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY TPP_P3_ID, KELAS ASC";
				 
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


		$allRecord = $tpp_p3->getCountByParams(array());
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $tpp_p3->getCountByParams(array(), " AND (UPPER(KELAS) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$tpp_p3->selectByParams(array(), $dsplyRange, $dsplyStart, " AND (UPPER(KELAS) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($tpp_p3->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($tpp_p3->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($tpp_p3->getField($aColumns[$i]), 5)."...";
				else if($aColumns[$i] == "JUMLAH")
					$row[] = currencyToPage($tpp_p3->getField($aColumns[$i]));			
				else
					$row[] = $tpp_p3->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function tpp_pms_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/TppPMS.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$tpp_pms = new TppPMS();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqKelas = httpFilterPost("reqKelas");
		$reqPeriode = httpFilterPost("reqPeriode");
		$reqJumlah = httpFilterPost("reqJumlah");
		$reqJenisPegawai = httpFilterPost("reqJenisPegawai");

		if($reqMode == "insert")
		{
			$tpp_pms->setField("KELAS", $reqKelas);
			$tpp_pms->setField("JUMLAH", dotToNo($reqJumlah));
			$tpp_pms->setField("JENIS_PEGAWAI_ID", $reqJenisPegawai);
			
			if($tpp_pms->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$tpp_pms->setField("TPP_PMS_ID", $reqId);
			$tpp_pms->setField("KELAS", $reqKelas);
			$tpp_pms->setField("JUMLAH", dotToNo($reqJumlah));
			$tpp_pms->setField("JENIS_PEGAWAI_ID", $reqJenisPegawai);
			
			if($tpp_pms->update())
				echo "Data berhasil disimpan.";
			
		}
	}
	
	function tpp_pms_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/TppPMS.php");

		$tpp_pms = new TppPMS();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("TPP_PMS_ID", "KELAS", "JENIS_PEGAWAI", "JUMLAH");
		$aColumnsAlias = array("TPP_PMS_ID", "KELAS", "JENIS_PEGAWAI", "JUMLAH");

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
			if ( trim($sOrder) == "ORDER BY KELAS ASC" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY KELAS DESC";
				 
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


		$allRecord = $tpp_pms->getCountByParams(array());
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $tpp_pms->getCountByParams(array(), " AND (UPPER(KELAS) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$tpp_pms->selectByParams(array(), $dsplyRange, $dsplyStart, " AND (UPPER(KELAS) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($tpp_pms->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($tpp_pms->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($tpp_pms->getField($aColumns[$i]), 5)."...";
				else if($aColumns[$i] == "JUMLAH")
					$row[] = currencyToPage($tpp_pms->getField($aColumns[$i]));			
				else
					$row[] = $tpp_pms->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

}
?>
