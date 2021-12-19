<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/TmpAgingRollRate.php");

$tmp_aging_roll_rate = new TmpAgingRollRate();

$reqMode = httpFilterGet("reqMode");
$reqTanggal = httpFilterGet("reqTanggal");
$reqKodeValuta = httpFilterGet("reqKodeValuta");
$reqBadanUsaha = httpFilterGet("reqBadanUsaha");
$arrTahunBulan = explode("-", $reqTanggal);
$reqTahunBulan = $arrTahunBulan[2].$arrTahunBulan[1];


/* LOGIN CHECK */

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);
	
$aColumns = array("BADAN_USAHA", "KD_KUSTO", "MPLG_NAMA", "VAL_30HARI", "VAL_90HARI", "VAL_180HARI", "VAL_270HARI", "VAL_365HARI", "VAL_A365HARI", "JUMLAH");
$aColumnsAlias = array("BADAN_USAHA", "KD_KUSTO", "MPLG_NAMA", "VAL_30HARI", "VAL_90HARI", "VAL_180HARI", "VAL_270HARI", "VAL_365HARI", "VAL_A365HARI", "JUMLAH");

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
	if ( trim($sOrder) == "ORDER BY ID_REF_FILE asc" )
	{
		/*
		* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
		* If there is no order by clause there might be bugs in table display.
		* No order by clause means that the db is not responsible for the data ordering,
		* which means that the same row can be displayed in two pages - while
		* another row will not be displayed at all.
		*/
		$sOrder = " ORDER BY ID_REF_FILE ASC";
		 
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
	$tmp_aging_roll_rate->setField("PERIODE", $reqTahunBuku.$reqBulanBuku);
	$tmp_aging_roll_rate->callIsiAgingRollRate();	
}

if($reqBadanUsaha == "")
{}
else
	$statement .= " AND BADAN_USAHA LIKE '%".$reqBadanUsaha."' ";


$allRecord = $tmp_aging_roll_rate->getCountByParamsAgingPiutang(array(), $reqTanggal, $reqTahunBulan, $reqKodeValuta, $statement);
if($_GET['sSearch'] == "")
	$allRecordFilter = $allRecord;
else	
	$allRecordFilter = $tmp_aging_roll_rate->getCountByParamsAgingPiutang(array(), $reqTanggal, $reqTahunBulan, $reqKodeValuta, $statement." AND ( UPPER(KD_KUSTO) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(MPLG_NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' ) ");

$tmp_aging_roll_rate->selectByParamsAgingPiutang(array(), $reqTanggal, $reqTahunBulan, $reqKodeValuta, $dsplyRange, $dsplyStart, $statement." AND ( UPPER(KD_KUSTO) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(MPLG_NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' ) ", $sOrder);     		
//echo $tmp_aging_roll_rate->query;

/* Output */
$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $allRecord,
	"iTotalDisplayRecords" => $allRecordFilter,
	"aaData" => array()
);

while($tmp_aging_roll_rate->nextRow())
{
	$row = array();
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if($aColumns[$i] == "TANGGAL")
			$row[] = getFormattedDate($tmp_aging_roll_rate->getField($aColumns[$i]));
		else if($aColumns[$i] == "BADAN_USAHA" || $aColumns[$i] == "KD_KUSTO" || $aColumns[$i] == "MPLG_NAMA")
			$row[] = $tmp_aging_roll_rate->getField($aColumns[$i]);
		else
			$row[] = numberToIna($tmp_aging_roll_rate->getField($aColumns[$i]));
	}
	
	$output['aaData'][] = $row;
}

echo json_encode( $output );
?>
