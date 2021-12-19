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

$fname = tempnam("/tmp", "jamsostek_excel.xls");
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

$gaji_awal_bulan->selectByParamsDaftarJamsostek(array(), -1, -1, $statement, " ORDER BY DEPARTEMEN_ID ASC, NAMA ASC");


$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 3.71);
$worksheet->set_column(2, 2, 11.00);
$worksheet->set_column(3, 3, 11.00);
$worksheet->set_column(4, 4, 22.00);
$worksheet->set_column(5, 5, 11.00);
$worksheet->set_column(6, 6, 11.00);
$worksheet->set_column(7, 7, 17.71);
$worksheet->set_column(8, 8, 12.14);
$worksheet->set_column(9, 9, 12.14);
$worksheet->set_column(10, 10, 16.14);
$worksheet->set_column(11, 11, 16.14);
$worksheet->set_column(12, 12, 12.14);
$worksheet->set_column(13, 13, 12.14);
$worksheet->set_column(14, 14, 12.14);
$worksheet->set_column(15, 15, 12.12);
$worksheet->set_column(16, 16, 25.43);

$worksheet->set_column(20, 20, 3.71);
$worksheet->set_column(21, 21, 25.00);
$worksheet->set_column(22, 22, 18.00);
$worksheet->set_column(23, 23, 15.00);
$worksheet->set_column(24, 24, 12.12);
$worksheet->set_column(25, 25, 12.12);
$worksheet->set_column(26, 26, 12.12);
$worksheet->set_column(27, 27, 12.12);

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
$worksheet->write(1, 1, "DAFTAR IURAN BPJS KETENAGAKERJAAN", $text_format_merge);
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
$worksheet->write_blank(1, 12, $text_format_merge);
$worksheet->write_blank(1, 13, $text_format_merge);
$worksheet->write_blank(1, 14, $text_format_merge);
$worksheet->write_blank(1, 15, $text_format_merge);
$worksheet->write_blank(1, 16, $text_format_merge);

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
$worksheet->write_blank(2, 12, $text_format_merge);
$worksheet->write_blank(2, 13, $text_format_merge);
$worksheet->write_blank(2, 14, $text_format_merge);
$worksheet->write_blank(2, 15, $text_format_merge);
$worksheet->write_blank(2, 16, $text_format_merge);

$worksheet->write(3, 1, "KANTOR CABANG : N14 - TJ. PERAK", $text_format);
$worksheet->write(4, 1, "NPP - UNIT KERJA : NN140549 - 000", $text_format);
$worksheet->write(5, 1, "NAMA PERUSAHAAN : PT. PELINDO PROPERTI INDONESIA", $text_format);

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
$worksheet->write(9, 3, "KPJ", $text_format_line_bold);
$worksheet->write(9, 4, "NAMA", $text_format_line_bold);
$worksheet->write(9, 5, "STAT", $text_format_line_bold);
$worksheet->write(9, 6, "TGL LAHIR", $text_format_line_bold);
$worksheet->write(9, 7, "PERIODE KEPESERTAAN", $text_format_line_bold);
$worksheet->write(9, 8, "UPAH TK", $text_format_line_bold);
$worksheet->write(9, 9, "UPAH BERSIH", $text_format_line_bold);
$worksheet->write(9, 10, "JHT PERUSAHAAN (3,70%)", $text_format_line_bold);
$worksheet->write(9, 11, "JHT PEGAWAI (2,00%)", $text_format_line_bold);
$worksheet->write(9, 12, "JKM (0,30%)", $text_format_line_bold);
$worksheet->write(9, 13, "JKK (1,74%)", $text_format_line_bold);
$worksheet->write(9, 14, "JPK (3,00%)", $text_format_line_bold);
$worksheet->write(9, 15, "IURAN", $text_format_line_bold);
$worksheet->write(9, 16, "KETERANGAN", $text_format_line_bold);

