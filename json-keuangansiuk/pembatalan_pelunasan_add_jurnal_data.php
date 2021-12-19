<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/BadanUsaha.php");

$badan_usaha = new BadanUsaha();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBukti= httpFilterPost("reqNoBukti");
$reqKodeKusto= httpFilterPost("reqKodeKusto");
$reqKusto= httpFilterPost("reqKusto");
$reqTipeTransaksi= httpFilterPost("reqTipeTransaksi");
$reqKodeValuta= httpFilterPost("reqKodeValuta");
$reqNilaiTransaksi= httpFilterPost("reqNilaiTransaksi");
$reqNoRef= httpFilterPost("reqNoRef");
$reqNoPosting= httpFilterPost("reqNoPosting");


$badan_usaha->setField("", $reqNoBukti);
$badan_usaha->setField("", $reqKodeKusto);
$badan_usaha->setField("", $reqKusto);
$badan_usaha->setField("", $reqTipeTransaksi);
$badan_usaha->setField("", $reqKodeValuta);
$badan_usaha->setField("", $reqNilaiTransaksi);
$badan_usaha->setField("", $reqNoRef);
$badan_usaha->setField("", $reqNoPosting);

if($reqMode == "insert")
{		
	if($badan_usaha->insert())
		echo "Data berhasil disimpan.";
}
else
{		
	if($badan_usaha->update())
		echo "Data berhasil disimpan.";
			
}
?>