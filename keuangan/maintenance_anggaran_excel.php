<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtNeracaAngg.php");

require_once "excel/class.writeexcel_workbookbig.inc.php";
require_once "excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "maintenance_anggaran.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$kbbt_neraca_angg = new KbbtNeracaAngg();

$reqTahunBuku= httpFilterGet("reqTahunBuku");




if ($reqTahunBuku != "")
    $statement= " AND THN_BUKU = '".$reqTahunBuku."'";
	
	
$kbbt_neraca_angg->selectByParams(array(),-1, -1, $statement, "");


$worksheet->set_column(0, 0, 10.00);
$worksheet->set_column(1, 1, 20.00);
$worksheet->set_column(2, 2, 20.00);
$worksheet->set_column(3, 3, 15.00);
$worksheet->set_column(4, 4, 15.00);
$worksheet->set_column(5, 5, 15.00);
$worksheet->set_column(6, 6, 15.00);
$worksheet->set_column(7, 7, 15.00);
$worksheet->set_column(8, 8, 15.00);
$worksheet->set_column(9, 9, 15.00);
$worksheet->set_column(10, 10, 15.00);
$worksheet->set_column(11, 11, 15.00);
$worksheet->set_column(12, 12, 15.00);
$worksheet->set_column(13, 13, 15.00);
$worksheet->set_column(14, 14, 15.00);
$worksheet->set_column(15, 15, 15.00);

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
$worksheet->write(1, 1, "MAINTENANCE ANGGARAN", $text_format);

$worksheet->write(3, 1, "TAHUN BUKU", $text_format_line_bold);
$worksheet->write(3, 2, "BUKU BESAR", $text_format_line_bold);
$worksheet->write(3, 3, "PUSAT BIAYA", $text_format_line_bold);
$worksheet->write(3, 4, "JUMLAH ANGGARAN", $text_format_line_bold);
$worksheet->write(3, 5, "JULI", $text_format_line_bold);
$worksheet->write(3, 6, "AGUSTUS", $text_format_line_bold);
$worksheet->write(3, 7, "SEPTEMBER", $text_format_line_bold);
$worksheet->write(3, 8, "OKTOBER", $text_format_line_bold);
$worksheet->write(3, 9, "NOVEMBER", $text_format_line_bold);
$worksheet->write(3, 10, "DESEMBER", $text_format_line_bold);
$worksheet->write(3, 11, "JANUARI ", $text_format_line_bold);
$worksheet->write(3, 12, "FEBRUARI ", $text_format_line_bold);
$worksheet->write(3, 13, "MARET ", $text_format_line_bold);
$worksheet->write(3, 14, "APRIL", $text_format_line_bold);
$worksheet->write(3, 15, "MEI ", $text_format_line_bold);
$worksheet->write(3, 16, "JUNI", $text_format_line_bold);

/*$worksheet->write(5, 1, "167121872", $text_format_line);
$worksheet->write(5, 2, "LUSIA TIVIANIE, SH, MH", $text_format_line_left);
$worksheet->write(5, 3, "5", $text_format_line);
$worksheet->write(5, 4, "Manager SDM dan Umum", $text_format_line_left);*/

$row = 4;
while($kbbt_neraca_angg->nextRow())
{
	$worksheet->write($row, 1, $kbbt_neraca_angg->getField("THN_BUKU"), $text_format_line);
	$worksheet->write($row, 2, $kbbt_neraca_angg->getField("KD_BUKU_PUSAT"), $text_format_line_left);
	$worksheet->write($row, 3, $kbbt_neraca_angg->getField("KD_BUKU_BESAR"), $text_format_line_left);
	$worksheet->write($row, 4, $kbbt_neraca_angg->getField("ANGG_TAHUNAN"), $text_format_line_left);
	$worksheet->write($row, 5, $kbbt_neraca_angg->getField("P01_ANGG"), $text_format_num);
	$worksheet->write($row, 6, $kbbt_neraca_angg->getField("P02_ANGG"), $text_format_num);
	$worksheet->write($row, 7, $kbbt_neraca_angg->getField("P03_ANGG"), $text_format_num);
	$worksheet->write($row, 8, $kbbt_neraca_angg->getField("P04_ANGG"), $text_format_num);
	$worksheet->write($row, 9, $kbbt_neraca_angg->getField("P05_ANGG"), $text_format_num);
	$worksheet->write($row, 10, $kbbt_neraca_angg->getField("P06_ANGG"), $text_format_num);
	$worksheet->write($row, 11, $kbbt_neraca_angg->getField("P07_ANGG"), $text_format_num);
	$worksheet->write($row, 12, $kbbt_neraca_angg->getField("P08_ANGG"), $text_format_num);
	$worksheet->write($row, 13, $kbbt_neraca_angg->getField("P09_ANGG"), $text_format_num);
	$worksheet->write($row, 14, $kbbt_neraca_angg->getField("P10_ANGG"), $text_format_num);
	$worksheet->write($row, 15, $kbbt_neraca_angg->getField("P11_ANGG"), $text_format_num);
	$worksheet->write($row, 16, $kbbt_neraca_angg->getField("P12_ANGG"), $text_format_num);

    /*for ($k=4; $k<=34; $k++)
	{
			$worksheet->write($row, $k, $absensi_koreksi->getField('HARI_'.($k-3)), $text_format_line);
	}*/
	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"maintenance_anggaran.xls\"");
header("Content-Disposition: inline; filename=\"maintenance_anggaran.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>