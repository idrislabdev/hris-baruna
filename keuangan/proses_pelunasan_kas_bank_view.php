<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kptt_nota = new KpttNota();
$kptt_nota_d = new KpttNotaD();
$safr_valuta = new SafrValuta();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqMode = httpFilterGet("reqMode");

if($reqId == "")
{
	$reqMode = "insert";
	$tempKursValuta = 1;
	$tempTahun = date("Y");
	$tempBulan = "";	
	$tempTanggalTransaksi = date("d-m-Y");
}
else
{
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
	$tempJumlahTransaksi = $kptt_nota->getField("JML_VAL_TRANS");
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempNoPosting = $kptt_nota->getField("NO_POSTING");
	$tempBadanUsaha = $kptt_nota->getField("BADAN_USAHA");
	$reqMode = "update";
}
$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
$disabled= "disabled";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>proses pelunasan kas bank view</title>
	<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
    <script type="text/javascript" src="js/entri_pelunasan_kas_bank.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');	
		}		
		/* KBBT_JUR_BB */
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/proses_pelunasan_kas_bank_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'proses_pelunasan_kas_bank_add.php?reqId='+data[0];
					top.frames['mainFrame'].location.reload();
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
					
		
		function OptionSet(id, nama,alamat, npwp, badan_usaha){
			document.getElementById('reqNoPelanggan').value = id;
			document.getElementById('reqPelanggan').value = nama;
			document.getElementById('reqBadanUsaha').value = badan_usaha;
			getDataPPKB();
		}	
			
		function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2) - 100;
			
			//opWidth = iecompattest().clientWidth - 200;
			//opHeight = iecompattest().clientHeight - 40;
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
		}			
	</script>
    
    
