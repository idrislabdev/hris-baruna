<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/UangMakanBantuan.php");

require_once "../WEB-INF/lib/excel/class.writeexcel_workbookbig.inc.php";
require_once "../WEB-INF/lib/excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "uang_makan_excel.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$uang_makan_bantuan = new UangMakanBantuan();

$reqPeriode = httpFilterGet("reqPeriode");
$reqJenisPegawai = httpFilterGet("reqJenisPegawai");


if($reqJenisPegawai == "")
{}
else
	$statement .= "AND C.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;

$uang_makan_bantuan->selectByParams(array(), -1, -1, $statement, $reqPeriode, " ORDER BY A.NAMA_BANK, C.JENIS_PEGAWAI_ID, A.NAMA ASC");
//echo $uang_makan_bantuan->query;exit;
$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 11.00);
$worksheet->set_column(2, 2, 30.00);
$worksheet->set_column(3, 3, 35.00);
$worksheet->set_column(4, 4, 11.00);
$worksheet->set_column(5, 5, 15.00);
$worksheet->set_column(6, 6, 15.00);
$worksheet->set_column(7, 7, 15.00);
$worksheet->set_column(8, 8, 10.00);
$worksheet->set_column(9, 9, 10.00);
$worksheet->set_column(10, 10, 10.00);

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
$worksheet->write(1, 1, "DAFTAR UANG MAKAN", $text_format);
$worksheet->write(2, 1, "PERIODE ".getNamePeriode($reqPeriode), $text_format);

$worksheet->write(4, 1, "NRP", $text_format_line_bold);
$worksheet->write(4, 2, "NAMA", $text_format_line_bold);
$worksheet->write(4, 3, "NAMA KAPAL", $text_format_line_bold);
$worksheet->write(4, 4, "NO REKENING", $text_format_line_bold);
$worksheet->write(4, 5, "HARI KERJA", $text_format_line_bold);
$worksheet->write(4, 6, "MASUK_KERJA", $text_format_line_bold);
$worksheet->write(4, 7, "JUMLAH", $text_format_line_bold);
$worksheet->write(4, 8, "% PPH", $text_format_line_bold);
$worksheet->write(4, 9, "JUMLAH PPH", $text_format_line_bold);
$worksheet->write(4, 10, "DIBAYARKAN", $text_format_line_bold);
/*$worksheet->write(5, 1, "167121872", $text_format_line);
$worksheet->write(5, 2, "LUSIA TIVIANIE, SH, MH", $text_format_line_left);
$worksheet->write(5, 3, "5", $text_format_line);
$worksheet->write(5, 4, "Manager SDM dan Umum", $text_format_line_left);*/


$row = 5;
$jenis_pegawai = "";
$jenis_bank = "";
while($uang_makan_bantuan->nextRow())
{
	if($jenis_bank == $uang_makan_bantuan->getField("NAMA_BANK"))
	{}
	else
	{
		$worksheet->write($row, 1, $uang_makan_bantuan->getField("NAMA_BANK"), $text_format_merge_line_bold);
		$worksheet->write_blank($row, 2, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 3, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 4, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 5, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 6, $text_format_merge_line_bold);		
		$worksheet->write_blank($row, 7, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 8, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 9, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 10, $text_format_merge_line_bold);
		$row++;
	}
	
	if($jenis_pegawai == $uang_makan_bantuan->getField("JENIS_PEGAWAI"))
	{}
	else
	{
		$worksheet->write($row, 1, $uang_makan_bantuan->getField("JENIS_PEGAWAI"), $text_format_merge_line_bold);
		$worksheet->write_blank($row, 2, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 3, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 4, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 5, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 6, $text_format_merge_line_bold);	
		$worksheet->write_blank($row, 7, $text_format_merge_line_bold);	
		$worksheet->write_blank($row, 8, $text_format_merge_line_bold);	
		$worksheet->write_blank($row, 9, $text_format_merge_line_bold);		
		$worksheet->write_blank($row, 10, $text_format_merge_line_bold);		
		$row++;
	}
		
	$worksheet->write($row, 1, $uang_makan_bantuan->getField("NRP"), $text_format_line);
	$worksheet->write($row, 2, $uang_makan_bantuan->getField("NAMA"), $text_format_line_left);
	$worksheet->write($row, 3, $uang_makan_bantuan->getField("KAPAL"), $text_format_line_left);
	$worksheet->write($row, 4, " " . $uang_makan_bantuan->getField("REKENING_NO"), $text_format_line_left);
	$worksheet->write($row, 5, $uang_makan_bantuan->getField("HARI_KERJA"), $text_format_line);
	$worksheet->write($row, 6, $uang_makan_bantuan->getField("MASUK_KERJA"), $text_format_line);
	$worksheet->write($row, 7, $uang_makan_bantuan->getField("JUMLAH"), $uang_line);
	$worksheet->write($row, 8, $uang_makan_bantuan->getField("PROSENTASE_POTONGAN"), $text_format_line);
	$worksheet->write($row, 9, $uang_makan_bantuan->getField("JUMLAH_POTONGAN"), $uang_line);
	$worksheet->write($row, 10, $uang_makan_bantuan->getField("JUMLAH"), $uang_line);	
	/*for ($k=4; $k<=34; $k++)
	{
			$worksheet->write($row, $k, $absensi_koreksi->getField('HARI_'.($k-3)), $text_format_line);
	}*/
	$jenis_pegawai = $uang_makan_bantuan->getField("JENIS_PEGAWAI");	
	$jenis_bank = $uang_makan_bantuan->getField("NAMA_BANK");
	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"uang_makan_excel.xls\"");
header("Content-Disposition: inline; filename=\"uang_makan_excel.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>