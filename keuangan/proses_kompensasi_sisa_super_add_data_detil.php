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
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");


/* create objects */
$kppt_nota_d = new KpttNotaD();

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
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/proses_kompensasi_sisa_super_add_data_detil.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("#");
					$.messager.alert('Info', data[1], 'info');
					document.location.href = 'proses_kompensasi_sisa_super_add_data_detil.php?reqId='+data[0];
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
		
		var column1= row.insertCell(0);
        var element1 = document.createElement("input");
        element1.type = "text";
		element1.name = "reqNoNota["+ id_row +"]";
		element1.id = "reqNoNota"+id_row;
		element1.style.width = '100px';
		element1.className='easyui-validatebox';
        column1.appendChild(element1);
		
		var column2= row.insertCell(1);
        var element2 = document.createElement("input");
        element2.type = "text";
		element2.name = "reqSumberBayar["+ id_row +"]";
		element2.id = "reqSumberBayar"+id_row;
		element2.style.width = '80px';
		element2.className='easyui-validatebox';
        column2.appendChild(element2);
		<?php /*?>$('#reqTanggalKadaluarsa'+id_row).datebox({  
			validType:'date'
		});  <?php */?>
		
		var column2= row.insertCell(2);
        var element2 = document.createElement("input");
        element2.type = "text";
		element2.name = "reqKartu["+ id_row +"]";
		element2.id = "reqKartu"+id_row;
		element2.style.width = '80px';
		element2.className='easyui-validatebox';
        column2.appendChild(element2);
		
		//alert(rowCount);
		var column0= row.insertCell(3);
		//column0.innerHTML = '<center>'+rowCount+'</center>';
		column0.innerHTML = rowCount;
		
		var column2= row.insertCell(4);
        var element2 = document.createElement("input");
        element2.type = "text";
		element2.name = "reqNoRef1["+ id_row +"]";
		element2.id = "reqNoRef1"+id_row;
		element2.style.width = '80px';
		element2.className='easyui-validatebox';
        column2.appendChild(element2);
		
		var column3= row.insertCell(5);
        var element3= document.createElement("input");
        element3.type = "text";
		element3.name = "reqTanggalTransaksi["+ id_row +"]";
		element3.id = "reqTanggalTransaksi"+id_row;
		element3.style.width = '80px';
		element3.className='easyui-datebox';
        column3.appendChild(element3);
		$('#reqTanggalTransaksi'+id_row).datebox({  
			validType:'date'
		});  
		
		var column4= row.insertCell(6);
        var element4= document.createElement("input");
        element4.type = "text";
		element4.name = "reqJumlah["+ id_row +"]";
		element4.id = "reqJumlah"+id_row;
		element4.style.width = '100px';
		element4.className='easyui-validatebox';
		element4.onfocus = function() {  
			FormatAngka("reqJumlah"+id_row);
		};
		element4.onkeyup = function() {  
			FormatUang("reqJumlah"+id_row);
		};
		element4.onblur = function() {  
			FormatUang("reqJumlah"+id_row);
		};
        column4.appendChild(element4);
		
		var column6 = row.insertCell(7);
        var element6 = document.createElement("input");
        element6.type = "text";
		element6.name = "reqSisaTagihan["+ id_row +"]";
		element6.id = "reqSisaTagihan"+id_row;
		element6.onfocus = function() {  
			FormatAngka("reqSisaTagihan"+id_row);
		};
		element6.onkeyup = function() {  
			FormatUang("reqSisaTagihan"+id_row);
		};
		element6.onblur = function() {  
			FormatUang("reqSisaTagihan"+id_row);
		};
		element6.style.width = '100px';
		element6.className='easyui-validatebox';
        column6.appendChild(element6);
		<?php /*?>$('#reqDebet'+id_row).validatebox({  
			required: true
		});<?php */?>
		
		var column6 = row.insertCell(8);
        var element6 = document.createElement("input");
        element6.type = "text";
		element6.name = "reqJumlahDibayar["+ id_row +"]";
		element6.id = "reqJumlahDibayar"+id_row;
		element6.onfocus = function() {  
			FormatAngka("reqJumlahDibayar"+id_row);
		};
		element6.onkeyup = function() {  
			FormatUang("reqJumlahDibayar"+id_row);
		};
		element6.onblur = function() {  
			FormatUang("reqJumlahDibayar"+id_row);
		};
		element6.style.width = '100px';
		element6.className='easyui-validatebox';
        column6.appendChild(element6);
		
		var column7= row.insertCell(9);
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
          No Nota
          <a style="cursor:pointer" title="Tambah" onclick="addRowDrawTables('dataTableRowDinamis')"><img src="../WEB-INF/images/tree-add.png" width="16" height="16" border="0" /></a>
          </th>
          <th>Sumber Bayar</th>
          <th>Kartu</th>
          <th>No</th>
          <th>No. Ref 1</th>
          <th>Tanggal Transaksi</th>
          <th>Jumlah</th>
          <th>Sisa Tagihan</th>
          <th>Jumlah Dibayar</th>
          <th>Aksi</th>
      </tr>
    </thead>
    <tbody> 
	  <?
	  $i = 1;
	  $checkbox_index = 0;
	  $kppt_nota_d->selectByParams(array("NO_NOTA"=>$reqId), -1, -1, "", "ORDER BY LINE_SEQ ASC");
	  
      while($kppt_nota_d->nextRow())
      {
      ?>
          <tr id="node-<?=$i?>">
              <td>
              	<input type="text" name="reqNoNota[<?=$checkbox_index?>]" style="width:100px" class="easyui-validatebox" value="<?=$kppt_nota_d->getField("NO_REF3")?>" />
              </td>
              <td>
              	<input type="text" name="reqSumberBayar[<?=$checkbox_index?>]" style="width:80px" class="easyui-validatebox" value="<?=$kppt_nota_d->getField("KLAS_TRANS")?>" />
              </td>
              <td>
              	<input type="text" name="reqKartu[<?=$checkbox_index?>]" style="width:80px" class="easyui-validatebox" value="<?=$kppt_nota_d->getField("KD_SUB_BANTU")?>" />
              </td>
              <td><?=$kppt_nota_d->getField("LINE_SEQ")?></td>
              <td>
              	<input type="text" name="reqNoRef1[<?=$checkbox_index?>]" style="width:80px" class="easyui-validatebox" value="<?=$kppt_nota_d->getField("NO_REF1")?>" />
              </td>
			  <td>
                <input type="text" name="reqTanggalTransaksi[<?=$checkbox_index?>]" style="width:80px" class="easyui-datebox" data-options="validType:'date'"  value="<?=$kppt_nota_d->getField("")?>" />
              </td>
              <td>
              	<input type="text" style="width:100px;" name="reqJumlah[]"  id="reqJumlah<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlah<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlah<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlah<?=$checkbox_index?>')" value="<?=numberToIna($kppt_nota_d->getField(""))?>">
              </td>
              <td>
              	<input type="text" style="width:100px;" name="reqSisaTagihan[]"  id="reqSisaTagihan<?=$checkbox_index?>"  OnFocus="FormatAngka('reqSisaTagihan<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisaTagihan<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisaTagihan<?=$checkbox_index?>')" value="<?=numberToIna($kppt_nota_d->getField(""))?>">
              </td>
              <td>
              	<input type="text" style="width:100px;" name="reqJumlahDibayar[]"  id="reqJumlahDibayar<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahDibayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahDibayar<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlahDibayar<?=$checkbox_index?>')" value="<?=numberToIna($kppt_nota_d->getField("JML_VAL_TRANS"))?>">
              </td>
              <td align="center">
              <label>
              <a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
              </label>
              
              </td>
          </tr>
      <?php
	  	$i++;
		$checkbox_index++;
      }
      ?>  
    </tbody>            
    </table>
        <div style="display:none">
            <input type="hidden" id="reqId" name="reqId" value="<?=$reqId?>">
            <input type="hidden" id="reqValutaNama" name="reqValutaNama" value="<?=$tempValutaNama?>">
            <input type="hidden" id="reqKursValuta" name="reqKursValuta" value="<?=$tempKursValuta?>">
            <input type="hidden" name="reqArrayIndex" id="reqArrayIndex" value="<?=$checkbox_index?>" />
            <input type="text" id="reqMode" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" name="btnSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
	</form>
</div>
<script>
$('input[id^="reqJumlahDibayar"]').keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>