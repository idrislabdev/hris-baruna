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
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbDTmp.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");


/* create objects */
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

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
				url:'../json-keuangansiuk/jurnal_pengeluaran_kas_bank_add_data_detil.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					alert(data);
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					document.location.href = 'jurnal_pengeluaran_kas_bank_add_data_detil.php?reqId='+data[0];
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
		//column0.innerHTML = '<center>'+rowCount+'</center>';
		column0.innerHTML = rowCount;
		//alert(rowCount);
		/*var column1= row.insertCell(0);
        var element1 = document.createElement("input");
        element1.type = "text";
		element1.name = "reqNoSeq["+ id_row +"]";
		element1.id = "reqNoSeq"+id_row;
		element1.style.width = '10px';
		element1.className='easyui-validatebox';
        column1.appendChild(element1);*/
		
		var column1= row.insertCell(1);
        var element1 = document.createElement("input");
        element1.type = "text";
		element1.name = "reqBukuBesar["+ id_row +"]";
		element1.id = "reqBukuBesar"+id_row;
		element1.style.width = '100px';
		element1.className='easyui-validatebox';
        column1.appendChild(element1);
		
		var column2= row.insertCell(2);
        var element2 = document.createElement("input");
        element2.type = "text";
		element2.name = "reqKartu["+ id_row +"]";
		element2.id = "reqKartu"+id_row;
		element2.style.width = '100px';
		element2.className='easyui-validatebox';
        column2.appendChild(element2);
		
		var column3= row.insertCell(3);
        var element3= document.createElement("input");
        element3.type = "text";
		element3.name = "reqBukuPusat["+ id_row +"]";
		element3.style.width = '100px';
		element3.className='easyui-validatebox';
        column3.appendChild(element3);
		
		var column4= row.insertCell(4);
        var element4= document.createElement("input");
        element4.type = "text";
		element4.name = "reqKeterangan["+ id_row +"]";
		element4.style.width = '415px';
		element4.className='easyui-validatebox';
        column4.appendChild(element4);
		
		var column6 = row.insertCell(5);
        var element6 = document.createElement("input");
        element6.type = "text";
		element6.name = "reqDebet["+ id_row +"]";
		element6.id = "reqDebet"+id_row;
		element6.onfocus = function() {  
			FormatAngka("reqDebet"+id_row);
		};
		element6.onkeyup = function() {  
			FormatUang("reqDebet"+id_row);
		};
		element6.onblur = function() {  
			FormatUang("reqDebet"+id_row);
		};
		
		element6.style.width = '100px';
		element6.className='easyui-validatebox';
        column6.appendChild(element6);
		
		
		var column6 = row.insertCell(6);
        var element6 = document.createElement("input");
        element6.type = "text";
		element6.name = "reqKredit["+ id_row +"]";
		element6.id = "reqKredit"+id_row;
		element6.onfocus = function() {  
			FormatAngka("reqKredit"+id_row);
		};
		element6.onkeyup = function() {  
			FormatUang("reqKredit"+id_row);
		};
		element6.onblur = function() {  
			FormatUang("reqKredit"+id_row);
		};
		element6.style.width = '100px';
		element6.className='easyui-validatebox';
        column6.appendChild(element6);
		
		var column7= row.insertCell(7);
		var add_label = document.createElement('label');
		add_label.style.textAlign='center';
		column7.appendChild(add_label);
		add_label.innerHTML = '<center><a style="cursor:pointer;" onclick="deleteRowDrawTable(\'dataTableRowDinamis\', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center>';
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
          <th>
          	No
            <a style="cursor:pointer" title="Tambah" onclick="addRowDrawTables('dataTableRowDinamis')"><img src="../WEB-INF/images/tree-add.png" width="16" height="16" border="0" /></a>
          </th>
          <th>Buku&nbsp;Besar</th>
          <th>Kartu</th>
          <th>Buku Pusat</th>
          <th>Keterangan</th>
          <th>Debet</th>
          <th>Kredit</th>
          <th>Aksi</th>
      </tr>
    </thead>
    <tbody> 
      <?
	  $i = 1;
	  $checkbox_index = 0;
	  
	  $kbbt_jur_bb_d_tmp->selectByParams(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY NO_SEQ ASC ");
      while($kbbt_jur_bb_d_tmp->nextRow())
	  {
      ?>
          <tr id="node-<?=$i?>">
          	  <td><?=$i?></td>
              <td>
              	<input type="text" name="reqBukuBesar[<?=$checkbox_index?>]" style="width:100px" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_BESAR")?>" />
              </td>
              <td>
              	<input type="text" name="reqKartu[<?=$checkbox_index?>]" style="width:100px" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KD_SUB_BANTU")?>" />
              </td>
              <td>
              	<input type="text" name="reqBukuPusat[<?=$checkbox_index?>]" style="width:100px" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_PUSAT")?>" />
              </td>
              <td>
              	<input type="text" name="reqKeterangan[<?=$checkbox_index?>]" style="width:415px" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KET_TAMBAH")?>" />
              </td>
              <td>
              	<input type="text" style="width:100px;" name="reqDebet[]" id="reqDebet<?=$checkbox_index?>"  OnFocus="FormatAngka('reqDebet<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqDebet<?=$checkbox_index?>');" OnBlur="FormatUang('reqDebet<?=$checkbox_index?>')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_DEBET'))?>">
              </td>
              <td>
              	<input type="text" style="width:100px;" name="reqKredit[]" id="reqKredit<?=$checkbox_index?>"  OnFocus="FormatAngka('reqKredit<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqKredit<?=$checkbox_index?>');" OnBlur="FormatUang('reqKredit<?=$checkbox_index?>')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_KREDIT'))?>">
              </td>
              <td align="center">
              <label>
              <a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
              </label>
              </td>
          </tr>
      <?
	  	$i++;
		$checkbox_index++;
		$temp_jml_debet += $kbbt_jur_bb_d_tmp->getField('SALDO_VAL_DEBET');
        $temp_jml_kredit += $kbbt_jur_bb_d_tmp->getField('SALDO_VAL_KREDIT');
      }
      ?>
    </tbody>            
    </table>
        <div style="display:none">
            <input type="hidden" id="reqId" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqArrayIndex" id="reqArrayIndex" value="<?=$checkbox_index?>" />
            <input type="hidden" id="reqMode" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" name="btnSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
	</form>
</div>
<script>
$('input[id^="reqJumlah"]').keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>