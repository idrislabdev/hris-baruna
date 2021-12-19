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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>

<link rel="stylesheet" type="text/css" href="../WEB-INF/css/gaya.css">

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
<script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/kalender-easyui.js"></script>

<script language="Javascript">
<? include_once "../jslib/formHandler.php"; ?>
</script>

<script type="text/javascript">		
$(function(){
	$('#ff').form({
		url:'../json-inventaris/pembelian_add_data_pemetaan.php',
		onSubmit:function(){
			return $(this).form('validate');
		},
		success:function(data){
			alert(data);
			data = data.split("-");
			$.messager.alert('Info', data[1], 'info');
			$('#rst_form').click();
			top.frames['mainFrame'].location.reload();	
			document.location.href = 'pembelian_add_data_pemetaan.php?reqId='+data[0];				
		}
	});
	
});
</script>
</head>

<body>
	<div id="judul-popup">Pemetaan Inventaris</div>
	<div id="konten">
    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
    	<div id="popup-tabel2">
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
    </div>
</body>
</html>