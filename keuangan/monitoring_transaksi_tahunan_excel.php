<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtNeracaSaldo.php");

require_once "excel/class.writeexcel_workbookbig.inc.php";
require_once "excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "monitoring_rekap_nota_excel_".$reqTahun.".xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$kbbt_neraca_saldo = new KbbtNeracaSaldo();

$reqTahun = httpFilterGet("reqTahun");

$kbbt_neraca_saldo->selectByParamsMonitoringTransaksiTahunan(array("JEN_JURNAL" => "JPJ", "TO_CHAR(TGL_TRANS, 'YYYY')" => $reqTahun));

//echo $kbbt_neraca_saldo->query;

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 10.00);
$worksheet->set_column(2, 2, 25.00);
$worksheet->set_column(3, 3, 38.00);
$worksheet->set_column(4, 4, 30.00);
$worksheet->set_column(5, 5, 15.00);
$worksheet->set_column(6, 6, 30.00);
$worksheet->set_column(7, 7, 35.00);
$worksheet->set_column(8, 8, 25.00);
$worksheet->set_column(9, 9, 15.00);
$worksheet->set_column(10, 10, 25.00);
$worksheet->set_column(11, 11, 30.00);
$worksheet->set_column(12, 12, 15.00);

$tanggal =& $workbook->addformat(array(num_format => ' dd mmmm yyy'));

$text_format =& $workbook->addformat(array( size => 10, font => 'Arial Narrow'));
$text_format_num =& $workbook->addformat(array( num_format => '###', size => 8, font => 'Arial Narrow', align => 'center'));
$text_format_num->set_left(1);
$text_format_num->set_right(1);
$text_format_num->set_top(1);
$text_format_num->set_bottom(1);

$text_format_left_none =& $workbook->addformat(array( size => 10, font => 'Arial Narrow'));
$text_format_left_none->set_color('black');

$text_format_merge =& $workbook->addformat(array(size => 8, font => 'Arial Narrow'));
$text_format_merge->set_color('black');
$text_format_merge->set_size(8);
$text_format_merge->set_border_color('black');
$text_format_merge->set_merge(1);
$text_format_merge->set_bold(1);

$text_format_merge_line_bold =& $workbook->addformat(array(size => 8, font => 'Arial Narrow'));
$text_format_merge_line_bold->set_color('black');
$text_format_merge_line_bold->set_size(8);
$text_format_merge_line_bold->set_border_color('black');
$text_format_merge_line_bold->set_merge(1);
$text_format_merge_line_bold->set_bold(1);
$text_format_merge_line_bold->set_left(1);
$text_format_merge_line_bold->set_right(1);
$text_format_merge_line_bold->set_top(1);
$text_format_merge_line_bold->set_bottom(1);

$text_format_merge_none =& $workbook->addformat(array(size => 8, font => 'Arial Narrow'));
$text_format_merge_none->set_color('black');
$text_format_merge_none->set_size(8);
$text_format_merge_none->set_border_color('black');
$text_format_merge_none->set_merge(1);

$text_format =& $workbook->addformat(array(align => 'left', size => 8, font => 'Arial Narrow'));
$text_format->set_color('black');
$text_format->set_size(8);
$text_format->set_border_color('black');

$text_format_center =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow'));
$text_format_center->set_color('black');
$text_format_center->set_size(8);
$text_format_center->set_border_color('black');

$text_format_line =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow'));
$text_format_line->set_color('black');
$text_format_line->set_size(8);
$text_format_line->set_border_color('black');
$text_format_line->set_left(1);
$text_format_line->set_right(1);
$text_format_line->set_top(1);
$text_format_line->set_bottom(1);

$text_format_line_left =& $workbook->addformat(array(align => 'left', size => 8, font => 'Arial Narrow'));
$text_format_line_left->set_color('black');
$text_format_line_left->set_size(8);
$text_format_line_left->set_border_color('black');
$text_format_line_left->set_left(1);
$text_format_line_left->set_right(1);
$text_format_line_left->set_top(1);
$text_format_line_left->set_bottom(1);
$text_format_line_left->set_text_wrap();

$text_format_line_bold =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow'));
$text_format_line_bold->set_color('black');
$text_format_line_bold->set_size(8);
$text_format_line_bold->set_border_color('black');
$text_format_line_bold->set_bold(1);
$text_format_line_bold->set_left(1);
$text_format_line_bold->set_right(1);
$text_format_line_bold->set_top(1);
$text_format_line_bold->set_bottom(1);

