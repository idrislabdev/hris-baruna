<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/TunjanganJabatan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$tunjangan_jabatan = new TunjanganJabatan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqJabatan = httpFilterPost("reqJabatan");
$reqJumlah = httpFilterPost("reqJumlah");
$reqJenisPegawai = httpFilterPost("reqJenisPegawai");
$reqKelas = httpFilterPost("reqKelas");

if($reqMode == "insert")
{
	$tunjangan_jabatan->setField('JABATAN_ID', $reqJabatan);
	$tunjangan_jabatan->setField('KELAS', $reqKelas);
	$tunjangan_jabatan->setField("JUMLAH", dotToNo($reqJumlah));
	$tunjangan_jabatan->setField("JENIS_PEGAWAI_ID", $reqJenisPegawai);
	
	if($tunjangan_jabatan->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$tunjangan_jabatan->setField("TUNJANGAN_JABATAN_ID", $reqId);
	$tunjangan_jabatan->setField('JABATAN_ID', $reqJabatan);
	$tunjangan_jabatan->setField('KELAS', $reqKelas);
	$tunjangan_jabatan->setField("JUMLAH", dotToNo($reqJumlah));
	$tunjangan_jabatan->setField("JENIS_PEGAWAI_ID", $reqJenisPegawai);
	
	if($tunjangan_jabatan->update())
		echo "Data berhasil disimpan.";
	
}
?>