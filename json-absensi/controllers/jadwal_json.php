<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class jadwal_json extends CI_Controller {

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
	
	
	function jadwal_piket_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/DaftarJagaPiket.php");

		$reqMode= httpFilterPost("reqMode");
		$reqPeriodeEntri= $_POST["reqPeriodeEntri"];
		$reqPeriodeEntri = substr($reqPeriodeEntri, 3);
		$days=cal_days_in_month(CAL_GREGORIAN,substr($reqPeriodeEntri,0,2),substr($reqPeriodeEntri,2));  

		$reqTotalEntri= $_POST["reqTotalEntri"];

		$user_login = new UserLogin();
		$reqPktId= $_POST["reqPktId"];

		$reqPegawaiId= $_POST["pegawaiId"];
		$reqDepartemenId= $_POST["reqDepartemenId"];
		$reqShift = "";

		$set = new DaftarJagaPiket();
		$set->setField("DEPARTEMEN_ID", $reqDepartemenId);
		$set->setField("PERIODE", $reqPeriodeEntri);
		$set->delete(); 
		unset($set);

		$reqTotalEntri += 1;
		//$strku = '';
		for ($i=0; $i<$reqTotalEntri; $i++) {
			//$strku .= "i awal " . $i;
			for($j=1; $j<=$days;$j++){
				$str_tanggal = '0' . $j;
				$str_tanggal = substr($str_tanggal, -2);
				$shift1 = $_POST["shift1_tgl" . $j . "_row" . $i];
				$shift2 = $_POST["shift2_tgl" . $j . "_row" . $i];
				$shift3 = $_POST["shift3_tgl" . $j . "_row" . $i];
				$reqShift = "";

				if ( $shift1 == "" && $shift2 == "" && $shift3 == "" ) continue;

				if ($shift1 <> "") {
					$reqShift = "1";
					$tgl = $shift1;
				}
				if ($shift2 <> "") {
					$reqShift = $reqShift . ",2";
					$tgl = $shift2;
				}
				if ($shift3 <> "") {
					$reqShift = $reqShift . ",3";
					$tgl = $shift3;
				}
				
				$pkt = new DaftarJagaPiket();
				//$pkt->setField("PIKET_ID", $reqPktId[$i]);
				$pkt->setField("DEPARTEMEN_ID", $reqDepartemenId);
				$pkt->setField("PEGAWAI_ID", $reqPegawaiId[$i]);
				$pkt->setField('TANGGAL', $str_tanggal. '-' .$reqPeriodeEntri);
				$pkt->setField('SHIFT', $reqShift);
				$pkt->setField('LAST_CREATE_USER', $user_login->nama);
				$pkt->setField('LAST_CREATE_DATE', OCI_SYSDATE);
				$pkt->insert();
				//$strku .= $pkt->insert(); 
				unset($pkt);
			}
		}
		//echo $strku;
		echo "Data berhasil disimpan.";	
	}
	
	function jadwal_piket_delete_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/DaftarJagaPiket.php");

		$reqDepartemenId= $_GET["reqDepartemenId"];
		$reqPeriode= $_GET["reqPeriode"];
		$reqPeriode = substr($reqPeriode, 0, 2) . '-' . substr($reqPeriode, 2, 4);
		$set = new DaftarJagaPiket();
		$set->setField("DEPARTEMEN_ID", $reqDepartemenId);
		$set->setField("PERIODE", $reqPeriode);
		$set->delete(); 
		unset($set);
		$output = array('sukses'=>true);
		echo json_encode($output);	
	}
	
	function jadwal_piket_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-absensi/DaftarJagaPiket.php");

		$jaga = new DaftarJagaPiket();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$reqTahun= httpFilterGet("reqTahun");
		$reqBulan= httpFilterGet("reqBulan");


		$aColumns = array("DEPARTEMEN_ID", "NAMA", "PERIODE");
		$aColumnsAlias = array("DEPARTEMEN_ID", "NAMA", "PERIODE");

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
			if ( trim($sOrder) == "ORDER BY PIKET_ID ASC" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY PIKET_ID DESC";
				 
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

		if ( $reqTahun <> "" ) {
			$statement = " AND TO_CHAR(A.TANGGAL, 'MMYYYY') = '".$reqBulan.$reqTahun."' ";
		}

		$allRecord = $jaga->getCountByParamsHeader(array("TO_CHAR(A.TANGGAL, 'MMYYYY')" => $reqBulan.$reqTahun ));
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $jaga->getCountByParamsHeader(array(), " AND (UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') " . $statement);

		$jaga->selectByParamsHeader(array(), $dsplyRange, $dsplyStart, " AND (UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') " . $statement, $sOrder);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($jaga->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($jaga->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($jaga->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $jaga->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

}
?>
