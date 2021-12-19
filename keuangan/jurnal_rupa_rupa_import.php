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
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/global-tab-easyui.js"></script>
    <script type="text/javascript" src="js/entri_tabel_jurnal_faktur.js"></script>
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
				url:'../json-keuangansiuk/jurnal_rupa_rupa_import.php',
				onSubmit:function(){
					$(this).find(':input').removeAttr('disabled');
					return $(this).form('validate');
				},
				success:function(data){
					document.location.href = 'jurnal_rupa_rupa_import_add.php?reqId='+data;
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

			$('#reqTanggalTransaksi').datebox({
				onSelect: function(date){
					var y = date.getFullYear();
					var m = date.getMonth() + 1;
					var d = date.getDate();
					var dat = (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
				    $('#reqBulan').val((m < 10 ? '0' + m : m));
				    $('#reqTahun').val(y);
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
			
		function cetak()
		{	
			/*newWindow = window.open('jurnal_rupa_rupa_rpt.php?reqId=<?=$reqId?>', 'Cetak');
			newWindow.focus();	*/		
			OpenDHTMLPopup('jurnal_rupa_rupa_penanda_tangan.php?reqNoBukti=<?=$reqId?>', 'Office Management - Aplikasi Keuangan', '600', '300');
			
		}			
		
		$(function(){
			  			  
				$('#reqPerusahaan').combobox('textbox').bind('mousedown',function(e){
					tabindex=3;
				}); 
				
				$('#reqBukuBesar0').combobox('textbox').bind('mousedown',function(e){
					tabindex=7;
				}); 
				
				$('#reqKartu0').combobox('textbox').bind('mousedown',function(e){
					tabindex=8;
				}); 
				
				$('#reqBukuPusat0').combobox('textbox').bind('mousedown',function(e){
					tabindex=9;
				}); 
								
				$('#reqTanggalTransaksi').datebox('textbox').bind('mousedown',function(e){
					tabindex=2;
				}); 
				
				$('#reqTanggalFakturPajak0').datebox('textbox').bind('mousedown',function(e){
					tabindex=11;
				});  
		});				

		function callExcel()
		{
			newWindow = window.open('jrr_import.xls', 'Cetak');
			newWindow.focus();
		}
					
	</script>
    
    
</head>
     
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Import Data Jurnal Rupa - Rupa</span>
    </div>
    <form id="ff" method="post" enctype="multipart/form-data" novalidate>
    <table style="margin-left:17px;">
    	<thead>
        <tr>           
             <td>Bukti&nbsp;Pendukung</td>
			 <td>
				<input name="reqBuktiPendukung" id="reqBuktiPendukung" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempBuktiPendukung?>" tabindex="1" onMouseDown="tabindex=1"/>
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
             <td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" tabindex="2" onMouseDown="tabindex=2"/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
            <td>Kurs&nbsp;Valuta</td>
			 <td>
				<input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px; background-color:#f0f0f0" type="text" value="<?=$tempKursValuta?>" readonly />
			</td>
        </tr>
        <tr>           
             <td>Agen&nbsp;/&nbsp;Perusahaan</td>
			 <td>
             	<input type="hidden" name="reqKusto" id="reqKusto" value="<?=$tempKusto?>">
                <input name="reqPerusahaan" id="reqPerusahaan" class="easyui-combobox" style="width:295px" type="text" value="<?=$tempPerusahaan?>"  data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/pelanggan_combo_json.php',
                    onSelect:function(rec){                    
                    	$('#reqKusto').val(rec.MPLG_KODE);
                    	$('#reqAlamat').val(rec.MPLG_ALAMAT);
                    }
                    "
                    onKeyDown="openPopup('PELANGGAN');" tabindex="3" onMouseDown="tabindex=3" />                       
			</td>
            <td>Bulan&nbsp;Buku</td>
			 <td>
                <input  type="text" id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:100px; background-color:#f0f0f0" value="<?=$tempTahun?>" readonly/>
                <input  type="text" id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px; background-color:#f0f0f0" value="<?=$tempBulan?>" readonly/>
			</td>
        </tr>
        <tr>           
             <td valign="top">Alamat</td>
			 <td>
  	  	        <textarea name="reqAlamat" id="reqAlamat" style="width:400px; height:80px"  tabindex="4" onMouseDown="tabindex=4"><?=$tempAlamat?></textarea>
			</td>
            <td valign="top">Keterangan</td>
			 <td>
				<textarea name="reqKeteranganJurnal" style="width:400px; height:80px;" tabindex="6" onMouseDown="tabindex=6"><?=$tempKeteranganJurnal?></textarea>
   			</td>
        </tr>
        <tr>           
             <td valign="top">File Import</td>
			 <td colspan="3">
             	<input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
        		<input type="file" name="reqLinkFile" id="reqLinkFile" />
                <br>
                <a href="#" onClick="callExcel()" style="font-size:14px">Contoh file excel.</a>			
   			</td>
        </tr>                
        </thead>
    </table>
 
    <div>
        <input type="hidden" name="reqId" value="<?=$reqId?>">
        <input type="hidden" name="reqMode" value="<?=$reqMode?>">
        <input type="submit" value="Submit">
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
</script>
</body>
</html>