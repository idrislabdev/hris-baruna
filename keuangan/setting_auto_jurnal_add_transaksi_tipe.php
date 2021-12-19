<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTrans.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");

$transaksi_tipe = new KbbrTipeTrans();
$transaksi_tipe_detil = new KbbrTipeTransD();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqMode = httpFilterGet("reqMode");

$transaksi_tipe->selectByParams(array("A.KD_SUBSIS"=>$reqId, "A.TIPE_TRANS"=>$reqRowId), -1, -1);
$transaksi_tipe->firstRow();
$tempKodeJurnal= $transaksi_tipe->getField("KD_JURNAL");
unset($transaksi_tipe);

$transaksi_tipe_detil->selectByParams(array("KD_SUBSIS"=>$reqId, "A.TIPE_TRANS"=>$reqRowId), -1, -1);
$arrTransaksiDetil="";
$index=0;
while($transaksi_tipe_detil->nextRow())
{
	$arrTransaksiDetil[$index]["KLAS_TRANS"] = $transaksi_tipe_detil->getField("KLAS_TRANS");
	$arrTransaksiDetil[$index]["KETK_TRANS"] = $transaksi_tipe_detil->getField("KETK_TRANS");
	$arrTransaksiDetil[$index]["GLREK_COAID"] = $transaksi_tipe_detil->getField("GLREK_COAID");
	$arrTransaksiDetil[$index]["KD_BUKU_BESAR1"] = $transaksi_tipe_detil->getField("KD_BUKU_BESAR1");
	$arrTransaksiDetil[$index]["KD_BUKU_BESAR2"] = $transaksi_tipe_detil->getField("KD_BUKU_BESAR2");
	$arrTransaksiDetil[$index]["KD_DK"] = $transaksi_tipe_detil->getField("KD_DK");
	$arrTransaksiDetil[$index]["STATUS_KENA_PAJAK"] = $transaksi_tipe_detil->getField("STATUS_KENA_PAJAK");
	$arrTransaksiDetil[$index]["FLAG_JURNAL"] = $transaksi_tipe_detil->getField("FLAG_JURNAL");
	$index++;
}
//echo $transaksi_tipe_detil->query;
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
				url:'../json-keuangansiuk/setting_auto_jurnal_add_transaksi_tipe.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					//$('#rst_form').click();
					document.location.href = 'setting_auto_jurnal_add_transaksi_tipe.php?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>';
					//top.frames['mainFrame'].location.reload();
					<?php /*?><? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?><?php */?>
				}
			});
		});
	
	function setDisable(index, status)
	{
		$('#reqKlasTransaksi'+index).prop('disabled', status);
		$('#reqKeteranganTransaksi'+index).prop('disabled', status);
		$('#reqGroupCoid'+index).prop('disabled', status);
		$('#reqKodeBukuBesar1'+index).prop('disabled', status);
		$('#reqKodeBukuBesar2'+index).prop('disabled', status);
		$('#reqKlasTransaksiDebetKredit'+index).prop('disabled', status);
		$('#reqStatusKenaPajak'+index).prop('disabled', status);
		$('#reqFlagJurnal'+index).prop('disabled', status);
	}
	
	function setRemoveStyle(index)
	{
		$('#reqKlasTransaksi'+index).removeAttr('style');
		$('#reqKeteranganTransaksi'+index).removeAttr('style');
		$('#reqGroupCoid'+index).removeAttr('style');
		$('#reqKodeBukuBesar1'+index).removeAttr('style');
		$('#reqKodeBukuBesar2'+index).removeAttr('style');
		$('#reqKlasTransaksiDebetKredit'+index).removeAttr('style');
		$('#reqStatusKenaPajak'+index).removeAttr('style');
		$('#reqFlagJurnal'+index).removeAttr('style');
	}
	
	function setAddStyle(index)
	{
		$('#reqKlasTransaksi'+index).css({'border':'none', 'background':'inherit'});
		$('#reqKeteranganTransaksi'+index).css({'border':'none', 'background':'inherit'});
		//$('#reqGroupCoid'+index).css({'border':'none', 'background':'inherit'});
		$('#reqKodeBukuBesar1'+index).css({'border':'none', 'background':'inherit'});
		$('#reqKodeBukuBesar2'+index).css({'border':'none', 'background':'inherit'});
		//$('#reqKlasTransaksiDebetKredit'+index).css({'border':'none', 'background':'inherit'});
		//$('#reqStatusKenaPajak'+index).css({'border':'none', 'background':'inherit'});
		//$('#reqFlagJurnal'+index).css({'border':'none', 'background':'inherit'});
		setDisable(index, true);
	}
	
	function resetValue(index)
	{
		$('#reqKlasTransaksi'+index).val($('#reqKlasTransaksiTemp'+index).val());
		$('#reqKeteranganTransaksi'+index).val($('#reqKeteranganTransaksiTemp'+index).val());
		$('#reqGroupCoid'+index).val($('#reqGroupCoidTemp'+index).val());
		$('#reqKodeBukuBesar1'+index).val($('#reqKodeBukuBesar1Temp'+index).val());
		$('#reqKodeBukuBesar2'+index).val($('#reqKodeBukuBesar2Temp'+index).val());
		$('#reqKlasTransaksiDebetKredit'+index).val($('#reqKlasTransaksiDebetKreditTemp'+index).val());
		$('#reqStatusKenaPajak'+index).val($('#reqStatusKenaPajakTemp'+index).val());
		$('#reqFlagJurnal'+index).val($('#reqFlagJurnalTemp'+index).val());
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
		element.name = "reqKlasTransaksi["+ id_row +"]";
		element.id = "reqKlasTransaksi"+id_row;
		element.className='easyui-validatebox';
        column.appendChild(element);
		$('#reqKlasTransaksi'+id_row).validatebox({  
			required: true
		});
		
		var column= row.insertCell(1);
        var element = document.createElement("input");
        element.type = "text";
		element.name = "reqKeteranganTransaksi["+ id_row +"]";
		element.id = "reqKeteranganTransaksi"+id_row;
		element.className='easyui-validatebox';
        column.appendChild(element);
		
		var column0 = row.insertCell(2);
		var combo = document.createElement("select");
		combo.setAttribute("name", "reqGroupCoid["+ id_row +"]"); 
		combo.setAttribute("id", "reqGroupCoid"+ id_row); 
		var option = document.createElement("option");
		combo.options[0] = new Option("Y", "Y");
		combo.options[1] = new Option("N", "N");
		column0.appendChild(combo);
		
		var column= row.insertCell(3);
        var element = document.createElement("input");
        element.type = "text";
		element.name = "reqKodeBukuBesar1["+ id_row +"]";
		element.id = "reqKodeBukuBesar1"+id_row;
		element.className='easyui-validatebox';
        column.appendChild(element);
		
		var column= row.insertCell(4);
        var element = document.createElement("input");
        element.type = "text";
		element.name = "reqKodeBukuBesar2["+ id_row +"]";
		element.id = "reqKodeBukuBesar2"+id_row;
		element.className='easyui-validatebox';
        column.appendChild(element);
		
		var column0 = row.insertCell(5);
		var combo = document.createElement("select");
		combo.setAttribute("name", "reqKlasTransaksiDebetKredit["+ id_row +"]"); 
		combo.setAttribute("id", "reqKlasTransaksiDebetKredit"+ id_row); 
		var option = document.createElement("option");
		combo.options[0] = new Option("DEBET", "D");
		combo.options[1] = new Option("KREDIT", "K");
		column0.appendChild(combo);
		
		var column0 = row.insertCell(6);
		var combo = document.createElement("select");
		combo.setAttribute("name", "reqStatusKenaPajak["+ id_row +"]"); 
		combo.setAttribute("id", "reqStatusKenaPajak"+ id_row); 
		var option = document.createElement("option");
		combo.options[0] = new Option("YA", "Y");
		combo.options[1] = new Option("TIDAK", "N");
		column0.appendChild(combo);
		
		var column0 = row.insertCell(7);
		var combo = document.createElement("select");
		combo.setAttribute("name", "reqFlagJurnal["+ id_row +"]"); 
		combo.setAttribute("id", "reqFlagJurnal"+ id_row); 
		var option = document.createElement("option");
		combo.options[0] = new Option("YA", "Y");
		combo.options[1] = new Option("TIDAK", "N");
		column0.appendChild(combo);
		
		var column= row.insertCell(8);
		var add_label = document.createElement('label');
		column.appendChild(add_label);
		add_label.innerHTML = '<input type="hidden" id="reqTipeTrans'+id_row+'" name="reqTipeTrans['+id_row+']" /><input type="hidden" id="reqSubmit'+id_row+'" name="reqSubmit['+id_row+']" /> <input type="button" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)" value="Cancel" />';
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
		document.location.href = 'setting_auto_jurnal_add_transaksi_tipe.php?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>';
	}
	function deleteRowDrawTablePhp(tableID, id, reqKlasTransaksiId) {
		if(confirm('Apakah anda ingin menghapus data terpilih?') == false)
			return "";
				
		try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		var id=id.parentNode.parentNode.rowIndex;
		var tempQuery;
		for(var i=0; i<=rowCount; i++) {
			if(id == i) {
				table.deleteRow(i);
				$.getJSON('../json-keuangansiuk/setting_auto_jurnal_add_transaksi_tipe_delete.php?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>&reqKodeJurnal=<?=$tempKodeJurnal?>&reqKlasTransaksiId='+reqKlasTransaksiId, function (data)
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Pengaturan Tipe : <?=$reqRowId?></span>
            </div>            
            </td>
        </tr>
    </table>
    
    <div id="konten">
        <form id="ff" method="post" novalidate>
        <?
        if($reqRowId == ""){}
        else
        {
        ?>
        <div class="gradient-class-style">
            <input type="submit" value="Simpan" />&nbsp;&nbsp;
            <span class="judul-halaman18"></span>
        </div>
        <?
        }
        ?>
        <table class="gradient-class-style" id="dataTableRowDinamis">
        <thead>
        <tr>
        <th scope="col">
        Klas
        <?
        if($reqRowId == ""){}
        else
        {
        ?>
        <a style="cursor:pointer" title="Tambah" onclick="addRowDrawTables('dataTableRowDinamis')"><img src="../WEB-INF/images/tree-add.png" width="16" height="16" border="0" /></a>
        <?
        }
        ?>
        </th>
        <th scope="col">Keterangan</th>
        <th scope="col">Group</th>
        <th scope="col">BB Awal</th>
        <th scope="col">BB Akhir</th>
        <th scope="col">Debet/Kredit</th>
        <th scope="col">Pajak</th>
        <th scope="col">Entry Jurnal</th>
        <th scope="col">Aksi</th>
        </tr>
        </thead>
        <tbody>
    
        <?
        if($index == 0){}
        else
        {
            $i = $checkbox_index =0;
            for($i=0;$i<count($arrTransaksiDetil);$i++)
            {
        ?>
            <tr>
                <td><input type="text" id="reqKlasTransaksi<?=$i?>" name="reqKlasTransaksi[<?=$i?>]" disabled style="border:none; background:inherit" value="<?=$arrTransaksiDetil[$i]["KLAS_TRANS"]?>" /></td>
                <td><input type="text" id="reqKeteranganTransaksi<?=$i?>" name="reqKeteranganTransaksi[<?=$i?>]" disabled style="border:none; background:inherit" value="<?=$arrTransaksiDetil[$i]["KETK_TRANS"]?>" /></td>
                <td>
                    <select id="reqGroupCoid<?=$i?>" name="reqGroupCoid[<?=$i?>]" disabled >
                        <option></option>
                        <option value="Y" <? if($arrTransaksiDetil[$i]["GLREK_COAID"] == "Y") echo "selected";?>>Y</option>
                        <option value="N" <? if($arrTransaksiDetil[$i]["GLREK_COAID"] == "N") echo "selected";?>>N</option>
                    </select>
                <td><input type="text" id="reqKodeBukuBesar1<?=$i?>" name="reqKodeBukuBesar1[<?=$i?>]" disabled style="border:none; background:inherit" value="<?=$arrTransaksiDetil[$i]["KD_BUKU_BESAR1"]?>" /></td>
                <td><input type="text" id="reqKodeBukuBesar2<?=$i?>" name="reqKodeBukuBesar2[<?=$i?>]" disabled style="border:none; background:inherit" value="<?=$arrTransaksiDetil[$i]["KD_BUKU_BESAR2"]?>" /></td>
                <td> 
                    <select id="reqKlasTransaksiDebetKredit<?=$i?>" name="reqKlasTransaksiDebetKredit[<?=$i?>]" disabled >
                        <option></option>
                        <option value="D" <? if($arrTransaksiDetil[$i]["KD_DK"] == "D") echo "selected";?>>DEBET</option>
                        <option value="K" <? if($arrTransaksiDetil[$i]["KD_DK"] == "K") echo "selected";?>>KREDIT</option>
                    </select>
                </td>
                <td> 
                    <select id="reqStatusKenaPajak<?=$i?>" name="reqStatusKenaPajak[<?=$i?>]" disabled >
                        <option></option>
                        <option value="Y" <? if($arrTransaksiDetil[$i]["STATUS_KENA_PAJAK"] == "Y") echo "selected";?>>YA</option>
                        <option value="N" <? if($arrTransaksiDetil[$i]["STATUS_KENA_PAJAK"] == "N") echo "selected";?>>TIDAK</option>
                    </select>
                </td>
                <td> 
                    <select id="reqFlagJurnal<?=$i?>" name="reqFlagJurnal[<?=$i?>]" disabled >
                        <option></option>
                        <option value="Y" <? if($arrTransaksiDetil[$i]["FLAG_JURNAL"] == "Y") echo "selected";?>>YA</option>
                        <option value="N" <? if($arrTransaksiDetil[$i]["FLAG_JURNAL"] == "N") echo "selected";?>>TIDAK</option>
                    </select>
                </td>
                <td>
                    <input type="button" onClick="setSimpan('<?=$i?>')" id="reqButton<?=$i?>" name="reqButton[<?=$i?>]" value="Update" />
                    <input type="button" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this, '<?=$arrTransaksiDetil[$i]["KLAS_TRANS"]?>')" value="Hapus" />
                </td>
                <input type="hidden" id="reqKlasTransaksiId<?=$i?>" name="reqKlasTransaksiId[<?=$i?>]" value="<?=$arrTransaksiDetil[$i]["KLAS_TRANS"]?>" />
                <input type="hidden" id="reqKlasTransaksiTemp<?=$i?>" value="<?=$arrTransaksiDetil[$i]["KLAS_TRANS"]?>" />
                <input type="hidden" id="reqKeteranganTransaksiTemp<?=$i?>" value="<?=$arrTransaksiDetil[$i]["KETK_TRANS"]?>" />
                <input type="hidden" id="reqGroupCoidTemp<?=$i?>" value="<?=$arrTransaksiDetil[$i]["GLREK_COAID"]?>" />
                <input type="hidden" id="reqKodeBukuBesar1Temp<?=$i?>" value="<?=$arrTransaksiDetil[$i]["KD_BUKU_BESAR1"]?>" />
                <input type="hidden" id="reqKodeBukuBesar2Temp<?=$i?>" value="<?=$arrTransaksiDetil[$i]["KD_BUKU_BESAR2"]?>" />
                <input type="hidden" id="reqKlasTransaksiDebetKreditTemp<?=$i?>" value="<?=$arrTransaksiDetil[$i]["KD_DK"]?>" />
                <input type="hidden" id="reqStatusKenaPajakTemp<?=$i?>" value="<?=$arrTransaksiDetil[$i]["STATUS_KENA_PAJAK"]?>" />
                <input type="hidden" id="reqFlagJurnalTemp<?=$i?>" value="<?=$arrTransaksiDetil[$i]["FLAG_JURNAL"]?>" />
            </tr>    
        <?
            $checkbox_index++;
            }
        }
        ?>    
        </table>
        <div class="gradient-class-style">
            <input type="hidden" name="reqId" id="reqId" value="<?=$reqId?>" />
            <input type="hidden" name="reqKodeJurnal" id="reqKodeJurnal" value="<?=$tempKodeJurnal?>" />
            <input type="hidden" name="reqRowId" id="reqRowId" value="<?=$reqRowId?>" />
            <input type="hidden" name="reqArrayIndex" id="reqArrayIndex" value="<?=$checkbox_index?>" />
        </div>
        </form>
    </div>
</div>
</body>
</html>