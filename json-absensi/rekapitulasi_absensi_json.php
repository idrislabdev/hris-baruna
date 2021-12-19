<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

$absensi_rekap = new AbsensiRekap();

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

/*
$aColumns = array("NRP", "NAMA", "IN_1", "OUT_1", "IN_2", "OUT_2", "IN_3", "OUT_3", "IN_4", "OUT_4", "IN_5", "OUT_5", "IN_6", "OUT_6", "IN_7", "OUT_7", "IN_8", "OUT_8", "IN_9", "OUT_9", "IN_10", "OUT_10", 
"IN_11", "OUT_11", "IN_12", "OUT_12", "IN_13", "OUT_13", "IN_14", "OUT_14", "IN_15", "OUT_15", "IN_16", "OUT_16", "IN_17", "OUT_17", "IN_18", "OUT_18", "IN_19", "OUT_19", "IN_20", 
"OUT_20", "IN_21", "OUT_21", "IN_22", "OUT_22", "IN_23", "OUT_23", "IN_24", "OUT_24", "IN_25", "OUT_25", "IN_26", "OUT_26", "IN_27", "OUT_27", "IN_28", "OUT_28", "IN_29", "OUT_29", "IN_30", 
"OUT_30", "IN_31", "OUT_31");
*/

$aColumns = array("NRP", "NAMA", "JABATAN", "KELAS", "IN_1", "OUT_1", "JJ_1", "IN_2", "OUT_2", "JJ_2", "IN_3", "OUT_3", "JJ_3", "IN_4", "OUT_4", "JJ_4", "IN_5", "OUT_5", "JJ_5", "IN_6", "OUT_6", "JJ_6",
 "IN_7", "OUT_7", "JJ_7", "IN_8", "OUT_8", "JJ_8", "IN_9", "OUT_9", "JJ_9", "IN_10", "OUT_10", "JJ_10", "IN_11", "OUT_11", "JJ_11", "IN_12", "OUT_12", "JJ_12",
 "IN_13", "OUT_13", "JJ_13", "IN_14", "OUT_14", "JJ_14", "IN_15", "OUT_15", "JJ_15", "IN_16", "OUT_16", "JJ_16", "IN_17", "OUT_17", "JJ_17", "IN_18", "OUT_18", "JJ_18",
 "IN_19", "OUT_19", "JJ_19", "IN_20", "OUT_20", "JJ_20", "IN_21", "OUT_21", "JJ_21", "IN_22", "OUT_22", "JJ_22", "IN_23", "OUT_23", "JJ_23", "IN_24", "OUT_24", "JJ_24", 
 "IN_25", "OUT_25", "JJ_25", "IN_26", "OUT_26", "JJ_26", "IN_27", "OUT_27", "JJ_27", "IN_28", "OUT_28", "JJ_28", "IN_29", "OUT_29", "JJ_29", "IN_30", "OUT_30", "JJ_30",
 "IN_31", "OUT_31", "JJ_31");



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
if(substr($reqDepartemen, 0, 3) == "CAB")
	$statement = " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
	$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

if($reqJenisPegawai == '')
{}
else
	$statement .= 'AND JENIS_PEGAWAI_ID = '.$reqJenisPegawai;
		
		
$allRecord = $absensi_rekap->getCountByParamsModif(array(), $statement, $periode);
if($_GET['sSearch'] == "")
	$allRecordFilter = $allRecord;
else	
	$allRecordFilter = $absensi_rekap->getCountByParamsModif(array(), $statement." AND UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'", $periode);
//echo $absensi_rekap->query;exit;
$absensi_rekap->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%'", $periode, "ORDER BY KELAS, NAMA");     		
//echo $absensi_rekap->query;exit;
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
	while($absensi_rekap->nextRow())
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if($aColumns[$i] == "TTL")
				$row[] = $absensi_rekap->getField("TEMPAT_LAHIR").", ".getFormattedDate($absensi_rekap->getField("TANGGAL_LAHIR"));			
			elseif($aColumns[$i] == "MASA_KERJA")
				$row[] = $absensi_rekap->getField("MASA_KERJA_TAHUN")." - ".$absensi_rekap->getField("MASA_KERJA_BULAN");			
			elseif($aColumns[$i] == "TMT_PANGKAT" || $aColumns[$i] == "TMT_JABATAN" || $aColumns[$i] == "TMT_ESELON")
				$row[] = dateToPage($absensi_rekap->getField(trim($aColumns[$i])));	
			else
				$row[] = $absensi_rekap->getField(trim($aColumns[$i]));
		}
		
		$output['aaData'][] = $row;
		$duk++;
	}
	
	echo json_encode( $output );
	
?>
