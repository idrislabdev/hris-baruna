<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base/Faq.php");

$faq = new Faq();
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$faq->selectByParams(array("FAQ_ID" => $reqId));
	$faq->firstRow();
	$tempPertanyaan = $faq->getField("PERTANYAAN");
	$tempJawaban 	= $faq->getField("JAWABAN");
	$tempNoUrut = $faq->getField("NO_URUT");	
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
		$(function(){
			$('#ff').form({
				url:'../json-intranet/faq_add.php',
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
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data FAQ</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>No. Urut</td>
            <td>
                <input name="reqNoUrut" class="easyui-validatebox" required="true" title="No. Urut harus diisi" size="5" type="text" value="<?=$tempNoUrut?>" />
            </td>
        </tr>
        <tr>
            <td>Pertanyaan</td>
            <td>
                <input name="reqPertanyaan" class="easyui-validatebox" required="true" title="Pertanyaan harus diisi" size="40" type="text" value="<?=$tempPertanyaan?>" />
            </td>
        </tr>
        <tr>
            <td>Jawaban</td>

            <td>
                <textarea name="reqJawaban" title="Jawaban harus diisi" style="width:250px; height:10	0px;"><?=$tempJawaban?></textarea>
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