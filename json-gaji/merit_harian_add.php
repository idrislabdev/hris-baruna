<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/MeritHarian.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$merit_harian = new MeritHarian();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqJenisLokasi = httpFilterPost("reqJenisLokasi");
$reqMinggu = httpFilterPost("reqMinggu");
$reqBulan = httpFilterPost("reqBulan");
$reqNilai = httpFilterPost("reqNilai");
$reqMax = httpFilterPost("reqMax");

if($reqMode == "insert")
{
	$merit_harian->setField("JENIS_LOKASI", $reqJenisLokasi);
	$merit_harian->setField("MINGGU", dotToNo($reqMinggu));
	$merit_harian->setField("BULAN", dotToNo($reqBulan));
	$merit_harian->setField("NILAI", dotToNo($reqNilai));
	$merit_harian->setField("MAX", dotToNo($reqMax));
	$merit_harian->setField("LAST_CREATE_USER", $userLogin->nama);
	$merit_harian->setField("LAST_CREATE_DATE", "SYSDATE");	
	
	if($merit_harian->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$merit_harian->setField("MERIT_HARIAN_ID", $reqId);
	$merit_harian->setField("JENIS_LOKASI", $reqJenisLokasi);
	$merit_harian->setField("MINGGU", dotToNo($reqMinggu));
	$merit_harian->setField("BULAN", dotToNo($reqBulan));
	$merit_harian->setField("NILAI", dotToNo($reqNilai));
	$merit_harian->setField("MAX", dotToNo($reqMax));
	$merit_harian->setField("LAST_UPDATE_USER", $userLogin->nama);
	$merit_harian->setField("LAST_UPDATE_DATE", "SYSDATE");
	
	if($merit_harian->update())
		echo "Data berhasil disimpan.";
	
}
?>