<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisPenyusutanDetil.php");

$inventaris_penyusutan_detil= new InventarisPenyusutanDetil();

$reqId = httpFilterGet("reqId");

if($reqId == "")
{
	echo '<script language="javascript">';
	echo "alert('Isi data terlebih dahulu.');";	
	echo "window.parent.location.href = 'penyusutan_add.php';";
	echo '</script>';
	exit();
}

$index_mutasi= 0;
$inventaris_penyusutan_detil->selectByParams(array("A.INVENTARIS_PENYUSUTAN_ID"=>$reqId), -1,-1, "", "ORDER BY INVENTARIS_PENYUSUTAN_DETIL_ID ASC");
while($inventaris_penyusutan_detil->nextRow())
{
	$arrPenyusutan[$index_mutasi]["INVENTARIS_RUANGAN_ID"] = $inventaris_penyusutan_detil->getField("INVENTARIS_RUANGAN_ID");
	$arrPenyusutan[$index_mutasi]["NOMOR"] = $inventaris_penyusutan_detil->getField("NOMOR");
	$arrPenyusutan[$index_mutasi]["LOKASI"] = $inventaris_penyusutan_detil->getField("LOKASI");
	$arrPenyusutan[$index_mutasi]["KETERANGAN"] = $inventaris_penyusutan_detil->getField("KETERANGAN");
	$index_mutasi++;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    
	<link rel="stylesheet" type="text/css" href="../WEB-INF/css/gaya.css">
	<link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />       
    
    
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>   
    <script type="text/javascript" src="../WEB-INF/lib/easyui/global-tab-easyui.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    
    
    <script type="text/javascript" src="js/entri_penyusutan.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		 $(function(){
			$('#ff').form({
				url:'../json-inventaris/penyusutan_add_data_detil.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					parent.frames['menuFramePop'].location.href = 'penyusutan_add_menu.php?reqId=' + data[0];
					document.location.href = 'penyusutan_add_data_detil.php?reqId=' + data[0];
				}
			});
			
		});
		
		function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2) - 100;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
		}
		
		function OptionSetInventarisRuangan(index, id){
			$.getJSON("../json-inventaris/inventaris_ruangan_get_info.php?reqId="+id,
			function(data){				
				document.getElementById('reqInventarisRuanganId'+index).value = data.tempId;	
				document.getElementById('reqNomor'+index).value = data.tempNomor;	
				document.getElementById('reqLokasi'+index).value = data.tempLokasi;	
				document.getElementById('reqKeterangan'+index).value = data.tempKeterangan;			
			});	
		}	
	</script>
    
</head>

<body class="bg-kanan-full" style="overflow-y: scroll;">
	<div id="judul-popup">Rincian Inventaris</div>
	<div id="konten">
    	<div id="popup-tabel2">    
    <form id="ff" method="post" novalidate>
    <table class="example" id="dataTableRowDinamis">
    <!--<table class="example altrowstable" id="alternatecolor" >-->
        <thead class="altrowstable">
          <tr>
              <th style="width:4%">
                No
                <a style="cursor:pointer" title="Tambah Rincian" onclick="addRow()"><img src="../WEB-INF/images/icn_add.gif" width="16" height="16" border="0" /></a>
              </th>
              <th style="width:200px">Nomor [F9]</th>
              <th style="width:300px">Lokasi</th>
              <th style="width:300px">Keterangan</th>
              <th style="width:5%">Aksi</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
          <?
		  $i = 1;
          $unit = 0;
		  $harga = 0;
		  $jumlah = 0;		  
          for($checkbox_index=0;$checkbox_index<count($arrPenyusutan);$checkbox_index++)
          {
          ?> 
			  <script type="text/javascript">
					$(function() {
						$('#reqNomor<?=$checkbox_index?>').keydown(function (e) {
							if(e.which == 120)
							{
								OpenDHTMLPopup('penyusutan_add_pencarian.php?reqIndex=<?=$checkbox_index?>', 'Pencarian Arsip', 950, 600);
							}
						});												  			
		
					});
              </script>  
                     
              <tr id="node-<?=$i?>">
                  <td>
                  		<input type="text" name="reqNoUrut[]" id="reqNoUrut<?=$checkbox_index?>" style="width:30px;" class="easyui-validatebox" value="<?=$i?>" />
                  </td>
                  <td>
                    	<input type="hidden" id="reqInventarisRuanganId<?=$checkbox_index?>" name="reqInventarisRuanganId[]" value="<?=$arrPenyusutan[$checkbox_index]["INVENTARIS_RUANGAN_ID"]?>"/>  
                   	 	<input type="text" id="reqNomor<?=$checkbox_index?>" name="reqNomor[]" readonly value="<?=$arrPenyusutan[$checkbox_index]["NOMOR"]?>" style="width:200px;" /> 
                  </td>
                  <td>
                      	<input type="text" id="reqLokasi<?=$checkbox_index?>" name="reqLokasi[]" class="easyui-validatebox" required readonly value="<?=$arrPenyusutan[$checkbox_index]["LOKASI"]?>" style="width:300px;" />
                  </td>
                  <td>
                      	<input type="text" id="reqKeterangan<?=$checkbox_index?>" name="reqKeterangan[]" class="easyui-validatebox" readonly value="<?=$arrPenyusutan[$checkbox_index]["KETERANGAN"]?>" style="width:300px;" />
                  </td>
                  <td align="center">
                  <label>
                  <a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
                  </label>
                  </td>
              </tr>
		  <?		  
            $i++;
          }
		  ?>         
        </tbody>   
        <tfoot class="altrowstable">
        	<tr style="background:#f1f4fc">
            	<td colspan="10">
                    <input type="hidden" name="reqId" value="<?=$reqId?>">
                    <input type="hidden" name="reqMode" value="insert">
                    <input type="submit" value="Submit">
                	<input type="reset" id="rst_form">
                </td>
            </tr>
        </tfoot>  
    </table>    
    </form>
    </div>
</div>
</body>
</html>