$worksheet->write(5, 20, "REKAP IURAN BPJS KETENAGAKERJAAN ".$caption." PT. PELINDO PROPERTI INDONESIA", $text_format_merge);
$worksheet->write_blank(5, 21, $text_format_merge);
$worksheet->write_blank(5, 22, $text_format_merge);
$worksheet->write_blank(5, 23, $text_format_merge);
$worksheet->write_blank(5, 24, $text_format_merge);
$worksheet->write_blank(5, 25, $text_format_merge);
$worksheet->write_blank(5, 26, $text_format_merge);
$worksheet->write_blank(5, 27, $text_format_merge);

$worksheet->write(6, 20, "PERIODE ".strtoupper(getNamePeriode($reqPeriode)), $text_format_merge);
$worksheet->write_blank(6, 21, $text_format_merge);
$worksheet->write_blank(6, 22, $text_format_merge);
$worksheet->write_blank(6, 23, $text_format_merge);
$worksheet->write_blank(6, 24, $text_format_merge);
$worksheet->write_blank(6, 25, $text_format_merge);
$worksheet->write_blank(6, 26, $text_format_merge);
$worksheet->write_blank(6, 27, $text_format_merge);

$worksheet->write(9, 20, "NO", $text_format_line_bold);
$worksheet->write(9, 21, "DEPARTEMEN", $text_format_line_bold);
$worksheet->write(9, 22, "JHT PERUSAHAAN (3,70%)", $text_format_line_bold);
$worksheet->write(9, 23, "JHT PEGAWAI (2,00%)", $text_format_line_bold);
$worksheet->write(9, 24, "JKM (0,30%)", $text_format_line_bold);
$worksheet->write(9, 25, "JKK (1,74%)", $text_format_line_bold);
$worksheet->write(9, 26, "JPK (3,00%)", $text_format_line_bold);
$worksheet->write(9, 27, "IURAN", $text_format_line_bold);

$row = 10;
$i= $no = 1;
$temp_jumlah_iuran=$temp_jumlah_jht= $temp_jumlah_jht_peg= $temp_jumlah_jkm= $temp_jumlah_jkk= $temp_jumlah_jpk="0";
$temp_jumlah_jht_departemen =$temp_jumlah_jht_peg_departemen =$temp_jumlah_jkm_departemen =$temp_jumlah_jkk_departemen =$temp_jumlah_jpk_departemen =$temp_jumlah_iuran_departemen = 0;