</head>
     
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Pelunasan Kas-Bank (JKM)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
    	<thead>
        <tr>           
             <td>No Bukti</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoBukti?>" <?=$disabled?> />
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" class="easyui-datebox" <?=$disabled?> data-options="validType:'date'" value="<?=$tempTanggalValuta?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Thn / Bln Buku
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" <?=$disabled?> data-options="validType:'minLength[4]'" maxlength="4" value="<?=$tempTahun?>" />
                &nbsp;/&nbsp;
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" <?=$disabled?> data-options="validType:'minLength[2]'" maxlength="2" style="width:50px" value="<?=$tempBulan?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" <?=$disabled?> style="width:50px" type="text" value="<?=$tempNoPelanggan?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" <?=$disabled?> style="width:295px" type="text" value="<?=$tempPelanggan?>" />
                <input name="reqBadanUsaha" id="reqBadanUsaha" class="easyui-validatebox" <?=$disabled?> style="width:295px" type="hidden" value="<?=$tempBadanUsaha?>" />
			</td>
            <td>Rek. Kas / Bank</td>
			 <td>
             	<input name="reqNoBukuBesarKas" id="reqNoBukuBesarKas" class="easyui-validatebox" <?=$disabled?> style="width:50px" type="text" value="<?=$tempNoBukuBesarKas?>" />
                <input name="reqBank" id="reqBank" class="easyui-validatebox" <?=$disabled?> style="width:200px" type="text" value="<?=$tempBank?>" />
                <input name="reqKodeKasBank" id="reqKodeKasBank"  class="easyui-validatebox" <?=$disabled?> style="width:100px" value="<?=$tempKodeKasBank?>" />
			</td>
        </tr>
        <tr>
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" <?=$disabled?> data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
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
                <select name="reqValutaNama" id="reqValutaNama" onChange="getDataPPKB();" <?=$disabled?>>
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
            	<input id="reqTanggalPosting" name="reqTanggalPosting" <?=$disabled?> <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> value="<?=$tempTanggalPosting?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Jml Trans
                <input id="reqJumlahTransaksi" name="reqJumlahTransaksi" class="easyui-validatebox" <?=$disabled?> style="width:140px" OnFocus="FormatAngka('reqJumlahTransaksi')" OnKeyUp="FormatUang('reqJumlahTransaksi')" OnBlur="FormatUang('reqJumlahTransaksi')" value="<?=numberToIna($tempJumlahTransaksi)?>"  />             
            </td>
        </tr>
        <tr>
            <td>Kurs&nbsp;Valuta</td>
			<td>
            	<input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" <?=$disabled?> style="width:50px" type="text" value="<?=$tempKursValuta?>" />
            </td>
            <td>No&nbsp;Posting</td>
			 <td>
                <input name="reqNoPosting" class="easyui-validatebox" <?=$disabled?> style="width:140px" type="text" value="<?=$tempNoPosting?>" />
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
              <th>No PPKB</th>
              <th>Pelanggan</th>
              <th>Tanggal Nota</th>
              <th>Sisa Piutang</th>
              <th>Jumlah Bayar</th>
              <th>Sisa Bayar</th>
              <th>Uang Titipan</th>
              <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
          <?
          $i = 1;
          $checkbox_index = 0;
          
          $kptt_nota_d->selectByParamsPelunasanKasBank(array("A.NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY LINE_SEQ ASC ");
          while($kptt_nota_d->nextRow())
          {
          ?>
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" <?=$disabled?> />
                  </td>
                  <td>
                  <input type="text" name="reqNoPpkb[]" class="easyui-validatebox" <?=$disabled?> value="<?=$kptt_nota_d->getField("NO_REF3")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqPelanggan[]" class="easyui-validatebox" <?=$disabled?> value="<?=$kptt_nota_d->getField("MPLG_NAMA")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqTanggalNota[]" class="easyui-validatebox" <?=$disabled?> value="<?=dateToPage($kptt_nota_d->getField("TGL_TRANS"))?>" />
                  </td>
                  <td>
                    <input type="text" name="reqSisaPiutang[]"  <?=$disabled?> style="text-align:right;"  id="reqSisaPiutang<?=$checkbox_index?>"  OnFocus="FormatAngka('reqSisaPiutang<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisaPiutang<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisaPiutang<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("JML_TAGIHAN"))?>">
                  </td>
                  <td>
                    <input type="text" name="reqJumlahBayar[]"  <?=$disabled?> style="text-align:right;"  id="reqJumlahBayar<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahBayar<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahBayar<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("JML_VAL_TRANS"))?>">
                  </td>
                  <td>
                    <input type="text" name="reqSisaBayar[]"  <?=$disabled?> style="text-align:right;"  id="reqSisaBayar<?=$checkbox_index?>"  OnFocus="FormatAngka('reqSisaBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisaBayar<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisaBayar<?=$checkbox_index?>')">
                  </td>
                  <td>
                    <input type="text" name="reqUangTitipan[]"  <?=$disabled?> style="text-align:right;" id="reqUangTitipan<?=$checkbox_index?>"  OnFocus="FormatAngka('reqUangTitipan<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqUangTitipan<?=$checkbox_index?>')" OnBlur="FormatUang('reqUangTitipan<?=$checkbox_index?>')">
                  </td>
                  <td align="center">
                  <label>
                  <input type="hidden" name="reqBukuBesar[]" id="reqBukuBesar<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("KD_BB_KUSTO")?>">
                  <input type="hidden" name="reqPrevNoNota[]" id="reqPrevNoNota<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("PREV_NO_NOTA")?>">
                  </label>
                  </td>
              </tr>
			  <?
                $i++;
                $checkbox_index++;
                $temp_jml_debet += $kptt_nota_d->getField('JML_VAL_TRANS');
              }
              ?>
        </tbody>
        
        <tfoot class="altrowstable">
        	<tr style="background:#f1f4fc">
            	<td colspan="5">&nbsp;</td>
            	<td class=""><input type="text" id="reqTotalBayar" name="reqTotalBayar" style="text-align:right;" <?=$disabled?> value="<?=numberToIna($temp_jml_debet)?>" /></td>
            	<td></td>
                <td class=""><input type="text" id="reqTotalUangTitipan" name="reqTotalUangTitipan" style="text-align:right;" <?=$disabled?> value="" /></td>
            	<td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>        
    </form>
</div>
</body>
</html>