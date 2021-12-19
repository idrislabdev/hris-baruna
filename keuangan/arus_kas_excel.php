<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqPejabatKiri = httpFilterGet("reqPejabatKiri");
$reqPeriode = httpFilterGet("reqPeriode");
$reqId = httpFilterGet("reqId");

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
$file_name	= "ARUS_KAS_RUPIAH";
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

$bulan = substr($reqPeriode, 0, 2);
$tahun = substr($reqPeriode, 2, 4);

$bulanint = (int)$bulan;
$tahunint = (int)$tahun;

if ($bulanint <=12) 
{
$akhirbulan = cal_days_in_month(CAL_GREGORIAN, $bulanint, $tahunint);
$tanggal = $akhirbulan." ".strtoupper(getNamePeriode($reqPeriode));
}
else
$tanggal = "31 DESEMBER AUDIT ".$tahun ;

//$creport->RecordSelectionFormula="{REKAP_THR_REPORT.PERIODE}='".$reqPeriode."'";
	
//$creport->RecordSelectionFormula="({LAPORAN_ARUS_KAS_1.THN_BUKU} ='".$tahun."' AND {LAPORAN_ARUS_KAS_1.BLN_BUKU} = '".$bulan."') OR ISNULL({LAPORAN_ARUS_KAS_1.THN_BUKU}) ";


//THN_BUKU = 2013 AND BLN_BUKU = '09' OR THN_BUKU IS NULL

//------ This is very important. DiscardSavedData make a	
// Refresh in your data -------
//$creport->DiscardSavedData;
//------ Read the records :-P -------

$arrPejabat = explode("-", $reqPejabatKiri);
$nama = $arrPejabat[0];
$nip = $arrPejabat[1];

//echo $pejabat;

$zz = $creport->ParameterFields(1)->SetCurrentValue($tanggal);
$zz = $creport->ParameterFields(2)->SetCurrentValue($nama);
$zz = $creport->ParameterFields(3)->SetCurrentValue($nip);
$zz = $creport->ParameterFields(4)->SetCurrentValue($bulan);
$zz = $creport->ParameterFields(5)->SetCurrentValue($tahun);

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

$name = $file_name."_".$reqPeriode.".xls";

$len = filesize("$my_pdf");
header("Content-type: application/xls");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=$name");
readfile("$my_pdf"); 
?> 