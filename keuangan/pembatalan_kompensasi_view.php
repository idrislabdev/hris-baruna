<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrRuleModul.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTrans.php");

$kptt_nota = new KpttNota();
$safr_valuta = new SafrValuta();
$kptt_nota_d = new KpttNotaD();
$kbbr_tipe_trans_d = new KbbrTipeTransD();
$kbbr_general_ref_d = new KbbrGeneralRefD();
$kbbr_rule_modul = new KbbrRuleModul();
$kbbr_tipe_trans = new KbbrTipeTrans();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");

if($reqId == "")
{
	$reqMode = "insert";
	$tempKursValuta = 1;
	$tempTahun = date("Y");
	$tempBulan = "";	
	$tempTanggalTransaksi = date("d-m-Y");
	$tempTanggalValuta = date("d-m-Y");
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
	$tempBank = $kptt_nota->getField("BANK");
	$tempKodeKasBank = $kptt_nota->getField("KD_BB_BANK");
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota->getField("TGL_TRANS"));
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempTanggalPosting = dateToPageCheck($kptt_nota->getField("TGL_POSTING"));
	$tempNoPosting = $kptt_nota->getField("NO_POSTING");
	$tempJumlahTransaksi = $kptt_nota->getField("JML_VAL_TRANS");
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempRekKompen = $kptt_nota->getField("");
	$tempKdBbKusto = $kptt_nota->getField("KD_BB_KUSTO");
	$tempBadanUsaha = $kptt_nota->getField("BADAN_USAHA");
}
$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
$kbbr_tipe_trans->selectByParams(array("KD_SUBSIS" => "KPT", "KD_JURNAL" => "JKK"));
$disabled="disabled";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>pembatalan kompensasi view</title>
	<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
    <script type="text/javascript" src="js/entri_pembatalan_kompensasi.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');	
		}		
		/* KBBT_JUR_BB */
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/pembatalan_kompensasi_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//data = data.split("-");					
					$.messager.alert('Info', data, 'info');
					//$.messager.alert('Info', data[1], 'info');	
					//document.location.href = 'pembatalan_pelunasan_add.php?reqId='+data[0];
					//top.frames['mainFrame'].location.reload();
				}
			});
			
		});
		
		$(function(){
			
			$("#reqNoBukuBesarKas").keypress(function(event) { 
			

				if(event.keyCode == 13){
					event.cancelBubble = true;
					event.returnValue = false;
				
					if (event.stopPropagation) {   
					  event.stopPropagation();
					  event.preventDefault();
					}
					$.getJSON("../json-keuangansiuk/get_bank_json.php?reqNoBukuBesarKasId="+$("#reqNoBukuBesarKas").val(),
					function(data){			
						$("#reqBank").val(data.MBANK_NAMA);
						$("#reqKodeKasBank").val(data.MBANK_KODE_BB);
						hitungJumlahTotal();		
					});				
					
					return false;
				}
			
			});	
			
			$('#reqNoPelanggan').keydown(function (event) {
				if(event.keyCode == 120)
				{
					OpenDHTMLPopup('pelanggan_pencarian.php', 'Pencarian Pelanggan', 950, 600);
					
					return false;
				}
				else if(event.keyCode == 13){
					event.cancelBubble = true;
					event.returnValue = false;
				
					if (event.stopPropagation) {   
					  event.stopPropagation();
					  event.preventDefault();
					}
					
					$.getJSON("../json-keuangansiuk/get_pelanggan_json.php?reqNoPelangganId="+$("#reqNoPelanggan").val(),
					function(data){
						OptionSet($("#reqNoPelanggan").val(), data.MPLG_NAMA,data.MPLG_ALAMAT, data.MPLG_NPWP, data.MPLG_BADAN_USAHA);
					});				
					
					return false;
				}			
			});				
					
		});	

		
		$(function(){
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
		
		function OptionSet(id, nama,alamat, npwp, badan_usaha){
		document.getElementById('reqNoPelanggan').value = id;
		document.getElementById('reqPelanggan').value = nama;
		//document.getElementById('reqAlamat').value = alamat;
		//document.getElementById('reqNPWP').value = npwp;
		document.getElementById('reqBadanUsaha').value = badan_usaha;
		}	
			
		function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2) - 100;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
		}		

	</script>
    
    
