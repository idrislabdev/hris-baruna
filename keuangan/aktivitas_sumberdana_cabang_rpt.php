<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");
$reqCabang = httpFilterGet("reqCabang");
// echo $reqCabang;exit();
$reqHalaman = httpFilterGet("reqHalaman");

//------ PATH REPORT -------
$xml_file = "../WEB-INF-SIUK/web.xml"; 
$data_xml = simplexml_load_file($xml_file);
$data_xml_user=3;
$data_xml_pass=4;
$data_xml_path=5;
$data_xml_connection=6;
$path = $data_xml->path->path->configValue->$data_xml_path;
$connection = trim($data_xml->path->path->configValue->$data_xml_connection); 
$user = trim($data_xml->path->path->configValue->$data_xml_user);
$pass = trim($data_xml->path->path->configValue->$data_xml_pass); 


$bulan = substr($reqPeriode, 0, 2);
$tahun = substr($reqPeriode, 2, 4);

if((int)$bulan < 10)
	$bulan = str_replace("0", "", $bulan);

$bulanint = (int)$bulan;
$tahunint = (int)$tahun;

if ($bulanint <=12) 
{
$akhirbulan = cal_days_in_month(CAL_GREGORIAN, $bulanint, $tahunint);
$tanggal = strtoupper(getNamePeriodeKeu($reqPeriode));
}
else
$tanggal = "30 JUNI AUDIT ".$tahun;

if((int)$bulan < 10)
	$bulan = str_replace("0", "", $bulan);

if ($reqCabang == "SD Barunawati Semarang") 
{
//------  Variables ------
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_SD_SEMARANG";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}	
elseif ($reqCabang == "SD Barunawati Banjarmasin") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_SD_BANJARMASIN";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}	
elseif ($reqCabang == "SD Barunawati Surabaya") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_SD_SURABAYA";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}	
elseif ($reqCabang == "SMA Barunawati Surabaya") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_SMA_SURABAYA";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "SMK Barunawati Surabaya") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_SMK_SURABAYA";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "SMP Barunawati Semarang") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_SMP_BANJARMASIN";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "SMP Barunawati Surabaya") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_SMP_SURABAYA";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "STIAMAK Barunawati Surabaya") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_STIAMAK_SURABAYA";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "TK Barunawati Badas") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_TK_BADAS";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "TK Barunawati Benoa") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_TK_BENOA";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "TK Barunawati Cilacap") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_TK_CILACAP";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "TK Barunawati Kota Baru") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_TK_KOTABARU";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "TK Barunawati Kupang") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_TK_KUPANG";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "TK Barunawati Lembar") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_TK_LEMBAR";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "TK Barunawati Probolinggo 1") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_TK_PROBOLINGGO_1";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "TK Barunawati Probolinggo 2") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_TK_PROBOLINGGO_2";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "TK Barunawati Pulang Pisau") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_TK_PULANG_PISAU";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
elseif ($reqCabang == "TK Barunawati Semarang") 
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_TK_SEMARANG";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}
	
// elseif ($reqCabang == "TK Barunawati Surabaya") 
// {
// 	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG_TK_SURABAYA";
// 	$my_report	= $path.$file_name.".rpt";
// 	$my_pdf		= $path.$file_name.".pdf";

// 	//------ Create a new COM Object of Crytal Reports XI ------
// 	$ObjectFactory= new COM("CrystalRuntime.Application.11");

// 	$creport = $ObjectFactory->OpenReport($my_report, 1);

// 	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
// 	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
// 	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
// 	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
// 	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
// }
	
else
{
	$file_name	= "AKTIVITAS_PER_JENIS_SUMBERDANA_CABANG";
	$my_report	= $path.$file_name.".rpt";
	$my_pdf		= $path.$file_name.".pdf";

	//------ Create a new COM Object of Crytal Reports XI ------
	$ObjectFactory= new COM("CrystalRuntime.Application.11");

	$creport = $ObjectFactory->OpenReport($my_report, 1);

	$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
	$zz = $creport->ParameterFields(2)->SetCurrentValue((int)$reqHalaman);
	$zz = $creport->ParameterFields(3)->SetCurrentValue($bulan);
	$zz = $creport->ParameterFields(4)->SetCurrentValue($tahun);
	$zz = $creport->ParameterFields(5)->SetCurrentValue($reqCabang);
}

//------ Create a instance of library Application -------
//$crapp=$ObjectFactory->CreateObject("CrystalDesignRunTime.Application.11");

//------ Open your rpt file ------


//- Set database logon info - must have


//------ Connect to Oracle 9i DataBase ------
//$crapp->LogOnServer('crdb_oracle.dll','YOUR_TNS','YOUR_TABLE','YOUR_LOGIN','YOUR_PASSWORD');

//------ Put the values that you want --------
//if($reqId == "")
//$creport->RecordSelectionFormula="{REKAP_THR_REPORT.PERIODE}='".$reqPeriode."'";

//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------





$creport->Database->Tables(1)->SetLogOnInfo($connection, $connection, $user, $pass);
$creport->ReadRecords();
//------ Export to PDF -------
$creport->ExportOptions->DiskFileName=$my_pdf;
$creport->ExportOptions->FormatType=31;
$creport->ExportOptions->DestinationType=1;
$creport->Export(false);

//------ Release the variables
$creport = null;
$crapp = null;
$ObjectFactory = null;

$name = $file_name."_".$reqPeriode.".pdf";

$len = filesize("$my_pdf");
header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=$name");
readfile("$my_pdf"); 
?> 