<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/Premi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$premi = new Premi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqDepartemen = httpFilterPost("reqDepartemen");
$reqKapalJenis = httpFilterPost("reqKapalJenis");
$reqJabatan = httpFilterPost("reqJabatan");
$reqProduksiNormal = httpFilterPost("reqProduksiNormal");
$reqProduksiMaksimal = httpFilterPost("reqProduksiMaksimal");
$reqIntervalProduksi = httpFilterPost("reqIntervalProduksi");
$reqTarifNormal = httpFilterPost("reqTarifNormal");
$reqTarifMaksimal = httpFilterPost("reqTarifMaksimal");

if($reqMode == "insert")
{
	$premi->setField("LOKASI_ID", $reqLokasi);
	$premi->setField("KAPAL_JENIS_ID", $reqKapalJenis);
	$premi->setField("KRU_JABATAN_ID", $reqJabatan);
	$premi->setField("PRODUKSI_NORMAL", $reqProduksiNormal);
	$premi->setField("PRODUKSI_MAKSIMAL", $reqProduksiMaksimal);
	$premi->setField("INTERVAL_PRODUKSI", $reqIntervalProduksi);
	$premi->setField("TARIF_NORMAL", dotToNo($reqTarifNormal));
	$premi->setField("TARIF_MAKSIMAL", dotToNo($reqTarifMaksimal));
	
	if($premi->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$premi->setField("PREMI_ID", $reqId);
	$premi->setField("LOKASI_ID", $reqLokasi);
	$premi->setField("KAPAL_JENIS_ID", $reqKapalJenis);
	$premi->setField("KRU_JABATAN_ID", $reqJabatan);
	$premi->setField("PRODUKSI_NORMAL", $reqProduksiNormal);
	$premi->setField("PRODUKSI_MAKSIMAL", $reqProduksiMaksimal);
	$premi->setField("INTERVAL_PRODUKSI", $reqIntervalProduksi);
	$premi->setField("TARIF_NORMAL", dotToNo($reqTarifNormal));
	$premi->setField("TARIF_MAKSIMAL", dotToNo($reqTarifMaksimal));
	
	if($premi->update())
		echo "Data berhasil disimpan.";
	
}
?>