<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSpp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSppD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kptt_nota = new KpttNota();
$kptt_nota_spp = new KpttNotaSpp();
$kptt_nota_spp_d = new KpttNotaSppD();
$safr_valuta = new SafrValuta();

$reqId = httpFilterGet("reqId");


$kptt_nota_spp->selectByParams(array("A.NO_NOTA"=>$reqId), -1, -1);
$kptt_nota_spp->firstRow();

$tempNoBukti = $kptt_nota_spp->getField("NO_NOTA");
$tempTanggalValuta = dateToPageCheck($kptt_nota_spp->getField("TGL_VALUTA"));
$tempTahun = $kptt_nota_spp->getField("THN_BUKU");
$tempBulan = $kptt_nota_spp->getField("BLN_BUKU");
$tempNoPelanggan = $kptt_nota_spp->getField("KD_KUSTO");
$tempPelanggan = $kptt_nota_spp->getField("MPLG_NAMA");
$tempNoBukuBesarKas = $kptt_nota_spp->getField("KD_BANK");
$tempBank = $kptt_nota_spp->getField("REK_BANK");
$tempKodeKasBank = $kptt_nota_spp->getField("KD_BB_BANK");
$tempTanggalTransaksi = getFormattedDate($kptt_nota_spp->getField("TGL_TRANS"));
$tempKeterangan = $kptt_nota_spp->getField("KET_TAMBAHAN");
$tempValutaNama = $kptt_nota_spp->getField("KD_VALUTA");
$tempTanggalPosting = dateToPageCheck($kptt_nota_spp->getField("TGL_POSTING"));
$tempJumlahTransaksi = $kptt_nota_spp->getField("JML_VAL_TRANS");
$tempKursValuta = numberToIna($kptt_nota_spp->getField("KURS_VALUTA"));
$tempNoPosting = $kptt_nota_spp->getField("NO_POSTING");
$tempBadanUsaha = $kptt_nota_spp->getField("BADAN_USAHA");
$tempKdSubSis = $kptt_nota_spp->getField("KD_SUBSIS");
$reqNoRef2 = $kptt_nota_spp->getField("NO_REF2");
$reqNoRef3 = $kptt_nota_spp->getField("NO_REF1");
$reqMode = "update";


$kptt_nota->selectByParams(array("A.NO_NOTA"=>$reqNoRef3), -1, -1);
$kptt_nota->firstRow();

$reqTahunAjaran = $kptt_nota->getField("THN_BUKU");

?>
<html>
<head>
<meta charset="UTF-8">
</head>

<body>
<table style="width: 80%;" align="center">
	<tr>
   	  <td><img src="logo.jpg" width="90"></td>
      <td align="center">
        	<h2 style="margin-bottom: 0px;">SURAT TANDA BUKTI PEMBAYARAN</h2>
            <strong>SEKOLAH BARUNAWATI SURABAYA</strong><br>
			Tahun Pelajaran <?=$reqTahunAjaran?> - <?=($reqTahunAjaran+1)?>
        
      </td>
    </tr>
</table>
<br>
<table style="width: 80%;" align="center">
  <tr>
      <td style="width: 180px;">No. Induk</td>
        <td style="width: 10px;">:</td>
        <td colspan="2"><span><?=strtoupper($kptt_nota_spp->getField("KD_KUSTO"))?></span></td>
        <td>&nbsp;</td>
    </tr>
	<tr>
    	<td style="width: 180px;">Nama</td>
        <td style="width: 10px;">:</td>
        <td colspan="2"><span><?=strtoupper($kptt_nota_spp->getField("MPLG_NAMA"))?></span></td>
        <td>&nbsp;</td>
    </tr>
  <?
  if(!empty($kptt_nota->getField("DEPARTEMEN_KELAS")))
  {
  ?>
	<tr>
    	<td style="width: 180px;">Unit Sekolah</td>
        <td style="width: 10px;">:</td>
        <td colspan="2"><span><?=strtoupper($kptt_nota->getField("DEPARTEMEN_KELAS"))?></span></td>
        <td>&nbsp;</td>
    </tr>
  <?
  }
  ?>
  <tr>
      <td style="width: 180px;">No. Pembayaran</td>
        <td style="width: 10px;">:</td>
        <td colspan="2"><span><?=strtoupper($kptt_nota_spp->getField("NO_NOTA"))?></span></td>
        <td>&nbsp;</td>
    </tr>
	<tr>
    	<td style="width: 180px;">Pembayaran</td>
        <td style="width: 10px;">:</td>
        <td colspan="2"><?=strtoupper($kptt_nota_spp->getField("KET_TAMBAHAN"))?></td>
        <td>&nbsp;</td>
    </tr>
  	<?
    if($reqNoRef2 == "SPP")
    {
  	$reqTanggalSPP = getFormattedDate($kptt_nota->getField("TGL_TRANS"));
  	$arrTanggalSPP = explode(" ", $reqTanggalSPP);

  	$reqBulanSPP = $arrTanggalSPP[1];
  	$reqTahunSPP = $arrTanggalSPP[2];
  	?>
	<tr>
	  <td style="width: 180px;">&nbsp;</td>
	  <td style="width: 20px;">&nbsp;</td>
	  <td><span>SPP Bulan <?=$reqBulanSPP?> Tahun <?=$reqTahunSPP?></span></td>
	  <td><span>Rp.</span></td>
	  <td align="right"><?=numberToIna($kptt_nota_spp->getField("JML_VAL_TRANS"))?></td>
  </tr>
  <?
  }
  else
  {
  ?>
	<tr>
	  <td style="width: 180px;">&nbsp;</td>
	  <td style="width: 20px;">&nbsp;</td>
	  <td><span><?=$reqNoRef2?></span></td>
	  <td><span>Rp.</span></td>
    <td align="right"><?=numberToIna($kptt_nota_spp->getField("JML_VAL_TRANS"))?></td>
  </tr>
  <?
  }
  ?>
	<tr>
	  <td style="width: 180px;">&nbsp;</td>
	  <td style="width: 20px;">&nbsp;</td>
	  <td><strong>TOTAL</strong></td>
	  <td><strong><span>Rp.</span></strong></td>
	  <td align="right"><strong><?=numberToIna($kptt_nota_spp->getField("JML_VAL_TRANS"))?></strong></td>
  </tr>
	<tr>
	  <td style="width: 180px;">Terbilang</td>
	  <td style="width: 10px;">:</td>
	  <td colspan="2"><span><?=terbilang($kptt_nota_spp->getField("JML_VAL_TRANS"))?> rupiah</span></td>
	  <td>&nbsp;</td>
  </tr>
	<tr>
	  <td colspan="5" align="right">
      	<table>
        	<tr>
            	<td align="center">Surabaya, <?=$tempTanggalTransaksi?></td>
            </tr>
        	<tr>
            	<td align="center">Penerima</td>
            </tr>
        	<tr>
        	  <td align="center">&nbsp;</td>
      	  </tr>
        	<tr>
        	  <td align="center">&nbsp;</td>
      	  </tr>
        	<tr>
            	<td align="center">( <?=$kptt_nota_spp->getField("LAST_UPDATED_BY")?> )</td>
            </tr>
        </table>
      </td>
  </tr>
</table>
</body>
</html>