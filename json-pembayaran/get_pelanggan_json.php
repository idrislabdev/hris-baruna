<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");

/* create objects */

/* LOGIN CHECK */

$reqNoPelangganId = httpFilterGet("reqNoPelangganId");

//$reqNoPelangganId = 'A.11';
//$reqTahun = 3;

$safm_pelanggan = new SafmPelanggan();
$safm_pelanggan->selectByParamsBB(array('NIS'=>$reqNoPelangganId, 'JENIS' => "SPP"));
$safm_pelanggan->firstRow();
//echo $safm_pelanggan->query;


if(empty($safm_pelanggan->rowResult))
{
	echo json_encode(array());
	exit;
}

echo json_encode($safm_pelanggan->rowResult[0]);

?>