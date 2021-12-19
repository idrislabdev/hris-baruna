<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/Pajak.php");

require_once "excel/class.writeexcel_workbookbig.inc.php";
require_once "excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);


$reqPeriode = httpFilterGet("reqPeriode");

if($reqPeriode == "")
{
	include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbrThnBukuD.php");
	$periode_buku = new KbbrThnBukuD();
	$reqPeriode = $periode_buku->getPeriodeAkhir();
}
	
$reqBulan = substr($reqPeriode, 0, 2);
$reqTahun = substr($reqPeriode, 2, 4);

if($reqBulan == "01")
	$reqBulan = "12";
else
	$reqBulan = generateZero((int)$reqBulan - 1, 2);

if($reqBulan == "01")
	$reqTahun = $reqTahun - 1;

$reqPeriodeLalu = $reqBulan.$reqTahun;


//echo $reqPeriode;

$fname = tempnam("/tmp", "pph21_excel".$reqPeriode.".xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$pajak = new Pajak();


$pajak->selectByParamsPph21Pegawai(array(), -1, -1, "", "ORDER BY F.JENIS_URUT ASC, DECODE(P.JENIS_PEGAWAI_ID, 6, TO_CHAR(A.NO_URUT), 7, TO_CHAR(A.NO_URUT), P.NAMA) ASC ", $reqPeriode, $reqPeriodeLalu);

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 16.00);
$worksheet->set_column(2, 2, 35.00);

for ($i=3; $i<=22; $i++)
$worksheet->set_column($i, $i, 15.00);


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

$text_format_merge_line_bold_color =& $workbook->addformat(array(size => 8, font => 'Arial Narrow', fg_color => 0x16));
$text_format_merge_line_bold_color->set_color('black');
$text_format_merge_line_bold_color->set_size(8);
$text_format_merge_line_bold_color->set_border_color('black');
$text_format_merge_line_bold_color->set_merge(1);
$text_format_merge_line_bold_color->set_bold(1);
$text_format_merge_line_bold_color->set_left(1);
$text_format_merge_line_bold_color->set_right(1);
$text_format_merge_line_bold_color->set_top(1);
$text_format_merge_line_bold_color->set_bottom(1);

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

$npwp_line =& $workbook->addformat(array(num_format => '###0', size => 8, font => 'Arial Narrow'));
$npwp_line->set_color('black');
$npwp_line->set_size(8);
$npwp_line->set_border_color('black');
$npwp_line->set_left(1);
$npwp_line->set_right(1);
$npwp_line->set_top(1);
$npwp_line->set_bottom(1);


//$worksheet->insert_bitmap('B1', 'images/logo_cetak.bmp', 5, 5);
$worksheet->write(1, 1, "DAFTAR REKAP PPH 21", $text_format);
	
$worksheet->write(4, 1, "NRP", $text_format_line_bold);
$worksheet->write(4, 2, "NAMA", $text_format_line_bold);
$worksheet->write(4, 3, "NPWP", $text_format_line_bold);
$worksheet->write(4, 4, "GAJI DIREKSI", $text_format_merge_line_bold);
for($i=5; $i<=8; $i++)
$worksheet->write_blank(4, $i, $text_format_merge_line_bold);
$worksheet->write(4, 9, "GAJI", $text_format_merge_line_bold);
for($i=10; $i<=14; $i++)
$worksheet->write_blank(4, $i, $text_format_merge_line_bold);
$worksheet->write(4, 15, "UANG MAKAN", $text_format_merge_line_bold);
for($i=16; $i<=17; $i++)
$worksheet->write_blank(4, $i, $text_format_merge_line_bold);
$worksheet->write(4, 18, "UANG TRANSPORT", $text_format_merge_line_bold);
for($i=19; $i<=20; $i++)
$worksheet->write_blank(4, $i, $text_format_merge_line_bold);
$worksheet->write(4, 21, "INSENTIF", $text_format_merge_line_bold);
for($i=22; $i<=22; $i++)
$worksheet->write_blank(4, $i, $text_format_merge_line_bold);
$worksheet->write(4, 23, "PREMI", $text_format_merge_line_bold);
for($i=24; $i<=24; $i++)
$worksheet->write_blank(4, $i, $text_format_merge_line_bold);
$worksheet->write(4, 25, "JUMLAH", $text_format_merge_line_bold);
for($i=26; $i<=27; $i++)
$worksheet->write_blank(4, $i, $text_format_merge_line_bold);

