<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");


$referensi_detil = new KbbrGeneralRefD();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqIdRefData= httpFilterGet("reqIdRefData");
$reqKetRefData= httpFilterGet("reqKetRefData");
$reqKdAktif= httpFilterGet("reqKdAktif");

$reqKodeCabang= "11";
$reqJenisFile= "R";
$reqIdFile= "GENREFD";
$reqProgramNama= "KLGR_ANAL_STOK";

if($reqRowId == "")
{
	$referensi_detil->setField("KD_CABANG", $reqKodeCabang);
	$referensi_detil->setField("JENIS_FILE", $reqJenisFile);
	$referensi_detil->setField("ID_FILE", $reqIdFile);
	$referensi_detil->setField("PROGRAM_NAME", $reqProgramNama);
	$referensi_detil->setField("ID_REF_FILE", $reqId);
	
	$referensi_detil->setField("ID_REF_DATA", strtoupper($reqIdRefData));
	$referensi_detil->setField("KET_REF_DATA", $reqKetRefData);
	$referensi_detil->setField("KD_AKTIF", $reqKdAktif);
	
	$referensi_detil->setField("LAST_UPDATED_BY", $userLogin->nama);
	$referensi_detil->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($referensi_detil->insert())
	{
		$temp= "Data berhasil disimpan.";
	}
}
else
{
	$referensi_detil->setField("ID_REF_FILE", $reqId);
	$referensi_detil->setField("ID_REF_DATA_TEMP", $reqRowId);
	
	$referensi_detil->setField("ID_REF_DATA", strtoupper($reqIdRefData));
	$referensi_detil->setField("KET_REF_DATA", $reqKetRefData);
	$referensi_detil->setField("KD_AKTIF", $reqKdAktif);
	$referensi_detil->setField("LAST_UPDATED_BY", $userLogin->nama);
	$referensi_detil->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($referensi_detil->update())
	{
		$temp= "Data berhasil disimpan.";
	}
}

$arrFinal = array("Query" => $temp);
echo json_encode($arrFinal);
?>