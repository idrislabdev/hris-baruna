<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/KalkulasiPenyusutan.php");

$kalkulasi_penyusutan = new KalkulasiPenyusutan();

$reqPeriode = httpFilterGet("reqPeriode");
$reqLokasi = httpFilterGet("reqLokasi");


//==============================================================
//==============================================================
//==============================================================
include("../WEB-INF/lib/MPDF60/mpdf.php");

$mpdf = new mPDF('c','A4');
$mpdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            10, // margin_left
            10, // margin right
            10, // margin top
            10, // margin bottom
            9, // margin header
            9);  
//$mpdf=new mPDF('c','A4'); 
//$mpdf=new mPDF('utf-8', array(297,420));

$mpdf->mirroMargins = true;

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
//$stylesheet = file_get_contents('css/invoice-kwitansi.css');
//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

// LOAD a stylesheet
$stylesheet = file_get_contents('gaya-laporan.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$html = file_get_contents("http://".$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI'])."/rekap_aktiva_tetap_tahunan_excel.php?reqPeriode=".$reqPeriode."");


$mpdf->WriteHTML($html,2);

$mpdf->Output('rekap_inventaris_ruangan.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>