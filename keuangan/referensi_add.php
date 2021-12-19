<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRef.php");

$referensi = new KbbrGeneralRef();

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
	$referensi->selectByParams(array('ID_REF_FILE'=>$reqId), -1, -1);
	$referensi->firstRow();
	
	$tempNama= $referensi->getField('ID_REF_FILE');
	$tempKeterangan= $referensi->getField('KET_REFERENCE');
	$tempStatus= $referensi->getField('KD_AKTIF');
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
		var tempNAMA='';
		
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
			existRefFileId:{
				validator: function(value, param){
					if($(param[0]).val() == "")
					{
						$.getJSON("../json-keuangansiuk/referensi_add_id_ref_json.php?reqNama="+value,
						function(data){
							tempNAMA= data.NAMA;
						});
					}
					else
					{
						$.getJSON("../json-keuangansiuk/referensi_add_id_ref_json.php?reqNamaTemp="+$(param[0]).val()+"&reqNama="+value,
						function(data){
							tempNAMA= data.NAMA;
						});
					}
					 
					 if(tempNAMA == '')
					 	return true;
					 else
					 	return false;
				},
				message: 'Kode Referensi, sudah ada.'
			}  
		});
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/referensi_add.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Tabel Referensi Umum</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Kode Header</td>
			 <td>
             	<input type="hidden" name="reqNamaTemp" id="reqNamaTemp" value="<?=$tempNama?>" >
                <input name="reqNama" id="reqNama" class="easyui-validatebox" validType="existRefFileId['#reqNamaTemp']" required size="20" style="width:180px" type="text" value="<?=$tempNama?>" />
			</td>			
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>
                <textarea name="reqKeterangan" style="width:250px; height:10 0px;"><?=$tempKeterangan?></textarea>
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
        	<input type="hidden" name="reqKodeCabang" value="11">
            <input type="hidden" name="reqJenisFile" value="R">
            <input type="hidden" name="reqIdFile" value="GENREF">
            <input type="hidden" name="reqProgramNama" value="KBB_R_GENERAL_REF_IMAIS">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>