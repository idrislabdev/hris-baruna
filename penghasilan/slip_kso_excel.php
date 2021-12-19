<?php

//header("Content-type: application/vnd-ms-excel");
//header("Content-Disposition: attachment; filename=gaji_kso_excel.xls");


include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiKondisi.php");
include_once("../WEB-INF/classes/base-gaji/PotonganKondisi.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriode.php");
include_once("../WEB-INF/classes/base-gaji/ProsesGajiLock.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");

$gaji_awal_bulan = new GajiAwalBulan();
$gaji_awal_bulan_count = new GajiAwalBulan();
$gaji_kondisi = new GajiKondisi();
$potongan_kondisi = new PotonganKondisi();
$proses_gaji_lock = new ProsesGajiLock();
$gaji_periode = new GajiPeriode();

$tinggi = 172;

$reqPegawaiId = httpFilterGet("reqPegawaiId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
$reqDepartemenId = httpFilterGet("reqDepartemenId");

$periode = getNamePeriode($reqPeriode);
/* INISIALISASI HEADER */
$gaji_kondisi->selectByParamsParameterGaji(array("B.JENIS_PEGAWAI_ID" => $reqJenisPegawaiId));
$potongan_kondisi->selectByParamsParameterPotongan(array("B.JENIS_PEGAWAI_ID" => $reqJenisPegawaiId, "JENIS_POTONGAN" => "P"));

$gaji = 0;
$potongan = 0;
$potongan_lain = 0;
while($gaji_kondisi->nextRow())
{
	$arrGaji[$gaji]["NAMA"] = $gaji_kondisi->getField("NAMA");
	$arrGaji[$gaji]["PREFIX"] = $gaji_kondisi->getField("PREFIX");
	$gaji++;
}
while($potongan_kondisi->nextRow())
{
	$arrPotongan[$potongan]["NAMA"] = $potongan_kondisi->getField("NAMA");
	$arrPotongan[$potongan]["PREFIX"] = $potongan_kondisi->getField("PREFIX");
	$potongan++;
}

$arrPotonganLain[$potongan_lain]["NAMA"] = "Hutang";
//$arrPotonganLain[$potongan_lain]["PREFIX"] = "POTONGAN_LAIN";
$arrPotonganLain[$potongan_lain]["PREFIX"] = "PIUTANG_PEGAWAI";
$potongan_lain++;


if($reqJenisPegawaiId == "")
{}
else
	$statement .= " AND B.JENIS_PEGAWAI_ID = '".$reqJenisPegawaiId."' ";


$statement .= " AND C.CABANG_ID LIKE '".substr($reqDepartemenId, 3)."%' ";


$statement .= " AND BULANTAHUN = '".$reqPeriode."' ";

if($reqPegawaiId == "")
	$statement .= "";
else
	$statement .= "AND A.PEGAWAI_ID = '".$reqPegawaiId."'";
		

$gaji_awal_bulan->selectByParamsSlipGaji(array(), -1, -1, $statement, "ORDER BY A.PEGAWAI_ID");

?>

<link rel="stylesheet" href="../WEB-INF/css/laporan-pdf.css" type="text/css">
<body>
	<? 
    $i = 0;
	$no_urut = 1;
    while($gaji_awal_bulan->nextRow())
    {
		if(($i % 2) == 0)
		{
		?>

		<?
		}
		?>
		<?
        $total_gaji = 0;
        $total_potongan = 0;
		$total_potongan_lain = 0;
    
        $json_gaji = json_decode($gaji_awal_bulan->getField("GAJI_JSON"));
        $json_potongan = json_decode($gaji_awal_bulan->getField("POTONGAN_JSON"));
        $json_potongan_lain = json_decode($gaji_awal_bulan->getField("POTONGAN_LAIN_JSON"));
        
        $bulan = substr($gaji_awal_bulan->getField("BULANTAHUN"),0,2);
        $nama_bulan = getNameMonth(intval($bulan));
        $tahun = substr($reqPeriode,2,4);
        
        $nama = $gaji_awal_bulan->getField("NAMA");
        $nrp = $gaji_awal_bulan->getField("NRP");
        $kelas = $gaji_awal_bulan->getField("KELAS");
        $jabatan = $gaji_awal_bulan->getField("JABATAN");
        $departemen = $gaji_awal_bulan->getField("DEPARTEMEN");
        $nama_departemen = $gaji_awal_bulan->getField("DEPARTEMEN_NAMA");
        $rekening_no = $gaji_awal_bulan->getField("REKENING_NO");
        $npwp = $gaji_awal_bulan->getField("NPWP");
        $gaji_pokok = $json_gaji->{"MERIT_PMS"}{0};
    ?>
    
    	<div class="area-slip-gaji">
        	<table class="header-slip">
                <tr>
                    <td colspan="2"><span class="dashed-bawah">YAYASAN BARUNAWATI BIRU SURABAYA</span></td>
                    <td style="text-align:center">SLIP GAJI</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td>NAMA</td>
                    <td>:</td>
                    <td><?=$nama?></td>
                    <td>NIPP</td>
                    <td>:</td>
                    <td><?=$nrp?></td>
                </tr>
                <tr>
                    <td>KELAS / JABATAN</td>
                    <td>:</td>
                    <td><?=$kelas?> / <?=$jabatan?></td>
                    <td>PERIODE BULAN</td>
                    <td>:</td>
                    <td><?=$nama_bulan?> <?=$tahun?></td>
                </tr>
                <tr>
                    <td>GAJI POKOK</td>
                    <td>:</td>
                    <td><?=numberToInaReport($gaji_pokok)?></td>
                    <td>REK BANK</td>
                    <td>:</td>
                    <td><?=$rekening_no?></td>
                </tr>
                <tr>
                    <td>UNIT KERJA</td>
                    <td>:</td>
                    <td><?=$nama_departemen?></td>
                    <td>No. Urut</td>
                    <td>:</td>
                    <td><?=$no_urut?></td>
                </tr>
            </table>
            
            <table class="slip-gaji">
                <tr>
                    <td valign="top">
                        <table>
                            <tr>
                                <td>A.</td>
                                <td colspan="3">PENERIMAAN</td>
                            </tr>
                            <?
                            for ( $j=0 ; $j<$gaji ; $j++ )
                            {	
                            ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td><?=$j+1?>. <?=$arrGaji[$j]["NAMA"]?></td>
                                <td>:</td>
                                <td class="kanan"><?=coalesce(numberToInaReport($json_gaji->{$arrGaji[$j]["PREFIX"]}{0}), 0) ?></td>
                            </tr>
                            <?
                                $total_gaji += $json_gaji->{$arrGaji[$j]["PREFIX"]}{0}; 
                            }
                            ?>
                            <tr>
                                <td style="text-align: center" colspan="2">Jumlah Kotor</td>
                                <td>:</td>
                                <td class="kanan"><span class="dashed-atas"><?= numberToInaReport($total_gaji) ?></span></td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <tr>
                                <td>B.</td>
                                <td colspan="3">POTONGAN LAIN-LAIN</td>
                            </tr>
                            <?
							$no = 0;
                            for ( $j=0 ; $j<$potongan ; $j++ )
                            {	
                            ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td><?=$j+1?>. <?=$arrPotongan[$j]["NAMA"]?></td>
                                <td>:</td>
                                <td class="kanan"><?=coalesce(numberToInaReport($json_potongan->{$arrPotongan[$j]["PREFIX"]}{0}), 0) ?></td>
                            </tr>
                            <?
                                $total_potongan += $json_potongan->{$arrPotongan[$j]["PREFIX"]}{0}; 
								$no++;
                            }
                            ?>
                            
                            <?
                            for ( $j=0 ; $j<$potongan_lain ; $j++ )
                            {	
                            ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td><?=$no+1?>. <?=$arrPotonganLain[$j]["NAMA"]?></td>
                                <td>:</td>
                                <td class="kanan"><?=coalesce(numberToInaReport($json_potongan_lain->{$arrPotonganLain[$j]["PREFIX"]}{0}), 0) ?></td>
                            </tr>
                            <?
                                $total_potongan_lain += $json_potongan_lain->{$arrPotonganLain[$j]["PREFIX"]}{0}; 
                            }
                            ?>
                            
                            <tr>
                                <td style="text-align: center" colspan="2">Jumlah Lain - lain</td>
                                <td>:</td>
                                <td class="kanan"><span class="dashed-atas"><?= numberToInaReport($total_potongan+$total_potongan_lain) ?></span></td>
                            </tr>
                            <tr>
                                <td style="text-align: center" colspan="2">Jumlah dibayar A - B</td>
                                <td>:</td>
                                <td class="kanan"><span class="dashed-atas"><?= numberToInaReport($total_gaji-($total_potongan+$total_potongan_lain)) ?></span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3" style="text-align:center">SURABAYA, <?= strtoupper(getFormattedDate(date('Y-m-d')))?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3"  style="text-align:center">PELAKSANA GAJI / UPAH</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
    
        <?
            $i++;
			$no_urut++;
            
            if(($i % 2) == 0)
            {
            ?>
                <!--<pagebreak>-->
				
            <?
            }
        }
        ?>
</body>