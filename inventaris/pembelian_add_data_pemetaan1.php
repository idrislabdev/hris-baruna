<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");


$inventaris_ruangan = new InventarisRuangan();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/globalfunction.js"></script>
<script type="text/javascript">
$(function(){
    $('#ff').form({
        url:'../json-inventaris/pembelian_add_data_pemetaan.php',
        onSubmit:function(){
            return $(this).form('validate');
        },
        success:function(data){
            //alert(data);
            data = data.split("-");
            $.messager.alert('Info', data[1], 'info');
            $('#rst_form').click();
            top.frames['mainFrame'].location.reload();  
            document.location.href = 'pembelian_add_data_pemetaan.php?reqId='+data[0];              
        }
    });
    
});

function iecompattest(){
  return (!window.opera && document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
{
  var left = iecompattest().scrollLeft; //(screen.width/2)-(opWidth/2);
  var top = (screen.height/2)-(opHeight/2) - 150;
  
  opWidth = iecompattest().clientWidth;      
  divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
}     
function openMap()
{
  OpenDHTMLPopup('lokasi_add_pilih.php?reqId='+$("#reqId").val()+'&reqMap='+$("#reqFileGambarTemp").val(), 'Administrasi Website', 500, 500)  
}
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
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Asset</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table class="example" id="dataTableRowDinamis">
        <!--<table class="example altrowstable" id="alternatecolor" >-->
            <thead class="altrowstable">
              <tr>
                  <th style="width:10%">Nomor</th>
                  <th style="width:10%">Inventaris</th>
                  <th style="width:10%">Lokasi</th>
              </tr>
            </thead>
            <tbody class="example altrowstable" id="alternatecolor"> 
              <?
              $i=0;
              $inventaris_ruangan->selectByParamsInventarisInvoice(array("A.INVOICE_ID" => $reqId));
                    while($inventaris_ruangan->nextRow())
              {
              ?>
                  <tr id="node-<?=$i?>">
                      <td>
                        <input type="hidden" name="reqInventarisRuanganId[]" readonly style="width:95%" value="<?=$inventaris_ruangan->getField("INVENTARIS_RUANGAN_ID")?>" />
                        <input type="hidden" name="reqInventarisId[]" readonly style="width:95%" value="<?=$inventaris_ruangan->getField("INVENTARIS_ID")?>" />
                        <input type="hidden" name="reqTahun[]" readonly style="width:95%" value="<?=$inventaris_ruangan->getField("PEROLEHAN_TAHUN")?>" />
                        <input type="hidden" name="reqLokasiLama[]" readonly style="width:95%" value="<?=$inventaris_ruangan->getField("LOKASI_ID")?>" />
                       
                        <input type="text" name="reqKode[]" readonly style="width:150px" value="<?=$inventaris_ruangan->getField("NOMOR")?>" />
                      </td>
                      <td>
                        <input type="text" name="reqInventaris[]" readonly style="width:180px" value="<?=$inventaris_ruangan->getField("INVENTARIS")?>" />
                      </td>
                      <td>
                        <input id="cc" class="easyui-combotree" name="reqLokasi[]"  data-options="url:'../json-inventaris/lokasi_combo_json.php'" style="width:250px;" value="<?=$inventaris_ruangan->getField("LOKASI_ID")?>">
                      </td>
                  </tr>
                  <? 
                    $i++;
                  }
                  ?>
            </tbody>          
        </table> 
         <div style="margin:15px;">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div> 
    </form>
</div>
</body>
</html>