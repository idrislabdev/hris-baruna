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
$worksheet->set_column(3, 3, 24.00);
$worksheet->set_column(4, 4, 12.14);
$worksheet->set_column(5, 5, 16.00);
$worksheet->set_column(6, 6, 21.00);

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
$worksheet->write(1, 1, "PT. (PERSERO) PELABUHAN INDONESIA III".getNamePeriode($periode), $text_format);
$worksheet->write(2, 1, "CABANG : SURABAYA", $text_format);

$worksheet->write		(4, 1, "DAFTAR SELURUH POTONGAN", $text_format_merge);
$worksheet->write_blank	(4, 2, $text_format_merge);
$worksheet->write_blank	(4, 3, $text_format_merge);
$worksheet->write_blank	(4, 4, $text_format_merge);
$worksheet->write_blank	(4, 5, $text_format_merge);
$worksheet->write_blank	(4, 6, $text_format_merge);

$worksheet->write		(5, 1, "BULAN : DESEMBER 2012", $text_format_merge);
$worksheet->write_blank	(5, 2, $text_format_merge);
$worksheet->write_blank	(5, 3, $text_format_merge);
$worksheet->write_blank	(5, 4, $text_format_merge);
$worksheet->write_blank	(5, 5, $text_format_merge);
$worksheet->write_blank	(5, 6, $text_format_merge);


$worksheet->write(7, 1, "KREDIT UANG TAMBAHAN", $text_format);

$worksheet->write(9, 1, "NO", $text_format_line_bold);
$worksheet->write(9, 2, "PEGAWAI ID", $text_format_line_bold);
$worksheet->write(9, 3, "NAMA", $text_format_line_bold);
$worksheet->write(9, 4, "ANGSURAN KE-", $text_format_line_bold);
$worksheet->write(9, 5, "JUMLAH (Rp.)", $text_format_line_bold);
$worksheet->write(9, 6, "KETERANGAN", $text_format_line_bold);

$worksheet->write(10, 1, "1", $text_format_line);
$worksheet->write(10, 2, "800504231", $text_format_line);
$worksheet->write(10, 3, "AGUS PURNOMO", $text_format_line_left);
$worksheet->write(10, 4, "1", $text_format_line);
$worksheet->write(10, 5, "440000", $uang_line);
$worksheet->write(10, 6, "AMBIL SERTIFIKAT", $text_format_line_left);

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