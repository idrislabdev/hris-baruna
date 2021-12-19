<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/Premi.php");

require_once "../WEB-INF/lib/excel/class.writecsv.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "gaji_premi_awak_kapal_bni_csv.xls");


$premi = new Premi();
$premi2 = new Premi();
$csv = new CSV();

$reqPeriode = httpFilterGet("reqPeriode");
$reqJenisPegawai = httpFilterGet("reqJenisPegawai");

if($reqJenisPegawai == "")
{}
else
	$statement .= "AND JENIS_PEGAWAI_ID = ".$reqJenisPegawai;

$statement .= " AND NAMA_BANK = 'BANK BNI 1946' ";	
	
$premi->selectByParamsReportKeuangan(array(), -1, -1, $statement, $reqPeriode, " ORDER BY  JENIS_PEGAWAI_ID, NAMA_BANK, AWAK_KAPAL ASC");

$row = 5;
$jenis_pegawai = "";
$jenis_bank = "";

$premi2->selectByParamsReportKeuanganCSVHeader($statement, $reqPeriode);

if ($premi2->nextRow()) {

$csv->addRow(array($premi2->getField('TANGGAL_BUAT'),$premi2->getField('TOTAL') + 2,',,,,,,,,,,,,,,,,,,'));
$csv->addRow(array('P',substr($reqPeriode,-4) . substr($reqPeriode,0,2) . '01','311220117',$premi2->getField('TOTAL'),$premi2->getField('SUM_PREMI'),',,,,,,,,,,,,,,,'));


}

while($premi->nextRow())
{

	if ($premi->getField("JUMLAH_DITERIMA") <= 0) {
	continue;
	}

	$csv->addRow(array($premi->getField('REKENING_NO'), $premi->replaceSpecialCharacter($premi->getField('AWAK_KAPAL')),$premi->getField("JUMLAH_DITERIMA"),',,,,,,,,,,,,,N,,,N'));
}

$filename = 'PREMI_AWAK_KAPAL_' . $reqPeriode;
$csv->export($filename);
?>