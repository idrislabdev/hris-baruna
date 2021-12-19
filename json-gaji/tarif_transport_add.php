<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/TarifTransport.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$tarif_transport = new TarifTransport();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqJenisPegawai = httpFilterPost("reqJenisPegawai");
$reqDepartemenId = httpFilterPost("reqDepartemenId");
$reqNilai = httpFilterPost("reqNilai");

if($reqMode == "insert")
{
	$tarif_transport->setField("JENIS_PEGAWAI_ID", $reqJenisPegawai);
	$tarif_transport->setField("DEPARTEMEN_ID", $reqDepartemenId);
	$tarif_transport->setField("NILAI", dotToNo($reqNilai));
	// echo $reqJenisPegawai;exit();
	
	if($tarif_transport->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$tarif_transport->setField("TARIF_TRANSPORT_ID", $reqId);
	$tarif_transport->setField("JENIS_PEGAWAI_ID ", $reqJenisPegawai);
	$tarif_transport->setField("DEPARTEMEN_ID", $reqDepartemenId);
	$tarif_transport->setField("NILAI", dotToNo($reqNilai));
	
	if($tarif_transport->update())
		echo "Data berhasil disimpan.";
	
}
?>