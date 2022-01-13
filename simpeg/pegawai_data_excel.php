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

$reqDepartemen 		= httpFilterGet("reqDepartemen");
$reqJenisPegawai 	= httpFilterGet("reqJenisPegawai");
$reqStatusPegawai 	= httpFilterGet("reqStatusPegawai");
$reqKelompok		= httpFilterGet("reqKelompok");

if(substr($reqDepartemen, 0, 3) == "CAB")
	$statement = " AND EXISTS(SELECT 1 FROM IMASYS_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
	$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

if($reqStatusPegawai == '')
	$statement .= 'AND A.STATUS_PEGAWAI_ID = 1';
else
	$statement .= 'AND A.STATUS_PEGAWAI_ID = '.$reqStatusPegawai;

if($reqJenisPegawai == "")
	$statement .= " AND NOT NVL(G.JENIS_PEGAWAI_ID, 1) = 8 ";
else
	$statement .= "AND G.JENIS_PEGAWAI_ID = ".$reqJenisPegawai;

if($reqKelompok == "")
	$statement .= "";
else
	$statement .= "AND KELOMPOK = '".$reqKelompok."'";
	
$pegawai->selectByParams(array(), -1, -1, $statement, " ORDER BY TO_NUMBER(D.KELAS) ASC, TO_NUMBER(D.NO_URUT) ASC");

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 11.00);
//$worksheet->set_column(2, 2, 11.00);
$worksheet->set_column(2, 2, 29.00);
$worksheet->set_column(3, 3, 37.00);
$worksheet->set_column(4, 4, 8.00);
$worksheet->set_column(5, 5, 12.00);
$worksheet->set_column(6, 6, 12.00);
$worksheet->set_column(7, 7, 10.00);
$worksheet->set_column(8, 8, 20.00);
$worksheet->set_column(9, 9, 15.00);
$worksheet->set_column(10, 10, 15.00);
$worksheet->set_column(11, 11, 11.00);
$worksheet->set_column(12, 12, 13.00);
$worksheet->set_column(13, 13, 15.00);
$worksheet->set_column(14, 14, 15.00);
$worksheet->set_column(15, 15, 15.00);
$worksheet->set_column(16, 16, 15.00);
$worksheet->set_column(17, 17, 15.00);
$worksheet->set_column(18, 18, 8.00);
 
$worksheet->set_column(19, 19, 25.00);
$worksheet->set_column(20, 20, 33.00);
$worksheet->set_column(21, 21, 15.00);
$worksheet->set_column(22, 22, 15.00);
$worksheet->set_column(23, 23, 15.00);
$worksheet->set_column(24, 24, 25.00);
$worksheet->set_column(25, 25, 25.00);
$worksheet->set_column(26, 26, 25.00);
$worksheet->set_column(27, 27, 25.00);
$worksheet->set_column(28, 28, 25.00);
$worksheet->set_column(29, 29, 15.00);
$worksheet->set_column(30, 30, 15.00);
$worksheet->set_column(31, 31, 15.00);
$worksheet->set_column(32, 32, 15.00);
$worksheet->set_column(33, 33, 15.00);

$worksheet->set_column(34, 34, 15.00);
$worksheet->set_column(35, 35, 15.00);
$worksheet->set_column(36, 36, 15.00);
$worksheet->set_column(37, 37, 15.00);

$worksheet->set_column(38, 38, 15.00);
$worksheet->set_column(39, 39, 15.00);
$worksheet->set_column(40, 40, 15.00);
 

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
$worksheet->write(1, 1, "Yayasan Barunawati Biru Surabaya", $text_format);


