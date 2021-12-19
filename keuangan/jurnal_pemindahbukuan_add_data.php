<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$safr_valuta = new SafrValuta();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";
	$tempKursValuta = 1;	
	$kbbt_jur_bb_tmp->selectByParamsGenerateKode("JKM");
	$kbbt_jur_bb_tmp->firstRow();
	$tempNoBuktiSiuk = $kbbt_jur_bb_tmp->getField("NO_NOTA");	
	$tempTahun = date("Y");
	$tempBulan = "";	
}
else
{
	$reqMode = "update";	
	$kbbt_jur_bb_tmp->selectByParams(array("A.NO_NOTA"=>$reqId), -1, -1);
	$kbbt_jur_bb_tmp->firstRow();
	
	$tempNoBuktiSiuk = $kbbt_jur_bb_tmp->getField("NO_NOTA");
	$tempValutaNama = $kbbt_jur_bb_tmp->getField("KD_VALUTA");
	//$tempValutaNama = $kbbt_jur_bb_tmp->getField("NAMA_VALUTA");
	$tempBuktiPendukung = $kbbt_jur_bb_tmp->getField("NO_REF3");
	$tempKursValuta = numberToIna($kbbt_jur_bb_tmp->getField("KURS_VALUTA"));
	$tempTanggalTransaksi = dateToPageCheck($kbbt_jur_bb_tmp->getField("TGL_TRANS"));
	$tempKeterangan = $kbbt_jur_bb_tmp->getField("KET_TAMBAH");
	$tempPerusahaan = $kbbt_jur_bb_tmp->getField("NM_AGEN_PERUSH");
	$tempNoPosting = $kbbt_jur_bb_tmp->getField("NO_POSTING");
	$tempTanggalPosting = dateToPageCheck($kbbt_jur_bb_tmp->getField("TGL_POSTING"));
	$tempAlamat = $kbbt_jur_bb_tmp->getField("ALMT_AGEN_PERUSH");
	$tempBulan = $kbbt_jur_bb_tmp->getField("BLN_BUKU");
	$tempTahun = $kbbt_jur_bb_tmp->getField("THN_BUKU");

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
				url:'../json-keuangansiuk/jurnal_pemindahbukuan_add_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					
					data = data.split("-");
					document.location.href = 'jurnal_pemindahbukuan_add_data.php?reqId=<?=$reqId?>';					
					parent.frames["mainFrameDetilPop"].document.getElementById("btnSubmit").click();
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Jurnal Pemindah Bukuan (JKM)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>No&nbsp;Bukti&nbsp;(SIUK)</td>
			 <td>
				<input name="reqNoBuktiSiuk" class="easyui-validatebox" required style="width:170px" type="text" value="<?=$tempNoBuktiSiuk?>" />
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
             <td>Bukti&nbsp;Pendukung</td>
			 <td>
				<input name="reqBuktiPendukung" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempBuktiPendukung?>" />
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
                <input type="hidden" id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" value="<?=$tempBulan?>" />
                <input type="hidden" id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" value="<?=$tempTahun?>" />
			</td>
            <td>Keterangan</td>
			 <td>
				<input name="reqKeterangan" class="easyui-validatebox" style="width:200px" type="text" value="<?=$tempKeterangan?>" />
			</td>
        </tr>
        <tr>           
             <td>Agen&nbsp;/&nbsp;Perusahaan</td>
			 <td>
				<input name="reqPerusahaan" id="reqPerusahaan" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempPerusahaan?>" onKeyDown="openPopup('PELANGGAN');" />
                &nbsp;&nbsp;&nbsp;&nbsp;
			</td>
            <td>No / Tanggal Posting</td>
			 <td>
				<input name="reqNoPosting" class="easyui-validatebox" style="width:100px" type="text" value="<?=$tempNoPosting?>" />
                <input id="reqTanggalPosting" name="reqTanggalPosting" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalPosting?>" />
			</td>
        </tr>
        <tr>           
             <td>Alamat</td>
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