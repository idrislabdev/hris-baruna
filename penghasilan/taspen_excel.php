<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");

require_once "../WEB-INF/lib/excel/class.writeexcel_workbookbig.inc.php";
require_once "../WEB-INF/lib/excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "taspen_excel.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$worksheet->hide_gridlines();
$gaji_awal_bulan = new GajiAwalBulan();

$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");

/*$arrJenisPegawaiId = explode(",", $reqJenisPegawaiId);
if(count($arrJenisPegawaiId) > 1)
{
	$statement = " AND ( ";
	
	for($i=0;$i<count($arrJenisPegawaiId);$i++)
	{
		if($i > 0)
			$statement .= " OR ";	
			
		$statement .= "JENIS_PEGAWAI_ID=".$arrJenisPegawaiId[$i];
	}
	
	$statement .= " ) ";
}
else
	$statement = " AND JENIS_PEGAWAI_ID= ".$reqJenisPegawaiId;*/

$statement .= " AND PERIODE = '".$reqPeriode."'";
$statement .= " AND DEPARTEMEN_ID NOT IN (88, 66)";

$gaji_awal_bulan->selectByParamsDaftarTaspen(array(), -1, -1, $statement, " ORDER BY DEPARTEMEN_ID ASC, NAMA ASC");

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 3.57);
$worksheet->set_column(2, 2, 11.00);
$worksheet->set_column(3, 3, 27.00);
$worksheet->set_column(4, 4, 23.00);
$worksheet->set_column(5, 5, 11.00);
$worksheet->set_column(6, 6, 12.00);
$worksheet->set_column(7, 7, 21.00);
$worksheet->set_column(8, 8, 8.00);
$worksheet->set_column(9, 9, 16.00);
$worksheet->set_column(10, 10, 16.00);
$worksheet->set_column(11, 11, 5.00);
$worksheet->set_column(12, 12, 5.00);
$worksheet->set_column(13, 13, 5.00);
$worksheet->set_column(14, 14, 9.00);
$worksheet->set_column(15, 15, 21.00);

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

$text_format_merge_line_bold_info =& $workbook->addformat(array(size => 8, font => 'Arial Narrow', fg_color => 0x16));
$text_format_merge_line_bold_info->set_color('black');
$text_format_merge_line_bold_info->set_size(8);
$text_format_merge_line_bold_info->set_border_color('black');
$text_format_merge_line_bold_info->set_merge(1);
$text_format_merge_line_bold_info->set_bold(1);
$text_format_merge_line_bold_info->set_left(1);
$text_format_merge_line_bold_info->set_right(1);
$text_format_merge_line_bold_info->set_top(1);
$text_format_merge_line_bold_info->set_bottom(1);

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
$worksheet->write(1, 1, "DAFTAR TASPEN PEGAWAI YAYASAN BARUNAWATI BIRU SURABAYA", $text_format);
$worksheet->write(2, 1, "PERIODE :  BULAN ".strtoupper(getNamePeriode($reqPeriode)), $text_format);

$worksheet->write(4, 1, "NO", $text_format_line_bold);
$worksheet->write(4, 2, "NIPP", $text_format_line_bold);
$worksheet->write(4, 3, "NAMA", $text_format_line_bold);
$worksheet->write(4, 4, "TEMPAT LAHIR", $text_format_line_bold);
$worksheet->write(4, 5, "TGL LAHIR", $text_format_line_bold);
$worksheet->write(4, 6, "GOLONGAN", $text_format_line_bold);
$worksheet->write(4, 7, "PANGKAT", $text_format_line_bold);
$worksheet->write(4, 8, "STAT KEL", $text_format_line_bold);
$worksheet->write(4, 9, "GAJI POKOK LAMA", $text_format_line_bold);
$worksheet->write(4, 10, "GAJI POKOK BARU", $text_format_line_bold);
$worksheet->write		(4, 11, "GAJI KOTOR", $text_format_merge_line_bold);
$worksheet->write_blank	(4, 12, $text_format_merge_line_bold);
$worksheet->write_blank	(4, 13, $text_format_merge_line_bold);
$worksheet->write_blank	(4, 14, $text_format_merge_line_bold);
$worksheet->write(4, 15, "POT. PREMI TASPEN (3.25%)", $text_format_line_bold);

