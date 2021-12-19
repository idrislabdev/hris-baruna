<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqStatusPosting = httpFilterGet("reqStatusPosting");
$reqTanggalMulai = httpFilterGet("reqTanggalMulai");
$reqTanggalAkhir = httpFilterGet("reqTanggalAkhir");
$reqJenisJurnal = httpFilterGet("reqJenisJurnal");

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
$file_name	= "RINCIAN_MUTASI_JURNAL";
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

$arrTanggalMulai = explode("-", $reqTanggalMulai);
$arrTanggalAkhir = explode("-", $reqTanggalAkhir);
$arrJenisJurnal = explode("-", $reqJenisJurnal);

/*$statement = "{LAPORAN_MUTASI_JURNAL_1.JEN_JURNAL} = '".$arrJenisJurnal[0]."' AND {LAPORAN_MUTASI_JURNAL_1.PIL} = '".$reqStatusPosting."' 
			  AND {LAPORAN_MUTASI_JURNAL_1.TGL_ENTRY} IN Date(".$arrTanggalMulai[2].", ".(int)$arrTanggalMulai[1].", ".(int)$arrTanggalMulai[0].") 
			  TO Date(".$arrTanggalAkhir[2].", ".(int)$arrTanggalAkhir[1].", ".(int)$arrTanggalAkhir[0].") ";*/
			  
$tgl_awal = $arrTanggalMulai[0].$arrTanggalMulai[1].substr((int)$arrTanggalMulai[2], 2, 2);
$tgl_akhir = $arrTanggalAkhir[0].$arrTanggalAkhir[1].substr((int)$arrTanggalAkhir[2], 2, 2);

$zz = $creport->ParameterFields(1)->SetCurrentValue($arrJenisJurnal[0]);
$zz = $creport->ParameterFields(2)->SetCurrentValue($arrJenisJurnal[1]);
$zz = $creport->ParameterFields(3)->SetCurrentValue($reqTanggalMulai);
$zz = $creport->ParameterFields(4)->SetCurrentValue($reqTanggalAkhir);
$zz = $creport->ParameterFields(5)->SetCurrentValue($arrJenisJurnal[0]);
$zz = $creport->ParameterFields(6)->SetCurrentValue($reqStatusPosting);
$zz = $creport->ParameterFields(7)->SetCurrentValue($tgl_awal);
$zz = $creport->ParameterFields(8)->SetCurrentValue($tgl_akhir);


//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------
/*$bulan = substr($reqPeriode, 0, 2);
$tahun = substr($reqPeriode, 2, 4);

*/
//$creport->ReadRecords();
////------ Export to PDF -------
$creport->ExportOptions->DiskFileName=$my_pdf;
$creport->ExportOptions->FormatType=31;
$creport->ExportOptions->DestinationType=1;
$creport->Export(false);

////------ Release the variables
$creport = null;
$crapp = null;
$ObjectFactory = null;

$name = $file_name."_".$tgl_awal."_".$tgl_akhir.".pdf";

$len = filesize("$my_pdf");
header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=$name");
readfile("$my_pdf"); 
?> 