<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranKelengkapanDokumen.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranOverBudget.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiD.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/utils/FileHandler.php");

$anggaran_mutasi = new AnggaranMutasi();
$anggaran_mutasi_d = new AnggaranMutasiD();
$anggaran_kelengkapan_dokumen = new AnggaranKelengkapanDokumen();
$anggaran_overbudget = new AnggaranOverBudget();
$file			 = new FileHandler();


$FILE_DIR = "../anggaran/uploads/tg_jawab/";
$_THUMB_PREFIX = "z__thumb_";

$reqId = httpFilterPost("reqId");
$reqNoBukti = httpFilterPost("reqNoBukti");
$reqNoRef2 = httpFilterPost("reqNoRef2");
$reqKelengkapanDokumen = httpFilterPost("reqKelengkapanDokumen");
$reqJumlahDiBayar = httpFilterPost("reqJumlahDiBayar");
$reqJumlahLebihKurang = httpFilterPost("reqJumlahLebihKurang");
$reqPuspelSubBantu = httpFilterPost("reqPuspelSubBantu");
$reqJumlahPPN = httpFilterPost("reqJumlahPPN");
$reqPerusahaan = httpFilterPost("reqPerusahaan");
$reqLinkFile   = $_FILES['reqLinkFile'];
$reqLinkFileTemp = httpFilterPost("reqLinkFileTemp");


if($reqJumlahPPN == "")
	$reqJumlahPPN = 0;

$reqBukuBesar = $_POST["reqBukuBesar"];
$reqKartu = $_POST["reqKartu"];
$reqBukuPusat = $_POST["reqBukuPusat"];
$reqSubBantu =  $_POST["reqKartu"];
$reqNama = $_POST["reqNama"];
$reqKeterangan = $_POST["reqKeterangan"];
$reqUnit = $_POST["reqUnit"];
$reqHarga = $_POST["reqHarga"];
$reqJumlah = $_POST["reqJumlah"];
$reqRealisasi = $_POST["reqRealisasi"];
$reqLebihKurang = $_POST["reqLebihKurang"];
$reqOverbudget = $_POST["reqOverbudget"];
$reqPajak = $_POST["reqPajak"];

$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);
$anggaran_mutasi->setField("NO_REF2", $reqNoRef2);
$anggaran_mutasi->setField("JML_VAL_REALISASI", dotToNo($reqJumlahDiBayar));
$anggaran_mutasi->setField("JML_VAL_LEBIH_KURANG", dotToNo($reqJumlahLebihKurang));
$anggaran_mutasi->setField("PUSPEL_SUB_BANTU", $reqPuspelSubBantu);
$anggaran_mutasi->setField("SUPPLIER", $reqPerusahaan);
$anggaran_mutasi->setField("TG_JAWAB_BY", $userLogin->nama);
$anggaran_mutasi->setField("JML_VAL_PAJAK_REALISASI", dotToNo($reqJumlahPPN));
$anggaran_mutasi->updatePertanggungjawaban();

if($reqKelengkapanDokumen==""){}
else
{
	$anggaran_kelengkapan_dokumen->setField("ANGGARAN_MUTASI_ID", $reqId);
	$anggaran_kelengkapan_dokumen->delete();
	
	$arrKelengkapanAnggaran = explode(",", $reqKelengkapanDokumen);
	for($i=0;$i<count($arrKelengkapanAnggaran);$i++)
	{
		$anggaran_kelengkapan_dokumen = new AnggaranKelengkapanDokumen();
		
		$anggaran_kelengkapan_dokumen->setField("ANGGARAN_MUTASI_ID", $reqId);
		$anggaran_kelengkapan_dokumen->setField("KELENGKAPAN_DOKUMEN_ID", $arrKelengkapanAnggaran[$i]);
		$anggaran_kelengkapan_dokumen->insert();
		unset($anggaran_kelengkapan_dokumen);	
	}
}

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
	$anggaran_mutasi_d->setField("KD_SUB_BANTU", $reqSubBantu[$i]);
	$anggaran_mutasi_d->setField("KD_BUKU_PUSAT", $reqBukuPusat[$i]);
	$anggaran_mutasi_d->setField("NAMA", $reqNama[$i]);
	$anggaran_mutasi_d->setField("UNIT", $reqUnit[$i]);
	$anggaran_mutasi_d->setField("HARGA_SATUAN", dotToNo($reqHarga[$i]));
	$anggaran_mutasi_d->setField("JUMLAH", dotToNo($reqJumlah[$i]));
	$anggaran_mutasi_d->setField("KET_TAMBAH", $reqKeterangan[$i]);
	$anggaran_mutasi_d->setField("STATUS_JURNAL", "REALISASI");
	$anggaran_mutasi_d->setField("PAJAK", $reqPajak[$i]);
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
	}
	unset($anggaran_overbudget);
}		
if($reqJumlahPPN > 0)
{
	$anggaran_mutasi_d = new AnggaranMutasiD();
	$anggaran_mutasi_d->setField("ANGGARAN_MUTASI_ID", $reqId);
	$anggaran_mutasi_d->setField("NO_SEQ", $i+1);
	$anggaran_mutasi_d->setField("NO_NOTA", $reqNoBukti);
	$anggaran_mutasi_d->setField("KD_BUKU_BESAR", "112.01.00");
	$anggaran_mutasi_d->setField("KD_SUB_BANTU", "00000");
	$anggaran_mutasi_d->setField("KD_BUKU_PUSAT", "000.00.00");
	$anggaran_mutasi_d->setField("NAMA", "PPN");
	$anggaran_mutasi_d->setField("UNIT", "");
	$anggaran_mutasi_d->setField("HARGA_SATUAN", dotToNo($reqJumlahPPN));
	$anggaran_mutasi_d->setField("JUMLAH", dotToNo($reqJumlahPPN));
	$anggaran_mutasi_d->setField("KET_TAMBAH", "");
	$anggaran_mutasi_d->setField("STATUS_JURNAL", "REALISASI");
	$anggaran_mutasi_d->insert();
	unset($anggaran_mutasi_d);		
}

$cek = formatTextToDb($file->getFileName('reqLinkFile'));
if($cek == "")
{
}
else
{
	$allowed = array(".exe");	$status_allowed='';
	foreach ($allowed as $file_cek) 
	{
		if(preg_match("/$file_cek\$/i", $_FILES['reqLinkFile']['name'])) 
		{
			$status_allowed = 'tidak_boleh';
		}
	}
	
	$renameFile = $reqId.'~'.formatTextToDb($file->getFileName('reqLinkFile'));
	$renameFile = str_replace(" ", "", $renameFile);
	
	$varSource=$FILE_DIR.$reqLinkFileTemp;
	$varThumbnail = $FILE_DIR.$_THUMB_PREFIX.$reqLinkFileTemp;
	
	if($file->uploadToDir('reqLinkFile', $FILE_DIR, $renameFile))
	{
		$insertLinkFile = $file->uploadedFileName;
		$set_file = new AnggaranMutasi();		
		$set_file->setField('ANGGARAN_MUTASI_ID', $reqId);	
		$set_file->setField('TGJAWAB_UPLOAD', $insertLinkFile);
		$set_file->update_file_tgjawab();
	}
}

echo $reqId."-Data berhasil disimpan.";	
	
?>