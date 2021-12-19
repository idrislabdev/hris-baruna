<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/utils/FileHandler.php");

$anggaran_mutasi = new AnggaranMutasi();
$file			 = new FileHandler();


$FILE_DIR = "../anggaran/uploads/nota_dinas/";
$_THUMB_PREFIX = "z__thumb_";

$reqId = httpFilterPost("reqId");
$reqLinkFile   = $_FILES['reqLinkFile'];
$reqLinkFileTemp = httpFilterPost("reqLinkFileTemp");

$cek = formatTextToDb($file->getFileName('reqLinkFile'));
if($cek == "")
{
}
else
{
	$allowed = array(".exe");	$status_allowed='';
	foreach ($allowed as $file_cek) 
	{
		if(preg_match("/$file_cek\$/i", $_FILES['reqLinkFile']['name'])) 
		{
			$status_allowed = 'tidak_boleh';
		}
	}
	
	$renameFile = $reqId.'~'.formatTextToDb($file->getFileName('reqLinkFile'));
	$renameFile = str_replace(" ", "", $renameFile);
	
	$varSource=$FILE_DIR.$reqLinkFileTemp;
	$varThumbnail = $FILE_DIR.$_THUMB_PREFIX.$reqLinkFileTemp;
	
	if($file->uploadToDir('reqLinkFile', $FILE_DIR, $renameFile))
	{
		$insertLinkFile = $file->uploadedFileName;
		$set_file = new AnggaranMutasi();		
		$set_file->setField('ANGGARAN_MUTASI_ID', $reqId);	
		$set_file->setField('NOTA_DINAS_UPLOAD', $insertLinkFile);
		$set_file->update_file();
		echo "Data berhasil disimpan.";
	}
}

?>