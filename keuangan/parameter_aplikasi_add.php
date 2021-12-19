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
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrRuleModul.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");


/* create objects */
$parameter_aplikasi = new KbbrRuleModul();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqRowId= httpFilterGet("reqRowId");


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
				url:'../json-keuangansiuk/parameter_aplikasi_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					//$('#rst_form').click();
					//document.location.href = 'parameter_aplikasi_add.php?reqId=<?=$reqId?>';
					//top.frames['mainFrame'].location.reload();
					<?php /*?><? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?><?php */?>
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
	
    </script>
</head> 
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Rule Aplikasi</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table class="example" id="dataTableJabatanKru">
    <thead>
      <tr>
          <th>
          	Kode
          </th>
          <th>Keterangan</th>
          <th>Value</th>
          <th>Default Value</th>
          <th>Status</th>
      </tr>
    </thead>
    <tbody> 
	  <?
	  $i = 1;
	  $checkbox_index = 0;
	  
	  $kondisi_status_by_params=$parameter_aplikasi->getCountByParams(array("KD_SUBSIS"=>$reqId));
	  
      $parameter_aplikasi->selectByParams(array("KD_SUBSIS"=>$reqId),-1,-1,"", "ORDER BY KD_RULE ASC");
	  //echo $parameter_aplikasi->query;
	  
      while($parameter_aplikasi->nextRow())
      {
      ?>
          <tr id="node-<?=$reqId.'-'.$parameter_aplikasi->getField('KD_RULE')?>">
          	  	<input type="hidden" name="reqRowId[<?=$checkbox_index?>]" value="<?=$parameter_aplikasi->getField("KD_RULE")?>" />
              <td>
              	<input type="text" class="easyui-validatebox" style="width:150px; background-color:#f0f0f0" name="reqKode[<?=$checkbox_index?>]" id="reqKode<?=$checkbox_index?>" readonly value="<?=$parameter_aplikasi->getField("KD_RULE")?>"  />
              </td>
              <td>
              	<input type="text" name="reqKeterangan[<?=$checkbox_index?>]" style="width:300px; background-color:#f0f0f0" class="easyui-validatebox" readonly value="<?=$parameter_aplikasi->getField('KET_RULE')?>" />
              </td>
			  <td>
                <input type="text" name="reqValue[<?=$checkbox_index?>]" style="width:80px; background-color:#f0f0f0" class="easyui-validatebox" readonly value="<?=$parameter_aplikasi->getField('PILIHAN')?>" />
              </td>
              <td>
              	<input type="text" name="reqStatus[<?=$checkbox_index?>]" style="width:80px" class="easyui-validatebox" value="<?=$parameter_aplikasi->getField('STATUS')?>" />
              </td>
              <td>
              	<select name="reqKodeAktif[<?=$checkbox_index?>]">
                	<option></option>
                    <option value="<?=$parameter_aplikasi->getField('KD_AKTIF')?>" <? if($parameter_aplikasi->getField('KD_AKTIF') == "A") echo "selected";?>>AKTIF</option>
                </select>
              </td>
          </tr>
      <?php
	  	$i++;
		$checkbox_index++;
      }
      ?>  
    </tbody>            
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="insert">
            <input type="hidden" name="reqArrayIndex" id="reqArrayIndex" value="<?=$checkbox_index?>">
            <input type="submit" value="Submit">
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