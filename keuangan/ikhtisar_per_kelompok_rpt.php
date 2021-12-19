<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");


$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqValuta = httpFilterGet("reqValuta");
$reqPejabatKiri = httpFilterGet("reqPejabatKiri");
$reqPejabatTengah = httpFilterGet("reqPejabatTengah");
$reqPejabatKanan = httpFilterGet("reqPejabatKanan");

//------ PATH REPORT -------
$xml_file = "../WEB-INF-SIUK/web.xml"; 
$data_xml = simplexml_load_file($xml_file);
$data_xml_user=3;
$data_xml_pass=4;
$data_xml_path=5;
$data_xml_connection=6;
$user = trim($data_xml->path->path->configValue->$data_xml_user);
$pass = trim($data_xml->path->path->configValue->$data_xml_pass);
$path = $data_xml->path->path->configValue->$data_xml_path;
$connection = trim($data_xml->path->path->configValue->$data_xml_connection); 
  
//------  Variables ------
$file_name	= "IKHTISAR_PER_KELOMPOK";
$my_report	= $path.$file_name.".rpt";
$my_pdf		= $path.$file_name.".pdf";

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

//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------
$bulan = substr($reqPeriode, 0, 2);
$tahun = substr($reqPeriode, 2, 4);

$periode = $tahun.$bulan;

$zz = $creport->ParameterFields(1)->SetCurrentValue($reqPejabatKiri);
$zz = $creport->ParameterFields(2)->SetCurrentValue($reqPejabatTengah);
$zz = $creport->ParameterFields(3)->SetCurrentValue($reqPejabatKanan);
$zz = $creport->ParameterFields(4)->SetCurrentValue($bulan);
$zz = $creport->ParameterFields(5)->SetCurrentValue($tahun);
$zz = $creport->ParameterFields(6)->SetCurrentValue($reqValuta);
$zz = $creport->ParameterFields(7)->SetCurrentValue($periode);

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