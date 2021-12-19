<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriode.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriodeCapegPKWT.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");

$jenis_pegawai = new JenisPegawai();

$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");
$reqPegawaiId = httpFilterGet("reqPegawaiId");
$reqCicilan = httpFilterGet("reqCicilan");



$jenis_pegawai_id = $jenis_pegawai->getJenisPegawaiPeriode($reqPeriode, $reqPegawaiId);

if($reqCicilan == 1)
	$arrPeriode[] = $reqPeriode;
else
{	
	if($jenis_pegawai_id == 3 || $jenis_pegawai_id == 5 || $jenis_pegawai_id = 1)
	{
	$gaji_periode = new GajiPeriodeCapegPKWT();	
	$gaji_periode->selectByParams(array(),2,0,"","ORDER BY GAJI_PERIODE_CAPEG_PKWT_ID DESC");
	}
	else
	{
	$gaji_periode = new GajiPeriode();	
	$gaji_periode->selectByParams(array(),2,0,"","ORDER BY GAJI_PERIODE_ID DESC");
	}
	
	while($gaji_periode->nextRow())
	{
		$arrPeriode[] = $gaji_periode->getField("PERIODE");	
	}
}
if($reqPeriode == "")
	$reqPeriode = $arrPeriode[0];
	
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
		function setValue(){
			$('#ccJabatan').combotree('setValue', '<?=$tempJabatan?>');
		}	
		$(function(){
			$('#ff').form({
				url:'../json-gaji/pegawai_potongan_lain_set_lunas.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					alert('Proses pelunasan berhasil, Silahkan proses ulang gaji.');			
					window.parent.location.reload();
					window.parent.divwin.close();					
				}
			});
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <link rel="stylesheet" href="css/jquery.cluetip.css" type="text/css" />
    <script type="text/javascript" src="js/jquery.cluetip.js" rel="stylesheet"></script>
    <script type="text/javascript">
    $(function() {
        $('#clueTipBox').cluetip({splitTitle: '|', showTitle:true, cluetipClass: 'jtip', dropShadow:false, positionBy:'fixed'});
        
        //show tooltip box when textbox get focus
        $('#textBox').focusin(function(){
            $('#clueTipBox').mouseenter();
        });
        
        //hide tooltip box when textbox lost focus
        $('#textBox').focusout(function(){
            $('#clueTipBox').mouseleave();
        });
    });
    </script>   
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Set Pelunasan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Periode Akhir Bayar</td>
            <td>
				  <select name="reqPeriode" id="reqPeriode">
        		  <?
                  for($i=0;$i<count($arrPeriode);$i++)
				  {
				  ?>
                  	<option value="<?=$arrPeriode[$i]?>" <? if($reqPeriode == $arrPeriode[$i]) { ?> selected <? } ?>><?=getNamePeriode($arrPeriode[$i])?></option>
                  <?	  
				  }
				  ?>
        		  </select>    
                  &nbsp;&nbsp;<a href="#" id="clueTipBox" class="clueTipBox" title="Panduan|Periode akhir bayar terakhir adalah proses terakhir pembayaran angsuran, apabila di set Juni 2013 maka pada proses gaji periode Juni 2013, pegawai terpilih masih terpotong untuk pelunasan terakhir. Perlu diketahui! Jenis Pegawai PTTPK dan PKWT periode proses gaji beda dengan Jenis Pegawai Lainnya karena dibayar di akhir."><img src="images/help.png"></a>                    
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