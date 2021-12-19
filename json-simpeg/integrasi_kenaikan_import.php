<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/IntegrasiKenaikan.php");


include "../simpeg/excel/excel_reader2.php";

// $reqTahun 	= httpFilterPost("reqTahun");

$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

$baris = $data->rowcount($sheet_index=0);

// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{	
	$reqNis					= $data->val($i, 1);
	$reqDepartemenId 		= $data->val($i, 2);
	$reqDepartemenKelasId 	= $data->val($i, 3);
	$reqTahun				= $data->val($i, 4);

	$integrasi_kenaikan_delete 	= new IntegrasiKenaikan();
	$integrasi_kenaikan_delete->setField("TAHUN",$reqTahun);
	$integrasi_kenaikan_delete->setField("DEPARTEMEN_ID", $reqDepartemenId);
	$integrasi_kenaikan_delete->setField("DEPARTEMEN_KELAS_ID", $reqreqDepartemenKelasIdPegawaiId);
	$integrasi_kenaikan_delete->setField("NIS", $reqNis);
	$integrasi_kenaikan_delete->deletePeriode();

// echo "ads".$reqPegawaiId;exit;
	$integrasi_kenaikan 	= new IntegrasiKenaikan();
	
	$integrasi_kenaikan->setField("NIS", $reqNis);
	$integrasi_kenaikan->setField("DEPARTEMEN_ID", $reqDepartemenId);
	$integrasi_kenaikan->setField("DEPARTEMEN_KELAS_ID",$reqDepartemenKelasId);
	$integrasi_kenaikan->setField("TAHUN", $reqTahun);
	
	if($reqNis == "")
	{}
	else
	{	
		$integrasi_kenaikan->import();
	}
	unset($integrasi_kenaikan);
}

echo "Data berhasil di import.";
?>