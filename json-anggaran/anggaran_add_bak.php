<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/Anggaran.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran = new Anggaran();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqTahunBuku= httpFilterPost("reqTahunBuku");
$reqKodeBukuPusat= httpFilterPost("reqKodeBukuPusat");
$reqKodeSubBantu= httpFilterPost("reqKodeSubBantu");
$reqKodeBukuBesar= httpFilterPost("reqKodeBukuBesar");
$reqKodeValuta= httpFilterPost("reqKodeValuta");
$reqJumlah= httpFilterPost("reqJumlah");
$reqJumlahTriwulan1= httpFilterPost("reqJumlahTriwulan1");
$reqJumlahTriwulan3= httpFilterPost("reqJumlahTriwulan3");
$reqJumlahTriwulan2= httpFilterPost("reqJumlahTriwulan2");
$reqJumlahTriwulan4= httpFilterPost("reqJumlahTriwulan4");

$anggaran->setField("TAHUN_BUKU", $reqTahunBuku);
$anggaran->setField("KD_BUKU_PUSAT", $reqKodeBukuPusat);
$anggaran->setField("KD_SUB_BANTU", $reqKodeSubBantu);
$anggaran->setField("KD_BUKU_BESAR", $reqKodeBukuBesar);
$anggaran->setField("KD_VALUTA", $reqKodeValuta);
$anggaran->setField("JUMLAH", dotToNo($reqJumlah));
$anggaran->setField("JUMLAH_TRIWULAN1", dotToNo($reqJumlahTriwulan1));
$anggaran->setField("JUMLAH_TRIWULAN2", dotToNo($reqJumlahTriwulan3));
$anggaran->setField("JUMLAH_TRIWULAN3", dotToNo($reqJumlahTriwulan2));
$anggaran->setField("JUMLAH_TRIWULAN4", dotToNo($reqJumlahTriwulan4));

if($reqMode == "insert")
{	
	if($anggaran->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$anggaran->setField("ANGGARAN_ID", $reqId);
	if($anggaran->update())
		echo "Data berhasil disimpan.";
}
?>