<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisPenyusutan.php");
include_once("../WEB-INF/classes/base-inventaris/JenisSusut.php");

$inventaris_penyusutan = new InventarisPenyusutan();
$jenis_susut = new JenisSusut();

$reqId = httpFilterGet("reqId");

if($reqId == "")
{
  $reqMode = "insert";  
}
else
{
  $reqMode = "update";
  $inventaris_penyusutan->selectByParams(array("INVENTARIS_PENYUSUTAN_ID" => $reqId));
  $inventaris_penyusutan->firstRow();
  
  $tempJenisSusut = $inventaris_penyusutan->getField("JENIS_SUSUT_ID");
  $tempTanggalSusut = dateToPageCheck($inventaris_penyusutan->getField("TANGGAL_SUSUT"));
  $tempKeterangan = $inventaris_penyusutan->getField("KETERANGAN");
  $tempNama = $inventaris_penyusutan->getField("NAMA");
}

$jenis_susut->selectByParams();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Form Validation - jQuery EasyUI Demo</title>

    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/globalfunction.js"></script>
    <script type="text/javascript" src="js/entri_invoice.js"></script>
   <script language="Javascript">
<? include_once "../jslib/formHandler.php"; ?>
</script>

<script type="text/javascript"> 
$(function(){
  $('#ff').form({
    url:'../json-inventaris/penyusutan_add_data.php',
    onSubmit:function(){
      return $(this).form('validate');
    },
    success:function(data){
      //alert(data);
      data = data.split("-");
      $.messager.alert('Info', data[1], 'info');
      $('#rst_form').click();
      top.frames['mainFrame'].location.reload();
      parent.frames['menuFramePop'].location.href = 'penghapusan_add_menu.php?reqId=' + data[0];
      document.location.href = 'penghapusan_add_menu.php?reqId=' + data[0];  
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
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Penyusutan Data Asset</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
          <tr>
                <td>Jenis Penghapusan</td>
                <td>:</td>
                <td>
                <select name="reqJenisSusut">
                <?
                while($jenis_susut->nextRow())
                {
                ?>
                <option value="<?=$jenis_susut->getField("JENIS_SUSUT_ID")?>" <? if($jenis_susut->getField("JENIS_SUSUT_ID") == $tempJenisSusut) echo "selected";?>><?=$jenis_susut->getField("NAMA")?></option>
                <?
                }
                ?>
                </select>
                </td>           
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                    <input id="reqNama" name="reqNama" class="easyui-validatebox" required size="50" type="text" value="<?=$tempNama?>" />
                </td>
            </tr>
            <tr>
                <td>Tanggal Susut</td>
                <td>:</td>
                <td>
                <input id="reqTanggalSusut" name="reqTanggalSusut" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalSusut?>" />
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
                  <input type="submit" value="Simpan" /> 
                    <input type="reset" value="Reset" />
                </td>
            </tr>
        </table>  
    </form>
</div>
</body>
</html>