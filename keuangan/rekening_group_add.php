<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGroupRek.php");

$rekening_group = new KbbrGroupRek();

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
	$rekening_group->selectByParams(array('ID_GROUP'=>$reqId), -1, -1);
	$rekening_group->firstRow();
				
	$tempKode= $rekening_group->getField('ID_GROUP');
	$tempNama= $rekening_group->getField('NAMA_GROUP');
	$tempTipe= $rekening_group->getField('TIPE_NOREK');
	$tempRekeningMulai= $rekening_group->getField('MULAI_REKENING');
	$tempRekeningSampai= $rekening_group->getField('SAMPAI_REKENING');
	$tempStatus= $rekening_group->getField('KD_AKTIF');
	
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
		var tempIDGROUP="";
		
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
			existIdGroup:{
				validator: function(value, param){
					if($(param[0]).val() == "")
					{
						$.getJSON("../json-keuangansiuk/rekening_group_add_json.php?reqKode="+value,
						function(data){
							tempIDGROUP= data.IDGROUP;
						});
					}
					else
					{
						$.getJSON("../json-keuangansiuk/rekening_group_add_json.php?reqKodeTemp="+$(param[0]).val()+"&reqKode="+value,
						function(data){
							tempIDGROUP= data.IDGROUP;
						});
					}
					 
					 if(tempIDGROUP == '')
					 	return true;
					 else
					 	return false;
				},
				message: 'Tipe group, sudah ada.'
			}  
		});
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/rekening_group_add.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Ubah Data Group Kode Rekening (COA)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Tipe</td>
			 <td>
             	<input type="hidden" name="reqKodeTemp" id="reqKodeTemp" value="<?=$tempKode?>" >
                <input name="reqKode" id="reqKode" class="easyui-validatebox" validType="existIdGroup['#reqKodeTemp']" required size="20" readonly style="width:80px; background-color:#f0f0f0" type="text" value="<?=$tempKode?>" />
			</td>			
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>
                <input name="reqNama" required style="width:170px; background-color:#f0f0f0" readonly type="text" value="<?=$tempNama?>" />
            </td>
        </tr> 
          <tr>
            <td>No Tipe</td>
            <td>
                <input name="reqTipe" required style="width:30px; background-color:#f0f0f0" type="text" readonly value="<?=$tempTipe?>" />
            </td>
        </tr> 
        <tr>
            <td>Rekening Mulai</td>
            <td>
                <input name="reqRekeningMulai" required style="width:170px" type="text" value="<?=$tempRekeningMulai?>" />
            </td>
        </tr> 
        <tr>
            <td>Rekening Sampai</td>
            <td>
                <input name="reqRekeningSampai" required style="width:170px" type="text" value="<?=$tempRekeningSampai?>" />
            </td>
        </tr>         
        <tr>
            <td>Status</td>
            <td>
            	<select name="reqStatus" >
                	<option value="A" <? if($tempStatus == "A") echo "selected";?>>AKTIF</option>
                    <option value="" <? if($tempStatus == "") echo "selected";?>>TIDAK AKTIF</option>
                </select>
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