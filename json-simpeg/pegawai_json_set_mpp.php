<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$pegawai = new Pegawai();

$reqId = httpFilterGet("reqId");
$reqNilai = httpFilterGet("reqNilai");

/* LOGIN CHECK 
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
*/
	$pegawai->setField('PEGAWAI_ID', $reqId);
	$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$pegawai->updateStatusMPP();
	
	if($pegawai->updateStatusMPP())
	{
		$alertMsg .= "Data berhasil diubah";
	}
	else
		$alertMsg .= "Error ".$pegawai->getErrorMsg();
?>