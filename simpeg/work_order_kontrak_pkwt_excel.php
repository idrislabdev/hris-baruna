<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

require_once "excel/class.writeexcel_workbookbig.inc.php";
require_once "excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqDepartemen = httpFilterGet("reqDepartemen");
$reqStatusPegawai= httpFilterGet("reqStatusPegawai");
$reqKelompok = httpFilterGet("reqKelompok");

$fname = tempnam("/tmp", "work_order_kontrak_pkwt.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

if(substr($reqDepartemen, 0, 3) == "CAB")
	$statement = " AND EXISTS(SELECT 1 FROM IMASYS_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
	$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

$statement .= " AND A.STATUS_PEGAWAI_ID = 1 ";
$statement .= " AND G.JENIS_PEGAWAI_ID = 3 AND (((G.TANGGAL_KONTRAK_AKHIR - INTERVAL '30' DAY) < SYSDATE AND G.TANGGAL_KONTRAK_AKHIR > SYSDATE) OR (G.TANGGAL_KONTRAK_AKHIR <= SYSDATE)) ";


$pegawai = new Pegawai();
$pegawai->selectByParamsKontrakPKWT(array(), -1, -1, $statement." " , " ORDER BY TO_NUMBER(D.KELAS) ASC, TO_NUMBER(D.NO_URUT) ASC");

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 5.00);
$worksheet->set_column(2, 2, 20.00);
$worksheet->set_column(3, 3, 33.00);
$worksheet->set_column(4, 4, 30.00);
$worksheet->set_column(5, 5, 10.00);
$worksheet->set_column(6, 6, 40.00);
$worksheet->set_column(7, 7, 10.00);
$worksheet->set_column(8, 8, 5.00);
$worksheet->set_column(9, 9, 18.00);
$worksheet->set_column(10, 10, 18.00);
$worksheet->set_column(11, 11, 18.00);
$worksheet->set_column(12, 12, 14.00);

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
	
$worksheet->write(1, 1, "DATA KONTRAK PKWT", $text_format);

$worksheet->write(4, 1, "NO.", $text_format_line_bold);
$worksheet->write(4, 2, "NRP", $text_format_line_bold);
$worksheet->write(4, 3, "NAMA", $text_format_line_bold);
$worksheet->write(4, 4, "JABATAN", $text_format_line_bold);
$worksheet->write(4, 5, "MKP", $text_format_line_bold);
$worksheet->write(4, 6, "DEPARTEMEN", $text_format_line_bold);
$worksheet->write(4, 7, "AGAMA", $text_format_line_bold);
$worksheet->write(4, 8, "L/P", $text_format_line_bold);
$worksheet->write(4, 9, "TANGGAL LAHIR", $text_format_line_bold);
$worksheet->write(4, 10, "KONTRAK AWAL", $text_format_line_bold);
$worksheet->write(4, 11, "KONTRAK AKHIR", $text_format_line_bold);
$worksheet->write(4, 12, "STATUS", $text_format_line_bold);

$row = 5;
$i=1;
while($pegawai->nextRow())
{	
	$worksheet->write($row, 1, $i,$text_format_line);
	$worksheet->write($row, 2, $pegawai->getField('NRP'),$text_format_line);
	$worksheet->write($row, 3, $pegawai->getField('NAMA'),$text_format_line);
	$worksheet->write($row, 4, $pegawai->getField('JABATAN_NAMA'),$text_format_line);
	$worksheet->write($row, 5, $pegawai->getField('MKP'),$text_format_line);
	$worksheet->write($row, 6, $pegawai->getField('DEPARTEMEN'),$text_format_line);
	$worksheet->write($row, 7, $pegawai->getField('AGAMA_NAMA'),$text_format_line);
	$worksheet->write($row, 8, $pegawai->getField('JENIS_KELAMIN'),$text_format_line);
	$worksheet->write($row, 9, getFormattedDate($pegawai->getField('TANGGAL_LAHIR')),$text_format_line_left);
	$worksheet->write($row, 10, getFormattedDate($pegawai->getField('TANGGAL_KONTRAK_AWAL')),$text_format_line_left);
	$worksheet->write($row, 11, getFormattedDate($pegawai->getField('TANGGAL_KONTRAK_AKHIR')),$text_format_line_left);
	$worksheet->write($row, 12, $pegawai->getField('STATUS_INFO'),$text_format_line);
	$row++;
	$i++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"work_order_kontrak_pkwt.xls\"");
header("Content-Disposition: inline; filename=\"work_order_kontrak_pkwt.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>