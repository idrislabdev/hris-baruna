<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class pegawai_json extends CI_Controller {

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
	
	
	function json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

		$pegawai = new Pegawai();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqStatusPegawai= httpFilterGet("reqStatusPegawai");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "JENIS_PEGAWAI_ID", "NRP", "NIPP", "NAMA", "JABATAN_NAMA", "DEPARTEMEN");
		$aColumnsAlias = array("A.PEGAWAI_ID", "JENIS_PEGAWAI_ID", "NRP", "NIPP", "A.NAMA", "D.NAMA", "B.NAMA");

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
				$sOrder = " ORDER BY TO_NUMBER(D.KELAS) ASC, TO_NUMBER(D.NO_URUT) ASC";
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

		if($reqStatusPegawai == '')
			$statement .= 'AND A.STATUS_PEGAWAI_ID = 1';
		else
			$statement .= 'AND A.STATUS_PEGAWAI_ID = '.$reqStatusPegawai;

		if($reqJenisPegawai == "")
			$statement .= "";
		else
			$statement .= "AND G.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;

		$allRecord = $pegawai->getCountByParams(array(),$statement);
		//echo $pegawai->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $pegawai->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ");

		//echo $pegawai->query;
		$pegawai->selectByParamsReplaceNama(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder);
		//" AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') AND (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%') "

		//echo $pegawai->query;

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($pegawai->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($pegawai->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($pegawai->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $pegawai->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function pegawai_potongan_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/PotonganKondisiPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$potongan_kondisi_pegawai = new PotonganKondisiPegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqPotonganKondisiId = $_POST["reqPotonganKondisiId"];
		$reqJumlahTotal = $_POST["reqJumlahTotal"];
		$reqPotongan = $_POST["reqPotongan"];
							  
		if($reqMode == "insert")
		{

			$potongan_kondisi_pegawai->setField("PEGAWAI_ID", $reqId);
			$potongan_kondisi_pegawai->delete();
			unset($potongan_kondisi_pegawai);

			for($i=0;$i<count($reqPotonganKondisiId);$i++)
			{
				if($reqPotongan[$i] == "")
				{}
				else
				{
				$index = $reqPotongan[$i];
				$potongan_kondisi_pegawai = new PotonganKondisiPegawai();
				$potongan_kondisi_pegawai->setField("POTONGAN_KONDISI_ID", $reqPotonganKondisiId[$index]);
				$potongan_kondisi_pegawai->setField("PEGAWAI_ID", $reqId);
				$potongan_kondisi_pegawai->setField("JUMLAH", dotToNo($reqJumlahTotal[$index]));
				$potongan_kondisi_pegawai->insert();
				unset($potongan_kondisi_pegawai);
				}
			}
			echo "Data berhasil disimpan.";
		}
	}
	
	function pegawai_potongan_add_backup()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/PotonganKondisiPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$potongan_kondisi_pegawai = new PotonganKondisiPegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqPotonganKondisiId = $_POST["reqPotonganKondisiId"];
		$reqJumlahTotal = $_POST["reqJumlahTotal"];
		$reqPotongan = $_POST["reqPotongan"];
							  
		if($reqMode == "insert")
		{

			$potongan_kondisi_pegawai->setField("PEGAWAI_ID", $reqId);
			$potongan_kondisi_pegawai->delete();
			unset($potongan_kondisi_pegawai);

			for($i=0;$i<count($reqPotonganKondisiId);$i++)
			{
				if($reqPotongan[$i] == "")
				{}
				else
				{
				$index = $reqPotongan[$i];
				$potongan_kondisi_pegawai = new PotonganKondisiPegawai();
				$potongan_kondisi_pegawai->setField("POTONGAN_KONDISI_ID", $reqPotonganKondisiId[$index]);
				$potongan_kondisi_pegawai->setField("PEGAWAI_ID", $reqId);
				$potongan_kondisi_pegawai->setField("JUMLAH", dotToNo($reqJumlahTotal[$index]));
				$potongan_kondisi_pegawai->insert();
				unset($potongan_kondisi_pegawai);
				}
			}
			echo "Data berhasil disimpan.";
		}
	}
	
	function pegawai_potongan_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

		$pegawai = new Pegawai();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "KELAS", "JENIS_PEGAWAI_ID", "KELOMPOK", "NRP", "NIPP", "NAMA", "JABATAN", "DEPARTEMEN", "POTONGAN");
		$aColumnsAlias = array("A.PEGAWAI_ID", "A.KELAS", "JENIS_PEGAWAI_ID", "KELOMPOK", "NRP", "NIPP", "A.NAMA", "JABATAN", "DEPARTEMEN", "POTONGAN");

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
				$sOrder = " ORDER BY TO_NUMBER(A.KELAS) ASC, TO_NUMBER(A.NO_URUT) ASC";
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

		if($reqJenisPegawai == '')
		{}
		else
			$statement .= 'AND A.JENIS_PEGAWAI_ID = '.$reqJenisPegawai;

		$statement .= " AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) ";

		$allRecord = $pegawai->getCountByParamsPegawaiPotongan(array(),$statement);
		//echo $pegawai->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $pegawai->getCountByParamsPegawaiPotongan(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ");

		//echo $pegawai->query;
		$pegawai->selectByParamsPotonganPegawai(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder);
		//" AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') AND (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%') "

		//echo $pegawai->query;

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($pegawai->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($pegawai->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($pegawai->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $pegawai->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function pegawai_potongan_lain_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

		$pegawai = new Pegawai();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "KELAS", "JENIS_PEGAWAI_ID", "KELOMPOK", "NRP", "NIPP", "NAMA", "JABATAN_NAMA", "DEPARTEMEN");
		$aColumnsAlias = array("A.PEGAWAI_ID", "D.KELAS", "JENIS_PEGAWAI_ID", "KELOMPOK", "NRP", "NIPP", "A.NAMA", "D.NAMA", "DEPARTEMEN");

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
				$sOrder = " ORDER BY TO_NUMBER(D.KELAS) ASC, TO_NUMBER(D.NO_URUT) ASC";
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

		if($reqJenisPegawai == '')
		{}
		else
			$statement .= 'AND G.JENIS_PEGAWAI_ID = '.$reqJenisPegawai;

		$statement .= " AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) ";

		$allRecord = $pegawai->getCountByParams(array(),$statement);
		//echo $pegawai->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $pegawai->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ");

		//echo $pegawai->query;
		$pegawai->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder);
		//" AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') AND (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%') "

		//echo $pegawai->query;

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($pegawai->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($pegawai->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($pegawai->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $pegawai->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function pegawai_potongan_lain_json1()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

		$pegawai = new Pegawai();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$reqDepartemen = httpFilterGet("reqDepartemen");
		$reqJenisPegawai = httpFilterGet("reqJenisPegawai");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("PEGAWAI_ID", "KELAS", "JENIS_PEGAWAI_ID", "KELOMPOK", "NRP", "NIPP", "NAMA", "JABATAN_NAMA", "DEPARTEMEN");
		$aColumnsAlias = array("A.PEGAWAI_ID", "D.KELAS", "JENIS_PEGAWAI_ID", "KELOMPOK", "NRP", "NIPP", "A.NAMA", "D.NAMA", "B.NAMA");

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
				$sOrder = " ORDER BY TO_NUMBER(D.KELAS) ASC, TO_NUMBER(D.NO_URUT) ASC";
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

		if($reqJenisPegawai == '')
		{}
		else
			$statement .= 'AND G.JENIS_PEGAWAI_ID = '.$reqJenisPegawai;

		$statement .= " AND (A.STATUS_PEGAWAI_ID = 1 OR A.STATUS_PEGAWAI_ID = 5) ";

		$allRecord = $pegawai->getCountByParams(array(),$statement);
		//echo $pegawai->query;
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $pegawai->getCountByParams(array(), $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ");

		//echo $pegawai->query;
		$pegawai->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder);
		//" AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') AND (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%') "

		//echo $pegawai->query;

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($pegawai->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL_LAHIR")
					$row[] = getFormattedDate($pegawai->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($pegawai->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $pegawai->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function pegawai_potongan_lain_set_lunas()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-gaji/LainKondisiPegawai.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");

		/* create objects */

		$lain_kondisi_pegawai = new LainKondisiPegawai();

		$reqId = httpFilterPost("reqId");
		$reqPeriode = httpFilterPost("reqPeriode");

		/* LOGIN CHECK 
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}
		*/

		$lain_kondisi_pegawai->setField("LAIN_KONDISI_PEGAWAI_ID", $reqId);
		$lain_kondisi_pegawai->setField("BULAN_AKHIR_BAYAR", $reqPeriode);
		$lain_kondisi_pegawai->updateSetLunasPeriode();
			
		echo "Tanggungan telah dilunasi.";
	}
	
	function pegawai_potongan_opsi_add()
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/PotonganOpsiTidakPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$potongan_opsi_tidak_pegawai = new PotonganOpsiTidakPegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");

		$reqJenisPotonganKondisiId = $_POST["reqJenisPotonganKondisiId"];
		$reqJenisPotongan = $_POST["reqJenisPotongan"];
							  
		if($reqMode == "insert")
		{

			$potongan_opsi_tidak_pegawai->setField("PEGAWAI_ID", $reqId);
			$potongan_opsi_tidak_pegawai->delete();
			unset($potongan_opsi_tidak_pegawai);

			for($i=0;$i<count($reqJenisPotonganKondisiId);$i++)
			{
				if($reqJenisPotongan[$i] == "")
				{
					$potongan_opsi_tidak_pegawai = new PotonganOpsiTidakPegawai();
					$potongan_opsi_tidak_pegawai->setField("POTONGAN_KONDISI_JENIS_PEGAWAI", $reqJenisPotonganKondisiId[$i]);
					$potongan_opsi_tidak_pegawai->setField("PEGAWAI_ID", $reqId);
					$potongan_opsi_tidak_pegawai->insert();
					unset($potongan_opsi_tidak_pegawai);
				}
			}
			echo "Data berhasil disimpan.";
		}

}
?>
