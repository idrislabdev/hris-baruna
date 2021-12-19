<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/BadanUsaha.php");
//include_once("../WEB-INF/classes/base-keuangan/BadanUsahaCoa.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrCoaKustKlien.php");

$badan_usaha_coa = new KbbrCoaKustKlien();
$badan_usaha = new BadanUsaha();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode"); 
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$badan_usaha_coa->selectByParams(array("KD_KUST_KLIEN" => 1, 'BADAN_USAHA'=>$reqId), -1, -1);
	//$badan_usaha_coa->selectByParams(array('BADAN_USAHA_COA_ID'=>$reqId), -1, -1);
	$badan_usaha_coa->firstRow();
	
	$tempBadanUsahaId= $badan_usaha_coa->getField('BADAN_USAHA_ID');
	$tempBadanUsaha= $badan_usaha_coa->getField('BADAN_USAHA');
	$tempKodeKustomerClient= $badan_usaha_coa->getField('KD_KUST_KLIEN');
	$tempCoa1= $badan_usaha_coa->getField('COA1');
	$tempCoa2= $badan_usaha_coa->getField('COA2');
	$tempCoa3= $badan_usaha_coa->getField('COA3');
	$tempCoa4= $badan_usaha_coa->getField('COA4');
	$tempCoa5= $badan_usaha_coa->getField('COA5');
	$tempCoa6= $badan_usaha_coa->getField('COA6');
	$tempCoa7= $badan_usaha_coa->getField('COA7');
	$tempCoa8= $badan_usaha_coa->getField('COA8');
	$tempCoa9= $badan_usaha_coa->getField('COA9');
	$tempCoa10= $badan_usaha_coa->getField('COA10');
	//$tempStatus= $badan_usaha_coa->getField('STATUS');
	$tempStatus= $badan_usaha_coa->getField('KD_AKTIF');
	
}
$badan_usaha->selectByParams();
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
				url:'../json-keuangansiuk/badan_usaha_coa_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[data.length-1], 'info');
					//$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> //window.parent.divwin.close(); <? } ?>					
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Ubah Rekening Piutang Pelanggan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
    
      <?php /*?> <tr>           
             <td>Badan&nbsp;Usaha</td>
			 <td colspan="3">
		<select id="reqBadanUsahaId" name="reqBadanUsahaId">
                <? while($badan_usaha->nextRow()){?>
                    <option value="<?=$badan_usaha->getField('BADAN_USAHA_ID')?>" <? if($tempBadanUsahaId == $badan_usaha->getField('BADAN_USAHA_ID')) echo 'selected';?>><?=$badan_usaha->getField('NAMA')?></option>
                <? }?>
                </select>

  			&nbsp;&nbsp;&nbsp;&nbsp;             
  			</td>			
        </tr><?php */?>
        <tr>
            <td>Badan&nbsp;Usaha</td>
            <td>
                <input name="reqBadanUsaha" required style="width:170px; background-color:#f0f0f0" type="text" value="<?=$tempBadanUsaha?>" readonly />
            </td>
        </tr>         
        <tr>
            <td>Kode Kustomer Client</td>
            <td>
                <input name="reqKodeKustomerClient" required style="width:170px; background-color:#f0f0f0" type="text" value="<?=$tempKodeKustomerClient?>" readonly />
            </td>
        </tr>    
        <tr>
        	<td align="center"><strong>Keterangan</strong></td>
        	<td align="center"><strong>Rupiah</strong></td>
        	<td align="center"><strong>Valas</strong></td>
        </tr>     
        <tr>
            <td>Piutang Usaha</td>
            <td>
                <input name="reqCoa1" required style="width:100px" type="text" value="<?=$tempCoa1?>"/>
            </td>    
            <td>
                <input name="reqCoa2" required style="width:100px" type="text" value="<?=$tempCoa2?>"/>
            </td>
        </tr> 
        <tr>
            <td>Penyisihan Piutang Usaha</td>
            <td>
                <input name="reqCoa3" required style="width:100px" type="text" value="<?=$tempCoa3?>"/>
            </td>
            <td>
                <input name="reqCoa4" required style="width:100px" type="text" value="<?=$tempCoa4?>"/>
            </td>
        </tr> 
        <tr>
            <td>Reduksi Pendapatan</td>
            <td>
                <input name="reqCoa5" required style="width:100px" type="text" value="<?=$tempCoa5?>"/>
            </td>
            <td>
                <input name="reqCoa6" required style="width:100px" type="text" value="<?=$tempCoa6?>"/>
            </td>
        </tr> 
        <tr>
            <td>Uper / Uang Panjar</td>
            <td>
                <input name="reqCoa7" required style="width:100px" type="text" value="<?=$tempCoa7?>"/>
            </td>
            <td>
                <input name="reqCoa8" required style="width:100px" type="text" value="<?=$tempCoa8?>"/>
            </td>
        </tr> 
        <tr>
            <td>Uang Titipan / Sisa Uper</td>
            <td>
                <input name="reqCoa9" required style="width:100px" type="text" value="<?=$tempCoa9?>"/>
            </td>
            <td>
                <input name="reqCoa10" required style="width:100px" type="text" value="<?=$tempCoa10?>"/>
            </td>
        </tr>      
        <tr>
            <td>Status</td>
            <td>
                <input name="reqStatus" required style="width:30px; background-color:#f0f0f0" type="text" value="<?=$tempStatus?>" readonly />
            </td>
        </tr>        
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>