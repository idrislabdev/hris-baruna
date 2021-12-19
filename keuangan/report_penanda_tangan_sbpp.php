<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");

$kptt_nota = new KpttNota();
$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

$kptt_nota->selectByParamsSimple(array("NO_NOTA"=>$reqId));
$kptt_nota->firstRow();
$tempNoNotaDinas= $kptt_nota->getField('NO_NOTA_DINAS');
$tempKetNotaDinas= $kptt_nota->getField('KET_NOTA_DINAS');

$tempTglTrans = $kptt_nota->getField("TGL_TRANS");

if($tempKetNotaDinas == "")
	$tempKetNotaDinas = "Dimohon untuk bukti potong PPh Pasal 15 untuk bulan ".getNamePeriode(getMonth($tempTglTrans).getYear($tempTglTrans))." agar dikirimkan kepada PT PELINDO MARINE SERVICE";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
	 
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/report_penanda_tangan_sbpp.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					top.frames['mainFrame'].location.reload();
					newWindow = window.open('penjualan_sbpp_cetak_sbpp_rpt.php?reqId=<?=$reqId?>', 'Cetak');
				  	newWindow.focus();		
					window.parent.divwin.close();		
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Masukkan Nomor dan Keterangan PPh 15</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>No Nota Dinas</td>
            <td>
                <input name="reqNoNotaDinas" id="reqNoNotaDinas" class="easyui-validatebox" size="20"  style="width:120px" type="text" value="<?=$tempNoNotaDinas?>" />
            </td>
        </tr>    
        <tr>
            <td>Keterangan Nota Dinas</td>
            <td> 
               <textarea name="reqKetNotaDinas" style="width:350px; height:100px;"><?=$tempKetNotaDinas?></textarea>
            </td>
        </tr>
    </table>
        <div>
            <input type="hidden" name="reqProgramNama" value="KBB_R_THN_BUKU_IMAIS">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
<script>
$("#reqTahun").keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>