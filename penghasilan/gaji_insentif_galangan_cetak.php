<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-operasional/Galangan.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");

require_once "../WEB-INF/lib/excel/class.writeexcel_workbookbig.inc.php";
require_once "../WEB-INF/lib/excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "cetak_insentif_galangan.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$galangan = new Galangan();
$galangan_pendapatan = new Galangan();

$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");

$galangan->selectByParamsInsetifGalangan(array("PERIODE" => $reqPeriode),-1,-1,$statement);
$galangan_pendapatan->selectByParamsGalanganPendapatan(array("PERIODE" => $reqPeriode),-1,-1,$statement);

$worksheet->set_column(0, 0, 4.43);
$worksheet->set_column(1, 1, 27.57);
$worksheet->set_column(2, 2, 27.57);
$worksheet->set_column(3, 3, 11.57);
$worksheet->set_column(4, 4, 11.57);
$worksheet->set_column(5, 5, 19.00);
$worksheet->set_column(6, 6, 19.00);
$worksheet->set_column(7, 7, 19.00);
$worksheet->set_column(8, 8, 19.00);
$worksheet->set_column(9, 9, 19.00);

$tanggal =& $workbook->addformat(array(num_format => ' dd mmmm yyy'));

$text_format =& $workbook->addformat(array( size => 10, font => 'Arial Narrow'));
$text_format_num =& $workbook->addformat(array( num_format => '###', size => 10, font => 'Arial Narrow', align => 'left'));

$text_format_left_none =& $workbook->addformat(array( size => 10, font => 'Arial Narrow'));
$text_format_left_none->set_color('black');

$text_format_merge =& $workbook->addformat(array(size => 8, font => 'Arial Narrow'));
$text_format_merge->set_color('black');
$text_format_merge->set_size(8);
$text_format_merge->set_border_color('black');
$text_format_merge->set_merge(1);
$text_format_merge->set_bold(1);

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

$uang_line_bold =& $workbook->addformat(array(num_format => '#,##0', size => 8, font => 'Arial Narrow'));
$uang_line_bold->set_color('black');
$uang_line_bold->set_size(8);
$uang_line_bold->set_bold(1);
$uang_line_bold->set_border_color('black');
$uang_line_bold->set_left(1);
$uang_line_bold->set_right(1);
$uang_line_bold->set_top(1);
$uang_line_bold->set_bottom(1);


//$worksheet->insert_bitmap('B1', 'images/logo_cetak.bmp', 5, 5);

$worksheet->write		(1, 0, "DAFTAR PEMBAYARAN INSENTIF KHUSUS GALANGAN", $text_format_merge);
$worksheet->write_blank	(1, 1, $text_format_merge);
$worksheet->write_blank	(1, 2, $text_format_merge);
$worksheet->write_blank	(1, 3, $text_format_merge);
$worksheet->write_blank	(1, 4, $text_format_merge);
$worksheet->write_blank	(1, 5, $text_format_merge);
$worksheet->write_blank	(1, 6, $text_format_merge);
$worksheet->write_blank	(1, 7, $text_format_merge);
$worksheet->write_blank	(1, 8, $text_format_merge);
$worksheet->write_blank	(1, 9, $text_format_merge);

$worksheet->write		(2, 0, "PT. PELINDO PROPERTI INDONESIA", $text_format_merge);
$worksheet->write_blank	(2, 1, $text_format_merge);
$worksheet->write_blank	(2, 2, $text_format_merge);
$worksheet->write_blank	(2, 3, $text_format_merge);
$worksheet->write_blank	(2, 4, $text_format_merge);
$worksheet->write_blank	(2, 5, $text_format_merge);
$worksheet->write_blank	(2, 6, $text_format_merge);
$worksheet->write_blank	(2, 7, $text_format_merge);
$worksheet->write_blank	(2, 8, $text_format_merge);
$worksheet->write_blank	(2, 9, $text_format_merge);

