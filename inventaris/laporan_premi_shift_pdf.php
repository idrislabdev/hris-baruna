<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");


include_once("lib/MPDF60/mpdf.php");

$reqPeriode = $this->input->get("reqPeriode");
$reqPerusahaanId = $this->input->get("reqPerusahaanId");


if($reqPerusahaanId == "")
	$reqPerusahaanId = $this->PERUSAHAAN_ID;
else
{
	$reqPerusahaanId = $reqPerusahaanId;
}
if($bulan == "")
	$bulan = date('m');
else
	$bulan = $bulan;

if($tahun == "")
	$tahun = date('Y');
else
	$tahun = $tahun;
/*$mpdf = new mPDF('c','LEGAL',0,'',2,2,2,2,2,2,'L');*/
//$mpdf = new mPDF('c','LEGAL',0,'',15,15,16,16,9,9, 'L');
$mpdf = new mPDF('c','A4');
$mpdf->AddPage('P', // L - landscape, P - portrait
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
$stylesheet = file_get_contents('css/gaya-laporan.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$html = file_get_contents("http://localhost/pjbs-gaji/cetak/loadUrl/report/laporan_premi_shift_excel/?logo=1&reqPeriode=".$reqPeriode."");


$mpdf->WriteHTML($html,2);

$mpdf->Output('Laporan_Arus_Kas.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================
?>