<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
//include_once("../WEB-INF/classes/base-absensi/AbsensiKoreksi.php");

require_once "../WEB-INF/lib/excel/class.writeexcel_workbookbig.inc.php";
require_once "../WEB-INF/lib/excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "cetak_absensi_koreksi.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

/*$absensi_koreksi = new AbsensiKoreksi();

$reqBulan = httpFilterGet("reqBulan");
$reqTahun = httpFilterGet("reqTahun");

$reqDepartemen = httpFilterGet("reqDepartemen");
$reqStatusPegawai= httpFilterGet("reqStatusPegawai");

$periode = $reqBulan.$reqTahun;
if(substr($reqDepartemen, 0, 3) == "CAB")
	$statement = " AND EXISTS(SELECT 1 FROM IMASYS_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
	$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

if($reqStatusPegawai == '')
	$statement .= 'AND A.STATUS_PEGAWAI_ID = 1';
else
	$statement .= 'AND A.STATUS_PEGAWAI_ID = '.$reqStatusPegawai;

$absensi_koreksi->selectByParams(array(), -1, -1, $statement, $periode, " ORDER BY NAMA ASC");*/

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 3.71);
$worksheet->set_column(2, 2, 11.00);
$worksheet->set_column(3, 3, 11.00);
$worksheet->set_column(4, 4, 22.00);
$worksheet->set_column(5, 5, 11.00);
$worksheet->set_column(6, 6, 11.00);
$worksheet->set_column(7, 7, 17.71);
$worksheet->set_column(8, 8, 12.14);
$worksheet->set_column(9, 9, 12.14);
$worksheet->set_column(10, 10, 12.14);
$worksheet->set_column(11, 11, 12.14);
$worksheet->set_column(12, 12, 12.14);
$worksheet->set_column(13, 13, 12.14);
$worksheet->set_column(14, 14, 12.14);
$worksheet->set_column(15, 15, 25.43);

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
$worksheet->write(1, 1, "DAFTAR IURAN JAMSOSTEK", $text_format_merge);
$worksheet->write_blank(1, 2, $text_format_merge);
$worksheet->write_blank(1, 3, $text_format_merge);
$worksheet->write_blank(1, 4, $text_format_merge);
$worksheet->write_blank(1, 5, $text_format_merge);
$worksheet->write_blank(1, 6, $text_format_merge);
$worksheet->write_blank(1, 7, $text_format_merge);
$worksheet->write_blank(1, 8, $text_format_merge);
$worksheet->write_blank(1, 9, $text_format_merge);
$worksheet->write_blank(1, 10, $text_format_merge);
$worksheet->write_blank(1, 11, $text_format_merge);
$worksheet->write_blank(1, 12, $text_format_merge);
$worksheet->write_blank(1, 13, $text_format_merge);
$worksheet->write_blank(1, 14, $text_format_merge);
$worksheet->write_blank(1, 15, $text_format_merge);

$worksheet->write(2, 1, "PERIODE NOPEMBER 2012".getNamePeriode($periode), $text_format_merge);
$worksheet->write_blank(2, 2, $text_format_merge);
$worksheet->write_blank(2, 3, $text_format_merge);
$worksheet->write_blank(2, 4, $text_format_merge);
$worksheet->write_blank(2, 5, $text_format_merge);
$worksheet->write_blank(2, 6, $text_format_merge);
$worksheet->write_blank(2, 7, $text_format_merge);
$worksheet->write_blank(2, 8, $text_format_merge);
$worksheet->write_blank(2, 9, $text_format_merge);
$worksheet->write_blank(2, 10, $text_format_merge);
$worksheet->write_blank(2, 11, $text_format_merge);
$worksheet->write_blank(2, 12, $text_format_merge);
$worksheet->write_blank(2, 13, $text_format_merge);
$worksheet->write_blank(2, 14, $text_format_merge);
$worksheet->write_blank(2, 15, $text_format_merge);

$worksheet->write(3, 1, "KANTOR CABANG : N14 - TJ. PERAK", $text_format);
$worksheet->write(4, 1, "NPP - UNIT KERJA : NN140549 - 000", $text_format);
$worksheet->write(5, 1, "NAMA PERUSAHAAN : PT. PELINDO PROPERTI INDONESIA", $text_format);

$worksheet->write(7, 1, "DAFTAR PEGAWAI ORGANIK", $text_format);

$worksheet->write(9, 1, "NO", $text_format_line_bold);
$worksheet->write(9, 2, "NIK", $text_format_line_bold);
$worksheet->write(9, 3, "KPJ", $text_format_line_bold);
$worksheet->write(9, 4, "NAMA", $text_format_line_bold);
$worksheet->write(9, 5, "KAWIN", $text_format_line_bold);
$worksheet->write(9, 6, "TGL LAHIR", $text_format_line_bold);
$worksheet->write(9, 7, "PERIODE KEPESERTAAN", $text_format_line_bold);
$worksheet->write(9, 8, "UPAH TK", $text_format_line_bold);
$worksheet->write(9, 9, "RAPEL UPAH TK", $text_format_line_bold);
$worksheet->write(9, 10, "JHT (5,70%)", $text_format_line_bold);
$worksheet->write(9, 11, "JKM (0,30%)", $text_format_line_bold);
$worksheet->write(9, 12, "JKK (1,27%)", $text_format_line_bold);
$worksheet->write(9, 13, "JPK (3,00%)", $text_format_line_bold);
$worksheet->write(9, 14, "IURAN", $text_format_line_bold);
$worksheet->write(9, 15, "KETERANGAN", $text_format_line_bold);

$worksheet->write(10, 1, "1", $text_format_line);
$worksheet->write(10, 2, "711203872", $text_format_line);
$worksheet->write(10, 3, "00NC0139252", $text_format_line);
$worksheet->write(10, 4, "ABDUL HAKIM WAHYONO", $text_format_line_left);
$worksheet->write(10, 5, "T", $text_format_line);
$worksheet->write(10, 6, "24-12-1971", $text_format_line);
$worksheet->write(10, 7, "02-2008", $text_format_line);
$worksheet->write(10, 8, "276480", $uang_line);
$worksheet->write(10, 9, "0", $uang_line);
$worksheet->write(10, 10, "15798", $uang_line);
$worksheet->write(10, 11, "829", $uang_line);
$worksheet->write(10, 12, "3511", $uang_line);
$worksheet->write(10, 13, "8294", $uang_line);
$worksheet->write(10, 14, "28394", $uang_line);
$worksheet->write(10, 15, "Mutasi ke kantor pusat Sept 11", $text_format_line_left);

/*
$row = 4;
while($absensi_koreksi->nextRow())
{
	$worksheet->write($row, 1, $absensi_koreksi->getField('PEGAWAI_ID'), $text_format_line);
	$worksheet->write($row, 2, $absensi_koreksi->getField('KELOMPOK'), $text_format_line);
	$worksheet->write($row, 3, $absensi_koreksi->getField('NAMA'), $text_format_line_left);
	for ($k=4; $k<=34; $k++)
	{
			$worksheet->write($row, $k, $absensi_koreksi->getField('HARI_'.($k-3)), $text_format_line);
	}
	$row++;
}*/

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"cetak_absensi_koreksi.xls\"");
header("Content-Disposition: inline; filename=\"cetak_absensi_koreksi.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>