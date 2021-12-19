<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");
$reqPejabatKiri = httpFilterGet("reqPejabatKiri");
$reqPejabatKanan = httpFilterGet("reqPejabatKanan");


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
$file_name	= "REKAP_KELOM_PASIF_RUPIAH";
$my_report 	= $path.$file_name.".rpt";
$my_pdf 	= $path.$file_name.".pdf";

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
//$creport->RecordSelectionFormula="{BANTUAN_PENDIDIKAN_REPORT.PERIODE}='".$reqPeriode."'".$statement;

//$creport->RecordSelectionFormula="{BANTUAN_PENDIDIKAN_REPORT.PERIODE}='".$reqPeriode."'";

//else
//$creport->RecordSelectionFormula="({BANTUAN_PENDIDIKAN_REPORT.THN_BUKU} = 2013 AND BLN_BUKU = '09' OR THN_BUKU IS NULL)";

//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------
//$zz = $creport->ParameterFields(1)->SetCurrentValue("2013");
//$zz = $creport->ParameterFields(2)->SetCurrentValue("SURABAYA, ".strtoupper(getNamePeriode($reqPeriode)));

$bulan = substr($reqPeriode, 0, 2);
$tahun = substr($reqPeriode, 2, 4);

$periode = $tahun.$bulan;

$zz = $creport->ParameterFields(1)->SetCurrentValue($reqPejabatKiri);
$zz = $creport->ParameterFields(2)->SetCurrentValue($reqPejabatKanan);
$zz = $creport->ParameterFields(3)->SetCurrentValue($periode);
$zz = $creport->ParameterFields(4)->SetCurrentValue($bulan);
$zz = $creport->ParameterFields(5)->SetCurrentValue($tahun);


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