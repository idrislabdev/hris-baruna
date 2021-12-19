<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/PegawaiKecualiJabatan.php");

$pegawai_kecuali_jabatan = new PegawaiKecualiJabatan();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$pegawai_kecuali_jabatan->selectByParamsMonitoring(array("PEGAWAI_KECUALI_JABATAN_ID" => $reqId));
	$pegawai_kecuali_jabatan->firstRow();
	
	$reqPegawaiId = $pegawai_kecuali_jabatan->getField('PEGAWAI_ID');
	$reqPegawaiNama = $pegawai_kecuali_jabatan->getField("PEGAWAI_NAMA");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../simpeg/js/globalfunction.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-gaji/pegawai_kecuali_jabatan_add.php',
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

         <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
    <script>
    
        function OptionSet(id, nrp,nama, jabatan, lama_cuti)
        {
            document.getElementById('reqNRP').value = nrp;
            document.getElementById('reqNama').value = nama;
            //document.getElementById('reqJabatan').value = jabatan;
            document.getElementById('reqPegawaiId').value = id;     
            //document.getElementById('reqCutiDiambil').value = lama_cuti;          
        }
        
        function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
        {
            var left = (screen.width/2)-(opWidth/2);
            //var left=50;
            
            divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
        }
        
        function openPencarianUser()
        {
            OpenDHTML('../simpeg/pegawai_pencarian.php', 'Pencarian User', 900, 700);   
        }
        
    </script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Pengecualian Tunjangan Jabatan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>             
        <tr>           
             <td>Nama</td>
             <td><input type="hidden" name="reqPegawaiId" id="reqPegawaiId" value="<?=$reqPegawaiId?>"/>
                <input name="reqNRP" id="reqNRP" class="easyui-validatebox" required style="width:80px" type="hidden" value="<?=$tempNRP?>" />
                <input name="reqNama" id="reqNama" class="easyui-validatebox" readonly style="width:200px" type="text" value="<?=$reqPegawaiNama?>" />
                &nbsp;&nbsp;
                <img src="../WEB-INF/images/group.png" onClick="openPencarianUser()">
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