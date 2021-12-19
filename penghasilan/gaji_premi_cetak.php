<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-operasional/KapalKru.php");
include_once("../WEB-INF/classes/base-operasional/Kapal.php");

require_once "../WEB-INF/lib/excel/class.writeexcel_workbookbig.inc.php";
require_once "../WEB-INF/lib/excel/class.writeexcel_worksheet.inc.php";

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "gaji_premi_excel.xls");
$workbook = & new writeexcel_workbookbig($fname);
//$worksheet = &$workbook->addworksheet();

$workbook = &new writeexcel_workbook($fname);

//$kapal_kru = new KapalKru();
$kapal = new Kapal();

$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");


$kapal->selectByParams();

$z=1;
$sheetname="";
while($kapal->nextRow())
{
$sheetname = $kapal->getField("NAMA");
	if (strlen($kapal->getField("NAMA")) > 30) $sheetname = substr($sheetname, 0, 30);
$worksheet =& $workbook->addworksheet($sheetname);
//$worksheet->cleanup($kapal->getField("NAMA"));

$kapal_kru = new KapalKru();

$jumlah_data= $kapal_kru->getCountByParamsKapalPremi($z, $reqPeriode);

$kapal_kru->selectByParamsKapalPremi($z, $reqPeriode);
//$kapal_kru->selectByParamsKapalPremi($kapal->getField("KAPAL_ID"), $reqPeriode);
$i=0;
while($kapal_kru->nextRow())
{
	$arrKapalKru[$i]["PREMI_JSON"] 			= $kapal_kru->getField("PREMI_JSON");
	$arrKapalKru[$i]["NAMA_KAPAL"] 			= $kapal_kru->getField("NAMA_KAPAL");
	$arrKapalKru[$i]["AWAK_KAPAL"] 			= $kapal_kru->getField("AWAK_KAPAL");
	$arrKapalKru[$i]["NRP"] 				= $kapal_kru->getField("NRP");
	$arrKapalKru[$i]["NPWP"] 				= $kapal_kru->getField("NPWP");
	$arrKapalKru[$i]["KELAS"] 				= $kapal_kru->getField("KELAS");
	$arrKapalKru[$i]["JABATAN"] 			= $kapal_kru->getField("JABATAN");
	$arrKapalKru[$i]["REALISASI_PRODUKSI"] 	= $kapal_kru->getField("REALISASI_PRODUKSI");
	$arrKapalKru[$i]["INTERVAL_PRODUKSI"] 	= $kapal_kru->getField("INTERVAL_PRODUKSI");
	$arrKapalKru[$i]["TARIF_NORMAL"] 		= $kapal_kru->getField("TARIF_NORMAL");
	$arrKapalKru[$i]["FAKTOR_KONVERSI"] 	= $kapal_kru->getField("FAKTOR_KONVERSI");
	$arrKapalKru[$i]["PRODUKSI_MAKSIMAL"] 	= $kapal_kru->getField("PRODUKSI_MAKSIMAL");
	$arrKapalKru[$i]["PRODUKSI_NORMAL"] 	= $kapal_kru->getField("PRODUKSI_NORMAL");
	$arrKapalKru[$i]["TARIF_MAKSIMAL"] 		= $kapal_kru->getField("TARIF_MAKSIMAL");
	$arrKapalKru[$i]["MASA_KERJA"] 			= $kapal_kru->getField("MASA_KERJA");
	$arrKapalKru[$i]["MASUK_KERJA"] 		= $kapal_kru->getField("MASUK_KERJA");
	$arrKapalKru[$i]["PPH"] 				= $kapal_kru->getField("PPH");
	$i++;	
}

$worksheet->set_column(0, 0, 4.43);
$worksheet->set_column(1, 1, 25.00);
$worksheet->set_column(2, 2, 8.43);
$worksheet->set_column(3, 3, 14.14);
$worksheet->set_column(4, 4, 5.00);
$worksheet->set_column(5, 5, 8.43);
$worksheet->set_column(6, 6, 8.43);
$worksheet->set_column(7, 7, 4.00);
$worksheet->set_column(8, 8, 8.43);
$worksheet->set_column(9, 9, 8.43);
$worksheet->set_column(10, 10, 9.29);
$worksheet->set_column(11, 11, 8.43);
$worksheet->set_column(12, 12, 11.29);
$worksheet->set_column(13, 13, 9.86);
$worksheet->set_column(14, 14, 9.86);
$worksheet->set_column(15, 15, 5.00);
$worksheet->set_column(16, 16, 5.00);
$worksheet->set_column(17, 17, 8.43);
$worksheet->set_column(18, 18, 4.00);


$text_format =& $workbook->addformat(array( size => 8, font => 'Arial Narrow'));
$text_format->set_color('black');
$text_format->set_size(8);
$text_format->set_border_color('black');

$text_format_bold =& $workbook->addformat(array( size => 10, font => 'Arial Narrow'));
$text_format_bold->set_color('black');
$text_format_bold->set_size(10);
$text_format_bold->set_bold(1);

$text_format_left =& $workbook->addformat(array( size => 8, font => 'Arial Narrow', align => 'left'));
$text_format_left->set_color('black');
$text_format_left->set_size(8);
$text_format_left->set_border_color('black');
$text_format_left->set_left(1);
$text_format_left->set_right(1);
$text_format_left->set_top(1);
$text_format_left->set_bottom(1);

$text_format_center =& $workbook->addformat(array( size => 9, font => 'Arial Narrow', align => 'center'));
$text_format_center->set_color('black');
$text_format_center->set_size(9);
$text_format_center->set_border_color('black');
$text_format_center->set_bold(1);
$text_format_center->set_left(1);
$text_format_center->set_right(1);
$text_format_center->set_top(1);
$text_format_center->set_bottom(1);


$text_format_center_8 =& $workbook->addformat(array( size => 8, font => 'Arial Narrow', align => 'center'));
$text_format_center_8->set_color('black');
$text_format_center_8->set_size(8);
$text_format_center_8->set_border_color('black');
$text_format_center_8->set_left(1);
$text_format_center_8->set_right(1);
$text_format_center_8->set_top(1);
$text_format_center_8->set_bottom(1);

$text_format_center_color_8 =& $workbook->addformat(array( size => 8, font => 'Arial Narrow', align => 'center', fg_color => 0x16));
$text_format_center_color_8->set_color('black');
$text_format_center_color_8->set_size(8);
$text_format_center_color_8->set_border_color('black');
$text_format_center_color_8->set_left(1);
$text_format_center_color_8->set_right(1);
$text_format_center_color_8->set_top(1);
$text_format_center_color_8->set_bottom(1);

$text_format_merge =& $workbook->addformat(array( size => 9, font => 'Arial Narrow', align => 'center'));
$text_format_merge->set_color('black');
$text_format_merge->set_size(9);
$text_format_merge->set_bold(1);
$text_format_merge->set_border_color('black');
$text_format_merge->set_merge();
$text_format_merge->set_left(1);
$text_format_merge->set_right(1);
$text_format_merge->set_top(1);
$text_format_merge->set_bottom(1);

$text_format_merge_no_bold =& $workbook->addformat(array( size => 8, font => 'Arial Narrow', align => 'center'));
$text_format_merge_no_bold->set_color('black');
$text_format_merge_no_bold->set_size(8);
$text_format_merge_no_bold->set_border_color('black');
$text_format_merge_no_bold->set_merge();
$text_format_merge_no_bold->set_left(1);
$text_format_merge_no_bold->set_right(1);
$text_format_merge_no_bold->set_top(1);
$text_format_merge_no_bold->set_bottom(1);

$text_format_merge_none =& $workbook->addformat(array( size => 9, font => 'Arial Narrow', align => 'center'));
$text_format_merge_none->set_color('black');
$text_format_merge_none->set_size(9);
$text_format_merge_none->set_bold(1);
$text_format_merge_none->set_border_color('black');
$text_format_merge_none->set_merge();

$text_format_wrapping =& $workbook->addformat(array( size => 10, font => 'Arial Narrow'));
$text_format_wrapping->set_text_wrap();
$text_format_wrapping->set_color('black');
$text_format_wrapping->set_size(10);
$text_format_wrapping->set_fg_color('white');
$text_format_wrapping->set_border_color('black');
$text_format_wrapping->set_left(1);
$text_format_wrapping->set_right(1);
$text_format_wrapping->set_top(1);
$text_format_wrapping->set_align('vcenter');

$uang =& $workbook->addformat(array(num_format => '#,##0', size => 8, font => 'Arial Narrow', align => 'right'));
$uang->set_color('black');
$uang->set_size(8);
$uang->set_border_color('black');
$uang->set_left(1);
$uang->set_right(1);
$uang->set_top(1);
$uang->set_bottom(1);

$uang_bold =& $workbook->addformat(array(num_format => '#,##0', size => 8, font => 'Arial Narrow', align => 'right'));
$uang_bold->set_color('black');
$uang_bold->set_size(8);
$uang_bold->set_border_color('black');
$uang_bold->set_bold(1);
$uang_bold->set_left(1);
$uang_bold->set_right(1);
$uang_bold->set_top(1);
$uang_bold->set_bottom(1);

//$worksheet->insert_bitmap('B2', 'images/logo2.bmp', 15, 5);
$worksheet->write		(0, 0, "DAFTAR INSENTIF / PREMI PRODUKSI PEGAWAI KAPAL", $text_format_merge_none);
$worksheet->write_blank	(0, 1, $text_format_merge_none);
$worksheet->write_blank	(0, 2, $text_format_merge_none);
$worksheet->write_blank	(0, 3, $text_format_merge_none);
$worksheet->write_blank	(0, 4, $text_format_merge_none);
$worksheet->write_blank	(0, 5, $text_format_merge_none);
$worksheet->write_blank	(0, 6, $text_format_merge_none);
$worksheet->write_blank	(0, 7, $text_format_merge_none);
$worksheet->write_blank	(0, 8, $text_format_merge_none);
$worksheet->write_blank	(0, 9, $text_format_merge_none);
$worksheet->write_blank	(0, 10, $text_format_merge_none);
$worksheet->write_blank	(0, 11, $text_format_merge_none);
$worksheet->write_blank	(0, 12, $text_format_merge_none);
$worksheet->write_blank	(0, 13, $text_format_merge_none);
$worksheet->write_blank	(0, 14, $text_format_merge_none);
$worksheet->write_blank	(0, 15, $text_format_merge_none);
$worksheet->write_blank	(0, 16, $text_format_merge_none);
$worksheet->write_blank	(0, 17, $text_format_merge_none);
$worksheet->write_blank	(0, 18, $text_format_merge_none);
$worksheet->write_blank	(0, 19, $text_format_merge_none);
/*$worksheet->write_blank	(0, 20, $text_format_merge_none);
$worksheet->write_blank	(0, 21, $text_format_merge_none);*/

$worksheet->write		(1, 0, "PERATURAN DIREKSI PT. PELINDO PROPERTI INDONESIA NOMOR : PER.06/KP.0602/PMS-2012", $text_format_merge_none);
$worksheet->write_blank	(1, 1, $text_format_merge_none);
$worksheet->write_blank	(1, 2, $text_format_merge_none);
$worksheet->write_blank	(1, 3, $text_format_merge_none);
$worksheet->write_blank	(1, 4, $text_format_merge_none);
$worksheet->write_blank	(1, 5, $text_format_merge_none);
$worksheet->write_blank	(1, 6, $text_format_merge_none);
$worksheet->write_blank	(1, 7, $text_format_merge_none);
$worksheet->write_blank	(1, 8, $text_format_merge_none);
$worksheet->write_blank	(1, 9, $text_format_merge_none);
$worksheet->write_blank	(1, 10, $text_format_merge_none);
$worksheet->write_blank	(1, 11, $text_format_merge_none);
$worksheet->write_blank	(1, 12, $text_format_merge_none);
$worksheet->write_blank	(1, 13, $text_format_merge_none);
$worksheet->write_blank	(1, 14, $text_format_merge_none);
$worksheet->write_blank	(1, 15, $text_format_merge_none);
$worksheet->write_blank	(1, 16, $text_format_merge_none);
$worksheet->write_blank	(1, 17, $text_format_merge_none);
$worksheet->write_blank	(1, 18, $text_format_merge_none);
$worksheet->write_blank	(1, 19, $text_format_merge_none);
$worksheet->write_blank	(1, 20, $text_format_merge_none);
/*$worksheet->write_blank	(1, 21, $text_format_merge_none);*/

$worksheet->write(3, 8, "NAMA KAPAL", $text_format);
$worksheet->write(3, 9, ": ".$arrKapalKru[0]["NAMA_KAPAL"], $text_format);

$worksheet->write(4, 8, "BULAN", $text_format);
$worksheet->write(4, 9, ": ".strtoupper(getNamePeriode($reqPeriode)), $text_format);

$worksheet->write(5, 8, "LOKASI", $text_format);
$worksheet->write(5, 9, ": ", $text_format);

$worksheet->write(7, 0, "", $text_format_center);
$worksheet->write(7, 1, "", $text_format_center);
$worksheet->write(7, 2, "", $text_format_center);
$worksheet->write(7, 3, "", $text_format_center);
$worksheet->write(7, 4, "", $text_format_center);
$worksheet->write(7, 5, "", $text_format_center);
$worksheet->write(7, 6, "REALISASI", $text_format_center);
$worksheet->write		(7, 7, "BESARAN INSENTIF", $text_format_merge);
$worksheet->write_blank	(7, 8, $text_format_merge);
$worksheet->write_blank	(7, 9, $text_format_merge);
$worksheet->write(7, 10, "FAKTOR", $text_format_center);
$worksheet->write(7, 11, "", $text_format_center);
$worksheet->write		(7, 12, "INSENTIF KELEBIHAN PRODUKSI", $text_format_merge);
$worksheet->write_blank	(7, 13, $text_format_merge);
$worksheet->write_blank	(7, 14, $text_format_merge);
$worksheet->write		(7, 15, "TOTAL", $text_format_merge);
$worksheet->write_blank	(7, 16, $text_format_merge);
$worksheet->write_blank	(7, 17, $text_format_merge);
$worksheet->write		(7, 18, "PPH PASAL 21", $text_format_merge);
$worksheet->write_blank	(7, 19, $text_format_merge);
$worksheet->write(7, 20, "INSENTIF", $text_format_center);
/*$worksheet->write(7, 20, "", $text_format_center);
$worksheet->write(7, 21, "", $text_format_center);*/

$worksheet->write(8, 0, "NO.", $text_format_center);
$worksheet->write(8, 1, "NAMA", $text_format_center);
$worksheet->write(8, 2, "NRP", $text_format_center);
$worksheet->write(8, 3, "NPWP", $text_format_center);
$worksheet->write(8, 4, "KJ", $text_format_center);
$worksheet->write(8, 5, "JABATAN", $text_format_center);
$worksheet->write(8, 6, "PRODUKSI", $text_format_center);
$worksheet->write		(8, 7, "PRODUKSI JAM", $text_format_merge);
$worksheet->write_blank	(8, 8, $text_format_merge);
$worksheet->write(8, 9, "TARIF / JAM", $text_format_center);
$worksheet->write(8, 10, "KONVERSI", $text_format_center);
$worksheet->write(8, 11, "JUMLAH", $text_format_center);
$worksheet->write(8, 12, "PRODUKSI JAM", $text_format_center);
$worksheet->write(8, 13, "TARIF / JAM", $text_format_center);
$worksheet->write(8, 14, "JUMLAH", $text_format_center);
$worksheet->write		(8, 15, "HARI KERJA", $text_format_merge);
$worksheet->write_blank	(8, 16, $text_format_merge);
$worksheet->write(8, 17, "INSENTIF", $text_format_center);
$worksheet->write(8, 18, "%", $text_format_center);
$worksheet->write(8, 19, "RUPIAH", $text_format_center);
$worksheet->write(8, 20, "DITERIMA", $text_format_center);

/*$worksheet->write		(8, 20, "Tanda Tangan", $text_format_merge);
$worksheet->write_blank	(8, 21, $text_format_merge);*/

$worksheet->write(9, 0, "", $text_format_center);
$worksheet->write(9, 1, "", $text_format_center);
$worksheet->write(9, 2, "", $text_format_center);
$worksheet->write(9, 3, "", $text_format_center);
$worksheet->write(9, 4, "", $text_format_center);
$worksheet->write(9, 5, "", $text_format_center);
$worksheet->write(9, 6, "JAM", $text_format_center);
$worksheet->write(9, 7, $arrKapalKru[0]["PRODUKSI_NORMAL"], $text_format_center);
$worksheet->write(9, 8, $arrKapalKru[0]["PRODUKSI_MAKSIMAL"], $text_format_center);
$worksheet->write(9, 9, "(Rp.)", $text_format_center);
$worksheet->write(9, 10, "%", $text_format_center);
$worksheet->write(9, 11, "(Rp.)", $text_format_center);
$worksheet->write(9, 12, $arrKapalKru[0]["PRODUKSI_MAKSIMAL"], $text_format_center);
$worksheet->write(9, 13, "(Rp.)", $text_format_center);
$worksheet->write(9, 14, "(Rp.)", $text_format_center);
$worksheet->write(9, 15, "(HK)", $text_format_center);
$worksheet->write(9, 16, "(MK)", $text_format_center);
$worksheet->write(9, 17, "(Rp.)", $text_format_center);
$worksheet->write(9, 18, "", $text_format_center);
$worksheet->write(9, 19, "(Rp.)", $text_format_center);
$worksheet->write(9, 20, "(Rp.)", $text_format_center);
/*$worksheet->write(9, 20, "", $text_format_center);
$worksheet->write(9, 21, "", $text_format_center);*/

$worksheet->write(10, 0, "1", $text_format_center_color_8);
$worksheet->write(10, 1, "2", $text_format_center_color_8);
$worksheet->write(10, 2, "3", $text_format_center_color_8);
$worksheet->write(10, 3, "4", $text_format_center_color_8);
$worksheet->write(10, 4, "5", $text_format_center_color_8);
$worksheet->write(10, 5, "6", $text_format_center_color_8);
$worksheet->write(10, 6, "7", $text_format_center_color_8);
$worksheet->write(10, 7, "8", $text_format_center_color_8);
$worksheet->write(10, 8, "9", $text_format_center_color_8);
$worksheet->write(10, 9, "10", $text_format_center_color_8);
$worksheet->write(10, 10, "11", $text_format_center_color_8);
$worksheet->write(10, 11, "12", $text_format_center_color_8);
$worksheet->write(10, 12, "13", $text_format_center_color_8);
$worksheet->write(10, 13, "14", $text_format_center_color_8);
$worksheet->write(10, 14, "15", $text_format_center_color_8);
$worksheet->write(10, 15, "16", $text_format_center_color_8);
$worksheet->write(10, 16, "17", $text_format_center_color_8);
$worksheet->write(10, 17, "18", $text_format_center_color_8);
$worksheet->write(10, 18, "19", $text_format_center_color_8);
$worksheet->write(10, 19, "20", $text_format_center_color_8);
$worksheet->write(10, 20, "21", $text_format_center_color_8);
/*$worksheet->write(10, 21, "22", $text_format_center_8);*/

$row = 11;
//for($i=0;$i<count($arrKapalKru);$i++)
for($i=0;$i<$jumlah_data;$i++)
{
	$json_premi = json_decode($arrKapalKru[$i]["PREMI_JSON"]);
	
	$worksheet->write($row, 0, $i+1, $text_format_center_8);
	$worksheet->write($row, 1, strtoupper($arrKapalKru[$i]["AWAK_KAPAL"]), $text_format_left);
	$worksheet->write($row, 2, $arrKapalKru[$i]["NRP"], $text_format_center_8);
	$worksheet->write($row, 3, $arrKapalKru[$i]["NPWP"], $text_format_center_8);
	$worksheet->write($row, 4, $arrKapalKru[$i]["KELAS"], $text_format_center_8);
	$worksheet->write($row, 5, $arrKapalKru[$i]["JABATAN"], $text_format_center_8);
	$worksheet->write($row, 6, $arrKapalKru[$i]["REALISASI_PRODUKSI"], $text_format_center_8);
	$worksheet->write		($row, 7, $arrKapalKru[$i]["INTERVAL_PRODUKSI"], $text_format_merge_no_bold);
	$worksheet->write_blank	($row, 8, $text_format_merge_no_bold);
	$worksheet->write($row, 9, $arrKapalKru[$i]["TARIF_NORMAL"], $uang);
	$worksheet->write($row, 10, $arrKapalKru[$i]["FAKTOR_KONVERSI"], $text_format_center_8);
	$worksheet->write($row, 11, $json_premi->{"PREMI"}{0}, $uang);

	if($arrKapalKru[$i]["REALISASI_PRODUKSI"] < $arrKapalKru[$i]["PRODUKSI_MAKSIMAL"])
		$jam = 0;
	else
		$jam = ($arrKapalKru[$i]["REALISASI_PRODUKSI"] - $arrKapalKru[$i]["PRODUKSI_MAKSIMAL"]);
		
	$worksheet->write($row, 12, $jam, $text_format_center_8);
	$worksheet->write($row, 13, $arrKapalKru[$i]["TARIF_MAKSIMAL"], $uang);
	$worksheet->write($row, 14, $json_premi->{"PREMI"}{1}, $uang);
	$worksheet->write($row, 15, $arrKapalKru[$i]["MASA_KERJA"], $text_format_center_8);
	$worksheet->write($row, 16, $arrKapalKru[$i]["MASUK_KERJA"], $text_format_center_8);
	$worksheet->write($row, 17, $json_premi->{"PREMI"}{2}, $uang);
	$worksheet->write($row, 18, $arrKapalKru[$i]["PPH"], $text_format_center_8);
	$worksheet->write($row, 19, $json_premi->{"PREMI"}{3}, $uang);
	$worksheet->write($row, 20, $json_premi->{"PREMI"}{4}, $uang);
	/*$worksheet->write($row, 20, "", $text_format_center_8);
	$worksheet->write($row, 21, "", $text_format_center_8);*/	
	
	$insentif 	+= $json_premi->{"PREMI"}{2};
	$pph 		+= $json_premi->{"PREMI"}{3};
	$insentif_diterima	+= $json_premi->{"PREMI"}{4};
	$row++;

}

	/*$worksheet->write($row, 0, "", $text_format_center);
	$worksheet->write($row, 1, "", $text_format_center);
	$worksheet->write($row, 2, "", $text_format_center);
	$worksheet->write($row, 3, "", $text_format_center);
	$worksheet->write($row, 4, "", $text_format_center);
	$worksheet->write($row, 5, "", $text_format_center);
	$worksheet->write($row, 6, "", $text_format_center);
	$worksheet->write($row, 7, "", $text_format_center);
	$worksheet->write($row, 8, "", $text_format_center);
	$worksheet->write($row, 9, "", $text_format_center);
	$worksheet->write($row, 10, "", $text_format_center);
	$worksheet->write($row, 11, "", $text_format_center);
	$worksheet->write($row, 12, "", $text_format_center);
	$worksheet->write($row, 13, "", $text_format_center);
	$worksheet->write($row, 14, "", $text_format_center);
	$worksheet->write($row, 15, "", $text_format_center);
	$worksheet->write($row, 16, $insentif, $uang_bold);
	$worksheet->write($row, 17, "", $text_format_center);
	$worksheet->write($row, 18, $pph, $uang_bold);
	$worksheet->write($row, 19, $insentif_diterima, $uang_bold);*/
	/*$worksheet->write($row, 20, "", $text_format_center);
	$worksheet->write($row, 21, "", $text_format_center);*/

	/*$worksheet->write($row+2, 1, "TERBILANG : TIGA BELAS JUTA SEMBILAN RATUS TUJUH PULUH DUA RIBU DELAPAN RATUS RUPIAH", $text_format);

	$worksheet->write($row+4, 1, "KETERANGAN", $text_format);
	$worksheet->write($row+5, 1, "PRODUKSI ".$arrKapalKru[0]["NAMA_KAPAL"], $text_format);
	$worksheet->write($row+5, 2, $arrKapalKru[0]["REALISASI_PRODUKSI"], $text_format);
	$worksheet->write($row+5, 3, "(JAM) BULAN ".getNamePeriode($reqPeriode), $text_format);
	$worksheet->write($row+5, 19, "SURABAYA, 16 JULI 2012", $text_format);
	
	$worksheet->write($row+7, 1, "CATATAN :", $text_format);
	$worksheet->write($row+7, 14, "MENGETAHUI,", $text_format);
	
	$worksheet->write($row+8, 1, "a. Tarif besaran Insentif Awak kapal berubah sesuai dengan peraturan direksi PT Pelindo Marine Service", $text_format);
	$worksheet->write($row+8, 14, "MANAGER OPERASI", $text_format);
	$worksheet->write($row+8, 19, "KADIV OPERASI ARMADA", $text_format);

	$worksheet->write($row+9, 1, "    Nomor : PER.06/KP.0602/PMS-2012 Tmt. 1 Pebruari 2012", $text_format);	
	$worksheet->write($row+10, 1, "b. Tarif besaran Insentif Awak kapal PKWT dan KSO Sebesar 85% dari besaran Insentif pegawai Organik", $text_format);
	$worksheet->write($row+11, 1, "    (Peraturan Menyusul)", $text_format);
	
	$worksheet->write($row+12, 14, "ONNY DJAYUS", $text_format);
	$worksheet->write($row+12, 19, "RECKY JULIUS URUILAL", $text_format);	*/
//$worksheet->cleanup();
$z++;
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"gaji_premi_excel.xls\"");
header("Content-Disposition: inline; filename=\"gaji_premi_excel.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>