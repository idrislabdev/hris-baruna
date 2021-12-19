<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPuspel.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_puspel = new PegawaiPuspel();
$departemen_cabang = new Departemen();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqTMTPuspel= httpFilterPost("reqTMTPuspel");
$reqKodePuspel1= httpFilterPost("reqKodePuspel1");
$reqKodePuspel2= httpFilterPost("reqKodePuspel2");
$reqKodePuspel3= httpFilterPost("reqKodePuspel3");
$reqCabang= httpFilterPost("reqCabang");
$reqDepartemen= httpFilterPost("reqDepartemen");
$reqTanggalPuspel= httpFilterPost("reqTanggalPuspel");

$departemen_cabang->selectByParams(array('DEPARTEMEN_ID'=>$reqDepartemen));
$departemen_cabang->firstRow();
$reqCabang= $departemen_cabang->getField('CABANG_ID');

$pegawai_puspel->setField('TMT_PUSPEL', dateToDBCheck($reqTMTPuspel));
$pegawai_puspel->setField('KODE_PUSPEL1', $reqKodePuspel1);
$pegawai_puspel->setField('KODE_PUSPEL2', $reqKodePuspel2);
$pegawai_puspel->setField('KODE_PUSPEL3', $reqKodePuspel3);
$pegawai_puspel->setField('TANGGAL_PUSPEL', dateToDBCheck($reqTanggalPuspel));
$pegawai_puspel->setField('CABANG_ID', $reqCabang);
$pegawai_puspel->setField('DEPARTEMEN_ID', $reqDepartemen);
$pegawai_puspel->setField('PEGAWAI_PUSPEL_ID', $reqRowId);
$pegawai_puspel->setField('PEGAWAI_ID', $reqId);

if($reqMode == "insert")
{
	$pegawai_puspel->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_puspel->setField("LAST_CREATE_DATE", OCI_SYSDATE);		
	if($pegawai_puspel->insert()){
		$reqRowId= $pegawai_puspel->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_puspel->query;
}
else
{
	$pegawai_puspel->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_puspel->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($pegawai_puspel->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_puspel->query;
}
?>