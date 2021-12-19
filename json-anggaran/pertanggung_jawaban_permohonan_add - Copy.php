<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranKelengkapanDokumen.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiD.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_mutasi = new AnggaranMutasi();
$anggaran_mutasi_d = new AnggaranMutasiD();
$anggaran_kelengkapan_dokumen = new AnggaranKelengkapanDokumen();

$reqId = httpFilterPost("reqId");
$reqNoRef2 = httpFilterPost("reqNoRef2");
$reqKelengkapanDokumen = httpFilterPost("reqKelengkapanDokumen");

$reqBukuBesar = $_POST["reqBukuBesar"];
$reqKartu = $_POST["reqKartu"];
$reqBukuPusat = $_POST["reqBukuPusat"];
$reqNama = $_POST["reqNama"];
$reqKeterangan = $_POST["reqKeterangan"];
$reqUnit = $_POST["reqUnit"];
$reqHarga = $_POST["reqHarga"];
$reqJumlah = $_POST["reqJumlah"];
$reqRealisasi = $_POST["reqRealisasi"];
$reqLebihKurang = $_POST["reqLebihKurang"];

$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);
$anggaran_mutasi->setField("NO_REF2", $reqNoRef2);
$anggaran_mutasi->updatePertanggungjawaban();


$anggaran_kelengkapan_dokumen->setField("ANGGARAN_MUTASI_ID", $reqId);
$anggaran_kelengkapan_dokumen->delete();

$arrKelengkapanAnggaran = explode(",", $reqKelengkapanDokumen);
for($i=0;$i<count($arrKelengkapanAnggaran);$i++)
{
	$anggaran_kelengkapan_dokumen = new AnggaranKelengkapanDokumen();
	
	$anggaran_kelengkapan_dokumen->setField("ANGGARAN_MUTASI_ID", $reqId);
	$anggaran_kelengkapan_dokumen->setField("KELENGKAPAN_DOKUMEN_ID", $arrKelengkapanAnggaran[$i]);
	$anggaran_kelengkapan_dokumen->insert();
	unset($anggaran_kelengkapan_dokumen);	
}

for($i=0;$i<count($reqBukuBesar);$i++)
{
	$anggaran_mutasi_d = new AnggaranMutasiD();
	$anggaran_mutasi_d->setField("ANGGARAN_MUTASI_ID", $reqId);
	$anggaran_mutasi_d->setField("KD_BUKU_BESAR", $reqBukuBesar[$i]);
	$anggaran_mutasi_d->setField("KD_BUKU_PUSAT", $reqBukuPusat[$i]);
	$anggaran_mutasi_d->setField("REALISASI", dotToNo($reqRealisasi[$i]));
	$anggaran_mutasi_d->setField("LEBIH_KURANG", dotToNo($reqLebihKurang[$i]));
	$anggaran_mutasi_d->updateRealisasi();
	unset($anggaran_mutasi_d);	
}

echo $reqId."-Data berhasil disimpan.";	
	
?>