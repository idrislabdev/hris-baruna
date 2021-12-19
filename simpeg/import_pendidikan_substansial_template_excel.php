<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");

require_once "excel/class.writeexcel_workbookbig.inc.php";
require_once "excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");
//$reqLokasi = httpFilterGet("reqLokasi");

$fname = tempnam("/tmp", "import_pendidikan_substansial_template.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$worksheet->set_column(0, 0, 14.00);
$worksheet->set_column(1, 1, 27.20);
$worksheet->set_column(2, 2, 14.00);
$worksheet->set_column(3, 3, 14.00);

//$worksheet->write_string();
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

$text_format_center =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow', fg_color => 0x16));
$text_format_center->set_color('black');
$text_format_center->set_size(8);
$text_format_center->set_border_color('black');
$text_format_center->set_bold(1);

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

$text_format_line_right =& $workbook->addformat(array(align => 'left', size => 8, font => 'Arial Narrow', fg_color => 0x16));
$text_format_line_right->set_color('black');
$text_format_line_right->set_size(8);
$text_format_line_right->set_border_color('black');
$text_format_line_right->set_right(1);

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

$date_format=& $workbook->addformat(array(num_format => 'mm-dd-yyyy', size => 8, font => 'Arial Narrow'));
$date_format->set_color('black');
$date_format->set_size(8);
$date_format->set_border_color('black');


$uang_line =& $workbook->addformat(array(num_format => '#,##0.##', size => 8, font => 'Arial Narrow'));
$uang_line->set_color('black');
$uang_line->set_size(8);
$uang_line->set_border_color('black');
$uang_line->set_left(1);
$uang_line->set_right(1);
$uang_line->set_top(1);
$uang_line->set_bottom(1);


//$worksheet->write(0, 0, "PEGAWAI_ID", $text_format_line_bold);
//$worksheet->write(0, 1, "PEGAWAI_PEND_PERJENJANGAN_ID", $text_format_line_bold);
$worksheet->write(0, 0, "NRP", $text_format_line_bold);
$worksheet->write(0, 1, "NAMA", $text_format_line_bold);
$worksheet->write(0, 2, "TANGGAL_AWAL", $text_format_line_bold);
$worksheet->write(0, 3, "TANGGAL_AKHIR", $text_format_line_bold);

$reqTanggalAwal='2012-08-01';	$reqTanggalAkhir='2012-09-01';

$aColumns = array('PEGAWAI_ID', 'NAMA');
$aColumnsAlias = array('PEGAWAI_ID', 'NAMA');

$reqTanggalAwal='2012-08-01';	$reqTanggalAkhir='2012-09-01';

$bulan = substr($reqPeriode, 0,2);
$tahun = substr($reqPeriode, 2,4);

$reqTanggalAwal=$tahun.'-'.$bulan.'-01';
$reqTanggalAkhir=$tahun.'-09-01';

$reqTanggalAkhir=date("Y-m-d", strtotime("+1 month", strtotime($reqTanggalAwal)));

$row = 2;
//while (strtotime($reqTanggalAwal) < strtotime($reqTanggalAkhir)) 
//{
	$worksheet->write($row, 0, "", $text_format);
	$worksheet->write($row, 1, "", $text_format);
	$worksheet->write($row, 2, "", $text_format);
	$worksheet->write($row, 3, "", $text_format);
	
	//$hari=getDay($reqTanggalAwal);
	
	//$worksheet->write($row, 20, $hari, $text_format);
	//$row++;
	//$reqTanggalAwal = date ("Y-m-d", strtotime("+1 day", strtotime($reqTanggalAwal)));
//}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"import_pendidikan_substansial_template.xls\"");
header("Content-Disposition: inline; filename=\"import_pendidikan_substansial_template.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>