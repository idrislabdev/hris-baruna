<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html moznomarginboxes mozdisallowselectionprint>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="test5.css" type="text/css" />	
</head>

<body>
<div id="laporan-wrapper" class="dash-bawah">
    <div id="header">
        <div id="laporan-header">
            <div id="laporan-header-atas" class="dash-bawah">
                <div id="laporan-header-kiri">
                    <div><span class="dash-bawah" style="display:inline; padding-bottom:20px;">PT. PELINDO MARINE SERVICE</span></div>
                    <div><br /><br /><br /><span>NO BUKTI : 001820/JKM/2011</span></div>
                </div>
                <div id="laporan-header-tengah">
                    <div><br /><br /><span class="dash-bawah" style="display:inline;">BUKTI PENERIMAAN KAS-BANK</span></div>
                    <div><span style="padding-top:7px;">TANGGAL : 17-11-2011</span></div>
                </div>
                <div id="laporan-header-kanan">
                    <div id="laporan-pojok" style="text-align:left;">
                        <div id="laporan-pojok-row">
                            <div>TANGGAL PROSES</div>
                            <div>:</div>
                            <div>17-11-2014</div>
                        </div>
                        <div id="laporan-pojok-row">
                            <div>HALAMAN</div>
                            <div>:</div>
                            <div>1</div>
                        </div>
                    </div>
                    <div style="position:absolute; bottom:0; right:0;"><span>OPERATOR : 18:55:03</span></div>
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
                <div style="float:left; width:100%;"><span>1. Pemegang Kas harap menerimakan uang sebesar : Rp. 75,000,000.00</span></div>
                <div id="laporan-uraian-row">
                    <div><span>2. Terbilang</span></div>
                    <div><span>:</span></div>
                    <div><span>TUJUH PULUH LIMA JUTA RUPIAH</span></div>
                </div>
                <div id="laporan-uraian-row">
                    <div><span>3. Dari</span></div>
                    <div><span>:</span></div>
                    <div><span>BANK MANDIRI</span></div>
                </div>
                <div id="laporan-uraian-row">
                    <div><span>4. Alamat</span></div>
                    <div><span>:</span></div>
                    <div><span>SURABAYA</span></div>
                </div>
                <div id="laporan-uraian-row">
                    <div><span>5. Uraian</span></div>
                    <div><span>:</span></div>
                    <div><span>PENGISIAN KAS PERUSAHAAN</span></div>
                </div>
                <div id="laporan-uraian-row">
                    <div><span>6. Bukti Pendukung</span></div>
                    <div><span>:</span></div>
                    <div>&nbsp;</div>
                    
                    <div style="float:right; margin-top:-14px; padding-bottom:10px;"><span>Tanggal, 17-11-2014</span></div>
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
                for ($i = 1; $i <= 45; $i++) {
                ?>
                <div id="tabel" style="display: table-row;">            
                    <div style="display: table-cell;"><span>00<?=$i?></span></div>
                    <div style="display: table-cell;"><span>101.01.00 00000 000.00.00<br />Kas</span></div>
                    <div style="display: table-cell;"><span>Rp</span></div>
                    <div style="display: table-cell;"><span>75,000,000.00</span></div>
                    <div style="display: table-cell;"><span>&nbsp;</span></div>
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
                    <div style="display: table-cell; width:200px;"><span>75,000,000.00</span></div>
                    <div style="display: table-cell; width:200px;"><span>75,000,000.00</span></div>
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
                        <div class="dash-kanan "><span>KASUBDIV TREASURY</span></div>
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
                        SURABAYA, 17-11-2014<br />
                        A.N. DIREKTUR UTAMA<br />
                        MANAGER KEUANGAN<br /><br /><br /><br /><br /></span>
                        <div><span class="dash-bawah" style="display:inline;">EKO MUNADI</span></div>
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