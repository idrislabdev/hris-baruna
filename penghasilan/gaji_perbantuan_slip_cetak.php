<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");

require_once "../WEB-INF/lib/excel/class.writeexcel_workbookbig.inc.php";
require_once "../WEB-INF/lib/excel/class.writeexcel_worksheet.inc.php";

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$fname = tempnam("/tmp", "cetak_gaji.xls");
$workbook = & new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$gaji_awal_bulan = new GajiAwalBulan();

$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");

$gaji_awal_bulan->selectByParamsGajiLihat(array("A.PEGAWAI_ID" => $reqId), -1, -1, "", "", $reqPeriode, 2);     		
$gaji_awal_bulan->firstRow();

$tempNama = $gaji_awal_bulan->getField("NAMA");
$tempNIPP = $gaji_awal_bulan->getField("NRP");
$tempKelas = $gaji_awal_bulan->getField("KELAS");
$tempJabatan = $gaji_awal_bulan->getField("JABATAN");
$tempGajiPokok = $gaji_awal_bulan->getField("GAJI_POKOK");
$tempGolongan = $gaji_awal_bulan->getField("PANGKAT");
$tempStatusNikah = $gaji_awal_bulan->getField("STATUS_KELUARGA");
$tempPeriodeBulan = getNamePeriode($gaji_awal_bulan->getField("BULANTAHUN"));
$tempRekening = $gaji_awal_bulan->getField("REKENING");
$tempDepartemen = $gaji_awal_bulan->getField("DEPARTEMEN");
$tempNPWP = $gaji_awal_bulan->getField("NPWP");

$json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
$tempPenghasilan = $json_gaji->{"MERIT_PMS"}{0};
$tempTunjanganAlih = $json_gaji->{"TUNJANGAN_PERBANTUAN"}{0};
$tempRapel = $json_gaji->{"TUNJANGAN_JABATAN"}{0};
$tempPrestasiPotongan = $json_gaji->{"TPP_PMS"}{0};

$json_sumbangan = json_decode($gaji_awal_bulan->getField("SUMBANGAN_JSON"));
$tempSumbanganPPh = $json_sumbangan->{"POTONGAN_PPH21"}{0};

$tempJumlahKotor = $tempPenghasilan + $tempTunjanganAlih + $tempRapel + $tempPrestasiPotongan + $tempSumbanganPPh;

$json_potongan = json_decode($gaji_awal_bulan->getField("POTONGAN_JSON"));
$tempIuranTaspen = $json_potongan->{"IURAN_TASPEN"}{0};
$tempDanaPensiun = $json_potongan->{"DANA_PENSIUN"}{0};
$tempIuranKesehatan = $json_potongan->{"IURAN_KESEHATAN"}{0};
$tempPotonganPPh = $json_sumbangan->{"POTONGAN_PPH21"}{0};
$tempSumbanganMasjid = 0;
$tempAsuransiJiwasraya = 0;
$tempArisanPerispindo = $json_potongan->{"ARISAN_PERISPINDO"}{0};
$tempIuranSPPI = $json_potongan->{"IURAN_SPPI"}{0};
$tempIuranPurnaBakti = $json_potongan->{"IURAN_PURNA_BAKTI"}{0};
$tempLainPotonganDinas = 0;

$tempJumlahPotongan = $tempIuranTaspen + $tempDanaPensiun + $tempIuranKesehatan + $tempPotonganPPh + $tempSumbanganMasjid + $tempAsuransiJiwasraya + $tempArisanPerispindo + $tempIuranSPPI + $tempIuranPurnaBakti;

$tempPembulatan = $tempJumlahKotor - $tempJumlahPotongan;
$tempPembulatan = 1000 - ($tempPembulatan % 1000);
$tempJumlahKotor = $tempPenghasilan + $tempTunjanganAlih + $tempRapel + $tempPrestasiPotongan + $tempSumbanganPPh + $tempPembulatan;


