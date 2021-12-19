<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
//include_once("../WEB-INF/classes/base-keuangan/Bank.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmBank.php");


$safm_bank = new SafmBank();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKode = httpFilterPost("reqKode");
$reqNama = httpFilterPost("reqNama");
$reqCabang = httpFilterPost("reqCabang");
$reqAlamat = httpFilterPost("reqAlamat");  
$reqKota = httpFilterPost("reqKota");
$reqKodeBukuBesar = httpFilterPost("reqKodeBukuBesar");

if($reqMode == "insert")
{
	$safm_bank->setField('KD_CABANG', "11");
	$safm_bank->setField('JENIS_TABLE', "M");
	$safm_bank->setField('ID_TABLE', "BANK");
	$safm_bank->setField('MBANK_KODE', $reqKode);
	$safm_bank->setField('MBANK_NAMA', $reqNama);
	$safm_bank->setField('MBANK_CABANG', $reqCabang);
	$safm_bank->setField('MBANK_ALAMAT', $reqAlamat);
	$safm_bank->setField('MBANK_NO_TELEPON', " ");
	$safm_bank->setField('MBANK_CONT_PERSON_1', " ");
	$safm_bank->setField('MBANK_CONT_PERSON_2', "");
	$safm_bank->setField('MBANK_CONT_PERSON_3', " ");
	$safm_bank->setField('MBANK_JAB_PERSON_1', " ");
	$safm_bank->setField('MBANK_JAB_PERSON_2', " ");
	$safm_bank->setField('MBANK_JAB_PERSON_3', " ");
	$safm_bank->setField('MBANK_NOTELP_PERSON_1', " ");
	$safm_bank->setField('MBANK_NOTELP_PERSON_2', " ");
	$safm_bank->setField('MBANK_NOTELP_PERSON_3', " ");
	$safm_bank->setField('KD_AKTIF', " ");
	$safm_bank->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$safm_bank->setField("LAST_UPDATED_BY", $userLogin->nama);
	$safm_bank->setField('PROGRAM_NAME', "KBB_MASTER_BANK");
	$safm_bank->setField('MBANK_KODE_BB', $reqKodeBukuBesar);
	$safm_bank->setField('NO_REK_PELINDO', " ");
	$safm_bank->setField('MBANK_KARTU_BB', " ");
	$safm_bank->setField('NO_URUT', "8");
		
	if($safm_bank->insert())
		echo "-Data berhasil disimpan.";
		
	//echo $safm_bank->query;
}
else
{
	$safm_bank->setField('KD_CABANG', "11");
	$safm_bank->setField('JENIS_TABLE', "M");
	$safm_bank->setField('ID_TABLE', "BANK");
	$safm_bank->setField('MBANK_KODE', $reqKode);
	$safm_bank->setField('MBANK_NAMA', $reqNama);
	$safm_bank->setField('MBANK_CABANG', $reqCabang);
	$safm_bank->setField('MBANK_ALAMAT', $reqAlamat);
	$safm_bank->setField('MBANK_NO_TELEPON', "");
	$safm_bank->setField('MBANK_CONT_PERSON_1', "");
	$safm_bank->setField('MBANK_CONT_PERSON_2', "");
	$safm_bank->setField('MBANK_CONT_PERSON_3', "");
	$safm_bank->setField('MBANK_JAB_PERSON_1', "");
	$safm_bank->setField('MBANK_JAB_PERSON_2', "");
	$safm_bank->setField('MBANK_JAB_PERSON_3', "");
	$safm_bank->setField('MBANK_NOTELP_PERSON_1', "");
	$safm_bank->setField('MBANK_NOTELP_PERSON_2', "");
	$safm_bank->setField('MBANK_NOTELP_PERSON_3', "");
	$safm_bank->setField('KD_AKTIF', "");
	$safm_bank->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$safm_bank->setField("LAST_UPDATED_BY", $userLogin->nama);
	$safm_bank->setField('PROGRAM_NAME', "KBB_MASTER_BANK");
	$safm_bank->setField('MBANK_KODE_BB', $reqKodeBukuBesar);
	$safm_bank->setField('NO_REK_PELINDO', "");
	$safm_bank->setField('MBANK_KARTU_BB', "");
	$safm_bank->setField('NO_URUT', "");
		
	if($safm_bank->update())
		echo "-Data berhasil disimpan.";
		
	//echo $safm_bank->query;
			
}
?>