<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/Pajak.php");

$pajak = new Pajak();

/* LOGIN CHECK */
$reqPeriode = httpFilterGet("reqPeriode");

if($reqPeriode == "")
	$reqPeriode = date("mY");

ini_set("memory_limit","850M");
ini_set('max_execution_time', 720);

$reqBulan = substr($reqPeriode, 0, 2);
$reqTahun = substr($reqPeriode, 2, 4);

if($reqBulan == "01")
	$reqBulan = "12";
else
	$reqBulan = generateZero((int)$reqBulan - 1, 2);

if($reqBulan == "01")
	$reqTahun = $reqTahun - 1;

$reqPeriodeLalu = $reqBulan.$reqTahun;

$aColumns = array("JENIS_PEGAWAI", "NRP", "NAMA", "NPWP", "MERIT_PMS", "MOBILITAS", "PERUMAHAN", "TELEPON", "POTONGAN_PPH21_DIREKSI", "PENGHASILAN", "TUNJANGAN_JABATAN", "TPP_PMS", "JUMLAH_GAJI_KOTOR", "POTONGAN_PPH21", "UANG_MAKAN", "UANG_MAKAN_PPH", "UANG_TRANSPORT", "UANG_TRANSPORT_PPH", "UANG_INSENTIF", "UANG_INSENTIF_PPH", "UANG_PREMI", "UANG_PREMI_PPH", "TOTAL_DPP", "TOTAL_PPH");										
$aColumnsAlias = array("P.JENIS_PEGAWAI_ID", "A.NRP", "A.NAMA", "A.NPWP", "MERIT_PMS", "MOBILITAS", "PERUMAHAN", "TELEPON", "POTONGAN_PPH21", "(MERIT_PMS + TUNJANGAN_PERBANTUAN)", "TUNJANGAN_JABATAN", "TPP_PMS", "(MERIT_PMS + TUNJANGAN_PERBANTUAN + TUNJANGAN_JABATAN + TPP_PMS)", "POTONGAN_PPH21", "B.JUMLAH", "B.BANTUAN_PPH", "C.JUMLAH", "C.BANTUAN_PPH", "D.JUMLAH", "D.JUMLAH_PPH", "E.JUMLAH_INSENTIF", "E.JUMLAH_PPH", "TOTAL_DPP", "TOTAL_PPH");										

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
	if ( trim($sOrder) == "ORDER BY P.JENIS_PEGAWAI_ID asc, P.JENIS_PEGAWAI_ID asc" )
	{
		/*
		* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
		* If there is no order by clause there might be bugs in table display.
		* No order by clause means that the db is not responsible for the data ordering,
		* which means that the same row can be displayed in two pages - while
		* another row will not be displayed at all.
		*/
		$sOrder = "ORDER BY F.JENIS_URUT, P.NAMA ASC ";
		 
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


$allRecord = $pajak->getCountByParamsPph21Pegawai(array(), "", $reqPeriode, $reqPeriodeLalu);
if($_GET['sSearch'] == "")
	$allRecordFilter = $allRecord;
else	
	$allRecordFilter = $pajak->getCountByParamsPph21Pegawai(array(), " AND (UPPER(P.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $reqPeriode, $reqPeriodeLalu);

$pajak->selectByParamsPph21Pegawai(array(), $dsplyRange, $dsplyStart, " AND (UPPER(P.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder, $reqPeriode, $reqPeriodeLalu);


/* Output */
$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $allRecord,
	"iTotalDisplayRecords" => $allRecordFilter,
	"aaData" => array()
);

while($pajak->nextRow())
{
	$row = array();
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if($aColumns[$i] == "NRP" || $aColumns[$i] == "NAMA" || $aColumns[$i] == "NPWP" || $aColumns[$i] == "JENIS_PEGAWAI")
			$row[] = $pajak->getField($aColumns[$i]);
		else
		{
			if($aColumns[$i] == "POTONGAN_PPH21_DIREKSI" || $aColumns[$i] == "MERIT_PMS")
			{
				if($pajak->getField("JENIS_PEGAWAI_ID") == "6" || $pajak->getField("JENIS_PEGAWAI_ID") == "7")
					$row[] = numberToIna($pajak->getField($aColumns[$i]));
				else
					$row[] = 0;
			}
			elseif($aColumns[$i] == "POTONGAN_PPH21" || $aColumns[$i] == "JUMLAH_GAJI_KOTOR")
			{
				if($pajak->getField("JENIS_PEGAWAI_ID") == "6" || $pajak->getField("JENIS_PEGAWAI_ID") == "7")
					$row[] = 0;				
				else
					$row[] = numberToIna($pajak->getField($aColumns[$i]));
			}
			else
				$row[] =numberToIna($pajak->getField($aColumns[$i]));
		}
	}
	
	$output['aaData'][] = $row;
}

echo json_encode( $output );
?>
