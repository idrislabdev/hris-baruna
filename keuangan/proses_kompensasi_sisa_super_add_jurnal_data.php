<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kptt_nota = new KpttNota();
$kbbt_jur_bb = new KbbtJurBb();
$safr_valuta = new SafrValuta();

$tempId=$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

$kbbt_jur_bb->selectByParams(array("NO_NOTA"=>$reqId), -1, -1);
$kbbt_jur_bb->firstRow();
$reqId = $kbbt_jur_bb->getField("NO_NOTA");

if($reqId == "")
{
	$reqMode = "insert";	
	$tempKursValuta = 1;
	
	$kptt_nota->selectByParams(array("A.NO_NOTA"=>$tempId), -1, -1);
	$kptt_nota->firstRow();
	
	$tempNoBukti = $kptt_nota->getField("NO_NOTA");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempBuktiPendukung = $kptt_nota->getField("NO_REF1");
	$tempJumlahTransaksi = $kptt_nota->getField("JML_VAL_TRANS");
	$tempNoPosting = $kptt_nota->getField("NO_POSTING");
	$tempNoPelanggan = $kptt_nota->getField("KD_KUSTO");
	$tempPelanggan = $kptt_nota->getField("MPLG_NAMA");

	$tempTahun = date("Y");
	$tempBulan = "";
}
else
{
	$reqMode = "update";	
	$kbbt_jur_bb->selectByParams(array("NO_NOTA"=>$reqId), -1, -1);
	$kbbt_jur_bb->firstRow();
	
	$tempNoBukti = $kbbt_jur_bb->getField("NO_NOTA");
	$tempValutaNama = $kbbt_jur_bb->getField("KD_VALUTA");
	$tempBuktiPendukung = $kbbt_jur_bb->getField("NO_REF1");
	$tempJumlahTransaksi = $kbbt_jur_bb->getField("JML_VAL_TRANS");
	$tempNoPosting = $kbbt_jur_bb->getField("NO_POSTING");
	$tempNoPelanggan = $kbbt_jur_bb->getField("KD_KUSTO");
	$tempPelanggan = $kbbt_jur_bb->getField("MPLG_NAMA");
	
	$tempTahun = $kbbt_jur_bb->getField("THN_BUKU");
	$tempBulan = $kbbt_jur_bb->getField("BLN_BUKU");
}
$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<script type="text/javascript">
		function setValue(){
			parent.frames["mainFrameDetilPop"].document.getElementById("reqId").value = '<?=$tempNoBukti?>';
		}
		$.fn.datebox.defaults.formatter = function(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
		};
		
		$.extend($.fn.validatebox.defaults.rules, {
			date:{
				validator:function(value, param) {
					if(value.length == '10')
					{
						var reg = /^(\d{1,2})(-|\/)(\d{1,2})\2(\d{1,4})$/;
						return reg.test(value);
					}
					else
					{
						return false;
					}
				},
				message:"Format Tanggal: dd-mm-yyyy"
			}  
		});
	
		$.fn.datebox.defaults.parser = function(s) {
			if (s) {
				var a = s.split('-');
				var d = new Number(a[0]);
				var m = new Number(a[1]);
				var y = new Number(a[2]);
				var dd = new Date(y, m-1, d);
				return dd;
			} 
			else 
			{
				return new Date();
			}
		};
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/proses_kompensasi_sisa_super_add_jurnal_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);
					
					//data = data.split("-");
					document.location.href = 'proses_kompensasi_sisa_super_add_jurnal_data.php?reqId=<?=$reqId?>';
					parent.frames["mainFrameDetilPop"].document.getElementById("btnSubmit").click();
					top.frames['mainFrame'].location.reload();
								
				}
			});
			
		});
		
		$(function(){
		
			$("#reqNoPelanggan").keypress(function(e) {
			return true;
			});
		
			$("#reqNoPelanggan").keyup(function(e) {		
			$.getJSON("../json-keuangansiuk/get_pelanggan_json.php?reqNoPelangganId="+$("#reqNoPelanggan").val(),
			function(data){
				$("#reqPelanggan").val(data.MPLG_NAMA);
				$("#reqAlamat").val(data.MPLG_ALAMAT);
				$("#reqNPWP").val(data.MPLG_NPWP);
			});
		});
		
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
						parent.OpenDHTML('pelanggan_pencarian.php', 'Pencarian Pelanggan', 900, 600);
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
		}		


	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <!--<script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script> -->

<style type="text/css">
div.message{
background: transparent url(msg_arrow.gif) no-repeat scroll bottom left;
padding-bottom: 5px;
}

div.error{
background-color:#F3E6E6;
border-color: #924949;
/*border-style: solid solid solid none;*/
border-style: solid solid solid solid;
border-width: 1px;
padding: 5px;
}
</style>
</head>
     
</head>
<body onLoad="setTimeout(setValue, 2000);">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Jurnal Rupa-Rupa Kompensasi Nota Tagih</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>No Bukti</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoBukti?>" readonly />
			</td>
            <td>Valuta</td>
			<td>
            	<select name="reqValutaNama" id="reqValutaNama">
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
				<input name="reqBuktiPendukung" class="easyui-validatebox" style="width:300px" type="text" value="<?=$tempBuktiPendukung?>" readonly />
			</td>
            <td>Jumlah Transaksi</td>
			 <td>
             	<input id="reqJumlahTransaksi" name="reqJumlahTransaksi" class="easyui-validatebox" style="width:140px" OnFocus="FormatAngka('reqJumlahTransaksi')" OnKeyUp="FormatUang('reqJumlahTransaksi')" OnBlur="FormatUang('reqJumlahTransaksi')" value="<?=numberToIna($tempJumlahTransaksi)?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoPelanggan?>" onKeyDown="openPopup('PELANGGAN');" readonly />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempPelanggan?>" readonly />
            </td>
            <td>No&nbsp;Posting</td>
			 <td>
				<input name="reqNoPosting" class="easyui-validatebox" style="width:300px" type="text" value="<?=$tempNoPosting?>" />
			</td>
        </tr>
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
	$("#reqBulan,#reqTahun").keypress(function(e) {
		if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
		{
		return false;
		}
	});
</script>
</body>
</html>