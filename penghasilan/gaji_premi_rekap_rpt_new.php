<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");
$reqNama1 = httpFilterGet("reqNama1");
$reqJabatan1 = httpFilterGet("reqJabatan1");
$reqNama2 = httpFilterGet("reqNama2");
$reqJabatan2 = httpFilterGet("reqJabatan2");

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
$pass = trim($data_xml->path->path->configValue->$data_xml_pass); 

//------  Variables ------
$my_report 	= $path."penghasilan\\report\\REKAPITULASI_PREMI_KAPAL_NEW.rpt";
$my_pdf 	= $path."penghasilan\\report\\REKAPITULASI_PREMI_KAPAL_NEW.pdf";

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
			
		$statement .= "{UANG_TRANSPORT_REPORT.JENIS_PEGAWAI_ID}=".$arrJenisPegawaiId[$i];
	}
	
	$statement .= " ) ";
}
else
	$statement = " AND {UANG_TRANSPORT_REPORT.JENIS_PEGAWAI_ID}= ".$reqJenisPegawaiId;*/

$creport->RecordSelectionFormula="{PREMI_REKAP_REPORT.PERIODE}='".$reqPeriode."'";
//else
//	$creport->RecordSelectionFormula="{DAFTAR_IURAN_JAMSOSTEK.PERIODE}='".$reqPeriode."' AND {DAFTAR_IURAN_JAMSOSTEK.PEGAWAI_ID} = ".$reqId;

//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------
$zz = $creport->ParameterFields(1)->SetCurrentValue(strtoupper(getNamePeriode($reqPeriode)));
$zz = $creport->ParameterFields(2)->SetCurrentValue(strtoupper($reqNama1));
$zz = $creport->ParameterFields(3)->SetCurrentValue(strtoupper($reqNama2));
$zz = $creport->ParameterFields(4)->SetCurrentValue(strtoupper($reqJabatan1));
$zz = $creport->ParameterFields(5)->SetCurrentValue(strtoupper($reqJabatan2));
//$zz = $creport->ParameterFields(2)->SetCurrentValue("SURABAYA, ".strtoupper(getNamePeriode($reqPeriode)));

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


$len = filesize("$my_pdf");
header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=$my_pdf");
readfile("$my_pdf"); 
?> 