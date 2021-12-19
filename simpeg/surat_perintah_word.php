<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
require_once '../WEB-INF/lib/PHPWord/PHPWord.php';
include_once("../WEB-INF/classes/base-operasional/SuratPerintah.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");

$surat_perintah = new SuratPerintah();

$reqId= httpFilterGet("reqId");
$reqNomor= httpFilterGet("reqNomor");
$PHPWord = new PHPWord();
$document = $PHPWord->loadTemplate('../template-simpeg/suratPerintah.docx');

//$reqId= '2';
$surat_perintah->selectByParams(array("SURAT_PERINTAH_ID"=>$reqId),-1,-1);
$surat_perintah->firstRow();
//echo $surat_perintah->query;
$document->setValue("REQNOMOR", $surat_perintah->getField("NOMOR_PENUGASAN"));
$document->setValue("REQNOKONTRAK", $surat_perintah->getField("NOMOR"));
$document->setValue("REQLOKASI", $surat_perintah->getField("LOKASI"));
$document->setValue("REQNAMAKAPAL", "");
$document->setValue("REQNAMAPERUSAHAAN", "");
$document->setValue("REQBULAN", "");
$document->setValue("REQTANGGAL", getFormattedDate(date("Y-m-d")));

$document->save('../template-simpeg/suratPerintah'.$NoAgenda.'.doc');
$file = '../template-simpeg/suratPerintah'.$NoAgenda.'.doc';

$down = '../template-simpeg/suratPerintah'.$NoAgenda.'.doc';
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($down));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($down));
ob_clean();
flush();
readfile($down);
unlink($file);
unset($oPrinter);
exit;	
exit();
?>