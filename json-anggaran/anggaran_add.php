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
$reqKodeBukuBesar= httpFilterPost("reqKodeBukuBesar");
$reqKodeValuta= httpFilterPost("reqKodeValuta");

$reqKodeSubBantu= $_POST["reqKodeSubBantu"];
$reqJumlah= $_POST["reqJumlah"];
$reqJumlahTriwulan1 = $_POST["reqJumlahTriwulan1"];
$reqJumlahTriwulan2 = $_POST["reqJumlahTriwulan2"];
$reqJumlahTriwulan3 = $_POST["reqJumlahTriwulan3"];
$reqJumlahTriwulan4 = $_POST["reqJumlahTriwulan4"];

$kbbt_neraca_angg->setField("KD_BUKU_PUSAT", $reqKodeBukuPusat);
$kbbt_neraca_angg->setField("KD_BUKU_BESAR", $reqKodeBukuBesar);
$kbbt_neraca_angg->setField("THN_BUKU", $reqTahunBuku);
$kbbt_neraca_angg->delete();

for($i=0; $i<=count($reqKodeSubBantu); $i++)
{			   
	$set = new KbbtNeracaAngg();
	$set->setField("ANGG_TAHUNAN", dotToNo($reqJumlah[$i]));
	$set->setField("ANGG_TRW1", dotToNo($reqJumlahTriwulan1[$i]));
	$set->setField("ANGG_TRW3", dotToNo($reqJumlahTriwulan3[$i]));
	$set->setField("ANGG_TRW2", dotToNo($reqJumlahTriwulan2[$i]));
	$set->setField("ANGG_TRW4", dotToNo($reqJumlahTriwulan4[$i]));
	$set->setField("KD_SUB_BANTU", $reqKodeSubBantu[$i]);
	$set->setField("THN_BUKU", $reqTahunBuku);
	$set->setField("KD_CABANG", "96");
	$set->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
	$set->setField("TGL_CLOSING", "NULL");
	$set->setField("PROGRAM_NAME", "KBB_M_ANGG_SALDO_IMAIS");
	$set->setField("LAST_UPDATED_BY", $userLogin->nama);
	$set->setField("KD_BUKU_PUSAT", $reqKodeBukuPusat);
	$set->setField("KD_BUKU_BESAR", $reqKodeBukuBesar);
	$set->setField("KD_VALUTA", $reqKodeValuta);
	$set->insert();
	unset($set);
}
echo "Data berhasil disimpan.";

?>