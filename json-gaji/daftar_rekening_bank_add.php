<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/DaftarRekeningBank.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$bank = new DaftarRekeningBank();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqJenisRekening = httpFilterPost("reqJenisRekening");
$reqRefId = httpFilterPost("reqRefId");
$reqBankId = httpFilterPost("reqBankId");
$reqNamaRekening = httpFilterPost("reqNamaRekening");
$reqNoRekening = httpFilterPost("reqNoRekening");

if($reqMode == "insert")
{
	$bank->setField("JENIS_REKENING", $reqJenisRekening);
	$bank->setField("REF_ID", $reqRefId);
	$bank->setField("BANK_ID", $reqBankId);
	$bank->setField("NAMA_REKENING", $reqNamaRekening);
	$bank->setField("NO_REKENING", $reqNoRekening);
	
	if($bank->insert())
		echo "Data berhasil disimpan.";
}
else
{
	
	$bank->setField("JENIS_REKENING", $reqJenisRekening);
	$bank->setField("REF_ID", $reqRefId);
	$bank->setField("BANK_ID", $reqBankId);
	$bank->setField("NAMA_REKENING", $reqNamaRekening);
	$bank->setField("NO_REKENING", $reqNoRekening);
	
	if($bank->update())
		echo "Data berhasil disimpan.";
	
}
?>