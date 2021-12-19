<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBuku.php");

$tahun_pembukuan = new KbbrThnBuku();
$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";
	$tempPeriode= $reqPeriode;
}
else
{
	$reqMode = "update";	
	$tahun_pembukuan->selectByParams(array("THN_BUKU"=>$reqId), -1, -1);
	$tahun_pembukuan->firstRow();
	
	$tempTahun= $tahun_pembukuan->getField('THN_BUKU');
	$tempNama= $tahun_pembukuan->getField('NM_THN_BUKU');
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
		var tempTAHUN="";
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
			existTahun:{
				validator: function(value, param){
					if($(param[0]).val() == "")
					{
						$.getJSON("../json-keuangansiuk/tahun_pembukuan_lookup_json.php?reqTahun="+value,
						function(data){
							tempTAHUN= data.TAHUN;
						});
					}
					else
					{
						$.getJSON("../json-keuangansiuk/tahun_pembukuan_lookup_json.php?reqTahunTemp="+$(param[0]).val()+"&reqTahun="+value,
						function(data){
							tempTAHUN= data.TAHUN;
						});
					}
					 
					 if(tempTAHUN == '')
					 	return true;
					 else
					 	return false;
				},
				message: 'Tahun pembukuan, sudah ada.'
			}  
		});
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/tahun_pembukuan_add.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Tahun Buku Akuntansi</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Tahun</td>
            <td>
            	<input type="hidden" name="reqTahunTemp" id="reqTahunTemp" value="<?=$tempTahun?>" >
                <input name="reqTahun" id="reqTahun" class="easyui-validatebox" validType="existTahun['#reqTahunTemp']" required size="20" style="width:80px" type="text" value="<?=$tempTahun?>" />
            </td>
        </tr>    
        <tr>
            <td>Nama</td>
            <td>
                <input name="reqNama" required style="width:180px" type="text" value="<?=$tempNama?>" />
            </td>
        </tr>
    </table>
        <div>
            <input type="hidden" name="reqProgramNama" value="KBB_R_THN_BUKU_IMAIS">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
<script>
$("#reqTahun").keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>