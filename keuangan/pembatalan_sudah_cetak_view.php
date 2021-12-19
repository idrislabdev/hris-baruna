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
    <script type="text/javascript" src="js/entri_pembatalan_sudah_cetak_nota.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');	
		}		
		/* KBBT_JUR_BB */
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/pembatalan_sudah_cetak_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'pembatalan_sudah_cetak_add.php?reqId='+data[0];
					//top.frames['mainFrame'].location.reload();
				}
			});
			
		});
		
		$(function(){
		$("#reqNoRef3").keypress(function(event) { 
		   getDataJPJ(event);
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Pembatalan Sudah Cetak Nota</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>
        <tr>           
             <td>No Bukti JRR</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" <?=$disabled?> style="width:170px" type="text" value="<?=$tempNoBukti?>" />
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" <?=$disabled?> class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalValuta?>" />
			</td>
        </tr>
     
        <tr>           
             <td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" <?=$disabled?> class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
			</td>
            <td>Nama Kapal</td>
			 <td>
             	<input id="reqKodeKapal" name="reqKodeKapal" class="easyui-validatebox" <?=$disabled?> style="width:70px" value="<?=$tempKodeKapal?>" />
                <input name="reqKapal" class="easyui-validatebox" style="width:290px" <?=$disabled?> type="text" value="<?=$tempKapal?>" />
			</td>
        </tr>
        <tr>           
             <td>Jenis Jasa</td>
			 <td>
             	<input name="reqJenisJasa" class="easyui-validatebox" style="width:150px" <?=$disabled?> type="text" value="<?=$tempJenisJasa?>" />
             </td>
             <td>Materai</td>
             <td>
				<input name="reqMaterai" id="reqMaterai" class="easyui-validatebox" <?=$disabled?> style="width:80px" type="text" value="<?=$tempMaterai?>" />
                &nbsp;
                Jumlah Upper
                <input id="reqJumlahUpper" name="reqJumlahUpper" class="easyui-validatebox" <?=$disabled?> style="width:140px" OnFocus="FormatAngka('reqJumlahUpper')" OnKeyUp="FormatUang('reqJumlahUpper')" OnBlur="FormatUang('reqJumlahUpper')" value="<?=numberToIna($tempJumlahUpper)?>"  />
             </td>
        </tr>
        <tr>           
             <td>Kd Agen</td>
			 <td>
	             <input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" <?=$disabled?> style="width:50px" type="text" value="<?=$tempNoPelanggan?>" onKeyDown="openPopup('PELANGGAN');" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" <?=$disabled?> style="width:280px" type="text" value="<?=$tempPelanggan?>" />
                <input name="reqBadanUsaha" id="reqBadanUsaha" type="hidden" value="<?=$tempBadanUsaha?>">
			</td>
            <td>Jumlah Tagihan</td>
			 <td>
             	<input id="reqJumlahTagihan" name="reqJumlahTagihan" class="easyui-validatebox" <?=$disabled?> style="width:140px" OnFocus="FormatAngka('reqJumlahTagihan')" OnKeyUp="FormatUang('reqJumlahTagihan')" OnBlur="FormatUang('reqJumlahTagihan')" value="<?=numberToIna($tempJumlahTagihan)?>"  />
            </td>
        </tr>
        <tr>
            <td>Kode Valuta</td>
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
                Kurs
                <input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" <?=$disabled?> style="width:50px" type="text" value="<?=$tempKursValuta?>" />
			</td>
            <td rowspan="2">Keterangan Tambahan</td>
            <td rowspan="2">
            	<textarea name="reqKeterangan" cols="50" rows="2" <?=$disabled?>><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>
            <td>No 1A / 1B / 1C</td>
			<td>
                <input name="reqNoRef3" id="reqNoRef3" class="easyui-validatebox" <?=$disabled?> style="width:150px" type="text" value="<?=$tempNoRef3?>" />
                <input name="reqNotaUpdate" id="reqNotaUpdate" class="easyui-validatebox" <?=$disabled?> style="width:150px" type="text" value="<?=$tempNotaUpdate?>" />
			</td>
        </tr>
            <tr>
                <td>Tanggal Posting</td>
                <td><input name="reqTanggalPosting" value="<?=$tempTanggalPosting?>"  <?=$disabled?> />&nbsp;&nbsp;No&nbsp;Posting &nbsp;&nbsp;<input name="reqNoPosting" value="<?=$tempNoPosting?>" <?=$disabled?> /></td>
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
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" <?=$disabled?> />
                  </td>
                  <td>
                    <input type="text" name="reqKlasTrans[]" id="reqKlasTrans<?=$checkbox_index?>" <?=$disabled?> class="easyui-validatebox" value="<?=$kptt_nota_d->getField("KLAS_TRANS")?>" />                   
                  </td>
                   <td>
                    <input type="text" name="reqNilaiPajak[]" style="text-align:right;" id="reqNilaiPajak<?=$checkbox_index?>" <?=$disabled?> OnFocus="FormatAngka('reqNilaiPajak<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiPajak<?=$checkbox_index?>')" OnBlur="FormatUang('reqNilaiPajak<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JML_VAL_PAJAK'))?>">
                  </td>
                  <td>
                    <input type="text" name="reqJumlah[]" style="text-align:right;" id="reqJumlah<?=$checkbox_index?>" <?=$disabled?> OnFocus="FormatAngka('reqJumlah<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlah<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlah<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JML_VAL_TRANS'))?>">
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
            	<td class=""><input type="text" id="reqJumlahPajak" name="reqJumlahPajak" style="text-align:right;" <?=$disabled?> value="<?=numberToIna($temp_jml_pajak)?>" /></td>
            	<td><input type="text" id="reqJumlahTrans" name="reqJumlahTrans" style="text-align:right;" <?=$disabled?> value="<?=numberToIna($temp_jml_trans)?>" /></td>            	
            </tr>
        </tfoot>
    </table>        
    </form>
</div>
</body>
</html>