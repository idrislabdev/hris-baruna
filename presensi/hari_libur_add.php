<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/HariLibur.php");

$hari_libur = new HariLibur();

$reqId = httpFilterGet("reqId");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$hari_libur->selectByParams(array('HARI_LIBUR_ID'=>$reqId), -1, -1);
	$hari_libur->firstRow();
	
	$tempStatusCutiBersama= $hari_libur->getField('STATUS_CUTI_BERSAMA');
	$tempNama= $hari_libur->getField('NAMA');
	$tempKeterangan= $hari_libur->getField('KETERANGAN');
	$tempTanggalAwal= dateToPageCheck($hari_libur->getField('TANGGAL_AWAL'));
	$tempTanggalAkhir= dateToPageCheck($hari_libur->getField('TANGGAL_AKHIR'));
	$tempTanggalFix= $hari_libur->getField('TANGGAL_FIX');
	$tempHari= substr($tempTanggalFix,0,2);
	$tempBulan= substr($tempTanggalFix,2,2);
	if($tempTanggalFix)	$tempPilih= 2;
	else				$tempPilih= 1;
}
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
			
			status=$('#reqPilih').val();
			if(status == 'Dinamis'){
				$('#reqTanggalAwal').addClass('required');
				$('#reqTanggalAkhir').addClass('required');
				$('#reqBulan').removeClass('required');
				$('#reqHari').removeClass('required');
				
				$('#reqBulan').val('');$('#reqHari').val('');
				
				$('#tr_tanggal_awal').show();
				$('#tr_tanggal_akhir').show();
				$('#tr_tanggal_fix').hide();
			}
			else if(status == 'Statis'){
				$('#reqTanggalAwal').removeClass('required');
				$('#reqTanggalAkhir').removeClass('required');
				$('#reqBulan').addClass('required');
				$('#reqHari').addClass('required');
				
				$('#reqTanggalAwal').val('');
				$('#reqTanggalAkhir').val('');
				
				$('#tr_tanggal_awal').hide();
				$('#tr_tanggal_akhir').hide();
				$('#tr_tanggal_fix').show();
				
			}			
		}
		$.fn.datebox.defaults.formatter = function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-absensi/hari_libur_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});


	;});

	function myformatter(date){
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		var d = date.getDate();
		return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;
	}
	
	function myparser(s){
		if (!s) return new Date();
		var ss = (s.split('-'));
		var y = parseInt(ss[0],10);
		var m = parseInt(ss[1],10);
		var d = parseInt(ss[2],10);
		if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
			return new Date(d,m-1,y);
		}
		else {
			return new Date();
		}
	}


	
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
<!--    <script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
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
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Hari Libur</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
    	<tr>
             <td>Pilih</td>
			 <td>
             	<? if ($reqId == ""){?>
                    <select name="reqPilih" id="reqPilih" onchange="setValue()">
                    <option <? if($tempPilih == 1) echo 'selected'?>>Dinamis</option>
                    <option <? if($tempPilih == 2) echo 'selected'?>>Statis</option>
                    </select>
                <? } else { ?>
                    <select name="reqPilih" id="reqPilih" disabled onchange="setValue()">
                    <option <? if($tempPilih == 1) echo 'selected'?>>Dinamis</option>
                    <option <? if($tempPilih == 2) echo 'selected'?>>Statis</option>
                    </select>
				<? } ?>
			</td>			
        </tr>
        <tr id="tr_tanggal_awal">    
            <td>Tanggal Awal</td>
            <td>
				<input id="dd" name="reqTanggalAwal" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" value="<?=$tempTanggalAwal?>"></input>                
            </td>
        </tr>  
         <tr id="tr_tanggal_akhir">
            <td>Tanggal Akhir</td>
            <td>
				<input id="dd" name="reqTanggalAkhir" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" value="<?=$tempTanggalAkhir?>"></input>                
            </td>
        </tr> 
        <tr id="tr_tanggal_fix">
             <td>Tanggal Fix</td>
			 <td>
                <select name="reqHari" id="reqHari">
                <option></option>
                <? for($i=1;$i<31;$i++){?>
                	<option value="<?=$i?>" <? if($i == $tempHari) echo 'selected';?>><?=$i?></option>
                <? }?>
                </select>
                &nbsp;&nbsp;
                <select name="reqBulan" id="reqBulan">
                <option></option>
                <? for($i=1;$i<=12;$i++){?>
                	<option value="<?=$i?>" <? if($i == $tempBulan) echo 'selected';?>><?=getNameMonth($i)?></option>
                <? }?>
                </select>
			</td>			
        </tr>                    
        <tr>           
             <td>Nama</td>
			 <td>
				<input name="reqNama" class="easyui-validatebox" required style="width:200px" type="text" value="<?=$tempNama?>" />
			</td>			
        </tr>
        <tr>
            <td>Keterangan</td>

            <td>
                <textarea name="reqKeterangan" style="width:250px; height:10 0px;"><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>
        	<td>Status Cuti Besama</td>
            <td><input type="checkbox" name="reqStatusCutiBersama" value="1" <? if($tempStatusCutiBersama == 1) { ?> checked <? } ?>></td>
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