<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");


$anggaran_mutasi = new AnggaranMutasi();
/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/

$reqTahunBuku= httpFilterGet("reqTahunBuku");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$aColumns = array("THN_BUKU", "KD_BUKU_BESAR", "KD_SUB_BANTU", "KD_BUKU_PUSAT", "ANGG_TAHUNAN", "ANGG_TRW1", "MUTASI_TRW1", "D_K_TRW1", "REALISASI_TRW1", "ANGG_TRW2", "MUTASI_TRW2", "D_K_TRW2", "REALISASI_TRW2", "ANGG_TRW3", "MUTASI_TRW3", "D_K_TRW3", "REALISASI_TRW3", "ANGG_TRW4", "MUTASI_TRW4", "D_K_TRW4", "REALISASI_TRW4");
$aColumnsAlias = array("THN_BUKU", "KD_BUKU_BESAR", "KD_SUB_BANTU", "KD_BUKU_PUSAT", "ANGG_TAHUNAN", "ANGG_TRW1", "MUTASI_TRW1", "D_K_TRW1", "REALISASI_TRW1", "ANGG_TRW2", "MUTASI_TRW2", "D_K_TRW2", "REALISASI_TRW2", "ANGG_TRW3", "MUTASI_TRW3", "D_K_TRW3", "REALISASI_TRW3", "ANGG_TRW4", "MUTASI_TRW4", "D_K_TRW4", "REALISASI_TRW4");
				 
/*$aColumnsAlias = array("KD_BUKU_BESAR", "KD_SUB_BANTU", "KD_BUKU_PUSAT", "ANGG_TAHUNAN", 
                 "JUMLAH_MUTASI", "D_K", "REALISASI");*/

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
				$sOrder .=" ASC, ";
			}else
			{
				$sOrder .=" DESC, ";
			}
		}
	}
	//echo $sOrder;
	 
	//Remove the last space / comma
	$sOrder = substr_replace( $sOrder, "", -2 );
	
	//Check if there is an order by clause
	if ( trim($sOrder) == "ORDER BY THN_BUKU ASC" )
	{
		/*
		* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
		* If there is no order by clause there might be bugs in table display.
		* No order by clause means that the db is not responsible for the data ordering,
		* which means that the same row can be displayed in two pages - while
		* another row will not be displayed at all.
		*/
		$sOrder = " ORDER BY KD_BUKU_BESAR ASC, THN_BUKU ASC";
		 
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


if($reqTahunBuku == "" || $reqTahunBuku == "0"){}
else $statement= " AND A.THN_BUKU = '".$reqTahunBuku."'";

if($userLogin->userAksesAnggaran >= 5){
	$statement .= " AND (A.KD_BUKU_BESAR || A.KD_BUKU_PUSAT IN (SELECT X.KD_BUKU_BESAR || X.KD_BUKU_PUSAT FROM PEL_ANGGARAN.ANGGARAN_AKSES X WHERE X.DEPARTEMEN_ID LIKE '" . substr($userLogin->idDepartemen,0,2) . "%')) ";
}

$search_json= " AND ((UPPER(A.KD_BUKU_PUSAT) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NM_BUKU_PUSAT) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.KD_SUB_BANTU) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NM_SUB_BANTU) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.KD_BUKU_BESAR) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(A.NM_BUKU_BESAR) LIKE '%".strtoupper($_GET['sSearch'])."%'))";
//$search_json= "";

$allRecord = $anggaran_mutasi->getCountByParamsMaintenanceAnggaranTriwulan(array(), $statement);
if($_GET['sSearch'] == "")
	$allRecordFilter = $allRecord;
else	
	$allRecordFilter = $anggaran_mutasi->getCountByParamsMaintenanceAnggaranTriwulan(array(), $statement.$search_json);

$anggaran_mutasi->selectByParamsMaintenanceAnggaranTriwulan(array(), $dsplyRange, $dsplyStart, $statement.$search_json, $sOrder);

//echo $anggaran_mutasi->query; exit;

/* Output */
$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $allRecord,
	"iTotalDisplayRecords" => $allRecordFilter,
	"aaData" => array()
);

while($anggaran_mutasi->nextRow())
{
	$row = array();
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if($aColumns[$i] == "TANGGAL")
			$row[] = getFormattedDate($anggaran_mutasi->getField($aColumns[$i]));
		else if($aColumns[$i] == "THN_BUKU" || $aColumns[$i] == "KD_BUKU_BESAR" || $aColumns[$i] == "KD_SUB_BANTU" || $aColumns[$i] == "KD_BUKU_PUSAT" || $aColumns[$i] == "D_K_TRW1" || $aColumns[$i] == "D_K_TRW2" || $aColumns[$i] == "D_K_TRW3" || $aColumns[$i] == "D_K_TRW4")
			$row[] = $anggaran_mutasi->getField($aColumns[$i]);
		else
			$row[] = numberToIna($anggaran_mutasi->getField($aColumns[$i]));
	}
	
	$output['aaData'][] = $row;
}

echo json_encode( $output );
?>
