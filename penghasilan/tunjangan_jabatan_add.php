<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/TunjanganJabatan.php");

$tunjangan_jabatan = new TunjanganJabatan();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$tunjangan_jabatan->selectByParams(array("TUNJANGAN_JABATAN_ID" => $reqId));
	$tunjangan_jabatan->firstRow();
	$tempJabatan = $tunjangan_jabatan->getField('JABATAN_ID');
	$tempJenisPegawai = $tunjangan_jabatan->getField('JENIS_PEGAWAI_ID');
    $tempJumlah  = $tunjangan_jabatan->getField("JUMLAH");
	$tempKelas  = $tunjangan_jabatan->getField("KELAS");
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
			$('#ccJabatan').combotree('setValue', '<?=$tempJabatan?>');
		}	
		$(function(){
			$('#ff').form({
				url:'../json-gaji/tunjangan_jabatan_add.php',
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
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Tunjangan Jabatan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <!-- <tr>
            <td>Jabatan</td>
            <td>
            	<input id="ccJabatan" class="easyui-combotree"  required="true" name="reqJabatan" data-options="url:'../json-simpeg/jabatan_combo_json.php'" style="width:300px;">
            </td>
        </tr> -->
        <tr>
            <td>Kelas</td>
            <td>
                <input name="reqKelas" class="easyui-validatebox" required="true" title="Kelas harus diisi" style="width:20px;" type="text" value="<?=$tempKelas?>" />
            </td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td>
                <input name="reqJumlah" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempJumlah)?>" id="reqJumlah"  OnFocus="FormatAngka('reqJumlah')" OnKeyUp="FormatUang('reqJumlah')" OnBlur="FormatUang('reqJumlah')"  />
            </td>
        </tr>      
        <!-- <tr>
        <td>Jenis Pegawai</td>
        	<td>
                <select id="JenisPegawai" class="easyui-combotree" data-options="onCheck:onCheckJenisPegawai,url:'../json-gaji/jenis_pegawai_combo_json.php?reqJenisId=<?=$tempJenisPegawai?>',onlyLeafCheck:true,checkbox:true,cascadeCheck:true" multiple style="width:300px;"></select> 
				<script>
                    function onCheckJenisPegawai(v){
                        var s = $('#JenisPegawai').combotree('getText');
						var k = s.replace("Organik","1").replace("Perbantuan","2").replace("PKWT","3").replace("PTTPK","5");
						
                        document.getElementById('reqJenisPegawai').value =  k;
                        }
                </script> 
                <input type="hidden" id="reqJenisPegawai" name="reqJenisPegawai" value="<?=$tempJenisPegawai?>">
           
            </td>
        </tr> -->          
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