<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriode.php");
$gaji_periode = new GajiPeriode();

$gaji_periode->selectByParams(array(),-1,-1,"","ORDER BY GAJI_PERIODE_ID DESC");
while($gaji_periode->nextRow())
{
    $arrPeriode[] = $gaji_periode->getField("PERIODE"); 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<script type="text/javascript">
		function setValue(){
			$('#ccMengajar').combotree('setValue', '<?=$tempMengajar?>');
		}	
		$(function(){
			$('#ff').form({
				url:'../json-gaji/integrasi_tunjangan_import.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info'); return false;
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});

            $("#reqBultah").change(function() { 
                $("#reqPeriode").val($("#reqBultah").val());
            });
		});

        function downloadForm()
        {
            window.open("import_tunjangan_template_excel.php", '_blank');
        }
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Honorium Mengajar</span>
    </div>
    <form id="ff" method="post" novalidate enctype="multipart/form-data">
    <table>
        <tr>
            <td>Periode</td>
            <td>
                <select name="reqBultah" id="reqBultah">
                <option value="0"></option>
                <?
                for($i=0;$i<count($arrPeriode);$i++)
                {
                ?>
                    <option value="<?=$arrPeriode[$i]?>" <? if($reqPeriode == $arrPeriode[$i]) { ?> selected <? } ?>><?=getNamePeriode($arrPeriode[$i])?></option>
                <?      
                }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Download</td>
            <td>
                <a onClick="downloadForm()" style="cursor: pointer;">Download Template</a>
            </td>
        </tr>  
        <tr>
            <td>Upload</td>
            <td>
                <input class="easyui-validatebox col-md-4" type="file" name="reqLinkFile" value="<?=$reqLinkFile?>"  style="width:100%" >
            </td>
        </tr>
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="hidden" id="reqPeriode" name="reqPeriode" value="">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>