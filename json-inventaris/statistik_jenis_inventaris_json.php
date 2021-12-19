<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-inventaris/Statistik.php");

$report = new Statistik();

$reqId = httpFilterGet("reqId");
$reqJenisInventaris = httpFilterGet("reqJenisInventaris");


$jumlah_inventaris = $report->getCountInventaris();

if($reqJenisInventaris == "")
	$report->selectByParamsJenisInventaris($statement);
else
	$report->selectByParamsJenisInventarisChild(" AND A.JENIS_INVENTARIS_PARENT_ID = '".$reqJenisInventaris."' ");
while($report->nextRow())
{
	$rata = round(($report->getField("JUMLAH") / $jumlah_inventaris) * 100, 2);
	$orders[] = array(
				'KODE_RATA' => $report->getField("KODE")." (".$rata."%)",
				'KODE' => $report->getField("KODE"),
				'KETERANGAN' => $report->getField("NAMA"),
				'JUMLAH' => $report->getField("JUMLAH"),
				'RATA' => $rata
				);
}

echo json_encode($orders);
?>