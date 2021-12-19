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
	$tempKdSubSis =  $kptt_nota->getField("KD_SUBSIS");
}
$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
$kbbr_tipe_trans->selectByParams(array("KD_SUBSIS" => "KPT", "KD_JURNAL" => "JKK"));

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
    <script type="text/javascript" src="js/entri_pembatalan_kompensasi.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');	
			$('#reqPelanggan').next().find('input').focus();
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
					//$.messager.alert('Info', data, 'info');
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'pembatalan_kompensasi_add.php?reqId='+data[0];
					top.frames['mainFrame'].location.reload();
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

			$('#btnPosting').on('click', function () {
				if(confirm("Posting jurnal <?=$reqId?> ?"))
				{			
					$.getJSON('../json-keuangansiuk/posting_jurnal_aksi.php?reqId=<?=$reqId?>&reqKdSubSis=<?=$tempKdSubSis?>',
					  function(data){
						  alert("Data berhasil diposting.");		
						  document.location.href = 'pembatalan_kompensasi_add.php?reqId=<?=$reqId?>';
						  top.frames['mainFrame'].location.reload();
					});	
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Pembatalan Pelunasan Per Nota (JRR)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>
             <td>No Bukti</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" style="width:170px; background-color:#f0f0f0" type="text" readonly value="<?=$tempNoBukti?>" />
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalValuta?>" />
                &nbsp;&nbsp;
                Thn / Bln Buku
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:60px; background-color:#f0f0f0" readonly value="<?=$tempTahun?>" />
                &nbsp;/&nbsp;
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:30px; background-color:#f0f0f0" readonly value="<?=$tempBulan?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="hidden" value="<?=$tempNoPelanggan?>"  onKeyDown="openPopup('PELANGGAN');"/>           
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-combobox" style="width:295px" type="text" value="<?=$tempNoPelanggan?>"  data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/pelanggan_by_id_combo_json.php',
                    onSelect:function(rec){ 
                    	$('#reqNoPelanggan').val(rec.MPLG_KODE);
                    	$('#reqBadanUsaha').val(rec.MPLG_BADAN_USAHA);
                    }
                    "
                      tabindex="1" onMouseDown="tabindex=1" /> 	         
                <input name="reqBadanUsaha" id="reqBadanUsaha" type="hidden" style="width:90px; background-color:#f0f0f0" value="<?=$tempBadanUsaha?>" readonly>   
                <input name="reqKdBbKusto" id="reqKdBbKusto" class="easyui-validatebox" style="width:295px" type="hidden" value="<?=$tempKdBbKusto?>" readonly />
             </td>
            <td>Rek. Kas / Bank</td>
			<td>
             	<input name="reqNoBukuBesarKas" id="reqNoBukuBesarKas" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoBukuBesarKas?>" />
                <input name="reqBank" id="reqBank" class="easyui-validatebox" style="width:200px" type="text" value="<?=$tempBank?>" readonly />
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
            <td>Tanggal, No&nbsp;Posting</td>
            <td>
            	<input id="reqTanggalPosting" name="reqTanggalPosting" style="width:100px; background-color:#f0f0f0" <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> value="<?=$tempTanggalPosting?>" readonly />
                &nbsp;
				<input name="reqNoPosting" class="easyui-validatebox" style="width:60px; background-color:#f0f0f0" type="text" value="<?=$tempNoPosting?>"  readonly />
                &nbsp;
                Jumlah Transaksi
                <input id="reqJumlahTransaksi" name="reqJumlahTransaksi" class="easyui-validatebox" style="width:140px; background-color:#f0f0f0" OnFocus="FormatAngka('reqJumlahTransaksi')" OnKeyUp="FormatUang('reqJumlahTransaksi')" OnBlur="FormatUang('reqJumlahTransaksi')" readonly value="<?=numberToIna($tempJumlahTransaksi)?>" />
            </td>
        </tr>
        <tr>
            <td>Kurs&nbsp;Valuta</td>
			<td>
            	<input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px; background-color:#f0f0f0" type="text" value="<?=$tempKursValuta?>" readonly />
			</td>
            <td>Rek. Kompen</td>
			<td>
            	<input name="reqRekKompen" class="easyui-validatebox" style="width:120px" type="text" value="<?=$tempRekKompen?>" />
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
                    if($tempNoPosting == "")
                    {
                    ?>
                        <input type="button" name="btnPosting" id="btnPosting" value="Posting">
					<?
					}
					?>                                    
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
                No
                <a style="cursor:pointer" title="Tambah" onclick="addRow()"><img src="../WEB-INF/images/tree-add.png" width="16" height="16" border="0" /></a>
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
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" readonly value="<?=$i?>" />
                  </td>
                  <td>
                    <input type="text" name="reqNoNota[]" class="easyui-validatebox" value="<?=$kptt_nota_d->getField("NO_REF3")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqNoPelangganDetil[]" class="easyui-validatebox" readonly />
                  </td>
                  <td>
                    <input type="text" name="reqTanggalNota[]" class="easyui-validatebox" readonly />
                  </td>
                  <td>
                    <input type="text" name="reqJumlahBayar[]"  style="text-align:right" id="reqJumlahBayar<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahBayar<?=$checkbox_index?>')" readonly OnBlur="FormatUang('reqJumlahBayar<?=$checkbox_index?>')" value="">
                  </td>
                  <td>
                    <input type="text" name="reqJumlahDikembalikan[]" style="text-align:right"  id="reqJumlahDikembalikan<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahDikembalikan<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahDikembalikan<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahDikembalikan<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("JML_VAL_TRANS"))?>">
                  </td>
                  <td>
                    <input type="text" name="reqSisa[]" style="text-align:right"  id="reqSisa<?=$checkbox_index?>"  OnFocus="FormatAngka('reqSisa<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisa<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisa<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("JML_VAL_TRANS"))?>">
                  </td>
                  <td>
                  	 <input type="hidden" name="reqPrevNoNota[]" id="reqPrevNoNota<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("PREV_NO_NOTA")?>">
 	                 <center><a style="cursor:pointer;" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center>
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
                <td><input type="text" id="reqJumlahTrans" name="reqJumlahTrans" style="text-align:right;" readonly value="<?=numberToIna($temp_jml_trans)?>" /></td>            	
            	<td></td><td></td>
            </tr>
        </tfoot>
    </table>        
    </form>
</div>
</body>
</html>