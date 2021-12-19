<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class potongan_json extends CI_Controller {

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
	
	
	function potongan_kondisi_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/PotonganKondisi.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$potongan_kondisi = new PotonganKondisi();

		$reqId = httpFilterPost("reqId");
		$reqMode = httpFilterPost("reqMode");
		$reqNama = httpFilterPost("reqNama");

		if($reqMode == "insert")
		{
			$potongan_kondisi->setField("POTONGAN_KONDISI_ID", $reqId);
			$potongan_kondisi->setField("NAMA", $reqNama);
			if($potongan_kondisi->insert())
				echo "Data berhasil disimpan.";
		}
		else
		{
			$potongan_kondisi->setField("POTONGAN_KONDISI_ID", $reqId);
			$potongan_kondisi->setField("NAMA", $reqNama);
			if($potongan_kondisi->update())
				echo "Data berhasil disimpan.";
			
		}
	}
	
	function potongan_kondisi_jenis_pegawai_add()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/PotonganKondisiJenisPegawai.php");
		include_once("../WEB-INF/classes/utils/UserLogin.php");

		$potongan_kondisi_jenis_pegawai = new PotonganKondisiJenisPegawai();

		$reqId = httpFilterPost("reqId");
		$reqJenisPegawaiId = httpFilterPost("reqJenisPegawaiId");
		$reqMode = httpFilterPost("reqMode");
		$reqJenisPenghasilan = $_POST["reqJenisPenghasilan"];
		$reqJumlah = $_POST["reqJumlah"];
		$reqProsentase = $_POST["reqProsentase"];
		$reqKali = $_POST["reqKali"];
		$reqJumlahEntri = $_POST["reqJumlahEntri"];
		$reqPotonganKondisiId = $_POST["reqPotonganKondisiId"];
		$reqKelas = httpFilterPost("reqKelas");
		$reqKelompok = httpFilterPost("reqKelompok");
		$reqCurrentKelas = httpFilterPost("reqCurrentKelas");
		$reqJenisPotongan = $_POST["reqJenisPotongan"];
		$reqOpsi = $_POST["reqOpsi"];
					  
		if($reqMode == "insert")
		{

			$potongan_kondisi_jenis_pegawai->setField("JENIS_PEGAWAI_ID", $reqJenisPegawaiId);
			$potongan_kondisi_jenis_pegawai->setField("KELOMPOK", $reqKelompok);
			$potongan_kondisi_jenis_pegawai->setField("KELAS", $reqCurrentKelas);
			$potongan_kondisi_jenis_pegawai->delete();
			unset($potongan_kondisi_jenis_pegawai);
			
			for($i=0;$i<count($reqPotonganKondisiId);$i++)
			{
				if($reqJenisPenghasilan[$i] == "")
				{}
				else
				{
				$index = $reqJenisPenghasilan[$i];
				$potongan_kondisi_jenis_pegawai = new PotonganKondisiJenisPegawai();
				$potongan_kondisi_jenis_pegawai->setField("JENIS_PEGAWAI_ID", $reqJenisPegawaiId);
				$potongan_kondisi_jenis_pegawai->setField("POTONGAN_KONDISI_ID", $reqPotonganKondisiId[$index]);
				$potongan_kondisi_jenis_pegawai->setField("JUMLAH", $reqJumlah[$index]);
				$potongan_kondisi_jenis_pegawai->setField("PROSENTASE", $reqProsentase[$index]);
				$potongan_kondisi_jenis_pegawai->setField("SUMBER", $reqId);
				$potongan_kondisi_jenis_pegawai->setField("KALI", $reqKali[$index]);
				$potongan_kondisi_jenis_pegawai->setField("KELAS", $reqKelas);
				$potongan_kondisi_jenis_pegawai->setField("KELOMPOK", $reqKelompok);
				$potongan_kondisi_jenis_pegawai->setField("JENIS_POTONGAN", $reqJenisPotongan[$index]);
				$potongan_kondisi_jenis_pegawai->setField("JUMLAH_ENTRI", dotToNo($reqJumlahEntri[$index]));		
				$potongan_kondisi_jenis_pegawai->setField("OPSI", $reqOpsi[$index]);		
				$potongan_kondisi_jenis_pegawai->insert();
				//echo $potongan_kondisi_jenis_pegawai->query;
				unset($potongan_kondisi_jenis_pegawai);
				}
			}
			echo "Data berhasil disimpan.";
		}
	}
	
	function potongan_kondisi_jenis_pegawai_combo_edit_json()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/Kondisi.php");
		include_once("../WEB-INF/classes/base-gaji/PotonganKondisiJenisPegawai.php");

		/* create objects */

		$kondisi = new Kondisi();
		$potongan_kondisi_jenis_pegawai = new PotonganKondisiJenisPegawai();


		$reqId = httpFilterGet("reqId");
		$reqKelasId = httpFilterGet("reqKelasId");
		$reqKelompokId = httpFilterGet("reqKelompokId");
		$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
		/* LOGIN CHECK */
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}

		$potongan_kondisi_jenis_pegawai->selectByParams(array("JENIS_PEGAWAI_ID" => $reqJenisPegawaiId, "POTONGAN_KONDISI_ID" => $reqId, "KELAS" => $reqKelasId, "KELOMPOK" => $reqKelompokId));
		$potongan_kondisi_jenis_pegawai->firstRow();
		$text = $potongan_kondisi_jenis_pegawai->getField("JUMLAH");

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
		$kondisi->selectByParams(array("KONDISI_PARENT_ID" => 0));
		while($kondisi->nextRow())
		{
			$arr_parent[$j]['id'] = $kondisi->getField("KONDISI_ID");
			$arr_parent[$j]['text'] = $kondisi->getField("NAMA");
			if(checkVariabel($text, $kondisi->getField("KONDISI_ID")))
				$arr_parent[$j]['checked'] = true;
			$k = 0;
			$child = new Kondisi();
			$child->selectByParams(array("KONDISI_PARENT_ID" => $kondisi->getField("KONDISI_ID")));
			while($child->nextRow())
			{
				$arr_child[$k]['id'] = $child->getField("KONDISI_ID");
				$arr_child[$k]['text'] = $child->getField("NAMA");
				if(checkVariabel($text, $child->getField("KONDISI_ID")))
					$arr_child[$k]['checked'] = true;
				
				$l = 0;
				$sub = new Kondisi();
				$sub->selectByParams(array("KONDISI_PARENT_ID" => $child->getField("KONDISI_ID")));
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
	
	function potongan_kondisi_jenis_pegawai_combo_json()
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
		$kondisi->selectByParams(array("KONDISI_PARENT_ID" => 0), -1, -1, " AND PERUNTUKAN LIKE '%P%' ");
		while($kondisi->nextRow())
		{
			$arr_parent[$j]['id'] = $kondisi->getField("KONDISI_ID");
			$arr_parent[$j]['text'] = $kondisi->getField("NAMA");
			$k = 0;
			$child = new Kondisi();
			$child->selectByParams(array("KONDISI_PARENT_ID" => $kondisi->getField("KONDISI_ID")), -1, -1, " AND PERUNTUKAN LIKE '%P%' ");
			while($child->nextRow())
			{
				$arr_child[$k]['id'] = $child->getField("KONDISI_ID");
				$arr_child[$k]['text'] = $child->getField("NAMA");
				
				$l = 0;
				$sub = new Kondisi();
				$sub->selectByParams(array("KONDISI_PARENT_ID" => $child->getField("KONDISI_ID")), -1, -1, " AND PERUNTUKAN LIKE '%P%' ");
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
	
	function potongan_kondisi_jenis_pegawai_json()
	{
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/base-gaji/PotonganKondisiJenisPegawai.php");

		$potongan_kondisi_jenis_pegawai = new PotonganKondisiJenisPegawai();

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
			if ( trim($sOrder) == "ORDER BY POTONGAN_KONDISI_JENIS_PEGAWAI_ID asc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY POTONGAN_KONDISI_JENIS_PEGAWAI_ID DESC";
				 
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


		$allRecord = $potongan_kondisi_jenis_pegawai->getCountByParams(array());
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $potongan_kondisi_jenis_pegawai->getCountByParams(array(), " AND (UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')");

		$potongan_kondisi_jenis_pegawai->selectByParamsMonitoring(array(), $dsplyRange, $dsplyStart, " AND (UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		

		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);

		while($potongan_kondisi_jenis_pegawai->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($potongan_kondisi_jenis_pegawai->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($potongan_kondisi_jenis_pegawai->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $potongan_kondisi_jenis_pegawai->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
	
	function potongan_lain_set_lunas()
	{
		/* INCLUDE FILE */
		include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-gaji/LainKondisiPegawai.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");

		/* create objects */

		$lain_kondisi_pegawai = new LainKondisiPegawai();

		$reqId = httpFilterGet("reqId");
		/* LOGIN CHECK 
		if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}
		*/

			$lain_kondisi_pegawai->setField("LAIN_KONDISI_PEGAWAI_ID", $reqId);
			$lain_kondisi_pegawai->updateSetLunas();
			
		$met = array();
		$i=0;

		$met[0]['STATUS'] = 1;
		echo json_encode($met);
	}

}
?>
