<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base/Integrasi.php");

$report = new Integrasi();

$reqId = httpFilterGet("reqId");

if($userLogin->userSatkerId == "")//kondisi login sebagai admin
{
	if($reqId == "")	$statement = " ";	
	else				$statement = " AND A.SATKER_ID LIKE '".$reqId."%'";	
}
else // kondisi login sebagai SKPD
{
	if($reqId == "")	$statement = " AND A.SATKER_ID LIKE '".$userLogin->userSatkerId."%'";	
	else				$statement = " AND A.SATKER_ID LIKE '".$reqId."%'";	
}

$report->selectByJenisKelaminGolongan($statement);
while($report->nextRow())
{
	$orders[] = array(
				'KETERANGAN' => $report->getField("UMUR"),
				'GOL1' => $report->getField("LAKI1") + $report->getField("PEREMPUAN1"),
				'GOL2' => $report->getField("LAKI2") + $report->getField("PEREMPUAN2"),
				'GOL3' => $report->getField("LAKI3") + $report->getField("PEREMPUAN3"),
				'GOL4' => $report->getField("LAKI4") + $report->getField("PEREMPUAN4")
				);
}

echo json_encode($orders);
?>