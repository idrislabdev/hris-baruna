<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisKartuKendali.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$inventaris_ruangan = new InventarisRuangan();
$inventaris_kartu_kendali = new InventarisKartuKendali();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqProsentase= httpFilterPost("reqProsentase");
$reqPenyusutan= httpFilterPost("reqPenyusutan");
$reqNilaiBuku= httpFilterPost("reqNilaiBuku");
$reqTanggal= httpFilterPost("reqTanggal");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqId= httpFilterPost("reqId");
$reqRowId= httpFilterPost("reqRowId");
$reqInventarisRuanganId= httpFilterPost("reqInventarisRuanganId");
$reqPeriode= httpFilterPost("reqPeriode");

/*DELETE FIRST*/
$inventaris_kartu_kendali->setField("LOKASI_ID", $reqId);
$inventaris_kartu_kendali->setField("PERIODE", $reqPeriode);
$inventaris_kartu_kendali->deleteByLokasi();

$inventaris_ruangan->selectByParams(array("A.LOKASI_ID" => $reqId));
while($inventaris_ruangan->nextRow())
{
	$nilai_buku = $inventaris_ruangan->getField("PEROLEHAN_HARGA");
	$penyusutan = $nilai_buku * ($reqPenyusutan / 100);
	$nilai_buku = $nilai_buku - $penyusutan;

	$inventaris_kartu_kendali = new InventarisKartuKendali();
	$inventaris_kartu_kendali->setField("KONDISI_FISIK_ID", ValToNullDB(""));
	$inventaris_kartu_kendali->setField("KONDISI_FISIK_PROSENTASE", ValToNullDB($reqProsentase));
	$inventaris_kartu_kendali->setField("PERIODE", $reqPeriode);
	$inventaris_kartu_kendali->setField("PENYUSUTAN", ValToNullDB($reqPenyusutan));
	$inventaris_kartu_kendali->setField("KETERANGAN", $reqKeterangan);
	$inventaris_kartu_kendali->setField("INVENTARIS_RUANGAN_ID", ValToNullDB($inventaris_ruangan->getField("INVENTARIS_RUANGAN_ID")));
	$inventaris_kartu_kendali->setField("TANGGAL", dateToDBCheck($reqTanggal));
	$inventaris_kartu_kendali->setField('NILAI_BUKU', ValToNullDB($nilai_buku));
	$inventaris_kartu_kendali->setField("LAST_CREATE_USER", $userLogin->nama);
	$inventaris_kartu_kendali->setField("LAST_CREATE_DATE", "CURRENT_DATE");			
	if($inventaris_kartu_kendali->insert());
	unset($inventaris_kartu_kendali);
}
echo "Data berhasil disimpan.";
	
?>