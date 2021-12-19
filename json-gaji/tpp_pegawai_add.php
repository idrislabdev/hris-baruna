<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/TppPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$tpp_pegawai = new TppPegawai();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqJabatanId = httpFilterPost("reqJabatanId");
$reqDibayarLumpsum = httpFilterPost("reqDibayarLumpsum");
$reqDibayarJam = httpFilterPost("reqDibayarJam");
$reqTarifKelebihanReguler = httpFilterPost("reqTarifKelebihanReguler");
$reqTarifKelebihanD3Kpnk = httpFilterPost("reqTarifKelebihanD3Kpnk");
$reqTunjanganDtReguler = httpFilterPost("reqTunjanganDtReguler");
$reqTunjanganDtD3Kpnk = httpFilterPost("reqTunjanganDtD3Kpnk");
$reqTarifDlReguler = httpFilterPost("reqTarifDlReguler");
$reqTarifDlD3Kpnk = httpFilterPost("reqTarifDlD3Kpnk");
$reqTarifJamWajib = httpFilterPost("reqTarifJamWajib");
$reqTarifJamTambahan = httpFilterPost("reqTarifJamTambahan");
$reqMinJamMengajar = httpFilterPost("reqMinJamMengajar");

if($reqMode == "insert")
{
	$tpp_pegawai->setField("JABATAN_ID", $reqJabatanId);
	$tpp_pegawai->setField("DIBAYAR_LUMPSUM", dotToNo($reqDibayarLumpsum));
	$tpp_pegawai->setField("DIBAYAR_JAM", dotToNo($reqDibayarJam));
	$tpp_pegawai->setField("TARIF_KELEBIHAN_REGULER", dotToNo($reqTarifKelebihanReguler));
	$tpp_pegawai->setField("TARIF_KELEBIHAN_D3_KPNK", dotToNo($reqTarifKelebihanD3Kpnk));
	$tpp_pegawai->setField("TUNJANGAN_DT_REGULER", dotToNo($reqTunjanganDtReguler));
	$tpp_pegawai->setField("TUNJANGAN_DT_D3_KPNK", dotToNo($reqTunjanganDtD3Kpnk));
	$tpp_pegawai->setField("TARIF_DL_REGULER", dotToNo($reqTarifDlReguler));
	$tpp_pegawai->setField("TARIF_DL_D3_KPNK", dotToNo($reqTarifDlD3Kpnk));
	$tpp_pegawai->setField("TARIF_JAM_WAJIB", dotToNo($reqTarifJamWajib));
	$tpp_pegawai->setField("TARIF_JAM_TAMBAHAN", dotToNo($reqTarifJamTambahan));
	$tpp_pegawai->setField("MIN_JAM_MENGAJAR", dotToNo($reqMinJamMengajar));
	
	if($tpp_pegawai->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$tpp_pegawai->setField("TPP_PEGAWAI_ID", $reqId);
	$tpp_pegawai->setField("JABATAN_ID", $reqJabatanId);
	$tpp_pegawai->setField("DIBAYAR_LUMPSUM", dotToNo($reqDibayarLumpsum));
	$tpp_pegawai->setField("DIBAYAR_JAM", dotToNo($reqDibayarJam));
	$tpp_pegawai->setField("TARIF_KELEBIHAN_REGULER", dotToNo($reqTarifKelebihanReguler));
	$tpp_pegawai->setField("TARIF_KELEBIHAN_D3_KPNK", dotToNo($reqTarifKelebihanD3Kpnk));
	$tpp_pegawai->setField("TUNJANGAN_DT_REGULER", dotToNo($reqTunjanganDtReguler));
	$tpp_pegawai->setField("TUNJANGAN_DT_D3_KPNK", dotToNo($reqTunjanganDtD3Kpnk));
	$tpp_pegawai->setField("TARIF_DL_REGULER", dotToNo($reqTarifDlReguler));
	$tpp_pegawai->setField("TARIF_DL_D3_KPNK", dotToNo($reqTarifDlD3Kpnk));
	$tpp_pegawai->setField("TARIF_JAM_WAJIB", dotToNo($reqTarifJamWajib));
	$tpp_pegawai->setField("TARIF_JAM_TAMBAHAN", dotToNo($reqTarifJamTambahan));
	$tpp_pegawai->setField("MIN_JAM_MENGAJAR", dotToNo($reqMinJamMengajar));

	if($tpp_pegawai->update())
		echo "Data berhasil disimpan.";
	
}
?>