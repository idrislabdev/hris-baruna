<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-simpeg/Integrasi.php");

$report = new Integrasi();

$reqId = httpFilterGet("reqId");
$reqTahun = httpFilterGet("reqTahun");

$statement = " AND TO_CHAR(TMT_JENIS_PEGAWAI, 'YYYY') <= ".$reqTahun;

$report->selectByParamsJenisPegawai($statement);
while($report->nextRow())
{
	$orders[] = array(
				'KETERANGAN' => $report->getField("NAMA"),
				'JUMLAH' => $report->getField("JUMLAH")
				);
}

echo json_encode($orders);
?>