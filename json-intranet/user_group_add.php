<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/UserGroup.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$user_group = new UserGroup();

$reqMode = httpFilterPost("reqMode");
$reqId = httpFilterPost("reqId");
$reqNama = httpFilterPost("reqNama");
$reqAksesLoginKepegawaian = httpFilterPost("reqAksesLoginKepegawaian");
$reqAksesLoginPenghasilan = httpFilterPost("reqAksesLoginPenghasilan");
$reqAksesLoginPresensi = httpFilterPost("reqAksesLoginPresensi");
$reqAksesLoginKeuangan = httpFilterPost("reqAksesLoginKeuangan");
$reqAksesLoginFixedAsset = httpFilterPost("reqAksesLoginFixedAsset");
$reqAksesLoginPembayaran = httpFilterPost("reqAksesLoginPembayaran");
$reqAksesLoginPengaturan = httpFilterPost("reqAksesLoginPengaturan");
//echo "kode:".$reqAplikasiGalangan;

if(($reqMode == "add") || ($reqMode == "copy"))
{
	$user_group->setField("NAMA", $reqNama);
	$user_group->setField("AKSES_LOGIN_KEPEGAWAIAN", $reqAksesLoginKepegawaian);
	$user_group->setField("AKSES_LOGIN_PENGHASILAN", $reqAksesLoginPenghasilan);
	$user_group->setField("AKSES_LOGIN_PRESENSI", $reqAksesLoginPresensi);
	$user_group->setField("AKSES_LOGIN_KEUANGAN", $reqAksesLoginKeuangan);
	$user_group->setField("AKSES_LOGIN_FIXED_ASSET", $reqAksesLoginFixedAsset);
	$user_group->setField("AKSES_LOGIN_PEMBAYARAN", $reqAksesLoginPembayaran);
	$user_group->setField("AKSES_LOGIN_PENGATURAN", $reqAksesLoginPengaturan);

	
	// echo $user_group->query;
	if($user_group->insert())
	{	
		// echo $user_group->query;
		echo "Data berhasil disimpan.";
	}
}
elseif($reqMode == "edit")
{
	$user_group->setField("USER_GROUP_ID", $reqId);
	$user_group->setField("NAMA", $reqNama);
	$user_group->setField("AKSES_LOGIN_KEPEGAWAIAN", $reqAksesLoginKepegawaian);
	$user_group->setField("AKSES_LOGIN_PENGHASILAN", $reqAksesLoginPenghasilan);
	$user_group->setField("AKSES_LOGIN_PRESENSI", $reqAksesLoginPresensi);
	$user_group->setField("AKSES_LOGIN_KEUANGAN", $reqAksesLoginKeuangan);
	$user_group->setField("AKSES_LOGIN_FIXED_ASSET", $reqAksesLoginFixedAsset);
	$user_group->setField("AKSES_LOGIN_PEMBAYARAN", $reqAksesLoginPembayaran);
	$user_group->setField("AKSES_LOGIN_PENGATURAN", $reqAksesLoginPengaturan);

	// echo $user_group->update();
	if($user_group->update()) { 
		echo "Data berhasil disimpan.";
	}
	
}
?>