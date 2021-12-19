<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/ReportPenandaTangan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$report_penanda_tangan = new ReportPenandaTangan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqJenisReport= httpFilterPost("reqJenisReport");
$reqNama1= httpFilterPost("reqNama1");
$reqJabatan1= httpFilterPost("reqJabatan1");
$reqNama2= httpFilterPost("reqNama2");
$reqJabatan2= httpFilterPost("reqJabatan2");
$reqNama3= httpFilterPost("reqNama3");
$reqJabatan3= httpFilterPost("reqJabatan3");

if($reqMode == "update")
{
	$report_penanda_tangan->setField("REPORT_PENANDA_TANGAN_ID", $reqId);
	$report_penanda_tangan->setField("JENIS_REPORT", $reqJenisReport);
	$report_penanda_tangan->setField("NAMA_1", $reqNama1);
	$report_penanda_tangan->setField("JABATAN_1", $reqJabatan1);
	$report_penanda_tangan->setField("NAMA_2", $reqNama2);
	$report_penanda_tangan->setField("JABATAN_2", $reqJabatan2);
	$report_penanda_tangan->setField("NAMA_3", $reqNama3);
	$report_penanda_tangan->setField("JABATAN_3", $reqJabatan3);
	
	if($report_penanda_tangan->update())
	{
		echo "Data berhasil disimpan.";
	}
}
?>