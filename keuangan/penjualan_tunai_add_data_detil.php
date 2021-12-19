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
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");


/* create objects */
$kptt_nota_d = new KpttNotaD();
$kbbr_tipe_trans_d = new KbbrTipeTransD();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqRowId= httpFilterGet("reqRowId");

if($reqRowId == "")
	$reqMode = "insert";
else
	$reqMode = "update";

$kbbr_tipe_trans_d->selectByParams(array("TIPE_TRANS" => "JKM-KPT-03", "KD_AKTIF" => "A"));
while($kbbr_tipe_trans_d->nextRow())
{
	$arrTipeTrans["KLAS_TRANS"][] = $kbbr_tipe_trans_d->getField("KLAS_TRANS");
	$arrTipeTrans["KETK_TRANS"][] = $kbbr_tipe_trans_d->getField("KETK_TRANS");		
}

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
				url:'../json-keuangansiuk/penjualan_tunai_add_data_detil.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					document.location.href = 'penjualan_tunai_add_data_detil.php?reqId=JKM-KPT-03&reqRowId='+data[0];
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
		
		//alert(rowCount);
		var column0= row.insertCell(0);
		//column0.innerHTML = '<center>'+rowCount+'</center>';
		column0.innerHTML = rowCount;
		
		var column1 = row.insertCell(1);
		var combo1 = document.createElement("select");
		combo1.style.width = '250px';
		combo1.setAttribute("name", "reqKlasTrans[]"); 
		combo1.setAttribute("id", "reqKlasTrans"+id_row); 
		
		$.getJSON("../json-keuangansiuk/jenis_jasa_lookup_json.php?reqTipeTrans=JKM-KPT-03",
		function(data){
			for(i=0;i<data.KLAS_TRANS.length; i++)
			{
				var option_element1 = document.createElement('option');
				option_element1.setAttribute('value', data.KLAS_TRANS[i]);
				option_element1.appendChild( document.createTextNode( data.KETK_TRANS[i] ) );
				combo1.appendChild(option_element1);
			} 
		});
		combo1.onchange = function() {  
			$.getJSON("../json-keuangansiuk/get_jenis_jasa_kena_pajak_json.php?reqTipeTrans=JKM-KPT-03&reqKlasTrans="+$("#reqKlasTrans"+id_row).val(),
			function(data){
				$("#reqPajak"+id_row).val(data.STATUS_KENA_PAJAK[0]);
			});			
		};
		column1.appendChild(combo1);		
		
		var column2= row.insertCell(2);
        var element2 = document.createElement("input");
        element2.type = "text";
		element2.name = "reqPajak[]";
		element2.id = "reqPajak"+id_row;
		element2.readOnly = "true";
		element2.style.width = '40px';
		element2.className='easyui-validatebox';
        column2.appendChild(element2);

		var column3= row.insertCell(3);
        var element3= document.createElement("input");
        element3.type = "text";
		element3.name = "reqLbr[]";
		element3.style.width = '40px';
		element3.className='easyui-validatebox';
        column3.appendChild(element3);
		
		var column4= row.insertCell(4);
        var element4= document.createElement("input");
        element4.type = "text";
		element4.name = "reqNilaiJasa[]";
		element4.id = "reqNilaiJasa"+id_row;
		element4.style.width = '100px';
		element4.className='easyui-validatebox';
		element4.onfocus = function() {  
			FormatAngka("reqNilaiJasa"+id_row);
		};
		element4.onkeyup = function() {  
			FormatUang("reqNilaiJasa"+id_row);	
			var nilai = FormatAngkaNumber($("#reqNilaiJasa"+id_row).val());
			if($("#reqPajak"+id_row).val() == 'Y')
			{
				// PERHITUNGAN PAJAK PER TRANSAKSI
				var prosen_pajak = parent.frames["mainFramePop"].document.getElementById("reqPersenPajak").value;
				var pajak = nilai * (prosen_pajak / 100);
				var total = Number(nilai) + Math.round(pajak);
				$("#reqNilaiPajak"+id_row).val(Math.round(pajak));
				$("#reqJumlah"+id_row).val(total);
				FormatUang("reqNilaiPajak"+id_row);
			}
			else
			{
				$("#reqNilaiPajak"+id_row).val('');	
				$("#reqJumlah"+id_row).val(nilai);
			}
			FormatUang("reqJumlah"+id_row);
			hitungTotal(tableID);
				
		};
		element4.onblur = function() {  
			FormatUang("reqNilaiJasa"+id_row);
		};
        column4.appendChild(element4);
		
		var column6 = row.insertCell(5);
        var element6 = document.createElement("input");
        element6.type = "text";
		element6.name = "reqNilaiPajak[]";
		element6.readOnly = "true";
		element6.id = "reqNilaiPajak"+id_row;
		element6.onfocus = function() {  
			FormatAngka("reqNilaiPajak"+id_row);
		};
		element6.onkeyup = function() {  
			FormatUang("reqNilaiPajak"+id_row);
		};
		element6.onblur = function() {  
			FormatUang("reqNilaiPajak"+id_row);
		};
		element6.style.width = '100px';
		element6.className='easyui-validatebox';
        column6.appendChild(element6);
		<?php /*?>$('#reqDebet'+id_row).validatebox({  
			required: true
		});<?php */?>
		
		var column6 = row.insertCell(6);
        var element6 = document.createElement("input");
        element6.type = "text";
		element6.readOnly = "true";
		element6.name = "reqJumlah[]";
		element6.id = "reqJumlah"+id_row;
		element6.onfocus = function() {  
			FormatAngka("reqJumlah"+id_row);
		};
		element6.onkeyup = function() {  
			FormatUang("reqJumlah"+id_row);
		};
		element6.onblur = function() {  
			FormatUang("reqJumlah"+id_row);
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
		parent.frames["mainFramePop"].document.getElementById("reqJumlahDiBayar").value = FormatCurrency(total);
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
		hitungTotal(tableID);
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
<body onLoad="hitungTotal('dataTableRowDinamis');">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <form id="ff" method="post" novalidate>

    <table class="example" id="dataTableRowDinamis">
    <thead>
      <tr>
          <th width="50px">
          	No
            <a style="cursor:pointer" title="Tambah" onclick="addRowDrawTables('dataTableRowDinamis')"><img src="../WEB-INF/images/tree-add.png" width="16" height="16" border="0" /></a>
          </th>
          <th>Jenis Jasa</th>
          <th>Pajak?</th>
          <th>Lbr(Pas)</th>
          <th>Nilai Jasa</th>
          <th>Nilai Pajak</th>
          <th>Jumlah</th>
          <th>Aksi</th>
      </tr>
    </thead>
    <tbody> 
	  <?
	  $i = 1;
	  $checkbox_index = 0;
	  
	  $kptt_nota_d->selectByParams(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY LINE_SEQ ASC ");
      while($kptt_nota_d->nextRow())
      {
      ?>
          <tr id="node-<?=$i?>">
          	  <td><?=$i?></td>
              <td>
              	<select style="width:250px;" name="reqKlasTrans[]">
                <?
                for($j=0;$j<count($arrTipeTrans["KLAS_TRANS"]);$j++)
				{
				?>
                	<option value="<?=$arrTipeTrans["KLAS_TRANS"][$j]?>" <? if($kptt_nota_d->getField("KLAS_TRANS") == $arrTipeTrans["KLAS_TRANS"][$j]) { ?> selected <? } ?>><?=$arrTipeTrans["KETK_TRANS"][$j]?></option>
                <?
				}
				?>
                </select>
              </td>
              <td>
              	<input type="text" name="reqPajak[]" style="width:40px" readonly class="easyui-validatebox" value="<?=$kptt_nota_d->getField("STATUS_KENA_PAJAK")?>" />
              </td>
			  <td>
                <input type="text" name="reqLbr[]" style="width:40px" class="easyui-validatebox" value="" />
              </td>
              <td>
              	<input type="text" style="width:100px;" name="reqNilaiJasa[]"  id="reqNilaiJasa<?=$checkbox_index?>"  OnFocus="FormatAngka('reqNilaiJasa<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiJasa<?=$checkbox_index?>')" OnBlur="FormatUang('reqNilaiJasa<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JML_RP_TRANS'))?>">
              </td>
              <td>
              	<input type="text" style="width:100px;" name="reqNilaiPajak[]"  id="reqNilaiPajak<?=$checkbox_index?>" readonly OnFocus="FormatAngka('reqNilaiPajak<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiPajak<?=$checkbox_index?>')" OnBlur="FormatUang('reqNilaiPajak<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JML_RP_PAJAK'))?>">
              </td>
              <td>
              	<input type="text" style="width:100px;" name="reqJumlah[]"  id="reqJumlah<?=$checkbox_index?>" readonly  OnFocus="FormatAngka('reqJumlah<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlah<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlah<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JUMLAH_TOTAL'))?>">
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
            <input type="hidden" id="reqId" name="reqId" value="<?=$reqRowId?>">
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