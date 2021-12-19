<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranAkses.php");

// get the search term
$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";
$anggaran_akses = new AnggaranAkses();

$reqJenis = httpFilterGet("reqJenis");

if($reqJenis == "uang_muka")
	$statement .= " AND A.KD_BUKU_BESAR LIKE '109%' ";
else
	$statement .= " AND NOT A.KD_BUKU_BESAR LIKE '109%' ";


$anggaran_akses->selectByParamsBukuBesar(array("A.DEPARTEMEN_ID" => $userLogin->idDepartemen, "TAHUN" => date("Y")), -1, -1, $statement." AND A.KD_BUKU_BESAR LIKE '".$search_term."%' ");

$j=0;
while($anggaran_akses->nextRow())
{
	$arr_parent[$j]['label'] = $anggaran_akses->getField("KD_BUKU_BESAR");
	$arr_parent[$j]['desc'] = $anggaran_akses->getField("NM_BUKU_BESAR");
	$j++;
}

echo json_encode($arr_parent);

?>