<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/HasilRapatAttachment.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");

ini_set("memory_limit","50000M");
ini_set('max_execution_time', 52000);

$hasil_rapat_attachment = new HasilRapatAttachment();

$key = httpFilterPost("key");
$reqId = httpFilterRequest("reqId");

if($key == "sms_image_uploader_2.0")
{
	$hasil_rapat_attachment->setField("NAMA", $_FILES['attachment']['name']);
	$hasil_rapat_attachment->setField("HASIL_RAPAT_ID", $reqId);
	$hasil_rapat_attachment->setField("FILE_NAMA", $_FILES['attachment']['name']);
	$hasil_rapat_attachment->setField("UKURAN", $_FILES['attachment']['size']);
	$hasil_rapat_attachment->setField("FORMAT", $_FILES['attachment']['type']);
	$hasil_rapat_attachment->insert();
	$id = $hasil_rapat_attachment->id;
	
	if($hasil_rapat_attachment->upload("HASIL_RAPAT_ATTACHMENT", "FILE_UPLOAD", $_FILES['attachment']['tmp_name'], "HASIL_RAPAT_ATTACHMENT_ID = ".$id))
	{
		//echo "Data Tersimpan";
		echo "1";
	}
	else
	{
		echo "Couldn't upload Blob\n";
	}
}
?>