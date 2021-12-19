<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisPenanggungJawab.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisLokasiHistori.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$inventaris_ruangan = new InventarisRuangan();

$reqInventarisId = httpFilterPost("reqInventarisId");
$reqLokasiBaru= httpFilterPost("reqLokasiBaru");
$reqLokasiLama= httpFilterPost("reqLokasiLama");

$inventaris_ruangan->setField("INVENTARIS_ID", $reqInventarisId);
$inventaris_ruangan->setField("LOKASI_ID", $reqLokasiLama);
$inventaris_ruangan->setField("LOKASI_ID_BARU", $reqLokasiBaru);
$inventaris_ruangan->setField("LAST_UPDATE_USER", $userLogin->nama);
		
if($inventaris_ruangan->updateLokasi())
{
	echo "Data berhasil disimpan";
}

				   
?>