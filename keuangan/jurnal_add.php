<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
/*include_once("../WEB-INF/classes/base-keuangan/Jurnal.php");*/
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");

$jurnal = new KbbrGeneralRefD();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$jurnal->selectByParams(array('ID_REF_DATA'=>$reqId), -1, -1);
	$jurnal->firstRow();
	
	$tempIdRefData= $jurnal->getField('ID_REF_DATA');
	$tempNama= $jurnal->getField('KET_REF_DATA');
	$tempKeterangan= $jurnal->getField('KET_REF_DATA');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		var tempJURNAL="";
		
		function setValue(){
			$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
		$.fn.datebox.defaults.formatter = function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return d+'-'+m+'-'+y;
		}
		
		$.extend($.fn.validatebox.defaults.rules, {
			existIdRefDataJurnal:{
				validator: function(value, param){
					if($(param[0]).val() == "")
					{
						$.getJSON("../json-keuangansiuk/jurnal_add_lookup_json.php?reqIdRefData="+value,
						function(data){
							tempJURNAL= data.JURNAL;
						});
					}
					else
					{
						$.getJSON("../json-keuangansiuk/jurnal_add_lookup_json.php?reqIdRefDataTemp="+$(param[0]).val()+"&reqIdRefData="+value,
						function(data){
							tempJURNAL= data.JURNAL;
						});
					}
					 
					 if(tempJURNAL == '')
					 	return true;
					 else
					 	return false;
				},
				message: 'Kode jurnal, sudah ada.'
			}  
		});
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/jurnal_add.php',
				onSubmit:function(){
					if($("#reqKeterangan").val() == "")
					{
						$.messager.alert('Info', 'Isi keterangan terlebih dahulu.', 'info');	
						return false;
					}
					else
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Parameter Jenis Jurnal</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Jurnal</td>
			 <td>
             	<input type="hidden" name="reqIdRefDataTemp" id="reqIdRefDataTemp" value="<?=$tempIdRefData?>" >
                <input name="reqIdRefData" id="reqIdRefData" class="easyui-validatebox" validType="existIdRefDataJurnal['#reqIdRefDataTemp']" required size="20" style="width:80px" type="text" value="<?=$tempIdRefData?>" />
			</td>			
        </tr>
			<?php /*?><tr>
            <td>Nama</td>
            <td>
            <input name="reqNama" required style="width:170px" type="text" value="<?=$tempNama?>" />
            </td>
            </tr>   
			<?php */?>
        <tr>
            <td>Keterangan</td>
            <td>
                <textarea id="reqKeterangan" name="reqKeterangan" style="width:250px;  height:10 0px;"><?=$tempKeterangan?></textarea>
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