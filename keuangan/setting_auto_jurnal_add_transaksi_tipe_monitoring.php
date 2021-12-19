<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTrans.php");

$transaksi_tipe = new KbbrTipeTrans();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqMode = httpFilterGet("reqMode");

$transaksi_tipe->selectByParams(array("A.KD_SUBSIS"=>$reqId, "A.KD_JURNAL"=>$reqRowId), -1, -1);
//echo $transaksi_tipe->query;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/setting_auto_jurnal_add_transaksi_tipe_monitoring.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					//$('#rst_form').click();
					document.location.href = 'setting_auto_jurnal_add_transaksi_tipe_monitoring.php?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>';
					//top.frames['mainFrame'].location.reload();
					<?php /*?><? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?><?php */?>
				}
			});
		});
	
	function lookupDetil(reqId, reqRowId)
	{
		parent.frames['mainFrameDetilPop'].location.href = 'setting_auto_jurnal_add_transaksi_tipe.php?reqId='+reqId+'&reqRowId='+reqRowId;
	}
	function setDisable(index, status)
	{
		$('#reqKode'+index).prop('disabled', status);
		$('#reqKeterangan'+index).prop('disabled', status);
		$('#reqNama'+index).prop('disabled', status);
		$('#reqStatusPostingJurnal'+index).prop('disabled', status);
		$('#reqStatusPajak'+index).prop('disabled', status);
		$('#reqStatusMaterai'+index).prop('disabled', status);
		$('#reqKodePajak1'+index).prop('disabled', status);
		$('#reqKodePajak2'+index).prop('disabled', status);
	}
	
	function setRemoveStyle(index)
	{
		$('#reqKode'+index).removeAttr('style');
		$('#reqKeterangan'+index).removeAttr('style');
		$('#reqNama'+index).removeAttr('style');
		//$('#reqStatusPostingJurnal'+index).removeAttr('style');
		//$('#reqStatusPajak'+index).removeAttr('style');
		//$('#reqStatusMaterai'+index).removeAttr('style');
		$('#reqKodePajak1'+index).removeAttr('style');
		$('#reqKodePajak2'+index).removeAttr('style');
	}
	
	function setAddStyle(index)
	{
		$('#reqKode'+index).css({'border':'none', 'background':'inherit'});
		$('#reqKeterangan'+index).css({'border':'none', 'background':'inherit'});
		$('#reqNama'+index).css({'border':'none', 'background':'inherit'});
		//$('#reqStatusPostingJurnal'+index).css({'border':'none', 'background':'inherit'});
		//$('#reqStatusPajak'+index).css({'border':'none', 'background':'inherit'});
		//$('#reqStatusMaterai'+index).css({'border':'none', 'background':'inherit'});
		$('#reqKodePajak1'+index).css({'border':'none', 'background':'inherit'});
		$('#reqKodePajak2'+index).css({'border':'none', 'background':'inherit'});
		setDisable(index, true);
	}
	
	function resetValue(index)
	{
		$('#reqKode'+index).val($('#reqKodeTemp'+index).val());
		$('#reqKeterangan'+index).val($('#reqKeteranganTemp'+index).val());
		$('#reqNama'+index).val($('#reqNamaTemp'+index).val());
		$('#reqStatusPostingJurnal'+index).val($('#reqStatusPostingJurnalTemp'+index).val());
		$('#reqStatusPajak'+index).val($('#reqStatusPajakTemp'+index).val());
		$('#reqStatusMaterai'+index).val($('#reqStatusMateraiTemp'+index).val());
		$('#reqKodePajak1'+index).val($('#reqKodePajak1Temp'+index).val());
		$('#reqKodePajak2'+index).val($('#reqKodePajak2Temp'+index).val());
	}
	function setSimpan(index)
	{
		if($('#reqButton'+index).val() == "Cancel")
		{
			setAddStyle(index);
			resetValue(index);
			$('#reqSubmit'+index).val('');
			$('#reqButton'+index).val('Update');
		}
		else
		{
			setRemoveStyle(index);
			setDisable(index, false);
			
			$('#reqSubmit'+index).val('update');
			$('#reqButton'+index).val('Cancel');
		}
	}
	
	function addRowDrawTables(tableID) {
		var table = document.getElementById(tableID);
	
		var rowCount = table.rows.length;
		var id_row = rowCount-1;
		var row = table.insertRow(rowCount);
		$('#reqArrayIndex').val(rowCount);
			
		var column= row.insertCell(0);
        var element = document.createElement("input");
        element.type = "text";
		element.name = "reqKode["+ id_row +"]";
		element.id = "reqKode"+id_row;
		element.value = "<?=$reqRowId?>-<?=$reqId?>-";
		/*element.disabled = "true";
		element.style.border = "none";
		element.style.background = "inherit";*/
		//element.style.width = '100px';
		element.className='easyui-validatebox';
        column.appendChild(element);
		$('#reqKode'+id_row).validatebox({  
			required: true
		});
		
		var column= row.insertCell(1);
        var element = document.createElement("input");
        element.type = "text";
		element.name = "reqKeterangan["+ id_row +"]";
		element.id = "reqKeterangan"+id_row;
		/*element.disabled = "true";
		element.style.border = "none";
		element.style.background = "inherit";*/
		//element.style.width = '100px';
		element.className='easyui-validatebox';
        column.appendChild(element);
		
		var column= row.insertCell(2);
        var element = document.createElement("input");
        element.type = "text";
		element.name = "reqNama["+ id_row +"]";
		element.id = "reqNama"+id_row;
		/*element.disabled = "true";
		element.style.border = "none";
		element.style.background = "inherit";*/
		//element.style.width = '100px';
		element.className='easyui-validatebox';
        column.appendChild(element);
		
		var column0 = row.insertCell(3);
		var combo = document.createElement("select");
		combo.setAttribute("name", "reqStatusPostingJurnal["+ id_row +"]"); 
		combo.setAttribute("id", "reqStatusPostingJurnal"+ id_row); 
		var option = document.createElement("option");
		combo.options[0] = new Option("YA", "Y");
		combo.options[1] = new Option("TIDAK", "T");
		column0.appendChild(combo);
		
		var column0 = row.insertCell(4);
		var combo = document.createElement("select");
		combo.setAttribute("name", "reqStatusPajak["+ id_row +"]"); 
		combo.setAttribute("id", "reqStatusPajak"+ id_row); 
		var option = document.createElement("option");
		combo.options[0] = new Option("YA", "Y");
		combo.options[1] = new Option("TIDAK", "T");
		column0.appendChild(combo);
		
		var column0 = row.insertCell(5);
		var combo = document.createElement("select");
		combo.setAttribute("name", "reqStatusMaterai["+ id_row +"]"); 
		combo.setAttribute("id", "reqStatusMaterai"+ id_row); 
		var option = document.createElement("option");
		combo.options[0] = new Option("YA", "Y");
		combo.options[1] = new Option("TIDAK", "T");
		column0.appendChild(combo);
		
		var column= row.insertCell(6);
        var element = document.createElement("input");
        element.type = "text";
		element.name = "reqKodePajak1["+ id_row +"]";
		element.id = "reqKodePajak1"+id_row;
		/*element.disabled = "true";
		element.style.border = "none";
		element.style.background = "inherit";*/
		//element.style.width = '100px';
		element.className='easyui-validatebox';
        column.appendChild(element);
		
		var column= row.insertCell(7);
        var element = document.createElement("input");
        element.type = "text";
		element.name = "reqKodePajak2["+ id_row +"]";
		element.id = "reqKodePajak2"+id_row;
		/*element.disabled = "true";
		element.style.border = "none";
		element.style.background = "inherit";*/
		//element.style.width = '100px';
		element.className='easyui-validatebox';
        column.appendChild(element);
		
		var column= row.insertCell(8);
		var add_label = document.createElement('label');
		//add_label.style.textAlign='center';
		column.appendChild(add_label);
		add_label.innerHTML = '<input type="hidden" id="reqTipeTrans'+id_row+'" name="reqTipeTrans['+id_row+']" /><input type="hidden" id="reqSubmit'+id_row+'" name="reqSubmit['+id_row+']" /> <input type="button" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)" value="Cancel" />';
		<?php /*?><input type="button" onClick="setSimpan('+id_row+')" id="reqButton'+id_row+'" value="Cancel" /><?php */?>
	}
	
	function deleteRowDrawTable(tableID, id) {
		if(confirm('Apakah anda ingin menghapus data terpilih?') == false)
			return "";
				
		try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		var id=id.parentNode.parentNode.parentNode.rowIndex;
		
		for(var i=0; i<=rowCount; i++) {
			if(id == i) {
				table.deleteRow(i);
			}
		}
		}catch(e) {
			alert(e);
		}
	}
	
	function reloadMe()
	{
		document.location.href = 'setting_auto_jurnal_add_transaksi_tipe_monitoring.php?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>';
	}
	
	function deleteRowDrawTablePhp(tableID, id, reqTipeTrans) {
		if(confirm('Apakah anda ingin menghapus data terpilih?') == false)
			return "";
				
		try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		var id=id.parentNode.parentNode.rowIndex;
		
		for(var i=0; i<=rowCount; i++) {
			if(id == i) {
				table.deleteRow(i);
				$.getJSON('../json-keuangansiuk/setting_auto_jurnal_add_transaksi_tipe_monitoring_delete.php?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>&reqTipeTrans='+reqTipeTrans, function (data)
				{
					$.each(data, function (i, SingleElement) {
						tempQuery= data.Query;
					});
				});
				setTimeout(reloadMe, 1000);
			}
		}
		}catch(e) {
			alert(e);
		}
	}
	
		$.fn.datebox.defaults.formatter = function(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
		};
		$.extend($.fn.validatebox.defaults.rules, {
			date:{
				validator:function(value, param) {
					if(value.length == '10')
					{
						var reg = /^(\d{1,2})(-|\/)(\d{1,2})\2(\d{1,4})$/;
						return reg.test(value);
					}
					else
					{
						return false;
					}
				},
				message:"Format Tanggal: dd-mm-yyyy"
			}  
		});
	
		$.fn.datebox.defaults.parser = function(s) {
			if (s) {
				var a = s.split('-');
				var d = new Number(a[0]);
				var m = new Number(a[1]);
				var y = new Number(a[2]);
				var dd = new Date(y, m-1, d);
				return dd;
			} 
			else 
			{
				return new Date();
			}
		};	
	</script>
    
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
		<span><img src="../WEB-INF/images/panah-judul.png"> Template Auto Jurnal</span>
    </div>
    
    <div id="konten">
        <form id="ff" method="post" novalidate>
        <div class="gradient-class-style">
            <input type="submit" value="Simpan" />
        </div>
        <table class="gradient-class-style" id="dataTableRowDinamis">
        <thead>
        <tr>
        <th scope="col">
            Tipe
        <a style="cursor:pointer" title="Tambah" onclick="addRowDrawTables('dataTableRowDinamis')"><img src="../WEB-INF/images/tree-add.png" width="16" height="16" border="0" /></a>
        </th>
        <th scope="col">Keterangan</th>
        <th scope="col">Akronim</th>
        <th scope="col">Posting</th>
        <th scope="col">Pajak</th>
        <th scope="col">Materai</th>
        <th scope="col">BB Pajak 1</th>
        <th scope="col">BB Pajak 2</th>
        <th scope="col">Aksi</th>
        </tr>
        </thead>
        <tbody>
    
        <?
        $i = $checkbox_index =0;
        while($transaksi_tipe->nextRow())
        {
        ?>
            <?php /*?><tr><?php */?>
            <tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'setting_auto_jurnal_add_transaksi_tipe.php?reqId=<?=$reqId?>&reqRowId=<?=$transaksi_tipe->getField("TIPE_TRANS")?>'">
                <td><input type="text" id="reqKode<?=$i?>" name="reqKode[<?=$i?>]" disabled style="border:none; background:inherit" value="<?=$transaksi_tipe->getField("TIPE_TRANS")?>" /></td>
                <td><input type="text" id="reqKeterangan<?=$i?>" name="reqKeterangan[<?=$i?>]" disabled style="border:none; background:inherit" value="<?=$transaksi_tipe->getField("TIPE_DESC")?>" /></td>
                <td><input type="text" id="reqNama<?=$i?>" name="reqNama[<?=$i?>]" disabled style="border:none; background:inherit" value="<?=$transaksi_tipe->getField("AKRONIM_DESC")?>" /></td>
                <td>
                    <select id="reqStatusPostingJurnal<?=$i?>" name="reqStatusPostingJurnal[<?=$i?>]" disabled >
                        <option></option>
                        <option value="Y" <? if($transaksi_tipe->getField("POST_JURNAL") == "Y") echo "selected";?>>YA</option>
                        <option value="T" <? if($transaksi_tipe->getField("POST_JURNAL") == "T") echo "selected";?>>TIDAK</option>
                    </select>
                </td>
                <td>
                    <select id="reqStatusPajak<?=$i?>" name="reqStatusPajak[<?=$i?>]" disabled>
                        <option></option>
                        <option value="Y" <? if($transaksi_tipe->getField("ADA_PAJAK") == "Y") echo "selected";?>>YA</option>
                        <option value="T" <? if($transaksi_tipe->getField("ADA_PAJAK") == "T") echo "selected";?>>TIDAK</option>
                    </select>
                </td>
                <td>
                    <select id="reqStatusMaterai<?=$i?>" name="reqStatusMaterai[<?=$i?>]" disabled>
                        <option></option>
                        <option value="Y" <? if($transaksi_tipe->getField("FLAG_METERAI") == "Y") echo "selected";?>>YA</option>
                        <option value="T" <? if($transaksi_tipe->getField("FLAG_METERAI") == "T") echo "selected";?>>TIDAK</option>
                    </select>
                </td>
                <td><input type="text" id="reqKodePajak1<?=$i?>" name="reqKodePajak1[<?=$i?>]" disabled style="border:none; background:inherit" value="<?=$transaksi_tipe->getField("KD_PAJAK1")?>" /></td>
                <td><input type="text" id="reqKodePajak2<?=$i?>" name="reqKodePajak2[<?=$i?>]" disabled style="border:none; background:inherit" value="<?=$transaksi_tipe->getField("KD_PAJAK2")?>" /></td>
                <td>
                    <input type="button" onClick="setSimpan('<?=$i?>')" id="reqButton<?=$i?>" name="reqButton[<?=$i?>]" value="Update" />
                    <?php /*?><input type="button" onClick="lookupDetil('<?=$reqId?>', '<?=$transaksi_tipe->getField("TIPE_TRANS")?>')" value="Detil" /><?php */?>
                    <input type="button" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this, '<?=$transaksi_tipe->getField("TIPE_TRANS")?>')" value="Hapus" />
                </td>
            </tr>
            <input type="hidden" id="reqSubmit<?=$i?>" name="reqSubmit[<?=$i?>]" />
            <input type="hidden" id="reqTipeTrans<?=$i?>" name="reqTipeTrans[<?=$i?>]" value="<?=$transaksi_tipe->getField("TIPE_TRANS")?>" />
            <input type="hidden" id="reqKodeTemp<?=$i?>" value="<?=$transaksi_tipe->getField("TIPE_TRANS")?>" />
            <input type="hidden" id="reqKeteranganTemp<?=$i?>" value="<?=$transaksi_tipe->getField("TIPE_DESC")?>" />
            <input type="hidden" id="reqNamaTemp<?=$i?>" value="<?=$transaksi_tipe->getField("AKRONIM_DESC")?>" />
            <input type="hidden" id="reqStatusPostingJurnalTemp<?=$i?>" value="<?=$transaksi_tipe->getField("POST_JURNAL")?>" />
            <input type="hidden" id="reqStatusPajakTemp<?=$i?>" value="<?=$transaksi_tipe->getField("ADA_PAJAK")?>" />
            <input type="hidden" id="reqStatusMateraiTemp<?=$i?>" value="<?=$transaksi_tipe->getField("FLAG_METERAI")?>" />
            <input type="hidden" id="reqKodePajak1Temp<?=$i?>" value="<?=$transaksi_tipe->getField("KD_PAJAK1")?>" />
            <input type="hidden" id="reqKodePajak2Temp<?=$i?>" value="<?=$transaksi_tipe->getField("KD_PAJAK2")?>" />
        <?
            $i++;
            $checkbox_index++;
        }
        ?>    
        </tbody>
        </table>
        <div class="gradient-class-style">
            <input type="hidden" name="reqId" id="reqId" value="<?=$reqId?>" />
            <input type="hidden" name="reqRowId" id="reqRowId" value="<?=$reqRowId?>" />
            <input type="hidden" name="reqArrayIndex" id="reqArrayIndex" value="<?=$checkbox_index?>" />
            <?php /*?><input type="submit" value="Simpan" /><?php */?>
        </div>
        </form>
	</div>
</div>
</body>
</html>