<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/PembayaranManfaat.php");

require_once "../WEB-INF/lib/excel/class.writeexcel_workbookbig.inc.php";
require_once "../WEB-INF/lib/excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "uang_transport_excel.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$pembayaran_manfaat = new PembayaranManfaat();

$reqPeriode = httpFilterGet("reqPeriode");
$reqJenisPegawai = httpFilterGet("reqJenisPegawai");
$reqDepartemen = httpFilterGet("reqDepartemen");

if($reqJenisPegawai == "")
{}
else
	$statement .= "AND A.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;
	
if($reqDepartemen == "")
{}
else
	$statement .= "AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

$pembayaran_manfaat->selectByParamsReport(array(), -1, -1, $statement, $reqPeriode, " ORDER BY 9, to_number(a.kelas) ");

$worksheet->set_column(0, 0, 10.00);
$worksheet->set_column(1, 1, 10.00);
$worksheet->set_column(2, 2, 10.00);
$worksheet->set_column(3, 3, 40.00);
$worksheet->set_column(4, 4, 10.00);
$worksheet->set_column(5, 5, 10.43);
$worksheet->set_column(6, 6, 40.00);
$worksheet->set_column(7, 7, 40.00);
$worksheet->set_column(8, 8, 10.00);
$worksheet->set_column(9, 9, 27.00);
$worksheet->set_column(10, 10, 30.00);
$worksheet->set_column(11, 11, 30.00);
$worksheet->set_column(12, 12, 30.00);
$worksheet->set_column(13, 13, 30.00);
$worksheet->set_column(14, 14, 30.00);
$worksheet->set_column(15, 15, 30.00);
$worksheet->set_column(16, 16, 30.00);
$worksheet->set_column(17, 17, 30.00);
$worksheet->set_column(18, 18, 30.00);
$worksheet->set_column(19, 19, 30.00);
$worksheet->set_column(20, 20, 30.00);
$worksheet->set_column(21, 21, 30.00);
$worksheet->set_column(22, 22, 30.00);

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

$worksheet->write(1, 1, "PEMBAYARAN MANFAAT PASCA KERJA yang dilakukan PT. PELINDO PROPERTI INDONESIA kepada karyawan Tetap yang berhenti pada periode 1 januari ".$reqPeriode." s/d 31 Desember ".$reqPeriode, $text_format);
$worksheet->write(2, 1, "RINCIAN TERDIRI DARI :", $text_format);

$worksheet->write(4, 1, "No", $text_format_line_bold);
$worksheet->write(4, 2, "NIK", $text_format_line_bold);
$worksheet->write(4, 3, "NAMA", $text_format_line_bold);
$worksheet->write(4, 4, "Gender", $text_format_line_bold);
$worksheet->write(4, 5, "Status", $text_format_line_bold);
$worksheet->write(4, 6, "Jabatan", $text_format_line_bold);
$worksheet->write(4, 7, "Divisi", $text_format_line_bold);
$worksheet->write(4, 8, "Tanggal Lahir", $text_format_line_bold);
$worksheet->write(4, 9, "Tanggal Mulai Bekerja P3", $text_format_line_bold);
$worksheet->write(4, 10, "Tanggal Mulai Bekerja PMS", $text_format_line_bold);
$worksheet->write(4, 11, "Tanggal Berhenti Bekerja", $text_format_line_bold);
$worksheet->write(4, 12, "Merit (Gross) 31-Des-".$reqPeriode, $text_format_line_bold);
$worksheet->write(4, 13, "TPP (Gross) 31-Des-".$reqPeriode, $text_format_line_bold);
$worksheet->write(4, 14, "Tun. Sel (Gross) 31-Des-".$reqPeriode, $text_format_line_bold);
$worksheet->write(4, 15, "Tun. Jab (Gross) 31-Des-".$reqPeriode, $text_format_line_bold);
$worksheet->write(4, 16, "Total Upah (Gross) Saat Berhenti", $text_format_line_bold);
$worksheet->write(4, 17, "Purnabakti (Gross) saat Berhenti Bekerja", $text_format_line_bold);
$worksheet->write(4, 18, "Saldo DPLK Porel Perusahaan Saat Berhenti Bekerja", $text_format_line_bold);
$worksheet->write(4, 19, "PhDP Saat Berhenti Bekerja", $text_format_line_bold);
$worksheet->write(4, 20, "Besar Manfaat dari Perusahaan (Gross) Saat Berhenti Bekerja", $text_format_line_bold);
$worksheet->write(4, 21, "Uang Duka & Uang Pemakaman (Jika Karyawan Meninggal)", $text_format_line_bold);
$worksheet->write(4, 22, "Alasan Berhenti Kerja", $text_format_line_bold);


