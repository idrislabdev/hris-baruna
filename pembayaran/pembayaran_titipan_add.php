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
	$reqDepartemenKelas = $kptt_nota_spp->getField("DEPARTEMEN_KELAS");
	$reqVerified = $kptt_nota_spp->getField("VERIFIED");


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
				url:'../json-pembayaran/pembayaran_titipan_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data); return;
					data = JSON.parse(data);			
					if(data.status == 'success')
					{		
						$.messager.alert('Info', data.message, 'info');	
						document.location.href = 'pembayaran_titipan_add.php?reqId='+data.id;
						top.frames['mainFrame'].reloadMonitoring();
					}
					else
					{
						$.messager.alert('Info', data.message, 'warning');	
					}
					//top.frames['mainFrame'].location.reload();
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


			<?
			if(empty($tempNoBukti))
			{
			?>

			$('#reqNoPelanggan').keydown(function (event) {


				if(event.keyCode == 13)
				{
					
					$.get( "../json-pembayaran/get_pelanggan_json.php?reqNoPelangganId="+$('#reqNoPelanggan').val(), function( data ) {
					 	data = JSON.parse(data);

						$("#reqPelanggan").val(data.NAMA);
						$("#reqDepartemenKelas").val(data.SEKOLAH + ' ' + data.KELAS);
						$("#reqVerified").val(data.KODE_BB);
						alert(data.SEKOLAH);
						$("#reqBank").val(data.SEKOLAH);


					});
					return false;
				}
			});	

			<?
			}
			?>

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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Pembayaran Tunai </span>
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
             <td>Masukkan NIS (enter)</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:60px" type="text" value="<?=$tempNoPelanggan?>" />         
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" style="width:250px; background-color:#f0f0f0" type="text" value="<?=$tempPelanggan?>" />   
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="reqBadanUsaha" id="reqBadanUsaha" class="easyui-validatebox" style="width:295px" type="hidden" value="SISWA" readonly />
			</td>
            <td>Rek. Kas Tunai</td>
			 <td>			
			 	<input name="reqNoRef3" id="reqNoRef3" class="easyui-combobox" style="width:280px" type="text" value="<?=$reqNoRef3?>"  data-options="
	                required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-pembayaran/uang_titipan_json.php?reqKdValuta=IDR',
                    onSelect:function(rec){ 
                    	$('#reqKodeKasBank').val(rec.id);
                    	$('#reqNoRef2').val(rec.text);
                    }
                    "
                 tabindex="4" onMouseDown="tabindex=4" /> 
                <input name="reqKodeKasBank" id="reqKodeKasBank" class="easyui-validatebox" readonly style="width:110px; background-color:#f0f0f0" type="text" value="<?=$reqNoRef3?>" readonly />
                <input name="reqVerified" id="reqVerified" class="easyui-validatebox" readonly style="width:110px; background-color:#f0f0f0" type="hidden" value="<?=$reqVerified?>" readonly />

                <input name="reqNoRef2" id="reqNoRef2" class="easyui-validatebox" readonly style="width:110px; background-color:#f0f0f0" type="hidden" value="<?=$reqNoRef2?>" readonly />
                <input name="reqBank" id="reqBank" class="easyui-validatebox" readonly style="width:110px; background-color:#f0f0f0" type="hidden" value="<?=$tempBank?>" readonly />

                             
			</td>
        </tr>
        <tr>
        	<td>Sekolah</td>
			 <td>
				<input name="reqDepartemenKelas" id="reqDepartemenKelas" class="easyui-validatebox" style="width:270px; background-color:#f0f0f0"  readonly type="text" value="<?=$reqDepartemenKelas?>" tabindex="5" onMouseDown="tabindex=5" />
             	
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
                
                <input id="reqJumlahTransaksi" name="reqJumlahTransaksi" class="easyui-validatebox" style="width:164px;" OnFocus="FormatAngka('reqJumlahTransaksi')" OnKeyUp="FormatUang('reqJumlahTransaksi')" OnBlur="FormatUang('reqJumlahTransaksi')"  value="<?=numberToIna($tempJumlahTransaksi)?>"  />   
			</td>
        </tr>
        <tr>
        	<td colspan="4">
            <div>
                <input type="hidden" name="reqValutaNama" value="IDR">
                <input type="hidden" name="reqKursValuta" value="1">
                <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <input type="submit" value="Submit">
                <input type="reset" id="rst_form">
            </div>           
            </td>
        </tr>   
        </thead>
    </table>
 	    
    </form>
</div>
</body>
</html>