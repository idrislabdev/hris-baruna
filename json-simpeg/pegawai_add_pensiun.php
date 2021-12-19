<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiStatusPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");

$pegawai_status_pegawai = new PegawaiStatusPegawai();
$user_login = new UserLoginBase();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId= httpFilterPost("reqRowId");

$reqNoSK= httpFilterPost("reqNoSK");
$reqTanggal= httpFilterPost("reqTanggal");
$reqTMT= httpFilterPost("reqTMT");
$reqPejabat= httpFilterPost("reqPejabat");

if($reqMode == "insert")
{
	$pegawai_status_pegawai->setField('NO_SK', $reqNoSK);
	$pegawai_status_pegawai->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
	$pegawai_status_pegawai->setField('TMT_SK', dateToDBCheck($reqTMT));
	$pegawai_status_pegawai->setField('PEJABAT_PENETAP_ID', $reqPejabat);
	$pegawai_status_pegawai->setField('PEGAWAI_ID', $reqId);
	$pegawai_status_pegawai->setField('STATUS_PEGAWAI_ID', 2);
	$pegawai_status_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_status_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	
	if($pegawai_status_pegawai->insert())
	{
		$pegawai = new Pegawai();
		$pegawai->setField('TANGGAL_PENSIUN', dateToDBCheck($reqTMT));
		$pegawai->setField('PEGAWAI_ID', $reqId);
		$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
		$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	
		if($pegawai->updatePensiun())
		{
			$reqRowId= $pegawai_status_pegawai->id;
			echo $reqId."-Data berhasil disimpan.-".$reqRowId;
		}
		$user_login->setField("STATUS", 0);
		$user_login->setField("PEGAWAI_ID", $reqId);
		$user_login->updateStatusAktif();
		
		//echo $pegawai->query;
	}
	//echo $pegawai_status_pegawai->query;
}
?>