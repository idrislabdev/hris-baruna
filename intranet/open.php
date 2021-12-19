<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/default.func.php");

/* variable */
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == 'hasil_rapat'){
	include_once("../WEB-INF/classes/base/HasilRapatAttachment.php");
	$hasil_rapat_attachment = new HasilRapatAttachment();
	$hasil_rapat_attachment->selectByParams(array("HASIL_RAPAT_ATTACHMENT_ID" => $reqId), -1, -1);
	$hasil_rapat_attachment->firstRow();
	$tipe = $hasil_rapat_attachment->getField('FORMAT');
	$isi = $hasil_rapat_attachment->getField("FILE_UPLOAD");
	$nama = $hasil_rapat_attachment->getField("FILE_NAMA");
}


header("Content-type: $tipe");
header("Content-Disposition: inline; filename=$nama");
echo $isi;
//header("Content-type: image/jpeg");

//echo $isi;
?>
