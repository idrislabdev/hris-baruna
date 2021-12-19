<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
require_once '../WEB-INF/lib/PHPWord/PHPWord.php';
include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");

$cuti_tahunan = new CutiTahunan();

$reqId= httpFilterGet("reqId");
$reqPeriode= httpFilterGet("reqPeriode");

$PHPWord = new PHPWord();
$document = $PHPWord->loadTemplate('template-gaji/PENGAJUAN_CUTI.docx');

$cuti_tahunan->selectByParams(array('A.PEGAWAI_ID'=>$reqId), -1, -1, "", $reqPeriode);
$cuti_tahunan->firstRow();

$document->setValue('REQTANGGAL', strtoupper(getFormattedDate($cuti_tahunan->getField("TANGGAL"))));
$document->setValue('REQNAMA', strtoupper($cuti_tahunan->getField("NAMA")));
$document->setValue('REQNIP', strtoupper($cuti_tahunan->getField("NRP")));
$document->setValue('REQPANGKAT', strtoupper($cuti_tahunan->getField("PANGKAT")));
$document->setValue('REQJABATAN', strtoupper($cuti_tahunan->getField("JABATAN")));
$document->setValue('REQKELAS', strtoupper($cuti_tahunan->getField("KELAS")));
$document->setValue('REQAWAL', strtoupper(getFormattedDate($cuti_tahunan->getField("TANGGAL_AWAL"))));
$document->setValue('REQTERAKHIR', strtoupper(getFormattedDate($cuti_tahunan->getField("TANGGAL_AKHIR"))));
$document->setValue('REQLIBUR', strtoupper($cuti_tahunan->getField("LAMA_CUTI_HURUF")));
$document->setValue('REQLAMA', strtoupper($cuti_tahunan->getField("LAMA_CUTI")));
$document->setValue('REQTAHUN', $reqPeriode);

$document->save('template-gaji/suratPerintah'.$reqId.'.doc');
$file = 'template-gaji/suratPerintah'.$reqId.'.doc';

$down = 'template-gaji/suratPerintah'.$reqId.'.doc';
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