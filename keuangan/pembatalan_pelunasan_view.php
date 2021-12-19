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
	$tempNoBuktiDikoreksi = $kptt_nota->getField("PREV_NOTA_UPDATE");
	$tempTipeTransaksi = $kptt_nota->getField("TIPE_DESC");
	$tempKdBukuBesar = $kptt_nota->getField("KD_BB_BANK");
	$tempNmBukuBesar = $kptt_nota->getField("NM_BUKU_BESAR");
	$tempNoPelanggan = $kptt_nota->getField("KD_KUSTO");
	$tempPelanggan = $kptt_nota->getField("MPLG_NAMA");
	$tempNoChqBukti = $kptt_nota->getField("NO_CHEQUE");
	$tempNoRef = $kptt_nota->getField("NO_REF1");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota->getField("TGL_TRANS"));
	$tempNilaiTransaksi = $kptt_nota->getField("JML_RP_TRANS");
	$tempTahun=  $kptt_nota->getField("THN_BUKU");
	$tempBulan=  $kptt_nota->getField("BLN_BUKU");
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
	$tempBadanUsaha = $kptt_nota->getField("BADAN_USAHA");
	$tempKodeBank = $kptt_nota->getField("KD_BANK");
	$tempKdBbKusto = $kptt_nota->getField("KD_BB_KUSTO");
	$tempTanggalValuta = dateToPageCheck($kptt_nota->getField("TGL_VALUTA"));
}
$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
$kbbr_tipe_trans->selectByParams(array("KD_SUBSIS" => "KPT", "KD_JURNAL" => "JKK"));
$disabled="disabled";
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
    <script type="text/javascript" src="js/entri_pembatalan_pelunasan_nota.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');	
		}		
		/* KBBT_JUR_BB */
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/pembatalan_pelunasan_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//data = data.split("-");					
					$.messager.alert('Info', data, 'info');	
					//$.messager.alert('Info', data[1], 'info');	
					//document.location.href = 'pembatalan_pelunasan_add.php?reqId='+data[0];
					top.frames['mainFrame'].location.reload();
				}
			});
			
		});
		
		$(function(){
		$("#reqNoBuktiDikoreksi").keypress(function(event) { 
		   getDataJKM(event);
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Pembatalan Pelunasan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>
        <tr>           
             <td>No Bukti</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" <?=$disabled?> style="width:170px" type="text" value="<?=$tempNoBukti?>" />
			</td>
            <td>No Bukti Dikoreksi</td>
			 <td>
				<input name="reqNoBuktiDikoreksi" id="reqNoBuktiDikoreksi" class="easyui-validatebox" <?=$disabled?> style="width:170px" type="text" value="<?=$tempNoBuktiDikoreksi?>" />
			</td>
        </tr>
        <tr>
        	<td>Tipe Transaksi</td>
			 <td>
             	<select name="reqTipeTransaksi" id="reqTipeTransaksi" <?=$disabled?>>
                <?
                while($kbbr_tipe_trans->nextRow())
				{
				?>
                <option value="<?=$kbbr_tipe_trans->getField("TIPE_TRANS")?>" <? if($kbbr_tipe_trans->getField("TIPE_TRANS") == $tempTipeTransaksi) { ?> selected <? } ?>><?=$kbbr_tipe_trans->getField("TIPE_DESC")?></option>
                <?
				}
				?>
                </select> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input id="reqTahun" name="reqTahun" type="hidden" class="easyui-validatebox" <?=$disabled?> data-options="validType:'minLength[4]'" maxlength="4" value="<?=$tempTahun?>" />
                &nbsp;&nbsp;
                <input id="reqBulan" name="reqBulan" type="hidden" class="easyui-validatebox" <?=$disabled?> data-options="validType:'minLength[2]'" maxlength="2" style="width:50px" value="<?=$tempBulan?>" />
			</td>
            <td>BB Kas / Bank</td>
			 <td>
 	            <input name="reqKodeBank" id="reqKodeBank" class="easyui-validatebox" <?=$disabled?> style="width:80px" type="hidden" value="<?=$tempKodeBank?>" />
				<input name="reqKdBukuBesar" id="reqKdBukuBesar" class="easyui-validatebox" <?=$disabled?> style="width:80px" type="text" value="<?=$tempKdBukuBesar?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqNmBukuBesar" id="reqNmBukuBesar" class="easyui-validatebox" <?=$disabled?> style="width:295px" type="text" value="<?=$tempNmBukuBesar?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" <?=$disabled?> style="width:50px" type="text" value="<?=$tempNoPelanggan?>" onKeyDown="openPopup('PELANGGAN');" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" <?=$disabled?> style="width:295px" type="text" value="<?=$tempPelanggan?>" />
				<input name="reqBadanUsaha" id="reqBadanUsaha" class="easyui-validatebox" <?=$disabled?> style="width:295px" type="hidden" value="<?=$tempBadanUsaha?>" />
                <input name="reqKdBbKusto" id="reqKdBbKusto" class="easyui-validatebox" <?=$disabled?> style="width:295px" type="hidden" value="<?=$tempKdBbKusto?>" />
			</td>
            <td>No Chq/Bukti</td>
            <td>
            	<input name="reqNoChqBukti" class="easyui-validatebox" <?=$disabled?> style="width:295px" type="text" value="<?=$tempNoChqBukti?>" />
            </td>
        </tr>
        <tr>           
             <td>No Ref</td>
			 <td>
             	<input name="reqNoRef" class="easyui-validatebox" <?=$disabled?> style="width:340px" type="text" value="<?=$tempNoRef?>" />
			</td>
            <td>Valuta</td>
			<td>
                <select name="reqValutaNama" id="reqValutaNama" <?=$disabled?>>
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
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" <?=$disabled?> class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
            <td>Nilai Transaksi</td>
            <td>
    	        <input id="reqNilaiTransaksi" name="reqNilaiTransaksi" <?=$disabled?> class="easyui-validatebox" style="width:140px" OnFocus="FormatAngka('reqNilaiTransaksi')" OnKeyUp="FormatUang('reqNilaiTransaksi')" OnBlur="FormatUang('reqNilaiTransaksi')" value="<?=numberToIna($tempNilaiTransaksi)?>"  />
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>
			<td>
                <input name="reqKeterangan" class="easyui-validatebox" <?=$disabled?> style="width:350px" type="text" value="<?=$tempKeterangan?>" />
			</td>
        </tr>
        <tr>
        	<td colspan="4">
            <div>
 	           <input type="hidden" id="reqTanggalValuta" name="reqTanggalValuta" value="<?=$tempTanggalValuta?>">
	            <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <input type="hidden" name="reqPpnMaterai" id="reqPpnMaterai" value="<?=$ppn_materai?>">
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
              <th>No&nbsp;Nota</th>
              <th>No Ref</th>
              <th>Tanggal Transaksi</th>
              <th>Jatuh Tempo</th>
              <th>Jumlah Upper</th>
              <th>Jumlah Piutang</th>
              <th>Jumlah Dibayar</th>
              <th style="display:none">Lain</th>
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
                  	<input type="text" name="reqNoUrut[]" <?=$disabled?> class="easyui-validatebox" value="<?=$i?>" />
                  </td>
                  <td>
                    <input type="text" name="reqNoNota[]" <?=$disabled?> class="easyui-validatebox" value="<?=$kptt_nota_d->getField("NO_REF3")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqNoRef3[]" <?=$disabled?> class="easyui-validatebox" value="<?=$kptt_nota_d->getField("NO_REF3")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqTanggalTransaksiDetil[]" <?=$disabled?> class="easyui-validatebox" value="<?=dateToPage($kptt_nota_d->getField("TGL_TRANS"))?>" />
                  </td>
                  <td>
                    <input type="text" name="reqJatuhTempo[]" <?=$disabled?> class="easyui-validatebox" value="<?=dateToPage($kptt_nota_d->getField("TGL_JT_TEMPO"))?>" />
                  </td>
                  <td>
                    <input type="text" name="reqJumlahUpper[]"  <?=$disabled?> style="text-align:right" id="reqJumlahUpper<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahUpper<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahUpper<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahUpper<?=$checkbox_index?>')" value="">
                  </td>
                  <td>
                    <input type="text" name="reqJumlahPiutang[]" <?=$disabled?> style="text-align:right"  id="reqJumlahPiutang<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahPiutang<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahPiutang<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahPiutang<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("SISA_TAGIHAN"))?>">
                  </td>
                  <td>
                    <input type="text" name="reqJumlahDibayar[]" <?=$disabled?> style="text-align:right"  id="reqJumlahDibayar<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahDibayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahDibayar<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahDibayar<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("JML_VAL_TRANS"))?>">
 	              </td>
				  <td style="display:none">
		            <input type="text" name="reqPrevNoNota[]" id="reqPrevNoNota<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("PREV_NO_NOTA")?>">         
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
            	<td colspan="7">&nbsp;</td>         	
                <td><input type="text" id="reqJumlahTrans" <?=$disabled?> name="reqJumlahTrans" style="text-align:right;" value="<?=numberToIna($temp_jml_trans)?>" /></td>            	
            </tr>
        </tfoot>
    </table>        
    </form>
</div>
</body>
</html>