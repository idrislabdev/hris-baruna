<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqTanggal = httpFilterGet("reqTanggal");
$reqKodeValuta = httpFilterGet("reqKodeValuta");
$reqBadanUsaha = httpFilterGet("reqBadanUsaha");

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
$file_name	= "REKAP_KELOMPOK_HARI";
$my_report	= $path.$file_name.".rpt";
$my_xls		= $path.$file_name.".xls";

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

/*$arrJenisPegawaiId = explode(",", $reqJenisPegawaiId);
if(count($arrJenisPegawaiId) > 1)
{
	$statement = " AND ( ";
	
	for($i=0;$i<count($arrJenisPegawaiId);$i++)
	{
		if($i > 0)
			$statement .= " OR ";	
			
		$statement .= "{REKAP_THR_REPORT.JENIS_PEGAWAI_ID}=".$arrJenisPegawaiId[$i];
	}
	
	$statement .= " ) ";
}
else
	$statement = " AND {REKAP_THR_REPORT.JENIS_PEGAWAI_ID}= ".$reqJenisPegawaiId;*/
	
//$creport->RecordSelectionFormula="{REKAP_THR_REPORT.PERIODE}='".$reqPeriode."'";

//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------

$arrTanggal = explode("-", $reqTanggal);

$periode = $arrTanggal[2].$arrTanggal[1];

if($reqBadanUsaha == "")
{
	$statement .= " AND 1=1 ";
}
else
{
	$statement .= " AND BADAN_USAHA LIKE '%".$reqBadanUsaha."' ";
}

$zz = $creport->ParameterFields(1)->SetCurrentValue($reqKodeValuta);
$zz = $creport->ParameterFields(2)->SetCurrentValue($statement);
$zz = $creport->ParameterFields(3)->SetCurrentValue($periode);
$zz = $creport->ParameterFields(4)->SetCurrentValue($reqTanggal);

$creport->ReadRecords();
//------ Export to PDF -------
$creport->ExportOptions->DiskFileName=$my_xls;
$creport->ExportOptions->FormatType=29;
$creport->ExportOptions->DestinationType=1;
$creport->Export(false);

//------ Release the variables
$creport = null;
$crapp = null;
$ObjectFactory = null;

$name = $file_name."_".$reqTanggal.".xls";

$len = filesize("$my_xls");
header("Content-type: application/xls");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=$name");
readfile("$my_xls"); 
?> 