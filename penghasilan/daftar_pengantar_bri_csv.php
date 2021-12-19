<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");

require_once "../WEB-INF/lib/excel/class.writecsv.inc.php";

//set_time_limit(3);
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$gaji_awal_bulan = new GajiAwalBulan();

$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");

$arrJenisPegawaiId = explode(",", $reqJenisPegawaiId);
if(count($arrJenisPegawaiId) > 1)
{
	$statement = " AND ( ";
	
	for($i=0;$i<count($arrJenisPegawaiId);$i++)
	{
		if($i > 0)
			$statement .= " OR ";	
			
		$statement .= "JENIS_PEGAWAI_ID=".$arrJenisPegawaiId[$i];
	}
	
	$statement .= " ) ";
}
else
	$statement = " AND JENIS_PEGAWAI_ID= ".$reqJenisPegawaiId;
	
if ($reqJenisPegawaiId == "") $statement = "";

//$statement .= " AND PERIODE = '".$reqPeriode."'";
$statement .= " AND PERIODE = DECODE(JENIS_PEGAWAI_ID,1,TO_CHAR(LAST_DAY(ADD_MONTHS(TO_DATE('".$reqPeriode."','MMYYYY'), -1)), 'MMYYYY'), 3,TO_CHAR(LAST_DAY(ADD_MONTHS(TO_DATE('".$reqPeriode."','MMYYYY'), -1)), 'MMYYYY'),5,TO_CHAR(LAST_DAY(ADD_MONTHS(TO_DATE('".$reqPeriode."','MMYYYY'), -1)), 'MMYYYY'), '".$reqPeriode."') ";
$statement .= " AND BANK = 'BANK BRI'";

$gaji_awal_bulan->selectByParamsDaftarPengantarBankReport(array(), -1, -1, $statement, $reqPeriode, " ORDER BY BANK, NAMA ASC");

if($reqJenisPegawaiId == 1)
	$caption = "PEGAWAI";
elseif($reqJenisPegawaiId == 2)
	$caption = "PEGAWAI";
elseif($reqJenisPegawaiId == 3)
	$caption = "PEGAWAI KONTRAK";
elseif($reqJenisPegawaiId == 5)
	$caption = "PTTKP";
elseif($reqJenisPegawaiId == 6)
	$caption = "DEWAN DIREKSI";
elseif($reqJenisPegawaiId == 7)
	$caption = "DEWAN KOMISARIS";

$row = 5;
$bank = "";
$i=1;

$csv = new CSV();
$csv->addRow(array('NO','NAMA','ACCOUNT','AMOUNT'));

$totalpegawai = 0;
$totaluang = 0;
$checkstring = "";

$gaji_awal_bulan2 = new GajiAwalBulan();

$gaji_awal_bulan2->selectByParamsPengantarBankBNIHeader($statement);

if ($gaji_awal_bulan2->nextRow()) {

$totalpegawai = $gaji_awal_bulan2->getField('TOTAL');
$totaluang = $gaji_awal_bulan2->getField('SUM_GAJI');
$checkstring = md5($gaji_awal_bulan2->getField('TOTAL') . $gaji_awal_bulan2->getField('SUM_GAJI') . $gaji_awal_bulan2->getField('CEK_AKUN'));

}


while($gaji_awal_bulan->nextRow())
{	
	$jumlah_lain_lain=$gaji_awal_bulan->getField('BNI') + $gaji_awal_bulan->getField('BUKOPIN') + $gaji_awal_bulan->getField('BRI') + $gaji_awal_bulan->getField('BTN') + $gaji_awal_bulan->getField('BPD') + $gaji_awal_bulan->getField('SIMPANAN_WAJIB_KOPERASI') + $gaji_awal_bulan->getField('MITRA_KARYA_ANGGOTA') + $gaji_awal_bulan->getField('INFAQ') + $gaji_awal_bulan->getField('KOPERASI') +  $gaji_awal_bulan->getField('POTONGAN_LAIN') +  $gaji_awal_bulan->getField('SIMPANAN_WAJIB_KOPERASI_3LAUT') +  $gaji_awal_bulan->getField('KOPERASI_PMS');
	$jumlah_potongan=$gaji_awal_bulan->getField('IURAN_TASPEN') + $gaji_awal_bulan->getField('DANA_PENSIUN') + $gaji_awal_bulan->getField('IURAN_KESEHATAN') + $gaji_awal_bulan->getField('POTONGAN_PPH21') + $gaji_awal_bulan->getField('SUMBANGAN_MASJID') + $gaji_awal_bulan->getField('ASURANSI_JIWASRAYA') + $gaji_awal_bulan->getField('ARISAN_PERISPINDO') + $gaji_awal_bulan->getField('IURAN_SPPI') + $gaji_awal_bulan->getField('IURAN_PURNA_BAKTI') + $gaji_awal_bulan->getField('POTONGAN_DINAS') + $gaji_awal_bulan->getField('BPJS_PESERTA');
	$jumlah_kotor= $gaji_awal_bulan->getField('MERIT_PMS') + $gaji_awal_bulan->getField('POTONGAN_PPH21') + $gaji_awal_bulan->getField('TUNJANGAN_PERBANTUAN') + $gaji_awal_bulan->getField('TUNJANGAN_JABATAN') + $gaji_awal_bulan->getField('TPP_PMS') + $gaji_awal_bulan->getField('MOBILITAS') + $gaji_awal_bulan->getField('TELEPON') + $gaji_awal_bulan->getField('BBM') + $gaji_awal_bulan->getField('PERUMAHAN');

	if ((($jumlah_kotor - ($jumlah_potongan + $jumlah_lain_lain)) % 1000) == 0) 
	{  
		$total_potongan = 1000;
	}
	else
	{
		$total_potongan = (($jumlah_kotor - ($jumlah_potongan + $jumlah_lain_lain)) % 1000);
	}
	//$pembulatan = 1000 - $total_potongan;
	$pembulatan = 0;
	
	$jumlah_kotor_pembulatan = $jumlah_kotor + $pembulatan;
	$jumlah_diterima= $jumlah_kotor_pembulatan - $jumlah_potongan;
	$jumlah_dibayar= $jumlah_diterima - $jumlah_lain_lain;

	$csv->addRow(array($i, $gaji_awal_bulan->replaceSpecialCharacter($gaji_awal_bulan->getField('NAMA')),$gaji_awal_bulan->getField('REKENING_NO'), $jumlah_dibayar));
	$row++;
	$i++;
}

$csv->addRow(array('COUNT,,',$totalpegawai));
$csv->addRow(array('TOTAL,,',$totaluang));
$csv->addRow(array('CHECK,,',$checkstring));
 
        // export csv as a download
    $filename = 'BRI_' . $reqPeriode;
	$csv->export($filename);

?>