$tempJumlahDiterima = $tempJumlahKotor - $tempJumlahPotongan;

//$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
$json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
$tempBNI = $json_potongan_lain->{"BNI"}{0};
$tempBukopin = $json_potongan_lain->{"BUKOPIN"}{0};
$tempBRI = $json_potongan_lain->{"BRI"}{0};
$tempBTN = $json_potongan_lain->{"BTN"}{0};
$tempBPD = $json_potongan_lain->{"BPD"}{0};
$tempSimpananWajibKoperasi = $json_potongan->{"SIMPANAN_WAJIB_KOPERASI"}{0};
$tempMitraKaryaAnggota = $json_potongan_lain->{"MITRA_KARYA_ANGGOTA"}{0};
$tempInfaq = $json_potongan_lain->{"INFAQ"}{0};
$tempKoperasi = $json_potongan_lain->{"KOPERASI"}{0};
$tempLainPotongan = $json_potongan_lain->{"POTONGAN_LAIN"}{0};

$tempJumlahLain = $tempBNI + $tempBukopin + $tempBRI + $tempBTN + $tempBPD + $tempSimpananWajibKoperasi + $tempMitraKaryaAnggota + $tempInfaq + $tempKoperasi + $tempLainPotongan;

$tempJumlahDibayar = $tempJumlahDiterima - $tempJumlahLain;

$worksheet->set_column(0, 0, 8.43);
$worksheet->set_column(1, 1, 24.43);
$worksheet->set_column(2, 2, 0.75);
$worksheet->set_column(3, 3, 18.71);
$worksheet->set_column(4, 4, 21.86);
$worksheet->set_column(5, 5, 23.57);
$worksheet->set_column(6, 6, 0.75);
$worksheet->set_column(7, 7, 18.71);

$text_format =& $workbook->addformat(array( size => 10, font => 'Arial Narrow'));
$text_format->set_color('black');
$text_format->set_size(10);
$text_format->set_border_color('black');

$text_format_bold =& $workbook->addformat(array( size => 10, font => 'Arial Narrow'));
$text_format_bold->set_color('black');
$text_format_bold->set_size(10);
$text_format_bold->set_bold(1);

$text_format_left =& $workbook->addformat(array( size => 10, font => 'Arial Narrow', align => 'left'));
$text_format_left->set_color('black');
$text_format_left->set_size(10);
$text_format_left->set_border_color('black');

$text_format_wrapping =& $workbook->addformat(array( size => 10, font => 'Arial Narrow'));
$text_format_wrapping->set_text_wrap();
$text_format_wrapping->set_color('black');
$text_format_wrapping->set_size(10);
$text_format_wrapping->set_fg_color('white');
$text_format_wrapping->set_border_color('black');
$text_format_wrapping->set_left(1);
$text_format_wrapping->set_right(1);
$text_format_wrapping->set_top(1);
$text_format_wrapping->set_align('vcenter');

$uang =& $workbook->addformat(array(num_format => '#,##0', size => 10, font => 'Arial Narrow', align => 'right'));
$uang->set_color('black');
$uang->set_size(10);
$uang->set_border_color('black');

//$worksheet->insert_bitmap('B2', 'images/logo2.bmp', 15, 5);

$worksheet->write(1, 1, "(Persero) Pelabuhan Indonesia III", $text_format_bold);

$worksheet->write(2, 1, "A / NIPP", $text_format);
$worksheet->write(2, 2, ":", $text_format);
$worksheet->write(2, 3, $tempNama." - ".$tempNIPP, $text_format);

$worksheet->write(3, 1, "S / Jabatan", $text_format);
$worksheet->write(3, 2, ":", $text_format);
$worksheet->write(3, 3, $tempKelas." - ".$tempJabatan, $text_format);
$worksheet->write(3, 5, "Periode Bulan", $text_format);
$worksheet->write(3, 6, ":", $text_format);
$worksheet->write(3, 7, $tempPeriodeBulan, $text_format);

