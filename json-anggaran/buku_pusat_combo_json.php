<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranAkses.php");

$anggaran_akses = new AnggaranAkses();

$reqId = httpFilterGet("reqId");
$reqTahun =httpFilterGet("reqTahun");

$anggaran_akses->selectByParamsBukuPusat(array("A.DEPARTEMEN_ID" => $userLogin->idDepartemen, "TAHUN" => $reqTahun, "A.KD_BUKU_BESAR" => $reqId));

$j=0;
while($anggaran_akses->nextRow())
{
	$arr_parent[$j]['id'] = $anggaran_akses->getField("KD_BUKU_PUSAT");
	$arr_parent[$j]['text'] = $anggaran_akses->getField("KD_BUKU_PUSAT")." - ".$anggaran_akses->getField("NM_BUKU_BESAR");
	$j++;
}

echo json_encode($arr_parent);
?>