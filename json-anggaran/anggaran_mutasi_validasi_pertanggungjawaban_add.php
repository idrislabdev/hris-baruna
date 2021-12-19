<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiD.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranOverbudget.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_mutasi = new AnggaranMutasi();
$anggaran_mutasi_d = new AnggaranMutasiD();
$anggaran_overbudget = new AnggaranOverBudget();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqJumlahDiBayar = httpFilterPost("reqJumlahDiBayar");
$reqJumlahLebihKurang = httpFilterPost("reqJumlahLebihKurang");
$reqJumlahUangMuka = httpFilterPost("reqJumlahUangMuka");
$reqNoNotaUM = httpFilterPost("reqNoNotaUM");
$reqNoNotaJRR = httpFilterPost("reqNoNotaJRR");
$reqNoNotaJKKJKM = httpFilterPost("reqNoNotaJKKJKM");
$reqStatusPengembalian = httpFilterPost("reqStatusPengembalian");
$reqNoRef2 = httpFilterPost("reqNoRef2");
$reqPuspelSubBantu = httpFilterPost("reqPuspelSubBantu");
$reqJenisAnggaranId = httpFilterPost("reqJenisAnggaranId");

$reqBukuBesar = $_POST["reqBukuBesar"];
$reqKartu = $_POST["reqKartu"];
$reqBukuPusat = $_POST["reqBukuPusat"];
$reqNama = $_POST["reqNama"];
$reqKeterangan = $_POST["reqKeterangan"];
$reqUnit = $_POST["reqUnit"];
$reqHarga = $_POST["reqHarga"];
$reqJumlah = $_POST["reqJumlah"];
$reqRealisasi = $_POST["reqRealisasi"];
$reqLebihKurang = $_POST["reqLebihKurang"];
$reqNoUrut = $_POST["reqNoUrut"];
$reqOverbudget = $_POST["reqOverbudget"];

$anggaran_mutasi_d->setField("ANGGARAN_MUTASI_ID", $reqId);
$anggaran_mutasi_d->deleteRealisasi();
unset($anggaran_mutasi_d);

$anggaran_overbudget->setField("ANGGARAN_MUTASI_ID", $reqId);
$anggaran_overbudget->delete();
unset($anggaran_overbudget);

for($i=0;$i<count($reqBukuBesar);$i++)
{
	$anggaran_mutasi_d = new AnggaranMutasiD();
	$anggaran_mutasi_d->setField("ANGGARAN_MUTASI_ID", $reqId);
	$anggaran_mutasi_d->setField("NO_SEQ", $i+1);
	$anggaran_mutasi_d->setField("NO_NOTA", $reqNoBukti);
	$anggaran_mutasi_d->setField("KD_BUKU_BESAR", $reqBukuBesar[$i]);
	$anggaran_mutasi_d->setField("KD_SUB_BANTU", $reqKartu[$i]);
	$anggaran_mutasi_d->setField("KD_BUKU_PUSAT", $reqBukuPusat[$i]);
	$anggaran_mutasi_d->setField("NAMA", $reqNama[$i]);
	$anggaran_mutasi_d->setField("UNIT", $reqUnit[$i]);
	$anggaran_mutasi_d->setField("HARGA_SATUAN", dotToNo($reqHarga[$i]));
	$anggaran_mutasi_d->setField("JUMLAH", dotToNo($reqJumlah[$i]));
	$anggaran_mutasi_d->setField("KET_TAMBAH", $reqKeterangan[$i]);
	$anggaran_mutasi_d->setField("STATUS_JURNAL", "REALISASI");
	$anggaran_mutasi_d->insert();
	unset($anggaran_mutasi_d);	
	
	if(dotToNo($reqOverbudget[$i]) > 0)
	{			
		$anggaran_overbudget = new AnggaranOverBudget();
		$anggaran_overbudget->setField("ANGGARAN_MUTASI_ID", $reqId);
		$anggaran_overbudget->setField("NO_NOTA", $reqNoBukti);
		$anggaran_overbudget->setField("KD_BUKU_BESAR", $reqBukuBesar[$i]);
		$anggaran_overbudget->setField("KD_BUKU_PUSAT", $reqBukuPusat[$i]);
		$anggaran_overbudget->setField("JUMLAH", dotToNo($reqOverbudget[$i]));
		$anggaran_overbudget->insert();
		unset($anggaran_overbudget);
	}
}	


$anggaran_mutasi->setField("VERIFIKASI_TGJAWAB_BY", $userLogin->nama);
$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);
$anggaran_mutasi->updateStatusVerifikasiTgjawabAsman();

echo $reqId."-Anggaran telah diverifikasi.";	
	
?>