<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Bank.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$bank = new Bank();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= httpFilterPost("reqNama");
$reqAlamat= httpFilterPost("reqAlamat");
$reqKota= httpFilterPost("reqKota");
$reqKodeBukuBesar = httpFilterPost("reqKodeBukuBesar");

if($reqMode == "insert")
{
	$bank->setField('NAMA', $reqNama);
	$bank->setField('ALAMAT', $reqAlamat);
	$bank->setField('KOTA', $reqKota);
	$bank->setField("LAST_CREATE_USER", $userLogin->nama);
	$bank->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	$bank->setField("KODE_BUKU_BESAR", $reqKodeBukuBesar);	
	if($bank->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$bank->setField('BANK_ID', $reqId); 
	$bank->setField('NAMA', $reqNama);
	$bank->setField('ALAMAT', $reqAlamat);
	$bank->setField('KOTA', $reqKota);
	$bank->setField("LAST_UPDATE_USER", $userLogin->nama);
	$bank->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	$bank->setField("KODE_BUKU_BESAR", $reqKodeBukuBesar);	
	if($bank->update())
		echo "Data berhasil disimpan.";
	
}
?>