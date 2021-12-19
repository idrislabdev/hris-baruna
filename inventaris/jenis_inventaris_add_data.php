<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/JenisInventaris.php");

$jenis_inventaris = new JenisInventaris();

$reqId = httpFilterGet("reqId");

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqMode == "update")
{
    $jenis_inventaris->selectByParams(array("JENIS_INVENTARIS_ID" => $reqId));
    $jenis_inventaris->firstRow();
    $tempNama = $jenis_inventaris->getField("NAMA");
    $tempKeterangan = $jenis_inventaris->getField("KETERANGAN");
    $tempKode = $jenis_inventaris->getField("KODE");
    $tempNilaiResidu = $jenis_inventaris->getField("NILAI_RESIDU");
    $tempKodeDebet = $jenis_inventaris->getField("KODE_GL_DEBET");
    $tempKodeKredit = $jenis_inventaris->getField("KODE_GL_KREDIT");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>

<script language="Javascript">
<? include_once "../jslib/formHandler.php"; ?>
</script>

<script type="text/javascript">
$.fn.datebox.defaults.formatter = function(date){
    var y = date.getFullYear();
    var m = date.getMonth()+1;
    var d = date.getDate();
    return d+'-'+m+'-'+y;
}       
$(function(){
    $('#ff').form({
        url:'../json-inventaris/jenis_inventaris_add.php',
        onSubmit:function(){
            return $(this).form('validate');
        },
        success:function(data){
            $.messager.alert('Info', data, 'info');
            $('#rst_form').click();
            top.frames['mainFrame'].location.reload();              
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
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Jenis Asset</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
            <tr>
                <td>Kode</td>
                <td>:</td>
                <td>
                    <input name="reqKode" class="easyui-validatebox" style="width:150px;" type="text" value="<?=$tempKode?>" />
                </td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                    <input name="reqNama" class="easyui-validatebox" required="true" title="Nama harus diisi" style="width:300px;" type="text" value="<?=$tempNama?>" />
                </td>
            </tr>
            <tr>
                <td>Kode GL Debet</td>
                <td>:</td>
                <td>
                     <input name="reqKodeDebet" type="text" style="width:150px; height:10 0px;"><?=$tempKodeDebet?></input>
                </td>
            </tr>
            <tr>
                <td>Kode GL Kredit</td>
                <td>:</td>
                <td>
                     <input name="reqKodeKredit" type="text" style="width:150px; height:10 0px;"><?=$tempKodeKredit?></input>
                </td>
            </tr>
            <tr>
                <td>Nilai Residu</td>
                <td>:</td>
                <td>
                     <input name="reqNilaiResidu" type="text" style="width:150px; height:10 0px;"><?=$tempKodeKredit?></input>
                </td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td>
                     <textarea name="reqKeterangan" style="width:250px; height:10 0px;"><?=$tempKeterangan?></textarea>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <input type="hidden" name="reqId" value="<?=$reqId?>">
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                    <input type="submit" name="" value="Simpan" /> 
                    <input type="reset" name="" value="Reset" />
                </td>
            </tr>   
        </table>
    </form>
</div>
</body>
</html>