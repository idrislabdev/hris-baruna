<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiMutasi.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_mutasi = new PegawaiMutasi();
$pegawai_jabatan = new PegawaiJabatan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId= httpFilterPost("reqRowId");

$reqDepartemenLama= httpFilterPost("reqDepartemenLama");
$reqDepartemen= httpFilterPost("reqDepartemen");
$reqJabatan= httpFilterPost("reqJabatan");
$reqNoSK= httpFilterPost("reqNoSK");
$reqTanggal= httpFilterPost("reqTanggal");
$reqTMT= httpFilterPost("reqTMT");
$reqPejabat= httpFilterPost("reqPejabat");
$reqKeterangan = httpFilterPost("reqKeterangan");



if($reqMode == "insert")
{
	$pegawai_mutasi->setField('DEPARTEMEN_ID_LAMA', $reqDepartemenLama);
	$pegawai_mutasi->setField('DEPARTEMEN_ID_BARU', $reqDepartemen);
	$pegawai_mutasi->setField('NO_SK', $reqNoSK);
	$pegawai_mutasi->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
	$pegawai_mutasi->setField('TMT_SK', dateToDBCheck($reqTMT));
	$pegawai_mutasi->setField('PEJABAT_PENETAP_ID', $reqPejabat);
	$pegawai_mutasi->setField('PEGAWAI_ID', $reqId);
	$pegawai_mutasi->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_mutasi->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	
	if($pegawai_mutasi->insert())
	{

		$pegawai_jabatan->setField('PEGAWAI_ID', $reqId);
		$pegawai_jabatan->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
		$pegawai_jabatan->setField('TMT_JABATAN', dateToDBCheck($reqTMT));
		$pegawai_jabatan->setField('NO_SK', $reqNoSK);
		$pegawai_jabatan->setField('CABANG_ID', 1);
		$pegawai_jabatan->setField('DEPARTEMEN_ID', $reqDepartemen);
		$pegawai_jabatan->setField('JABATAN_ID', $reqJabatan);
		$pegawai_jabatan->setField('KETERANGAN', $reqKeterangan);
		$pegawai_jabatan->setField('PEJABAT_PENETAP_ID', $reqPejabat);

		$pegawai_jabatan->setField("LAST_CREATE_USER", $userLogin->nama);
		$pegawai_jabatan->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
		$pegawai_jabatan->insert();

		$pegawai = new Pegawai();
		$pegawai->setField('DEPARTEMEN_ID', $reqDepartemen);
		$pegawai->setField('PEGAWAI_ID', $reqId);
		$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
		$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	
		if($pegawai->updateDepartemen())
		{
			$reqRowId= $pegawai_mutasi->id;
			echo $reqId."-Data berhasil disimpan.-".$reqRowId;
		}
		//echo $pegawai->query;
	}
	//echo $pegawai_mutasi->query;
}
?>