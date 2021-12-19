<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbtNeracaAngg.php");


/* create objects */
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$kbbt_neraca_angg = new KbbtNeracaAngg();

$reqId = httpFilterGet("reqId");
$reqTahun = httpFilterGet("reqTahun");
$reqJenis = httpFilterGet("reqJenis");
$reqPPN = httpFilterGet("reqPPN");

$j=0;

if($reqJenis == 3 || $reqJenis == 6)
{
	$arr_parent[$j]['id'] = "000.00.00";
	$arr_parent[$j]['text'] = "000.00.00 - TIDAK TERDEFINISI";	
}
else
{
	
	if($reqPPN == 1)
	{
		$arr_parent[$j]['id'] = "000.00.00";
		$arr_parent[$j]['text'] = "000.00.00 - TIDAK TERDEFINISI";			
		$j++;
	}
	
	if($reqId == ""){}
	else
	$statement= " AND UPPER(A.KD_BUKU_BESAR) = '".strtoupper($reqId)."'";
	
	if($reqTahun == ""){}
	else
	$statement.= " AND THN_BUKU = '".$reqTahun."'";
	
	$kbbt_neraca_angg->selectByParams(array(),-1,-1, $statement, "ORDER BY KD_BUKU_PUSAT ASC");
	while($kbbt_neraca_angg->nextRow())
	{
		$arr_parent[$j]['id'] = $kbbt_neraca_angg->getField("KD_BUKU_PUSAT");
		$arr_parent[$j]['text'] = $kbbt_neraca_angg->getField("KD_BUKU_PUSAT")." - ".$kbbt_neraca_angg->getField("NM_BUKU_BESAR");
		$j++;
	}
}
echo json_encode($arr_parent);
?>