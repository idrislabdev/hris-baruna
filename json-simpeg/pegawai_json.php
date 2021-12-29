<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

$pegawai = new Pegawai();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$reqDepartemen = httpFilterGet("reqDepartemen");
$reqStatusPegawai= httpFilterGet("reqStatusPegawai");
$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
$reqKelompok = httpFilterGet("reqKelompok");
$reqPeriode = httpFilterGet("reqPeriode");

$reqPeriode = ($reqPeriode == '') ? date('dmY') : $reqPeriode;

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$aColumns = array("PEGAWAI_ID", "NRP", "NAMA", "JABATAN_NAMA", "KELAS", "TANGGAL_KONTRAK_AWAL", "TANGGAL_KONTRAK_AKHIR", "MKP", "DEPARTEMEN", "PENDIDIKAN_TERAKHIR", "JENIS_KELAMIN", "TANGGAL_LAHIR","UMUR", "ZODIAC", "STATUS_KAWIN", "STATUS_PEGAWAI_NAMA", "GOLONGAN_DARAH", "ALAMAT", "TELEPON", "EMAIL", "HOBBY", "NIS", "STATUS_PEGAWAI_ID", "JENIS_PEGAWAI_ID", "BIDANG_STUDI", "LINERITAS", "SPESIFIKASI_PRESTASI_KARYA", "TUGAS_PEMBIMBINGAN");
$aColumnsAlias = array("A.PEGAWAI_ID", "F.NRP", "F.NAMA", "E.NAMA", "E.KELAS", "J.TANGGAL_AWAL", "J.TANGAL_AKHIR", "B.TMT_JENIS_PEGAWAI", "DEPARTEMEN", "PENDIDIKAN_TERAKHIR", "JENIS_KELAMIN", "TANGGAL_LAHIR", "UMUR", "STATUS_KAWIN", "H.NAMA", "GOLONGAN_DARAH", "ALAMAT", "TELEPON", "EMAIL", "HOBBY", "F.NIS", "STATUS_PEGAWAI_ID", "JENIS_PEGAWAI_ID" , "BIDANG_STUDI", "LINERITAS", "SPESIFIKASI_PRESTASI_KARYA", "TUGAS_PEMBIMBINGAN");

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
	if ( trim($sOrder) == "ORDER BY A.PEGAWAI_ID asc" )
	{
		/*
		* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
		* If there is no order by clause there might be bugs in table display.
		* No order by clause means that the db is not responsible for the data ordering,
		* which means that the same row can be displayed in two pages - while
		* another row will not be displayed at all.
		*/
		//$sOrder = " ORDER BY PEGAWAI_ID DESC";
		$sOrder = " ORDER BY TO_NUMBER(E.KELAS) ASC, TO_NUMBER(E.NO_URUT) ASC";
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

if(substr($reqDepartemen, 0, 3) == "CAB"){}

	/*if($reqJenisPegawai == 4 )
		$statement = " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE ((D.DEPARTEMEN_ID = X.DEPARTEMEN_ID OR F.DEPARTEMEN_ID = X.DEPARTEMEN_ID) AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') OR D.DEPARTEMEN_ID IS NULL) ";
	else if($reqStatusPegawai != 1)
		$statement = " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE F.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
	
	else 
		$statement = " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE (D.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') OR D.DEPARTEMEN_ID IS NULL ) ";
		*/
else
	$statement = " AND F.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

if($reqStatusPegawai != '')
	$statement .= 'AND F.STATUS_PEGAWAI_ID = '.$reqStatusPegawai;

if($reqJenisPegawai == "")
	$statement .= " AND NOT NVL(A.JENIS_PEGAWAI_ID, 1) = 8 ";
else
	$statement .= "AND (B.JENIS_PEGAWAI_ID = ".$reqJenisPegawai . " OR B.JENIS_PEGAWAI_ID IS NULL)";
	
$allRecord = $pegawai->getCountByParamsNew(array(),$statement, $reqPeriode);
//echo $pegawai->query;
if($_GET['sSearch'] == "")
	$allRecordFilter = $allRecord;
else	
	$allRecordFilter = $pegawai->getCountByParamsNew(array(), $statement." AND ((UPPER(F.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(F.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) ", $reqPeriode);

//echo $pegawai->query;
$pegawai->selectByParamsNew(array(), $dsplyRange, $dsplyStart, $statement." AND ((UPPER(F.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') OR (UPPER(F.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%')) " , $sOrder, $reqPeriode, $reqStatusPegawai);
//" AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%') AND (UPPER(A.NIPP) LIKE '%".strtoupper($_GET['sSearch'])."%') "

//echo $pegawai->query;

/* Output */
$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $allRecord,
	"iTotalDisplayRecords" => $allRecordFilter,
	"aaData" => array()
);

while($pegawai->nextRow())
{
	$row = array();
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{

		if($aColumns[$i] == "TANGGAL_LAHIR" || $aColumns[$i] == "TANGGAL_KONTRAK_AWAL" || $aColumns[$i] == "TANGGAL_KONTRAK_AKHIR")
			$row[] = getFormattedDate($pegawai->getField($aColumns[$i]));
		else if($aColumns[$i] == "ZODIAC")
			$row[] = getZodiac((int)getDay($pegawai->getField("TANGGAL_LAHIR")), (int)getMonth($pegawai->getField("TANGGAL_LAHIR")));
		else if($aColumns[$i] == "KETERANGAN")
			$row[] = truncate($pegawai->getField($aColumns[$i]), 5)."...";
		else
			$row[] = $pegawai->getField($aColumns[$i]);
	}
	
	$output['aaData'][] = $row;
}

echo json_encode( $output );
?>
