<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");

$kptt_nota = new KpttNota();
$kptt_nota_d = new KpttNotaD();
$safr_valuta = new SafrValuta();
$kbbr_tipe_trans_d = new KbbrTipeTransD();

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
	$tempTanggalValuta =  date("d-m-Y");
}
else
{
	$reqMode = "update";	
	$kptt_nota->selectByParams(array("A.NO_NOTA"=>$reqId), -1, -1);
	$kptt_nota->firstRow();
	$tempNoBukti = $kptt_nota->getField("NO_NOTA");
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota->getField("TGL_TRANS"));
	$tempTahun = $kptt_nota->getField("THN_BUKU");
	$tempBulan = $kptt_nota->getField("BLN_BUKU");
	$tempNoPelanggan = $kptt_nota->getField("KD_KUSTO");
	$tempPelanggan = $kptt_nota->getField("MPLG_NAMA");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempBuktiPendukung = $kptt_nota->getField("NO_REF1");
	$tempTanggalValuta = dateToPageCheck($kptt_nota->getField("TGL_VALUTA"));
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
	$tempBadanUsaha = $kptt_nota->getField("BADAN_USAHA");
}

$kbbr_tipe_trans_d->selectByParams(array("TIPE_TRANS" => "JRR-KPT-04"));
while($kbbr_tipe_trans_d->nextRow())
{
	$arrTipeTransD["KLAS_TRANS"][] = $kbbr_tipe_trans_d->getField("KLAS_TRANS");
	$arrTipeTransD["KETK_TRANS"][] = $kbbr_tipe_trans_d->getField("KETK_TRANS");		
}

