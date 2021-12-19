<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");

$kbbt_jur_bb = new KbbtJurBb();

$reqId = httpFilterPost("reqId");
$reqJenisJurnal = httpFilterPost("reqJenisJurnal");
$reqBulan = httpFilterPost("reqBulan");
$reqTahun = httpFilterPost("reqTahun");
$reqTanggalTransaksi = httpFilterPost("reqTanggalTransaksi");
$reqKeteranganJurnal = httpFilterPost("reqKeteranganJurnal");


$kbbt_jur_bb->setField("NOJUR",$reqId);
$kbbt_jur_bb->setField("JENJUR",$reqJenisJurnal);
$kbbt_jur_bb->setField("BLN",$reqBulan);
$kbbt_jur_bb->setField("THN",$reqTahun);
$kbbt_jur_bb->setField("TGLTR",dateToDB($reqTanggalTransaksi));
$kbbt_jur_bb->setField("KET",$reqKeteranganJurnal);
$no_nota = $kbbt_jur_bb->callCopyJurnal();
echo $no_nota."-Data berhasil dicopy.";

?>