<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");


$cuti_tahunan = new CutiTahunan();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$cuti_tahunan->selectByParams(array('B.CUTI_TAHUNAN_ID'=>$reqId), -1, -1, "", $reqPeriode);
	$cuti_tahunan->firstRow();
	
	//echo $cuti_tahunan->query;
	
	$tempNRP=$cuti_tahunan->getField('NRP'); 
	$tempNama=$cuti_tahunan->getField('NAMA');
	$tempJabatan=$cuti_tahunan->getField('JABATAN'); 
	$tempTanggal=dateToPageCheck($cuti_tahunan->getField('TANGGAL')); 
	$tempLamaCuti=$cuti_tahunan->getField('LAMA_CUTI'); 
	$tempTanggalAwal=dateToPageCheck($cuti_tahunan->getField('TANGGAL_AWAL')); 
	$tempTanggalAkhir=dateToPageCheck($cuti_tahunan->getField('TANGGAL_AKHIR'));
	$tempPegawaiId=$cuti_tahunan->getField('PEGAWAI_ID');
	$tempJenisPegawaiId=$cuti_tahunan->getField('JENIS_PEGAWAI_ID');
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
				url:'../json-simpeg/cuti_tahunan_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					top.frames['mainFrame'].location.reload();
					parent.frames['menuFramePop'].location.href = 'cuti_tahunan_add_menu.php?reqPeriode=<?=date("Y")?>&reqId=' + data[0];
					document.location.href = 'cuti_tahunan_add_data.php?reqPeriode=<?=date("Y")?>&reqId=' + data[0];	
				}
			});
		});
		function OptionSet(id, nrp,nama, jabatan, lama_cuti){
			document.getElementById('reqNRP').value = nrp;
			document.getElementById('reqNama').value = nama;
			document.getElementById('reqJabatan').value = jabatan;
			document.getElementById('reqPegawaiId').value = id;		
			//document.getElementById('reqCutiDiambil').value = lama_cuti;			
		}		

		$.extend($.fn.validatebox.defaults.rules, {
			existNRP:{
				validator: function(value, param){
					if(document.getElementById('reqNRP').value == '')
						return true;
					
					if(parseInt(document.getElementById('reqLamaCuti').value) + parseInt(document.getElementById('reqCutiDiambil').value) > 12)
					{
						return false;
					}
					
					return true;
				},
				message: 'Lama cuti melebihi batas yang telah ditentukan.'
			}  
		});
		
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <!-- POPUP WINDOW -->
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
	<script>
		function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			//var left=50;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
		}
		    
		function openPencarianUser()
		{
			OpenDHTML('pegawai_cuti_tahunan_pencarian.php', 'Pencarian User', 900, 700);	
		}
		
    </script>
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Permohonan Cuti Tahunan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>NRP</td>
            <td>
                <input id="reqNRP" name="reqNRP" class="easyui-validatebox" required size="45" type="text" value="<?=$tempNRP?>" />&nbsp;&nbsp;
                <img src="../WEB-INF/images/group.png" onClick="openPencarianUser()">
            </td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>
                <input id="reqNama" name="reqNama" class="easyui-validatebox" required size="50" type="text" value="<?=$tempNama?>" />&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>
                <input id="reqJabatan" name="reqJabatan" size="50" type="text" value="<?=$tempJabatan?>" />
            </td>
        </tr>
        <?php /*?><tr>
            <td>Tanggal Permohonan</td>
            <td>
                <input id="dd" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" required value="<?=$tempTanggal?>"></input>
            </td>
        </tr>
        <tr>
            <td>Lama Cuti</td>
            <td>
                <input id="reqLamaCuti" name="reqLamaCuti" size="8" type="text" maxlength="2" value="<?=$tempLamaCuti?>" class="easyui-validatebox" validType="existNRP" /> hari
                <input id="reqCutiDiambil" name="reqCutiDiambil" size="8" type="hidden" value="" /> 
                
                
            </td>
        </tr>
        <tr>
            <td>Tanggal Cuti</td>
            <td>
                <input id="dd" name="reqTanggalAwal" class="easyui-datebox" data-options="validType:'date'" required value="<?=$tempTanggalAwal?>"></input> s/d
                <input id="dd" name="reqTanggalAkhir" class="easyui-datebox" data-options="validType:'date'" required value="<?=$tempTanggalAkhir?>"></input>
            </td>
        </tr><?php */?>
       
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqPegawaiId" id="reqPegawaiId" value="<?=$tempPegawaiId?>">
            <input type="hidden" name="reqJenisPegawaiId" id="reqJenisPegawaiId" value="<?=$tempJenisPegawaiId?>">
            <input type="hidden" name="reqPeriode" id="reqPeriode" value="<?=$reqPeriode?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>