<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Invoice.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");

$invoice = new Invoice();
$inventaris_ruangan = new InventarisRuangan();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

if($reqId == "")
{
	$reqMode = "insert";
}
else
{
	$reqMode = "update";
	$invoice->selectByParams(array("INVOICE_ID" => $reqId));
	$invoice->firstRow();
	
	$tempNama = $invoice->getField("NAMA");
	$tempInvoiceNo = $invoice->getField("INVOICE_NO");
	$tempTanggal = dateToPageCheck($invoice->getField("TANGGAL"));
}
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
<script type="text/javascript" src="../WEB-INF/lib/easyui/globalfunction.js"></script>
<script type="text/javascript" src="js/entri_invoice.js"></script>

<script language="Javascript">
<? include_once "../jslib/formHandler.php"; ?>
</script>

<script type="text/javascript">	
$(function(){
	$('#ff').form({
		url:'../json-inventaris/pembelian_add.php',
		onSubmit:function(){
			return $(this).form('validate');
		},
		success:function(data){
			//alert(data);
			//$.messager.alert('Info', data, 'info');	
			data = data.split("-");
			$.messager.alert('Info', data[1], 'info');
			$('#rst_form').click();
			top.frames['mainFrame'].location.reload();
			document.location.href = 'pembelian_add_data.php?reqId='+data[0];
			parent.frames['menuFramePop'].location.href = 'pembelian_add_menu.php?reqId=' + data[0];
		}
	});
	
});
</script>
</head>

<body class="bg-kanan-full">
	<div id="judul-popup">Tambah Data Pembelian</div>
	<div id="konten">
    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
    	<div id="popup-tabel2">
    	<table style="margin-left:17px;">
    	<thead>
            <tr>
                <td>Invoice No</td>
                <td>:</td>
                <td>
                     <input name="reqInvoiceNo" class="easyui-validatebox" style="width:100px;" type="text" value="<?=$tempInvoiceNo?>" />
                </td>
            </tr>  
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                    <input name="reqNama" class="easyui-validatebox" required title="Nama harus diisi" style="width:300px;" type="text" value="<?=$tempNama?>" />
                </td>
            </tr> 
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>
                    <input id="reqTanggal" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggal?>" />
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
        </thead>
        </table>
        <table class="example" id="dataTableRowDinamis">
        <!--<table class="example altrowstable" id="alternatecolor" >-->
            <thead class="altrowstable">
              <tr>
                  <th style="width:5%">
                    No
                    <a style="cursor:pointer" title="Tambah Petugas" onclick="addRow()"><img src="../WEB-INF/images/icn_add.gif" width="16" height="16" border="0" /></a>
                  </th>
                  <th style="width:10%">Inventaris</th>
                  <th style="width:10%">Unit</th>
                  <th style="width:10%">Harga</th>
                  <th style="width:15%">Aksi</th>
              </tr>
            </thead>
            <tbody class="example altrowstable" id="alternatecolor"> 
              <?
              $i=0;
              $inventaris_ruangan->selectByParamsInvoice(array("A.INVOICE_ID" => $reqId));
              while($inventaris_ruangan->nextRow())
              {
              ?>
                  <tr id="node-<?=$i?>">
                      <td>
                        <input type="text" name="reqNoUrut[]" id="reqNoUrut<?=$i?>" readonly class="easyui-validatebox" value="<?=$i+1?>" style="width:50px" />
                      </td>
                      <td>
                        <input type="text" name="reqInventaris[]" id="reqInventaris<?=$i?>" class="easyui-combobox" style="width:450px;" 
                        data-options="
                        filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                        valueField: 'id', 
                        textField: 'text',
                        url:'../json-inventaris/inventaris_combo_json.php?reqTahun=<?=$tempTahun?>'"
                        value="<?=$inventaris_ruangan->getField("INVENTARIS_ID")?>" />
                      </td>
                      <td>
                        <input type="text" name="reqUnit[]" <? if($inventaris_ruangan->getField("JUMLAH_LOKASI") == 0) {} else { ?> readonly <? } ?> id="reqUnit<?=$i?>" style="text-align:right; width:100px" OnKeyUp="hitungJumlahHargaUnitPhp('<?=$i?>')" value="<?=$inventaris_ruangan->getField("JUMLAH")?>" />
                      </td>
                      <td>
                        <input type="text" name="reqHarga[]" <? if($inventaris_ruangan->getField("JUMLAH_LOKASI") == 0) {} else { ?> readonly <? } ?> id="reqHarga<?=$i?>" style="text-align:right; width:150px" OnFocus="FormatAngka('reqHarga<?=$i?>')" OnKeyUp="FormatUang('reqHarga<?=$i?>'); hitungJumlahHargaUnitPhp('<?=$i?>')" OnBlur="FormatUang('reqHarga<?=$i?>')" value="<?=numberToIna($inventaris_ruangan->getField("PEROLEHAN_HARGA"))?>">
                      </td>
                      <td align="center">
                      <label>
                      <?
                      if($inventaris_ruangan->getField("JUMLAH_LOKASI") == 0)
                      {
                      ?>
                      <a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
                      <?
                      }
                      else
                      {
                      ?>
                        <?=$inventaris_ruangan->getField("JUMLAH_LOKASI")?> item sudah ditentukan lokasinya.
                      <?
                      }
                      ?>
                      </label>
                      <input type="hidden" name="reqLokasi[]" value="<?=$inventaris_ruangan->getField("JUMLAH_LOKASI")?>">
                      </td>
                  </tr>
                  <? 
                    $i++;
                  }
                  ?>
            </tbody>          
        </table>  
        </div>
        </form>
        </div>
    </div>
</body>
</html>