<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$pegawai_jenis_pegawai = new PegawaiJenisPegawai();

$reqId = httpFilterGet("reqId");

/* LOGIN CHECK 
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
*/

$pegawai_jenis_pegawai->selectByParamsPegawaiJenisPegawaiTerakhir(array('PEGAWAI_ID'=>$reqId));
$pegawai_jenis_pegawai->firstRow();

$arrFinal = array("reqId" => $reqId, "jenis_pegawai_id" => $pegawai_jenis_pegawai->getField('JENIS_PEGAWAI_ID'));
echo json_encode($arrFinal);
?>