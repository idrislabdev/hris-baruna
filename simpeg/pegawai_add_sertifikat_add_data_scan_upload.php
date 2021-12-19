<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiSertifikatFile.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");

ini_set("memory_limit","50000M");
ini_set('max_execution_time', 52000);

$pegawai_sertifikat_file = new PegawaiSertifikatFile();

$key = httpFilterPost("key");
$reqId = httpFilterRequest("reqId");
$reqRowId = httpFilterRequest("reqRowId");

if($key == "sms_image_uploader_2.0")
{
	$pegawai_sertifikat_file->setField("PEGAWAI_SERTIFIKAT_ID", $reqId);
	
	$pegawai_sertifikat_file->setField("NAMA", $_FILES['attachment']['name']);
	$pegawai_sertifikat_file->setField("FILE_NAMA", $_FILES['attachment']['name']);
	$pegawai_sertifikat_file->setField("FILE_UKURAN", $_FILES['attachment']['size']);
	$pegawai_sertifikat_file->setField("FILE_FORMAT", $_FILES['attachment']['type']);
	$pegawai_sertifikat_file->insert();
	
	$id = $pegawai_sertifikat_file->id;
	
	if($pegawai_sertifikat_file->upload("IMASYS_SIMPEG.PEGAWAI_SERTIFIKAT_FILE", "FILE_UPLOAD", $_FILES['attachment']['tmp_name'], "PEGAWAI_SERTIFIKAT_FILE_ID = ".$id))
	{
		echo "1";
	}
	else
	{
		echo "Couldn't upload Blob\n";
	}
}
?>