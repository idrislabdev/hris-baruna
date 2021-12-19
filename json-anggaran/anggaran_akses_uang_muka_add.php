<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranAkses.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_akses = new AnggaranAkses();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqTahun = httpFilterPost("reqTahun");
$reqSubBantu = httpFilterPost("reqSubBantu");

$reqKdBukuBesar = $_POST["reqKdBukuBesar"];
$reqBukuBesarJrr = $_POST["reqBukuBesarJrr"];

$anggaran_akses->setField("KD_SUB_BANTU", $reqSubBantu);
$anggaran_akses->deleteSubBantu();


for($i=0;$i<count($reqKdBukuBesar);$i++)
{
	if($reqKdBukuBesar[$i] == "")
	{}
	else
	{
		$anggaran_akses = new AnggaranAkses();
		$anggaran_akses->setField("DEPARTEMEN_ID", $reqId);
		$anggaran_akses->setField("KD_BUKU_PUSAT", "000.00.00");
		$anggaran_akses->setField("KD_BUKU_BESAR", $reqKdBukuBesar[$i]);
		$anggaran_akses->setField("KD_BUKU_BESAR_JRR", $reqBukuBesarJrr[$i]);
		$anggaran_akses->setField("TAHUN", $reqTahun);
		$anggaran_akses->setField("KD_SUB_BANTU", $reqSubBantu);
		$anggaran_akses->insert();
		unset($anggaran_akses);
	}
}

echo "Data berhasil disimpan.";

?>