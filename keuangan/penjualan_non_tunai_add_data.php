<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTrans.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kptt_nota = new KpttNota();
$safr_valuta = new SafrValuta();
$kbbr_tipe_trans=new KbbrTipeTrans();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
	$tempKursValuta = 1;
	$kptt_nota->selectByParamsGenerateKode("JPJ");
	$kptt_nota->firstRow();
	$tempNoValuta = $kptt_nota->getField("NO_NOTA");	
	$tempTahun = date("Y");
	$tempBulan = "";
}
else
{
	$reqMode = "update";	
	$kptt_nota->selectByParams(array("A.NO_NOTA"=>$reqId), -1, -1);
	$kptt_nota->firstRow();
	
	$tempMaterai = $kptt_nota->getField("FLAG_EKSPEDISI");
	$tempNoPPKB = $kptt_nota->getField("NO_REF3");
	$tempTipeTrans = $kptt_nota->getField("TIPE_TRANS");
	$tempSegmen = $kptt_nota->getField("TIPE_TRANS");
	$tempTanggalValuta = dateToPageCheck($kptt_nota->getField("TGL_VALUTA"));
	$tempNoValuta = $kptt_nota->getField("NO_NOTA");
	$tempNoRef = $kptt_nota->getField("NO_REF1");
	$tempNoRefLain = $kptt_nota->getField("NO_REF2");
	$tempKodeKapal = $kptt_nota->getField("");
	$tempKapal = $kptt_nota->getField("");
	$tempNoPelanggan = $kptt_nota->getField("KD_KUSTO");
	$tempPelanggan = $kptt_nota->getField("MPLG_NAMA");
	$tempKodeBank = $kptt_nota->getField("KD_BANK");
	$tempBank = $kptt_nota->getField("REK_BANK");
	$tempBadanUsaha = $kptt_nota->getField("BADAN_USAHA");
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota->getField("TGL_TRANS"));
	$tempTanggalValutaPajak = dateToPageCheck($kptt_nota->getField("TGL_VAL_PAJAK"));
	$tempJumlahTagihan = $kptt_nota->getField("JML_TAGIHAN");
	$tempJumlahUpper = $kptt_nota->getField("JML_WD_UPPER");
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempKursPajak = $kptt_nota->getField("KURS_VAL_PAJAK");
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempTahun = $kptt_nota->getField("THN_BUKU");
	$tempBulan = $kptt_nota->getField("BLN_BUKU");
	$tempTanggalPosting = dateToPageCheck($kptt_nota->getField("TGL_POSTING"));
	$tempNoPosting = $kptt_nota->getField("NO_POSTING");
}

