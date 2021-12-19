<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");

$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");
$cuti = new CutiTahunanDetil();
$cuti->selectJenisPegawaiDanLokasi($reqId);
$cuti->firstRow();
$kelompok = $cuti->getField('KELOMPOK');
$luar_kota = $cuti->getField('LUAR_KOTA');
//echo $kelompok. ' ' .$luar_kota; exit;
//------ PATH REPORT -------
$xml_file = "../WEB-INF/web.xml"; 
$data_xml = simplexml_load_file($xml_file);
$data_xml_path=5;
$data_xml_connection=6;
$path = $data_xml->path->path->configValue->$data_xml_path;
$connection = trim($data_xml->path->path->configValue->$data_xml_connection); 

//------  Variables ------

$my_report 	= $path."simpeg\\SURAT_IJIN_CUTI_TAHUNAN.rpt";
$my_pdf 	= $path."simpeg\\SURAT_IJIN_CUTI_TAHUNAN.pdf";
if($kelompok == 'K' AND $luar_kota == '1'){
	$my_report 	= $path."simpeg\\SURAT_PEMBAYARAN_UANG_CUTI.rpt";
	$my_pdf 	= $path."simpeg\\SURAT_PEMBAYARAN_UANG_CUTI.pdf";
}
else if($kelompok == 'D'){
	$my_report 	= $path."simpeg\\SURAT_IJIN_CUTI_TAHUNAN_DARAT.rpt";
	$my_pdf 	= $path."simpeg\\SURAT_IJIN_CUTI_TAHUNAN_DARAT.pdf";
}

//echo $my_report; exit;

//------ Create a new COM Object of Crytal Reports XI ------
$ObjectFactory= new COM("CrystalRuntime.Application.11");

//------ Create a instance of library Application -------
//$crapp=$ObjectFactory->CreateObject("CrystalDesignRunTime.Application.11");

//------ Open your rpt file ------
$creport = $ObjectFactory->OpenReport($my_report, 1);

//- Set database logon info - must have
$creport->Database->Tables(1)->SetLogOnInfo("dbapp", "dbapp", "IMASYS", "imasys");


//------ Connect to Oracle 9i DataBase ------
//$crapp->LogOnServer('crdb_oracle.dll','YOUR_TNS','YOUR_TABLE','YOUR_LOGIN','YOUR_PASSWORD');

//------ Put the values that you want --------
//if($reqId == "")

//$creport->RecordSelectionFormula="{ASURANSI_REPORT.PERIODE}='".$reqPeriode."'".$statement;
//else
//	$creport->RecordSelectionFormula="{CUTI_TAHUNAN_IJIN_REPORT.PERIODE}='".$reqPeriode."' AND {CUTI_TAHUNAN_IJIN_REPORT.PEGAWAI_ID} = ".$reqId;

//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------
//$zz = $creport->ParameterFields(1)->SetCurrentValue(strtoupper(getNamePeriode($reqPeriode)));
//$zz = $creport->ParameterFields(2)->SetCurrentValue("SURABAYA, ".strtoupper(getNamePeriode($reqPeriode)));

$arrJenisPegawaiId = explode(",", $reqId);
if(count($arrJenisPegawaiId) > 1)
{
	$statement = "  ( ";
	
	for($i=0;$i<count($arrJenisPegawaiId);$i++)
	{
		if($i > 0)
			$statement .= " OR ";	
			
		$statement .= "{CUTI_TAHUNAN_IJIN_REPORT.CUTI_TAHUNAN_ID}=".$arrJenisPegawaiId[$i];
	}
	
	$statement .= " ) ";
}
else
	$statement = "  {CUTI_TAHUNAN_IJIN_REPORT.CUTI_TAHUNAN_ID}= ".$reqId;



$creport->RecordSelectionFormula=$statement;

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