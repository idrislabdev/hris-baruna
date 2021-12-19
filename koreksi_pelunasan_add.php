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
	$tempTanggalValuta = date("d-m-Y");
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
	$tempKdSubSis = $kptt_nota->getField("KD_SUBSIS");
	$reqNoRef2 = $kptt_nota->getField("NO_REF2");
	$reqNoRef3 = $kptt_nota->getField("NO_REF1");
	$reqMode = "update";
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
    <script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="js/xlsx.core.min.js"></script>
    <script src="js/xls.core.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>    
    <script type="text/javascript" src="../WEB-INF/lib/easyui/global-tab-easyui.js"></script>
    <script type="text/javascript" src="js/entri_pelunasan_kas_bank.js"></script>
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
				url:'../json-keuangansiuk/koreksi_pelunasan_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data); return;
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'koreksi_pelunasan_add.php?reqId='+data[0];
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
			$("#reqNoBukuBesarKas").keydown(function(event) { 
				if(event.keyCode == 120)
				{
					OpenDHTMLPopup('bank_pencarian.php?reqKdValuta='+$("#reqValutaNama").val(), 'Pencarian Bank', 950, 600);
					
					return false;
				}			
				else if(event.keyCode == 13){
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
						  document.location.href = 'proses_pelunasan_kas_bank_add.php?reqId=<?=$reqId?>';
						  top.frames['mainFrame'].location.reload();
					});	
				}
			});
			
			$('#reqTanggalTransaksi').datebox({
				onSelect: function(date){
					var y = date.getFullYear();
					var m = date.getMonth() + 1;
					var d = date.getDate();
					var dat = (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
					$('#reqTanggalValuta').datebox('setValue', dat);
					var datMonth = (m < 10 ? '0' + m : m);
					var datYear  = y;
					$('#reqBulan').val(datMonth);
					$('#reqTahun').val(datYear);					
				}
			});	
						
						  
		});	
					
		
		function OptionSet(id, nama,alamat, npwp, badan_usaha){
			document.getElementById('reqNoPelanggan').value = id;
			document.getElementById('reqPelanggan').value = nama;
			document.getElementById('reqBadanUsaha').value = badan_usaha;
			//getDataPPKB();
			$("#reqNoPelanggan").focus();
		}	
		function OptionSetBank(bb, kode, nama){
			document.getElementById('reqNoBukuBesarKas').value = kode;
			document.getElementById('reqBank').value = nama;
			document.getElementById('reqKodeKasBank').value = bb;
			$("#reqNoBukuBesarKas").focus();
		}	

		function OptionSetPembayaran(anSelectedId, anSelectedKdBank, anSelectedBbBank, anSelectedNama)
		{
			 
			document.getElementById('reqNoRef2').value = anSelectedId;
			document.getElementById('reqNoRef3').value = anSelectedId;
			document.getElementById('reqKodeKasBank').value = anSelectedBbBank; 
			document.getElementById('reqNoBukuBesarKas').value = anSelectedKdBank;
			document.getElementById('reqKeterangan').value = "KOREKSI " + anSelectedNama;
			$("#alternatecolor").html("");
			$.get("koreksi_pelunasan_add_template.php?reqId="+anSelectedId, function (data) {
				$("#alternatecolor").append(data);
				hitungJumlahTotal();
			});			
			
		}
		
		function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2) - 100;
			
			//opWidth = iecompattest().clientWidth - 200;
			//opHeight = iecompattest().clientHeight - 40;
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
		}	
		
		$(function(){
			  			  
				$('#reqPelanggan').combobox('textbox').bind('mousedown',function(e){
					tabindex=1;
				});
				
				$('#reqBank').combobox('textbox').bind('mousedown',function(e){
					tabindex=4;
				}); 
				
				$('#reqTanggalTransaksi').datebox('textbox').bind('mousedown',function(e){
					tabindex=2;
				}); 
				
		});


		function openPopup()
		{
		
			var isCtrl = false;
			$('#reqNoRef3').keyup(function (e) {
				if(e.which == 120)
				{
					OpenDHTMLPopup('koreksi_pelunasan_pencarian.php', 'Pencarian Kelas', 950, 600);
					return false;
				}
			});
		
		}
		
				
		//OpenDHTMLPopup('proses_pelunasan_kas_bank_pencarian.php?reqIndex='+rowCount+'&reqId='+$("#reqNoPelanggan").val()+'&reqKdValuta='+$("#reqValutaNama").val(), 'Pencarian Pelanggan', 950, 600);
				
	</script>
    
    
