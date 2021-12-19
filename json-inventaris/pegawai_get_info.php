<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/string.func.php");

/* variable */
$reqId = httpFilterGet("reqId");

include_once("../WEB-INF/classes/base-inventaris/Pegawai.php");
$pegawai = new Pegawai();
$pegawai->selectByParamsPegawaiJabatan(array("A.PEGAWAI_ID"=>$reqId),-1,-1);
$pegawai->firstRow();
$tempNama = $pegawai->getField("NAMA");
$tempJabatan = $pegawai->getField("JABATAN");
unset($pegawai);

$arrFinal = array(
	"tempNama" => $tempNama, "tempJabatan" => $tempJabatan
);
	
echo json_encode($arrFinal);
?>