$row = 5;
$root_departemen = "";
while($pembayaran_manfaat->nextRow())
{
	
	if($root_departemen == $pembayaran_manfaat->getField("ROOT_DEPARTEMEN"))
	{}
	else
	{
	$root_departemen = "";
	$rowseq = 1;
		$worksheet->write($row, 1, $pembayaran_manfaat->getField("ROOT_DEPARTEMEN"), $text_format_merge_line_bold);
		$worksheet->write_blank($row, 2, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 3, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 4, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 5, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 6, $text_format_merge_line_bold);		
		$worksheet->write_blank($row, 7, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 8, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 9, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 10, $text_format_merge_line_bold);
		
		$worksheet->write_blank($row, 11, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 12, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 13, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 14, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 15, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 16, $text_format_merge_line_bold);		
		$worksheet->write_blank($row, 17, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 18, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 19, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 20, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 21, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 22, $text_format_merge_line_bold);
		$row++;
	}
	
	$worksheet->write($row, 1, $rowseq, $text_format_line);
	$worksheet->write($row, 2, $pembayaran_manfaat->getField("NRP"), $text_format_line);
	$worksheet->write($row, 3, $pembayaran_manfaat->getField("NAMA"), $text_format_line_left);
	$worksheet->write($row, 4, $pembayaran_manfaat->getField("GENDER"), $text_format_line_left);
	$worksheet->write($row, 5, $pembayaran_manfaat->getField("STATUS"), $text_format_line);
	$worksheet->write($row, 6, $pembayaran_manfaat->getField("JABATAN"), $text_format_line);
	$worksheet->write($row, 7, $pembayaran_manfaat->getField("DIVISI"), $text_format_line);
	$worksheet->write($row, 8, $pembayaran_manfaat->getField("TGL_LAHIR"), $text_format_line);
	$worksheet->write($row, 9, $pembayaran_manfaat->getField("TGL_MULAI_BEKERJA_P3"), $text_format_line);
	$worksheet->write($row, 10, $pembayaran_manfaat->getField("TGL_MULAI_BEKERJA_PMS"), $text_format_line);
	$worksheet->write($row, 11, $pembayaran_manfaat->getField("TGL_MULAI_BERHENTI_PMS"), $text_format_line);
	
	$worksheet->write($row, 12, $pembayaran_manfaat->getField("MERIT_PMS"), $uang_line);
	$worksheet->write($row, 13, $pembayaran_manfaat->getField("TPP_PMS"), $uang_line);
	$worksheet->write($row, 14, $pembayaran_manfaat->getField("TUNJANGAN_PERBANTUAN"), $uang_line);
	$worksheet->write($row, 15, $pembayaran_manfaat->getField("TUNJANGAN_JABATAN"), $uang_line);
	$worksheet->write($row, 16, $pembayaran_manfaat->getField("TOTAL_UPAH_GROSS"), $uang_line);
	$worksheet->write($row, 17, $pembayaran_manfaat->getField("TOTAL_PURNA_BAKTI"), $uang_line);
	$worksheet->write($row, 18, $pembayaran_manfaat->getField("SALDO_DPLK_SAAT_BERHENTI"), $uang_line);
	$worksheet->write($row, 19, $pembayaran_manfaat->getField("PHDP_SAAT_BERHENTI"), $uang_line);
	$worksheet->write($row, 20, $pembayaran_manfaat->getField("BESAR_MANFAAT_PERUSAHAAN"), $uang_line);
	$worksheet->write($row, 21, $pembayaran_manfaat->getField("UANG_DUKA"), $uang_line);
	$worksheet->write($row, 22, $pembayaran_manfaat->getField("ALASAN_BERHENTI"), $text_format_line_left);

	$root_departemen = $pembayaran_manfaat->getField("ROOT_DEPARTEMEN");
	$row++;
	$rowseq++;
}
	$worksheet->write($row++, 1, "Note:", $text_format);
	$worksheet->write($row++, 1, "Yang termasuk pembayaran manfaat apabila karyawan:", $text_format);
	$worksheet->write($row++, 1, "1.mengundurkan diri (Resignation Benefit).", $text_format);
	$worksheet->write($row++, 1, "2.mencapai usia pensiun (Retirement Benefit).", $text_format);
	$worksheet->write($row++, 1, "3.meninggal(Death Benefit).", $text_format);
	$worksheet->write($row++, 1, "4.mengalami cacat/sakit berkepanjangan(Disabilitty/Prolonged lilness Benefit).", $text_format);
	$worksheet->write($row++, 1, "Manfaat yang diberikan tidak termasuk gaji yang terhutang/cuti tahunan yang dibayar/THR, dsb", $text_format);
	$worksheet->write($row++, 1, "(hanya perhitungan pembelian manfaat berdasarkan UUK No. 13 Thn 2003 dan Peraturan Perusahaan", $text_format);
	$worksheet->write($row++, 1, "pembayaran manfaat juga termasuk (jika ada):", $text_format);
	$worksheet->write($row++, 1, "Cuti Panjang (bukan cuti tahunan), Jubllee atau Penghargaan Masa Kerja dalam bentuk emas, nominal dll", $text_format);

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"pembayaran_manfaat.xls\"");
header("Content-Disposition: inline; filename=\"pembayaran_manfaat.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>