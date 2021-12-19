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
$pass = trim($data_xml->path->path->configValue->$data_xml_pass); if ($reqId == 1) {
//$wherekondisi = " ({T_BONUS_2013.JENIS_PEGAWAI}='PERBANTUAN' OR {T_BONUS_2013.JENIS_PEGAWAI}='ORGANIK' OR {T_BONUS_2013.JENIS_PEGAWAI}='PTTPK') ";
$wherekondisi = " ({T_BONUS_2013.JENIS_PEGAWAI}='PTTPK') ";
$my_report	= $path."penghasilan\\report\\T_SLIP_BONUS.rpt";
$my_pdf		= $path."penghasilan\\report\\T_SLIP_BONUS.pdf";
}elseif ($reqId == 2){
$wherekondisi = " ({T_BONUS_2013.JENIS_PEGAWAI}='PKWT' OR {T_BONUS_2013.JENIS_PEGAWAI}='KSO') ";
$my_report	= $path."penghasilan\\report\\T_SLIP_BONUS_2.rpt";
$my_pdf		= $path."penghasilan\\report\\T_SLIP_BONUS_2.pdf";
}elseif ($reqId == 3){
$wherekondisi = " ({T_BONUS_2013.JENIS_PEGAWAI}='PERBANTUAN') ";
$my_report	= $path."penghasilan\\report\\T_SLIP_BONUS_2.rpt";
$my_pdf		= $path."penghasilan\\report\\T_SLIP_BONUS_2.pdf";
}elseif ($reqId == 4){
$wherekondisi = " ";
$my_report	= $path."penghasilan\\report\\T_SLIP_BONUS.rpt";
$my_pdf		= $path."penghasilan\\report\\T_SLIP_BONUS.pdf";
}


//------ Create a new COM Object of Crytal Reports XI ------
$o_CrObjectFactory = new COM('CrystalReports11.ObjectFactory.1'); 
$ObjectFactory = $o_CrObjectFactory->CreateObject("CrystalRunTime.Application.11");

// Register the typelibrary.
com_load_typelib('CrystalDesignRunTime.Application');


//$ObjectFactory= new COM("CrystalRuntime.Application.11");

//------ Create a instance of library Application -------
//$crapp=$ObjectFactory->CreateObject("CrystalDesignRunTime.Application.11");

//------ Open your rpt file ------
$creport = $ObjectFactory->OpenReport($my_report, 1);

//- Set database logon info - must have
$creport->Database->Tables(1)->SetLogOnInfo($connection, $connection, $user, $pass);
$creport->RecordSelectionFormula = $wherekondisi;
//$creport->Database->LogOnServer('p2sifmx', 'name', 'name', 'acc', 'pass');

//$creport->Database->LogOnServer('crdb_oracle.dll', 'DBAPP', 'GAJI_AWAL_BULAN_REPORT', 'imasys', 'imasys');
// Logon to the database.
/*$creport->Database->LogOnServer
        (
        'odbc',
        'dbapp',
         'dbapp' ,
        'IMASYS',
        'imasys'
        );
*/
//$creport->setConnectionProperties();

//------ Connect to Oracle 9i DataBase ------
//$crapp->LogOnServer('crdb_oracle.dll','YOUR_TNS','YOUR_TABLE','YOUR_LOGIN','YOUR_PASSWORD');

//------ Put the values that you want --------

//$creport->RecordSelectionFormula="{GAJI_AWAL_BULAN_REPORT.PERIODE}='".$reqPeriode."' AND {GAJI_AWAL_BULAN_REPORT.PEGAWAI_ID} = ".$reqId;

//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------

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