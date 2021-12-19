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

$report->selectBySexUmur($statement);
while($report->nextRow())
{
	$orders[] = array(
				'KETERANGAN' => $report->getField("UMUR"),
				'LAKI' => $report->getField("LAKI"),
				'PEREMPUAN' => $report->getField("PEREMPUAN"),
				'JUMLAH' => $report->getField("JUMLAH")
				);
}

echo json_encode($orders);
?>