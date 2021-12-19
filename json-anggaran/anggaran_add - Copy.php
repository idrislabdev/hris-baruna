<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtNeracaAngg.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$kbbt_neraca_angg = new KbbtNeracaAngg();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqPusat = httpFilterPost("reqPusat");
$reqBesar = httpFilterPost("reqBesar");
$reqTahun = httpFilterPost("reqTahun");

$reqTahunBuku= httpFilterPost("reqTahunBuku");
$reqKodeBukuPusat= httpFilterPost("reqKodeBukuPusat");
$reqKodeSubBantu= httpFilterPost("reqKodeSubBantu");
$reqKodeBukuBesar= httpFilterPost("reqKodeBukuBesar");
$reqKodeValuta= httpFilterPost("reqKodeValuta");
$reqJumlah= httpFilterPost("reqJumlah");
$reqJumlahTriwulan1= httpFilterPost("reqJumlahTriwulan1");
$reqJumlahTriwulan2= httpFilterPost("reqJumlahTriwulan2");
$reqJumlahTriwulan3= httpFilterPost("reqJumlahTriwulan3");
$reqJumlahTriwulan4= httpFilterPost("reqJumlahTriwulan4");

$kbbt_neraca_angg->setField("THN_BUKU", $reqTahunBuku);
$kbbt_neraca_angg->setField("KD_CABANG", "96");
$kbbt_neraca_angg->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
$kbbt_neraca_angg->setField("PROGRAM_NAME", "KBB_M_ANGG_SALDO_IMAIS");
$kbbt_neraca_angg->setField("LAST_UPDATED_BY", $userLogin->nama);
$kbbt_neraca_angg->setField("KD_BUKU_PUSAT", $reqKodeBukuPusat);
$kbbt_neraca_angg->setField("KD_SUB_BANTU", $reqKodeSubBantu);
$kbbt_neraca_angg->setField("KD_BUKU_BESAR", $reqKodeBukuBesar);
$kbbt_neraca_angg->setField("KD_VALUTA", $reqKodeValuta);
$kbbt_neraca_angg->setField("ANGG_TAHUNAN", dotToNo($reqJumlah));
$kbbt_neraca_angg->setField("ANGG_TRW1", dotToNo($reqJumlahTriwulan1));
$kbbt_neraca_angg->setField("ANGG_TRW3", dotToNo($reqJumlahTriwulan3));
$kbbt_neraca_angg->setField("ANGG_TRW2", dotToNo($reqJumlahTriwulan2));
$kbbt_neraca_angg->setField("ANGG_TRW4", dotToNo($reqJumlahTriwulan4));

if($reqMode == "insert")
{	
	if($kbbt_neraca_angg->insert())
		echo "Data berhasil disimpan.";
	//echo $kbbt_neraca_angg->query;
}
else
{
	$kbbt_neraca_angg->setField("THN_BUKU_1", $reqTahun);
	$kbbt_neraca_angg->setField("KD_BUKU_BESAR_1", $reqBesar);
	$kbbt_neraca_angg->setField("KD_BUKU_PUSAT_1", $reqPusat);
	if($kbbt_neraca_angg->update())
		echo "Data berhasil disimpan.";
}
?>