$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
$kbbr_tipe_trans->selectByParams(array("A.KD_JURNAL"=>"JPJ", "A.KD_SUBSIS"=>"KPT", "AUTO_MANUAL"=>"M", "KD_AKTIF"=>"A"),-1,-1,"", "ORDER BY TIPE_TRANS ASC");
$arrTipeTrans="";
while($kbbr_tipe_trans->nextRow())
{
	$arrTipeTrans["TIPE_TRANS"][] = $kbbr_tipe_trans->getField("TIPE_TRANS");
	$arrTipeTrans["AKRONIM_DESC"][] = $kbbr_tipe_trans->getField("AKRONIM_DESC");		
}
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
			parent.frames["mainFrameDetilPop"].document.getElementById("reqId").value = '<?=$tempNoValuta?>';
			<?php /*?>parent.frames["mainFrameDetilPop"].document.getElementById("reqTipeTrans").value = '<?=$arrTipeTrans["TIPE_TRANS"][0]?>';<?php */?>
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/penjualan_non_tunai_add_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);
					data = data.split("-");
					document.location.href = 'penjualan_non_tunai_add_data.php?reqId=<?=$reqId?>';
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
		});
		});
		
		$("#reqKodeBank").keypress(function(e) {
			  return true;
		});
		
		$("#reqKodeBank").keyup(function(e) {		
		  $.getJSON("../json-keuangansiuk/get_bank_json.php?reqNoBukuBesarKasId="+$("#reqKodeBank").val(),
		  function(data){
			  $("#reqBank").val(data.MBANK_NAMA);
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
		
		$("#reqSegmen").change(function() { 
		   parent.frames["mainFrameDetilPop"].document.getElementById("reqTipeTrans").value = document.getElementById("reqSegmen").value;
		   parent.frames["mainFrameDetilPop"].deleteRowDrawTableAll('dataTableRowDinamis');
		});
		
		$("#reqNoPPKB").keypress(function(e) {
			  return true;
		});
		
		$("#reqNoPPKB").keyup(function(e) {		
		  $("#reqNoRef").val($("#reqNoPPKB").val());
		});
		
		$('#reqTanggalTransaksi').datebox({
			onChange:function(newValue,oldValue){
				val_tanggal_transaksi="";
				if($('#reqTanggalTransaksi').datebox('getValue').length == 10)
				{
					val_tanggal_transaksi = $('#reqTanggalTransaksi').datebox('getValue');
					
					$("#reqTanggalValuta").val(val_tanggal_transaksi);
					$("#reqTanggalPosting").val(val_tanggal_transaksi);
					/*$('#reqTanggalValuta').datebox('setValue') = val_tanggal_transaksi;
					$('#reqTanggalPosting').datebox('setValue') = val_tanggal_transaksi;*/
					//reqTanggalValutaPajak
				}
				else
				{
					$('#reqTanggalValuta').datebox('setValue') = $('#reqTanggalPosting').datebox('setValue') = "";
				}
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
		//document.getElementById('reqAlamat').value = alamat;
		//document.getElementById('reqNPWP').value = npwp;
		//document.getElementById('reqBadanUsaha').value = badan_usaha;
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
<body onLoad="setTimeout(setValue, 2000);">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Transaksi Jurnal Penjualan Jasa</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
    	<tr>
        	<td colspan="4" align="right">
            Materai
            &nbsp;&nbsp;&nbsp;
            <select name="reqMaterai" id="reqMaterai">
            	<option value="1" <? if($tempMaterai == "1") echo "selected";?>>Ya</option>
                <option value="0" <? if($tempMaterai == "0") echo "selected";?>>Tidak</option>
            </select>
            </td>
        </tr>
        <tr>           
             <td>No PPKB</td>
			 <td>
				<input name="reqNoPPKB" id="reqNoPPKB" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoPPKB?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;
            	Segmen
                <select name="reqSegmen" id="reqSegmen">
                	<?
					for($j=0;$j<count($arrTipeTrans["TIPE_TRANS"]);$j++)
					{
                    ?>
                		<option value="<?=$arrTipeTrans["TIPE_TRANS"][$j]?>" <? if($tempSegmen == $arrTipeTrans["TIPE_TRANS"][$j]) echo "selected";?> ><?=$arrTipeTrans["AKRONIM_DESC"][$j]?></option>
                    <?
					}
                    ?>
                </select>
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" readonly <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> style="width:80px" value="<?=$tempTanggalValuta?>" />
                <input name="reqNoValuta" class="easyui-validatebox" readonly style="width:290px" type="text" value="<?=$tempNoValuta?>" />
			</td>
        </tr>
        <tr>           
             <td>No Ref</td>
			 <td>
				<input name="reqNoRef" id="reqNoRef" readonly class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoRef?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;
            	No Ref 2
                <input name="reqNoRefLain" class="easyui-validatebox" style="width:120px" type="text" value="<?=$tempNoRefLain?>" />
			</td>
            <td>Nama Kapal</td>
			 <td>
             	<input id="reqKodeKapal" name="reqKodeKapal" class="easyui-validatebox" style="width:70px" value="<?=$tempKodeKapal?>" />
                <input name="reqKapal" class="easyui-validatebox" readonly style="width:290px" type="text" value="<?=$tempKapal?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoPelanggan?>"  onKeyDown="openPopup('PELANGGAN');"/>
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqPelanggan" id="reqPelanggan" readonly class="easyui-validatebox" style="width:290px" type="text" value="<?=$tempPelanggan?>" />
			</td>
            <td>Kode Bank</td>
			 <td>
             	<input id="reqKodeBank" name="reqKodeBank" class="easyui-validatebox" style="width:70px" value="<?=$tempKodeBank?>" />
                <input name="reqBank" id="reqBank" class="easyui-validatebox" readonly style="width:290px" type="text" value="<?=$tempBank?>" />
                <input name="reqBadanUsaha" id="reqBadanUsaha" type="hidden" value="<?=$tempBadanUsaha?>">
			</td>
        </tr>
        <tr>
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Tanggal Valuta Pajak
                <input id="reqTanggalValutaPajak" name="reqTanggalValutaPajak" readonly <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> value="<?=$tempTanggalValutaPajak?>" />
			</td>
            <td>Jumlah Tagihan</td>
			 <td>
             	<input id="reqJumlahTagihan" name="reqJumlahTagihan" class="easyui-validatebox" readonly style="width:140px" OnFocus="FormatAngka('reqJumlahTagihan')" OnKeyUp="FormatUang('reqJumlahTagihan')" OnBlur="FormatUang('reqJumlahTagihan')" value="<?=numberToIna($tempJumlahTagihan)?>" />
                &nbsp;
                Jumlah Upper
                <input id="reqJumlahUpper" name="reqJumlahUpper" class="easyui-validatebox" style="width:140px" OnFocus="FormatAngka('reqJumlahUpper')" OnKeyUp="FormatUang('reqJumlahUpper')" OnBlur="FormatUang('reqJumlahUpper')" value="<?=numberToIna($tempJumlahUpper)?>" />
			</td>
        </tr>
        <tr>
            <td>Kurs&nbsp;Valuta</td>
			<td>
            	<input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox"  style="width:50px" type="text" value="<?=$tempKursValuta?>" readonly />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Kurs Pajak
                <input name="reqKursPajak" id="reqKursPajak" class="easyui-validatebox" maxlength="3" style="width:50px" type="text" value="<?=$tempKursPajak?>" />
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
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Tahun
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:80px" value="<?=$tempTahun?>" readonly />
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px" value="<?=$tempBulan?>" readonly />
			</td>
            <td>Tanggal Posting</td>
            <td>
            	<input name="reqTanggalPosting" readonly <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> value="<?=$tempTanggalPosting?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                No&nbsp;Posting
				<input name="reqNoPosting" class="easyui-validatebox" readonly style="width:170px" type="text" value="<?=$tempNoPosting?>" />
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
	$("#reqKursPajak, #reqBulan,#reqTahun").keypress(function(e) {
		if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
		{
		return false;
		}
	});
</script>
</body>
</html>