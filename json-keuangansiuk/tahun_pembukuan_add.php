<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBuku.php");


$nota_penomoran = new KbbrThnBuku();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqTahun= httpFilterPost("reqTahun");
$reqNama= httpFilterPost("reqNama");
$reqProgramNama= httpFilterPost("reqProgramNama");

$reqKodeCabang= '96';
$reqStatusClosing= 'O';
$reqKaliKlosing= '';

if($reqMode == "insert")
{   
	$nota_penomoran->setField("THN_BUKU", $reqTahun);
	$nota_penomoran->setField("NM_THN_BUKU", $reqNama);
	$nota_penomoran->setField("STATUS_CLOSING", $reqStatusClosing);
	$nota_penomoran->setField("KALI_CLOSING", $reqKaliKlosing);
	
	$nota_penomoran->setField("KD_CABANG", $reqKodeCabang);
	$nota_penomoran->setField("PROGRAM_NAME", $reqProgramNama);
	$nota_penomoran->setField("LAST_UPDATED_BY", $userLogin->nama);
	$nota_penomoran->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($nota_penomoran->insert())
		echo "Data berhasil disimpan.";
}
else
{   
	$nota_penomoran->setField('THN_BUKU_TEMP', $reqId); 
	$nota_penomoran->setField("THN_BUKU", $reqTahun);
	$nota_penomoran->setField("NM_THN_BUKU", $reqNama);
	
	$nota_penomoran->setField("LAST_UPDATED_BY", $userLogin->nama);
	$nota_penomoran->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($nota_penomoran->update())
		echo "Data berhasil disimpan.";
	
}
?>