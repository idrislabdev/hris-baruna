<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/default.func.php");

/* variable */
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == 'pegawai_sertifikat'){
	include_once("../WEB-INF/classes/base-simpeg/PegawaiSertifikatFile.php");
	$pegawai_sertifikat_file= new PegawaiSertifikatFile();
	$pegawai_sertifikat_file->selectByParams(array("PEGAWAI_SERTIFIKAT_FILE_ID" => $reqId), -1, -1);
	$pegawai_sertifikat_file->firstRow();
	$tipe = $pegawai_sertifikat_file->getField('FORMAT');
	$isi = $pegawai_sertifikat_file->getField("FILE_UPLOAD");
	$nama = $pegawai_sertifikat_file->getField("FILE_NAMA");
}


header("Content-type: $tipe");
header("Content-Disposition: inline; filename=$nama");
echo $isi;
?>