</head>
     
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Koreksi Pelunasan SPP (SUDAH POSTING)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
    	<thead>
        <tr>           
             <td>No Bukti</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" style="width:170px; background-color:#f0f0f0" type="text" readonly value="<?=$tempNoBukti?>" />
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalValuta?>" />
                &nbsp;
                <div style="display:none">
                Thn / Bln Buku
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:50px; background-color:#f0f0f0" readonly value="<?=$tempTahun?>" />
                &nbsp;/&nbsp;
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px; background-color:#f0f0f0" readonly value="<?=$tempBulan?>" />
				</div>
			</td>
        </tr>
        <tr>           
             <td>No Ref JKM</td>
			 <td>
                <input type="hidden" name="reqNoRef2" id="reqNoRef2" class="easyui-validatebox" style="width:150px" type="text" value="<?=$reqNoRef2?>" tabindex="3"  />
                <input name="reqNoRef3" readonly id="reqNoRef3" class="easyui-validatebox" style="width:98%;" type="text"  value="<?=$reqNoRef3?>" onKeyDown="openPopup();"  />   <!--onKeyDown="openPopup();"-->
                <input name="reqBadanUsaha" id="reqBadanUsaha" class="easyui-validatebox" style="width:295px" type="hidden" value="SISWA" readonly />
			</td>
            <td>Rek. Kas / Bank</td>
			 <td>
				<input name="reqNoBukuBesarKas" id="reqNoBukuBesarKas" class="easyui-validatebox" style="width:40px; background-color:#f0f0f0" readonly type="text" value="<?=$tempNoBukuBesarKas?>"/>
                <input name="reqKodeKasBank" id="reqKodeKasBank" class="easyui-validatebox" readonly style="width:110px; background-color:#f0f0f0" type="text" value="<?=$tempKodeKasBank?>" readonly />
                             
			</td>
        </tr>
        <tr>
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" tabindex="2" onMouseDown="tabindex=2" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
            <td>Keterangan Tambahan</td>
            <td>
				<input id="reqKeterangan" name="reqKeterangan" class="easyui-validatebox" style="width:370px" type="text" value="<?=$tempKeterangan?>" tabindex="5" onMouseDown="tabindex=5" />
            </td>
        </tr>
        <tr>
            <td>Kode Valuta</td>
			<td>
                <select name="reqValutaNama" id="reqValutaNama" tabindex="3" onFocus="tabindex=3">
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
            	<input id="reqTanggalPosting" name="reqTanggalPosting" style="width:140px; background-color:#f0f0f0" <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> value="<?=$tempTanggalPosting?>" readonly/>
                &nbsp;
                Jml Trans
                <input id="reqJumlahTransaksi" name="reqJumlahTransaksi" class="easyui-validatebox" style="width:140px; background-color:#f0f0f0" OnFocus="FormatAngka('reqJumlahTransaksi')" OnKeyUp="FormatUang('reqJumlahTransaksi')" OnBlur="FormatUang('reqJumlahTransaksi')" readonly value="<?=numberToIna($tempJumlahTransaksi)?>"  />             
            </td>
        </tr>
        <tr>
            <td>Kurs&nbsp;Valuta</td>
			<td>
            	<input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px; background-color:#f0f0f0" type="text" value="<?=$tempKursValuta?>" readonly />
            </td>
            <td>No&nbsp;Posting</td>
			 <td>
                <input name="reqNoPosting" class="easyui-validatebox" style="width:140px; background-color:#f0f0f0" type="text" value="<?=$tempNoPosting?>" readonly />
			</td>
        </tr>
        <tr>
        	<td colspan="4">
            <div>
                <input type="hidden" name="reqDepartemenId" value="0">
                <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <input type="submit" value="Submit">
                <input type="reset" id="rst_form">
                <?
                if($reqMode == "update")
				{
				?>
                <input type="button" value="Rincian Jurnal" onClick="OpenDHTMLPopup('jurnal_lihat.php?reqId=<?=$reqId?>', 'Rincian Jurnal', 900, 600)">
                <input type="button" name="btnPosting" id="btnPosting" value="Posting">
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
              <th style="width:10%">
                No
              </th>
              <th>No. Kartu</th>
              <th>Siswa</th>
              <th>Tanggal Nota</th>
              <th>Sisa Piutang</th>
              <th>Jumlah Bayar</th>
              <th>Koreksi Siswa</th>
              <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
          <?
          $i = 1;
          $checkbox_index = 0;
          
          $kptt_nota_d->selectByParamsKoreksiPelunasanJRR(array("A.NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY LINE_SEQ ASC ");
          while($kptt_nota_d->nextRow())
          {
          ?>
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$kptt_nota_d->getField("NO_REF1")?>"  style="width:98%" readonly />
                  </td>
                  <td>
                  <input type="text" name="reqNoPpkb[]" id="reqNoPpkb<?=$checkbox_index?>" class="easyui-validatebox" value="<?=$kptt_nota_d->getField("KD_SUB_BANTU")?>" style="width:98%" readonly />
                  </td>
                  <td>
                    <input type="text" name="reqPelanggan[]" id="reqPelanggan<?=$checkbox_index?>" class="easyui-validatebox" value="<?=$kptt_nota_d->getField("MPLG_NAMA")?>" readonly  style="width:98%" />
                  </td>
                  <td>
                    <input type="text" name="reqTanggalNota[]" id="reqTanggalNota<?=$checkbox_index?>" class="easyui-validatebox" value="<?=dateToPage($kptt_nota_d->getField("TGL_TRANS"))?>" readonly />
                  </td>
                  <td>
                    <input type="text" name="reqSisaPiutang[]"  style="text-align:right;"  id="reqSisaPiutang<?=$checkbox_index?>" readonly  OnFocus="FormatAngka('reqSisaPiutang<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisaPiutang<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisaPiutang<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("TAGIHAN"))?>">
                  </td>
                  <td>
                    <input type="text" name="reqJumlahBayar[]"  style="text-align:right;"  id="reqJumlahBayar<?=$checkbox_index?>" readonly  OnFocus="FormatAngka('reqJumlahBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahBayar<?=$checkbox_index?>'); hitungJumlahTotal(); hitungSisaBayar('<?=$checkbox_index?>');" OnBlur="FormatUang('reqJumlahBayar<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("JML_VAL_TRANS"))?>">
                  </td>
                  <td>
                    <select name="reqKdPengganti[]">
                    <?
                    $kptt_nota_d_siswa = new KpttNotaD();
                    $kptt_nota_d_siswa->selectByParamsDaftarSiswa(array("NO_NOTA" => $kptt_nota_d->getField("NO_REF1")), -1, -1, " AND NOT NVL(A.NO_REF_PELUNASAN, 'X') = '".$kptt_nota_d->getField("NO_REF3")."' ");
                    while($kptt_nota_d_siswa->nextRow())
                    {
                    ?>
                        <option value="<?=$kptt_nota_d_siswa->getField("KD_SUB_BANTU")?>" <? if($kptt_nota_d_siswa->getField("KD_SUB_BANTU") == $kptt_nota_d->getField("NO_REF2")) { ?> selected <? } ?>><?=$kptt_nota_d_siswa->getField("NM_SUB_BANTU")?></option>
                    <?
                    }
                    ?>
                    </select>
                    <input type="hidden" name="reqSisaBayar[]"  style="text-align:right;"  id="reqSisaBayar<?=$checkbox_index?>"  readonly OnFocus="FormatAngka('reqSisaBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisaBayar<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisaBayar<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("SISA"))?>">
                  </td>
                  <td align="center">
                  <label>
                  <input type="hidden" name="reqBukuBesar[]" id="reqBukuBesar<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("KD_BUKU_BESAR")?>">
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
            	<td colspan="5">&nbsp;</td>
            	<td class=""><input type="text" id="reqTotalBayar" name="reqTotalBayar" style="text-align:right;" readonly value="<?=numberToIna($temp_jml_debet)?>" /></td>
            	<td></td>
                <td class=""><input type="hidden" id="reqTotalUangTitipan" name="reqTotalUangTitipan" style="text-align:right;" readonly value="" /></td>
                <td></td>
            </tr>
        </tfoot>
    </table>      
    <div>
    	<p style="text-align: right; padding-right: 15px; color:red;" ><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /> untuk menghapus data yang <strong>TIDAK</strong> dikoreksi</p>
    </div>  
    </form>
</div>
</body>
</html>