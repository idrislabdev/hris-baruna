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
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");
//include_once("../WEB-INF/classes/base-keuangan/TahunBukuDetil.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");


/* create objects */
$tahun_buku_detil = new KbbrThnBukuD();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

$tahun_buku_detil->selectByParams(array("THN_BUKU"=>$reqId),-1,-1,"","ORDER BY BLN_BUKU ASC");
$index= 0;
$arrBukuDetil="";

while($tahun_buku_detil->nextRow())
{
	//$arrBukuDetil[$index]["TAHUN_BUKU_DETIL_ID"] = $tahun_buku_detil->getField("TAHUN_BUKU_DETIL_ID");
	$arrBukuDetil[$index]["PERIODE"] = $tahun_buku_detil->getField("PERIODE");
	$arrBukuDetil[$index]["STATUS_CLOSING"] = $tahun_buku_detil->getField("STATUS_CLOSING");
	$arrBukuDetil[$index]["NM_BLN_BUKU"] = $tahun_buku_detil->getField("NM_BLN_BUKU");
	$arrBukuDetil[$index]["KALI_CLOSING"] = $tahun_buku_detil->getField("KALI_CLOSING");
	$index++;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>tahun pembukuan lihat</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">

<link href="../WEB-INF/lib/treeTable/doc/stylesheets/master.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.ui.js"></script>
<link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/treeTable/src/javascripts/jquery.treeTable.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$(".example").treeTable({
  initialState: "collapsed"
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

function setUpdate(index, nama)
{
	var value="";
	
	value= $('#reqStatus'+index).val();
	id= $('#reqRowId'+index).val();
	
	if( value == "O"){}
	else
	{
		if(confirm('Apakah anda yakin merubah status periode '+nama+'?') == false)
		{
			$('#reqStatus'+index).val('O');
			return "";
		}
		try 
		{
			$('#reqStatus'+index).prop('disabled', true);
			$.getJSON('../json-keuangansiuk/tahun_pembukuan_status.php?reqId='+id, function (data)
			{
				$.each(data, function (i, SingleElement) {
				});
			});
		}
		catch(e) 
		{
			alert(e);
		}
	}
}
</script>

<?
if($reqHeight == "")
{
?>
<script type="text/javascript">
	window.location.replace('tahun_pembukuan_lihat.php?reqId=<?=$reqId?>&reqHeight=' + screen.height);
</script>
<?
}
?>
<style type="text/css">
<!--
div.scroll {
height: <?=$reqHeight - 390?>px;
width: 98%;
overflow: auto;
padding: 8px;
}
-->
</style> 

<!-- CSS for Drop Down Tabs Menu #2 -->
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
<link href="../WEB-INF/css/bluetabs.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../WEB-INF/css/dropdowntabs.js"></script>
<script language="JavaScript" src="../jslib/displayElement.js"></script>  

    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		var tempPeriode='';
		
		$.extend($.fn.validatebox.defaults.rules, {
			existPeriode:{
				validator: function(value, param){
					$.getJSON("../json-keuangansiuk/tahun_pembukuan_lihat_periode_json.php?reqId=<?=$reqId?>&reqPeriode="+value,
					function(data){
						tempPeriode= data.PERIODE;
					});
					
					 if(tempPeriode == '')
					 	return true;
					 else
					 	return false;
				},
				message: 'Periode, sudah ada.'
			}  
		});
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/tahun_pembukuan_lihat.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					alert(data);
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					document.location.href = 'tahun_pembukuan_lihat.php?reqId=<?=$reqId?>';
					top.frames['mainFrame'].location.reload();
					<?php /*?><? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>	<?php */?>				
				}
			});
			
			$.extend($.fn.validatebox.defaults.rules, {  
				minLength: { 
					validator: function(value, param){  
						return value.length >= param[0];  
					},
					message: 'Total Kata Minimal {0} huruf.'
				}  
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">

</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
                <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Tahun Buku Akuntansi</span>
                </div>            
            </td>
        </tr>
    </table>

    <div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif);">    
        <ul>
            <li>
            <!--<a href="#" id="btnAdd" onClick="window.parent.OpenDHTML('tahun_buku_detil_add.php?reqMode=insert&reqId=0', 'Sistem Informasi Persuratan', '600', '300')" title="Tambah">Tambah</a>-->
            </li>        
        </ul>
    </div>
    <div class="scroll">
      <div>
      <form id="ff" method="post" novalidate>
      <table class="example" id="sf">
            <thead>
              <tr>
                  <th style="width:200px">Periode</th>
                  <th>Status</th>
                  <th>Status close kali</th>
              </tr>
            </thead>
            <tbody> 
            	<?
				if($index == 0){}
				else
				{
                ?>
                <tr>
					<?
					$i=0;
					for($i=0;$i<count($arrBukuDetil);$i++)
					{
					?>
                        <tr id="node-<?=$arrBukuDetil[$i]["PERIODE"]?>">
                            <td class="padding5">
                            	<input type="hidden" id="reqRowId<?=$i?>" name="reqRowId[<?=$i?>]" value="<?=$arrBukuDetil[$i]["PERIODE"]?>">
                            	<span class='file'>
									<?
									$bulan= substr($arrBukuDetil[$i]["PERIODE"], 0,2);
									$tempNama= $arrBukuDetil[$i]["NM_BLN_BUKU"];
									echo $tempNama;
									?>
                                </span>
                            </td>
                            <td align="center">
                            	<?
								if($arrBukuDetil[$i]["STATUS_CLOSING"] == "C")
								{
								?>
                                <input type="hidden" name="reqStatus[<?=$i?>]" id="reqStatus<?=$i?>" value="C">
                                <label>Close</label>
                                <?
								}
								else
								{
                                ?>
                            	<select name="reqStatus[<?=$i?>]" id="reqStatus<?=$i?>" style="width:50px" onChange="setUpdate('<?=$i?>', '<?=$tempNama?>')">
                                	<option value="C" <? if($arrBukuDetil[$i]["STATUS_CLOSING"] == "C") echo "selected";?>>Close</option>
                                    <option value="O" <? if($arrBukuDetil[$i]["STATUS_CLOSING"] == "O") echo "selected";?>>Open</option>
                                </select>
                                <?
								}
                                ?>
                            </td>
                            <td><?=$arrBukuDetil[$i]["KALI_CLOSING"]?></td>
                        </tr>
                    <?
					}
                    ?>
                </tr>
                <?
				}
                ?>
                <tr>
                    <td align="left">
					<?
						if($index == 0)
						{
							$bulan = '01';
							$tahun = $reqId;
						}
						else
						{
							$bulan = substr($arrBukuDetil[$i-1]["PERIODE"],0,2);
							$tahun = substr($arrBukuDetil[$i-1]["PERIODE"],2,4);
						}
						
						
						if($bulan == 12)
						{
							$tempPeriode = "13".($tahun); 	
							$bulan++;
						}
						elseif($bulan == 13)
						{
							$tempPeriode = "14".($tahun); 	
							$bulan++;
						}
						elseif($bulan == 14)
						{
							$tempPeriode = "15".($tahun); 	
							$bulan++;
						}
						elseif($bulan == 16)
						{
							$tempPeriode = ""; 	
							$bulan++;
						}
						elseif($index == 0 && $bulan == '01')
						{
							$tempPeriode = "01".($tahun);
						}
						else
						{
							$tempPeriode = generateZero(($bulan+1),2).$tahun;
							$bulan++;
						}
						

						if((int)$bulan >= "7")
						{
							$tahun = $tahun+1;
						}						
						
						if($bulan == 13)
							$val_nama= "JUNI ".$tahun." AJP (".$reqId.")";
						elseif($bulan == 14)
							$val_nama= "JUNI ".$tahun." AJT (".$reqId.")";
						elseif($bulan == 15)
							$val_nama= "JUNI ".$tahun." AUDIT (".$reqId.")";
						elseif($bulan == 16)
							$val_nama= "JUNI ".$tahun." TUTUP BUKU (".$reqId.")";
						else
							$val_nama= getNameMonthKeu((int)$bulan)." ".$tahun;
						
						if($tempPeriode == "")
						{}
						else
						{		
					?>
                    	<input name="reqNama" value="<?=strtoupper($val_nama)?>" style="width:200px" readonly>
                        <input type="hidden" name="reqPeriode" id="reqPeriode" class="easyui-validatebox" data-options="validType:'minLength[6]'" validType="existPeriode['#reqPeriode']" required size="10" maxlength="6" type="text" value="<?=$tempPeriode?>" />&nbsp;&nbsp;
                        <?
						}
						?>
                        
                        <input type="hidden" name="reqArrayIndex" value="<?=$i?>">
                        <input type="hidden" name="reqId" value="<?=$reqId?>">
                        <input type="submit" value="Submit">
                    </td>
                </tr>
            <?php
				//unset($tahun_buku_detil);
            ?>  
           </tbody>            
          </table>
    </form>                   
      </div> 
    </div> 

</div>
</body>
</html>