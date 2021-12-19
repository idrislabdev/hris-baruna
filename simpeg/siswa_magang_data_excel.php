<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

require_once "excel/class.writeexcel_workbookbig.inc.php";
require_once "excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "pegawai_data_excel.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$pegawai = new Pegawai();
$reqKelas = httpFilterGet("reqKelas");
$reqDepartemen = httpFilterGet("reqDepartemen");
$reqTanggalAwal	= httpFilterGet("reqPeriodeAwal");
$reqTanggalAkhir = httpFilterGet("reqPeriodeAkhir");



$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'" ;


if($reqKelas == "")
{}
else
	$statement .= ' AND G.DEPARTEMEN_KELAS_ID = '.$reqKelas;


if($reqStatusPegawai == '')
	$statement .= ' AND A.STATUS_PEGAWAI_ID = 1';
else
	$statement .= ' AND A.STATUS_PEGAWAI_ID = '.$reqStatusPegawai;

if($reqJenisPegawai == "")
	$statement .= " AND NVL(G.JENIS_PEGAWAI_ID, 1) = 8 ";
else
	$statement .= " AND G.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;

if($reqKelompok == "")
	$statement .= "";
else
	$statement .= " AND KELOMPOK = '".$reqKelompok."'";
	
	
$pegawai->selectByParamsSiswa(array(), -1, -1, $statement, " ORDER BY TO_NUMBER(D.KELAS) ASC, TO_NUMBER(D.NO_URUT) ASC");


$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 15.00);
$worksheet->set_column(2, 2, 25.00);
$worksheet->set_column(3, 3, 35.00);
$worksheet->set_column(4, 4, 10.00);
$worksheet->set_column(5, 5, 25.00);
$worksheet->set_column(6, 6, 10.00);
$worksheet->set_column(7, 7, 15.00);
$worksheet->set_column(8, 8, 20.00);
$worksheet->set_column(9, 9, 20.00);
$worksheet->set_column(10, 10, 12.00);
$worksheet->set_column(11, 11, 12.00);
$worksheet->set_column(12, 12, 11.00);
$worksheet->set_column(13, 13, 13.00);
$worksheet->set_column(14, 14, 38.00);
$worksheet->set_column(15, 15, 18.00);
$worksheet->set_column(16, 16, 22.00);

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
$worksheet->write(1, 1, "DATA SISWA YAYASAN BARUNAWATI BIRU SURABAYA", $text_format);

$worksheet->write(3, 1, "NIS", $text_format_line_bold);
$worksheet->write(3, 2, "NAMA", $text_format_line_bold);
$worksheet->write(3, 3, "JENIS KELAMIN", $text_format_line_bold);
$worksheet->write(3, 4, "TEMPAT LAHIR", $text_format_line_bold);
$worksheet->write(3, 5, "TANGGAL LAHIR", $text_format_line_bold);
$worksheet->write(3, 6, "ALAMAT", $text_format_line_bold);
$worksheet->write(3, 7, "TANGGAL MASUK KELAS", $text_format_line_bold);
$worksheet->write(3, 8, "SEKOLAH ID", $text_format_line_bold);
$worksheet->write(3, 9, "KELAS ID", $text_format_line_bold);
$worksheet->write(3, 10, "SEKOLAH", $text_format_line_bold);
$worksheet->write(3, 11, "KELAS", $text_format_line_bold);
$worksheet->write(3, 12, "SPP ", $text_format_line_bold);

/*$worksheet->write(5, 1, "167121872", $text_format_line);
$worksheet->write(5, 2, "LUSIA TIVIANIE, SH, MH", $text_format_line_left);
$worksheet->write(5, 3, "5", $text_format_line);
$worksheet->write(5, 4, "Manager SDM dan Umum", $text_format_line_left);*/

$row = 4;
while($pegawai->nextRow())
{
	$worksheet->write($row, 1, $pegawai->getField("NIS"), $text_format_line);
	$worksheet->write($row, 2, $pegawai->getField("NAMA"), $text_format_line_left);
	$worksheet->write($row, 3, $pegawai->getField("JENIS_KELAMIN"), $text_format_line_left);
	$worksheet->write($row, 4, $pegawai->getField("TEMPAT_LAHIR"), $text_format_line_left);
	$worksheet->write($row, 5, $pegawai->getField("TANGGAL_LAHIR_EKS"), $text_format_line_left);
	$worksheet->write($row, 6, $pegawai->getField("ALAMAT"), $text_format_line_left);
	$worksheet->write($row, 7, $pegawai->getField("TMT_JENIS_PEGAWAI_EKS"), $text_format_line_left);
	$worksheet->write($row, 8, ($pegawai->getField("DEPARTEMEN_ID")), $text_format_line);
	$worksheet->write($row, 9, ($pegawai->getField("DEPARTEMEN_KELAS_ID")), $text_format_line_left);
	$worksheet->write($row, 10, $pegawai->getField("DEPARTEMEN"), $text_format_line);
	$worksheet->write($row, 11, $pegawai->getField("DEPARTEMEN_KELAS"), $text_format_line);
	$worksheet->write($row, 12, ($pegawai->getField("JUMLAH_SPP")), $text_format_line);
	/*for ($k=4; $k<=34; $k++)
	{
			$worksheet->write($row, $k, $absensi_koreksi->getField('HARI_'.($k-3)), $text_format_line);
	}*/
	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"pegawai_data_excel.xls\"");
header("Content-Disposition: inline; filename=\"pegawai_data_excel.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>