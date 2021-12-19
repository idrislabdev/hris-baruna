<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtNeracaAngg.php");

include "../operasional/excel/excel_reader2.php";

$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
$kbbt_neraca_angg= new KbbtNeracaAngg();

$reqTahunBuku= httpFilterPost("reqTahunBuku");

$baris= $data->rowcount($sheet_index=0);

//DELETE INSERT PAKAI KONFIRMASI
if($reqTahunBuku == ""){}
else
{
$kbbt_neraca_angg->setField("THN_BUKU", $reqTahunBuku);
$kbbt_neraca_angg->deleteTahun();
}

// import data excel mulai baris ke-4 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{
	$tempTahun= $reqTahunBuku;
	$tempKdCabang= "96";
	$tempKdValuta= "IDR";
	$tempKdSubBantu= "00000";
	
	$tempBukuBesar= $data->val($i, 2);
	$tempBukuPusat= $data->val($i, 3);
	$tempAnggTahunan= $data->val($i, 4);
	$tempAnggTrw1= $data->val($i, 5);
	$tempAnggTrw2= $data->val($i, 6);
	$tempAnggTrw3= $data->val($i, 7);
	$tempAnggTrw4= $data->val($i, 8);
	
	$set= new KbbtNeracaAngg();
	$set->setField("LAST_UPDATED_BY", "SYSTEM");
	$set->setField("PROGRAM_NAME", "IMPORT");
	$set->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
	$set->setField("TGL_CLOSING", dateToDBCheck($req));
	$set->setField("KD_CABANG", $tempKdCabang);
	$set->setField("KD_SUB_BANTU", $tempKdSubBantu);
	$set->setField("KD_VALUTA", $tempKdValuta);
	$set->setField("THN_BUKU", $reqTahunBuku);
	$set->setField("KD_BUKU_BESAR", $tempBukuBesar);
	$set->setField("KD_BUKU_PUSAT", $tempBukuPusat);
	$set->setField("ANGG_TAHUNAN", ValToNo($tempAnggTahunan));
	$set->setField("ANGG_TRW1", ValToNo($tempAnggTrw1));
	$set->setField("ANGG_TRW2", ValToNo($tempAnggTrw2));
	$set->setField("ANGG_TRW3", ValToNo($tempAnggTrw3));
	$set->setField("ANGG_TRW4", ValToNo($tempAnggTrw4));
	$set->insert();
	//if($i == 2)
		//$temp= $set->query;
	unset($set);
	
}

echo "Data berhasil disimpan.";
//echo $temp;
//echo $baris;
?>