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
include_once("../WEB-INF/classes/base-gaji/PotonganKondisi.php");
include_once("../WEB-INF/classes/base-gaji/PotonganKondisiPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

/* create objects */
$potongan_kondisi = new PotonganKondisi();
$potongan_kondisi_pegawai = new PotonganKondisiPegawai();
$jenis_pegawai = new JenisPegawai();
$pegawai = new Pegawai();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
$reqKelas = httpFilterGet("reqKelas");
$reqId = httpFilterGet("reqId");

$jenis_pegawai->selectByParams();
$pegawai->selectByParams(array("A.PEGAWAI_ID" => $reqId));
$pegawai->firstRow();

/*$potongan_kondisi_pegawai->selectByParamsGajiPotongan($reqJenisPegawaiId);
$potongan_kondisi_pegawai->firstRow();
$arrPerhitunganGaji = explode("-", $potongan_kondisi_pegawai->getField("PERHITUNGAN_GAJI"));*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-gaji/pegawai_potongan_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					//$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					window.parent.divwin.close();				
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master.css" rel="stylesheet" type="text/css" />
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
    <script type="text/javascript">
		function getValuePotongan(checkboxid, textboxid, prefix)
		{
			if(document.getElementById(checkboxid).checked)
			{
				$(function(){
					$.getJSON('../json-gaji/get_jumlah_potongan.php?reqId=<?=$reqId?>&reqPrefix=' + prefix,
					function(data){
							$("#" + textboxid).val(data.JUMLAH_POTONGAN);
					});
				});
			}
			else
			{
				$("#" + textboxid).val('');
			}
		}
	</script>     
</head> 
<body>

<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
		<span><img src="../WEB-INF/images/panah-judul.png"> Potongan</span>
        
        
    </div>
    <div style="float:right; margin-right:20px; margin-top:-20px;">
        <div style="margin-top:28px; width:400px; margin-left:5px; float:left; position:relative; text-align:left;">
            <div style="border:2px solid #FFF; float:left; margin-right:4px; height:77px; width:60px; -webkit-box-shadow: 0 8px 6px -6px black; -moz-box-shadow: 0 8px 6px -6px black; box-shadow: 0 8px 6px -6px black;">
                <img src="../simpeg/image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="60" height="77">
                <!--<img src="images/pns.jpg" width="50" height="66" />-->
            </div>
            
            <div style="float:left; position:relative; width:300px;"> 
                <div style="color:#000; font-size:18px; text-shadow:1px 1px 1px #000;"><?=$pegawai->getField("NAMA")?> (<?=$pegawai->getField("NRP")?>)</div>     
                <div style="color:#000; font-size:15px; text-shadow:1px 1px 1px #000; line-height:20px;"><?=$pegawai->getField("JABATAN_NAMA")?></div>
                <div style="color:#000; font-size:12px; text-shadow:1px 1px 1px #000; line-height:20px;">Kelas : <?=$pegawai->getField("KELAS")?></div>
                <div style="color:#000; font-size:12px; text-shadow:1px 1px 1px #000; line-height:20px;">NPWP : <?=$pegawai->getField("NPWP")?></div>
            </div>
    
        </div>
    </div>
    
    <div style="clear:both;"></div>    
    
    <div style="float:right; background:#930;">
        <form id="ff" method="post" novalidate>
        
        <table class="example" id="sf">
        <thead>
          <tr>
              <th>Potongan</th>
              <th>Jumlah</th>
          </tr>
        </thead>
        <tbody> 
          <?
              $parent_id = 0;
              $j = 1;
              $checkbox_index = 0;
              $potongan_kondisi->selectByParamsPotongan(array(), -1, -1, "", $reqJenisPegawaiId, $reqKelas, $reqId);
              while($potongan_kondisi->nextRow())
              {
                 $style = ""; 
                 if($potongan_kondisi->getField('JUMLAH_RUMUS') == "03")
                 {}
                 else
                    $style = "style='display:none'"; 
                    
                 if($potongan_kondisi->getField("POTONGAN_KONDISI_PARENT_ID") ==  0)
                 {
          ?>
                  <tr id="node-<?=$potongan_kondisi->getField('POTONGAN_KONDISI_ID')?>">
                      <td width="75%"><input type="checkbox" name="reqPotongan[]" value="<?=$checkbox_index?>" id="checkbox-<?=$j?>" <? if($potongan_kondisi->getField('POTONGAN_KONDISI_ID') == $potongan_kondisi->getField('POTONGAN_KONDISI_ID_PEGAWAI')) echo "checked"; ?>><?=$potongan_kondisi->getField('NAMA')?></td>
                      <td>
                        <div <?=$style?>>
                        <input type="text" style="width:60px;" name="reqJumlahTotal[]" id="reqJumlahTotal<?=$j?>" class="easyui-validatebox"  value="<?=numberToIna($potongan_kondisi->getField('JUMLAH'))?>" OnFocus="FormatAngka('reqJumlahTotal<?=$j?>')" OnKeyUp="FormatUang('reqJumlahTotal<?=$j?>')" OnBlur="FormatUang('reqJumlahTotal<?=$j?>')"/>
                        <input type="hidden" style="width:60px;" name="reqPotonganKondisiId[]" id="reqPotonganKondisiId<?=$j?>" value="<?=$potongan_kondisi->getField('POTONGAN_KONDISI_ID')?>" />
                        </div>
                      </td>
                  </tr>
          <?
                 }
                 else
                 {
                     if($parent_id == $potongan_kondisi->getField("POTONGAN_KONDISI_PARENT_ID"))
                     {
                     }
                     else
                     {
                     ?>
                        <tr id="node-<?=$potongan_kondisi->getField('POTONGAN_KONDISI_PARENT_ID')?>">
                        <td><?=$potongan_kondisi->getField('PARENT_NAMA')?></td>
                        <td></td>
                     <?	 
                     }
          ?>
                  <tr id='node-<?=$potongan_kondisi->getField("POTONGAN_KONDISI_ID")?>' class='child-of-node-<?=$potongan_kondisi->getField("POTONGAN_KONDISI_PARENT_ID")?>'>
                      <td width="75%"><input type="checkbox" name="reqPotongan[]" value="<?=$checkbox_index?>" id="checkbox-<?=$j?>" <? if($potongan_kondisi->getField('POTONGAN_KONDISI_ID') == $potongan_kondisi->getField('POTONGAN_KONDISI_ID_PEGAWAI')) echo "checked"; ?> ><?=$potongan_kondisi->getField('NAMA')?></td>
                      <td>
                      <div <?=$style?>>
                        <input type="text" style="width:60px;" name="reqJumlahTotal[]" id="reqJumlahTotal<?=$j?>" class="easyui-validatebox"  value="<?=numberToIna($potongan_kondisi->getField('JUMLAH'))?>" OnFocus="FormatAngka('reqJumlahTotal<?=$j?>')" OnKeyUp="FormatUang('reqJumlahTotal<?=$j?>')" OnBlur="FormatUang('reqJumlahTotal<?=$j?>')"/>
                        <input type="hidden" style="width:60px;" name="reqPotonganKondisiId[]" id="reqPotonganKondisiId<?=$j?>" value="<?=$potongan_kondisi->getField('POTONGAN_KONDISI_ID')?>" />
                      </div>
                      </td>
                  </tr>	  
          <?	 	
                    $parent_id =  $potongan_kondisi->getField("POTONGAN_KONDISI_PARENT_ID");
                 }
                 $j++;
                 $checkbox_index++;
             }
          ?>  
          </tr>
        </tbody>            
        </table>         
        
            <div>
                <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <input type="submit" value="Submit">
                <input type="reset" id="rst_form">
            </div>
        </form>
    </div>
</div>
</body>
</html>