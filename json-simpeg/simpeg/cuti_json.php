<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class cuti_json extends CI_Controller {

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
	
	
	function cuti_tahunan_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
		include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$cuti_tahunan = new CutiTahunan();
		$cuti_tahunan_detil = new CutiTahunanDetil();
		$pegawai_jabatan = new PegawaiJabatan();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqPegawaiId = httpFilterPost("reqPegawaiId");
		$reqJenisPegawaiId = httpFilterPost("reqJenisPegawaiId");
		$reqLamaCuti = httpFilterPost("reqLamaCuti");
		$reqTanggal = httpFilterPost("reqTanggal");
		$reqTanggalAwal = httpFilterPost("reqTanggalAwal");
		$reqTanggalAkhir = httpFilterPost("reqTanggalAkhir");
		$reqPeriode = httpFilterPost("reqPeriode");
						

		if($reqMode == "insert")
		{
			$cuti_tahunan->setField('PEGAWAI_ID', $reqPegawaiId);
			$cuti_tahunan->setField('JENIS_PEGAWAI_ID', $reqJenisPegawaiId);
			$cuti_tahunan->setField('PERIODE', $reqPeriode);
			$cuti_tahunan->setField('LAMA_CUTI', $reqLamaCuti);
			$cuti_tahunan->setField('TANGGAL', dateToDBCheck($reqTanggal));
			$cuti_tahunan->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
			$cuti_tahunan->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
			if ($cuti_tahunan->insert())
			{
		/*		$pegawai_jabatan->selectByParamsPegawaiJabatanOperasional(array("A.PEGAWAI_ID" => $reqPegawaiId));
				$pegawai_jabatan->firstRow();
				
				if($pegawai_jabatan->getField("KELOMPOK") == "D")
				{
					$cuti_tahunan_detil->setField("CUTI_TAHUNAN_ID", $cuti_tahunan->id);
					$cuti_tahunan_detil->insertDetil();
				}*/
			
				echo $cuti_tahunan->id."-Data berhasil disimpan.";
			}
		}
		else
		{
			$cuti_tahunan->setField('PEGAWAI_ID', $reqPegawaiId);
			$cuti_tahunan->setField('JENIS_PEGAWAI_ID', $reqJenisPegawaiId);
			$cuti_tahunan->setField('PERIODE', date('Y'));
			$cuti_tahunan->setField('LAMA_CUTI', $reqLamaCuti);
			$cuti_tahunan->setField('TANGGAL', dateToDBCheck($reqTanggal));
			$cuti_tahunan->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
			$cuti_tahunan->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
			$cuti_tahunan->setField('CUTI_TAHUNAN_ID', $reqId);
			
			if ($cuti_tahunan->update())
				echo $cuti_tahunan->id."-Data berhasil disimpan.";
			//echo $cuti_tahunan->query;

		}

	}

	function cuti_tahunan_add_detil()
	{

		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$cuti_tahunan_detil_check = new CutiTahunanDetil();
		$cuti_tahunan_detil_cb = new CutiTahunanDetil();
		$cuti_tahunan_detil = new CutiTahunanDetil();


		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqRowId = httpFilterPost("reqRowId");

		$reqLamaCuti = httpFilterPost("reqLamaCuti");
		$reqTanggal = httpFilterPost("reqTanggal");
		$reqTanggalAwal = httpFilterPost("reqTanggalAwal");
		$reqTanggalAkhir = httpFilterPost("reqTanggalAkhir");
		$reqLokasiCuti = httpFilterPost("reqLokasiCuti");
		$reqTunda = httpFilterPost("reqTunda");
		if($reqTunda == '') $reqTunda = 0;
		$reqNDTunda = httpFilterPost("reqNDTunda");
		$reqTanggalNDTunda = httpFilterPost("reqTanggalNDTunda");
		$reqKeteranganTunda = httpFilterPost("reqKeteranganTunda");

		$jumlah_cuti = $cuti_tahunan_detil_check->getCountByParams(array("CUTI_TAHUNAN_ID" => $reqId), " AND NOT STATUS_TUNDA = 1 ");

		if($jumlah_cuti == 0)
		{
			$reqLamaCuti += $cuti_tahunan_detil_cb->sumCutiBersama();
		}

		if($reqMode == "realisasi")
		{
			$cuti_tahunan_detil->setField("CUTI_TAHUNAN_DETIL_ID", $reqRowId);
			$cuti_tahunan_detil->updateStatusTundaRealisasi();
			$status = 'R';
		}

		else
			$status = '';


		$cuti_tahunan_detil->setField('CUTI_TAHUNAN_ID', $reqId);
		$cuti_tahunan_detil->setField('CUTI_TAHUNAN_DETIL_ID', $reqRowId);
		$cuti_tahunan_detil->setField('STATUS_TUNDA', $reqTunda);
		$cuti_tahunan_detil->setField('LAMA_CUTI', $reqLamaCuti);
		$cuti_tahunan_detil->setField('LOKASI_CUTI', $reqLokasiCuti);
		$cuti_tahunan_detil->setField('TANGGAL', dateToDBCheck($reqTanggal));
		$cuti_tahunan_detil->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
		$cuti_tahunan_detil->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
		$cuti_tahunan_detil->setField('STATUS_BAYAR_MUTASI', $status);
		$cuti_tahunan_detil->setField('NOTA_DINAS_TUNDA', $reqNDTunda);
		$cuti_tahunan_detil->setField('TANGGAL_NOTA_DINAS_TUNDA', dateToDBCheck($reqTanggalNDTunda));
		$cuti_tahunan_detil->setField('KETERANGAN_TUNDA', $reqKeteranganTunda);

		if($reqMode == ''){
			if($cuti_tahunan_detil->insert()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
		}
		else if($reqMode == 'update'){
			if($cuti_tahunan_detil->update()){
				echo $reqId."-Data berhasil disimpan.-".$reqRowId;
			}
		}
	}

	function cuti_tahunan_cetak_sp()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");


		$reqCutiTahunanDetilId = $_POST["reqCutiTahunanDetilId"];
		$reqNotaDinas =  $_POST["reqNotaDinas"];
		$reqNama1 = httpFilterPost("reqNama1");
		$reqJabatan1 = httpFilterPost("reqJabatan1");

		for($i=0;$i<count($reqCutiTahunanDetilId);$i++)
		{

			$cuti_tahunan_detil = new CutiTahunanDetil();
			
			$cuti_tahunan_detil->setField("CUTI_TAHUNAN_DETIL_ID", $reqCutiTahunanDetilId[$i]);
			$cuti_tahunan_detil->setField("NO_NOTA", $reqNotaDinas[$i]);
			$cuti_tahunan_detil->setField("TTD_NAMA", $reqNama1);
			$cuti_tahunan_detil->setField("TTD_JABATAN", $reqJabatan1);
			$cuti_tahunan_detil->updateNota();
			
			unset($cuti_tahunan_detil);
				
		}

		echo "Data berhasil diubah.";


	}

	function cuti_tahunan_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");

		$cuti_tahunan = new CutiTahunan();

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqStatusProses = httpFilterGet("reqStatusProses");
		$reqMode = httpFilterGet("reqMode");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("CUTI_TAHUNAN_ID",  "TANGGAL_CETAK", "NRP", "NAMA", "DEPARTEMEN", "LAMA_CUTI", "TANGGAL_CETAK", "UANG_CUTI", "PPH", "TIPE_LANGSUNG", "UANG_CUTI_ANGKA", "PPH_ANGKA");
		$aColumnsAlias = array("CUTI_TAHUNAN_ID", "A.PEGAWAI_ID", "NRP", "NAMA", "DEPARTEMEN", "LAMA_CUTI", "TANGGAL_CETAK", "UANG_CUTI", "PPH", "TIPE_LANGSUNG", "UANG_CUTI_ANGKA", "PPH_ANGKA");

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
			if ( trim($sOrder) == "ORDER BY CUTI_TAHUNAN_ID asc" )
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

		if($reqStatusProses == "SUDAH")
			$statement .= " AND F.TANGGAL_CETAK IS NOT NULL ";
		elseif($reqStatusProses == "BELUM")
			$statement .= " AND F.TANGGAL_CETAK IS NULL ";


		$allRecord = $cuti_tahunan->getCountByParams(array(),$statement, $reqPeriode);
		//echo $cuti_tahunan->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $cuti_tahunan->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

		$cuti_tahunan->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $reqPeriode, $sOrder);

		if($reqStatusProses == "BELUM_AJUKAN") {
			$statement = ($reqJenisPegawai == '') ? '' : " AND B.JENIS_PEGAWAI_ID = '" . $reqJenisPegawai. "' ";
			$statement .= " AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ";
			$allRecord = $cuti_tahunan->getCountBelumAjukan($reqPeriode, array(), $statement);
			$cuti_tahunan->selectPegawaiBelumMengajukanCuti($reqPeriode, $dsplyRange, $dsplyStart, array('B.JENIS_PEGAWAI_ID' => $reqJenisPegawai), $statement, $sOrder);
			$allRecordFilter = $allRecord;
			
		}
		if($reqStatusProses == "BERHAK_CUTI") {
			$statement = ($reqJenisPegawai == '') ? '' : " AND B.JENIS_PEGAWAI_ID = '" . $reqJenisPegawai. "' ";
			$statement .= " AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ";
			$allRecord = $cuti_tahunan->getCountBelumAjukan($reqPeriode, array(), $statement);
			$cuti_tahunan->selectPegawaiBerhakCuti($reqPeriode, $dsplyRange, $dsplyStart, array('B.JENIS_PEGAWAI_ID' => $reqJenisPegawai), $statement, $sOrder);
			$allRecordFilter = $allRecord;
			
		}
		//echo $cuti_tahunan->query;
		//echo $sOrder;
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
				if($aColumns[$i] == "TANGGAL_CETAK")
					$row[] = getFormattedDate($cuti_tahunan->getField($aColumns[$i]));
				else if($aColumns[$i] == "JUMLAH" || $aColumns[$i] == "JUMLAH_POTONGAN")
					$row[] = currencyToPage($cuti_tahunan->getField($aColumns[$i]));
				else if($aColumns[$i] == "UANG_CUTI" AND $reqStatusProses == "BERHAK_CUTI"){
					$row[] = number_format($cuti_tahunan->getField($aColumns[$i]), 0, '.', '.');
				}
				else if($aColumns[$i] == "PPH" AND $reqStatusProses == "BERHAK_CUTI") {
					$row[] = number_format($cuti_tahunan->getField($aColumns[$i]), 0, '.', '.');
				}
				else
					$row[] = $cuti_tahunan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

	function cuti_tahunan_json-lama()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");

		$cuti_tahunan = new CutiTahunan();

		$reqPeriode = httpFilterGet("reqPeriode");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
		$reqStatusProses = httpFilterGet("reqStatusProses");
		$reqMode = httpFilterGet("reqMode");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("CUTI_TAHUNAN_ID",  "TANGGAL_CETAK", "NRP", "NAMA", "DEPARTEMEN", "LAMA_CUTI", "TANGGAL_CETAK");
		$aColumnsAlias = array("CUTI_TAHUNAN_ID", "A.PEGAWAI_ID", "NRP", "NAMA", "DEPARTEMEN", "LAMA_CUTI", "TANGGAL_CETAK");

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
			if ( trim($sOrder) == "ORDER BY CUTI_TAHUNAN_ID asc" )
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

		if($reqStatusProses == "SUDAH")
			$statement .= " AND F.TANGGAL_CETAK IS NOT NULL ";
		elseif($reqStatusProses == "BELUM")
			$statement .= " AND F.TANGGAL_CETAK IS NULL ";


		$allRecord = $cuti_tahunan->getCountByParams(array(),$statement, $reqPeriode);
		//echo $cuti_tahunan->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $cuti_tahunan->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

		$cuti_tahunan->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $reqPeriode, $sOrder);

		if($reqStatusProses == "BELUM_AJUKAN") {
			$statement = ($reqJenisPegawai == '') ? '' : " AND B.JENIS_PEGAWAI_ID = '" . $reqJenisPegawai. "' ";
			$statement .= " AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NRP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ";
			$allRecord = $cuti_tahunan->getCountBelumAjukan($reqPeriode, array(), $statement);
			$cuti_tahunan->selectPegawaiBelumMengajukanCuti($reqPeriode, $dsplyRange, $dsplyStart, array('B.JENIS_PEGAWAI_ID' => $reqJenisPegawai), $statement, $sOrder);
			$allRecordFilter = $allRecord;
			
		}
		//echo $cuti_tahunan->query;
		//echo $sOrder;
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
				if($aColumns[$i] == "TANGGAL_CETAK")
					$row[] = getFormattedDate($cuti_tahunan->getField($aColumns[$i]));
				else if($aColumns[$i] == "JUMLAH" || $aColumns[$i] == "JUMLAH_POTONGAN")
					$row[] = currencyToPage($cuti_tahunan->getField($aColumns[$i]));
				else
					$row[] = $cuti_tahunan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}			
}
?>
