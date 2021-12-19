<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbDTmp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
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
	$tempBiayaKomersil = $kbbt_jur_bb_tmp->getField("FLAG_SETOR_PAJAK");
	$tempKusto = $kbbt_jur_bb_tmp->getField("KD_KUSTO");
		
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

    <!-- AUTO KOMPLIT -->
	<link rel="stylesheet" href="../WEB-INF/lib/autokomplit/jquery-ui.css">
	<script src="../WEB-INF/lib/autokomplit/jquery-1.7.1.min.js"></script>     
	<script src="../WEB-INF/lib/autokomplit/jquery-ui.js"></script>  

    
	<style>
		.ui-autocomplete {
			max-height: 200px;
			overflow-y: auto;
			/* prevent horizontal scrollbar */
			font-size:11px;
			overflow-x: hidden;
		}
		/* IE 6 doesn't support max-height
		 * we use height instead, but this forces the menu to always be this tall
		 */
		* html .ui-autocomplete {
			height: 200px;
		}
	</style>      
    <!-- AUTO KOMPLIT -->

    <script type="text/javascript">
		$(function() {
				$( "#reqPerusahaan" ).autocomplete({ source:'../json-keuangansiuk/pelanggan_combo_v2_json.php', 
					select: function (event, ui) {  
						$('#reqKusto').val(ui.item.MPLG_KODE);
                    	$('#reqAlamat').val(ui.item.MPLG_ALAMAT);
						},
						change:  function (event, ui) {  
						if(ui.item == null)
						{
							$('#reqKusto').val('');
							$('#reqAlamat').val('');																	
						}	
					}, 
					autoFocus: true
				}).autocomplete( "instance" )._renderItem = function( ul, item ) {
					return $( "<li>" )
				  .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
				  .appendTo( ul );
				};
		
		});	
		
			
	</script>

    <script type="text/javascript" src="../WEB-INF/lib/easyui/easyloader.js"></script>   
    <script type="text/javascript" src="../WEB-INF/lib/easyui/plugins/jquery.form.js"></script>  
    <script type="text/javascript" src="../WEB-INF/lib/easyui/plugins/jquery.linkbutton.js"></script> 
    <script type="text/javascript" src="../WEB-INF/lib/easyui/plugins/jquery.draggable.js"></script> 
    <script type="text/javascript" src="../WEB-INF/lib/easyui/plugins/jquery.resizable.js"></script> 
    <script type="text/javascript" src="../WEB-INF/lib/easyui/plugins/jquery.panel.js"></script> 
    <script type="text/javascript" src="../WEB-INF/lib/easyui/plugins/jquery.window.js"></script> 
    <script type="text/javascript" src="../WEB-INF/lib/easyui/plugins/jquery.progressbar.js"></script> 
    <script type="text/javascript" src="../WEB-INF/lib/easyui/plugins/jquery.messager.js"></script>      
    <script type="text/javascript" src="../WEB-INF/lib/easyui/plugins/jquery.tooltip.js"></script>  
    <script type="text/javascript" src="../WEB-INF/lib/easyui/plugins/jquery.validatebox.js"></script>  
    <script type="text/javascript" src="../WEB-INF/lib/easyui/plugins/jquery.combo.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/plugins/jquery.calendar.js"></script>   
    <script type="text/javascript" src="js/globalfunction.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/upperfunction.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/global-tab-easyui_v2.js"></script>
    <script type="text/javascript" src="js/entri_tabel_jurnal_faktur_v2.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>      

	<script type="text/javascript">
	    function myformatter(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;
        }
        function myparser(s){
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[2],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(d,m-1,y);
            } else {
                return new Date();
            }
        }
        
		function setValue(){
			// {'setValue', '<?=$tempTanggalTransaksi?>'},
			$('#reqTanggalTransaksi').datebox({
				onSelect: function(date){
					var y = date.getFullYear();
					var m = date.getMonth() + 1;
					var d = date.getDate();
					var dat = (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
					//alert(y + ', ' + m);
				    $('#reqBulan').val((m < 10 ? '0' + m : m));
				    $('#reqTahun').val(y);
				}
			});	
			$('#reqBuktiPendukung').focus();	
		}		

		/* KBBT_JUR_BB */
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/jurnal_rupa_rupa_add.php',
				onSubmit:function(){
					$(this).find(':input').removeAttr('disabled');
					if($("#reqUnbalance").is(':checked'))
					{
						$.messager.alert('Info', "Jurnal tidak balance.", 'info');	
						return false;					
					}
					else
						return $(this).form('validate');
				},
				success:function(data){
					//alert(data);
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'jurnal_rupa_rupa_add.php?reqId='+data[0];
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
						if(data.NILAI_RATE == "")
						{
							if(confirm("Kurs Valuta belum dientri, tambahkan kurs?"))
							{
								OpenDHTMLPopup('kurs_add_popup.php', 'Tambah Kurs', 950, 600);									
							}	
						}
						else 
							$("#reqKursValuta").val(data.NILAI_RATE);
				  });
			   }
			});	
				
			

		});	
			
		function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2) - 100;
			
			//opWidth = iecompattest().clientWidth - 200;
			//opHeight = iecompattest().clientHeight - 40;
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
		}	
			
		function cetak()
		{	
			/*newWindow = window.open('jurnal_rupa_rupa_rpt.php?reqId=<?=$reqId?>', 'Cetak');
			newWindow.focus();	*/		
			OpenDHTMLPopup('jurnal_rupa_rupa_penanda_tangan.php?reqNoBukti=<?=$reqId?>', 'Office Management - Aplikasi Penghasilan', '600', '300');
			
		}						
			
	</script>
    
    
