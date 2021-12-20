<?php
ini_set('max_execution_time', 3600); //300 seconds = 5 minutes 3600 =  1 hours
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
include_once("../WEB-INF/classes/base-gaji/Gaji.php");


$gaji_awal_bulan = new GajiAwalBulan();
$gaji = new Gaji();


$reqPeriode = httpFilterGet("reqPeriode");
$reqExcel = httpFilterGet("reqExcel");
$reqDepartemen = httpFilterGet("reqDepartemen");
$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
// echo $reqJenisPegawaiId;exit();


$statement_privacy .= " AND A.PERIODE = '".$reqPeriode."' ";
		

$reqNama1 = httpFilterGet("reqNama1");
$reqJabatan1 = httpFilterGet("reqJabatan1");
$reqNama2 = httpFilterGet("reqNama2");
$reqJabatan2 = httpFilterGet("reqJabatan2");

/*
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$baseurl = "http://" . $host . $path . "/";
*/


include_once("../WEB-INF/lib/MPDF60/mpdf.php");

/*$mpdf = new mPDF('c','LEGAL',0,'',2,2,2,2,2,2,'L');*/
$mpdf = new mPDF('c','LEGAL');
$mpdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            2, // margin_left
            2, // margin right
            2, // margin top
            2, // margin bottom
            2, // margin header
            2);  
//$mpdf=new mPDF('c','A4'); 
//$mpdf=new mPDF('utf-8', array(297,420));

