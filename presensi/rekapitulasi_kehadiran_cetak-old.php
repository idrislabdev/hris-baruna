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

$fname = tempnam("/tmp", "cetak_rekapitulasi_kehadiran.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$absensi_rekap = new AbsensiRekap();

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

$absensi_rekap->selectByParamsRekapKehadiranKoreksi($periode, array(), -1, -1, $statement, " ORDER BY NAMA ASC");

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 29.00);
$worksheet->set_column(2, 2, 11.00);

for ($j=3; $j<=19; $j++)
{
	$worksheet->set_column($j, $j, 6.86);
}

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
$worksheet->write(1, 1, "DAFTAR KEHADIRAN", $text_format);
$worksheet->write(2, 1, "BULAN ".getNamePeriode($periode), $text_format);

$worksheet->write(4, 1, "NAMA", $text_format_line_bold);
$worksheet->write(4, 2, "KELOMPOK", $text_format_line_bold);
$worksheet->write		(4, 3, "HADIR", $text_format_merge_line_bold);
$worksheet->write_blank	(4, 4, $text_format_merge_line_bold);
$worksheet->write_blank	(4, 5, $text_format_merge_line_bold);
$worksheet->write_blank	(4, 6, $text_format_merge_line_bold);
$worksheet->write_blank	(4, 7, $text_format_merge_line_bold);
$worksheet->write		(4, 8, "SAKIT", $text_format_merge_line_bold);
$worksheet->write_blank	(4, 9, $text_format_merge_line_bold);
$worksheet->write_blank	(4, 10, $text_format_merge_line_bold);
$worksheet->write		(4, 11, "IJIN", $text_format_merge_line_bold);
$worksheet->write_blank	(4, 12, $text_format_merge_line_bold);
$worksheet->write_blank	(4, 13, $text_format_merge_line_bold);
$worksheet->write		(4, 14, "CUTI", $text_format_merge_line_bold);
$worksheet->write_blank	(4, 15, $text_format_merge_line_bold);
$worksheet->write_blank	(4, 16, $text_format_merge_line_bold);
$worksheet->write_blank	(4, 17, $text_format_merge_line_bold);
$worksheet->write_blank	(4, 18, $text_format_merge_line_bold);
$worksheet->write(4, 19, "DINAS", $text_format_line_bold);
$worksheet->write(4, 20, "ALPHA", $text_format_line_bold);

$worksheet->write(5, 1, "", $text_format_line);
$worksheet->write(5, 2, "", $text_format_line);
$worksheet->write(5, 3, "JML", $text_format_line);
$worksheet->write(5, 4, "H", $text_format_line);
$worksheet->write(5, 5, "HT", $text_format_line);
$worksheet->write(5, 6, "HPC", $text_format_line);
$worksheet->write(5, 7, "HTPC", $text_format_line);
$worksheet->write(5, 8, "JML", $text_format_line);
$worksheet->write(5, 9, "STK", $text_format_line);
$worksheet->write(5, 10, "SDK", $text_format_line);
$worksheet->write(5, 11, "JML", $text_format_line);
$worksheet->write(5, 12, "ITK", $text_format_line);
$worksheet->write(5, 13, "IDK", $text_format_line);
$worksheet->write(5, 14, "JML", $text_format_line);
$worksheet->write(5, 15, "CT", $text_format_line);
$worksheet->write(5, 16, "CAP", $text_format_line);
$worksheet->write(5, 17, "CS", $text_format_line);
$worksheet->write(5, 18, "CB", $text_format_line);
$worksheet->write(5, 19, "", $text_format_line);
$worksheet->write(5, 20, "", $text_format_line);


$row = 6;
while($absensi_rekap->nextRow())
{
	$worksheet->write($row, 1, $absensi_rekap->getField('NAMA'), $text_format_line_left);
	$worksheet->write($row, 2, $absensi_rekap->getField('KELOMPOK'), $text_format_line);
	$worksheet->write($row, 3, $absensi_rekap->getField('JUMLAH_H'), $text_format_line);
	$worksheet->write($row, 4, $absensi_rekap->getField('H'), $text_format_line);
	$worksheet->write($row, 5, $absensi_rekap->getField('HT'), $text_format_line);
	$worksheet->write($row, 6, $absensi_rekap->getField('HPC'), $text_format_line);
	$worksheet->write($row, 7, $absensi_rekap->getField('HTPC'), $text_format_line);
	$worksheet->write($row, 8, $absensi_rekap->getField('JUMLAH_S'), $text_format_line);
	$worksheet->write($row, 9, $absensi_rekap->getField('STK'), $text_format_line);
	$worksheet->write($row, 10, $absensi_rekap->getField('SDK'), $text_format_line);
	$worksheet->write($row, 11, $absensi_rekap->getField('JUMLAH_I'), $text_format_line);
	$worksheet->write($row, 12, $absensi_rekap->getField('ITK'), $text_format_line);
	$worksheet->write($row, 13, $absensi_rekap->getField('IDK'), $text_format_line);
	$worksheet->write($row, 14, $absensi_rekap->getField('JUMLAH_C'), $text_format_line);
	$worksheet->write($row, 15, $absensi_rekap->getField('CT'), $text_format_line);
	$worksheet->write($row, 16, $absensi_rekap->getField('CAP'), $text_format_line);
	$worksheet->write($row, 17, $absensi_rekap->getField('CS'), $text_format_line);
	$worksheet->write($row, 18, $absensi_rekap->getField('CB'), $text_format_line);
	$worksheet->write($row, 19, $absensi_rekap->getField('DL'), $text_format_line);
	$worksheet->write($row, 20, $absensi_rekap->getField('JUMLAH_A'), $text_format_line);
	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"cetak_rekapitulasi_kehadiran.xls\"");
header("Content-Disposition: inline; filename=\"cetak_rekapitulasi_kehadiran.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>