</head>
     
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Jurnal Rupa - Rupa</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>
        <tr>           
             <td>No&nbsp;Bukti&nbsp;(SIUK)</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" style="width:170px; background-color:#f0f0f0" type="text" readonly value="<?=$tempNoBukti?>" />
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
				<input name="reqBuktiPendukung" id="reqBuktiPendukung" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempBuktiPendukung?>" tabindex="1" onMouseDown="tabindex=1"/>
			</td>
            <td>Kurs&nbsp;Valuta</td>
			 <td>
				<input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px; background-color:#f0f0f0" type="text" value="<?=$tempKursValuta?>" readonly />
			</td>
        </tr>
        <tr>           
             <td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser,validType:'date'" value="<?=$tempTanggalTransaksi?>" tabindex="2" onMouseDown="tabindex=2"/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
            <td>Bulan&nbsp;Buku</td>
			 <td>
                <input  type="text" id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:100px; background-color:#f0f0f0" value="<?=$tempTahun?>" readonly/>
                <input  type="text" id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px; background-color:#f0f0f0" value="<?=$tempBulan?>" readonly/>
			</td>
        </tr>
        <tr>           
             <td>Agen&nbsp;/&nbsp;Perusahaan</td>
			 <td>
                <input type="hidden" name="reqKusto" id="reqKusto" value="<?=$tempKusto?>">
                <input type="hidden" name="reqPerusahaanTemp" id="reqPerusahaanTemp" value="<?=$tempPerusahaan?>">
                <input type="text" id="reqPerusahaan" name="reqPerusahaan" style="width:400px;" tabindex="3" onMouseDown="tabindex=3" value="<?=$tempPerusahaan?>"  />   
                                       
			</td>
            <td>No / Tanggal Posting</td>
			 <td>
				<input name="reqNoPosting" class="easyui-validatebox" style="width:100px; background-color:#f0f0f0" type="text" value="<?=$tempNoPosting?>" readonly />
                <input id="reqTanggalPosting" name="reqTanggalPosting" style="background-color:#f0f0f0" readonly <?php /*?>class="easyui-datebox" data-options="validType:'date'"<?php */?> value="<?=$tempTanggalPosting?>" />
			</td>
        </tr>
        <tr>           
             <td valign="top">Alamat</td>
			 <td>
  	  	        <textarea name="reqAlamat" id="reqAlamat" style="width:400px; height:80px"  tabindex="4" onMouseDown="tabindex=4"><?=$tempAlamat?></textarea>
			</td>
            <td valign="top">Keterangan</td>
			 <td>
				<textarea name="reqKeteranganJurnal" id="reqKeteranganJurnal" style="width:400px; height:80px;" tabindex="6" onMouseDown="tabindex=6"><?=$tempKeteranganJurnal?></textarea>
   			</td>
        </tr>
        </thead>
    </table>
 
    <table class="example" id="dataTableRowDinamis">
    <!--<table class="example altrowstable" id="alternatecolor" >-->
        <thead class="altrowstable">
          <tr>
              <th style="width:35px;">No<a style="cursor:pointer" title="Tambah" onclick="addRow()"><img src="../WEB-INF/images/tree-add.png" width="16" height="16" border="0" /></a></th>
              <th style="width:165px;">Buku&nbsp;Besar</th>
              <th style="width:165px;">Kartu</th>
              <th style="width:165px;">Buku&nbsp;Pusat</th>
              <th>Keterangan</th>
              <th>Debet</th>
              <th>Kredit</th>
              <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
          <?
          $i = 1;
          $checkbox_index = 0;
          $last_tab = 6;
          
          $kbbt_jur_bb_d_tmp->selectByParams(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY NO_SEQ ASC ");
          while($kbbt_jur_bb_d_tmp->nextRow())
          {
          ?>
          	<script type="text/javascript">
			$(function() {
				$( "#reqBukuBesar<?=$checkbox_index?>" ).autocomplete({ source:'../json-keuangansiuk/buku_besar_combo_v2_json.php', 
															//select: function (event, ui) { disableByPolaEntry(ui.item.POLA_ENTRY_ID, '<?=$checkbox_index?>'); }, 
															minLength:1,
															autoFocus: true
														}).autocomplete( "instance" )._renderItem = function( ul, item ) {
															return $( "<li>" )
														  .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
														  .appendTo( ul );
				};
														
				$( "#reqKartu<?=$checkbox_index?>" ).autocomplete({ source:'../json-keuangansiuk/kartu_tambah_combo_v2_json.php' , 
													   autoFocus: true
														}).autocomplete( "instance" )._renderItem = function( ul, item ) {
															return $( "<li>" )
														  .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
														  .appendTo( ul );
				};							
							  
				$( "#reqBukuPusat<?=$checkbox_index?>" ).autocomplete({ source:'../json-keuangansiuk/buku_pusat_combo_v2_json.php', 
														   autoFocus: true 
														}).autocomplete( "instance" )._renderItem = function( ul, item ) {
															return $( "<li>" )
														  .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
														  .appendTo( ul );		
				};													  			

			});
			</script>          
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" style="width:35px" />
                  </td>
                  <td>
                    <input type="text" id="reqBukuBesar<?=$checkbox_index?>" name="reqBukuBesar[]" value="<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_BESAR")?>" style="width:165px;" tabindex="<? $last_tab++; echo $last_tab ?>" onMouseDown="tabindex=<?=$last_tab?>"  />                   
                  </td>
                  <td>
                    <input type="text" id="reqKartu<?=$checkbox_index?>" name="reqKartu[]" value="<?=$kbbt_jur_bb_d_tmp->getField("KD_SUB_BANTU")?>" style="width:165px;" <? if($kbbt_jur_bb_d_tmp->getField("DISABLE_KARTU") == "DISABLED") {} else { ?> tabindex="<? $last_tab++; echo $last_tab ?>"  onMouseDown="tabindex=<?=$last_tab?>" <? } ?> <?=$kbbt_jur_bb_d_tmp->getField("DISABLE_KARTU")?>  />                   	
                  </td>
                  <td>
                    <input type="text" id="reqBukuPusat<?=$checkbox_index?>" name="reqBukuPusat[]" value="<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_PUSAT")?>" style="width:165px;" <? if($kbbt_jur_bb_d_tmp->getField("DISABLE_BPUSAT") == "DISABLED") {} else { ?> tabindex="<? $last_tab++; echo $last_tab ?>"  onMouseDown="tabindex=<?=$last_tab?>" <? } ?> <?=$kbbt_jur_bb_d_tmp->getField("DISABLE_BPUSAT")?>  />                   	
                  </td>
                  <td>
                    <input type="text" name="reqKeterangan[]" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KET_TAMBAH")?>" style="width:95%;" tabindex="<? $last_tab++; echo $last_tab ?>" onMouseDown="tabindex=<?=$last_tab?>" />
                  </td>
                  <td>
                    <input type="text" name="reqDebet[]" id="reqDebet<?=$checkbox_index?>" style="text-align:right; width:95%;" OnFocus="FormatAngka('reqDebet<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqDebet<?=$checkbox_index?>'); hitungDebetTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqDebet<?=$checkbox_index?>')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_DEBET'))?>" tabindex="<? $last_tab++; echo $last_tab ?>" onMouseDown="tabindex=<?=$last_tab?>">
                  </td>
                  <td>
                    <input type="text" name="reqKredit[]" id="reqKredit<?=$checkbox_index?>" style="text-align:right; width:95%;" OnFocus="FormatAngka('reqKredit<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqKredit<?=$checkbox_index?>'); hitungKreditTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqKredit<?=$checkbox_index?>')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_KREDIT'))?>" tabindex="<? $last_tab++; echo $last_tab ?>" onMouseDown="tabindex=<?=$last_tab?>">
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

				<script type="text/javascript">
                $(function() {
                    $( "#reqBukuBesar<?=$checkbox_index?>" ).autocomplete({ source:'../json-keuangansiuk/buku_besar_combo_v2_json.php', 
                                                                //select: function (event, ui) { disableByPolaEntry(ui.item.POLA_ENTRY_ID, '<?=$checkbox_index?>'); }, 
                                                                minLength:1,
                                                                autoFocus: true
                                                            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                                                                return $( "<li>" )
                                                              .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
                                                              .appendTo( ul );
                    };
                                                            
                    $( "#reqKartu<?=$checkbox_index?>" ).autocomplete({ source:'../json-keuangansiuk/kartu_tambah_combo_v2_json.php' , 
                                                           autoFocus: true
                                                            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                                                                return $( "<li>" )
                                                              .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
                                                              .appendTo( ul );
                    };							
                                  
                    $( "#reqBukuPusat<?=$checkbox_index?>" ).autocomplete({ source:'../json-keuangansiuk/buku_pusat_combo_v2_json.php', 
                                                               autoFocus: true 
                                                            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                                                                return $( "<li>" )
                                                              .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
                                                              .appendTo( ul );		
                    };													  			
    
                });
                </script>              
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" style="width:35px" />
                  </td>
                  <td>
                    <input type="text" id="reqBukuBesar<?=$checkbox_index?>" name="reqBukuBesar[]" style="width:165px;" tabindex="7" onMouseDown="tabindex=9"  />
                  <td>
                    <input type="text" id="reqKartu<?=$checkbox_index?>" name="reqKartu[]" style="width:165px;" tabindex="8"  onMouseDown="tabindex=10"  />                   	
                  </td>
                  <td>
                    <input type="text" id="reqBukuPusat<?=$checkbox_index?>" name="reqBukuPusat[]"  style="width:165px;" tabindex="9"  onMouseDown="tabindex=11" />                   	
                  </td>
                  <td>
                    <input type="text" name="reqKeterangan[]" class="easyui-validatebox" style="width:95%;" tabindex="12" onMouseDown="tabindex=12"/>
                  </td>
                  <td>
                    <input type="text" name="reqDebet[]" id="reqDebet<?=$checkbox_index?>" style="text-align:right; width:95%;" OnFocus="FormatAngka('reqDebet<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqDebet<?=$checkbox_index?>'); hitungDebetTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqDebet<?=$checkbox_index?>')" tabindex="13" onMouseDown="tabindex=13" value="0" />
                  </td>
                  <td>
                    <input type="text" name="reqKredit[]" id="reqKredit<?=$checkbox_index?>" style="text-align:right; width:95%;" OnFocus="FormatAngka('reqKredit<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqKredit<?=$checkbox_index?>'); hitungKreditTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqKredit<?=$checkbox_index?>')" tabindex="14" onMouseDown="tabindex=14" value="0" />
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
            	<td class=""><input type="text" id="reqJumlahDebet" name="reqJumlahDebet" style="text-align:right; width:95%;" readonly value="<?=numberToIna($temp_jml_debet)?>" /></td>
            	<td class=""><input type="text" id="reqJumlahKredit" name="reqJumlahKredit" style="text-align:right; width:95%;" readonly value="<?=numberToIna($temp_jml_kredit)?>" /></td>
            	<td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>
    <div>
        <input type="hidden" name="reqId" value="<?=$reqId?>">
        <input type="hidden" name="reqMode" value="<?=$reqMode?>">
        <input type="submit" value="Submit">
        <input type="reset" id="rst_form">
        <?
        if($reqId == "")
		{}
		else
		{
		?>
        <input type="button" name="btnCetak" id="btnCetak" value="Cetak" onClick="cetak()">
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

$('input[id^="reqKredit"]').keydown(function(e) {
	if(e.which==13)
	{
		if(FormatAngkaNumber($(this).val()) == "0")
		{}
		else
		{		
			var num = $(this).attr("id").replace("reqKredit", "");
			tabBody=document.getElementsByTagName("TBODY").item(0);
			var rownum = tabBody.rows.length - 1;
			if(num == rownum)
				addRow();
		}
	}
});
$('input[id^="reqDebet"]').keydown(function(e) {
  if(e.which==13)
  {
	  if(FormatAngkaNumber($(this).val()) == "0")
	  {}
	  else
	  {
			var num = $(this).attr("id").replace("reqDebet", "");
			tabBody=document.getElementsByTagName("TBODY").item(0);
			var rownum = tabBody.rows.length - 1;
			if(num == rownum)
				addRow();		  
		  
		  var idReqKredit = $(this).attr('id').replace("reqDebet", "reqKredit");
		  $("#"+idReqKredit).removeAttr("tabindex");
	  }
  }
});

$("#reqBuktiPendukung, #reqPerusahaan, #reqAlamat, #reqKeteranganJurnal").keyup(function(e) {
	forceupper(this)
	//var temp= this.value.toUpperCase();
	//$(this).val(temp);
});
</script>
</body>
</html>