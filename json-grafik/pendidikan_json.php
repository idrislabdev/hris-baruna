<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-simpeg/Integrasi.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");


$report = new Integrasi();
$pegawai = new Pegawai();

$reqId = httpFilterGet("reqId");
$reqDepartemen = httpFilterGet("reqDepartemen");

if(strpos($reqDepartemen, 'CAB') !== false)
	$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
	$statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%' ";

$pegawai_total = $pegawai->getCountByParams(array(), $statement." AND A.STATUS_PEGAWAI_ID IN (1,5) AND NOT NVL(G.JENIS_PEGAWAI_ID, 1) = 8 ".$statement);

$report->selectByParamsPendidikan($statement);
while($report->nextRow())
{
	$rata = round(($report->getField("TOTAL") / $pegawai_total) * 100, 2);
	$orders[] = array(
				'ID' => $report->getField("PENDIDIKAN_ID"),
				'KETERANGAN' => $report->getField("NAMA")." (".$rata."%)",
				'TOTAL' => $report->getField("TOTAL"),
				'RATA' => $rata,
				'JUMLAH_PS' => $report->getField("JUMLAH_PS"),
				'JUMLAH_OPS' => $report->getField("JUMLAH_OPS"),
				'JUMLAH_INTERNAL' => $report->getField("JUMLAH_INTERNAL")
				);
}

echo json_encode($orders);
?>