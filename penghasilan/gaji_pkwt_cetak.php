<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
include_once("../WEB-INF/classes/base-gaji/Gaji.php");

require_once "../WEB-INF/lib/excel/class.writeexcel_workbookbig.inc.php";
require_once "../WEB-INF/lib/excel/class.writeexcel_worksheet.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "cetak_gaji_pkwt.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$gaji_awal_bulan = new GajiAwalBulan();
$gaji = new Gaji();

$reqPeriode = httpFilterGet("reqPeriode");
$reqDepartemen = httpFilterGet("reqDepartemen");

$json_item_gaji = json_decode($gaji->getItemGajiDiberikan(3, "AWAL_BULAN"));
$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan(3));
$json_item_potongan_lain = json_decode($gaji->getItemPotonganLain());

$aColumns[] = "NRP";
$aColumns[] = "NAMA";
for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
{
	$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
}
for($i=0;$i<count($json_item_tanggungan->{"ITEM_TANGGUNGAN"});$i++)
{
	$aColumns[] = "TANGGUNGAN_".$json_item_tanggungan->{"ITEM_TANGGUNGAN"}{$i};		
}
$aColumns[] = "POTONGAN_LAIN";
$aColumns[] = "TOTAL";


if(substr($reqDepartemen, 0, 3) == "CAB")
	$statement = " AND EXISTS(SELECT 1 FROM IMASYS_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
	$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

$gaji_awal_bulan->selectByParamsGaji(array(), -1, -1, $statement, " ORDER BY NRP ASC ", $reqPeriode, 3);

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 10.29);
$worksheet->set_column(2, 2, 27.00);

for ($j=3; $j<=26; $j++)
{
	$worksheet->set_column($j, $j, 17.57);
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

$text_format_line_left =& $workbook->addformat(array(align => 'left', size => 8, font => 'Arial Narrow'));
$text_format_line_left->set_color('black');
$text_format_line_left->set_size(8);
$text_format_line_left->set_border_color('black');
$text_format_line_left->set_left(1);
$text_format_line_left->set_right(1);
$text_format_line_left->set_top(1);
$text_format_line_left->set_bottom(1);

$text_format_line_right =& $workbook->addformat(array(align => 'right', size => 8, font => 'Arial Narrow'));
$text_format_line_right->set_color('black');
$text_format_line_right->set_size(8);
$text_format_line_right->set_border_color('black');
$text_format_line_right->set_left(1);
$text_format_line_right->set_right(1);
$text_format_line_right->set_top(1);
$text_format_line_right->set_bottom(1);

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
$worksheet->write		(1, 1, "REKAP GAJI PKWT BULAN  ".getNamePeriode($reqPeriode), $text_format);

$worksheet->write(3, 1, "NRP", $text_format_line_bold);
$worksheet->write(3, 2, "Nama", $text_format_line_bold);

for($i=0;$i<count($json_item_gaji->{'NAMA'});$i++)
{
	 $worksheet->write(3, $i+3, $json_item_gaji->{'NAMA'}{$i}, $text_format_line_bold);
}
$row_gaji = ($i+3)-1;

for($i=0;$i<count($json_item_tanggungan->{'NAMA'});$i++)
{
	 $worksheet->write(3, $row_gaji+1, $json_item_tanggungan->{'NAMA'}{$i}, $text_format_line_bold);
	 $row_gaji++;
}

$row_potongan_lain = $row_gaji;

$worksheet->write(3, $row_potongan_lain+1, "Potongan Lain", $text_format_line_bold);
$worksheet->write(3, $row_potongan_lain+2, "Gaji Potongan", $text_format_line_bold);

//-------------//
$row = 4;
while($gaji_awal_bulan->nextRow())
{
	$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
	$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
	$json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
	$total_gaji = 0;
	$total_tanggungan = 0;
	$total_potongan_lain = 0;
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{	
		if(substr($aColumns[$i],0,4) == "GAJI")
		{
			$column_gaji = str_replace("GAJI_", "", $aColumns[$i]);
			if($column_gaji == "TOTAL_GAJI")
			{
				$hasil = $total_gaji;
				$worksheet->write($row, $i+1, $hasil, $uang_line);					
			}
			else
			{
				$hasil = $json_gaji->{$column_gaji}{0};
				$worksheet->write($row, $i+1, $hasil, $uang_line);	
				$total_gaji += $json_gaji->{$column_gaji}{0};
			}
		}
		elseif(substr($aColumns[$i],0,4) == "TANG")
		{
			$column_tanggungan = str_replace("TANGGUNGAN_", "", $aColumns[$i]);
			if($column_tanggungan == "TOTAL_TANGGUNGAN")
			{
				$hasil = $total_tanggungan;
				$worksheet->write($row, $i+1, $hasil, $uang_line);					
			}
			else
			{
				$hasil = $json_tanggungan->{$column_tanggungan}{0};
				$worksheet->write($row, $i+1, $hasil, $uang_line);	
				$total_tanggungan += $json_tanggungan->{$column_tanggungan}{0};
			}
		}
		elseif($aColumns[$i] == "POTONGAN_LAIN")		
		{
			for($j=0;$j<count($json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"});$j++)
			{
				$total_potongan_lain += $json_potongan_lain->{$json_item_potongan_lain->{"ITEM_POTONGAN_LAIN"}{$j}}{0};	
			}
			$hasil = $total_potongan_lain;
			$worksheet->write($row, $i+1, $hasil, $uang_line);		
		}
		elseif($aColumns[$i] == "TOTAL")			
		{
			$hasil = $total_gaji - $total_potongan_lain;
			$worksheet->write($row, $i+1, $hasil, $uang_line);		
		}
		else
			$worksheet->write($row, $i+1, $gaji_awal_bulan->getField($aColumns[$i]), $text_format_line_left);		
	}
	$row++;	
}
$workbook->close();

header("Content-Type: application/x-msexcel; name=\"cetak_gaji_pkwt.xls\"");
header("Content-Disposition: inline; filename=\"cetak_gaji_pkwt.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>