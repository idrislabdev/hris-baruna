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
$reqJumlahBulanJuli= httpFilterPost("reqJumlahBulanJuli");
$reqJumlahBulanAgustus= httpFilterPost("reqJumlahBulanAgustus");
$reqJumlahBulanSeptember= httpFilterPost("reqJumlahBulanSeptember");
$reqJumlahBulanOktober= httpFilterPost("reqJumlahBulanOktober");
$reqJumlahBulanNovember= httpFilterPost("reqJumlahBulanNovember");
$reqJumlahBulanDesember= httpFilterPost("reqJumlahBulanDesember");
$reqJumlahBulanJanuari= httpFilterPost("reqJumlahBulanJanuari");
$reqJumlahBulanFebruari= httpFilterPost("reqJumlahBulanFebruari");
$reqJumlahBulanMaret= httpFilterPost("reqJumlahBulanMaret");
$reqJumlahBulanApril= httpFilterPost("reqJumlahBulanApril");
$reqJumlahBulanMei= httpFilterPost("reqJumlahBulanMei");
$reqJumlahBulanJuni= httpFilterPost("reqJumlahBulanJuni");

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
$kbbt_neraca_angg->setField("P01_ANGG", dotToNo($reqJumlahBulanJuli));
$kbbt_neraca_angg->setField("P02_ANGG", dotToNo($reqJumlahBulanAgustus));
$kbbt_neraca_angg->setField("P03_ANGG", dotToNo($reqJumlahBulanSeptember));
$kbbt_neraca_angg->setField("P04_ANGG", dotToNo($reqJumlahBulanOktober));
$kbbt_neraca_angg->setField("P05_ANGG", dotToNo($reqJumlahBulanNovember));
$kbbt_neraca_angg->setField("P06_ANGG", dotToNo($reqJumlahBulanDesember));
$kbbt_neraca_angg->setField("P07_ANGG", dotToNo($reqJumlahBulanJanuari));
$kbbt_neraca_angg->setField("P08_ANGG", dotToNo($reqJumlahBulanFebruari));
$kbbt_neraca_angg->setField("P09_ANGG", dotToNo($reqJumlahBulanMaret));
$kbbt_neraca_angg->setField("P10_ANGG", dotToNo($reqJumlahBulanApril));
$kbbt_neraca_angg->setField("P11_ANGG", dotToNo($reqJumlahBulanMei));
$kbbt_neraca_angg->setField("P12_ANGG", dotToNo($reqJumlahBulanJuni));


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