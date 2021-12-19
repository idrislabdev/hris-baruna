<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisPenanggungJawab.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisLokasiHistori.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$inventaris_ruangan = new InventarisRuangan();
$inventaris_ruangan_nomor = new InventarisRuangan();
$inventaris_ruangan_barcode = new InventarisRuangan();

$reqId = httpFilterPost("reqId");
$reqLokasiBaru= httpFilterPost("reqLokasiBaru");
$reqPenanggungJawab= httpFilterPost("reqPenanggungJawab");
$reqTMT= httpFilterPost("reqTMT");

$inventaris_ruangan->setField("INVENTARIS_RUANGAN_ID", $reqId);
$inventaris_ruangan->setField("LOKASI_ID", $reqLokasiBaru);
$inventaris_ruangan->setField("LAST_UPDATE_USER", $userLogin->nama);
$inventaris_ruangan->setField("NOMOR", $inventaris_ruangan_nomor->getNomorInventaris($reqInventaris, $reqLokasiBaru, $reqTahun));
$inventaris_ruangan->setField("BARCODE", $inventaris_ruangan_barcode->getBarcodeInventaris($reqInventaris, $reqLokasiBaru, $reqTahun));
		
if($inventaris_ruangan->updatePendataanLokasi())
{
	$inventaris_penanggung_jawab = new InventarisPenanggungJawab();
	$inventaris_penanggung_jawab->setField("INVENTARIS_RUANGAN_ID", ValToNullDB($reqId));
	$inventaris_penanggung_jawab->setField("PEGAWAI_ID", ValToNullDB($reqPenanggungJawab));
	$inventaris_penanggung_jawab->setField("LOKASI_ID", $reqLokasiBaru);
	$inventaris_penanggung_jawab->setField("TMT", dateToDBCheck($reqTMT));
	$inventaris_penanggung_jawab->insert();
	unset($inventaris_penanggung_jawab);	
	
	$inventaris_lokasi_histori = new InventarisLokasiHistori();
	$inventaris_lokasi_histori->setField("INVENTARIS_RUANGAN_ID", $reqId);
	$inventaris_lokasi_histori->setField("LAST_CREATE_USER", $userLogin->nama);
	$inventaris_lokasi_histori->setField("TMT", dateToDBCheck($reqTMT));
	$inventaris_lokasi_histori->insertLokasiPindah();
	
}

echo "Data berhasil disimpan";
				   
?>