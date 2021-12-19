<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiKondisiPegawai.php");


include "../WEB-INF/lib/excel/excel_reader2.php";

$reqPeriode 	= httpFilterPost("reqPeriode");

$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

$baris = $data->rowcount($sheet_index=0);

// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{	
	$reqPegawaiId				= $data->val($i, 1);
	$reqNama 					= $data->val($i, 2);
	$reqJabatan 				= $data->val($i, 3);
	$reqGajiKondisiId 			= $data->val($i, 4);
	$reqJumlah 					= $data->val($i, 5);
	
	$gaji_kondisi_pegawai_delete 	= new GajiKondisiPegawai();
	$gaji_kondisi_pegawai_delete->setField("PERIODE", coalesce($reqPeriode, '0'));
	$gaji_kondisi_pegawai_delete->setField("GAJI_KONDISI_ID", $reqGajiKondisiId);
	$gaji_kondisi_pegawai_delete->setField("PEGAWAI_ID", $reqPegawaiId);
	$gaji_kondisi_pegawai_delete->deletePeriode();

// echo "ads".$reqPegawaiId;exit;
	$gaji_kondisi_pegawai 	= new GajiKondisiPegawai();
	
	$gaji_kondisi_pegawai->setField("PEGAWAI_ID", $reqPegawaiId);
	$gaji_kondisi_pegawai->setField("PERIODE", $reqPeriode);
	$gaji_kondisi_pegawai->setField("GAJI_KONDISI_ID", coalesce($reqGajiKondisiId, '0'));
	$gaji_kondisi_pegawai->setField("JUMLAH", coalesce($reqJumlah, '0'));
	
	if($reqPegawaiId == "")
	{}
	else
	{	
		$gaji_kondisi_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
		$gaji_kondisi_pegawai->setField("LAST_CREATE_DATE", "SYSDATE");
		$gaji_kondisi_pegawai->import();
	}
	unset($gaji_kondisi_pegawai);
}

echo "Data berhasil di import.";
?>