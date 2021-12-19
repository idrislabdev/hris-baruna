<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");

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
$tempAsuransiJiwasraya = $json_potongan->{"ASURANSI_JIWASRAYA"}{0};
$tempArisanPerispindo = $json_potongan->{"ARISAN_PERISPINDO"}{0};
$tempIuranSPPI = $json_potongan->{"IURAN_SPPI"}{0};
$tempIuranPurnaBakti = $json_potongan->{"IURAN_PURNA_BAKTI"}{0};
$tempLainPotonganDinas = $json_potongan->{"ABSENSI_DINAS"}{0};

$tempJumlahPotongan = $tempIuranTaspen + $tempDanaPensiun + $tempIuranKesehatan + $tempPotonganPPh + $tempSumbanganMasjid + $tempAsuransiJiwasraya + $tempArisanPerispindo + $tempIuranSPPI + $tempIuranPurnaBakti + $tempLainPotonganDinas;

//$json_tanggungan = json_decode($gaji_awal_bulan->getField("TANGGUNGAN_JSON"));
$json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
$tempBNI = $json_potongan_lain->{"BNI"}{0};
$tempBukopin = $json_potongan_lain->{"BUKOPIN"}{0};
$tempBRI = $json_potongan_lain->{"BRI"}{0};
$tempBTN = $json_potongan_lain->{"BTN"}{0};
$tempBPD = $json_potongan_lain->{"BPD"}{0};
$tempSimpananWajibKoperasi = $json_potongan->{"SIMPANAN_WAJIB_KOPERASI"}{0};
$tempSimpananWajibKoperasi3Laut = $json_potongan->{"SIMPANAN_WAJIB_KOPERASI_3LAUT"}{0};
$tempMitraKaryaAnggota = $json_potongan_lain->{"MITRA_KARYA_ANGGOTA"}{0};
$tempInfaq = $json_potongan_lain->{"INFAQ"}{0};
$tempKoperasi = $json_potongan_lain->{"KOPERASI"}{0};
$tempKoperasiPMS = $json_potongan_lain->{"KOPERASI_PMS"}{0};
$tempLainPotongan = $json_potongan_lain->{"POTONGAN_LAIN"}{0};

$tempJumlahLain = $tempBNI + $tempBukopin + $tempBRI + $tempBTN + $tempBPD + $tempSimpananWajibKoperasi + $tempMitraKaryaAnggota + $tempInfaq + $tempKoperasi + $tempLainPotongan;


$tempPembulatan = $tempJumlahKotor - ($tempJumlahPotongan + $tempJumlahLain);
$total_pembulatan = $tempPembulatan % 1000;
if($total_pembulatan == 0)
	$total_pembulatan = 1000;
$tempPembulatan = 1000 - $total_pembulatan;
$tempJumlahKotor = $tempPenghasilan + $tempTunjanganAlih + $tempRapel + $tempPrestasiPotongan + $tempSumbanganPPh + $tempPembulatan;


$tempJumlahDiterima = $tempJumlahKotor - $tempJumlahPotongan;