$worksheet->write(3, 1, "NRP", $text_format_line_bold);
//$worksheet->write(3, 2, "NIPP", $text_format_line_bold);d
$worksheet->write(3, 2, "NAMA", $text_format_line_bold);
$worksheet->write(3, 3, "JABATAN", $text_format_line_bold);
$worksheet->write(3, 4, "KELAS", $text_format_line_bold);
$worksheet->write(3, 5, "KONTRAK AWAL", $text_format_line_bold);
$worksheet->write(3, 6, "KONTRAK AKHIR", $text_format_line_bold);
$worksheet->write(3, 7, "KELOMPOK", $text_format_line_bold);
$worksheet->write(3, 8, "DEPARTEMEN", $text_format_line_bold);
$worksheet->write(3, 9, "JENIS KELAMIN", $text_format_line_bold);
$worksheet->write(3, 10, "TEMPAT LAHIR ", $text_format_line_bold);
$worksheet->write(3, 11, "TGL LAHIR ", $text_format_line_bold);
$worksheet->write(3, 12, "STATUS KAWIN", $text_format_line_bold);
$worksheet->write(3, 13, "STATUS KELUARGA", $text_format_line_bold);
$worksheet->write(3, 14, "PENDIDIKAN TERAKHIR", $text_format_line_bold);
$worksheet->write(3, 15, "UMUR", $text_format_line_bold);
$worksheet->write(3, 16, "TINGGI", $text_format_line_bold);
$worksheet->write(3, 17, "BERAT BADAN", $text_format_line_bold);
$worksheet->write(3, 18, "AGAMA", $text_format_line_bold); 
$worksheet->write(3, 19, "NO KTP", $text_format_line_bold);
$worksheet->write(3, 20, "ALAMAT", $text_format_line_bold);
$worksheet->write(3, 21, "TELEPON", $text_format_line_bold);
$worksheet->write(3, 22, "EMAIL", $text_format_line_bold);
$worksheet->write(3, 23, "NAMA BANK", $text_format_line_bold);
$worksheet->write(3, 24, "A.N. REKENING", $text_format_line_bold);
$worksheet->write(3, 25, "NO. REKENING", $text_format_line_bold);
$worksheet->write(3, 26, "NPWP", $text_format_line_bold);
$worksheet->write(3, 27, "NO MPP", $text_format_line_bold);
$worksheet->write(3, 28, "TANGGAL MPP", $text_format_line_bold);
$worksheet->write(3, 29, "NO JAMSOSTEK", $text_format_line_bold);
$worksheet->write(3, 30, "TANGGAL JAMSOSTEK", $text_format_line_bold);
$worksheet->write(3, 31, "TANGGAL MASUK", $text_format_line_bold);
$worksheet->write(3, 32, "MASA KERJA", $text_format_line_bold);
$worksheet->write(3, 33, "UMUR PENSIUN", $text_format_line_bold);
$worksheet->write(3, 34, "TANGGAL PENSIUN", $text_format_line_bold); 
$worksheet->write(3, 35, "TANGGAL MUTASI KELUAR", $text_format_line_bold);
$worksheet->write(3, 36, "TANGGAL WAFAT", $text_format_line_bold);
$worksheet->write(3, 37, "BIDANG STUDI", $text_format_line_bold);
$worksheet->write(3, 38, "LINERITAS", $text_format_line_bold);
$worksheet->write(3, 39, "SPESIFIKASI PRESTASI KARYA", $text_format_line_bold);
$worksheet->write(3, 40, "TUGAS PEMBIMBINGAN", $text_format_line_bold);





//$worksheet->write(3, 17, "ZODIAC", $text_format_line_bold);

/*$worksheet->write(5, 1, "167121872", $text_format_line);
$worksheet->write(5, 2, "LUSIA TIVIANIE, SH, MH", $text_format_line_left);
$worksheet->write(5, 3, "5", $text_format_line);
$worksheet->write(5, 4, "Manager SDM dan Umum", $text_format_line_left);*/


