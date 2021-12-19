<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/PotonganOpsiTidakPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$potongan_opsi_tidak_pegawai = new PotonganOpsiTidakPegawai();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqJenisPotonganKondisiId = $_POST["reqJenisPotonganKondisiId"];
$reqJenisPotongan = $_POST["reqJenisPotongan"];
					  
if($reqMode == "insert")
{

	$potongan_opsi_tidak_pegawai->setField("PEGAWAI_ID", $reqId);
	$potongan_opsi_tidak_pegawai->delete();
	unset($potongan_opsi_tidak_pegawai);

	for($i=0;$i<count($reqJenisPotonganKondisiId);$i++)
	{
		if($reqJenisPotongan[$i] == "")
		{
			$potongan_opsi_tidak_pegawai = new PotonganOpsiTidakPegawai();
			$potongan_opsi_tidak_pegawai->setField("POTONGAN_KONDISI_JENIS_PEGAWAI", $reqJenisPotonganKondisiId[$i]);
			$potongan_opsi_tidak_pegawai->setField("PEGAWAI_ID", $reqId);
			$potongan_opsi_tidak_pegawai->insert();
			unset($potongan_opsi_tidak_pegawai);
		}
	}
	echo "Data berhasil disimpan.";
}

?>