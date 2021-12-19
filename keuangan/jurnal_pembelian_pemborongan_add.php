<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kbbt_jur_bb_tmp = new KbbtJurBb();
$kbbt_jur_bb_d_tmp = new KbbtJurBbD();
$safr_valuta = new SafrValuta();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$tempKursValuta = 1;
	$tempTahun = date("Y");
	$tempBulan = "";	
	$tempTanggalTransaksi = date("d-m-Y");
}
else
{
	$kbbt_jur_bb_tmp->selectByParams(array("NO_NOTA"=>$reqId), -1, -1);
	$kbbt_jur_bb_tmp->firstRow();
	
	$tempNoBukti = $kbbt_jur_bb_tmp->getField("NO_NOTA");
	$tempBuktiPendukung = $kbbt_jur_bb_tmp->getField("NO_REF3");
	$tempBuktiPendukung2 = $kbbt_jur_bb_tmp->getField("NO_REF2");
	$tempTanggalTransaksi = dateToPageCheck($kbbt_jur_bb_tmp->getField("TGL_TRANS"));
	$tempPerusahaan = $kbbt_jur_bb_tmp->getField("NM_AGEN_PERUSH");
	$tempAlamat = $kbbt_jur_bb_tmp->getField("ALMT_AGEN_PERUSH");
	$tempValutaNama = $kbbt_jur_bb_tmp->getField("KD_VALUTA");
	$tempKursValuta = numberToIna($kbbt_jur_bb_tmp->getField("KURS_VALUTA"));
	$tempNoFakturPajak = $kbbt_jur_bb_tmp->getField("NO_CEK_NOTA");
	$tempKeteranganJurnal = $kbbt_jur_bb_tmp->getField("KET_TAMBAH");
	$tempNoPosting = $kbbt_jur_bb_tmp->getField("NO_POSTING");
	$tempTanggalPosting = dateToPageCheck($kbbt_jur_bb_tmp->getField("TGL_POSTING"));
	$tempTahun = $kbbt_jur_bb_tmp->getField("THN_BUKU");
	$tempBulan = $kbbt_jur_bb_tmp->getField("BLN_BUKU");
	$tempKusto = $kbbt_jur_bb_tmp->getField("KD_SUB_BANTU");
	$tempNoRefNota = $kbbt_jur_bb_tmp->getField("NO_REF_NOTA");
	$tempUraian =  $kbbt_jur_bb_tmp->getField("URAIAN");
	
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
    <script type="text/javascript" src="js/entri_tabel_jurnal.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/global-tab-easyui.js"></script>
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
				url:'../json-keuangansiuk/jurnal_pembelian_pemborongan_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'jurnal_pembelian_pemborongan_add.php?reqId='+data[0];
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
		
		$("#reqAlamat").focus();
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Jurnal Pembelian Pemborongan (JPB)</span>
    </div>
    <form id="ff" method="post">
    <table style="margin-left:17px;">
    	<thead>
        <tr>           
             <td>No&nbsp;Bukti&nbsp;(SIUK)</td>
			 <td>
				<input name="reqNoBukti" id="reqNoBukti" class="easyui-validatebox" style="width:170px" type="text" readonly value="<?=$tempNoBukti?>" />
			</td>
            <td>Valuta</td>
			 <td>
				 <select name="reqValutaNama" id="reqValutaNama" tabindex="5" >
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
             <td>Bukti&nbsp;Pendukung 1</td>
			 <td>
				<input name="reqBuktiPendukung" id="reqBuktiPendukung" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempBuktiPendukung?>" tabindex="1"/>&nbsp;&nbsp;
                No. PO <input name="reqBuktiPendukung2" id="reqBuktiPendukung2" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempBuktiPendukung2?>" tabindex="2"/>
			</td>
            <td>Kurs&nbsp;Valuta</td>
			 <td>
				<input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKursValuta?>" readonly  />
			</td>
        </tr>
        <tr>           
             <td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" type="text" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" tabindex="3"/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input  type="hidden" id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:100px" value="<?=$tempTahun?>" />
                <input  type="hidden" id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px" value="<?=$tempBulan?>" />
			</td>
            <td>No Faktur Pajak</td>
			 <td>
				<input name="reqNoFakturPajak" class="easyui-validatebox" style="width:150px" type="text" value="<?=$tempNoFakturPajak?>"  tabindex="6"/>
			</td>
        </tr>
        <tr>           
             <td>Agen&nbsp;/&nbsp;Perusahaan</td>
			 <td>
                <input type="hidden" name="reqKusto" id="reqKusto" value="<?=$tempKusto?>">
				<input name="reqPerusahaan" id="reqPerusahaan" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempPerusahaan?>" onKeyDown="openPopup('PELANGGAN');" tabindex="4" /> [F9]
			</td>
            <td>No / Tanggal Posting</td>
			 <td>
				<input name="reqNoPosting" class="easyui-validatebox" style="width:100px" type="text" value="<?=$tempNoPosting?>" readonly />
                <input id="reqTanggalPosting" name="reqTanggalPosting" readonly <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> value="<?=$tempTanggalPosting?>" />
			</td>
        </tr>
        <tr>           
             <td valign="top">Alamat</td>
			 <td>
  	  	        <textarea name="reqAlamat" id="reqAlamat" style="width:433px; height:80px;" readonly><?=$tempAlamat?></textarea>
			</td>
            <td valign="top">Keterangan</td>
			 <td>
				<textarea name="reqKeteranganJurnal" style="width:400px; height:80px;" tabindex="7"><?=$tempKeteranganJurnal?></textarea>
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
              <th style="width:10%">Debet</th>
              <th style="width:10%">Kredit</th>
              <th style="width:5%">Aksi</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
          <?
          $i = 1;
          $checkbox_index=0;
          
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
                    	disableByPolaEntry(rec.POLA_ENTRY_ID, '<?=$checkbox_index?>');
                    }
                    "
                    value="<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_BESAR")?>" style="width:208px" tabindex="<? $last_tab++; echo $last_tab ?>" />
                  </td>
                  <td>
                  	<input id="reqKartu<?=$checkbox_index?>" name="reqKartu[]" class="easyui-combobox" data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/kartu_tambah_combo_json.php',
                    onSelect:function(rec){
                    }<?php /*?>,
                    validType:['exists[\'#reqKartu<?=$checkbox_index?>\']']<?php */?>
                    "
                    value="<?=$kbbt_jur_bb_d_tmp->getField("KD_SUB_BANTU")?>" style="width:208px" <? if($kbbt_jur_bb_d_tmp->getField("DISABLE_KARTU") == "DISABLED") {} else { ?> tabindex="<? $last_tab++; echo $last_tab ?>" <? } ?> <?=$kbbt_jur_bb_d_tmp->getField("DISABLE_KARTU")?> />
                  </td>
                  <td>
                  	<input id="reqBukuPusat<?=$checkbox_index?>" name="reqBukuPusat[]" class="easyui-combobox" data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/buku_pusat_combo_json.php',
                    onSelect:function(rec){
                    }
                    "
                    value="<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_PUSAT")?>" style="width:208px" <? if($kbbt_jur_bb_d_tmp->getField("DISABLE_BPUSAT") == "DISABLED") {} else { ?> tabindex="<? $last_tab++; echo $last_tab ?>" <? } ?> <?=$kbbt_jur_bb_d_tmp->getField("DISABLE_BPUSAT")?> />
                  </td>
                  <td>
                    <input type="text" name="reqKeterangan[]" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KET_TAMBAH")?>" style="width:98%;" tabindex="<? $last_tab++; echo $last_tab ?>" />
                  </td>
                  <td>
                    <input type="text" name="reqDebet[]" id="reqDebet<?=$checkbox_index?>" style="text-align:right;" OnFocus="FormatAngka('reqDebet<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqDebet<?=$checkbox_index?>'); hitungDebetTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqDebet<?=$checkbox_index?>')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_DEBET'))?>" tabindex="<? $last_tab++; echo $last_tab ?>" >
                  </td>
                  <td>
                    <input type="text" name="reqKredit[]" id="reqKredit<?=$checkbox_index?>" style="text-align:right;" OnFocus="FormatAngka('reqKredit<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqKredit<?=$checkbox_index?>'); hitungKreditTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqKredit<?=$checkbox_index?>')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_KREDIT'))?>" tabindex="<? $last_tab++; echo $last_tab ?>" >
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
                    	disableByPolaEntry(rec.POLA_ENTRY_ID, '<?=$checkbox_index?>');
                    }
                    "
                    value="" style="width:208px"  tabindex="8"/>
                  </td>
                  <td>
                  	<input id="reqKartu<?=$checkbox_index?>" name="reqKartu[]" class="easyui-combobox" data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/kartu_tambah_combo_json.php',
                    onSelect:function(rec){
                    }
                    "
                    value="" style="width:208px" tabindex="9"/>
                  </td>
                  <td>
                  	<input id="reqBukuPusat<?=$checkbox_index?>" name="reqBukuPusat[]" class="easyui-combobox" data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/buku_pusat_combo_json.php',
                    onSelect:function(rec){
                    }
                    "
                    value="" style="width:208px" tabindex="10" />
                  </td>
                  <td>
                    <input type="text" name="reqKeterangan[]" class="easyui-validatebox" style="width:98%;" tabindex="11"/>
                  </td>
                  <td>
                    <input type="text" name="reqDebet[]" id="reqDebet<?=$checkbox_index?>" style="text-align:right;" OnFocus="FormatAngka('reqDebet<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqDebet<?=$checkbox_index?>'); hitungDebetTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqDebet<?=$checkbox_index?>')" tabindex="12"/>
                  </td>
                  <td>
                    <input type="text" name="reqKredit[]" id="reqKredit<?=$checkbox_index?>" style="text-align:right;" OnFocus="FormatAngka('reqKredit<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqKredit<?=$checkbox_index?>'); hitungKreditTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqKredit<?=$checkbox_index?>')" tabindex="13"/>
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
            	<td class=""><input type="text" id="reqJumlahDebet" name="reqJumlahDebet" style="text-align:right;" readonly value="<?=numberToIna($temp_jml_debet)?>" /></td>
            	<td class=""><input type="text" id="reqJumlahKredit" name="reqJumlahKredit" style="text-align:right;" readonly value="<?=numberToIna($temp_jml_kredit)?>" /></td>
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
<?
if($reqMode == "update")
{
?>
tabindex = <?=$last_tab?>;
<?
}
?>

$('input[id^="reqKredit"]').keydown(function(e) {
	if(e.which==13)
	{
		if(FormatAngkaNumber($(this).val()) == "0")
		{}
		else
			addRow();
	}
});
$('input[id^="reqDebet"]').keydown(function(e) {
  if(e.which==13)
  {
	  if(FormatAngkaNumber($(this).val()) == "0")
	  {}
	  else
	  {
		  addRow();
		  var idReqKredit = $(this).attr('id').replace("reqDebet", "reqKredit");
		  $("#"+idReqKredit).removeAttr("tabindex");
	  }
  }
});
</script>
</body>
</html>