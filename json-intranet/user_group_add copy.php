<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/UserGroup.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$user_group = new UserGroup();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama = httpFilterPost("reqNama");
$reqAksesIntranet = httpFilterPost("reqAksesIntranet");
$reqAplikasiDatabase = httpFilterPost("reqAplikasiDatabase");
$reqAplikasiOperasional = httpFilterPost("reqAplikasiOperasional");
$reqAplikasiKepegawaian = httpFilterPost("reqAplikasiKepegawaian");
$reqAplikasiPenghasilan = httpFilterPost("reqAplikasiPenghasilan");
$reqAplikasiPresensi = httpFilterPost("reqAplikasiPresensi");
$reqAplikasiPenilaian = httpFilterPost("reqAplikasiPenilaian");
$reqAplikasiKomersial = httpFilterPost("reqAplikasiKomersial");
$reqAplikasiBackup = httpFilterPost("reqAplikasiBackup");
$reqAplikasiHukum = httpFilterPost("reqAplikasiHukum");
$reqAdministrasiWebsite = httpFilterPost("reqAdministrasiWebsite");
$reqAplikasiSurvey = httpFilterPost("reqAplikasiSurvey");
$reqAplikasiFileManager = httpFilterPost("reqAplikasiFileManager");
$reqAplikasiArsip = httpFilterPost("reqAplikasiArsip");
$reqAplikasiInventaris = httpFilterPost("reqAplikasiInventaris");
$reqAplikasiNotifikasi = httpFilterPost("reqAplikasiNotifikasi");
$reqAplikasiSPPD = httpFilterPost("reqAplikasiSPPD");
$reqPublish = httpFilterPost("reqPublish");
$reqSMSGateway = httpFilterPost("reqSMSGateway");
$reqKeuangan = httpFilterPost("reqKeuangan");
$reqAksesKontrakHukum = httpFilterPost("reqAksesKontrakHukum");
$reqAplikasiGalangan = httpFilterPost("reqAplikasiGalangan");
$reqAplikasiAnggaran = httpFilterPost("reqAplikasiAnggaran");
$reqAplikasiKeuangan = httpFilterPost("reqAplikasiKeuangan");
//echo "kode:".$reqAplikasiGalangan;

if(($reqMode == "add") || ($reqMode == "copy"))
{
	$user_group->setField("NAMA", $reqNama);
	$user_group->setField("AKSES_APP_OPERASIONAL_ID", $reqAplikasiOperasional);
	$user_group->setField("AKSES_APP_ARSIP_ID", $reqAplikasiArsip);
	$user_group->setField("AKSES_APP_INVENTARIS_ID", $reqAplikasiInventaris);
	$user_group->setField("AKSES_APP_SPPD_ID", $reqAplikasiSPPD);
	$user_group->setField("AKSES_APP_KEPEGAWAIAN_ID", $reqAplikasiKepegawaian);
	$user_group->setField("AKSES_APP_PENGHASILAN_ID", $reqAplikasiPenghasilan);
	$user_group->setField("AKSES_APP_PRESENSI_ID", $reqAplikasiPresensi);
	$user_group->setField("AKSES_APP_PENILAIAN_ID", $reqAplikasiPenilaian);
	$user_group->setField("AKSES_APP_BACKUP_ID", $reqAplikasiBackup);
	$user_group->setField("AKSES_APP_HUKUM_ID", $reqAplikasiHukum);
	$user_group->setField("AKSES_APP_KOMERSIAL_ID", $reqAplikasiKomersial);
	$user_group->setField("AKSES_ADM_WEBSITE_ID", $reqAdministrasiWebsite);	
	$user_group->setField("AKSES_ADM_INTRANET_ID", $reqAksesIntranet);	
	$user_group->setField("AKSES_APP_SURVEY_ID", $reqAplikasiSurvey);		
	$user_group->setField("AKSES_APP_FILE_MANAGER_ID", $reqAplikasiFileManager);	
	$user_group->setField("AKSES_SMS_GATEWAY", $reqSMSGateway);		
	$user_group->setField("PUBLISH_KANTOR_PUSAT", $reqPublish);	
	$user_group->setField("AKSES_KEUANGAN", $reqKeuangan);	
	$user_group->setField("AKSES_KONTRAK_HUKUM", $reqAksesKontrakHukum);
	$user_group->setField("AKSES_APP_NOTIFIKASI_ID", $reqAplikasiNotifikasi);
	$user_group->setField("AKSES_APP_GALANGAN_ID", $reqAplikasiGalangan);
	$user_group->setField("AKSES_APP_ANGGARAN_ID", $reqAplikasiAnggaran);
	$user_group->setField("AKSES_APP_KEUANGAN_ID", $reqAplikasiKeuangan);
	
	//echo $user_group->query;
	if($user_group->insert())
	{	echo $user_group->query;
		echo "Data berhasil disimpan.";
	}
}
elseif($reqMode == "edit")
{
	$user_group->setField("USER_GROUP_ID", $reqId);
	$user_group->setField("NAMA", $reqNama);
	$user_group->setField("AKSES_APP_OPERASIONAL_ID", $reqAplikasiOperasional);
	$user_group->setField("AKSES_APP_ARSIP_ID", $reqAplikasiArsip);
	$user_group->setField("AKSES_APP_INVENTARIS_ID", $reqAplikasiInventaris);
	$user_group->setField("AKSES_APP_SPPD_ID", $reqAplikasiSPPD);
	$user_group->setField("AKSES_APP_KEPEGAWAIAN_ID", $reqAplikasiKepegawaian);
	$user_group->setField("AKSES_APP_PENGHASILAN_ID", $reqAplikasiPenghasilan);

	$user_group->setField("AKSES_APP_PRESENSI_ID", $reqAplikasiPresensi);
	$user_group->setField("AKSES_APP_PENILAIAN_ID", $reqAplikasiPenilaian);
	$user_group->setField("AKSES_APP_BACKUP_ID", $reqAplikasiBackup);
	$user_group->setField("AKSES_APP_HUKUM_ID", $reqAplikasiHukum);
	$user_group->setField("AKSES_APP_KOMERSIAL_ID", $reqAplikasiKomersial);
	$user_group->setField("AKSES_ADM_WEBSITE_ID", $reqAdministrasiWebsite);	
	$user_group->setField("AKSES_ADM_INTRANET_ID", $reqAksesIntranet);	
	$user_group->setField("AKSES_APP_SURVEY_ID", $reqAplikasiSurvey);		
	$user_group->setField("AKSES_APP_FILE_MANAGER_ID", $reqAplikasiFileManager);		
	$user_group->setField("AKSES_SMS_GATEWAY", $reqSMSGateway);		
	$user_group->setField("PUBLISH_KANTOR_PUSAT", $reqPublish);		
	$user_group->setField("AKSES_KEUANGAN", $reqKeuangan);	
	$user_group->setField("AKSES_KONTRAK_HUKUM", $reqAksesKontrakHukum);	
	$user_group->setField("AKSES_APP_NOTIFIKASI_ID", $reqAplikasiNotifikasi);
	$user_group->setField("AKSES_APP_GALANGAN_ID", $reqAplikasiGalangan);
	$user_group->setField("AKSES_APP_ANGGARAN_ID", $reqAplikasiAnggaran);
	$user_group->setField("AKSES_APP_KEUANGAN_ID", $reqAplikasiKeuangan);

	if($user_group->update()) { 
		echo "Data berhasil disimpan.";
	}
	
}
?>