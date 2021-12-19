<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");

$reqLokasi = httpFilterGet("reqLokasi");
$reqNotIn = httpFilterGet("reqNotIn");

$inventaris_ruangan = new InventarisRuangan();

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$aColumns = array("INVENTARIS", "INVENTARIS_RUANGAN_ID", "NOMOR", "LOKASI_KETERANGAN", "PEROLEHAN_PERIODE", "PEROLEHAN_HARGA", "KETERANGAN");
$aColumnsAlias = array("INVENTARIS", "INVENTARIS_RUANGAN_ID", "NOMOR", "LOKASI_KETERANGAN", "PEROLEHAN_PERIODE", "PEROLEHAN_HARGA", "KETERANGAN");

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
	if ( trim($sOrder) == "ORDER BY INVENTARIS asc, INVENTARIS asc" )
	{
		/*
		* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
		* If there is no order by clause there might be bugs in table display.
		* No order by clause means that the db is not responsible for the data ordering,
		* which means that the same row can be displayed in two pages - while
		* another row will not be displayed at all.
		*/
		$sOrder = " ORDER BY A.INVENTARIS_ID ASC";
		 
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

if($reqLokasi == 0)
{}
else
	$statement = " AND A.LOKASI_ID LIKE '".$reqLokasi."%'";
	
if($reqNotIn == "")
{}
else
	$statement .= " AND NOT A.INVENTARIS_RUANGAN_ID IN (".$reqNotIn.") ";

$allRecord = $inventaris_ruangan->getCountByParams(array(), $statement);
if($_GET['sSearch'] == "")
	$allRecordFilter = $allRecord;
else	
	$allRecordFilter = $inventaris_ruangan->getCountByParams(array(), $statement." AND (UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.NOMOR) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.BARCODE) LIKE '%".strtoupper($_GET['sSearch'])."%')");

$inventaris_ruangan->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND (UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.NOMOR) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.BARCODE) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder); 
// echo $inventaris_ruangan->query;exit();    		

/* Output */
$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $allRecord,
	"iTotalDisplayRecords" => $allRecordFilter,
	"aaData" => array()
);

while($inventaris_ruangan->nextRow())
{
	$row = array();
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if($aColumns[$i] == "PEROLEHAN_HARGA")
			$row[] = numberToIna($inventaris_ruangan->getField($aColumns[$i]));
		else if($aColumns[$i] == "PEROLEHAN_PERIODE")
			$row[] = getNamePeriode($inventaris_ruangan->getField($aColumns[$i]));
		else if($aColumns[$i] == "KETERANGAN1")
			$row[] = currencyToPage($inventaris_ruangan->getField($aColumns[$i]));			
		else
			$row[] = $inventaris_ruangan->getField($aColumns[$i]);
	}
	
	$output['aaData'][] = $row;
}

echo json_encode( $output );
?>
