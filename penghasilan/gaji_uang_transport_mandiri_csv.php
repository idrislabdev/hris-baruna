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

$statement .= " AND BANK_NAMA = 'BANK MANDIRI' ";	
	
$uang_transport_bantuan->selectByParamsReport(array(), -1, -1, $statement, $reqPeriode, " ORDER BY  A.JENIS_PEGAWAI_ID, BANK_NAMA, NAMA ASC");

$row = 5;
$jenis_pegawai = "";
$jenis_bank = "";

$uang_transport_bantuan2->selectByParamsReportCSVHeader($statement, $reqPeriode);

if ($uang_transport_bantuan2->nextRow()) {

$csv->addRow(array('P',substr($reqPeriode,-4) . substr($reqPeriode,0,2) . '01','1400015522221',$uang_transport_bantuan2->getField('TOTAL'),$uang_transport_bantuan2->getField('SUM_TRANSPORT'),',,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,'));
}

$monthNum = substr($reqPeriode,0,2);
$monthName = date("M", mktime(0, 0, 0, $monthNum, 10));
$keterangan = strtoupper("TRANSPORT  " . $monthName . " " . substr($reqPeriode,-4));

while($uang_transport_bantuan->nextRow())
{
	/*
	$worksheet->write($row, 1, $uang_transport_bantuan->getField("NRP"), $text_format_line);
	$worksheet->write($row, 2, $uang_transport_bantuan->getField("NAMA"), $text_format_line_left);
	$worksheet->write($row, 3, " ". $uang_transport_bantuan->getField("NO_REKENING"), $text_format_line_left);
	$worksheet->write($row, 4, $uang_transport_bantuan->getField("JUMLAH"), $uang_line);
	$worksheet->write($row, 5, $uang_transport_bantuan->getField("PROSENTASE_POTONGAN"), $text_format_line);
	$worksheet->write($row, 6, $uang_transport_bantuan->getField("POTONGAN_PPH"), $uang_line);
	$worksheet->write($row, 7, $uang_transport_bantuan->getField("DIBAYARKAN"), $uang_line);
	*/
	if ($uang_transport_bantuan->getField("DIBAYARKAN") <= 0) {
	continue;
	}
	
	$csv->addRow(array($uang_transport_bantuan->getField("NO_REKENING"),$uang_transport_bantuan->replaceSpecialCharacter($uang_transport_bantuan->getField('NAMA')),',,,IDR',$uang_transport_bantuan->getField("DIBAYARKAN"),$keterangan.',,IBU,,,,,,,N,ahmaddal@yahoo.com,,,,,,,,,,,,,,,,,,,,,,,'.$keterangan));
	
	$row++;
}

$filename = 'UANG_TRANSPORT_MANDIRI_' . $reqPeriode;
$csv->export($filename);
?>