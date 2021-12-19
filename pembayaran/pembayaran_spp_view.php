<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSpp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSppD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kptt_nota_spp = new KpttNotaSpp();
$kptt_nota_spp_d = new KpttNotaSppD();
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
	$kptt_nota_spp->selectByParams(array("A.NO_NOTA"=>$reqId), -1, -1);
	$kptt_nota_spp->firstRow();
	
	$tempNoBukti = $kptt_nota_spp->getField("NO_NOTA");
	$tempTanggalValuta = dateToPageCheck($kptt_nota_spp->getField("TGL_VALUTA"));
	$tempTahun = $kptt_nota_spp->getField("THN_BUKU");
	$tempBulan = $kptt_nota_spp->getField("BLN_BUKU");
	$tempNoPelanggan = $kptt_nota_spp->getField("KD_KUSTO");
	$tempPelanggan = $kptt_nota_spp->getField("MPLG_NAMA");
	$tempNoBukuBesarKas = $kptt_nota_spp->getField("KD_BANK");
	$tempBank = $kptt_nota_spp->getField("REK_BANK");
	$tempKodeKasBank = $kptt_nota_spp->getField("KD_BB_BANK");
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota_spp->getField("TGL_TRANS"));
	$tempKeterangan = $kptt_nota_spp->getField("KET_TAMBAHAN");
	$tempValutaNama = $kptt_nota_spp->getField("KD_VALUTA");
	$tempTanggalPosting = dateToPageCheck($kptt_nota_spp->getField("TGL_POSTING"));
	$tempJumlahTransaksi = $kptt_nota_spp->getField("JML_VAL_TRANS");
	$tempKursValuta = numberToIna($kptt_nota_spp->getField("KURS_VALUTA"));
	$tempNoPosting = $kptt_nota_spp->getField("NO_POSTING");
	$tempBadanUsaha = $kptt_nota_spp->getField("BADAN_USAHA");
	$tempKdSubSis = $kptt_nota_spp->getField("KD_SUBSIS");
	$reqNoRef2 = $kptt_nota_spp->getField("NO_REF2");
	$reqNoRef3 = $kptt_nota_spp->getField("NO_REF1");
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
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>    
    <script type="text/javascript" src="../WEB-INF/lib/easyui/global-tab-easyui.js"></script>
    <script type="text/javascript" src="js/entri_pelunasan_transaksi_kas_bank.js"></script>
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
				url:'../json-pembayaran/pembayaran_spp_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					alert(data); return;
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'pembayaran_spp_add.php?reqId='+data[0];
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


				if(event.keyCode == 13)
				{
					
					OpenDHTMLPopup('proses_pelunasan_transaksi_kas_bank_pencarian.php?reqIndex=0&reqId='+$("#reqNoPelanggan").val()+'&reqKdValuta=IDR', 'Pencarian Transaksi', 950, 600);
					
					return false;
				}
			});	

			$('#btnPosting').on('click', function () {
				if(confirm("Posting jurnal <?=$reqId?> ?"))
				{			
					$.getJSON('../json-keuangansiuk/posting_jurnal_aksi.php?reqId=<?=$reqId?>&reqKdSubSis=<?=$tempKdSubSis?>',
					  function(data){					  
						  alert("Data berhasil diposting.");		
						  document.location.href = 'proses_pelunasan_transaksi_kas_bank_add.php?reqId=<?=$reqId?>';
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

		function OptionSetPPKB(anSelectedId, anSelectedKasId, anSelectedKas, anSelectedTgl, anSelectedPeriode, anSelectedBB, anSelectedTagihan, anSelectedNama){
			
			$("#reqNoRef3").val(anSelectedId);
			$("#reqKodeKasBank").val(anSelectedKasId);
			$("#reqBank").val(anSelectedKas);
			$("#reqPelanggan").val(anSelectedNama);

			$("#reqTotalBayar").val(anSelectedTagihan);
			$("#reqJumlahTransaksi").val(anSelectedTagihan);
			

			
			var anSelectedPeriodeArr = anSelectedPeriode.split(' ');

			$("#reqKeterangan").val("Pelunasan SPP " + anSelectedId + " Periode " + anSelectedPeriodeArr[1] + " " + anSelectedPeriodeArr[2]);


			var isi = `

              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="1" readonly />
                  </td>
                  <td>
                  <input type="text" name="reqNoPpkb[]" id="reqNoPpkb<?=$checkbox_index?>" class="easyui-validatebox" value="`+anSelectedId+`" />
                  </td>
                  <td>
                    <input type="text" name="reqTanggalNota[]" id="reqTanggalNota<?=$checkbox_index?>" class="easyui-validatebox" value="`+anSelectedTgl+`" readonly />
                  </td>
                  <td>
                    <input type="text" name="reqSisaPiutang[]"  style="text-align:right;"  id="reqSisaPiutang<?=$checkbox_index?>" readonly  OnFocus="FormatAngka('reqSisaPiutang<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisaPiutang<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisaPiutang<?=$checkbox_index?>')" value="`+anSelectedTagihan+`">
                  </td>
                  <td>
                    <input type="text" name="reqJumlahBayar[]"  style="text-align:right;"  id="reqJumlahBayar<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahBayar<?=$checkbox_index?>'); hitungJumlahTotal();" OnBlur="FormatUang('reqJumlahBayar<?=$checkbox_index?>')" readonly value="`+anSelectedTagihan+`">
                  </td>
                  <td align="center">
                  <label>
                    <input type="hidden" name="reqUangTitipan[]"  style="text-align:right;" id="reqUangTitipan<?=$checkbox_index?>"  readonly  OnFocus="FormatAngka('reqUangTitipan<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqUangTitipan<?=$checkbox_index?>')" OnBlur="FormatUang('reqUangTitipan<?=$checkbox_index?>')">
                    <input type="hidden" name="reqSisaBayar[]"  style="text-align:right;"  id="reqSisaBayar<?=$checkbox_index?>"  readonly OnFocus="FormatAngka('reqSisaBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisaBayar<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisaBayar<?=$checkbox_index?>')" value="0">
                    <input type="hidden" name="reqPelanggan[]" id="reqPelanggan<?=$checkbox_index?>" class="easyui-validatebox" value="`+anSelectedNama+`" readonly />
                  <input type="hidden" name="reqBukuBesar[]" id="reqBukuBesar<?=$checkbox_index?>" value="`+anSelectedBB+`">
                  <input type="hidden" name="reqPrevNoNota[]" id="reqPrevNoNota<?=$checkbox_index?>" value="">
                  </label>
                  </td>
              </tr>
			`;

			$("#alternatecolor").append(isi);

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
				
	</script>
    
    
</head>
     
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Pembayaran Tunai  SPP</span>
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
             <td>NIS</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:60px;  background-color:#f0f0f0" readonly type="text" value="<?=$tempNoPelanggan?>" />         
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" style="width:250px; background-color:#f0f0f0" type="text" value="<?=$tempPelanggan?>" />   
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="reqBadanUsaha" id="reqBadanUsaha" class="easyui-validatebox" style="width:295px" type="hidden" value="SISWA" readonly />
			</td>
            <td>Rek. Kas Tunai</td>
			 <td>			
                <input name="reqKodeKasBank" id="reqKodeKasBank" class="easyui-validatebox" readonly style="width:110px; background-color:#f0f0f0" type="text" value="<?=$tempKodeKasBank?>" readonly />
                <input name="reqBank" id="reqBank" class="easyui-validatebox" readonly style="width:310px; background-color:#f0f0f0" type="text" value="<?=$tempBank?>" readonly />
                             
			</td>
        </tr>
        <tr>
            <td>No Ref Tagihan</td>
            <td>
            	<input id="reqNoRef3" name="reqNoRef3" style="width:140px; background-color:#f0f0f0"  value="<?=$reqNoRef3?>" readonly/>
                &nbsp;          
            </td>
            <td>Keterangan Tambahan</td>
            <td>
				<input name="reqKeterangan" id="reqKeterangan" class="easyui-validatebox" style="width:470px" type="text" value="<?=$tempKeterangan?>" tabindex="5" onMouseDown="tabindex=5" />
            </td>
        </tr>
        <tr>
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" tabindex="2" onMouseDown="tabindex=2" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
            <td>Jml Trans</td>
			 <td>
                
                <input id="reqJumlahTransaksi" name="reqJumlahTransaksi" class="easyui-validatebox" style="width:164px; background-color:#f0f0f0" OnFocus="FormatAngka('reqJumlahTransaksi')" OnKeyUp="FormatUang('reqJumlahTransaksi')" OnBlur="FormatUang('reqJumlahTransaksi')" readonly value="<?=numberToIna($tempJumlahTransaksi)?>"  />   
			</td>
        </tr>
        </thead>
    </table>
 
    <table class="example" id="dataTableRowDinamis">
    <!--<table class="example altrowstable" id="alternatecolor" >-->
        <thead class="altrowstable">
          <tr>
              <th style="width:5%">
                No</a>
              </th>
              <th>No Nota</th>
              <th>Tanggal Nota</th>
              <th>Sisa Piutang</th>
              <th>Jumlah Bayar</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
          <?
          $i = 1;
          $checkbox_index = 0;
          
          $kptt_nota_spp_d->selectByParamsPelunasanKasBank(array("A.NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY LINE_SEQ ASC ");
          while($kptt_nota_spp_d->nextRow())
          {
          ?>
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" readonly />
                  </td>
                  <td>
                  <input type="text" name="reqNoPpkb[]" id="reqNoPpkb<?=$checkbox_index?>" class="easyui-validatebox" value="<?=$kptt_nota_spp_d->getField("NO_REF3")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqTanggalNota[]" id="reqTanggalNota<?=$checkbox_index?>" class="easyui-validatebox" value="<?=dateToPage($kptt_nota_spp_d->getField("TGL_TRANS"))?>" readonly />
                  </td>
                  <td>
                    <input type="text" name="reqSisaPiutang[]"  style="text-align:right;"  id="reqSisaPiutang<?=$checkbox_index?>" readonly  OnFocus="FormatAngka('reqSisaPiutang<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisaPiutang<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisaPiutang<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_spp_d->getField("JML_VAL_TRANS"))?>">
                  </td>
                  <td>
                    <input type="text" name="reqJumlahBayar[]"  style="text-align:right;"  id="reqJumlahBayar<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahBayar<?=$checkbox_index?>'); hitungJumlahTotal();" readonly OnBlur="FormatUang('reqJumlahBayar<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_spp_d->getField("JML_VAL_TRANS"))?>">
                  </td>
                  <td align="center">
                  <label>
                    <input type="hidden" name="reqUangTitipan[]"  style="text-align:right;" id="reqUangTitipan<?=$checkbox_index?>"  readonly  OnFocus="FormatAngka('reqUangTitipan<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqUangTitipan<?=$checkbox_index?>')" OnBlur="FormatUang('reqUangTitipan<?=$checkbox_index?>')">
                    <input type="hidden" name="reqSisaBayar[]"  style="text-align:right;"  id="reqSisaBayar<?=$checkbox_index?>"  readonly OnFocus="FormatAngka('reqSisaBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisaBayar<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisaBayar<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_spp_d->getField("SISA_TAGIHAN"))?>">
                    <input type="hidden" name="reqPelanggan[]" id="reqPelanggan<?=$checkbox_index?>" class="easyui-validatebox" value="<?=$kptt_nota_spp_d->getField("MPLG_NAMA")?>" readonly />
                  <input type="hidden" name="reqBukuBesar[]" id="reqBukuBesar<?=$checkbox_index?>" value="<?=$kptt_nota_spp_d->getField("KD_BB_KUSTO")?>">
                  <input type="hidden" name="reqPrevNoNota[]" id="reqPrevNoNota<?=$checkbox_index?>" value="<?=$kptt_nota_spp_d->getField("PREV_NO_NOTA")?>">
                  </label>
                  </td>
              </tr>
			  <?
                $i++;
                $checkbox_index++;
                $temp_jml_debet += $kptt_nota_spp_d->getField('JML_VAL_TRANS');
              }
              ?>
        </tbody>
        
        <tfoot class="altrowstable">
        	<tr style="background:#f1f4fc">
            	<td colspan="4">&nbsp;</td>
            	<td class=""><input type="text" id="reqTotalBayar" name="reqTotalBayar" style="text-align:right;" readonly value="<?=numberToIna($temp_jml_debet)?>" /></td>
            </tr>
        </tfoot>
    </table>        
    </form>
</div>
</body>
</html>