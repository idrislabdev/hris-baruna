<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Invoice.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$invoice = new Invoice();
$inventaris_ruangan = new InventarisRuangan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqInvoiceNo = httpFilterPost("reqInvoiceNo");
$reqNama= httpFilterPost("reqNama");
$reqTanggal= httpFilterPost("reqTanggal");

$reqInventaris = $_POST["reqInventaris"];
$reqUnit = $_POST["reqUnit"];
$reqHarga = $_POST["reqHarga"];
$reqLokasi = $_POST["reqLokasi"];

$invoice->setField("NAMA", $reqNama);
$invoice->setField("INVOICE_NO", $reqInvoiceNo);
$invoice->setField("TANGGAL", dateToDBCheck($reqTanggal));
	
if($reqMode == "insert")
{	
	if($invoice->insert())
	{
		$id = $invoice->id;
		for($i=0;$i<count($reqInventaris);$i++)
		{
			if($reqLokasi[$i] == 0)
			{
				
				for($j=1;$j<=$reqUnit[$i];$j++)
				{
					$inventaris_ruangan = new InventarisRuangan();
					$tanggal_perolehan = dateToDB($reqTanggal);
					$inventaris_ruangan->setField("INVENTARIS_ID", ValToNullDB($reqInventaris[$i]));
					$inventaris_ruangan->setField("LOKASI_ID", "");
					$inventaris_ruangan->setField("KONDISI_FISIK_ID", "1");
					$inventaris_ruangan->setField("NOMOR", "NULL");
					$inventaris_ruangan->setField("PEROLEHAN_TANGGAL", dateToDBCheck($reqTanggal));
					$inventaris_ruangan->setField("PEROLEHAN_PERIODE", getMonth($tanggal_perolehan).getYear($tanggal_perolehan));
					$inventaris_ruangan->setField("PEROLEHAN_TAHUN", getYear($tanggal_perolehan));
					$inventaris_ruangan->setField("PEROLEHAN_HARGA", ValToNullDB(dotToNo($reqHarga[$i])));
					$inventaris_ruangan->setField("PENYUSUTAN", 0);
					$inventaris_ruangan->setField("NILAI_BUKU", ValToNullDB(dotToNo($reqHarga[$i])));
					$inventaris_ruangan->setField("KETERANGAN", "");
					$inventaris_ruangan->setField("BARCODE", "NULL");
					$inventaris_ruangan->setField("STATUS_HAPUS", 0);
					$inventaris_ruangan->setField("NO_URUT", $j);
					$inventaris_ruangan->setField("KONDISI_FISIK_PROSENTASE", 100);
					$inventaris_ruangan->setField("NO_INVOICE", $reqInvoiceNo);
					$inventaris_ruangan->setField("INVOICE_ID", $id);
					$inventaris_ruangan->setField("LAST_CREATE_USER", $userLogin->nama);
					$inventaris_ruangan->insert();
					unset($inventaris_ruangan);	
				}
			}
		}
	}
	//echo $invoice->query;
}
else
{
	$invoice->setField("INVOICE_ID", $reqId);
	
	if($invoice->update())
	{
		$id = $reqId;
		
		$inventaris_ruangan = new InventarisRuangan();
		$inventaris_ruangan->setField("INVENTARIS_ID",ValToNullDB($reqInventaris[$i]));
		$inventaris_ruangan->setField("INVOICE_ID",$reqId);
		$inventaris_ruangan->deleteByInvoiceInventaris();

		unset($inventaris_ruangan);
		for($i=0;$i<count($reqInventaris);$i++)
		{
			if($reqLokasi[$i] == 0)
			{
				for($j=1;$j<=$reqUnit[$i];$j++)
				{
					
					$inventaris_ruangan = new InventarisRuangan();
					$tanggal_perolehan = dateToDB($reqTanggal);
					$inventaris_ruangan->setField("INVENTARIS_ID", ValToNullDB($reqInventaris[$i]));
					$inventaris_ruangan->setField("LOKASI_ID", "");
					$inventaris_ruangan->setField("KONDISI_FISIK_ID", "1");
					$inventaris_ruangan->setField("NOMOR", "NULL");
					$inventaris_ruangan->setField("PEROLEHAN_TANGGAL", dateToDBCheck($reqTanggal));
					$inventaris_ruangan->setField("PEROLEHAN_PERIODE", getMonth($tanggal_perolehan).getYear($tanggal_perolehan));
					$inventaris_ruangan->setField("PEROLEHAN_TAHUN", getYear($tanggal_perolehan));
					$inventaris_ruangan->setField("PEROLEHAN_HARGA", ValToNullDB(dotToNo($reqHarga[$i])));
					$inventaris_ruangan->setField("PENYUSUTAN", 0);
					$inventaris_ruangan->setField("NILAI_BUKU", ValToNullDB(dotToNo($reqHarga[$i])));
					$inventaris_ruangan->setField("KETERANGAN", "");
					$inventaris_ruangan->setField("BARCODE", "NULL");
					$inventaris_ruangan->setField("STATUS_HAPUS", 0);
					$inventaris_ruangan->setField("NO_URUT", $j);
					$inventaris_ruangan->setField("KONDISI_FISIK_PROSENTASE", 100);
					$inventaris_ruangan->setField("NO_INVOICE", $reqInvoiceNo);
					$inventaris_ruangan->setField("INVOICE_ID", $id);
					$inventaris_ruangan->setField("LAST_CREATE_USER", $userLogin->nama);
					$inventaris_ruangan->insert();
					unset($inventaris_ruangan);	
				}
			}
		}
	}	
}
echo $id."-Data berhasil disimpan.";
?>