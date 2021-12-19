<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");

$reqId = httpFilterPost("reqId");
$reqRowId = httpFilterPost("reqRowId");
$reqKodeJurnal= httpFilterPost("reqKodeJurnal");

$reqKlasTransaksiId= $_POST["reqKlasTransaksiId"];
$reqKlasTransaksi= $_POST["reqKlasTransaksi"];
$reqKeteranganTransaksi= $_POST["reqKeteranganTransaksi"];
$reqGroupCoid= $_POST["reqGroupCoid"];
$reqKodeBukuBesar1= $_POST["reqKodeBukuBesar1"];
$reqKodeBukuBesar2= $_POST["reqKodeBukuBesar2"];
$reqKlasTransaksiDebetKredit= $_POST["reqKlasTransaksiDebetKredit"];
$reqStatusKenaPajak= $_POST["reqStatusKenaPajak"];
$reqFlagJurnal= $_POST["reqFlagJurnal"];

$reqArrayIndex= $_POST["reqArrayIndex"];
$set_loop= $reqArrayIndex;

for($i=0;$i<=$set_loop;$i++)
{
	$index = $i;
	if($reqKlasTransaksiId[$i] == "")
	{
		$transaksi_tipe_detil= new KbbrTipeTransD();
		$transaksi_tipe_detil->setField("KD_CABANG", '11');
		$transaksi_tipe_detil->setField("KD_SUBSIS", $reqId);
		$transaksi_tipe_detil->setField("KD_JURNAL", $reqKodeJurnal);
		$transaksi_tipe_detil->setField("TIPE_TRANS", $reqRowId);
		
		$transaksi_tipe_detil->setField("KLAS_TRANS", $reqKlasTransaksi[$index]);
		$transaksi_tipe_detil->setField("KETK_TRANS", $reqKeteranganTransaksi[$index]);
		$transaksi_tipe_detil->setField("GLREK_COAID", $reqGroupCoid[$index]);
		$transaksi_tipe_detil->setField("KD_BUKU_BESAR1", $reqKodeBukuBesar1[$index]);
		$transaksi_tipe_detil->setField("KD_BUKU_BESAR2", $reqKodeBukuBesar2[$index]);
		$transaksi_tipe_detil->setField("KD_BUKU_BESAR3", "");
		$transaksi_tipe_detil->setField("KD_DK", $reqKlasTransaksiDebetKredit[$index]);
		$transaksi_tipe_detil->setField("KD_AKTIF", "A");
		$transaksi_tipe_detil->setField("LAST_UPDATED_BY", $userLogin->nama);
		$transaksi_tipe_detil->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		$transaksi_tipe_detil->setField("PROGRAM_NAME", "KBB_R_TEMPL_JURNAL");
		$transaksi_tipe_detil->setField("TIPE_LR_VALAS", "");
		$transaksi_tipe_detil->setField("STATUS_KENA_PAJAK", $reqStatusKenaPajak[$index]);
		$transaksi_tipe_detil->setField("FLAG_JURNAL", $reqFlagJurnal[$index]);
		$transaksi_tipe_detil->insert();
		unset($transaksi_tipe_detil);
	}
	else
	{
		$transaksi_tipe_detil= new KbbrTipeTransD();
		$transaksi_tipe_detil->setField("KLAS_TRANS", $reqKlasTransaksi[$index]);
		$transaksi_tipe_detil->setField("KETK_TRANS", $reqKeteranganTransaksi[$index]);
		$transaksi_tipe_detil->setField("GLREK_COAID", $reqGroupCoid[$index]);
		$transaksi_tipe_detil->setField("KD_BUKU_BESAR1", $reqKodeBukuBesar1[$index]);
		$transaksi_tipe_detil->setField("KD_BUKU_BESAR2", $reqKodeBukuBesar2[$index]);
		$transaksi_tipe_detil->setField("KD_DK", $reqKlasTransaksiDebetKredit[$index]);
		$transaksi_tipe_detil->setField("LAST_UPDATED_BY", $userLogin->nama);
		$transaksi_tipe_detil->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		$transaksi_tipe_detil->setField("STATUS_KENA_PAJAK", $reqStatusKenaPajak[$index]);
		$transaksi_tipe_detil->setField("FLAG_JURNAL", $reqFlagJurnal[$index]);
		
		$transaksi_tipe_detil->setField("KD_SUBSIS", $reqId);
		$transaksi_tipe_detil->setField("KD_JURNAL", $reqKodeJurnal);
		$transaksi_tipe_detil->setField("TIPE_TRANS", $reqRowId);
		$transaksi_tipe_detil->setField("KLAS_TRANS_ID", $reqKlasTransaksiId[$index]);
		$transaksi_tipe_detil->update();
		unset($transaksi_tipe_detil);
	}
}
echo "Data Berhasil Disimpan";
?>