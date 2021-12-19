<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");

$cuti_tahunan = new CutiTahunan();

$reqJenisProses = httpFilterGet("reqJenisProses");
$reqPeriode = httpFilterGet("reqPeriode");
$reqMode = httpFilterGet("reqMode");
$reqData = httpFilterGet("reqData");

/*
if($reqMode == "update")
{
	$cuti_tahunan->updateTanggalApprove();	
}
*/

$jumlah = $cuti_tahunan->getCountByParamsGaji(array(), " AND G.TANGGAL_APPROVE IS NULL AND G.JUMLAH IS NOT NULL AND G.CUTI_TAHUNAN_ID IN (". $reqData .")", $reqPeriode);
$cuti_tahunan->selectByParamsGaji(array(), -1, -1, " AND G.TANGGAL_APPROVE IS NULL AND G.JUMLAH IS NOT NULL AND G.CUTI_TAHUNAN_ID IN (". $reqData .")", $reqPeriode);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-gaji/proses_gaji_set_lock.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					top.frames['mainFrame'].location.reload();
				    window.parent.divwin.close(); 
					document.location.href = 'proses_gaji_set_lock_cuti_tahunan.php?reqJenisProses=CUTI_TAHUNAN&reqPeriode=<?=$reqPeriode?>&reqMode=update';
				    newWindow.focus();
				}
			});
			
			$('#btnCetak').on('click', function () {
				newWindow = window.open('cuti_tahunan_rpt.php?reqPeriode=<?=date('dmY')?>', 'Cetak');
				newWindow.focus();
			  });
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">

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
<body onLoad="setValue('<?=$tempFitur?>')">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Set Nota Dinas</span>
    </div>
    <form id="ff" method="post" novalidate>
    <?
    if($jumlah == 0)
	{
	?>
    	&nbsp;&nbsp;&nbsp;&nbsp;<strong>Data cuti tahunan telah di approve semua.</strong>
    <?
	}
	else
	{
	?>
    <table>
    <tr>
    	<th>NRP</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>PPH21</th>
    </tr>
    <?
	$i = 0;
	$total = 0;
	$pph = 0;
    while($cuti_tahunan->nextRow())
	{
	?>
    <tr>
    	<td><?=$cuti_tahunan->getField("NRP")?></td>
        <td><?=$cuti_tahunan->getField("NAMA")?></td>
        <td><?=currencyToPage($cuti_tahunan->getField("JUMLAH"))?></td>
        <td><?=currencyToPage($cuti_tahunan->getField("JUMLAH_POTONGAN"))?></td>
    </tr>    
    <?
		$total += $cuti_tahunan->getField("JUMLAH");
		$pph += $cuti_tahunan->getField("JUMLAH_POTONGAN");		
		$i++;
		$nama = $cuti_tahunan->getField("NAMA");
	}
	?>    
    <tr>
    	<td colspan="2" style="text-align:right"> <strong>Total :</strong> </td>
        <td><strong><?=currencyToPage($total)?></strong></td>
        <td><strong><?=currencyToPage($pph)?></strong></td>
    </tr>
    </table>
    <?
	}
	?>
    <?
    if($jumlah == 0)
	{}
	else
	{
	?>
    <table>        
        <tr>           
             <td>Nota Dinas</td>
			 <td colspan="2">
            	<input type="text" name="reqNotaDinas1" required>
			</td>			
        </tr>               
    </table>
	<?
	}
    ?>
        <div>
        	No JKK : <input type="text" name="reqNoNota" value="<?=$reqNoNota?>">
            No JKM : <input type="text" name="reqNoNotaJKM" value="<?=$reqNoNotaJKM?>">
            <input type="hidden" name="reqJenisProses" value="<?=$reqJenisProses?>">
            <input type="hidden" name="reqPeriode" value="<?=$reqPeriode?>">
            <?
            if($i == 1)
				$nama = "SDR. ".$nama;
			else
				$nama = "PEGAWAI PT. PMS";
			?>
            <input type="hidden" name="reqKeterangan" value="<?=$nama?>">
            <?
            if($reqMode == "update")
			{
			?>
            <input type="button" id="btnCetak" value="Cetak">
            <?
			}
			else
			{
			 if($jumlah == 0)
				{}
			 else
			 {				
			?>
            <input type="hidden" name="reqData" value="<?=$reqData?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
            <?
			 }
			}
			?>
            
        </div>
    </form>
</div>
</body>
</html>