$worksheet->write(5, 1, "", $text_format_line_bold);
$worksheet->write(5, 2, "", $text_format_line_bold);
$worksheet->write(5, 3, "", $text_format_line_bold);
$worksheet->write(5, 4, "GAJI DIREKSI", $text_format_line_bold);
$worksheet->write(5, 5, "TUNJ. TRANSPORT", $text_format_line_bold);
$worksheet->write(5, 6, "TUNJ. PERUM", $text_format_line_bold);
$worksheet->write(5, 7, "TUNJ. KOMUNIKASI", $text_format_line_bold);
$worksheet->write(5, 8, "PPH 21", $text_format_line_bold);
$worksheet->write(5, 9, "PENGHASILAN", $text_format_line_bold);
$worksheet->write(5, 10, "TUNJ. STRUKTURAL", $text_format_line_bold);
$worksheet->write(5, 11, "TUNJ. PRESTASI", $text_format_line_bold);
$worksheet->write(5, 12, "DPP", $text_format_line_bold);
$worksheet->write(5, 13, "PPH 21", $text_format_line_bold);
$worksheet->write(5, 14, "TUNJ. PPH 21", $text_format_line_bold);
$worksheet->write(5, 15, "DPP", $text_format_line_bold);
$worksheet->write(5, 16, "PPH 21", $text_format_line_bold);
$worksheet->write(5, 17, "TUNJ. PPH 21", $text_format_line_bold);
$worksheet->write(5, 18, "DPP", $text_format_line_bold);
$worksheet->write(5, 19, "PPH 21", $text_format_line_bold);
$worksheet->write(5, 20, "TUNJ. PPH 21", $text_format_line_bold);
$worksheet->write(5, 21, "DPP", $text_format_line_bold);
$worksheet->write(5, 22, "PPH 21", $text_format_line_bold);
$worksheet->write(5, 23, "DPP", $text_format_line_bold);
$worksheet->write(5, 24, "PPH 21", $text_format_line_bold);
$worksheet->write(5, 25, "DPP", $text_format_line_bold);
$worksheet->write(5, 26, "PPH 21", $text_format_line_bold);
$worksheet->write(5, 27, "TUNJ. PPH 21", $text_format_line_bold);

$row = 6;

$pph21 = "";

while($pajak->nextRow())
{
	if($pph21 == $pajak->getField("JENIS_PEGAWAI"))
	{}
	else
	{
		$worksheet->write($row, 1, $pajak->getField("JENIS_PEGAWAI"), $text_format_merge_line_bold_color);
		for($j=2; $j<=27; $j++)
		$worksheet->write_blank($row, $j, $text_format_merge_line_bold_color);
		
		$row++;
	}
	
	$worksheet->write($row, 1, $pajak->getField("NRP"), $text_format_line_left);
	$worksheet->write($row, 2, $pajak->getField("NAMA"), $text_format_line_left);
	$worksheet->write($row, 3, $pajak->getField("NPWP"), $npwp_line);
	if($pajak->getField("JENIS_PEGAWAI_ID") == "6" || $pajak->getField("JENIS_PEGAWAI_ID") == "7")
	{
		$worksheet->write($row, 4, $pajak->getField("MERIT_PMS"), $uang_line);
		$worksheet->write($row, 5, $pajak->getField("MOBILITAS"), $uang_line);
		$worksheet->write($row, 6, $pajak->getField("PERUMAHAN"), $uang_line);
		$worksheet->write($row, 7, $pajak->getField("TELEPON"), $uang_line);
		$worksheet->write($row, 8, $pajak->getField("POTONGAN_PPH21"), $uang_line);
		$worksheet->write($row, 9, "", $uang_line);
		$worksheet->write($row, 10, "", $uang_line);
		$worksheet->write($row, 11, "", $uang_line);
		$worksheet->write($row, 12, "", $uang_line);
		$worksheet->write($row, 13, "", $uang_line);
		$worksheet->write($row, 14, "", $uang_line);			
	}
	else
	{
		$worksheet->write($row, 4, "", $uang_line);
		$worksheet->write($row, 5, "", $uang_line);
		$worksheet->write($row, 6, "", $uang_line);
		$worksheet->write($row, 7, "", $uang_line);
		$worksheet->write($row, 8, "", $uang_line);		
		$worksheet->write($row, 9, $pajak->getField("PENGHASILAN"), $uang_line);
		$worksheet->write($row, 10, $pajak->getField("TUNJANGAN_JABATAN"), $uang_line);
		$worksheet->write($row, 11, $pajak->getField("TPP_PMS"), $uang_line);
		$worksheet->write($row, 12, $pajak->getField("JUMLAH_GAJI_KOTOR"), $uang_line);
		$worksheet->write($row, 13, $pajak->getField("POTONGAN_PPH21"), $uang_line);
		$worksheet->write($row, 14, $pajak->getField("POTONGAN_PPH21"), $uang_line);		
	}
	$worksheet->write($row, 15, $pajak->getField("UANG_MAKAN"), $uang_line);
	$worksheet->write($row, 16, $pajak->getField("UANG_MAKAN_PPH"), $uang_line);
	$worksheet->write($row, 17, $pajak->getField("UANG_MAKAN_PPH"), $uang_line);
	$worksheet->write($row, 18, $pajak->getField("UANG_TRANSPORT"), $uang_line);
	$worksheet->write($row, 19, $pajak->getField("UANG_TRANSPORT_PPH"), $uang_line);
	$worksheet->write($row, 20, $pajak->getField("UANG_TRANSPORT_PPH"), $uang_line);
	$worksheet->write($row, 21, $pajak->getField("UANG_INSENTIF"), $uang_line);
	$worksheet->write($row, 22, $pajak->getField("UANG_INSENTIF_PPH"), $uang_line);
	$worksheet->write($row, 23, $pajak->getField("UANG_PREMI"), $uang_line);
	$worksheet->write($row, 24, $pajak->getField("UANG_PREMI_PPH"), $uang_line);
	$worksheet->write($row, 25, $pajak->getField("TOTAL_DPP"), $uang_line);
	$worksheet->write($row, 26, $pajak->getField("TOTAL_PPH"), $uang_line);
	$worksheet->write($row, 27, $pajak->getField("TOTAL_PPH"), $uang_line);
	
	$pph21 = $pajak->getField("JENIS_PEGAWAI");
	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"pph21_excel_".$reqPeriode.".xls\"");
header("Content-Disposition: inline; filename=\"pph21_excel".$reqPeriode.".xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>