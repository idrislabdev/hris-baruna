<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");

require_once "excel/class.writeexcel_workbookbig.inc.php";
require_once "excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "cetak_rekap.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$absensi_rekap = new AbsensiRekap();

$reqBulan = httpFilterGet("reqBulan");
$reqTahun = httpFilterGet("reqTahun");
$reqPeriode = $reqBulan.$reqTahun;

$absensi_rekap->selectByParamsRekapTerlambatPulangCepatReport($reqPeriode);

$worksheet->set_column(0, 0, 19.00);
$worksheet->set_column(1, 1, 9.57);
$worksheet->set_column(2, 2, 29.00);
$worksheet->set_column(3, 3, 8.00);
$worksheet->set_column(4, 4, 34.00);
$worksheet->set_column(5, 5, 8.00);
$worksheet->set_column(6, 6, 27.00);
$worksheet->set_column(7, 7, 8.00);
$worksheet->set_column(8, 8, 13.00);
$worksheet->set_column(9, 9, 19.00);

$tanggal =& $workbook->addformat(array(num_format => ' dd mmmm yyy'));

$text_format =& $workbook->addformat(array( size => 10, font => 'Arial Narrow'));
$text_format_num =& $workbook->addformat(array( num_format => '###', size => 10, font => 'Arial Narrow', align => 'left'));

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

$worksheet->write		(1, 0, "REKAP KEHADIRAN BULAN ".getNamePeriode($reqPeriode), $text_format_merge);
$worksheet->write_blank	(1, 1, $text_format_merge);
$worksheet->write_blank	(1, 2, $text_format_merge);
$worksheet->write_blank	(1, 3, $text_format_merge);
$worksheet->write_blank	(1, 4, $text_format_merge);
$worksheet->write_blank	(1, 5, $text_format_merge);
$worksheet->write_blank	(1, 6, $text_format_merge);
$worksheet->write_blank	(1, 7, $text_format_merge);
$worksheet->write_blank	(1, 8, $text_format_merge);
$worksheet->write_blank	(1, 9, $text_format_merge);

$worksheet->write(3, 0, "DEPARTEMEN", $text_format_line_bold);
$worksheet->write(3, 1, "NIP", $text_format_line_bold);
$worksheet->write(3, 2, "NAMA", $text_format_line_bold);
$worksheet->write		(3, 3, "TERLAMBAT", $text_format_merge_line_bold);
$worksheet->write_blank	(3, 4, $text_format_merge_line_bold);
$worksheet->write		(3, 5, "PULANG CEPAT", $text_format_merge_line_bold);
$worksheet->write_blank	(3, 6, $text_format_merge_line_bold);
$worksheet->write		(3, 7, "TIDAK MASUK", $text_format_merge_line_bold);
$worksheet->write_blank	(3, 8, $text_format_merge_line_bold);
$worksheet->write(3, 9, "JUMLAH JAM KERJA", $text_format_line_bold);

$worksheet->write(4, 0, "", $text_format_line_bold);
$worksheet->write(4, 1, "", $text_format_line_bold);
$worksheet->write(4, 2, "", $text_format_line_bold);
$worksheet->write(4, 3, "JUMLAH", $text_format_line_bold);
$worksheet->write(4, 4, "TANGGAL", $text_format_line_bold);
$worksheet->write(4, 5, "JUMLAH", $text_format_line_bold);
$worksheet->write(4, 6, "TANGGAL", $text_format_line_bold);
$worksheet->write(4, 7, "JUMLAH", $text_format_line_bold);
$worksheet->write(4, 8, "TANGGAL", $text_format_line_bold);
$worksheet->write(4, 9, "", $text_format_line_bold);

$row = 5;
while($absensi_rekap->nextRow())
{
	$worksheet->write($row, 0, $absensi_rekap->getField('DEPARTEMEN'), $text_format_line);
	$worksheet->write($row, 1, $absensi_rekap->getField('NRP'), $text_format_line);
	$worksheet->write($row, 2, $absensi_rekap->getField('NAMA'), $text_format_line_left);
	$worksheet->write($row, 3, $absensi_rekap->getField('TERLAMBAT'), $text_format_line);
	$worksheet->write($row, 4, $absensi_rekap->getField('TERLAMBAT_HARI'), $text_format_line);
	$worksheet->write($row, 5, $absensi_rekap->getField('PULANG_CEPAT'), $text_format_line);
	$worksheet->write($row, 6, $absensi_rekap->getField('PULANG_CEPAT_HARI'), $text_format_line);
	$worksheet->write($row, 7, "", $text_format_line);
	$worksheet->write($row, 8, "", $text_format_line);
	$worksheet->write($row, 9, "", $text_format_line);
	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"cetak_rekap.xls\"");
header("Content-Disposition: inline; filename=\"cetak_rekap.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>