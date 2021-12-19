<?php
error_reporting(1);
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
include_once("../WEB-INF/lib/Classes/PHPExcel.php");
$huruf = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
						'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',
						'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ',
						'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ'
					);

//// sampai disini
$dari = 5;
$reqPeriode = httpFilterGet("reqPeriode");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);
$phpExcel = new PHPExcel();
$styleheader = array(
	'font' => array('bold' => true,),
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,),
	'borders' => array('vertical' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
		),
); 
$styleBody = array(
	'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,),
	'borders' => array('vertical' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
		),
); 
$styleCenter = array(
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
); 
$phpExcel->getProperties()->setCreator("PT PELINDO MARINE SERVICES")
	->setLastModifiedBy("PT PELINDO MARINE SERVICES")
	->setTitle("Rekap Cuti Tunda")
	->setSubject("Rekap Cuti Tunda")
	->setDescription("Rekap Cuti Tunda")
	->setKeywords("Rekap Cuti Tunda")
	->setCategory("Rekap Cuti Tunda");
$phpExcel->getActiveSheet()->setTitle("Cuti Tunda");
$phpExcel->setActiveSheetIndex(0);
$sheet = $phpExcel->getActiveSheet();
$judul_rekap = "REKAPAN CUTI TUNDA PERIODE " . $reqPeriode;
$sheet->setCellValue("A1", "PT. PELINDO MARINE SERVICES")
	->setCellValue("A2", "DAFTAR PEGAWAI CUTI TUNDA PERIODE ". $reqPeriode)
	->setCellValue("A4", "No")
	->setCellValue("B4", "NRP ")
	->setCellValue("C4", "NAMA ")
	->setCellValue("D4", "Jumlah Cuti Terlaksana")
	->setCellValue("E4", "Jumlah Cuti Tunda")
	->setCellValue("F4", "Type Cuti")
	->setCellValue("G4", "Tgl Permohonan")
	->setCellValue("H4", "Lama Cuti")
	->setCellValue("I4", "Nota Dinas Tunda")
	->setCellValue("J4", "Tgl ND Tunda")
	;

$kolAwal=0; $hurufAwal=''; $tglIsi=0;

$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(12);
$sheet->getColumnDimension('C')->setWidth(45);
for($i=3; $i<10; $i++){
	$sheet->getColumnDimension($huruf[$i])->setWidth(23);
}

$sheet->getStyle('A4:J4')->applyFromArray($styleheader); 


$cuti_tunda = new CutiTahunan();
$cuti_tunda->selectByParamsCutiTunda(array(), -1, -1, "AND TUNDA <> 0  AND PERIODE = '" . $reqPeriode . "'", "");
$baris=0;
while($cuti_tunda->nextRow()) {
	$baris++;
	$sheet->setCellValue('A'. $dari, $baris);
	$sheet->setCellValue('B'. $dari, $cuti_tunda->getField("NRP"));
	$sheet->setCellValue('C'. $dari, $cuti_tunda->getField("NAMA"));
	$sheet->setCellValue('D'. $dari, $cuti_tunda->getField("DILAKSANAKAN"));
	$sheet->setCellValue('E'. $dari, $cuti_tunda->getField("TUNDA"));
	$sheet->getStyle('A'. $dari .':J' . $dari)->applyFromArray($styleBody); 
		$sheet->getStyle('A'. $dari .':J' . $dari)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$sheet->getStyle('A'. $dari .':J' . $dari)->getFill()->getStartColor()->setARGB('d9d9d9d9');
	$cuti_tunda_detail = new CutiTahunan();
	$cuti_tunda_detail->selectByParamsCutiTundaDetail(array(), -1, -1, "  AND CUTI_TAHUNAN_ID = " . $cuti_tunda->getField("CUTI_TAHUNAN_ID") . " " ,"");

	while($cuti_tunda_detail->nextRow()){
		$dari++;
		$sheet->setCellValue('A'. $dari, '');
		$sheet->setCellValue('B'. $dari, '');
		$sheet->setCellValue('C'. $dari, '');
		$sheet->setCellValue('D'. $dari, '');
		$sheet->setCellValue('E'. $dari, '');
		$sheet->setCellValue('F' . $dari, $cuti_tunda_detail->getField("TYPE"));
		$sheet->setCellValue('G' . $dari, $cuti_tunda_detail->getField("TANGGAL"));
		$sheet->setCellValue('H' . $dari, $cuti_tunda_detail->getField("LAMA_CUTI"));
		$sheet->setCellValue('I' . $dari, $cuti_tunda_detail->getField("NOTA_DINAS_TUNDA"));
		$sheet->setCellValue('J' . $dari, $cuti_tunda_detail->getField("TANGGAL_NOTA_DINAS_TUNDA"));
		$sheet->getStyle('A'. $dari .':J' . $dari)->applyFromArray($styleBody); 
	}
	unset($cuti_tunda_detail);
	$sheet->getStyle('A'. $dari)->applyFromArray($styleCenter);
	$dari++;
}
$namaFile = 'cuti_tunda_' . date('Ymd:His') . '.xls';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$namaFile");
header("Cache-Control: max-age=0");
$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;

//while($report_ibt->nextRow())