<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiDetil.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId= $_POST["reqRowId"];
$reqStatusVerifikasi= $_POST["reqStatusVerifikasi"];
$reqArrayIndex= $_POST["reqArrayIndex"];

$set_loop= $reqArrayIndex;
if($reqMode == "update")
{
	for($i=0;$i<=$set_loop;$i++)
	{
		if($reqRowId[$i] == "")
		{}
		else
		{
			$anggaran_mutasi_detil = new AnggaranMutasiDetil();
			$anggaran_mutasi_detil->setField('ANGGARAN_MUTASI_DETIL_ID', $reqRowId[$i]);
			$anggaran_mutasi_detil->setField('STATUS_VERIFIKASI', setChecked($reqStatusVerifikasi[$i], 1, 2));
			
			$anggaran_mutasi_detil->updateStatus();
			unset($anggaran_mutasi_detil);
		}
	}
	
	echo $reqId."-Data berhasil disimpan.";
	//echo $reqId."-".$reqRowId[1]."&".$reqStatusVerifikasi[1];
}
?>