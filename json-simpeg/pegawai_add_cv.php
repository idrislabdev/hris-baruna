<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPengalamanKerja.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pengalaman_kerja = new PegawaiPengalamanKerja();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$nama_perusahaan= httpFilterPost("nama_perusahaan");
$jabatan= httpFilterPost("jabatan");
$masuk_kerja = httpFilterPost("mulai_bulan") . httpFilterPost("mulai_tahun");
$keluar_kerja = httpFilterPost("selesai_bulan") . httpFilterPost("selesai_tahun");
$gaji = httpFilterPost("gaji");
$fasilitas_lain = httpFilterPost("fasilitas_lain");

$pengalaman_kerja->setField('PEGAWAI_ID', $reqId);
$pengalaman_kerja->setField('NAMA_PERUSAHAAN', $nama_perusahaan);
$pengalaman_kerja->setField('JABATAN', $jabatan);
$pengalaman_kerja->setField('MASUK_KERJA', $masuk_kerja);
$pengalaman_kerja->setField('KELUAR_KERJA', $keluar_kerja);
$pengalaman_kerja->setField('GAJI', $gaji);
$pengalaman_kerja->setField('FASILITAS', $fasilitas_lain);

if($reqMode == "insert")
{
	$pengalaman_kerja->setField("CREATED_BY", $userLogin->nama);
	$pengalaman_kerja->setField("CREATED_DATE", OCI_SYSDATE);	
	if($pengalaman_kerja->insert()){
		$reqRowId = $pengalaman_kerja->id;
		echo $reqId . "-Data berhasil disimpan.-".$reqRowId;
	}
	echo $pengalaman_kerja->query;
}
else
{
	$pengalaman_kerja->setField("UPDATED_BY", $userLogin->nama);
	$pengalaman_kerja->setField("UPDATED_DATE", OCI_SYSDATE);		
	$pengalaman_kerja->setField("PEGAWAI_PENGALAMAN_KERJA_ID", $reqRowId);		
	if($pengalaman_kerja->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pengalaman_kerja->query;
}
?>