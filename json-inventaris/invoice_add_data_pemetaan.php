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
$inventaris_penanggung_jawab = new InventarisPenanggungJawab();
$inventaris_lokasi_histori = new InventarisLokasiHistori();

$reqId = httpFilterPost("reqId");

$reqInventarisId = $_POST["reqInventarisId"];
$reqLokasi = $_POST["reqLokasi"];
$reqPenanggungJawab = $_POST["reqPenanggungJawab"];
$reqTMT = $_POST["reqTMT"];
$reqInventarisRuanganId = $_POST["reqInventarisRuanganId"];
$reqInventaris = $_POST["reqInventaris"];
$reqTahun = $_POST["reqTahun"];
$reqLokasiLama = $_POST["reqLokasiLama"];
$reqPenanggungJawabLama = $_POST["reqPenanggungJawabLama"];

for($i=0;$i<count($reqInventarisRuanganId);$i++)
{
	if($reqLokasi[$i] == $reqLokasiLama[$i])
	{}
	else
	{
		$inventaris_ruangan = new InventarisRuangan();		
		$inventaris_ruangan_nomor = new InventarisRuangan();
		$inventaris_ruangan_barcode = new InventarisRuangan();
		$inventaris_ruangan->setField("INVENTARIS_RUANGAN_ID", $reqInventarisRuanganId[$i]);
		$inventaris_ruangan->setField("LOKASI_ID", $reqLokasi[$i]);
		$inventaris_ruangan->setField("LAST_UPDATE_USER", $userLogin->nama);
		$inventaris_ruangan->setField("NOMOR", $inventaris_ruangan_nomor->getNomorInventaris($reqInventarisId[$i], $reqLokasi[$i], $reqTahun[$i]));
		$inventaris_ruangan->setField("BARCODE", $inventaris_ruangan_barcode->getBarcodeInventaris($reqInventarisId[$i], $reqLokasi[$i], $reqTahun[$i]));
		$inventaris_ruangan->updatePendataanLokasi();
		unset($inventaris_ruangan);
		unset($inventaris_ruangan_nomor);
		unset($inventaris_ruangan_barcode);
	
		$inventaris_lokasi_histori = new InventarisLokasiHistori();
		$inventaris_lokasi_histori->setField("INVENTARIS_RUANGAN_ID", $reqInventarisRuanganId[$i]);
		$inventaris_lokasi_histori->setField("TMT", dateToDBCheck($reqTMT[$i]));
		$inventaris_lokasi_histori->setField("LAST_CREATE_USER", $userLogin->nama);
		$inventaris_lokasi_histori->insertLokasiPindah();
		unset($inventaris_lokasi_histori);	
	}

	if($reqPenanggungJawab[$i] == $reqPenanggungJawabLama[$i])
	{}
	else
	{	
		$inventaris_penanggung_jawab = new InventarisPenanggungJawab();
		$inventaris_penanggung_jawab->setField("INVENTARIS_RUANGAN_ID", $reqInventarisRuanganId[$i]);
		$inventaris_penanggung_jawab->setField("PEGAWAI_ID", $reqPenanggungJawab[$i]);
		$inventaris_penanggung_jawab->setField("LOKASI_ID", $reqLokasi[$i]);
		$inventaris_penanggung_jawab->setField("TMT", dateToDBCheck($reqTMT[$i]));
		$inventaris_penanggung_jawab->insert();
		echo $inventaris_penanggung_jawab->query;
		unset($inventaris_penanggung_jawab);	
	}
	
}

//echo $reqId."-Data berhasil disimpan.";
?>