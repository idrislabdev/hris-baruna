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
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajak.php");

$kptt_nota = new KpttNota();
$safr_valuta = new SafrValuta();
$kptt_nota_d = new KpttNotaD();
$kbbr_tipe_trans_d = new KbbrTipeTransD();
$kbbr_general_ref_d = new KbbrGeneralRefD();
$kbbr_rule_modul = new KbbrRuleModul();
$no_faktur_pajak = new NoFakturPajak();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");

if($reqId == "")
{
	$reqMode = "insert";	
	$tempKursValuta = 1;
	$tempKursPajak = 1;
	$tempTahun = date("Y");
	$tempBulan = "";
	$tempPersenPajak = $kbbr_general_ref_d->getSetting(array("ID_REF_FILE" => "JKK_NOTA", "ID_REF_DATA" => "POT1"));
	$tempTanggalValutaPajak = date("d-m-Y");
	$tempTanggalValuta = date("d-m-Y");
	$tempTanggalTransaksi = date("d-m-Y");
	$tempMaterai = 0;
	$tempFakturPajak = $no_faktur_pajak->getLastFakturPajak($tempTanggalTransaksi);
}
else
{
	$reqMode = "update";	
	$kptt_nota->selectByParams(array("A.NO_NOTA"=>$reqId), -1, -1);
	$kptt_nota->firstRow();
	
	$tempNoBukti = $kptt_nota->getField("NO_NOTA");
	$tempNoNota = $kptt_nota->getField("NO_REF3");
	$tempNoBuktiLain = $kptt_nota->getField("NO_REF1");
	$tempNoBukuBesarKas = $kptt_nota->getField("KD_BANK");
	$tempBukuBesarKas = $kptt_nota->getField("BANK");
	$tempBukuBesarKasBB = $kptt_nota->getField("KD_BB_BANK");
	$tempNoPelanggan = $kptt_nota->getField("KD_KUSTO");
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
	$tempPelanggan = $kptt_nota->getField("MPLG_NAMA");
	$tempAlamat = $kptt_nota->getField("MPLG_ALAMAT");
	$tempNPWP = $kptt_nota->getField("MPLG_NPWP");
	$tempPersenPajak = $kptt_nota->getField("PPN1_PERSEN");
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota->getField("TGL_TRANS"));
	$tempTahun = $kptt_nota->getField("THN_BUKU");
	$tempBulan = $kptt_nota->getField("BLN_BUKU");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempTanggalValuta = dateToPageCheck($kptt_nota->getField("TGL_VALUTA"));
	$tempTanggalValutaPajak = dateToPageCheck($kptt_nota->getField("TGL_VAL_PAJAK"));
	$tempMaterai = $kptt_nota->getField("METERAI");
	$tempBadanUsaha = $kptt_nota->getField("BADAN_USAHA");
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempKursPajak = numberToIna($kptt_nota->getField("KURS_VAL_PAJAK"));
	$tempJumlahDiBayar = $kptt_nota->getField("JUMLAH");
	$tempFakturPajak = $kptt_nota->getField("FAKTUR_PAJAK");
	$tempFakturPajakPrefix = $kptt_nota->getField("FAKTUR_PAJAK_PREFIX");
	$tempTanggalFakturPajak = dateToPageCheck($kptt_nota->getField("TGL_FAKTUR_PAJAK"));
	
}

$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));

$kbbr_tipe_trans_d->selectByParams(array("TIPE_TRANS" => "JKM-KPT-03", "KD_AKTIF" => "A"));
while($kbbr_tipe_trans_d->nextRow())
{
	$arrTipeTrans["KLAS_TRANS"][] = $kbbr_tipe_trans_d->getField("KLAS_TRANS");
	$arrTipeTrans["KETK_TRANS"][] = $kbbr_tipe_trans_d->getField("KETK_TRANS");		
}

