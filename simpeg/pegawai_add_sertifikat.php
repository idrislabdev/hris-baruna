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
include_once("../WEB-INF/classes/base-simpeg/PegawaiSertifikat.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

/* create objects */
$pegawai_sertifikat = new PegawaiSertifikat();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqRowId= httpFilterGet("reqRowId");

if($reqId == "")
{
	echo '<script language="javascript">';
	echo 'alert("Isi data pegawai terlebih dahulu.");';	
	echo 'window.parent.location.href = "pegawai_add.php";';
	echo '</script>';
	exit();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/js/globalfunction.js"></script>
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
				url:'../json-simpeg/pegawai_add_sertifikat.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					//$('#rst_form').click();
					document.location.href = 'pegawai_add_sertifikat.php?reqId=<?=$reqId?>';
					//top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
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
        var element0= document.createElement("input");
        element0.type = "text";
		element0.name = "reqPegawaiSertifikatId["+ id_row +"]";
		element0.style.width = '150px';
		element0.className='easyui-datebox';
        column0.appendChild(element0);

		var column1= row.insertCell(1);
        var element1 = document.createElement("input");
        element1.type = "text";
		element1.name = "reqTanggalTerbit["+ id_row +"]";
		element1.id = "reqTanggalTerbit"+id_row;
		element1.style.width = '80px';
		element1.className='easyui-datebox';
        column1.appendChild(element1);
		
		$('#reqTanggalTerbit'+id_row).datebox({  
			validType:'date'
		});
		
		var column2= row.insertCell(2);
        var element2 = document.createElement("input");
        element2.type = "text";
		element2.name = "reqTanggalKadaluarsa["+ id_row +"]";
		element2.id = "reqTanggalKadaluarsa"+id_row;
		element2.style.width = '80px';
		element2.className='easyui-datebox';
        column2.appendChild(element2);
		$('#reqTanggalKadaluarsa'+id_row).datebox({  
			validType:'date'
		});  
		
		var column3= row.insertCell(3);
        var element3= document.createElement("input");
        element3.type = "text";
		element3.name = "reqGroupKapal["+ id_row +"]";
		element3.style.width = '80px';
		element3.className='easyui-validatebox';
        column3.appendChild(element3);
		
		var column4= row.insertCell(4);
        var element4= document.createElement("input");
        element4.type = "text";
		element4.name = "reqKeterangan["+ id_row +"]";
		element2.style.width = '120px';
		element4.className='easyui-validatebox';
        column4.appendChild(element4);
		
		var column5= row.insertCell(5);
		var add_label = document.createElement('label');
		add_label.style.textAlign='center';
		column5.appendChild(add_label);
		add_label.innerHTML = '<center><a style="cursor:pointer;" onclick="deleteRowDrawTable(\'dataTableJabatanKru\', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a></center>';
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

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Sertifikat Pegawai</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table class="example" id="dataTableJabatanKru">
    <thead>
      <tr>
          <th>
          	Nama Sertifikat
            <a style="cursor:pointer" title="Tambah Petugas" onclick="addRowDrawTables('dataTableJabatanKru')"><img src="../WEB-INF/images/icn_add.gif" width="16" height="16" border="0" /></a>
          </th>
          <th>Tanggal Terbit</th>
          <th>Tanggal Kadaluarsa</th>
          <th>Group</th>
          <th>Keterangan</th>
          <th>Aksi</th>
      </tr>
    </thead>
    <tbody> 
	  <?
	  $i = 1;
	  $checkbox_index = 0;
	  
	  $kondisi_status_by_params=$pegawai_sertifikat->getCountByParams(array('PEGAWAI_ID'=>$reqId));
	  
      $pegawai_sertifikat->selectByParams(array('PEGAWAI_ID'=>$reqId),-1,-1);

	  //echo $pegawai_sertifikat->query;
      while($pegawai_sertifikat->nextRow())
      {
      ?>
          <tr id="node-<?=$pegawai_sertifikat->getField('SERTIFIKAT_PEGAWAI_ID')?>">
              <td>
              <input type="text" class="easyui-validatebox" style="width:150px" name="reqPegawaiSertifikatId[<?=$checkbox_index?>]" id="reqPegawaiSertifikatId" value="<?=$pegawai_sertifikat->getField("NAMA")?>"  />
              </td>
              <td>
              	<input type="text" name="reqTanggalTerbit[<?=$checkbox_index?>]" style="width:80px" class="easyui-datebox" data-options="validType:'date'" value="<?=dateToPageCheck($pegawai_sertifikat->getField('TANGGAL_TERBIT'))?>" />
              </td>
			  <td>
                <input type="text" name="reqTanggalKadaluarsa[<?=$checkbox_index?>]" style="width:80px" class="easyui-datebox" data-options="validType:'date'" value="<?=dateToPageCheck($pegawai_sertifikat->getField('TANGGAL_KADALUARSA'))?>" />
              </td>
              <td>
              	<input type="text" class="easyui-validatebox" style="width:80px" name="reqGroupKapal[<?=$checkbox_index?>]" id="reqGroupKapal" value="<?=$pegawai_sertifikat->getField("GROUP_SERTIFIKAT")?>"  />
              </td>
              <td>
              	<input type="text" class="easyui-validatebox" style="width:120px" name="reqKeterangan[<?=$checkbox_index?>]" id="reqKeterangan" value="<?=$pegawai_sertifikat->getField("KETERANGAN")?>"  />
              </td>
              <td align="center">
              <label style="text-align:center">
              <?
			  if($kondisi_status_by_params > 0)
			  {
              ?>
 	          <a href="#" onClick="parent.OpenDHTML('pegawai_add_sertifikat_add_upload.php?reqId=<?=$pegawai_sertifikat->getField('PEGAWAI_SERTIFIKAT_ID')?>&reqRowId=<?=$reqId?>', 'Sertifikat Pegawai', 880, 410)"><img src="../WEB-INF/images/download.png" height="25" title="Upload"></a>
              <?
			  }
              ?>
              <a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableJabatanKru', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
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