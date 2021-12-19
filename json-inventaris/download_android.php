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
elseif($reqTipe=='inventaris_ruangan')
{
	include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
	$lampiran = new InventarisRuangan();
	$lampiran->selectByParamsSimple(array("INVENTARIS_RUANGAN_ID" => $reqId));
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
else
{
	if($reqTipe=='inventaris_ruangan')
	{
		$FILE_DIR = "../operasional/uploads/inventaris_ruangan/z__thumb_";
		$tipe = "image/jpeg";
		$isi = imagecreatefromjpeg($FILE_DIR.$isi);
		imagepng($isi);		
	}		
}

$nama = "download";

header("Content-type: $tipe");
header("Content-Disposition: inline; filename=".$nama.".".getExe($tipe));
//echo base64_decode($isi);

$data = base64_decode($isi);

$im = imagecreatefromstring($data);

$width = ImageSX($im); // width
$height = ImageSY($im); // height

$newwidth = 300;
$newheight = 300;

$thumb = imagecreatetruecolor($newwidth, $newheight);

imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// Output and free memory
//the resized image will be 400x300
imagejpeg($thumb);
imagedestroy($thumb);


?>