$worksheet->write		(3, 0, "MASA BULAN : ".getNamePeriode($reqPeriode), $text_format_merge);
$worksheet->write_blank	(3, 1, $text_format_merge);
$worksheet->write_blank	(3, 2, $text_format_merge);
$worksheet->write_blank	(3, 3, $text_format_merge);
$worksheet->write_blank	(3, 4, $text_format_merge);
$worksheet->write_blank	(3, 5, $text_format_merge);
$worksheet->write_blank	(3, 6, $text_format_merge);
$worksheet->write_blank	(3, 7, $text_format_merge);
$worksheet->write_blank	(3, 8, $text_format_merge);
$worksheet->write_blank	(3, 9, $text_format_merge);

$worksheet->write(5, 7, "PENDAPATAN GALANGAN", $text_format);

$row2 = 6;
while($galangan_pendapatan->nextRow())
{
	$worksheet->write($row2, 7, $galangan_pendapatan->getField('NAMA'), $text_format);
	$worksheet->write($row2, 8, $galangan_pendapatan->getField('JUMLAH'), $uang);
	
	$jumlah += $galangan_pendapatan->getField('JUMLAH');	
	$row2++;
}

$insentif = $jumlah * 2.5 / 100;

$worksheet->write(8, 8, $jumlah, $uang);
$worksheet->write		(9, 7, "INSENTIF = 2.5% x NET REVENUE = ", $text_format_merge_none);
$worksheet->write_blank	(9, 8, $text_format_merge_none);
$worksheet->write(9, 9, $insentif, $uang);

/*$worksheet->write(11, 8, "DIBULATKAN", $text_format_center);
$worksheet->write(11, 9, "10755000", $uang);*/

$worksheet->write(13, 0, "", $text_format_line_bold);
$worksheet->write(13, 1, "", $text_format_line_bold);
$worksheet->write(13, 2, "", $text_format_line_bold);
$worksheet->write(13, 3, "", $text_format_line_bold);
$worksheet->write(13, 4, "POTONGAN", $text_format_line_bold);
$worksheet->write(13, 5, "", $text_format_line_bold);
$worksheet->write(13, 6, "POTONGAN", $text_format_line_bold);
$worksheet->write(13, 7, "JUMLAH", $text_format_line_bold);
$worksheet->write(13, 8, "JUMLAH", $text_format_line_bold);
$worksheet->write(13, 9, "", $text_format_line_bold);

$worksheet->write(14, 0, "NO", $text_format_line_bold);
$worksheet->write(14, 1, "NAMA", $text_format_line_bold);
$worksheet->write(14, 2, "JABATAN", $text_format_line_bold);
$worksheet->write(14, 3, "INSENTIF", $text_format_line_bold);
$worksheet->write(14, 4, "PPH", $text_format_line_bold);
$worksheet->write(14, 5, "INSENTIF", $text_format_line_bold);
$worksheet->write(14, 6, "KEHADIRAN", $text_format_line_bold);
$worksheet->write(14, 7, "POTONGAN", $text_format_line_bold);
$worksheet->write(14, 8, "DITERIMA", $text_format_line_bold);
$worksheet->write(14, 9, "TANDA TANGAN", $text_format_line_bold);

$worksheet->write(15, 0, "", $text_format_line_bold);
$worksheet->write(15, 1, "", $text_format_line_bold);
$worksheet->write(15, 2, "", $text_format_line_bold);
$worksheet->write(15, 3, "%", $text_format_line_bold);
$worksheet->write(15, 4, "%", $text_format_line_bold);
$worksheet->write(15, 5, "( Rp. )", $text_format_line_bold);
$worksheet->write(15, 6, "( Rp. )", $text_format_line_bold);
$worksheet->write(15, 7, "PPH", $text_format_line_bold);
$worksheet->write(15, 8, "", $text_format_line_bold);
$worksheet->write(15, 9, "", $text_format_line_bold);

$worksheet->write(16, 0, "1", $text_format_line_bold);
$worksheet->write(16, 1, "2", $text_format_line_bold);
$worksheet->write(16, 2, "3", $text_format_line_bold);
$worksheet->write(16, 3, "4", $text_format_line_bold);
$worksheet->write(16, 4, "5", $text_format_line_bold);
$worksheet->write(16, 5, "7", $text_format_line_bold);
$worksheet->write(16, 6, "8", $text_format_line_bold);
$worksheet->write(16, 7, "9", $text_format_line_bold);
$worksheet->write(16, 8, "10", $text_format_line_bold);
$worksheet->write(16, 9, "11", $text_format_line_bold);

