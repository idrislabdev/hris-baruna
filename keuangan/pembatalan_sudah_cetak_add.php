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

$kptt_nota = new KpttNota();
$safr_valuta = new SafrValuta();
$kptt_nota_d = new KpttNotaD();
$kbbr_tipe_trans_d = new KbbrTipeTransD();
$kbbr_general_ref_d = new KbbrGeneralRefD();
$kbbr_rule_modul = new KbbrRuleModul();

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
	$tempJumlahTagihan = $kptt_nota->getField("JML_VAL_TRANS");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
	$tempNoRef3 = $kptt_nota->getField("NO_REF3");
	$tempNotaUpdate = $kptt_nota->getField("PREV_NOTA_UPDATE");
	$tempTanggalPosting = dateToPageCheck($kptt_nota->getField("TGL_POSTING"));
	$tempNoPosting = $kptt_nota->getField("NO_POSTING");
	$tempBadanUsaha = $kptt_nota->getField("BADAN_USAHA");
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
    <script type="text/javascript" src="js/entri_pembatalan_sudah_cetak_nota.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');	
			$('#reqNoPelanggan').focus();
		}		
		/* KBBT_JUR_BB */
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/pembatalan_sudah_cetak_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'pembatalan_sudah_cetak_add.php?reqId='+data[0];
					top.frames['mainFrame'].location.reload();
				}
			});
			
		});
		
		$(function(){
			$("#reqNoRef3").keydown(function(event) { 
				if(event.keyCode == 120)
				{
					OpenDHTMLPopup('pembatalan_sudah_cetak_pencarian.php?reqId='+$("#reqNoPelanggan").val(), 'Pencarian Nota', 950, 600);
					
					return false;
				}			
				else if(event.keyCode == 13){
					event.cancelBubble = true;
					event.returnValue = false;
				
					if (event.stopPropagation) {   
					  event.stopPropagation();
					  event.preventDefault();
					}
					
			   		getDataJPJ();				
					
					return false;
				}
			});		  
		});	

		function OptionSetPPKB(id, no_pel, nama, badan_usaha){
			document.getElementById('reqNoRef3').value = id;		
			document.getElementById('reqNoPelanggan').value = no_pel;
			document.getElementById('reqPelanggan').value = nama;
			document.getElementById('reqBadanUsaha').value = badan_usaha;
			getDataJPJ();
		}	
		
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
			
			
			$('#reqTanggalTransaksi').datebox({
				onSelect: function(date){
					$('#reqTanggalValuta').datebox('setValue', date.getDate()+"-"+(date.getMonth()+1)+"-"+date.getFullYear());
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
					OpenDHTMLPopup('pelanggan_pencarian.php', 'Pencarian Pelanggan', 950, 600);
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Pembatalan Nota (JRR)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>
        <tr>           
             <td>No Bukti JRR</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" style="width:170px; background-color:#f0f0f0" type="text" readonly value="<?=$tempNoBukti?>" />
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" style="background-color:#f0f0f0" readonly <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> value="<?=$tempTanggalValuta?>" />
			</td>
        </tr>
     
        <tr>           
             <td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
			</td>
            <td>Nama Kapal</td>
			 <td>
             	<input id="reqKodeKapal" name="reqKodeKapal" class="easyui-validatebox" style="width:70px; background-color:#f0f0f0" readonly value="<?=$tempKodeKapal?>" />
                <input name="reqKapal" class="easyui-validatebox" style="width:290px; background-color:#f0f0f0" type="text" readonly value="<?=$tempKapal?>" />
			</td>
        </tr>
        <tr>           
             <td>Jenis Jasa</td>
			 <td>
             	<input name="reqJenisJasa" class="easyui-validatebox" style="width:150px" type="text" value="<?=$tempJenisJasa?>" />
             </td>
             <td>Materai</td>
             <td>
				<input name="reqMaterai" id="reqMaterai" class="easyui-validatebox" style="width:80px; background-color:#f0f0f0" type="text" readonly value="<?=$tempMaterai?>" />
                &nbsp;
                Jumlah Upper
                <input id="reqJumlahUpper" name="reqJumlahUpper" class="easyui-validatebox" style="width:140px; background-color:#f0f0f0" OnFocus="FormatAngka('reqJumlahUpper')" OnKeyUp="FormatUang('reqJumlahUpper')" OnBlur="FormatUang('reqJumlahUpper')" readonly value="<?=numberToIna($tempJumlahUpper)?>"  />
             </td>
        </tr>
        <tr>           
             <td>Kd Agen</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="hidden" value="<?=$tempNoPelanggan?>"  onKeyDown="openPopup('PELANGGAN');"/>           
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-combobox" style="width:275px" type="text" value="<?=$tempNoPelanggan?>"  data-options="
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
                <input name="reqBadanUsaha" id="reqBadanUsaha" type="text" style="width:90px; background-color:#f0f0f0" value="<?=$tempBadanUsaha?>" readonly>
			</td>
            <td>Jumlah Tagihan</td>
			 <td>
             	<input id="reqJumlahTagihan" name="reqJumlahTagihan" class="easyui-validatebox" style="width:140px; background-color:#f0f0f0" OnFocus="FormatAngka('reqJumlahTagihan')" OnKeyUp="FormatUang('reqJumlahTagihan')" OnBlur="FormatUang('reqJumlahTagihan')" readonly value="<?=numberToIna($tempJumlahTagihan)?>"  />
            </td>
        </tr>
        <tr>
            <td>Kode Valuta</td>
			<td>
            	<select name="reqValutaNama" id="reqValutaNama" tabindex="2">
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
                <input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px; background-color:#f0f0f0" type="text" value="<?=$tempKursValuta?>" readonly />
			</td>
            <td rowspan="2">Keterangan Tambahan</td>
            <td rowspan="2">
            	<textarea name="reqKeterangan" cols="50" rows="2" class="easyui-validatebox" required style="background-color:#f0f0f0" tabindex="4"><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>
            <td>No 1A / 1B / 1C [F9]</td>
			<td>
                <input name="reqNoRef3" id="reqNoRef3" class="easyui-validatebox" style="width:150px" type="text" value="<?=$tempNoRef3?>" tabindex="3" />
                <input name="reqNotaUpdate" id="reqNotaUpdate" class="easyui-validatebox" style="width:150px; background-color:#f0f0f0" type="text" readonly value="<?=$tempNotaUpdate?>" />
			</td>
        </tr>
            <tr>
                <td>Tanggal Posting</td>
                <td><input name="reqTanggalPosting" style="width:100px; background-color:#f0f0f0" value="<?=$tempTanggalPosting?>" readonly />&nbsp;&nbsp;No&nbsp;Posting &nbsp;&nbsp;<input name="reqNoPosting" value="<?=$tempNoPosting?>" style="background-color:#f0f0f0" readonly /></td>
            </tr>
        <tr>
        	<td colspan="4">
            <div>
	            <input id="reqTahun" name="reqTahun" type="hidden" maxlength="4" style="width:40px" value="<?=$tempTahun?>" readonly />
                <input id="reqBulan" name="reqBulan" type="hidden" maxlength="2" style="width:20px" value="<?=$tempBulan?>" readonly />
                <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <input type="hidden" name="reqPpnMaterai" id="reqPpnMaterai" value="<?=$ppn_materai?>">
                <?
                if($reqMode == "insert")
				{
				?>
                <input type="submit" value="Submit">
                <input type="reset" id="rst_form">
                <?
				}
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
                No
              </th>
              <th>Jenis Jasa</th>
              <th>Nilai Pajak</th>
              <th>Jumlah</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
			  <?
              $i = 1;
              $checkbox_index = 0;
              
              $kptt_nota_d->selectByParams(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY LINE_SEQ ASC ");
              while($kptt_nota_d->nextRow())
              {
              ?>
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" readonly value="<?=$i?>" />
                  </td>
                  <td>
                    <input type="text" name="reqKlasTrans[]" id="reqKlasTrans<?=$checkbox_index?>" class="easyui-validatebox" readonly value="<?=$kptt_nota_d->getField("KLAS_TRANS")?>" />                   
                  </td>
                   <td>
                    <input type="text" name="reqNilaiPajak[]" style="text-align:right;" id="reqNilaiPajak<?=$checkbox_index?>" readonly OnFocus="FormatAngka('reqNilaiPajak<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiPajak<?=$checkbox_index?>')" OnBlur="FormatUang('reqNilaiPajak<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JML_VAL_PAJAK'))?>">
                  </td>
                  <td>
                    <input type="text" name="reqJumlah[]" style="text-align:right;" id="reqJumlah<?=$checkbox_index?>" readonly  OnFocus="FormatAngka('reqJumlah<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlah<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlah<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JML_VAL_TRANS'))?>">
                  </td>                 
              </tr>
			  <?
                $i++;
                $checkbox_index++;
                $temp_jml_trans += $kptt_nota_d->getField('JML_VAL_TRANS');
                $temp_jml_pajak += $kptt_nota_d->getField('JML_VAL_PAJAK');
              }
              ?>
        </tbody>
        
        <tfoot class="altrowstable">
        	<tr style="background:#f1f4fc">
            	<td colspan="2">&nbsp;</td>
            	<td class=""><input type="text" id="reqJumlahPajak" name="reqJumlahPajak" style="text-align:right; background-color:#f0f0f0" readonly value="<?=numberToIna($temp_jml_pajak)?>" /></td>
            	<td><input type="text" id="reqJumlahTrans" name="reqJumlahTrans" style="text-align:right; background-color:#f0f0f0" readonly value="<?=numberToIna($temp_jml_trans)?>" /></td>            	
            </tr>
        </tfoot>
    </table>        
    </form>
</div>
</body>
</html>