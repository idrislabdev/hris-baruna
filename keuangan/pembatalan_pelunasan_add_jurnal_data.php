<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");

$pembatalan_pelunasan = new KpttNota();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$pembatalan_pelunasan->selectByParams(array("A.TIPE_TRANS"=>$reqId, "NO_NOTA"=>$reqRowId), -1, -1);
	$pembatalan_pelunasan->firstRow();
	
	$tempNoBukti = $pembatalan_pelunasan->getField("NO_NOTA");
	$tempKodeKusto = $pembatalan_pelunasan->getField("KD_KUSTO");
	$tempKusto = $pembatalan_pelunasan->getField("MPLG_NAMA");
	$tempTipeTransaksi = $pembatalan_pelunasan->getField("TIPE_DESC");
	$tempKodeValuta = $pembatalan_pelunasan->getField("KD_VALUTA");
	$tempNilaiTransaksi = $pembatalan_pelunasan->getField("JML_RP_TRANS");
	$tempNoRef = $pembatalan_pelunasan->getField("");
	$tempNoPosting = $pembatalan_pelunasan->getField("NO_POSTING");
}
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
			//$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
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
				url:'../json-keuangansiuk/pembatalan_pelunasan_add_jurnal_data.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Jurnal Kas Keluar (Pembatalan Pelunasan Nota Tagih)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>No Bukti</td>
			 <td>
				<input name="reqNoBukti" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoBukti?>" />
			</td>
            <td>Kode Kusto</td>
			 <td>
             	<input name="reqKodeKusto" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKodeKusto?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;
				<input name="reqKusto" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempKusto?>" />
			</td>
        </tr>
        <tr>
        	<td>Tipe Transaksi</td>
			 <td>
				<input name="reqTipeTransaksi" class="easyui-validatebox" style="width:300px" type="text" value="<?=$tempTipeTransaksi?>" />
			</td>
            <td>Kode Valuta</td>
			 <td>
				<input name="reqKodeValuta" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKodeValuta?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Nilai Transaksi
                <input type="text" style="width:100px;" name="reqNilaiTransaksi"  id="reqNilaiTransaksi"  OnFocus="FormatAngka('reqNilaiTransaksi')" OnKeyUp="FormatUang('reqNilaiTransaksi')" OnBlur="FormatUang('reqNilaiTransaksi')" value="<?=numberToIna($tempNilaiTransaksi)?>">
			</td>
        </tr>
        <tr>           
             <td>No Ref</td>
			 <td>
             	<input name="reqNoRef" class="easyui-validatebox" style="width:240px" type="text" value="<?=$tempNoRef?>" />
			</td>
            <td>No&nbsp;Posting</td>
			<td>
                <input name="reqNoPosting" class="easyui-validatebox" style="width:150px" type="text" value="<?=$tempNoPosting?>" />
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
<script>
	$("#reqBulan,#reqTahun").keypress(function(e) {
		if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
		{
		return false;
		}
	});
</script>
</body>
</html>