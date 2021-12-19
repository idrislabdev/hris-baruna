<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/JamKerja.php");
include_once("../WEB-INF/classes/base-absensi/JamKerjaJenis.php");

$jam_kerja = new JamKerja();
$jam_kerja_jenis = new JamKerjaJenis();

$reqId = httpFilterGet("reqId");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$jam_kerja->selectByParams(array('JAM_KERJA_ID'=>$reqId), -1, -1);
	$jam_kerja->firstRow();
	
	$tempNama= $jam_kerja->getField('NAMA');
	$tempJamAwal= $jam_kerja->getField('JAM_AWAL');
	$tempJamAkhir= $jam_kerja->getField('JAM_AKHIR');
	$tempTerlambatAwal= $jam_kerja->getField('TERLAMBAT_AWAL');
	$tempTerlambatAkhir= $jam_kerja->getField('TERLAMBAT_AKHIR');
	$tempJamKerjaJenisId= $jam_kerja->getField('JAM_KERJA_JENIS_ID');
}

$jam_kerja_jenis->selectByParams();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="../WEB-INF/lib/colorpicker/js/jquery/jquery.js"></script>
    
    <!--warna-->
	<script src="../WEB-INF/lib/colorpicker/jquery.colourPicker.js" type="text/javascript"></script>
	<link href="../WEB-INF/lib/colorpicker/jquery.colourPicker.css" rel="stylesheet" type="text/css">
    <!--warna-->   
    
	<script type="text/javascript">
		function setValue(){
			$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
		$.fn.datebox.defaults.formatter = function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return d+'-'+m+'-'+y;
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-absensi/jam_kerja_add.php',
				onSubmit:function(){
					return $(this).form('validate');
					//return $(this).form('novalidate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
		});
		
		$.extend($.fn.validatebox.defaults.rules, {  
			BandingJam: {
				validator: function(value, param){
					var start = value;
					var end = $(param[0]).val();
					var dtStart = new Date("1/1/2007 " + start);
					var dtEnd = new Date("1/1/2007 " + end);
					
					if(dtEnd < dtStart) 	return true;
					else 					return false;
					//return value.length >= param[0];
				},
				message: 'Menit akhir lebih besar / sama dengan menit awal '
			}  
		});
			
		$(document).ready(function(){ jQuery('select[name="reqWarna"]').colourPicker({ ico:    '../WEB-INF/lib/colorpicker/jquery.colourPicker.gif',  title:    true });});
	</script>
    
    <script language="Javascript">
	<? include_once "../jslib/formHandler.php"; ?>
	</script>
    
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script> 

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
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Jam Kerja</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Jenis Jam Kerja</td><td>:</td>
			 <td>
                <select name="reqJamKerjaJenis">
                <? while($jam_kerja_jenis->nextRow()){?>     
                    <option value="<?=$jam_kerja_jenis->getField('JAM_KERJA_JENIS_ID')?>" <? if($tempJamKerjaJenisId == $jam_kerja_jenis->getField('JAM_KERJA_JENIS_ID')) echo 'selected'?>> <?=$jam_kerja_jenis->getField('NAMA')?></option>
                <? }?>
                </select>  
			</td>			
        </tr>
        <tr>           
             <td>Nama</td><td>:</td>
			 <td>
				<input name="reqNama" class="easyui-validatebox" required="true" style="width:170px" type="text" value="<?=$tempNama?>" />
			</td>			
        </tr>
        <tr>           
             <td>Jam Awal</td><td>:</td>
			 <td>
             	<input class="easyui-timespinner" name="reqJamAwal" id="reqJamAwal" data-options="max:'23:59'" required="true" style="width:50px;" maxlength="5" value="<?=$tempJamAwal?>" onkeydown="return format_menit(event,'reqJamAwal');" />
				<?php /*?><input  id="reqJamAwal" name="reqJamAwal" class="easyui-validatebox" required="true" style="width:40px" type="text" value="<?=$tempJamAwal?>" maxlength="5" onkeydown="return format_menit(event,'reqJamAwal');"/><?php */?>
			</td>			
        </tr>
        <tr>           
             <td>Jam Akhir</td><td>:</td>
			 <td>
             	<input class="easyui-timespinner" name="reqJamAkhir" id="reqJamAkhir" validType="BandingJam['#reqJamAwal']" data-options="max:'23:59'" required="true" style="width:50px;" maxlength="5" value="<?=$tempJamAkhir?>" onkeydown="return format_menit(event,'reqJamAkhir');" />
				<?php /*?><input  id="reqJamAkhir" name="reqJamAkhir" class="easyui-validatebox" required="true" style="width:40px" type="text" value="<?=$tempJamAkhir?>" maxlength="5" onkeydown="return format_menit(event,'reqJamAkhir');"/><?php */?>
			</td>			
        </tr>
        <tr>           
             <td>Terlambat Awal</td><td>:</td>
			 <td>
             	<input class="easyui-timespinner" name="reqTerlambatAwal" id="reqTerlambatAwal" data-options="max:'23:59'" required="true" style="width:50px;" maxlength="5" value="<?=$tempTerlambatAwal?>" onkeydown="return format_menit(event,'reqTerlambatAwal');" />
				<?php /*?><input  id="reqTerlambatAwal" name="reqTerlambatAwal" class="easyui-validatebox" required="true" style="width:40px" type="text" value="<?=$tempTerlambatAwal?>" maxlength="5" onkeydown="return format_menit(event,'reqTerlambatAwal');"/>				<?php */?>
			</td>			
        </tr>
        <tr>           
             <td>Terlambat Akhir</td><td>:</td>
			 <td>
             	<input class="easyui-timespinner" name="reqTerlambatAkhir" id="reqTerlambatAkhir" validType="BandingJam['#reqTerlambatAwal']" data-options="max:'23:59'" required="true" style="width:50px;" maxlength="5" value="<?=$tempTerlambatAkhir?>" onkeydown="return format_menit(event,'reqTerlambatAkhir');" />
				<?php /*?><input  id="reqTerlambatAkhir" name="reqTerlambatAkhir" class="easyui-validatebox" required="true" style="width:40px" type="text" value="<?=$tempTerlambatAkhir?>" maxlength="5" onkeydown="return format_menit(event,'reqTerlambatAkhir');"/>	<?php */?>
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