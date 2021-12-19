<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
//include_once("../WEB-INF/classes/base-keuangan/Valuta.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajak.php");

$no_faktur_pajak = new NoFakturPajak();

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
	
	$no_faktur_pajak->selectByParams(array("NO_FAKTUR_PAJAK_ID"=>$reqId));
	$no_faktur_pajak->firstRow();
	
	$tempTanggalMulai = dateToPageCheck($no_faktur_pajak->getField('TANGGAL_AWAL'));
	$tempTanggalSelesai = dateToPageCheck($no_faktur_pajak->getField('TANGGAL_AKHIR'));
	$tempDigitAwal= $no_faktur_pajak->getField('DIGIT_AWAL');
	$tempDigitAkhir= $no_faktur_pajak->getField('DIGIT_AKHIR');
	$tempDigitFix= $no_faktur_pajak->getField('DIGIT_FIX');
	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
	<script type="text/javascript">
		/*function setValue(){
			$('#reqTanggalMulai').datebox('setValue', '<?="01-".date("m-Y")?>');	
			$('#reqTanggalSelesai').datebox('setValue', '<?=date("t",strtotime(date("Y-m-01"))).'-'.date("m-Y")?>');
		}*/
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/faktur_pajak_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);
					//data = data.split("-");
					//$.messager.alert('Info', data[1], 'info');
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
<body onLoad="setValue()">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data No Faktur Pajak</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
        <td>Tanggal Awal</td>
            <td>
                 <input id="reqTanggalMulai" name="reqTanggalMulai" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalMulai?>"></input>
       		</td>
        </tr>
        <tr>
        <td>Tanggal Akhir</td>
            <td>
                 <input id="reqTanggalSelesai" name="reqTanggalSelesai" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalSelesai?>"></input>
       		</td>
        </tr>            
        <tr>
            <td>Digit Fix</td>
            <td>
            	<input type="text" style="width:150px;" name="reqDigitFix" id="reqDigitFix" maxlength="12" value="<?=$tempDigitFix?>">
            </td>
        </tr>     
        <tr>
            <td>Digit Mulai</td>
            <td>
            	<input type="text" style="width:50px;" name="reqDigitAwal" id="reqDigitAwal" maxlength="3" value="<?=$tempDigitAwal?>">
            </td>
        </tr>             
        <tr>
            <td>Digit Akhir</td>
            <td>
            	<input type="text" style="width:50px;" name="reqDigitAkhir" id="reqDigitAkhir" maxlength="3" value="<?=$tempDigitAkhir?>">
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