$row = 4;
while($pegawai->nextRow())
{
	$worksheet->write($row, 1, $pegawai->getField("NRP"), $text_format_line);
	$worksheet->write($row, 2, $pegawai->getField("NAMA"), $text_format_line_left);
	$worksheet->write($row, 3, $pegawai->getField("JABATAN_NAMA"), $text_format_line_left);
	$worksheet->write($row, 4, $pegawai->getField("KELAS"), $text_format_line);
	$worksheet->write($row, 5, dateToPageCheck($pegawai->getField("TANGGAL_KONTRAK_AWAL")), $text_format_line);
	$worksheet->write($row, 6, dateToPageCheck($pegawai->getField("TANGGAL_KONTRAK_AKHIR")), $text_format_line);
	$worksheet->write($row, 7, $pegawai->getField("KELOMPOK"), $text_format_line);
	$worksheet->write($row, 8, $pegawai->getField("DEPARTEMEN"), $text_format_line_left);
	$worksheet->write($row, 9, $pegawai->getField("JENIS_KELAMIN"), $text_format_line);
	$worksheet->write($row, 10, $pegawai->getField("TANGGAL_LAHIR"), $text_format_line);
	$worksheet->write($row, 11, dateToPageCheck($pegawai->getField("TANGGAL_LAHIR")), $text_format_line);
	$worksheet->write($row, 12, $pegawai->getField("STATUS_KAWIN"), $text_format_line);
	$worksheet->write($row, 13, $pegawai->getField("STATUS_KELUARGA"), $text_format_line);
	$worksheet->write($row, 14, $pegawai->getField("PENDIDIKAN_TERAKHIR"), $text_format_line_left);
	$worksheet->write($row, 15, $pegawai->getField("UMUR"), $uang_line);
	$worksheet->write($row, 16, $pegawai->getField("TINGGI"), $text_format_line);
	$worksheet->write($row, 17, $pegawai->getField("BERAT_BADAN"), $text_format_line);
	$worksheet->write($row, 18, $pegawai->getField("AGAMA_NAMA"), $text_format_line);
	$worksheet->write($row, 19, $pegawai->getField("KTP_NO"), $text_format_line);
	$worksheet->write($row, 20, $pegawai->getField("ALAMAT"), $text_format_line);
	$worksheet->write($row, 21, $pegawai->getField("TELEPON"), $text_format_line);
	$worksheet->write($row, 22, $pegawai->getField("EMAIL"), $text_format_line);
	$worksheet->write($row, 23, $pegawai->getField("NAMA_BANK"), $text_format_line);
	$worksheet->write($row, 24, $pegawai->getField("REKENING_NAMA"), $text_format_line);
	$worksheet->write($row, 25, $pegawai->getField("REKENING_NO"), $text_format_line);
	$worksheet->write($row, 26, $pegawai->getField("NPWP"), $text_format_line);
	$worksheet->write($row, 27, $pegawai->getField("NO_MPP"), $text_format_line);
	$worksheet->write($row, 28,dateToPageCheck($pegawai->getField("TANGGAL_MPP")), $text_format_line);
	$worksheet->write($row, 29, $pegawai->getField("JAMSOSTEK_NO"), $text_format_line);
	$worksheet->write($row, 30,dateToPageCheck($pegawai->getField("JAMSOSTEK_TANGGAL")), $text_format_line);
	$worksheet->write($row, 31,dateToPageCheck($pegawai->getField("TANGGAL_MASUK")), $text_format_line);
	$worksheet->write($row, 32,dateToPageCheck($pegawai->getField("MASA_KERJA")), $uang_line);
	$worksheet->write($row, 33,dateToPageCheck($pegawai->getField("UMUR_PENSIUN")), $uang_line);
	$worksheet->write($row, 34,dateToPageCheck($pegawai->getField("TANGGAL_PENSIUN")), $text_format_line);
	$worksheet->write($row, 35,dateToPageCheck($pegawai->getField("TANGGAL_MUTASI_KELUAR")), $text_format_line);
	$worksheet->write($row, 36,dateToPageCheck($pegawai->getField("TANGGAL_WAFAT")), $text_format_line);
	$worksheet->write($row, 37, $pegawai->getField("BIDANG_STUDI"), $text_format_line);
	$worksheet->write($row, 38, $pegawai->getField("LINERITAS"), $text_format_line);
	$worksheet->write($row, 39, $pegawai->getField("SPESIFIKASI_PRESTASI_KARYA"), $text_format_line);
	$worksheet->write($row, 40, $pegawai->getField("TUGAS_PEMBIMBINGAN"), $text_format_line);


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