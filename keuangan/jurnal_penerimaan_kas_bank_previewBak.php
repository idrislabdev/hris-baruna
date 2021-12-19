<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/ReportPrint.php");

$tinggi = 155;
$set= new ReportPrint();

$reqNoBukti= httpFilterGet("reqNoBukti");
$reqPejabat= httpFilterGet("reqPejabat");
$reqParam1= httpFilterGet("reqParam1");
$reqParam2= httpFilterGet("reqParam2");
$reqParam3= httpFilterGet("reqParam3");
$reqParam4= httpFilterGet("reqParam4");

$statement= " AND A.NO_NOTA IN ('".$reqNoBukti."')";

$arrPejabat = explode('-', $reqPejabat);
$pejabat = $arrPejabat[0];
$jabatan = $arrPejabat[1];

$index_set= 0;
$set->selectByParamsJKM(array(), -1, -1,$statement);
//echo $set->query;
while($set->nextRow())
{
	//NO_NOTA, TGL_TRANS, JML_VAL_TRANS, JML_RP_TRANS, NM_AGEN_PERUSH, ALMT_AGEN_PERUSH, KETERANGAN_UTAMA, 
	//BUKTI_PENDUKUNG, NOMOR, KD_BUKU_BESAR, KD_SUB_BANTU, KD_BUKU_PUSAT, NM_BUKU_BESAR_WITH_PARENT,
	//NM_BUKU_BESAR, NM_SUB_BANTU, NM_BUKU_PUSAT,
	//KETERANGAN_DETIL, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, SALDO_RP_DEBET, SALDO_RP_KREDIT, KD_VALUTA
	
	$arrData[$index_set]["NO_NOTA"]= $set->getField("NO_NOTA");
	$arrData[$index_set]["TGL_TRANS"]= $set->getField("TGL_TRANS");
	$arrData[$index_set]["JML_VAL_TRANS"]= $set->getField("JML_VAL_TRANS");
	$arrData[$index_set]["JML_RP_TRANS"]= $set->getField("JML_RP_TRANS");
	$arrData[$index_set]["NM_AGEN_PERUSH"]= $set->getField("NM_AGEN_PERUSH");
	$arrData[$index_set]["ALMT_AGEN_PERUSH"]= $set->getField("ALMT_AGEN_PERUSH");
	$arrData[$index_set]["KETERANGAN_UTAMA"]= $set->getField("KETERANGAN_UTAMA");
	$arrData[$index_set]["BUKTI_PENDUKUNG"]= $set->getField("BUKTI_PENDUKUNG");
	$arrData[$index_set]["NOMOR"]= $set->getField("NOMOR");
	$arrData[$index_set]["KD_BUKU_BESAR"]= $set->getField("KD_BUKU_BESAR");
	$arrData[$index_set]["KD_SUB_BANTU"]= $set->getField("KD_SUB_BANTU");
	$arrData[$index_set]["KD_BUKU_PUSAT"]= $set->getField("KD_BUKU_PUSAT");
	$arrData[$index_set]["NM_BUKU_BESAR_WITH_PARENT"]= $set->getField("NM_BUKU_BESAR_WITH_PARENT");
	$arrData[$index_set]["NM_BUKU_BESAR"]= $set->getField("NM_BUKU_BESAR");
	$arrData[$index_set]["NM_SUB_BANTU"]= $set->getField("NM_SUB_BANTU");
	$arrData[$index_set]["NM_BUKU_PUSAT"]= $set->getField("NM_BUKU_PUSAT");
	$arrData[$index_set]["KETERANGAN_DETIL"]= $set->getField("KETERANGAN_DETIL");
	$arrData[$index_set]["SALDO_VAL_DEBET"]= $set->getField("SALDO_VAL_DEBET");
	$arrData[$index_set]["SALDO_VAL_KREDIT"]= $set->getField("SALDO_VAL_KREDIT");
	$arrData[$index_set]["SALDO_RP_DEBET"]= $set->getField("SALDO_RP_DEBET");
	$arrData[$index_set]["SALDO_RP_KREDIT"]= $set->getField("SALDO_RP_KREDIT");
	$arrData[$index_set]["KD_VALUTA"]= $set->getField("KD_VALUTA");
	$index_set++;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html moznomarginboxes mozdisallowselectionprint>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="cetak/test5.css" type="text/css" />
<script src="../WEB-INF/lib/media/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready( function () {
	   $('#btnCetak').live('click', function () {
			newWindow = window.open('jurnal_penerimaan_kas_bank_print.php?reqNoBukti=<?=$reqNoBukti?>&reqPejabat=<?=$reqPejabat?>&reqParam1=<?=$reqParam1?>&reqParam2=<?=$reqParam2?>&reqParam3=<?=$reqParam3?>&reqParam4=<?=$reqParam4?>', 'Cetak');
			newWindow.focus();
			setTimeout(window.newWindow.close(), 1000);
			//window.newWindow.close();		
	  });  
	});
