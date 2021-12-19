<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/classes/base/AksesAdmIntranet.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$akses_adm_intranet = new AksesAdmIntranet();

$reqAksesIntranet = httpFilterPost("reqAksesIntranet");
$reqMode = httpFilterPost("reqMode");
$reqNama = httpFilterPost("reqNama");
$reqInformasi = httpFilterPost("reqInformasi");
$reqHasilRapat = httpFilterPost("reqHasilRapat");
$reqAgenda = httpFilterPost("reqAgenda");
$reqForum = httpFilterPost("reqForum");
$reqKataMutiara = httpFilterPost("reqKataMutiara");
$reqKalenderKerja = httpFilterPost("reqKalenderKerja");
$reqUserGroup = httpFilterPost("reqUserGroup");
$reqUserApp = httpFilterPost("reqUserApp");
$reqDepartemen = httpFilterPost("reqDepartemen");

if($reqMode == "insert")
{	
	$akses_adm_intranet->setField("NAMA", $reqNama);
	$akses_adm_intranet->setField("INFORMASI", setNULL($reqInformasi));
	$akses_adm_intranet->setField("HASIL_RAPAT", setNULL($reqHasilRapat));
	$akses_adm_intranet->setField("AGENDA", setNULL($reqAgenda));
	$akses_adm_intranet->setField("FORUM", setNULL($reqForum));
	$akses_adm_intranet->setField("KATA_MUTIARA", setNULL($reqKataMutiara));
	$akses_adm_intranet->setField("KALENDER_KERJA", setNULL($reqKalenderKerja));
	$akses_adm_intranet->setField("USER_GROUP", setNULL($reqUserGroup));
	$akses_adm_intranet->setField("USER_APP", setNULL($reqUserApp));
	$akses_adm_intranet->setField("DEPARTEMEN", setNULL($reqDepartemen));	
	
	if($akses_adm_intranet->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$akses_adm_intranet->setField("AKSES_ADM_INTRANET_ID", $reqAksesIntranet);
	$akses_adm_intranet->setField("NAMA", $reqNama);
	$akses_adm_intranet->setField("INFORMASI", setNULL($reqInformasi));
	$akses_adm_intranet->setField("HASIL_RAPAT", setNULL($reqHasilRapat));
	$akses_adm_intranet->setField("AGENDA", setNULL($reqAgenda));
	$akses_adm_intranet->setField("FORUM", setNULL($reqForum));
	$akses_adm_intranet->setField("KATA_MUTIARA", setNULL($reqKataMutiara));
	$akses_adm_intranet->setField("KALENDER_KERJA", setNULL($reqKalenderKerja));
	$akses_adm_intranet->setField("USER_GROUP", setNULL($reqUserGroup));
	$akses_adm_intranet->setField("USER_APP", setNULL($reqUserApp));
	$akses_adm_intranet->setField("DEPARTEMEN", setNULL($reqDepartemen));
	
	if($akses_adm_intranet->update())
		echo "Data berhasil disimpan.";
	
}
?>