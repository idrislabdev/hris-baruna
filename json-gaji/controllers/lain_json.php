<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class lain_json extends CI_Controller {

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
	
	
	function lain_kondisi_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/LainKondisi.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$lain_kondisi = new LainKondisi();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqNama = httpFilterPost("reqNama");

		if($reqMode == "insert")
		{
			$lain_kondisi->setField("LAIN_KONDISI_ID", $reqId);
			$lain_kondisi->setField("NAMA", $reqNama);
			if($lain_kondisi->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$lain_kondisi->setField("LAIN_KONDISI_ID", $reqId);
			$lain_kondisi->setField("NAMA", $reqNama);
			if($lain_kondisi->update())
				echo "Data berhasil disimpan.";
			
		}
	}
	
	function lain_kondisi_bulan_lookup_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-gaji/GajiPeriodeCapegPKWT.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");

		$reqId = httpFilterGet("reqId");
		$reqRow = httpFilterGet("reqRow");
		$reqKey = httpFilterGet("reqKey");

		$gaji_periode = new GajiPeriodeCapegPKWT();

		$periode = $gaji_periode->getPeriodeAkhir();
		$bulan = (int)substr($periode,0,2);
		$tahun = substr($periode,2,4);

		$arrBulanId[] = $periode;
		$arrBulanNama[] =  getNamePeriode($periode);
		for($i=1; $i<=5;$i++)
		{
			$bulan += 1;
			
			if($bulan == 13)
			{
				$bulan = 1;
				$tahun += 1;	
			}
			$arrBulanId[] = generateZero($bulan,2).$tahun;
			$arrBulanNama[] =  getNamePeriode(generateZero($bulan,2).$tahun);
		}

			$arrFinal = array("BULAN_ID" => $arrBulanId, 
							  "BULAN_NAMA" => $arrBulanNama);
			echo json_encode($arrFinal);
	}
	
	function lain_kondisi_combo_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/LainKondisi.php");


		/* create objects */

		$lain_kondisi = new LainKondisi();

		$reqId = httpFilterGet("reqId");

		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$j=0;
		$lain_kondisi->selectByParams(array("LAIN_KONDISI_PARENT_ID" => 0));
		while($lain_kondisi->nextRow())
		{
			$arr_parent[$j]['id'] = $lain_kondisi->getField("LAIN_KONDISI_ID");
			$arr_parent[$j]['text'] = $lain_kondisi->getField("NAMA");
			$k = 0;
			$child = new LainKondisi();
			$child->selectByParams(array("LAIN_KONDISI_PARENT_ID" => $lain_kondisi->getField("LAIN_KONDISI_ID")));
			while($child->nextRow())
			{
				$arr_child[$k]['id'] = $child->getField("LAIN_KONDISI_ID");
				$arr_child[$k]['text'] = $child->getField("NAMA");
				
				$l = 0;
				$sub = new LainKondisi();
				$sub->selectByParams(array("LAIN_KONDISI_PARENT_ID" => $child->getField("LAIN_KONDISI_ID")));
				while($sub->nextRow())
				{
					$arr_sub[$l]['id'] = $sub->getField("LAIN_KONDISI_ID");
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
	
	function lain_kondisi_jenis_pegawai_add()
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
		$reqBatasCicilan = $_POST["reqBatasCicilan"];
		$reqLainKondisiId = $_POST["reqLainKondisiId"];
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
			
			for($i=0;$i<count($reqLainKondisiId);$i++)
			{
				if($reqJenisPenghasilan[$i] == "")
				{}
				else
				{
				$index = $reqJenisPenghasilan[$i];
				$gaji_kondisi_jenis_pegawai = new GajiKondisiJenisPegawai();
				$gaji_kondisi_jenis_pegawai->setField("JENIS_PEGAWAI_ID", $reqJenisPegawaiId);
				$gaji_kondisi_jenis_pegawai->setField("GAJI_KONDISI_ID", $reqLainKondisiId[$index]);
				$gaji_kondisi_jenis_pegawai->setField("JUMLAH", $reqJumlah[$index]);
				$gaji_kondisi_jenis_pegawai->setField("PROSENTASE", $reqProsentase[$index]);
				$gaji_kondisi_jenis_pegawai->setField("SUMBER", $reqId);
				$gaji_kondisi_jenis_pegawai->setField("KALI", $reqBatasCicilan[$index]);
				$gaji_kondisi_jenis_pegawai->setField("KELAS", $reqKelas);
				$gaji_kondisi_jenis_pegawai->setField("KELOMPOK", $reqKelompok);
				$gaji_kondisi_jenis_pegawai->insert();
				unset($gaji_kondisi_jenis_pegawai);
				}
			}
			echo "Data berhasil disimpan.";
		}

	}
	
	function lain_kondisi_jenis_pegawai_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/LainKondisiJenisPegawai.php");

		$lain_kondisi_jenis_pegawai = new LainKondisiJenisPegawai();

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
			if ( trim($sOrder) == "ORDER BY LAIN_KONDISI_JENIS_PEGAWAI_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY LAIN_KONDISI_JENIS_PEGAWAI_ID DESC";
				 
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


		$allRecord = $lain_kondisi_jenis_pegawai->getCountByParams(array());
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $lain_kondisi_jenis_pegawai->getCountByParams(array(), " AND (UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$lain_kondisi_jenis_pegawai->selectByParamsMonitoring(array(), $dsplyRange, $dsplyStart, " AND (UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($lain_kondisi_jenis_pegawai->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($lain_kondisi_jenis_pegawai->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($lain_kondisi_jenis_pegawai->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $lain_kondisi_jenis_pegawai->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function lain_kondisi_lookup_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-gaji/LainKondisi.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");

		$lain_kondisi = new LainKondisi();

		$reqId = httpFilterGet("reqId");
		$reqRow = httpFilterGet("reqRow");
		$reqKey = httpFilterGet("reqKey");

		//$lain_kondisi->selectByParams(array(), -1, -1, " AND B.LAIN_KONDISI_PEGAWAI_ID IS NULL", $reqId);
		$lain_kondisi->selectByParamsSimple(array(), -1, -1, " ");

		$i = 0;
		while($lain_kondisi->nextRow())
		{
			$arrCompanyID[$i] =  $lain_kondisi->getField("LAIN_KONDISI_ID");
			$arrCompanyName[$i] =  $lain_kondisi->getField("NAMA");
			$i += 1;
		}
			$arrFinal = array("LAIN_KONDISI_ID" => $arrCompanyID, 
							  "LAIN_KONDISI_NAMA" => $arrCompanyName);
			echo json_encode($arrFinal);
	}
	
	function lain_kondisi_pegawai_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/LainKondisiPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$lain_kondisi_pegawai = new LainKondisiPegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqPotonganLain = $_POST["reqPotonganLain"];
		$reqJumlahTotal = $_POST["reqJumlahTotal"];
		$reqAngsuran = $_POST["reqAngsuran"];
		$reqJumlahAwalAngsuran = $_POST["reqJumlahAwalAngsuran"];
		$reqJumlahAngsuran = $_POST["reqJumlahAngsuran"];
		$reqAngsuranTerbayar = $_POST["reqAngsuranTerbayar"];
		$reqKeterangan = $_POST["reqKeterangan"];
		$reqBulan = $_POST["reqBulan"];

		$reqLainKondisiId = $_POST["reqLainKondisiId"];
							  
		if($reqMode == "insert")
		{
			for($i=0;$i<count($reqLainKondisiId);$i++)
			{
				$index = $i;
				if($reqPotonganLain[$i] == "")
				{
				$lain_kondisi_pegawai = new LainKondisiPegawai();
				$lain_kondisi_pegawai->setField("LAIN_KONDISI_ID", $reqLainKondisiId[$index]);
				$lain_kondisi_pegawai->setField("PEGAWAI_ID", $reqId);
				$lain_kondisi_pegawai->setField("JUMLAH_TOTAL", dotToNo($reqJumlahTotal[$index]));
				$lain_kondisi_pegawai->setField("ANGSURAN", $reqAngsuran[$index]);
				$lain_kondisi_pegawai->setField("BULAN_MULAI", $reqBulan[$index]);
				$lain_kondisi_pegawai->setField("JUMLAH_AWAL_ANGSURAN", dotToNo($reqJumlahAwalAngsuran[$index]));
				$lain_kondisi_pegawai->setField("JUMLAH_ANGSURAN", dotToNo($reqJumlahAngsuran[$index]));
				$lain_kondisi_pegawai->setField("ANGSURAN_TERBAYAR", $reqAngsuranTerbayar[$index]);
				$lain_kondisi_pegawai->setField("KETERANGAN", $reqKeterangan[$index]);
				$lain_kondisi_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
				$lain_kondisi_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
				
				$lain_kondisi_pegawai->insert();
				$temp=$lain_kondisi_pegawai->query;
				unset($lain_kondisi_pegawai);			
				}
				else
				{
				$lain_kondisi_pegawai = new LainKondisiPegawai();
				$lain_kondisi_pegawai->setField("LAIN_KONDISI_PEGAWAI_ID", $reqPotonganLain[$index]);
				$lain_kondisi_pegawai->setField("JUMLAH_TOTAL", dotToNo($reqJumlahTotal[$index]));
				$lain_kondisi_pegawai->setField("ANGSURAN", $reqAngsuran[$index]);
				$lain_kondisi_pegawai->setField("BULAN_MULAI", $reqBulan[$index]);
				$lain_kondisi_pegawai->setField("ANGSURAN_TERBAYAR", $reqAngsuranTerbayar[$index]);
				$lain_kondisi_pegawai->setField("KETERANGAN", $reqKeterangan[$index]);
				$lain_kondisi_pegawai->setField("JUMLAH_ANGSURAN", dotToNo($reqJumlahAngsuran[$index]));
				$lain_kondisi_pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
				$lain_kondisi_pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
				
				$lain_kondisi_pegawai->update();
					
				}
			}
			echo "Data berhasil disimpan.";
		}
	}
	
	function lain_kondisi_pegawai_add_backup()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/LainKondisiPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$lain_kondisi_pegawai = new LainKondisiPegawai();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqPotonganLain = $_POST["reqPotonganLain"];
		$reqJumlahTotal = $_POST["reqJumlahTotal"];
		$reqAngsuran = $_POST["reqAngsuran"];
		$reqJumlahAwalAngsuran = $_POST["reqJumlahAwalAngsuran"];
		$reqJumlahAngsuran = $_POST["reqJumlahAngsuran"];
		$reqAngsuranTerbayar = $_POST["reqAngsuranTerbayar"];
		$reqBulan = $_POST["reqBulan"];
		$reqTahun = $_POST["reqTahun"];

		$reqLainKondisiId = $_POST["reqLainKondisiId"];
							  
		if($reqMode == "insert")
		{

			$lain_kondisi_pegawai->setField("PEGAWAI_ID", $reqId);
			$lain_kondisi_pegawai->delete();
			unset($lain_kondisi_pegawai);

			for($i=0;$i<count($reqLainKondisiId);$i++)
			{
				if($reqPotonganLain[$i] == "")
				{}
				else
				{
				$index = $reqPotonganLain[$i];
				$lain_kondisi_pegawai = new LainKondisiPegawai();
				$lain_kondisi_pegawai->setField("LAIN_KONDISI_ID", $reqLainKondisiId[$index]);
				$lain_kondisi_pegawai->setField("PEGAWAI_ID", $reqId);
				$lain_kondisi_pegawai->setField("JUMLAH_TOTAL", dotToNo($reqJumlahTotal[$index]));
				$lain_kondisi_pegawai->setField("ANGSURAN", $reqAngsuran[$index]);
				$lain_kondisi_pegawai->setField("BULAN_MULAI", $reqBulan[$index].$reqTahun[$index]);
				$lain_kondisi_pegawai->setField("JUMLAH_AWAL_ANGSURAN", dotToNo($reqJumlahAwalAngsuran[$index]));
				$lain_kondisi_pegawai->setField("JUMLAH_ANGSURAN", dotToNo($reqJumlahAngsuran[$index]));
				$lain_kondisi_pegawai->setField("ANGSURAN_TERBAYAR", $reqAngsuranTerbayar[$index]);
				$lain_kondisi_pegawai->insert();
				unset($lain_kondisi_pegawai);
				}
			}
			echo "Data berhasil disimpan.";
		}

	}
	
	function lain_kondisi_tahun_lookup_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");

		$reqId = httpFilterGet("reqId");
		$reqRow = httpFilterGet("reqRow");
		$reqKey = httpFilterGet("reqKey");

		$tahun_for = date("Y");
		$j=0;
		for($i=$tahun_for; $i<=$tahun_for + 1; $i++)
		{
			$arrCompanyID[$j]=$arrCompanyName[$j]=$i;
			$j++;
		}

			$arrFinal = array("TAHUN_ID" => $arrCompanyID, 
							  "TAHUN_NAMA" => $arrCompanyName);
			echo json_encode($arrFinal);
	}

}
?>
