<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/TunjanganMengajar.php");

$tunjangan_mengajar = new TunjanganMengajar();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$tunjangan_mengajar->selectByParams(array("PEGAWAI_ID" => $reqId));
	$tunjangan_mengajar->firstRow();
	$tempMengajar = $tunjangan_mengajar->getField('PEGAWAI_ID');
	$tempPeriode = $tunjangan_mengajar->getField('PERIODE');
    $tempJumlahIntra  = $tunjangan_mengajar->getField("JUMLAH_JAM_INTRA");
    $tempJumlahEskul  = $tunjangan_mengajar->getField("JUMLAH_JAM_ESKUL");
    $tempJumlahLebih  = $tunjangan_mengajar->getField("JUMLAH_JAM_LEBIH");
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
				url:'../json-gaji/tunjangan_mengajar_add.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Honorium Mengajar</span>
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
            <td>Kelompok Pegawai</td>
            <td>
                <input name="reqKelompok" class="easyui-validatebox" required="true" title="Kelas harus diisi" style="width:20px;" type="text" value="<?=$tempKelompok?>" />
            </td>
        </tr>
        <tr>
            <td>Periode</td>
            <td>
                <input name="reqPeriode" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempPeriode)?>" id="reqPeriode"  OnFocus="FormatAngka('reqPeriode')" OnKeyUp="FormatUang('reqPeriode')" OnBlur="FormatUang('reqPeriode')"  />
            </td>
        </tr>  
        <tr>
            <td>Jumlah Jam Intra</td>
            <td>
                <input name="reqJumlahIntra" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempJumlahIntra)?>" id="reqJumlahIntra"  OnFocus="FormatAngka('reqJumlahIntra')" OnKeyUp="FormatUang('reqJumlahIntra')" OnBlur="FormatUang('reqJumlahIntra')"  />
            </td>
        </tr>  
        <tr>
            <td>Jumlah Jam Ekstra</td>
            <td>
                <input name="reqJumlahEkstra" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempJumlahEskul)?>" id="reqJumlahEskul"  OnFocus="FormatAngka('reqJumlahEskul')" OnKeyUp="FormatUang('reqJumlahEskul')" OnBlur="FormatUang('reqJumlahEskul')"  />
            </td>
        </tr>  
        <tr>
            <td>Jumlah Jam Lebih </td>
            <td>
                <input name="reqJumlahLebih" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempJumlahLebih)?>" id="reqJumlahLebih"  OnFocus="FormatAngka('reqJumlahLebih')" OnKeyUp="FormatUang('reqJumlahLebih')" OnBlur="FormatUang('reqJumlahLebih')"  />
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