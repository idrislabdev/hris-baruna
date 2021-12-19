<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");

$anggaran_mutasi = new AnggaranMutasi();

/* LOGIN CHECK */

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqPeriode = httpFilterGet("reqPeriode");
$reqStatus= httpFilterGet("reqStatus");       

$aColumns = array("ANGGARAN_MUTASI_ID", "STATUS_KIRIM_LEBIH_KURANG", "CHECK", "NO_NOTA", "NO_REF3", "NO_REF2", "JENIS_ANGGARAN", "NM_BUKU_BESAR", "PEGAWAI", "TGL_TRANS", "JML_VAL_TRANS", "REALISASI", "KET_TAMBAH");
$aColumnsAlias = array("ANGGARAN_MUTASI_ID", "STATUS_KIRIM_LEBIH_KURANG", "CHECK", "NO_NOTA", "NO_REF3", "NO_REF2", "A.JENIS_ANGGARAN_ID", "PUSPEL_NAMA", "B.NAMA", "TGL_TRANS", "JML_VAL_TRANS", "REALISASI", "KET_TAMBAH");

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
	if ( trim($sOrder) == "ORDER BY ANGGARAN_MUTASI_ID asc" )
	{
		/*
		* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
		* If there is no order by clause there might be bugs in table display.
		* No order by clause means that the db is not responsible for the data ordering,
		* which means that the same row can be displayed in two pages - while
		* another row will not be displayed at all.
		*/
		$sOrder = " ORDER BY A.TGL_TRANS ASC";
		 
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

if($reqPeriode == ""){}
else
{
	$statement= " AND A.THN_BUKU = '".$reqPeriode."'";
}

if($reqStatus == "")
	$statement .= "";
else
	$statement .= " AND STATUS_KIRIM_LEBIH_KURANG = '".$reqStatus."' ";

$statement .= " AND A.JENIS_ANGGARAN_ID IN (1, 2, 3, 5, 6) AND VERIFIKASI_TGJAWAB_BY IS NOT NULL AND APPROVED_TGJAWAB_DATE IS NOT NULL AND NVL(JML_VAL_REALISASI, 0) > 0 ";

$statement_json= " AND (UPPER(B.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.KET_TAMBAH) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.NO_NOTA) LIKE '%".strtoupper($_GET['sSearch'])."%')";

$allRecord = $anggaran_mutasi->getCountByParams(array(), $statement);
if($_GET['sSearch'] == "")
	$allRecordFilter = $allRecord;
else	
	$allRecordFilter = $anggaran_mutasi->getCountByParams(array(), $statement.$statement_json);

$anggaran_mutasi->selectByParams(array(), $dsplyRange, $dsplyStart, $statement.$statement_json, $sOrder);


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
		if($aColumns[$i] == "TGL_TRANS")
			$row[] = getFormattedDate($anggaran_mutasi->getField($aColumns[$i]));
		else if($aColumns[$i] == "JML_VAL_TRANS" || $aColumns[$i] == "JUMLAH" || $aColumns[$i] == "REALISASI")
			$row[] = currencyToPage($anggaran_mutasi->getField($aColumns[$i]));
		else if($aColumns[$i] == "CHECK")
			if ($anggaran_mutasi->getField("STATUS_KIRIM_LEBIH_KURANG") == "0")
			{
				$row[] = '<input type="checkbox" name="reqCheck[]" class="selectedId" id="reqCheck'.$index.'" value="'.$anggaran_mutasi->getField("ANGGARAN_MUTASI_ID").'">';//"<input type='checkbox' name='reqCheck[]' id='reqCheck".$i."' value='".$kbbt_jur_bb->getField("NO_REF1")."'";	
			}
			else
			{
				$row[] = $anggaran_mutasi->getField($aColumns[$i]);		
			}
		else if($aColumns[$i] == "KET_TAMBAH")
			$row[] = truncate($anggaran_mutasi->getField($aColumns[$i]), 5)."...";	
		else
			$row[] = $anggaran_mutasi->getField($aColumns[$i]);
	}
	
	$output['aaData'][] = $row;
}

echo json_encode( $output );
?>