$worksheet->write(5, 1, "", $text_format_line_bold);
$worksheet->write(5, 2, "", $text_format_line_bold);
$worksheet->write(5, 3, "", $text_format_line_bold);
$worksheet->write(5, 4, "", $text_format_line_bold);
$worksheet->write(5, 5, "", $text_format_line_bold);
$worksheet->write(5, 6, "", $text_format_line_bold);
$worksheet->write(5, 7, "", $text_format_line_bold);
$worksheet->write(5, 8, "", $text_format_line_bold);
$worksheet->write(5, 9, "(Rp.)", $text_format_line_bold);
$worksheet->write(5, 10, "(Rp.)", $text_format_line_bold);
$worksheet->write(5, 11, "%", $text_format_line_bold);
$worksheet->write(5, 12, "%", $text_format_line_bold);
$worksheet->write(5, 13, "%", $text_format_line_bold);
$worksheet->write(5, 14, "(Rp.)", $text_format_line_bold);
$worksheet->write(5, 15, strtoupper(getNamePeriode($reqPeriode)), $text_format_line_bold);

$row = 6;
$i=1;
$tempJumlah="0";
$nama_departemen = "";
while($gaji_awal_bulan->nextRow())
{
	if($nama_departemen == $gaji_awal_bulan->getField('DEPARTEMEN'))
	{}
	else		
	{
		$worksheet->write($row, 1, strtoupper($gaji_awal_bulan->getField('DEPARTEMEN')),$text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 2, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 3, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 4, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 5, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 6, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 7, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 8, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 9, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 10, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 11, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 12, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 13, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 14, $text_format_merge_line_bold_info);
		$worksheet->write_blank($row, 15, $text_format_merge_line_bold_info);
		$row++;	
		$i=1;
	}
	
	$worksheet->write($row, 1, $i, $text_format_line);
	$worksheet->write($row, 2, $gaji_awal_bulan->getField('NRP'), $text_format_line);
	$worksheet->write($row, 3, $gaji_awal_bulan->getField('NAMA'), $text_format_line_left);
	$worksheet->write($row, 4, strtoupper($gaji_awal_bulan->getField('TEMPAT_LAHIR')), $text_format_line_left);
	$worksheet->write($row, 5, dateToPage($gaji_awal_bulan->getField('TANGGAL_LAHIR')), $text_format_line);
	$worksheet->write($row, 6, $gaji_awal_bulan->getField('GOLONGAN'), $text_format_line);
	$worksheet->write($row, 7, $gaji_awal_bulan->getField('PANGKAT'), $text_format_line_left);
	$worksheet->write($row, 8, $gaji_awal_bulan->getField('KODE'), $text_format_line);
	$worksheet->write($row, 9, $gaji_awal_bulan->getField('GAJI_POKOK'), $uang_line);
	$worksheet->write($row, 10, "", $uang_line);
	$worksheet->write($row, 11, $gaji_awal_bulan->getField('PROSENTASE_1'), $text_format_line);
	$worksheet->write($row, 12, $gaji_awal_bulan->getField('PROSENTASE_2'), $text_format_line);
	$worksheet->write($row, 13, $gaji_awal_bulan->getField('PROSENTASE_3'), $text_format_line);
	$worksheet->write($row, 14, $gaji_awal_bulan->getField('GAJI_KOTOR'), $uang_line);
	$worksheet->write($row, 15, $gaji_awal_bulan->getField('IURAN_TASPEN'), $uang_line);
	$tempJumlah += $gaji_awal_bulan->getField('IURAN_TASPEN');
	$row++;
	$i++;
	
	$nama_departemen = $gaji_awal_bulan->getField('DEPARTEMEN');
}

$worksheet->write($row, 14, "Jumlah", $text_format_line);
$worksheet->write($row, 15, $tempJumlah, $uang_line);

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"taspen_excel.xls\"");
header("Content-Disposition: inline; filename=\"taspen_excel.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>