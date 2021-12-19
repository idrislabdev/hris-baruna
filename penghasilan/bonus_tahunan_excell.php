<?php
error_reporting(1);
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/BonusTahunan.php");
include_once("../WEB-INF/lib/Classes/PHPExcel.php");
$huruf = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
						'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',
						'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ',
						'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ'
					);

//// sampai disini
$reqPeriode = httpFilterGet("reqPeriode");
$reqJenis = httpFilterGet("reqJenis");
$reqDepartemen = httpFilterGet("reqDepartemen");

ini_set("memory_limit","700M");
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
$phpExcel->getProperties()->setCreator("PT. PELINDO PROPERTI INDONESIA")
	->setLastModifiedBy("PT. PELINDO PROPERTI INDONESIA")
	->setTitle("Rekap Nilai PI Pegawai")
	->setSubject("Rekap Nilai PI Pegawai")
	->setDescription("Rekap Nilai PI Pegawai")
	->setKeywords("Rekap Nilai PI Pegawai")
	->setCategory("Rekap Nilai PI Pegawai");
$phpExcel->getActiveSheet()->setTitle("bonus");
$phpExcel->setActiveSheetIndex(0);
$sheet = $phpExcel->getActiveSheet();
$judul_rekap = "BONUS TAHUN " . $reqPeriode;

$sheet->setCellValue("A1", "PT. PELINDO PROPERTI INDONESIA")
	->setCellValue("A2", "BONUS TAHUN " .  $reqPeriode)
	;

$sheet->setCellValue('A4', 'NO');	 				$sheet->getColumnDimension('A')->setWidth(5);
$sheet->setCellValue('B4', 'Nama'); 				$sheet->getColumnDimension('B')->setWidth(39);
$sheet->setCellValue('C4', 'NRP'); 					$sheet->getColumnDimension('C')->setWidth(10);
$sheet->setCellValue('D4', 'KELAS'); 				$sheet->getColumnDimension('D')->setWidth(6);
$sheet->setCellValue('E4', 'Departemen');  			$sheet->getColumnDimension('E')->setWidth(41);
$sheet->setCellValue('F4', 'Jenis Pegawai'); 		$sheet->getColumnDimension('F')->setWidth(17);
$sheet->setCellValue('G4', 'Nama Bank'); 			$sheet->getColumnDimension('G')->setWidth(15);
$sheet->setCellValue('H4', 'Nama Rekening'); 		$sheet->getColumnDimension('H')->setWidth(35);
$sheet->setCellValue('I4', 'No Rekening'); 			$sheet->getColumnDimension('I')->setWidth(17);
$sheet->setCellValue('J4', 'Jumlah Bonus'); 		$sheet->getColumnDimension('J')->setWidth(15);
$sheet->setCellValue('K4', 'PPH (%)'); 				$sheet->getColumnDimension('K')->setWidth(7);
$sheet->setCellValue('L4', 'PPH'); 					$sheet->getColumnDimension('L')->setWidth(15);
$sheet->setCellValue('M4', 'Jumlah Dibayar'); 		$sheet->getColumnDimension('M')->setWidth(15);

$sheet->getStyle('A4:M4')->applyFromArray($styleheader); 
//$sheet->getStyle('A4:AM4')->getAlignment()->setWrapText(true); 

$bonus = new BonusTahunan();
$where =" AND A.PERIODE = '" . $reqPeriode . "' ";

if($reqDepartemen != 'ALL'){
	$where .= " AND E.DEPARTEMEN_ID = '". $reqDepartemen ."' ";
}

if($reqJenis != 'ALL'){
	$where .= " AND A.JENIS_PEGAWAI = '". $reqJenis ."' ";
}

$order = " ORDER BY A.JENIS_PEGAWAI ASC, A.NAMA ASC ";
$bonus->selectByParamsNew(array(), -1, -1, $where, $order); 
//echo $bonus->query; exit;
$baris=0; 
$dari = 5;

//$warna_putih = new PHPExcel_Style_Color(); 
while($bonus->nextRow()) {
	$baris++;  
	$sheet->setCellValue('A'. $dari, $baris);
	$sheet->setCellValue('B'. $dari, $bonus->getField("NAMA"));
	$sheet->setCellValueExplicit('C'. $dari, $bonus->getField("NRP"), PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValue('D'. $dari, $bonus->getField("KELAS"));
	$sheet->setCellValue('E'. $dari, $bonus->getField("DEPARTEMEN"));
	$sheet->setCellValue('F'. $dari, $bonus->getField("JENIS_PEGAWAI"));
	$sheet->setCellValue('G'. $dari, $bonus->getField("BANK"));	
	$sheet->setCellValue('H'. $dari, $bonus->getField("REKENING_NAMA"));

	$sheet->setCellValueExplicit('I'. $dari, $bonus->getField("REKENING_NO"), PHPExcel_Cell_DataType::TYPE_STRING);

	//$sheet->setCellValue('G'. $dari, "'" . $bonus->getField("REKENING_NO"));	
	$sheet->setCellValue('J'. $dari, $bonus->getField("JUMLAH_BONUS"));	
	$sheet->setCellValue('K'. $dari, $bonus->getField("PPH_PERSEN"));	
	$sheet->setCellValue('L'. $dari, $bonus->getField("PPH_NILAI"));	
	$sheet->setCellValue('M'. $dari, $bonus->getField("JUMLAH_DIBAYAR"));	

	
	$sheet->getStyle('A'. $dari .':M' . $dari)->applyFromArray($styleBody); 
	$dari++;
} 

$sheet->getStyle('J5:J'. $dari)->getNumberFormat()->setFormatCode('#,##0.00');
$sheet->getStyle('L5:M'. $dari)->getNumberFormat()->setFormatCode('#,##0.00');
$baris_rumus = $dari;
$dari++;

$sheet->setCellValue('I'. $dari, 'JUMLAH' );	
$sheet->setCellValue('J'. $dari, '=SUM(J5:J'. $baris_rumus .')' );	
$sheet->setCellValue('L'. $dari, '=SUM(L5:L'. $baris_rumus .')' );	
$sheet->setCellValue('M'. $dari, '=SUM(M5:M'. $baris_rumus .')' );	
$sheet->getStyle('J'. $dari)->getNumberFormat()->setFormatCode('#,##0.00');
$sheet->getStyle('K'. $dari .':M'. $dari)->getNumberFormat()->setFormatCode('#,##0.00');

$namaFile = 'bonus_' . date('Ymd:His') . '.xls';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$namaFile");
header("Cache-Control: max-age=0");
$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;
