<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/TunjanganMengajar.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$tunjangan_mengajar = new TunjanganMengajar();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqMenagajar = httpFilterPost("reqMenagajar");
$reqPeriode = httpFilterPost("reqPeriode");
$reqJumlahIntra = httpFilterPost("reqJumlahIntra");
$reqJumlahEskul = httpFilterPost("reqJumlahEskul");
$reqJumlahLebih = httpFilterPost("reqJumlahLebih");

if($reqMode == "insert")
{
	$tunjangan_mengajar->setField('PEGAWAI_ID', $reqMenagajar);
	$tunjangan_mengajar->setField('PERIODE', $reqPeriode);	
	$tunjangan_mengajar->setField('KELOMPOK_PEGAWAI', $reqKelas);
	$tunjangan_mengajar->setField("KELOMPOK_PENDIDIK", $reqJenisPegawai);
	$tunjangan_mengajar->setField("JUMLAH_JAM_INTRA", dotToNo($reqJumlahIntra));
	$tunjangan_mengajar->setField("JUMLAH_JAM_EKSUL", dotToNo($reqJumlahEskul));
	$tunjangan_mengajar->setField("JUMLAH_JAM_LEBIH", dotToNo($reqJumlahLebih));
	
	if($tunjangan_mengajar->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$tunjangan_mengajar->setField('PEGAWAI_ID', $reqMenagajar);
	$tunjangan_mengajar->setField('PERIODE', $reqPeriode);	
	$tunjangan_mengajar->setField('KELOMPOK_PEGAWAI', $reqKelas);
	$tunjangan_mengajar->setField("KELOMPOK_PENDIDIK", $reqJenisPegawai);
	$tunjangan_mengajar->setField("JUMLAH_JAM_INTRA", dotToNo($reqJumlahIntra));
	$tunjangan_mengajar->setField("JUMLAH_JAM_EKSUL", dotToNo($reqJumlahEskul));
	$tunjangan_mengajar->setField("JUMLAH_JAM_LEBIH", dotToNo($reqJumlahLebih));
	
	if($tunjangan_jabatan->update())
		echo "Data berhasil disimpan.";
	
}
?>