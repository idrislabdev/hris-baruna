<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");


$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");

$bulan = substr($reqPeriode,0, 2);
$tahun = substr($reqPeriode,2, 4);

$bulan = (int)$bulan + 1;
if($bulan == 13)
	$reqPeriodePembayaran = "01".($tahun + 1);
else
	$reqPeriodePembayaran = generateZero($bulan, 2).$tahun;	

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
if($reqJenisPegawaiId == "")
{
	$pegawai_jenis_pegawai = new PegawaiJenisPegawai();
	$pegawai_jenis_pegawai->selectByParamsTerakhir(array("PEGAWAI_ID" => $reqId), -1, -1, " ORDER BY A.TMT_JENIS_PEGAWAI DESC ");
	$pegawai_jenis_pegawai->firstRow();
	$reqJenisPegawaiId =  $pegawai_jenis_pegawai->getField("JENIS_PEGAWAI_ID");
	
	$reqPeriodePembayaran = $reqPeriode;
}

if($reqJenisPegawaiId == "6,7" || $reqJenisPegawaiId == "6" || $reqJenisPegawaiId == "7")
{
	$my_report	= $path."penghasilan\\report\\SLIP_DIREKSI.rpt";
	$my_pdf		= $path."penghasilan\\report\\SLIP_DIREKSI.pdf";

	$reqPeriodePembayaran = $reqPeriode;

}
else if($reqJenisPegawaiId == "4")
{
	$my_report	= $path."penghasilan\\report\\SLIP_KSO.rpt";
	$my_pdf		= $path."penghasilan\\report\\SLIP_KSO.pdf";
}
else if($reqJenisPegawaiId == "1")
{
	$my_report	= $path."penghasilan\\report\\SLIP_GAJI_PEGAWAI_TETAP.rpt";
	$my_pdf		= $path."penghasilan\\report\\SLIP_GAJI_PEGAWAI_TETAP.pdf";
	
	$reqPeriodePembayaran = $reqPeriode;
	
}
else if($reqJenisPegawaiId == "2")
{
	$my_report	= $path."penghasilan\\report\\SLIP_PERBANTUAN_BARU.rpt";
	$my_pdf		= $path."penghasilan\\report\\SLIP_PERBANTUAN_BARU.pdf";
	
	$reqPeriodePembayaran = $reqPeriode;
}
else if($reqJenisPegawaiId == "3")
{
	$my_report	= $path."penghasilan\\report\\SLIP_GAJI_PKWT.rpt";
	$my_pdf		= $path."penghasilan\\report\\SLIP_GAJI_PKWT.pdf";
}
else if($reqJenisPegawaiId == "5")
{
	$my_report	= $path."penghasilan\\report\\SLIP_GAJI_PTTK.rpt";
	$my_pdf		= $path."penghasilan\\report\\SLIP_GAJI_PTTK.pdf";
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

$arrJenisPegawaiId = explode(",", $reqJenisPegawaiId);
if(count($arrJenisPegawaiId) > 1)
{
	$statement = " AND ( ";
	
	for($i=0;$i<count($arrJenisPegawaiId);$i++)
	{
		if($i > 0)
			$statement .= " OR ";	
			
		$statement .= "PPI_SIMPEG.AMBIL_JENIS_PEGAWAI_PERIODE(B.BULANTAHUN, A.PEGAWAI_ID)=".$arrJenisPegawaiId[$i];
	}
	
	$statement .= " ) ";
}
else
	$statement .= " AND PPI_SIMPEG.AMBIL_JENIS_PEGAWAI_PERIODE(B.BULANTAHUN, A.PEGAWAI_ID)= ".$reqJenisPegawaiId;



if($reqId == "")
{
	$statement .= " AND BULANTAHUN='".$reqPeriode."' ";
}
else
	$statement .= " AND BULANTAHUN='".$reqPeriode."' AND A.PEGAWAI_ID = ".$reqId;
//echo $statement; exit;

//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------
$zz = $creport->ParameterFields(1)->SetCurrentValue(strtoupper(getNamePeriode($reqPeriode)));
$zz = $creport->ParameterFields(2)->SetCurrentValue("SURABAYA, ".strtoupper(getNamePeriode($reqPeriodePembayaran)));
$zz = $creport->ParameterFields(3)->SetCurrentValue("SLIP PENGHASILAN PEGAWAI");
$zz = $creport->ParameterFields(4)->SetCurrentValue($statement);

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