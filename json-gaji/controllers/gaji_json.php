<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class gaji_json extends CI_Controller {

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
	
	
	function gaji_awal_bulan_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");

		$gaji_awal_bulan = new GajiAwalBulan();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "NAMA", "NAMA", "NAMA", "NAMA", "NAMA", "NAMA");
		$aColumnsAlias = array("A.PEGAWAI_ID", "A.NAMA", "A.NAMA", "A.NAMA");

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
			if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID ASC" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY A.PEGAWAI_ID DESC";
				 
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


		$allRecord = $gaji_awal_bulan->getCountByParams(array());
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array(), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$gaji_awal_bulan->selectByParams(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($gaji_awal_bulan->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($gaji_awal_bulan->getField($aColumns[$i]), 5)."...";
				else if($aColumns[$i] == "TARIF_NORMAL" || $aColumns[$i] == "TARIF_MAKSIMAL")
					$row[] = currencyToPage($gaji_awal_bulan->getField($aColumns[$i]));			
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function gaji_bantuan_pendidikan_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/BantuanPendidikan.php");

		$bantuan_pendidikan = new BantuanPendidikan();

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqMode = httpFilterGet("reqMode");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA","JUMLAH", "PROSENTASE_POTONGAN", "JUMLAH_POTONGAN", "JUMLAH_DIBAYAR");
		$aColumnsAlias = array("A.PEGAWAI_ID", "NRP", "NAMA","JUMLAH", "PROSENTASE_POTONGAN", "JUMLAH_POTONGAN", "JUMLAH_DIBAYAR");

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

		if($reqMode == "proses")
		{
			$bantuan_pendidikan->callBantuanPendidikan();
		}

		if($reqJenisPegawai == "")
		{}
		else
			$statement .= "AND C.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;


		$allRecord = $bantuan_pendidikan->getCountByParams(array(),$statement, $reqPeriode);
		//echo $bantuan_pendidikan->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $bantuan_pendidikan->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

		$bantuan_pendidikan->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $reqPeriode, $sOrder);

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($bantuan_pendidikan->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($bantuan_pendidikan->getField($aColumns[$i]));
				else if($aColumns[$i] == "JUMLAH" || $aColumns[$i] == "JUMLAH_POTONGAN" || $aColumns[$i] == "JUMLAH_DIBAYAR")
					$row[] = currencyToPage($bantuan_pendidikan->getField($aColumns[$i]));
				else
					$row[] = $bantuan_pendidikan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function gaji_bonus_tahunan_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/BonusTahunan.php");

		$bonus_tahunan = new BonusTahunan();

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqMode = httpFilterGet("reqMode");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA","JUMLAH");
		$aColumnsAlias = array("A.PEGAWAI_ID", "NRP", "NAMA","JUMLAH");

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

		if($reqMode == "proses")
		{
			$bonus_tahunan->callBonusTahunan();
		}

		if($reqJenisPegawai == "")
		{}
		else
			$statement .= "AND C.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;


		$allRecord = $bonus_tahunan->getCountByParams(array(),$statement, $reqPeriode);
		//echo $bonus_tahunan->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $bonus_tahunan->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

		$bonus_tahunan->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $reqPeriode, $sOrder);

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($bonus_tahunan->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($bonus_tahunan->getField($aColumns[$i]));
				else if($aColumns[$i] == "JUMLAH")
					$row[] = currencyToPage($bonus_tahunan->getField($aColumns[$i]));
				else
					$row[] = $bonus_tahunan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function gaji_bonus_tahunan_json_new()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/BonusTahunan.php");
		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$bonus = new BonusTahunan();

		$reqProses = httpFilterPost("reqProses");
		$reqJenis = httpFilterPost("reqJenis");
		$reqPeriode = httpFilterPost("reqPeriode");
		$reqDepartemen = httpFilterPost("reqDepartemen");
		$reqKeyword = httpFilterPost("query");
		$reqLimit = httpFilterPost("limit");
		$reqPage = httpFilterPost("page");
		$reqStart = httpFilterPost("start");
		$reqSorting = httpFilterPost("sort");

		$where =" AND A.PERIODE = '" . $reqPeriode . "' ";
		$order = " ORDER BY A.JENIS_PEGAWAI ASC, A.NAMA ASC ";

		/*
		if($reqSorting != ''){
			$reqSorting = json_decode($reqSorting);
			$kolOrder =  $reqSorting[0]->property;
			$orderType = $reqSorting[0]->direction;
			if($kolOrder == 'DEPARTEMEN') $kolOrder = 'C.DEPARTEMEN_ID';
			if($kolOrder == 'NAMA') $kolOrder = 'B.NAMA';
			$order = " ORDER BY ". $kolOrder ."  ". $orderType ." ";
		}
		*/
		if($reqDepartemen != 'ALL'){
			$where .= " AND E.DEPARTEMEN_ID = '". $reqDepartemen ."' ";
		}
		if($reqKeyword != ""){
			$where .= " AND (UPPER(A.NAMA) LIKE UPPER('%". $reqKeyword ."%') OR UPPER(B.NAMA) LIKE UPPER('%". $reqKeyword ."%')) ";
		}
		if($reqJenis != 'ALL'){
			$where .= " AND A.JENIS_PEGAWAI = ". $reqJenis ." ";
		}

		$totalRecord = $bonus->getCountByParamsNew(array(), $where);	
		$bonus->selectByParamsNew(array(), $reqLimit, $reqStart, $where, $order);     
		//echo $bonus->query; exit;	

		$kolom = array('NO', 'NAMA','JENIS_PEGAWAI','PEGAWAI_ID', 'NRP', 'NPWP', 'DEPARTEMEN', 'NILAI_PI','NILAI_SKI',
			'NILAI_TOTAL','NILAI_KATEGORI','JUMLAH_BONUS','PPH_PERSEN','PPH_KALI','PPH_NILAI','PERIODE',
			'BANK', 'REKENING_NO', 'REKENING_NAMA', 'JUMLAH_DIBAYAR');
		/* Output */
		$data = array();
		while($bonus->nextRow()){	
			$row = array();
			for ( $i=0 ; $i<count($kolom) ; $i++ ){
				$row[$kolom[$i]] = $bonus->getField($kolom[$i]);
			}
			$data['hasil'][] = $row;
		}
		echo '({"TOTAL":"'.$totalRecord.'","ISI_DATA":'.json_encode($data['hasil']).'})';
	}
	
	function gaji_capeg_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();
		$gaji = new Gaji();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqMode = httpFilterGet("reqMode");
		$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");

		$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(5, "AWAL_BULAN"));
		$json_item_sumbangan = json_decode($gaji->getItemSumbanganDiberikan(5));
		$json_item_potongan = json_decode($gaji->getItemPotonganDiberikan(5));
		$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan(5));
		$json_item_potongan_lain = json_decode($gaji->getItemPotonganLain());

		$aColumns[] = "PEGAWAI_ID";
		$aColumns[] = "STATUS_BAYAR";
		$aColumns[] = "NO_URUT";
		$aColumns[] = "NRP";
		$aColumns[] = "NAMA";
		$aColumns[] = "JBT_KLS";
		$aColumns[] = "STATUS_BAYAR";
		for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
		{
			$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
		}
		for($i=0;$i<count($json_item_sumbangan->{"ITEM_SUMBANGAN"});$i++)
		{
			$aColumns[] = "SUMBANGAN_".$json_item_sumbangan->{"ITEM_SUMBANGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_potongan->{"ITEM_POTONGAN"});$i++)
		{
			$aColumns[] = "POTONGAN_".$json_item_potongan->{"ITEM_POTONGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_tanggungan->{"ITEM_TANGGUNGAN"});$i++)
		{
			$aColumns[] = "TANGGUNGAN_".$json_item_tanggungan->{"ITEM_TANGGUNGAN"}{$i};		
		}

		$aColumns[] = "LAIN";
		$aColumns[] = "TOTAL";
			
		$aColumnsAlias = array("A.PEGAWAI_ID", "B.STATUS_BAYAR", "B.NO_URUT", "A.NRP", "A.NAMA", "JBT_KLS");

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
				$sOrder = " ORDER BY NO_URUT ASC ";
				 
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

		if($reqMode == "proses")
		{
			$gaji_awal_bulan_proses = new GajiAwalBulan();
			$gaji_awal_bulan_proses->setField("PERIODE", $reqPeriode);
			$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "5");		
			$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();		
			unset($gaji_awal_bulan_proses);
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		$statement_count .= $statement." AND B.JENIS_PEGAWAI_ID IN (".$reqJenisPegawaiId.") ";
		$allRecord = $gaji_awal_bulan->getCountByParams(array(),$statement_count, $reqPeriode);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array(), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement_count, $reqPeriode);

		$gaji_awal_bulan->selectByParamsGaji(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, "ORDER BY NO_URUT ASC", $reqPeriode, $reqJenisPegawaiId);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			
			$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
			$json_sumbangan = json_decode($gaji_awal_bulan->getField("SUMBANGAN_JSON"));
			$json_potongan = json_decode($gaji_awal_bulan->getField("POTONGAN_JSON"));
			$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
			$json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
			$total_gaji = 0;
			$total_sumbangan = 0;
			$total_potongan = 0;
			$total_tanggungan = 0;
			$total_potongan_lain = 0;
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{	
				if(substr($aColumns[$i],0,4) == "GAJI")
				{
					$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
					if($column_gaji == "TOTAL_GAJI")
					{
						$row[] = currencyToPage($total_gaji);				
					}
					else
					{
						$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
						$total_gaji += $json_gaji->{$column_gaji}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "SUMB")
				{
					$column_sumbangan = str_replace("SUMBANGAN_", "", $aColumns[$i]);
					if($column_sumbangan == "TOTAL_SUMBANGAN")
					{
						$row[] = currencyToPage($total_sumbangan);				
					}
					else
					{
						$row[] = currencyToPage($json_sumbangan->{$column_sumbangan}{0});
						$total_sumbangan += $json_sumbangan->{$column_sumbangan}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "POTO")
				{
					$column_potongan = str_replace("POTONGAN_", "", $aColumns[$i]);
					if($column_potongan == "TOTAL_POTONGAN")
					{
						$row[] = currencyToPage($total_potongan);				
					}
					else
					{
						$row[] = currencyToPage($json_potongan->{$column_potongan}{0});
						$total_potongan += $json_potongan->{$column_potongan}{0};
					}
				}		
				elseif(substr($aColumns[$i],0,4) == "TANG")
				{
					$column_tanggungan = str_replace("TANGGUNGAN_", "", $aColumns[$i]);
					if($column_tanggungan == "TOTAL_TANGGUNGAN")
					{
						$row[] = currencyToPage($total_tanggungan);				
					}
					else
					{
						$row[] = currencyToPage($json_tanggungan->{$column_tanggungan}{0});
						$total_tanggungan += $json_tanggungan->{$column_tanggungan}{0};
					}
				}
				elseif($aColumns[$i] == "LAIN")		
				{
					for($j=0;$j<count($json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"});$j++)
					{
						$total_potongan_lain += $json_potongan_lain->{$json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"}{$j}}{0};	
					}
					$row[] = currencyToPage($total_potongan_lain);	
				}
				elseif($aColumns[$i] == "STATUS_BAYAR")		
				{
					if($gaji_awal_bulan->getField($aColumns[$i]) == 1)
						$row[] = "<img src='../WEB-INF/images/centang.png'>";
					else
						$row[] = "";
					
				}			
				elseif($aColumns[$i] == "TOTAL")			
				{
					$total_sebelum = $total_gaji - $total_potongan;
					$total_pembulatan = (($total_sebelum - $total_potongan_lain) % 1000);
					if($total_pembulatan == 0)
						$total_pembulatan = 1000;
					$total_gaji = $total_sebelum;
					$row[] = currencyToPage($total_gaji - $total_potongan_lain);
				}
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
			}
			
			$output['aaData'][] = $row;
			
			unset($json_gaji);
		}

		echo json_encode( $output );
	}
	
	function gaji_capeg_json_coba()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();
		$gaji = new Gaji();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqMode = httpFilterGet("reqMode");
		$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");

		$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(2, "AWAL_BULAN"));
		$json_item_sumbangan = json_decode($gaji->getItemSumbanganDiberikan(2));
		$json_item_potongan = json_decode($gaji->getItemPotonganDiberikan(2));
		$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan(2));
		$json_item_potongan_lain = json_decode($gaji->getItemPotonganLain());

		$aColumns[] = "PEGAWAI_ID";
		$aColumns[] = "STATUS_BAYAR";
		$aColumns[] = "NO_URUT";
		$aColumns[] = "NRP";
		$aColumns[] = "NAMA";
		$aColumns[] = "JBT_KLS";
		for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
		{
			$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
		}
		for($i=0;$i<count($json_item_sumbangan->{"ITEM_SUMBANGAN"});$i++)
		{
			$aColumns[] = "SUMBANGAN_".$json_item_sumbangan->{"ITEM_SUMBANGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_potongan->{"ITEM_POTONGAN"});$i++)
		{
			$aColumns[] = "POTONGAN_".$json_item_potongan->{"ITEM_POTONGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_tanggungan->{"ITEM_TANGGUNGAN"});$i++)
		{
			$aColumns[] = "TANGGUNGAN_".$json_item_tanggungan->{"ITEM_TANGGUNGAN"}{$i};		
		}

		$aColumns[] = "LAIN";
		$aColumns[] = "TOTAL";
			
		$aColumnsAlias = array("A.PEGAWAI_ID", "A.NAMA", "A.NAMA", "A.NAMA");

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
				$sOrder = " ORDER BY NO_URUT ASC ";
				 
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

		if($reqMode == "proses")
		{
			$gaji_awal_bulan_proses = new GajiAwalBulan();
			$gaji_awal_bulan_proses->setField("PERIODE", $reqPeriode);
			$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "5");		
			$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();		
			unset($gaji_awal_bulan_proses);
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		$statement_count .= $statement." AND B.JENIS_PEGAWAI_ID IN (".$reqJenisPegawaiId.") ";
		$allRecord = $gaji_awal_bulan->getCountByParams(array(),$statement_count, $reqPeriode);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array(), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement_count, $reqPeriode);

		$gaji_awal_bulan->selectByParamsGaji(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, $sOrder, $reqPeriode, $reqJenisPegawaiId);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			
			$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
			$json_sumbangan = json_decode($gaji_awal_bulan->getField("SUMBANGAN_JSON"));
			$json_potongan = json_decode($gaji_awal_bulan->getField("POTONGAN_JSON"));
			$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
			$json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
			$total_gaji = 0;
			$total_sumbangan = 0;
			$total_potongan = 0;
			$total_tanggungan = 0;
			$total_potongan_lain = 0;
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{	
				if(substr($aColumns[$i],0,4) == "GAJI")
				{
					$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
					if($column_gaji == "TOTAL_GAJI")
					{
						$row[] = currencyToPage($total_gaji);				
					}
					else
					{
						$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
						$total_gaji += $json_gaji->{$column_gaji}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "SUMB")
				{
					$column_sumbangan = str_replace("SUMBANGAN_", "", $aColumns[$i]);
					if($column_sumbangan == "TOTAL_SUMBANGAN")
					{
						$row[] = currencyToPage($total_sumbangan);				
					}
					else
					{
						$row[] = currencyToPage($json_sumbangan->{$column_sumbangan}{0});
						$total_sumbangan += $json_sumbangan->{$column_sumbangan}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "POTO")
				{
					$column_potongan = str_replace("POTONGAN_", "", $aColumns[$i]);
					if($column_potongan == "TOTAL_POTONGAN")
					{
						$row[] = currencyToPage($total_potongan);				
					}
					else
					{
						$row[] = currencyToPage($json_potongan->{$column_potongan}{0});
						$total_potongan += $json_potongan->{$column_potongan}{0};
					}
				}		
				elseif(substr($aColumns[$i],0,4) == "TANG")
				{
					$column_tanggungan = str_replace("TANGGUNGAN_", "", $aColumns[$i]);
					if($column_tanggungan == "TOTAL_TANGGUNGAN")
					{
						$row[] = currencyToPage($total_tanggungan);				
					}
					else
					{
						$row[] = currencyToPage($json_tanggungan->{$column_tanggungan}{0});
						$total_tanggungan += $json_tanggungan->{$column_tanggungan}{0};
					}
				}
				elseif($aColumns[$i] == "LAIN")		
				{
					for($j=0;$j<count($json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"});$j++)
					{
					echo $json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"}{$j}."<br>";
						//$total_potongan_lain += $json_potongan_lain->{$json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"}{$j}}{0};	
					}
					$row[] = currencyToPage($total_potongan_lain);	
				}
				elseif($aColumns[$i] == "TOTAL")			
				{
					$total_sebelum = $total_gaji - $total_potongan;
					$total_pembulatan = (($total_sebelum - $total_potongan_lain) % 1000);
					if($total_pembulatan == 0)
						$total_pembulatan = 1000;
					$total_gaji = $total_sebelum + (1000 - $total_pembulatan);
					$row[] = currencyToPage($total_gaji - $total_potongan_lain);
				}
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
			}
			
			$output['aaData'][] = $row;
			
			unset($json_gaji);
		}

		echo json_encode( $output );
	}
	
	function gaji_cuti_tahunan_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$cuti_tahunan = new CutiTahunan();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqPegawaiId = httpFilterPost("reqPegawaiId");
		$reqJenisPegawaiId = httpFilterPost("reqJenisPegawaiId");
		$reqLamaCuti = httpFilterPost("reqLamaCuti");
		$reqTanggal = httpFilterPost("reqTanggal");
		$reqTanggalAwal = httpFilterPost("reqTanggalAwal");
		$reqTanggalAkhir = httpFilterPost("reqTanggalAkhir");
						   
		$cuti_tahunan->setField('PEGAWAI_ID', $reqPegawaiId);
		$cuti_tahunan->setField('JENIS_PEGAWAI_ID', $reqJenisPegawaiId);
		$cuti_tahunan->setField('PERIODE', date('Y'));
		$cuti_tahunan->setField('LAMA_CUTI', $reqLamaCuti);
		$cuti_tahunan->setField('TANGGAL', dateToDBCheck($reqTanggal));
		$cuti_tahunan->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
		$cuti_tahunan->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));

		if($cuti_tahunan->insert())
			echo "Data berhasil disimpan.";
	}
	
	function gaji_cuti_tahunan_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");

		$cuti_tahunan = new CutiTahunan();

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqMode = httpFilterGet("reqMode");
		$reqStatusProses = httpFilterGet("reqStatusProses");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("PEGAWAI_ID", "CHECK", "NRP", "NAMA", "LAMA_CUTI", "JUMLAH", "JUMLAH_POTONGAN", "TANGGAL_APPROVE");
		$aColumnsAlias = array("A.PEGAWAI_ID", "CHECK", "NRP", "NAMA", "LAMA_CUTI", "JUMLAH", "JUMLAH_POTONGAN", "TANGGAL_APPROVE");

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

		if($reqMode == "proses")
		{
			$cuti_tahunan->callCutiTahunan();
		}

		if($reqJenisPegawai == "")
		{}
		else
			$statement .= "AND C.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;

		if($reqStatusProses == "BELUM")
			$statement .= "AND G.TANGGAL_APPROVE IS NULL";
		elseif($reqStatusProses == "SUDAH")
			$statement .= "AND G.TANGGAL_APPROVE IS NOT NULL";



		$allRecord = $cuti_tahunan->getCountByParamsGaji(array(),$statement, $reqPeriode);
		//echo $cuti_tahunan->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $cuti_tahunan->getCountByParamsGaji(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

		$cuti_tahunan->selectByParamsGaji(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $reqPeriode, $sOrder);

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($cuti_tahunan->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_APPROVE")
					$row[] = getFormattedDate($cuti_tahunan->getField($aColumns[$i]));
				else if($aColumns[$i] == "JUMLAH" || $aColumns[$i] == "JUMLAH_POTONGAN")
					$row[] = currencyToPage($cuti_tahunan->getField($aColumns[$i]));
				else if($aColumns[$i] == "CHECK")
					$row[] = "<input type='checkbox' name='check'  " . ($cuti_tahunan->getField("TANGGAL_APPROVE") == "" ? "" : "disabled='disabled' ") . " value='". $cuti_tahunan->getField("CUTI_TAHUNAN_ID") ."'>";
				else
					$row[] = $cuti_tahunan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function gaji_direksi_komisaris_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();
		$gaji = new Gaji();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqMode = httpFilterGet("reqMode");

		$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(6, "SEMUA"));
		$json_item_sumbangan = json_decode($gaji->getItemSumbanganDiberikan(6));
		$json_item_potongan = json_decode($gaji->getItemPotonganDiberikan(6));
		$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan(6));
		$json_item_potongan_lain = json_decode($gaji->getItemPotonganLain());

		$aColumns[] = "PEGAWAI_ID";
		$aColumns[] = "STATUS_BAYAR";
		$aColumns[] = "NO_URUT";
		$aColumns[] = "NRP";
		$aColumns[] = "NAMA";
		$aColumns[] = "JBT_KLS";
		$aColumns[] = "STATUS_BAYAR";
		for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
		{
			$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
		}
		for($i=0;$i<count($json_item_sumbangan->{"ITEM_SUMBANGAN"});$i++)
		{
			$aColumns[] = "SUMBANGAN_".$json_item_sumbangan->{"ITEM_SUMBANGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_potongan->{"ITEM_POTONGAN"});$i++)
		{
			$aColumns[] = "POTONGAN_".$json_item_potongan->{"ITEM_POTONGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_tanggungan->{"ITEM_TANGGUNGAN"});$i++)
		{
			$aColumns[] = "TANGGUNGAN_".$json_item_tanggungan->{"ITEM_TANGGUNGAN"}{$i};		
		}

		$aColumns[] = "LAIN";
		$aColumns[] = "TOTAL";

		$aColumnsAlias = array("A.PEGAWAI_ID", "B.STATUS_BAYAR", "B.NO_URUT", "A.NRP", "A.NAMA", "JBT_KLS");

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
				$sOrder = " ORDER BY NO_URUT ASC ";
				 
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

		if($reqMode == "proses")
		{
			$gaji_awal_bulan_proses = new GajiAwalBulan();
			$gaji_awal_bulan_proses->setField("PERIODE", $reqPeriode);
			$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "6,7");		
			$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();		
			unset($gaji_awal_bulan_proses);

		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		$statement_count .= $statement." AND B.JENIS_PEGAWAI_ID IN (6,7) ";
		$allRecord = $gaji_awal_bulan->getCountByParams(array(),$statement_count, $reqPeriode);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array(), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement_count, $reqPeriode);

		$gaji_awal_bulan->selectByParamsGaji(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, "ORDER BY NO_URUT ASC", $reqPeriode, "6,7");     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			
			$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
			$json_sumbangan = json_decode($gaji_awal_bulan->getField("SUMBANGAN_JSON"));
			$json_potongan = json_decode($gaji_awal_bulan->getField("POTONGAN_JSON"));
			$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
			$json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
			$total_gaji = 0;
			$total_sumbangan = 0;
			$total_potongan = 0;
			$total_tanggungan = 0;
			$total_potongan_lain = 0;
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{	
				if(substr($aColumns[$i],0,4) == "GAJI")
				{
					$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
					if($column_gaji == "TOTAL_GAJI")
					{
						$row[] = currencyToPage($total_gaji);				
					}
					else
					{
						$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
						$total_gaji += $json_gaji->{$column_gaji}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "SUMB")
				{
					$column_sumbangan = str_replace("SUMBANGAN_", "", $aColumns[$i]);
					if($column_sumbangan == "TOTAL_SUMBANGAN")
					{
						$row[] = currencyToPage($total_sumbangan);				
					}
					else
					{
						$row[] = currencyToPage($json_sumbangan->{$column_sumbangan}{0});
						$total_sumbangan += $json_sumbangan->{$column_sumbangan}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "POTO")
				{
					$column_potongan = str_replace("POTONGAN_", "", $aColumns[$i]);
					if($column_potongan == "TOTAL_POTONGAN")
					{
						$row[] = currencyToPage($total_potongan);				
					}
					else
					{
						$row[] = currencyToPage($json_potongan->{$column_potongan}{0});
						$total_potongan += $json_potongan->{$column_potongan}{0};
					}
				}		
				elseif(substr($aColumns[$i],0,4) == "TANG")
				{
					$column_tanggungan = str_replace("TANGGUNGAN_", "", $aColumns[$i]);
					if($column_tanggungan == "TOTAL_TANGGUNGAN")
					{
						$row[] = currencyToPage($total_tanggungan);				
					}
					else
					{
						$row[] = currencyToPage($json_tanggungan->{$column_tanggungan}{0});
						$total_tanggungan += $json_tanggungan->{$column_tanggungan}{0};
					}
				}
				elseif($aColumns[$i] == "LAIN")		
				{
					for($j=0;$j<count($json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"});$j++)
					{
						$total_potongan_lain += $json_potongan_lain->{$json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"}{$j}}{0};	
					}
					$row[] = currencyToPage($total_potongan_lain);	
				}
				elseif($aColumns[$i] == "STATUS_BAYAR")		
				{
					if($gaji_awal_bulan->getField($aColumns[$i]) == 1)
						$row[] = "<img src='../WEB-INF/images/centang.png'>";
					else
						$row[] = "";
					
				}	
				elseif($aColumns[$i] == "TOTAL")			
				{
					$total_sebelum = $total_gaji - $total_potongan;
					$total_pembulatan = (($total_sebelum - $total_potongan_lain) % 1000);
					if($total_pembulatan == 0)
						$total_pembulatan = 1000;
					$total_gaji = $total_sebelum;
					$row[] = currencyToPage($total_gaji - $total_potongan_lain);
				}
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
			}
			
			$output['aaData'][] = $row;
			
			unset($json_gaji);
		}

		echo json_encode( $output );
	}
	
	function gaji_insentif_galangan_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-operasional/Galangan.php");

		$galangan = new Galangan();

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqMode = httpFilterGet("reqMode");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("PEGAWAI_ID", "NAMA", "JABATAN", "PROSENTASE_INSENTIF", "PROSENTASE_POTONGAN_PPH","PENDAPATAN_GALANGAN", "JUMLAH_INSENTIF", "POTONGAN_KEHADIRAN", "JUMLAH_POTONGAN_PPH", "JUMLAH_DITERIMA");
		$aColumnsAlias = array("A.PEGAWAI_ID", "NAMA", "JABATAN", "PROSENTASE_INSENTIF", "PROSENTASE_POTONGAN_PPH","PENDAPATAN_GALANGAN", "JUMLAH_INSENTIF", "POTONGAN_KEHADIRAN", "JUMLAH_POTONGAN_PPH", "JUMLAH_DITERIMA");

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
			if ( trim($sOrder) == "ORDER BY A.KAPAL_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				//$sOrder = " ORDER BY PEGAWAI_ID DESC";
				$sOrder = " ORDER BY A.KAPAL_ID ASC";
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

		if($reqMode == "proses")
		{
			$galangan->callHitungInsentifGalangan();		
		}

		$allRecord = $galangan->getCountByParamsInsentifGalangan(array("PERIODE" => $reqPeriode),$statement);
		//echo $galangan->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $galangan->getCountByParamsInsentifGalangan(array("PERIODE" => $reqPeriode), $statement." AND ((UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.JABATAN) LIKE '%".strtoupper($_GET['sSearch'])."%')) ");

		$galangan->selectByParamsInsetifGalangan(array("PERIODE" => $reqPeriode), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.JABATAN) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder);

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($galangan->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($galangan->getField($aColumns[$i]));
				else if($aColumns[$i] == "PENDAPATAN_GALANGAN" || $aColumns[$i] == "JUMLAH_INSENTIF" || $aColumns[$i] == "JUMLAH_INSENTIF" || $aColumns[$i] == "JUMLAH_POTONGAN_PPH" || $aColumns[$i] == "JUMLAH_DITERIMA" || $aColumns[$i] == "POTONGAN_KEHADIRAN")
					$row[] = currencyToPage($galangan->getField($aColumns[$i]));
				else
					$row[] = $galangan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function gaji_insentif_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/InsentifBantuan.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulanLog.php");

		$log = new GajiAwalBulanLog();
		$insentif_bantuan = new InsentifBantuan();

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqMode = httpFilterGet("reqMode");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA", "JUMLAH", "PROSENTASE_POTONGAN","JUMLAH_POTONGAN", "JUMLAH_BERSIH","PROSENTASE_PPH","JUMLAH_PPH", "DIBAYARKAN");
		$aColumnsAlias = array("A.PEGAWAI_ID", "NRP", "NAMA", "JUMLAH", "PROSENTASE_POTONGAN","JUMLAH_POTONGAN","JUMLAH_BERSIH","PROSENTASE_PPH","JUMLAH_PPH", "DIBAYARKAN");

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

		if($reqMode == "proses")
		{
			$log->setField("PERIODE", $reqPeriode);
			$log->setField("PROSES_BY", $userLogin->nama);
			$log->setField("JENIS_PROSES", "INSENTIF");
			$log->insert();		
			$insentif_bantuan->setField("JENIS_PEGAWAI_ID", $reqJenisPegawai);
			$insentif_bantuan->callInsentifBantuan();
		}

		if($reqJenisPegawai == "")
		{}
		else
			$statement .= "AND C.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;


		$allRecord = $insentif_bantuan->getCountByParams(array(),$statement, $reqPeriode);
		//echo $insentif_bantuan->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $insentif_bantuan->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

		$insentif_bantuan->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " ,$reqPeriode , $sOrder);

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($insentif_bantuan->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($insentif_bantuan->getField($aColumns[$i]));
				else if($aColumns[$i] == "JUMLAH" || $aColumns[$i] == "JUMLAH_POTONGAN" || $aColumns[$i] == "DIBAYARKAN")
					$row[] = currencyToPage($insentif_bantuan->getField($aColumns[$i]));
				else
					$row[] = $insentif_bantuan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$gaji = new Gaji();

		$reqMode = httpFilterGet("reqMode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqBulan = httpFilterGet("reqBulan");
		$reqTahun = httpFilterGet("reqTahun");

		ini_set("memory_limit","500M");
		ini_set("max_execution_time", 520);

		$aColumns = array("PEGAWAI_ID", "NAMA", "KELAS", "PERIODE", "MERIT", "TPP", "TUNJANGAN_PERBANTUAN", "TUNJANGAN_JABATAN", "TOTAL", "STATUS_BAYAR");
		$aColumnsAlias = array("PEGAWAI_ID", "NAMA", "KELAS", "PERIODE", "MERIT", "TPP", "TUNJANGAN_PERBANTUAN", "TUNJANGAN_JABATAN", "TOTAL", "STATUS_BAYAR");

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
				$sOrder = " ORDER BY NAMA DESC";
				 
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


		if($reqMode == "proses")
		{
			$gaji->setField("PERIODE", $reqBulan.$reqTahun);	
			$gaji->setField("DEPARTEMEN_ID", $reqDepartemen);	
			$gaji->callGaji();
		}
		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";


		$allRecord = $gaji->getCountByParams(array(), $statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji->getCountByParams(array(), $statement." AND (UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$gaji->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND (UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder, $reqBulan, $reqTahun);     		

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
			
			while($gaji->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if(trim($aColumns[$i]) == "MERIT" || trim($aColumns[$i]) == "TPP" || trim($aColumns[$i]) == "TUNJANGAN_PERBANTUAN" || trim($aColumns[$i]) == "TUNJANGAN_JABATAN" || trim($aColumns[$i]) == "TOTAL")
						$row[] = currencyToPage($gaji->getField(trim($aColumns[$i])));
					else
						$row[] = $gaji->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;
				$duk++;
			}
			
			echo json_encode( $output );
	}
	
	function gaji_json_set()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");

		/* create objects */

		$gaji = new Gaji();

		$reqId = httpFilterGet("reqId");
		$reqNilai = httpFilterGet("reqNilai");
		$reqBulanTahun = httpFilterGet("reqBulanTahun");
		/* LOGIN CHECK 
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}
		*/

			$gaji->setField("PEGAWAI_ID", $reqId);
			$gaji->setField("BULANTAHUN", $reqBulanTahun);
			$gaji->updateStatusGaji();
			
		$met = array();
		$i=0;

		$met[0]['STATUS'] = $gaji->query;
		echo json_encode($met);
	}
	
	function gaji_kondisi_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/GajiKondisi.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$gaji_kondisi = new GajiKondisi();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqNama = httpFilterPost("reqNama");

		if($reqMode == "insert")
		{
			$gaji_kondisi->setField("GAJI_KONDISI_ID", $reqId);
			$gaji_kondisi->setField("NAMA", $reqNama);
			if($gaji_kondisi->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$gaji_kondisi->setField("GAJI_KONDISI_ID", $reqId);
			$gaji_kondisi->setField("NAMA", $reqNama);
			if($gaji_kondisi->update())
				echo "Data berhasil disimpan.";
			
		}
	}
	
	function gaji_kondisi_jenis_pegawai_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/GajiKondisiJenisPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$gaji_kondisi_jenis_pegawai = new GajiKondisiJenisPegawai();

		$reqId = httpFilterPost("reqId");
		$reqJenisPegawaiId = httpFilterPost("reqJenisPegawaiId");
		$reqMode = httpFilterPost("reqMode");
		$reqJenisPenghasilan = $_POST["reqJenisPenghasilan"];
		$reqJumlah = $_POST["reqJumlah"];
		$reqProsentase = $_POST["reqProsentase"];
		$reqKali = $_POST["reqKali"];
		$reqGajiKondisiId = $_POST["reqGajiKondisiId"];
		$reqKelas = httpFilterPost("reqKelas");
		$reqKelompok = httpFilterPost("reqKelompok");
		$reqCurrentKelas = httpFilterPost("reqCurrentKelas");
							  
		if($reqMode == "insert")
		{

			$gaji_kondisi_jenis_pegawai->setField("JENIS_PEGAWAI_ID", $reqJenisPegawaiId);
			$gaji_kondisi_jenis_pegawai->setField("KELOMPOK", $reqKelompok);
			$gaji_kondisi_jenis_pegawai->setField("KELAS", $reqCurrentKelas);
			$gaji_kondisi_jenis_pegawai->delete();
			unset($gaji_kondisi_jenis_pegawai);
			
			for($i=0;$i<count($reqGajiKondisiId);$i++)
			{
				if($reqJenisPenghasilan[$i] == "")
				{}
				else
				{
				$index = $reqJenisPenghasilan[$i];
				$gaji_kondisi_jenis_pegawai = new GajiKondisiJenisPegawai();
				$gaji_kondisi_jenis_pegawai->setField("JENIS_PEGAWAI_ID", $reqJenisPegawaiId);
				$gaji_kondisi_jenis_pegawai->setField("GAJI_KONDISI_ID", $reqGajiKondisiId[$index]);
				if($reqJumlah[$index] == "")
					$gaji_kondisi_jenis_pegawai->setField("JUMLAH", "NULL");
				else
					$gaji_kondisi_jenis_pegawai->setField("JUMLAH", $reqJumlah[$index]);		
				$gaji_kondisi_jenis_pegawai->setField("PROSENTASE", $reqProsentase[$index]);
				$gaji_kondisi_jenis_pegawai->setField("SUMBER", $reqId);
				$gaji_kondisi_jenis_pegawai->setField("KALI", $reqKali[$index]);
				$gaji_kondisi_jenis_pegawai->setField("KELAS", $reqKelas);
				$gaji_kondisi_jenis_pegawai->setField("KELOMPOK", $reqKelompok);
				$gaji_kondisi_jenis_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
				$gaji_kondisi_jenis_pegawai->insert();
				unset($gaji_kondisi_jenis_pegawai);
				}
			}
			echo "Data berhasil disimpan.";
		}
	}
	
	function gaji_kondisi_jenis_pegawai_combo_edit_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/Kondisi.php");
		include_once("../WEB-INF/classes/base-gaji/GajiKondisiJenisPegawai.php");

		/* create objects */

		$kondisi = new Kondisi();
		$gaji_kondisi_jenis_pegawai = new GajiKondisiJenisPegawai();


		$reqId = httpFilterGet("reqId");
		$reqKelasId = httpFilterGet("reqKelasId");
		$reqKelompokId = httpFilterGet("reqKelompokId");
		$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$gaji_kondisi_jenis_pegawai->selectByParams(array("JENIS_PEGAWAI_ID" => $reqJenisPegawaiId, "GAJI_KONDISI_ID" => $reqId, "KELAS" => $reqKelasId, "KELOMPOK" => $reqKelompokId));
		$gaji_kondisi_jenis_pegawai->firstRow();
		$text = $gaji_kondisi_jenis_pegawai->getField("JUMLAH");

		function checkVariabel($text, $search)
		{
			$arrText = explode(",",$text);
			for($i=0;$i<count($arrText);$i++)
			{
				if($arrText[$i] == $search)
					return true;	
			}
			return false;
		}

		$j=0;
		$kondisi->selectByParams(array("KONDISI_PARENT_ID" => 0), -1, -1, " AND PERUNTUKAN LIKE '%G%' ");
		while($kondisi->nextRow())
		{
			$arr_parent[$j]['id'] = $kondisi->getField("KONDISI_ID");
			$arr_parent[$j]['text'] = $kondisi->getField("NAMA");
			if(checkVariabel($text, $kondisi->getField("KONDISI_ID")))
				$arr_parent[$j]['checked'] = true;
			$k = 0;
			$child = new Kondisi();
			$child->selectByParams(array("KONDISI_PARENT_ID" => $kondisi->getField("KONDISI_ID")), -1, -1, " AND PERUNTUKAN LIKE '%G%' ");
			while($child->nextRow())
			{
				$arr_child[$k]['id'] = $child->getField("KONDISI_ID");
				$arr_child[$k]['text'] = $child->getField("NAMA");
				if(checkVariabel($text, $child->getField("KONDISI_ID")))
					$arr_child[$k]['checked'] = true;
				
				$l = 0;
				$sub = new Kondisi();
				$sub->selectByParams(array("KONDISI_PARENT_ID" => $child->getField("KONDISI_ID")), -1, -1, " AND PERUNTUKAN LIKE '%G%' ");
				while($sub->nextRow())
				{
					$arr_sub[$l]['id'] = $sub->getField("KONDISI_ID");
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

		echo json_encode($arr_parent);
	}
	
	function gaji_kondisi_jenis_pegawai_combo_json_bak()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/GajiKondisi.php");


		/* create objects */

		$gaji_kondisi = new GajiKondisi();

		$reqId = httpFilterGet("reqId");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$j=0;
		$gaji_kondisi->selectByParams(array("GAJI_KONDISI_PARENT_ID" => 0));
		while($gaji_kondisi->nextRow())
		{
			$arr_parent[$j]['id'] = $gaji_kondisi->getField("GAJI_KONDISI_ID");
			$arr_parent[$j]['text'] = $gaji_kondisi->getField("NAMA");
			if($reqId == $gaji_kondisi->getField("GAJI_KONDISI_ID"))
				$arr_parent[$j]['checked'] = true;
			$k = 0;
			$child = new GajiKondisi();
			$child->selectByParams(array("GAJI_KONDISI_PARENT_ID" => $gaji_kondisi->getField("GAJI_KONDISI_ID")));
			while($child->nextRow())
			{
				$arr_child[$k]['id'] = $child->getField("GAJI_KONDISI_ID");
				$arr_child[$k]['text'] = $child->getField("NAMA");
				if($reqId == $child->getField("GAJI_KONDISI_ID"))
					$arr_child[$k]['checked'] = true;
				
				$l = 0;
				$sub = new GajiKondisi();
				$sub->selectByParams(array("GAJI_KONDISI_PARENT_ID" => $child->getField("GAJI_KONDISI_ID")));
				while($sub->nextRow())
				{
					$arr_sub[$l]['id'] = $sub->getField("GAJI_KONDISI_ID");
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

		echo json_encode($arr_parent);
	}
	
	function gaji_kondisi_jenis_pegawai_combo_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/Kondisi.php");


		/* create objects */

		$kondisi = new Kondisi();

		$reqId = httpFilterGet("reqId");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$j=0;
		$kondisi->selectByParams(array("KONDISI_PARENT_ID" => 0), -1, -1, " AND PERUNTUKAN LIKE '%G%' ");
		while($kondisi->nextRow())
		{
			$arr_parent[$j]['id'] = $kondisi->getField("KONDISI_ID");
			$arr_parent[$j]['text'] = $kondisi->getField("NAMA");
			$k = 0;
			$child = new Kondisi();
			$child->selectByParams(array("KONDISI_PARENT_ID" => $kondisi->getField("KONDISI_ID")), -1, -1, " AND PERUNTUKAN LIKE '%G%' ");
			while($child->nextRow())
			{
				$arr_child[$k]['id'] = $child->getField("KONDISI_ID");
				$arr_child[$k]['text'] = $child->getField("NAMA");
				
				$l = 0;
				$sub = new Kondisi();
				$sub->selectByParams(array("KONDISI_PARENT_ID" => $child->getField("KONDISI_ID")), -1, -1, " AND PERUNTUKAN LIKE '%G%' ");
				while($sub->nextRow())
				{
					$arr_sub[$l]['id'] = $sub->getField("KONDISI_ID");
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

		echo json_encode($arr_parent);
	}
	
	function gaji_kondisi_jenis_pegawai_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/GajiKondisiJenisPegawai.php");

		$gaji_kondisi_jenis_pegawai = new GajiKondisiJenisPegawai();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("JENIS_PEGAWAI_ID", "KELOMPOK_ID", "KELAS_ID", "NAMA", "KELOMPOK", "KELAS");
		$aColumnsAlias = array("JENIS_PEGAWAI_ID", "KELOMPOK_ID", "KELAS_ID", "NAMA", "KELOMPOK", "KELAS");

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
			if ( trim($sOrder) == "ORDER BY GAJI_KONDISI_JENIS_PEGAWAI_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY GAJI_KONDISI_JENIS_PEGAWAI_ID DESC";
				 
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


		$allRecord = $gaji_kondisi_jenis_pegawai->getCountByParams(array());
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_kondisi_jenis_pegawai->getCountByParams(array(), " AND (UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$gaji_kondisi_jenis_pegawai->selectByParamsMonitoring(array(), $dsplyRange, $dsplyStart, " AND (UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_kondisi_jenis_pegawai->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($gaji_kondisi_jenis_pegawai->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($gaji_kondisi_jenis_pegawai->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $gaji_kondisi_jenis_pegawai->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function gaji_kso_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();
		$gaji = new Gaji();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqMode = httpFilterGet("reqMode");

		$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(4, "SEMUA"));
		$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan(4));

		$aColumns[] = "ASAL_PERUSAHAAN";
		$aColumns[] = "PEGAWAI_ID";
		$aColumns[] = "NAMA";
		$aColumns[] = "NAMA";
		$aColumns[] = "NRP";
		for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
		{
			$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
		}
		for($i=0;$i<count($json_item_tanggungan->{"ITEM_TANGGUNGAN"});$i++)
		{
			$aColumns[] = "TANGGUNGAN_".$json_item_tanggungan->{"ITEM_TANGGUNGAN"}{$i};		
		}
		$aColumns[] = "TOTAL";
			
		$aColumnsAlias = array("A.PEGAWAI_ID", "A.NAMA", "A.NAMA", "A.NAMA");

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
			if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID ASC" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY A.PEGAWAI_ID DESC";
				 
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

		if($reqMode == "proses")
		{
			$gaji_awal_bulan->setField("PERIODE", $reqPeriode);
			$gaji_awal_bulan->setField("JENIS_PEGAWAI_ID", 4);		
			$gaji_awal_bulan->callHitungGajiAwalBulan();		
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";


		$allRecord = $gaji_awal_bulan->getCountByParams(array("B.JENIS_PEGAWAI_ID" => 4),$statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array("B.JENIS_PEGAWAI_ID" => 4), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement);

		$gaji_awal_bulan->selectByParamsGaji(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, $sOrder, $reqPeriode, 4);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			
			$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
			$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
			$total_gaji = 0;
			$total_tanggungan = 0;
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{	
				if(substr($aColumns[$i],0,4) == "GAJI")
				{
					$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
					if($column_gaji == "TOTAL_GAJI")
					{
						$row[] = currencyToPage($total_gaji);				
					}
					else
					{
						$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
						$total_gaji += $json_gaji->{$column_gaji}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "TANG")
				{
					$column_tanggungan = str_replace("TANGGUNGAN_", "", $aColumns[$i]);
					if($column_tanggungan == "TOTAL_TANGGUNGAN")
					{
						$row[] = currencyToPage($total_tanggungan);				
					}
					else
					{
						$row[] = currencyToPage($json_tanggungan->{$column_tanggungan}{0});
						$total_tanggungan += $json_tanggungan->{$column_tanggungan}{0};
					}
				}
				elseif($aColumns[$i] == "TOTAL")			
					$row[] = currencyToPage($total_gaji + $total_tanggungan);	
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
			}
			
			$output['aaData'][] = $row;
			
			unset($json_gaji);
		}

		echo json_encode( $output );
	}
	
	function gaji_mobilitas_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/MobilitasBantuan.php");

		$mobilitas_bantuan = new MobilitasBantuan();

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqMode = httpFilterGet("reqMode");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA", "JUMLAH", "JUMLAH_POTONGAN","JUMLAH_POTONGAN", "DIBAYARKAN");
		$aColumnsAlias = array("A.PEGAWAI_ID", "NRP", "NAMA", "JUMLAH", "JUMLAH_POTONGAN","JUMLAH_POTONGAN","DIBAYARKAN");

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
				$sOrder = " ORDER BY D.KELAS ASC, A.DEPARTEMEN_ID ASC";
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

		if($reqMode == "proses")
		{
			$mobilitas_bantuan->setField("JENIS_PEGAWAI_ID", $reqJenisPegawai);
			$mobilitas_bantuan->callMobilitasBantuan();
		}

		if($reqJenisPegawai == "")
		{}
		else
			$statement .= "AND C.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;


		$allRecord = $mobilitas_bantuan->getCountByParams(array(),$statement, $reqPeriode);
		//echo $mobilitas_bantuan->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $mobilitas_bantuan->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

		$mobilitas_bantuan->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " ,$reqPeriode , $sOrder);

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($mobilitas_bantuan->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($mobilitas_bantuan->getField($aColumns[$i]));
				else if($aColumns[$i] == "JUMLAH" || $aColumns[$i] == "JUMLAH_POTONGAN" || $aColumns[$i] == "DIBAYARKAN")
					$row[] = currencyToPage($mobilitas_bantuan->getField($aColumns[$i]));
				else
					$row[] = $mobilitas_bantuan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function gaji_organik_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();
		$gaji = new Gaji();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqMode = httpFilterGet("reqMode");
		$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");

		$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(1, "AWAL_BULAN"));
		$json_item_sumbangan = json_decode($gaji->getItemSumbanganDiberikan(1));
		$json_item_potongan = json_decode($gaji->getItemPotonganDiberikan(1));
		$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan(1));
		$json_item_potongan_lain = json_decode($gaji->getItemPotonganLain());

		$aColumns[] = "PEGAWAI_ID";
		$aColumns[] = "STATUS_BAYAR";
		$aColumns[] = "NO_URUT";
		$aColumns[] = "NRP";
		$aColumns[] = "NAMA";
		$aColumns[] = "JBT_KLS";
		$aColumns[] = "STATUS_BAYAR";
		for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
		{
			$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
		}
		for($i=0;$i<count($json_item_sumbangan->{"ITEM_SUMBANGAN"});$i++)
		{
			$aColumns[] = "SUMBANGAN_".$json_item_sumbangan->{"ITEM_SUMBANGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_potongan->{"ITEM_POTONGAN"});$i++)
		{
			$aColumns[] = "POTONGAN_".$json_item_potongan->{"ITEM_POTONGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_tanggungan->{"ITEM_TANGGUNGAN"});$i++)
		{
			$aColumns[] = "TANGGUNGAN_".$json_item_tanggungan->{"ITEM_TANGGUNGAN"}{$i};		
		}

		$aColumns[] = "LAIN";
		$aColumns[] = "TOTAL";
			
		$aColumnsAlias = array("A.PEGAWAI_ID", "B.STATUS_BAYAR", "B.NO_URUT", "A.NRP", "A.NAMA", "JBT_KLS");

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
				$sOrder = " ORDER BY NO_URUT ASC ";
				 
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

		if($reqMode == "proses")
		{
			$gaji_awal_bulan_proses = new GajiAwalBulan();
			$gaji_awal_bulan_proses->setField("PERIODE", $reqPeriode);
			$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "1");		
			$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();		
			unset($gaji_awal_bulan_proses);
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		$statement_count .= $statement." AND B.JENIS_PEGAWAI_ID IN (".$reqJenisPegawaiId.") ";
		$allRecord = $gaji_awal_bulan->getCountByParams(array(),$statement_count, $reqPeriode);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array(), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement_count, $reqPeriode);

		$gaji_awal_bulan->selectByParamsGaji(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, "ORDER BY NO_URUT ASC", $reqPeriode, $reqJenisPegawaiId);
		//echo $gaji_awal_bulan->query;exit;

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			
			$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
			$json_sumbangan = json_decode($gaji_awal_bulan->getField("SUMBANGAN_JSON"));
			$json_potongan = json_decode($gaji_awal_bulan->getField("POTONGAN_JSON"));
			$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
			$json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
			$total_gaji = 0;
			$total_sumbangan = 0;
			$total_potongan = 0;
			$total_tanggungan = 0;
			$total_potongan_lain = 0;
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{	
				if(substr($aColumns[$i],0,4) == "GAJI")
				{
					$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
					if($column_gaji == "TOTAL_GAJI")
					{
						$row[] = currencyToPage($total_gaji);				
					}
					else
					{
						$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
						$total_gaji += $json_gaji->{$column_gaji}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "SUMB")
				{
					$column_sumbangan = str_replace("SUMBANGAN_", "", $aColumns[$i]);
					if($column_sumbangan == "TOTAL_SUMBANGAN")
					{
						$row[] = currencyToPage($total_sumbangan);				
					}
					else
					{
						$row[] = currencyToPage($json_sumbangan->{$column_sumbangan}{0});
						$total_sumbangan += $json_sumbangan->{$column_sumbangan}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "POTO")
				{
					$column_potongan = str_replace("POTONGAN_", "", $aColumns[$i]);
					if($column_potongan == "TOTAL_POTONGAN")
					{
						$row[] = currencyToPage($total_potongan);				
					}
					else
					{
						$row[] = currencyToPage($json_potongan->{$column_potongan}{0});
						$total_potongan += $json_potongan->{$column_potongan}{0};
					}
				}		
				elseif(substr($aColumns[$i],0,4) == "TANG")
				{
					$column_tanggungan = str_replace("TANGGUNGAN_", "", $aColumns[$i]);
					if($column_tanggungan == "TOTAL_TANGGUNGAN")
					{
						$row[] = currencyToPage($total_tanggungan);				
					}
					else
					{
						$row[] = currencyToPage($json_tanggungan->{$column_tanggungan}{0});
						$total_tanggungan += $json_tanggungan->{$column_tanggungan}{0};
					}
				}
				elseif($aColumns[$i] == "LAIN")		
				{
					for($j=0;$j<count($json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"});$j++)
					{
						$total_potongan_lain += $json_potongan_lain->{$json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"}{$j}}{0};	
					}
					$row[] = currencyToPage($total_potongan_lain);	
				}
				elseif($aColumns[$i] == "STATUS_BAYAR")		
				{
					if($gaji_awal_bulan->getField($aColumns[$i]) == 1)
						$row[] = "<img src='../WEB-INF/images/centang.png'>";
					else
						$row[] = "";
					
				}			
				elseif($aColumns[$i] == "TOTAL")			
				{
					$total_sebelum = $total_gaji - $total_potongan;
					$total_pembulatan = (($total_sebelum - $total_potongan_lain) % 1000);
					if($total_pembulatan == 0)
						$total_pembulatan = 1000;
					$total_gaji = $total_sebelum;
					$row[] = currencyToPage($total_gaji - $total_potongan_lain);
				}
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
			}
			
			$output['aaData'][] = $row;
			
			unset($json_gaji);
		}

		echo json_encode( $output );
	}
	
	function gaji_organik_set_status()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");

		/* create objects */
		$gaji_awal_bulan = new GajiAwalBulan();

		$reqId = httpFilterGet("reqId");
		$reqNilai = httpFilterGet("reqNilai");
		$reqPeriode = httpFilterGet("reqPeriode");

			$gaji_awal_bulan->setField("FIELD", "STATUS_BAYAR");
			$gaji_awal_bulan->setField("FIELD_VALUE", $reqNilai);
			$gaji_awal_bulan->setField("PEGAWAI_ID", $reqId);
			$gaji_awal_bulan->setField("BULANTAHUN", $reqPeriode);
			$gaji_awal_bulan->updateByField();

		$met = array();
		$i=0;

		$met[0]['STATUS_BAYAR'] = 1;
		echo json_encode($met);
	}
	
	function gaji_pembayaran_manfaat_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/PembayaranManfaat.php");

		$pembayaran_manfaat = new PembayaranManfaat();

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqMode = httpFilterGet("reqMode");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("ID", "NRP", "NAMA", "GENDER", "STATUS", "JABATAN", "DIVISI", "TGL_LAHIR", "TGL_MULAI_BEKERJA_P3", "TGL_MULAI_BEKERJA_PMS", "TGL_BERHENTI_BEKERJA", "MERIT_PMS", "TPP_PMS", "TUNJANGAN_PERBANTUAN", "TUNJANGAN_JABATAN", "TOTAL_UPAH_GROSS", "TOTAL_PURNA_BAKTI", "SALDO_DPLK_SAAT_BERHENTI", "PHDP_SAAT_BERHENTI", "BESAR_MANFAAT_PERUSAHAAN", "UANG_DUKA", "ALASAN_BERHENTI");
		$aColumnsAlias = array("ID", "NRP", "NAMA", "GENDER", "STATUS", "JABATAN", "DIVISI", "TGL_LAHIR", "TGL_MULAI_BEKERJA_P3", "TGL_MULAI_BEKERJA_PMS", "TGL_BERHENTI_BEKERJA", "MERIT_PMS", "TPP_PMS", "TUNJANGAN_PERBANTUAN", "TUNJANGAN_JABATAN", "TOTAL_UPAH_GROSS", "TOTAL_PURNA_BAKTI", "SALDO_DPLK_SAAT_BERHENTI", "PHDP_SAAT_BERHENTI", "BESAR_MANFAAT_PERUSAHAAN", "UANG_DUKA", "ALASAN_BERHENTI");

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

		if($reqJenisPegawai == "")
		{}
		else
			$statement .= "AND A.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;
			
		if($reqDepartemen == "")
		{}
		else
			$statement .= "AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";


		$allRecord = $pembayaran_manfaat->getCountByParams(array(),$statement, $reqPeriode);
		//echo $pembayaran_manfaat->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $pembayaran_manfaat->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

		$pembayaran_manfaat->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $reqPeriode, $sOrder);

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($pembayaran_manfaat->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				//if($aColumns[$i] == "TANGGAL_LAHIR")
				if(strpos($aColumns[$i], "TGL") !== false)
					$row[] = getFormattedDate($pembayaran_manfaat->getField($aColumns[$i]));
				else if(strpos($aColumns[$i], "PMS") !== false || strpos($aColumns[$i], "TUNJANGAN") !== false || strpos($aColumns[$i], "TOTAL") !== false || strpos($aColumns[$i], "DPLK") !== false || strpos($aColumns[$i], "PHDP") !== false || strpos($aColumns[$i], "UANG") !== false || strpos($aColumns[$i], "BESAR") !== false)
					$row[] = currencyToPage($pembayaran_manfaat->getField($aColumns[$i]));		
				else
					$row[] = $pembayaran_manfaat->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function gaji_perbantuan_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();
		$gaji = new Gaji();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqMode = httpFilterGet("reqMode");

		$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(2, "AWAL_BULAN"));
		$json_item_sumbangan = json_decode($gaji->getItemSumbanganDiberikan(2));
		$json_item_potongan = json_decode($gaji->getItemPotonganDiberikan(2));
		$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan(2));
		$json_item_potongan_lain = json_decode($gaji->getItemPotonganLain());

		$aColumns[] = "PEGAWAI_ID";
		$aColumns[] = "STATUS_BAYAR";
		$aColumns[] = "NRP";
		$aColumns[] = "NAMA";
		for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
		{
			$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
		}
		for($i=0;$i<count($json_item_sumbangan->{"ITEM_SUMBANGAN"});$i++)
		{
			$aColumns[] = "SUMBANGAN_".$json_item_sumbangan->{"ITEM_SUMBANGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_potongan->{"ITEM_POTONGAN"});$i++)
		{
			$aColumns[] = "POTONGAN_".$json_item_potongan->{"ITEM_POTONGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_tanggungan->{"ITEM_TANGGUNGAN"});$i++)
		{
			$aColumns[] = "TANGGUNGAN_".$json_item_tanggungan->{"ITEM_TANGGUNGAN"}{$i};		
		}

		$aColumns[] = "POTONGAN_LAIN";
		$aColumns[] = "TOTAL";
			
		$aColumnsAlias = array("A.PEGAWAI_ID", "A.NAMA", "A.NAMA", "A.NAMA");

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
			if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID ASC" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY A.PEGAWAI_ID DESC";
				 
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

		if($reqMode == "proses")
		{
			$gaji_awal_bulan->setField("PERIODE", $reqPeriode);
			$gaji_awal_bulan->setField("JENIS_PEGAWAI_ID", 2);		
			$gaji_awal_bulan->callHitungGajiAwalBulan();		
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";


		$allRecord = $gaji_awal_bulan->getCountByParams(array("B.JENIS_PEGAWAI_ID" => 2),$statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array("B.JENIS_PEGAWAI_ID" => 2), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement);

		$gaji_awal_bulan->selectByParamsGaji(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, $sOrder, $reqPeriode, 2);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			
			$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
			$json_sumbangan = json_decode($gaji_awal_bulan->getField("SUMBANGAN_JSON"));
			$json_potongan = json_decode($gaji_awal_bulan->getField("POTONGAN_JSON"));
			$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
			$json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
			$total_gaji = 0;
			$total_sumbangan = 0;
			$total_potongan = 0;
			$total_tanggungan = 0;
			$total_potongan_lain = 0;
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{	
				if(substr($aColumns[$i],0,4) == "GAJI")
				{
					$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
					if($column_gaji == "TOTAL_GAJI")
					{
						$row[] = currencyToPage($total_gaji);				
					}
					else
					{
						$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
						$total_gaji += $json_gaji->{$column_gaji}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "SUMB")
				{
					$column_sumbangan = str_replace("SUMBANGAN_", "", $aColumns[$i]);
					if($column_sumbangan == "TOTAL_SUMBANGAN")
					{
						$row[] = currencyToPage($total_sumbangan);				
					}
					else
					{
						$row[] = currencyToPage($json_sumbangan->{$column_sumbangan}{0});
						$total_sumbangan += $json_sumbangan->{$column_sumbangan}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "POTO")
				{
					$column_potongan = str_replace("POTONGAN_", "", $aColumns[$i]);
					if($column_potongan == "TOTAL_POTONGAN")
					{
						$row[] = currencyToPage($total_potongan);				
					}
					else
					{
						$row[] = currencyToPage($json_potongan->{$column_potongan}{0});
						$total_potongan += $json_potongan->{$column_potongan}{0};
					}
				}		
				elseif(substr($aColumns[$i],0,4) == "TANG")
				{
					$column_tanggungan = str_replace("TANGGUNGAN_", "", $aColumns[$i]);
					if($column_tanggungan == "TOTAL_TANGGUNGAN")
					{
						$row[] = currencyToPage($total_tanggungan);				
					}
					else
					{
						$row[] = currencyToPage($json_tanggungan->{$column_tanggungan}{0});
						$total_tanggungan += $json_tanggungan->{$column_tanggungan}{0};
					}
				}
				elseif($aColumns[$i] == "POTONGAN_LAIN")		
				{
					for($j=0;$j<count($json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"});$j++)
					{
						$total_potongan_lain += $json_potongan_lain->{$json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"}{$j}}{0};	
					}
					$row[] = currencyToPage($total_potongan_lain);	
				}
				elseif($aColumns[$i] == "TOTAL")			
				{
					$total_sebelum = $total_gaji - $total_potongan;
					$total_pembulatan = ($total_sebelum % 1000);
					$total_gaji = $total_sebelum + (1000 - $total_pembulatan);
					$row[] = currencyToPage($total_gaji - $total_potongan_lain);
				}
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
			}
			
			$output['aaData'][] = $row;
			
			unset($json_gaji);
		}

		echo json_encode( $output );
	}
	
	function gaji_perbantuan_organik_capeg_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();
		$gaji = new Gaji();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqMode = httpFilterGet("reqMode");
		$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
		$reqStatusPegawaiId = httpFilterGet("reqStatusPegawaiId");

		$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(2, "AWAL_BULAN"));
		$json_item_sumbangan = json_decode($gaji->getItemSumbanganDiberikan(2));
		$json_item_potongan = json_decode($gaji->getItemPotonganDiberikan(2));
		$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan(2));
		$json_item_potongan_lain = json_decode($gaji->getItemPotonganLain());

		$aColumns[] = "PEGAWAI_ID";
		$aColumns[] = "STATUS_BAYAR";
		$aColumns[] = "NO_URUT";
		$aColumns[] = "NRP";
		$aColumns[] = "NAMA";
		$aColumns[] = "JBT_KLS";
		$aColumns[] = "STATUS_BAYAR";
		for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
		{
			$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
		}
		for($i=0;$i<count($json_item_sumbangan->{"ITEM_SUMBANGAN"});$i++)
		{
			$aColumns[] = "SUMBANGAN_".$json_item_sumbangan->{"ITEM_SUMBANGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_potongan->{"ITEM_POTONGAN"});$i++)
		{
			$aColumns[] = "POTONGAN_".$json_item_potongan->{"ITEM_POTONGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_tanggungan->{"ITEM_TANGGUNGAN"});$i++)
		{
			$aColumns[] = "TANGGUNGAN_".$json_item_tanggungan->{"ITEM_TANGGUNGAN"}{$i};		
		}

		$aColumns[] = "LAIN";
		$aColumns[] = "TOTAL";
			
		$aColumnsAlias = array("A.PEGAWAI_ID", "B.STATUS_BAYAR", "B.NO_URUT", "A.NRP", "A.NAMA", "JBT_KLS");

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
				$sOrder = " ORDER BY NO_URUT ASC ";
				 
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

		if($reqMode == "proses")
		{
			$gaji_awal_bulan_proses = new GajiAwalBulan();
			$gaji_awal_bulan_proses->setField("PERIODE", $reqPeriode);
			$gaji_awal_bulan_proses->setField("JENIS_PEGAWAI_ID", "2");		
			$gaji_awal_bulan_proses->callHitungGajiAwalBulanV2();		
			unset($gaji_awal_bulan_proses);
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		$statement_count .= $statement." AND B.JENIS_PEGAWAI_ID IN (".$reqJenisPegawaiId.") ";
		$allRecord = $gaji_awal_bulan->getCountByParams(array(),$statement_count, $reqPeriode, $reqStatusPegawaiId);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array(), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement_count, $reqPeriode, $reqStatusPegawaiId);

		$gaji_awal_bulan->selectByParamsGaji(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, "ORDER BY NO_URUT ASC", $reqPeriode, $reqJenisPegawaiId, $reqStatusPegawaiId);     		
		//echo $gaji_awal_bulan->query;exit;

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			
			$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
			$json_sumbangan = json_decode($gaji_awal_bulan->getField("SUMBANGAN_JSON"));
			$json_potongan = json_decode($gaji_awal_bulan->getField("POTONGAN_JSON"));
			$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
			$json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
			$total_gaji = 0;
			$total_sumbangan = 0;
			$total_potongan = 0;
			$total_tanggungan = 0;
			$total_potongan_lain = 0;
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{	
				if(substr($aColumns[$i],0,4) == "GAJI")
				{
					$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
					if($column_gaji == "TOTAL_GAJI")
					{
						$row[] = currencyToPage($total_gaji);				
					}
					else
					{
						$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
						$total_gaji += $json_gaji->{$column_gaji}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "SUMB")
				{
					$column_sumbangan = str_replace("SUMBANGAN_", "", $aColumns[$i]);
					if($column_sumbangan == "TOTAL_SUMBANGAN")
					{
						$row[] = currencyToPage($total_sumbangan);				
					}
					else
					{
						$row[] = currencyToPage($json_sumbangan->{$column_sumbangan}{0});
						$total_sumbangan += $json_sumbangan->{$column_sumbangan}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "POTO")
				{
					$column_potongan = str_replace("POTONGAN_", "", $aColumns[$i]);
					if($column_potongan == "TOTAL_POTONGAN")
					{
						$row[] = currencyToPage($total_potongan);				
					}
					else
					{
						$row[] = currencyToPage($json_potongan->{$column_potongan}{0});
						$total_potongan += $json_potongan->{$column_potongan}{0};
					}
				}		
				elseif(substr($aColumns[$i],0,4) == "TANG")
				{
					$column_tanggungan = str_replace("TANGGUNGAN_", "", $aColumns[$i]);
					if($column_tanggungan == "TOTAL_TANGGUNGAN")
					{
						$row[] = currencyToPage($total_tanggungan);				
					}
					else
					{
						$row[] = currencyToPage($json_tanggungan->{$column_tanggungan}{0});
						$total_tanggungan += $json_tanggungan->{$column_tanggungan}{0};
					}
				}
				elseif($aColumns[$i] == "LAIN")		
				{
					for($j=0;$j<count($json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"});$j++)
					{
						$total_potongan_lain += $json_potongan_lain->{$json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"}{$j}}{0};	
					}
					$row[] = currencyToPage($total_potongan_lain);	
				}
				elseif($aColumns[$i] == "STATUS_BAYAR")		
				{
					if($gaji_awal_bulan->getField($aColumns[$i]) == 1)
						$row[] = "<img src='../WEB-INF/images/centang.png'>";
					else
						$row[] = "";
					
				}		
				elseif($aColumns[$i] == "TOTAL")			
				{
					$total_sebelum = $total_gaji - $total_potongan;
					$total_pembulatan = (($total_sebelum - $total_potongan_lain) % 1000);
					if($total_pembulatan == 0)
						$total_pembulatan = 1000;
					$total_gaji = $total_sebelum;
					$row[] = currencyToPage($total_gaji - $total_potongan_lain);
				}
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
			}
			
			$output['aaData'][] = $row;
			
			unset($json_gaji);
		}

		echo json_encode( $output );
	}
	
	function gaji_perbantuan_set_status()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");

		/* create objects */
		$gaji_awal_bulan = new GajiAwalBulan();

		$reqId = httpFilterGet("reqId");
		$reqNilai = httpFilterGet("reqNilai");
		$reqPeriode = httpFilterGet("reqPeriode");

			$gaji_awal_bulan->setField("FIELD", "STATUS_BAYAR");
			$gaji_awal_bulan->setField("FIELD_VALUE", $reqNilai);
			$gaji_awal_bulan->setField("PEGAWAI_ID", $reqId);
			$gaji_awal_bulan->setField("BULANTAHUN", $reqPeriode);
			$gaji_awal_bulan->updateByField();

		$met = array();
		$i=0;

		$met[0]['STATUS_BAYAR'] = 1;
		echo json_encode($met);
	}
	
	function gaji_periode_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/GajiPeriode.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$set= new GajiPeriode();

		$reqId = httpFilterPost("reqId");
		$reqPeriode = httpFilterPost("reqPeriode");

		if($reqPeriode == ""){}
		else
		{
			$set_detil= new GajiPeriode();
			$statement= " AND PERIODE = '".$reqPeriode."'";
			$set_detil->selectByParams(array(), -1,-1, $statement);
			$set_detil->firstRow();
			$tempPeriode= $set_detil->getField("PERIODE");
			unset($set_detil);
			
			if($tempPeriode == "")
			{
				$set->setField("GAJI_PERIODE_ID", $reqId);
				$set->setField("PERIODE", $reqPeriode);
				if($set->insert())
					echo "Data berhasil disimpan.";
			}
		}
	}
	
	function gaji_periode_capeg_pkwt_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/GajiPeriodeCapegPKWT.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$set= new GajiPeriodeCapegPKWT();

		$reqId = httpFilterPost("reqId");
		$reqPeriode = httpFilterPost("reqPeriode");

		if($reqPeriode == ""){}
		else
		{
			$set_detil= new GajiPeriodeCapegPKWT();
			$statement= " AND PERIODE = '".$reqPeriode."'";
			$set_detil->selectByParams(array(), -1,-1, $statement);
			$set_detil->firstRow();
			$tempPeriode= $set_detil->getField("PERIODE");
			unset($set_detil);
			
			if($tempPeriode == "")
			{
				$set->setField("GAJI_PERIODE_CAPEG_PKWT_ID", $reqId);
				$set->setField("PERIODE", $reqPeriode);
				if($set->insert())
					echo "Data berhasil disimpan.";
			}
		}
	}
	
	function gaji_periode_tahunan_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/GajiPeriodeTahun.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$set= new GajiPeriodeTahun();

		$reqId = httpFilterPost("reqId");
		$reqPeriode = httpFilterPost("reqPeriode");

		if($reqPeriode == ""){}
		else
		{
			$set_detil= new GajiPeriodeTahun();
			$statement= " AND PERIODE = '".$reqPeriode."'";
			$set_detil->selectByParams(array(), -1,-1, $statement);
			$set_detil->firstRow();
			$tempPeriode= $set_detil->getField("PERIODE");
			unset($set_detil);
			
			if($tempPeriode == "")
			{
				$set->setField("GAJI_PERIODE_TAHUN_ID", $reqId);
				$set->setField("PERIODE", $reqPeriode);
				if($set->insert())
					echo "Data berhasil disimpan.";
			}
		}
	}
	
	function gaji_periode_tengah_bulan_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/GajiPeriodeTengahBulan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$set= new GajiPeriodeTengahBulan();

		$reqId = httpFilterPost("reqId");
		$reqPeriode = httpFilterPost("reqPeriode");

		if($reqPeriode == ""){}
		else
		{
			$set_detil= new GajiPeriodeTengahBulan();
			$statement= " AND PERIODE = '".$reqPeriode."'";
			$set_detil->selectByParams(array(), -1,-1, $statement);
			$set_detil->firstRow();
			$tempPeriode= $set_detil->getField("PERIODE");
			unset($set_detil);
			
			if($tempPeriode == "")
			{
				$set->setField("GAJI_PERIODE_TENGAH_BULAN_ID", $reqId);
				$set->setField("PERIODE", $reqPeriode);
				if($set->insert())
					echo "Data berhasil disimpan.";
			}
		}
	}
	
	function gaji_pkwt_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();
		$gaji = new Gaji();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqMode = httpFilterGet("reqMode");

		$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(3, "AWAL_BULAN"));
		$json_item_sumbangan = json_decode($gaji->getItemSumbanganDiberikan(3));
		$json_item_potongan = json_decode($gaji->getItemPotonganDiberikan(3));
		$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan(3));
		$json_item_potongan_lain = json_decode($gaji->getItemPotonganLain());

		$aColumns[] = "PEGAWAI_ID";
		$aColumns[] = "STATUS_BAYAR";
		$aColumns[] = "NO_URUT";
		$aColumns[] = "NRP";
		$aColumns[] = "NAMA";
		$aColumns[] = "JBT_KLS";
		$aColumns[] = "STATUS_BAYAR";
		for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
		{
			$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
		}
		for($i=0;$i<count($json_item_sumbangan->{"ITEM_SUMBANGAN"});$i++)
		{
			$aColumns[] = "SUMBANGAN_".$json_item_sumbangan->{"ITEM_SUMBANGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_potongan->{"ITEM_POTONGAN"});$i++)
		{
			$aColumns[] = "POTONGAN_".$json_item_potongan->{"ITEM_POTONGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_tanggungan->{"ITEM_TANGGUNGAN"});$i++)
		{
			$aColumns[] = "TANGGUNGAN_".$json_item_tanggungan->{"ITEM_TANGGUNGAN"}{$i};		
		}
		$aColumns[] = "POTONGAN_LAIN";
		$aColumns[] = "TOTAL";
			
		$aColumnsAlias = array("A.PEGAWAI_ID", "B.STATUS_BAYAR", "B.NO_URUT", "A.NRP", "A.NAMA", "JBT_KLS");


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
				$sOrder = " ORDER BY NO_URUT ASC ";
				 
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

		if($reqMode == "proses")
		{
			$gaji_awal_bulan->setField("PERIODE", $reqPeriode);
			$gaji_awal_bulan->setField("JENIS_PEGAWAI_ID", 3);		
			$gaji_awal_bulan->callHitungGajiAwalBulanV2();		
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";


		$allRecord = $gaji_awal_bulan->getCountByParams(array("B.JENIS_PEGAWAI_ID" => 3),$statement, $reqPeriode);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array("B.JENIS_PEGAWAI_ID" => 3), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, $reqPeriode);

		$gaji_awal_bulan->selectByParamsGaji(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, "ORDER BY NO_URUT ASC", $reqPeriode, 3);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			
			$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
			$json_sumbangan = json_decode($gaji_awal_bulan->getField("SUMBANGAN_JSON"));
			$json_potongan = json_decode($gaji_awal_bulan->getField("POTONGAN_JSON"));
			$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
			$json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
			$total_gaji = 0;
			$total_tanggungan = 0;
			$total_potongan_lain = 0;
			$total_sumbangan = 0;
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{	
				if(substr($aColumns[$i],0,4) == "GAJI")
				{
					$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
					if($column_gaji == "TOTAL_GAJI")
					{
						$row[] = currencyToPage($total_gaji);				
					}
					else
					{
						$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
						$total_gaji += $json_gaji->{$column_gaji}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "SUMB")
				{
					$column_sumbangan = str_replace("SUMBANGAN_", "", $aColumns[$i]);
					if($column_sumbangan == "TOTAL_SUMBANGAN")
					{
						$row[] = currencyToPage($total_sumbangan);				
					}
					else
					{
						$row[] = currencyToPage($json_sumbangan->{$column_sumbangan}{0});
						$total_sumbangan += $json_sumbangan->{$column_sumbangan}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "POTO")
				{
					$column_potongan = str_replace("POTONGAN_", "", $aColumns[$i]);
					if($column_potongan == "TOTAL_POTONGAN")
					{
						$row[] = currencyToPage($total_potongan);				
					}
					else
					{
						$row[] = currencyToPage($json_potongan->{$column_potongan}{0});
						$total_potongan += $json_potongan->{$column_potongan}{0};
					}
				}			
				elseif(substr($aColumns[$i],0,4) == "TANG")
				{
					$column_tanggungan = str_replace("TANGGUNGAN_", "", $aColumns[$i]);
					if($column_tanggungan == "TOTAL_TANGGUNGAN")
					{
						$row[] = currencyToPage($total_tanggungan);				
					}
					else
					{
						$row[] = currencyToPage($json_tanggungan->{$column_tanggungan}{0});
						$total_tanggungan += $json_tanggungan->{$column_tanggungan}{0};
					}
				}
				elseif($aColumns[$i] == "POTONGAN_LAIN")		
				{
					for($j=0;$j<count($json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"});$j++)
					{
						$total_potongan_lain += $json_potongan_lain->{$json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"}{$j}}{0};	
					}
					$row[] = currencyToPage($total_potongan_lain);	
				}
				elseif($aColumns[$i] == "STATUS_BAYAR")		
				{
					if($gaji_awal_bulan->getField($aColumns[$i]) == 1)
						$row[] = "<img src='../WEB-INF/images/centang.png'>";
					else
						$row[] = "";
					
				}			
				elseif($aColumns[$i] == "TOTAL")			
				{
					$total_sebelum = $total_gaji - $total_potongan;
					$total_pembulatan = ($total_sebelum % 1000);
					if($total_pembulatan == 0)
						$total_pembulatan = 1000;
					$total_gaji = $total_sebelum;
					$row[] = currencyToPage($total_gaji - $total_potongan_lain);
				}
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
			}
			
			$output['aaData'][] = $row;
			
			unset($json_gaji);
		}

		echo json_encode( $output );
	}
	
	function gaji_pkwt_khusus_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();
		$gaji = new Gaji();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqMode = httpFilterGet("reqMode");

		$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(12, "SEMUA"));
		$json_item_sumbangan = json_decode($gaji->getItemSumbanganDiberikan(12));
		$json_item_potongan = json_decode($gaji->getItemPotonganDiberikan(12));
		$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan(12));
		$json_item_potongan_lain = json_decode($gaji->getItemPotonganLain());

		$aColumns[] = "PEGAWAI_ID";
		$aColumns[] = "STATUS_BAYAR";
		$aColumns[] = "NO_URUT";
		$aColumns[] = "NRP";
		$aColumns[] = "NAMA";
		$aColumns[] = "JBT_KLS";
		$aColumns[] = "STATUS_BAYAR";
		for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
		{
			$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
		}
		for($i=0;$i<count($json_item_sumbangan->{"ITEM_SUMBANGAN"});$i++)
		{
			$aColumns[] = "SUMBANGAN_".$json_item_sumbangan->{"ITEM_SUMBANGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_potongan->{"ITEM_POTONGAN"});$i++)
		{
			$aColumns[] = "POTONGAN_".$json_item_potongan->{"ITEM_POTONGAN"}{$i};		
		}
		for($i=0;$i<count($json_item_tanggungan->{"ITEM_TANGGUNGAN"});$i++)
		{
			$aColumns[] = "TANGGUNGAN_".$json_item_tanggungan->{"ITEM_TANGGUNGAN"}{$i};		
		}
		$aColumns[] = "POTONGAN_LAIN";
		$aColumns[] = "TOTAL";
			
		$aColumnsAlias = array("A.PEGAWAI_ID", "B.STATUS_BAYAR", "B.NO_URUT", "A.NRP", "A.NAMA", "JBT_KLS");


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
				$sOrder = " ORDER BY NO_URUT ASC ";
				 
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

		if($reqMode == "proses")
		{
			$gaji_awal_bulan->setField("PERIODE", $reqPeriode);
			$gaji_awal_bulan->setField("JENIS_PEGAWAI_ID", 3);		
			$gaji_awal_bulan->callHitungGajiAwalBulanV2();		
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";


		$allRecord = $gaji_awal_bulan->getCountByParams(array("B.JENIS_PEGAWAI_ID" => 12),$statement, $reqPeriode);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array("B.JENIS_PEGAWAI_ID" => 12), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, $reqPeriode);

		$gaji_awal_bulan->selectByParamsGaji(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, "ORDER BY NO_URUT ASC", $reqPeriode, 12);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			
			$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
			$json_sumbangan = json_decode($gaji_awal_bulan->getField("SUMBANGAN_JSON"));
			$json_potongan = json_decode($gaji_awal_bulan->getField("POTONGAN_JSON"));
			$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
			$json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
			$total_gaji = 0;
			$total_tanggungan = 0;
			$total_potongan_lain = 0;
			$total_sumbangan = 0;
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{	
				if(substr($aColumns[$i],0,4) == "GAJI")
				{
					$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
					if($column_gaji == "TOTAL_GAJI")
					{
						$row[] = currencyToPage($total_gaji);				
					}
					else
					{
						$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
						$total_gaji += $json_gaji->{$column_gaji}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "SUMB")
				{
					$column_sumbangan = str_replace("SUMBANGAN_", "", $aColumns[$i]);
					if($column_sumbangan == "TOTAL_SUMBANGAN")
					{
						$row[] = currencyToPage($total_sumbangan);				
					}
					else
					{
						$row[] = currencyToPage($json_sumbangan->{$column_sumbangan}{0});
						$total_sumbangan += $json_sumbangan->{$column_sumbangan}{0};
					}
				}
				elseif(substr($aColumns[$i],0,4) == "POTO")
				{
					$column_potongan = str_replace("POTONGAN_", "", $aColumns[$i]);
					if($column_potongan == "TOTAL_POTONGAN")
					{
						$row[] = currencyToPage($total_potongan);				
					}
					else
					{
						$row[] = currencyToPage($json_potongan->{$column_potongan}{0});
						$total_potongan += $json_potongan->{$column_potongan}{0};
					}
				}			
				elseif(substr($aColumns[$i],0,4) == "TANG")
				{
					$column_tanggungan = str_replace("TANGGUNGAN_", "", $aColumns[$i]);
					if($column_tanggungan == "TOTAL_TANGGUNGAN")
					{
						$row[] = currencyToPage($total_tanggungan);				
					}
					else
					{
						$row[] = currencyToPage($json_tanggungan->{$column_tanggungan}{0});
						$total_tanggungan += $json_tanggungan->{$column_tanggungan}{0};
					}
				}
				elseif($aColumns[$i] == "POTONGAN_LAIN")		
				{
					for($j=0;$j<count($json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"});$j++)
					{
						$total_potongan_lain += $json_potongan_lain->{$json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"}{$j}}{0};	
					}
					$row[] = currencyToPage($total_potongan_lain);	
				}
				elseif($aColumns[$i] == "STATUS_BAYAR")		
				{
					if($gaji_awal_bulan->getField($aColumns[$i]) == 1)
						$row[] = "<img src='../WEB-INF/images/centang.png'>";
					else
						$row[] = "";
					
				}			
				elseif($aColumns[$i] == "TOTAL")			
				{
					$total_sebelum = $total_gaji - $total_potongan;
					$total_pembulatan = ($total_sebelum % 1000);
					if($total_pembulatan == 0)
						$total_pembulatan = 1000;
					$total_gaji = $total_sebelum;
					$row[] = currencyToPage($total_gaji - $total_potongan_lain);
				}
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
			}
			
			$output['aaData'][] = $row;
			
			unset($json_gaji);
		}

		echo json_encode( $output );
	}
	
	function gaji_pkwt_set_status()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");

		/* create objects */
		$gaji_awal_bulan = new GajiAwalBulan();

		$reqId = httpFilterGet("reqId");
		$reqNilai = httpFilterGet("reqNilai");
		$reqPeriode = httpFilterGet("reqPeriode");

			$gaji_awal_bulan->setField("FIELD", "STATUS_BAYAR");
			$gaji_awal_bulan->setField("FIELD_VALUE", $reqNilai);
			$gaji_awal_bulan->setField("PEGAWAI_ID", $reqId);
			$gaji_awal_bulan->setField("BULANTAHUN", $reqPeriode);
			$gaji_awal_bulan->updateByField();

		$met = array();
		$i=0;

		$met[0]['STATUS_BAYAR'] = 1;
		echo json_encode($met);
	}
	
	function gaji_premi_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-operasional/Kapal.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulanLog.php");

		$kapal = new Kapal();
		$log = new GajiAwalBulanLog();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqMode = httpFilterGet("reqMode");
		$reqPeriode = httpFilterGet("reqPeriode");
		 
		$aColumns = array("KAPAL_ID", "NAMA", "KAPAL_JENIS_NAMA", "KODE", "CALL_SIGN", "IMO_NUMBER", "LOKASI_NAMA","JUMLAH_KRU");
		$aColumnsAlias = array("KAPAL_ID", "NAMA", "B.NAMA", "KODE", "CALL_SIGN", "IMO_NUMBER", "LOKASI_NAMA", "JUMLAH_KRU");

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
			if ( trim($sOrder) == "ORDER BY A.KAPAL_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				//$sOrder = " ORDER BY PEGAWAI_ID DESC";
				$sOrder = " ORDER BY A.KAPAL_ID ASC";
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


		if($reqMode == "proses")
		{
			$log->setField("PERIODE", $reqPeriode);
			$log->setField("PROSES_BY", $userLogin->nama);
			$log->setField("JENIS_PROSES", "GAJI_PREMI");
			$log->insert();
			$kapal->callHitungPremi();		
		}

		$allRecord = $kapal->getCountByParams(array(),$statement);
		//echo $kapal->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $kapal->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.KODE) LIKE '%".strtoupper($_GET['sSearch'])."%')) ");

		//echo $kapal->query;
		$kapal->selectByParamsPremi(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.KODE) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode, $sOrder);
		//" AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') AND (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%') "

		//echo $kapal->query;

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($kapal->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($kapal->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($kapal->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $kapal->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function gaji_premi_khusus_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-operasional/KapalPekerjaan.php");

		$kapal_pekerjaan = new KapalPekerjaan();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqMode = httpFilterGet("reqMode");

		$aColumns = array('KAPAL_PEKERJAAN_ID', 'KAPAL_NAMA', 'LOKASI_NAMA', 'NO_KONTRAK', 'NAMA', 'TANGGAL_AWAL', 'TANGGAL_AKHIR', 'JUMLAH', 'TOTAL_PREMI');
		$aColumnsAlias = array('KAPAL_PEKERJAAN_ID', 'C.NAMA', 'B.NAMA', 'NO_KONTRAK', 'A.NAMA', 'TANGGAL_AWAL', 'TANGGAL_AKHIR', 'JUMLAH', 'TOTAL_PREMI');

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
			if ( trim($sOrder) == "ORDER BY KAPAL_PEKERJAAN_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				//$sOrder = " ORDER BY PEGAWAI_ID DESC";
				$sOrder = " ORDER BY KAPAL_PEKERJAAN_ID ASC";
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

		if($reqMode == "proses")
		{
			$kapal_pekerjaan->callHitungPremiKhusus();		
		}


		$allRecord = $kapal_pekerjaan->getCountByParamsKapalKhususPremi(array(),$statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $kapal_pekerjaan->getCountByParamsKapalKhususPremi(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')) ");

		$kapal_pekerjaan->selectByParamsKapalKhususPremi(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder);

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($kapal_pekerjaan->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_AWAL" || $aColumns[$i] == "TANGGAL_AKHIR")
					$row[] = getFormattedDate($kapal_pekerjaan->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($kapal_pekerjaan->getField($aColumns[$i]), 5)."...";
				else if(trim($aColumns[$i]) == "JUMLAH" || trim($aColumns[$i]) == "TOTAL_PREMI")
					$row[] = currencyToPage($kapal_pekerjaan->getField(trim($aColumns[$i])));
				else
					$row[] = $kapal_pekerjaan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function gaji_tengah_organik_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();
		$gaji = new Gaji();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqMode = httpFilterGet("reqMode");

		$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(1, "TENGAH_BULAN"));

		$aColumns[] = "PEGAWAI_ID";
		$aColumns[] = "NAMA";
		$aColumns[] = "NAMA";
		for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
		{
			$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
		}
			
		$aColumnsAlias = array("A.PEGAWAI_ID", "A.NAMA", "A.NAMA", "A.NAMA");

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
			if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID ASC" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY A.PEGAWAI_ID DESC";
				 
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

		if($reqMode == "proses")
		{
			$gaji_awal_bulan->setField("PERIODE", $reqPeriode);
			$gaji_awal_bulan->setField("JENIS_PEGAWAI_ID", 1);		
			$gaji_awal_bulan->callHitungGajiAwalBulan();		
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";


		$allRecord = $gaji_awal_bulan->getCountByParams(array(),$statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array(), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement);

		$gaji_awal_bulan->selectByParamsGajiTengahBulan(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, $sOrder, $reqPeriode, 1);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			
			$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
			$total_gaji = 0;
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{	
				if(substr($aColumns[$i],0,4) == "GAJI")
				{
					$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
					if($column_gaji == "TOTAL_GAJI")
					{
						$row[] = currencyToPage($total_gaji);				
					}
					else
					{
						$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
						$total_gaji += $json_gaji->{$column_gaji}{0};
					}
				}
				elseif($aColumns[$i] == "TOTAL")			
					$row[] = currencyToPage($total_gaji - $total_potongan_lain);	
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
			}
			
			$output['aaData'][] = $row;
			
			unset($json_gaji);
		}

		echo json_encode( $output );
	}
	
	function gaji_tengah_perbantuan_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();
		$gaji = new Gaji();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqMode = httpFilterGet("reqMode");

		$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(2, "TENGAH_BULAN"));

		$aColumns[] = "PEGAWAI_ID";
		$aColumns[] = "NAMA";
		$aColumns[] = "NAMA";
		for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
		{
			$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
		}
			
		$aColumnsAlias = array("A.PEGAWAI_ID", "A.NAMA", "A.NAMA", "A.NAMA");

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
			if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID ASC" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY A.PEGAWAI_ID DESC";
				 
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

		if($reqMode == "proses")
		{
			$gaji_awal_bulan->setField("PERIODE", $reqPeriode);
			$gaji_awal_bulan->setField("JENIS_PEGAWAI_ID", 2);		
			$gaji_awal_bulan->callHitungGajiAwalBulan();		
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";


		$allRecord = $gaji_awal_bulan->getCountByParams(array(),$statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array(), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement);

		$gaji_awal_bulan->selectByParamsGajiTengahBulan(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, $sOrder, $reqPeriode, 2);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			
			$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
			$total_gaji = 0;
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{	
				if(substr($aColumns[$i],0,4) == "GAJI")
				{
					$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
					if($column_gaji == "TOTAL_GAJI")
					{
						$row[] = currencyToPage($total_gaji);				
					}
					else
					{
						$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
						$total_gaji += $json_gaji->{$column_gaji}{0};
					}
				}
				elseif($aColumns[$i] == "TOTAL")			
					$row[] = currencyToPage($total_gaji - $total_potongan_lain);	
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
			}
			
			$output['aaData'][] = $row;
			
			unset($json_gaji);
		}

		echo json_encode( $output );
	}
	
	function gaji_tengah_pkwt_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
		include_once("../WEB-INF/classes/base-gaji/Gaji.php");

		$gaji_awal_bulan = new GajiAwalBulan();
		$gaji = new Gaji();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqMode = httpFilterGet("reqMode");

		$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(3, "TENGAH_BULAN"));

		$aColumns[] = "PEGAWAI_ID";
		$aColumns[] = "NAMA";
		$aColumns[] = "NAMA";
		for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
		{
			$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
		}
			
		$aColumnsAlias = array("A.PEGAWAI_ID", "A.NAMA", "A.NAMA", "A.NAMA");

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
			if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID ASC" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY A.PEGAWAI_ID DESC";
				 
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

		if($reqMode == "proses")
		{
			$gaji_awal_bulan->setField("PERIODE", $reqPeriode);
			$gaji_awal_bulan->setField("JENIS_PEGAWAI_ID", 3);		
			$gaji_awal_bulan->callHitungGajiAwalBulan();		
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";


		$allRecord = $gaji_awal_bulan->getCountByParams(array(),$statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $gaji_awal_bulan->getCountByParams(array(), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement);

		$gaji_awal_bulan->selectByParamsGajiTengahBulan(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, $sOrder, $reqPeriode, 3);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($gaji_awal_bulan->nextRow())
		{
			$row = array();
			
			$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
			$total_gaji = 0;
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{	
				if(substr($aColumns[$i],0,4) == "GAJI")
				{
					$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
					if($column_gaji == "TOTAL_GAJI")
					{
						$row[] = currencyToPage($total_gaji);				
					}
					else
					{
						$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
						$total_gaji += $json_gaji->{$column_gaji}{0};
					}
				}
				elseif($aColumns[$i] == "TOTAL")			
					$row[] = currencyToPage($total_gaji - $total_potongan_lain);	
				else
					$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
			}
			
			$output['aaData'][] = $row;
			
			unset($json_gaji);
		}

		echo json_encode( $output );
	}
	
	function gaji_tunjangan_hari_raya_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/TunjanganHariRaya.php");

		$tunjangan_hari_raya = new TunjanganHariRaya();

		$reqPeriodeTHR = httpFilterGet("reqPeriodeTHR");
		$reqPeriode = httpFilterGet("reqPeriode");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqMode = httpFilterGet("reqMode");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA","MASUK_KERJA","HADIR","JUMLAH","JUMLAH_POTONGAN");
		$aColumnsAlias = array("A.PEGAWAI_ID", "NRP", "NAMA","MASUK_KERJA","HADIR","JUMLAH","JUMLAH_POTONGAN");

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

		if($reqMode == "proses")
		{
			$tunjangan_hari_raya->callTunjanganHariRaya($reqPeriodeTHR);
		}

		if($reqJenisPegawai == "")
		{}
		else
			$statement .= "AND B.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;


		$allRecord = $tunjangan_hari_raya->getCountByParams(array(),$statement, $reqPeriode);
		//echo $tunjangan_hari_raya->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $tunjangan_hari_raya->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

		$tunjangan_hari_raya->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $reqPeriode, $sOrder);

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($tunjangan_hari_raya->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($tunjangan_hari_raya->getField($aColumns[$i]));
				else if($aColumns[$i] == "JUMLAH" || $aColumns[$i] == "JUMLAH_POTONGAN")
					$row[] = currencyToPage($tunjangan_hari_raya->getField($aColumns[$i]));
				else if($aColumns[$i] == "MASUK_KERJA")
					$row[] = getNamePeriode($tunjangan_hari_raya->getField($aColumns[$i]));			
				else
					$row[] = $tunjangan_hari_raya->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function gaji_uang_makan_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/UangMakanBantuan.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulanLog.php");

		$log = new GajiAwalBulanLog();
		$uang_makan_bantuan = new UangMakanBantuan();

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqMode = httpFilterGet("reqMode");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA", "HARI_KERJA", "MASUK_KERJA","JUMLAH");
		$aColumnsAlias = array("A.PEGAWAI_ID", "NRP", "NAMA", "HARI_KERJA", "MASUK_KERJA","JUMLAH");

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

		if($reqMode == "proses")
		{
			$log->setField("PERIODE", $reqPeriode);
			$log->setField("PROSES_BY", $userLogin->nama);
			$log->setField("JENIS_PROSES", "UANG_MAKAN");
			$log->insert();	
			
			$uang_makan_bantuan->setField("JENIS_PEGAWAI_ID", $reqJenisPegawai);
			$uang_makan_bantuan->callUangMakanBantuan();
		}

		if($reqJenisPegawai == "")
		{}
		else
			$statement .= "AND C.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;


		$allRecord = $uang_makan_bantuan->getCountByParams(array(),$statement, $reqPeriode);
		//echo $uang_makan_bantuan->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $uang_makan_bantuan->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

		$uang_makan_bantuan->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " ,$reqPeriode , $sOrder);

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($uang_makan_bantuan->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($uang_makan_bantuan->getField($aColumns[$i]));
				else if($aColumns[$i] == "JUMLAH")
					$row[] = currencyToPage($uang_makan_bantuan->getField($aColumns[$i]));
				else
					$row[] = $uang_makan_bantuan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function gaji_uang_transport_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/UangTransportBantuan.php");
		include_once("../WEB-INF/classes/base-gaji/GajiAwalBulanLog.php");

		$log = new GajiAwalBulanLog();
		$uang_transport_bantuan = new UangTransportBantuan();

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqMode = httpFilterGet("reqMode");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("PEGAWAI_ID", "NRP", "NAMA", "HARI_KERJA", "MASUK_KERJA","JUMLAH");
		$aColumnsAlias = array("A.PEGAWAI_ID", "NRP", "NAMA", "HARI_KERJA", "MASUK_KERJA","JUMLAH");

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

		if($reqMode == "proses")
		{
			$log->setField("PERIODE", $reqPeriode);
			$log->setField("PROSES_BY", $userLogin->nama);
			$log->setField("JENIS_PROSES", "UANG_TRANSPORT");
			$log->insert();	
			
			$uang_transport_bantuan->setField("JENIS_PEGAWAI_ID", $reqJenisPegawai);
			$uang_transport_bantuan->callTransportBantuan();
		}

		if($reqJenisPegawai == "")
		{}
		else
			$statement .= "AND C.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;


		$allRecord = $uang_transport_bantuan->getCountByParams(array(),$statement, $reqPeriode);
		//echo $uang_transport_bantuan->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $uang_transport_bantuan->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

		$uang_transport_bantuan->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $reqPeriode, $sOrder);

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($uang_transport_bantuan->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($uang_transport_bantuan->getField($aColumns[$i]));
				else if($aColumns[$i] == "JUMLAH")
					$row[] = currencyToPage($uang_transport_bantuan->getField($aColumns[$i]));
				else
					$row[] = $uang_transport_bantuan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

}
?>
