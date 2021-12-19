<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");

require_once "excel/class.writeexcel_workbookbig.inc.php";
require_once "excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "cetak_rekapitulasi_absensi.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();
$worksheet->hide_gridlines();

$absensi_rekap = new AbsensiRekap();

$reqBulan = httpFilterGet("reqBulan");
$reqTahun = httpFilterGet("reqTahun");

$reqDepartemen = httpFilterGet("reqDepartemen");
$reqStatusPegawai= httpFilterGet("reqStatusPegawai");

$periode = $reqBulan.$reqTahun;
if(substr($reqDepartemen, 0, 3) == "CAB")
	$statement = " AND EXISTS(SELECT 1 FROM IMASYS_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
	$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

/*if($reqStatusPegawai == '')
	$statement .= 'AND A.STATUS_PEGAWAI_ID = 1';
else
	$statement .= 'AND A.STATUS_PEGAWAI_ID = '.$reqStatusPegawai;*/

$absensi_rekap->selectByParamsRekapAbsensiCetak(array(), -1, -1, $statement, $periode, " ORDER BY NAMA ASC");
//echo $absensi_rekap->query;

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 30.00);

for ($j=2; $j<=63; $j++){
	$worksheet->set_column($j, $j, 4.29);
}

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
$text_format->set_bold(1);
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

$text_format_line_red =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow', fg_color => 0x0A));
$text_format_line_red->set_color('black');
$text_format_line_red->set_size(8);
$text_format_line_red->set_border_color('black');
$text_format_line_red->set_left(1);
$text_format_line_red->set_right(1);
$text_format_line_red->set_top(1);
$text_format_line_red->set_bottom(1);

$text_format_line_yellow =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow', fg_color => 0x0D));
$text_format_line_yellow->set_color('black');
$text_format_line_yellow->set_size(8);
$text_format_line_yellow->set_border_color('black');
$text_format_line_yellow->set_left(1);
$text_format_line_yellow->set_right(1);
$text_format_line_yellow->set_top(1);
$text_format_line_yellow->set_bottom(1);

$text_format_line_silver =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow', fg_color => 0x1F));
$text_format_line_silver->set_color('black');
$text_format_line_silver->set_size(8);
$text_format_line_silver->set_border_color('black');
$text_format_line_silver->set_left(1);
$text_format_line_silver->set_right(1);
$text_format_line_silver->set_top(1);
$text_format_line_silver->set_bottom(1);

$text_format_line_blue =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow', fg_color => 0x28));
$text_format_line_blue->set_color('black');
$text_format_line_blue->set_size(8);
$text_format_line_blue->set_border_color('black');
$text_format_line_blue->set_left(1);
$text_format_line_blue->set_right(1);
$text_format_line_blue->set_top(1);
$text_format_line_blue->set_bottom(1);


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

$text_format_line_bold_no_bottom =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow'));
$text_format_line_bold_no_bottom->set_color('black');
$text_format_line_bold_no_bottom->set_size(8);
$text_format_line_bold_no_bottom->set_border_color('black');
$text_format_line_bold_no_bottom->set_bold(1);
$text_format_line_bold_no_bottom->set_left(1);
$text_format_line_bold_no_bottom->set_right(1);
$text_format_line_bold_no_bottom->set_top(1);
$text_format_line_bold_no_bottom->set_bottom(0);

$text_format_line_bold_no_top =& $workbook->addformat(array(align => 'center', size => 8, font => 'Arial Narrow'));
$text_format_line_bold_no_top->set_color('black');
$text_format_line_bold_no_top->set_size(8);
$text_format_line_bold_no_top->set_border_color('black');
$text_format_line_bold_no_top->set_bold(1);
$text_format_line_bold_no_top->set_left(1);
$text_format_line_bold_no_top->set_right(1);
$text_format_line_bold_no_top->set_top(0);
$text_format_line_bold_no_top->set_bottom(1);

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
$worksheet->write		(1, 1, "REKAP KEHADIRAN BULAN ".strtoupper(getNamePeriode($periode)), $text_format);

$jumHari = cal_days_in_month(CAL_GREGORIAN, date($reqBulan), date('Y'));

$worksheet->write(3, 1, "NAMA", $text_format_line_bold_no_bottom);
$worksheet->write(4, 1, "", $text_format_line_bold_no_top);

for ($i=2; $i<=($jumHari*2)+1; $i++)
{

	if($i % 2 == 0)
	{
		$worksheet->write		(3, $i, $i/2, $text_format_merge_line_bold);
		$worksheet->write(4, $i, "IN", $text_format_line_bold);
	}
	else
	{
		//1 3 5 7 9 11 13 15 17 19 21 23 25 27 29 31
		//$worksheet->write		(3, $i, $i."dsd", $text_format_merge_line_bold);
		$worksheet->write_blank	(3, $i, $text_format_merge_line_bold);
		$worksheet->write(4, $i, "OUT", $text_format_line_bold);
	}
}

$row = 5;
while($absensi_rekap->nextRow())
{
	$worksheet->write($row, 1, $absensi_rekap->getField('NAMA'), $text_format_line_left);
	for ($k=2; $k<=($jumHari*2)+1; $k++)
	{
		if($k % 2 == 0)
		{	
			$hari = $k/2;
			$date = $reqTahun.'/'.$reqBulan.'/'.$hari; 
			$day = date('l', strtotime($date));
			if($day == "Saturday" || $day == "Sunday")
				$style = $text_format_line_red;
			else
			{
				if($absensi_rekap->getField('IN_'.($k/2)) == "")
					if($absensi_rekap->getField('OUT_'.($k/2)) == "")
						$style = $text_format_line_silver;
					else					
						$style = $text_format_line_blue;
				else
				{
					if(substr($absensi_rekap->getField('IN_'.($k/2)), 5, 1) == "Y")
						$style = $text_format_line_yellow;
					else				
						$style = $text_format_line;
				}
			}
			$worksheet->write($row, $k, substr($absensi_rekap->getField('IN_'.($k/2)), 0, 5), $style);
		}
		else
		{		
			$hari = (($k-1)/2);
			$date = $reqTahun.'/'.$reqBulan.'/'.$hari; 
			$day = date('l', strtotime($date));
			if($day == "Saturday" || $day == "Sunday")
				$style = $text_format_line_red;
			else
			{
				if($absensi_rekap->getField('OUT_'.(($k-1)/2)) == "")
					if($absensi_rekap->getField('IN_'.(($k-1)/2)) == "")
						$style = $text_format_line_silver;
					else					
						$style = $text_format_line_blue;
				else
				{
					if(substr($absensi_rekap->getField('OUT_'.(($k-1)/2)), 5, 1) == "Y")
						$style = $text_format_line_yellow;
					else				
						$style = $text_format_line;
				}
			}
			$worksheet->write($row, $k, substr($absensi_rekap->getField('OUT_'.(($k-1)/2)), 0, 5), $style);
		}
	}
	$row++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"cetak_rekapitulasi_absensi.xls\"");
header("Content-Disposition: inline; filename=\"cetak_rekapitulasi_absensi.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>