<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PerubahanAlamat.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$perubahan_alamat = new PerubahanAlamat();

$reqId = httpFilterPost("reqId");
$reqRowId = httpFilterPost("reqRowId");
$reqMode = httpFilterPost("reqMode");
$reqTMT= httpFilterPost("reqTMT");
$reqAlamat= httpFilterPost("reqAlamat");


if($reqMode == "insert")
{
	$perubahan_alamat->setField('PEGAWAI_ID', $reqId);
	$perubahan_alamat->setField('TMT_PERUBAHAN_ALAMAT', dateToDBCheck($reqTMT));
	$perubahan_alamat->setField('ALAMAT', $reqAlamat);
	if($perubahan_alamat->insert())
	{
		$reqRowId= $perubahan_alamat->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
}
else
{
	$perubahan_alamat->setField('PERUBAHAN_ALAMAT_ID', $reqRowId); 
	$perubahan_alamat->setField('TMT_PERUBAHAN_ALAMAT', dateToDBCheck($reqTMT));
	$perubahan_alamat->setField('ALAMAT', $reqAlamat);
	if($perubahan_alamat->update())
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	
}
?>