$ppn_materai = "N";//$kbbr_rule_modul->getStatus(array("KD_RULE" => "PPNMETERAI"));
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
    <script type="text/javascript" src="../WEB-INF/lib/easyui/upperfunction.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/global-tab-easyui.js"></script>
    <script type="text/javascript" src="js/entri_tabel_nota.js"></script>
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
				url:'../json-keuangansiuk/penjualan_tunai_add.php',
				onSubmit:function(){
					$('#reqFakturPajak').combobox('setValue', $('#reqFakturPajak').combobox('getText'));
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'penjualan_tunai_add.php?reqId='+data[0];
					top.frames['mainFrame'].location.reload();
				}
			});
			
		});
		
		$(function(){

				
			
			  $("#reqValutaNama").change(function() { 
			
				   if($("#reqValutaNama").val() == "IDR")
				   {
						$("#reqKursValuta").val('1');
						$("#reqKursPajak").val('1');	
						$('#reqBukuBesarKas').combobox('reload', '../json-keuangansiuk/bank_combo_json.php?reqKdValuta=IDR');					
				   }
				   else
				   {
					  $('#reqBukuBesarKas').combobox('reload', '../json-keuangansiuk/bank_combo_json.php?reqKdValuta=USD');										   
					  $.getJSON("../json-keuangansiuk/get_valuta_kurs_json.php?reqValutaKursId="+$("#reqValutaNama").val()+ "&reqTanggalTransaksi="+$('#reqTanggalTransaksi').datebox('getValue'),
					  function(data){
							if(data.NILAI_RATE == "")
							{
								if(confirm("Kurs Valuta belum dientri, tambahkan kurs?"))
								{
									OpenDHTMLPopup('kurs_add_popup.php', 'Tambah Kurs', 950, 600);									
								}	
							}
							else
							{
								$("#reqKursValuta").val(data.NILAI_RATE);
								$("#reqTanggalValuta").val(data.TGL_MULAI_RATE);
								  $.getJSON("../json-keuangansiuk/get_valuta_kurs_pajak_json.php?reqValutaKursId="+$("#reqValutaNama").val()+ "&reqTanggalTransaksi="+$('#reqTanggalTransaksi').datebox('getValue'),
								  function(data){
										if(data.NILAI_RATE == "")
										{
											if(confirm("Kurs pajak belum dientri, tambahkan kurs?"))
											{
												OpenDHTMLPopup('kurs_pajak_add_popup.php', 'Tambah Kurs Pajak', 950, 600);
											}	
										}				
										else	
										{				  
											$("#reqKursPajak").val(data.NILAI_RATE);
											$("#reqTanggalValutaPajak").val(data.TGL_MULAI_RATE);
										}
								  });									
							}
					  });
				  
				   }
				   
			  });	

			 
			$('#reqTanggalTransaksi').datebox({
				onSelect: function(date){
					var y = date.getFullYear();
					var m = date.getMonth() + 1;
					var d = date.getDate();
					var dat = (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
					$('#reqFakturPajak').combobox('reload','../json-keuangansiuk/faktur_pajak_aktif_combo_json.php?reqTanggal='+dat); 
					$('#reqTanggalValuta').val(dat);
					$('#reqTanggalValutaPajak').val(dat);
					$('#reqTanggalFakturPajak').datebox('setValue', dat);
					<?
					if($reqMode == "insert")
					{
					?>
						$.getJSON('../json-keuangansiuk/faktur_pajak_aktif_json.php?reqTanggal='+dat,
						function(data){
							$('#reqFakturPajak').combobox('setValue', data.NOMOR);
						});						
					<?
					}
					?>
					
				}
			});			 
			   				  
		});	

		function checkPajak()
		{
			$.getJSON("../json-keuangansiuk/get_valuta_kurs_pajak_json.php?reqValutaKursId="+$("#reqValutaNama").val()+ "&reqTanggalTransaksi="+$('#reqTanggalTransaksi').datebox('getValue'),
			function(data){
				  if(data.NILAI_RATE == "")
				  {
					  if(confirm("Kurs pajak belum dientri, tambahkan kurs?"))
					  {
						  OpenDHTMLPopup('kurs_pajak_add_popup.php', 'Tambah Kurs Pajak', 950, 600);
					  }	
				  }				
				  else	
				  {				  
					  $("#reqKursPajak").val(data.NILAI_RATE);
					  $("#reqTanggalValutaPajak").val(data.TGL_MULAI_RATE);
				  }
			});				
		}
				
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
			document.getElementById('reqAlamat').value = alamat;
			document.getElementById('reqNPWP').value = npwp;
			document.getElementById('reqBadanUsaha').value = badan_usaha;
			$("#reqNoPelanggan").focus();
		}	
		
		function OptionSetBank(bb, kode, nama){
			document.getElementById('reqNoBukuBesarKas').value = kode;
			document.getElementById('reqBukuBesarKas').value = nama;
			document.getElementById('reqBukuBesarKasBB').value = bb;
			$("#reqNoBukuBesarKas").focus();
		}	
					
		function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2) - 100;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
		}		

		$(function(){
			  			  
				$('#reqPelanggan').combobox('textbox').bind('mousedown',function(e){
					tabindex=1;
				});

				$('#reqBukuBesarKas').combobox('textbox').bind('mousedown',function(e){
					tabindex=6;
				});

				$('#reqFakturPajak').combobox('textbox').bind('mousedown',function(e){
					tabindex=9;
				});

				$('#reqTanggalTransaksi').datebox('textbox').bind('mousedown',function(e){
					tabindex=3;
				});
				
				$('#reqTanggalFakturPajak').datebox('textbox').bind('mousedown',function(e){
					tabindex=10;
				});
		});
		
		function setComboBoxUpper(newValue, reqNmComboBox)
		{
			//var temp= $('#'+reqNmComboBox).combobox('getValue');
			var temp= forceupper($('#'+reqNmComboBox), "combobox");
			//temp= temp.toUpperCase();
			//$('#'+reqNmComboBox).combobox('setValue', temp)
		}
	</script>
    
    
