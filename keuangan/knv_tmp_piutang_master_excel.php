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

$Tahun = substr($reqTahunBuku, 2, 4);
$bulan = substr($reqTahunBuku, 0, 2);

$periode = $Tahun.$bulan;

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "PIUT_EXCEL_".$reqTahunBuku."_".$reqTahunBukuAkhir.".xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$keuangan_pusat = new KeuanganPusat();

$keuangan_pusat->selectByParamsTmpPiutangMaster();

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 11.00);
$worksheet->set_column(2, 2, 14.00);
$worksheet->set_column(3, 3, 11.00);
$worksheet->set_column(4, 4, 11.00);
$worksheet->set_column(5, 5, 11.00);
$worksheet->set_column(6, 6, 11.00);
$worksheet->set_column(7, 7, 11.00);
$worksheet->set_column(8, 8, 11.00);
$worksheet->set_column(9, 9, 11.00);
$worksheet->set_column(10, 10, 11.00);
$worksheet->set_column(11, 11, 11.00);
$worksheet->set_column(12, 12, 11.00);
$worksheet->set_column(13, 13, 11.00);
$worksheet->set_column(14, 14, 15.00);
$worksheet->set_column(15, 15, 15.00);
$worksheet->set_column(16, 16, 15.00);
$worksheet->set_column(17, 17, 15.00);
$worksheet->set_column(18, 18, 11.00);
$worksheet->set_column(19, 19, 11.00);
$worksheet->set_column(20, 20, 11.00);
$worksheet->set_column(21, 21, 11.00);

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
$worksheet->write(1, 1, "DAFTAR PIUTANG MASTER PERIODE DARI ".getNamePeriode($reqTahunBuku)." SAMPAI ".getNamePeriode($reqTahunBukuAkhir), $text_format);

$worksheet->write(4, 1, "KD_CABANG", $text_format_line_bold);
$worksheet->write(4, 2, "BADAN_USAHA", $text_format_line_bold);
$worksheet->write(4, 3, "KD_PELAYANAN", $text_format_line_bold);
$worksheet->write(4, 4, "KD_KUSTO", $text_format_line_bold);
$worksheet->write(4, 5, "MPLG_NAMA", $text_format_line_bold);
$worksheet->write(4, 6, "NO_NOTA", $text_format_line_bold);
$worksheet->write(4, 7, "BULTAH", $text_format_line_bold);
$worksheet->write(4, 8, "TGL_TRANS", $text_format_line_bold);
$worksheet->write(4, 9, "TIPE_TRANS", $text_format_line_bold);
$worksheet->write(4, 10, "NO_REF_UTAMA", $text_format_line_bold);
$worksheet->write(4, 11, "NO_REF3", $text_format_line_bold);
$worksheet->write(4, 12, "PREV_NO_NOTA", $text_format_line_bold);
$worksheet->write(4, 13, "KET_NOTA", $text_format_line_bold);
$worksheet->write(4, 14, "JML_SALDO_AWAL", $text_format_line_bold);
$worksheet->write(4, 15, "JML_DEBET", $text_format_line_bold);
$worksheet->write(4, 16, "JML_KREDIT", $text_format_line_bold);
$worksheet->write(4, 17, "JML_SALDO_AKHIR", $text_format_line_bold);
$worksheet->write(4, 18, "KD_VALUTA", $text_format_line_bold);
$worksheet->write(4, 19, "KURS_VALUTA", $text_format_line_bold);
$worksheet->write(4, 20, "KD_BB_KUSTO", $text_format_line_bold);
$worksheet->write(4, 21, "DIRECT_NAME", $text_format_line_bold);

$row = 5;

$inventaris = "";
while($keuangan_pusat->nextRow())
{
	$worksheet->write($row, 1, $keuangan_pusat->getField("KD_CABANG"), $text_format_line_left);
	$worksheet->write($row, 2, $keuangan_pusat->getField("BADAN_USAHA"), $text_format_line_left);
	$worksheet->write($row, 3, $keuangan_pusat->getField("KD_PELAYANAN"), $text_format_line_left);
	$worksheet->write($row, 4, " ".$keuangan_pusat->getField("KD_KUSTO"), $text_format_line_left);
	$worksheet->write($row, 5, $keuangan_pusat->getField("MPLG_NAMA"), $text_format_line_left);
	$worksheet->write($row, 6, $keuangan_pusat->getField("NO_NOTA"), $text_format_line_left);
	$worksheet->write($row, 7, $keuangan_pusat->getField("BULTAH"), $text_format_line_left);
	$worksheet->write($row, 8, getFormattedDate($keuangan_pusat->getField("TGL_TRANS")), $text_format_line_left);
	$worksheet->write($row, 9, $keuangan_pusat->getField("TIPE_TRANS"), $text_format_line_left);
	$worksheet->write($row, 10, $keuangan_pusat->getField("NO_REF_UTAMA"), $text_format_line_left);
	$worksheet->write($row, 11, $keuangan_pusat->getField("NO_REF3"), $text_format_line_left);
	$worksheet->write($row, 12, $keuangan_pusat->getField("PREV_NO_NOTA"), $text_format_line_left);
	$worksheet->write($row, 13, $keuangan_pusat->getField("KET_NOTA"), $text_format_line_left);
	$worksheet->write($row, 14, $keuangan_pusat->getField("JML_SALDO_AWAL"), $uang_line);
	$worksheet->write($row, 15, $keuangan_pusat->getField("JML_DEBET"), $uang_line);
	$worksheet->write($row, 16, $keuangan_pusat->getField("JML_KREDIT"), $uang_line);
	$worksheet->write($row, 17, $keuangan_pusat->getField("JML_SALDO_AKHIR"), $uang_line);
	$worksheet->write($row, 18, $keuangan_pusat->getField("KD_VALUTA"), $text_format_line_left);
	$worksheet->write($row, 19, $keuangan_pusat->getField("KURS_VALUTA"), $text_format_line_left);
	$worksheet->write($row, 20, $keuangan_pusat->getField("KD_BB_KUSTO"), $text_format_line_left);
	$worksheet->write($row, 21, " ".$keuangan_pusat->getField("DIRECT_NAME"), $text_format_line_left);
	
	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"PIUT_EXCEL_".$reqTahunBuku."_".$reqTahunBukuAkhir.".xls\"");
header("Content-Disposition: inline; filename=\"PIUT_EXCEL_".$reqTahunBuku."_".$reqTahunBukuAkhir.".xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>