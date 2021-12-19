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

if($reqId == "")
{
	$reqMode = "insert";	
	$tempKursValuta = 1;
	$kptt_nota->selectByParamsGenerateKode("JRR");
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
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota->getField("TGL_TRANS"));
	$tempTahun = $kptt_nota->getField("THN_BUKU");
	$tempBulan = $kptt_nota->getField("BLN_BUKU");
	$tempNoPelanggan = $kptt_nota->getField("KD_KUSTO");
	$tempPelanggan = $kptt_nota->getField("MPLG_NAMA");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempBuktiPendukung = $kptt_nota->getField("NO_REF1");
	$tempTanggalValuta = dateToPageCheck($kptt_nota->getField("TGL_VALUTA"));
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
}
$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
$arrValuta="";
$index=0;
while($safr_valuta->nextRow())
{
	$arrValuta[$index]["KODE_VALUTA"] = $safr_valuta->getField("KODE_VALUTA");
	$index++;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    
	<script type="text/javascript">
		function setValue(){
			parent.frames["mainFrameDetilPop"].document.getElementById("reqId").value = '<?=$tempNoBukti?>';
			parent.frames["mainFrameDetilPop"].document.getElementById("reqValutaNama").value = $("#reqValutaNama").val();
			parent.frames["mainFrameDetilPop"].document.getElementById("reqKursValuta").value = $("#reqKursValuta").val();
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/proses_kompensasi_sisa_super_add_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);
					//data = data.split("-");
					document.location.href = 'proses_kompensasi_sisa_super_add_data.php?reqId=<?=$reqId?>';
					//document.location.href = 'proses_kompensasi_sisa_super_add.php?reqId=<?=$reqId?>';
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
			//document.getElementById('reqAlamat').value = alamat;
			//document.getElementById('reqNPWP').value = npwp;
			//document.getElementById('reqBadanUsaha').value = badan_usaha;
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Kompensasi Nota Tagih</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>No Bukti</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoBukti?>" />
			</td>
            <td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Thn / Bln Buku
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:80px" value="<?=$tempTahun?>" />
                &nbsp;/&nbsp;
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px" value="<?=$tempBulan?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoPelanggan?>" onKeyDown="openPopup('PELANGGAN');" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempPelanggan?>" readonly />
            </td>
            <td>Valuta</td>
			<td>
            	<select name="reqValutaNama" id="reqValutaNama">
                <?
                //while($safr_valuta->nextRow())
				for($i=0; $i<$index;$i++)
				{
				?>
                <option value="<?=$arrValuta[$i]["KODE_VALUTA"]?>" <? if($arrValuta[$i]["KODE_VALUTA"] == $tempValutaNama) { ?> selected <? } ?>><?=$arrValuta[$i]["KODE_VALUTA"]?></option>
                <?php /*?><option value="<?=$safr_valuta->getField("KODE_VALUTA")?>" <? if($safr_valuta->getField("KODE_VALUTA") == $tempValutaNama) { ?> selected <? } ?>><?=$safr_valuta->getField("KODE_VALUTA")?></option><?php */?>
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
				<input name="reqBuktiPendukung" class="easyui-validatebox" style="width:300px" type="text" value="<?=$tempBuktiPendukung?>" />
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" class="easyui-datebox" data-options="validType:'date'" style="width:80px" value="<?=$tempTanggalValuta?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Kurs
                <input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKursValuta?>" readonly />
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