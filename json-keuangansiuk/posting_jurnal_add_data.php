<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");


$kbbt_jur_bb = new KbbtJurBb();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBukti= httpFilterPost("reqNoBukti");
$reqTanggalValuta= httpFilterPost("reqTanggalValuta");
$reqTahun= httpFilterPost("reqTahun");
$reqBulan= httpFilterPost("reqBulan");
$reqNoPelanggan= httpFilterPost("reqNoPelanggan");
$reqPelanggan= httpFilterPost("reqPelanggan");
$reqKode= httpFilterPost("reqKode");
$reqBank= httpFilterPost("reqBank");
$reqKodeBank= httpFilterPost("reqKodeBank");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqTanggalPosting= httpFilterPost("reqTanggalPosting");
$reqNoPosting= httpFilterPost("reqNoPosting");
$reqJumlahTransaksi= httpFilterPost("reqJumlahTransaksi");
$reqKursValuta= httpFilterPost("reqKursValuta");
$reqRekKompen= httpFilterPost("reqRekKompen");

$kbbt_jur_bb->setField("", $reqNoBukti);
$kbbt_jur_bb->setField("", dateToDBCheck($reqTanggalValuta));
$kbbt_jur_bb->setField("", $reqTahun);
$kbbt_jur_bb->setField("", $reqBulan);
$kbbt_jur_bb->setField("", $reqNoPelanggan);
$kbbt_jur_bb->setField("", $reqPelanggan);
$kbbt_jur_bb->setField("", $reqKode);
$kbbt_jur_bb->setField("", $reqBank);
$kbbt_jur_bb->setField("", $reqKodeBank);
$kbbt_jur_bb->setField("", dateToDBCheck($reqTanggalTransaksi));
$kbbt_jur_bb->setField("", $reqKeterangan);
$kbbt_jur_bb->setField("", $reqValutaNama);
$kbbt_jur_bb->setField("", dateToDBCheck($reqTanggalPosting));
$kbbt_jur_bb->setField("", $reqNoPosting);
$kbbt_jur_bb->setField("", $reqJumlahTransaksi);
$kbbt_jur_bb->setField("", $reqKursValuta);
$kbbt_jur_bb->setField("", $reqRekKompen);

if($reqMode == "insert")
{		
	if($kbbt_jur_bb->insert())
		echo "Data berhasil disimpan.";
}
else
{		
	if($kbbt_jur_bb->update())
		echo "Data berhasil disimpan.";
			
}
?>