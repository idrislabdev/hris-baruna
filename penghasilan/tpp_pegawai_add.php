<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/TppPegawai.php");

$tpp_pegawai = new TppPegawai();
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$tpp_pegawai->selectByParams(array("TPP_PEGAWAI_ID" => $reqId));
	$tpp_pegawai->firstRow();

	$reqJabatanId = $tpp_pegawai->getField("JABATAN_ID");
	$reqDibayarLumpsum = $tpp_pegawai->getField("DIBAYAR_LUMPSUM");	
    $reqDibayarJam = $tpp_pegawai->getField("DIBAYAR_JAM");
    $reqTarifKelebihanReguler = $tpp_pegawai->getField("TARIF_KELEBIHAN_REGULER");
    $reqTarifKelebihanD3Kpnk = $tpp_pegawai->getField("TARIF_KELEBIHAN_D3_KPNK");
    $reqTunjanganDtReguler = $tpp_pegawai->getField("TUNJANGAN_DT_REGULER");
    $reqTunjanganDtD3Kpnk = $tpp_pegawai->getField("TUNJANGAN_DT_D3_KPNK");
    $reqTarifDlReguler = $tpp_pegawai->getField("TARIF_DL_REGULER");
    $reqTarifDlD3Kpnk = $tpp_pegawai->getField("TARIF_DL_D3_KPNK");
    $reqTarifJamWajib = $tpp_pegawai->getField("TARIF_JAM_WAJIB");
    $reqTarifJamTambahan = $tpp_pegawai->getField("TARIF_JAM_TAMBAHAN");
    $reqMinJamMengajar = $tpp_pegawai->getField("MIN_JAM_MENGAJAR");
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
				url:'../json-gaji/tpp_pegawai_add.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data TPP Pegawai</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr> 
            <td>Jabatan</td>
            <td>
                <input id="reqJabatanId" class="easyui-combotree" name="reqJabatanId" data-options="url:'../json-simpeg/jabatan_combo_json.php'" style="width:300px;" value="<?=$reqJabatanId?>">
            </td>
        </tr>
        <tr>
            <td>Dibayarkan secara lumpsum/ bulan</td>
            <td>
                <input name="reqDibayarLumpsum" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($reqDibayarLumpsum)?>" id="reqDibayarLumpsum"  OnFocus="FormatAngka('reqDibayarLumpsum')" OnKeyUp="FormatUang('reqDibayarLumpsum')" OnBlur="FormatUang('reqDibayarLumpsum')"  />
            </td>
        </tr> 
        <tr>
            <td>Dibayarkan sesuai jam TM/ bulan</td>
            <td>
                <input name="reqDibayarJam" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($reqDibayarJam)?>" id="reqDibayarJam"  OnFocus="FormatAngka('reqDibayarJam')" OnKeyUp="FormatUang('reqDibayarJam')" OnBlur="FormatUang('reqDibayarJam')"  />
            </td>
        </tr> 
        <tr>
            <td>Minimal Jam Mengajar</td>
            <td>
                <input name="reqMinJamMengajar" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($reqMinJamMengajar)?>" id="reqMinJamMengajar"  OnFocus="FormatAngka('reqMinJamMengajar')" OnKeyUp="FormatUang('reqMinJamMengajar')" OnBlur="FormatUang('reqMinJamMengajar')"  />
            </td>
        </tr> 
        <tr>
            <td>Tarif Jam Wajib</td>
            <td>
                <input name="reqTarifJamWajib" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($reqTarifJamWajib)?>" id="reqTarifJamWajib"  OnFocus="FormatAngka('reqTarifJamWajib')" OnKeyUp="FormatUang('reqTarifJamWajib')" OnBlur="FormatUang('reqTarifJamWajib')"  />
            </td>
        </tr> 
        <tr>
            <td>Tarif Jam Tambahan</td>
            <td>
                <input name="reqTarifJamTambahan" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($reqTarifJamTambahan)?>" id="reqTarifJamTambahan"  OnFocus="FormatAngka('reqTarifJamTambahan')" OnKeyUp="FormatUang('reqTarifJamTambahan')" OnBlur="FormatUang('reqTarifJamTambahan')"  />
            </td>
        </tr> 
        <tr>
            <td>Tarif Tambahan Reguler</td>
            <td>
                <input name="reqTarifKelebihanReguler" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($reqTarifKelebihanReguler)?>" id="reqTarifKelebihanReguler"  OnFocus="FormatAngka('reqTarifKelebihanReguler')" OnKeyUp="FormatUang('reqTarifKelebihanReguler')" OnBlur="FormatUang('reqTarifKelebihanReguler')"  />
            </td>
        </tr> 
        <tr>
            <td>Tarif Tambahan D3 KPNK</td>
            <td>
                <input name="reqTarifKelebihanD3Kpnk" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($reqTarifKelebihanD3Kpnk)?>" id="reqTarifKelebihanD3Kpnk"  OnFocus="FormatAngka('reqTarifKelebihanD3Kpnk')" OnKeyUp="FormatUang('reqTarifKelebihanD3Kpnk')" OnBlur="FormatUang('reqTarifKelebihanD3Kpnk')"  />
            </td>
        </tr> 
        <tr>
            <td>Tunjangan Dosen Reguler</td>
            <td>
                <input name="reqTunjanganDtReguler" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($reqTunjanganDtReguler)?>" id="reqTunjanganDtReguler"  OnFocus="FormatAngka('reqTunjanganDtReguler')" OnKeyUp="FormatUang('reqTunjanganDtReguler')" OnBlur="FormatUang('reqTunjanganDtReguler')"  />
            </td>
        </tr>
        <tr>
            <td>Tunjangan Dosen D3 KPNK</td>
            <td>
                <input name="reqTunjanganDtD3Kpnk" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($reqTunjanganDtD3Kpnk)?>" id="reqTunjanganDtD3Kpnk"  OnFocus="FormatAngka('reqTunjanganDtD3Kpnk')" OnKeyUp="FormatUang('reqTunjanganDtD3Kpnk')" OnBlur="FormatUang('reqTunjanganDtD3Kpnk')"  />
            </td>
        </tr>
        <tr>
            <td>Tarif per Jam Dosen Luar Reguler</td>
            <td>
                <input name="reqTarifDlReguler" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($reqTarifDlReguler)?>" id="reqTarifDlReguler"  OnFocus="FormatAngka('reqTarifDlReguler')" OnKeyUp="FormatUang('reqTarifDlReguler')" OnBlur="FormatUang('reqTarifDlReguler')"  />
            </td>
        </tr> 
        <tr>
            <td>Tarif per Jam Dosen Luar D3 KPNK</td>
            <td>
                <input name="reqTarifDlD3Kpnk" class="easyui-validatebox" required="true" title="Jumlah harus diisi" style="width:70px;" type="text" value="<?=numberToIna($reqTarifDlD3Kpnk)?>" id="reqTarifDlD3Kpnk"  OnFocus="FormatAngka('reqTarifDlD3Kpnk')" OnKeyUp="FormatUang('reqTarifDlD3Kpnk')" OnBlur="FormatUang('reqTarifDlD3Kpnk')"  />
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