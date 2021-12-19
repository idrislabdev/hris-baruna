<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrNoNota.php");

$nota_penomoran = new KbbrNoNota();

$reqId = httpFilterPost("reqId");
$reqRowId= httpFilterPost("reqRowId");
$reqMode = httpFilterPost("reqMode");
$reqKode= httpFilterPost("reqKode");
$reqNama= httpFilterPost("reqNama");
$reqPeriode= httpFilterPost("reqPeriode");
$reqAwalan= httpFilterPost("reqAwalan");
$reqNoStart= httpFilterPost("reqNoStart");
$reqNoStop= httpFilterPost("reqNoStop");
$reqNoDipakai= httpFilterPost("reqNoDipakai");
$reqStatus= httpFilterPost("reqStatus");
$reqKodeCabang= httpFilterPost("reqKodeCabang");
$reqProgramNama= httpFilterPost("reqProgramNama");

if($reqMode == "insert")
{   
	$nota_penomoran->setField("KD_BUKTI", $reqKode);
	$nota_penomoran->setField("KET_BUKTI", $reqNama);
	$nota_penomoran->setField("KD_PERIODE", $reqPeriode);
	$nota_penomoran->setField("AWALAN", $reqAwalan);
	$nota_penomoran->setField("NO_START", $reqNoStart);
	$nota_penomoran->setField("NO_STOP", $reqNoStop);
	$nota_penomoran->setField("NO_DIPAKAI", $reqNoDipakai);
	$nota_penomoran->setField("KD_AKTIF", $reqStatus);
	$nota_penomoran->setField("KD_CABANG", $reqKodeCabang);
	$nota_penomoran->setField("PROGRAM_NAME", $reqProgramNama);
	$nota_penomoran->setField("LAST_UPDATED_BY", $userLogin->nama);
	$nota_penomoran->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($nota_penomoran->insert())
		echo "Data berhasil disimpan.";
}
else
{   
	$nota_penomoran->setField('KD_BUKTI_TEMP', $reqId); 
	$nota_penomoran->setField('KD_PERIODE_TEMP', $reqRowId); 
	$nota_penomoran->setField("KD_BUKTI", $reqKode);
	$nota_penomoran->setField("KET_BUKTI", $reqNama);
	$nota_penomoran->setField("KD_PERIODE", $reqPeriode);
	$nota_penomoran->setField("AWALAN", $reqAwalan);
	$nota_penomoran->setField("NO_START", $reqNoStart);
	$nota_penomoran->setField("NO_STOP", $reqNoStop);
	$nota_penomoran->setField("NO_DIPAKAI", $reqNoDipakai);
	$nota_penomoran->setField("KD_AKTIF", $reqStatus);
	$nota_penomoran->setField("LAST_UPDATED_BY", $userLogin->nama);
	$nota_penomoran->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($nota_penomoran->update())
		echo "Data berhasil disimpan.";
	
}
?>