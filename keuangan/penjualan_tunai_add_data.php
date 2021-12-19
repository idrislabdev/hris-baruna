<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kptt_nota = new KpttNota();
$safr_valuta = new SafrValuta();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

	
//echo $arrNoNota;

if($reqId == "")
{
	$reqMode = "insert";	
	$tempKursValuta = 1;
	$kptt_nota->selectByParamsGenerateKode("JKM");
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
	$tempNoNota = $kptt_nota->getField("NO_REF3");
	$tempNoBuktiLain = $kptt_nota->getField("NO_REF1");
	$tempNoBukuBesarKas = $kptt_nota->getField("KD_BANK");
	$tempBukuBesarKas = $kptt_nota->getField("BANK");
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
	$tempMaterai = $kptt_nota->getField("METERAI");
	$tempBadanUsaha = $kptt_nota->getField("BADAN_USAHA");
	
		
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempJumlahDiBayar = numberToIna($kptt_nota->getField("JUMLAH"));
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
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    
	<script type="text/javascript">
		function setValue(){
			parent.frames["mainFrameDetilPop"].document.getElementById("reqId").value = '<?=$tempNoBukti?>';
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/penjualan_tunai_add_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);
					data = data.split("-");
					document.location.href = 'penjualan_tunai_add_data.php?reqId=<?=$reqId?>';					
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
		
		$("#reqNoBukuBesarKas").keypress(function(e) {
			  return true;
		});
		
		$("#reqNoBukuBesarKas").keyup(function(e) {		
		  $.getJSON("../json-keuangansiuk/get_bank_json.php?reqNoBukuBesarKasId="+$("#reqNoBukuBesarKas").val(),
		  function(data){
			  $("#reqBukuBesarKas").val(data.MBANK_NAMA);
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
<body onLoad="setTimeout(setValue, 2000);">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Transaksi Penjualan Tunai (JKM)</span>
    </div>
    

    
    <form id="ff" method="post" novalidate>
    <table>
    	<tr>
        	<td colspan="4" align="right">
            No Bukti JKM
            &nbsp;&nbsp;&nbsp;
            <input name="reqNoBukti" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoBukti?>" />
            </td>
        </tr>
        <tr>           
             <td>No Nota</td>
			 <td>
				<input name="reqNoNota" id="reqNoNota" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoNota?>" onKeyUp="document.getElementById('reqNoBuktiLain').value = document.getElementById('reqNoNota').value" />
                &nbsp;&nbsp;&nbsp;&nbsp;
            	No Bukti Lain
				<input name="reqNoBuktiLain" id="reqNoBuktiLain" class="easyui-validatebox" style="width:100px" type="text" value="<?=$tempNoBuktiLain?>" />
			</td>
            <td>B. Besar Kas</td>
			 <td>
				<input name="reqNoBukuBesarKas" id="reqNoBukuBesarKas" class="easyui-validatebox" style="width:70px" type="text" value="<?=$tempNoBukuBesarKas?>" />
                <input name="reqBukuBesarKas" id="reqBukuBesarKas" class="easyui-validatebox" style="width:290px" type="text" value="<?=$tempBukuBesarKas?>" readonly />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoPelanggan?>" onKeyDown="openPopup('PELANGGAN');" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempPelanggan?>" readonly />
			</td>
            <td rowspan="4">Keterangan</td>
            <td rowspan="4">
            	<textarea name="reqKeterangan" rows="5" cols="48"><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>           
             <td>Alamat</td>
			 <td>
             	<input name="reqAlamat" id="reqAlamat" class="easyui-validatebox" style="width:370px" type="text" value="<?=$tempAlamat?>" readonly />
                <input name="reqBadanUsaha" id="reqBadanUsaha" type="hidden" value="<?=$tempBadanUsaha?>">
			</td>
        </tr>
        <tr>           
             <td>NPWP</td>
			 <td>
				<input name="reqNPWP" id="reqNPWP" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNPWP?>" readonly />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                %Pajak
                <input name="reqPersenPajak" id="reqPersenPajak" class="easyui-validatebox" style="width:130px" type="text" value="<?=$tempPersenPajak?>" />
			</td>
        </tr>
        <tr>
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Tahun Buku
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:100px" value="<?=$tempTahun?>" />
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px" value="<?=$tempBulan?>" />
			</td>
        </tr>
        <tr>
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
                Materai
               <select name="reqMaterai" id="reqMaterai">
            	<option value="1" <? if($tempMaterai == "1") echo "selected";?>>Ya</option>
                <option value="0" <? if($tempMaterai == "0") echo "selected";?>>Tidak</option>
           		</select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Kurs
                <input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKursValuta?>" readonly />
			</td>
            <td>Jumlah Di bayar</td>
            <td>
            	<input id="reqJumlahDiBayar" name="reqJumlahDiBayar" class="easyui-validatebox" style="width:140px" OnFocus="FormatAngka('reqJumlahDiBayar')" OnKeyUp="FormatUang('reqJumlahDiBayar')" OnBlur="FormatUang('reqJumlahDiBayar')" value="<?=numberToIna($tempJumlahDiBayar)?>"  />
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