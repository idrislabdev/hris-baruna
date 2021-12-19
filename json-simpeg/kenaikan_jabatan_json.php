<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/KenaikanJabatan.php");

$kenaikan_jabatan = new KenaikanJabatan();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$reqDepartemen = httpFilterGet("reqDepartemen");
$reqStatus = httpFilterGet("reqStatus");
$reqStatusKenaikanJabatan= httpFilterGet("reqStatusKenaikanJabatan");
$reqJenisKenaikanJabatan = httpFilterGet("reqJenisKenaikanJabatan");
$reqKelompok = httpFilterGet("reqKelompok");
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$aColumns = array("KENAIKAN_JABATAN_ID","PEGAWAI_ID", "NRP", "NIPP", "NAMA", "DEPARTEMEN_ID_SEBELUM_NAMA", "JABATAN_ID_SEBELUM_NAMA", "DEPARTEMEN_ID_SESUDAH_NAMA", "JABATAN_ID_SESUDAH_NAMA");
$aColumnsAlias = array("KENAIKAN_JABATAN_ID","PEGAWAI_ID", "NRP", "NIPP", "B.NAMA", "DEPARTEMEN_ID_SEBELUM_NAMA", "JABATAN_ID_SEBELUM_NAMA", "DEPARTEMEN_ID_SESUDAH_NAMA", "JABATAN_ID_SESUDAH_NAMA");

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
	if ( trim($sOrder) == "ORDER BY KENAIKAN_JABATAN_ID asc" )
	{
		/*
		* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
		* If there is no order by clause there might be bugs in table display.
		* No order by clause means that the db is not responsible for the data ordering,
		* which means that the same row can be displayed in two pages - while
		* another row will not be displayed at all.
		*/
		$sOrder = " ORDER BY KENAIKAN_JABATAN_ID DESC";
		//$sOrder = " ORDER BY TO_NUMBER(D.KELAS) ASC, TO_NUMBER(D.NO_URUT) ASC";
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

/*if(substr($reqDepartemen, 0, 3) == "CAB")
	$statement = " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
	$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

if($reqStatusKenaikanJabatan == '')
	$statement .= 'AND A.STATUS_PEGAWAI_ID = 1';
else
	$statement .= 'AND A.STATUS_PEGAWAI_ID = '.$reqStatusKenaikanJabatan;

if($reqJenisKenaikanJabatan == "")
	$statement .= " AND NOT G.JENIS_PEGAWAI_ID = 8 ";
else
	$statement .= "AND G.JENIS_PEGAWAI_ID = ".$reqJenisKenaikanJabatan;

if($reqKelompok == "")
	$statement .= "";
else
	$statement .= "AND KELOMPOK = '".$reqKelompok."'";*/

	
$allRecord = $kenaikan_jabatan->getCountByParams(array("STATUS" => $reqStatus),$statement);
//echo $kenaikan_jabatan->query;
if($_GET['sSearch'] == "")
	$allRecordFilter = $allRecord;
else	
	$allRecordFilter = $kenaikan_jabatan->getCountByParams(array("STATUS" => $reqStatus), $statement." AND ((UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(B.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ");

//echo $kenaikan_jabatan->query;
$kenaikan_jabatan->selectByParams(array("STATUS" => $reqStatus), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(B.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder);
//echo $kenaikan_jabatan->query;

/* Output */
$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $allRecord,
	"iTotalDisplayRecords" => $allRecordFilter,
	"aaData" => array()
);

while($kenaikan_jabatan->nextRow())
{
	$row = array();
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if($aColumns[$i] == "TANGGAL_LAHIR")
			$row[] = getFormattedDate($kenaikan_jabatan->getField($aColumns[$i]));
		else if($aColumns[$i] == "ZODIAC")
			$row[] = getZodiac((int)getDay($kenaikan_jabatan->getField("TANGGAL_LAHIR")), (int)getMonth($kenaikan_jabatan->getField("TANGGAL_LAHIR")));
		else if($aColumns[$i] == "KETERANGAN")
			$row[] = truncate($kenaikan_jabatan->getField($aColumns[$i]), 5)."...";
		else
			$row[] = $kenaikan_jabatan->getField($aColumns[$i]);
	}
	
	$output['aaData'][] = $row;
}

echo json_encode( $output );
?>