$mpdf->mirroMargins = true;

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('../WEB-INF/css/laporan-pdf.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text


$html .= file_get_contents("penghasilan/rekap_gaji_awal_bulan_excel.php?reqExcel=".$reqExcel."&reqJenisPegawaiId=".$reqJenisPegawaiId."&reqDepartemen=".$reqDepartemen."&reqPeriode=".$reqPeriode."&reqJenisPegawai=".$jenisPegawai."&reqPegawaiId=".$reqPegawaiId."");

// echo $html->query;exit();
/*
if(substr($reqPerusahanCabangId, 0, 3) == "PER")
{
	$perusahaan_cabang->selectByParamsCabang(array("A.PERUSAHAAN_ID" => $reqPerusahaanId, "A.PERUSAHAAN_CABANG_PARENT_ID" => "0"), -1, -1, " AND EXISTS(SELECT 1 FROM PDS_PENGEMBANGAN.PEGAWAI_CABANG_TERAKHIR X INNER JOIN PDS_PENGEMBANGAN.PEGAWAI_JENIS_PEGAWAI_TERAKHIR Y ON X.PEGAWAI_ID = Y.PEGAWAI_ID WHERE Y.JENIS_PEGAWAI_ID = '".$reqJenisPegawaiId."' AND X.PERUSAHAAN_ID = A.PERUSAHAAN_ID AND X.PERUSAHAAN_CABANG_ID = A.PERUSAHAAN_CABANG_ID) ");
	$i = 0;
	while($perusahaan_cabang->nextRow())
	{
		$reqPerusahanCabangId = $perusahaan_cabang->getField("PERUSAHAAN_CABANG_ID");
		$reqPerusahanCabang = str_replace(" ", "_",$perusahaan_cabang->getField("NAMA_PERUSAHAAN"));
		if($i > 0)
			$html .= "<pagebreak>";
		
		/* CHECK APAKAH KATEGORI JABATAN PS & OPS  */
	/*	
		$jumlahKategori = $pegawai_jabatan->getCountByParamsKategori(array("B.JENIS_PEGAWAI_ID" => $reqJenisPegawaiId, "C.PERUSAHAAN_ID" => $reqPerusahaanId), " AND C.PERUSAHAAN_CABANG_ID LIKE '".$reqPerusahanCabangId."%'");
		if($jumlahKategori == 1)
			$html .= file_get_contents("http://10.35.3.93/pds-allnew/GAJI/slip_kso_excel.php?reqKategoriPegawaiId=".$reqKategoriPegawaiId."&reqJenisPegawaiId=".$reqJenisPegawaiId."&reqPerusahanCabangId=".$reqPerusahanCabangId."&reqPerusahaanId=".$reqPerusahaanId."&reqPeriode=".$reqPeriode."&reqJenisPegawai=".$jenisPegawai."&reqPerusahanCabang=".$reqPerusahanCabang."&reqPegawaiId=".$reqPegawaiId."");
		else
		{
			$arrKategoriJabatan = array("OPS", "PS");
			for($j=0;$j<count($arrKategoriJabatan);$j++)
			{
				if($j > 0)
					$html .= "<pagebreak>";
					
				$html .= file_get_contents("http://10.35.3.93/pds-allnew/GAJI/slip_kso_excel.php?reqKategoriPegawaiId=".$reqKategoriPegawaiId."&reqJenisPegawaiId=".$reqJenisPegawaiId."&reqPerusahanCabangId=".$reqPerusahanCabangId."&reqPerusahaanId=".$reqPerusahaanId."&reqPeriode=".$reqPeriode."&reqJenisPegawai=".$jenisPegawai."&reqPerusahanCabang=".$reqPerusahanCabang."&reqKategoriJabatan=".$arrKategoriJabatan[$j]."&reqPegawaiId=".$reqPegawaiId."");						
			}
		}
		$i++;
	}
}
else
{	
	$perusahaan_cabang->selectByParamsCabang(array("A.PERUSAHAAN_ID" => $reqPerusahaanId, "A.PERUSAHAAN_CABANG_ID" => $reqPerusahanCabangId));
	$perusahaan_cabang->firstRow();
	$reqPerusahanCabang = str_replace(" ", "_",$perusahaan_cabang->getField("NAMA_PERUSAHAAN"));
	/* CHECK APAKAH KATEGORI JABATAN PS & OPS  */

/*
	
	$jumlahKategori = $pegawai_jabatan->getCountByParamsKategori(array("B.JENIS_PEGAWAI_ID" => $reqJenisPegawaiId, "C.PERUSAHAAN_ID" => $reqPerusahaanId), " AND C.PERUSAHAAN_CABANG_ID LIKE '".$reqPerusahanCabangId."%'");
	if($jumlahKategori == 1)
		$html .= file_get_contents("http://10.35.3.93/pds-allnew/GAJI/slip_kso_excel.php?reqKategoriPegawaiId=".$reqKategoriPegawaiId."&reqJenisPegawaiId=".$reqJenisPegawaiId."&reqPerusahanCabangId=".$reqPerusahanCabangId."&reqPerusahaanId=".$reqPerusahaanId."&reqPeriode=".$reqPeriode."&reqJenisPegawai=".$jenisPegawai."&reqPerusahanCabang=".$reqPerusahanCabang."&reqPegawaiId=".$reqPegawaiId."");		
	else
	{
		$arrKategoriJabatan = array("OPS", "PS");
		for($i=0;$i<count($arrKategoriJabatan);$i++)
		{
			if($i > 0)
				$html .= "<pagebreak>";
			
			$html .= file_get_contents("http://10.35.3.93/pds-allnew/GAJI/slip_kso_excel.php?reqKategoriPegawaiId=".$reqKategoriPegawaiId."&reqJenisPegawaiId=".$reqJenisPegawaiId."&reqPerusahanCabangId=".$reqPerusahanCabangId."&reqPerusahaanId=".$reqPerusahaanId."&reqPeriode=".$reqPeriode."&reqJenisPegawai=".$jenisPegawai."&reqPerusahanCabang=".$reqPerusahanCabang."&reqKategoriJabatan=".$arrKategoriJabatan[$i]."&reqePegawaiId=".$reqPegawaiId."");						
		}
	}	
}
*/

$mpdf->WriteHTML($html,2);

$mpdf->Output('gaji_kso_pdf.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================
?>