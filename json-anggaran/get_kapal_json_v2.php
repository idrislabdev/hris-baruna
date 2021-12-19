<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiD.php");

/* create objects */

/* LOGIN CHECK */

$reqId = httpFilterGet("reqId");

$anggaran_mutasi_d = new AnggaranMutasiD();
$anggaran_mutasi_d->selectByParamsPencarian(array("KD_SUB_BANTU"=>$reqId));
$anggaran_mutasi_d->firstRow();

/*
$j=0;
while($anggaran_mutasi_d->nextRow())
{
	$arrFinal[$j]['PELANGGAN'] = $anggaran_mutasi_d->getField("PELANGGAN");
	$arrFinal[$j]['TGL_NOTA'] = $anggaran_mutasi_d->getField("NAMA");
	$arrFinal[$j]['TOT_TAGIHAN'] = numberToIna($anggaran_mutasi_d->getField("TOT_TAGIHAN"));
	$arrFinal[$j]['BAYAR'] = numberToIna($anggaran_mutasi_d->getField("BAYAR"));
	$arrFinal[$j]['SISA_TAGIHAN'] = numberToIna($anggaran_mutasi_d->getField("SISA_TAGIHAN"));
	$arrFinal[$j]['NO_NOTA'] = $anggaran_mutasi_d->getField("NO_NOTA");
	$arrFinal[$j]['KD_BB_KUSTO'] = $anggaran_mutasi_d->getField("KD_BB_KUSTO");
	$arrFinal[$j]['NO_PPKB'] = $anggaran_mutasi_d->getField("NO_PPKB");
	$j++;
}

echo json_encode($arrFinal);
*/


$arrFinal = array("KD_SUB_BANTU" => $anggaran_mutasi_d->getField("KD_SUB_BANTU"));

echo json_encode($arrFinal);
?>