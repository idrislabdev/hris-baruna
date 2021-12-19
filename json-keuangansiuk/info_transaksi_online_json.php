<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaLap.php");

$kptt_nota_lap = new KpttNotaLap();

/* LOGIN CHECK */
$reqPeriode = httpFilterGet("reqPeriode");
$reqKodeValuta = httpFilterGet("reqKodeValuta");
$reqPelunasan = httpFilterGet("reqPelunasan");
$reqId = httpFilterGet("reqId");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$aColumns = array("BULTAH", "KD_KUSTO", "MPLG_NAMA",  "NO_REF3", "TGL_TRANS", "KD_VALUTA", "SEGMEN", "KET_TAMBAHAN", "SISA_TAGIHAN", "PELUNASAN");
$aColumnsAlias = array("BULTAH", "KD_KUSTO", "MPLG_NAMA",  "NO_REF3", "TGL_TRANS", "KD_VALUTA", "SEGMEN", "KET_TAMBAHAN", "SISA_TAGIHAN", "PELUNASAN");

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
	if ( trim($sOrder) == "ORDER BY ID_REF_DATA asc" )
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
 
if($reqPeriode == "")
{}
else
{
	$statement .= "AND A.BULTAH  = (SELECT MAX(BULTAH)    
											  FROM KPTT_NOTA_LAP
												WHERE BULTAH = '".$reqPeriode."')";	
}
if($reqPelunasan == 0)
{
	$statement .= "  AND NVL(JML_SALDO_AKHIR,0) <> 0 AND 
                                                    NOT EXISTS (SELECT 1 FROM KPTT_NOTA_LAP Y WHERE A.NO_NOTA = Y.NO_NOTA AND NVL(Y.JML_SALDO_AKHIR,0) = 0) ";
}
elseif($reqPelunasan == 1)
{
	$statement = " AND NVL(JML_SALDO_AKHIR,0) = 0 ";
}
else
{
	$statement .= " AND ((NVL(JML_SALDO_AKHIR,0) <> 0 AND 
                                                    NOT EXISTS (SELECT 1 FROM KPTT_NOTA_LAP Y WHERE A.NO_NOTA = Y.NO_NOTA AND NVL(Y.JML_SALDO_AKHIR,0) = 0)) OR NVL(JML_SALDO_AKHIR,0) = 0) ";
}


if($reqId == "")
	$arrStatement = array();
else
	$arrStatement = array("A.KD_KUSTO" => $reqId);

$allRecord = $kptt_nota_lap->getCountByParamsTransaksi($arrStatement, $statement);
if($_GET['sSearch'] == "")
	$allRecordFilter = $allRecord;
else	
	$allRecordFilter = $kptt_nota_lap->getCountByParamsTransaksi($arrStatement, $statement." AND (UPPER(A.NO_REF3) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.KET_TAMBAHAN) LIKE '%".strtoupper($_GET['sSearch'])."%')");

$kptt_nota_lap->selectByParamsTransaksi($arrStatement, $dsplyRange, $dsplyStart, $statement." AND (UPPER(A.NO_REF3) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.KET_TAMBAHAN) LIKE '%".strtoupper($_GET['sSearch'])."%')", " ORDER BY A.BULTAH DESC, A.KD_VALUTA ASC ");     		

/* Output */
$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $allRecord,
	"iTotalDisplayRecords" => $allRecordFilter,
	"aaData" => array()
);
//echo $kptt_nota_lap->query;exit;
while($kptt_nota_lap->nextRow())
{
	$row = array();
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if($aColumns[$i] == "SISA_TAGIHAN")
			$row[] = numberToIna($kptt_nota_lap->getField($aColumns[$i]));
		else if($aColumns[$i] == "TGL_TRANS")
			$row[] = getFormattedDate($kptt_nota_lap->getField($aColumns[$i]));
		else if($aColumns[$i] == "BULTAH")
			$row[] = getNameMonthKeu((int)substr($kptt_nota_lap->getField($aColumns[$i]), 4, 2))." ".substr($kptt_nota_lap->getField($aColumns[$i]), 0, 4);
		else
			$row[] = $kptt_nota_lap->getField($aColumns[$i]);
	}
	
	$output['aaData'][] = $row;
}

echo json_encode( $output );
?>
