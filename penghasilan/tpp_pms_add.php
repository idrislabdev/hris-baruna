<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/TppPMS.php");
$tpp_pms = new TppPMS();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$tpp_pms->selectByParams(array("TPP_PMS_ID" => $reqId));
	$tpp_pms->firstRow();
	$tempKelas = $tpp_pms->getField("KELAS");
    $tempTunjanganPrestasi = $tpp_pms->getField("TUNJANGAN_PRESTASI");
	$tempMinJamMengajar = $tpp_pms->getField("MIN_JAM_MENGAJAR");
    $tempTarifKelebihan = $tpp_pms->getField('TARIF_KELEBIHAN');
    $tempMaxKelebihan = $tpp_pms->getField('MAX_KELEBIHAN');
    $tempMaxPotongan = $tpp_pms->getField('MAX_POTONGAN');
	$tempKelompokPegawai = $tpp_pms->getField('KELOMPOK_PEGAWAI');

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
		$(function(){
			$('#ff').form({
				url:'../json-gaji/tpp_pms_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
                    //alert(data);return false;
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Tunjangan Kehadiran</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr> 
            <td>Kelompok Pegawai</td>
            <td>
                <input id="reqKelompokPegawai" class="easyui-combotree" name="reqKelompokPegawai" data-options="url:'../json-simpeg/kelompok_pegawai_combo_json.php'" style="width:300px;" value="<?=$tempKelompokPegawai?>">
            </td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>
                <input name="reqKelas" class="easyui-validatebox" required="true" title="Kelas harus diisi" style="width:20px;" type="text" value="<?=$tempKelas?>" />
            </td>
        </tr>
        <tr>
            <td>Tunjangan Prestasi / bulan</td>
            <td>
                <input name="reqTunjanganPrestasi" class="easyui-validatebox" required="true" title="Data harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempTunjanganPrestasi)?>" id="reqTunjanganPrestasi"  OnFocus="FormatAngka('reqTunjanganPrestasi')" OnKeyUp="FormatUang('reqTunjanganPrestasi')" OnBlur="FormatUang('reqTunjanganPrestasi')"  />
            </td>
        </tr>
        <tr>
            <td>Minimal Jam Mengajar</td>
            <td>
                <input name="reqMinJamMengajar" class="easyui-validatebox" required="true" title="Data harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempMinJamMengajar)?>" id="reqMinJamMengajar"  OnFocus="FormatAngka('reqMinJamMengajar')" OnKeyUp="FormatUang('reqMinJamMengajar')" OnBlur="FormatUang('reqMinJamMengajar')"  />
            </td>
        </tr>
        <tr>
            <td>Tarif Kelebihan Jam Mengajar</td>
            <td>
                <input name="reqTarifKelebihan" class="easyui-validatebox" required="true" title="Data harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempTarifKelebihan)?>" id="reqTarifKelebihan"  OnFocus="FormatAngka('reqTarifKelebihan')" OnKeyUp="FormatUang('reqTarifKelebihan')" OnBlur="FormatUang('reqTarifKelebihan')"  />
            </td>
        </tr>
        <tr>
            <td>Maks Kelebihan Jam Mengajar</td>
            <td>
                <input name="reqMaxKelebihan" class="easyui-validatebox" required="true" title="Data harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempMaxKelebihan)?>" id="reqMaxKelebihan"  OnFocus="FormatAngka('reqMaxKelebihan')" OnKeyUp="FormatUang('reqMaxKelebihan')" OnBlur="FormatUang('reqMaxKelebihan')"  />
            </td>
        </tr>
        <tr>
            <td>Maks Potongan Tidak Mengajar</td>
            <td>
                <input name="reqMaxPotongan" class="easyui-validatebox" required="true" title="Data harus diisi" style="width:70px;" type="text" value="<?=numberToIna($tempMaxPotongan)?>" id="reqMaxPotongan"  OnFocus="FormatAngka('reqMaxPotongan')" OnKeyUp="FormatUang('reqMaxPotongan')" OnBlur="FormatUang('reqMaxPotongan')"  />
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