<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisKartuKendali.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

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

$arrInvetarisRuanganId = explode(",", $reqInventarisRuanganId);

for($i=0;$i<count($arrInvetarisRuanganId);$i++)
{
	$inventaris_kartu_kendali = new InventarisKartuKendali();
	$inventaris_kartu_kendali->setField("INVENTARIS_RUANGAN_ID", $arrInvetarisRuanganId[$i]);	
	$inventaris_kartu_kendali->setField("PERIODE", $reqPeriode);
	$inventaris_kartu_kendali->deleteByInventarisPeriode();
	
	$inventaris_ruangan = new InventarisRuangan();
	$inventaris_ruangan->selectByParamsSimple(array("A.INVENTARIS_RUANGAN_ID" => $arrInvetarisRuanganId[$i]));
	$inventaris_ruangan->firstRow();
	$perolehan_harga = $inventaris_ruangan->getField("PEROLEHAN_HARGA");
	$reqNilaiBuku = $perolehan_harga - round(($perolehan_harga * ($reqPenyusutan/100)));
	$inventaris_kartu_kendali->setField("KONDISI_FISIK_ID", ValToNullDB(""));
	$inventaris_kartu_kendali->setField("KONDISI_FISIK_PROSENTASE", ValToNullDB($reqProsentase));
	$inventaris_kartu_kendali->setField("PERIODE", $reqPeriode);
	$inventaris_kartu_kendali->setField("PENYUSUTAN", ValToNullDB($reqPenyusutan));
	$inventaris_kartu_kendali->setField("KETERANGAN", $reqKeterangan);
	$inventaris_kartu_kendali->setField("INVENTARIS_RUANGAN_ID", ValToNullDB($arrInvetarisRuanganId[$i]));
	$inventaris_kartu_kendali->setField("TANGGAL", dateToDBCheck($reqTanggal));
	$inventaris_kartu_kendali->setField('NILAI_BUKU', ValToNullDB(dotToNo($reqNilaiBuku)));
	$inventaris_kartu_kendali->setField("LAST_CREATE_USER", $userLogin->nama);
	$inventaris_kartu_kendali->setField("LAST_CREATE_DATE", "CURRENT_DATE");	
	$inventaris_kartu_kendali->insert();

	unset($inventaris_kartu_kendali);
	unset($inventaris_ruangan);
}
echo "Data berhasil disimpan.";
?>