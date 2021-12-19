<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/string.func.php");

/* variable */
$reqId = httpFilterGet("reqId");

include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
$inventaris_ruangan = new InventarisRuangan();
$inventaris_ruangan->selectByParams(array("A.INVENTARIS_RUANGAN_ID"=>$reqId),-1,-1);
// echo $inventaris_ruangan->query;exit();
$inventaris_ruangan->firstRow();
$tempKeterangan = $inventaris_ruangan->getField("KETERANGAN");
$tempId = $inventaris_ruangan->getField("INVENTARIS_RUANGAN_ID");
$tempNomor = $inventaris_ruangan->getField("NOMOR");
$tempLokasi = $inventaris_ruangan->getField("LOKASI");
$tempNama = $inventaris_ruangan->getField("INVENTARIS");
$tempKondisi = $inventaris_ruangan->getField("KONDISI");
$tempKondisiFisik = $inventaris_ruangan->getField("KONDISI_FISIK_PROSENTASE");
$tempPerolehanHarga = $inventaris_ruangan->getField("PEROLEHAN_HARGA");
unset($inventaris_ruangan);
$arrFinal = array(
"tempId"=> $tempId, "tempNomor" => $tempNomor, "tempKeterangan" => $tempKeterangan, "tempLokasi" => $tempLokasi, 
"tempNama" => $tempNama, "tempKondisi" => $tempKondisi, "tempKondisiFisik" => $tempKondisiFisik,
"tempPerolehanHarga" =>$tempPerolehanHarga
);
	
echo json_encode($arrFinal);
?>
