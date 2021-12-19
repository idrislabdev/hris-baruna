<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");

$lokasi = new Lokasi();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");

if($reqMode == "update")
{
    $lokasi->selectByParams(array("LOKASI_ID" => $reqId));
    $lokasi->firstRow();
    
    $tempLokasiParent   = $lokasi->getField("LOKASI_PARENT_ID");
    $tempNama           = $lokasi->getField("NAMA");
    $tempKeterangan     = $lokasi->getField("KETERANGAN");
    $tempKode           = $lokasi->getField("KODE");
    $tempKodeGLPusat    = $lokasi->getField("KODE_GL_PUSAT");
    $tempAlamat         = $lokasi->getField("ALAMAT");
    $tempSumberDana     = $lokasi->getField("SUMBER_DANA");
    $tempLinkFileTemp   = $lokasi->getField('FILE_GAMBAR');
    $tempX= $lokasi->getField('X');
    $tempY= $lokasi->getField('Y');
}
else
    $tempLokasiParent = $reqId;
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
        url:'../json-inventaris/lokasi_add.php',
        onSubmit:function(){
            return $(this).form('validate');
        },
        success:function(data){
            //alert(data);
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
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Lokasi</span>
    </div>
    <form id="ff" method="post" novalidate>
   <table>          
            <tr style="display:none">
                <td>Kode</td>
                <td>:</td>
                <td>
                    <input name="reqKode" class="easyui-validatebox" size="40" type="text" value="<?=$tempKode?>" style="display:none" />
                </td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                    <input name="reqNama"  class="easyui-validatebox" required title="Nama harus diisi" size="40" type="text" value="<?=$tempNama?>" />
                </td>
            </tr>       
            <tr>
                <td>Kode GL Pusat</td>
                <td>:</td>
                <td>
                    <input name="reqKodeGLPusat" required class="easyui-validatebox" size="40" type="text" value="<?=$tempKodeGLPusat?>" />
                </td>
            </tr>      
            <tr>
                <td>Sumber Dana</td>
                <td>:</td>
                <td>
                    <input name="reqSumberDana" class="easyui-validatebox" size="40" type="text" value="<?=$tempSumberdana?>" />
                </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>
                    <textarea name="reqAlamat" title="Alamat harus diisi" style="width:300px; height:60px;"><?=$tempAlamat?></textarea>
                </td>
            </tr>  
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td>
                    <textarea name="reqKeterangan" title="Keterangan harus diisi" style="width:300px; height:60px;"><?=$tempKeterangan?></textarea>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <input type="hidden" id="reqId" name="reqId" value="<?=$reqId?>">
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