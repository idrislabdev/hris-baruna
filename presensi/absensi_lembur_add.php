<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/Lembur.php");

$lembur = new Lembur();

$reqId = httpFilterGet("reqId");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	

	$lembur->selectByParamsMonitoring(array('LEMBUR_ID'=>$reqId), -1, -1);
	$lembur->firstRow();
	
	$tempPegawaiId= $lembur->getField('PEGAWAI_ID');
	$tempNRP= $lembur->getField('NRP');
	$tempNama= $lembur->getField('NAMA_PEGAWAI');
	$tempDepartemenId= $lembur->getField('DEPARTEMEN_ID');
	$tempDepartemen= $lembur->getField('DEPARTEMEN');
	$tempLembur= $lembur->getField('LEMBUR');
	$tempKeterangan= $lembur->getField('KETERANGAN');
	$tempTanggalAwal= $lembur->getField('TANGGAL_AWAL_EDIT');
	$tempJamAwal= $lembur->getField('JAM_AWAL_EDIT');
	$tempTanggalAkhir= $lembur->getField('TANGGAL_AKHIR_EDIT');
	$tempJamAkhir= $lembur->getField('JAM_AKHIR_EDIT');
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
		}
		$.fn.datebox.defaults.formatter = function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return d+'-'+m+'-'+y;
		}			
		$(function(){
			$('#ff').form({
				url:'../json-absensi/absensi_lembur_add.php',
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

		$("#reqNRP").keypress(function(e) {
			var code = e.which;
			if(code==13){	
				$.getJSON("../json-absensi/get_pegawai.php?reqKode="+$("#reqNRP").val(),
				function(data){
					$("#reqNama").val(data.nama);
					$("#reqPegawaiId").val(data.pegawai_id);
					$("#reqDepartemen").val(data.departemen);
					$("#reqDepartemenId").val(data.departemen_id);
				});
			}
		});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <!--<script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script>--> 

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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Lembur</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>     
        <tr>           
             <td>NRP</td>
			 <td colspan="3">
             	<input type="hidden" name="reqPegawaiId" id="reqPegawaiId" value="<?=$tempPegawaiId?>"/>
				<input name="reqNRP" id="reqNRP" class="easyui-validatebox" required style="width:80px" type="text" value="<?=$tempNRP?>" />
                <span style="font-size:12px;"><strong><em>&nbsp;*tekan enter untuk pencarian data.</em></strong></span>
			</td>			
        </tr>
        <tr>           
             <td>Nama</td>
			 <td colspan="3">
				<input name="reqNama" id="reqNama" class="easyui-validatebox" readonly style="width:200px" type="text" value="<?=$tempNama?>" />
			</td>			
        </tr>
        <tr>
            <td>Departemen</td>
            <td colspan="3">
                <input type="hidden" name="reqDepartemenId" id="reqDepartemenId" value="<?=$tempDepartemenId?>"/>
                <input name="reqDepartemen" id="reqDepartemen" class="easyui-validatebox" readonly style="width:200px" type="text" value="<? if($tempDepartemen != "01"){ echo $tempDepartemen; }?>" />
            </td>
        </tr>
        <tr>           
             <td>Lembur</td>
			 <td colspan="3">
				<input name="reqLembur" id="reqLembur" class="easyui-validatebox" required style="width:200px" type="text" value="<?=$tempLembur?>" />
			</td>			
        </tr>
        <tr>
            <td>Keterangan</td>
            <td colspan="3">
                <textarea name="reqKeterangan" style="width:250px; height:10 0px;"><?=$tempKeterangan?></textarea>
            </td>
        </tr>                     
        <tr>
            <td>Tanggal Awal</td>
            <td>
				<input id="dd" name="reqTanggalAwal" class="easyui-datebox" required value="<?=$tempTanggalAwal?>"></input>                
            </td>
            <td>Jam Awal</td>
			<td>
				<input  id="reqJamAwal" name="reqJamAwal" class="easyui-validatebox" required style="width:40px" type="text" value="<?=$tempJamAwal?>" maxlength="5" onkeydown="return format_menit(event,'reqJamAwal');"/>
			</td>	            
        </tr>
        <tr>
            <td>Tanggal Akhir</td>
            <td>
				<input id="dd" name="reqTanggalAkhir" class="easyui-datebox" required value="<?=$tempTanggalAkhir?>"></input>                
            </td>
            <td>Jam Akhir</td>
			<td>
				<input  id="reqJamAkhir" name="reqJamAkhir" class="easyui-validatebox" required style="width:40px" type="text" value="<?=$tempJamAkhir?>" maxlength="5" onkeydown="return format_menit(event,'reqJamAkhir');"/>
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