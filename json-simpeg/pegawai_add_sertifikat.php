<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiSertifikat.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_sertifikat = new PegawaiSertifikat();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqTanggalTerbit 			= $_POST["reqTanggalTerbit"];
$reqTanggalKadaluarsa 		= $_POST["reqTanggalKadaluarsa"];
$reqJumlah = $_POST["reqJumlah"];
$reqGroupKapal= $_POST["reqGroupKapal"];
$reqKeterangan= $_POST["reqKeterangan"];
$reqPegawaiSertifikatId = $_POST["reqPegawaiSertifikatId"];
$reqArrayIndex= $_POST["reqArrayIndex"];

$set_loop= $reqArrayIndex;

if($reqMode == "insert")
{
	$pegawai_sertifikat->setField("PEGAWAI_ID", $reqId);
	$pegawai_sertifikat->delete();
	unset($pegawai_sertifikat);
	
	for($i=0;$i<=$set_loop;$i++)
	{
		if($reqPegawaiSertifikatId[$i] == "")
		{}
		else
		{
		$index = $i;
		$pegawai_sertifikat = new PegawaiSertifikat();
		$pegawai_sertifikat->setField("NAMA", $reqPegawaiSertifikatId[$index]);
		$pegawai_sertifikat->setField("TANGGAL_TERBIT", dateToDBCheck($reqTanggalTerbit[$index]));
		$pegawai_sertifikat->setField("TANGGAL_KADALUARSA", dateToDBCheck($reqTanggalKadaluarsa[$index]));
		$pegawai_sertifikat->setField("GROUP_SERTIFIKAT", $reqGroupKapal[$index]);
		$pegawai_sertifikat->setField("KETERANGAN", $reqKeterangan[$index]);
		$pegawai_sertifikat->setField("PEGAWAI_ID", $reqId);
		$pegawai_sertifikat->setField("LAST_CREATE_USER", $userLogin->nama);
		$pegawai_sertifikat->setField("LAST_CREATE_DATE", OCI_SYSDATE);			
		
		$pegawai_sertifikat->insert();
		//echo $pegawai_sertifikat->query;
		unset($pegawai_sertifikat);
		}
	}
	echo "Data berhasil disimpan.";
}

?>