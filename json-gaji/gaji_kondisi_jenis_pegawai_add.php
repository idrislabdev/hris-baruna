<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiKondisiJenisPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$gaji_kondisi_jenis_pegawai = new GajiKondisiJenisPegawai();

$reqId = httpFilterPost("reqId");
$reqJenisPegawaiId = httpFilterPost("reqJenisPegawaiId");
$reqMode = httpFilterPost("reqMode");
$reqJenisPenghasilan = $_POST["reqJenisPenghasilan"];
$reqJumlah = $_POST["reqJumlah"];
$reqProsentase = $_POST["reqProsentase"];
$reqKali = $_POST["reqKali"];
$reqGajiKondisiId = $_POST["reqGajiKondisiId"];
$reqKelas = httpFilterPost("reqKelas");
$reqKelompok = httpFilterPost("reqKelompok");
$reqCurrentKelas = httpFilterPost("reqCurrentKelas");
$reqKelasId = httpFilterPost("reqKelasId");
					  
if($reqMode == "insert")
{

	$gaji_kondisi_jenis_pegawai->setField("JENIS_PEGAWAI_ID", $reqJenisPegawaiId);
	$gaji_kondisi_jenis_pegawai->setField("KELOMPOK", $reqKelompok);
	$gaji_kondisi_jenis_pegawai->setField("KELAS", $reqKelasId);
	$gaji_kondisi_jenis_pegawai->delete();
	unset($gaji_kondisi_jenis_pegawai);
	
	for($i=0;$i<count($reqGajiKondisiId);$i++)
	{
		if($reqJenisPenghasilan[$i] == "")
		{}
		else
		{
		$index = $reqJenisPenghasilan[$i];
		$gaji_kondisi_jenis_pegawai = new GajiKondisiJenisPegawai();
		$gaji_kondisi_jenis_pegawai->setField("JENIS_PEGAWAI_ID", $reqJenisPegawaiId);
		$gaji_kondisi_jenis_pegawai->setField("GAJI_KONDISI_ID", $reqGajiKondisiId[$index]);
		if($reqJumlah[$index] == "")
			$gaji_kondisi_jenis_pegawai->setField("JUMLAH", "NULL");
		else
			$gaji_kondisi_jenis_pegawai->setField("JUMLAH", $reqJumlah[$index]);		
		$gaji_kondisi_jenis_pegawai->setField("PROSENTASE", $reqProsentase[$index]);
		$gaji_kondisi_jenis_pegawai->setField("SUMBER", $reqId);
		$gaji_kondisi_jenis_pegawai->setField("KALI", $reqKali[$index]);
		$gaji_kondisi_jenis_pegawai->setField("KELAS", $reqKelasId);
		$gaji_kondisi_jenis_pegawai->setField("KELOMPOK", $reqKelompok);
		$gaji_kondisi_jenis_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
		$gaji_kondisi_jenis_pegawai->insert();
		unset($gaji_kondisi_jenis_pegawai);
		}
	}
	echo "Data berhasil disimpan.";
}

?>