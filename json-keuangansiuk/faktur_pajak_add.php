<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajak.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajakD.php");


$no_faktur_pajak = new NoFakturPajak();

$reqId 		   		 = httpFilterPost("reqId");
$reqMode 	   		 = httpFilterPost("reqMode");
$reqNomorSurat 		 = httpFilterPost("reqNomorSurat");
$reqTanggal    		 = httpFilterPost("reqTanggal"); 
$reqNomorFakturAwal  = httpFilterPost("reqNomorFakturAwal");
$reqNomorFakturAkhir = httpFilterPost("reqNomorFakturAkhir");
$reqLinkFile = $_FILES["reqLinkFile"];


$no_faktur_pajak->setField('NOMOR_SURAT', $reqNomorSurat);
$no_faktur_pajak->setField('TANGGAL', dateToDBCheck($reqTanggal)); 
$no_faktur_pajak->setField('NOMOR_FAKTUR_AWAL', $reqNomorFakturAwal);
$no_faktur_pajak->setField('NOMOR_FAKTUR_AKHIR', $reqNomorFakturAkhir); 

if($reqMode == "insert")
{
	
	if($no_faktur_pajak->insert())
	{	
	
		if($reqLinkFile['tmp_name'])
		{
			$no_faktur_pajak->upload("PERPAJAKAN.NO_FAKTUR_PAJAK", "FILE_UPLOAD", $reqLinkFile['tmp_name'], "NO_FAKTUR_PAJAK_ID = ".$no_faktur_pajak->id);			
			$no_faktur_pajak->setField("FILE_FORMAT", $reqLinkFile['type']);
			$no_faktur_pajak->setField("NO_FAKTUR_PAJAK_ID", $no_faktur_pajak->id);
			$no_faktur_pajak->updateFileFormat();			
		}
	
		$reqId = $no_faktur_pajak->id;
		$reqDigitFix = substr($reqNomorFakturAwal, 0, 12);
		$reqDigitAwal = (int)substr($reqNomorFakturAwal, 12, 3);
		$reqDigitAkhir = (int)substr($reqNomorFakturAkhir, 12, 3);	
		
		for ($i=$reqDigitAwal; $i<=$reqDigitAkhir; $i++)
		{
			$no_faktur_pajak_d = new NoFakturPajakD();
			$no_faktur_pajak_d->setField("NOMOR", $reqDigitFix.generateZero($i,3,"0"));
			$no_faktur_pajak_d->setField("NO_FAKTUR_PAJAK_ID", $reqId);
			$no_faktur_pajak_d->setField("STATUS", 0);
			$no_faktur_pajak_d->insert();
			unset($no_faktur_pajak_d);
		}
		echo "Data berhasil disimpan.";
		
	} 
	else
	{
		echo "Data gagal disimpan.";		
	}

	//echo "Data berhasil disimpan.";
	
}
else
{
	$no_faktur_pajak->setField('NO_FAKTUR_PAJAK_ID', $reqId);
	$no_faktur_pajak->setField('NOMOR_SURAT', $reqNomorSurat);
	$no_faktur_pajak->setField('TANGGAL', dateToDBCheck($reqTanggal)); 
	$no_faktur_pajak->setField('NOMOR_FAKTUR_AWAL', $reqNomorFakturAwal);
	$no_faktur_pajak->setField('NOMOR_FAKTUR_AKHIR', $reqNomorFakturAkhir); 	
	if($no_faktur_pajak->update())
	{	
	
		if($reqLinkFile['tmp_name'])
		{
			$no_faktur_pajak->upload("PERPAJAKAN.NO_FAKTUR_PAJAK", "FILE_UPLOAD", $reqLinkFile['tmp_name'], "NO_FAKTUR_PAJAK_ID = ".$reqId);			
			$no_faktur_pajak->setField("FILE_FORMAT", $reqLinkFile['type']);
			$no_faktur_pajak->setField("NO_FAKTUR_PAJAK_ID", $reqId);
			$no_faktur_pajak->updateFileFormat();			
		}
			
		$set= new NoFakturPajakD();
		$set->setField("NO_FAKTUR_PAJAK_ID", $reqId);
		$set->delete();
		unset($set);

		$reqDigitFix = substr($reqNomorFakturAwal, 0, 11);
		$reqDigitAwal = substr($reqNomorFakturAwal, 11, 4);
		$reqDigitAkhir = substr($reqNomorFakturAkhir, 11, 4);	
		for ($i=$reqDigitAwal; $i<=$reqDigitAkhir; $i++)
		{
			$no_faktur_pajak_d = new NoFakturPajakD();
			$no_faktur_pajak_d->setField("NOMOR", $reqDigitFix.generateZero($i,3,"0"));
			$no_faktur_pajak_d->setField("NO_FAKTUR_PAJAK_ID", $reqId);
			$no_faktur_pajak_d->setField("STATUS", 0);
			$no_faktur_pajak_d->insert();
			unset($no_faktur_pajak_d);
		}
		echo "Data berhasil disimpan.";
	}
	//echo $no_faktur_pajak->query;
}
?>