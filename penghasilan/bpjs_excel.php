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

$fname = tempnam("/tmp", "bpjs_excel.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$worksheet->hide_gridlines();
$gaji_awal_bulan = new GajiAwalBulan();

$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");

$arrJenisPegawaiId = explode(",", $reqJenisPegawaiId);
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
	$statement = " AND JENIS_PEGAWAI_ID= ".$reqJenisPegawaiId;

$statement .= " AND BULANTAHUN = '".$reqPeriode."'";
$statement .= " AND DEPARTEMEN_ID NOT IN (88, 66)";

$gaji_awal_bulan->selectByParamsDaftarBPJS(array(), -1, -1, $statement, " ORDER BY DEPARTEMEN_ID ASC, NAMA ASC");


$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 3.71);
$worksheet->set_column(2, 2, 11.00);
$worksheet->set_column(3, 3, 25.00);
$worksheet->set_column(4, 4, 30.00);
$worksheet->set_column(5, 5, 11.00);
$worksheet->set_column(6, 6, 11.00);
$worksheet->set_column(7, 7, 11.00);
$worksheet->set_column(8, 8, 17.71);
$worksheet->set_column(9, 9, 21.14);
$worksheet->set_column(10, 10, 21.14);
$worksheet->set_column(11, 11, 16.14);
$worksheet->set_column(12, 12, 19.14);

$worksheet->set_column(15, 20, 3.71);
$worksheet->set_column(16, 21, 30.00);
$worksheet->set_column(17, 22, 21.00);
$worksheet->set_column(18, 23, 21.00);
$worksheet->set_column(19, 24, 21.12);

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

$text_format_merge_line_bold_info =& $workbook->addformat(array(align => 'left', size => 8, font => 'Arial Narrow', fg_color => 0x16));
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
$worksheet->write(1, 1, "DAFTAR IURAN BPJS", $text_format_merge);
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

$worksheet->write(2, 1, "PERIODE ".strtoupper(getNamePeriode($reqPeriode)), $text_format_merge);
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

$worksheet->write(3, 1, "", $text_format);
$worksheet->write(4, 1, "", $text_format);
$worksheet->write(5, 1, "NAMA PERUSAHAAN : YAYASAN BARUNAWATI BIRU SURABAYA", $text_format);

if($reqJenisPegawaiId == 1)
	$caption = "PEGAWAI ORGANIK";
elseif($reqJenisPegawaiId == 2)
	$caption = "PEGAWAI";
elseif($reqJenisPegawaiId == 3)
	$caption = "PEGAWAI KONTRAK";
elseif($reqJenisPegawaiId == 5)
	$caption = "PTTPK";
elseif($reqJenisPegawaiId == 6)
	$caption = "DEWAN DIREKSI";
elseif($reqJenisPegawaiId == 7)
	$caption = "DEWAN KOMISARIS";


$worksheet->write(7, 1, "DAFTAR ".$caption, $text_format);


$worksheet->write(9, 1, "NO", $text_format_line_bold);
$worksheet->write(9, 2, "NIK", $text_format_line_bold);
$worksheet->write(9, 3, "NAMA", $text_format_line_bold);
$worksheet->write(9, 4, "DEPARTEMEN", $text_format_line_bold);
$worksheet->write(9, 5, "STATUS KAWIN", $text_format_line_bold);
$worksheet->write(9, 6, "TGL LAHIR", $text_format_line_bold);
$worksheet->write(9, 7, "UPAH TK", $text_format_line_bold);
$worksheet->write(9, 8, "UPAH BERSIH", $text_format_line_bold);
$worksheet->write(9, 9, "BEBAN PERUSAHAAN (4,00%)", $text_format_line_bold);
$worksheet->write(9, 10, "BEBAN PEGAWAI (0,5%)", $text_format_line_bold);
$worksheet->write(9, 11, "IURAN", $text_format_line_bold);
$worksheet->write(9, 12, "KETERANGAN", $text_format_line_bold);

$worksheet->write(5, 15, "REKAP IURAN BPJS ".$caption." PT. PELINDO PROPERTI INDONESIA", $text_format_merge);
$worksheet->write_blank(5, 16, $text_format_merge);
$worksheet->write_blank(5, 17, $text_format_merge);
$worksheet->write_blank(5, 18, $text_format_merge);
$worksheet->write_blank(5, 19, $text_format_merge);

$worksheet->write(6, 15, "PERIODE ".strtoupper(getNamePeriode($reqPeriode)), $text_format_merge);
$worksheet->write_blank(6, 16, $text_format_merge);
$worksheet->write_blank(6, 17, $text_format_merge);
$worksheet->write_blank(6, 18, $text_format_merge);
$worksheet->write_blank(6, 19, $text_format_merge);

$worksheet->write(9, 15, "NO", $text_format_line_bold);
$worksheet->write(9, 16, "DEPARTEMEN", $text_format_line_bold);
$worksheet->write(9, 17, "BEBAN PERUSAHAAN (4,00%)", $text_format_line_bold);
$worksheet->write(9, 18, "BEBAN PEGAWAI (0,5%)", $text_format_line_bold);
$worksheet->write(9, 19, "IURAN", $text_format_line_bold);