$arrDepartemen="";
$nama_departemen = "";
$index=0;
while($gaji_awal_bulan->nextRow())
{
	if($nama_departemen == $gaji_awal_bulan->getField('DEPARTEMEN'))
	{
	}
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
		$worksheet->write_blank($row, 16, $text_format_merge_line_bold_info);
		$arrDepartemen[$index]["DEPARTEMEN"] = strtoupper($gaji_awal_bulan->getField('DEPARTEMEN'));
		$row++;	
		$i=1;
	}
	
	if($i == "1")
	{
		$arrDepartemen[$index-1]["JTH"] = $temp_jumlah_jht_departemen;
		$arrDepartemen[$index-1]["JTH_PEG"] = $temp_jumlah_jht_peg_departemen;
		$arrDepartemen[$index-1]["JKM"] = $temp_jumlah_jkm_departemen;
		$arrDepartemen[$index-1]["JKK"] = $temp_jumlah_jkk_departemen;
		$arrDepartemen[$index-1]["JPK"] = $temp_jumlah_jpk_departemen;
		$arrDepartemen[$index-1]["IURAN"] = $temp_jumlah_iuran_departemen;
		$index++;
		$temp_jumlah_jht_departemen =$temp_jumlah_jht_peg_departemen =$temp_jumlah_jkm_departemen =$temp_jumlah_jkk_departemen =$temp_jumlah_jpk_departemen =$temp_jumlah_iuran_departemen = 0;
	}
	
	$worksheet->write($row, 1, $i, $text_format_line);
	$worksheet->write($row, 2, $gaji_awal_bulan->getField("NRP"), $text_format_line);
	$worksheet->write($row, 3, $gaji_awal_bulan->getField("KPJ"), $text_format_line);
	$worksheet->write($row, 4, $gaji_awal_bulan->getField("NAMA"), $text_format_line_left);
	$worksheet->write($row, 5, $gaji_awal_bulan->getField("KAWIN"), $text_format_line);
	$worksheet->write($row, 6, $gaji_awal_bulan->getField("TGL_LAHIR"), $text_format_line);
	$worksheet->write($row, 7, $gaji_awal_bulan->getField("PERIODE"), $text_format_line);
	$worksheet->write($row, 8, $gaji_awal_bulan->getField("UPAH_TK"), $uang_line);
	$worksheet->write($row, 9, $gaji_awal_bulan->getField("RAPEL_UPAH_TK"), $uang_line);
	$worksheet->write($row, 10, $gaji_awal_bulan->getField("JHT"), $uang_line);
	$worksheet->write($row, 11, $gaji_awal_bulan->getField("JHT_PEG"), $uang_line);
	$worksheet->write($row, 12, $gaji_awal_bulan->getField("JKM"), $uang_line);
	$worksheet->write($row, 13, $gaji_awal_bulan->getField("JKK"), $uang_line);
	$worksheet->write($row, 14, $gaji_awal_bulan->getField("JPK"), $uang_line);
	$worksheet->write($row, 15, $gaji_awal_bulan->getField("IURAN"), $uang_line);
	$worksheet->write($row, 16, $gaji_awal_bulan->getField("KETERANGAN"), $text_format_line_left);
	
	$temp_jumlah_jht += $gaji_awal_bulan->getField('JHT');			$temp_jumlah_jht_departemen =$temp_jumlah_jht;
	$temp_jumlah_jht_peg += $gaji_awal_bulan->getField('JHT_PEG');	$temp_jumlah_jht_peg_departemen = $temp_jumlah_jht_peg;
	$temp_jumlah_jkm += $gaji_awal_bulan->getField('JKM');			$temp_jumlah_jkm_departemen = $temp_jumlah_jkm;
	$temp_jumlah_jkk += $gaji_awal_bulan->getField('JKK');			$temp_jumlah_jkk_departemen = $temp_jumlah_jkk;
	$temp_jumlah_jpk += $gaji_awal_bulan->getField('JPK');			$temp_jumlah_jpk_departemen = $temp_jumlah_jpk;
	$temp_jumlah_iuran += $gaji_awal_bulan->getField('IURAN');		$temp_jumlah_iuran_departemen = $temp_jumlah_iuran;
	$row++;
	$no++;
	$i++;
	$nama_departemen = $gaji_awal_bulan->getField('DEPARTEMEN');
}

$arrDepartemen[$index-1]["JTH"] = $temp_jumlah_jht_departemen;
$arrDepartemen[$index-1]["JTH_PEG"] = $temp_jumlah_jht_peg_departemen;
$arrDepartemen[$index-1]["JKM"] = $temp_jumlah_jkm_departemen;
$arrDepartemen[$index-1]["JKK"] = $temp_jumlah_jkk_departemen;
$arrDepartemen[$index-1]["JPK"] = $temp_jumlah_jpk_departemen;
$arrDepartemen[$index-1]["IURAN"] = $temp_jumlah_iuran_departemen;

$worksheet->write($row, 9, "Jumlah", $text_format_line);
$worksheet->write($row, 10, $temp_jumlah_jht, $uang_line);
$worksheet->write($row, 11, $temp_jumlah_jht_peg, $uang_line);
$worksheet->write($row, 12, $temp_jumlah_jkm, $uang_line);
$worksheet->write($row, 13, $temp_jumlah_jkk, $uang_line);
$worksheet->write($row, 14, $temp_jumlah_jpk, $uang_line);
$worksheet->write($row, 15, $temp_jumlah_iuran, $uang_line);

