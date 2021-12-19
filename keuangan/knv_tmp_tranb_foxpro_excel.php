<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KeuanganPusat.php");

require_once "excel/class.writeexcel_workbookbig.inc.php";
require_once "excel/class.writeexcel_worksheet.inc.php";

$reqTahunBuku = httpFilterGet("reqTahunBuku");
$reqTahunBukuAkhir = httpFilterGet("reqTahunBukuAkhir");

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "TRAN_EXCEL_".$reqTahunBuku."_".$reqTahunBukuAkhir.".xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$keuangan_pusat = new KeuanganPusat();

$keuangan_pusat->selectByParamsTmpTranbFoxpro();

$col_row=0;
$worksheet->set_column($col_row, $col_row, 8.43);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 33.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 30.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 15.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 11.00);$col_row++;
$worksheet->set_column($col_row, $col_row, 15.00);

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

$text_format_merge_line_bold =& $workbook->addformat(array(size => 8, font => 'Arial Narrow', fg_color => 0x16));
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
$worksheet->write(1, 1, "DAFTAR TRANB FOXPRO PERIODE DARI ".getNamePeriode($reqTahunBuku)." SAMPAI ".getNamePeriode($reqTahunBukuAkhir), $text_format);

$col_row=1;
$worksheet->write(4, $col_row, "NOMOR", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "NO BUKTI PENDUKUNG", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "INDEX", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "JUN", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "KDBB01", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "KDBB02", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "KDBB03", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "RLBB01", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "RLBB02", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "RLBB03", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "RKBB01", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "STAT01", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "FSTATUS", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "TGL", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "AGEN", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "URAI01", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "URAI02", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "URAI03", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "URAI04", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "URAI05", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "BDUK01", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "BDUK02", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "JUMLAH", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "BNOPOS", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "BTGPOS", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "DEBET", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "KREDIT", $text_format_line_bold);$col_row++;
$worksheet->write(4, $col_row, "DIRECT_NAME", $text_format_line_bold);

$row = 5;

$inventaris = "";
while($keuangan_pusat->nextRow())
{
	$col_row=1;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("NOMOR"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("NOBUKTIPENDUKUNG"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("INDEKS"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, " ".$keuangan_pusat->getField("JUN"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("KDBB01"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, " ".$keuangan_pusat->getField("KDBB02"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, " ".$keuangan_pusat->getField("KDBB03"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("RLBB01"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("RLBB02"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("RLBB03"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("RKBB01"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("STAT01"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("FSTATUS"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, getFormattedDate($keuangan_pusat->getField("TGL")), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("AGEN"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("URAI01"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("URAI02"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("URAI03"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("URAI04"), $uang_line);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("URAI05"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("BDUK01"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, getFormattedDate($keuangan_pusat->getField("BDUK02")), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("JUMLAH"), $uang_line);$col_row++;
	$worksheet->write($row, $col_row, " ".$keuangan_pusat->getField("BNOPOS"), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, getFormattedDate($keuangan_pusat->getField("BTGPOS")), $text_format_line_left);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("DEBET"), $uang_line);$col_row++;
	$worksheet->write($row, $col_row, $keuangan_pusat->getField("KREDIT"), $uang_line);$col_row++;
	$worksheet->write($row, $col_row, " ".$keuangan_pusat->getField("DIRECT_NAME"), $text_format_line_left);
	
	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"TRAN_EXCEL_".$reqTahunBuku."_".$reqTahunBukuAkhir.".xls\"");
header("Content-Disposition: inline; filename=\"TRAN_EXCEL_".$reqTahunBuku."_".$reqTahunBukuAkhir.".xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>