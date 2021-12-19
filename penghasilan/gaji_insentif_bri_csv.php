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

$statement .= " AND BANK_NAMA = 'BANK BRI' ";	
	
$insentif->selectByParamsReport(array(), -1, -1, $statement, $reqPeriode, " ORDER BY  JENIS_PEGAWAI_ID, BANK_NAMA, NAMA ASC");

$row = 5;
$jenis_pegawai = "";
$jenis_bank = "";
$totalpegawai = 0;
$totaluang = 0;
$checkstring = "";

$insentif2->selectByParamsReportCSVHeader($statement, $reqPeriode);
$csv->addRow(array('NO','NAMA','ACCOUNT','AMOUNT'));

if ($insentif2->nextRow()) {

$totalpegawai = $insentif2->getField('TOTAL');
$totaluang = $insentif2->getField('SUM_TRANSPORT');
$checkstring = md5($insentif2->getField('TOTAL') . $insentif2->getField('SUM_PREMI') . $insentif2->getField('CEK_AKUN'));
}

$monthNum = substr($reqPeriode,0,2);
$monthName = date("M", mktime(0, 0, 0, $monthNum, 10));
$keterangan = strtoupper("INSENTIF  " . $monthName . " " . substr($reqPeriode,-4));
$sequence = 1;

while($insentif->nextRow())
{

	if ($insentif->getField("DIBAYARKAN") <= 0) {
	continue;
	}

	$csv->addRow(array($sequence, $insentif->replaceSpecialCharacter($insentif->getField('NAMA')),$insentif->getField('NO_REKENING'), $insentif->getField("DIBAYARKAN")));
	$sequence++;
}

$csv->addRow(array('COUNT,,',$totalpegawai));
$csv->addRow(array('TOTAL,,',$totaluang));
$csv->addRow(array('CHECK,,',$checkstring));

$filename = 'INSENTIF_PEGAWAI_' . $reqPeriode;
$csv->export($filename);
?>