$row++;
$worksheet->write($row, 9, "Total Iuran Pegawai", $text_format_line);
$worksheet->write_blank($row, 10, $text_format_line);
$worksheet->write_blank($row, 11, $text_format_line);
$worksheet->write_blank($row, 12, $text_format_line);
$worksheet->write_blank($row, 13, $text_format_line);
$worksheet->write_blank($row, 14, $text_format_line);
$worksheet->write($row, 15, $temp_jumlah_jht+$temp_jumlah_jkm+$temp_jumlah_jkk+$temp_jumlah_jpk, $uang_line);

$row++;
$worksheet->write($row, 9, "Total Iuran Perusahaan", $text_format_line);
$worksheet->write_blank($row, 10, $text_format_line);
$worksheet->write_blank($row, 11, $text_format_line);
$worksheet->write_blank($row, 12, $text_format_line);
$worksheet->write_blank($row, 13, $text_format_line);
$worksheet->write_blank($row, 14, $text_format_line);
$worksheet->write($row, 15, $temp_jumlah_jht_peg, $uang_line);

$row++;
$worksheet->write($row, 9, "Total", $text_format_line);
$worksheet->write_blank($row, 10, $text_format_line);
$worksheet->write_blank($row, 11, $text_format_line);
$worksheet->write_blank($row, 12, $text_format_line);
$worksheet->write_blank($row, 13, $text_format_line);
$worksheet->write_blank($row, 14, $text_format_line);
$worksheet->write($row, 15, $temp_jumlah_jht+$temp_jumlah_jkm+$temp_jumlah_jkk+$temp_jumlah_jpk+$temp_jumlah_jht_peg, $uang_line);

$row = 10;
$i= $no = 1;

//echo print_r($arrDepartemen);
if($index == 0){}
else
{
	for($i=0;$i<count($arrDepartemen);$i++)
	{
		if($arrDepartemen[$i]["DEPARTEMEN"] == ""){}
		else
		{
			$worksheet->write($row, 20, $i+1, $text_format_line);
			$worksheet->write($row, 21, $arrDepartemen[$i]["DEPARTEMEN"], $text_format_line);
			$worksheet->write($row, 22, $arrDepartemen[$i]["JTH"], $uang_line);
			$worksheet->write($row, 23, $arrDepartemen[$i]["JTH_PEG"], $uang_line);
			$worksheet->write($row, 24, $arrDepartemen[$i]["JKM"], $uang_line);
			$worksheet->write($row, 25, $arrDepartemen[$i]["JKK"], $uang_line);
			$worksheet->write($row, 26, $arrDepartemen[$i]["JPK"], $uang_line);
			$worksheet->write($row, 27, $arrDepartemen[$i]["IURAN"], $uang_line);
			
			$temp_jumlah_jht += $arrDepartemen[$i]["JTH"];
			$temp_jumlah_jht_peg += $arrDepartemen[$i]["JTH_PEG"];
			$temp_jumlah_jkm += $arrDepartemen[$i]["JKM"];
			$temp_jumlah_jkk += $arrDepartemen[$i]["JKK"];
			$temp_jumlah_jpk += $arrDepartemen[$i]["JPK"];
			$temp_jumlah_iuran += $arrDepartemen[$i]["IURAN"];
			$row++;
		}
		
	}
}

$worksheet->write($row, 21, "Jumlah", $text_format_line);
$worksheet->write($row, 22, $temp_jumlah_jht, $uang_line);
$worksheet->write($row, 23, $temp_jumlah_jht_peg, $uang_line);
$worksheet->write($row, 24, $temp_jumlah_jkm, $uang_line);
$worksheet->write($row, 25, $temp_jumlah_jkk, $uang_line);
$worksheet->write($row, 26, $temp_jumlah_jpk, $uang_line);
$worksheet->write($row, 27, $temp_jumlah_iuran, $uang_line);

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"jamsostek_excel.xls\"");
header("Content-Disposition: inline; filename=\"jamsostek_excel.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>