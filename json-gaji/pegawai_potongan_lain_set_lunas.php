<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-gaji/LainKondisiPegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");

/* create objects */

$lain_kondisi_pegawai = new LainKondisiPegawai();

$reqId = httpFilterPost("reqId");
$reqPeriode = httpFilterPost("reqPeriode");

/* LOGIN CHECK 
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
*/

$lain_kondisi_pegawai->setField("LAIN_KONDISI_PEGAWAI_ID", $reqId);
$lain_kondisi_pegawai->setField("BULAN_AKHIR_BAYAR", $reqPeriode);
$lain_kondisi_pegawai->updateSetLunasPeriode();
	
echo "Tanggungan telah dilunasi.";
?>