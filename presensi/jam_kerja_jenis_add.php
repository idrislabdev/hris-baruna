<?
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-absensi/JamKerjaJenis.php");

$jam_kerja_jenis = new JamKerjaJenis();
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
	$jam_kerja_jenis->selectByParams(array("JAM_KERJA_JENIS_ID" => $reqId));
	$jam_kerja_jenis->firstRow();
	$tempNama 		= $jam_kerja_jenis->getField("NAMA");
	$tempKeterangan = $jam_kerja_jenis->getField("KETERANGAN");	
	$tempWarna 		= $jam_kerja_jenis->getField("WARNA");
	$tempKelompok 	= $jam_kerja_jenis->getField("KELOMPOK");	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>

    <!--warna-->
	<script src="../WEB-INF/lib/colorpicker/jquery.colourPicker.js" type="text/javascript"></script>
	<link href="../WEB-INF/lib/colorpicker/jquery.colourPicker.css" rel="stylesheet" type="text/css">
    <!--warna-->      
    
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-absensi/jam_kerja_jenis_add.php',
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
		$(document).ready(function(){ jQuery('select[name="reqWarna"]').colourPicker({ ico:    '../WEB-INF/lib/colorpicker/jquery.colourPicker.gif',  title:    true });});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Jenis Jam Kerja</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Nama</td>
            <td>
                <input name="reqNama" class="easyui-validatebox" required title="Nama harus diisi" size="40" type="text" value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>

            <td>
                <textarea name="reqKeterangan" title="Keterangan harus diisi" style="width:250px; height:10	0px;"><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>
            <td>Kelompok</td>
            <td>
                <select name="reqKelompok" id="reqKelompok">
                  <option value="5H" <? if($tempKelompok == "5H") echo "selected"; ?>>5H</option>
                  <option value="7H" <? if($tempKelompok == "7H") echo "selected"; ?>>7H</option>
                </select>
            </td>
        </tr>        
        <tr>
            <td>Warna</td>
            <td>
				<div id="jquery-colour-picker-example">
                <select name="reqWarna">
                    <option value="ffffff">#ffffff</option>
                    <option value="ffccc9">#ffccc9</option>
                    <option value="ffce93">#ffce93</option>
                    <option value="fffc9e">#fffc9e</option>
                    <option value="ffffc7">#ffffc7</option>
                    <option value="9aff99">#9aff99</option>
                    <option value="96fffb">#96fffb</option>
                    <option value="cdffff">#cdffff</option>
                    <option value="cbcefb">#cbcefb</option>
                    <option value="cfcfcf">#cfcfcf</option>
                    <option value="fd6864">#fd6864</option>
                    <option value="fe996b">#fe996b</option>
                    <option value="fffe65">#fffe65</option>
                    <option value="fcff2f">#fcff2f</option>
                    <option value="67fd9a">#67fd9a</option>
                    <option value="38fff8">#38fff8</option>
                    <option value="68fdff">#68fdff</option>
                    <option value="9698ed">#9698ed</option>
                    <option value="c0c0c0">#c0c0c0</option>
                    <option value="fe0000">#fe0000</option>
                    <option value="f8a102">#f8a102</option>
                    <option value="ffcc67">#ffcc67</option>
                    <option value="f8ff00">#f8ff00</option>
                    <option value="34ff34">#34ff34</option>
                    <option value="68cbd0">#68cbd0</option>
                    <option value="34cdf9">#34cdf9</option>
                    <option value="6665cd">#6665cd</option>
                    <option value="9b9b9b">#9b9b9b</option>
                    <option value="cb0000">#cb0000</option>
                    <option value="f56b00">#f56b00</option>
                    <option value="ffcb2f">#ffcb2f</option>
                    <option value="ffc702">#ffc702</option>
                    <option value="32cb00">#32cb00</option>
                    <option value="00d2cb">#00d2cb</option>
                    <option value="3166ff">#3166ff</option>
                    <option value="6434fc">#6434fc</option>
                    <option value="656565">#656565</option>
                    <option value="9a0000">#9a0000</option>
                    <option value="ce6301">#ce6301</option>
                    <option value="cd9934">#cd9934</option>
                    <option value="999903">#999903</option>
                    <option value="009901">#009901</option>
                    <option value="329a9d">#329a9d</option>
                    <option value="3531ff">#3531ff</option>
                    <option value="6200c9">#6200c9</option>
                    <option value="343434">#343434</option>
                    <option value="680100">#680100</option>
                    <option value="963400">#963400</option>
                    <option value="986536">#986536</option>
                    <option value="646809">#646809</option>
                    <option value="036400">#036400</option>
                    <option value="34696d">#34696d</option>
                    <option value="00009b">#00009b</option>
                    <option value="303498">#303498</option>
                    <option value="000000">#000000</option>
                    <option value="330001">#330001</option>
                    <option value="643403">#643403</option>
                    <option value="663234">#663234</option>
                    <option value="343300">#343300</option>
                    <option value="013300">#013300</option>
                    <option value="003532">#003532</option>
                    <option value="010066">#010066</option>
                    <option value="340096">#340096</option>
                    <option value="<?=$jam_kerja_jenis->getField("WARNA")?>" <? if($jam_kerja_jenis->getField("WARNA") == $tempWarna) echo "selected"; ?>></option>
                </select>
            </p>
            </div>               
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