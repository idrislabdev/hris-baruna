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

$fname = tempnam("/tmp", "cetak_rekapitulasi_terlambat_pulang_cepat.xls");
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

$absensi_rekap->selectByParamsRekapTerlambatPulangKoreksi($periode, array(), -1, -1, $statement, " ORDER BY NAMA ASC");

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 29.00);
$worksheet->set_column(2, 2, 9.57);
$worksheet->set_column(3, 3, 9.57);
$worksheet->set_column(4, 4, 9.57);
$worksheet->set_column(5, 5, 27.00);
$worksheet->set_column(6, 6, 12.00);
$worksheet->set_column(7, 7, 16.71);
$worksheet->set_column(8, 8, 11.00);
$worksheet->set_column(9, 9, 47.00);

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
$worksheet->write(1, 1, "DETAIL KEHADIRAN", $text_format);
$worksheet->write(2, 1, "BULAN ".getNamePeriode($periode), $text_format);

$worksheet->write(4, 1, "NAMA", $text_format_line_bold);
$worksheet->write(4, 2, "KELOMPOK", $text_format_line_bold);
$worksheet->write(4, 3, "MASUK", $text_format_line_bold);
$worksheet->write(4, 4, "TERLAMBAT", $text_format_line_bold);
$worksheet->write(4, 5, "TERLAMBAT HARI", $text_format_line_bold);
$worksheet->write(4, 6, "PULANG CEPAT", $text_format_line_bold);
$worksheet->write(4, 7, "PULANG CEPAT HARI", $text_format_line_bold);
$worksheet->write(4, 8, "TIDAK MASUK", $text_format_line_bold);
$worksheet->write(4, 9, "TIDAK MASUK HARI", $text_format_line_bold);

$row = 5;
while($absensi_rekap->nextRow())
{
	$worksheet->write($row, 1, $absensi_rekap->getField('NAMA'), $text_format_line_left);
	$worksheet->write($row, 2, $absensi_rekap->getField('KELOMPOK'), $text_format_line);
	$worksheet->write($row, 3, $absensi_rekap->getField('JUMLAH_H'), $text_format_line);
	$worksheet->write($row, 4, $absensi_rekap->getField('JUMLAH_HT'), $text_format_line);
	$worksheet->write($row, 5, $absensi_rekap->getField('HT'), $text_format_line);
	$worksheet->write($row, 6, $absensi_rekap->getField('JUMLAH_HPC'), $text_format_line);
	$worksheet->write($row, 7, $absensi_rekap->getField('PC'), $text_format_line);
	$worksheet->write($row, 8, $absensi_rekap->getField('JUMLAH_TM'), $text_format_line);
	$worksheet->write($row, 9, $absensi_rekap->getField('TM'), $text_format_line);
	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"cetak_rekapitulasi_terlambat_pulang_cepat.xls\"");
header("Content-Disposition: inline; filename=\"cetak_rekapitulasi_terlambat_pulang_cepat.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>