<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");


/* create objects */
ini_set("memory_limit","500M");
ini_set("max_execution_time", 520);
/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$departemen = new Departemen();



$reqId = httpFilterGet("reqId");
$reqKplJenis = httpFilterGet("reqKplJenis");

$j=0;

if ($reqKplJenis <> "") $statement=" AND A.KAPAL_JENIS_ID= " . $reqKplJenis;

if($reqId == ""){}
else
$statement= " AND UPPER(A.KD_BUKU_BESAR) LIKE '%".strtoupper($reqId)."%'";

$departemen->selectByParams();

while($departemen->nextRow())
{
	if ( $j == 0 ) {
		$arr_parent[$j]['id'] = 0;
		$arr_parent[$j]['text'] = '';
	}
	$j++;
	$arr_parent[$j]['id'] = $departemen->getField("DEPARTEMEN_ID");
	$arr_parent[$j]['text'] = $departemen->getField("NAMA").' ('.$departemen->getField("DEPARTEMEN_ID").')';
	
}

echo json_encode($arr_parent);
?>