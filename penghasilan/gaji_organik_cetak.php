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

$fname = tempnam("/tmp", "cetak_gaji_perbantuan.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$gaji_awal_bulan = new GajiAwalBulan();
$gaji = new Gaji();

$reqPeriode = httpFilterGet("reqPeriode");
$reqDepartemen = httpFilterGet("reqDepartemen");
$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
if($reqJenisPegawaiId == '') $reqJenisPegawaiId = 1;

$json_item_gaji = json_decode($gaji->getItemGajiDiberikan($reqJenisPegawaiId, "AWAL_BULAN"));
$json_item_sumbangan = json_decode($gaji->getItemSumbanganDiberikan($reqJenisPegawaiId));
$json_item_potongan = json_decode($gaji->getItemPotonganDiberikan($reqJenisPegawaiId));
$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan($reqJenisPegawaiId));
$json_item_potongan_lain = json_decode($gaji->getItemPotonganLain());

$aColumns[] = "NRP";
$aColumns[] = "NAMA";
$aColumns[] = "KELAS";
for($i=0;$i<count($json_item_gaji->{"ITEM_GAJI"});$i++)
{
	$aColumns[] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$i};		
}
for($i=0;$i<count($json_item_sumbangan->{"ITEM_SUMBANGAN"});$i++)
{
	$aColumns[] = "SUMBANGAN_".$json_item_sumbangan->{"ITEM_SUMBANGAN"}{$i};		
}
for($i=0;$i<count($json_item_potongan->{"ITEM_POTONGAN"});$i++)
{
	$aColumns[] = "POTONGAN_".$json_item_potongan->{"ITEM_POTONGAN"}{$i};		
}
for($i=0;$i<count($json_item_tanggungan->{"ITEM_TANGGUNGAN"});$i++)
{
	$aColumns[] = "TANGGUNGAN_".$json_item_tanggungan->{"ITEM_TANGGUNGAN"}{$i};		
}

$aColumns[] = "LAIN";
$aColumns[] = "TOTAL";


if(substr($reqDepartemen, 0, 3) == "CAB")
	$statement = " AND EXISTS(SELECT 1 FROM IMASYS_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
	$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

$gaji_awal_bulan->selectByParamsGaji(array(), -1, -1, $statement, " ORDER BY A.DEPARTEMEN_ID, B.NO_URUT ASC", $reqPeriode, $reqJenisPegawaiId);

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 8.14);
$worksheet->set_column(2, 2, 26.57);

