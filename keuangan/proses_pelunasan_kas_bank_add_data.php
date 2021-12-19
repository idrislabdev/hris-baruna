<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kptt_nota = new KpttNota();
$safr_valuta = new SafrValuta();


$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
	$tempKursValuta = 1;
	$kptt_nota->selectByParamsGenerateKode("JKM");
	$kptt_nota->firstRow();
	$tempNoBukti = $kptt_nota->getField("NO_NOTA");	
	$tempTahun = date("Y");
	$tempBulan = "";
}
else
{
	$reqMode = "update";	
	$kptt_nota->selectByParams(array("A.NO_NOTA"=>$reqId), -1, -1);
	$kptt_nota->firstRow();
	
	$tempNoBukti = $kptt_nota->getField("NO_NOTA");
	$tempTanggalValuta = dateToPageCheck($kptt_nota->getField("TGL_VALUTA"));
	$tempTahun = $kptt_nota->getField("THN_BUKU");
	$tempBulan = $kptt_nota->getField("BLN_BUKU");
	$tempNoPelanggan = $kptt_nota->getField("KD_KUSTO");
	$tempPelanggan = $kptt_nota->getField("MPLG_NAMA");
	$tempNoBukuBesarKas = $kptt_nota->getField("KD_BANK");
	$tempBukuBesarKas = $kptt_nota->getField("BANK");
	$tempKodeKasBank = $kptt_nota->getField("KD_BB_BANK");
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota->getField("TGL_TRANS"));
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempTanggalPosting = dateToPageCheck($kptt_nota->getField("TGL_POSTING"));
	$tempJumlahTransaksi = $kptt_nota->getField("JML_RP_TRANS");
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempNoPosting = $kptt_nota->getField("NO_POSTING");

}
$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    
	<script type="text/javascript">
		function setValue(){
			//$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/proses_pelunasan_kas_bank_add_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);

					data = data.split("-");
					document.location.href = 'proses_pelunasan_kas_bank_add_data.php?reqId=<?=$reqId?>';					
					parent.frames["mainFrameDetilPop"].document.getElementById("btnSubmit").click();
					top.frames['mainFrame'].location.reload();					
				}
			});
			
		});
		
		$(function(){
		
		$("#reqNoPelanggan").keypress(function(e) {
			return true;
		});
		
		$("#reqNoPelanggan").keyup(function(e) {		
		$.getJSON("../json-keuangansiuk/get_pelanggan_json.php?reqNoPelangganId="+$("#reqNoPelanggan").val(),
		function(data){
			$("#reqPelanggan").val(data.MPLG_NAMA);
			$("#reqAlamat").val(data.MPLG_ALAMAT);
			$("#reqNPWP").val(data.MPLG_NPWP);
		});
		});
		
		$("#reqNoBukuBesarKas").keypress(function(e) {
			  return true;
		});
		
		$("#reqNoBukuBesarKas").keyup(function(e) {		
		  $.getJSON("../json-keuangansiuk/get_bank_json.php?reqNoBukuBesarKasId="+$("#reqNoBukuBesarKas").val(),
		  function(data){
			  $("#reqBukuBesarKas").val(data.MBANK_NAMA);
			  $("#reqKodeKasBank").val(data.MBANK_KODE_BB)
		  });
		});
		
		$("#reqValutaNama").change(function() { 
			
			   if($("#reqValutaNama").val() == "IDR")
					$("#reqKursValuta").val('1');
			   else
			   {
				  $.getJSON("../json-keuangansiuk/get_valuta_kurs_json.php?reqValutaKursId="+$("#reqValutaNama").val()+ "&reqTanggalTransaksi="+$('#reqTanggalTransaksi').datebox('getValue'),
				  function(data){
					$("#reqKursValuta").val(data.NILAI_RATE);
				  });
			   }
			});		  
		});		
	
		function openPopup(tipe)
		{
			
			var isCtrl = false;$('#reqNoPelanggan').keyup(function (e) {
				if(e.which == 120)
				{
					if(tipe == "PELANGGAN")
					{					
						parent.OpenDHTML('pelanggan_pencarian.php', 'Pencarian Pelanggan', 900, 600);
					}
					return false;
				}
			});
			
		}
		function OptionSet(id, nama,alamat, npwp, badan_usaha){
			document.getElementById('reqNoPelanggan').value = id;
			document.getElementById('reqPelanggan').value = nama;
			document.getElementById('reqAlamat').value = alamat;
			document.getElementById('reqNPWP').value = npwp;
			document.getElementById('reqBadanUsaha').value = badan_usaha;
		}		


	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <!--<script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script> -->

