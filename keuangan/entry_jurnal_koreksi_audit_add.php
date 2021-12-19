<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbDTmp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
$safr_valuta = new SafrValuta();
$kbbt_jur_bb = new KbbtJurBb();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$tempKursValuta = 1;
	$tempTahun = date("Y") - 1;
	$tempBulan = 15;	
	$tempTanggalTransaksi = "31-12-".(date("Y") - 1);
	$tempTanggalValuta = "31-12-".(date("Y") - 1);
}
else
{
	$kbbt_jur_bb_tmp->selectByParams(array("NO_NOTA"=>$reqId));
	$kbbt_jur_bb_tmp->firstRow();
	
	$kbbt_jur_bb->selectByParamsSimple(array("NO_NOTA"=>$reqId));
	$kbbt_jur_bb->firstRow();
	
	$tempNoBuktiSiuk = $kbbt_jur_bb_tmp->getField("NO_NOTA");
	$tempAlamat = $kbbt_jur_bb_tmp->getField("ALMT_AGEN_PERUSH");
	$tempBuktiPendukung = $kbbt_jur_bb_tmp->getField("NO_REF3");
	$tempValutaNama = $kbbt_jur_bb_tmp->getField("KD_VALUTA");
	$tempBulan = $kbbt_jur_bb_tmp->getField("BLN_BUKU");
	$tempTahun = $kbbt_jur_bb_tmp->getField("THN_BUKU");
	$tempKursValuta = numberToIna($kbbt_jur_bb_tmp->getField("KURS_VALUTA"));
	$tempTanggalTransaksi = dateToPageCheck($kbbt_jur_bb_tmp->getField("TGL_TRANS"));
	$tempKeterangan = $kbbt_jur_bb_tmp->getField("KET_TAMBAH");
	$tempPerusahaan = $kbbt_jur_bb_tmp->getField("NM_AGEN_PERUSH");
	$tempNoPosting = $kbbt_jur_bb_tmp->getField("NO_POSTING");
	$tempTanggalPosting = dateToPageCheck($kbbt_jur_bb_tmp->getField("TGL_POSTING"));
	$tempKusto = $kbbt_jur_bb_tmp->getField("KD_KUSTO");
	$tempTanggalValuta = dateToPageCheck($kbbt_jur_bb_tmp->getField("TGL_VALUTA"));
	$tempNoFaktur = $kbbt_jur_bb_tmp->getField("NOREK_BANK");
	$tempNoDokumen = $kbbt_jur_bb->getField("NO_REG_KASIR");
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
    <script type="text/javascript" src="js/entri_tabel_jurnal_koreksi_audit.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');
			$('#reqBuktiPendukung').focus();			
		}		
		/* KBBT_JUR_BB */
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/entry_jurnal_koreksi_audit_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'entry_jurnal_koreksi_audit_add.php?reqId='+data[0];
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
		
		function openPopup(tipe)
		{
		
		var isCtrl = false;$('#reqPerusahaan').keyup(function (e) {
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
		document.getElementById('reqKusto').value = id;
		document.getElementById('reqPerusahaan').value = nama;
		document.getElementById('reqAlamat').value = alamat;
		$("#reqPerusahaan").focus();
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Jurnal Rupa-Rupa (JRR) Untuk Koreksi Audit</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>
        <tr>           
            <td>No&nbsp;Bukti&nbsp;(SIUK)</td>
			<td>
				<input name="reqNoBukti" class="easyui-validatebox" style="width:170px" type="text" readonly value="<?=$tempNoBuktiSiuk?>" />
			</td>
            <td>Valuta</td>
            <td>
            	<select name="reqValutaNama" id="reqValutaNama" tabindex="3">
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
                Tgl Valuta <input id="reqTanggalValuta" name="reqTanggalValuta" <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> readonly value="<?=$tempTanggalValuta?>" />&nbsp;&nbsp;
            	Kurs&nbsp;Valuta <input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKursValuta?>" readonly />
			                
            </td>
        </tr>
        <tr> 
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Periode
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" value="<?=$tempBulan?>" style="width:20px;" readonly />&nbsp;&nbsp;
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" value="<?=$tempTahun?>" style="width:30px;" readonly />
			</td>                  
            <td>No Faktur</td>
			<td>
				<input name="reqNoFaktur" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoFaktur?>" tabindex="4"/>
			</td>           
        </tr>
        <tr>        
             <td>Bukti&nbsp;Pendukung</td>
			 <td>
				<input name="reqBuktiPendukung" id="reqBuktiPendukung" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempBuktiPendukung?>" tabindex="1" />
			</td>
            <td>Keterangan Tambahan</td>
            <td>
				<input name="reqKeteranganJurnal" class="easyui-validatebox" style="width:399px" type="text" value="<?=$tempKeterangan?>" tabindex="5" />
            </td>
        </tr>
        <tr>
             <td>Agen&nbsp;/&nbsp;Perusahaan [F9]</td>
			 <td>
 	            <input type="hidden" name="reqKusto" id="reqKusto" value="<?=$tempKusto?>">
				<input name="reqPerusahaan" id="reqPerusahaan" class="easyui-validatebox" style="width:300px" type="text" value="<?=$tempPerusahaan?>" onKeyDown="openPopup('PELANGGAN');" tabindex="2" />
                &nbsp;&nbsp;&nbsp;&nbsp;
			</td>
            <td>No Dokumen</td>
			<td>
				<input name="reqNoDokumen" class="easyui-validatebox" style="width:170px" type="text" readonly value="<?=$tempNoDokumen?>" />
			</td>              
        </tr>
        <tr>       
            <td>Alamat</td>
			 <td>
             	<input name="reqAlamat" id="reqAlamat" class="easyui-validatebox" style="width:300px" type="text" value="<?=$tempAlamat?>" readonly />
			</td>  
            <td>No / Tanggal Posting</td>
			 <td>
				<input name="reqNoPosting" class="easyui-validatebox" style="width:100px" type="text" readonly value="<?=$tempNoPosting?>"  />
                <input id="reqTanggalPosting" name="reqTanggalPosting" <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> value="<?=$tempTanggalPosting?>" readonly />
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
              <th style="width:10%">Buku&nbsp;Besar</th>
              <th style="width:10%">Kartu</th>
              <th style="width:10%">Buku&nbsp;Pusat</th>
              <th>Keterangan</th>
              <th style="width:10%">Debet (Val)</th>
              <th style="width:10%">Kredit (Val)</th>
              <th style="width:10%">Debet (Rp)</th>
              <th style="width:10%">Kredit (Rp)</th>
              <th style="width:5%">Aksi</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
          <?
          $i = 1;
          $checkbox_index = 0;
          
          $kbbt_jur_bb_d_tmp->selectByParams(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY NO_SEQ ASC ");
          while($kbbt_jur_bb_d_tmp->nextRow())
          {
          ?>
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" style="width:88px" />
                  </td>
                  <td>
                  	<input id="reqBukuBesar<?=$checkbox_index?>" name="reqBukuBesar[]" class="easyui-combobox" data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/buku_besar_combo_json.php',
                    onSelect:function(rec){
                    }<?php /*?>,
                    validType:['exists[\'#reqBukuBesar<?=$checkbox_index?>\']','checkOption[\'reqBukuBesar\', \'<?=$checkbox_index?>\']']<?php */?>
                    "
                    value="<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_BESAR")?>" style="width:198px" />
                  </td>
                  <td>
                  	<input id="reqKartu<?=$checkbox_index?>" name="reqKartu[]" class="easyui-combobox" data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/kartu_tambah_combo_json.php',
                    onSelect:function(rec){
                    }<?php /*?>,
                    validType:['exists[\'#reqKartu<?=$checkbox_index?>\']']<?php */?>
                    "
                    value="<?=$kbbt_jur_bb_d_tmp->getField("KD_SUB_BANTU")?>" style="width:198px" />
                  </td>
                  <td>
                  	<input id="reqBukuPusat<?=$checkbox_index?>" name="reqBukuPusat[]" class="easyui-combobox" data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/buku_pusat_combo_json.php',
                    onSelect:function(rec){
                    }<?php /*?>,
                    validType:['exists[\'#reqBukuPusat<?=$checkbox_index?>\']']<?php */?>
                    "
                    value="<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_PUSAT")?>" style="width:198px" />
                  </td>
                  <td>
                    <input type="text" name="reqKeterangan[]" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KET_TAMBAH")?>" style="width:98%;" />
                  </td>
                  <td>
                    <input type="text" name="reqDebet[]" id="reqDebet<?=$checkbox_index?>" style="text-align:right; width:111px" OnFocus="FormatAngka('reqDebet<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqDebet<?=$checkbox_index?>'); hitungDebetTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqDebet<?=$checkbox_index?>')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_DEBET'))?>">
                  </td>
                  <td>
                    <input type="text" name="reqKredit[]" id="reqKredit<?=$checkbox_index?>" style="text-align:right; width:111px" OnFocus="FormatAngka('reqKredit<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqKredit<?=$checkbox_index?>'); hitungKreditTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqKredit<?=$checkbox_index?>')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_KREDIT'))?>">
                  </td>
                  <td>
                    <input type="text" name="reqDebetRp[]" id="reqDebetRp<?=$checkbox_index?>" style="text-align:right; width:111px" OnFocus="FormatAngka('reqDebetRp<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqDebetRp<?=$checkbox_index?>'); hitungDebetTotalRp('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqDebetRp<?=$checkbox_index?>')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_RP_DEBET'))?>">
                  </td>
                  <td>
                    <input type="text" name="reqKreditRp[]" id="reqKreditRp<?=$checkbox_index?>" style="text-align:right; width:111px" OnFocus="FormatAngka('reqKreditRp<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqKreditRp<?=$checkbox_index?>'); hitungKreditTotalRp('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqKreditRp<?=$checkbox_index?>')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_RP_KREDIT'))?>">
                  </td>
                  <td align="center">
                  <label>
                  <a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
                  </label>
                  </td>
              </tr>
			  <?
                $i++;
                $checkbox_index++;
                $temp_jml_debet += $kbbt_jur_bb_d_tmp->getField('SALDO_VAL_DEBET');
                $temp_jml_kredit += $kbbt_jur_bb_d_tmp->getField('SALDO_VAL_KREDIT');
                $temp_jml_debet_rp += $kbbt_jur_bb_d_tmp->getField('SALDO_RP_DEBET');
                $temp_jml_kredit_rp += $kbbt_jur_bb_d_tmp->getField('SALDO_RP_KREDIT');
              }
              ?>
              <?
			  if($checkbox_index == 0)
			  {
              ?>
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" style="width:88px" />
                  </td>
                  <td>
                  	<input id="reqBukuBesar<?=$checkbox_index?>" name="reqBukuBesar[]" class="easyui-combobox" data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/buku_besar_combo_json.php',
                    onSelect:function(rec){
                    }<?php /*?>,
                    validType:['exists[\'#reqBukuBesar<?=$checkbox_index?>\']','checkOption[\'reqBukuBesar\', \'<?=$checkbox_index?>\']']<?php */?>
                    "
                    value="" style="width:198px" tabindex="6" />
                  </td>
                  <td>
                  	<input id="reqKartu<?=$checkbox_index?>" name="reqKartu[]" class="easyui-combobox" data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/kartu_tambah_combo_json.php',
                    onSelect:function(rec){
                    }<?php /*?>,
                    validType:['exists[\'#reqKartu<?=$checkbox_index?>\']']<?php */?>
                    "
                    value="" style="width:198px" tabindex="7" />
                  </td>
                  <td>
                  	<input id="reqBukuPusat<?=$checkbox_index?>" name="reqBukuPusat[]" class="easyui-combobox" data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/buku_pusat_combo_json.php',
                    onSelect:function(rec){
                    }<?php /*?>,
                    validType:['exists[\'#reqBukuPusat<?=$checkbox_index?>\']']<?php */?>
                    "
                    value="" style="width:198px" tabindex="8"/>
                  </td>
                  <td>
                    <input type="text" name="reqKeterangan[]" class="easyui-validatebox" style="width:98%;" tabindex="9"/>
                  </td>
                  <td>
                    <input type="text" name="reqDebet[]" id="reqDebet<?=$checkbox_index?>" style="text-align:right; width:111px" OnFocus="FormatAngka('reqDebet<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqDebet<?=$checkbox_index?>'); hitungDebetTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqDebet<?=$checkbox_index?>')" tabindex="10"/>
                  </td>
                  <td>
                    <input type="text" name="reqKredit[]" id="reqKredit<?=$checkbox_index?>" style="text-align:right; width:111px" OnFocus="FormatAngka('reqKredit<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqKredit<?=$checkbox_index?>'); hitungKreditTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqKredit<?=$checkbox_index?>')" tabindex="11"/>
                  </td>
                  <td>
                    <input type="text" name="reqDebetRp[]" id="reqDebetRp<?=$checkbox_index?>" style="text-align:right; width:111px" OnFocus="FormatAngka('reqDebetRp<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqDebetRp<?=$checkbox_index?>'); hitungDebetTotalRp('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqDebetRp<?=$checkbox_index?>')" tabindex="12" />
                  </td>
                  <td>
                    <input type="text" name="reqKreditRp[]" id="reqKreditRp<?=$checkbox_index?>" style="text-align:right; width:111px" OnFocus="FormatAngka('reqKreditRp<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqKreditRp<?=$checkbox_index?>'); hitungKreditTotalRp('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqKreditRp<?=$checkbox_index?>')" tabindex="13" />
                  </td>
                  <td align="center">
                  <label>
                  <a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
                  </label>
                  </td>
              </tr>
              <?
			  }
              ?>
        </tbody>
        
        <tfoot class="altrowstable">
        	<tr style="background:#f1f4fc">
            	<td>&nbsp;</td>
            	<td>
                <div>
                    <input type="checkbox" id="reqAll" name="reqAll" disabled <? if($reqAll == 'on') echo "checked";?>>
                    <label for="reqAll">All</label> 
                </div>
                </td>
            	<td>
                <div>
                    <input type="checkbox" id="reqBalance" name="reqBalance" disabled <? if(floor($temp_jml_debet) == floor($temp_jml_kredit)) { ?> checked <? } ?>>
                    <label for="reqBalance">Balance</label> 
                </div>
                </td>
            	<td>
                <div>
                    <input type="checkbox" id="reqUnbalance" name="reqUnbalance" disabled <? if(floor($temp_jml_debet) == floor($temp_jml_kredit)) {} else { ?> checked <? } ?>>
                    <label for="reqUnbalance">Unbalance</label> 
                </div>
                </td>
            	<td>&nbsp;</td>
            	<td class=""><input type="text" id="reqJumlahDebet" name="reqJumlahDebet" style="text-align:right; width:111px" readonly value="<?=numberToIna($temp_jml_debet)?>" /></td>
            	<td class=""><input type="text" id="reqJumlahKredit" name="reqJumlahKredit" style="text-align:right; width:111px" readonly value="<?=numberToIna($temp_jml_kredit)?>" /></td>
            	<td class=""><input type="text" id="reqJumlahDebetRp" name="reqJumlahDebetRp" style="text-align:right; width:111px" readonly value="<?=numberToIna($temp_jml_debet_rp)?>" /></td>
            	<td class=""><input type="text" id="reqJumlahKreditRp" name="reqJumlahKreditRp" style="text-align:right; width:111px" readonly value="<?=numberToIna($temp_jml_kredit_rp)?>" /></td>
            <td>&nbsp;</td>
            </tr>
        </tfoot>
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
$('input[id^="reqKreditRp"]').keydown(function(e) {
	if(e.which==13)
	{
		addRow();
		var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
		if(key == 13) {
			e.preventDefault();
			var inputs = $(this).closest('form').find(':input:visible');
			inputs.eq( inputs.index(this)+ 1 ).focus();
		}
	}
});
</script>
</body>
</html>