<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/Notifikasi.php");
include_once("../WEB-INF/classes/base/NotifikasiUserLogin.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$notifikasi = new Notifikasi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqUserLogin= $_POST['reqUserLogin'];
$reqEmailUserTerkait= httpFilterPost("reqEmailUserTerkait");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqKirim= httpFilterPost("reqKirim");
$reqUserLoginId= httpFilterPost("reqUserLoginId");
$reqUserLogin= httpFilterPost("reqUserLogin");

if($reqMode == "update")
{
	//echo $reqUserLogin.'---';
	//$notifikasi->setField("NOTIFIKASI_ID", $reqId);
	//$notifikasi->delete();
	
	$notifikasi->setField("NOTIFIKASI_ID", $reqId);
	$notifikasi->setField("EMAIL_USER_TERKAIT", setNULL($reqEmailUserTerkait));
	$notifikasi->setField("NAMA", $reqNama);
	$notifikasi->setField("KIRIM_HARI_MINUS", setNULL($reqKirim));
	$notifikasi->setField("KETERANGAN", $reqKeterangan);
	
	if($notifikasi->update())
	{
		$set=new Notifikasi();
		$set->setField("NOTIFIKASI_ID", $reqId);
		if($set->delete())
		{
			$arrUserLogin=explode(',',$reqUserLoginId);
			for($i=0;$i<count($arrUserLogin);$i++)
			{
				$child=new NotifikasiUserLogin();
				$child->setField('USER_LOGIN_ID',$arrUserLogin[$i]);
				$child->setField('NOTIFIKASI_ID',$reqId);
				$child->insert();
			}
		}
		
		
		echo "Data berhasil disimpan.";
	}
}
?>