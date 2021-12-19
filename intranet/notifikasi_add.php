<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/Notifikasi.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$notifikasi = new Notifikasi();

$reqId = httpFilterGet("reqId");

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$notifikasi->selectByParams(array("NOTIFIKASI_ID" => $reqId));
	$notifikasi->firstRow();
	
	//$tempUserLogin= $notifikasi->getField("DEPARTEMEN_ID");
	$tempEmailUserTerkait= $notifikasi->getField("EMAIL_USER_TERKAIT");
	$tempNama= $notifikasi->getField("NAMA");
	$tempKeterangan= $notifikasi->getField("KETERANGAN");
	$tempKirim= $notifikasi->getField("KIRIM_HARI_MINUS");
	$tempUserLoginId= $notifikasi->getField("NOTIFIKASI_USER_LOGIN_ID");
	//echo $tempUserLoginId;
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
			$('#reqUserLogin').combogrid('setValues', [<?=$tempUserLoginId?>]);
		}
		$(function(){
			$('#ff').form({
				url:'../json-intranet/notifikasi_add.php',
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
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <!-- POPUP WINDOW -->
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
	<script>
		function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
		{
			//var left = (screen.width/2)-(opWidth/2);
			var left=50;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
		}
		    
    </script>
</head>
<body onload="setValue()">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Notifikasi</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Nama</td>
            <td>
                <input id="reqNama" name="reqNama" class="easyui-validatebox" size="50" type="text" value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
            <td>User Login</td>
            <td>
            	<select class="easyui-combogrid" id="reqUserLogin" name="reqUserLogin"
                data-options=" 
                panelWidth:500,
				idField: 'id',
				textField: 'text',  
				url:'../json-intranet/user_login_lookup_json.php',
				columns: [[  
					{field:'ck',checkbox:true,width:5},
					{field:'id',title:'User Id',width:50},
					{field:'text',title:'Nama',width:300},
                    {field:'email',title:'Email',width:345}
				]],
                onChange:function(record){
                    var id = $('#reqUserLogin').combogrid('getValues');
                    $('#reqUserLoginId').val(id);
                },  
            	fitColumns: true
                " style="width:500px" multiple="multiple">
                </select>
                <input type="hidden" id="reqUserLoginId" name="reqUserLoginId" >
                <!--fitColumns: true
                multiple: true,
                delay: 50,
    			mode: 'remote',
                -->
            </td>
        </tr>
        <tr>
        	<td>Email User terkait</td>
            <td>
            	<input type="checkbox" id="reqEmailUserTerkait" name="reqEmailUserTerkait" value="1" <? if($tempEmailUserTerkait == 1) echo "checked"; ?>>
            </td>
        </tr>
        <tr>
            <td>Kirim Hari Minus</td>
            <td>
                <input id="reqKirim" name="reqKirim" size="10" type="text" value="<?=$tempKirim?>" />
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>

            <td>
                <textarea name="reqKeterangan" title="Keterangan harus diisi" style="width:250px; height:10	0px;"><?=$tempKeterangan?></textarea>
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
<script>
$("#reqKirim").keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});

</script>

</body>
</html>