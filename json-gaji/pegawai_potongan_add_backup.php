<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/PotonganKondisiPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$potongan_kondisi_pegawai = new PotonganKondisiPegawai();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqPotonganKondisiId = $_POST["reqPotonganKondisiId"];
$reqJumlahTotal = $_POST["reqJumlahTotal"];
$reqPotongan = $_POST["reqPotongan"];
					  
if($reqMode == "insert")
{

	$potongan_kondisi_pegawai->setField("PEGAWAI_ID", $reqId);
	$potongan_kondisi_pegawai->delete();
	unset($potongan_kondisi_pegawai);

	for($i=0;$i<count($reqPotonganKondisiId);$i++)
	{
		if($reqPotongan[$i] == "")
		{}
		else
		{
		$index = $reqPotongan[$i];
		$potongan_kondisi_pegawai = new PotonganKondisiPegawai();
		$potongan_kondisi_pegawai->setField("POTONGAN_KONDISI_ID", $reqPotonganKondisiId[$index]);
		$potongan_kondisi_pegawai->setField("PEGAWAI_ID", $reqId);
		$potongan_kondisi_pegawai->setField("JUMLAH", dotToNo($reqJumlahTotal[$index]));
		$potongan_kondisi_pegawai->insert();
		unset($potongan_kondisi_pegawai);
		}
	}
	echo "Data berhasil disimpan.";
}

?>