<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSpp.php");

$kptt_nota_spp = new KpttNotaSpp();

/* LOGIN CHECK */

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);


$reqTanggalAwal = httpFilterGet("reqTanggalAwal");
$reqTanggalAkhir = httpFilterGet("reqTanggalAkhir");
$reqMode = httpFilterGet("reqMode");

if($reqTanggalAkhir == "")
	$reqTanggalAkhir = $reqTanggalAwal;

$aColumns = array("NO_NOTA", "NO_NOTA", "PELANGGAN", "TGL_TRANS", "NO_REF1", "PERIODE", "REKENING_KAS_BANK", "TGL_POSTING", "NO_POSTING", "JML_VAL_TRANS", "KET_TAMBAHAN", "NO_POSTING");
$aColumnsAlias = array("A.NO_NOTA", "A.NO_NOTA", "A.KD_KUSTO", "TGL_TRANS", "NO_REF1",  "PERIODE", "REKENING_KAS_BANK", "TGL_POSTING", "NO_POSTING", "JML_VAL_TRANS", "KET_TAMBAHAN", "NO_POSTING");
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
	if ( trim($sOrder) == "ORDER BY A.NO_NOTA asc" )
	{
		/*
		* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
		* If there is no order by clause there might be bugs in table display.
		* No order by clause means that the db is not responsible for the data ordering,
		* which means that the same row can be displayed in two pages - while
		* another row will not be displayed at all.
		*/
		$sOrder = " ORDER BY TGL_TRANS DESC, NO_NOTA DESC";
		 
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

if($reqMode == "view")
 	$statement = " AND A.TGL_POSTING IS NULL ";
else
	$statement = " AND A.TGL_TRANS BETWEEN TO_DATE('".$reqTanggalAwal."', 'DD-MM-YYYY') AND TO_DATE('".$reqTanggalAkhir."', 'DD-MM-YYYY') ";

$statement .= " AND A.DEPARTEMEN_ID IS NULL ";
$statement .= " AND A.JNS_JUAL IS NOT NULL ";
$statement .= " AND A.TIPE_TRANS = 'JKM-KPT-99' ";



$allRecord = $kptt_nota_spp->getCountByParams(array("JEN_JURNAL" => "JKM", "A.KD_SUBSIS"=>"KPT", "JEN_TRANS"=>2, "STATUS_PROSES"=>1), $statement);
if($_GET['sSearch'] == "")
	$allRecordFilter = $allRecord;
else	
	$allRecordFilter = $kptt_nota_spp->getCountByParams(array("JEN_JURNAL" => "JKM", "A.KD_SUBSIS"=>"KPT", "JEN_TRANS"=>2, "STATUS_PROSES"=>1), $statement." AND (UPPER(A.NO_NOTA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(KD_KUSTO) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(MPLG_NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')");

$kptt_nota_spp->selectByParams(array("JEN_JURNAL" => "JKM", "A.KD_SUBSIS"=>"KPT", "JEN_TRANS"=>2, "STATUS_PROSES"=>1), $dsplyRange, $dsplyStart, $statement." AND (UPPER(A.NO_NOTA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(KD_KUSTO) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(MPLG_NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')", $sOrder);     		

/* Output */
$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $allRecord,
	"iTotalDisplayRecords" => $allRecordFilter,
	"aaData" => array()
);

while($kptt_nota_spp->nextRow())
{
	$row = array();
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		
		if($aColumns[$i] == "TGL_TRANS" || $aColumns[$i] == "TGL_VALUTA" || $aColumns[$i] == "TGL_POSTING")
			$row[] = dateToPage($kptt_nota_spp->getField($aColumns[$i]));
		else if($aColumns[$i] == "JML_VAL_TRANS" || $aColumns[$i] == "KURS_VALUTA")
			$row[] = numberToIna($kptt_nota_spp->getField($aColumns[$i]), "");
		else if($aColumns[$i] == "KET_TAMBAHAN")
			$row[] = truncate($kptt_nota_spp->getField($aColumns[$i]), 5)."...";
		else
			$row[] = $kptt_nota_spp->getField($aColumns[$i]);
	}
	
	$output['aaData'][] = $row;
}

echo json_encode( $output );
?>