$row = 10;
$i= $no = 1;
$temp_jumlah_iuran=$temp_jumlah_jpk_perusahaan=$temp_jumlah_jpk_peserta="0";

$nama_departemen = "";
$index=0;
while($gaji_awal_bulan->nextRow())
{
	/*
	if($nama_departemen != $gaji_awal_bulan->getField('DEPARTEMEN'))		
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
		$row++;	
		$i=1;
	}*/
	$namaDept = ''; 
	if(substr($gaji_awal_bulan->getField("DEPARTEMEN_ID"), 0, 2) == '02' AND substr($gaji_awal_bulan->getField("DEPARTEMEN_ID"), 0, 4) == '0202') { $namaDept = ' Armada'; }
	else if(substr($gaji_awal_bulan->getField("DEPARTEMEN_ID"), 0, 2) == '02' AND substr($gaji_awal_bulan->getField("DEPARTEMEN_ID"), 0, 4) != '0202') { $namaDept = ' Non Armada';}

	$worksheet->write($row, 1, $i, $text_format_line);
	$worksheet->write($row, 2, $gaji_awal_bulan->getField("NRP"), $text_format_line);
	$worksheet->write($row, 3, $gaji_awal_bulan->getField("NAMA"), $text_format_line_left);
	$worksheet->write($row, 4, $gaji_awal_bulan->getField("DEPARTEMEN") . $namaDept, $text_format_line_left);
	$worksheet->write($row, 5, $gaji_awal_bulan->getField("KAWIN"), $text_format_line);
	$worksheet->write($row, 6, $gaji_awal_bulan->getField("TGL_LAHIR"), $text_format_line);
	$worksheet->write($row, 7, $gaji_awal_bulan->getField("UPAH_TK"), $uang_line);
	$worksheet->write($row, 8, $gaji_awal_bulan->getField("UPAH_BERSIH"), $uang_line);
	$worksheet->write($row, 9, $gaji_awal_bulan->getField("JPK_PERUSAHAAN"), $uang_line);
	$worksheet->write($row, 10, $gaji_awal_bulan->getField("JPK_PESERTA"), $uang_line);
	$worksheet->write($row, 11, $gaji_awal_bulan->getField("IURAN"), $uang_line);
	$worksheet->write($row, 12, $gaji_awal_bulan->getField("KETERANGAN"), $text_format_line_left);
	
	$temp_jumlah_jpk_perusahaan += $gaji_awal_bulan->getField('JPK_PERUSAHAAN');
	$temp_jumlah_jpk_peserta += $gaji_awal_bulan->getField('JPK_PESERTA');
	$temp_jumlah_iuran += $gaji_awal_bulan->getField('IURAN');
	$row++;
	$no++;
	$i++;
	$nama_departemen = $gaji_awal_bulan->getField('DEPARTEMEN');
}

$worksheet->write($row, 8, "Jumlah", $text_format_line);
$worksheet->write($row, 9, $temp_jumlah_jpk_perusahaan, $uang_line);
$worksheet->write($row, 10, $temp_jumlah_jpk_peserta, $uang_line);
$worksheet->write($row, 11, $temp_jumlah_iuran, $uang_line);

$gaji_awal_bulan = new GajiAwalBulan();
$gaji_awal_bulan->selectByParamsDaftarBPJSRekap(array(), -1, -1, $statement, " ORDER BY DEPARTEMEN ASC");
$i=1;
$row=10;
$temp_jumlah_jpk_perusahaan_departemen =$temp_jumlah_jpk_peserta_departemen =$temp_jumlah_iuran_departemen = 0;
while($gaji_awal_bulan->nextRow())
{
	$worksheet->write($row, 15, $i, $text_format_line);
	$worksheet->write($row, 16, $gaji_awal_bulan->getField("DEPARTEMEN"), $text_format_line_left);
	$worksheet->write($row, 17, $gaji_awal_bulan->getField("JPK_PERUSAHAAN"), $uang_line);
	$worksheet->write($row, 18, $gaji_awal_bulan->getField("JPK_PESERTA"), $uang_line);
	$worksheet->write($row, 19, $gaji_awal_bulan->getField("IURAN"), $uang_line);
	
	$temp_jumlah_jpk_perusahaan_departemen += $gaji_awal_bulan->getField("JPK_PERUSAHAAN");
	$temp_jumlah_jpk_peserta_departemen += $gaji_awal_bulan->getField("JPK_PESERTA");
	$temp_jumlah_iuran_departemen += $gaji_awal_bulan->getField("IURAN");
	$row++;
	$i++;
}
$worksheet->write_blank($row, 15, $text_format_line);
$worksheet->write($row, 16, "Jumlah", $text_format_line);
$worksheet->write($row, 17, $temp_jumlah_jpk_perusahaan_departemen, $uang_line);
$worksheet->write($row, 18, $temp_jumlah_jpk_peserta_departemen, $uang_line);
$worksheet->write($row, 19, $temp_jumlah_iuran_departemen, $uang_line);

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"bpjs_excel.xls\"");
header("Content-Disposition: inline; filename=\"bpjs_excel.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>