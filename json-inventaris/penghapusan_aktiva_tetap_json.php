<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-inventaris/KalkulasiPenyusutan.php");

$kalkulas_penyusutan = new KalkulasiPenyusutan();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$reqPeriode = httpFilterGet("reqPeriode");
$reqPeriodeAwal = httpFilterGet("reqPeriodeAwal");
$reqPeriodeAkhir = httpFilterGet("reqPeriodeAkhir");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$aColumns = array("HEADER", "KODE", "LOKASI", "NAMA", "SPESIFIKASI", "TANGGAL_PEROLEHAN", "SISA_UMUR", "NILAI_PEROLEHAN", "AKM_PENYUSUTAN_LALU", "NILAI_PENYUSUTAN", "AKM_PENYUSUTAN", "NILAI_AKHIR");
$aColumnsAlias = array("HEADER", "KODE", "LOKASI", "NAMA", "SPESIFIKASI", "TANGGAL_PEROLEHAN", "SISA_UMUR", "NILAI_PEROLEHAN", "AKM_PENYUSUTAN_LALU", "NILAI_PENYUSUTAN", "AKM_PENYUSUTAN", "NILAI_AKHIR");

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
	if ( trim($sOrder) == "ORDER BY PEGAWAI_ID ASC" )
	{
		/*
		* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
		* If there is no order by clause there might be bugs in table display.
		* No order by clause means that the db is not responsible for the data ordering,
		* which means that the same row can be displayed in two pages - while
		* another row will not be displayed at all.
		*/
		$sOrder = " ORDER BY KELAS ASC";
		 
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

if($reqPeriode == "")
	$reqPeriode = '0';
$statement_privacy = " AND PERIODE = '".$reqPeriode."'";



$statement_privacy .= " AND EXISTS( SELECT 1 FROM PPI_ASSET.INVENTARIS_SUSUT X WHERE X.INVENTARIS_RUANGAN_ID =  A.INVENTARIS_RUANGAN_ID AND X.TANGGAL_SUSUT BETWEEN TO_DATE('".$reqPeriodeAwal."', 'MMYYYY') AND LAST_DAY(TO_DATE('".$reqPeriodeAkhir."', 'MMYYYY'))) ";



$allRecord = $kalkulas_penyusutan->getCountByParamsRekapAktiva(array(), $statement_privacy);	
if($_GET['sSearch'] == "")
	$allRecordFilter = $allRecord;
else	
	$allRecordFilter = $kalkulas_penyusutan->getCountByParamsRekapAktiva(array(), " AND (UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement_privacy);

$kalkulas_penyusutan->selectByParamsRekapAktiva(array(), $dsplyRange, $dsplyStart, " AND (UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')".$statement_privacy, $sOrder);     		

// echo $kalkulas_penyusutan->query; exit;
// echo $allRecord; exit;

/* Output */
$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $allRecord,
	"iTotalDisplayRecords" => $allRecordFilter,
	"aaData" => array()
);

while($kalkulas_penyusutan->nextRow())
{
	$row = array();
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if($aColumns[$i] == "TANGGAL_PEROLEHAN")
			$row[] = getFormattedDate($kalkulas_penyusutan->getField($aColumns[$i]));
		else if($aColumns[$i] == "KETERANGAN")
			$row[] = truncate($kalkulas_penyusutan->getField($aColumns[$i]), 5)."...";
		else if($aColumns[$i] == "NILAI_PEROLEHAN" || $aColumns[$i] == "NILAI_PENYUSUTAN"  || $aColumns[$i] == "AKM_PENYUSUTAN_LALU" || $aColumns[$i] == "AKM_PENYUSUTAN" || $aColumns[$i] == "NILAI_AKHIR")
			$row[] = numberToIna($kalkulas_penyusutan->getField($aColumns[$i]));			
		else
			$row[] = $kalkulas_penyusutan->getField($aColumns[$i]);
	}
	
	$output['aaData'][] = $row;
}

echo json_encode( $output );
?>
