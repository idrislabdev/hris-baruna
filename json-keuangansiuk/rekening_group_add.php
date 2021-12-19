<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGroupRek.php");

$rekening_group = new KbbrGroupRek();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKode= httpFilterPost("reqKode");
$reqNama= httpFilterPost("reqNama");
$reqTipe= httpFilterPost("reqTipe");
$reqRekeningMulai= httpFilterPost("reqRekeningMulai");
$reqRekeningSampai= httpFilterPost("reqRekeningSampai");
$reqStatus= httpFilterPost("reqStatus");


if($reqMode == "insert")
{
	$rekening_group->setField('ID_GROUP_TEMP', $reqId); 
	$rekening_group->setField('ID_GROUP', strtoupper($reqKode));
	$rekening_group->setField('KODE', $reqKode);
	$rekening_group->setField('NAMA_GROUP', $reqNama);
	$rekening_group->setField('TIPE_NOREK', $reqTipe);
	$rekening_group->setField('MULAI_REKENING', $reqRekeningMulai);
	$rekening_group->setField('SAMPAI_REKENING', $reqRekeningSampai);
	$rekening_group->setField('KD_AKTIF', $reqStatus);
	$rekening_group->setField("LAST_UPDATED_BY", $userLogin->nama);
	$rekening_group->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$rekening_group->setField("PROGRAM_NAME", "KBB_M_GROUP_REK_IMAIS");
	
		
	if($rekening_group->insert())
		echo "Data berhasil disimpan.";
		//echo $rekening_group->query;
}
else
{
	$rekening_group->setField('ID_GROUP_TEMP', $reqId); 
	$rekening_group->setField('ID_GROUP', strtoupper($reqKode));
	$rekening_group->setField('NAMA_GROUP', $reqNama);
	$rekening_group->setField('TIPE_NOREK', $reqTipe);
	$rekening_group->setField('MULAI_REKENING', $reqRekeningMulai);
	$rekening_group->setField('SAMPAI_REKENING', $reqRekeningSampai);
	$rekening_group->setField('KD_AKTIF', $reqStatus);
	$rekening_group->setField("LAST_UPDATED_BY", $userLogin->nama);
	$rekening_group->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$rekening_group->setField("PROGRAM_NAME", "KBB_M_GROUP_REK_IMAIS");
		
	if($rekening_group->update())
		echo "Data berhasil disimpan.";
		echo $rekening_group->query;
}
?>