for ($j=3; $j<=26; $j++)
{
	$worksheet->set_column($j, $j, 15.14);
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

if($reqJenisPegawaiId == "1,2")
	$caption = "PERBANTUAN, ORGANIK";
elseif($reqJenisPegawaiId == "1")
	$caption = "ORGANIK";
elseif($reqJenisPegawaiId == "2")
	$caption = "PERBANTUAN";
elseif($reqJenisPegawaiId == "3")
	$caption = "PKWT";
elseif($reqJenisPegawaiId == "5")
	$caption = "CAPEG";
elseif($reqJenisPegawaiId == "6")
	$caption = "DIREKSI";
elseif($reqJenisPegawaiId == "7")
	$caption = "KOMISARIS";
else
	$caption = "DIREKSI, KOMISARIS";

$worksheet->write		(1, 1, "REKAP GAJI ".$caption." BULAN  ".strtoupper(getNamePeriode($reqPeriode)), $text_format);

$worksheet->write(3, 1, "NRP", $text_format_line_bold);
$worksheet->write(3, 2, "Nama", $text_format_line_bold);
$worksheet->write(3, 3, "Kelas", $text_format_line_bold);

for($i=0;$i<count($json_item_gaji->{'NAMA'});$i++)
{
	 $worksheet->write(3, $i+4, $json_item_gaji->{'NAMA'}{$i}, $text_format_line_bold);
}
$row_gaji = ($i+4)-1;

for($i=0;$i<count($json_item_sumbangan->{'NAMA'});$i++)
{
	 $worksheet->write(3, $row_gaji+1, $json_item_sumbangan->{'NAMA'}{$i}, $text_format_line_bold);
	 $row_gaji++;
}
$row_sumbangan = $row_gaji;

for($i=0;$i<count($json_item_potongan->{'NAMA'});$i++)
{
	 $worksheet->write(3, $row_sumbangan+1, $json_item_potongan->{'NAMA'}{$i}, $text_format_line_bold);
	 $row_sumbangan++;
}
$row_potongan = $row_sumbangan;

for($i=0;$i<count($json_item_tanggungan->{'NAMA'});$i++)
{
	 $worksheet->write(3, $row_potongan+1, $json_item_tanggungan->{'NAMA'}{$i}, $text_format_line_bold);
	 $row_potongan++;
}

$row_potongan_lain = $row_potongan;

$worksheet->write(3, $row_potongan_lain+1, "Potongan Lain", $text_format_line_bold);
// $worksheet->write(3, $row_potongan_lain+2, "Pembulatan", $text_format_line_bold);
$worksheet->write(3, $row_potongan_lain+3, "Jumlah Dibayar", $text_format_line_bold);

//-------------//
$row = 4;

$departemen_pegawai == "";

while($gaji_awal_bulan->nextRow())
{
	if($departemen_pegawai == $gaji_awal_bulan->getField("DEPARTEMEN"))
	{}
	else
	{
		$worksheet->write($row, 1, $gaji_awal_bulan->getField("DEPARTEMEN"), $text_format_merge_line_bold);
		$worksheet->write_blank($row, 2, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 3, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 4, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 5, $text_format_merge_line_bold);
		$worksheet->write_blank($row, 6, $text_format_merge_line_bold);	
		$worksheet->write_blank($row, 7, $text_format_merge_line_bold);	
		$worksheet->write_blank($row, 8, $text_format_merge_line_bold);		
		$row++;
	}
	
	$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
	$json_sumbangan = json_decode($gaji_awal_bulan->getField("SUMBANGAN_JSON"));
	$json_potongan = json_decode($gaji_awal_bulan->getField("POTONGAN_JSON"));
	$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
	$json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
	$total_gaji = 0;
	$total_sumbangan = 0;
	$total_potongan = 0;
	$total_tanggungan = 0;
	$total_potongan_lain = 0;	
	//echo var_dump($json_gaji);exit;
	for ( $i=0; $i<count($aColumns); $i++ )
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
				$hasil = $json_gaji->{$column_gaji}{0} + $gaji_awal_bulan->getField("LUMPSUM");
				$worksheet->write($row, $i+1, $hasil, $uang_line);	
				$total_gaji += $json_gaji->{$column_gaji}{0} + $gaji_awal_bulan->getField("LUMPSUM");
			}
		}
		elseif(substr($aColumns[$i],0,4) == "SUMB")
		{
			$column_sumbangan = str_replace("SUMBANGAN_", "", $aColumns[$i]);
			if($column_sumbangan == "TOTAL_SUMBANGAN")
			{
				$hasil = $total_sumbangan;				
				$worksheet->write($row, $i+1, $hasil, $uang_line);	
			}
			else
			{
				$hasil = $json_sumbangan->{$column_sumbangan}{0};
				$worksheet->write($row, $i+1, $hasil, $uang_line);	
				$total_sumbangan += $json_sumbangan->{$column_sumbangan}{0};
			}
		}
		elseif(substr($aColumns[$i],0,4) == "POTO")
		{
			$column_potongan = str_replace("POTONGAN_", "", $aColumns[$i]);
			if($column_potongan == "TOTAL_POTONGAN")
			{
				$hasil = $total_potongan;	
				$worksheet->write($row, $i+1, $hasil, $uang_line);				
			}
			else
			{
				$hasil = $json_potongan->{$column_potongan}{0};
				$worksheet->write($row, $i+1, $hasil, $uang_line);	
				$total_potongan += $json_potongan->{$column_potongan}{0};
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
		elseif($aColumns[$i] == "LAIN")		
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
			$total_sebelum = $total_gaji - ($total_potongan + $total_potongan_lain);
			$total_pembulatan = ($total_sebelum % 1000);
			if($total_pembulatan == 0)
				$total_pembulatan = 1000;
			
			$total_gaji = $total_sebelum + $gaji_awal_bulan->getField("PEMBULATAN");
			$hasil = $total_gaji;
			// $worksheet->write($row, $i+1, $gaji_awal_bulan->getField("PEMBULATAN"), $uang_line);	
			$worksheet->write($row, $i+2, $hasil, $uang_line);	
		}
		elseif($aColumns[$i] == "KELAS")			
		{
			$worksheet->write($row, $i+1, $gaji_awal_bulan->getField("KELAS"), $uang_line);
		}
		else
			$worksheet->write($row, $i+1, $gaji_awal_bulan->getField($aColumns[$i]), $text_format_line_left);			
	}
	
	$departemen_pegawai = $gaji_awal_bulan->getField("DEPARTEMEN");
	$row++;
	//$row++;	
	
}
$workbook->close();

header("Content-Type: application/x-msexcel; name=\"cetak_gaji_perbantuan.xls\"");
header("Content-Disposition: inline; filename=\"cetak_gaji_perbantuan.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>