<style type="text/css">
div.message{
background: transparent url(msg_arrow.gif) no-repeat scroll bottom left;
padding-bottom: 5px;
}

div.error{
background-color:#F3E6E6;
border-color: #924949;
/*border-style: solid solid solid none;*/
border-style: solid solid solid solid;
border-width: 1px;
padding: 5px;
}
</style>
</head>
     
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Transaksi Pelunasan Nota</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>No Bukti</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoBukti?>" />
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" class="easyui-datebox" data-options="validType:'date'" style="width:80px" value="<?=$tempTanggalValuta?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Thn / Bln Buku
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:80px" value="<?=$tempTahun?>" />
                &nbsp;/&nbsp;
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px" value="<?=$tempBulan?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoPelanggan?>" onKeyDown="openPopup('PELANGGAN');" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempPelanggan?>" readonly />
			</td>
            <td>Rek. Kas / Bank</td>
			 <td>
             	<input name="reqNoBukuBesarKas" id="reqNoBukuBesarKas" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoBukuBesarKas?>" />
                <input name="reqBukuBesarKas" id="reqBukuBesarKas" class="easyui-validatebox" style="width:200px" type="text" value="<?=$tempBukuBesarKas?>" readonly />
                <input name="reqKodeKasBank" id="reqKodeKasBank"  class="easyui-validatebox" style="width:100px" value="<?=$tempKodeKasBank?>" readonly />
			</td>
        </tr>
        <tr>
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
            <td>Keterangan Tambahan</td>
            <td>
				<input name="reqKeterangan" class="easyui-validatebox" style="width:370px" type="text" value="<?=$tempKeterangan?>" />
            </td>
        </tr>
        <tr>
            <td>Kode Valuta</td>
			<td>
                <select name="reqValutaNama" id="reqValutaNama">
                <?
                while($safr_valuta->nextRow())
				{
				?>
                <option value="<?=$safr_valuta->getField("KODE_VALUTA")?>" <? if($safr_valuta->getField("KODE_VALUTA") == $tempValutaNama) { ?> selected <? } ?>><?=$safr_valuta->getField("KODE_VALUTA")?></option>
                <?
				}
				?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
            <td>Tanggal Posting</td>
            <td>
            	<input id="reqTanggalPosting" name="reqTanggalPosting" <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> value="<?=$tempTanggalPosting?>" readonly/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Jml Trans
                <input id="reqJumlahTransaksi" name="reqJumlahTransaksi" class="easyui-validatebox" style="width:140px" OnFocus="FormatAngka('reqJumlahTransaksi')" OnKeyUp="FormatUang('reqJumlahTransaksi')" OnBlur="FormatUang('reqJumlahTransaksi')" value="<?=numberToIna($tempJumlahTransaksi)?>"  />             
            </td>
        </tr>
        <tr>
            <td>Kurs&nbsp;Valuta</td>
			<td>
            	<input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKursValuta?>" readonly />
            </td>
            <td>No&nbsp;Posting</td>
			 <td>
                <input name="reqNoPosting" class="easyui-validatebox" style="width:140px" type="text" value="<?=$tempNoPosting?>" readonly />
			</td>
        </tr>
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
<script>
	$("#reqBulan,#reqTahun").keypress(function(e) {
		if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
		{
		return false;
		}
	});
</script>
</body>
</html>