$text_format_wrapping =& $workbook->addformat(array( size => 8, font => 'Arial Narrow'));
$text_format_wrapping->set_text_wrap();
$text_format_wrapping->set_color('black');
$text_format_wrapping->set_size(8);
$text_format_wrapping->set_border_color('black');
$text_format_wrapping->set_left(1);
$text_format_wrapping->set_right(1);
$text_format_wrapping->set_top(1);

$uang =& $workbook->addformat(array(num_format => '#,##0', size => 8, font => 'Arial Narrow'));
$uang->set_color('black');
$uang->set_size(8);
$uang->set_border_color('black');

$uang_line =& $workbook->addformat(array(num_format => '#,##0', size => 8, font => 'Arial Narrow'));
$uang_line->set_color('black');
$uang_line->set_size(8);
$uang_line->set_border_color('black');
$uang_line->set_left(1);
$uang_line->set_right(1);
$uang_line->set_top(1);
$uang_line->set_bottom(1);

//$worksheet->insert_bitmap('B1', 'images/logo_cetak.bmp', 5, 5);
$worksheet->write(1, 1, "MONITORING REKAP NOTA TAHUN ".$reqTahun, $text_format);
	

$worksheet->write(5, 1, "No Tanggal", $text_format_line_bold);
$worksheet->write(5, 2, "No Invoice", $text_format_line_bold);
$worksheet->write(5, 3, "No Faktur Pajak", $text_format_line_bold);
$worksheet->write(5, 4, "No SIUK", $text_format_line_bold);
$worksheet->write(5, 5, "Valuta", $text_format_line_bold);
$worksheet->write(5, 6, "Nama Debitur", $text_format_line_bold);
$worksheet->write(5, 7, "Keterangan", $text_format_line_bold);
$worksheet->write(5, 8, "Nominal", $text_format_line_bold);
$worksheet->write(5, 9, "Tanggal", $text_format_line_bold);
$worksheet->write(5, 10, "No SIUK", $text_format_line_bold);
$worksheet->write(5, 11,"Jumlah", $text_format_line_bold); 
$worksheet->write(5, 12,"No. Posting", $text_format_line_bold); 

$row = 6;

while($kbbt_neraca_saldo->nextRow())
{
	$worksheet->write($row, 1, getFormattedDate($kbbt_neraca_saldo->getField("TGL_TRANS")), $text_format_line_left);
	$worksheet->write($row, 2, $kbbt_neraca_saldo->getField("NO_REF1"), $text_format_line_left);
	$worksheet->write($row, 3, $kbbt_neraca_saldo->getField("NO_FAKTUR_PAJAK"), $text_format_line_left);
	$worksheet->write($row, 4, $kbbt_neraca_saldo->getField("NO_NOTA"), $text_format_line_left); 
	$worksheet->write($row, 5, $kbbt_neraca_saldo->getField("KD_VALUTA"), $text_format_line_left);
	$worksheet->write($row, 6, $kbbt_neraca_saldo->getField("MPLG_NAMA"), $text_format_line_left);
	$worksheet->write($row, 7, $kbbt_neraca_saldo->getField("KET_TAMBAHAN"), $text_format_line_left); 
	$worksheet->write($row, 8, $kbbt_neraca_saldo->getField("JML_TAGIHAN"), $text_format_line_left);
	$worksheet->write($row, 9, str_replace("<br>", "\n", $kbbt_neraca_saldo->getField("TGL_PELUNASAN")), $text_format_line_left);
	$worksheet->write($row, 10, str_replace("<br>", "\n", $kbbt_neraca_saldo->getField("NOTA_PELUNASAN")), $text_format_line_left);
	$worksheet->write($row, 11, str_replace("<br>", "\n", $kbbt_neraca_saldo->getField("JUMLAH_PELUNASAN")), $text_format_line_left);
	$worksheet->write($row, 12, str_replace("<br>", "\n", $kbbt_neraca_saldo->getField("NO_POSTING")), $text_format_line_left);
	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"monitoring_rekap_nota_excel_".$reqTahun.".xls\"");
header("Content-Disposition: inline; filename=\"monitoring_rekap_nota_excel_".$reqTahun.".xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>