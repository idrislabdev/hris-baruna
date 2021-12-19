<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");


$reqId = httpFilterGet("reqId");

//------ PATH REPORT -------
$xml_file = "../WEB-INF/web.xml"; 
$data_xml = simplexml_load_file($xml_file);
$data_xml_user=3;
$data_xml_pass=4;
$data_xml_path=5;
$data_xml_connection=6;
$path = $data_xml->path->path->configValue->$data_xml_path;
$connection = trim($data_xml->path->path->configValue->$data_xml_connection); 
$user = trim($data_xml->path->path->configValue->$data_xml_user);
$pass = trim($data_xml->path->path->configValue->$data_xml_pass); $reqDepartemen 	= httpFilterGet('reqDepartemen');
$reqPeriode 	= httpFilterGet('reqPeriode');
$reqJenis 		= httpFilterGet('reqJenis');

$wherekondisi = " ({V_BONUS_NEW.PERIODE} = ". $reqPeriode ." "; 
if($reqJenis != 'ALL') {
	$wherekondisi .= " AND {V_BONUS_NEW.JENIS_PEGAWAI_ID}= ". $reqJenis ." ";
}
if($reqDepartemen != 'ALL') {
	$wherekondisi .= " AND {V_BONUS_NEW.DEPARTEMEN_ID} LIKE '". $reqDepartemen ."*' ";
}

$wherekondisi .= ") ";
//echo $wherekondisi; exit;

$my_report	= $path."penghasilan\\report\\SLIP_BONUS_NEW.rpt";
$my_pdf		= $path."penghasilan\\report\\SLIP_BONUS_NEW.pdf";



//------ Create a new COM Object of Crytal Reports XI ------
$o_CrObjectFactory = new COM('CrystalReports11.ObjectFactory.1'); 
$ObjectFactory = $o_CrObjectFactory->CreateObject("CrystalRunTime.Application.11");

com_load_typelib('CrystalDesignRunTime.Application');


$creport = $ObjectFactory->OpenReport($my_report, 1);
$creport->Database->Tables(1)->SetLogOnInfo($connection, $connection, $user, $pass);
$creport->RecordSelectionFormula = $wherekondisi;

$creport->ReadRecords();
$creport->ExportOptions->DiskFileName=$my_pdf;
$creport->ExportOptions->FormatType=31;
$creport->ExportOptions->DestinationType=1;
$creport->Export(false);

//------ Release the variables
$creport = null;
$crapp = null;
$ObjectFactory = null;


$len = filesize("$my_pdf");
header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=$my_pdf");
readfile("$my_pdf"); 
?> 