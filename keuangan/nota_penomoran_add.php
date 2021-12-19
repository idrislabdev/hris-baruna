<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrNoNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");

$nota_penomoran = new KbbrNoNota();
$kbbr_general_ref_detil = new KbbrGeneralRefD();
$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";
	$tempPeriode= $reqPeriode;
}
else
{
	$reqMode = "update";	
	$nota_penomoran->selectByParams(array("KD_BUKTI"=>$reqId, "KD_PERIODE"=>$reqPeriode), -1, -1);
	$nota_penomoran->firstRow();
	
	$tempKode= $nota_penomoran->getField('KD_BUKTI');
	$tempNama= $nota_penomoran->getField('KET_BUKTI');
	$tempPeriode= $nota_penomoran->getField('KD_PERIODE');
	$tempAwalan= $nota_penomoran->getField('AWALAN');
	$tempNoStart= $nota_penomoran->getField('NO_START');
	$tempNoStop= $nota_penomoran->getField('NO_STOP');
	$tempNoDipakai= $nota_penomoran->getField('NO_DIPAKAI');
	$tempStatus= $nota_penomoran->getField('KD_AKTIF');
	
	$state = "OR A.ID_REF_DATA = '".$tempKode."'";
}

//$statement = " AND (NOT EXISTS (SELECT X.KD_BUKTI FROM SIUK.KBBR_NO_NOTA X LEFT JOIN SIUK.KBBR_GENERAL_REF_D Y ON X.KD_BUKTI = Y.ID_REF_DATA WHERE X.KD_PERIODE = '".$tempPeriode."' AND A.ID_REF_DATA = Y.ID_REF_DATA) ".$state.")";

$kbbr_general_ref_detil->selectByParams(array(),-1,-1, $statement." AND ID_REF_FILE IN ( 'JENISJURNAL', 'NOPOS', 'PNJUAL')");
//echo $kbbr_general_ref_detil->query;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		function setValue(){
			$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
		$.fn.datebox.defaults.formatter = function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return d+'-'+m+'-'+y;
		}		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/nota_penomoran_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
			
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <!--<script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script> -->

<style type="text/css">
div.message{
background: transparent url(msg_arrow.gif) no-repeat scroll bottom left;
padding-bottom: 5px;
}

div.error{
background-color:#F3E6E6;
border-color: #924949;
/*border-style: solid solid solid none;*/
border-style: solid solid solid solid;
border-width: 1px;
padding: 5px;
}
</style>
</head>
     
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Referensi Nomor Transaksi</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Kode</td>
			 <td>
             	<?php /*?><select id="reqKode" class="easyui-combobox" name="reqKode" style="width:50px;" data-options="filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; }, required:true"><?php */?>
                <select id="reqKode" name="reqKode">
                <? 
				while($kbbr_general_ref_detil->nextRow())
				{
				?>
                    <option value="<?=$kbbr_general_ref_detil->getField('ID_REF_DATA')?>" <? if($tempKode == $kbbr_general_ref_detil->getField('ID_REF_DATA')) echo 'selected';?>><?=$kbbr_general_ref_detil->getField('ID_REF_DATA')?> - <?=$kbbr_general_ref_detil->getField('KET_REF_DATA')?></option>
                <? 
				}
				?>
                </select>
			</td>			
        </tr>
        <tr>
            <td>Nama</td>
            <td>
                <input name="reqNama" required style="width:250px" type="text" value="<?=$tempNama?>" />
            </td>
        </tr>    
        <tr>
            <td>Periode</td>
            <td>
                <input name="reqPeriode" required style="width:80px" type="text" value="<?=$tempPeriode?>" />
            </td>
        </tr>
        <tr>
            <td>Awalan</td>
            <td>
                <input name="reqAwalan" required style="width:100px" type="text" value="<?=$tempAwalan?>" />
            </td>
        </tr>
        <tr>
            <td>No Start</td>
            <td>
                <input name="reqNoStart" id="reqNoStart" required style="width:50px" type="text" value="<?=$tempNoStart?>" />
            </td>
        </tr> 
        <tr>
            <td>No Stop</td>
            <td>
                <input name="reqNoStop" id="reqNoStop" required style="width:50px" type="text" value="<?=$tempNoStop?>" />
            </td>
        </tr> 
        <tr>
            <td>No Terpakai</td>
            <td>
                <input name="reqNoDipakai" style="width:100px" type="text" value="<?=$tempNoDipakai?>" />
            </td>
        </tr>         
        <tr style="display:none">
            <td>Status</td>
            <td>
                <input name="reqStatus" required style="width:30px" type="hidden" value="A" />
            </td>
        </tr>     
    </table>
        <div>
        	<input type="hidden" name="reqKodeCabang" value="95">
            <input type="hidden" name="reqProgramNama" value="KBB_R_NOTA_IMAIS">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqRowId" value="<?=$reqPeriode?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
<script>
$("#reqNoStart, #reqNoStop").keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>