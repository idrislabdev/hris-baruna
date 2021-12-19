<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
include_once("../WEB-INF/classes/base/PenandaTangan.php");
include_once("../WEB-INF/classes/base/ReportPenandaTangan.php");

$cuti_tahunan = new CutiTahunan();

$report_penanda_tangan = new ReportPenandaTangan();
$penanda_tangan = new PenandaTangan();

	$report_penanda_tangan->selectByParams(array("JENIS_REPORT" => 'CUTI_TAHUNAN'));
	$report_penanda_tangan->firstRow();

	$tempNama1= $report_penanda_tangan->getField("NAMA_1");
	$tempJabatan1= $report_penanda_tangan->getField("JABATAN_1");
	$tempNama2= $report_penanda_tangan->getField("NAMA_2");
	$tempJabatan2= $report_penanda_tangan->getField("JABATAN_2");

$penanda_tangan->selectByParams();
while($penanda_tangan->nextRow())
{
	$arrNama[] = $penanda_tangan->getField("NAMA");
	$arrJabatan[] = $penanda_tangan->getField("JABATAN");
}

$reqJenisProses = httpFilterGet("reqJenisProses");
$reqPeriode = httpFilterGet("reqPeriode");
$reqMode = httpFilterGet("reqMode");
$reqData = httpFilterGet("reqData");

$cuti_tahunan->selectByParamsTanggalApprove(array(), -1, -1, " AND TANGGAL_APPROVE IS NOT NULL ", " ORDER BY TANGGAL_APPROVE DESC ");
//echo $cuti_tahunan->query;

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
				    //window.parent.divwin.close(); 
					document.location.href = 'proses_gaji_set_lock_cuti_tahunan.php?reqJenisProses=CUTI_TAHUNAN&reqPeriode=<?=$reqPeriode?>&reqMode=update';
				    newWindow.focus();
				}
			});
			
			$('#btnCetak').on('click', function () {
				newWindow = window.open('cuti_tahunan_rpt.php?reqPeriode='+$("#reqTglApprove").val()+'&reqNama1='+ $("#reqNama1").val()+'&reqJabatan1='+ $("#reqJabatan1").val()+'&reqNama2='+ $("#reqNama2").val()+'&reqJabatan2='+ $("#reqJabatan2").val() + '&reqData=<?=$reqData?>', 'Cetak');
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Cetak Cuti Tahunan</span>
    </div>
	<table>
    	<tr>
        <td>Tanggal Approval</td>
        <td>
        	<select id="reqTglApprove">
            <option value="">Belum Approve</option>
            <?
            while($cuti_tahunan->nextRow())
			{
			?>
            	<option value="<?=$cuti_tahunan->getField("NO_NOTA_DINAS2")?>"><? echo $cuti_tahunan->getField("NO_NOTA_DINAS");?></option>
            <?
			}
			?>
            </select>
        </td>
        </tr>
        
        <tr>
            <td>Nama (Kiri)</td>
            <td>
            	<select name="reqNama1" id="reqNama1">
            	<?
                for($i=0; $i<count($arrNama); $i++)
				{
				?>
                	<option value="<?=$arrNama[$i]?>" <? if($arrNama[$i] == $tempNama1) { ?> selected <? } ?>><?=$arrNama[$i]?></option>
                <?
				}
				?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jabatan (Kiri)</td>
            <td>
            	<input id="reqJabatan1" name="reqJabatan1" class="easyui-validatebox" size="80" type="text" value="<?=$tempJabatan1?>" />
            </td>
        </tr>
        <tr>
            <td>Nama (Tengah)</td>
            <td>
            	<select name="reqNama2" id="reqNama2">
            	<?
                for($i=0; $i<count($arrNama); $i++)
				{
				?>
                	<option value="<?=$arrNama[$i]?>" <? if($arrNama[$i] == $tempNama2) { ?> selected <? } ?>><?=$arrNama[$i]?></option>
                <?
				}
				?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jabatan (Tengah)</td>
            <td>
            	<input id="reqJabatan2" name="reqJabatan2" class="easyui-validatebox" size="80" type="text" value="<?=$tempJabatan2?>" />
            </td>
        </tr>
        
        <tr>
        	<td colspan="2"><input type="button" id="btnCetak" value="Cetak"></td>
        </tr>
    </table>
</div>
</body>
</html>