<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTrans.php");

$kptt_nota = new KpttNota();
$safr_valuta = new SafrValuta();
$kbbr_tipe_trans = new KbbrTipeTrans();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";
	$tempKursValuta = 1;
	$kptt_nota->selectByParamsGenerateKode("JRR");
	$kptt_nota->firstRow();
	$tempNoBuktiJrr = $kptt_nota->getField("NO_NOTA");	
	$tempTahun = date("Y");
	$tempBulan = "";	
}
else
{
	$reqMode = "update";	
	$kptt_nota->selectByParams(array("A.NO_NOTA"=>$reqId), -1, -1);
	$kptt_nota->firstRow();
	
	$tempNoBuktiJrr = $kptt_nota->getField("NO_NOTA");
	$tempTanggalValuta = dateToPageCheck($kptt_nota->getField("TGL_VALUTA"));
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota->getField("TGL_TRANS"));
	$tempKodeKapal = $kptt_nota->getField("KD_OBYEK");
	$tempKapal = $kptt_nota->getField("");
	$tempTahun = $kptt_nota->getField("THN_BUKU");
	$tempBulan = $kptt_nota->getField("BLN_BUKU");
	$tempJenisJasa = $kptt_nota->getField("AKRONIM_DESC");
	$tempMaterai = $kptt_nota->getField("METERAI");
	$tempJumlahUpper = $kptt_nota->getField("JML_WD_UPPER");
	$tempNoPelanggan = $kptt_nota->getField("KD_KUSTO");
	$tempPelanggan = $kptt_nota->getField("MPLG_NAMA");
	$tempJumlahTagihan = $kptt_nota->getField("JML_TAGIHAN");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
	$tempNoRef3 = $kptt_nota->getField("NO_REF3");
	$tempNotaUpdate = $kptt_nota->getField("PREV_NOTA_UPDATE");
	$tempTanggalPosting = dateToPageCheck($kptt_nota->getField("TGL_POSTING"));
	$tempNoPosting = $kptt_nota->getField("NO_POSTING");
}
$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
$kbbr_tipe_trans->selectByParams(array("KD_AKTIF" => "A", "KD_SUBSIS" => "KPT", "KD_JURNAL" => "JPJ"));
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
				url:'../json-keuangansiuk/pembatalan_sudah_cetak_add_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);

					data = data.split("-");
					document.location.href = 'pembatalan_sudah_cetak_add_data.php?reqId=<?=$reqId?>';					
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Entry Pembatalan Nota (JRR)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table border="0">
        <tr>           
             <td>No Bukti JRR</td>
			 <td>
				<input name="reqNoBuktiJrr" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoBuktiJrr?>" />
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalValuta?>" />
			</td>
        </tr>
        <tr>           
             <td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
			</td>
            <td>Nama Kapal</td>
			 <td>
             	<input id="reqKodeKapal" name="reqKodeKapal" class="easyui-validatebox" style="width:70px" value="<?=$tempKodeKapal?>" />
                <input name="reqKapal" class="easyui-validatebox" style="width:290px" type="text" value="<?=$tempKapal?>" />
			</td>
        </tr>
        <tr>           
             <td>Jenis Jasa</td>
			 <td>
             	<select name="reqJenisJasa" id="reqJenisJasa">
                <?
                while($kbbr_tipe_trans->nextRow())
				{
				?>
                <option value="<?=$kbbr_tipe_trans->getField("TIPE_TRANS")?>" <? if($kbbr_tipe_trans->getField("TIPE_TRANS") == $tempTipeTransaksi) { ?> selected <? } ?>><?=$kbbr_tipe_trans->getField("AKRONIM_DESC")?></option>
                <?
				}
				?>
                </select> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input id="reqTahun" name="reqTahun" type="hidden" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:80px" value="<?=$tempTahun?>" />
                &nbsp;&nbsp;
                <input id="reqBulan" name="reqBulan" type="hidden" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px" value="<?=$tempBulan?>" />
				<?php /*?><input name="reqJenisJasa" class="easyui-validatebox" style="width:150px" type="text" value="<?=$tempJenisJasa?>" /><?php */?>
             </td>
             <td>Materai</td>
             <td>
				<input name="reqMaterai" class="easyui-validatebox" style="width:80px" type="text" value="<?=$tempMaterai?>" />
                &nbsp;
                Jumlah Upper
                <input id="reqJumlahUpper" name="reqJumlahUpper" class="easyui-validatebox" style="width:140px" OnFocus="FormatAngka('reqJumlahUpper')" OnKeyUp="FormatUang('reqJumlahUpper')" OnBlur="FormatUang('reqJumlahUpper')" value="<?=numberToIna($tempJumlahUpper)?>"  />
             </td>
        </tr>
        <tr>           
             <td>Kd Agen</td>
			 <td>
	             <input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoPelanggan?>" onKeyDown="openPopup('PELANGGAN');" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempPelanggan?>" readonly />
			</td>
            <td>Jumlah Tagihan</td>
			 <td>
             	<input id="reqJumlahTagihan" name="reqJumlahTagihan" class="easyui-validatebox" style="width:140px" OnFocus="FormatAngka('reqJumlahTagihan')" OnKeyUp="FormatUang('reqJumlahTagihan')" OnBlur="FormatUang('reqJumlahTagihan')" value="<?=numberToIna($tempJumlahTagihan)?>"  />
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
                Kurs
                <input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKursValuta?>" readonly />
			</td>
            <td rowspan="2">Keterangan Tambahan</td>
            <td rowspan="2">
            	<textarea name="reqKeterangan" cols="50" rows="2"><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>
            <td>No 1A / 1B / 1C</td>
			<td>
                <input name="reqNoRef3" class="easyui-validatebox" style="width:150px" type="text" value="<?=$tempNoRef3?>" />
                <input name="reqNotaUpdate" class="easyui-validatebox" style="width:150px" type="text" value="<?=$tempNotaUpdate?>" />
			</td>
        </tr>
        <tr>
        	<td colspan="2">
            	<fieldset>
                	<table class="example" id="dataTableRowDinamis">
                    	<tr>
                    		<th>No</th>
                            <th>Jenis Jasa</th>
                            <th>Jumlah Pajak</th>
                            <th>Jumlah Transaksi</th>
                        </tr>
                    </table>
                </fieldset>
            </td>
            <td colspan="2">
            	<table>
                	<tr>
                    	<td>Tanggal Posting</td>
                        <td><input name="reqTanggalPosting" <?php /*?>class="easyui-datebox" style="width:100px" type="text"<?php */?> value="<?=$tempTanggalPosting?>" readonly /></td>
                    </tr>
                    <tr>
                    	<td>No&nbsp;Posting</td>
                        <td><input name="reqNoPosting" <?php /*?>class="easyui-validatebox" style="width:100px" type="text" <?php */?> value="<?=$tempNoPosting?>" readonly /></td>
                    </tr>
                </table>
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