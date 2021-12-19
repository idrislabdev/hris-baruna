<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Bank.php");

$bank = new Bank();

$reqId = httpFilterGet("reqId");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$bank->selectByParams(array('BANK_ID'=>$reqId), -1, -1);
	$bank->firstRow();
	
	$tempNama= $bank->getField('NAMA');
	$tempAlamat= $bank->getField('ALAMAT');
	$tempKota= $bank->getField('KOTA');
	$tempKodeBukuBesar = $bank->getField('KODE_BUKU_BESAR');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
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
				url:'../json-simpeg/bank_add.php',
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
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
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
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Bank</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Nama</td>
			 <td>
				<input name="reqNama" class="easyui-validatebox" required style="width:170px" type="text" value="<?=$tempNama?>" />
			</td>			
        </tr>
        <tr>           
             <td>Alamat</td>
			 <td>
				<input name="reqAlamat" class="easyui-validatebox" required style="width:170px" type="text" value="<?=$tempAlamat?>" />
			</td>			
        </tr>
        <tr>           
             <td>Kota</td>
			 <td>
				<input name="reqKota" class="easyui-validatebox" required style="width:170px" type="text" value="<?=$tempKota?>" />
			</td>			
        </tr>                
        <tr>           
             <td>Kode Buku Besar</td>
			 <td>
				<input name="reqKodeBukuBesar" class="easyui-validatebox" required style="width:170px" type="text" value="<?=$tempKodeBukuBesar?>" />
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