$worksheet->write(4, 1, "I Pokok/Golongan/Status Keluarga", $text_format);
$worksheet->write(4, 2, ":", $text_format);
$worksheet->write(4, 3, $tempGajiPokok." - ".$tempGolongan." - ".$tempStatusNikah, $text_format);
$worksheet->write(4, 5, "Rekening Bank", $text_format);
$worksheet->write(4, 6, ":", $text_format);
$worksheet->write(4, 7, $tempRekening, $text_format_left);

$worksheet->write(5, 1, "Divisi", $text_format);
$worksheet->write(5, 2, ":", $text_format);
$worksheet->write(5, 3, $tempDepartemen, $text_format);
$worksheet->write(5, 5, "NPWP", $text_format);
$worksheet->write(5, 6, ":", $text_format);
$worksheet->write(5, 7, $tempNPWP, $text_format);

$worksheet->write(7, 1, "A. Penghasilan", $text_format_bold);
$worksheet->write(7, 5, "C. Jumlah yang diterima (A-B)", $text_format_bold);
$worksheet->write(7, 6, ":", $text_format);
$worksheet->write(7, 7, $tempJumlahDiterima, $uang);

$worksheet->write(8, 1, "Penghasilan", $text_format);
$worksheet->write(8, 2, ":", $text_format);
$worksheet->write(8, 3, $tempPenghasilan, $uang);

$worksheet->write(9, 1, "Sumbangan PPh 21", $text_format);
$worksheet->write(9, 2, ":", $text_format);
$worksheet->write(9, 3, $tempSumbanganPPh, $uang);

$worksheet->write(10, 1, "T. Alih / T. Dik", $text_format);
$worksheet->write(10, 2, ":", $text_format);
$worksheet->write(10, 3, $tempTunjanganAlih , $uang);

$worksheet->write(11, 1, "Pembulatan", $text_format);
$worksheet->write(11, 2, ":", $text_format);
$worksheet->write(11, 3, $tempPembulatan, $uang);

$worksheet->write(12, 1, "Rapel / Tunjab", $text_format);
$worksheet->write(12, 2, ":", $text_format);
$worksheet->write(12, 3, $tempRapel, $uang);
$worksheet->write(12, 5, "D. Lain-lain", $text_format_bold);

$worksheet->write(13, 1, "T. Prestasi - Potongan", $text_format);
$worksheet->write(13, 2, ":", $text_format);
$worksheet->write(13, 3, $tempPrestasiPotongan, $uang);

$worksheet->write(13, 5, "1. BNI", $text_format);
$worksheet->write(13, 6, ":", $text_format);
$worksheet->write(13, 7, $tempBNI, $uang);

$worksheet->write(14, 5, "2. Bukopin", $text_format);
$worksheet->write(14, 6, ":", $text_format);
$worksheet->write(14, 7, $tempBukopin, $uang);

$worksheet->write(15, 1, "Jumlah Kotor", $text_format_bold);
$worksheet->write(15, 2, ":", $text_format);
$worksheet->write(15, 3, $tempJumlahKotor, $uang);
$worksheet->write(15, 5, "3. BRI", $text_format);
$worksheet->write(15, 6, ":", $text_format);
$worksheet->write(15, 7, $tempBRI, $uang);

$worksheet->write(16, 5, "4. BTN", $text_format);
$worksheet->write(16, 6, ":", $text_format);
$worksheet->write(16, 7, $tempBTN, $uang);

$worksheet->write(17, 1, "B. Potongan", $text_format_bold);
$worksheet->write(17, 5, "5. BPD", $text_format);
$worksheet->write(17, 6, ":", $text_format);
$worksheet->write(17, 7, $tempBPD, $uang);

