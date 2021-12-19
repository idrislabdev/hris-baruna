<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/InsentifBantuan.php");

require_once "../WEB-INF/lib/excel/class.writeexcel_workbookbig.inc.php";
require_once "../WEB-INF/lib/excel/class.writeexcel_worksheet.inc.php";

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "gaji_insentif_excel.xls");
$workbook = & new writeexcel_workbookbig($fname);
//$worksheet = &$workbook->addworksheet();

$workbook = &new writeexcel_workbook($fname);

$insentif_bantuan = new InsentifBantuan();
$departemen = new InsentifBantuan();

$reqPeriode = httpFilterGet("reqPeriode");
$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");

$departemen->selectByParamsDepartemen($reqJenisPegawaiId, $reqPeriode);

$z=1;
while($departemen->nextRow())
{
$worksheet =& $workbook->addworksheet(substr($departemen->getField("DEPARTEMEN"), 0, 30));

$departemen_id = $departemen->getField("DEPARTEMEN_ID");

if($reqMode == "proses")
{
	$insentif_bantuan->setField("JENIS_PEGAWAI_ID", $reqJenisPegawaiId);
	$insentif_bantuan->callInsentifBantuan();
}

/*if($reqJenisPegawaiId == "")
{}
else*/
$statement = "AND JENIS_PEGAWAI_ID = ".$reqJenisPegawaiId." AND DEPARTEMEN_ID = '".$departemen_id."'";

$insentif_bantuan->selectByParamsReport(array(), -1, -1, $statement, $reqPeriode, " ORDER BY BANK_NAMA, NAMA ASC");

$worksheet->set_column(0, 0, 3.43);
$worksheet->set_column(1, 1, 27.00);
$worksheet->set_column(2, 2, 40.00);
$worksheet->set_column(3, 3, 5.00);
$worksheet->set_column(4, 4, 14.00);
$worksheet->set_column(4, 5, 14.00);
$worksheet->set_column(5, 6, 9.00);
$worksheet->set_column(6, 7, 7.00);
$worksheet->set_column(7, 8, 14.00);
$worksheet->set_column(8, 9, 14.00);

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
$worksheet->write		(1, 1, "DAFTAR TUNJANGAN INSENTIF KINERJA PEGAWAI DARAT PELINDO MARINE SERVICE", $text_format_merge);
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

$worksheet->write(4, 1, strtoupper($departemen->getField("DEPARTEMEN")), $text_format_left_none);

$worksheet->write(6, 0, "NO.", $text_format_line_bold);
$worksheet->write(6, 1, "NAMA", $text_format_line_bold);
$worksheet->write(6, 2, "JABATAN", $text_format_line_bold);
$worksheet->write(6, 3, "KELAS", $text_format_line_bold);
$worksheet->write(6, 4, "NO REKENING", $text_format_line_bold);
$worksheet->write(6, 5, "BESAR TUNJANGAN", $text_format_line_bold);
$worksheet->write(6, 6, "POTONGAN", $text_format_line_bold);
$worksheet->write(6, 7, "PPH (Rp.)", $text_format_line_bold);
$worksheet->write(6, 8, "JUMLAH DITERIMA", $text_format_line_bold);
$worksheet->write(6, 9, "TANDA TANGAN", $text_format_line_bold);

/*$worksheet->write(5, 1, "167121872", $text_format_line);
$worksheet->write(5, 2, "LUSIA TIVIANIE, SH, MH", $text_format_line_left);
$worksheet->write(5, 3, "5", $text_format_line);
$worksheet->write(5, 4, "Manager SDM dan Umum", $text_format_line_left);*/

$row = 7;
$no = 1;
$jenis_bank = "";
while($insentif_bantuan->nextRow())
{
	if($jenis_bank == $insentif_bantuan->getField("BANK_NAMA"))
	{}
	else
	{
		$worksheet->write($row, 0, $insentif_bantuan->getField("BANK_NAMA"), $text_format_merge_line_bold);
		$worksheet->write_blank($row, 1, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 2, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 3, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 4, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 5, $text_format_merge_line_bold);	
		$worksheet->write_blank($row, 6, $text_format_merge_line_bold);	
		$worksheet->write_blank($row, 7, $text_format_merge_line_bold);	
		$worksheet->write_blank($row, 8, $text_format_merge_line_bold);	
		$worksheet->write_blank($row, 9, $text_format_merge_line_bold);		
		$row++;
	}
	
	$worksheet->write($row, 0, $no, $text_format_line);
	$worksheet->write($row, 1, $insentif_bantuan->getField("NAMA")."\n"."NPWP : ".$insentif_bantuan->getField("NPWP"), $text_format_line_left);
	$worksheet->write($row, 2, strtoupper($insentif_bantuan->getField("JABATAN")), $text_format_line_left);
	//$worksheet->write($row, 3, $insentif_bantuan->getField("NPWP"), $text_format_line);
	$worksheet->write($row, 3, $insentif_bantuan->getField("KELAS"), $text_format_line);
	$worksheet->write($row, 4, $insentif_bantuan->getField("NO_REKENING"), $text_format_line);
	$worksheet->write($row, 5, $insentif_bantuan->getField("JUMLAH"), $uang_line);
	$worksheet->write($row, 6, $insentif_bantuan->getField("JUMLAH_POTONGAN"), $uang_line);
	$worksheet->write($row, 7, $insentif_bantuan->getField("JUMLAH_PPH"), $uang_line);
	$worksheet->write($row, 8, $insentif_bantuan->getField("DIBAYARKAN"), $uang_line);
	$worksheet->write($row, 9, $no." ............", $text_format_line_left);
	
	$jumlah += $insentif_bantuan->getField("JUMLAH");
	$jumlah_potongan += $insentif_bantuan->getField("JUMLAH_POTONGAN");
	$jumlah_pph += $insentif_bantuan->getField("JUMLAH_PPH");
	$dibayarkan	+= $insentif_bantuan->getField("DIBAYARKAN");
	
	$jenis_bank = $insentif_bantuan->getField("BANK_NAMA");	
	
	$no++;
	$row++;
}

	$worksheet->write($row, 0, "", $text_format_line);
	$worksheet->write($row, 1, "", $text_format_line);
	$worksheet->write($row, 2, "", $text_format_line);
	$worksheet->write($row, 3, "", $text_format_line);
	$worksheet->write($row, 4, "", $text_format_line);
	$worksheet->write($row, 5, $jumlah, $uang_line);
	$worksheet->write($row, 6, $jumlah_potongan, $uang_line);
	$worksheet->write($row, 7, $jumlah_pph, $uang_line);
	$worksheet->write($row, 8, $dibayarkan, $uang_line);
	$worksheet->write($row, 9, "", $text_format_line_left);

$z++;
}
$workbook->close();

header("Content-Type: application/x-msexcel; name=\"gaji_insentif_excel.xls\"");
header("Content-Disposition: inline; filename=\"gaji_insentif_excel.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>