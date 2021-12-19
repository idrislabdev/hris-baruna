<?php 
// require the PHPExcel file 
require '../WEB-INF/lib/Classes/PHPExcel.php'; 
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikanPerjenjangan.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPendidikanSubstansial.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPangkat.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");

/* create objects */
$pegawai = new Pegawai();
$pegawai_pendidikan_perjenjangan = new PegawaiPendidikanPerjenjangan();
$pegawai_pendidikan_substansial = new PegawaiPendidikanSubstansial();
$pegawai_jabatan = new PegawaiJabatan();
$pegawai_pangkat = new PegawaiPangkat();

//$link_file = $_SERVER['DOCUMENT_ROOT']."/imasys-pms/template-simpeg/";
$link_file = $_SERVER['DOCUMENT_ROOT']."/template-simpeg/";
/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

/* VARIABLE */
$reqId = httpFilterGet("reqId");

$objPHPexcel = PHPExcel_IOFactory::load('../template-simpeg/cv.xlsx');
$objWorksheet = $objPHPexcel->getActiveSheet();

$field = array('NAMA', 'NRP', 'ALAMAT', 'KOTA', 'TELEPON', 'TTL', 'JENIS_KELAMIN', 'AGAMA_NAMA', 'STATUS_PERNIKAHAN', 
			   'GOLONGAN_DARAH', 'TINGGIBB', 'JABATAN_NAMA', 'STATUS_PEGAWAI', 'PENDIDIKAN_FORMAL', 'HOBBY');
			   
$pegawai->selectByParamsCV(array('A.PEGAWAI_ID'=>$reqId),-1,-1);
$pegawai->firstRow();
//echo $pegawai->query;
$start = 3;
$col = 'D';
//$objWorksheet->freezePane('C2');

$data = $pegawai->getField('FOTO');

$styleArrayFontBold = 
array(
	'font'=>array(
		'name'      =>  'Arial Narrow',
		'size'      =>  14,
		'bold'      => true
	)
);

if(strlen($data) > 1){
	$im = imagecreatefromstring($data);
	//echo $im;
	if ($im !== false) {
		//$save = "../template-simpeg/". $reqId .".png";
		$save = $link_file. $reqId .".png";
		
		imagepng($im, $save, 0, NULL);
		imagedestroy($im);
	}
	else {
		echo 'An error occurred.';
	}	

	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('FotoPegawai');
	$objDrawing->setDescription('FotoPegawai');
	$objDrawing->setPath($save);
	$objDrawing->setOffsetX(250);
	$objDrawing->setWidth(145);
	$objDrawing->setCoordinates('F3');
	
	$sheet = $objWorksheet;
	$objDrawing->setWorksheet($sheet);
}
  	
for($i=0; $i<count($field); $i++)
{
	if($start == 16)
		$tempValue= str_replace("<BR/>","\n",$pegawai->getField($field[$i]));
	elseif($start == 4)
	{
		//$tempValue= " ".$pegawai->getField($field[$i]);//str_replace(",",".",$pegawai->getField($field[$i]));
		$tempValue= " ".$pegawai->getField("NRP");
		$tempNip= explode('.',$pegawai->getField($field[$i]));
		//$tempNip = $tempNip[1];
		$tempNip = $pegawai->getField("NRP");
	}
	else
		$tempValue= $pegawai->getField($field[$i]);
	
	$objWorksheet->setCellValue($col.$start,$tempValue);
	
	if($start == 16)
	{
		$objWorksheet->getStyle($col.$start)->getAlignment()->setWrapText(true); 
		$objWorksheet->getStyle($col.$start)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	}
	elseif($start == 4)
	{
		//$objWorksheet->getStyle($col.$start)->getNumberFormat()->setFormatCode('#');
		//$objWorksheet->getStyle($col.$start)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
	}
	$start += 1;
}

$objWorksheet->setBreak("A19", PHPExcel_Worksheet::BREAK_ROW);

