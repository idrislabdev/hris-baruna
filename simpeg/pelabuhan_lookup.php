<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/Pelabuhan.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

$pelabuhan = new Pelabuhan();

/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();  
}*/

$reqMode = httpFilterRequest("reqMode");

$reqSubmit= httpFilterPost("reqSubmit");
$reqId= httpFilterRequest("reqId");
$reqText = httpFilterPost("reqText");

if($reqText == "") {}
else
{
	$pelabuhan->setField("NAMA", $reqText);
	$pelabuhan->insert();
	echo "
	<script language=\"javascript\"> 
	window.parent.document.getElementById('reqJenisProgram').value = '".$reqText."';
	window.parent.document.getElementById('reqJenisProgramId').value = '".$pelabuhan->id."';
	window.parent.divwin.close();	
	</script>
	";
}


$pelabuhan->selectByParams();	

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
				url:'../json-intranet/departemen_add.php',
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
    
    <script type="text/javascript">
	function sendValue (s){
		var selvalue = s.value;
		var explode = selvalue.split('#');
		var varId = explode[0];
		var varNama = explode[1];
		var varKode = explode[2];
		//var varPenanggungJawab = explode[3];
		
		  
		
		window.parent.document.getElementById('reqAsalPelabuhanId').value = varId;
		window.parent.document.getElementById('reqAsalPelabuhan').value = varNama;
		window.parent.document.getElementById('reqAsalPelabuhanKode').value = varKode;
		//window.parent.document.getElementById('reqPenanggungJawab').value = varPenanggungJawab;
		window.parent.divwin.close();	
	}
	</script>
    
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Lookup Pelabuhan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
    	<tr>
            <th>Nama</th>
            <th>Kode</th>
            <th>Keterangan</th>         
            <th width="7%">Action</th>                                        
        </tr>
    	<?
            while($pelabuhan->nextRow())
            {
        ?> 
                <form name="selectform">
            <tr id="node-<?=$pelabuhan->getField('PELABUHAN_ID')?>">
                <td><?=$pelabuhan->getField('NAMA')?></td>
                <td><?=$pelabuhan->getField('KODE')?></td>
                <td><?=$pelabuhan->getField('KETERANGAN')?></td>
                <input type="hidden" name="data1" value="<?=$pelabuhan->getField('PELABUHAN_ID')?>#<?=$pelabuhan->getField('NAMA')?>#<?=$pelabuhan->getField('KODE')?>">
                <td align="center"><input type=button value="Pilih" onClick="sendValue(this.form.data1);"></td>
 				</form>
            </tr>
        <?php
            }
        ?>  
    </table>
    </form>
</div>
</body>
</html>