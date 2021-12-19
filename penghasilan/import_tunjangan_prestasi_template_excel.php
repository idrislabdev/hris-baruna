<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");

include_once("../WEB-INF/classes/base-gaji/IntegrasiTunjanganPrestasi.php");

require_once "../WEB-INF/lib/excel/class.writeexcel_workbookbig.inc.php";
require_once "../WEB-INF/lib/excel/class.writeexcel_worksheet.inc.php";


$reqDepartemen = httpFilterGet("reqDepartemen");
$reqJenisPegawaiId = httpFilterGet("reqJenisPegawai");
$reqPeriode = httpFilterGet("reqPeriode");


$integrasi_tunjangan_prestasi = new IntegrasiTunjanganPrestasi();


$statement .= " AND A.PERIODE = '".$reqPeriode."' ";

if($reqJenisPegawaiId == "")
{}
else
{
	$statement .= " AND JENIS_PEGAWAI_ID = '".$reqJenisPegawaiId."'";
}

if(substr($reqDepartemen, 0, 3) == "CAB")
	$statement .= " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
	$statement .= " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%' ";


$integrasi_tunjangan_prestasi->selectByParamsImport(array(), -1, -1, $statement);
// echo($integrasi_tunjangan_prestasi->query); exit;

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

//$reqLokasi = httpFilterGet("reqLokasi");

$fname = tempnam("/tmp", "import_tunjangan_prestasi_template.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();


$worksheet->set_column(0, 0, 14.00);
$worksheet->set_column(1, 1, 27.20);
$worksheet->set_column(2, 2, 20.00);
$worksheet->set_column(3, 3, 15.00);
$worksheet->set_column(4, 4, 15.00);
$worksheet->set_column(5, 5, 15.00);
$worksheet->set_column(6, 6, 15.00);

//$worksheet->write_string();
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

$text_format_center =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow', fg_color => 0x16));
$text_format_center->set_color('black');
$text_format_center->set_size(8);
$text_format_center->set_border_color('black');
$text_format_center->set_bold(1);

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

$text_format_line_right =& $workbook->addformat(array(align => 'left', size => 8, font => 'Arial Narrow', fg_color => 0x16));
$text_format_line_right->set_color('black');
$text_format_line_right->set_size(8);
$text_format_line_right->set_border_color('black');
$text_format_line_right->set_right(1);

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

$date_format=& $workbook->addformat(array(num_format => 'dd-mm-yyyy', size => 8, font => 'Arial Narrow'));
$date_format->set_color('black');
$date_format->set_size(8);
$date_format->set_border_color('black');


$uang_line =& $workbook->addformat(array(num_format => '#,##0.##', size => 8, font => 'Arial Narrow'));
$uang_line->set_color('black');
$uang_line->set_size(8);
$uang_line->set_border_color('black');
$uang_line->set_left(1);
$uang_line->set_right(1);
$uang_line->set_top(1);
$uang_line->set_bottom(1);


//$worksheet->write(0, 0, "PEGAWAI_ID", $text_format_line_bold);
//$worksheet->write(0, 1, "PEGAWAI_PEND_PERJENJANGAN_ID", $text_format_line_bold);
$worksheet->write(0, 0, "PEGAWAI ID", $text_format_line_bold);
$worksheet->write(0, 1, "NAMA PEGAWAI", $text_format_line_bold);
$worksheet->write(0, 2, "JABATAN PEGAWAI", $text_format_line_bold);
$worksheet->write(0, 3, "DEPARTEMEN", $text_format_line_bold);
$worksheet->write(0, 4, "JUMLAH JAM MENGAJAR", $text_format_line_bold);
$worksheet->write(0, 5, "JUMLAH POTONGAN", $text_format_line_bold);
// $worksheet->write(0, 4, "JUMLAH JAM LEBIH", $text_format_line_bold);
// $worksheet->write(0, 5, "TARIF MENGAJAR", $text_format_line_bold);
// $worksheet->write(0, 6, "TARIF LEBIH ", $text_format_line_bold);


$row = 1;
while ($integrasi_tunjangan_prestasi->nextRow()) 
{
	$worksheet->write($row, 0, $integrasi_tunjangan_prestasi->getField("PEGAWAI_ID"), $text_format_line_left);
	$worksheet->write($row, 1, $integrasi_tunjangan_prestasi->getField("NAMA"), $text_format_line_left);
	$worksheet->write($row, 2, $integrasi_tunjangan_prestasi->getField("NAMA_JABATAN"), $text_format_line_left);
	$worksheet->write($row, 3, $integrasi_tunjangan_prestasi->getField("KATEGORI_SEKOLAH"), $text_format_line_left);
	$worksheet->write($row, 4, $integrasi_tunjangan_prestasi->getField("JUMLAH_JAM_MENGAJAR"), $text_format_line_left);
	$worksheet->write($row, 5, $integrasi_tunjangan_prestasi->getField("JUMLAH_POTONGAN"), $text_format_line_left);
	// $worksheet->write($row, 4, "", $text_format_line_left);
	// $worksheet->write($row, 5, "", $text_format_line_left);
	// $worksheet->write($row, 6, "", $text_format_line_left);

	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"import_tunjangan_prestasi_template.xls\"");
header("Content-Disposition: inline; filename=\"import_tunjangan_prestasi_template.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>