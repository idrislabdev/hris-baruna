<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

$pegawai = new Pegawai();

$reqId = httpFilterGet("reqId");
$reqTahun =httpFilterGet("reqTahun");

$pegawai->selectByParamsGetInfo(array(),-1,-1, " AND A.STATUS_PEGAWAI_ID IN (1,5) ");

$j=0;
while($pegawai->nextRow())
{
	$arr_parent[$j]['id'] = $pegawai->getField("PEGAWAI_ID");
	$arr_parent[$j]['text'] = $pegawai->getField("NRP")." - ".$pegawai->getField("NAMA");
	$j++;
}

echo json_encode($arr_parent);
?>