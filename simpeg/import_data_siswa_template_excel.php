<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");

include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
include_once("../WEB-INF/classes/base-simpeg/DepartemenKelas.php");

require_once "../keuangan/excel/class.writeexcel_workbookbig.inc.php";
require_once "../keuangan/excel/class.writeexcel_worksheet.inc.php";

$departemen = new Departemen();
$departemen_kelas = new DepartemenKelas();


//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

//$reqLokasi = httpFilterGet("reqLokasi");

$fname = tempnam("/tmp", "import_pendidikan_template.xls");
$workbook = new writeexcel_workbookbig($fname);

$workbook = new writeexcel_workbook($fname);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// echo "jbjbijb";
$arrayNama[0]="IMPORT DATA";
$arrayNama[1]="SEKOLAH";
// $arrayNama[2]="KELAS";

$departemen->selectByParamsImport(array());
$departemen_kelas->selectByParamsImport();

for ($i=0; $i < 2; $i++)
{

	$worksheet =& $workbook->addworksheet($arrayNama[$i]);

	// $worksheet->write_string();
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

	if ($i==0)
	{

		$worksheet->set_column(0, 0, 14.00);
		$worksheet->set_column(1, 1, 27.20);
		$worksheet->set_column(2, 2, 20.00);
		$worksheet->set_column(3, 3, 27.00);
		$worksheet->set_column(4, 4, 30.00);
		$worksheet->set_column(5, 5, 30.00);
		$worksheet->set_column(6, 6, 15.00);
		$worksheet->set_column(6, 7, 30.00);
		//$worksheet->write(0, 0, "PEGAWAI_ID", $text_format_line_bold);
		//$worksheet->write(0, 1, "PEGAWAI_PEND_PERJENJANGAN_ID", $text_format_line_bold);
		$worksheet->write(0, 0, "NIS", $text_format_line_bold);
		$worksheet->write(0, 1, "NAMA", $text_format_line_bold);
		$worksheet->write(0, 2, "JENIS KELAMIN", $text_format_line_bold);
		$worksheet->write(0, 3, "TEMPAT LAHIR", $text_format_line_bold);
		$worksheet->write(0, 4, "TANGGAL LAHIR(YYYYMMDD)", $text_format_line_bold);
		$worksheet->write(0, 5, "ALAMAT", $text_format_line_bold);
		$worksheet->write(0, 6, "TANGGAL MASUK KELAS(YYYYMMDD)", $text_format_line_bold);
		$worksheet->write(0, 7, "SEKOLAH ID", $text_format_line_bold);
		$worksheet->write(0, 8, "KELAS ID", $text_format_line_bold);
		$worksheet->write(0, 9, "KELAS", $text_format_line_bold);
		$worksheet->write(0, 10, "SPP", $text_format_line_bold);
	}
	// elseif($i==1)
	// {

	// 		$worksheet->set_column(0, 0, 12.00);
	// 		$worksheet->set_column(1, 1, 50.00); 
			
	// 		$worksheet->set_column(3, 3, 18.86);
	// 		$worksheet->set_column(4, 4, 50.00);
			
	// 		$worksheet->set_column(6, 6, 18.43);
	// 		$worksheet->set_column(7, 7, 50.00);
			
	// 		$worksheet->write(1, 0, "SEKOLAH ID", $text_format_line_bold);
	// 		$worksheet->write(1, 1, "NAMA SEKOLAH", $text_format_line_bold);			
		
	// 		$row = 3;			
	// 		while ($departemen->nextRow()) {
	// 			$worksheet->write_string($row, 0, $departemen->getField("DEPARTEMEN_ID"),$text_format_line_left);	
	// 			$worksheet->write($row, 1, $departemen->getField("NAMA"),$text_format_line_left);	
	// 			$row++;
	// 		}
	// }
	elseif($i==1)
	{

			$worksheet->set_column(0, 0, 12.00);
			$worksheet->set_column(1, 1, 10.00); 
			$worksheet->set_column(1, 2, 40.00); 
			
			$worksheet->set_column(3, 3, 18.86);
			$worksheet->set_column(4, 4, 50.00);
			
			$worksheet->set_column(6, 6, 18.43);
			$worksheet->set_column(7, 7, 50.00);
			
			$worksheet->write(1, 0, "SEKOLAH ID", $text_format_merge_line_bold);
			$worksheet->write(1, 1, "KELAS ID", $text_format_merge_line_bold);
			$worksheet->write(1, 2, "KELAS", $text_format_merge_line_bold);
			// $worksheet->write(1, 2, "JURUSAN", $text_format_merge_line_bold);
			$worksheet->write(1, 3, "NAMA SEKOLAH", $text_format_merge_line_bold);		
		
			$row = 3;			
			while ($departemen_kelas->nextRow()) {
				$worksheet->write_string($row, 0, $departemen_kelas->getField("DEPARTEMEN_ID"),$text_format_line_left);	
				$worksheet->write_string($row, 1, $departemen_kelas->getField("DEPARTEMEN_KELAS_ID"),$text_format_line_left);	
				$worksheet->write($row, 2, $departemen_kelas->getField("NAMA"),$text_format_line_left);	
				// $worksheet->write($row, 2, $departemen_kelas->getField("JURUSAN"),$text_format_line_left);	
				$worksheet->write($row, 3, $departemen_kelas->getField("KETERANGAN"),$text_format_line_left);	
				$row++;
			}
	}
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"import_data_siswa_template.xls\"");
header("Content-Disposition: inline; filename=\"import_data_siswa_template.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>