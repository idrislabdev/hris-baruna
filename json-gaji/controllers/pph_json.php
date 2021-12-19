<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class pph_json extends CI_Controller {

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
	
	
	function pph_kondisi_jenis_pegawai_combo_json()
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

		function checkVariabel($text, $search)
		{
			if($text == "")
				return false;
			$arrText = explode(",",$text);
			for($i=0;$i<count($arrText);$i++)
			{
				if($arrText[$i] == $search)
					return true;	
			}
			return false;
		}

		$j=0;
		$kondisi->selectByParams(array("KONDISI_PARENT_ID" => 0), -1, -1, " AND PERUNTUKAN LIKE '%T%' ");
		while($kondisi->nextRow())
		{
			$arr_parent[$j]['id'] = $kondisi->getField("KONDISI_ID");
			$arr_parent[$j]['text'] = $kondisi->getField("NAMA");
			$k = 0;
			$child = new Kondisi();
			$child->selectByParams(array("KONDISI_PARENT_ID" => $kondisi->getField("KONDISI_ID")), -1, -1, " AND PERUNTUKAN LIKE '%T%' ");
			while($child->nextRow())
			{
				$arr_child[$k]['id'] = $child->getField("KONDISI_ID");
				$arr_child[$k]['text'] = $child->getField("NAMA");
				if(checkVariabel($reqId,$child->getField("KONDISI_ID")))
					$arr_child[$k]['checked'] = true;
				$l = 0;
				$sub = new Kondisi();
				$sub->selectByParams(array("KONDISI_PARENT_ID" => $child->getField("KONDISI_ID")), -1, -1, " AND PERUNTUKAN LIKE '%T%' ");
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
	
	function pph_parameter_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/PerhitunganPph.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$perhitungan_pph = new PerhitunganPph();

		$reqJenisPegawaiId = httpFilterPost("reqJenisPegawaiId");
		$reqKelas = httpFilterPost("reqKelas");
		$reqJenisPenghasilan = httpFilterPost("reqJenisPenghasilan");
		$reqJenisPerhitungan = httpFilterPost("reqJenisPerhitungan");
		$reqJumlah = httpFilterPost("reqJumlah");
		$reqMode = httpFilterPost("reqMode");
		$reqProsentaseNpwp = httpFilterPost("reqProsentaseNpwp");
		$reqJumlahNPWP = httpFilterPost("reqNilaiNpwp");
		$reqProsentaseTanpaNpwp = httpFilterPost("reqProsentaseTanpaNpwp");
		$reqJumlahTanpaNPWP = httpFilterPost("reqNilaiTanpaNpwp");

		$reqId = httpFilterPost("reqId");

		$arrProsentaseNPWP = explode("/", $reqProsentaseNpwp);
		$arrProsentaseTanpaNPWP = explode("/", $reqProsentaseTanpaNpwp);

		$perhitungan_pph->setField("JENIS_PENGHASILAN", $reqJenisPenghasilan);
		$perhitungan_pph->setField("KELAS", $reqKelas);
		$perhitungan_pph->setField("JENIS_PEGAWAI_ID", $reqJenisPegawaiId);
		$perhitungan_pph->setField("JENIS_PERHITUNGAN", $reqJenisPerhitungan);	
		if($reqJenisPerhitungan == "PROSENTASE"){
			//$reqJumlahNPWP = $arrProsentaseNPWP[0] / $arrProsentaseNPWP[1];
			//$reqJumlahTanpaNPWP = $arrProsentaseTanpaNPWP[0] / $arrProsentaseTanpaNPWP[1];
			$perhitungan_pph->setField("JUMLAH", $reqJumlah);
			$perhitungan_pph->setField("PROSENTASE_NPWP", $reqProsentaseNpwp);
			$perhitungan_pph->setField("PROSENTASE_TANPA_NPWP", $reqProsentaseTanpaNpwp);
			$perhitungan_pph->setField("JUMLAH_NPWP", $reqJumlahNPWP);
			$perhitungan_pph->setField("JUMLAH_TANPA_NPWP", $reqJumlahTanpaNPWP);
		}
		$perhitungan_pph->setField("PERHITUNGAN_PPH_ID", $reqId);

		if($reqId == "")
		{
			if($perhitungan_pph->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			if($perhitungan_pph->update())
				echo "Data berhasil disimpan.";	
		}
	}
	
	function pph_parameter_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");
		include_once("../WEB-INF/classes/base-gaji/PerhitunganPph.php");

		$perhitungan_pph = new PerhitunganPph();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

						   
		$aColumns = array("JENIS_PEGAWAI", "PERHITUNGAN_PPH_ID", "JENIS_PENGHASILAN", "KELAS", "JENIS_PERHITUNGAN", "PROSENTASE_NPWP", "PROSENTASE_TANPA_NPWP");
		$aColumnsAlias = array("B.NAMA", "PERHITUNGAN_PPH_ID", "A.JENIS_PENGHASILAN", "KELAS", "JENIS_PERHITUNGAN", "PROSENTASE_NPWP", "PROSENTASE_TANPA_NPWP");

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
			if ( trim($sOrder) == "ORDER BY B.NAMA asc, B.NAMA asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY A.JENIS_PEGAWAI_ID, JENIS_PENGHASILAN ASC";
				 
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


		$allRecord = $perhitungan_pph->getCountByParams(array());
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $perhitungan_pph->getCountByParams(array(), " AND (UPPER(JENIS_PENGHASILAN) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$perhitungan_pph->selectByParams(array(), $dsplyRange, $dsplyStart, " AND (UPPER(JENIS_PENGHASILAN) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($perhitungan_pph->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($perhitungan_pph->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($perhitungan_pph->getField($aColumns[$i]), 5)."...";
				else if($aColumns[$i] == "JUMLAH")
					$row[] = currencyToPage($perhitungan_pph->getField($aColumns[$i]));			
				else
					$row[] = $perhitungan_pph->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function pph_per_jabatan_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$jabatan = new Jabatan();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqKode= httpFilterPost("reqKode");
		$reqNoUrut= httpFilterPost("reqNoUrut");
		$reqKelas= httpFilterPost("reqKelas");
		$reqPPH= httpFilterPost("reqPPH");
		$reqNama= httpFilterPost("reqNama");
		$reqStatus= httpFilterPost("reqStatus");
		$reqKelompok= httpFilterPost("reqKelompok");

		if($reqMode == "insert")
		{
			$jabatan->setField('KODE', $reqKode);
			$jabatan->setField('NO_URUT', $reqNoUrut);
			$jabatan->setField('KELAS', $reqKelas);
			$jabatan->setField('PPH', $reqPPH);
			$jabatan->setField('NAMA', $reqNama);
			$jabatan->setField('KELOMPOK', $reqKelompok);
			$jabatan->setField("STATUS", setNULL($reqStatus));
			$jabatan->setField("LAST_CREATE_USER", $userLogin->nama);
			$jabatan->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
			if($jabatan->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$jabatan->setField('JABATAN_ID', $reqId); 
			$jabatan->setField('KODE', $reqKode);
			$jabatan->setField('NO_URUT', $reqNoUrut);
			$jabatan->setField('KELAS', $reqKelas);
			$jabatan->setField('PPH', $reqPPH);
			$jabatan->setField('NAMA', $reqNama);
			$jabatan->setField('KELOMPOK', $reqKelompok);
			$jabatan->setField("STATUS", setNULL($reqStatus));
			$jabatan->setField("LAST_UPDATE_USER", $userLogin->nama);
			$jabatan->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
			if($jabatan->update())
				echo "Data berhasil disimpan.";
			
		}
	}
	
	function pph_per_jabatan_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");

		$jabatan = new Jabatan();

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);


		$aColumns = array("JABATAN_ID", "NAMA", "KELAS", "PPH");
		$aColumnsAlias = array("JABATAN_ID", "NAMA", "KELAS", "PPH");

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
			if ( trim($sOrder) == "ORDER BY JABATAN_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY TO_NUMBER(KELAS) ASC, JABATAN_ID ASC";
				 
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


		$allRecord = $jabatan->getCountByParams(array());
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $jabatan->getCountByParams(array(), " AND (UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$jabatan->selectByParams(array(), $dsplyRange, $dsplyStart, " AND (UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($jabatan->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($jabatan->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($jabatan->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $jabatan->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}

}
?>
