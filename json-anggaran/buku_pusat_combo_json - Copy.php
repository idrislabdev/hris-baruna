<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");

$departemen = new Departemen();
$departemen->selectByParams(array("DEPARTEMEN_ID" => substr($userLogin->idDepartemen, 0, 2)));
$departemen->firstRow();

$puspel = $departemen->getField("PUSPEL");

include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbtNeracaAngg.php");


/* create objects */
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$kbbt_neraca_angg = new KbbtNeracaAngg();

$reqId = httpFilterGet("reqId");
$reqTahun = httpFilterGet("reqTahun");

$j=0;

if($reqId == ""){}
else
$statement= " AND UPPER(KD_BUKU_BESAR) = '".strtoupper($reqId)."'";

if($reqTahun == ""){}
else
$statement.= " AND THN_BUKU = '".$reqTahun."'";

$kbbt_neraca_angg->selectByParams(array("KD_BUKU_PUSAT" => $puspel),-1,-1, $statement, "ORDER BY KD_BUKU_PUSAT ASC");
while($kbbt_neraca_angg->nextRow())
{
	$arr_parent[$j]['id'] = $kbbt_neraca_angg->getField("KD_BUKU_PUSAT");
	$arr_parent[$j]['text'] = $kbbt_neraca_angg->getField("KD_BUKU_PUSAT");
	$j++;
}

echo json_encode($arr_parent);
?>