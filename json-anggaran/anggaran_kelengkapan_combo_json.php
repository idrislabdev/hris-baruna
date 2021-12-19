<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranKelengkapanDokumen.php");

/* create objects */

$anggaran_kelengkapan_dokumen = new AnggaranKelengkapanDokumen();

$reqId = httpFilterGet("reqId");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$j=0;
$anggaran_kelengkapan_dokumen->selectByParamsCombo($reqId);
while($anggaran_kelengkapan_dokumen->nextRow())
{
	$arr_parent[$j]['id'] = $anggaran_kelengkapan_dokumen->getField("KELENGKAPAN_DOKUMEN_ID");
	$arr_parent[$j]['text'] = $anggaran_kelengkapan_dokumen->getField("NAMA");
	if($anggaran_kelengkapan_dokumen->getField("KELENGKAPAN_DOKUMEN_ID") == $anggaran_kelengkapan_dokumen->getField("KELENGKAPAN_ANGGARAN_ID"))
		$arr_parent[$j]['checked'] = true;
	$j++;
}

echo json_encode($arr_parent);
?>