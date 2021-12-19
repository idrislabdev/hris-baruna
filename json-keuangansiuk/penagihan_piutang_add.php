<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/PenagihanPiutang.php");


$penagihan = new PenagihanPiutang();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqNoPelanggan= httpFilterPost("reqNoPelanggan");
$reqJumlahPiutang= httpFilterPost("reqJumlahPiutang");
$reqTanggalPenagihan= httpFilterPost("reqTglTagih");
$reqMedia= httpFilterPost("reqMedia");
$reqKet= httpFilterPost("reqKet");
$reqTanggalPenagihanBerikut= httpFilterPost("reqTglTagihB");

$reqAlamatPenagihan= httpFilterPost("reqAlamatPenagihan");
$reqKontakPerson= httpFilterPost("reqKontakPerson");
$reqTanggapan= httpFilterPost("reqTanggapan");

if($reqMode <> "")
{	
	$penagihan->setField("KODE", $reqId);
	$penagihan->setField("MPLG_KODE", $reqNoPelanggan);
	$penagihan->setField("JUMLAH_PIUTANG", dotToNo($reqJumlahPiutang));
	$penagihan->setField("TGL_TAGIH", $reqTanggalPenagihan);
	$penagihan->setField("MEDIA", $reqMedia);
	$penagihan->setField("KETERANGAN", $reqKet);
	$penagihan->setField("TGL_TAGIH_BERIKUT", $reqTanggalPenagihanBerikut);
	$penagihan->setField("ALAMAT_PENAGIHAN", $reqAlamatPenagihan);
	$penagihan->setField("KONTAK_PERSON", $reqKontakPerson);
	$penagihan->setField("TANGGAPAN", $reqTanggapan);
	
	if($reqMode=="insert") {
		$penagihan->setField("CREATED_BY", $userLogin->nama);
		$penagihan->insert();	
	} elseif($reqMode == "update") {
		$penagihan->setField("UPDATED_BY", $userLogin->nama);
		$penagihan->update();
	}
	//echo $penagihan->query;
		echo "Data berhasil disimpan.";
	
	//echo $penagihan->query;
}
?>