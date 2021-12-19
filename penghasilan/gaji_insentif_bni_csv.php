<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/InsentifBantuan.php");

require_once "../WEB-INF/lib/excel/class.writecsv.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "gaji_insentif_mandiri_csv.xls");


$insentif = new InsentifBantuan();
$insentif2 = new InsentifBantuan();
$csv = new CSV();

$reqPeriode = httpFilterGet("reqPeriode");
$reqJenisPegawai = httpFilterGet("reqJenisPegawai");

if($reqJenisPegawai == "")
{}
else
	$statement .= "AND JENIS_PEGAWAI_ID = ".$reqJenisPegawai;

$statement .= " AND BANK_NAMA = 'BANK BNI 1946' ";	
	
$insentif->selectByParamsReport(array(), -1, -1, $statement, $reqPeriode, " ORDER BY  JENIS_PEGAWAI_ID, BANK_NAMA, NAMA ASC");

$row = 5;
$jenis_pegawai = "";
$jenis_bank = "";

$insentif2->selectByParamsReportCSVHeader($statement, $reqPeriode);

if ($insentif2->nextRow()) {

//$csv->addRow(array('P',substr($reqPeriode,-4) . substr($reqPeriode,0,2) . '01','1400015522221',$insentif2->getField('TOTAL'),$insentif2->getField('SUM_INSENTIF'),',,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,'));

$csv->addRow(array($insentif2->getField('TANGGAL_BUAT'),$insentif2->getField('TOTAL') + 2,',,,,,,,,,,,,,,,,,,'));
$csv->addRow(array('P',substr($reqPeriode,-4) . substr($reqPeriode,0,2) . '01','311220117',$insentif2->getField('TOTAL'),$insentif2->getField('SUM_INSENTIF'),',,,,,,,,,,,,,,,'));
}

while($insentif->nextRow())
{

	if ($insentif->getField("DIBAYARKAN") <= 0) {
	continue;
	}

	$csv->addRow(array($insentif->getField('NO_REKENING'), $insentif->replaceSpecialCharacter($insentif->getField('NAMA')),$insentif->getField("DIBAYARKAN"),',,,,,,,,,,,,,N,,,N'));
}

$filename = 'INSENTIF_PEGAWAI_' . $reqPeriode;
$csv->export($filename);
?>