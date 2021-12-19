<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_jenis_pegawai = new PegawaiJenisPegawai();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqTMT= httpFilterPost("reqTMT");
$reqJenisPegawai= 8;
$reqJurusan= httpFilterPost("reqJurusan");
$reqKelas= httpFilterPost("reqKelas");
$reqDokumenId = httpFilterPost("reqDokumenId");
$reqSPP = httpFilterPost("reqSPP");
$reqDepartemenKelas = httpFilterPost("reqDepartemenKelas");

//echo $reqDepartemenKelas;exit;
$pegawai_jenis_pegawai->setField('TMT_JENIS_PEGAWAI', dateToDBCheck($reqTMT));
$pegawai_jenis_pegawai->setField('JURUSAN', $reqJurusan);
$pegawai_jenis_pegawai->setField('JUMLAH_SPP', dotToNo($reqSPP));
$pegawai_jenis_pegawai->setField('KELAS_SEKOLAH', $reqKelas);
$pegawai_jenis_pegawai->setField('PEGAWAI_JENIS_PEGAWAI_ID', $reqRowId);
$pegawai_jenis_pegawai->setField('PEGAWAI_ID', $reqId);
$pegawai_jenis_pegawai->setField('DEPARTEMEN_KELAS_ID', $reqDepartemenKelas);

if($reqMode == "insert")
{
	$pegawai_jenis_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai_jenis_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($pegawai_jenis_pegawai->insertKadet()){
		$reqRowId= $pegawai_jenis_pegawai->id;
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_jenis_pegawai->query;exit;
}
else
{
	$pegawai_jenis_pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai_jenis_pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
	if($pegawai_jenis_pegawai->updateKadet()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
	//echo $pegawai_jenis_pegawai->query;
}
?>