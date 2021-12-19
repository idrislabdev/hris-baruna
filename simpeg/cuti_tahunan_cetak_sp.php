<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");
include_once("../WEB-INF/classes/base/PenandaTangan.php");

$penanda_tangan = new PenandaTangan();

$cuti_tahunan_detil = new CutiTahunanDetil();
$reqId = httpFilterGet("reqId");

$cuti_tahunan_detil->selectByParamsCetak(array(), -1, -1, " AND TANGGAL_CETAK IS NULL ");
$id = "";
$i=0;
while($cuti_tahunan_detil->nextRow())
{
	$arrCuti[$i]["NRP"] = $cuti_tahunan_detil->getField("NRP");	
	$arrCuti[$i]["NAMA"] = $cuti_tahunan_detil->getField("NAMA");		
	$arrCuti[$i]["CUTI_TAHUNAN_DETIL_ID"]	 = $cuti_tahunan_detil->getField("CUTI_TAHUNAN_DETIL_ID");	
	
	if($id == "")
		$id = $cuti_tahunan_detil->getField("CUTI_TAHUNAN_DETIL_ID");
	else
		$id .= ",".$cuti_tahunan_detil->getField("CUTI_TAHUNAN_DETIL_ID");
	$i++;	
}

$penanda_tangan->selectByParams();
while($penanda_tangan->nextRow())
{
	$arrNama[] = $penanda_tangan->getField("NAMA");
	$arrJabatan[] = $penanda_tangan->getField("JABATAN");
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
				url:'../json-simpeg/cuti_tahunan_cetak_sp.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					//$('#rst_form').click();
					newWindow = window.open('cuti_tahunan_cetak_sp_cetak.php?reqId=<?=$id?>', 'Cetak');
				    newWindow.focus();
					top.frames['mainFrame'].location.reload();
				}
			});
			
		});
		$(document).ready( function () {
			  $("#reqNama1").change(function() { 
					$.getJSON("../json-intranet/penanda_tangan_combo.php?reqNama="+ $("#reqNama1").val(),
					function(data){
						$.each(data, function (i, SingleElement) {
							document.getElementById('reqJabatan1').value = SingleElement.JABATAN;	  
						});
					}); 
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
                <span><img src="../WEB-INF/images/panah-judul.png">Cetak Surat Perintah</span>
    </div>
    <?
    if(count($arrCuti) == 0)
	{
	?>
    	<p style="margin-left:30px;"><strong>Tidak ada permohonan.</strong></p>
    <?
	}
	else
	{
	?>    
    <form id="ff" method="post" novalidate>
    <table>
    <tr>
    	<th>NRP</th>
    	<th>Nama</th>
    	<th>Nomor Surat Ijin</th>
    </tr>
    <?
    for($i=0;$i<count($arrCuti);$i++)
	{
	?>
        <tr>           
			 <td><?=$arrCuti[$i]["NRP"]?></td>
    		 <td><?=$arrCuti[$i]["NAMA"]?></td>
    		 <td>             	
				<input name="reqCutiTahunanDetilId[]" style="width:170px" type="hidden" value="<?=$arrCuti[$i]["CUTI_TAHUNAN_DETIL_ID"]?>" />
				<input name="reqNotaDinas[]" class="easyui-validatebox" required style="width:170px" type="text" value="" />
			</td>			
        </tr>
    <?
	}
	?>        
    </table>
    <br>
    <br>
	<table>
    	<tr>
        	<th colspan="2" style="text-align:left">Penandatangan</th>
        </tr>
        <tr>
            <td>Nama</td>
            <td>
            	<select name="reqNama1" id="reqNama1">
            	<?
                for($i=0; $i<count($arrNama); $i++)
				{
				?>
                	<option value="<?=$arrNama[$i]?>" <? if($arrNama[$i] == $tempNama1) { ?> selected <? } ?>><?=$arrNama[$i]?></option>
                <?
				}
				?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>
            	<input id="reqJabatan1" name="reqJabatan1" class="easyui-validatebox" size="80" type="text" value="<?=$tempJabatan1?>" />
            </td>
        </tr>    
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Cetak">
            <input type="reset" id="rst_form">
        </div>
    </form>
    <?
	}
	?>
</div>
</body>
</html>