$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
	<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/global-tab-easyui.js"></script>
    <script type="text/javascript" src="js/entri_kompensasi_sisa_uper.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');	
			$("#reqNoPelanggan").focus();
		}		
		/* KBBT_JUR_BB */
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/proses_kompensasi_sisa_super_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");	
					$.messager.alert('Info', data[1], 'info');	
					if(data[0] == 0)				
					{}
					else
					{
						document.location.href = 'proses_kompensasi_sisa_super_add.php?reqId='+data[0];
						top.frames['mainFrame'].location.reload();
					}
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
					});				
					
					return false;
				}
			
			});	
			
			$("#reqNoPelanggan").keydown(function(event) { 
				
				if(event.keyCode == 120){
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
			$("#reqNoPelanggan").focus();
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Konpensasi Nota Tagih</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
    	<thead>
        <tr>           
             <td>No Bukti</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" style="width:170px; background-color:#f0f0f0" type="text" readonly value="<?=$tempNoBukti?>"/>
			</td>
            <td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" tabindex="4" onMouseDown="tabindex=4" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Thn / Bln Buku
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:60px; background-color:#f0f0f0" readonly value="<?=$tempTahun?>" />
                &nbsp;/&nbsp;
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px; background-color:#f0f0f0" readonly value="<?=$tempBulan?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan [F9]</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoPelanggan?>" tabindex="1" onMouseDown="tabindex=1" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" style="width:295px; background-color:#f0f0f0" type="text" value="<?=$tempPelanggan?>" readonly />
                <input name="reqBadanUsaha" id="reqBadanUsaha" class="easyui-validatebox" style="width:295px" type="hidden" value="<?=$tempBadanUsaha?>" readonly />
            </td>
            <td>Valuta</td>
			<td>
                <select name="reqValutaNama" id="reqValutaNama" tabindex="5" onFocus="tabindex=5">
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
        </tr>
        <tr>
        	<td>Bukti&nbsp;Pendukung</td>
			 <td>
				<input name="reqBuktiPendukung" class="easyui-validatebox" style="width:350px" type="text" value="<?=$tempBuktiPendukung?>" tabindex="2" onMouseDown="tabindex=2" />
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" readonly <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> style="width:100px; background-color:#f0f0f0" value="<?=$tempTanggalValuta?>" />
                &nbsp;
                Kurs
                <input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:100px; background-color:#f0f0f0" type="text" value="<?=$tempKursValuta?>" readonly />
			</td>
        </tr>
        <tr>
            <td>Keterangan</td>
			<td>
                <input name="reqKeterangan" class="easyui-validatebox" style="width:350px" type="text" value="<?=$tempKeterangan?>" tabindex="3" onMouseDown="tabindex=3" />
			</td>
        </tr>   
        <tr>
        	<td colspan="4">
            <div>
                <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <input type="submit" value="Submit">
                <input type="reset" id="rst_form">
                <?
                if($reqMode == "update")
				{
				?>
                <input type="button" value="Rincian Jurnal" onClick="OpenDHTMLPopup('jurnal_lihat.php?reqId=<?=$reqId?>', 'Rincian Jurnal', 900, 600)">
            	<?
				}
				?>          
                <input type="button" name="btnClose" id="btnClose" value="Close" onClick="window.parent.divwin.close();">      
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
                No&nbsp;Nota</th>
              <th>Sumber Bayar</th>
              <th>Kartu</th>
              <th>No</th>
              <th>No. Ref 1</th>
              <th>Tanggal Transaksi</th>
              <th>Jumlah</th>
              <th>Sisa Tagihan</th>
              <th>Jumlah Dibayar</th>
              <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
          <?
          $i = 1;
          $checkbox_index = 0;
          
          $kptt_nota_d->selectByParamsKompensasiSisaUper(array("A.NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY LINE_SEQ ASC ");
          while($kptt_nota_d->nextRow())
          {
          ?>
              <tr id="node-<?=$i?>">
                  <td>
                  <input type="text" name="reqNoNota[]" id="reqNoNota<?=$checkbox_index?>" class="easyui-validatebox" value="<?=$kptt_nota_d->getField("NO_REF3")?>" />
                  </td>
                  <td>
                    <select name="reqSumberBayar[]" id="reqSumberBayar<?=$checkbox_index?>" onChange="ambilReferensiKlasTrans('<?=$checkbox_index?>')">
                    <?
                    for($j=0;$j<count($arrTipeTransD["KLAS_TRANS"]);$j++)
                    {
                    ?>
                        <option value="<?=$arrTipeTransD["KLAS_TRANS"][$j]?>" <? if($kptt_nota_d->getField("KLAS_TRANS") == $arrTipeTransD["KLAS_TRANS"][$j]) { ?> selected <? } ?>><?=$arrTipeTransD["KETK_TRANS"][$j]?></option>
                    <?
                    }
                    ?>
                    </select>
                  </td>
                  <td>
                    <input type="text" name="reqKartu[]" id="reqKartu<?=$checkbox_index?>" class="easyui-validatebox" value="<?=$kptt_nota_d->getField("KD_SUB_BANTU")?>" />
                  </td>
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" />
                  </td>                  
                  <td>
                    <input type="text" name="reqNoRef[]" id="reqNoRef<?=$checkbox_index?>" class="easyui-validatebox" readonly value="<?=$kptt_nota_d->getField("NO_REF3")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqTanggalNota[]" id="reqTanggalNota<?=$checkbox_index?>" class="easyui-validatebox" readonly value="<?=dateToPage($kptt_nota_d->getField("TGL_TRANS"))?>" />
                  </td>                  
                  <td>
                    <input type="text" name="reqJumlah[]"  style="text-align:right;"  id="reqJumlah<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahBayar<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahBayar<?=$checkbox_index?>')" readonly value="0">
                  </td>
                  <td>
                    <input type="text" name="reqSisaTagihan[]"  style="text-align:right;" id="reqSisaTagihan<?=$checkbox_index?>"  OnFocus="FormatAngka('reqSisaTagihan<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisaTagihan<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisaTagihan<?=$checkbox_index?>')" readonly value="<?=numberToIna($kptt_nota_d->getField("SISA_VAL_BAYAR"))?>">
                  </td>                                                               																																																																																																																					
                  <td>
                    <input type="text" name="reqJumlahDibayar[]"  style="text-align:right;" id="reqJumlahDibayar<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahDibayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahDibayar<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahDibayar<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("JML_VAL_TRANS"))?>">
                  </td>
                  <td align="center">
                  <label>
                  <!--QUESTION : BAGAIMANA MENETUKAN 403.05 DAN 403.04-->
                  <input type="hidden" name="reqBukuBesar[]" id="reqBukuBesar<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("KD_BUKU_BESAR")?>">
                  <input type="hidden" name="reqBukuPusat[]" id="reqBukuPusat<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("KD_BUKU_PUSAT")?>">
                  <input type="hidden" name="reqPrevNoNota[]" id="reqPrevNoNota<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("PREV_NO_NOTA")?>">
                  <a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
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
            	<td colspan="8">&nbsp;</td>
            	<td class=""><input type="text" id="reqTotalBayar" name="reqTotalBayar" style="text-align:right;" readonly value="<?=numberToIna($temp_jml_debet)?>" /></td>
				<td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>        
    </form>
</div>
</body>
</html>