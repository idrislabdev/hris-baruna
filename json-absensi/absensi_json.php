<?php
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
?>
