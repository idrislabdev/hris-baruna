<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/PotonganKondisiJenisPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$potongan_kondisi_jenis_pegawai = new PotonganKondisiJenisPegawai();

$reqId = httpFilterPost("reqId");
$reqJenisPegawaiId = httpFilterPost("reqJenisPegawaiId");
$reqMode = httpFilterPost("reqMode");
$reqJenisPenghasilan = $_POST["reqJenisPenghasilan"];
$reqJumlah = $_POST["reqJumlah"];
$reqProsentase = $_POST["reqProsentase"];
$reqKali = $_POST["reqKali"];
$reqJumlahEntri = $_POST["reqJumlahEntri"];
$reqPotonganKondisiId = $_POST["reqPotonganKondisiId"];
$reqKelas = httpFilterPost("reqKelas");
$reqKelompok = httpFilterPost("reqKelompok");
$reqCurrentKelas = httpFilterPost("reqCurrentKelas");
$reqJenisPotongan = $_POST["reqJenisPotongan"];
$reqOpsi = $_POST["reqOpsi"];
			  
if($reqMode == "insert")
{

	$potongan_kondisi_jenis_pegawai->setField("JENIS_PEGAWAI_ID", $reqJenisPegawaiId);
	$potongan_kondisi_jenis_pegawai->setField("KELOMPOK", $reqKelompok);
	$potongan_kondisi_jenis_pegawai->setField("KELAS", $reqCurrentKelas);
	$potongan_kondisi_jenis_pegawai->delete();
	unset($potongan_kondisi_jenis_pegawai);
	
	for($i=0;$i<count($reqPotonganKondisiId);$i++)
	{
		if($reqJenisPenghasilan[$i] == "")
		{}
		else
		{
		$index = $reqJenisPenghasilan[$i];
		$potongan_kondisi_jenis_pegawai = new PotonganKondisiJenisPegawai();
		$potongan_kondisi_jenis_pegawai->setField("JENIS_PEGAWAI_ID", $reqJenisPegawaiId);
		$potongan_kondisi_jenis_pegawai->setField("POTONGAN_KONDISI_ID", $reqPotonganKondisiId[$index]);
		$potongan_kondisi_jenis_pegawai->setField("JUMLAH", $reqJumlah[$index]);
		$potongan_kondisi_jenis_pegawai->setField("PROSENTASE", $reqProsentase[$index]);
		$potongan_kondisi_jenis_pegawai->setField("SUMBER", $reqId);
		$potongan_kondisi_jenis_pegawai->setField("KALI", $reqKali[$index]);
		$potongan_kondisi_jenis_pegawai->setField("KELAS", $reqKelas);
		$potongan_kondisi_jenis_pegawai->setField("KELOMPOK", $reqKelompok);
		$potongan_kondisi_jenis_pegawai->setField("JENIS_POTONGAN", $reqJenisPotongan[$index]);
		$potongan_kondisi_jenis_pegawai->setField("JUMLAH_ENTRI", dotToNo($reqJumlahEntri[$index]));		
		$potongan_kondisi_jenis_pegawai->setField("OPSI", $reqOpsi[$index]);		
		$potongan_kondisi_jenis_pegawai->insert();
		//echo $potongan_kondisi_jenis_pegawai->query;
		unset($potongan_kondisi_jenis_pegawai);
		}
	}
	echo "Data berhasil disimpan.";
}

?>