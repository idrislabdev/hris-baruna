<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-simpeg/Universitas.php");
include_once("../WEB-INF/classes/base-simpeg/Pendidikan.php");
include_once("../WEB-INF/classes/base-simpeg/PendidikanBiaya.php");

require_once "excel/class.writeexcel_workbookbig.inc.php";
require_once "excel/class.writeexcel_worksheet.inc.php";

$universitas = new Universitas();
$pendidikan = new Pendidikan();
$pendidikan_biaya = new PendidikanBiaya();

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");
//$reqLokasi = httpFilterGet("reqLokasi");

$fname = tempnam("/tmp", "import_pendidikan_template.xls");
$workbook = & new writeexcel_workbookbig($fname);

$workbook = &new writeexcel_workbook($fname);

$arrayNama[0]="IMPORT DATA";
$arrayNama[1]="KETERANGAN";

$pendidikan->selectByParams();
$pendidikan_biaya->selectByParams();
$universitas->selectByParams();

for ($i=0; $i < 2; $i++)
{

	$worksheet = &$workbook->addworksheet($arrayNama[$i]);
	
	$text_format =& $workbook->addformat(array( size => 10, font => 'Arial Narrow'));
	$text_format->set_merge(1);
	$text_format->set_bold(1);
	
	$text_format_line_bold_top =& $workbook->addformat(array(align => 'center', size => 9, font => 'Arial Narrow'));
	$text_format_line_bold_top->set_color('black');
	$text_format_line_bold_top->set_size(9);
	$text_format_line_bold_top->set_border_color('black');
	$text_format_line_bold_top->set_bold(1);
	$text_format_line_bold_top->set_left(1);
	$text_format_line_bold_top->set_right(1);
	$text_format_line_bold_top->set_top(1);
	
	$text_format_line_bold_bottom =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial'));
	$text_format_line_bold_bottom->set_color('black');
	$text_format_line_bold_bottom->set_size(8);
	$text_format_line_bold_bottom->set_border_color('black');
	$text_format_line_bold_bottom->set_bold(1);
	$text_format_line_bold_bottom->set_left(1);
	$text_format_line_bold_bottom->set_right(1);
	$text_format_line_bold_bottom->set_bottom(1);
	
	$text_format_merge_line_bold_bottom =& $workbook->addformat(array(size => 9, font => 'Arial Narrow'));
	$text_format_merge_line_bold_bottom->set_color('black');
	$text_format_merge_line_bold_bottom->set_size(9);
	$text_format_merge_line_bold_bottom->set_border_color('black');
	$text_format_merge_line_bold_bottom->set_merge(1);
	$text_format_merge_line_bold_bottom->set_bold(1);
	$text_format_merge_line_bold_bottom->set_left(1);
	$text_format_merge_line_bold_bottom->set_right(1);
	$text_format_merge_line_bold_bottom->set_top(1);
	$text_format_merge_line_bold_bottom->set_bottom(1);
	
	//$text_format_merge_line_bold =& $workbook->addformat(array(align => 'left', size => 8, font => 'Arial Narrow', fg_color => 0x16));
	$text_format_merge_line_bold =& $workbook->addformat(array(align => 'left', size => 8, font => 'Arial Narrow'));
	$text_format_merge_line_bold->set_color('black');
	$text_format_merge_line_bold->set_size(8);
	$text_format_merge_line_bold->set_border_color('black');
	$text_format_merge_line_bold->set_merge(1);
	$text_format_merge_line_bold->set_bold(1);
	$text_format_merge_line_bold->set_left(1);
	$text_format_merge_line_bold->set_right(1);
	$text_format_merge_line_bold->set_top(1);
	$text_format_merge_line_bold->set_bottom(1);
	
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
	
	$text_format_merge_none =& $workbook->addformat(array(size => 8, font => 'Arial Narrow'));
	$text_format_merge_none->set_color('black');
	$text_format_merge_none->set_size(8);
	$text_format_merge_none->set_border_color('black');
	$text_format_merge_none->set_merge(1);
	$text_format_merge_none->set_bold(1);
	
	$text_format =& $workbook->addformat(array(align => 'left', size => 8, font => 'Arial Narrow'));
	$text_format->set_color('black');
	$text_format->set_size(8);
	$text_format->set_border_color('black');
	
	$text_format_center =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow'));
	$text_format_center->set_color('black');
	$text_format_center->set_size(8);
	$text_format_center->set_border_color('black');
	$text_format_center->set_bold(1);
	
	$text_format_center_underline =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow'));
	$text_format_center_underline->set_color('black');
	$text_format_center_underline->set_size(8);
	$text_format_center_underline->set_border_color('black');
	$text_format_center_underline->set_bold(1);
	$text_format_center_underline->set_underline(1);
	
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
	$text_format_line_left->set_bold(1);
	
	$text_format_line_center =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow'));
	$text_format_line_center->set_color('black');
	$text_format_line_center->set_size(8);
	$text_format_line_center->set_border_color('black');
	$text_format_line_center->set_left(1);
	$text_format_line_center->set_right(1);
	$text_format_line_center->set_top(1);
	$text_format_line_center->set_bottom(1);
	$text_format_line_center->set_bold(1);
	
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

	if ($i==0)
	{
		$worksheet->set_column(0, 0, 14.00);
		$worksheet->set_column(1, 1, 14.00);
		$worksheet->set_column(2, 2, 17.00);
		$worksheet->set_column(3, 3, 14.00);
		$worksheet->set_column(4, 4, 14.00);
		$worksheet->set_column(5, 5, 14.00);
		$worksheet->set_column(6, 6, 14.00);
		$worksheet->set_column(7, 7, 14.00);
			
			
			$worksheet->write(0, 0, "NRP", $text_format_line_bold);
			$worksheet->write(0, 1, "PENDIDIKAN_ID", $text_format_line_bold);
			$worksheet->write(0, 2, "PENDIDIKAN_BIAYA_ID", $text_format_line_bold);
			$worksheet->write(0, 3, "NAMA_SEKOLAH", $text_format_line_bold);
			$worksheet->write(0, 4, "KOTA", $text_format_line_bold);
			$worksheet->write(0, 5, "UNIVESITAS_ID", $text_format_line_bold);
			$worksheet->write(0, 6, "LULUS", $text_format_line_bold);
			$worksheet->write(0, 7, "NO_IJAZAH", $text_format_line_bold);
			
			/*$aColumns = array('PEGAWAI_ID', 'NAMA');
			$aColumnsAlias = array('PEGAWAI_ID', 'NAMA');*/
			
			$row = 2;
				$worksheet->write($row, 0, "", $text_format);
				$worksheet->write($row, 1, "", $text_format);
				$worksheet->write($row, 2, "", $text_format);
				$worksheet->write($row, 3, "", $text_format);
				$worksheet->write($row, 4, "", $text_format);
				$worksheet->write($row, 5, "", $text_format);
				$worksheet->write($row, 6, "", $text_format);
				$worksheet->write($row, 7, "", $text_format);
	}
	elseif($i==1)
	{
			$worksheet->set_column(0, 0, 12.00);
			$worksheet->set_column(1, 1, 50.00); 
			
			$worksheet->set_column(3, 3, 18.86);
			$worksheet->set_column(4, 4, 50.00);
			
			$worksheet->set_column(6, 6, 18.43);
			$worksheet->set_column(7, 7, 50.00);
			
			$worksheet->write(1, 0, "PENDIDIKAN", $text_format_merge_line_bold);
			$worksheet->write_blank(1, 1, $text_format_merge_line_bold);
			
			$worksheet->write(2, 0, "PENDIDIKAN_ID", $text_format_line_bold_top);
			$worksheet->write(2, 1, "NAMA", $text_format_line_bold_top);
		
			$row = 3;			
			while($pendidikan->nextRow()){				
				$worksheet->write($row, 0, $pendidikan->getField("PENDIDIKAN_ID"),$text_format_line_left);	
				$worksheet->write($row, 1, $pendidikan->getField("NAMA"),$text_format_line_left);					
				$row++;
			}
			
			$worksheet->write(1, 3, "UNIVERSITAS", $text_format_merge_line_bold);
			$worksheet->write_blank(1, 4, $text_format_merge_line_bold);
			
			$worksheet->write(2, 3, "UNIVESITAS_ID", $text_format_line_bold_top);
			$worksheet->write(2, 4, "NAMA", $text_format_line_bold_top);
			$row = 3;
			while($universitas->nextRow()){				
				$worksheet->write($row, 3, $universitas->getField("UNIVERSITAS_ID"),$text_format_line_left);	
				$worksheet->write($row, 4, $universitas->getField("NAMA"),$text_format_line_left);					
				$row++;
			}
		
			$worksheet->write(1, 6, "PENDIDIKAN BIAYA", $text_format_merge_line_bold);
			$worksheet->write_blank(1, 7, $text_format_merge_line_bold);
			
			$worksheet->write(2, 6, "PENDIDIKAN_BIAYA_ID", $text_format_line_bold_top);
			$worksheet->write(2, 7, "NAMA", $text_format_line_bold_top);
			$row = 3;
			while($pendidikan_biaya->nextRow()){				
				$worksheet->write($row, 6, $pendidikan_biaya->getField("PENDIDIKAN_BIAYA_ID"),$text_format_line_left);	
				$worksheet->write($row, 7, $pendidikan_biaya->getField("NAMA"),$text_format_line_left);					
				$row++;
			}
		
			
			
			/*$worksheet->write(0, 1, "TANGGAL_AWAL", $text_format_line_bold);
			$worksheet->write(0, 2, "TANGGAL_AKHIR", $text_format_line_bold);
			
			$worksheet->write(0, 0, "NAMA", $text_format_line_bold);
			$worksheet->write(0, 1, "TANGGAL_AWAL", $text_format_line_bold);
			$worksheet->write(0, 2, "TANGGAL_AKHIR", $text_format_line_bold);
			
			$aColumns = array('PEGAWAI_ID', 'NAMA');
			$aColumnsAlias = array('PEGAWAI_ID', 'NAMA');
			
			$row = 2;
				$worksheet->write($row, 0, "", $text_format);
				$worksheet->write($row, 1, "", $text_format);
				$worksheet->write($row, 2, "", $text_format);*/
	}
	//$hari=getDay($reqTanggalAwal);
	
	//$worksheet->write($row, 20, $hari, $text_format);
	//$row++;
	//$reqTanggalAwal = date ("Y-m-d", strtotime("+1 day", strtotime($reqTanggalAwal)));
//}
}
$workbook->close();

header("Content-Type: application/x-msexcel; name=\"import_pendidikan_template.xls\"");
header("Content-Disposition: inline; filename=\"import_pendidikan_template.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>