$worksheet->write(18, 1, "Iuran Taspen", $text_format);
$worksheet->write(18, 2, ":", $text_format);
$worksheet->write(18, 3, $tempIuranTaspen, $uang);
$worksheet->write(18, 5, "6. Simpanan Wajib Koperasi", $text_format);
$worksheet->write(18, 6, ":", $text_format);
$worksheet->write(18, 7, $tempSimpananWajibKoperasi, $uang);

$worksheet->write(19, 1, "Dana Pensiun", $text_format);
$worksheet->write(19, 2, ":", $text_format);
$worksheet->write(19, 3, $tempDanaPensiun, $uang);
$worksheet->write(19, 5, "7. Mitra Karya Anggota", $text_format);
$worksheet->write(19, 6, ":", $text_format);
$worksheet->write(19, 7, $tempMitraKaryaAnggota, $uang);

$worksheet->write(20, 1, "Iuran Kesehatan", $text_format);
$worksheet->write(20, 2, ":", $text_format);
$worksheet->write(20, 3, $tempIuranKesehatan, $uang);
$worksheet->write(20, 5, "8. Infaq", $text_format);
$worksheet->write(20, 6, ":", $text_format);
$worksheet->write(20, 7, $tempInfaq, $uang);

$worksheet->write(21, 1, "Potongan PPh 21", $text_format);
$worksheet->write(21, 2, ":", $text_format);
$worksheet->write(21, 3, $tempPotonganPPh, $uang);
$worksheet->write(21, 5, "9. Koperasi", $text_format);
$worksheet->write(21, 6, ":", $text_format);
$worksheet->write(21, 7, $tempKoperasi, $uang);

$worksheet->write(22, 1, "Sumbangan Masjid", $text_format);
$worksheet->write(22, 2, ":", $text_format);
$worksheet->write(22, 3, $tempSumbanganMasjid, $uang);
$worksheet->write(22, 5, "10. Lain-lain Potongan", $text_format);
$worksheet->write(22, 6, ":", $text_format);
$worksheet->write(22, 7, $tempLainPotongan, $uang);

$worksheet->write(23, 1, "Asuransi Jiwasraya", $text_format);
$worksheet->write(23, 2, ":", $text_format);
$worksheet->write(23, 3, $tempAsuransiJiwasraya, $uang);

$worksheet->write(24, 1, "Arisan Perispindo", $text_format);
$worksheet->write(24, 2, ":", $text_format);
$worksheet->write(24, 3, $tempArisanPerispindo, $uang);
$worksheet->write(24, 5, "Jumlah Lain-lain", $text_format);
$worksheet->write(24, 6, ":", $text_format);
$worksheet->write(24, 7, $tempJumlahLain, $uang);

$worksheet->write(25, 1, "Iuran SPPI", $text_format);
$worksheet->write(25, 2, ":", $text_format);
$worksheet->write(25, 3, $tempIuranSPPI, $uang);
$worksheet->write(25, 5, "Jumlah dibayar C - D", $text_format_bold);
$worksheet->write(25, 6, ":", $text_format);
$worksheet->write(25, 7, $tempJumlahDibayar, $uang);

$worksheet->write(26, 1, "Iuran Purna Bakti", $text_format);
$worksheet->write(26, 2, ":", $text_format);
$worksheet->write(26, 3, $tempIuranPurnaBakti, $uang);

$worksheet->write(27, 1, "Lain-lain Potongan Dinas", $text_format);
$worksheet->write(27, 2, ":", $text_format);
$worksheet->write(27, 3, $tempLainPotongan, $uang);

$worksheet->write(28, 6, "Surabaya, 02 Mei 2012", $text_format);

$worksheet->write(29, 1, "Jumlah Potongan", $text_format_bold);
$worksheet->write(29, 2, ":", $text_format);
$worksheet->write(29, 3, $tempJumlahPotongan, $uang);
$worksheet->write(29, 6, "Pelaksana Gaji / Upah", $text_format);

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"cetak_gaji.xls\"");
header("Content-Disposition: inline; filename=\"cetak_gaji.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);
?>