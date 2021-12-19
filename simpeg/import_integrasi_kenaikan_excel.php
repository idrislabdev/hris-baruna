<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");

// include_once("../WEB-INF/classes/base-gaji/GajiKondisiPegawai.php");
// include_once("../WEB-INF/classes/base-gaji/GajiKondisi.php");

include_once("../WEB-INF/classes/base-simpeg/DepartemenKelasData.php");
include_once("../WEB-INF/classes/base-simpeg/TahunAjaran.php");

require_once "../keuangan/excel/class.writeexcel_workbookbig.inc.php";
require_once "../keuangan/excel/class.writeexcel_worksheet.inc.php";

// $gaji_kondisi_pegawai = new GajiKondisiPegawai();
// $gaji_kondisi = new GajiKondisi();

$departemen_kelas_data = new DepartemenKelasData();
$tahun_ajaran = new TahunAjaran();

$tahun_ajaran->selectByParams();

// echo "afafdada";
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
$arrayNama[0]="IMPORT DATA SISWA";
$arrayNama[1]="KETERANGAN";
// $gaji_kondisi->selectByParamsKondisi();
$departemen_kelas_data->selectByParamsKondisi();

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
		$worksheet->set_column(3, 3, 15.00);
		//$worksheet->write(0, 0, "PEGAWAI_ID", $text_format_line_bold);
		//$worksheet->write(0, 1, "PEGAWAI_PEND_PERJENJANGAN_ID", $text_format_line_bold);
		$worksheet->write(0, 0, "NIS", $text_format_line_bold);
		$worksheet->write(0, 1, "DEPARTEMEN ID", $text_format_line_bold);
		$worksheet->write(0, 2, "DEPARTEMEN_KELAS_ID", $text_format_line_bold);
		$worksheet->write(0, 3, "TAHUN", $text_format_line_bold);


		$row = 1;
		while ($tahun_ajaran->nextRow()) 
		// {
		// 	$worksheet->write_string($row, 0, "", $text_format_line_left);
		// 	$worksheet->write_string($row, 1, "", $text_format_line_left);
		// 	$worksheet->write_string($row, 2, "", $text_format_line_left);
		// 	$worksheet->write_string($row, 3, "", $text_format_line_left);
			$worksheet->write($row, 3, $tahun_ajaran->getField("PERIODE"),$text_format_line_left);
		

		// 	$row++;
		// }
	}
	elseif($i==1)
	{

			$worksheet->set_column(0, 0, 15.00);
			$worksheet->set_column(1, 1, 25.00); 
			$worksheet->set_column(2, 2, 40.00); 
			
			$worksheet->set_column(3, 3, 20.86);
			$worksheet->set_column(4, 4, 10.00);
			
			$worksheet->set_column(6, 6, 18.43);
			$worksheet->set_column(7, 7, 50.00);
			
			$worksheet->write(1, 0, "INTEGRASI KENAIKAN", $text_format_merge_line_bold);
			$worksheet->write_blank(1, 1, $text_format_merge_line_bold);
			$worksheet->write_blank(1, 2, $text_format_merge_line_bold);
			$worksheet->write_blank(1, 3, $text_format_merge_line_bold);
			$worksheet->write_blank(1, 4, $text_format_merge_line_bold);
			
			$worksheet->write(2, 0, "DEPARTEMEN ID", $text_format_line_bold_top);
			$worksheet->write(2, 1, "SEKOLAH", $text_format_line_bold_top);
			$worksheet->write(2, 2, "DEPARTEMEN KELAS ID", $text_format_line_bold_top);
			$worksheet->write(2, 3, "KELAS", $text_format_line_bold_top);
			$worksheet->write(2, 4, "TAHUN", $text_format_line_bold_top);
			
		
// echo $departemen_kelas_data->query;exit();
			$row = 3;			
			while ($departemen_kelas_data->nextRow()) {
				$worksheet->write($row, 0, $departemen_kelas_data->getField("DEPARTEMEN_ID"),$text_format_line_left);	
				$worksheet->write($row, 1, $departemen_kelas_data->getField("SEKOLAH"),$text_format_line_left);	
				$worksheet->write($row, 2, $departemen_kelas_data->getField("DEPARTEMEN_KELAS_ID"),$text_format_line_left);	
				$worksheet->write($row, 3, $departemen_kelas_data->getField("KELAS"),$text_format_line_left);	
				$worksheet->write(3, 4, "1819",$text_format_line_left);	
				$worksheet->write($row, 4, "",$text_format_line_left);	
				// $worksheet->write_string($row, 0, $gaji_kondisi->getField("GAJI_KONDISI_ID"),$text_format_line_left);	
				// $worksheet->write($row, 1, $gaji_kondisi->getField("NAMA"),$text_format_line_left);	
				$row++;
			}
	}
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"import_data_kenaikan_kelas_template.xls\"");
header("Content-Disposition: inline; filename=\"import_data_kenaikan_kelas_template.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>