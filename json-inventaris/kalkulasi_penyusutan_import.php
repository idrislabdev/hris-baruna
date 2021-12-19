<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-intervensi/KalkulasiPenyusutan.php");


include "../keuangan/excel/excel_reader2.php";

$reqPeriode 	= httpFilterPost("reqPeriode");

$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

$baris = $data->rowcount($sheet_index=0);


$kalkulasi_penyusutan_delete 	= new KalkulasiPenyusutan();
$kalkulasi_penyusutan_delete->setField("PERIODE", $reqPeriode);
$kalkulasi_penyusutan_delete->deletePeriode();


// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{	
	$reqInventarisRuanganId		= $data->val($i, 1);
	$reqInventarisId 			= $data->val($i, 2);
	$reqJenisInventarsiId		= $data->val($i, 3);
	$reqLokasiId		 		= $data->val($i, 4);
	$reqKode					= $data->val($i, 5);
	$reqNomor		 			= $data->val($i, 6);
	$reqNama					= $data->val($i, 7);
	$reqLokasi					= $data->val($i, 8);
	$reqTanggalPerolehan		= $data->val($i, 9);
	$reqUmurEkonomis			= $data->val($i, 10);
	$reqUmurEkonomisReal		= $data->val($i, 11);
	$reqNilaiPerolehan			= $data->val($i, 12);
	$reqNilaiPenyusutan			= $data->val($i, 13);
	$reqNilaiAkhir				= $data->val($i, 14);
	
// echo "ads".$reqPegawaiId;exit;
	$kalkulasi_penyusutan 	= new KalkulasiPenyusutan();
	
	$kalkulasi_penyusutan->setField("PERIODE", $reqPeriode);
	$kalkulasi_penyusutan->setField("INVENTARIS_RUANGAN_ID", $reqInventarisRuanganId);
	$kalkulasi_penyusutan->setField("INVENTARIS_ID", $reqInventarisId);
	$kalkulasi_penyusutan->setField("JENIS_INVENTARIS_ID", $reqJenisInventarsiId);
	$kalkulasi_penyusutan->setField("LOKASI_ID", $reqLokasiId);
	$kalkulasi_penyusutan->setField("KODE", $reqKode);
	$kalkulasi_penyusutan->setField("NOMOR", $reqNomor);
	$kalkulasi_penyusutan->setField("NAMA", $reqNama);
	$kalkulasi_penyusutan->setField("LOKASI", $reqLokasi);
	$kalkulasi_penyusutan->setField("TANGGAL_PEROLEHAN", $reqTanggalPerolehan);
	$kalkulasi_penyusutan->setField("UMUR_EKONOMIS", $reqUmurEkonomis);
	$kalkulasi_penyusutan->setField("UMUR_EKONOMIS_REAL", $reqUmurEkonomisReal);
	$kalkulasi_penyusutan->setField("NILAI_PEROLEHAN", coalesce($reqNilaiPerolehan, '0'));
	$kalkulasi_penyusutan->setField("NILAI_PENYUSUTAN", coalesce($reqNilaiPenyusutan, '0'));
	$kalkulasi_penyusutan->setField("NILAI_AKHIR", coalesce($reqNilaiAkhir, '0'));	
	$kalkulasi_penyusutan->import();
	unset($kalkulasi_penyusutan);
}

echo "Data berhasil di import.";
?>