<?php
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
?>
