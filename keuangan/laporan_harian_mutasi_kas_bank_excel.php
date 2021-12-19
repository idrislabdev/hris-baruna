<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqMengetahui = httpFilterGet("reqMengetahui");
$reqPeriode = httpFilterGet("reqPeriode");
$reqTanggal = httpFilterGet("reqTanggal");

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

//------  Variables ------
$file_name	= "LAPORAN_HARIAN_MUTASI_KAS_BANK";
$my_report	= $path.$file_name.".rpt";
$my_pdf		= $path.$file_name.".xls";


//------ Create a new COM Object of Crytal Reports XI ------
$ObjectFactory= new COM("CrystalRuntime.Application.11");

//------ Create a instance of library Application -------
//$crapp=$ObjectFactory->CreateObject("CrystalDesignRunTime.Application.11");

//------ Open your rpt file ------
$creport = $ObjectFactory->OpenReport($my_report, 1);

//- Set database logon info - must have
$creport->Database->Tables(1)->SetLogOnInfo($connection, $connection, $user, $pass);


//------ Connect to Oracle 9i DataBase ------
//$crapp->LogOnServer('crdb_oracle.dll','YOUR_TNS','YOUR_TABLE','YOUR_LOGIN','YOUR_PASSWORD');

//------ Put the values that you want --------
//if($reqId == "")

$reqTanggalParse = str_replace("-", "", $reqTanggal);

/*if($reqPeriode == "tanggal")
	$statement = "{LAPORAN_MUTASI_HARIAN_1.TGL_POSTING_CHAR}='".$reqTanggalParse."' ";
else
	$statement = 'MID({LAPORAN_MUTASI_HARIAN_1.TGL_POSTING_CHAR}, 3, 6)=MID("'.$reqTanggalParse.'", 3, 6) ';*/	

$statement = "{LAPORAN_MUTASI_HARIAN_1.TGL_POSTING_CHAR}='".$reqTanggalParse."' ";

$creport->RecordSelectionFormula=$statement;

$arrMengetahui = explode("-", $reqMengetahui);

$Pejabat = $arrMengetahui[0];
$Jabatan = $arrMengetahui[1];

//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------
/*if($reqPeriode == "tanggal")
	$zz = $creport->ParameterFields(1)->SetCurrentValue($reqTanggal);
else
	$zz = $creport->ParameterFields(1)->SetCurrentValue(strtoupper(getNamePeriode(substr($reqTanggalParse, 2, 6))));*/

$zz = $creport->ParameterFields(1)->SetCurrentValue($reqTanggal);
$zz = $creport->ParameterFields(2)->SetCurrentValue($Pejabat);
$zz = $creport->ParameterFields(3)->SetCurrentValue($Jabatan);


$creport->ReadRecords();
//------ Export to PDF -------
$creport->ExportOptions->DiskFileName=$my_pdf;
$creport->ExportOptions->FormatType=29;
$creport->ExportOptions->DestinationType=1;
$creport->Export(false);

//------ Release the variables
$creport = null;
$crapp = null;
$ObjectFactory = null;

$name = $file_name."_".$reqTanggalParse.".xls";

$len = filesize("$my_pdf");
header("Content-type: application/xls");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=$name");
readfile("$my_pdf"); 

?> 