</script>
</head>

<body>
<input type="button" id="btnCetak" value="Cetak">
<div id="laporan-wrapper" class="dash-bawah">
    <div id="header">
        <div id="laporan-header">
            <div id="laporan-header-atas" class="dash-bawah">
                <div id="laporan-header-kiri">
                    <div><span class="dash-bawah" style="display:inline; padding-bottom:20px;">PT. PELINDO MARINE SERVICE</span></div>
                    <div><br /><br /><br /><span>NO BUKTI : <?=$reqNoBukti?></span></div>
                </div>
                <div id="laporan-header-tengah">
                    <div><br /><br /><span class="dash-bawah" style="display:inline;">BUKTI PENERIMAAN KAS-BANK</span></div>
                    <div><span style="padding-top:7px;">TANGGAL : <?=dateToPageCheck($arrData[0]["TGL_TRANS"])?></span></div>
                </div>
                <div id="laporan-header-kanan">
                    <div id="laporan-pojok" style="text-align:left;">
                        <div id="laporan-pojok-row">
                            <div>TANGGAL PROSES</div>
                            <div>:</div>
                            <div><?=dateToPageCheck($arrData[0]["TGL_TRANS"])?></div>
                        </div>
                        <div id="laporan-pojok-row">
                            <div>HALAMAN</div>
                            <div>:</div>
                            <div>1</div>
                        </div>
                    </div>
                    <div style="position:absolute; bottom:0; right:0;"><span>OPERATOR : <?=date("H:i:s")?><!--18:55:03--></span></div>
                </div>
            </div>
            <div style="float:left; width:100%; border-bottom:1px dashed #000; margin-top:-7px;"></div>
            
        </div>
    </div>
    
    
    <!--<div id="main" style="position:relative;">--> <!-- FIREFOX OK -->
    <div id="main" style="position:relative;">
    
    	<div style="clear:both"></div>
        <!--<div style="float:left; margin-top:-8px;" class="dash-keliling">-->
        <div style="float:left; border:0px solid #C66;">
            <!-- URAIAN -->
            <div id="laporan-uraian">
                <div style="float:left; width:100%;"><span>1. Pemegang Kas harap menerimakan uang sebesar : Rp. <?=numberToIna($arrData[0]["JML_RP_TRANS"])?></span></div>
                <div id="laporan-uraian-row">
                    <div><span>2. Terbilang</span></div>
                    <div><span>:</span></div>
                    <div><span><?=terbilang($arrData[0]["JML_RP_TRANS"])?></span></div>
                </div>
                <div id="laporan-uraian-row">
                    <div><span>3. Dari</span></div>
                    <div><span>:</span></div>
                    <div><span><?=$arrData[0]["NM_AGEN_PERUSH"]?></span></div>
                </div>
                <div id="laporan-uraian-row">
                    <div><span>4. Alamat</span></div>
                    <div><span>:</span></div>
                    <div><span><?=$arrData[0]["ALMT_AGEN_PERUSH"]?></span></div>
                </div>
                <div id="laporan-uraian-row">
                    <div><span>5. Uraian</span></div>
                    <div><span>:</span></div>
                    <div><span><?=$arrData[0]["KETERANGAN_UTAMA"]?></span></div>
                </div>
                <div id="laporan-uraian-row">
                    <div><span>6. Bukti Pendukung</span></div>
                    <div><span>:</span></div>
                    <div><span><?=$arrData[0]["BUKTI_PENDUKUNG"]?></span></div>
                    
                    <div style="float:right; margin-top:-14px; padding-bottom:10px;"><span>Tanggal, <?=dateToPageCheck($arrData[0]["TGL_TRANS"])?></span></div>
                </div>
            </div>
        </div>
        <!---->
        
        <div id="laporan-isi-area" class="dash-kiri dash-kanan">
            <div id="laporan-isi-judul" class="dash-bawah dash-atas"><span>KODE DAN NAMA REKENING</span></div>
            
            <div style="clear:both"></div>
            <div style="display: table;">
                <div id="tabel" style="display: table-row;">            
                    <div style="display: table-cell;"><span>&nbsp;NO.</span></div>
                    <div style="display: table-cell;"><span>MUTASI JURNAL :</span></div>
                    <div style="display: table-cell;"><span>&nbsp;</span></div>
                    <div style="display: table-cell;"><span>DEBET</span></div>
                    <div style="display: table-cell;"><span>KREDIT</span></div>
                </div>
            </div>
            
            <div style="display: table;">
                <?
				for($checkbox_index=0;$checkbox_index<count($arrData);$checkbox_index++)
				{
					$tempNoNota= $arrData[$checkbox_index]["NO_NOTA"];
					$tempTanggalTrans= $arrData[$checkbox_index]["TGL_TRANS"];
					$tempJumlahValTrans= $arrData[$checkbox_index]["JML_VAL_TRANS"];
					$tempJumlahRpTrans= $arrData[$checkbox_index]["JML_RP_TRANS"];
					$tempNamaAgenPerusahaan= $arrData[$checkbox_index]["NM_AGEN_PERUSH"];
					$tempAlamatAgenPerusahaan= $arrData[$checkbox_index]["ALMT_AGEN_PERUSH"];
					$tempKeteranganUtama= $arrData[$checkbox_index]["KETERANGAN_UTAMA"];
					$tempBuktiPendukung= $arrData[$checkbox_index]["BUKTI_PENDUKUNG"];
					$tempNomor= $arrData[$checkbox_index]["NOMOR"];
					$tempKdBukuBesar= $arrData[$checkbox_index]["KD_BUKU_BESAR"];
					$tempKdSubBantu= $arrData[$checkbox_index]["KD_SUB_BANTU"];
					$tempKdBukuPusat= $arrData[$checkbox_index]["KD_BUKU_PUSAT"];
					$tempNamaBukuBesarParent= $arrData[$checkbox_index]["NM_BUKU_BESAR_WITH_PARENT"];
					$tempNamaBukuBesar= $arrData[$checkbox_index]["NM_BUKU_BESAR"];
					$tempNamaSubBantu= $arrData[$checkbox_index]["NM_SUB_BANTU"];
					$tempNamaBukuPusat= $arrData[$checkbox_index]["NM_BUKU_PUSAT"];
					$tempKeteranganDetil= $arrData[$checkbox_index]["KETERANGAN_DETIL"];
					$tempSaldoValDebet= $arrData[$checkbox_index]["SALDO_VAL_DEBET"];
					$tempSaldoValKredit= $arrData[$checkbox_index]["SALDO_VAL_KREDIT"];
					$tempSaldoRpDebet= $arrData[$checkbox_index]["SALDO_RP_DEBET"];
					$tempSaldoRpKredit= $arrData[$checkbox_index]["SALDO_RP_KREDIT"];
					$tempKdValuta= $arrData[$checkbox_index]["KD_VALUTA"];
                ?>
                <div id="tabel" style="display: table-row;">            
                    <div style="display: table-cell;"><span><?=$tempNomor?></span></div>
                    <div style="display: table-cell;"><span><?=$tempKdBukuBesar?> <?=$tempKdSubBantu?> <?=$tempKdBukuPusat?><br /><?=$tempNamaBukuBesar?></span></div>
                    <div style="display: table-cell;"><span>Rp</span></div>
                    <?
                    if($tempSaldoRpDebet == 0)
				    {
					?>
                    <div style="display: table-cell;"><span>&nbsp;</span></div>
                    <div style="display: table-cell;"><span><?=numberToIna($tempSaldoRpKredit)?></span></div>
                    <?
					}
					else
					{
                    ?>
                    <div style="display: table-cell;"><span><?=numberToIna($tempSaldoRpDebet)?></span></div>
                    <div style="display: table-cell;"><span>&nbsp;</span></div>
                    <?
					}
					?>
                </div>
                <?
                }
                ?>
            </div>
            
            <div style="display: table;">
            	<div id="tabel" style="display: table-row;">            
                    <div style="display: table-cell;">&nbsp;</div>
                </div>
                <div id="tabel" style="display: table-row;">
                    <div style="display: table-cell; width:358px; text-align:right;"><span>JUMLAH MUTASI</span></div>
                    <div style="display: table-cell; width:50px;"><span>Rp</span></div>
                    <div style="display: table-cell; width:200px;"><span><?=numberToIna($arrData[0]["JML_RP_TRANS"])?></span></div>
                    <div style="display: table-cell; width:200px;"><span><?=numberToIna($arrData[0]["JML_RP_TRANS"])?></span></div>
                </div>
            </div>
    
        </div>
    </div>
    
    <div id="footer-line" style="border-bottom:1px solid #000;">
        <span style="border-bottom:1px dashed #000; border-left:1px dashed #000; border-right:1px dashed #000;">&nbsp;</span>
    </div>
    <div id="footer">
        <div id="laporan-footer">
            <div id="laporan-periksa" class="dash-kanan dash-kiri dash-bawah">
                <div id="laporan-periksa-kiri">
                    <div id="laporan-diperiksa-row" class="dash-kanan dash-bawah" style="text-align:center;">
                        <span>TELAH DIPERIKSA</span>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan dash-bawah">
                        <div class="dash-kanan "><span>PEJABAT</span></div>
                        <div class="dash-kanan "><span>PARAF</span></div>
                        <div><span>TANGGAL</span></div>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan dash-bawah">
                        <div class="dash-kanan"><span>STAFF VALIDASI</span></div>
                        <div class="dash-kanan">&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan ">
                        <div class="dash-kanan "><span><?=$reqParam1?></span></div>
                        <div class="dash-kanan ">&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                    <!--<div id="laporan-diperiksa-row" class="dash-kanan dash-bawah">
                        <div class="dash-kanan "><span>ASMAN TREASURY</span></div>
                        <div class="dash-kanan ">&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan dash-bawah">
                        <div class="dash-kanan "><span>&nbsp;</span></div>
                        <div class="dash-kanan "><span>&nbsp;</span></div>
                        <div><span>&nbsp;</span></div>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan ">
                        <div class="dash-kanan "><span>&nbsp;</span></div>
                        <div class="dash-kanan "><span>&nbsp;</span></div>
                        <div><span>&nbsp;</span></div>
                    </div>-->
                    
                </div>
                <div id="laporan-periksa-kanan">
                    <div id="laporan-periksa-manager" class="">
                        <span>
                        SURABAYA, <?=dateToPageCheck($arrData[0]["TGL_TRANS"])?><br />
                        <?=$jabatan?><br /><br /><br /><br /><br /></span>
                        <div><span class="dash-bawah" style="display:inline;"><?=$pejabat?></span></div>
                        <br />
                    </div>
                    <!--<div id="laporan-periksa-penerima">
                        <span>Uang Telah Diterima Oleh :<br /><br /><br /><br /><br /></span>
                        <div><span class="dash-atas" style="display:inline;">Nama Terang</span></div>
                    </div>-->
                </div>
                
                <div style="clear:both;"></div>
            </div>
            
            <div id="laporan-periksa" class="dash-kanan dash-kiri">
            	<div id="laporan-periksa-kiri">
                    <div id="laporan-diperiksa-row" class="dash-kanan dash-bawah">
                        <div class="dash-kanan "><span><?=$reqParam2?></span></div>
                        <div class="dash-kanan ">&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan dash-bawah">
                        <div class="dash-kanan "><span><?=$reqParam3?></span></div>
                        <div class="dash-kanan "><span>&nbsp;</span></div>
                        <div><span>&nbsp;</span></div>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan ">
                        <div class="dash-kanan "><span><?=$reqParam4?></span></div>
                        <div class="dash-kanan "><span>&nbsp;</span></div>
                        <div><span>&nbsp;</span></div>
                    </div>
                    
                </div>
                <div id="laporan-periksa-kanan">
                    <div id="laporan-periksa-penerima">
                        <span>Uang Telah Diterima Oleh :<br /><br /><br /><br /><br /></span>
                        <div><span class="dash-atas" style="display:inline;">Nama Terang</span></div>
                    </div>
                </div>
                
            </div>
            
            <div style="clear:both;"></div>
            <div id="laporan-keterangan" class=" dash-kiri dash-kanan dash-bawah" style="">
                <div id="laporan-keterangan-judul" class="dash-atas dash-bawah"><span>KETERANGAN</span></div>
                <div id="laporan-keterangan-kiri">
                    <span>
                    a. Nomor Posting : <br /><br />
                    b. Tanggal Posting : <br />
                    </span>
                </div>
                <div id="laporan-keterangan-kanan">
                    <div><span class="dash-bawah" style="display:inline;">c. Paraf Petugas Posting</span></div>
                    <div style="height:100px;"></div>
                </div>
            </div>
            
            
        </div>
    </div>
</div>
</body>
</html>