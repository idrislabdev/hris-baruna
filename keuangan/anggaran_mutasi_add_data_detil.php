<?
/* *******************************************************************************************************
MODUL NAME 			: informasi Kategori
FILE NAME 			: informasi_kategori.php
AUTHOR				: Aon-Prog
VERSION				: 1.0 beta
MODIFICATION DOC	:
DESCRIPTION			: Halaman untuk menampilkan informasi kategori
******************************************************************************************************* */

include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiDetil.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");


/* create objects */
$anggaran_mutasi_detil = new AnggaranMutasiDetil();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqPeriode= httpFilterGet("reqPeriode");

if($reqId == "")
	$reqMode = "insert";
else
	$reqMode = "update";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<script type="text/javascript">
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
		
		$(function(){
			$('#ff').form({
				url:'../json-anggaran/anggaran_mutasi_add_data_detil.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					document.location.href = 'anggaran_mutasi_add_data_detil.php?reqId='+data[0];
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.ui.js"></script>
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/src/javascripts/jquery.treeTable.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    $(".example").treeTable({
      initialState: "expanded"
    });
    
    // Drag & Drop Example Code
    $("#dnd-example .file, #dnd-example .folder").draggable({
      helper: "clone",
      opacity: .75,
      refreshPositions: true,
      revert: "invalid",
      revertDuration: 300,
      scroll: true
    });
    
    $("#dnd-example .folder").each(function() {
      $($(this).parents("tr")[0]).droppable({
        accept: ".file, .folder",
        drop: function(e, ui) { 
          $($(ui.draggable).parents("tr")[0]).appendBranchTo(this);
          
          // Issue a POST call to send the new location (this) of the 
          // node (ui.draggable) to the server.
          $.post("move.php", {id: $(ui.draggable).parents("tr")[0].id, to: this.id});
        },
        hoverClass: "accept",
        over: function(e, ui) {
          if(this.id != $(ui.draggable.parents("tr.parent")[0]).id && !$(this).is(".expanded")) {
            $(this).expand();
          }
        }
      });
    });
    
    // Make visible that a row is clicked
    $("table#dnd-example tbody tr").mousedown(function() {
      $("tr.selected").removeClass("selected"); // Deselect currently selected rows
      $(this).addClass("selected");
    });
    
    // Make sure row is selected when span is clicked
    $("table#dnd-example tbody tr span").mousedown(function() {
      $($(this).parents("tr")[0]).trigger("mousedown");
    });
    });
	
	function addRowDrawTables(tableID) {
		var table = document.getElementById(tableID);
	
		var rowCount = table.rows.length;
		var id_row = rowCount-1;
		var row = table.insertRow(rowCount);
		$('#reqArrayIndex').val(rowCount);
		
		var column0= row.insertCell(0);
		column0.setAttribute('style', 'text-align: center;');
		column0.innerHTML = rowCount;
		
		var column1= row.insertCell(1);
        var element1 = document.createElement("input");
        element1.type = "text";
		element1.name = "reqNama["+ id_row +"]";
		element1.id = "reqNama"+id_row;
		element1.style.width = '300px';
		column1.setAttribute('style', 'text-align: center;');
		element1.className='easyui-validatebox';
        column1.appendChild(element1);
		
		var column2= row.insertCell(2);
        var element2 = document.createElement("input");
        element2.type = "text";
		element2.name = "reqUnit["+ id_row +"]";
		element2.id = "reqUnit"+id_row;
		element2.style.width = '50px';
		column2.setAttribute('style', 'text-align: center;');
		element2.className='easyui-validatebox';
		element2.onkeyup = function() {  
			hitungJumlahHargaUnit(id_row, tableID);
		};
        column2.appendChild(element2);
		
		$('input[id^="reqUnit"]').keypress(function(e) {
			if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
			{
			return false;
			}
		});
		
		var column6 = row.insertCell(3);
        var element6 = document.createElement("input");
        element6.type = "text";
		element6.name = "reqHargaSatuan["+ id_row +"]";
		element6.id = "reqHargaSatuan"+id_row;
		column6.setAttribute('style', 'text-align: center;');
		element6.onfocus = function() {  
			FormatAngka("reqHargaSatuan"+id_row);
		};
		element6.onkeyup = function() {  
			FormatUang("reqHargaSatuan"+id_row);
			hitungJumlahHargaUnit(id_row, tableID);
		};
		element6.onblur = function() {  
			FormatUang("reqHargaSatuan"+id_row);
		};
		element6.style.width = '100px';
		element6.className='easyui-validatebox';
        column6.appendChild(element6);
		
		var column3= row.insertCell(4);
        var element3= document.createElement("input");
        element3.type = "text";
		element3.name = "reqJumlah["+ id_row +"]";
		element3.id = "reqJumlah"+id_row;
		element3.readOnly = true;
		element3.style.width = '100px';
		column3.setAttribute('style', 'text-align: center;');
		element3.className='easyui-validatebox';
        column3.appendChild(element3);
		
		/*var column6 = row.insertCell(5);
        var element6 = document.createElement("input");
        element6.type = "checkbox";
		column6.setAttribute('style', 'text-align: center;');
		element6.name = "reqStatusVerifikasi["+ id_row +"]";
		element6.id = "reqStatusVerifikasi"+id_row;
        column6.appendChild(element6);*/
		
		var column7= row.insertCell(5);
		var add_label = document.createElement('label');
		add_label.style.textAlign='center';
		column7.appendChild(add_label);
		add_label.innerHTML = '<center><a style="cursor:pointer;" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center>';
	}
	
	var jumlah_total=0;
	function hitungTotal(tableID)
	{
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		var total = 0;
		
		for(var i=0; i<=rowCount; i++) {
			if(typeof $("#reqJumlah"+i).val() == "undefined")
			{}
			else
			{
				jumlah = FormatAngkaNumber($("#reqJumlah"+i).val());
				total = total + Number(jumlah);	
			}
		}
		jumlah_total= total;
		setTimeout(setJumlah, 200);
	}
	
	function setJumlah()
	{
		parent.frames["mainFramePop"].setJumlah(jumlah_total);
	}
	
	function hitungJumlahHargaUnit(id_row, tableID)
	{
		var i = id_row;
		var total= jumlah= 0;
		
		if(typeof $("#reqHargaSatuan"+i).val() == "undefined")
		{}
		else
		{
			jumlah = FormatAngkaNumber($("#reqHargaSatuan"+i).val());
			total = parseInt($("#reqUnit"+i).val()) * Number(jumlah);
		}
		
		$("#reqJumlah"+i).val(FormatCurrency(total));
		
		hitungTotal(tableID);
	}
	
	function deleteRowDrawTable(tableID, id) {
		if(confirm('Apakah anda ingin menghapus data terpilih?') == false)
			return "";
				
		try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		var id=id.parentNode.parentNode.parentNode.parentNode.rowIndex;
		
		for(var i=0; i<=rowCount; i++) {
			if(id == i) {
				table.deleteRow(i);
			}
		}
		}catch(e) {
			alert(e);
		}
	}
	
	function deleteRowDrawTablePhp(tableID, id) {
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
    </script>
</head> 
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <form id="ff" method="post" novalidate>
    <table class="example" id="dataTableRowDinamis">
    <thead>
      <tr>
          <th style="width:5%">
          	No
            <a style="cursor:pointer" title="Tambah" onclick="addRowDrawTables('dataTableRowDinamis')"><img src="../WEB-INF/images/tree-add.png" width="16" height="16" border="0" /></a>
          </th>
          <th style="width:10%">Nama</th>
          <th style="width:10%">Unit</th>
          <th style="width:10%">Harga Satuan</th>
          <th style="width:10%">Jumlah</th>
          <!--<th style="width:1%">Status</th>-->
          <th style="width:5%">Aksi</th>
      </tr>
    </thead>
    <tbody> 
	  <?
	  $i = 1;
	  $checkbox_index = 0;
	  
	  $anggaran_mutasi_detil->selectByParams(array("ANGGARAN_MUTASI_ID"=>$reqId), -1, -1, "", " ORDER BY ANGGARAN_MUTASI_DETIL_ID ASC ");
      while($anggaran_mutasi_detil->nextRow())
	  {
      ?>
          <tr id="node-<?=$i?>">
          	  <td align="center"><?=$i?></td>
              <td align="center">
              	<input type="text" name="reqNama[<?=$checkbox_index?>]" style="width:300px" class="easyui-validatebox" value="<?=$anggaran_mutasi_detil->getField("NAMA")?>" />
              </td>
              <td align="center">
              	<input type="text" name="reqUnit[<?=$checkbox_index?>]" id="reqUnit<?=$checkbox_index?>" style="width:50px" class="easyui-validatebox" OnKeyUp="hitungJumlahHargaUnit('<?=$checkbox_index?>', 'dataTableRowDinamis');" value="<?=$anggaran_mutasi_detil->getField("UNIT")?>" />
              </td>
              <td align="center">
              	<input type="text" style="width:100px;" name="reqHargaSatuan[<?=$checkbox_index?>]" id="reqHargaSatuan<?=$checkbox_index?>"  OnFocus="FormatAngka('reqHargaSatuan<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqHargaSatuan<?=$checkbox_index?>'); hitungJumlahHargaUnit('<?=$checkbox_index?>', 'dataTableRowDinamis');" OnBlur="FormatUang('reqHargaSatuan<?=$checkbox_index?>')" value="<?=numberToIna($anggaran_mutasi_detil->getField('HARGA_SATUAN'))?>">
              </td>
              <td align="center">
              	<input type="text" name="reqJumlah[<?=$checkbox_index?>]" id="reqJumlah<?=$checkbox_index?>" readonly style="width:100px" class="easyui-validatebox" value="<?=numberToIna($anggaran_mutasi_detil->getField("JUMLAH"))?>" />
              </td>
              <?php /*?><td align="center">
              	<input type="checkbox" name="reqStatusVerifikasi[<?=$checkbox_index?>]" id="reqStatusVerifikasi<?=$checkbox_index?>" />
              </td><?php */?>
              <td align="center">
              <label>
              <a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
              </label>
              </td>
          </tr>
      <?
	  	$i++;
		$checkbox_index++;
      }
      ?>
    </tbody>
    </table>
        <div style="display:none">
            <input type="hidden" id="reqId" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqPeriode" value="<?=$reqPeriode?>">
            <input type="hidden" name="reqArrayIndex" id="reqArrayIndex" value="<?=$checkbox_index?>" />
            <input type="hidden" id="reqMode" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" name="btnSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
	</form>
</div>
<script>
$('input[id^="reqUnit"]').keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>