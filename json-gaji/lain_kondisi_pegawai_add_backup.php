<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/LainKondisiPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$lain_kondisi_pegawai = new LainKondisiPegawai();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqPotonganLain = $_POST["reqPotonganLain"];
$reqJumlahTotal = $_POST["reqJumlahTotal"];
$reqAngsuran = $_POST["reqAngsuran"];
$reqJumlahAwalAngsuran = $_POST["reqJumlahAwalAngsuran"];
$reqJumlahAngsuran = $_POST["reqJumlahAngsuran"];
$reqAngsuranTerbayar = $_POST["reqAngsuranTerbayar"];
$reqBulan = $_POST["reqBulan"];
$reqTahun = $_POST["reqTahun"];

$reqLainKondisiId = $_POST["reqLainKondisiId"];
					  
if($reqMode == "insert")
{

	$lain_kondisi_pegawai->setField("PEGAWAI_ID", $reqId);
	$lain_kondisi_pegawai->delete();
	unset($lain_kondisi_pegawai);

	for($i=0;$i<count($reqLainKondisiId);$i++)
	{
		if($reqPotonganLain[$i] == "")
		{}
		else
		{
		$index = $reqPotonganLain[$i];
		$lain_kondisi_pegawai = new LainKondisiPegawai();
		$lain_kondisi_pegawai->setField("LAIN_KONDISI_ID", $reqLainKondisiId[$index]);
		$lain_kondisi_pegawai->setField("PEGAWAI_ID", $reqId);
		$lain_kondisi_pegawai->setField("JUMLAH_TOTAL", dotToNo($reqJumlahTotal[$index]));
		$lain_kondisi_pegawai->setField("ANGSURAN", $reqAngsuran[$index]);
		$lain_kondisi_pegawai->setField("BULAN_MULAI", $reqBulan[$index].$reqTahun[$index]);
		$lain_kondisi_pegawai->setField("JUMLAH_AWAL_ANGSURAN", dotToNo($reqJumlahAwalAngsuran[$index]));
		$lain_kondisi_pegawai->setField("JUMLAH_ANGSURAN", dotToNo($reqJumlahAngsuran[$index]));
		$lain_kondisi_pegawai->setField("ANGSURAN_TERBAYAR", $reqAngsuranTerbayar[$index]);
		$lain_kondisi_pegawai->insert();
		unset($lain_kondisi_pegawai);
		}
	}
	echo "Data berhasil disimpan.";
}

?>