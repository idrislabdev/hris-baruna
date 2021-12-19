<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class kalender_json extends CI_Controller {

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
	
	
	function kalender_kerja_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/KalenderKerja.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$kalender_kerja = new KalenderKerja();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqDepartemen = httpFilterPost("reqDepartemen");
		$reqTanggalAwal = httpFilterPost("reqTanggalAwal");
		$reqTanggalAkhir = httpFilterPost("reqTanggalAkhir");
		$reqWarna = httpFilterPost("reqWarna");
		$reqNama = httpFilterPost("reqNama");
		$reqKeterangan = httpFilterPost("reqKeterangan");
		$reqSubmit = httpFilterPost("reqSubmit");

		if($reqDepartemen == 0)
			$reqDepartemen = "CAB1";
		else
			$reqDepartemen = $reqDepartemen;

		if($reqMode == "insert")
		{
			$kalender_kerja->setField("DEPARTEMEN_ID", $reqDepartemen);
			$kalender_kerja->setField("NAMA", $reqNama);
			$kalender_kerja->setField("KETERANGAN", $reqKeterangan);
			$kalender_kerja->setField("TANGGAL_AWAL", dateToDBCheck($reqTanggalAwal));
			$kalender_kerja->setField("TANGGAL_AKHIR", dateToDBCheck($reqTanggalAkhir));
			$kalender_kerja->setField("WARNA", $reqWarna);
			$kalender_kerja->setField("USER_LOGIN_ID", $userLogin->UID);
			$kalender_kerja->setField("STATUS", 1);
			$kalender_kerja->setField("LAST_CREATE_USER", $userLogin->nama);
			$kalender_kerja->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
				
			if($kalender_kerja->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$kalender_kerja->setField("KALENDER_KERJA_ID", $reqId);
			$kalender_kerja->setField("DEPARTEMEN_ID", $reqDepartemen);
			$kalender_kerja->setField("NAMA", $reqNama);
			$kalender_kerja->setField("KETERANGAN", $reqKeterangan);
			$kalender_kerja->setField("TANGGAL_AWAL", dateToDBCheck($reqTanggalAwal));
			$kalender_kerja->setField("TANGGAL_AKHIR", dateToDBCheck($reqTanggalAkhir));
			$kalender_kerja->setField("WARNA", $reqWarna);
			$kalender_kerja->setField("USER_LOGIN_ID", $userLogin->UID);
			$kalender_kerja->setField("STATUS", 1);
			$kalender_kerja->setField("LAST_UPDATE_USER", $userLogin->nama);
			$kalender_kerja->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			
			if($kalender_kerja->update())
				echo "Data berhasil disimpan.";
			
		}
	}
	
	function kalender_kerja_admin_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/KalenderKerja.php");

		$kalender_kerja = new KalenderKerja();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("KALENDER_KERJA_ID", "DEPARTEMEN", "NAMA", "TANGGAL_AWAL", "TANGGAL_AKHIR", "STATUS");
		$aColumnsAlias = array("KALENDER_KERJA_ID", "B.NAMA", "A.NAMA", "TANGGAL_AWAL", "TANGGAL_AKHIR", "STATUS");

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
			if ( trim($sOrder) == "ORDER BY AGENDA_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY AGENDA_ID DESC";
				 
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

		if($userLogin->userPublish == 1)
			$statement = " AND (A.DEPARTEMEN_ID LIKE '".substr($userLogin->idDepartemen, 0, 2)."%' OR A.DEPARTEMEN_ID = 'CAB".$userLogin->idCabang."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".substr($userLogin->idDepartemen, 0, 2)."%' ";

		$allRecord = $kalender_kerja->getCountByParams(array(), $statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $kalender_kerja->getCountByParams(array(), $statement." AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$kalender_kerja->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($kalender_kerja->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_AWAL" || $aColumns[$i] == "TANGGAL_AKHIR")
					$row[] = getFormattedDate($kalender_kerja->getField($aColumns[$i]));
				else
					$row[] = $kalender_kerja->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function kalender_kerja_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base/KalenderKerja.php");

		/* create objects */

		$kalender_kerja = new KalenderKerja();

		if($userLogin->UID == "")
			$kalender_kerja->selectByParams(array(), -1, -1, " AND SUBSTR(A.DEPARTEMEN_ID, 1, 3) = 'CAB' AND TO_CHAR(TANGGAL_AWAL, 'YYYY') BETWEEN TO_CHAR(SYSDATE, 'YYYY') - 1 AND TO_CHAR(SYSDATE, 'YYYY')");
		else
			$kalender_kerja->selectByParams(array(), -1, -1, " AND (A.DEPARTEMEN_ID = 'CAB".$userLogin->idCabang."' OR A.DEPARTEMEN_ID LIKE '".$userLogin->idDepartemen."%')  AND TO_CHAR(TANGGAL_AWAL, 'YYYY') BETWEEN TO_CHAR(SYSDATE, 'YYYY') - 1 AND TO_CHAR(SYSDATE, 'YYYY')");

		$arr_json = array();
		$i=0;
		while($kalender_kerja->nextRow())
		{
			$arr_json[$i]['id'] = $kalender_kerja->getField("KALENDER_KERJA_ID");
			$arr_json[$i]['title'] = truncate($kalender_kerja->getField("NAMA"), 3)."..";
			$arr_json[$i]['start'] = $kalender_kerja->getField("TANGGAL_AWAL");
			$arr_json[$i]['end'] = $kalender_kerja->getField("TANGGAL_AKHIR");
			$arr_json[$i]['color'] = $kalender_kerja->getField("WARNA");
			$arr_json[$i]['url'] = $kalender_kerja->getField("NAMA");
			$i++;
		}
		echo json_encode($arr_json);
	}
	
	function kalender_kerja_set_status()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base/KalenderKerja.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* create objects */

		$kalender_kerja = new KalenderKerja();

		$reqId = httpFilterGet("reqId");
		$reqNilai = httpFilterGet("reqNilai");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

			$kalender_kerja->setField("FIELD", "STATUS");
			$kalender_kerja->setField("FIELD_VALUE", $reqNilai);
			$kalender_kerja->setField("KALENDER_KERJA_ID", $reqId);
			$kalender_kerja->updateByField();
		$met = array();
		$i=0;

		$met[0]['STATUS'] = 1;
		echo json_encode($met);
	}

}
?>
