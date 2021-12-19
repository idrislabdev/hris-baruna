<?
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/string.func.php");

ini_set("memory_limit","100M");

$reqId = httpFilterRequest("reqId");  
$reqTipe = httpFilterRequest("reqTipe");  

if($reqTipe=='inventaris')
{
	include_once("../WEB-INF/classes/base-inventaris/Inventaris.php");
	$lampiran = new Inventaris();
	$lampiran->selectByParamsFile(array("INVENTARIS_ID" => $reqId));
}
elseif($reqTipe=='perbaikan')
{
	include_once("../WEB-INF/classes/base-inventaris/InventarisPerbaikanDetil.php");
	$lampiran = new InventarisPerbaikanDetil();
	$lampiran->selectByParams(array("INVENTARIS_PERBAIKAN_DETIL_ID" => $reqId));
}

$lampiran->firstRow();

if($lampiran->getField('TIPE') == 'image/jpeg'){
	$tempTipe=str_replace('jpeg','jpg',$lampiran->getField('TIPE'));
}else{
	$tempTipe=$lampiran->getField('TIPE');
}

$tipe = $tempTipe;
$isi = $lampiran->getField("FILE_GAMBAR");

if($isi == "")
{
	$tipe = "image/jpeg";
	$isi = imagecreatefromjpeg("../WEB-INF/images/noimage.jpg");
	imagepng($isi);
	
}

$nama = "download";

header("Content-type: $tipe");
header("Content-Disposition: inline; filename=".$nama.".".getExe($tipe));
echo base64_decode($isi);
?>