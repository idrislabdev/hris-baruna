<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/KalenderKerja.php");

/* create objects */

$kalender_kerja = new KalenderKerja();

if($userLogin->UID == "")
	$kalender_kerja->selectByParams(array(), -1, -1, " AND SUBSTR(A.DEPARTEMEN_ID, 1, 3) = 'CAB' AND TO_CHAR(TANGGAL_AWAL, 'YYYY') BETWEEN TO_CHAR(SYSDATE, 'YYYY') - 1 AND TO_CHAR(SYSDATE, 'YYYY')");
else
	$kalender_kerja->selectByParams(array(), -1, -1, " AND (A.DEPARTEMEN_ID = 'CAB".$userLogin->idCabang."' OR A.DEPARTEMEN_ID LIKE '".$userLogin->idDepartemen."%')  AND TO_CHAR(TANGGAL_AWAL, 'YYYY') BETWEEN TO_CHAR(SYSDATE, 'YYYY') - 1 AND TO_CHAR(SYSDATE, 'YYYY')");

$arr_json = array();
$i=0;
while($kalender_kerja->nextRow())
{
	$arr_json[$i]['id'] = $kalender_kerja->getField("KALENDER_KERJA_ID");
	$arr_json[$i]['title'] = truncate($kalender_kerja->getField("NAMA"), 3)."..";
	$arr_json[$i]['start'] = $kalender_kerja->getField("TANGGAL_AWAL");
	$arr_json[$i]['end'] = $kalender_kerja->getField("TANGGAL_AKHIR");
	$arr_json[$i]['color'] = $kalender_kerja->getField("WARNA");
	$arr_json[$i]['url'] = $kalender_kerja->getField("NAMA");
	$i++;
}
echo json_encode($arr_json);
?>