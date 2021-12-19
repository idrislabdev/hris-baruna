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
include_once("../WEB-INF/classes/base-gaji/LainKondisi.php");
include_once("../WEB-INF/classes/base-gaji/LainKondisiPegawai.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

/* create objects */
$lain_kondisi = new LainKondisi();
$lain_kondisi_pegawai = new LainKondisiPegawai();
$jenis_pegawai = new JenisPegawai();

$reqHeight = httpFilterGet("reqHeight");
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

$jenis_pegawai->selectByParams();

$lain_kondisi_pegawai->selectByParamsGajiPotongan($reqId);
$lain_kondisi_pegawai->firstRow();
$arrPerhitunganGaji = explode("-", $lain_kondisi_pegawai->getField("PERHITUNGAN_GAJI"));

function getLainKondisiByParent($id_induk, $parent, $i, $jumlah_child, $checkbox_index)
{
	$child = new LainKondisi();
	
	$child->selectByParams(array("LAIN_KONDISI_PARENT_ID"=>$id_induk));
	$j=1;
	while($child->nextRow())
	{
		$checkbox_index++;
		$nama = $child->getField('NAMA');
		echo "
			  <tr id='node-".$child->getField('LAIN_KONDISI_ID')."' class='child-of-node-".$child->getField('LAIN_KONDISI_PARENT_ID')."'>
				  <td><input type=\"checkbox\" name=\"reqPotonganLain[]\" value=\"".$checkbox_index."\" id=\"checkbox-".$i."-".$j."\" onclick=\"check('checkbox-".$i."-".$j."', '".$jumlah_child."')\">".$nama."</td>
				  <td><input type=\"text\" style=\"width:50px;\" name=\"reqPotongan[]\" value=\"\"></td>	
				  <td><input type=\"text\" style=\"width:30px;\" name=\"reqAngsuran[]\" value=\"100\"></td>
			  </tr>
			 ";
		
	  	getLainKondisiByParent($child->getField("LAIN_KONDISI_ID"), $child->getField('NAMA'), $i, $jumlah_child, $checkbox_index);		
		$j++;
		
	}
	unset($child);
	return $checkbox_index;
}
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
				url:'../json-gaji/lain_kondisi_pegawai_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					//$('#rst_form').click();
					<?php /*?>top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>	<?php */?>				
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
		function check(checkboxid, jumlahchild)
		{
			var arrCheckbox = checkboxid.split('-');
			if(arrCheckbox.length == 3)
			{
				var childcheck = false;
				for(i=1;i<=jumlahchild;i++)
				{
					if(arrCheckbox[0] + '-' + arrCheckbox[1] + '-' + i == checkboxid)
					{}
					else
					{
						if(document.getElementById(arrCheckbox[0] + '-' + arrCheckbox[1] + '-' + i).checked == true)
							childcheck = true;
					}
				}
				if(childcheck == false)
					document.getElementById(arrCheckbox[0] + '-' + arrCheckbox[1]).checked = document.getElementById(checkboxid).checked;	
			}
			else
			{
						
				for(j=1;j<=jumlahchild;j++)
				{
					document.getElementById(arrCheckbox[0] + '-' + arrCheckbox[1] + '-' + j).checked = document.getElementById(checkboxid).checked;
				}				
			}
			//alert(document.getElementById(checkboxid).checked);
			
		}
	</script>     
</head> 
<body>

<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
		<span><img src="../WEB-INF/images/panah-judul.png"> Potongan Lain-lain</span>
    </div>
        
	<div class="data-foto-table">
        <div class="data-foto">
            <div class="data-foto-img">
                <img src="../simpeg/image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="60" height="77">
            </div>
            
            <div class="data-foto-ket">
            	<div style="font-size:18px; "><?=$lain_kondisi_pegawai->getField("NAMA")?> (<?=$lain_kondisi_pegawai->getField("NRP")?>)</div>     
                <div style="font-size:14px; line-height:20px;">Total Gaji : <?=currencyToPage($arrPerhitunganGaji[0])?></div>
                <div style="font-size:14px; line-height:20px;">Total Potongan : <?=currencyToPage($arrPerhitunganGaji[1])?></div>
                <div style="font-size:14px; line-height:20px;">Total Saldo : <?=currencyToPage($arrPerhitunganGaji[2])?></div>
            </div>
    
        </div>
        
        <div class="data-table">
            
            <form id="ff" method="post" novalidate>
        
            <table class="example" id="sf">
            <thead>
              <tr>
                  <th>Nama Bank</th>
                  <th>Bulan Mulai</th>
                  <th>Angsuran Kali</th>
                  <th>Angsuran Terbayar</th>  
        
                  <th>Angsuran Awal</th>
                  <th>Angsuran Per Bulan</th>             
                  <th>Jumlah Total</th>
              </tr>
            </thead>
            <tbody> 
              <?
                  $j = 1;
                  $checkbox_index = 0;
                  $lain_kondisi->selectByParams(array('LAIN_KONDISI_PARENT_ID' => 0), -1, -1, "", $reqId);
                  while($lain_kondisi->nextRow())
                  {
              ?>
                  <tr id="node-<?=$lain_kondisi->getField('LAIN_KONDISI_ID')?>">
                      <td width="20%"><input type="checkbox" name="reqPotonganLain[]" value="<?=$checkbox_index?>" id="checkbox-<?=$i?>" <? if($lain_kondisi->getField('LAIN_KONDISI_ID') == $lain_kondisi->getField('LAIN_KONDISI_ID_PEGAWAI')) echo "checked"; ?> onClick="check('checkbox-<?=$i?>', '<?=$lain_kondisi->getField('JUMLAH_CHILD')?>')"><?=$lain_kondisi->getField('NAMA')?></td>
                      <td width="160px">
                        <?
                            $bulan = substr($lain_kondisi->getField('BULAN_MULAI'),0,2);
                            $tahun = substr($lain_kondisi->getField('BULAN_MULAI'),2,4);
                            //echo $bulan."----".$tahun;      
                            if($lain_kondisi->getField('BULAN_MULAI') == "")
                            {
                                $bulan = date("m");  
                                $tahun = date("Y");        
                            }
                        ?>              
                        <select name="reqBulan[]">
                            <option value="01" <? if($bulan == "01") echo "selected"; ?>>Januari</option>
                            <option value="02" <? if($bulan == "02") echo "selected"; ?>>Februari</option>
                            <option value="03" <? if($bulan == "03") echo "selected"; ?>>Maret</option>
                            <option value="04" <? if($bulan == "04") echo "selected"; ?>>April</option>
                            <option value="05" <? if($bulan == "05") echo "selected"; ?>>Mei</option>
                            <option value="06" <? if($bulan == "06") echo "selected"; ?>>Juni</option>
                            <option value="07" <? if($bulan == "07") echo "selected"; ?>>Juli</option>
                            <option value="08" <? if($bulan == "08") echo "selected"; ?>>Agustus</option>
                            <option value="09" <? if($bulan == "09") echo "selected"; ?>>September</option>
                            <option value="10" <? if($bulan == "10") echo "selected"; ?>>Oktober</option>
                            <option value="11" <? if($bulan == "11") echo "selected"; ?>>November</option>
                            <option value="12" <? if($bulan == "12") echo "selected"; ?>>Desember</option>			
                        </select>
                        
                        <select name="reqTahun[]">
                        <?
                        $tahun_for = date("Y");
                        for($i=$tahun_for; $i<=$tahun_for + 1; $i++)
                        {
                        ?>
                            <option value="<?=$i?>" <? if($i == $tahun) echo "selected"; ?>>
                            <?=$i?>
                            </option>
                        <?
                        }			
                        ?>
                        </select>	            
                      <?php /*?><input type="text" style="width:30px;" name="reqBulanMulai[]" value="<?=$lain_kondisi->getField('BULAN_MULAI')?>"><?php */?>
                      </td>
                      <td><input type="text" style="width:20px;" name="reqAngsuran[]" value="<?=$lain_kondisi->getField('ANGSURAN')?>"></td>
                      <td width="100px">
                            <input type="text" style="width:20px;" readonly name="reqAngsuranTerbayar[]" value="<?=$lain_kondisi->getField('ANGSURAN_TERBAYAR')?>">&nbsp; 
                            <?
                                $bulan = substr($lain_kondisi->getField('BULAN_AKHIR_BAYAR'),0,2);
                                $tahun = substr($lain_kondisi->getField('BULAN_AKHIR_BAYAR'),2,4);
                                echo getExtMonth((int)$bulan)." ".$tahun;
                            ?>
                      </td>              
                      <td><input type="text" style="width:50px;" name="reqJumlahAwalAngsuran[]" id="reqJumlahAwalAngsuran<?=$j?>"  OnFocus="FormatAngka('reqJumlahAwalAngsuran<?=$j?>')" OnKeyUp="FormatUang('reqJumlahAwalAngsuran<?=$j?>')" OnBlur="FormatUang('reqJumlahAwalAngsuran<?=$j?>')" value="<?=numberToIna($lain_kondisi->getField('JUMLAH_AWAL_ANGSURAN'))?>"></td>
                      <td><input type="text" style="width:50px;" name="reqJumlahAngsuran[]" id="reqJumlahAngsuran<?=$j?>"  OnFocus="FormatAngka('reqJumlahAngsuran<?=$j?>')" OnKeyUp="FormatUang('reqJumlahAngsuran<?=$j?>')" OnBlur="FormatUang('reqJumlahAngsuran<?=$j?>')" value="<?=numberToIna($lain_kondisi->getField('JUMLAH_ANGSURAN'))?>">
                          <input type="hidden" name="reqLainKondisiId[]" value="<?=$lain_kondisi->getField('LAIN_KONDISI_ID')?>">
                      </td>
                      <td><input type="text" style="width:60px;" name="reqJumlahTotal[]" id="reqJumlahTotal<?=$j?>" class="easyui-validatebox"  value="<?=numberToIna($lain_kondisi->getField('JUMLAH_TOTAL'))?>" OnFocus="FormatAngka('reqJumlahTotal<?=$j?>')" OnKeyUp="FormatUang('reqJumlahTotal<?=$j?>')" OnBlur="FormatUang('reqJumlahTotal<?=$j?>')"/></td>
                  </tr>
              <?php
                    $j++;
                    $checkbox_index++;
                  }
              ?>  
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
    
</div>
</body>
</html>