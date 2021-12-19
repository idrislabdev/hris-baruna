<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaLap.php");

/* create objects */

/* LOGIN CHECK */

$reqId = httpFilterGet("reqId");
$reqPelunasan = httpFilterGet("reqPelunasan");
$reqPeriode = httpFilterGet("reqPeriode");

if($reqPeriode == "")
{}
else
{
	$statement .= "AND A.BULTAH  = (SELECT MAX(BULTAH)    
											  FROM KPTT_NOTA_LAP
												WHERE BULTAH = '".$reqPeriode."')";	
}
if($reqPelunasan == 0)
{
	$statement .= "  AND NVL(JML_SALDO_AKHIR,0) <> 0 AND 
                                                    NOT EXISTS (SELECT 1 FROM KPTT_NOTA_LAP Y WHERE A.NO_NOTA = Y.NO_NOTA AND NVL(Y.JML_SALDO_AKHIR,0) = 0) ";
}
elseif($reqPelunasan == 1)
{
	$statement = " AND NVL(JML_SALDO_AKHIR,0) = 0 ";
}
else
{
	$statement .= " AND ((NVL(JML_SALDO_AKHIR,0) <> 0 AND 
                                                    NOT EXISTS (SELECT 1 FROM KPTT_NOTA_LAP Y WHERE A.NO_NOTA = Y.NO_NOTA AND NVL(Y.JML_SALDO_AKHIR,0) = 0)) OR NVL(JML_SALDO_AKHIR,0) = 0) ";
}

$kptt_nota_lap = new KpttNotaLap();
$kptt_nota_lap->selectByParamsSummaryTransaksi($reqId, $statement);
$kptt_nota_lap->firstRow();

$arrFinal = array("IDR" => numberToIna($kptt_nota_lap->getField("IDR")), "USD" => numberToIna($kptt_nota_lap->getField("USD")));
echo json_encode($arrFinal);
?>