<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
//include_once("../WEB-INF/classes/base-keuangan/Bank.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmBank.php");

$safm_bank = new SafmBank();

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
	//$safm_bank->selectByParams(array('BANK_ID'=>$reqId), -1, -1);
	$safm_bank->selectByParams(array('MBANK_KODE'=>$reqId), -1, -1);
	
	$safm_bank->firstRow();
	$tempKode= $safm_bank->getField('MBANK_KODE');
	$tempNama= $safm_bank->getField('MBANK_NAMA');
	$tempAlamat= $safm_bank->getField('MBANK_ALAMAT');
	$tempCabang= $safm_bank->getField('MBANK_CABANG');
	$tempKodeBukuBesar= $safm_bank->getField('MBANK_KODE_BB');
	/*$tempNama= $safm_bank->getField('NAMA');
	$tempAlamat= $safm_bank->getField('ALAMAT');
	$tempKota= $safm_bank->getField('KOTA');
	$tempKodeBukuBesar= $safm_bank->getField('KODE_BUKU_BESAR');*/
	
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
				url:'../json-keuangansiuk/bank_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[data.length-1], 'info');
					//$.messager.alert('Info', data, 'info');
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Bank</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
    	<tr>           
             <td>Kode</td>
			 <td>
				<input name="reqKode" class="easyui-validatebox" required style="width:100px" type="text" value="<?=$tempKode?>" />
			</td>			
        </tr>
        <tr>           
             <td>Nama</td>
			 <td>
				<input name="reqNama" class="easyui-validatebox" required style="width:100px" type="text" value="<?=$tempNama?>" />
			</td>			
        </tr>
        <tr>
            <td>Alamat</td>
            <td>
                <textarea name="reqAlamat" style="width:250px; height:10 0px;"><?=$tempAlamat?></textarea>
            </td>
        </tr>
        <tr>           
             <td>Cabang</td>
			 <td>
				<input name="reqCabang" class="easyui-validatebox" required style="width:100px" type="text" value="<?=$tempCabang?>" />
			</td>			
        </tr>
		<tr>           
             <td>Kode&nbsp;Buku&nbsp;Besar</td>
			 <td>
				<input name="reqKodeBukuBesar" class="easyui-validatebox" required style="width:100px" type="text" value="<?=$tempKodeBukuBesar?>" />
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