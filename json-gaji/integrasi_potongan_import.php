<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/IntegrasiPotongan.php");


include "../WEB-INF/lib/excel/excel_reader2.php";

$reqPeriode 	= httpFilterPost("reqPeriode");

$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

$baris = $data->rowcount($sheet_index=0);


$integrasi_potongan_delete 	= new IntegrasiPotongan();


// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{	
	$reqPegawaiId				= $data->val($i, 1);
	$reqNama 					= $data->val($i, 2);
	$reqJabatan 				= $data->val($i, 3);
	$reqPotonganKondisiId 		= $data->val($i, 4);
	$reqJumlah		 			= $data->val($i, 5);
	$reqTarifMengajar 			= $data->val($i, 6);
	$reqTarifLebih 				= $data->val($i, 7);
	
// echo "ads".$reqPegawaiId;exit;
	$integrasi_potongan 	= new IntegrasiPotongan();
	
	$integrasi_potongan->setField("PEGAWAI_ID", $reqPegawaiId);
	$integrasi_potongan->setField("PERIODE", $reqPeriode);
	$integrasi_potongan->setField("POTONGAN_KONDISI_ID", $reqPotonganKondisiId);
	$integrasi_potongan->setField("JUMLAH", coalesce(ValToNo($reqJumlah), '0'));

	$integrasi_potongan_delete->setField("PEGAWAI_ID", $reqPegawaiId);
	$integrasi_potongan_delete->setField("PERIODE", $reqPeriode);

	if($reqPegawaiId == "" || $reqPotonganKondisiId == "")
	{}
	else
	{	
		$integrasi_potongan->setField("LAST_CREATE_USER", $userLogin->nama);
		$integrasi_potongan->setField("LAST_CREATE_DATE", "SYSDATE");

		$integrasi_potongan_delete->delete();
		$integrasi_potongan->import();
	}
	unset($integrasi_potongan);
}

echo "Data berhasil di import.";
?>