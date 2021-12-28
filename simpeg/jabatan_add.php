<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
include_once("../WEB-INF/classes/base-simpeg/Pendidikan.php");

$jabatan = new Jabatan();
$pendidikan= new Pendidikan();

$reqId = httpFilterGet("reqId");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$jabatan->selectByParams(array('JABATAN_ID'=>$reqId), -1, -1);
	$jabatan->firstRow();
	
	$tempKode= $jabatan->getField('KODE');
	$tempNoUrut= $jabatan->getField('NO_URUT');
	$tempKelas= $jabatan->getField('KELAS');
	$tempNama= $jabatan->getField('NAMA');
	$tempStatus= $jabatan->getField('STATUS');
	$tempKelompok= $jabatan->getField('KELOMPOK');
	$tempPPH= $jabatan->getField('PPH');
	$tempNamaSlip = $jabatan->getField('NAMA_SLIP');
	$tempDepartemen= $jabatan->getField('DEPARTEMEN_ID');
	
	$tempKandidatPengalaman= $jabatan->getField('KANDIDAT_PENGALAMAN');
	$tempKandidatPendidikanKode= $jabatan->getField('KANDIDAT_PENDIDIKAN_KODE');
	$tempKandidatUsia= $jabatan->getField('KANDIDAT_USIA');
}

$pendidikan->selectByParams(array(),-1,-1, " AND KODE LIKE '%000'");
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
				url:'../json-simpeg/jabatan_add.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Jabatan</span> 
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Kode</td>
			 <td>
             	<input type="hidden" name="reqKelompok" value="D">
				<input name="reqKode" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKode?>" />
			</td>			
        </tr>
        <tr>           
             <td>No. Urut</td>
			 <td>
				<input name="reqNoUrut" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempNoUrut?>" />
			</td>			
        </tr>   
        <tr>           
             <td>Kelas</td>
			 <td>
				<input name="reqKelas" class="easyui-validatebox"   style="width:50px" type="text" value="<?=$tempKelas?>" />
			</td>			
        </tr>
        <!-- <tr>           
             <td>PPH</td>
			 <td>
				<input name="reqPPH" class="easyui-validatebox"  style="width:50px" type="text" value="<?=$tempPPH?>" />
			</td>			
        </tr> -->                        
        <tr>           
             <td>Nama</td>
			 <td>
				<input name="reqNama" class="easyui-validatebox" required style="width:170px" type="text" value="<?=$tempNama?>" />
			</td>			
        </tr>
        <tr>           
             <td>Nama pada Slip</td>
			 <td>
				<input name="reqNamaSlip" class="easyui-validatebox" required style="width:170px" type="text" value="<?=coalesce($tempNamaSlip, $tempNama)?>" />
			</td>			
        </tr>
        <tr>           
             <td>Kelompok</td>
			 <td>
			 	<select name="reqKelompok" id="reqKelompok">
			 		<option value="">&nbsp;</option>
			 		<option value="DOSEN" <? if($tempKelompok == "DOSEN") { echo "selected"; } ?>>Dosen</option>
			 		<option value="PENDIDIK" <? if($tempKelompok == "PENDIDIK") { echo "selected"; } ?>>Pendidik</option>
			 		<option value="STAFF" <? if($tempKelompok == "STAFF") { echo "selected"; } ?>>Staff</option>
			 	</select>
			</td>			
        </tr>
        <!-- <tr>
            <td>Status</td>
            <td>
                <input type="checkbox" <? if($tempStatus == '1') echo 'checked';?> name="reqStatus" value="1" />
            </td>
        </tr> -->   
        <tr>
            <td>Departemen</td>
            <td>
                <input id="reqDepartemen" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-simpeg/departemen_combo_json.php'" style="width:380px;" value="<?=$tempDepartemen?>">
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
$("#reqKandidatPengalaman,#reqKandidatUsia").keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>