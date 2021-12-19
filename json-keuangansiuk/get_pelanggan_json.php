<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");

/* create objects */

/* LOGIN CHECK */

$reqNoPelangganId = httpFilterGet("reqNoPelangganId");

//$reqNoPelangganId = 'A.11';
//$reqTahun = 3;

$safm_pelanggan = new SafmPelanggan();
$safm_pelanggan->selectByParams(array('MPLG_KODE'=>$reqNoPelangganId));
$safm_pelanggan->firstRow();
//echo $safm_pelanggan->query;
$tempPelanggan = $safm_pelanggan->getField('MPLG_NAMA'); 
$tempAlamat = $safm_pelanggan->getField('MPLG_ALAMAT'); 
$tempNpwp = $safm_pelanggan->getField('MPLG_NPWP');
$tempBadanUsaha = $safm_pelanggan->getField('MPLG_BADAN_USAHA');

$arrFinal = array("MPLG_NAMA" => $tempPelanggan, "MPLG_ALAMAT" =>$tempAlamat, "MPLG_NPWP"=>$tempNpwp, "MPLG_BADAN_USAHA"=>$tempBadanUsaha);
echo json_encode($arrFinal);
?>