<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$inventaris_ruangan = new InventarisRuangan();

$reqId = httpFilterPost("reqId");
$reqRowId = httpFilterPost("reqRowId");
$reqMode = httpFilterPost("reqMode");
$reqNomor = httpFilterPost("reqNomor");
$reqPerolehanHarga= httpFilterPost("reqPerolehanHarga");
$reqKondisiFisikProsentase= httpFilterPost("reqKondisiFisikProsentase");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqPerolehan= httpFilterPost("reqPerolehan");

if($reqMode == "insert")
{
	/*$inventaris_ruangan->setField("PEROLEHAN_HARGA", $reqPerolehanHarga);
	$inventaris_ruangan->setField("KETERANGAN", $reqKeterangan);
	$inventaris_ruangan->setField("NOMOR", $reqNomor);
	$inventaris_ruangan->setField("KONDISI_FISIK_PROSENTASE", $reqKondisiFisikProsentase);
	
	if($inventaris_ruangan->insert())
		echo "Data berhasil disimpan.";*/
}
else
{
	$reqTahun= substr($reqPerolehan,2,4);
	$inventaris_ruangan->setField("PEROLEHAN_TAHUN", $reqTahun);
	$inventaris_ruangan->setField("PEROLEHAN_PERIODE", $reqPerolehan);
	$inventaris_ruangan->setField("INVENTARIS_RUANGAN_ID", $reqRowId);
	$inventaris_ruangan->setField('PEROLEHAN_HARGA', dotToNo($reqPerolehanHarga));
	$inventaris_ruangan->setField("KETERANGAN", $reqKeterangan);
	$inventaris_ruangan->setField("NOMOR", $reqNomor);
	$inventaris_ruangan->setField("KONDISI_FISIK_PROSENTASE", $reqKondisiFisikProsentase);
	
	
	if($inventaris_ruangan->updatePendataanDetil())
		echo "Data berhasil disimpan.";
	
}
?>