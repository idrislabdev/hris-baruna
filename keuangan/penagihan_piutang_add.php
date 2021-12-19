<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/PenagihanPiutang.php");

$penagihan_piutang = new PenagihanPiutang();
	
if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	
	$reqMode = "update";	
	$penagihan_piutang->selectByParams(array("KODE"=>$reqId), -1, -1);
	$penagihan_piutang->firstRow();
	
	$tempKode = $penagihan_piutang->getField("KODE");
	$tempMplgKode = $penagihan_piutang->getField("MPLG_KODE");
	$tempMplgBadanUsaha = $penagihan_piutang->getField("MPLG_BADAN_USAHA");
	$tempJmlPiutang = $penagihan_piutang->getField("JUMLAH_PIUTANG");
	$tempTglTagih = $penagihan_piutang->getField("TGL_TAGIH");
	$tempMedia = $penagihan_piutang->getField("MEDIA");
	$tempKet = $penagihan_piutang->getField("KETERANGAN");
	$tempTglTagihBerikut = $penagihan_piutang->getField("TGL_TAGIH_BERIKUT");
	$tempAlamatPenagihan = $penagihan_piutang->getField("ALAMAT_PENAGIHAN");
	$tempKontakPerson = $penagihan_piutang->getField("KONTAK_PERSON");
	$tempTanggapan = $penagihan_piutang->getField("TANGGAPAN");
	
	
}
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
			$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/penagihan_piutang_add.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Penagihan Piutang</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Pelanggan</td>
             <td>
<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="hidden" value="<?=$tempMplgKode?>"  onKeyDown="openPopup('PELANGGAN');"/>           
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-combobox" style="width:295px" type="text" value="<?=$tempMplgKode?>"  data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/pelanggan_piutang_combo_json.php',
                     onSelect:function(rec){ 
                    	$('#reqNoPelanggan').val(rec.MPLG_KODE);
                    	$('#reqBadanUsaha').val(rec.MPLG_BADAN_USAHA);
                        $('#reqJumlahPiutang').val(rec.TOTAL_PIUTANG);
                    }
                    "
                      tabindex="3" onMouseDown="tabindex=3" /> 	         
                <input name="reqBadanUsaha" id="reqBadanUsaha" type="text" style="width:90px; background-color:#f0f0f0" value="<?=$tempMplgBadanUsaha?>" readonly>     
        		  &nbsp;&nbsp;
        
            </td>
        </tr>
        <tr>
            <td>Jumlah Piutang</td>
            <td>
                <input id="reqJumlahPiutang" name="reqJumlahPiutang" style="width:170px" type="text" value="<?=$tempJmlPiutang?>" onblur="FormatUang('reqJumlahPiutang')" onkeyup="FormatUang('reqJumlahPiutang')" onfocus="FormatAngka('reqJumlahPiutang')" />
            </td>
        </tr>
        <tr>
            <td>Tanggal Penagihan</td>
            <td>
                <input id="reqTglTagih" name="reqTglTagih" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTglTagih?>" tabindex="9" onMouseDown="tabindex=9"/>
            </td>
        </tr>
        <tr>
            <td>Media / Via</td>
            <td>
                <select name="reqMedia" id="reqMedia">
                 <option <? if ($tempMedia == "Telepon") echo "selected"; ?> value="Telepon">Telepon</option>
                 <option <? if ($tempMedia == "Surat") echo "selected"; ?> value="Surat">Surat</option>
                 <option <? if ($tempMedia == "Langsung") echo "selected"; ?> value="Langsung">On the spot (Penagihan secara langsung)</option>
                 </select>
            </td>
        </tr>
        <tr>
            <td>NoTelp/Alamat</td>
            <td><input id="reqAlamatPenagihan" name="reqAlamatPenagihan" value="<?=$tempAlamatPenagihan?>" tabindex="9" onMouseDown="tabindex=9"/></td>
        </tr>
        <tr>
            <td>Kontak Person</td>
            <td><input id="reqKontakPerson" name="reqKontakPerson" value="<?=$tempKontakPerson?>" tabindex="9" onMouseDown="tabindex=9"/></td>
        </tr>
        <tr>
            <td>Tanggapan</td>
            <td>
                <textarea id="reqTanggapan" name="reqTanggapan" cols="50" rows="3"><?=$tempTanggapan?></textarea>
            </td>
        </tr>
        <tr>
            <td>Hasil Penagihan</td>
            <td>
                <textarea id="reqKet" name="reqKet" cols="50" rows="5"><?=$tempKet?></textarea>
            </td>
        </tr>
        <tr>
            <td>Jadwal Penagihan Berikut</td>
            <td>
                <input id="reqTglTagihB" name="reqTglTagihB" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTglTagihBerikut?>" tabindex="9" onMouseDown="tabindex=9"/>
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