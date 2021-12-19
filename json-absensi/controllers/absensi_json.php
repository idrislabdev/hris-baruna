<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class absensi_json extends CI_Controller {

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
	
	
	function absensi_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-absensi/Absensi.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$absensi = new Absensi();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqPegawaiId= httpFilterPost("reqPegawaiId");
		$reqNRP= httpFilterPost("reqNRP");
		$reqNama= httpFilterPost("reqNama");
		$reqDepartemenId= httpFilterPost("reqDepartemenId");
		$reqDepartemen= httpFilterPost("reqDepartemen");
		$reqStatus= httpFilterPost("reqStatus");
		$reqTanggal= httpFilterPost("reqTanggal");
		$reqJam= httpFilterPost("reqJam");

		if($reqMode == "insert")
		{
			$reqJamTanggal = $reqTanggal.":".$reqJam;
			
			$absensi->setField('PEGAWAI_ID', $reqPegawaiId);
			$absensi->setField('DEPARTEMEN_ID', $reqDepartemenId);
			$absensi->setField('JAM', datetimeToDB($reqJamTanggal));
			$absensi->setField('STATUS', $reqStatus);
			$absensi->setField('VALIDASI', 0);
			$absensi->setField("LAST_CREATE_USER", $userLogin->nama);
			$absensi->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			if($absensi->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$reqJamTanggal = $reqTanggal.":".$reqJam;
			
			$absensi->setField('ABSENSI_ID', $reqId); 
			$absensi->setField('PEGAWAI_ID', $reqPegawaiId);
			$absensi->setField('DEPARTEMEN_ID', $reqDepartemenId);
			$absensi->setField('JAM', datetimeToDB($reqJamTanggal));
			$absensi->setField('STATUS', $reqStatus);
			$absensi->setField('VALIDASI', 0);
			$absensi->setField("LAST_UPDATE_USER", $userLogin->nama);
			$absensi->setField("LAST_UPDATE_DATE", OCI_SYSDATE);			
			if($absensi->update())
				echo "Data berhasil disimpan.";
			
		}
	}
	
	function absensi_ijin_cuti_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiIjin.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$absensi_ijin = new AbsensiIjin();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqPegawaiId= httpFilterPost("reqPegawaiId");
		$reqNRP= httpFilterPost("reqNRP");
		$reqNama= httpFilterPost("reqNama");
		$reqDepartemenId= httpFilterPost("reqDepartemenId");
		$reqDepartemen= httpFilterPost("reqDepartemen");
		$reqIjinId= httpFilterPost("reqIjinId");
		$reqTanggalAwal= httpFilterPost("reqTanggalAwal");
		$reqTanggalAkhir= httpFilterPost("reqTanggalAkhir");

		/*
		$reqStatusKeteranganSakit= httpFilterPost("reqStatusKeteranganSakit");
		$reqStatusKeteranganCuti= httpFilterPost("reqStatusKeteranganCuti");

		$reqKeteranganSakit= httpFilterPost("reqKeteranganSakit");
		$reqKeteranganCuti= httpFilterPost("reqKeteranganCuti");
		*/
		$tempKeterangan = httpFilterPost("reqKeterangan");

		if($reqMode == "insert")
		{
			/*
			if($reqStatusKeteranganSakit == '3' || $reqKeteranganSakit)
				$tempKeterangan= $reqKeteranganSakit;
			elseif($reqStatusKeteranganCuti == '1')
				$tempKeterangan= $reqKeteranganCuti;
			else
				$tempKeterangan= '';
			*/
			$absensi_ijin->setField('KETERANGAN', $tempKeterangan);
			
			$absensi_ijin->setField('IJIN_ID', $reqIjinId);
			$absensi_ijin->setField('PEGAWAI_ID', $reqPegawaiId);
			$absensi_ijin->setField('DEPARTEMEN_ID', $reqDepartemenId);
			$absensi_ijin->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
			$absensi_ijin->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
			//$absensi_ijin->setField('VALIDASI', 0);
			$absensi_ijin->setField("LAST_CREATE_USER", $userLogin->nama);
			$absensi_ijin->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			
			if($absensi_ijin->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			/*
			if($reqStatusKeteranganSakit == '3' || $reqKeteranganSakit)
				$tempKeterangan= $reqKeteranganSakit;
			elseif($reqStatusKeteranganCuti == '1')
				$tempKeterangan= $reqKeteranganCuti;
			else
				$tempKeterangan= '';
			*/	
			
			$absensi_ijin->setField('KETERANGAN', $tempKeterangan);
			
			$absensi_ijin->setField('ABSENSI_IJIN_ID', $reqId);
			$absensi_ijin->setField('IJIN_ID', $reqIjinId);
			$absensi_ijin->setField('PEGAWAI_ID', $reqPegawaiId);
			$absensi_ijin->setField('DEPARTEMEN_ID', $reqDepartemenId);
			$absensi_ijin->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
			$absensi_ijin->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
			//$absensi_ijin->setField('VALIDASI', 0);
			$absensi_ijin->setField("LAST_UPDATE_USER", $userLogin->nama);
			$absensi_ijin->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
				
			if($absensi_ijin->update())
				echo "Data berhasil disimpan.";
			//echo $tempKeterangan.'---'.$reqStatusKeteranganSakit.'---'.$reqStatusKeteranganCuti;
		}
	}
	
	function absensi_ijin_cuti_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiIjin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$absensi_ijin = new AbsensiIjin();

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		/* SEARCHING */
		$reqSearchKey = httpFilterRequest("reqSearchKey");
		$reqSearchValue = httpFilterRequest("reqSearchValue");

		$reqTahun= httpFilterGet("reqTahun");
		$reqBulan= httpFilterGet("reqBulan");

		$search_statement = "";
		if($reqSearchKey == "")
		{}
		else
		{
			$arrSearchKey = explode(",", $reqSearchKey);
			$arrSearchValue = explode(",", $reqSearchValue);

			for($i=0;$i<count($arrSearchKey);$i++)
			{
				if($arrSearchKey[$i] == "")
				{}
				else
					$search_statement .= " AND UPPER(".$arrSearchKey[$i].") LIKE '%".strtoupper($arrSearchValue[$i])."%'";
			}
		}
		/* SEARCHING */

		$aColumns = array('ABSENSI_IJIN_ID', 'NRP', 'NAMA_PEGAWAI', 'DEPARTEMEN', 'JENIS_IJIN', 'TANGGAL_AWAL', 'TANGGAL_AKHIR', 'KETERANGAN');
		$aColumnsAlias = array('A.ABSENSI_IJIN_ID', 'C.NRP', 'C.NAMA', 'D.NAMA', 'B.NAMA', 'TANGGAL_AWAL', 'TANGGAL_AKHIR', 'KETERANGAN');

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
			if ( trim($sOrder) == "ORDER BY B.NIK asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY B.NIK DESC";
				 
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
			$statement = " AND TO_CHAR(a.TANGGAL_AWAL, 'MMYYYY') = '".$reqBulan.$reqTahun."' ";
		}

		$allRecord = $absensi_ijin->getCountByParamsMonitoring(array(), $statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $absensi_ijin->getCountByParamsMonitoring(array(), $dsplyRange, $dsplyStart,  " AND (UPPER(C.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') ". $statement , " ORDER BY TANGGAL_AWAL DESC ");

		$absensi_ijin->selectByParamsMonitoring(array(), $dsplyRange, $dsplyStart,  " AND (UPPER(C.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') ". $statement , " ORDER BY TANGGAL_AWAL DESC ");     		

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
			
			while($absensi_ijin->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if($aColumns[$i] == "TANGGAL")
						$row[] = getFormattedDate($absensi_ijin->getField(trim($aColumns[$i])));	
					elseif($aColumns[$i] == "STATUS")
						$row[] = getNameInputOutput($absensi_ijin->getField(trim($aColumns[$i])));
					elseif($aColumns[$i] == "VALIDASI")
						$row[] = getNameValidasi($absensi_ijin->getField(trim($aColumns[$i])));									
					else			
					$row[] = $absensi_ijin->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;

			}
			
			echo json_encode( $output );
	}
	
	function absensi_ijin_json_set()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiIjin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* create objects */

		$absensi_ijin = new AbsensiIjin();

		$reqId = httpFilterGet("reqId");
		$reqNilai = httpFilterGet("reqNilai");

		/* LOGIN CHECK 
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}
		*/

			$absensi_ijin->setField("FIELD", "VALIDASI");
			$absensi_ijin->setField("FIELD_VALUE", $reqNilai);
			$absensi_ijin->setField("FIELD_VALIDATOR", "VALIDATOR");
			$absensi_ijin->setField("FIELD_VALUE_VALIDATOR", $userLogin->nama);
			$absensi_ijin->setField("ABSENSI_IJIN_ID", $reqId);
			$absensi_ijin->updateByField();
			
		$met = array();
		$i=0;

		$met[0]['STATUS'] = 1;
		echo json_encode($met);
	}
	
	function json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/Absensi.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$absensi = new Absensi();

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		/* SEARCHING */
		$reqSearchKey = httpFilterRequest("reqSearchKey");
		$reqSearchValue = httpFilterRequest("reqSearchValue");

		$search_statement = "";
		if($reqSearchKey == "")
		{}
		else
		{
			$arrSearchKey = explode(",", $reqSearchKey);
			$arrSearchValue = explode(",", $reqSearchValue);

			for($i=0;$i<count($arrSearchKey);$i++)
			{
				if($arrSearchKey[$i] == "")
				{}
				else
					$search_statement .= " AND UPPER(".$arrSearchKey[$i].") LIKE '%".strtoupper($arrSearchValue[$i])."%'";
			}
		}
		/* SEARCHING */

		$aColumns = array('ABSENSI_ID', 'NRP', 'NAMA', 'DEPARTEMEN', 'STATUS', 'TANGGAL', 'JAM', 'VALIDASI', 'VALIDATOR');
		$aColumnsAlias = array('A.ABSENSI_ID', 'B.NRP', 'B.NAMA', 'C.NAMA', 'STATUS', 'TANGGAL', 'JAM', 'VALIDASI', 'VALIDATOR');

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
			if ( trim($sOrder) == "ORDER BY B.NIK asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY B.NIK DESC";
				 
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


		$allRecord = $absensi->getCountByParams(array()," AND (VALIDASI = 0 OR VALIDASI = 2 OR (VALIDASI = 1 AND VALIDATOR IS NOT NULL)) ");
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $absensi->getCountByParams(array()," AND (VALIDASI = 0 OR VALIDASI = 2 OR (VALIDASI = 1 AND VALIDATOR IS NOT NULL)) ");

		$absensi->selectByParamsMonitoring(array(), $dsplyRange, $dsplyStart,  " AND (VALIDASI = 0 OR VALIDASI = 2 OR (VALIDASI = 1 AND VALIDATOR IS NOT NULL)) ".$search_statement, $sOrder);     		

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
			
			while($absensi->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if($aColumns[$i] == "STATUS")
						$row[] = getNameInputOutput($absensi->getField(trim($aColumns[$i])));
					elseif($aColumns[$i] == "VALIDASI")
						$row[] = getNameValidasi($absensi->getField(trim($aColumns[$i])));									
					else			
					$row[] = $absensi->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;

			}
			
			echo json_encode( $output );
	}
	
	function absensi_json_set()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/Absensi.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* create objects */

		$absensi = new Absensi();

		$reqId = httpFilterGet("reqId");
		$reqNilai = httpFilterGet("reqNilai");

		/* LOGIN CHECK 
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}
		*/

			$absensi->setField("FIELD", "VALIDASI");
			$absensi->setField("FIELD_VALUE", $reqNilai);
			$absensi->setField("FIELD_VALIDATOR", "VALIDATOR");
			$absensi->setField("FIELD_VALUE_VALIDATOR", $userLogin->nama);
			$absensi->setField("ABSENSI_ID", $reqId);
			$absensi->updateByField();
			
		$met = array();
		$i=0;

		$met[0]['STATUS'] = 1;
		echo json_encode($met);
	}
	
	function absensi_koreksi_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiKoreksi.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$absensi_koreksi = new AbsensiKoreksi();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqPeriode = httpFilterPost("reqPeriode");
		$reqIjinId = $_POST["reqIjinId"];
		$reqKoreksiHari = httpFilterPost("reqKoreksiHari");

		$reqKategori = httpFilterPost("reqKategori");


		$absensi_koreksi_delete = new AbsensiKoreksi();
		$absensi_koreksi_delete->setField('PEGAWAI_ID', $reqId);
		$absensi_koreksi_delete->setField('PERIODE', $reqPeriode);
		$absensi_koreksi_delete->delete();


		$absensi_koreksi->setField('PEGAWAI_ID', $reqId);
		$absensi_koreksi->setField('PERIODE', $reqPeriode);
		$absensi_koreksi->setField('HARI_1', $reqIjinId[0]);
		$absensi_koreksi->setField('HARI_2', $reqIjinId[1]);
		$absensi_koreksi->setField('HARI_3', $reqIjinId[2]);
		$absensi_koreksi->setField('HARI_4', $reqIjinId[3]);
		$absensi_koreksi->setField('HARI_5', $reqIjinId[4]);
		$absensi_koreksi->setField('HARI_6', $reqIjinId[5]);
		$absensi_koreksi->setField('HARI_7', $reqIjinId[6]);
		$absensi_koreksi->setField('HARI_8', $reqIjinId[7]);
		$absensi_koreksi->setField('HARI_9', $reqIjinId[8]);
		$absensi_koreksi->setField('HARI_10', $reqIjinId[9]);
		$absensi_koreksi->setField('HARI_11', $reqIjinId[10]);
		$absensi_koreksi->setField('HARI_12', $reqIjinId[11]);
		$absensi_koreksi->setField('HARI_13', $reqIjinId[12]);
		$absensi_koreksi->setField('HARI_14', $reqIjinId[13]);
		$absensi_koreksi->setField('HARI_15', $reqIjinId[14]);
		$absensi_koreksi->setField('HARI_16', $reqIjinId[15]);
		$absensi_koreksi->setField('HARI_17', $reqIjinId[16]);
		$absensi_koreksi->setField('HARI_18', $reqIjinId[17]);
		$absensi_koreksi->setField('HARI_19', $reqIjinId[18]);
		$absensi_koreksi->setField('HARI_20', $reqIjinId[19]);
		$absensi_koreksi->setField('HARI_21', $reqIjinId[20]);
		$absensi_koreksi->setField('HARI_22', $reqIjinId[21]);
		$absensi_koreksi->setField('HARI_23', $reqIjinId[22]);
		$absensi_koreksi->setField('HARI_24', $reqIjinId[23]);
		$absensi_koreksi->setField('HARI_25', $reqIjinId[24]);
		$absensi_koreksi->setField('HARI_26', $reqIjinId[25]);
		$absensi_koreksi->setField('HARI_27', $reqIjinId[26]);
		$absensi_koreksi->setField('HARI_28', $reqIjinId[27]);
		$absensi_koreksi->setField('HARI_29', $reqIjinId[28]);
		$absensi_koreksi->setField('HARI_30', $reqIjinId[29]);
		$absensi_koreksi->setField('HARI_31', $reqIjinId[30]);
		$absensi_koreksi->setField('KOREKSI_MANUAL_HARI', $reqKoreksiHari);
		$absensi_koreksi->setField('KATEGORI', $reqKategori);

		if($absensi_koreksi->insert())
		{
			echo "Data berhasil disimpan.";	
		}
	}
	
	function absensi_koreksi_awak_kapal_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiKoreksi.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$absensi_koreksi = new AbsensiKoreksi();

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
		$reqJamKerja= httpFilterGet("reqJamKerja");
		$reqLokasiId = httpFilterGet("reqLokasiId");


		$aColumns = array("KAPAL", "PEGAWAI_ID", "NRP", "KELOMPOK", "NAMA", "HARI_1", "HARI_2", "HARI_3", "HARI_4", "HARI_5", "HARI_6", "HARI_7", "HARI_8", "HARI_9", "HARI_10", 
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


		if($reqMode == "proses")
		{
			$absensi_koreksi->setField("PERIODE", $periode);
			$absensi_koreksi->callProsesAbsensiKoreksiAwakKapal();		
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		//$statement .= 'AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) ';

		if($reqJenisPegawai == "")
		{}
		else
			$statement .= ' AND E.JENIS_PEGAWAI_ID = '.$reqJenisPegawai;		

		if($reqJamKerja == "")
		{}
		else
			$statement .= ' AND C.JAM_KERJA_JENIS_ID = '.$reqJamKerja;
			
		if($reqLokasiId == "")
		{}
		else
			$statement .= ' AND G.LOKASI_ID = '.$reqLokasiId;
				
		$allRecord = $absensi_koreksi->getCountByParams(array(), $statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $absensi_koreksi->getCountByParams(array(), $statement." AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(KAPAL) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$absensi_koreksi->selectByParamsAwakKapal(array(), $dsplyRange, $dsplyStart, $statement." AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(KAPAL) LIKE '%".strtoupper($_GET['sSearch'])."%')", $periode, "ORDER BY KAPAL, A.NAMA ASC");     		

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
			while($absensi_koreksi->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if($absensi_koreksi->getField(trim($aColumns[$i])) == "DL")
						$row[] = "D";			
					else
						$row[] = $absensi_koreksi->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;
				$duk++;
			}
			
			echo json_encode( $output );
	}
	
	function absensi_koreksi_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiKoreksi.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$absensi_koreksi = new AbsensiKoreksi();

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
		$reqJamKerja= httpFilterGet("reqJamKerja");


		$aColumns = array("PEGAWAI_ID", "NRP", "KELOMPOK", "NAMA", "HARI_1", "HARI_2", "HARI_3", "HARI_4", "HARI_5", "HARI_6", "HARI_7", "HARI_8", "HARI_9", "HARI_10", 
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


		if($reqMode == "proses")
		{
			$absensi_koreksi->setField("PERIODE", $periode);
			$absensi_koreksi->callProsesAbsensiKoreksi();		
		}

		if(substr($reqDepartemen, 0, 3) == "CAB")
			$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
		else
			$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

		//$statement .= 'AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) ';

		if($reqJenisPegawai == "")
		{}
		else
			$statement .= ' AND E.JENIS_PEGAWAI_ID = '.$reqJenisPegawai;		

		if($reqJamKerja == "")
		{
			$statement .= ' AND (C.JAM_KERJA_JENIS_ID IN (1,2,3,5) OR NVL(C.JAM_KERJA_JENIS_ID, 0) = 0)';	
		}
		elseif($reqJamKerja == "1")
		{
			$statement .= ' AND (NVL(C.JAM_KERJA_JENIS_ID, 0) = 0 OR C.JAM_KERJA_JENIS_ID = '.$reqJamKerja.')';
		}
		else
			$statement .= ' AND C.JAM_KERJA_JENIS_ID = '.$reqJamKerja;
				
		$allRecord = $absensi_koreksi->getCountByParams(array(), $statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $absensi_koreksi->getCountByParams(array(), $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'");

		$absensi_koreksi->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'", $periode, "ORDER BY A.NAMA ASC");     		

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
			while($absensi_koreksi->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if($absensi_koreksi->getField(trim($aColumns[$i])) == "DL")
						$row[] = "D";			
					else
						$row[] = $absensi_koreksi->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;
				$duk++;
			}
			
			echo json_encode( $output );
	}
	
	function absensi_koreksi_validasi_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiKoreksi.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");

		$absensi_koreksi = new AbsensiKoreksi();

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqJamKerja = httpFilterGet("reqJamKerja");

		if($reqJamKerja == "")
			$statement = " AND NOT B.JAM_KERJA_JENIS_ID = 4";
		else
			$statement = " AND B.JAM_KERJA_JENIS_ID = 4";

		$data = $absensi_koreksi->getCountByParamsValidasi(array("PERIODE" => $reqPeriode), $statement);

		$absensi_koreksi->firstRow();

		$arrFinal = array("DATA" => $data);

		echo json_encode($arrFinal);
	}
	
	function absensi_lembur_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-absensi/Lembur.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$lembur = new Lembur();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqPegawaiId= httpFilterPost("reqPegawaiId");
		$reqNRP= httpFilterPost("reqNRP");
		$reqNama= httpFilterPost("reqNama");
		$reqDepartemenId= httpFilterPost("reqDepartemenId");
		$reqDepartemen= httpFilterPost("reqDepartemen");
		$reqLembur= httpFilterPost("reqLembur");
		$reqKeterangan= httpFilterPost("reqKeterangan");
		$reqTanggalAwal= httpFilterPost("reqTanggalAwal");
		$reqJamAwal= httpFilterPost("reqJamAwal");
		$reqTanggalAkhir= httpFilterPost("reqTanggalAkhir");
		$reqJamAkhir= httpFilterPost("reqJamAkhir");

		if($reqMode == "insert")
		{
			$reqJamTanggalAwal 	= $reqTanggalAwal.":".$reqJamAwal;
			$reqJamTanggalAkhir = $reqTanggalAkhir.":".$reqJamAkhir;

			$lembur->setField('PEGAWAI_ID', $reqPegawaiId);
			$lembur->setField('NAMA', $reqLembur);
			$lembur->setField('KETERANGAN', $reqKeterangan);
			$lembur->setField('JAM_AWAL', datetimeToDB($reqJamTanggalAwal));
			$lembur->setField('JAM_AKHIR', datetimeToDB($reqJamTanggalAkhir));
			$lembur->setField('DEPARTEMEN_ID', $reqDepartemenId);
			$lembur->setField("LAST_CREATE_USER", $userLogin->nama);
			$lembur->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			
			if($lembur->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$reqJamTanggalAwal 	= $reqTanggalAwal.":".$reqJamAwal;
			$reqJamTanggalAkhir = $reqTanggalAkhir.":".$reqJamAkhir;
			
			$lembur->setField('LEMBUR_ID', $reqId); 
			$lembur->setField('PEGAWAI_ID', $reqPegawaiId);
			$lembur->setField('NAMA', $reqLembur);
			$lembur->setField('KETERANGAN', $reqKeterangan);
			$lembur->setField('JAM_AWAL', datetimeToDB($reqJamTanggalAwal));
			$lembur->setField('JAM_AKHIR', datetimeToDB($reqJamTanggalAkhir));
			$lembur->setField('DEPARTEMEN_ID', $reqDepartemenId);
			$lembur->setField("LAST_UPDATE_USER", $userLogin->nama);
			$lembur->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			
			if($lembur->update())
				echo "Data berhasil disimpan.";
		}
	}
	
	function absensi_lembur_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/Lembur.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$lembur = new Lembur();

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		/* SEARCHING */
		$reqSearchKey = httpFilterRequest("reqSearchKey");
		$reqSearchValue = httpFilterRequest("reqSearchValue");

		$search_statement = "";
		if($reqSearchKey == "")
		{}
		else
		{
			$arrSearchKey = explode(",", $reqSearchKey);
			$arrSearchValue = explode(",", $reqSearchValue);

			for($i=0;$i<count($arrSearchKey);$i++)
			{
				if($arrSearchKey[$i] == "")
				{}
				else
					$search_statement .= " AND UPPER(".$arrSearchKey[$i].") LIKE '%".strtoupper($arrSearchValue[$i])."%'";
			}
		}
		/* SEARCHING */

		$aColumns = array('LEMBUR_ID', 'NRP', 'NAMA_PEGAWAI', 'DEPARTEMEN', 'LEMBUR', 'KETERANGAN', 'JAM_AWAL', 'JAM_AKHIR');
		$aColumnsAlias = array('A.LEMBUR_ID', 'B.NRP', 'B.NAMA', 'C.NAMA', 'A.NAMA', 'KETERANGAN', 'JAM_AWAL', 'JAM_AKHIR');

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
			if ( trim($sOrder) == "ORDER BY B.NIK asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY B.NIK DESC";
				 
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


		$allRecord = $lembur->getCountByParams(array());
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $lembur->getCountByParams(array());

		$lembur->selectByParamsMonitoring(array(), $dsplyRange, $dsplyStart,  $search_statement, $sOrder);     		

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
			
			while($lembur->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if($aColumns[$i] == "STATUS")
						$row[] = getNameInputOutput($lembur->getField(trim($aColumns[$i])));
					elseif($aColumns[$i] == "VALIDASI")
						$row[] = getNameValidasi($lembur->getField(trim($aColumns[$i])));									
					else			
					$row[] = $lembur->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;

			}
			
			echo json_encode( $output );
	}
	
	function absensi_manual_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiManual.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$absensi_manual = new AbsensiManual();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqPegawaiId= httpFilterPost("reqPegawaiId");
		$reqStatus= httpFilterPost("reqStatus");
		$reqBukti= httpFilterPost("reqBukti");
		$reqJam= " TO_DATE('".httpFilterPost("reqJam")."', 'DD-MM-YYYY HH24:MI:SS') ";
		$reqKeterangan= httpFilterPost("reqKeterangan");
		if($reqMode == "insert")
		{

			$absensi_manual->setField('ABSENSI_MANUAL_ID', 0);
			$absensi_manual->setField('PEGAWAI_ID', $reqPegawaiId);
			$absensi_manual->setField('STATUS', $reqStatus);
			$absensi_manual->setField('BUKTI', $reqBukti);
			$absensi_manual->setField('JAM', $reqJam);
			$absensi_manual->setField('KETERANGAN', $reqKeterangan);

			$absensi_manual->setField("LAST_CREATE_USER", $userLogin->nama);
			$absensi_manual->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
			
			if($absensi_manual->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{	
			$absensi_manual->setField('ABSENSI_MANUAL_ID', $reqId);
			$absensi_manual->setField('PEGAWAI_ID', $reqPegawaiId);
			$absensi_manual->setField('STATUS', $reqStatus);
			$absensi_manual->setField('BUKTI', $reqBukti);
			$absensi_manual->setField('JAM',$reqJam);
			$absensi_manual->setField('KETERANGAN', $reqKeterangan);
			$absensi_manual->setField("LAST_UPDATE_USER", $userLogin->nama);
			$absensi_manual->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			
			if($absensi_manual->update()) {
				echo $absensi_manual->query;
				echo "Data berhasil disimpan.";
			}
		}
	}
	
	function absensi_manual_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-absensi/AbsensiManual.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		$absensi_manual = new AbsensiManual();

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		/* SEARCHING */
		$reqSearchKey = httpFilterRequest("reqSearchKey");
		$reqSearchValue = httpFilterRequest("reqSearchValue");

		$reqTahun= httpFilterGet("reqTahun");
		$reqBulan= httpFilterGet("reqBulan");
		$reqId= httpFilterGet("reqId");
		$reqRefId = httpFilterGet("reqRefId");
		$reqMode = httpFilterGet("reqMode");

		$search_statement = "";
		if($reqSearchKey == "")
		{}
		else
		{
			$arrSearchKey = explode(",", $reqSearchKey);
			$arrSearchValue = explode(",", $reqSearchValue);

			for($i=0;$i<count($arrSearchKey);$i++)
			{
				if($arrSearchKey[$i] == "")
				{}
				else
					$search_statement .= " AND UPPER(".$arrSearchKey[$i].") LIKE '%".strtoupper($arrSearchValue[$i])."%'";
			}
		}
		/* SEARCHING */

		$aColumns = array('ABSENSI_MANUAL_ID','NRP', 'NAMA', 'DEPARTEMEN', 'JENIS', 'JAM', 'BUKTI', 'STATUS', 'REF_ID');
		$aColumnsAlias = array('ABSENSI_MANUAL_ID', 'NRP', 'B.NAMA', 'DEPARTEMEN', 'JENIS', 'JAM', 'BUKTI', 'STATUS', 'REF_ID');

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
			if ( trim($sOrder) == "ORDER BY B.NIK asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY B.NIK DESC";
				 
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

		if ( $reqId <> "" && $reqMode == "Approve") {
			$absensi_manual->setField("LAST_CREATE_USER", $userLogin->nama);
			$absensi_manual->ApproveAbsensiManual($reqId);
		}

		if ( $reqId <> "" && $reqMode == "Hapus") {
			$absensi_manual->AbsensiManualHapus($reqId);
		}

		if ( $reqTahun <> "" ) {
			$statement = " AND TO_CHAR(a.JAM, 'MMYYYY') = '".$reqBulan.$reqTahun."' ";
		}

		$allRecord = $absensi_manual->getCountByParamsMonitoring(array(), $statement);
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $absensi_manual->getCountByParamsMonitoring(array(), $dsplyRange, $dsplyStart,  " AND (UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') ". $statement , " ORDER BY JAM DESC ");

		$absensi_manual->selectByParamsMonitoring(array(), $dsplyRange, $dsplyStart,  " AND (UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') ". $statement , " ORDER BY JAM DESC ");     		

		//echo $absensi_manual->query;
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
			
			while($absensi_manual->nextRow())
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{		
					$row[] = $absensi_manual->getField(trim($aColumns[$i]));
				}
				
				$output['aaData'][] = $row;

			}
			
			echo json_encode( $output );
	}

}
?>
