<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTrans.php");

$transaksi_tipe = new KbbrTipeTrans();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqKode= httpFilterGet("reqKode");
$reqKeterangan= httpFilterGet("reqKeterangan");
$reqNama= httpFilterGet("reqNama");
$reqStatusPostingJurnal= httpFilterGet("reqStatusPostingJurnal");
$reqStatusPajak= httpFilterGet("reqStatusPajak");
$reqStatusMaterai= httpFilterGet("reqStatusMaterai");
$reqKodePajak1= httpFilterGet("reqKodePajak1");
$reqKodePajak2= httpFilterGet("reqKodePajak2");

$reqKodeCabang= "11";
$reqProgramNama= "KBB_R_TEMPL_JURNAL_IMAIS";
$reqIdRefJurnal= "MODULSIUK";

if($reqRowId == "")
{
	$transaksi_tipe->setField("KD_CABANG", $reqKodeCabang);
	$transaksi_tipe->setField("JENIS_FILE", $reqJenisFile);
	$transaksi_tipe->setField("ID_FILE", $reqIdFile);
	$transaksi_tipe->setField("PROGRAM_NAME", $reqProgramNama);
	$transaksi_tipe->setField("ID_REF_FILE", $reqId);
	
	$transaksi_tipe->setField("ID_REF_DATA", strtoupper($reqKode));
	$transaksi_tipe->setField("KET_REF_DATA", $reqKeterangan);
	$transaksi_tipe->setField("KD_AKTIF", $reqNama);
	
	$transaksi_tipe->setField("LAST_UPDATED_BY", $userLogin->nama);
	$transaksi_tipe->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($transaksi_tipe->insert())
	{
		$temp= "Data berhasil disimpan.";
	}
}
else
{
	$transaksi_tipe->setField("ID_REF_FILE", $reqId);
	$transaksi_tipe->setField("ID_REF_DATA_TEMP", $reqRowId);
	
	$transaksi_tipe->setField("ID_REF_DATA", strtoupper($reqKode));
	$transaksi_tipe->setField("KET_REF_DATA", $reqKeterangan);
	$transaksi_tipe->setField("KD_AKTIF", $reqNama);
	$transaksi_tipe->setField("LAST_UPDATED_BY", $userLogin->nama);
	$transaksi_tipe->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($transaksi_tipe->update())
	{
		$temp= "Data berhasil disimpan.";
	}
}

$arrFinal = array("Query" => $temp);
echo json_encode($arrFinal);
?>