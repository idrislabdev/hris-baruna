<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
include_once("../WEB-INF/classes/base-simpeg/Cabang.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
include_once("../WEB-INF/classes/base-simpeg/PejabatPenetap.php");

$pegawai = new Pegawai();
$pegawai_jabatan = new PegawaiJabatan();
$jabatan = new Jabatan();
$cabang = new Cabang();
$pejabat_penetap = new PejabatPenetap();
$departemen_cabang = new Departemen();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$pegawai_jabatan->selectByParams(array('PEGAWAI_JABATAN_ID'=>$reqRowId));
$pegawai_jabatan->firstRow();

$tempTanggal = dateToPageCheck($pegawai_jabatan->getField('TANGGAL_SK'));
$tempTMT = dateToPageCheck($pegawai_jabatan->getField('TMT_JABATAN'));
$tempNoSK = $pegawai_jabatan->getField('NO_SK');
$tempCabang = $pegawai_jabatan->getField('CABANG_ID');

$pegawai->selectByParams(array("A.PEGAWAI_ID" => $reqId));
$pegawai->firstRow();	
$tempDepartemenPegawai = $pegawai->getField('DEPARTEMEN_ID');
$tempDepartemen = $pegawai_jabatan->getField('DEPARTEMEN_ID');

if($tempDepartemen == '') 
	$tempDepartemen= $tempDepartemenPegawai;

$tempJabatan = $pegawai_jabatan->getField('JABATAN_ID');
//$tempNoUrut = $pegawai_jabatan->getField('');
//$tempKelas = $pegawai_jabatan->getField('');
$tempNama = $pegawai_jabatan->getField('NAMA');
$tempKeterangan = $pegawai_jabatan->getField('KETERANGAN');
$tempPejabat = $pegawai_jabatan->getField('PEJABAT_PENETAP_ID');
$tempRowId = $pegawai_jabatan->getField('PEGAWAI_JABATAN_ID');
$tempKondisiJabatan = $pegawai_jabatan->getField('KONDISI_JABATAN');

$jabatan->selectByParams();
$cabang->selectByParams();
$pejabat_penetap->selectByParams();

//check apakah sudah pernah entri, kalau sudah harus melalui proses apabila belum enable
$jumlah_entri = 0;//$pegawai_jabatan->getCountByParams(array("PEGAWAI_ID" => $reqId));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/bluetabs.css" />
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">

    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript">
		var tempTMT='';
		
		function setValue(){

			<?
			if($jumlah_entri > 0)
			{
			?>
			$("#ff :input").attr("disabled", true);
			$('#bluemenu').hide();
			<?
			}
			?>			
			
			$('#ccDepartemen').combotree('setValue', '<?=$tempDepartemen?>');
			$('#ccJabatan').combotree('setValue', '<?=$tempJabatan?>');
		}
		$.fn.datebox.defaults.formatter = function(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
		};
		$.extend($.fn.validatebox.defaults.rules, {
			date:{
				validator:function(value, param) {
					if(value.length == '10')
					{
						var reg = /^(\d{1,2})(-|\/)(\d{1,2})\2(\d{1,4})$/;
						return reg.test(value);
					}
					else
					{
						return false;
					}
				},
				message:"Format Tanggal: dd-mm-yyyy"
			}  
		});
	
		$.fn.datebox.defaults.parser = function(s) {
			if (s) {
				var a = s.split('-');
				var d = new Number(a[0]);
				var m = new Number(a[1]);
				var y = new Number(a[2]);
				var dd = new Date(y, m-1, d);
				return dd;
			} 
			else 
			{
				return new Date();
			}
		};
		
		$.extend($.fn.validatebox.defaults.rules, {
			existTMT:{
				validator: function(value, param){
					if(value.length == '10')
					{
						var reg = /^(\d{1,2})(-|\/)(\d{1,2})\2(\d{1,4})$/;
						if(reg.test(value) == true)
						{
							if($(param[0]).val() == "")
							{
								$.getJSON("../json-simpeg/pegawai_add_jabatan_tmt_json.php?reqId=<?=$reqId?>&reqTMT="+value,
								function(data){
									tempTMT= data.PEGAWAI_JABATAN_ID;
								});
							}
							else
							{
								$.getJSON("../json-simpeg/pegawai_add_jabatan_tmt_json.php?reqId=<?=$reqId?>&reqTMTTemp="+$(param[0]).val()+"&reqTMT="+value,
								function(data){
									tempTMT= data.PEGAWAI_JABATAN_ID;
								});
							}
							 
							 if(tempTMT == '')
								return true;
							 else
								return false;
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}
				},
				message: 'TMT Tanggal, sudah ada atau Format Tanggal belum sesuai: {dd-mm-yyyy}'
			}
		});
		
		$(function(){
			$('#ff').form({
				url:'../json-simpeg/pegawai_add_jabatan.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					
					parent.frames['mainFramePop'].location.href = 'pegawai_add_jabatan_monitoring.php?reqId=' + data[0];
					document.location.href = 'pegawai_add_jabatan.php?reqId=' + data[0] + '&reqRowId=' + data[2];				
				}				
			});
		});
		
	</script>
    
    <style>
	    .CodeMirror-scroll { height: 100%; overflow-x: auto;}
	</style>
    
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah" class="CodeMirror-scroll">
	<div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif); position:fixed; width:100%; margin-top:0px; zIndex: -1'"> 
        <ul>
            <li>
            <a href="#" onClick="$('#btnSubmit').click();">Simpan</a>
            </li>        
        <?
        if($reqRowId == "") {}
		else
		{
		?>
            <li>
            <a href="pegawai_add_jabatan.php?reqId=<?=$reqId?>">Batal</a>
            </li>        
        <?
		}
		?>
        </ul>
    </div>
    <form id="ff" method="post" novalidate style="margin-top:20px;">
    <table>
        <tr>
            <td>Jabatan</td>
            <td>
            	<input id="ccJabatan" class="easyui-combotree"  required="true" name="reqJabatan" data-options="panelHeight:'120',url:'../json-simpeg/jabatan_combo_v2_json.php/?reqPegawaiId=<?=$reqId?>'" style="width:300px;"><input name="reqKondisiJabatan" <? if ($tempKondisiJabatan==1) echo "checked";?> type="checkbox" value="1"> PJS
            </td>
        </tr>
        <tr>
            <td>Nomor SK</td>
            <td>
                <input name="reqNoSK" id="reqNoSK" class="easyui-validatebox" size="30" type="text" value="<?=$tempNoSK?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;
                Pejabat Penetap&nbsp;&nbsp;
                <select id="reqPejabat" name="reqPejabat">
                <? while($pejabat_penetap->nextRow()){?>
                	<option value="<?=$pejabat_penetap->getField('PEJABAT_PENETAP_ID')?>" <? if($tempPejabat == $pejabat_penetap->getField('PEJABAT_PENETAP_ID')) echo 'selected';?>><?=$pejabat_penetap->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tanggal SK</td>
            <td>
                <input id="dd" name="reqTanggal" class="easyui-datebox" data-options="validType:'date', panelHeight:'130'" value="<?=$tempTanggal?>"></input>
                &nbsp;&nbsp;&nbsp;
                Terhitung Mulai Tanggal (TMT)
                <input type="hidden" name="reqTMTTemp" id="reqTMTTemp" value="<?=$tempTMT?>">
                <input id="dd" name="reqTMT" class="easyui-datebox" data-options="panelHeight:'130'" validType="existTMT['#reqTMTTemp']" required value="<?=$tempTMT?>"></input>
            </td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td>
                <input id="ccDepartemen" class="easyui-combotree"  required="true" name="reqDepartemen" data-options="panelHeight:'88',url:'../json-simpeg/departemen_combo_json.php'" style="width:300px;">
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>
            	<textarea id="reqKeterangan" name="reqKeterangan" cols="60" class="easyui-validatebox" ><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <?php /*?><tr>
            <td>Pejabat Penetap</td>
            <td>
            	<select id="reqPejabat" name="reqPejabat">
                <? while($pejabat_penetap->nextRow()){?>
                	<option value="<?=$pejabat_penetap->getField('PEJABAT_PENETAP_ID')?>" <? if($tempPejabat == $pejabat_penetap->getField('PEJABAT_PENETAP_ID')) echo 'selected';?>><?=$pejabat_penetap->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
        </tr><?php */?>
    </table>
    	<div style="display:none">
        	<? if($tempRowId == ''){ $reqMode='insert'; }else{ $reqMode='update'; }?>
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqRowId" value="<?=$reqRowId?>">
            <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>