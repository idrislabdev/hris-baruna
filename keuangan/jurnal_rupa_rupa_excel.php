<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqNoBukti = httpFilterGet("reqNoBukti");
$reqId = httpFilterGet("reqId");
$reqPejabat = httpFilterGet("reqPejabat");
$reqParam1 = httpFilterGet("reqParam1");
$reqParam2 = httpFilterGet("reqParam2");

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
$file_name	= "JURNAL_RUPA_RUPA";
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

$arrReqId = explode(",", $reqNoBukti);
if(count($arrReqId) > 1)
{
	
	for($i=0;$i<count($arrReqId);$i++)
	{
		if($i > 0)
			$statement .= " , ";	
			
		$statement .= "'".$arrReqId[$i]."'";
	}
	
}
else
	$statement = "'".$reqNoBukti."'";
	

if(count($arrReqId) > 1)
{
	
	for($i=0;$i<count($arrReqId);$i++)
	{
		if($i > 0)
			$statement1 .= "_";	
			
		$statement1 .= "".$arrReqId[$i]."";
	}
	
}
else
	$statement1 = "".$reqNoBukti."";

$arrReqPejabat = explode("-", $reqPejabat);
$pejabat = $arrReqPejabat[0];
$jabatan = $arrReqPejabat[1];

//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------
$zz = $creport->ParameterFields(1)->SetCurrentValue($statement);
$zz = $creport->ParameterFields(2)->SetCurrentValue($pejabat);
$zz = $creport->ParameterFields(3)->SetCurrentValue($jabatan);
$zz = $creport->ParameterFields(4)->SetCurrentValue($reqParam1);
$zz = $creport->ParameterFields(5)->SetCurrentValue($reqParam2);


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

$name = $file_name."_".$statement1.".xls";

$len = filesize("$my_pdf");
header("Content-type: application/xls");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=$name");
readfile("$my_pdf"); 

?> 