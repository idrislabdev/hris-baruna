<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
include_once("../WEB-INF/classes/base-gaji/Gaji.php");

$gaji_awal_bulan = new GajiAwalBulan();
$gaji = new Gaji();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqPeriode = httpFilterGet("reqPeriode");
$reqDepartemen = httpFilterGet("reqDepartemen");
$reqMode = httpFilterGet("reqMode");

$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(2, "TENGAH_BULAN"));

$aColumns[] = "PEGAWAI_ID";
$aColumns[] = "NAMA";
$aColumns[] = "NAMA";
for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
{
	$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
}
	
$aColumnsAlias = array("A.PEGAWAI_ID", "A.NAMA", "A.NAMA", "A.NAMA");

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
	if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID ASC" )
	{
		/*
		* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
		* If there is no order by clause there might be bugs in table display.
		* No order by clause means that the db is not responsible for the data ordering,
		* which means that the same row can be displayed in two pages - while
		* another row will not be displayed at all.
		*/
		$sOrder = " ORDER BY A.PEGAWAI_ID DESC";
		 
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
	$gaji_awal_bulan->setField("PERIODE", $reqPeriode);
	$gaji_awal_bulan->setField("JENIS_PEGAWAI_ID", 2);		
	$gaji_awal_bulan->callHitungGajiAwalBulan();		
}

if(substr($reqDepartemen, 0, 3) == "CAB")
	$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
	$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";


$allRecord = $gaji_awal_bulan->getCountByParams(array(),$statement);
if($_GET['sSearch'] == "")
	$allRecordFilter = $allRecord;
else	
	$allRecordFilter = $gaji_awal_bulan->getCountByParams(array(), " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement);

$gaji_awal_bulan->selectByParamsGajiTengahBulan(array(), $dsplyRange, $dsplyStart, " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement, $sOrder, $reqPeriode, 2);     		

/* Output */
$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $allRecord,
	"iTotalDisplayRecords" => $allRecordFilter,
	"aaData" => array()
);

while($gaji_awal_bulan->nextRow())
{
	$row = array();
	
	$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
	$total_gaji = 0;
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{	
		if(substr($aColumns[$i],0,4) == "GAJI")
		{
			$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
			if($column_gaji == "TOTAL_GAJI")
			{
				$row[] = currencyToPage($total_gaji);				
			}
			else
			{
				$row[] = currencyToPage($json_gaji->{$column_gaji}{0});
				$total_gaji += $json_gaji->{$column_gaji}{0};
			}
		}
		elseif($aColumns[$i] == "TOTAL")			
			$row[] = currencyToPage($total_gaji - $total_potongan_lain);	
		else
			$row[] = $gaji_awal_bulan->getField($aColumns[$i]);		
	}
	
	$output['aaData'][] = $row;
	
	unset($json_gaji);
}

echo json_encode( $output );
?>
