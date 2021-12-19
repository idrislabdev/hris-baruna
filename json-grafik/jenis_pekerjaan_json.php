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

if($reqDepartemen == 0)
{}
else
	$statement = " AND EXISTS(SELECT 1 FROM PEL_SIMPEG.PEGAWAI_CABANG_P3_TERAKHIR X WHERE X.PEGAWAI_ID = C.PEGAWAI_ID AND X.CABANG_P3_ID = ".$reqDepartemen.")";
	
if($reqDepartemen == 20)
	$statement .= " AND COALESCE(A.CABANG_P3_ID, 0) = ".$reqDepartemen;
else
	$statement .= " AND COALESCE(A.CABANG_P3_ID, 0) = 0 ";

$pegawai_total = $report->getCountByParamsJenisPekerjaan($statement);

$report->selectByParamsJenisPekerjaan($statement);
while($report->nextRow())
{
	$rata = round(($report->getField("TOTAL") / $pegawai_total) * 100, 2);
	$orders[] = array(
				'ID' => $report->getField("JABATAN_ID"),
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