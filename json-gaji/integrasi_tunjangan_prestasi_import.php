<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/IntegrasiTunjanganPrestasi.php");


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
	$reqDepartemen 				= $data->val($i, 4);
	$reqJumlahJamMengajar 		= $data->val($i, 5);
	$reqJumlahPotongan 			= $data->val($i, 6);
	// $reqJumlahJamLebih 			= $data->val($i, 5);
	// $reqTarifMengajar 			= $data->val($i, 6);
	// $reqTarifLebih 				= $data->val($i, 7);
	
// echo "ads".$reqPegawaiId;exit;
	$integrasi_tunjangan_prestasi 	= new IntegrasiTunjanganPrestasi();
	$integrasi_tunjangan_prestasi_delete 	= new IntegrasiTunjanganPrestasi();
	
	$integrasi_tunjangan_prestasi->setField("PEGAWAI_ID", $reqPegawaiId);
	$integrasi_tunjangan_prestasi->setField("PERIODE", $reqPeriode);
	$integrasi_tunjangan_prestasi->setField("JUMLAH_JAM_MENGAJAR", coalesce($reqJumlahJamMengajar, '0'));
	$integrasi_tunjangan_prestasi->setField("JUMLAH_POTONGAN", coalesce($reqJumlahPotongan, '0'));

	$integrasi_tunjangan_prestasi_delete->setField("PEGAWAI_ID", $reqPegawaiId);
	$integrasi_tunjangan_prestasi_delete->setField("PERIODE", $reqPeriode);

	// $integrasi_tunjangan_prestasi->setField("JUMLAH_JAM_LEBIH", coalesce($reqJumlahJamLebih, '0'));
	// $integrasi_tunjangan_prestasi->setField("TARIF_MENGAJAR", coalesce($reqTarifMengajar, '0'));
	// $integrasi_tunjangan_prestasi->setField("TARIF_LEBIH", coalesce($reqTarifLebih, '0'));
	
	if($reqPegawaiId == "")
	{}
	else
	{	
		$integrasi_tunjangan_prestasi->setField("LAST_CREATE_USER", $userLogin->nama);
		$integrasi_tunjangan_prestasi->setField("LAST_CREATE_DATE", "SYSDATE");

		$integrasi_tunjangan_prestasi_delete->delete();
		$integrasi_tunjangan_prestasi->import();
	}
	unset($integrasi_tunjangan_prestasi);
}

echo "Data berhasil di import.";
?>