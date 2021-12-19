<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/Premi.php");

require_once "../WEB-INF/lib/excel/class.writeexcel_workbookbig.inc.php";
require_once "../WEB-INF/lib/excel/class.writeexcel_worksheet.inc.php";

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "premi_awak_kapal_excel.xls");
$workbook = & new writeexcel_workbookbig($fname);
//$worksheet = &$workbook->addworksheet();

$workbook = &new writeexcel_workbook($fname);

$premi = new Premi();
$reqPeriode = httpFilterGet("reqPeriode");
$reqJenisPegawai = httpFilterGet("reqJenisPegawai");

if($reqJenisPegawai == "")
{}
else
	$statement .= "AND JENIS_PEGAWAI = ".$reqJenisPegawai;

$premi->selectByParamsReportKeuangan(array(), -1, -1, $statement, $reqPeriode, " ORDER BY JENIS_PEGAWAI_ID, NAMA_BANK ");

$worksheet =& $workbook->addworksheet();
$worksheet->set_column(0, 0, 3.43);
$worksheet->set_column(1, 1, 40.00);
$worksheet->set_column(2, 2, 14.00);
$worksheet->set_column(3, 3, 14.00);
$worksheet->set_column(4, 4, 25.00);
$worksheet->set_column(5, 5, 10.00);
$worksheet->set_column(6, 6, 25.00);
$worksheet->set_column(7, 7, 25.00);

$tanggal =& $workbook->addformat(array(num_format => ' dd mmmm yyy'));

$text_format =& $workbook->addformat(array( size => 10, font => 'Arial Narrow'));
$text_format_num =& $workbook->addformat(array( num_format => '###', size => 8, font => 'Arial Narrow', align => 'center'));
$text_format_num->set_left(1);
$text_format_num->set_right(1);
$text_format_num->set_top(1);
$text_format_num->set_bottom(1);

$text_format_left_none =& $workbook->addformat(array( size => 8, font => 'Arial Narrow'));
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
$text_format_line_left->set_text_wrap();


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
$worksheet->write		(1, 1, "REKAPITULASI PENERIMAAN PREMI AWAK KAPAL", $text_format_merge);
$worksheet->write_blank	(1, 2, $text_format_merge);
$worksheet->write_blank	(1, 3, $text_format_merge);
$worksheet->write_blank	(1, 4, $text_format_merge);
$worksheet->write_blank	(1, 5, $text_format_merge);
$worksheet->write_blank	(1, 6, $text_format_merge);
$worksheet->write_blank	(1, 7, $text_format_merge);

$worksheet->write(2, 1, "BULAN : ".strtoupper(getNamePeriode($reqPeriode)), $text_format_merge);
$worksheet->write_blank	(2, 2, $text_format_merge);
$worksheet->write_blank	(2, 3, $text_format_merge);
$worksheet->write_blank	(2, 4, $text_format_merge);
$worksheet->write_blank	(2, 5, $text_format_merge);
$worksheet->write_blank	(2, 6, $text_format_merge);
$worksheet->write_blank	(2, 7, $text_format_merge);

//$worksheet->write(4, 1, strtoupper($departemen->getField("DEPARTEMEN")), $text_format_left_none);

$worksheet->write(6, 0, "NO.", $text_format_line_bold);
$worksheet->write(6, 1, "NAMA", $text_format_line_bold);
$worksheet->write(6, 2, "NRP", $text_format_line_bold);
$worksheet->write(6, 3, "NO REKENING", $text_format_line_bold);
$worksheet->write(6, 4, "TOTAL INSENTIF", $text_format_line_bold);
$worksheet->write(6, 5, "% PPH", $text_format_line_bold);
$worksheet->write(6, 6, "POTONGAN PPH", $text_format_line_bold);
$worksheet->write(6, 7, "JUMLAH YANG DITERIMA", $text_format_line_bold);

/*$worksheet->write(5, 1, "167121872", $text_format_line);
$worksheet->write(5, 2, "LUSIA TIVIANIE, SH, MH", $text_format_line_left);
$worksheet->write(5, 3, "5", $text_format_line);
$worksheet->write(5, 4, "Manager SDM dan Umum", $text_format_line_left);*/

				   
$row = 7;
$no = 1;
$kelompok = "";
$jenis_pegawai = "";
$nama_bank = "";
while($premi->nextRow())
{
	if($jenis_pegawai == $premi->getField("JENIS_PEGAWAI"))
	{}
	else
	{
		$worksheet->write($row, 0, $premi->getField("JENIS_PEGAWAI"), $text_format_merge_line_bold);
		$worksheet->write_blank($row, 1, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 2, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 3, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 4, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 5, $text_format_merge_line_bold);	
		$worksheet->write_blank($row, 6, $text_format_merge_line_bold);		
		$worksheet->write_blank($row, 7, $text_format_merge_line_bold);		
		$row++;
	}
	
	if($nama_bank == $premi->getField("NAMA_BANK"))
	{}
	else
	{
		$worksheet->write($row, 0, $premi->getField("NAMA_BANK"), $text_format_merge_line_bold);
		$worksheet->write_blank($row, 1, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 2, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 3, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 4, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 5, $text_format_merge_line_bold);	
		$worksheet->write_blank($row, 6, $text_format_merge_line_bold);		
		$worksheet->write_blank($row, 7, $text_format_merge_line_bold);		
		$row++;
	}
	
	$worksheet->write($row, 0, $no, $text_format_line);
	$worksheet->write($row, 1, $premi->getField("AWAK_KAPAL"), $text_format_line_left);
	$worksheet->write($row, 2, $premi->getField("NRP"), $text_format_line_left);
	$worksheet->write($row, 3, " " . $premi->getField("REKENING_NO"), $text_format_line_left);
	$worksheet->write($row, 4, $premi->getField("TOTAL_INSENTIF"), $uang_line);
	$worksheet->write($row, 5, $premi->getField("PPH"), $uang_line);
	$worksheet->write($row, 6, $premi->getField("JUMLAH_PPH"), $uang_line);
	$worksheet->write($row, 7, $premi->getField("JUMLAH_DITERIMA"), $uang_line);
	$jenis_pegawai = $premi->getField("JENIS_PEGAWAI");	
	$nama_bank = $premi->getField("NAMA_BANK");	
	$no++;
	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"premi_awak_kapal_excel.xls\"");
header("Content-Disposition: inline; filename=\"premi_awak_kapal_excel.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>