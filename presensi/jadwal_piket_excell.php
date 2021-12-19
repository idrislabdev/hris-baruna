<?php
error_reporting(1);
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/PageNumber.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-operasional/GlobalQuery.php");
include_once("../WEB-INF/classes/base-absensi/DaftarJagaPiket.php");
include_once("../WEB-INF/lib/Classes/PHPExcel.php");
$huruf = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
						'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',
						'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ',
						'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ'
					);

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
	->setTitle("Rekap Jadwal Piket")
	->setSubject("Rekap Jadwal Piket")
	->setDescription("Rekap Jadwal Piket")
	->setKeywords("Rekap Jadwal Piket")
	->setCategory("Rekap Jadwal Piket");
$phpExcel->getActiveSheet()->setTitle("Jadwal Piket");
$phpExcel->setActiveSheetIndex(0);
$sheet = $phpExcel->getActiveSheet();
$judul_rekap = "REKAPAN JADWAL PIKET PERIODE " . $tanggalPeriode;
$sheet->setCellValue("A1", "PT. PELINDO MARINE SERVICES")
	->setCellValue("A2", "DEPARTEMEN ")
	->setCellValue("A4", "No")
	->setCellValue("B4", "NAMA ");

$kolAwal=0; $hurufAwal=''; $tglIsi=0;
for($i=2; $i<95; $i++){
	$sheet->getColumnDimension($huruf[$i])->setWidth(2.7);
	if($kolAwal==0) $hurufAwal = $huruf[$i];
	$kolAwal++;
	if($kolAwal==3){
		$kolAwal=0; $tglIsi++;
		$sheet->mergeCells($hurufAwal . "4:". $huruf[$i] ."4");
		$sheet->setCellValue($hurufAwal.'4', 'TGL' . $tglIsi);
	}
	
}

$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(45);

$sheet->getStyle('A4:CQ4')->applyFromArray($styleheader); 
//// sampai disini
$dari = 5;
$reqPeriode = httpFilterGet("reqPeriode");
$reqDepartemenId= httpFilterGet("reqDepartemenId");
$tanggalPeriode = substr($reqPeriode, 0, 2) . '-' . substr($reqPeriode, -4);
$orangPiket = new DaftarJagaPiket();
$orangPiket->selectDaftarJaga(array("A.DEPARTEMEN_ID" => $reqDepartemenId, "TO_CHAR(TANGGAL, 'MMYYYY')" => $reqPeriode));
$baris=0;
while($orangPiket->nextRow()) {
	$sheet->setCellValue("A2", "DEPARTEMEN " . $orangPiket->getField("DEPARTEMEN"));
	$baris++;
	$jadwal_piket = new DaftarJagaPiket();
	$jadwal_piket->selectByParamsWithTanggal(array("A.DEPARTEMEN_ID" => $reqDepartemenId, "TO_CHAR(TANGGAL, 'MMYYYY')" => $reqPeriode, "A.PEGAWAI_ID"=>$orangPiket->getField("PEGAWAI_ID")),-1,-1,""," ORDER BY TANGGAL, PIKET_ID ");
	$sheet->setCellValue('A'. $dari, $baris);
	$sheet->setCellValue('B'. $dari, $orangPiket->getField("PEGAWAI"));

	while($jadwal_piket->nextRow()){
		$kolAwal=0; $hurufAwal='';  $i=2; $tglTemp = 0;
		while($i<95){
			$tglTemp++;
			$tglku = substr("0" . $tglTemp, -2) .substr($reqPeriode,0,2). substr($reqPeriode,2);
			//$sheet->setCellValue($huruf[$i]. $dari, '1');
			if ($orangPiket->getField("PEGAWAI_ID") == $jadwal_piket->getField("PEGAWAI_ID") AND $tglku == $jadwal_piket->getField("TANGGAL_BANDING") AND strpos($jadwal_piket->getField("SHIFT"), "1")!== false) {
				$sheet->setCellValue($huruf[$i]. $dari, '1');
				$sheet->getStyle($huruf[$i]. $dari)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$sheet->getStyle($huruf[$i]. $dari)->getFill()->getStartColor()->setARGB('00000000');
			}
			$i++;
			if ($orangPiket->getField("PEGAWAI_ID") == $jadwal_piket->getField("PEGAWAI_ID") AND $tglku == $jadwal_piket->getField("TANGGAL_BANDING") AND strpos($jadwal_piket->getField("SHIFT"), "2")!== false) {
				$sheet->setCellValue($huruf[$i]. $dari, '1');
				$sheet->getStyle($huruf[$i]. $dari)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$sheet->getStyle($huruf[$i]. $dari)->getFill()->getStartColor()->setARGB('00000000');
			}
			$i++;
			if ($orangPiket->getField("PEGAWAI_ID") == $jadwal_piket->getField("PEGAWAI_ID") AND $tglku == $jadwal_piket->getField("TANGGAL_BANDING") AND strpos($jadwal_piket->getField("SHIFT"), "3")!== false) {
				$sheet->setCellValue($huruf[$i]. $dari, '1');
				$sheet->getStyle($huruf[$i]. $dari)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$sheet->getStyle($huruf[$i]. $dari)->getFill()->getStartColor()->setARGB('00000000');
			}
			$i++;
		}
	}
	unset($jadwal_piket);
	$sheet->getStyle('A'. $dari .':CQ' . $dari)->applyFromArray($styleBody); 
	$sheet->getStyle('A'. $dari)->applyFromArray($styleCenter);
	$dari++;
}
$namaFile = 'jadwal_piket_' . date('Ymd:His') . '.xls';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$namaFile");
header("Cache-Control: max-age=0");
$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;

//while($report_ibt->nextRow())