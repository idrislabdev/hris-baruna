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
include_once("../WEB-INF/classes/base-operasional/SuratPerintahPegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

/* create objects */
$surat_perintah_pegawai = new SuratPerintahPegawai();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqRowId= httpFilterGet("reqRowId");

$surat_perintah_pegawai->selectByParamsSuratPerintah(array("B.SURAT_PERINTAH_ID" => $reqId));

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
				url:'../json-simpeg/surat_perintah_setujui.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					top.frames['mainFrame'].location.reload();
					window.parent.divwin.close();
					
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
	
	function setCheck(index)
	{
		
		if (document.getElementById('reqCheck'+index).checked)	
			document.getElementById('reqPilih'+index).value = 1;
		else
			document.getElementById('reqPilih'+index).value = 0;		
		
	}

    </script>
</head> 
<body onLoad="setValue()">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Persetujuan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table class="example" id="dataTableJabatanKru">
    <thead>
      <tr>
          <th rowspan="2" width="80px">NRP</th>
          <th rowspan="2">Nama</th>
          <th rowspan="2">KJ</th>
          <th colspan="3">Posisi Lama</th>
          <th colspan="3">Posisi Baru</th>
      </tr>
      <tr>
      	<th>Posisi</th>
      	<th>Kapal</th>
      	<th>Off-hire</th>
      	<th>Posisi</th>
      	<th>Kapal</th>
      	<th>On-hire</th>
      </tr>
      <?
	  $i = 0;
      while($surat_perintah_pegawai->nextRow())
	  {
	  ?>
      <tr>
      	<td><input type="hidden" name="reqSuratPerintahPegawaiId[]" value="<?=$surat_perintah_pegawai->getField("SURAT_PERINTAH_PEGAWAI_ID")?>"><?=$surat_perintah_pegawai->getField("NRP")?></td>
      	<td><?=$surat_perintah_pegawai->getField("NAMA")?></td>
      	<td><?=$surat_perintah_pegawai->getField("KELAS")?></td>
      	<td><?=$surat_perintah_pegawai->getField("JABATAN_AWAL")?></td>
      	<td><?=$surat_perintah_pegawai->getField("KAPAL_AWAL")?></td>
		<td>
        <?
        if($surat_perintah_pegawai->getField("JABATAN_AWAL") == "")
		{
		?>

        	<input type="hidden" name="reqPegawaiKapalHistoriIdOff[]"/>       
        	<input type="hidden" name="reqOffHire[]"/>       
        <?
		}
		else
		{
		?>
        	<input type="hidden" name="reqPegawaiKapalHistoriIdOff[]" value="<?=$surat_perintah_pegawai->getField("PEGAWAI_KAPAL_HISTORI_ID_OFF")?>"/>       
        	<input type="text" name="reqOffHire[]" style="width:70px" class="easyui-datebox" data-options="validType:'date'" value="<?=dateToPageCheck($surat_perintah_pegawai->getField("OFF_HIRE"))?>" />
        <?
		}
		?>
        </td>
      	<td><?=$surat_perintah_pegawai->getField("JABATAN_AKHIR")?></td>
      	<td><?=$surat_perintah_pegawai->getField("KAPAL_AKHIR")?></td>
        <td>
        <?
        if($surat_perintah_pegawai->getField("JABATAN_AKHIR") == "")
		{
		?>
        	<input type="hidden" name="reqPegawaiKapalHistoriIdOn[]"/>          
        	<input type="hidden" name="reqOnHire[]"/>       
        <?
		}
		else
		{
		?>
        	<input type="hidden" name="reqPegawaiKapalHistoriIdOn[]" value="<?=$surat_perintah_pegawai->getField("PEGAWAI_KAPAL_HISTORI_ID_ON")?>"/>          
        	<input type="text" name="reqOnHire[]" style="width:70px" class="easyui-datebox" data-options="validType:'date'" value="<?=dateToPageCheck($surat_perintah_pegawai->getField("ON_HIRE"))?>" />
        <?
		}
		?>
        </td>		
      </tr>
      <?
	  $i++;
	  }
	  ?>
    </thead>
    <tbody> 
		
    </tbody>            
    </table>
		<div>
        <input type="hidden" id="reqId" name="reqId" value="<?=$reqId?>">
        &nbsp;&nbsp;<input type="submit" value="Setujui">
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