//$start= 68;
$start= 20;
$objWorksheet->setCellValue("A".$start,"RIWAYAT PENDIDIKAN, JABATAN, KEPANGKATAN");
$objWorksheet->mergeCells('A'.$start.':F'.$start);
//$objWorksheet->getStyle("A1")->getFont()->setBold(true);
$objWorksheet->getStyle("A".$start.":F".$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objWorksheet->getStyle('A'.$start.':F'.$start)->applyFromArray($styleArrayFontBold);


$start++;
$objWorksheet->setCellValue("A".$start,"RIWAYAT PENDIDIKAN PENJEJANGAN");
$objWorksheet->getStyle("A".$start)->applyFromArray($styleArrayFontBold);
$objWorksheet->mergeCells('A'.$start.':E'.$start);
$objWorksheet->setCellValue("F".$start,$tempNip);

$start = $start+1; $no=1;
$pegawai_pendidikan_perjenjangan->selectByParams(array('PEGAWAI_ID'=>$reqId),-1,-1);
while($pegawai_pendidikan_perjenjangan->nextRow())
{
	$objWorksheet->setCellValue("A".$start,$no);
	$objWorksheet->setCellValue("B".$start,$pegawai_pendidikan_perjenjangan->getField("NAMA"));
	$objWorksheet->mergeCells('B'.$start.':D'.$start.'');
	$objWorksheet->setCellValue("E".$start,dateToPageCheck($pegawai_pendidikan_perjenjangan->getField("TANGGAL_AWAL")).' - '.dateToPageCheck($pegawai_pendidikan_perjenjangan->getField("TANGGAL_AWAL")));
	$objWorksheet->getStyle('E'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objWorksheet->mergeCells('E'.$start.':F'.$start.'');
	
	/*$objWorksheet->mergeCells('B'.$start.':C'.$start.'');
	$objWorksheet->setCellValue("D".$start,dateToPageCheck($pegawai_pendidikan_perjenjangan->getField("TANGGAL_AWAL")).' - '.dateToPageCheck($pegawai_pendidikan_perjenjangan->getField("TANGGAL_AWAL")));
	$objWorksheet->getStyle('D'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objWorksheet->mergeCells('D'.$start.':E'.$start.'');*/
	$start += 1;
	$no++;
}

$start += 1;
$no=1;
$objWorksheet->setCellValue("A".$start,"RIWAYAT PENDIDIKAN SUBSTANSIAL");
$objWorksheet->setCellValue("F".$start,$tempNip);
//$objWorksheet->getStyle('A'.$start)->getFont()->setBold(true);
$objWorksheet->getStyle('A'.$start)->applyFromArray($styleArrayFontBold);
$objWorksheet->mergeCells('A'.$start.':E'.$start.'');
$start += 1;

$pegawai_pendidikan_substansial->selectByParams(array('PEGAWAI_ID'=>$reqId),-1,-1);
while($pegawai_pendidikan_substansial->nextRow())
{
	$objWorksheet->setCellValue("A".$start,$no);
	$objWorksheet->setCellValue("B".$start,$pegawai_pendidikan_substansial->getField("NAMA"));
	$objWorksheet->mergeCells('B'.$start.':D'.$start.'');
	$objWorksheet->setCellValue("E".$start,dateToPageCheck($pegawai_pendidikan_substansial->getField("TANGGAL_AWAL")).' - '.dateToPageCheck($pegawai_pendidikan_substansial->getField("TANGGAL_AWAL")));
	$objWorksheet->getStyle('E'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objWorksheet->mergeCells('E'.$start.':F'.$start.'');
	
	/*$objWorksheet->mergeCells('B'.$start.':C'.$start.'');
	$objWorksheet->setCellValue("D".$start,dateToPageCheck($pegawai_pendidikan_substansial->getField("TANGGAL_AWAL")).' - '.dateToPageCheck($pegawai_pendidikan_substansial->getField("TANGGAL_AWAL")));
	$objWorksheet->getStyle('D'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objWorksheet->mergeCells('D'.$start.':E'.$start.'');*/
	$start += 1;
	$no++;
}

$start += 1;
$no=1;
$objWorksheet->setCellValue("A".$start,"RIWAYAT JABATAN");
//$objWorksheet->getStyle('A'.$start)->getFont()->setBold(true);
$objWorksheet->getStyle('A'.$start)->applyFromArray($styleArrayFontBold);
$objWorksheet->mergeCells('A'.$start.':F'.$start.'');
$start += 1;

$pegawai_jabatan->selectByParams(array("PEGAWAI_ID"=>$reqId),-1,-1);
while($pegawai_jabatan->nextRow())
{
	$objWorksheet->setCellValue("A".$start,$no);
	$objWorksheet->setCellValue("B".$start,$pegawai_jabatan->getField("NAMA"));
	$objWorksheet->mergeCells('B'.$start.':D'.$start.'');
	$objWorksheet->setCellValue("E".$start," TMT. ".dateToPageCheck($pegawai_jabatan->getField("TMT_JABATAN")));
	$objWorksheet->getStyle('E'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objWorksheet->mergeCells('E'.$start.':F'.$start.'');
	
	/*$objWorksheet->mergeCells('B'.$start.':C'.$start.'');
	$objWorksheet->setCellValue("D".$start," TMT. ".dateToPageCheck($pegawai_jabatan->getField("TMT_JABATAN")));
	$objWorksheet->getStyle('D'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objWorksheet->mergeCells('D'.$start.':E'.$start.'');*/
	$start += 1;
	
	$objWorksheet->setCellValue("B".$start,"NO SK :".$pegawai_jabatan->getField("NO_SK")." Tgl :".dateToPageCheck($pegawai_jabatan->getField("TGL_SK"))." Oleh :".$pegawai_jabatan->getField("PEJABAT_PENETAP_NAMA"));
	$objWorksheet->mergeCells('B'.$start.':E'.$start.'');
	$start += 1;
	
	$no++;
}

$objWorksheet->setBreak("A".$start, PHPExcel_Worksheet::BREAK_ROW);

$start += 1;
$no=1;
$objWorksheet->setCellValue("A".$start,"RIWAYAT PANGKAT");
//$objWorksheet->getStyle('A'.$start)->getFont()->setBold(true);
$objWorksheet->getStyle('A'.$start)->applyFromArray($styleArrayFontBold);
$objWorksheet->mergeCells('A'.$start.':F'.$start.'');
$start += 1;

$pegawai_pangkat->selectByParams(array("PEGAWAI_ID"=>$reqId),-1,-1);
while($pegawai_pangkat->nextRow())
{
	$objWorksheet->setCellValue("A".$start,$no);
	$objWorksheet->setCellValue("B".$start,$pegawai_pangkat->getField("PANGKAT_KETERANGAN")."     ".$pegawai_pangkat->getField("PANGKAT_NAMA"));
	$objWorksheet->mergeCells('B'.$start.':D'.$start.'');
	$objWorksheet->setCellValue("E".$start," TMT. ".dateToPageCheck($pegawai_pangkat->getField("TMT_PANGKAT")));
	$objWorksheet->getStyle('E'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objWorksheet->mergeCells('E'.$start.':F'.$start.'');
	
	$start += 1;
	
	$objWorksheet->setCellValue("B".$start,"NO SK :".$pegawai_pangkat->getField("NO_SK")." Tgl :".dateToPageCheck($pegawai_pangkat->getField("TANGGAL_SK"))."     ".$pegawai_pangkat->getField("KETERANGAN"));
	$objWorksheet->mergeCells('B'.$start.':E'.$start.'');
	$start += 1;
	
	$no++;
}

//$objWorksheet->setShowGridLines(false);
$objWorksheet->getStyle('A1:F'.$start)->getBorders()->getAllBorders()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objWriter = new PHPExcel_Writer_PDF($objPHPexcel);
$objWriter->save($link_file."cv.pdf");

$down = $link_file.'cv.pdf';
header("Content-Type: application/pdf; name=\"cv.pdf\"");
header("Content-Disposition: inline; filename=\"cv.pdf\"");
$fh=fopen($down, "rb");
fpassthru($fh);
unlink($down);
unlink($save);

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
//$objWriter->save('../template-simpeg/cv.xls');
/*$down = '../template-simpeg/cv.xls';

header("Content-Type: application/x-msexcel; name=\"pegawai_data_excel.xls\"");
header("Content-Disposition: inline; filename=\"pegawai_data_excel.xls\"");
$fh=fopen($down, "rb");
fpassthru($fh);*/
//unlink($down);
//unlink($save);
?>