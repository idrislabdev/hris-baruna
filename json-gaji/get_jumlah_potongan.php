<?
/* INCLUDE FILE */
//include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-gaji/PotonganKondisiPegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqId= httpFilterGet("reqId");
$reqPrefix= httpFilterGet("reqPrefix");
	
$potongan_kondisi_pegawai = new PotonganKondisiPegawai();
$jumlah = $potongan_kondisi_pegawai->getJumlahPotongan($reqId, $reqPrefix);
$arrFinal = array("JUMLAH_POTONGAN" => $jumlah);
echo json_encode($arrFinal);
?>