<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiD.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_mutasi = new AnggaranMutasi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqValidasi = httpFilterPost("reqValidasi");
$reqValidasiAlasan = httpFilterPost("reqValidasiAlasan");
$reqJumlahUangMuka = httpFilterPost("reqJumlahUangMuka");
$reqJenisAnggaranId = httpFilterPost("reqJenisAnggaranId");
$reqJumlahPPN = httpFilterPost("reqJumlahPPN");
$reqNoNota = httpFilterPost("reqNoNota");
$reqNoRef3 = httpFilterPost("reqNoRef3");
$reqJumlahDiBayar = httpFilterPost("reqJumlahDiBayar");
$reqKetTambah = httpFilterPost("reqKetTambah");
$reqBukuBesarUm =  httpFilterPost("reqBukuBesarUm");


$reqBukuBesar = $_POST["reqBukuBesar"];
$reqKartu = $_POST["reqKartu"];
$reqBukuPusat = $_POST["reqBukuPusat"];
$reqNama = $_POST["reqNama"];
$reqKeterangan = $_POST["reqKeterangan"];
$reqUnit = $_POST["reqUnit"];
$reqHarga = $_POST["reqHarga"];
$reqPajak = $_POST["reqPajak"];
$reqJumlah = $_POST["reqJumlah"];
$reqRealisasi = $_POST["reqRealisasi"];
$reqLebihKurang = $_POST["reqLebihKurang"];
$reqNoUrut = $_POST["reqNoUrut"];

for($i=0;$i<count($reqBukuBesar);$i++)
{
	$anggaran_mutasi_d = new AnggaranMutasiD();
	$anggaran_mutasi_d->setField("ANGGARAN_MUTASI_ID", $reqId);
	$anggaran_mutasi_d->setField("NO_SEQ", $reqNoUrut[$i]);
	$anggaran_mutasi_d->setField("KD_BUKU_BESAR", $reqBukuBesar[$i]);
	$anggaran_mutasi_d->setField("KD_BUKU_PUSAT", $reqBukuPusat[$i]);
	$anggaran_mutasi_d->setField("KD_SUB_BANTU", $reqKartu[$i]);
	$anggaran_mutasi_d->setField("PAJAK", $reqPajak[$i]);
	$anggaran_mutasi_d->setField("NAMA", $reqNama[$i]);
	$anggaran_mutasi_d->updateVerifikasiRencana();
	unset($anggaran_mutasi_d);	
}

$anggaran_mutasi->setField("VERIFIKASI_ALASAN", $reqValidasiAlasan);
$anggaran_mutasi->setField("VERIFIKASI_BY", $userLogin->nama);
$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);
$anggaran_mutasi->setField("JML_VAL_PAJAK", dotToNo($reqJumlahPPN));
$anggaran_mutasi->setField("JML_VAL_TRANS", dotToNo($reqJumlahDiBayar));
$anggaran_mutasi->setField("JML_RP_TRANS", dotToNo($reqJumlahDiBayar));
$anggaran_mutasi->setField("KD_BUKU_BESAR_UM", $reqBukuBesarUm);
$anggaran_mutasi->updateStatusVerifikasiAsman();


if($reqValidasi == "S")
{

	echo $reqId."-Anggaran telah diverifikasi.";
}
else
	echo $reqId."-Anggaran telah diverifikasi.";

?>