<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");
include_once("../WEB-INF/classes/base/DeleteRowUser.php");


$referensi_detil = new KbbrGeneralRefD();

$reqId = httpFilterGet("reqId");
$reqDeleteId = httpFilterGet("reqDeleteId");
$reqMode = httpFilterGet("reqMode");

if($reqId == "")
{
	echo '<script language="javascript">';
	echo 'alert("Isi data pegawai terlebih dahulu.");';	
	echo 'window.parent.location.href = "referensi_add.php";';
	echo '</script>';
	exit();
}

if($reqMode == "delete")
{
	$referensi_detil->setField("REFERENSI_DETIL_ID", $reqDeleteId);
	$referensi_detil->delete();	
	
	$delete_row_user = new DeleteRowUser();
	$delete_row_user->setField("TABEL_NAMA", "REFERENSI_DETIL");
	$delete_row_user->setField("TABEL_ROW_ID", $reqDeleteId);
	$delete_row_user->setField("USER_NAMA", $userLogin->nama);
	$delete_row_user->setField("TABEL_ROW_ID_INDUK", $reqId);
	$delete_row_user->insert();

	echo '<script language="javascript">';
	echo 'window.parent.frames["mainFrameDetilPop"].location.reload();';
	echo '</script>';
		
}

$referensi_detil->selectByParams(array("ID_REF_FILE" => $reqId));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>referensi detil monitoring</title>
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript">
	var tempQuery="";
	
	function setDisable(index, status)
	{
		$('#reqIdRefData'+index).prop('disabled', status);
		$('#reqKetRefData'+index).prop('disabled', status);
		$('#reqKdAktif'+index).prop('disabled', status);
	}
	
	function setRemoveStyle(index)
	{
		$('#reqIdRefData'+index).removeAttr('style');
		$('#reqKetRefData'+index).removeAttr('style');
		$('#reqKdAktif'+index).removeAttr('style');
		$('#reqKetRefData'+index).css({'width':'400px'});
	}
	
	function setAddStyle(index)
	{
		$('#reqIdRefData'+index).css({'border':'none', 'background':'inherit'});
		$('#reqKetRefData'+index).css({'border':'none', 'background':'inherit', 'width':'400px'});
		//$('#reqKdAktif'+index).css({'border':'none', 'background':'inherit'});
		setDisable(index, true);
	}
	
	function setSimpan(index)
	{
		if($('#reqButton'+index).val() == "Simpan")
		{
			if(confirm('Apakah anda yakin merubah data ?') == false)
			{
				setAddStyle(index);
				$('#reqSubmit'+index).val('');
				$('#reqButton'+index).val('Update');
				return "";
			}
			
			try 
			{
				var reqRowId= $('#reqRowId'+index).val();
				var reqIdRefData= $('#reqIdRefData'+index).val();
				var reqKetRefData= $('#reqKetRefData'+index).val();
				var reqKdAktif= $('#reqKdAktif'+index).val();
		
				setAddStyle(index);
				$('#reqSubmit'+index).val('');
				$('#reqButton'+index).val('Update');
				
				//window.setTimeout(function() {
					$.getJSON('../json-keuangansiuk/referensi_detil_monitoring.php?reqId=<?=$reqId?>&reqRowId='+reqRowId+'&reqIdRefData='+reqIdRefData+'&reqKetRefData='+reqKetRefData+'&reqKdAktif='+reqKdAktif,
					function(data){
						tempQuery= data.Query;
					});
				setTimeout(reloadMe, 1000);
				
				//window.parent.divwin.close();
				
				//}, 1000);
				
				//alert(tempQuery);
				//$('#reqRowId'+index).val(reqIdRefData);
			}
			catch(e) 
			{
				alert(e);
			}
		}
		else
		{
			setRemoveStyle(index);
			setDisable(index, false);
			
			$('#reqSubmit'+index).val('update');
			$('#reqButton'+index).val('Simpan');
		}
	}
	
	function addRowDrawTables(tableID) {
		var table = document.getElementById(tableID);
	
		var rowCount = table.rows.length;
		var id_row = rowCount-1;
		var row = table.insertRow(rowCount);
		//$('#reqArrayIndex').val(rowCount);
		
		var column= row.insertCell(0);
        var element = document.createElement("input");
        element.type = "text";
		element.name = "reqIdRefData["+ id_row +"]";
		element.id = "reqIdRefData"+id_row;
		/*element.disabled = "true";
		element.style.border = "none";
		element.style.background = "inherit";*/
		//element.style.width = '100px';
		element.className='easyui-validatebox';
        column.appendChild(element);
		$('#reqIdRefData'+id_row).validatebox({  
			required: true
		});
		
		var column= row.insertCell(1);
        var element = document.createElement("input");
        element.type = "text";
		element.name = "reqKetRefData["+ id_row +"]";
		element.id = "reqKetRefData"+id_row;
		/*element.disabled = "true";
		element.style.border = "none";
		element.style.background = "inherit";*/
		//element.style.width = '100px';
		element.className='easyui-validatebox';
        column.appendChild(element);
		
		var column0 = row.insertCell(2);
		var combo = document.createElement("select");
		combo.setAttribute("name", "reqKdAktif["+ id_row +"]"); 
		combo.setAttribute("id", "reqKdAktif"+ id_row); 
		var option = document.createElement("option");
		combo.options[0] = new Option("AKTIF", "A");
		combo.options[1] = new Option("TIDAK AKTIF", "");
		column0.appendChild(combo);
		
		var column= row.insertCell(3);
		var add_label = document.createElement('label');
		//add_label.style.textAlign='center';
		column.appendChild(add_label);
		add_label.innerHTML = '<input type="hidden" id="reqRowId'+id_row+'" value="" /><input type="button" onClick="setSimpan('+id_row+')" id="reqButton'+id_row+'" value="Simpan" /> <input type="button" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)" value="Hapus" />';
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
		document.location.href = 'referensi_detil_monitoring.php?reqId=<?=$reqId?>';
	}
	
	function deleteRowDrawTablePhp(tableID, id, reqRowId) {
		if(confirm('Apakah anda ingin menghapus data terpilih?') == false)
			return "";
				
		try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		var id=id.parentNode.parentNode.rowIndex;
		
		for(var i=0; i<=rowCount; i++) {
			if(id == i) {
				table.deleteRow(i);
				$.getJSON('../json-keuangansiuk/referensi_detil_monitoring_delete.php?reqId=<?=$reqId?>&reqRowId='+reqRowId, function (data)
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Setting Referensi Umum</span>
            </div>            
            </td>
        </tr>
    </table>
    
    <div id="konten">
        <table class="gradient-class-style" id="dataTableRowDinamis">
        <thead>
        <tr>
            <th scope="col">
            Kode Detil
            <a style="cursor:pointer" title="Tambah" onclick="addRowDrawTables('dataTableRowDinamis')"><img src="../WEB-INF/images/tree-add.png" width="16" height="16" border="0" /></a>
            </th>
            <th scope="col">Keterangan</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
        </tr>
        </thead>
        <tbody>
    
        <?
        $i=0;
        while($referensi_detil->nextRow())
        {
        ?>
            <?php /*?><tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'referensi_detil_monitoring.php?reqId=<?=$reqId?>&reqRowId=<?=$referensi_detil->getField("REFERENSI_DETIL_ID")?>'"><?php */?>
            <tr>
                <input type="hidden" id="reqRowId<?=$i?>" value="<?=$referensi_detil->getField("ID_REF_DATA")?>">
                <td><input type="text" id="reqIdRefData<?=$i?>" disabled class="easyui-validatebox" required style="border:none; background:inherit" value="<?=$referensi_detil->getField("ID_REF_DATA")?>" /></td>
                <td><input type="text" id="reqKetRefData<?=$i?>" disabled style="border:none; background:inherit; width:400px;" value="<?=$referensi_detil->getField("KET_REF_DATA")?>" /></td>
                <td>
                    <select id="reqKdAktif<?=$i?>" name="reqKdAktif[<?=$i?>]" disabled >
                        <option value="A" <? if($referensi_detil->getField("KD_AKTIF") == "A") echo "selected";?>>AKTIF</option>
                        <option value="" <? if($referensi_detil->getField("KD_AKTIF") == "") echo "selected";?>>TIDAK AKTIF</option>
                    </select>
                <td>
                    <input type="button" onClick="setSimpan('<?=$i?>')" id="reqButton<?=$i?>" value="Update" />
                    <input type="button" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this, '<?=$referensi_detil->getField("ID_REF_DATA")?>')" value="Hapus" />
                </td>
            </tr>    
        <?
        $i++;
        }
        ?>    
        </table>
    </div>
    
</div>
</body>
</html>