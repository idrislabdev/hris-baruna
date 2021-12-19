<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
include_once("../WEB-INF/classes/base-inventaris/Inventaris.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisPenanggungJawab.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisLokasiHistori.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$inventaris_ruangan = new InventarisRuangan();
$inventaris = new Inventaris();
$inventaris_penanggung_jawab = new InventarisPenanggungJawab();
$inventaris_lokasi_histori = new InventarisLokasiHistori();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqInventaris = httpFilterPost("reqInventaris");
$reqInventarisNama = httpFilterPost("reqInventarisNama");
$reqJenisInventaris = httpFilterPost("reqJenisInventaris");
$reqLokasi= httpFilterPost("reqLokasi");
$reqJumlah= httpFilterPost("reqJumlah");
$reqPerolehan= httpFilterPost("reqPerolehan");
$reqNoInvoice= httpFilterPost("reqNoInvoice");
$reqPerolehanHarga = httpFilterPost("reqPerolehanHarga");
$reqPenanggungJawab = httpFilterPost("reqPenanggungJawab");
$reqSpesifikasi = httpFilterPost("reqSpesifikasi");
$reqUmurEkonomis = httpFilterPost("reqUmurEkonomis");

//echo $reqJumlah;

if(is_numeric($reqInventaris))
{
	$inventaris->setField("SPESIFIKASI", trim($reqSpesifikasi));
	$inventaris->setField("INVENTARIS_ID", $reqInventaris);
	$inventaris->updateSpesifikasi();	
}
else
{
	$inventaris->setField("NAMA", $reqInventarisNama);
	$inventaris->setField("KODE", $reqKode);
	$inventaris->setField("JENIS_INVENTARIS_ID", $reqJenisInventaris);
	$inventaris->setField("SPESIFIKASI", trim($reqSpesifikasi));
	$inventaris->setField("LAST_CREATE_USER", $userLogin->nama);
	$inventaris->setField("LAST_CREATE_DATE", "SYSDATE");	
	$inventaris->insert();
	$reqInventaris = $inventaris->id;		
}

if($reqMode == "insert")
{
	for($i=1;$i<=$reqJumlah;$i++)
	{
		$inventaris_ruangan = new InventarisRuangan();
	
		$tanggal_perolehan = dateToDB($reqPerolehan);
		$inventaris_ruangan->setField("INVENTARIS_ID", ValToNullDB($reqInventaris));
		$inventaris_ruangan->setField("LOKASI_ID", $reqId);
		$inventaris_ruangan->setField("KONDISI_FISIK_ID", ValToNullDB("1"));
		$inventaris_ruangan->setField("NOMOR", "PPI_ASSET.INVENTARIS_PENOMORAN('".$reqInventaris."','".$reqId."','".getYear($tanggal_perolehan)."')");
		$inventaris_ruangan->setField("PEROLEHAN_TANGGAL", dateToDBCheck($reqPerolehan));
		$inventaris_ruangan->setField("PEROLEHAN_PERIODE", getMonth($tanggal_perolehan).getYear($tanggal_perolehan));
		$inventaris_ruangan->setField("PEROLEHAN_TAHUN", getYear($tanggal_perolehan));
		$inventaris_ruangan->setField("PEROLEHAN_HARGA", ValToNullDB(dotToNo($reqPerolehanHarga)));
		$inventaris_ruangan->setField("PENYUSUTAN", ValToNullDB(0));
		$inventaris_ruangan->setField("NILAI_BUKU", ValToNullDB(dotToNo($reqPerolehanHarga)));
		$inventaris_ruangan->setField("KETERANGAN", "");
		$inventaris_ruangan->setField("BARCODE", "PPI_ASSET.INVENTARIS_BARCODE('".$reqInventaris."', '".$reqId."', '".getYear($tanggal_perolehan)."')");
		$inventaris_ruangan->setField("STATUS_HAPUS", 0);
		$inventaris_ruangan->setField("NO_URUT", ValToNullDB($i));
		$inventaris_ruangan->setField("KONDISI_FISIK_PROSENTASE", ValToNullDB(100));
		$inventaris_ruangan->setField("NO_INVOICE", $reqNoInvoice);
		$inventaris_ruangan->setField("UMUR_EKONOMIS", $reqUmurEkonomis);
		$inventaris_ruangan->setField("INVOICE_ID", ValToNullDB(""));
		$inventaris_ruangan->setField("LAST_CREATE_USER", $userLogin->nama);
		
		if($inventaris_ruangan->insert())
		{
			$inventaris_penanggung_jawab = new InventarisPenanggungJawab();
			$inventaris_penanggung_jawab->setField("INVENTARIS_RUANGAN_ID", ValToNullDB($inventaris_ruangan->id));
			$inventaris_penanggung_jawab->setField("PEGAWAI_ID", ValToNullDB($reqPenanggungJawab));
			$inventaris_penanggung_jawab->setField("LOKASI_ID", $reqId);
			$inventaris_penanggung_jawab->setField("TMT", dateToDBCheck($reqPerolehan));
			$inventaris_penanggung_jawab->insert();
			unset($inventaris_penanggung_jawab);	
			
			$inventaris_lokasi_histori = new InventarisLokasiHistori();
			$inventaris_lokasi_histori->setField("INVENTARIS_RUANGAN_ID", $inventaris_ruangan->id);
			$inventaris_lokasi_histori->setField("LAST_CREATE_USER", $userLogin->nama);
			$inventaris_lokasi_histori->setField("TMT", dateToDBCheck($req));
			$inventaris_lokasi_histori->insertLokasi();
			unset($inventaris_lokasi_histori);	
				   
		}
		unset($inventaris_ruangan);
								
	}
}

$inventaris->selectByParamsPengendalian(array("A.INVENTARIS_ID" => $reqInventaris));
$inventaris->firstRow();

echo $reqInventaris."-Data berhasil disimpan.";

?>