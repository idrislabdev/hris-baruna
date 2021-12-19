<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$cuti_tahunan = new CutiTahunan();
$cuti_tahunan_detil = new CutiTahunanDetil();
$pegawai_jabatan = new PegawaiJabatan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqPegawaiId = httpFilterPost("reqPegawaiId");
$reqJenisPegawaiId = httpFilterPost("reqJenisPegawaiId");
$reqLamaCuti = httpFilterPost("reqLamaCuti");
$reqTanggal = httpFilterPost("reqTanggal");
$reqTanggalAwal = httpFilterPost("reqTanggalAwal");
$reqTanggalAkhir = httpFilterPost("reqTanggalAkhir");
$reqPeriode = httpFilterPost("reqPeriode");
				

if($reqMode == "insert")
{
	$cuti_tahunan->setField('PEGAWAI_ID', $reqPegawaiId);
	$cuti_tahunan->setField('JENIS_PEGAWAI_ID', $reqJenisPegawaiId);
	$cuti_tahunan->setField('PERIODE', $reqPeriode);
	$cuti_tahunan->setField('LAMA_CUTI', $reqLamaCuti);
	$cuti_tahunan->setField('TANGGAL', dateToDBCheck($reqTanggal));
	$cuti_tahunan->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
	$cuti_tahunan->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
	if ($cuti_tahunan->insert())
	{
/*		$pegawai_jabatan->selectByParamsPegawaiJabatanOperasional(array("A.PEGAWAI_ID" => $reqPegawaiId));
		$pegawai_jabatan->firstRow();
		
		if($pegawai_jabatan->getField("KELOMPOK") == "D")
		{
			$cuti_tahunan_detil->setField("CUTI_TAHUNAN_ID", $cuti_tahunan->id);
			$cuti_tahunan_detil->insertDetil();
		}*/
	
		echo $cuti_tahunan->id."-Data berhasil disimpan.";
	}
}
else
{
	$cuti_tahunan->setField('PEGAWAI_ID', $reqPegawaiId);
	$cuti_tahunan->setField('JENIS_PEGAWAI_ID', $reqJenisPegawaiId);
	$cuti_tahunan->setField('PERIODE', date('Y'));
	$cuti_tahunan->setField('LAMA_CUTI', $reqLamaCuti);
	$cuti_tahunan->setField('TANGGAL', dateToDBCheck($reqTanggal));
	$cuti_tahunan->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
	$cuti_tahunan->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
	$cuti_tahunan->setField('CUTI_TAHUNAN_ID', $reqId);
	
	if ($cuti_tahunan->update())
		echo $cuti_tahunan->id."-Data berhasil disimpan.";
	//echo $cuti_tahunan->query;

}
?>