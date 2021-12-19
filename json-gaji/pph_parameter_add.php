<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/PerhitunganPph.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$perhitungan_pph = new PerhitunganPph();

$reqJenisPegawaiId = httpFilterPost("reqJenisPegawaiId");
$reqKelas = httpFilterPost("reqKelas");
$reqJenisPenghasilan = httpFilterPost("reqJenisPenghasilan");
$reqJenisPerhitungan = httpFilterPost("reqJenisPerhitungan");
$reqJumlah = httpFilterPost("reqJumlah");
$reqMode = httpFilterPost("reqMode");
$reqProsentaseNpwp = httpFilterPost("reqProsentaseNpwp");
$reqJumlahNPWP = httpFilterPost("reqNilaiNpwp");
$reqProsentaseTanpaNpwp = httpFilterPost("reqProsentaseTanpaNpwp");
$reqJumlahTanpaNPWP = httpFilterPost("reqNilaiTanpaNpwp");

$reqId = httpFilterPost("reqId");

$arrProsentaseNPWP = explode("/", $reqProsentaseNpwp);
$arrProsentaseTanpaNPWP = explode("/", $reqProsentaseTanpaNpwp);

$perhitungan_pph->setField("JENIS_PENGHASILAN", $reqJenisPenghasilan);
$perhitungan_pph->setField("KELAS", $reqKelas);
$perhitungan_pph->setField("JENIS_PEGAWAI_ID", $reqJenisPegawaiId);
$perhitungan_pph->setField("JENIS_PERHITUNGAN", $reqJenisPerhitungan);	
if($reqJenisPerhitungan == "PROSENTASE"){
	//$reqJumlahNPWP = $arrProsentaseNPWP[0] / $arrProsentaseNPWP[1];
	//$reqJumlahTanpaNPWP = $arrProsentaseTanpaNPWP[0] / $arrProsentaseTanpaNPWP[1];
	$perhitungan_pph->setField("JUMLAH", $reqJumlah);
	$perhitungan_pph->setField("PROSENTASE_NPWP", $reqProsentaseNpwp);
	$perhitungan_pph->setField("PROSENTASE_TANPA_NPWP", $reqProsentaseTanpaNpwp);
	$perhitungan_pph->setField("JUMLAH_NPWP", $reqJumlahNPWP);
	$perhitungan_pph->setField("JUMLAH_TANPA_NPWP", $reqJumlahTanpaNPWP);
}
$perhitungan_pph->setField("PERHITUNGAN_PPH_ID", $reqId);

if($reqId == "")
{
	if($perhitungan_pph->insert())
		echo "Data berhasil disimpan.";
}
else
{
	if($perhitungan_pph->update())
		echo "Data berhasil disimpan.";	
}

?>