</head>
     
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Pembatalan Kompensasi (JRR)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>
             <td>No Bukti</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" <?=$disabled?> style="width:170px" type="text" value="<?=$tempNoBukti?>" />
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" <?=$disabled?> class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalValuta?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Thn / Bln Buku
                <input id="reqTahun" name="reqTahun" <?=$disabled?> class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:80px" value="<?=$tempTahun?>" />
                &nbsp;/&nbsp;
                <input id="reqBulan" name="reqBulan" <?=$disabled?> class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px" value="<?=$tempBulan?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" <?=$disabled?> class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoPelanggan?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqPelanggan" id="reqPelanggan" <?=$disabled?> class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempPelanggan?>" />
				<input name="reqBadanUsaha" id="reqBadanUsaha" <?=$disabled?> class="easyui-validatebox" style="width:295px" type="hidden" value="<?=$tempBadanUsaha?>" />
                <input name="reqKdBbKusto" id="reqKdBbKusto" <?=$disabled?> class="easyui-validatebox" style="width:295px" type="hidden" value="<?=$tempKdBbKusto?>" />
             </td>
            <td>Rek. Kas / Bank</td>
			<td>
             	<input name="reqNoBukuBesarKas" id="reqNoBukuBesarKas" <?=$disabled?> class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoBukuBesarKas?>" />
                <input name="reqBank" id="reqBank" <?=$disabled?> class="easyui-validatebox" style="width:200px" type="text" value="<?=$tempBank?>" />
                <input name="reqKodeKasBank" id="reqKodeKasBank"  <?=$disabled?> class="easyui-validatebox" style="width:100px" value="<?=$tempKodeKasBank?>" />
			</td>
        </tr>
        <tr>
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" <?=$disabled?> class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
            <td>Keterangan Tambahan</td>
            <td>
				<input name="reqKeterangan" class="easyui-validatebox" <?=$disabled?> style="width:370px" type="text" value="<?=$tempKeterangan?>" />
            </td>
        </tr>
        <tr>
        	<td>Kode Valuta</td>
			<td>
                <select name="reqValutaNama" id="reqValutaNama" <?=$disabled?>>
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
            <td>Tanggal, No&nbsp;Posting</td>
            <td>
            	<input id="reqTanggalPosting" name="reqTanggalPosting" <?=$disabled?> <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> value="<?=$tempTanggalPosting?>" readonly />
                &nbsp;
				<input name="reqNoPosting" class="easyui-validatebox" <?=$disabled?> style="width:100px" type="text" value="<?=$tempNoPosting?>"  />
                &nbsp;
                Jumlah Transaksi
                <input id="reqJumlahTransaksi" name="reqJumlahTransaksi" <?=$disabled?> class="easyui-validatebox" style="width:140px" <?php /*?>OnFocus="FormatAngka('reqJumlahTransaksi')" OnKeyUp="FormatUang('reqJumlahTransaksi')" OnBlur="FormatUang('reqJumlahTransaksi')"<?php */?> value="<?=numberToIna($tempJumlahTransaksi)?>" />
            </td>
        </tr>
        <tr>
            <td>Kurs&nbsp;Valuta</td>
			<td>
            	<input name="reqKursValuta" id="reqKursValuta" <?=$disabled?> class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKursValuta?>" />
			</td>
            <td>Rek. Kompen</td>
			<td>
            	<input name="reqRekKompen" class="easyui-validatebox" <?=$disabled?> style="width:120px" type="text" value="<?=$tempRekKompen?>" />
			</td>
        </tr>
        <tr>
        	<td colspan="4">
            <div>
	            <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <?
                if($reqMode == "update")
				{
				?>
                <input type="button" value="Rincian Jurnal" onClick="OpenDHTMLPopup('jurnal_lihat.php?reqId=<?=$reqId?>', 'Rincian Jurnal', 900, 600)">
            	<?
				}
				?>
            </div>           
            </td>
        </tr>
        </thead>
    </table>
 
    <table class="example" id="dataTableRowDinamis">
    <!--<table class="example altrowstable" id="alternatecolor" >-->
        <thead class="altrowstable">
          <tr>
              <th style="width:5%">
                No
              </th>
              <th>No&nbsp;Nota</th>
              <th>Pelanggan</th>
              <th>Tanggal Nota</th>
              <th>Jml Bayar</th>
              <th>Jml Dikembalikan</th>
              <th>Sisa</th>
              <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
			  <?
              $i = 1;
              $checkbox_index = 0;
              
              $kptt_nota_d->selectByParamsPelunasanKasBank(array("A.NO_NOTA"=>$reqId, "B.JEN_JURNAL" => "JPJ"), -1, -1, "", " ORDER BY LINE_SEQ ASC ");
              while($kptt_nota_d->nextRow())
              {
              ?>
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" <?=$disabled?> class="easyui-validatebox" value="<?=$i?>" />
                  </td>
                  <td>
                    <input type="text" name="reqNoNota[]" <?=$disabled?> class="easyui-validatebox" value="<?=$kptt_nota_d->getField("NO_REF3")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqNoPelangganDetil[]" <?=$disabled?> class="easyui-validatebox" />
                  </td>
                  <td>
                    <input type="text" name="reqTanggalNota[]" <?=$disabled?> class="easyui-validatebox" />
                  </td>
                  <td>
                    <input type="text" name="reqJumlahBayar[]" <?=$disabled?>  style="text-align:right" id="reqJumlahBayar<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahBayar<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahBayar<?=$checkbox_index?>')" value="">
                  </td>
                  <td>
                    <input type="text" name="reqJumlahDikembalikan[]" <?=$disabled?> style="text-align:right"  id="reqJumlahDikembalikan<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahDikembalikan<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahDikembalikan<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahDikembalikan<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("JML_VAL_TRANS"))?>">
                  </td>
                  <td>
                    <input type="text" name="reqSisa[]" style="text-align:right"  <?=$disabled?> id="reqSisa<?=$checkbox_index?>"  OnFocus="FormatAngka('reqSisa<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisa<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisa<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("JML_VAL_TRANS"))?>">
                  </td>
                  <td>
                  	 <input type="text" name="reqPrevNoNota[]" <?=$disabled?> id="reqPrevNoNota<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("PREV_NO_NOTA")?>">
                  </td>
              </tr>
			  <?
                $i++;
                $checkbox_index++;
                $temp_jml_trans += $kptt_nota_d->getField('JML_VAL_TRANS');
              }
              ?>
        </tbody>
        
        <tfoot class="altrowstable">
        	<tr style="background:#f1f4fc">
            	<td colspan="5">&nbsp;</td>         	
                <td><input type="text" id="reqJumlahTrans" name="reqJumlahTrans" style="text-align:right;" <?=$disabled?> value="<?=numberToIna($temp_jml_trans)?>" /></td>            	
            	<td></td><td></td>
            </tr>
        </tfoot>
    </table>        
    </form>
</div>
</body>
</html>