$row = 17;
$i=1;
while($galangan->nextRow())
{
	
	$worksheet->write($row, 0, $i, $text_format_line);
	$worksheet->write($row, 1, $galangan->getField('NAMA'), $text_format_line);
	$worksheet->write($row, 2, $galangan->getField('JABATAN'), $text_format_line);
	$worksheet->write($row, 3, $galangan->getField('PROSENTASE_INSENTIF'), $text_format_line);
	$worksheet->write($row, 4, $galangan->getField('PROSENTASE_POTONGAN_PPH'), $text_format_line);
	$worksheet->write($row, 5, $galangan->getField('JUMLAH_INSENTIF'), $uang_line);
	$worksheet->write($row, 6, $galangan->getField('POTONGAN_KEHADIRAN'), $uang_line);
	$worksheet->write($row, 7, $galangan->getField('JUMLAH_POTONGAN_PPH'), $uang_line);
	$worksheet->write($row, 8, $galangan->getField('JUMLAH_DITERIMA'), $uang_line);
	$worksheet->write($row, 9, "", $text_format_line);
	
	$jumlah_diterima 		+= $galangan->getField('JUMLAH_DITERIMA');
	$jumlah_potongan_pph 	+= $galangan->getField('JUMLAH_POTONGAN_PPH');
	$jumlah_insentif 		+= $galangan->getField('JUMLAH_INSENTIF');
	
	$row++;
	$i++;
}

$child= new PegawaiJabatan();
$child->selectByParamsPegawaiJabatanOperasional(array("C.JABATAN_ID"=>"5","A.STATUS_PEGAWAI_ID"=>"1"),-1,-1);
$child->firstRow();
$nama_jabatan_1= $child->getField("JABATAN_NAMA");
$nama_pejabat_1= $child->getField("NAMA");
unset($child);

$child= new PegawaiJabatan();
$child->selectByParamsPegawaiJabatanOperasional(array("C.JABATAN_ID"=>"1","A.STATUS_PEGAWAI_ID"=>"1"),-1,-1);
$child->firstRow();
$nama_jabatan_2= $child->getField("JABATAN_NAMA");
$nama_pejabat_2= $child->getField("NAMA");
unset($child);

$worksheet->write($row, 0, "", $text_format_line);
$worksheet->write($row, 1, "", $text_format_line);
$worksheet->write($row, 2, "", $text_format_line);
$worksheet->write($row, 3, "", $text_format_line);
$worksheet->write($row, 4, "", $text_format_line);
$worksheet->write($row, 5, $jumlah_insentif , $uang_line_bold);
$worksheet->write($row, 6, $jumlah_insentif , $uang_line_bold);
$worksheet->write($row, 7, $jumlah_potongan_pph, $uang_line_bold);
$worksheet->write($row, 8, $jumlah_diterima, $uang_line_bold);
$worksheet->write($row, 9, "", $text_format_line);

$worksheet->write($row+2, 1, "Catatan : Angka besaran insentif dan pajak adalah angka pembulatan", $text_format);

$worksheet->write($row+4, 1, "TERBILANG : ".terbilang($jumlah_insentif) . " rupiah ", $text_format);
$worksheet->write($row+4, 9, "SURABAYA, ".strtoupper(getNamePeriode($reqPeriode)), $text_format_center);

$worksheet->write($row+6, 5, "MENGETAHUI,", $text_format_center);
$worksheet->write($row+6, 9, "PEMBUAT DAFTAR", $text_format_center);

$worksheet->write($row+7, 5, $nama_jabatan_1 . ",", $text_format_center);
$worksheet->write($row+7, 9, $nama_jabatan_2, $text_format_center);

$worksheet->write($row+11, 5, $nama_pejabat_1 . ",", $text_format_center);
$worksheet->write($row+11, 9, $nama_pejabat_2, $text_format_center);

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"cetak_insentif_galangan.xls\"");
header("Content-Disposition: inline; filename=\"cetak_insentif_galangan.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>