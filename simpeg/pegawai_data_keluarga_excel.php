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
	
$pegawai->selectByParamsDataKeluarga(array(), -1, -1, $statement, " ORDER BY A.NAMA ");

$worksheet->set_column(0, 0, 8.00);
$worksheet->set_column(1, 1, 5.00);
$worksheet->set_column(2, 2, 5.00);
$worksheet->set_column(3, 3, 10.00);
$worksheet->set_column(4, 4, 32.00);
$worksheet->set_column(5, 5, 15.00);
$worksheet->set_column(6, 6, 20.00);
$worksheet->set_column(7, 7, 15.00);
$worksheet->set_column(8, 8, 12.00);
$worksheet->set_column(9, 9, 10.00);

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
$worksheet->write(1, 1, "DATA PEGAWAI PT PELINDO MARINE SERVICE", $text_format);

$worksheet->write(3, 1, "NO", $text_format_line_bold);
$worksheet->write(3, 2, "NO", $text_format_line_bold);
$worksheet->write(3, 3, "NRP", $text_format_line_bold);
$worksheet->write(3, 4, "NAMA PEGAWAI & TANGGUNGAN KELUARGA", $text_format_line_bold);
$worksheet->write(3, 5, "NIK", $text_format_line_bold);
$worksheet->write(3, 6, "STATUS", $text_format_line_bold);
$worksheet->write(3, 7, "TANGGAL LAHIR", $text_format_line_bold);
$worksheet->write(3, 8, "JENIS KELAMIN", $text_format_line_bold);
$worksheet->write(3, 9, "USIA", $text_format_line_bold);

/*$worksheet->write(5, 1, "167121872", $text_format_line);
$worksheet->write(5, 2, "LUSIA TIVIANIE, SH, MH", $text_format_line_left);
$worksheet->write(5, 3, "5", $text_format_line);
$worksheet->write(5, 4, "Manager SDM dan Umum", $text_format_line_left);*/

$row = 4;
$nrp = "";
$nomor = 0;
$urutan = 1;
while($pegawai->nextRow())
{
	if ($nrp <> $pegawai->getField("NRP")) {
		$nomor = $nomor + 1;
		$urutan = 1;
		$worksheet->write($row, 1, $nomor, $text_format_line);
		$worksheet->write($row, 2, $urutan, $text_format_line);
		$worksheet->write($row, 3, $pegawai->getField("NRP"), $text_format_line);
		$worksheet->write($row, 4, $pegawai->getField("NAMA"), $text_format_line_left);
		$worksheet->write($row, 5, '', $text_format_line_left);
		$worksheet->write($row, 6, 'Diri Sendiri', $text_format_line_left);
		$worksheet->write($row, 7, dateToPageCheck($pegawai->getField("TANGGAL_LAHIR")), $text_format_line_left);
		$worksheet->write($row, 8, $pegawai->getField("JENIS_KELAMIN"), $text_format_line);
		$worksheet->write($row, 9, $pegawai->getField("USIA"), $text_format_line);
		$nrp = $pegawai->getField("NRP");
		$row++;
	}
	if ($pegawai->getField("NAMA_KELUARGA") <> $pegawai->getField("NAMA")) {
		$urutan = $urutan + 1;
	$worksheet->write($row, 1, '', $text_format_line);
	$worksheet->write($row, 2, $urutan, $text_format_line);
	$worksheet->write($row, 3, '', $text_format_line);
	$worksheet->write($row, 4, $pegawai->getField("NAMA_KELUARGA"), $text_format_line_left);
	$worksheet->write($row, 5, $pegawai->getField("NIK"), $text_format_line_left);
	$worksheet->write($row, 6, $pegawai->getField("HUBUNGAN_KELUARGA"), $text_format_line_left);
	$worksheet->write($row, 7, dateToPageCheck($pegawai->getField("TANGGAL_LAHIR_KELUARGA")), $text_format_line_left);
	$worksheet->write($row, 8, $pegawai->getField("JENIS_KELAMIN_KELUARGA"), $text_format_line);
	$worksheet->write($row, 9, $pegawai->getField("USIA_KELUARGA"), $text_format_line);
	$nrp = $pegawai->getField("NRP");
	$row++;
	}
	
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"pegawai_data_excel.xls\"");
header("Content-Disposition: inline; filename=\"pegawai_data_excel.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>