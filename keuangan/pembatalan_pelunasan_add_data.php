<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTrans.php");

$kptt_nota = new KpttNota();
$safr_valuta = new SafrValuta();
$kbbr_tipe_trans = new KbbrTipeTrans();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
	$tempKursValuta = 1;
	$kptt_nota->selectByParamsGenerateKode("JKK");
	$kptt_nota->firstRow();
	$tempNoBukti = $kptt_nota->getField("NO_NOTA");	
	$tempTahun = date("Y");
	$tempBulan = "";
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
	$tempTahun=  $kptt_nota->getField("BLN_BUKU");
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
}
$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
$kbbr_tipe_trans->selectByParams(array("KD_SUBSIS" => "KPT", "KD_JURNAL" => "JKK"));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    
	<script type="text/javascript">
		function setValue(){
			//$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/pembatalan_pelunasan_add_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);

					data = data.split("-");
					document.location.href = 'proses_pelunasan_kas_bank_add_data.php?reqId=<?=$reqId?>';					
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
		
		$("#reqKdBukuBesar").keypress(function(e) {
			  return true;
		});
		
		$("#reqKdBukuBesar").keyup(function(e) {		
		  $.getJSON("../json-keuangansiuk/get_bb_kas_json.php?reqKdBukuBesarId="+$("#reqKdBukuBesar").val(),
		  function(data){
			  $("#reqNmBukuBesar").val(data.NM_BUKU_BESAR);
			  
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
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Transaksi Pembatalan Pelunasan Nota Tagih</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>No Bukti</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoBukti?>" />
			</td>
            <td>No Bukti Dikoreksi</td>
			 <td>
				<input name="reqNoBuktiDikoreksi" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoBuktiDikoreksi?>" />
			</td>
        </tr>
        <tr>
        	<td>Tipe Transaksi</td>
			 <td>
             	<select name="reqTipeTransaksi" id="reqTipeTransaksi">
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
                <input id="reqTahun" name="reqTahun" type="hidden" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:80px" value="<?=$tempTahun?>" />
                &nbsp;&nbsp;
                <input id="reqBulan" name="reqBulan" type="hidden" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px" value="<?=$tempBulan?>" />
			</td>
            <td>BB Kas / Bank</td>
			 <td>
				<input name="reqKdBukuBesar" id="reqKdBukuBesar" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKdBukuBesar?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqNmBukuBesar" id="reqNmBukuBesar" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempNmBukuBesar?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoPelanggan?>" onKeyDown="openPopup('PELANGGAN');" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempPelanggan?>" readonly />
			</td>
            <td>No Chq/Bukti</td>
            <td>
            	<input name="reqNoChqBukti" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempNoChqBukti?>" />
            </td>
        </tr>
        <tr>           
             <td>No Ref</td>
			 <td>
             	<input name="reqNoRef" class="easyui-validatebox" style="width:340px" type="text" value="<?=$tempNoRef?>" />
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
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
            <td>Nilai Transaksi</td>
            <td>
    	        <input id="reqNilaiTransaksi" name="reqNilaiTransaksi" class="easyui-validatebox" style="width:140px" OnFocus="FormatAngka('reqNilaiTransaksi')" OnKeyUp="FormatUang('reqNilaiTransaksi')" OnBlur="FormatUang('reqNilaiTransaksi')" value="<?=numberToIna($tempNilaiTransaksi)?>"  />
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>
			<td>
                <input name="reqKeterangan" class="easyui-validatebox" style="width:350px" type="text" value="<?=$tempKeterangan?>" />
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