<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/UangTransportBantuan.php");

require_once "../WEB-INF/lib/excel/class.writecsv.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "uang_transport_excel.xls");


$uang_transport_bantuan = new UangTransportBantuan();
$uang_transport_bantuan2 = new UangTransportBantuan();
$csv = new CSV();

$reqPeriode = httpFilterGet("reqPeriode");
$reqJenisPegawai = httpFilterGet("reqJenisPegawai");

if($reqJenisPegawai == "")
{}
else
	$statement .= "AND B.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;

$statement .= " AND BANK_NAMA = 'BANK BRI' ";	
	
$uang_transport_bantuan->selectByParamsReport(array(), -1, -1, $statement, $reqPeriode, " ORDER BY  A.JENIS_PEGAWAI_ID, BANK_NAMA, NAMA ASC");

$row = 5;
$sequence = 1;
$jenis_pegawai = "";
$jenis_bank = "";
$totalpegawai = 0;
$totaluang = 0;
$checkstring = "";

$uang_transport_bantuan2->selectByParamsReportCSVHeader($statement, $reqPeriode);

$csv->addRow(array('NO','NAMA','ACCOUNT','AMOUNT'));

if ($uang_transport_bantuan2->nextRow()) {
	$totalpegawai = $uang_transport_bantuan2->getField('TOTAL');
	$totaluang = $uang_transport_bantuan2->getField('SUM_TRANSPORT');
	$checkstring = md5($uang_transport_bantuan2->getField('TOTAL') . $uang_transport_bantuan2->getField('SUM_TRANSPORT') . $uang_transport_bantuan2->getField('CEK_AKUN'));
}

while($uang_transport_bantuan->nextRow())
{
	
	if ($uang_transport_bantuan->getField("DIBAYARKAN") <= 0) {
	continue;
	}
	
	$csv->addRow(array($sequence, $uang_transport_bantuan->replaceSpecialCharacter($uang_transport_bantuan->getField('NAMA')),$uang_transport_bantuan->getField('NO_REKENING'), $uang_transport_bantuan->getField("DIBAYARKAN")));
	$row++;
	$sequence++;
}
$csv->addRow(array('COUNT,,',$totalpegawai));
$csv->addRow(array('TOTAL,,',$totaluang));
$csv->addRow(array('CHECK,,',$checkstring));

$filename = 'UANG_TRANSPORT_BRI_' . $reqPeriode;
$csv->export($filename);
?>