$tempJumlahDibayar = $tempJumlahDiterima - $tempJumlahLain;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../simpeg/js/globalfunction.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-gaji/insentif_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Form Data Gaji</span>
    </div>
    <table>

        <tr>
            <td>Nama / NRP</td>
            <td>
                <input name="reqNama" title="Nama harus diisi" style="width:233px;" readonly type="text" value="<?=$tempNama?>" />&nbsp;&nbsp;
                <input name="reqNIPP" title="NIPP harus diisi" style="width:100px;" readonly type="text" value="<?=$tempNIPP?>" />
            </td>
        </tr>
        <tr>
            <td>Kelas / Jabatan</td>
            <td>
                <input name="reqKelas" title="Kelas harus diisi" style="width:50px;" readonly type="text" value="<?=$tempKelas?>" />&nbsp;-&nbsp;
                <input name="reqJabatan" title="Jabatan harus diisi" style="width:280px;" readonly type="text" value="<?=$tempJabatan?>" />
            </td>
            <td>Periode Bulan</td>
            <td>
                <input name="reqPeriodeBulan" title="Periode Bulan harus diisi" style="width:150px;" readonly type="text" value="<?=$tempPeriodeBulan?>" />&nbsp;&nbsp;
            </td>            
        </tr>
        <tr>
            <td>Gaji Pokok</td>
            <td>
                <input name="reqGajiPokok" title="Gaji Pokok harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempGajiPokok)?>" />&nbsp;-&nbsp;
                <input name="reqGolongan" title="Jabatan harus diisi" style="width:40px;" readonly type="text" value="<?=$tempGolongan?>" />&nbsp;&nbsp;
            	<input name="reqStatusNikah" title="Status Nikah harus diisi" style="width:40px;" readonly type="text" value="<?=$tempStatusNikah?>" />
            </td>
            <td>Rekening Bank</td>
            <td>
                <input name="reqRekeningBank" title="Rekening Bank harus diisi" style="width:150px;" readonly type="text" value="<?=$tempRekeningBank?>" />&nbsp;&nbsp;
            </td>            
        </tr>        
        <tr>
            <td><strong>A. Penghasilan</strong></td> 
        </tr>         

        <tr>
            <td>Penghasilan</td>
            <td align="center">
                <input name="reqPenghasilan" title="Penghasilan harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempPenghasilan)?>" />&nbsp;&nbsp;
            </td> 
            <td><strong>C. Jumlah yang diterima (A-B)</strong></td>
            <td>
                <input name="reqJumlahDiterima" title="Jumlah Diterima harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempJumlahDiterima)?>" />&nbsp;&nbsp;
            </td>              
        </tr>
        <tr>
            <td>Sumbangan PPh. 21</td>
            <td align="center">
                <input name="reqSumbanganPPh" title="Sumbangan PPh 21 harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempSumbanganPPh)?>" />&nbsp;&nbsp;
            </td> 
            <td><strong>D. Lain-lain</strong></td>
        </tr>  
        <tr>
            <td>T. Alih / T. Dik</td>
            <td align="center">
                <input name="reqTunjanganAlih" title="Tunjangan Alih harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempTunjanganAlih)?>" />&nbsp;&nbsp;
            </td> 
            <td>B N I</td>
            <td>
                <input name="reqBNI" title="BNI harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempBNI)?>" />&nbsp;&nbsp;
            </td>              
        </tr> 
        <tr>
            <td>Pembulatan</td>
            <td align="center">
                <input name="reqPembulatan" title="Pembulatan harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempPembulatan)?>" />&nbsp;&nbsp;
            </td> 
            <td>Bukopin</td>
            <td>
                <input name="reqBukopin" title="Bukopin harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempBukopin)?>" />&nbsp;&nbsp;
            </td>              
        </tr> 
        <tr>
            <td>Rapel / Tunjangan</td>
            <td align="center">
                <input name="reqRapel" title="Rapel harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempRapel)?>" />&nbsp;&nbsp;
            </td> 
            <td>B R I</td>
            <td>
                <input name="reqBRI" title="BRI harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempBRI)?>" />&nbsp;&nbsp;
            </td>              
        </tr>                                 
        <tr>
            <td>T. Prestasi - T. Potongan</td>
            <td align="center">
                <input name="reqPrestasiPotongan" title="Prestasi Potongan harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempPrestasiPotongan)?>" />&nbsp;&nbsp;
            </td> 
            <td>B T N</td>
            <td>
                <input name="reqBTN" title="BTN harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempBTN)?>" />&nbsp;&nbsp;
            </td>              
        </tr>
        <tr>
            <td>Jumlah Kotor</td>
            <td align="center">
                <input name="reqJumlahKotor" title="Jumlah Kotor harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempJumlahKotor)?>" />&nbsp;&nbsp;
            </td> 
            <td>B P D</td>
            <td>
                <input name="reqBPD" title="BPD harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempBPD)?>" />&nbsp;&nbsp;
            </td>              
        </tr>                                
        <tr>
            <td colspan="2"><strong>B. Potongan</strong></td>
            <td>Simpanan Wajib Kopegpel 3</td>
            <td>
                <input name="reqSimpananWajibKoperasi" title="Simpanan Wajib Koperasi harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempSimpananWajibKoperasi)?>" />&nbsp;&nbsp;
            </td>              
        </tr>                                
        <tr>
            <td>Iuran Taspen</td>
            <td align="center">
                <input name="reqIuranTaspen" title="Iuran Taspen harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempIuranTaspen)?>" />&nbsp;&nbsp;
            </td> 
            <td>Simpanan Wajib Kop 3 Laut</td>
            <td>
                <input name="reqSimpananWajibKoperasi3Laut" title="Simpanan Wajib Koperasi 3 Laut harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempSimpananWajibKoperasi3Laut)?>" />&nbsp;&nbsp;
            </td>            
        </tr>
        <tr>
            <td>Dana Pensiun</td>
            <td align="center">
                <input name="reqDanaPensiun" title="Dana Pensiun harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempDanaPensiun)?>" />&nbsp;&nbsp;
            </td>
            <td>Mitra Karya Anggota</td>
            <td>
                <input name="reqMitraKaryaAnggota" title="Mitra Karya Anggota harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempMitraKaryaAnggota)?>" />&nbsp;&nbsp;
            </td>             
        </tr>  
        <tr>
            <td>Iuran Kesehatan</td>
            <td align="center">
                <input name="reqIuranKesehatan" title="Iuran Kesehatan harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempIuranKesehatan)?>" />&nbsp;&nbsp;
            </td> 
            <td>Infaq</td>
            <td>
                <input name="reqInfaq" title="Infaq harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempInfaq)?>" />&nbsp;&nbsp;
            </td>
        </tr>             
        <tr>
            <td>Potongan PPh 21</td>
            <td align="center">
                <input name="reqPotonganPPh" title="Potongan PPh harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempPotonganPPh)?>" />&nbsp;&nbsp;
            </td> 
            <td>Koperasi Peg P3</td>
            <td>
                <input name="reqKoperasi" title="Koperasi harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempKoperasi)?>" />&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td>Sumbangan Masjid</td>
            <td align="center">
                <input name="reqSumbanganMasjid" title="Sumbangan Masjid harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempSumbanganMasjid)?>" />&nbsp;&nbsp;
            </td>
            <td>Koperasi 3 Laut</td>
            <td>
                <input name="reqKoperasiPMS" title="Koperasi PMS harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempKoperasiPMS)?>" />&nbsp;&nbsp;
            </td>             
        </tr>
        <tr>
            <td>Jaminan Hari Tua</td>
            <td align="center">
                <input name="reqAsuransiJiwasraya" title="Jaminan Hari Tua harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempAsuransiJiwasraya)?>" />&nbsp;&nbsp;
            </td> 
            <td>Lain-lain Potongan</td>
            <td>
                <input name="reqLainPotongan" title="Lain Potongan harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempLainPotongan)?>" />&nbsp;&nbsp;
            </td>
        </tr>   
        <tr>
            <td>Arisan Perispindo</td>
            <td align="center">
                <input name="reqArisanPerispindo" title="Arisan Perispindo harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempArisanPerispindo)?>" />&nbsp;&nbsp;
            </td>           
            <td>Jumlah Lain-lain</td>
            <td>
                <input name="reqJumlahLain" title="Jumlah Lain harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempJumlahLain)?>" />&nbsp;&nbsp;
            </td>
        </tr>     
        <tr>
            <td>Iuran SPPI</td>
            <td align="center">
                <input name="reqIuranSPPI" title="Iuran SPPI harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempIuranSPPI)?>" />&nbsp;&nbsp;
            </td>           
            <td>Jumlah dibayar C - D</td>
            <td>
                <input name="reqJumlahDibayar" title="Jumlah Dibayar harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempJumlahDibayar)?>" />&nbsp;&nbsp;
            </td>
        </tr>     
        <tr>
            <td>Iuran Purna Bakti</td>
            <td align="center">
                <input name="reqIuranPurnaBakti" title="Iuran Purna Bakti harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempIuranPurnaBakti)?>" />&nbsp;&nbsp;
            </td>           
        </tr>   
        <tr>
            <td>Lain-lain Potongan Dinas</td>
            <td align="center">
                <input name="reqLainPotonganDinas" title="Lain-lain Potongan Dinas harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempLainPotonganDinas)?>" />&nbsp;&nbsp;
            </td>           
        </tr>   
        <tr>
            <td>Jumlah Potongan</td>
            <td align="center">
                <input name="reqJumlahPotongan" title="Jumlah Potongan harus diisi" style="width:150px;" readonly type="text" value="<?=currencyToPage($tempJumlahPotongan)?>" />&nbsp;&nbsp;
            </td>           
        </tr>                                                                      
    </table>
</div>
</body>
</html>