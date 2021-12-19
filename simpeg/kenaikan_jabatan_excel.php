<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-simpeg/KenaikanJabatan.php");

require_once "excel/class.writeexcel_workbookbig.inc.php";
require_once "excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqStatus = httpFilterGet("reqStatus");

$fname = tempnam("/tmp", "kenaikan_jabatan.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$kenaikan_jabatan = new KenaikanJabatan();
$kenaikan_jabatan->selectByParams(array("STATUS" => $reqStatus), -1, -1, $statement." " , $sOrder);

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 5.00);
$worksheet->set_column(2, 2, 15.00);
$worksheet->set_column(3, 3, 15.00);
$worksheet->set_column(4, 4, 30.00);
$worksheet->set_column(5, 5, 30.00);
$worksheet->set_column(6, 6, 30.00);
$worksheet->set_column(7, 7, 30.00);
$worksheet->set_column(8, 8, 30.00);

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
$text_format_line->set_text_wrap();

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

$text_format_merge_line_bold_top =& $workbook->addformat(array(size => 8, font => 'Arial Narrow'));
$text_format_merge_line_bold_top->set_color('black');
$text_format_merge_line_bold_top->set_size(8);
$text_format_merge_line_bold_top->set_border_color('black');
$text_format_merge_line_bold_top->set_merge(1);
$text_format_merge_line_bold_top->set_bold(1);
$text_format_merge_line_bold_top->set_left(1);
$text_format_merge_line_bold_top->set_right(1);
$text_format_merge_line_bold_top->set_top(1);
//$text_format_merge_line_bold_top->set_fg_color('white');

$text_format_merge_line_bold_bottom =& $workbook->addformat(array(size => 8, font => 'Arial Narrow'));
$text_format_merge_line_bold_bottom->set_color('black');
$text_format_merge_line_bold_bottom->set_size(8);
$text_format_merge_line_bold_bottom->set_border_color('black');
$text_format_merge_line_bold_bottom->set_merge(1);
$text_format_merge_line_bold_bottom->set_bold(1);
$text_format_merge_line_bold_bottom->set_left(1);
$text_format_merge_line_bold_bottom->set_right(1);
$text_format_merge_line_bold_bottom->set_top(1);
$text_format_merge_line_bold_bottom->set_bottom(1);
//$text_format_merge_line_bold_bottom->set_fg_color('white');

$text_format_line_bold_top =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow'));
$text_format_line_bold_top->set_color('black');
$text_format_line_bold_top->set_size(8);
$text_format_line_bold_top->set_border_color('black');
$text_format_line_bold_top->set_bold(1);
$text_format_line_bold_top->set_left(1);
$text_format_line_bold_top->set_right(1);
$text_format_line_bold_top->set_top(1);
//$text_format_line_bold_top->set_fg_color('white');

$text_format_line_bold_bottom =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow'));
$text_format_line_bold_bottom->set_color('black');
$text_format_line_bold_bottom->set_size(8);
$text_format_line_bold_bottom->set_border_color('black');
$text_format_line_bold_bottom->set_bold(1);
$text_format_line_bold_bottom->set_left(1);
$text_format_line_bold_bottom->set_right(1);
$text_format_line_bold_bottom->set_bottom(1);
//$text_format_line_bold_bottom->set_fg_color('white');

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
	
$worksheet->write(1, 1, "DATA KENAIKAN JABATAN", $text_format);

$worksheet->write(4, 1, "NO", $text_format_line_bold_top);
$worksheet->write(4, 2, "NRP", $text_format_line_bold_top);
$worksheet->write(4, 3, "NIPP", $text_format_line_bold_top);
$worksheet->write(4, 4, "NAMA", $text_format_line_bold_top);
$worksheet->write		(4, 5, "SEBELUM", $text_format_merge_line_bold_top);
$worksheet->write_blank	(4, 6, $text_format_merge_line_bold_top);
$worksheet->write		(4, 7, "SESUDAH", $text_format_merge_line_bold_top);
$worksheet->write_blank	(4, 8, $text_format_merge_line_bold_top);

$worksheet->write(5, 1, "", $text_format_line_bold_bottom);
$worksheet->write(5, 2, "", $text_format_line_bold_bottom);
$worksheet->write(5, 3, "", $text_format_line_bold_bottom);
$worksheet->write(5, 4, "", $text_format_line_bold_bottom);
$worksheet->write(5, 5, "DEPARTEMEN", $text_format_merge_line_bold_bottom);
$worksheet->write(5, 6, "JABATAN", $text_format_merge_line_bold_bottom);
$worksheet->write(5, 7, "DEPARTEMEN", $text_format_merge_line_bold_bottom);
$worksheet->write(5, 8, "JABATAN", $text_format_merge_line_bold_bottom);

$row = 6;
$i=1;
while($kenaikan_jabatan->nextRow())
{	
	$worksheet->write($row, 1, $i,$text_format_line);
	$worksheet->write($row, 2, $kenaikan_jabatan->getField('NRP'),$text_format_line);
	$worksheet->write($row, 3, $kenaikan_jabatan->getField('NIPP'),$text_format_line);
	$worksheet->write($row, 4, $kenaikan_jabatan->getField('NAMA'),$text_format_line);
	
	$val = $kenaikan_jabatan->getField('DEPARTEMEN_ID_SEBELUM_NAMA');
	if(strlen($val) > 100)
	{
		$worksheet->write($row, 5, substr($val, 0, 100)."\n".substr($val,101, strlen($val)), $text_format_line);
	}
	else
	{
		$worksheet->write($row, 5, $val, $text_format_line);
	}
	
	$val = $kenaikan_jabatan->getField('JABATAN_ID_SEBELUM_NAMA');
	if(strlen($val) > 100)
	{
		$worksheet->write($row, 6, substr($val, 0, 100)."\n".substr($val,101, strlen($val)), $text_format_line);
	}
	else
	{
		$worksheet->write($row, 6, $val, $text_format_line);
	}
	
	$val = $kenaikan_jabatan->getField('DEPARTEMEN_ID_SESUDAH_NAMA');
	if(strlen($val) > 100)
	{
		$worksheet->write($row, 7, substr($val, 0, 100)."\n".substr($val,101, strlen($val)), $text_format_line);
	}
	else
	{
		$worksheet->write($row, 7, $val, $text_format_line);
	}
	
	$val = $kenaikan_jabatan->getField('JABATAN_ID_SESUDAH_NAMA');
	if(strlen($val) > 100)
	{
		$worksheet->write($row, 8, substr($val, 0, 100)."\n".substr($val,101, strlen($val)), $text_format_line);
	}
	else
	{
		$worksheet->write($row, 8, $val, $text_format_line);
	}
	
	$row++;
	$i++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"kenaikan_jabatan.xls\"");
header("Content-Disposition: inline; filename=\"kenaikan_jabatan.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>