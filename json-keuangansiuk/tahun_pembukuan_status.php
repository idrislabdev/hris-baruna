<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");


$reqId = httpFilterGet("reqId");

$tahun_pembukuan_detil= new KbbrThnBukuD();
$tahun_pembukuan_detil->setField("THN_BUKU", getTahunPeriode($reqId));
$tahun_pembukuan_detil->setField("BLN_BUKU", getBulanPeriode($reqId));
$tahun_pembukuan_detil->setField("STATUS_CLOSING", "C");
$tahun_pembukuan_detil->setField("LAST_UPDATED_BY", $userLogin->nama);
$tahun_pembukuan_detil->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
$tahun_pembukuan_detil->update();
unset($tahun_buku_detil);

echo "Data berhasil disimpan.";
?>