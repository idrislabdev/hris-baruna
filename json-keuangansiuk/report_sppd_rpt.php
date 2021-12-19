<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");
$reqJenis = httpFilterGet("reqJenis");

//------ PATH REPORT -------
$xml_file = "../WEB-INF/web.xml"; 
$data_xml = simplexml_load_file($xml_file);
$data_xml_path=5;
$data_xml_connection=6;
$path = $data_xml->path->path->configValue->$data_xml_path;
$connection = trim($data_xml->path->path->configValue->$data_xml_connection); 

//------  Variables ------
if ($reqJenis=="BARU")
{
$my_report	= $path."sppd\\REPORT_SPPD_DETASERING.rpt";
$my_pdf		= $path."sppd\\REPORT_SPPD_DETASERING.pdf";
}
else
{
$my_report	= $path."sppd\\REPORT_SPPD.rpt";
$my_pdf		= $path."sppd\\REPORT_SPPD.pdf";
}

//------ Create a new COM Object of Crytal Reports XI ------
$ObjectFactory= new COM("CrystalRuntime.Application.11");

//------ Create a instance of library Application -------
//$crapp=$ObjectFactory->CreateObject("CrystalDesignRunTime.Application.11");

//------ Open your rpt file ------
$creport = $ObjectFactory->OpenReport($my_report, 1);

//- Set database logon info - must have
//$creport->Database->Tables(1)->SetLogOnInfo("ORCL_LOCAL", "ORCL_LOCAL", "IMASYS", "imasys");

$creport->Database->Tables(1)->SetLogOnInfo($connection, $connection, "IMASYS", "imasys");

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
	

/*$bulan = substr($reqPeriode, 0, 2);
$tahun = substr($reqPeriode, 2, 4);

$bulanint = (int)$bulan;
$tahunint = (int)$tahun;

$akhirbulan = cal_days_in_month(CAL_GREGORIAN, $bulanint, $tahunint);*/

//$tanggal = $akhirbulan." ".strtoupper(getNamePeriode($reqPeriode));

/*if($bulanint < 10)
	$bulan = str_replace("0", "", $bulan);
	
$tanggal = (string)$akhirbulan;*/
//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------
/*$zz = $creport->ParameterFields(1)->SetCurrentValue($reqPeriode);
$zz = $creport->ParameterFields(2)->SetCurrentValue(strtoupper($reqNama2));
$zz = $creport->ParameterFields(3)->SetCurrentValue(strtoupper($reqJabatan2));
$zz = $creport->ParameterFields(4)->SetCurrentValue(strtoupper($reqNama1));
$zz = $creport->ParameterFields(5)->SetCurrentValue(strtoupper($reqJabatan1));*/

$zz = $creport->ParameterFields(1)->SetCurrentValue(strtoupper($reqNama1));
$zz = $creport->ParameterFields(2)->SetCurrentValue(strtoupper($reqJabatan1));
$zz = $creport->ParameterFields(3)->SetCurrentValue(strtoupper($reqNama2));
$zz = $creport->ParameterFields(4)->SetCurrentValue(strtoupper($reqJabatan2));
$zz = $creport->ParameterFields(5)->SetCurrentValue((int)$reqId);


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