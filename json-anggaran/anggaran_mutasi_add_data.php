<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_mutasi = new AnggaranMutasi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqPeriode= httpFilterPost("reqPeriode");
$reqIdAnggaran = httpFilterPost("reqIdAnggaran");
$reqBukuPusat = httpFilterPost("reqBukuPusat");
$reqBukuBesar =  httpFilterPost("reqBukuBesar");
$reqTanggal = httpFilterPost("reqTanggal");
$reqJumlah = httpFilterPost("reqJumlah");
$reqPph = httpFilterPost("reqPph");
$reqStatusVerifikasi = httpFilterPost("reqStatusVerifikasi");


if($reqMode == "insert")
{		
	$anggaran_mutasi->setField("TANGGAL", dateToDBCheck($reqTanggal));
	$anggaran_mutasi->setField("ANGGARAN_ID", $reqIdAnggaran);
	$anggaran_mutasi->setField("PERIODE", $reqPeriode);
	$anggaran_mutasi->setField("JUMLAH", dotToNo($reqJumlah));
	$anggaran_mutasi->setField("PPH", dotToNo($reqPph));
	$anggaran_mutasi->setField("TOTAL", "");
	$anggaran_mutasi->setField("STATUS_VERIFIKASI", "0");		
	
	if($anggaran_mutasi->insert())
	{
		$id=$anggaran_mutasi->id;
		echo $id."-Data berhasil disimpan.";
	}
	//echo $anggaran_mutasi->query;
}
else
{
	$id=$reqId;		
	$anggaran_mutasi->setField("TANGGAL", dateToDBCheck($reqTanggal));
	$anggaran_mutasi->setField("ANGGARAN_ID", $reqIdAnggaran);
	$anggaran_mutasi->setField("PERIODE", $reqPeriode);
	$anggaran_mutasi->setField("JUMLAH", dotToNo($reqJumlah));
	$anggaran_mutasi->setField("PPH", dotToNo($reqPph));
	$anggaran_mutasi->setField("TOTAL", "");
	$anggaran_mutasi->setField("STATUS_VERIFIKASI", "0");		
	$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);
	

	if($anggaran_mutasi->update())
		echo $id."-Data berhasil disimpan.";
	
	//echo $anggaran_mutasi->query;
}
?>