</head>
     
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Penjualan Tunai (JKM)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>
    	<tr>
        	<td colspan="4" align="right">
            No Bukti JKM
            &nbsp;&nbsp;&nbsp;
            <input name="reqNoBukti" class="easyui-validatebox" style="width:170px; background-color:#f0f0f0" type="text" readonly value="<?=$tempNoBukti?>" />
            </td>
        </tr>
        <tr>           
             <td>No Nota</td>
			 <td>
				<input name="reqNoNota" id="reqNoNota" class="easyui-validatebox" type="text" readonly style="width:149px; background-color:#f0f0f0" value="<?=$tempNoNota?>" onKeyUp="document.getElementById('reqNoBuktiLain').value = document.getElementById('reqNoNota').value"/>
                &nbsp;&nbsp;
            	No Bukti Lain
				<input name="reqNoBuktiLain" id="reqNoBuktiLain" class="easyui-validatebox" type="text" style="width:152px; background-color:#f0f0f0" readonly value="<?=$tempNoBuktiLain?>"/>
			</td>
            <td>B. Besar Kas</td>
			 <td>
				<input name="reqNoBukuBesarKas" id="reqNoBukuBesarKas" class="easyui-validatebox" style="width:70px" type="hidden" value="<?=$tempNoBukuBesarKas?>"/>
				<input name="reqBukuBesarKas" id="reqBukuBesarKas" class="easyui-combobox" style="width:295px; text-transform:uppercase" type="text" value="<?=$tempBukuBesarKas?>"  data-options="
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/bank_combo_json.php?reqKdValuta=IDR',
                    onChange:function(newValue,oldValue)
        			{
                    	//setComboBoxUpper(newValue, 'reqBukuBesarKas');
                    },
                    onSelect:function(rec){ 
                    	$('#reqNoBukuBesarKas').val(rec.MBANK_KODE);
                    	$('#reqBukuBesarKasBB').val(rec.MBANK_KODE_BB);
                    }
                    "
                     tabindex="6" onMouseDown="tabindex=6" /> 				
                <input name="reqBukuBesarKasBB" id="reqBukuBesarKasBB" class="easyui-validatebox" style="width:320px; background-color:#f0f0f0" type="hidden" value="<?=$tempBukuBesarKasBB?>" readonly />
                
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="hidden" value="<?=$tempNoPelanggan?>" onKeyDown="openPopup('PELANGGAN');"/>                
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-combobox" style="width:295px;text-transform:uppercase" type="text" value="<?=$tempNoPelanggan?>"  data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/pelanggan_by_id_combo_json.php',
                    onChange:function(newValue,oldValue)
        			{
                    	//setComboBoxUpper(newValue, 'reqPelanggan');
                    },
                    onSelect:function(rec){ 
                    	$('#reqNoPelanggan').val(rec.MPLG_KODE);
                    	$('#reqAlamat').val(rec.MPLG_ALAMAT);
                    	$('#reqBadanUsaha').val(rec.MPLG_BADAN_USAHA);
                    	$('#reqNPWP').val(rec.MPLG_NPWP);
                    }
                    "
                     tabindex="1" onMouseDown="tabindex=1" /> 				
                <input name="reqBadanUsaha" id="reqBadanUsaha" type="text" style="width:90px; background-color:#f0f0f0" value="<?=$tempBadanUsaha?>" readonly>     
				<?php /*?><input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" style="width:345px; background-color:#f0f0f0" type="text" value="<?=$tempPelanggan?>" readonly /><?php */?>
			</td>
            <td rowspan="3" valign="top">Keterangan</td>
            <td rowspan="3">
            	<textarea name="reqKeterangan" id="reqKeterangan" rows="3" cols="48" tabindex="7" onMouseDown="tabindex=7"><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>           
             <td>Alamat</td>
			 <td>
             	<input name="reqAlamat" id="reqAlamat" class="easyui-validatebox" style="width:404px; background-color:#f0f0f0" type="text" value="<?=$tempAlamat?>" readonly />
                
			</td>
        </tr>
        <tr>           
             <td>NPWP</td>
			 <td>
				<input name="reqNPWP" id="reqNPWP" class="easyui-validatebox" style="width:308px; background-color:#f0f0f0" type="text" value="<?=$tempNPWP?>" readonly />
                &nbsp;&nbsp;
                %Pajak
                <input name="reqPersenPajak" id="reqPersenPajak" class="easyui-validatebox" maxlength="3" style="width:30px" type="text" value="<?=$tempPersenPajak?>" tabindex="2" onMouseDown="tabindex=2" OnKeyUp="FormatUang('reqPersenPajak')" />
			</td>
        </tr>
        <tr>
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" tabindex="3" onMouseDown="tabindex=3" />
                &nbsp;&nbsp;
                Tahun Buku
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:60px; background-color:#f0f0f0" readonly value="<?=$tempTahun?>" />
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:20px; background-color:#f0f0f0" readonly value="<?=$tempBulan?>" />
			</td>
			<td style="display:none">Faktur Pajak</td>
            <td style="display:none">
            	
                <input id="reqFakturPajakPrefix" name="reqFakturPajakPrefix" class="easyui-validatebox"  data-options="validType:'minLength[3]'" maxlength="3" style="width:30px" value="<?=$tempFakturPajakPrefix?>" tabindex="8" onMouseDown="tabindex=8" />.
            	<input id="reqFakturPajak" class="easyui-combobox" name="reqFakturPajak" data-options="filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },valueField:'id',textField:'text', url:'../json-keuangansiuk/faktur_pajak_aktif_combo_json.php?reqTanggal=<?=$tempTanggalTransaksi?>&reqFakturPajak=<?=$tempFakturPajak?>'" style="width:139px;" value="<?=$tempFakturPajak?>" tabindex="9" onMouseDown="tabindex=9"/>&nbsp;
                                   
                Tgl. Faktur <input id="reqTanggalFakturPajak" name="reqTanggalFakturPajak" class="easyui-datebox" data-options="validType:'date'"  value="<?=$tempTanggalFakturPajak?>" tabindex="10" onMouseDown="tabindex=10"/>              
            </td>
        </tr>
        <tr>
            <td>Valuta</td>
			<td>
            	<select name="reqValutaNama" id="reqValutaNama" tabindex="4" onFocus="tabindex=4">
                <?
                while($safr_valuta->nextRow())
				{
				?>
                	<option value="<?=$safr_valuta->getField("KODE_VALUTA")?>" <? if($safr_valuta->getField("KODE_VALUTA") == $tempValutaNama) { ?> selected <? } ?>><?=$safr_valuta->getField("KODE_VALUTA")?></option>
                <?
				}
				?>
                </select>      
                <div style="display:none">          
                &nbsp;&nbsp;
                Materai
               <select name="reqMateraiPilih" id="reqMateraiPilih" tabindex="5" onFocus="tabindex=5">
            	<option value="1">Ya</option>
                <option value="0" selected>Tidak</option>
           		</select>
                <input name="reqMaterai" id="reqMaterai" class="easyui-validatebox" style="width:74px; background-color:#f0f0f0" type="text" value="<?=$tempMaterai?>" readonly />
                </div>
			</td>
            <td>Jumlah Di bayar</td>
            <td>
            	<input id="reqJumlahDiBayar" name="reqJumlahDiBayar" class="easyui-validatebox" style="width:140px; background-color:#f0f0f0" OnFocus="FormatAngka('reqJumlahDiBayar')" OnKeyUp="FormatUang('reqJumlahDiBayar')" OnBlur="FormatUang('reqJumlahDiBayar')" value="<?=numberToIna($tempJumlahDiBayar)?>" readonly  />                
		    </td>
        </tr>
        <tr>
        	<td>Kurs&nbsp;Valuta / Pajak</td>
            <td colspan="3">
            	<input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:45px; background-color:#f0f0f0" type="text" value="<?=$tempKursValuta?>" readonly />
               	Tanggal
                <input id="reqTanggalValuta" name="reqTanggalValuta" style="width:80px; background-color:#f0f0f0" readonly value="<?=$tempTanggalValuta?>" />
                /
                <input name="reqKursPajak" id="reqKursPajak" class="easyui-validatebox" maxlength="3" style="width:45px; background-color:#f0f0f0" type="text" value="<?=$tempKursPajak?>" readonly />               
                Tanggal
                <input id="reqTanggalValutaPajak" name="reqTanggalValutaPajak" style="width:80px; background-color:#f0f0f0" readonly value="<?=$tempTanggalValutaPajak?>" /> 
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
              <th>Jenis Jasa</th>
              <th>Pajak?</th>
              <th>Jumlah</th>
              <th>Nilai Jasa</th>
              <th>Nilai Pajak</th>
              <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
			  <?
              $i = 1;
              $checkbox_index = 0;
         	  $last_tab = 10;              
              $kptt_nota_d->selectByParams(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY LINE_SEQ ASC ");
              while($kptt_nota_d->nextRow())
              {
              ?>
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" />
                  </td>
                  <td>
                  	<input id="reqKlasTrans<?=$checkbox_index?>" name="reqKlasTrans[]" class="easyui-combobox" style="width:300px" data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/jenis_jasa_combo_json.php',
                    onSelect:function(rec){
                    	ambilReferensiKlasTrans('<?=$checkbox_index?>');
                    }
                    "
                    validType="exists['#reqKlasTrans<?=$checkbox_index?>']"
                    value="<?=$kptt_nota_d->getField("KLAS_TRANS")?>" tabindex="<? $last_tab++; echo $last_tab ?>" />
                  </td>
                  <td>
                    <input type="text" name="reqPajak[]" id="reqPajak<?=$checkbox_index?>" readonly class="easyui-validatebox" value="<?=$kptt_nota_d->getField("STATUS_KENA_PAJAK")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqJumlah[]" style="text-align:right;" id="reqJumlah<?=$checkbox_index?>"   OnFocus="FormatAngka('reqJumlah<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlah<?=$checkbox_index?>'); hitungSemua('<?=$checkbox_index?>');" OnBlur="FormatUang('reqJumlah<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JUMLAH_TOTAL'))?>" tabindex="<? $last_tab++; echo $last_tab ?>">                         
                  </td>
                  <td>
                    <input type="text" name="reqNilaiJasa[]" style="text-align:right;" id="reqNilaiJasa<?=$checkbox_index?>" readonly OnFocus="FormatAngka('reqNilaiJasa<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiJasa<?=$checkbox_index?>'); " OnBlur="FormatUang('reqNilaiJasa<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JML_VAL_TRANS'))?>">
                  </td>
                  <td>
                    <input type="text" name="reqNilaiPajak[]" style="text-align:right;" id="reqNilaiPajak<?=$checkbox_index?>" readonly OnFocus="FormatAngka('reqNilaiPajak<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiPajak<?=$checkbox_index?>')" OnBlur="FormatUang('reqNilaiPajak<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JML_VAL_PAJAK'))?>">
                  </td>
                  <td align="center">
                  <label>
                  <input type="hidden" name="reqKdBukuBesar[]" id="reqKdBukuBesar<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("KD_BUKU_BESAR")?>"><input type="hidden" name="reqDK[]" id="reqDK<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("KD_D_K")?>">
                  <a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
                  </label>
                  </td>
              </tr>
			  <?
                $i++;
                $checkbox_index++;
                $temp_jml_trans += $kptt_nota_d->getField('JML_VAL_TRANS');
                $temp_jml_pajak += $kptt_nota_d->getField('JML_VAL_PAJAK');
              }
              ?>
              <?
			  if($checkbox_index == 0)
			  {
              ?>
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" />
                  </td>
                  <td>
                  	<input id="reqKlasTrans<?=$checkbox_index?>" name="reqKlasTrans[]" class="easyui-combobox" style="width:300px" data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/jenis_jasa_combo_json.php',
                    onSelect:function(rec){
                    	ambilReferensiKlasTrans('<?=$checkbox_index?>');
                    }
                    "
                    validType="exists['#reqKlasTrans<?=$checkbox_index?>']"
                    value="" tabindex="11" onMouseDown="tabindex=11"/>
                  </td>
                  <td>
                    <input type="text" name="reqPajak[]" id="reqPajak<?=$checkbox_index?>" readonly class="easyui-validatebox" />
                  </td>
                  <td>
                    <input type="text" name="reqJumlah[]" style="text-align:right;" id="reqJumlah<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlah<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlah<?=$checkbox_index?>'); hitungSemua('<?=$checkbox_index?>');" OnBlur="FormatUang('reqJumlah<?=$checkbox_index?>')" tabindex="12" onMouseDown="tabindex=12"/>
                  </td>
                  <td>
                    <input type="text" name="reqNilaiJasa[]" style="text-align:right;" id="reqNilaiJasa<?=$checkbox_index?>" readonly OnFocus="FormatAngka('reqNilaiJasa<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiJasa<?=$checkbox_index?>'); " OnBlur="FormatUang('reqNilaiJasa<?=$checkbox_index?>')"/>
                  </td>
                  <td>
                    <input type="text" name="reqNilaiPajak[]" style="text-align:right;" id="reqNilaiPajak<?=$checkbox_index?>" readonly OnFocus="FormatAngka('reqNilaiPajak<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiPajak<?=$checkbox_index?>')" OnBlur="FormatUang('reqNilaiPajak<?=$checkbox_index?>')"/>
                  </td>
                  <td align="center">
                  <label>
                  <input type="hidden" name="reqKdBukuBesar[]" id="reqKdBukuBesar<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("KD_BUKU_BESAR")?>"><input type="hidden" name="reqDK[]" id="reqDK<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("KD_D_K")?>">
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
            	<td colspan="4">&nbsp;</td>
            	<td><input type="text" id="reqJumlahTrans" name="reqJumlahTrans" style="text-align:right; background-color:#f0f0f0" readonly value="<?=numberToIna($temp_jml_trans)?>" /></td>
            	<td class=""><input type="text" id="reqJumlahPajak" name="reqJumlahPajak" style="text-align:right; background-color:#f0f0f0" readonly value="<?=numberToIna($temp_jml_pajak)?>" /></td>
            	<td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>
    <div>
        <input type="hidden" name="reqId" value="<?=$reqId?>">
        <input type="hidden" name="reqMode" value="<?=$reqMode?>">
        <input type="hidden" name="reqPpnMaterai" id="reqPpnMaterai" value="<?=$ppn_materai?>">
        <input type="submit" value="Submit">
        <input type="reset" id="rst_form">
        <?
        if($reqMode == "update")
        {
        ?>
        <input type="button" value="Rincian Jurnal" onClick="OpenDHTMLPopup('penjualan_tunai_add_jurnal.php?reqId=<?=$reqId?>', 'Rincian Jurnal', 900, 600)">
        <input type="button" value="Screen" id="btnScreen">
        <input type="button" value="Print" id="btnPrint">
        <?
        }
        ?>
        <input type="button" name="btnClose" id="btnClose" value="Close" onClick="window.parent.divwin.close();">
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

$('input[id^="reqJumlah"]').keydown(function(e) {
	if(e.which==13)
	{
		addRow();
	}
});

$("#reqKeterangan, #reqFakturPajakPrefix").keyup(function(e) {
	forceupper(this)
	//var temp= this.value.toUpperCase();
	//$(this).val(temp);
});

</script>
</body>
</html>