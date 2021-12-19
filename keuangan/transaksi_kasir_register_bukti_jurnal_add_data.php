<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kbbt_jur_bb = new KbbtJurBb();
$safr_valuta = new SafrValuta();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";
	/*if($reqNoDokumenLain == "JKM")
	{
		$kbbt_jur_bb->selectByParamsGenerateKode("JKM");
		$kbbt_jur_bb->firstRow();
		$tempNoDokumen = $kbbt_jur_bb->getField("NO_NOTA");
	}
	else
	{
		$kbbt_jur_bb->selectByParamsGenerateKode("JKK");
		$kbbt_jur_bb->firstRow();
		$tempNoDokumen = $kbbt_jur_bb->getField("NO_NOTA");
	}*/
		
	$tempKursValuta = 1;
	$tempTahun = date("Y");
	$tempBulan = "";	
}
else
{
	$reqMode = "update";	
	$kbbt_jur_bb->selectByParams(array("A.TIPE_TRANS"=>$reqId, "NO_NOTA"=>$reqRowId), -1, -1);
	$kbbt_jur_bb->firstRow();
	
	$tempJKM = $kbbt_jur_bb->getField("");
	$tempNoJKM = $kbbt_jur_bb->getField("");
	$tempJKK = $kbbt_jur_bb->getField("");
	$tempNoJKK = $kbbt_jur_bb->getField("");
	$tempNoDokumen = $kbbt_jur_bb->getField("NO_NOTA");
	$tempNoDokumenLain = $kbbt_jur_bb->getField("JEN_JURNAL");
	$tempTanggalTransaksi = dateToPageCheck($kbbt_jur_bb->getField("TGL_TRANS"));
	$tempPerusahaan = $kbbt_jur_bb->getField("NM_AGEN_PERUSH");
	$tempAlamat = $kbbt_jur_bb->getField("ALMT_AGEN_PERUSH");
	$tempValutaNama = $kbbt_jur_bb->getField("KD_VALUTA");
	$tempKursValuta = numberToIna($kbbt_jur_bb->getField("KURS_VALUTA"));
	$tempKeterangan = $kbbt_jur_bb->getField("KET_TAMBAH");
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
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    
	<script type="text/javascript">
		function setValue(){
			//$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/transaksi_kasir_register_bukti_jurnal_add_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
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
		$("#reqNoDokumenLain").change(function() { 
		
		   if($("#reqNoDokumenLain").val() == "JKM")
		   		$("#reqNoDokumen").val('1');
				
				/*$kbbt_jur_bb->selectByParamsGenerateKode("JKM");
				$kbbt_jur_bb->firstRow();
				$reqNoDokumen = $kbbt_jur_bb->getField("NO_NOTA")*/
				
		   else
		   {
			  $("#reqNoDokumen").val('2');
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
					parent.OpenDHTML('pelanggan_pencarian.php', 'Pencarian Pelanggan', 900, 600);
				}
				return false;
			}
		});
		
	}
	function OptionSet(id, nama,alamat, npwp, badan_usaha){
		//document.getElementById('reqPerusahaan').value = id;
		document.getElementById('reqPerusahaan').value = nama;
		document.getElementById('reqAlamat').value = alamat;
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
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Register Jurnal (JKM)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
    	<tr>
        	<td colspan="2">
            	<input type="radio" name="reqJKM"> JKM
                <input name="reqNoJKM" class="easyui-validatebox" style="width:150px" type="text" value="<?=$tempNoJKM?>" />
                &nbsp;&nbsp;&nbsp;
                <input type="radio" name="reqJKK"> JKK
                <input name="reqNoJKK" class="easyui-validatebox" style="width:150px" type="text" value="<?=$tempNoJKK?>" />
            </td>
            <td>Valuta</td>
			<td>
                <select name="reqValutaNama" id="reqValutaNama">
                <?
                while($safr_valuta->nextRow())
				{
				?>
                	<option value="<?=$safr_valuta->getField("KODE_VALUTA")?>" <? if($safr_valuta->getField("KODE_VALUTA") == $tempValutaNama) { ?> selected <? } ?>><?=$safr_valuta->getField("NAMA_VALUTA")?></option>
                <?
				}
				?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
        <tr>           
             <td>No Dokumen</td>
			 <td>
				<input name="reqNoDokumen" id="reqNoDokumen" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoDokumen?>" />
                &nbsp;&nbsp;&nbsp
				<select name="reqNoDokumenLain" id="reqNoDokumenLain">
                	<option value="JKM" <? if($tempNoDokumenLain == "JKM") echo "selected";?>>JKM</option>
                    <option value="JKK" <? if($tempNoDokumenLain == "JKK") echo "selected";?>>JKK</option>
                </select>
			</td>
            <td>Kurs&nbsp;Valuta</td>
            <td>
                <input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKursValuta?>" readonly />
            </td>
        </tr>
        <tr>
        	 <td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input  type="hidden" id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:100px" value="<?=$tempTahun?>" />
                <input  type="hidden" id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:50px" value="<?=$tempBulan?>" />
			</td>
            <td rowspan="3">Keterangan</td>
            <td rowspan="3">
            	<textarea name="reqKeterangan" cols="50" rows="3"><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>           
             <td>Kepada</td>
			 <td>
				<input name="reqPerusahaan" id="reqPerusahaan" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempPerusahaan?>" onKeyDown="openPopup('PELANGGAN');" />
                &nbsp;&nbsp;&nbsp;&nbsp;
			</td>
        </tr>
        <tr>           
             <td>Alamat Agen Perusahaan</td>
			 <td>
             	<input name="reqAlamat" id="reqAlamat" class="easyui-validatebox" style="width:370px" type="text" value="<?=$tempAlamat?>" readonly />
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
</body>
</html>