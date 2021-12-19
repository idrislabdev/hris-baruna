<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrKeyTabel.php");

$kbbr_key_tabel = new KbbrKeyTabel();

$reqId = httpFilterPost("reqId");
$reqRowId = httpFilterPost("reqRowId");
$reqMode = httpFilterPost("reqMode");
$reqKode= httpFilterPost("reqKode");
$reqNama= httpFilterPost("reqNama");
$reqNamaJabatan= httpFilterPost("reqNamaJabatan");

if($reqMode == "insert")
{   
	$kbbr_key_tabel->setField('KD_CABANG', "11");
	$kbbr_key_tabel->setField('KD_SUBSIS', "ALL");
	$kbbr_key_tabel->setField('ID_TABEL', "OFFICER");
	$kbbr_key_tabel->setField('KD_TABEL', $reqKode); 	
	$kbbr_key_tabel->setField('NM_KET1', $reqNama); 	
	$kbbr_key_tabel->setField('NM_KET2', "");
	$kbbr_key_tabel->setField('NM_KET3', $reqNamaJabatan);
	$kbbr_key_tabel->setField('NM_NUM1', "");
	$kbbr_key_tabel->setField('NM_NUM2', "");
	$kbbr_key_tabel->setField('NM_NUM3', "");
	$kbbr_key_tabel->setField('NM_VAL', "");
	$kbbr_key_tabel->setField('KD_AKTIF', "A");
	//$kbbr_key_tabel->setField('PROGRAM_NAME', "KBB_R_PEJABAT");
	$kbbr_key_tabel->setField('PROGRAM_NAME', "KBBR_PEJABAT_OTOR_IMAIS");
	$kbbr_key_tabel->setField('LEVEL_OPERATOR', "");
	$kbbr_key_tabel->setField('PASSW', "");
	 
	$kbbr_key_tabel->setField("LAST_UPDATED_BY", "IMAIS");
	$kbbr_key_tabel->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($kbbr_key_tabel->insert())
		echo "Data berhasil disimpan.";
}
else
{   
	$kbbr_key_tabel->setField('ID_TABEL_ID', $reqId); 
	$kbbr_key_tabel->setField('KD_TABEL_ID', $reqRowId);
	$kbbr_key_tabel->setField('KD_CABANG', "11");
	$kbbr_key_tabel->setField('KD_SUBSIS', "ALL");
	$kbbr_key_tabel->setField('ID_TABEL', "OFFICER");
	$kbbr_key_tabel->setField('KD_TABEL', $reqKode); 	
	$kbbr_key_tabel->setField('NM_KET1', $reqNama); 	
	$kbbr_key_tabel->setField('NM_KET2', "");
	$kbbr_key_tabel->setField('NM_KET3', $reqNamaJabatan);
	$kbbr_key_tabel->setField('NM_NUM1', "");
	$kbbr_key_tabel->setField('NM_NUM2', "");
	$kbbr_key_tabel->setField('NM_NUM3', "");
	$kbbr_key_tabel->setField('NM_VAL', "");
	$kbbr_key_tabel->setField('KD_AKTIF', "A");
	//$kbbr_key_tabel->setField('PROGRAM_NAME', "KBB_R_PEJABAT");
	$kbbr_key_tabel->setField('PROGRAM_NAME', "KBBR_PEJABAT_OTOR_IMAIS");
	$kbbr_key_tabel->setField('LEVEL_OPERATOR', "");
	$kbbr_key_tabel->setField('PASSW', "");
	 
	$kbbr_key_tabel->setField("LAST_UPDATED_BY", "IMAIS");
	$kbbr_key_tabel->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($kbbr_key_tabel->update())
		echo "Data berhasil disimpan.";
	
}
?>