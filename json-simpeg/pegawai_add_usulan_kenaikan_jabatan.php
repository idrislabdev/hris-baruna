<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/KenaikanJabatan.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$kenaikan_jabatan = new KenaikanJabatan();
$UserLoginBase = new UserLoginBase();

$reqId = httpFilterPost("reqId");

$reqDepartemenLama= httpFilterPost("reqDepartemenLama");
$reqJabatanLama= httpFilterPost("reqJabatanLama");
$reqDepartemenBaru= httpFilterPost("reqDepartemenBaru");
$reqJabatanBaru= httpFilterPost("reqJabatanBaru");

$kenaikan_jabatan->setField('PEGAWAI_ID', $reqId);
$kenaikan_jabatan->setField('TANGGAL', OCI_SYSDATE);
$kenaikan_jabatan->setField('DEPARTEMEN_ID_SEBELUM', $reqDepartemenLama);
$kenaikan_jabatan->setField('JABATAN_ID_SEBELUM', $reqJabatanLama);
$kenaikan_jabatan->setField('DEPARTEMEN_ID_SESUDAH', $reqDepartemenBaru);
$kenaikan_jabatan->setField('JABATAN_ID_SESUDAH', $reqJabatanBaru);

if($kenaikan_jabatan->insert())
{
	$UserLoginBase->updateByQuery("UPDATE PPI.USER_LOGIN 
		SET USER_GROUP_ID = (
			SELECT USER_GROUP_ID FROM PPI.USER_GROUP 
			WHERE DEPARTEMEN_ID = '".$reqDepartemenBaru."' 
			AND ((SELECT KELAS FROM PPI_SIMPEG.JABATAN WHERE JABATAN_ID = '". $reqJabatanBaru ."') BETWEEN PEGAWAI_KELAS_MAX AND PEGAWAI_KELAS_MIN) AND ROWNUM = 1
		),
		LAST_UPDATE_DATE = SYSDATE, 
		LAST_UPDATE_USER = '". $userLogin->pegawaiId ."' 
		WHERE PEGAWAI_ID = " . $reqId );
	echo "Data berhasil disimpan.";
}

?>