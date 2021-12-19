<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/BonusTahunan.php");

require_once "../WEB-INF/lib/excel/class.writeexcel_workbookbig.inc.php";
require_once "../WEB-INF/lib/excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "daftar_pengantar_bonus_tahunan_excel.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$bonus_tahunan = new BonusTahunan();

$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");

$arrJenisPegawaiId = explode(",", $reqJenisPegawaiId);
/*if(count($arrJenisPegawaiId) > 1)
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

$bonus_tahunan->selectByParamsDaftarPengantarBankReport(array(), -1, -1, "", $reqPeriode, " ORDER BY BANK, NAMA ASC");

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 5.00);
$worksheet->set_column(2, 2, 15.00);
$worksheet->set_column(3, 3, 33.00);
$worksheet->set_column(4, 4, 14.00);
$worksheet->set_column(5, 5, 13.00);

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

if($reqJenisPegawaiId == 1)
	$caption = "PEGAWAI";
elseif($reqJenisPegawaiId == 2)
	$caption = "PEGAWAI";
elseif($reqJenisPegawaiId == 3)
	$caption = "PEGAWAI KONTRAK";
elseif($reqJenisPegawaiId == 5)
	$caption = "PTTKP";
elseif($reqJenisPegawaiId == 6)
	$caption = "DEWAN DIREKSI";
elseif($reqJenisPegawaiId == 7)
	$caption = "DEWAN KOMISARIS";
	
//$worksheet->insert_bitmap('B1', 'images/logo_cetak.bmp', 5, 5);
$worksheet->write(1, 1, "DAFTAR PENGANTAR PEMBAYARAN TUNJANGAN BONUS TAHUNAN ", $text_format);
$worksheet->write(2, 1, "PERIODE ".$reqPeriode, $text_format);

$worksheet->write(4, 1, "NO.", $text_format_line_bold);
$worksheet->write(4, 2, "NRP", $text_format_line_bold);
$worksheet->write(4, 3, "NAMA PEGAWAI", $text_format_line_bold);
$worksheet->write(4, 4, "NO. REKENING", $text_format_line_bold);
$worksheet->write(4, 5, "JUMLAH DITERIMA", $text_format_line_bold);

/*$worksheet->write(5, 1, "167121872", $text_format_line);
$worksheet->write(5, 2, "LUSIA TIVIANIE, SH, MH", $text_format_line_left);
$worksheet->write(5, 3, "5", $text_format_line);
$worksheet->write(5, 4, "Manager SDM dan Umum", $text_format_line_left);
$worksheet->write(5, 5, "326873", $uang_line);
$worksheet->write(5, 6, "14871", $uang_line);*/


$row = 5;
$bank = "";
$i=1;
while($bonus_tahunan->nextRow())
{	
	$jumlah_lain_lain=$bonus_tahunan->getField('BNI') + $bonus_tahunan->getField('BUKOPIN') + $bonus_tahunan->getField('BRI') + $bonus_tahunan->getField('BTN') + $bonus_tahunan->getField('BPD') + $bonus_tahunan->getField('SIMPANAN_WAJIB_KOPERASI') + $bonus_tahunan->getField('MITRA_KARYA_ANGGOTA') + $bonus_tahunan->getField('INFAQ') + $bonus_tahunan->getField('KOPERASI') +  $bonus_tahunan->getField('POTONGAN_LAIN');
	$jumlah_potongan=$bonus_tahunan->getField('IURAN_TASPEN') + $bonus_tahunan->getField('DANA_PENSIUN') + $bonus_tahunan->getField('IURAN_KESEHATAN') + $bonus_tahunan->getField('POTONGAN_PPH21') + $bonus_tahunan->getField('SUMBANGAN_MASJID') + $bonus_tahunan->getField('ASURANSI_JIWASRAYA') + $bonus_tahunan->getField('ARISAN_PERISPINDO') + $bonus_tahunan->getField('IURAN_SPPI') + $bonus_tahunan->getField('IURAN_PURNA_BAKTI') + $bonus_tahunan->getField('POTONGAN_DINAS');
	$jumlah_kotor= $bonus_tahunan->getField('MERIT_PMS') + $bonus_tahunan->getField('POTONGAN_PPH21') + $bonus_tahunan->getField('TUNJANGAN_PERBANTUAN') + $bonus_tahunan->getField('TUNJANGAN_JABATAN') + $bonus_tahunan->getField('TPP_PMS') + $bonus_tahunan->getField('MOBILITAS') + $bonus_tahunan->getField('TELEPON') + $bonus_tahunan->getField('BBM') + $bonus_tahunan->getField('PERUMAHAN');

	if ((($jumlah_kotor - ($jumlah_potongan + $jumlah_lain_lain)) % 1000) == 0) 
	{  
		$total_potongan = 1000;
	}
	else
	{
		$total_potongan = (($jumlah_kotor - ($jumlah_potongan + $jumlah_lain_lain)) % 1000);
	}
	$pembulatan = 1000 - $total_potongan;

	
	$jumlah_kotor_pembulatan = $jumlah_kotor + $pembulatan;
	$jumlah_diterima= $jumlah_kotor_pembulatan - $jumlah_potongan;
	$jumlah_dibayar= $jumlah_diterima - $jumlah_lain_lain;

	if($bank == $bonus_tahunan->getField('BANK'))
	{}
	else		
	{
		$worksheet->write($row, 1, strtoupper($bonus_tahunan->getField('BANK')),$text_format_merge_line_bold);
		$worksheet->write_blank($row, 2, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 3, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 4, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 5, $text_format_merge_line_bold);
		$row++;	
		$i=1;
	}	
	
	$worksheet->write($row, 1, $i,$text_format_line);
	$worksheet->write($row, 2, $bonus_tahunan->getField('NRP'),$text_format_line);
	$worksheet->write($row, 3, $bonus_tahunan->getField('NAMA'),$text_format_line_left);
	$worksheet->write($row, 4, " ".$bonus_tahunan->getField('REKENING_NO'),$text_format_num);
	$worksheet->write($row, 5, $bonus_tahunan->getField('JUMLAH'),$uang_line);
	$row++;
	$i++;
	$bank = $bonus_tahunan->getField('BANK');
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"daftar_pengantar_bonus_tahunan_excel.xls\"");
header("Content-Disposition: inline; filename=\"daftar_pengantar_bonus_tahunan_excel.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>