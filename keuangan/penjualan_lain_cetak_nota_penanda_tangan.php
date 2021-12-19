<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrKeyTabel.php");

$reqId = httpFilterGet("reqId");
$reqKdValuta = httpFilterGet("reqKdValuta");

$kbbr_thn_buku_d  = new KbbrThnBukuD();
$kbbr_key_table  = new KbbrKeyTabel();

$kbbr_thn_buku_d->selectByParams(array(), -1, -1, "", " ORDER BY THN_BUKU DESC, TO_NUMBER(BLN_BUKU) DESC ");
$kbbr_key_table->selectByParams(array("KD_SUBSIS" => "ALL", "ID_TABEL" => "OFFICER"));

$i=0;
while($kbbr_key_table->nextRow())
{
	$officer[$i]["KD_TABEL"] = $kbbr_key_table->getField("KD_TABEL");
	$officer[$i]["NM_KET1"] = $kbbr_key_table->getField("NM_KET1");
	$officer[$i]["NM_KET2"] = $kbbr_key_table->getField("NM_KET2");	
	$officer[$i]["NM_KET3"] = $kbbr_key_table->getField("NM_KET3");	
	$i++;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>neraca komparatif</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">


<!--RIGHT CLICK EVENT-->		
<style>

	.vmenu{
	border:1px solid #aaa;
	position:absolute;
	background:#fff;
	display:none;font-size:0.75em;}
	.first_li{}
	.first_li span{width:100px;display:block;padding:5px 10px;cursor:pointer}
	.inner_li{display:none;margin-left:120px;position:absolute;border:1px solid #aaa;border-left:1px solid #ccc;margin-top:-28px;background:#fff;}
	.sep_li{border-top: 1px ridge #aaa;margin:5px 0}
	.fill_title{font-size:11px;font-weight:bold;/height:15px;/overflow:hidden;word-wrap:break-word;}

</style>
<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
<link rel="stylesheet" type="text/css" href="css/bluetabs.css" />
<script src="../WEB-INF/lib/media/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready( function () {
			  $('#btnCetak').live('click', function () {
					newWindow = window.open('penjualan_lain_cetak_nota_rpt.php?reqId='+ $("#reqId").val()+'&reqKdValuta='+ $("#reqKdValuta").val()+'&reqPejabat='+ $("#reqPejabat").val()+'&reqParam1='+ $("#reqParam1").val()+'&reqParam2='+ $("#reqParam2").val()+'', 'Cetak');
			  		newWindow.focus();	
				 	window.parent.divwin.close();
			  });
			  
			  
	});
</script>
</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
	<form method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Cetak Nota</span>
            </div>            
            </td>
        </tr>
    </table>

	<table>
        <tr>           
             <td>Nomor</td>
			 <td>
             	<input name="reqId" id="reqId" class="easyui-validatebox" style="width:170px" type="text" readonly value="<?=$reqId?>" />
             	<input name="reqKdValuta" id="reqKdValuta" class="easyui-validatebox" style="width:170px" type="hidden" readonly value="<?=$reqKdValuta?>" />
             </td>			
        </tr>
        <tr>           
             <td>Penandatangan</td>
			 <td>
             	<select id="reqPejabat" name="reqPejabat">
                	<?
                    for($i=0;$i<count($officer);$i++)
					{
					?>
                    	<option value="<?=$officer[$i]["NM_KET1"]?>" <? if($officer[$i]["KD_TABEL"] == "MAN") { ?> selected <? } ?>><?=$officer[$i]["NM_KET1"]?></option>
                    <?	
					}
					?>
                </select>
             </td>			
        </tr>
         <tr>
        	<td>Pemeriksa-1</td>
            <td>
            	<select name="reqParam1" id="reqParam1">
                    <option value=" " <? if($reqParam1 == " ") echo "selected";?>> </option>
                    <option value="ASMAN AKUNTANSI" <? if($reqParam1 == "ASMAN AKUNTANSI") echo "selected";?>>ASMAN AKUNTANSI</option>
                    <option value="SPV AKT MAN" <? if($reqParam1 == "SPV AKT MAN") echo "selected";?>>SPV AKT MAN</option>
                    <option value="SPV AKT KEU" <? if($reqParam1 == "SPV AKT KEU") echo "selected";?>>SPV AKT KEU</option>
                    <option value="ASMAN TRESURI" <? if($reqParam1 == "ASMAN TRESURI") echo "selected";?>>ASMAN TRESURI</option>
                    <option value="SPV ADM KEU" <? echo "selected";?>>SPV ADM KEU</option>
                    <option value="SPV PERBENDAHARAAN" <? if($reqParam1 == "SPV PERBENDAHARAAN") echo "selected";?>>SPV PERBENDAHARAAN</option>
                </select>
            </td>
        </tr>
        <tr>
        	<td>Pemeriksa-2</td>
            <td>
            	<select name="reqParam2" id="reqParam2">
                    <option value=" " <? if($reqParam2 == " ") echo "selected";?>> </option>
                    <option value="ASMAN AKUNTANSI" <?  if($reqParam2 == "ASMAN AKUNTANSI") echo "selected"; ?>>ASMAN AKUNTANSI</option>
                    <option value="SPV AKT MAN" <? if($reqParam2 == "SPV AKT MAN") echo "selected";?>>SPV AKT MAN</option>
                    <option value="SPV AKT KEU" <? if($reqParam2 == "SPV AKT KEU") echo "selected";?>>SPV AKT KEU</option>
                    <option value="ASMAN TRESURI" <? echo "selected";?>>ASMAN TRESURI</option>
                    <option value="SPV ADM KEU" <? if($reqParam2 == "SPV ADM KEU") echo "selected";?>>SPV ADM KEU</option>
                    <option value="SPV PERBENDAHARAAN" <? if($reqParam2 == "SPV PERBENDAHARAAN") echo "selected";?>>SPV PERBENDAHARAAN</option>
                </select>
            </td>
        </tr>
        <tr>
        	<td colspan="3"><input type="button" id="btnCetak" value="Cetak"></td>
        </tr>      
    </table>    	   
    </form>
</div>
</body>
</html>

