<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/HapusJurnal.php");
include_once("../WEB-INF/classes/utils/FileHandler.php");


$file = new FileHandler();
$hapus_jurnal = new HapusJurnal();


$reqNomor = httpFilterPost("reqNomor");

$hapus_jurnal->setField('NO_NOTA', $reqNomor);
$hapus_jurnal->setField("CREATED_BY", $userLogin->nama);
$hapus_jurnal->insert();


echo "Data berhasil dihapus.";
?>