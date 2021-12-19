<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatanP3.php");
include_once("../WEB-INF/classes/base-simpeg/DirektoratP3.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_jabatan_p3 = new PegawaiJabatanP3();
$departemen_cabang = new DirektoratP3();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId= httpFilterPost("reqRowId");

$reqTanggal= httpFilterPost("reqTanggal");
$reqTMT= httpFilterPost("reqTMT");
$reqNoSK= httpFilterPost("reqNoSK");
$reqCabang= httpFilterPost("reqCabang");
$reqDirektoratP3= httpFilterPost("reqDirektoratP3");
//$reqSubDirektoratP3= httpFilterPost("reqSubDirektoratP3");
//$reqSubDirektoratP3= httpFilterPost("reqSubDirektoratP3");
$reqJabatanId= httpFilterPost("reqJabatanId");
$reqNoUrut= httpFilterPost("reqNoUrut");
$reqKelas= httpFilterPost("reqKelas");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqPejabat= httpFilterPost("reqPejabat");

$reqCabangId= httpFilterPost("reqCabangId");
$reqDirektorat= httpFilterPost("reqDirektorat");
$reqSubDirektorat= httpFilterPost("reqSubDirektorat");
$reqSeksi= httpFilterPost("reqSeksi");

$reqCabang= $reqCabangId;
//reqCabangId reqDirektorat reqSubDirektorat reqSeksi
$reqDirektoratP3= $reqDirektorat.$reqSubDirektorat.$reqSeksi;

/*$departemen_cabang->selectByParams(array('DIREKTORAT_P3_ID'=>$reqDirektoratP3));
$departemen_cabang->firstRow();
$reqCabang= $departemen_cabang->getField('CABANG_P3_ID');*/

$pegawai_jabatan_p3->setField('PEGAWAI_ID', $reqId);
$pegawai_jabatan_p3->setField('TANGGAL_SK', dateToDBCheck($reqTanggal));
$pegawai_jabatan_p3->setField('TMT_JABATAN', dateToDBCheck($reqTMT));
$pegawai_jabatan_p3->setField('NO_SK', $reqNoSK);
$pegawai_jabatan_p3->setField('CABANG_P3_ID', $reqCabang);
$pegawai_jabatan_p3->setField('DIREKTORAT_P3_ID', $reqDirektoratP3);
//$pegawai_jabatan_p3->setField('', $reqSubDirektoratP3);
$pegawai_jabatan_p3->setField('JABATAN_ID', $reqJabatanId);
//$pegawai_jabatan_p3->setField('', $reqNoUrut);
//$pegawai_jabatan_p3->setField('', $reqKelas);
$pegawai_jabatan_p3->setField('NAMA', $reqNama);
$pegawai_jabatan_p3->setField('KETERANGAN', $reqKeterangan);
$pegawai_jabatan_p3->setField('PEJABAT_PENETAP_ID', $reqPejabat);
$pegawai_jabatan_p3->setField('PEGAWAI_JABATAN_P3_ID', $reqRowId);

if($reqMode == "insert")
{
	$pegawai_jabatan_p3->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_jabatan_p3->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($pegawai_jabatan_p3->insert()){
		$reqRowId= $pegawai_jabatan_p3->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_jabatan_p3->query;
}
else
{
	$pegawai_jabatan_p3->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_jabatan_p3->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($pegawai_jabatan_p3->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_jabatan_p3->query;
}
?>