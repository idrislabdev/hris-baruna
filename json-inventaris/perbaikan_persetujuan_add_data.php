<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisPerbaikan.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisKartuKendali.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$inventaris_perbaikan = new InventarisPerbaikan();
$inventaris_kartu_kendali = new InventarisKartuKendali();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqTanggalAwal=httpFilterPost("reqTanggalAwal");
$reqTanggalAkhir=httpFilterPost("reqTanggalAkhir");
$reqKeterangan=httpFilterPost("reqKeterangan");
$reqKondisiFisikSebelum=httpFilterPost("reqKondisiFisikSebelum");
$reqKondisiFisikSesudah=httpFilterPost("reqKondisiFisikSesudah");
$reqIdPerbaikan=httpFilterPost("reqIdPerbaikan");
$reqPerolehanHarga = httpFilterPost("reqPerolehanHarga");
	
$id=$reqId;
$inventaris_perbaikan->setField("LAST_UPDATE_USER", $userLogin->nama);
$inventaris_perbaikan->setField("LAST_UPDATE_DATE", "CURRENT_DATE");
$inventaris_perbaikan->setField("PERSETUJUAN", "S");
$inventaris_perbaikan->setField("INVENTARIS_PERBAIKAN_ID", $reqId);

if($inventaris_perbaikan->updateValidasi())
{
	
	$periode = dateToDB($reqTanggalAkhir);
	$periode = getMonth($periode).getYear($periode);
	
	$inventaris_kartu_kendali->setField("INVENTARIS_RUANGAN_ID", $reqIdPerbaikan);
	$inventaris_kartu_kendali->setField("PERIODE", $periode);
	$inventaris_kartu_kendali->deleteByInventarisPeriode();
	
	$nilai_buku = $reqPerolehanHarga;
	$penyusutan = 100 - $reqKondisiFisikSesudah;
	$penyusutan_nilai = $nilai_buku * ($penyusutan / 100);
	$nilai_buku = $nilai_buku - $penyusutan_nilai;

	$inventaris_kartu_kendali = new InventarisKartuKendali();
	$inventaris_kartu_kendali->setField("KONDISI_FISIK_ID", ValToNullDB($req));
	$inventaris_kartu_kendali->setField("KONDISI_FISIK_PROSENTASE", ValToNullDB($reqKondisiFisikSesudah));
	$inventaris_kartu_kendali->setField("PERIODE", $periode);
	$inventaris_kartu_kendali->setField("PENYUSUTAN", ValToNullDB($penyusutan));
	$inventaris_kartu_kendali->setField("KETERANGAN", "ITEM TELAH DIPERBAIKI");
	$inventaris_kartu_kendali->setField("INVENTARIS_RUANGAN_ID", $reqIdPerbaikan);
	$inventaris_kartu_kendali->setField("TANGGAL", dateToDBCheck($reqTanggalAkhir));
	$inventaris_kartu_kendali->setField('NILAI_BUKU', ValToNullDB($nilai_buku));
	$inventaris_kartu_kendali->setField("LAST_CREATE_USER", $userLogin->nama);
	$inventaris_kartu_kendali->setField("LAST_CREATE_DATE", "CURRENT_DATE");			
	if($inventaris_kartu_kendali->insert())
		echo $id."-Data berhasil disimpan.";		
	
}
	
?>